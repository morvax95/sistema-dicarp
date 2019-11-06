<?php

/**
 * Created by PhpStorm.
 * User: Juan
 * Date: 23/03/2018
 * Time: 05:55 PM
 */
class Unidad_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function registrar_unidad(){

        $response = array(
            'success' => FALSE,
            'messages' => array()
        );
        $this->form_validation->set_rules('descripcion_unidad', 'nombre unidad', 'trim|required|is_unique[unidad_medida.descripcion]');
        $this->form_validation->set_rules('descripcion_abreviatura', 'abreviatura', 'trim|required|is_unique[unidad_medida.abreviatura]');

        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() === true) {
            /** OBTENERMOS VALORES DE LOS INPUT **/
            $obj_data['descripcion'] = mb_strtoupper($this->input->post('descripcion_unidad'), 'UTF-8');
            $obj_data['abreviatura'] = mb_strtoupper($this->input->post('descripcion_abreviatura'), 'UTF-8');
            $response['success'] = $this->db->insert('unidad_medida', $obj_data);
        } else {
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }
        return json_encode($response);
    }


    public function get_combo_unidad($unidad_id){
        $unidades = $this->get_all();
        $combo = '';
        foreach ($unidades as $row){
            $combo = $combo . "<option value='$row->id' ".is_selected($unidad_id,$row->id).">".$row->abreviatura."</option>";
        }
        return $combo;
    }


    public function get_all($params = array()){
        if($this->input->post('draw')){
            $this->db->start_cache();
            $this->db->select('*')
                ->from('unidad_medida');
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
                $this->db->order_by("{$params['column']}", $params['order']);
            } else {
                $this->db->order_by('id', 'ASC');
            }

            if (array_key_exists('search', $params) && !empty($params['search'])) {
                $this->db->like('lower(descripcion)', $params['search']);
            }

            // Obtencion de resultados finales
            $draw = $this->input->post('draw');
            $data = $this->db->get()->result_array();

            $json_data = array(
                'draw'            => intval($draw),
                'recordsTotal'    => $records_total,
                'recordsFiltered' => $records_total,
                'data'            => $data,
            );
        }else{
            // No se verifica estado activo porque no es importante
            $json_data = $this->db->get('unidad_medida')->result();
        }
        return $json_data;
    }

    public function get_unit_by_id($data){
        $name = $this->db->get_where('unidad_medida', array('id' => $data))->row()->descripcion;
        return $name;
    }
}