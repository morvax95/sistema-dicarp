<?php

/**
 * Created by PhpStorm.
 * User: Juan
 * Date: 23/03/2018
 * Time: 03:46 PM
 */
class Sucursal_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all(){
        return $this->db->get('sucursal')->result();
    }
    public function get_all_talla(){
        return $this->db->get('talla')->result();
    }
    public function get_all_color(){
        return $this->db->get('color')->result();
    }

    public function get_datos_empresa($id)
    {
        $this->db->select('*');
        $this->db->from('sucursal suc');
        $this->db->where('suc.id',$id);
        return $this->db->get()->row();
    }


    public function listar_sucursal($params = array())
    {
        if (!empty($this->input->post('draw'))) {

            $this->db->start_cache();
            $this->db->select('*')
                ->from('sucursal c')
                ->where('c.id > 0');
            $this->db->stop_cache();

            // Obtener la cantidad de registros NO filtrados.
            // Query builder se mantiene ya que se tiene almacenada la estructura de la consulta en memoria
            $records_total = count($this->db->get()->result_array());

            // Concatenar parametros enviados (solo si existen)
            if (array_key_exists('start', $params) && array_key_exists('limit', $params)) {
                $this->db->limit($params['limit']);
                $this->db->offset($params['start']);
            }

            if (array_key_exists('column', $params) && array_key_exists('order', $params)) {
                $this->db->order_by("c.{$params['column']}", $params['order']);
            } else {
                $this->db->order_by('c.id', 'ASC');
            }

            if (array_key_exists('search', $params) && !empty($params['search'])) {
                $this->db->like('c.nit', $params['search']);
                $this->db->or_like('lower(c.nombre_empresa)', $params['search']);
            }

            // Obtencion de resultados finales
            $draw = $this->input->post('draw');
            $data = $this->db->get()->result_array();

            $json_data = array(
                'draw' => intval($draw),
                'recordsTotal' => $records_total,
                'recordsFiltered' => $records_total,
                'data' => $data,
            );
            return $json_data;
        } else {
            return $this->db->get_where('sucursal', array('estado' => get_state('ACTIVO')))->result();
        }
    }

}