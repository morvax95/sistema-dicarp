<?php

/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 15/02/2018
 * Time: 09:55 AM
 */
class Venta_proceso extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('producto_model', 'producto');
        $this->load->model('inventario_model', 'inventario');
        $this->load->model('Producto_produccion_model', 'producto_produccion');
        $this->load->model('venta_proceso_model', 'ventas_proceso');
    }

    //region Vistas de producto

    public function index()
    {
        plantilla('venta_proceso/index');
    }


    public function cambiar_estado_produccion()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id_producto');
            echo($id);

            $res = $this->producto_produccion->cambiar_estado_produccion($id);
            if ($res !== 1) {
                echo 'true';
            } else {
                echo 'error';
            }
        } else {
            show_404();
        }
    }

    //hace referencia al metodo obtener todos los articulos con el estado_venta==5
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

            echo json_encode($this->ventas_proceso->get_all_items($params));
        } else {
            show_404();
        }
    }

    //hace referencia al metodo obtener todos los articulos con el estado_venta==4
    public function get_all_items_in_production()
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

            echo json_encode($this->ventas_proceso->get_all_items_in_production($params));
        } else {
            show_404();
        }
    }

    //metodo para cambiar el estad de la venta
    public function modificar_estado_solicitud_cancelada()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id_solicitud');
            echo $this->ventas_proceso->cambiar_estado_solicitud_cancelada($id);

        } else {
            show_404();
        }
    }


}