<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//session_start();

/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 25/02/2018
 * Time: 05:07 PM
 */
class Venta extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('venta_model', 'venta');
        $this->load->model('producto_model', 'producto');
        $this->load->model('almacen_model', 'almacen');
        $this->load->model('sucursal_model', 'sucursal');
        $this->load->model('caja_model', 'caja');
        $this->load->model('reporte_model', 'reportes');
        $this->load->model('venta_proceso_model', 'ventas_proceso');
    }


    public function index()
    {

        $data['cajas'] = $this->caja->get_available_boxes();
        $data['almacenes'] = $this->almacen->get_all();
        $data['sucursales'] = $this->sucursal->get_all();
        plantilla('venta/index', $data);
    }


    public function agregar()
    {
        if ($this->input->is_ajax_request()) {

            if ($this->venta->verificar_stock($this->input->post('id_producto'), $this->input->post('cantidad_venta'))) {
                // Recibimos los parametros del formulario
                $contador = $this->input->post('contador');
                $id_producto = $this->input->post('id_producto');
                $id_talla = $this->input->post('id_talla');
                $id_color = $this->input->post('id_color');
                $descripcion = $this->input->post('detalle_venta');
                $precio = $this->input->post('precio_venta');
                $cantidad = $this->input->post('cantidad_venta');
                $codigo_barra_detalle = $this->input->post('codigo_barra_detalle');
                $stock_disponible = $this->input->post('stock_disponible');
                $stock_produccion = $this->input->post('stock_produccion');
                $estado_entrega = $this->input->post('estado_entrega');
                $descuento_producto = $this->input->post('descuento_producto');

                $estado_ent = array();
                if (isset($_SESSION["estado_entrega"])) {
                    $estado_ent = $_SESSION["estado_entrega"];
                    $estado_ent[] = $estado_entrega;
                    $_SESSION["estado_entrega"] = $estado_ent;
                } else {
                    $estado_ent[] = $estado_entrega;
                    $_SESSION["estado_entrega"] = $estado_ent;
                }

                $sub_total = round($cantidad * $precio, 2);

                // Creamos las filas del detalle
                $fila = '<tr>';
                $fila .= '<td>' . $codigo_barra_detalle . '</td>';
                $fila .= '<td><input type="text" value="' . $id_producto . '" id="producto_id" name="producto_id[]" hidden/>
            <input type="text" value="' . $id_talla . '" id="talla_id" name="talla_id[]" hidden/>
            <input type="text" value="' . $id_color . '" id="color_id" name="color_id[]" hidden/>
            <input type="text" value="' . $descripcion . '" id="descripcion" name="descripcion[]" hidden/>' . $descripcion . '</td>';

                $fila .= '<td>' . $stock_disponible . '</td>';
                $fila .= '<td><input type="number" step="any" value="' . $stock_produccion . '" id="stock_produccion' . $contador . '" name="stock_produccion[]" hidden/>' . $stock_produccion . '</td>';
                $fila .= '<td><input type="number" step="any" value="' . $precio . '" id="precio' . $contador . '" name="precio[]" hidden/>' . $precio . '</td>';
                /*descuento*/
                //  $fila .= '<td><input type="text" step="any" class="form-control" value="' . $descuento_producto . '" id="descuento_producto_id' . $contador . '" name="descuento_producto_id[]" hidden/>' . $descuento_producto . '</td>';
                //$fila .= '<td><input type="text" class="form-control"  value="' . $descuento_producto . '" id="descuento_producto_id' . $contador . '" name="descuento_producto_id[]" onkeyup="modificar_detalle(' . $contador . ')" onclick="modificar_detalle(' . $contador . ')" style="text-align: right" min="1" max="" /></td>';
                $fila .= '<td><input type="text" class="form-control"  value="' . $cantidad . '" id="cantidad' . $contador . '" name="cantidad[]" onkeyup="modificar_detalle(' . $contador . ')" onclick="modificar_detalle(' . $contador . ')" style="text-align: right" min="1" max=""/></td>';


                if ($estado_entrega == 5) {
                    $val1 = '<option  value="5">Entregado</option>';
                    //<option  value="4">Pendiente</option>';
                } else {
                    $val1 = '<option  value="4">Pendiente</option>';
                    //<option  value="5">Entregado</option>';
                }

                //$fila .= '<td><select class="form-control" id="estado_entrega' . $contador . '" name="estado_entrega[]" readonly="readonly" >
                //                                      ' . $val1 . '
                //                                   </select></td>';
                $fila .= '<td><input type="text"  class="form-control"   id="estado_entrega' . $contador . '" name="estado_entrega[]" readonly="readonly"  >
                                                      ' . $val1 . '
                                                  </td>';
                $fila .= '<td><input type="text" class="form-control" value="' . $sub_total . '" id="monto' . $contador . '" name="monto[]" size="4" style="text-align: right" readonly/></td>';

                $fila .= '<td class="text-center"><a class="elimina"><i class="fa fa-trash-o"></i></a></td></tr>';

                $datos = array(
                    0 => $fila,
                    1 => $contador,
                    2 => $sub_total,

                );

                echo json_encode($datos);
            } else {
                $datos = array(
                    0 => 'error',
                );

                echo json_encode($datos);
            }
        } else {
            show_404();
        }
    }

    //actualizar el estado de la venta
    public function modificar_estado_venta()
    {
        if ($this->input->is_ajax_request()) {
            $nro_venta = $this->input->post('nroVenta');

            $res = $this->venta->cambiar_estado_venta($nro_venta);
            if ($res !== 1) {
                echo 'true';
            } else {
                echo 'error';
            }
        } else {
            show_404();
        }
    }

    public function consultar_producto()
    {
        if ($this->input->is_ajax_request()) {
            $data = $this->input->post('product_code');
            $this->db->select('nombre_item, SUM(cantidad) as cantidad, sucursal,cantidad_produccion');
            $this->db->from('inventario_producto');
            // $this->db->where('lower(nombre_item)', strtolower($data));
            $this->db->like('lower(nombre_item)', strtolower($data));
            $this->db->group_by('nombre_item, sucursal');
            $res = $this->db->get();

            $fila = '';
            if ($res->num_rows() > 0) {
                $fila = '';
                foreach ($res->result() as $row) {
                    $fila = $fila . '<tr>';
                    $fila .= '<td>' . $row->nombre_item . '</td>';
                    $fila .= '<td>' . $row->cantidad . '</td>';
                    $fila .= '<td>' . $row->cantidad_produccion . '</td>';
                    $fila .= '<td>' . $row->sucursal . '</td>';
                    $fila .= '</tr>';
                }
            } else {
                $fila = $fila . '<tr>';
                $fila .= '<td colspan="5"> No existe datos para el codigo ingresado</td>';
                $fila .= '</tr>';
            }
            echo($fila);
        } else {
            show_404();
        }
    }

    public function pruebaa()
    {
        $monto = "0";
        $monto1 = 0.00;

        if ($monto == $monto1) {
            echo 'bien';
        } else {
            echo 'mal';
        }
    }

    /*-------------------------------------------------
     * Funcion para el registro de venta de otros productos
     *------------------------------------------------- */
    public function registro_venta()
    {
        if ($this->input->is_ajax_request()) {

            echo json_encode($this->venta->registro_venta());

        } else {
            show_404();
        }
    }

    public function registroDetalleVenta()
    {
        if ($this->input->is_ajax_request()) {
            $detalle['venta_id'] = $this->input->post('venta_id');
            $detalle['detalle'] = $this->input->post('detalle');
            $detalle['cantidad'] = $this->input->post('cantidad');
            $detalle['precio_venta'] = $this->input->post('precio');

            $this->venta->registroDetalleVenta($detalle);
        } else {
            show_404();
        }
    }

    public function registroDetalleVentaMateria()
    {
        if ($this->input->is_ajax_request()) {
            $detalle['venta_id'] = $this->input->post('venta_id');
            $detalle['especie_id'] = $this->input->post('especie');
            $detalle['espesor'] = $this->input->post('espesor');
            $detalle['ancho'] = $this->input->post('ancho');
            $detalle['largo'] = $this->input->post('largo');
            $detalle['detalle'] = $this->input->post('detalle');
            $detalle['cantidad'] = $this->input->post('cantidad');
            $detalle['precio_venta'] = $this->input->post('precio');
            $detalle['total_pie'] = $this->input->post('total_pie');

            $this->venta->registroDetalleVentaMateria($detalle);
        } else {
            show_404();
        }
    }

    function obtener_mes($valor)
    {
        $result = '';
        switch ($valor) {
            case '01':
                $result = 'Enero';
                break;
            case '02':
                $result = 'Febrero';
                break;
            case '03':
                $result = 'Marzo';
                break;
            case '04':
                $result = 'Abril';
                break;
            case '05':
                $result = 'Mayo';
                break;
            case '06':
                $result = 'Junio';
                break;
            case '07':
                $result = 'Julio';
                break;
            case '08':
                $result = 'Agosto';
                break;
            case '09':
                $result = 'Septiembre';
                break;
            case '10':
                $result = 'Octubre';
                break;
            case '11':
                $result = 'Noviembre';
                break;
            case '12':
                $result = 'Diciembre';
                break;
        }
        return $result;
    }



    public function imprimir_nota_venta()
    {
        $venta_id = $this->uri->segment(3);
        $respuesta = $this->venta->imprimir_nota_venta($venta_id);

        $this->load->view('venta/impresion_nota_venta', $respuesta);
    }

    /*** Imprimir nota de la solicitud ****/
    public function imprimir_nota_ventas_contado()
    {
        $venta_id = $this->uri->segment(3);
        $datos = $this->venta->comprobante_ventas($venta_id);
        $lista_compras = $datos['datos'];
        $lista_detalle_ventas = $datos['datos_venta_detalle'];
        $lista_monto_detalle_ventas = $datos['datos_montos_venta_detalle'];

        foreach ($lista_compras as $row_detalle) {
            $nombre_cliente = $row_detalle->nombre_cliente;

            $fecha_venta = $row_detalle->fecha;
            $usuario = $row_detalle->nombre_usuario;
            $nota = $row_detalle->nota;
            $forma_pagos = $row_detalle->forma_pago;
            $tipo_cambio = $row_detalle->tipo_cambio;
        }
        foreach ($lista_monto_detalle_ventas as $row_detalle_venta) {

            $monto_pagado = $row_detalle_venta->monto;
            $monto_a_plazos = $monto_pagado;
            $total_venta = $row_detalle_venta->total + $row_detalle_venta->descuento;
            $descuento_total_venta = $row_detalle_venta->descuento;
            $saldo = $row_detalle_venta->saldo;

        }

        $this->load->library('pdf');
        $this->pdf = new Pdf('P', 'mm', 'Legal');
        $this->pdf->AddPage();

        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();

        $this->pdf->SetTitle("COMPROBANTE DE VENTA");
        $var_img = base_url() . 'assets/img/logo_empresa.png';
        $this->pdf->Image($var_img, 10, 10, 60, 28);

        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(133, 5, '', 0, 0, 'C');
        $this->pdf->Cell(65, 5, 'DICARP ', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->SetTextColor(248, 000, 000);

        /**/
        $this->pdf->Ln(5);
        $this->pdf->Cell(133, 5, '', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->SetTextColor(0, 0, 0);/* volvemos a color de texto negro*/

        $this->pdf->Cell(60, 5, '      Colchones y Complementos', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->MultiCell(72, 5, '', 0, 'C');
        $this->pdf->Cell(75, 5, ' ', 0, 0, 'C');

        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->SetTextColor(248, 0, 0);
        $this->pdf->Cell(40, 5, 'RECIBO', 0, 0, 'C');
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetTextColor(0, 0, 0);/* volvemos a color de texto negro*/

        $this->pdf->Cell(90, 4, 'Av 26 de Febrero 2do anillo casi centenario', 0, 0, 'C');
        $this->pdf->Cell(60, 4, '', 0);
        $this->pdf->SetFont('Arial', '', 9);

        $this->pdf->MultiCell(72, 4, '', 0, 'C');
        $this->pdf->Cell(75, 5, '', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->SetTextColor(248, 0, 0);
        // $this->pdf->Cell(40, 5, 'Nro. 000' . $nro_comprobante, 0, 0, 'C');
        $this->pdf->Cell(40, 5, ' ', 0, 0, 'C');

        $this->pdf->SetTextColor(0, 0, 0);
        $this->pdf->SetFont('Arial', 'B', 7);
        $this->pdf->Cell(100, 4, 'Telf. 9302099 - 70838701
', 0, 0, 'C');

        $this->pdf->Ln(10);
        $nro = 1;
        $nro = $nro + 1;

        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Ln(5);
        /*COLOCANDO FECHA EN LITERAL*/
        $anio = substr($fecha_venta, 0, 4);
        $mes = substr($fecha_venta, 5, 2);
        $dia = substr($fecha_venta, 8, 2);
        $fechaTransaccion = $dia . ' de ' . $this->obtener_mes($mes) . ' del ' . $anio;

        /*  NOMBRE DEL CLIENTE*/
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode('NOMBRE CLIENTE     : ' . $nombre_cliente), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);
        /*  FECHA DE LA VENTA*/
        $this->pdf->Cell(27, 5, utf8_decode('FECHA DE VENTA      : ' . $fechaTransaccion . '                                                                                   FORMA PAGO  : CONTADO - ' . $forma_pagos), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(7);

        /* Encabezado de la columna*/
        $this->pdf->Cell(12, 5, "CANT.", 1, 0, 'C');
        $this->pdf->Cell(20, 5, "CODIGO", 1, 0, 'C');
        $this->pdf->Cell(96, 5, "NOMBRE PRODUCTO", 1, 0, 'C');
        $this->pdf->Cell(22, 5, "ESTADO", 1, 0, 'C');
        $this->pdf->Cell(20, 5, "P/U", 1, 0, 'C');
        $this->pdf->Cell(22, 5, "TOTAL VENTA", 1, 0, 'C');


        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial', '', 7);

        $cantidad_filas = 0;

        foreach ($lista_detalle_ventas as $row_detalle) {
            if ($row_detalle->estado_entrega == 4) {
                $estado_entrega = "PENDIENTE";
            }
            if ($row_detalle->estado_entrega == 5) {
                $estado_entrega = "ENTREGADO";

            }
            $cantidad_filas++;
            $estilo = 'RL';
            if ($nro == 1) {
                $estilo = $estilo . 'T';
            }
            if ($cantidad_filas == count($lista_detalle_ventas)) {
                $estilo = 'LRB';
            }

            $this->pdf->Cell(12, 4, utf8_decode($row_detalle->cantidad), $estilo, 0, 'C');
            $this->pdf->Cell(20, 4, utf8_decode($row_detalle->codigo_barra), $estilo, 0, 'C');
            $this->pdf->Cell(96, 4, utf8_decode($row_detalle->nombre_item), $estilo, 0, 'L');
            $this->pdf->Cell(22, 4, utf8_decode($estado_entrega), $estilo, 0, 'C');
            $this->pdf->Cell(20, 4, utf8_decode($row_detalle->precio_venta ), $estilo, 0, 'C');
            $this->pdf->Cell(22, 4, utf8_decode($row_detalle->cantidad * $row_detalle->precio_venta . '.00'), $estilo, 0, 'C');

            $this->pdf->Ln(4);
            $nro = $nro + 1;
        }
        $this->pdf->Ln(3);
        /**************************************************************************/
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode('                                                                                                                                                                                               SUBTOTAL     Bs  : ' . $total_venta.'.00'), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);

        $this->pdf->Cell(27, 5, utf8_decode('TIPO CAMBIO :      ' . $tipo_cambio . '                                                                                                                                                             DESCUENTO  Bs  : ' . $descuento_total_venta ), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(5);
        /***/


        $this->pdf->Cell(27, 5, utf8_decode('                                                                                                                                                                                                             PAGO Bs  : ' . $monto_pagado), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(5);

        $this->pdf->Cell(27, 5, utf8_decode('                                                                                                                                                                                                          SALDO  Bs   : ' . $saldo), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(5);
        /**************************************************************************/


        // Convertimos el monto en literal
        include APPPATH . '/libraries/convertidor.php';
        $v = new EnLetras();
        $valor = $v->ValorEnLetras($monto_a_plazos, " ");
        $this->pdf->Ln(2);
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(7, 5, 'MONTO TOTAL Bs  :  ', 'LTB', 0, 'L');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(125, 5, '                           ' . $valor, 'TBR', 0, 'L');
        $this->pdf->Cell(5, 5, '', '', 0, 'L');
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(20, 5, 'TOTAL Bs :', 1, 0, 'R');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(35, 5, $monto_a_plazos, 1, 0, 'R');
        $this->pdf->Ln(8);
        /*  NOTA DE LA VENTA*/
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode('USUARIO    : ' . $usuario), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);
        /*  LINEA DE SEPARACION */
        $this->pdf->Cell(27, 5, utf8_decode('NOTA          :' . $nota), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(15);
        /*  ENTREGADO Y RECIBIDO POR*/
        $this->pdf->Cell(27, 5, utf8_decode('                                   -------------------------------------------------------------   ' . '                            -------------------------------------------------------------  '), ' ');
        $this->pdf->Ln(3);
        $this->pdf->Cell(27, 5, utf8_decode('                                                       ENTREGADO                                ' . '                                                       RECIBIDO    '), ' ');
        $this->pdf->Ln(17);
        $this->pdf->Cell(27, 5, utf8_decode('   *******************************************************      GRACIAS POR SU COMPRA VUELVA PRONTO   *************************************************  '), ' ');
        $this->pdf->Ln(8);
        $this->pdf->Cell(27, 5, utf8_decode('   ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------  '), ' ');
        /*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
        $this->pdf->Ln(6);
        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->SetTextColor(248, 0, 0);    //color rojo
        $this->pdf->Cell(200, 5, 'RECIBO ', 0, 0, 'C');
        $this->pdf->Ln(4);
        $this->pdf->SetTextColor(0, 0, 0);    //color negro
        $this->pdf->Ln(4);

        /*  NOMBRE DEL CLIENTE*/
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode('NOMBRE CLIENTE  : ' . $nombre_cliente), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);
        /*  FECHA DE LA VENTA*/
        $this->pdf->Cell(27, 5, utf8_decode('FECHA DE VENTA   :  ' . $fechaTransaccion . '                                                                           FORMA DE PAGO  : CONTADO - ' . $forma_pagos), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(7);

        /* Encabezado de la columna*/
        $this->pdf->Cell(12, 5, "CANT.", 1, 0, 'C');
        $this->pdf->Cell(20, 5, "CODIGO", 1, 0, 'C');
        $this->pdf->Cell(96, 5, "NOMBRE PRODUCTO", 1, 0, 'C');
        $this->pdf->Cell(22, 5, "ESTADO", 1, 0, 'C');
        $this->pdf->Cell(20, 5, "P/U", 1, 0, 'C');
        $this->pdf->Cell(22, 5, "TOTAL VENTA", 1, 0, 'C');

        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial', '', 7);

        $cantidad_filas = 0;

        foreach ($lista_detalle_ventas as $row_detalle) {
            if ($row_detalle->estado_entrega == 4) {
                $estado_entrega = "PENDIENTE";
            }
            if ($row_detalle->estado_entrega == 5) {
                $estado_entrega = "ENTREGADO";

            }
            $cantidad_filas++;
            $estilo = 'RL';
            if ($nro == 1) {
                $estilo = $estilo . 'T';
            }
            if ($cantidad_filas == count($lista_detalle_ventas)) {
                $estilo = 'LRB';
            }

            $this->pdf->Cell(12, 4, utf8_decode($row_detalle->cantidad), $estilo, 0, 'C');
            $this->pdf->Cell(20, 4, utf8_decode($row_detalle->codigo_barra), $estilo, 0, 'C');
            $this->pdf->Cell(96, 4, utf8_decode($row_detalle->nombre_item), $estilo, 0, 'L');
            $this->pdf->Cell(22, 4, utf8_decode($estado_entrega), $estilo, 0, 'C');
            $this->pdf->Cell(20, 4, utf8_decode($row_detalle->precio_venta . '.00'), $estilo, 0, 'C');
            $this->pdf->Cell(22, 4, utf8_decode($row_detalle->cantidad * $row_detalle->precio_venta . '.00'), $estilo, 0, 'C');

            $this->pdf->Ln(4);
            $nro = $nro + 1;
        }
        $this->pdf->Ln(3);
        /**************************************************************************/
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode('                                                                                                                                                                                               SUBTOTAL     Bs  : ' . $total_venta.'.00'), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);

        $this->pdf->Cell(27, 5, utf8_decode('TIPO CAMBIO :      ' . $tipo_cambio . '                                                                                                                                                             DESCUENTO  Bs  : ' . $descuento_total_venta ), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(5);
        /***/
        $this->pdf->Cell(27, 5, utf8_decode('                                                                                                                                                                                                             PAGO Bs  : ' . $monto_pagado), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(5);

        $this->pdf->Cell(27, 5, utf8_decode('                                                                                                                                                                                                          SALDO  Bs   : ' . $saldo), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(5);
        /**************************************************************************/


        $this->pdf->Ln(2);
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(7, 5, 'MONTO TOTAL Bs  :  ', 'LTB', 0, 'L');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(125, 5, '                           ' . $valor, 'TBR', 0, 'L');
        $this->pdf->Cell(5, 5, '', '', 0, 'L');
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(20, 5, 'TOTAL Bs :', 1, 0, 'R');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(35, 5, $monto_a_plazos, 1, 0, 'R');
        $this->pdf->Ln(8);
        /*  NOTA DE LA VENTA*/
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode('USUARIO    : ' . $usuario), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);
        /*  LINEA DE SEPARACION */
        $this->pdf->Cell(27, 5, utf8_decode('NOTA          :' . $nota), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(20);
        /*  ENTREGADO Y RECIBIDO POR*/
        $this->pdf->Cell(27, 5, utf8_decode('                                   -------------------------------------------------------------   ' . '                            -------------------------------------------------------------  '), ' ');
        $this->pdf->Ln(3);
        $this->pdf->Cell(27, 5, utf8_decode('                                                       ENTREGADO                                ' . '                                                       RECIBIDO    '), ' ');


        $this->pdf->Output("ComprobanteVenta.pdf", 'I');
    }

    /*** Imprimir nota de la solicitud a plazos****/
    public function imprimir_nota_ventas_plazos()
    {
        $venta_id = $this->uri->segment(3);
        $datos = $this->venta->comprobante_ventas($venta_id);
        $lista_compras = $datos['datos'];
        $lista_detalle_ventas = $datos['datos_venta_detalle'];
        $lista_monto_detalle_ventas_II = $datos['datos_montos_venta_detalle_II'];

        foreach ($lista_compras as $row_detalle) {
            $nombre_cliente = $row_detalle->nombre_cliente;
            $fecha_venta = $row_detalle->fecha;
            $usuario = $row_detalle->nombre_usuario;
            $nota = $row_detalle->nota;
            $forma_pago_plazo = $row_detalle->descripcion;
            $tipo_cambio = $row_detalle->tipo_cambio;
            $monto_total = $row_detalle->monto;
            $saldo = $row_detalle->saldo;


            if ($forma_pago_plazo == 'forma_pago_efectivo') {
                $modo_pago = 'Efectivo';
            } else if ($forma_pago_plazo == 'forma_pago_tarjeta') {
                $modo_pago = 'Tarjeta';
            } else if ($forma_pago_plazo == 'forma_pago_cheque') {
                $modo_pago = 'Cheque';
            } else if ($forma_pago_plazo = 'forma_pago_deposito') {
                $modo_pago = 'Deposito';
            } else {
                $modo_pago = 'NADA';
            }

        }
        foreach ($lista_monto_detalle_ventas_II as $row_detalle_venta) {
            $descuento_total_venta = $row_detalle_venta->descuento;
            $sub_total_venta = $row_detalle_venta->subtotal;

        }
        $this->load->library('pdf');
        $this->pdf = new Pdf('P', 'mm', 'Legal');
        $this->pdf->AddPage();

        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();

        $this->pdf->SetTitle("RECIBO");
        $var_img = base_url() . 'assets/img/logo_empresa.png';
        $this->pdf->Image($var_img, 10, 10, 60, 28);

        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(133, 5, '', 0, 0, 'C');
        $this->pdf->Cell(65, 5, 'DICARP ', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->SetTextColor(248, 000, 000);

        /**/
        $this->pdf->Ln(5);
        $this->pdf->Cell(133, 5, '', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->SetTextColor(0, 0, 0);/* volvemos a color de texto negro*/

        $this->pdf->Cell(60, 5, '      Colchones y Complementos', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->MultiCell(72, 5, '', 0, 'C');
        $this->pdf->Cell(75, 5, ' ', 0, 0, 'C');

        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->SetTextColor(248, 0, 0);
        $this->pdf->Cell(40, 5, 'RECIBO', 0, 0, 'C');
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetTextColor(0, 0, 0);/* volvemos a color de texto negro*/

        $this->pdf->Cell(90, 4, 'Av 26 de Febrero 2do anillo casi centenario', 0, 0, 'C');
        $this->pdf->Cell(60, 4, '', 0);
        $this->pdf->SetFont('Arial', '', 9);

        $this->pdf->MultiCell(72, 4, '', 0, 'C');
        $this->pdf->Cell(75, 5, '', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->SetTextColor(248, 0, 0);
        //$this->pdf->Cell(40, 5, 'Nro. 000' . $nro_comprobante, 0, 0, 'C');
        $this->pdf->Cell(40, 5, ' ', 0, 0, 'C');

        $this->pdf->SetTextColor(0, 0, 0);
        $this->pdf->SetFont('Arial', 'B', 7);
        $this->pdf->Cell(100, 4, 'Telf. 9302099 - 70838701
', 0, 0, 'C');

        $this->pdf->Ln(10);
        $nro = 1;
        $nro = $nro + 1;

        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Ln(5);
        $anio = substr($fecha_venta, 0, 4);
        $mes = substr($fecha_venta, 5, 2);
        $dia = substr($fecha_venta, 8, 2);
        $fechaTransaccion = $dia . ' de ' . $this->obtener_mes($mes) . ' del ' . $anio;

        /*  NOMBRE DEL CLIENTE*/
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode('NOMBRE CLIENTE     : ' . $nombre_cliente), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);
        /*  FECHA DE LA VENTA*/
        $this->pdf->Cell(27, 5, utf8_decode('FECHA DE VENTA      : ' . $fechaTransaccion . '                                                                           FORMA DE PAGO  : PLAZO - ' . $modo_pago), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(7);

        /* Encabezado de la columna*/
        $this->pdf->Cell(12, 5, "CANT.", 1, 0, 'C');
        $this->pdf->Cell(20, 5, "CODIGO", 1, 0, 'C');
        $this->pdf->Cell(96, 5, "NOMBRE PRODUCTO", 1, 0, 'C');
        $this->pdf->Cell(22, 5, "ESTADO", 1, 0, 'C');
        $this->pdf->Cell(20, 5, "P/U", 1, 0, 'C');
        $this->pdf->Cell(22, 5, "TOTAL VENTA", 1, 0, 'C');


        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial', '', 7);

        $cantidad_filas = 0;

        foreach ($lista_detalle_ventas as $row_detalle) {
            if ($row_detalle->estado_entrega == 4) {
                $estado_entrega = "PENDIENTE";
            }
            if ($row_detalle->estado_entrega == 5) {
                $estado_entrega = "ENTREGADO";

            }

            $cantidad_filas++;
            $estilo = 'RL';
            if ($nro == 1) {
                $estilo = $estilo . 'T';
            }
            if ($cantidad_filas == count($lista_detalle_ventas)) {
                $estilo = 'LRB';
            }


            $this->pdf->Cell(12, 4, utf8_decode($row_detalle->cantidad), $estilo, 0, 'C');
            $this->pdf->Cell(20, 4, utf8_decode($row_detalle->codigo_barra), $estilo, 0, 'C');
            $this->pdf->Cell(96, 4, utf8_decode($row_detalle->nombre_item), $estilo, 0, 'L');
            $this->pdf->Cell(22, 4, utf8_decode($estado_entrega), $estilo, 0, 'C');
            $this->pdf->Cell(20, 4, utf8_decode($row_detalle->precio_venta), $estilo, 0, 'C');
            $this->pdf->Cell(22, 4, utf8_decode($row_detalle->cantidad * $row_detalle->precio_venta . '.00'), $estilo, 0, 'C');

            $this->pdf->Ln(4);
            $nro = $nro + 1;
        }
        $this->pdf->Ln(3);


        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode('                                                                                                                                                                                                SUBTOTAL  Bs  : ' . $sub_total_venta), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);

        $this->pdf->Cell(27, 5, utf8_decode('                                                                                                                                                                                             DESCUENTO  Bs  : ' . $descuento_total_venta), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(5);
        /********/
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode('                                                                                                                                                                                                         PAGO  Bs  : ' . $monto_total), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);

        $this->pdf->Cell(27, 5, utf8_decode(' TIPO CAMBIO : ' . $tipo_cambio . '                                                                                                                                                                         SALDO  Bs  : ' . $saldo), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(5);
        /********/

        // Convertimos el monto en literal
        include APPPATH . '/libraries/convertidor.php';
        $v = new EnLetras();
        $valor = $v->ValorEnLetras($monto_total, " ");
        $this->pdf->Ln(2);
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(7, 5, 'MONTO TOTAL Bs  :  ', 'LTB', 0, 'L');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(125, 5, '                           ' . $valor, 'TBR', 0, 'L');
        $this->pdf->Cell(5, 5, '', '', 0, 'L');
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(20, 5, 'TOTAL Bs :', 1, 0, 'R');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(35, 5, $monto_total, 1, 0, 'R');
        $this->pdf->Ln(8);
        /*  NOTA DE LA VENTA*/
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode('USUARIO    : ' . $usuario), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);
        /*  LINEA DE SEPARACION */
        $this->pdf->Cell(27, 5, utf8_decode('NOTA          :' . $nota), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(15);
        /*  ENTREGADO Y RECIBIDO POR*/
        $this->pdf->Cell(27, 5, utf8_decode('                                   -------------------------------------------------------------   ' . '                            -------------------------------------------------------------  '), ' ');
        $this->pdf->Ln(3);
        $this->pdf->Cell(27, 5, utf8_decode('                                                       ENTREGADO                                ' . '                                                       RECIBIDO    '), ' ');
        $this->pdf->Ln(10);
        $this->pdf->Cell(27, 5, utf8_decode('   *******************************************************      GRACIAS POR SU COMPRA VUELVA PRONTO   *************************************************  '), ' ');
        $this->pdf->Ln(5);
        $this->pdf->Cell(27, 5, utf8_decode('   ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------  '), ' ');
        /*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

        $this->pdf->Ln(4);
        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->SetTextColor(248, 0, 0);    //color rojo
        $this->pdf->Cell(200, 5, 'RECIBO ', 0, 0, 'C');
        $this->pdf->Ln(3);
        $this->pdf->SetTextColor(0, 0, 0);    //color negro
        $this->pdf->Ln(5);

        /*  NOMBRE DEL CLIENTE*/
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode('NOMBRE CLIENTE     : ' . $nombre_cliente), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);
        /*  FECHA DE LA VENTA*/
        $this->pdf->Cell(27, 5, utf8_decode('FECHA DE VENTA      :  ' . $fechaTransaccion . '                                                                               FORMA DE PAGO  : PLAZO - ' . $modo_pago), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(7);

        /* Encabezado de la columna*/
        $this->pdf->Cell(12, 5, "CANT.", 1, 0, 'C');
        $this->pdf->Cell(20, 5, "CODIGO", 1, 0, 'C');
        $this->pdf->Cell(96, 5, "NOMBRE PRODUCTO", 1, 0, 'C');
        $this->pdf->Cell(22, 5, "ESTADO", 1, 0, 'C');
        $this->pdf->Cell(20, 5, "P/U", 1, 0, 'C');
        $this->pdf->Cell(22, 5, "TOTAL VENTA", 1, 0, 'C');

        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial', '', 7);

        $cantidad_filas = 0;

        foreach ($lista_detalle_ventas as $row_detalle) {
            if ($row_detalle->estado_entrega == 4) {
                $estado_entrega = "PENDIENTE";
            }
            if ($row_detalle->estado_entrega == 5) {
                $estado_entrega = "ENTREGADO";

            }
            $cantidad_filas++;
            $estilo = 'RL';
            if ($nro == 1) {
                $estilo = $estilo . 'T';
            }
            if ($cantidad_filas == count($lista_detalle_ventas)) {
                $estilo = 'LRB';
            }
            $this->pdf->Cell(12, 4, utf8_decode($row_detalle->cantidad), $estilo, 0, 'C');
            $this->pdf->Cell(20, 4, utf8_decode($row_detalle->codigo_barra), $estilo, 0, 'C');
            $this->pdf->Cell(96, 4, utf8_decode($row_detalle->nombre_item), $estilo, 0, 'L');
            $this->pdf->Cell(22, 4, utf8_decode($estado_entrega), $estilo, 0, 'C');
            $this->pdf->Cell(20, 4, utf8_decode($row_detalle->precio_venta), $estilo, 0, 'C');
            $this->pdf->Cell(22, 4, utf8_decode($row_detalle->cantidad * $row_detalle->precio_venta . '.00'), $estilo, 0, 'C');

            $this->pdf->Ln(4);
            $nro = $nro + 1;
        }
        $this->pdf->Ln(3);
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode('                                                                                                                                                                                                SUBTOTAL  Bs  : ' . $sub_total_venta), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);

        $this->pdf->Cell(27, 5, utf8_decode('                                                                                                                                                                                             DESCUENTO  Bs  : ' . $descuento_total_venta), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(5);
        /********/
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode('                                                                                                                                                                                                         PAGO  Bs  : ' . $monto_total), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);

        $this->pdf->Cell(27, 5, utf8_decode(' TIPO CAMBIO : ' . $tipo_cambio . '                                                                                                                                                                          SALDO  Bs  : ' . $saldo), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(5);
        /********/
        $this->pdf->Ln(2);
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(7, 5, 'MONTO TOTAL Bs  :  ', 'LTB', 0, 'L');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(125, 5, '                           ' . $valor, 'TBR', 0, 'L');
        $this->pdf->Cell(5, 5, '', '', 0, 'L');
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(20, 5, 'TOTAL Bs :', 1, 0, 'R');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(35, 5, $monto_total, 1, 0, 'R');
        $this->pdf->Ln(8);
        /*  NOTA DE LA VENTA*/
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode('USUARIO    : ' . $usuario), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);
        /*  LINEA DE SEPARACION */
        $this->pdf->Cell(27, 5, utf8_decode('NOTA          :' . $nota), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(20);
        /*  ENTREGADO Y RECIBIDO POR*/
        $this->pdf->Cell(27, 5, utf8_decode('                                   -------------------------------------------------------------   ' . '                            -------------------------------------------------------------  '), ' ');
        $this->pdf->Ln(3);
        $this->pdf->Cell(27, 5, utf8_decode('                                                       ENTREGADO                                ' . '                                                       RECIBIDO    '), ' ');

        $this->pdf->Output("ComprobanteVenta.pdf", 'I');
    }


    /*** Imprimir  en pdf ventas ****/
    public function nota_entrega_productos()
    {
        $codigo = $this->input->post('codigo');

        $datos = $this->venta->nota_entrega($codigo);
        $datos_empresa = $this->sucursal->get_datos_empresa(2);

        $lista_compras = $datos['datos'];
        $monto_total = 0;

        foreach ($lista_compras as $row_detalle) {
            $monto_total = $monto_total + $row_detalle->cantidad_total;
            $forma_pago = $row_detalle->forma_pago;
            $nombre_cliente = $row_detalle->nombre_cliente;
        }

        $this->load->library('pdf');
        $this->pdf = new Pdf('P', 'mm', 'Legal');
        $this->pdf->AddPage();

        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();

        $this->pdf->SetTitle("NOTA DE ENTREGA");
        $var_img = base_url() . 'assets/img/logo_empresa.png';
        $this->pdf->Image($var_img, 10, 10, 60, 28);

        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(133, 5, '', 0, 0, 'C');
        $this->pdf->Cell(65, 5, 'DICARP ', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->SetTextColor(248, 000, 000);

        /**/
        $this->pdf->Ln(5);
        $this->pdf->Cell(133, 5, '', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->SetTextColor(0, 0, 0);/* volvemos a color de texto negro*/

        $this->pdf->Cell(60, 5, '      Colchones y Complementos', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->MultiCell(72, 5, '', 0, 'C');
        $this->pdf->Cell(75, 5, ' ', 0, 0, 'C');

        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->SetTextColor(248, 0, 0);
        $this->pdf->Cell(60, 5, 'NOTA DE ENTREGA', 0, 0, 'C');
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetTextColor(0, 0, 0);/* volvemos a color de texto negro*/

        $this->pdf->Cell(60, 4, 'Av 26 de Febrero 2do anillo casi centenario', 0, 0, 'C');
        $this->pdf->Cell(60, 4, '', 0);
        $this->pdf->SetFont('Arial', '', 9);

        $this->pdf->MultiCell(72, 4, '', 0, 'C');
        $this->pdf->Cell(75, 5, '', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->SetTextColor(248, 0, 0);
        $this->pdf->Cell(61, 5, 'DICARP', 0, 0, 'C');

        $this->pdf->SetTextColor(0, 0, 0);
        $this->pdf->SetFont('Arial', 'B', 7);
        $this->pdf->Cell(60, 4, 'Telf. 9302099 - 70838701
', 0, 0, 'C');

        $this->pdf->Ln(10);
        $nro = 1;
        $nro = $nro + 1;

        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Ln(10);

        /*  FECHA INICIO*/
        $this->pdf->SetFont('Arial', 'B', 8);
        //$this->pdf->Cell(27, 5, utf8_decode('Nombre Cliente    :   ' . $nombre_cliente . '                            Fecha de Impresión   :  ' . date('d/m/Y') . '                           Sucursal : ' . $datos_empresa->sucursal), 'TL');
        $this->pdf->Cell(27, 5, utf8_decode('Nombre Cliente    :   ' . $nombre_cliente . '                            Fecha de Impresión   :  ' . date('d/m/Y')), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);
        /*  FECHA FIN  */
        $this->pdf->Cell(27, 5, utf8_decode('Cantidad Total   : ' . $monto_total) . '                                                                 Tipo Venta  : ' . $forma_pago, 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(7);

        /* Encabezado de la columna*/
        $this->pdf->Cell(30, 5, "NRO", 1, 0, 'C');
        $this->pdf->Cell(125, 5, "PRODUCTO", 1, 0, 'C');
        $this->pdf->Cell(37, 5, "CANTIDAD", 1, 0, 'C');


        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial', '', 8);

        $cantidad_filas = 0;

        foreach ($lista_compras as $row_detalle) {
            $cantidad_filas++;
            $estilo = 'RL';
            if ($nro == 1) {
                $estilo = $estilo . 'T';
            }
            if ($cantidad_filas == count($lista_compras)) {
                $estilo = 'LRB';
            }

            $this->pdf->Cell(30, 4, utf8_decode($cantidad_filas), $estilo, 0, 'C');
            $this->pdf->Cell(125, 4, utf8_decode($row_detalle->nombre_item), $estilo, 0, 'C');
            $this->pdf->Cell(37, 4, utf8_decode($row_detalle->cantidad_total), $estilo, 0, 'C');

            $this->pdf->Ln(4);
            $nro = $nro + 1;
        }

        $this->pdf->Output("NotaEntrega.pdf", 'I');

    }

    /************************************************************************/
    /*** IMPRESION DE LAS NOTA DE ENTREGA ****/
    public function imprimir_nota_entrega()
    {
        $venta_id = $this->uri->segment(3);
        $datos = $this->venta->comprobante_ventas($venta_id);
        $lista_compras = $datos['datos'];
        $lista_detalle_ventas = $datos['datos_venta_detalle'];

        foreach ($lista_compras as $row_detalle) {
            $nombre_cliente = $row_detalle->nombre_cliente;
            $fecha_venta = $row_detalle->fecha;

        }

        $this->load->library('pdf');
        $this->pdf = new Pdf('P', 'mm', 'Legal');
        $this->pdf->AddPage();

        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();

        $this->pdf->SetTitle("NOTA DE ENTREGA");
        $var_img = base_url() . 'assets/img/logo_empresa.png';
        $this->pdf->Image($var_img, 10, 10, 60, 28);

        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(133, 5, '', 0, 0, 'C');
        $this->pdf->Cell(65, 5, 'DICARP ', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->SetTextColor(248, 000, 000);

        /**/
        $this->pdf->Ln(5);
        $this->pdf->Cell(133, 5, '', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->SetTextColor(0, 0, 0);/* volvemos a color de texto negro*/

        $this->pdf->Cell(60, 5, '      Colchones y Complementos', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->MultiCell(72, 5, '', 0, 'C');
        $this->pdf->Cell(75, 5, ' ', 0, 0, 'C');

        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->SetTextColor(248, 0, 0);
        $this->pdf->Cell(40, 5, 'NOTA DE ENTREGA', 0, 0, 'C');
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetTextColor(0, 0, 0);/* volvemos a color de texto negro*/

        $this->pdf->Cell(90, 4, 'Av 26 de Febrero 2do anillo casi centenario', 0, 0, 'C');
        $this->pdf->Cell(60, 4, '', 0);
        $this->pdf->SetFont('Arial', '', 9);

        $this->pdf->MultiCell(72, 4, '', 0, 'C');
        $this->pdf->Cell(75, 5, '', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->SetTextColor(248, 0, 0);
        // $this->pdf->Cell(40, 5, 'Nro. ' . $nro_comprobante, 0, 0, 'C');
        $this->pdf->Cell(40, 5, ' ', 0, 0, 'C');

        $this->pdf->SetTextColor(0, 0, 0);
        $this->pdf->SetFont('Arial', 'B', 7);
        $this->pdf->Cell(100, 4, 'Telf. 9302099 - 70838701
', 0, 0, 'C');

        $this->pdf->Ln(10);
        $nro = 1;
        $nro = $nro + 1;

        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Ln(10);
        /*COLOCANDO FECHA EN LITERAL*/
        $anio = substr($fecha_venta, 0, 4);
        $mes = substr($fecha_venta, 5, 2);
        $dia = substr($fecha_venta, 8, 2);
        $fechaTransaccion = $dia . ' de ' . $this->obtener_mes($mes) . ' del ' . $anio;

        /*  NOMBRE DEL CLIENTE*/
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode('NOMBRE CLIENTE     : ' . $nombre_cliente), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);
        /*  FECHA DE LA VENTA*/
        $this->pdf->Cell(27, 5, utf8_decode('FECHA DE VENTA      : ' . $fechaTransaccion), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(11);

        /* Encabezado de la columna*/
        $this->pdf->Cell(20, 5, "CANTIDAD", 1, 0, 'C');
        $this->pdf->Cell(20, 5, "CODIGO", 1, 0, 'C');
        $this->pdf->Cell(122, 5, "NOMBRE PRODUCTO", 1, 0, 'C');
        $this->pdf->Cell(30, 5, "ESTADO", 1, 0, 'C');


        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial', '', 8);

        $cantidad_filas = 0;

        foreach ($lista_detalle_ventas as $row_detalle) {
            if ($row_detalle->estado_entrega == 4) {
                $estado_entrega = "PENDIENTE";
            }
            if ($row_detalle->estado_entrega == 5) {
                $estado_entrega = "ENTREGADO";

            }

            $cantidad_filas++;
            $estilo = 'RL';
            if ($nro == 1) {
                $estilo = $estilo . 'T';
            }
            if ($cantidad_filas == count($lista_detalle_ventas)) {
                $estilo = 'LRB';
            }


            $this->pdf->Cell(20, 4, utf8_decode($row_detalle->cantidad), $estilo, 0, 'C');
            $this->pdf->Cell(20, 4, utf8_decode($row_detalle->codigo_barra), $estilo, 0, 'C');
            $this->pdf->Cell(122, 4, utf8_decode($row_detalle->nombre_item), $estilo, 0, 'C');
            $this->pdf->Cell(30, 4, utf8_decode($estado_entrega), $estilo, 0, 'C');


            $this->pdf->Ln(4);
            $nro = $nro + 1;
        }
        $this->pdf->Ln(20);


        /*  ENTREGADO Y RECIBIDO POR*/
        $this->pdf->Cell(27, 5, utf8_decode('                                   -------------------------------------------------------------   ' . '                            -------------------------------------------------------------  '), ' ');
        $this->pdf->Ln(3);
        $this->pdf->Cell(27, 5, utf8_decode('                                                       ENTREGADO                                ' . '                                                       RECIBIDO    '), ' ');
        $this->pdf->Ln(17);
        $this->pdf->Cell(27, 5, utf8_decode('   *******************************************************      GRACIAS POR SU COMPRA VUELVA PRONTO   *************************************************  '), ' ');
        $this->pdf->Ln(8);
        $this->pdf->Cell(27, 5, utf8_decode('   ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------  '), ' ');
        /*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
        $this->pdf->Ln(6);
        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->SetTextColor(248, 0, 0);    //color rojo
        $this->pdf->Cell(200, 5, 'DICARP ', 0, 0, 'C');
        $this->pdf->Ln(5);
        // $this->pdf->Cell(200, 5, utf8_decode('COMPROBANTE DE VENTA  ' . $nro_comprobante), 0, 0, 'C');
        $this->pdf->Cell(200, 5, utf8_decode('NOTA DE ENTREGA  '), 0, 0, 'C');
        $this->pdf->SetTextColor(0, 0, 0);    //color negro
        $this->pdf->Ln(8);

        /*  NOMBRE DEL CLIENTE*/
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode('NOMBRE CLIENTE  : ' . $nombre_cliente), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);
        /*  FECHA DE LA VENTA*/
        $this->pdf->Cell(27, 5, utf8_decode('FECHA DE VENTA   :  ' . $fechaTransaccion), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(11);

        /* Encabezado de la columna*/
        $this->pdf->Cell(20, 5, "CANTIDAD", 1, 0, 'C');
        $this->pdf->Cell(20, 5, "CODIGO", 1, 0, 'C');
        $this->pdf->Cell(122, 5, "NOMBRE PRODUCTO", 1, 0, 'C');
        $this->pdf->Cell(30, 5, "ESTADO", 1, 0, 'C');


        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial', '', 8);

        $cantidad_filas = 0;

        foreach ($lista_detalle_ventas as $row_detalle) {
            if ($row_detalle->estado_entrega == 4) {
                $estado_entrega = "PENDIENTE";
            }
            if ($row_detalle->estado_entrega == 5) {
                $estado_entrega = "ENTREGADO";

            }
            $cantidad_filas++;
            $estilo = 'RL';
            if ($nro == 1) {
                $estilo = $estilo . 'T';
            }
            if ($cantidad_filas == count($lista_detalle_ventas)) {
                $estilo = 'LRB';
            }
            $this->pdf->Cell(20, 4, utf8_decode($row_detalle->cantidad), $estilo, 0, 'C');
            $this->pdf->Cell(20, 4, utf8_decode($row_detalle->codigo_barra), $estilo, 0, 'C');
            $this->pdf->Cell(122, 4, utf8_decode($row_detalle->nombre_item), $estilo, 0, 'C');
            $this->pdf->Cell(30, 4, utf8_decode($estado_entrega), $estilo, 0, 'C');


            $this->pdf->Ln(4);
            $nro = $nro + 1;
        }
        $this->pdf->Ln(20);
        /*  ENTREGADO Y RECIBIDO POR*/
        $this->pdf->Cell(27, 5, utf8_decode('                                   -------------------------------------------------------------   ' . '                            -------------------------------------------------------------  '), ' ');
        $this->pdf->Ln(3);
        $this->pdf->Cell(27, 5, utf8_decode('                                                       ENTREGADO                                ' . '                                                       RECIBIDO    '), ' ');


        $this->pdf->Output("ComprobanteVenta.pdf", 'I');
    }

}