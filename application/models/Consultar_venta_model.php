<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Juan
 * Date: 23/03/2018
 * Time: 5:20 PM
 */
class Consultar_venta_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function get_all($params = array())
    {
        // Si se envia como parametro "draw", la peticion se esta realizando desde datatables
        if (!empty($this->input->post('draw'))) {

            $this->db->start_cache();
            $this->db->select("*");
            $this->db->from('ventas_emitidas');
            $this->db->where('sucursal_id', get_branch_id_in_session());
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
                $this->db->order_by('id', 'DESC');
            }

            if (array_key_exists('search', $params) && !empty($params['search'])) {
                $this->db->group_start();
                $this->db->like('lower(nombre_cliente)', strtolower($params['search']));
//                $this->db->or_like('fecha', $params['search']);
                $this->db->or_like('ci_nit', $params['search']);
                $this->db->group_end();
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
        }
    }


    public function anular_venta($id)
    {
        $this->db->trans_start();

        $this->db->where('id', $id);
        $this->db->update('venta', array('estado' => get_state('ANULADO')));
        $id_ingreso = $this->db->get_where('ingreso_venta', array('venta_id' => $id))->row()->ingreso_id;


        $this->db->where('id', $id_ingreso);
        $this->db->update('ingreso_caja', array('estado' => get_state('ANULADO')));

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }

    }
    // Cambia el estado de venta_pagos
    public function anular_pagos($id)
    {
        $this->db->where('venta_id', $id);
        return $this->db->update('venta_pago', array('estado_pago' => 2));
    }


}