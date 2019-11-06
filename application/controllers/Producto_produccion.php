<?php

/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 15/02/2018
 * Time: 09:55 AM
 */
class Producto_produccion extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('producto_model', 'producto');
        $this->load->model('inventario_model', 'inventario');
        $this->load->model('Producto_produccion_model', 'producto_produccion');
    }

    //region Vistas de producto

    public function index()
    {
        plantilla('producto_produccion/index');
    }


    public function cambiar_estado_produccion()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id_producto');
            $cantidad_produccion = $this->input->post('cantidad_produccion');
            $cantidad = $this->input->post('cantidad');
            echo($id);

            $res = $this->producto_produccion->cambiar_estado_produccion($id, $cantidad_produccion, $cantidad);
            if ($res !== 1) {
                echo 'true';
            } else {
                echo 'error';
            }
        } else {
            show_404();
        }
    }
    public function ver_datos()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $data = $this->inventario->get_income_by_id_producction($id);
            plantilla('producto_produccion/ver', $data);
        } else {
            show_404();
        }
    }
    //obtiene los datos del clientes y de ingreso_inventario
    public function get_all_items()
    {
        if ($this->input->is_ajax_request()) {
            // Se recuperan los parametros enviados por datatable
            $start = $this->input->post('start');
            $limit = $this->input->post('length');
            $search = $this->input->post('search')['value'];
            $order = $this->input->post('order')['0']['dir'];
            $column_num = $this->input->post('order')['0']['column'];
            $column = $this->input->post('columns')[$column_num]['data'];

            // Se almacenan los parametros recibidos en un array para enviar al modelo
            $params = array(
                'start' => $start,
                'limit' => $limit,
                'search' => $search,
                'column' => $column,
                'order' => $order
            );

            echo json_encode($this->producto_produccion->get_all_items($params));
        } else {
            show_404();
        }
    }
    //obtiene el dato del ingreso
    public function get_all_items_ingreso()
    {
        if ($this->input->is_ajax_request()) {
            // Se recuperan los parametros enviados por datatable
            $start = $this->input->post('start');
            $limit = $this->input->post('length');
            $search = $this->input->post('search')['value'];
            $order = $this->input->post('order')['0']['dir'];
            $column_num = $this->input->post('order')['0']['column'];
            $column = $this->input->post('columns')[$column_num]['data'];

            // Se almacenan los parametros recibidos en un array para enviar al modelo
            $params = array(
                'start' => $start,
                'limit' => $limit,
                'search' => $search,
                'column' => $column,
                'order' => $order
            );

            echo json_encode($this->producto_produccion->get_ingreso_detalle_by_id($params));
        } else {
            show_404();
        }
    }




}