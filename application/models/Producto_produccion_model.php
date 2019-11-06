<?php

/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 19/02/2018
 * Time: 09:53 AM
 */
class Producto_produccion_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    // Cambia el estado de producto produccion a existente
    public function cambiar_estado_produccion($idIngreso, $idProducto)
    {
        $datos = $this->traer_datos($idIngreso, $idProducto);
        $lista_datos = $datos['detalle'];
        foreach ($lista_datos as $row_detalle) {
            $cantidad = $row_detalle->cantidad_produccion;
        }
        $cantidad_produccion = $cantidad;
        $this->db->where('id', $idIngreso);
        $this->db->where('producto_id', $idProducto);
        $this->db->update('detalle_producto_ingreso ', array('cantidad_produccion ' => 0, 'cantidad ' => $cantidad_produccion));
        $this->db->where('id', $idIngreso);

        //  $res = $this->verificar_EstadoProduccion($idIngreso);
        /*$fila = $this->verificar_EstadoProduccion($idIngreso);
        $lista = $fila['detalle_datos'];
        $cantidad = 0;
        foreach ($lista as $row_detalle) {
            $cantidad = $row_detalle->cantidad;
        }
        if ($cantidad != 0) {
            $this->db->update('ingreso_inventario', array('estado_producto' => 2));

        } else {
            $this->db->update('ingreso_inventario', array('estado_producto' => 1));
        }*/

        $this->db->where('id', $idIngreso);
        return $this->db->update('ingreso_inventario', array('estado_producto' => 1));


    }

    public function verificar_EstadoProduccion($idIngreso)
    {

        $this->db->select("sum(cantidad_produccion) as cantidad")
            ->from("detalle_producto_ingreso dti")
            ->where("dti.id=", $idIngreso);
        $lista_datos['detalle_datos'] = $this->db->get()->result();
        /* $cantidad_prod = $lista_datos->cantidad;
         $res = true;

         if ($cantidad_prod == 0) {
             $res = false;
         }*/
        return $lista_datos;

    }

    public function traer_datos($idIngreso, $idProducto)
    {

        $this->db->select("dti.cantidad_produccion")
            ->from("ingreso_inventario inv,detalle_producto_ingreso dti")
            ->where("inv.id=dti.ingreso_id")
            ->where("inv.id=", $idIngreso)
            ->where("dti.producto_id=", $idProducto);
        $data['detalle'] = $this->db->get()->result();
        return $data;

    }

    // Obtiene todos los items usan procesamiendo de datatable (probado)
    public function get_all_items($params = array())
    {
        if (!empty($this->input->post('draw'))) {
            $this->db->start_cache();
            $this->db->select('inve.id , date(inve.fecha_ingreso) as fecha_ingreso,u.nombre_usuario,al.descripcion as nombre_almacen ')
                ->from('detalle_producto_ingreso dt,ingreso_inventario inve,usuario u,almacen al')
                ->where(' inve.id=dt.ingreso_id ')
                ->where(' u.id=inve.usuario_id ')
                ->where(' al.id=inve.almacen_id ')
                ->where('dt.cantidad_produccion >0 group by(inve.id)');
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
                $this->db->order_by("inve.{$params['column']}", $params['order']);
            } else {
                $this->db->order_by('inve.id', 'ASC');
            }

            if (array_key_exists('search', $params) && !empty($params['search'])) {
                $this->db->like('inve.fecha_ingreso', $params['search']);
                $this->db->or_like('lower(inve.fecha_ingreso)', $params['search']);
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
            return $this->db->get_where('producto', array('estado' => get_state('ACTIVO')))->result();
        }
    }

    //obtiene los datos de ingresos
    public function get_ingreso_detalle_by_id($id)
    {
        $this->db->select("i.fecha_ingreso,i.id,u.nombre_usuario")
            ->from("ingreso_inventario i, usuario u")
            ->where("i.usuario_id=u.id")
            ->where("i.estado_producto=2");
        $data['detalle'] = $this->db->get()->result();
        return $data;
    }


}