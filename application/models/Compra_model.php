<?php

/**
 * Created by PhpStorm.
 * User: Juan
 * Date: 23/03/2018
 * Time: 10:48 AM
 */
class Compra_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    // Registro de compra y detalle
    public function registrar(){
        $response = array(
            'success' => FALSE,
            'messages' => array()
        );

        /* VALIDACION DEL LOS CAMPOS DEL FORMULARIO */
        $this->form_validation->set_rules('fecha_compra', 'fecha de compra', 'trim|required');
        $this->form_validation->set_rules('observacion', 'observacion', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() === true) {
            // Iniciamos la transaccion
            $this->db->trans_start();

            $obj_data['fecha_compra']    = $this->input->post('fecha_compra');
            $obj_data['observacion']     = $this->input->post('observacion');
            $obj_data['subtotal']        = $this->input->post('subtotal_compra');
            $obj_data['descuento']       = $this->input->post('descuento_compra');
            $obj_data['monto_total']     = $this->input->post('total_compra');
            $obj_data['estado']          = get_state('ACTIVO');
            $obj_data['proveedor_id']    = $this->input->post('proveedor');
            $obj_data['nro_fiscal']    = $this->input->post('nro_fiscal');
            $obj_data['usuario_id']      = get_user_id_in_session();
            $obj_data['sucursal_id']     = get_branch_id_in_session();
            $obj_data['fecha_registro']  = date('Y-m-d');

            $this->db->insert('compra',$obj_data);
            $compra_id = $this->db->insert_id();

            //Registramos el detalle de compra
            $detalle = array(
                'contador'      => $this->input->post('contador_compra'),
                'producto_id'   => $this->input->post('producto_id[]'),
                'compra_id'     => $compra_id,
                'cantidad'      => $this->input->post('cantidad[]'),
                'precio_compra' => $this->input->post('precio[]'),
                'unidad'        => $this->input->post('unidad_seleccionada[]'),
            );

            // Registramos el detalle de compra
            /*if(!$this->detalle_compra($detalle)){
                $this->db->trans_rollback();
                $response['success'] = false;
            }*/

            $cantidad_filas = count($this->input->post('producto_id'));
            $array_producto_id = $this->input->post('producto_id');
            $array_cantidad = $this->input->post('cantidad');
            $array_precio = $this->input->post('precio');
            $array_unidad_seleccionada = $this->input->post('unidad_seleccionada');

            for($index = 0; $index<$cantidad_filas; $index++){
                $detalle_compra['producto_id']   = $array_producto_id[$index];
                $detalle_compra['compra_id']     = $compra_id;
                $detalle_compra['unidad_id']     = $array_unidad_seleccionada[$index];
                $detalle_compra['cantidad']      = $array_cantidad[$index];
                $detalle_compra['precio_compra'] = $array_precio[$index];
                $this->db->insert('detalle_compra',$detalle_compra);
            }

            // Registro de egreso por compra
            $this->load->model('egreso_model','egreso');
            $egreso['fecha_registro']   = date('Y-m-d');
            $egreso['fecha_egreso']     = date('Y-m-d');
            $egreso['detalle']          = 'Egreso por compra generado automaticamente';
            $egreso['monto']            = $obj_data['monto_total'];
            $egreso['tipo_egreso']      = $this->input->post('egreso_compra');

            $this->egreso->registrar_egreso_compra($egreso, $compra_id);

            // Fin de la transaccion
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $response['success'] = false;
            } else {
                $this->db->trans_commit();
                $response['success'] = TRUE;
            }
        } else {
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }
        return json_encode($response);
    }

    // detalle de compra
    public function detalle_compra($data){
        $this->db->trans_begin();
        for ($index = 0; $index < $data['contador']; $index++){
            $detalle['producto_id']     = $data['producto_id'][$index];
            $detalle['compra_id']       = $data['compra_id'];
            $detalle['cantidad']        = $data['cantidad'][$index];
            $detalle['precio_compra']   = $data['precio_compra'][$index];
            $detalle['unidad_id']       = $data['unidad'][$index];

            $this->db->insert('detalle_compra',$detalle);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $response = false;
        } else {
            $this->db->trans_commit();
            $response = TRUE;
        }
        return $response;
    }

    // Obtener el id de la compra
    public function get_buy_by_id($id){
        $this->db->select('c.*, eg.tipo_egreso_id')
            ->from('compra c, egreso_compra e, egreso_caja eg')
            ->where('c.id = e.compra_id')
            ->where('e.egreso_id = eg.id')
            ->where('c.id',$id);
        return $this->db->get()->row();
    }

    // Obtener el detalle de compra
    public function get_detail_of_buy($id){
        $this->db->select('p.id, p.nombre_item, d.cantidad, d.precio_compra, d.unidad_id, u.abreviatura')
            ->from('detalle_compra d, producto p, unidad_medida u')
            ->where('d.producto_id = p.id')
            ->where('d.unidad_id = u.id')
            ->where('d.compra_id',$id);
        return $this->db->get()->result();
    }

    // Obtener todos los registros
    public function get_all($params = array()){
        if($this->input->post('draw')){
            $this->db->start_cache();
            $this->db->select('c.id, c.fecha_compra, c.estado, c.monto_total, c.observacion, p.nombre, s.sucursal')
                ->from('compra c')
                ->join('proveedor p', 'p.id = c.proveedor_id')
                ->join('sucursal s', 's.id = c.sucursal_id')
                ->where('s.estado',get_state('ACTIVO'))
                ->where('p.estado',get_state('ACTIVO'));
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
                $this->db->like('lower(p.nombre)', $params['search']);
                $this->db->or_like('lower(s.sucursal)', $params['search']);
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
            $json_data = $this->db->get_where('compra',array('estado'=>get_state('ACTIVO')))->result();
        }
        return $json_data;
    }

    public function eliminar($id){
        $this->db->where('id',$id);
        return $this->db->update('compra',array('estado'=>get_state('INACTIVO')));
    }
}