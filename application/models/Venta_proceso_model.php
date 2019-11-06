<?php

/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 19/02/2018
 * Time: 09:53 AM
 */
class Venta_proceso_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }


    // Cambia el estado a produccion
    public function cambiar_estado_produccion($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('ingreso_inventario', array('estado_producto' => 1));
    }

    // Obtiene todas los productos con el estado_venta==5
    public function get_all_items($params = array())
    {
        // Si se envia como parametro "draw", la peticion se esta realizando desde datatables
        if (!empty($this->input->post('draw'))) {

            $this->db->start_cache();
            $this->db->select("*");
            $this->db->from('ventas_emitidas');//vista que consulta el estado_venta==5
            $this->db->where('sucursal_id', get_branch_id_in_session());
            $this->db->where('estado=1');
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
    // Obtiene todas los productos con el estado_venta==4
    public function get_all_items_in_production($params = array())
    {
        // Si se envia como parametro "draw", la peticion se esta realizando desde datatables
        if (!empty($this->input->post('draw'))) {

            $this->db->start_cache();
            $this->db->select("*");
            $this->db->from('ventas_produccion');//vista que consulta el estado_venta==5
            $this->db->where('sucursal_id', get_branch_id_in_session());
            $this->db->where('estado=1');
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

    public function consultar_ventas_emitidas($tipo_venta)
    {
        $this->db->select("v.id,v.fecha,v.subtotal,v.descuento,v.total,v.cliente_id,v.nro_venta ,v.estado ,v.sucursal_id ,v.usuario_id AS usuario_id,v.tipo_venta AS tipo_venta,v.hora,c.nombre_cliente,c.ci_nit,n.nro_nota");
        $this->db->from("nota_venta n,venta v,cliente c ,venta_pago vp");
        $this->db->where("n.venta_id=v.id");
        $this->db->where("v.cliente_id=c.id");
        $this->db->where("vp.venta_id=v.id");

        if (!empty($tipo_venta)) {
            $this->db->where("vp.forma_pago='" . $tipo_venta . "' ");
        }

        $resultado['datos'] = $this->db->get()->result();

        return $resultado;
    }

    //metodo para cambiar el estado de las ventas en proceso
    public function cambiar_estado_solicitud_cancelada($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('detalle_venta', array('estado_entrega' => 5));

    }

}