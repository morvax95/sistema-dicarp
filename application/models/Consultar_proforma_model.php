<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Consultar_proforma_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Obtiene todas las proformas emitidas por sucursal
    public function get_all($params = array())
    {
        // Si se envia como parametro "draw", la peticion se esta realizando desde datatables
        if (!empty($this->input->post('draw'))) {

            $this->db->start_cache();
            $this->db->select("*");
            $this->db->from('proforma_emitida');

            //$this->db->where('sucursal_id',get_branch_id_in_session());
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
                    $this->db->or_like('ci_nit', $params['search']);
                    $this->db->or_like('nro_proforma', $params['search']);
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

    public function anularFactura($id)
    {
        $this->db->trans_start();

        $this->db->where('id',$id);
        $this->db->update('venta',array('cliente_id'=> 2));

        $datos['estado'] = 'A';
        $datos['monto_total'] = '0.00';
        $datos['importe_ice'] = '0.00';
        $datos['importe_excento'] = '0.00';
        $datos['subtotal'] = '0.00';
        $datos['descuento'] = '0.00';
        $datos['importe_base'] = '0.00';
        $datos['debito_fiscal'] = '0.00';

        $this->db->where('venta_id', $id);
        $this->db->update('factura', $datos);

        $datos['nit_cliente'] = 0;
        $datos['nombre_cliente'] = 'ANULADO';
        $this->db->where('venta_id', $id);
        $this->db->update('factura_datos', $datos);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }

    }

    public function anular_venta($id) {
        $this->db->trans_start();

        $this->db->where('id',$id);
        $this->db->update('venta',array('estado'=> get_state('ANULADO')));

        $id_ingreso = $this->db->get_where('ingreso_venta',array('venta_id' => $id))->row()->ingreso_id;

        $this->db->where('id',$id_ingreso);
        $this->db->update('ingreso_caja',array('estado'=> get_state('ANULADO')));

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }

    }

}