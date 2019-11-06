<?php

/**
 * Created by PhpStorm.
 * User: Juan
 * Date: 23/03/2018
 * Time: 11:56 AM
 */
class Compra extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('unidad_model','unidad');
        $this->load->model('proveedor_model','prov');
        $this->load->model('compra_model','compra');
        $this->load->model('egreso_model','egreso');
        $this->load->library('form_validation');
    }


    //region Description
    public function index(){
        plantilla('compra/index');
    }

    public function nuevo(){
        $data['proveedores'] = $this->prov->get_all();
        $data['unidades']    = $this->unidad->get_all();
        $data['tipo_egreso'] = $this->egreso->get_all_type_of_egress();
        plantilla('compra/nuevo',$data);
    }


    public function editar(){
        $id_compra = $this->input->post('id');
        $data['proveedores'] = $this->prov->get_all();
        $data['compra']      = $this->compra->get_buy_by_id($id_compra);
        $data['detalle']     = $this->compra->get_detail_of_buy($id_compra);
        $data['unidades']    = $this->unidad->get_all();
        $data['tipo_egreso'] = $this->egreso->get_all_type_of_egress();
        plantilla('compra/editar',$data);
    }
    //endregion


    //region Metodos de compra

    public function registrar(){
        if ($this->input->is_ajax_request()){
            echo $this->compra->registrar();
        }else{
            show_404();
        }
    }


    public function modificar(){
        if ($this->input->is_ajax_request()){
            echo $this->compra->modificar();
        }else{
            show_404();
        }
    }


    public function get_all(){
        if ($this->input->is_ajax_request())
        {
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

            echo json_encode($this->compra->get_all($params));
        } else {
            show_404();
        }
    }

    // Agrega una nueva fila al detalle de compra
    public function agregar(){
        if ($this->input->is_ajax_request()){
            $unidad_seleccionda = $this->input->post('unidad');
            $unidades       = $this->unidad->get_combo_unidad($unidad_seleccionda);
            // Recibimos los parametros del formulario de compra
            $contador       = $this->input->post('contador');
            $id_producto    = $this->input->post('id_producto_seleccionado');
            $descripcion    = $this->input->post('detalle_compra');
            $precio         = $this->input->post('precio_compra');
            $cantidad       = $this->input->post('cantidad_compra');
            $unidad         = $this->input->post('unidad');

            $sub_total = round($cantidad*$precio,2); // Redondeo con dos decimales
            // Creamos las filas del detalle de compra
            $fila = '<tr>';
            $fila .= '<td><input type="text" value="'.$id_producto.'" id="producto_id" name="producto_id[]" hidden/>'.$descripcion.'</td>';
            $fila .= '<td><input type="text" value="'.$cantidad.'" id="cantidad'.$contador.'" name="cantidad[]" onkeyup="modificar_detalle('.$contador.')" onclick="modificar_detalle('.$contador.')" style="width: 55%; padding: 1.4%;text-align: right"/><select id="unidad_seleccionada" name="unidad_seleccionada[]" style="width: 40%; padding: 1%; float: right;">'.$unidades.'</select></td>';
            $fila .= '<td class="text-right"><input type="number" step="any" value="'.$precio.'" id="precio'.$contador.'" name="precio[]" hidden/>'.$precio.'</td>';
            $fila .= '<td class="text-right"><input type="text" value="'.$sub_total.'" id="monto'.$contador.'" name="monto[]" size="4" style="text-align: right" hidden/>'.number_format($sub_total,2).'</td>';
            $fila .= '<td class="text-center"><a title="Borra esta fila"  class="elimina"><i class="fa fa-trash-o fa-2x"></i></a></td></tr>';

            $datos = array(
                0 => $fila,
                1 => $contador,
                2 => $sub_total,
            );

            echo json_encode($datos);
        }else{
            show_404();
        }
    }

    public function eliminar(){
        if ($this->input->is_ajax_request()) {
            echo $this->compra->eliminar($this->input->post('id'));
        }else{
            show_404();
        }
    }


    //endregion


}