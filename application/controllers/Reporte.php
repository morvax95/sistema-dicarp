<?php

class Reporte extends CI_Controller
{
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Este es el pie de página creado con el método Footer() de la clase creada PDF que hereda de FPDF', 'T', 0, 'C');
    }

    public function __construct()
    {
        parent::__construct();
        $this->load->model('reporte_model', 'reporte');
        $this->load->model('sucursal_model', 'sucursal');
        $this->load->model('cliente_model', 'cliente');
        $this->load->model('proveedor_model', 'proveedor');
        $this->load->model('producto_model');
    }

    public function index()
    {
        show_error('Pagina no habilitada.<br><br><a class="btn btn-danger" href="' . base_url('inicio') . '"> Volver</a> ', 'Error de acceso', '<b>PAGINA EN CONSTRUCCION</b>');
    }


    //region Metodos de reportes de venta
    public function reporte_productos()
    {
        $data['sucursales'] = $this->sucursal->get_all();
        plantilla('reporte/reporte_producto', $data);
    }

    public function reporte_materia()
    {
        $data['sucursales'] = $this->sucursal->get_all();
        $data['talla'] = $this->sucursal->get_all_talla();
        $data['color'] = $this->sucursal->get_all_color();
        plantilla('reporte/reporte_materia', $data);
    }


    public function reporte_venta()
    {
        $inicio_mes = date("Y-m");
        $inicio_dia = $inicio_mes . "-01";
        $data["fecha_inicio"] = $inicio_dia;
        $data["fecha_actual"] = date("Y-m-d");
        $data['sucursales'] = $this->sucursal->get_all();
        $data['producto'] = $this->producto_model->get_all();
        plantilla('reporte/reporte_ventas', $data);
    }

    public function flujo_caja_ingreso()
    {
        $inicio_mes = date("Y-m");
        $inicio_dia = $inicio_mes . "-01";
        $data["fecha_inicio"] = $inicio_dia;
        $data["fecha_actual"] = date("Y-m-d");
        $data['sucursales'] = $this->sucursal->get_all();
        $data['producto'] = $this->producto_model->get_all();
        plantilla('reporte/reporte_ingresos', $data);
    }


    public function reporte_inventario()
    {
        $data['sucursales'] = $this->sucursal->get_all();
        plantilla('reporte/reporte_stock', $data);
    }

    public function reporte_clientes()
    {
        $inicio_mes = date("Y-m");
        $inicio_dia = $inicio_mes . "-01";
        $data["fecha_inicio"] = $inicio_dia;
        $data["fecha_actual"] = date("Y-m-d");
        plantilla('reporte/reporte_clientes', $data);
    }

    public function reporte_cuenta_corriente()
    {
        $inicio_mes = date("Y-m");
        $inicio_dia = $inicio_mes . "-01";
        $data["fecha_inicio"] = $inicio_dia;
        $data["fecha_actual"] = date("Y-m-d");
        $data['cliente'] = $this->cliente->get_all();

        plantilla('reporte/reporte_cuenta_corriente', $data);
    }

    public function reporte_compras()
    {
        $data['proveedor'] = $this->proveedor->get_provider();
        $data['sucursal'] = $this->sucursal->get_all();
        plantilla('reporte/reporte_compras', $data);
    }

    public function stock_minimo()
    {
        $data['sucursales'] = $this->sucursal->get_all();
        plantilla('reporte/reporte_stock', $data);
    }

    public function reporte_deudas()
    {
        $inicio_mes = date("Y-m");
        $inicio_dia = $inicio_mes . "-01";
        $data["fecha_inicio"] = $inicio_dia;
        $data["fecha_actual"] = date("Y-m-d");
        $data['sucursales'] = $this->sucursal->get_all();
        plantilla('reporte/deudas', $data);
    }

    public function deudas()
    {
        $data['sucursales'] = $this->sucursal->get_all();
        plantilla('reporte/deudas', $data);
    }

    public function reporte_venta_dia()
    {
        $data["fecha_actual"] = date("Y-m-d");
        $data['sucursales'] = $this->sucursal->get_all();
        plantilla('reporte/reporte_venta_diaria', $data);
    }

//compras
    public function get_compras()
    {
        if ($this->input->is_ajax_request()) {
            $proveedor = $this->input->post('proveedor');
            $sucursal = $this->input->post('sucursal');
            echo json_encode($this->reporte->get_compras($proveedor, $sucursal));
        } else {
            show_404();
        }
    }

    //materias
    public function get_materias()
    {
        if ($this->input->is_ajax_request()) {
            //  $proveedor = $this->input->post('proveedor');
            $sucursal = $this->input->post('sucursal');
            echo json_encode($this->reporte->get_materias($sucursal));
        } else {
            show_404();
        }
    }

//cliente
    public function get_clientes()
    {
        if ($this->input->is_ajax_request()) {
            $fecha_inicio = $this->input->post('fecha_inicio');
            $fecha_fin = $this->input->post('fecha_fin');
            $talla_pantalon = $this->input->post('talla_pantalon');
            $talla_camisa = $this->input->post('talla_camisa');
            $talla_saco = $this->input->post('talla_saco');
            echo json_encode($this->reporte->get_clientes($fecha_inicio, $fecha_fin, $talla_saco, $talla_camisa, $talla_pantalon));
        } else {
            show_404();
        }
    }


//exportar excel compras
    public function exportar_excel_compras()
    {
        $proveedor = $this->input->post('proveedor');
        $sucursal = $this->input->post('sucursal');
        $datos = $this->reporte->get_compras($proveedor, $sucursal);

        $this->load->library("excel/PHPExcel");

        //membuat objek PHPExcel
        $objPHPExcel = new PHPExcel();

        //Unir celdas
        $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('F3:G3');
        $objPHPExcel->getActiveSheet()->mergeCells('H3:I3');
        $objPHPExcel->setActiveSheetIndex(0)//elegimos hoja donde vamos a escribir
//empesamos a escribir en la hoja de excel

        ->setCellValue('A1', 'Listado Compras')
//            //CABEZERA DE LA TABLA
            ->setCellValue('A3', 'Empresa: ' . 'M Y K')
            ////Encabezado de la tabla
            ->setCellValue('A5', 'FECHA COMPRA')
            ->setCellValue('B5', 'SUBTOTAL')
            ->setCellValue('C5', 'DESCUENTO')
            ->setCellValue('D5', 'MONTO TOTAL')
            ->setCellValue('E5', 'PROVEEDOR')
            ->setCellValue('F5', 'SUCURSAL');
        //poner en negritas
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('B5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('D5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('E5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('F5')->getFont()->setBold(TRUE);
//centrar los titulos
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// //Pintamos los bordes
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('C5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('E5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('F5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $fila = 6; //enpieza a escribir desde la linea 6\
        $i = 1;
        foreach ($datos['datos'] as $row) {

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $fila, $row->fecha_compra)
                ->setCellValue('B' . $fila, $row->subtotal)
                ->setCellValue('C' . $fila, $row->descuento)
                ->setCellValue('D' . $fila, $row->monto_total)
                ->setCellValue('E' . $fila, $row->nombre)
                ->setCellValue('F' . $fila, $row->sucursal);
//     //Pintar los bordes
            $objPHPExcel->getActiveSheet()->getStyle('A' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $fila = $fila + 1;
            $i++;
        }
//ESTABLECE LA ANCHURA DE LAS CELDA
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(TRUE);

//mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

//sesuaikan headernya
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//ubah nama file saat diunduh
        header('Content-Disposition: attachment;filename="ReportesCompras.xlsx"');
//unduh file
        $objWriter->save("php://output");
    }

//exportar excel clientes
    public function exportar_excel_clientes()
    {
        $fecha_inicio = $this->input->post('fecha_inicio');
        $fecha_fin = $this->input->post('fecha_fin');

        $datos = $this->reporte->get_clientes($fecha_inicio, $fecha_fin);

        $this->load->library("excel/PHPExcel");

        //membuat objek PHPExcel
        $objPHPExcel = new PHPExcel();

        //Unir celdas
        $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('F3:G3');
        $objPHPExcel->getActiveSheet()->mergeCells('H3:I3');
        $objPHPExcel->setActiveSheetIndex(0)//elegimos hoja donde vamos a escribir
//empesamos a escribir en la hoja de excel

        ->setCellValue('A1', 'Listado de Clientes')
//            //CABEZERA DE LA TABLA
            ->setCellValue('A3', 'Empresa: ' . 'DICARP')
            ////Encabezado de la tabla
            ->setCellValue('A5', 'NRO.')
            ->setCellValue('B5', 'CI /NIT')
            ->setCellValue('C5', 'NOMBRE CLIENTE')
            ->setCellValue('D5', 'TELEFONO')
            ->setCellValue('E5', 'CORREO ELECTONICO')
            ->setCellValue('F5', 'DIRECCION');

        //poner en negritas
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('B5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('D5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('E5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('F5')->getFont()->setBold(TRUE);

//centrar los titulos
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// //Pintamos los bordes
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('C5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('E5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('F5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $fila = 6; //enpieza a escribir desde la linea 6\
        $i = 1;
        foreach ($datos['datos'] as $row) {

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $fila, $i)
                ->setCellValue('B' . $fila, $row->ci_nit)
                ->setCellValue('C' . $fila, $row->nombre_cliente)
                ->setCellValue('D' . $fila, $row->telefono)
                ->setCellValue('E' . $fila, $row->correo)
                ->setCellValue('F' . $fila, $row->direccion);


//     //Pintar los bordes
            $objPHPExcel->getActiveSheet()->getStyle('A' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $fila = $fila + 1;
            $i++;
        }
//ESTABLECE LA ANCHURA DE LAS CELDA
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(TRUE);


//mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

//sesuaikan headernya
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//ubah nama file saat diunduh
        header('Content-Disposition: attachment;filename="ReportesClientes.xlsx"');
//unduh file
        $objWriter->save("php://output");
    }

    //stock
    public function reporte_stock_minimo()
    {
        if ($this->input->is_ajax_request()) {
            $sucursal = $this->input->post('sucursales');
            echo json_encode($this->reporte->reporte_stock_minimo($sucursal));
        } else {
            show_404();
        }
    }

    //solicitud de traspaso
    public function reporte_solicitud_traspaso()
    {
        if ($this->input->is_ajax_request()) {
            $fecha_solicitud = $this->input->post('fecha_solicitud');
            echo json_encode($this->reporte->reporte_solicitud_traspaso($fecha_solicitud));
        } else {
            show_404();
        }
    }

    public function get_ventas()
    {
        if ($this->input->is_ajax_request()) {
            $fecha_inicio = $this->input->post('fecha_inicio');
            $fecha_fin = $this->input->post('fecha_fin');
            echo json_encode($this->reporte->get_ventas($fecha_inicio, $fecha_fin));
        } else {
            show_404();
        }
    }

//endregion

    public function get_deudas()
    {
        if ($this->input->is_ajax_request()) {
            $sucursal = $this->input->post('sucursales');
            $fecha_inicio = $this->input->post('fecha_inicio');
            $fecha_fin = $this->input->post('fecha_fin');
            echo json_encode($this->reporte->get_deudas($fecha_inicio, $fecha_fin, $sucursal));
        } else {
            show_404();
        }
    }

    public function reporte_inventario1()
    {

        if ($this->input->is_ajax_request()) {
            $sucursal = $this->input->post('sucursales');
            echo json_encode($this->reporte->reporte_inventario($sucursal));
        } else {
            show_404();
        }
    }

    public function reporte_material()
    {

        if ($this->input->is_ajax_request()) {
            $sucursal = $this->input->post('sucursales');

            echo json_encode($this->reporte->reporte_material($sucursal));
        } else {
            show_404();
        }

    }

    public function getFacturasLCV()
    {
        if ($this->input->is_ajax_request()) {
            $mes = $this->input->post('mes');
            $anio = $this->input->post('anio');
            $sucursal = $this->input->post('sucursal');

            echo json_encode($this->reporte->getFacturasLCV($mes, $anio, $sucursal));
        } else {
            show_404();
        }
    }

    public function getTxt()
    {
        $mes = $this->uri->segment(3);
        $anio = $this->uri->segment(4);
        $sucursal = $this->uri->segment(5);

        $respuesta = $this->reporte->getFacturasLCV($mes, $anio, $sucursal);
        $empresa = $this->reporte->getNitEmpresa();
        $nit_empresa = $empresa->nit;
        $archivo = "ventas_" . $mes . $anio . "_" . $nit_empresa . ".txt";
        header('Content-Disposition: attachment;filename="' . $archivo . '"');
        ob_start();

        $linea = "";
        $i = 1;
        foreach ($respuesta as $row) {
            $nit_cliente = $row->ci_nit;
            $nombre = $row->nombre_cliente;
            $nro_factura = $row->nro_factura;
            $autorizacion = $row->autorizacion;
            $fecha = $row->fecha;
            $monto_total = $row->monto_total;
            $ice = $row->importe_ice;
            $excento = $row->importe_excento;
            $codigo_control = $row->codigo_control;
            $ventasGrabadas = $row->ventas_grabadas_taza_cero;
            $descuento = $row->descuento;
            $subtotal = $row->subtotal;
            $base_iva = $row->importe_base;
            $iva = $row->debito_fiscal;
            $estado = $row->estado;

            $linea .= $i . "|" . $fecha . "|" . $nro_factura . "|" . $autorizacion . "|" . $estado . "|" . $nit_cliente . "|" . $nombre . "|" . $monto_total . "|" . $ice . "|" . $excento . "|" . $ventasGrabadas . "|" . $subtotal . "|" . $descuento . "|" . $base_iva . "|" . $iva . "|" . $codigo_control . "\r\n";
            $i++;
        }
        ob_end_clean();
        header('Content-Type: application/txt');
        header('Content-Disposition: attachment;filename=' . $archivo . '');
        header('Pragma:no-cache');
        echo $linea;
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

    public function getExcel()
    {
        $mes = $this->uri->segment(3);
        $anio = $this->uri->segment(4);
        $sucursal = $this->uri->segment(5);

        $respuesta = $this->reporte->getFacturasLCV($mes, $anio, $sucursal);
        $empresa = $this->reporte->getNitEmpresa();
        $nit_empresa = $empresa->nit;
        $nombre_empresa = $empresa->nombre_empresa;


        $this->load->library("excel/PHPExcel");

        //membuat objek PHPExcel
        $objPHPExcel = new PHPExcel();

        //Unir celdas
        $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('F3:G3');
        $objPHPExcel->getActiveSheet()->mergeCells('H3:I3');
        $objPHPExcel->setActiveSheetIndex(0)//elegimos hoja donde vamos a escribir
//empesamos a escribir en la hoja de excel

        ->setCellValue('A1', 'Libro de Ventas I.V.A.')
//            //CABEZERA DE LA TABLA

            ->setCellValue('A3', 'Empresa: ' . $nombre_empresa)
            ->setCellValue('F3', 'Periodo Fiscal: ' . $this->obtener_mes($mes))
            ->setCellValue('H3', 'Año Fiscal: ' . $anio)
            ////Encabezado de la tabla
            ->setCellValue('A5', 'NRO.')
            ->setCellValue('B5', 'FECHA')
            ->setCellValue('C5', 'NRO. FACTURA')
            ->setCellValue('D5', 'NRO. AUTORIZACION')
            ->setCellValue('E5', 'ESTADO')
            ->setCellValue('F5', 'NIT')
            ->setCellValue('G5', 'NOMBRE CLIENTE')
            ->setCellValue('H5', 'MONTO TOTAL')
            ->setCellValue('I5', 'IMPORTE ICE')
            ->setCellValue('J5', 'IMPORTE EXENCTO')
            ->setCellValue('K5', 'VENTAS GRABADAS A TASA CERO')
            ->setCellValue('L5', 'SUBTOTAL')
            ->setCellValue('M5', 'DESCUENTOS Y BONIDICACIONES')
            ->setCellValue('N5', 'IMPORTE BASE PARA DEBITO FISCAL')
            ->setCellValue('O5', 'DEBITO FISCAL')
            ->setCellValue('P5', 'CODIGO DE CONTROL');
        //poner en negritas
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('D3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('F3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('H3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('B5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('D5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('E5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('F5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('G5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('H5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('I5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('J5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('K5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('L5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('M5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('N5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('O5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('P5')->getFont()->setBold(TRUE);
//centrar los titulos
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('O5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('P5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// //Pintamos los bordes
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('C5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('E5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('F5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('G5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('H5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('I5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('J5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('K5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('L5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('M5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('N5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('O5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('P5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $fila = 6; //enpieza a escribir desde la linea 6\
        $i = 1;
        foreach ($respuesta as $row) {

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $fila, $i)
                ->setCellValue('B' . $fila, $row->fecha)
                ->setCellValue('C' . $fila, $row->nro_factura)
                ->setCellValue('D' . $fila, $row->autorizacion . ' ')
                ->setCellValue('E' . $fila, $row->estado)
                ->setCellValue('F' . $fila, $row->ci_nit)
                ->setCellValue('G' . $fila, $row->nombre_cliente)
                ->setCellValue('H' . $fila, number_format($row->monto_total, 2) . ' ')
                ->setCellValue('I' . $fila, number_format($row->importe_ice, 2) . ' ')
                ->setCellValue('J' . $fila, number_format($row->importe_excento, 2) . ' ')
                ->setCellValue('K' . $fila, number_format($row->ventas_grabadas_taza_cero, 2) . ' ')
                ->setCellValue('L' . $fila, number_format($row->subtotal, 2) . ' ')
                ->setCellValue('M' . $fila, number_format($row->descuento, 2) . ' ')
                ->setCellValue('N' . $fila, number_format($row->importe_base, 2) . ' ')
                ->setCellValue('O' . $fila, number_format($row->debito_fiscal, 2) . ' ')
                ->setCellValue('P' . $fila, $row->codigo_control);
//     //Pintar los bordes
            $objPHPExcel->getActiveSheet()->getStyle('A' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('H' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('I' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('J' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('K' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('L' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('M' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('N' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('O' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('P' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $fila = $fila + 1;
            $i++;
        }
//ESTABLECE LA ANCHURA DE LAS CELDA
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("J")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("K")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("L")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("M")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("N")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("O")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("P")->setAutoSize(TRUE);

//mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

//sesuaikan headernya
//sesuaikan headernya
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//ubah nama file saat diunduh
        header('Content-Disposition: attachment;filename="ventas' . $mes . $anio . "_" . $nit_empresa . '.xlsx"');
//unduh file
        $objWriter->save("php://output");
    }

    public function get_ventas_emitidas()
    {
        if ($this->input->is_ajax_request()) {
            $fecha_inicio = $this->input->post('fecha_inicio');
            $fecha_fin = $this->input->post('fecha_fin');
            //  $producto = $this->input->post('sucursales');
            echo json_encode($this->reporte->get_ventas_emitidas($fecha_inicio, $fecha_fin));
        } else {
            show_404();
        }
    }

    public function get_flujo_caja_ingreso()
    {
        if ($this->input->is_ajax_request()) {
            $fecha_inicio = $this->input->post('fecha_inicio');
            $fecha_fin = $this->input->post('fecha_fin');

            echo json_encode($this->reporte->get_flujo_caja_ingreso($fecha_inicio, $fecha_fin));
        } else {
            show_404();
        }
    }


    public function get_ventas_diarias()
    {
        if ($this->input->is_ajax_request()) {
            $fecha_inicio = $this->input->post('fecha_inicio');
            //  $sucursal_id = $this->input->post('sucursales');
            echo json_encode($this->reporte->get_ventas_diarias($fecha_inicio));
        } else {
            show_404();
        }
    }

    public function get_ventas_usuario()
    {
        if ($this->input->is_ajax_request()) {
            $fecha_inicio = $this->input->post('fecha_inicio');
            $fecha_fin = $this->input->post('fecha_fin');
            echo json_encode($this->reporte->get_ventas_usuario($fecha_inicio, $fecha_fin));
        } else {
            show_404();
        }
    }

    public function exportar_excel_ventas_emitidas()
    {
        $fecha_inicio = $this->input->post('fecha_inicio');
        $fecha_fin = $this->input->post('fecha_fin');
        $sucursal_id = $this->input->post('sucursal');
        $forma_pago = $this->input->post('forma_pagos');

        $datos = $this->reporte->get_ventas_emitidas($fecha_inicio, $fecha_fin, $sucursal_id, $forma_pago);
        $empresa = $this->reporte->getNitEmpresa();
        $nit_empresa = $empresa->nit;
        $nombre_empresa = $empresa->nombre_empresa;

        $this->load->library("excel/PHPExcel");

        //membuat objek PHPExcel
        $objPHPExcel = new PHPExcel();

        //Unir celdas
        $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('F3:G3');
        $objPHPExcel->getActiveSheet()->mergeCells('H3:I3');
        $objPHPExcel->setActiveSheetIndex(0)//elegimos hoja donde vamos a escribir
//empesamos a escribir en la hoja de excel

        ->setCellValue('A1', 'Ventas Emitidas')
//            //CABEZERA DE LA TABLA
            ->setCellValue('A3', 'Empresa: ' . 'DICARP')//. $nombre_empresa)
            ////Encabezado de la tabla
            ->setCellValue('A5', 'NRO.')
            ->setCellValue('B5', 'FECHA')
            ->setCellValue('C5', 'CI/NIT')
            ->setCellValue('D5', 'NOMBRE CLIENTE')
            ->setCellValue('E5', 'PRODUCTO')
            ->setCellValue('F5', 'CANTIDAD')
            ->setCellValue('G5', 'SUCURSAL');
        //poner en negritas
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('B5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('D5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('E5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('F5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('G5')->getFont()->setBold(TRUE);
//centrar los titulos
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// //Pintamos los bordes
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('C5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('E5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('F5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('G5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $fila = 6; //enpieza a escribir desde la linea 6\
        $i = 1;
        foreach ($datos['datos'] as $row) {

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $fila, $i)
                ->setCellValue('A' . $fila, $row->nro_nota)
                ->setCellValue('B' . $fila, $row->fecha)
                ->setCellValue('C' . $fila, $row->ci_nit)
                ->setCellValue('D' . $fila, $row->nombre_cliente)
                ->setCellValue('E' . $fila, $row->producto)
                ->setCellValue('F' . $fila, $row->cantidad)
                ->setCellValue('G' . $fila, $row->sucursal);
//     //Pintar los bordes
            $objPHPExcel->getActiveSheet()->getStyle('A' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $fila = $fila + 1;
            $i++;
        }
//ESTABLECE LA ANCHURA DE LAS CELDA
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(TRUE);

//mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

//sesuaikan headernya
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//ubah nama file saat diunduh
        header('Content-Disposition: attachment;filename="ReporteVentasRealizadas.xlsx"');
//unduh file
        $objWriter->save("php://output");
    }

    public function exportar_excel_ventas_diarias()
    {
        $fecha_inicio = $this->input->post('fecha_inicio');
        $sucursal_id = $this->input->post('sucursal');
        $datos = $this->reporte->get_ventas_diarias($fecha_inicio, $sucursal_id);
        $empresa = $this->reporte->getNitEmpresa();
        $nit_empresa = $empresa->nit;
        $nombre_empresa = $empresa->nombre_empresa;

        $this->load->library("excel/PHPExcel");

        //membuat objek PHPExcel
        $objPHPExcel = new PHPExcel();

        //Unir celdas
        $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('F3:G3');
        $objPHPExcel->getActiveSheet()->mergeCells('H3:I3');
        $objPHPExcel->setActiveSheetIndex(0)//elegimos hoja donde vamos a escribir
//empesamos a escribir en la hoja de excel

        ->setCellValue('A1', 'Facturas Emitidas')
//            //CABEZERA DE LA TABLA
            ->setCellValue('A3', 'Empresa: ' . $nombre_empresa)
            ////Encabezado de la tabla
            ->setCellValue('A5', 'NRO.')
            ->setCellValue('B5', 'FECHA')
            ->setCellValue('C5', 'CI/NIT')
            ->setCellValue('D5', 'NOMBRE CLIENTE')
            ->setCellValue('E5', 'PRODUCTO')
            ->setCellValue('F5', 'PRECIO VENTA')
            ->setCellValue('G5', 'CANTIDAD')
            ->setCellValue('H5', 'MONTO BS')
            ->setCellValue('I5', 'SUCURSAL');
        //poner en negritas
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('B5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('D5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('E5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('F5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('G5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('H5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('I5')->getFont()->setBold(TRUE);
//centrar los titulos
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// //Pintamos los bordes
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('C5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('E5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('F5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('G5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('H5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('I5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $fila = 6; //enpieza a escribir desde la linea 6\
        $i = 1;
        foreach ($datos['datos'] as $row) {

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $fila, $i)
                ->setCellValue('A' . $fila, $row->nro_nota)
                ->setCellValue('B' . $fila, $row->fecha)
                ->setCellValue('C' . $fila, $row->ci_nit)
                ->setCellValue('D' . $fila, $row->nombre_cliente)
                ->setCellValue('E' . $fila, $row->producto)
                ->setCellValue('F' . $fila, $row->precio_venta)
                ->setCellValue('G' . $fila, $row->cantidad)
                ->setCellValue('H' . $fila, $row->total)
                ->setCellValue('I' . $fila, $row->sucursal);
//     //Pintar los bordes
            $objPHPExcel->getActiveSheet()->getStyle('A' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('H' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('I' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $fila = $fila + 1;
            $i++;
        }
//ESTABLECE LA ANCHURA DE LAS CELDA
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(TRUE);

//mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

//sesuaikan headernya
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//ubah nama file saat diunduh
        header('Content-Disposition: attachment;filename="ReporteVentasDiarias.xlsx"');
//unduh file
        $objWriter->save("php://output");
    }


    //imprimir en excel el inventario
    public function exportar_inventario()
    {
        $id_sucursal = $this->input->post('sucursales');
        $result = $this->reporte->reporte_stock_minimo($id_sucursal);
        $empresa = $this->reporte->getNitEmpresa();
        $nit_empresa = $empresa->nit;
        $nombre_empresa = $empresa->nombre_empresa;

        $this->load->library("excel/PHPExcel");

        //membuat objek PHPExcel
        $objPHPExcel = new PHPExcel();

        //Unir celdas
        $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('F3:G3');
        $objPHPExcel->getActiveSheet()->mergeCells('H3:I3');
        $objPHPExcel->setActiveSheetIndex(0)//elegimos hoja donde vamos a escribir
//empesamos a escribir en la hoja de excel

        ->setCellValue('A1', ' REPORTE DE STOCK DE INVENTARIO')
//            //CABEZERA DE LA TABLA
            ->setCellValue('A3', 'Empresa: ' . $nombre_empresa)
            ->setCellValue('F3', 'Fecha: ' . date('Y-m-d'))
            ////Encabezado de la tabla
            ->setCellValue('A5', 'NRO.')
            ->setCellValue('B5', 'CODIGO')
            ->setCellValue('C5', 'PRODUCTO')
            ->setCellValue('D5', 'COLOR')
            ->setCellValue('E5', 'TALLA')
            ->setCellValue('F5', 'PRECIO VENTA')
            ->setCellValue('G5', 'ESTADO INVENTARIO')
            ->setCellValue('H5', 'CANTIDAD')
            ->setCellValue('I5', 'DEPOSITO');
        //poner en negritas
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('D3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('F3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('H3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('B5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('D5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('E5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('F5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('G5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('H5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('I5')->getFont()->setBold(TRUE);
//centrar los titulos
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// //Pintamos los bordes
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('C5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('E5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('F5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('G5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('H5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('I5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $fila = 6; //enpieza a escribir desde la linea 6\
        $i = 1;
        foreach ($result as $row) {

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $fila, $i)
                ->setCellValue('B' . $fila, $row->codigo_barra)
                ->setCellValue('C' . $fila, $row->nombre_item)
                ->setCellValue('D' . $fila, $row->color)
                ->setCellValue('E' . $fila, $row->talla)
                ->setCellValue('F' . $fila, $row->precio_venta)
                ->setCellValue('G' . $fila, $row->estado_inventario)
                ->setCellValue('H' . $fila, $row->cantidad)
                ->setCellValue('I' . $fila, $row->almacen);
//     //Pintar los bordes
            $objPHPExcel->getActiveSheet()->getStyle('A' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('H' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('I' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $fila = $fila + 1;
            $i++;
        }
//ESTABLECE LA ANCHURA DE LAS CELDA
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO

//mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

//sesuaikan headernya
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//ubah nama file saat diunduh
        header('Content-Disposition: attachment;filename="StockInventario.xlsx"');
//unduh file
        $objWriter->save("php://output");
    }

    //imprimir en excel el inventario
    public function exportar_material()
    {
        $id_sucursal = $this->input->post('sucursales');
        $result = $this->reporte->reporte_stock_minimo($id_sucursal);
        $empresa = $this->reporte->getNitEmpresa();
        $nit_empresa = $empresa->nit;
        $nombre_empresa = $empresa->nombre_empresa;

        $this->load->library("excel/PHPExcel");

        //membuat objek PHPExcel
        $objPHPExcel = new PHPExcel();

        //Unir celdas
        $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('F3:G3');
        $objPHPExcel->getActiveSheet()->mergeCells('H3:I3');
        $objPHPExcel->setActiveSheetIndex(0)//elegimos hoja donde vamos a escribir
//empesamos a escribir en la hoja de excel

        ->setCellValue('A1', ' REPORTE DE MATERIAS PRIMAS')
//            //CABEZERA DE LA TABLA
            ->setCellValue('A3', 'Empresa: ' . $nombre_empresa)
            ->setCellValue('F3', 'Fecha: ' . date('Y-m-d'))
            ////Encabezado de la tabla
            ->setCellValue('A5', 'NRO.')
            ->setCellValue('B5', 'CODIGO')
            ->setCellValue('C5', 'PRODUCTO')
            ->setCellValue('D5', 'TIPO PRODUCTO')
            ->setCellValue('E5', 'TALLA')
            ->setCellValue('F5', 'PRECIO VENTA')
            ->setCellValue('G5', 'ESTADO INVENTARIO')
            ->setCellValue('H5', 'CANTIDAD')
            ->setCellValue('I5', 'DEPOSITO');
        //poner en negritas
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('D3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('F3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('H3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('B5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('D5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('E5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('F5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('G5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('H5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('I5')->getFont()->setBold(TRUE);
//centrar los titulos
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// //Pintamos los bordes
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('C5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('E5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('F5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('G5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('H5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('I5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $fila = 6; //enpieza a escribir desde la linea 6\
        $i = 1;
        foreach ($result as $row) {

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $fila, $i)
                ->setCellValue('B' . $fila, $row->codigo_barra)
                ->setCellValue('C' . $fila, $row->nombre_item)
                ->setCellValue('D' . $fila, $row->tipo_producto)
                ->setCellValue('E' . $fila, $row->talla)
                ->setCellValue('F' . $fila, $row->precio_venta)
                ->setCellValue('G' . $fila, $row->estado_inventario)
                ->setCellValue('H' . $fila, $row->cantidad)
                ->setCellValue('I' . $fila, $row->almacen);
//     //Pintar los bordes
            $objPHPExcel->getActiveSheet()->getStyle('A' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('H' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('I' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $fila = $fila + 1;
            $i++;
        }
//ESTABLECE LA ANCHURA DE LAS CELDA
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO

//mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

//sesuaikan headernya
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//ubah nama file saat diunduh
        header('Content-Disposition: attachment;filename="ReporteMateriaPrimas.xlsx"');
//unduh file
        $objWriter->save("php://output");
    }

    //imprimir en excel el stock minimo
    public function exportar_stock_minimo()
    {
        $id_sucursal = $this->input->post('sucursales');
        $result = $this->reporte->reporte_stock_minimo($id_sucursal);
        $empresa = $this->reporte->getNitEmpresa();
        $nit_empresa = $empresa->nit;
        $nombre_empresa = $empresa->nombre_empresa;

        $this->load->library("excel/PHPExcel");

        //membuat objek PHPExcel
        $objPHPExcel = new PHPExcel();

        //Unir celdas
        $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('F3:G3');
        $objPHPExcel->getActiveSheet()->mergeCells('H3:I3');
        $objPHPExcel->setActiveSheetIndex(0)//elegimos hoja donde vamos a escribir
//empesamos a escribir en la hoja de excel

        ->setCellValue('A1', 'Productos con Stock Minimo')
//            //CABEZERA DE LA TABLA
//            ->setCellValue('A2', 'ID Transaccion: '.$_REQUEST['idTransaccion'])
//            ->setCellValue('C2', 'Paciente: '.$_REQUEST['paciente'])
            ->setCellValue('A3', 'Empresa: ' . $nombre_empresa)
            ->setCellValue('F3', 'Fecha: ' . date('Y-m-d'))
            ////Encabezado de la tabla
            ->setCellValue('A5', 'NRO.')
            ->setCellValue('B5', 'CODIGO')
            ->setCellValue('C5', 'PRODUCTO')
            ->setCellValue('D5', 'COLOR')
            ->setCellValue('E5', 'TALLA')
            ->setCellValue('F5', 'PRECIO VENTA')
            ->setCellValue('G5', 'ESTADO INVENTARIO')
            ->setCellValue('H5', 'CANTIDAD')
            ->setCellValue('I5', 'DEPOSITO');
        //poner en negritas
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('D3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('F3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('H3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('B5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('D5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('E5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('F5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('G5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('H5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('I5')->getFont()->setBold(TRUE);
//centrar los titulos
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// //Pintamos los bordes
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('C5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('E5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('F5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('G5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('H5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('I5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $fila = 6; //enpieza a escribir desde la linea 6\
        $i = 1;
        foreach ($result as $row) {

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $fila, $i)
                ->setCellValue('B' . $fila, $row->codigo_barra)
                ->setCellValue('C' . $fila, $row->nombre_item)
                ->setCellValue('D' . $fila, $row->color)
                ->setCellValue('E' . $fila, $row->talla)
                ->setCellValue('F' . $fila, $row->precio_venta)
                ->setCellValue('G' . $fila, $row->estado_inventario)
                ->setCellValue('H' . $fila, $row->cantidad)
                ->setCellValue('I' . $fila, $row->almacen);
//     //Pintar los bordes
            $objPHPExcel->getActiveSheet()->getStyle('A' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('H' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('I' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $fila = $fila + 1;
            $i++;
        }
//ESTABLECE LA ANCHURA DE LAS CELDA
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO

//mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

//sesuaikan headernya
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//ubah nama file saat diunduh
        header('Content-Disposition: attachment;filename="ProductosConStockMinimo.xlsx"');
//unduh file
        $objWriter->save("php://output");
    }

    //imprimir en excel el stock minimo
    public function exportar_solicitud_traspaso()
    {
        $id_sucursal = $this->input->post('fecha_solicitud');
        $result = $this->reporte->reporte_solicitud_traspaso($id_sucursal);
        $empresa = $this->reporte->getNitEmpresa();
        $nit_empresa = $empresa->nit;
        $nombre_empresa = $empresa->nombre_empresa;

        $this->load->library("excel/PHPExcel");

        //membuat objek PHPExcel
        $objPHPExcel = new PHPExcel();

        //Unir celdas
        $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('F3:G3');
        $objPHPExcel->getActiveSheet()->mergeCells('H3:I3');
        $objPHPExcel->setActiveSheetIndex(0)//elegimos hoja donde vamos a escribir
//empesamos a escribir en la hoja de excel

        ->setCellValue('A1', 'Solicitud Traspaso de Mercaderia')
//            //CABEZERA DE LA TABLA

            ->setCellValue('A3', 'Empresa: ' . $nombre_empresa)
            ->setCellValue('F3', 'Fecha: ' . date('Y-m-d'))
            ////Encabezado de la tabla
            ->setCellValue('A5', 'NRO.')
            ->setCellValue('B5', 'ALMACEN ORIGEN')
            ->setCellValue('C5', 'ALMACEN DESTINO')
            ->setCellValue('D5', 'FECHA SALIDA')
            ->setCellValue('E5', 'USUARIO SOLICITA')
            ->setCellValue('F5', 'PRODUCTO')
            ->setCellValue('G5', 'CANTIDAD');
        //poner en negritas
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('D3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('F3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('H3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('B5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('D5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('E5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('F5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('G5')->getFont()->setBold(TRUE);
//centrar los titulos
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// //Pintamos los bordes
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('C5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('E5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('F5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('G5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $fila = 6; //enpieza a escribir desde la linea 6\
        $i = 1;
        foreach ($result as $row) {

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $fila, $i)
                ->setCellValue('B' . $fila, $row->almacen_origen)
                ->setCellValue('C' . $fila, $row->almacen_destino)
                ->setCellValue('D' . $fila, $row->fecha_salida)
                ->setCellValue('E' . $fila, $row->nombre_usuario)
                ->setCellValue('F' . $fila, $row->producto)
                ->setCellValue('G' . $fila, $row->cantidad);
//     //Pintar los bordes
            $objPHPExcel->getActiveSheet()->getStyle('A' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $fila = $fila + 1;
            $i++;
        }
//ESTABLECE LA ANCHURA DE LAS CELDA
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO

//mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

//sesuaikan headernya
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//ubah nama file saat diunduh
        header('Content-Disposition: attachment;filename="Solicitud_Traspaso_Mercaderia.xlsx"');
//unduh file
        $objWriter->save("php://output");
    }


    public function exportar_deudas()
    {
        $fecha_inicio = $this->input->post('inicio');
        $fecha_fin = $this->input->post('fin');
        $sucursal = $this->input->post('sucursal');

        $result = $this->reporte->get_deudas($fecha_inicio, $fecha_fin, $sucursal);
        $empresa = $this->reporte->getNitEmpresa();
        $nit_empresa = $empresa->nit;
        $nombre_empresa = $empresa->nombre_empresa;


        $this->load->library("excel/PHPExcel");

        //membuat objek PHPExcel
        $objPHPExcel = new PHPExcel();

        //Unir celdas
        $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('F3:G3');
        $objPHPExcel->getActiveSheet()->mergeCells('H3:I3');
        $objPHPExcel->setActiveSheetIndex(0)//elegimos hoja donde vamos a escribir
//empesamos a escribir en la hoja de excel

        ->setCellValue('A1', 'Deudas por cobrar')
//            //CABEZERA DE LA TABLA
//            ->setCellValue('A2', 'ID Transaccion: '.$_REQUEST['idTransaccion'])
//            ->setCellValue('C2', 'Paciente: '.$_REQUEST['paciente'])
            ->setCellValue('A3', 'Empresa: ' . $nombre_empresa)
            ->setCellValue('F3', 'Fecha: ' . date('Y-m-d'))
            ////Encabezado de la tabla
            ->setCellValue('A5', 'NRO.')
            ->setCellValue('B5', 'FECHA VENTA')
            ->setCellValue('C5', 'CLIENTE')
            ->setCellValue('D5', 'TOTAL VENTA')
            ->setCellValue('E5', 'TOTAL PAGADO')
            ->setCellValue('F5', 'SALDO')
            ->setCellValue('G5', 'ESTADO');
        //poner en negritas
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('D3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('F3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('H3')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('B5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('D5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('E5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('F5')->getFont()->setBold(TRUE)
            ->getActiveSheet()->getStyle('G5')->getFont()->setBold(TRUE);
//centrar los titulos
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// //Pintamos los bordes
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('C5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('E5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('F5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('G5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $fila = 6; //enpieza a escribir desde la linea 6\
        $i = 1;
        foreach ($result as $row) {

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $fila, $i)
                ->setCellValue('B' . $fila, $row->fecha)
                ->setCellValue('C' . $fila, $row->nombre_cliente)
                ->setCellValue('D' . $fila, $row->total)
                ->setCellValue('E' . $fila, $row->total_pagado)
                ->setCellValue('F' . $fila, $row->saldo)
                ->setCellValue('G' . $fila, $row->estado);
//     //Pintar los bordes
            $objPHPExcel->getActiveSheet()->getStyle('A' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G' . $fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $fila = $fila + 1;
            $i++;
        }
//ESTABLECE LA ANCHURA DE LAS CELDA
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(TRUE); //DAR ANCHURA  A LAS CELDAS AUTOMATICO

//mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

//sesuaikan headernya
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//ubah nama file saat diunduh
        header('Content-Disposition: attachment;filename="DeudasPorCobrar.xlsx"');
//unduh file
        $objWriter->save("php://output");
    }
//----------------------------------------------------------------------------------

    /*** Imprimir  en pdf cuentas corrientes ****/
    public function imprimir_cuentas_corrientes()
    {
        $cliente = $this->input->post('cliente');
        $fecha_inicio = $this->input->post('fecha_inicio');
        $fecha_fin = $this->input->post('fecha_fin');
        $datos = $this->reporte->get_cuentas_clientes($cliente, $fecha_inicio, $fecha_fin);
        $datos_sumatoria = $this->reporte->get_cuentas_cliente_sumatoria($cliente, $fecha_inicio, $fecha_fin);

        $lista_datos = $datos['datos'];
        $lista_datos_sumatoria = $datos_sumatoria['datos_sumatoria'];


        foreach ($lista_datos as $row_detalle) {
            $nombre_cliente = $row_detalle->cliente;
            $telefono = $row_detalle->telefono;
        }

        $monto_total_venta = 0;
        $monto_total_saldo = 0;
        $monto_total_pagado = 0;

        foreach ($lista_datos_sumatoria as $row_detalle) {
            $monto_total_venta = $monto_total_venta + $row_detalle->monto_total;
            $monto_total_pagado = $monto_total_pagado + $row_detalle->monto;
            $monto_total_saldo = $monto_total_venta - $monto_total_pagado;

        }

        $this->load->library('pdf');
        $this->pdf = new Pdf('P', 'mm', 'Legal');
        $this->pdf->AddPage();

        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();
        $this->pdf->SetTitle("REPORTE");
        $var_img = base_url() . 'assets/img/logo_empresa.png';
        $this->pdf->Image($var_img, 10, 10, 60, 28);

        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(133, 5, '', 0, 0, 'C');
        $this->pdf->Cell(65, 5, 'DICARP ', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->SetTextColor(248, 000, 000);

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
        $this->pdf->Cell(50, 5, 'CUENTA CORRIENTE ', 0, 0, 'C');
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetTextColor(0, 0, 0);/* volvemos a color de texto negro*/

        $this->pdf->Cell(70, 4, 'Av 26 de Febrero 2do anillo casi centenario', 0, 0, 'C');
        $this->pdf->Cell(60, 4, '', 0);
        $this->pdf->SetFont('Arial', '', 9);

        $this->pdf->MultiCell(72, 4, '', 0, 'C');
        $this->pdf->Cell(75, 5, '', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->SetTextColor(248, 0, 0);
        $this->pdf->Cell(51, 5, 'CLIENTES', 0, 0, 'C');

        $this->pdf->SetTextColor(0, 0, 0);
        $this->pdf->SetFont('Arial', 'B', 7);
        $this->pdf->Cell(77, 4, 'Telf. 9302099 - 70838701', 0, 0, 'C');

        $this->pdf->Ln(8);

        $nro = 1;
        $nro = $nro + 1;

        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Ln(10);


        /*  FECHA IMRESION*/
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode(' FECHA IMPRESIÓN :  ' . date('d/m/Y') . '                        FECHA INICIO :' . $fecha_inicio . '          FECHA FIN : ' . $fecha_fin), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);
        /*  CANTIDAD  */
        $this->pdf->Cell(27, 5, utf8_decode(' NOMBRE CLIENTE  : ' . $nombre_cliente . '                 TELEFONO : ' . $telefono), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(7);


        /* Encabezado de la columna*/
        $this->pdf->Cell(10, 5, "NRO", 1, 0, 'C');
        $this->pdf->Cell(28, 5, "FECHA", 1, 0, 'C');
        $this->pdf->Cell(30, 5, "COMPR. VENTA ", 1, 0, 'C');
        $this->pdf->Cell(44, 5, "DEBE", 1, 0, 'C');
        $this->pdf->Cell(46, 5, "HABER", 1, 0, 'C');
        $this->pdf->Cell(34, 5, "SALDO", 1, 0, 'C');

        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial', '', 8);
        $cantidad_filas = 0;

        $lista_compras = $datos['datos'];

        foreach ($lista_compras as $row_detalle) {
            $cantidad_filas++;
            $estilo = 'RL';
            if ($nro == 1) {
                $estilo = $estilo . 'T';
            }
            if ($cantidad_filas == count($lista_compras)) {
                $estilo = 'LRB';
            }
            $this->pdf->Cell(10, 4, utf8_decode($cantidad_filas), $estilo, 0, 'C');
            $this->pdf->Cell(28, 4, utf8_decode($row_detalle->fecha), $estilo, 0, 'C');
            $this->pdf->Cell(30, 4, utf8_decode('000' . $row_detalle->id), $estilo, 0, 'C');
            $this->pdf->Cell(44, 4, utf8_decode($row_detalle->total_venta), $estilo, 0, 'C');
            $this->pdf->Cell(46, 4, utf8_decode($row_detalle->monto_pagado), $estilo, 0, 'C');
            $this->pdf->Cell(34, 4, utf8_decode($row_detalle->total_venta - $row_detalle->monto_pagado), $estilo, 0, 'C');


            $this->pdf->Ln(4);
            $nro = $nro + 1;

        }
        // Convertimos el monto en literal
        $this->pdf->Ln(5);

        $this->pdf->Cell(35, 5, 'TOTAL DEBE Bs :', 1, 0, 'R');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(26, 5, ' ' . $monto_total_venta, 1, 0, 'R');
        $this->pdf->Cell(5, 5, '', '', 0, 'L');
        $this->pdf->Cell(35, 5, 'TOTAL HABER Bs :', 1, 0, 'R');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(25, 5, ' ' . $monto_total_pagado, 1, 0, 'R');
        $this->pdf->Cell(5, 5, '', '', 0, 'L');
        $this->pdf->Cell(35, 5, 'TOTAL SALDO Bs :', 1, 0, 'R');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(25, 5, ' ' . $monto_total_saldo, 1, 0, 'R');

        $this->pdf->Output("Reporte.pdf", 'I');

    }

    /*** Imprimir  en pdf clientes ****/
    public function imprimir_clientes()
    {
        $fecha_inicio = $this->input->post('fecha_inicio');
        $fecha_fin = $this->input->post('fecha_fin');
        $datos = $this->reporte->get_clientes($fecha_inicio, $fecha_fin);


        $this->load->library('pdf');
        $this->pdf = new Pdf('P', 'mm', 'Legal');
        $this->pdf->AddPage();

        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();
        $this->pdf->SetTitle("REPORTE");
        $var_img = base_url() . 'assets/img/logo_empresa.png';
        $this->pdf->Image($var_img, 10, 10, 60, 28);

        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(133, 5, '', 0, 0, 'C');
        $this->pdf->Cell(65, 5, 'DICARP ', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->SetTextColor(248, 000, 000);

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
        $this->pdf->Cell(50, 5, 'REPORTE DE CLIENTES', 0, 0, 'C');
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetTextColor(0, 0, 0);/* volvemos a color de texto negro*/

        $this->pdf->Cell(70, 4, 'Av 26 de Febrero 2do anillo casi centenario', 0, 0, 'C');
        $this->pdf->Cell(60, 4, '', 0);
        $this->pdf->SetFont('Arial', '', 9);

        $this->pdf->MultiCell(72, 4, '', 0, 'C');
        $this->pdf->Cell(75, 5, '', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->SetTextColor(248, 0, 0);
        $this->pdf->Cell(51, 5, 'DICARP', 0, 0, 'C');

        $this->pdf->SetTextColor(0, 0, 0);
        $this->pdf->SetFont('Arial', 'B', 7);
        $this->pdf->Cell(77, 4, 'Telf. 9302099 - 70838701', 0, 0, 'C');

        $this->pdf->Ln(8);

        $nro = 1;
        $nro = $nro + 1;

        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Ln(10);


        /*  FECHA IMRESION*/
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode(' Fecha de Impresión   :  ' . date('d/m/Y')), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);
        /*  CANTIDAD  */
        $this->pdf->Cell(27, 5, utf8_decode(' '), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(7);


        /* Encabezado de la columna*/
        $this->pdf->Cell(10, 5, "NRO", 1, 0, 'C');
        $this->pdf->Cell(50, 5, "NOMBRE CLIENTE", 1, 0, 'C');
        $this->pdf->Cell(25, 5, "TELEFONO", 1, 0, 'C');
        $this->pdf->Cell(45, 5, "CORREO", 1, 0, 'C');
        $this->pdf->Cell(62, 5, "DIRECCION", 1, 0, 'C');

        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial', '', 8);
        $cantidad_filas = 0;

        $lista_compras = $datos['datos'];

        foreach ($lista_compras as $row_detalle) {
            $cantidad_filas++;
            $estilo = 'RL';
            if ($nro == 1) {
                $estilo = $estilo . 'T';
            }
            if ($cantidad_filas == count($lista_compras)) {
                $estilo = 'LRB';
            }
            $this->pdf->Cell(10, 4, utf8_decode($cantidad_filas), $estilo, 0, 'C');
            $this->pdf->Cell(50, 4, utf8_decode($row_detalle->nombre_cliente), $estilo, 0, 'C');
            $this->pdf->Cell(25, 4, utf8_decode($row_detalle->telefono), $estilo, 0, 'C');
            $this->pdf->Cell(45, 4, utf8_decode($row_detalle->correo), $estilo, 0, 'C');
            $this->pdf->Cell(62, 4, utf8_decode($row_detalle->direccion), $estilo, 0, 'C');


            $this->pdf->Ln(4);
            $nro = $nro + 1;

        }
        $this->pdf->Output("ReporteClientes.pdf", 'I');

    }

    /*** Imprimir  en pdf deudas ****/
    public function imprimir_deudas()
    {
        $sucursal = $this->input->post('sucursal');
        $fecha_inicio = $this->input->post('fecha_inicio');
        $fecha_fin = $this->input->post('fecha_fin');
        $datos = $this->reporte->get_deudas($fecha_inicio, $fecha_fin, $sucursal);

        $datos_total_suma = $this->reporte->sum_saldo($fecha_inicio, $fecha_fin, $sucursal);
        $lista_datos_sumatoria = $datos_total_suma['datos_total_saldo'];

        $total_saldo = 0;

        foreach ($lista_datos_sumatoria as $row_detalle) {
            $total_saldo = $total_saldo + $row_detalle->saldo;


        }
        //$total_saldo= $total_saldo +   $total_saldo1;

        $this->load->library('pdf');
        $this->pdf = new Pdf('P', 'mm', 'Legal');
        $this->pdf->AddPage();

        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();
        $this->pdf->SetTitle("DEUDAS POR COBRAR");
        $var_img = base_url() . 'assets/img/logo_empresa.png';
        $this->pdf->Image($var_img, 10, 10, 60, 28);

        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(133, 5, '', 0, 0, 'C');
        $this->pdf->Cell(65, 5, 'DICARP ', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->SetTextColor(248, 000, 000);

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
        $this->pdf->Cell(50, 5, 'DEUDAS POR COBRAR', 0, 0, 'C');
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetTextColor(0, 0, 0);/* volvemos a color de texto negro*/

        $this->pdf->Cell(70, 4, 'Av 26 de Febrero 2do anillo casi centenario', 0, 0, 'C');
        $this->pdf->Cell(60, 4, '', 0);
        $this->pdf->SetFont('Arial', '', 9);

        $this->pdf->MultiCell(72, 4, '', 0, 'C');
        $this->pdf->Cell(75, 5, '', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->SetTextColor(248, 0, 0);
        $this->pdf->Cell(51, 5, 'DICARP', 0, 0, 'C');

        $this->pdf->SetTextColor(0, 0, 0);
        $this->pdf->SetFont('Arial', 'B', 7);
        $this->pdf->Cell(77, 4, 'Telf. 9302099 - 70838701', 0, 0, 'C');

        $this->pdf->Ln(8);

        $nro = 1;
        $nro = $nro + 1;

        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Ln(10);

        /*  FECHA IMRESION*/
        $this->pdf->SetFont('Arial', 'B', 8);
        //$this->pdf->Cell(27, 5, utf8_decode(' Fecha de Impresión   :  ' . date('d/m/Y') . '             Fecha Inicio     : ' . $fecha_inicio . '          Fecha Fin   : ' . $fecha_fin . '        Total Saldo  : ' . $total_saldo), 'TL');
        $this->pdf->Cell(27, 5, utf8_decode(' Fecha de Impresión   :  ' . date('d/m/Y') . '             Fecha Inicio     : ' . $fecha_inicio . '          Fecha Fin   : ' . $fecha_fin), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(3);
        /*  FECHA DE VENTA  */
        $this->pdf->Cell(27, 5, utf8_decode('    '), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(7);


        /* Encabezado de la columna*/
        $this->pdf->Cell(10, 5, "NRO", 1, 0, 'C');
        $this->pdf->Cell(85, 5, "NOMBRE CLIENTE", 1, 0, 'C');
        $this->pdf->Cell(30, 5, "TOTAL VENTA", 1, 0, 'C');
        $this->pdf->Cell(35, 5, "TOTAL PAGADO", 1, 0, 'C');
        $this->pdf->Cell(32, 5, "SALDO", 1, 0, 'C');

        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial', '', 8);
        $cantidad_filas = 0;

        $lista_compras = $datos['datos'];

        foreach ($lista_compras as $row_detalle) {

            $cantidad_filas++;
            $estilo = 'RL';
            if ($nro == 1) {
                $estilo = $estilo . 'T';
            }
            if ($cantidad_filas == count($lista_compras)) {
                $estilo = 'LRB';
            }
            $this->pdf->Cell(10, 4, utf8_decode($cantidad_filas), $estilo, 0, 'C');
            $this->pdf->Cell(85, 4, utf8_decode($row_detalle->nombre_cliente), $estilo, 0, 'L');
            $this->pdf->Cell(30, 4, utf8_decode($row_detalle->total), $estilo, 0, 'C');
            $this->pdf->Cell(35, 4, utf8_decode($row_detalle->total_pagado), $estilo, 0, 'C');
            $this->pdf->Cell(32, 4, utf8_decode($row_detalle->saldo), $estilo, 0, 'C');


            $this->pdf->Ln(4);
            $nro = $nro + 1;

        }
        $this->pdf->Output("DeudasPorCobrar.pdf", 'I');

    }

    /*** Imprimir  en pdf ingresos ****/
    public function imprimir_ingresos()
    {
        $fecha_inicio = $this->input->post('fecha_inicio');
        $fecha_fin = $this->input->post('fecha_fin');

        $datos = $this->reporte->get_ingreso_total($fecha_inicio, $fecha_fin);
        $datos_ingresos_efectivo_plazo = $this->reporte->get_ingreso_efectivo_plazo($fecha_inicio, $fecha_fin);
        $datos_ingresos_efectivo_contado = $this->reporte->get_ingreso_efectivo_contado($fecha_inicio, $fecha_fin);

        $datos_ingresos_tarjeta_plazo = $this->reporte->get_ingreso_tarjeta_plazo($fecha_inicio, $fecha_fin);
        $datos_ingresos_tarjeta_contado = $this->reporte->get_ingreso_tarjeta_contado($fecha_inicio, $fecha_fin);

        $datos_ingresos_cheque_plazo = $this->reporte->get_ingreso_cheque_plazo($fecha_inicio, $fecha_fin);
        $datos_ingresos_cheque_contado = $this->reporte->get_ingreso_cheque_contado($fecha_inicio, $fecha_fin);

        $datos_ingresos_deposito_plazo = $this->reporte->get_ingreso_deposito_plazo($fecha_inicio, $fecha_fin);
        $datos_ingresos_deposito_contado = $this->reporte->get_ingreso_deposito_contado($fecha_inicio, $fecha_fin);

        $datos_egresos_efectivo = $this->reporte->get_egreso_efectivo($fecha_inicio, $fecha_fin);
        $datos_egresos_transferencia = $this->reporte->get_egreso_trasferencia_bancaria($fecha_inicio, $fecha_fin);
        $datos_egresos = $this->reporte->get_flujo_caja_egreso($fecha_inicio, $fecha_fin);


        $lista_compras = $datos['datos'];
        $lista_egresos = $datos_egresos['datos_egresos'];

        $lista_ingresos_efectivo_plazo = $datos_ingresos_efectivo_plazo['datos_ingresos_efectivo_plazo'];
        $lista_ingresos_efectivo_contado = $datos_ingresos_efectivo_contado['datos_ingresos_efectivo_contado'];

        $lista_ingresos_tarjeta_plazo = $datos_ingresos_tarjeta_plazo['datos_ingresos_tarjeta_plazo'];
        $lista_ingresos_tarjeta_contado = $datos_ingresos_tarjeta_contado['datos_ingresos_tarjeta_contado'];

        $lista_ingresos_cheque_plazo = $datos_ingresos_cheque_plazo['datos_ingresos_cheque_plazo'];
        $lista_ingresos_cheque_contado = $datos_ingresos_cheque_contado['datos_ingresos_cheque_contado'];

        $lista_ingresos_deposito_plazo = $datos_ingresos_deposito_plazo['datos_ingresos_deposito_plazo'];
        $lista_ingresos_deposito_contado = $datos_ingresos_deposito_contado['datos_ingresos_deposito_contado'];

        //EGRESOS
        $lista_egresos_efectivo = $datos_egresos_efectivo['datos_egresos_efectivo'];
        $lista_egresos_transferencia = $datos_egresos_transferencia['datos_egresos_transferencia'];


        foreach ($lista_compras as $row_detalle) {
            $monto_total_ingresos = $row_detalle->monto;
        }
        foreach ($lista_egresos as $row_detalle_egreso) {
            $monto_total_egresos = $row_detalle_egreso->monto_egreso;
        }
        $total = $monto_total_ingresos - $monto_total_egresos;

        //MONTO INGRESOS POR EFECTIVO A PLAZO
        foreach ($lista_ingresos_efectivo_plazo as $row) {
            $monto_ingreso_efectivo_plazo = $row->monto;
        }
        //MONTO INGRESOS POR EFECTIVO AL CONTADO
        foreach ($lista_ingresos_efectivo_contado as $row) {
            $monto_ingreso_efectivo_contado = $row->monto;
        }
        $monto_total_ingresos_efectivo = $monto_ingreso_efectivo_plazo + $monto_ingreso_efectivo_contado;

        //MONTO INGRESOS POR TARJETA A PLAZO
        foreach ($lista_ingresos_tarjeta_plazo as $row) {
            $monto_ingreso_tarjeta_plazo = $row->monto;
        }
        //MONTO INGRESOS POR TARJETA AL CONTADO
        foreach ($lista_ingresos_tarjeta_contado as $row) {
            $monto_ingreso_tarjeta_contado = $row->monto;
        }
        $monto_total_ingresos_tarjeta = $monto_ingreso_tarjeta_plazo + $monto_ingreso_tarjeta_contado;

        //MONTO INGRESOS POR CHEQUE A PLAZO
        foreach ($lista_ingresos_cheque_plazo as $row) {
            $monto_ingreso_cheque_plazo = $row->monto;
        }
        //MONTO INGRESOS POR CHEQUE AL CONTADO
        foreach ($lista_ingresos_cheque_contado as $row) {
            $monto_ingreso_cheque_contado = $row->monto;
        }
        $monto_total_ingresos_cheque = $monto_ingreso_cheque_plazo + $monto_ingreso_cheque_contado;

        //MONTO INGRESOS POR DEPOSITO A PLAZO
        foreach ($lista_ingresos_deposito_plazo as $row) {
            $monto_ingreso_deposito_plazo = $row->monto;
        }
        //MONTO INGRESOS POR DEPOSITO AL CONTADO
        foreach ($lista_ingresos_deposito_contado as $row) {
            $monto_ingreso_deposito_contado = $row->monto;
        }
        $monto_total_ingresos_deposito = $monto_ingreso_deposito_plazo + $monto_ingreso_deposito_contado;

        //EGERESOS
        //MONTO EGRESOS POR EFECTIVO
        foreach ($lista_egresos_efectivo as $row) {
            $monto_egreso_efectivo = $row->monto;
        }
        $monto_total_egresos_efectivo = $monto_egreso_efectivo;

        //MONTO EGRESOS POR TRANSFERENCIA
        foreach ($lista_egresos_transferencia as $row) {
            $monto_egreso_trans_bancaria = $row->monto;
        }
        $monto_total_egresos_transferencia = $monto_egreso_trans_bancaria;


        $this->load->library('pdf');
        $this->pdf = new Pdf('P', 'mm', 'Legal');
        $this->pdf->AddPage();

        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();

        $this->pdf->SetTitle("REPORTE INGRESOS");
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
        $this->pdf->Cell(60, 5, 'REPORTE DE INGRESOS', 0, 0, 'C');
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
        $this->pdf->Cell(27, 5, utf8_decode('FECHA DESDE        : ' . $fecha_inicio . '                     ' . '                FECHA DE IMPRESIÓN   :  ' . date('d/m/Y')), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);
        /*  FECHA FIN  */
        $this->pdf->Cell(27, 5, utf8_decode('FECHA HASTA        : ' . $fecha_fin . '                     '), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(7);

        //INGRESOS DICARP
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode('                                                                                          I N G R E S O S -  D I C A R P '), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);
        $this->pdf->Cell(27, 1, utf8_decode(' '), 'LB');
        $this->pdf->Cell(165, 1, '', 'RB');
        $this->pdf->Ln(5);


        /* Encabezado de la columna*/
        $this->pdf->Cell(162, 5, "TITULO", 1, 0, 'C');
        $this->pdf->Cell(30, 5, "TOTAL", 1, 0, 'C');

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
            $this->pdf->Cell(162, 4, utf8_decode('INGRESOS EFECTIVO'), $estilo, 0, 'C');
            $this->pdf->Cell(30, 4, utf8_decode($monto_total_ingresos_efectivo), $estilo, 0, 'C');

            $this->pdf->Ln(4);
            $nro = $nro + 1;
        }
        //TARJETA
        $this->pdf->Ln(5);
        /* Encabezado de la columna*/
        $this->pdf->Cell(162, 5, "TITULO", 1, 0, 'C');
        $this->pdf->Cell(30, 5, "TOTAL", 1, 0, 'C');

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
            $this->pdf->Cell(162, 4, utf8_decode('INGRESOS TARJETA'), $estilo, 0, 'C');
            $this->pdf->Cell(30, 4, utf8_decode($monto_total_ingresos_tarjeta), $estilo, 0, 'C');

            $this->pdf->Ln(4);
            $nro = $nro + 1;
        }

        //CHEQUE
        $this->pdf->Ln(5);
        /* Encabezado de la columna*/
        $this->pdf->Cell(162, 5, "TITULO", 1, 0, 'C');
        $this->pdf->Cell(30, 5, "TOTAL", 1, 0, 'C');

        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial', '', 8);

        $cantidad_filas = 0;

        foreach ($lista_egresos as $row_detalle) {
            $cantidad_filas++;
            $estilo = 'RL';
            if ($nro == 1) {
                $estilo = $estilo . 'T';
            }
            if ($cantidad_filas == count($lista_egresos)) {
                $estilo = 'LRB';
            }
            $this->pdf->Cell(162, 4, utf8_decode('INGRESOS CHEQUE'), $estilo, 0, 'C');
            $this->pdf->Cell(30, 4, utf8_decode($monto_total_ingresos_cheque), $estilo, 0, 'C');

            $this->pdf->Ln(4);
            $nro = $nro + 1;
        }
        //DEPOSITO
        $this->pdf->Ln(5);
        /* Encabezado de la columna*/
        $this->pdf->Cell(162, 5, "TITULO", 1, 0, 'C');
        $this->pdf->Cell(30, 5, "TOTAL", 1, 0, 'C');

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
            $this->pdf->Cell(162, 4, utf8_decode('INGRESOS DEPOSITO'), $estilo, 0, 'C');
            $this->pdf->Cell(30, 4, utf8_decode($monto_total_ingresos_deposito), $estilo, 0, 'C');

            $this->pdf->Ln(4);
            $nro = $nro + 1;
        }
        $this->pdf->Ln(5);
        //INGRESOS DICARP
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode('                                                                                          E G R E S O S -  D I C A R P '), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);
        $this->pdf->Cell(27, 1, utf8_decode(' '), 'LB');
        $this->pdf->Cell(165, 1, '', 'RB');
        $this->pdf->Ln(5);
        /******************************************************************************************************************************************************************************************************************************/
        //TIPO EGRESO EFECTIVO
        /* Encabezado de la columna*/
        $this->pdf->Cell(162, 5, "TITULO", 1, 0, 'C');
        $this->pdf->Cell(30, 5, "TOTAL", 1, 0, 'C');

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
            $this->pdf->Cell(162, 4, utf8_decode('EGRESOS EFECTIVO'), $estilo, 0, 'C');
            $this->pdf->Cell(30, 4, utf8_decode($monto_total_egresos_efectivo), $estilo, 0, 'C');

            $this->pdf->Ln(4);
            $nro = $nro + 1;
        }
        $this->pdf->Ln(5);
        /* Encabezado de la columna*/
        $this->pdf->Cell(162, 5, "TITULO", 1, 0, 'C');
        $this->pdf->Cell(30, 5, "TOTAL", 1, 0, 'C');

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
            $this->pdf->Cell(162, 4, utf8_decode('EGRESOS TRANSFERENCIA BANCARIA'), $estilo, 0, 'C');
            $this->pdf->Cell(30, 4, utf8_decode($monto_total_egresos_transferencia), $estilo, 0, 'C');

            $this->pdf->Ln(4);
            $nro = $nro + 1;
        }
        $this->pdf->Ln(5);

        /******************************************************************************************************************************************************************************************************************************/
        // INGRESOS
        $valor = ("  ");
        $this->pdf->Ln(2);
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(7, 5, 'TOTAL INGRESOS    ', 'LTB', 0, 'L');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(125, 5, '                           ' . $valor, 'TBR', 0, 'L');
        $this->pdf->Cell(5, 5, '', '', 0, 'L');
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(25, 5, 'INGRESOS Bs :', 1, 0, 'R');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(30, 5, $monto_total_ingresos, 1, 0, 'R');

        //EGRESOS
        $valor = ("  ");
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(7, 5, 'TOTAL EGRESOS    ', 'LTB', 0, 'L');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(125, 5, '                           ' . $valor, 'TBR', 0, 'L');
        $this->pdf->Cell(5, 5, '', '', 0, 'L');
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(25, 5, 'EGRESOS Bs :', 1, 0, 'R');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(30, 5, $monto_total_egresos, 1, 0, 'R');
        $this->pdf->Ln(8);

        // Convertimos el monto en literal
        include APPPATH . '/libraries/convertidor.php';
        $v = new EnLetras();
        $valor = $v->ValorEnLetras($total, " ");
        $this->pdf->Ln(2);
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(7, 5, 'MONTO TOTAL Bs  :  ', 'LTB', 0, 'L');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(125, 5, '                           ' . $valor, 'TBR', 0, 'L');
        $this->pdf->Cell(5, 5, '', '', 0, 'L');
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(25, 5, 'TOTAL Bs :', 1, 0, 'R');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(30, 5, $total, 1, 0, 'R');
        $this->pdf->Ln(8);


        $this->pdf->Output("REPORTE.pdf", 'I');

    }

    /*** Imprimir  en pdf ventas ****/
    public
    function imprimir_ventas()
    {
        $fecha_inicio = $this->input->post('fecha_inicio');
        $fecha_fin = $this->input->post('fecha_fin');

        $datos = $this->reporte->get_ventas_emitidas($fecha_inicio, $fecha_fin);
        $datos_sumatoria = $this->reporte->get_ventas_emitidas_sumatoria($fecha_inicio, $fecha_fin);

        $lista_compras = $datos['datos'];
        $lista_suma = $datos_sumatoria['datos_sumatoria'];
        $monto_total = 0;

        foreach ($lista_compras as $row_detalle) {
            $monto_total = $monto_total + $row_detalle->cantidad;

        }
        foreach ($lista_suma as $row_detalle) {
            $total_suma_venta = $row_detalle->suma_subtotal;
        }

        $this->load->library('pdf');
        $this->pdf = new Pdf('P', 'mm', 'Legal');
        $this->pdf->AddPage();
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();

        $this->pdf->SetTitle("REPORTE PRODUCTO TERMINADO");
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
        $this->pdf->Cell(60, 5, 'PRODUCTO TERMINADO', 0, 0, 'C');
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
        $this->pdf->Cell(27, 5, utf8_decode('Fecha desde        : ' . $fecha_inicio . '                     ' . '                Fecha de Impresión   :  ' . date('d/m/Y')), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);
        /*  FECHA FIN  */
        $this->pdf->Cell(27, 5, utf8_decode('Fecha Hasta        : ' . $fecha_fin . '                                      Total   : ' . $total_suma_venta), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(7);

        /* Encabezado de la columna*/
        $this->pdf->Cell(10, 5, "NRO", 1, 0, 'C');
        $this->pdf->Cell(129, 5, "PRODUCTO", 1, 0, 'C');
        $this->pdf->Cell(15, 5, "CANT.", 1, 0, 'C');
        $this->pdf->Cell(18, 5, "P.U", 1, 0, 'C');
        $this->pdf->Cell(20, 5, "TOTAL", 1, 0, 'C');

        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial', '', 7);

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
            $this->pdf->Cell(10, 4, utf8_decode($cantidad_filas), $estilo, 0, 'C');
            $this->pdf->Cell(129, 4, utf8_decode($row_detalle->producto), $estilo, 0, 'L');
            $this->pdf->Cell(15, 4, utf8_decode($row_detalle->cantidad), $estilo, 0, 'C');
            $this->pdf->Cell(18, 4, utf8_decode($row_detalle->precio_venta), $estilo, 0, 'C');
            $this->pdf->Cell(20, 4, utf8_decode($row_detalle->cantidad * $row_detalle->precio_venta), $estilo, 0, 'C');
            $this->pdf->Ln(4);
            $nro = $nro + 1;
        }


        $this->pdf->Output("REPORTE_PRODUCTO_TERMINADO.pdf", 'I');

    }

    /*** Imprimir  en pdf ventas diarias ****/
    public function imprimir_ventas_diarias()
    {
        $fecha_inicio = $this->input->post('fecha_inicio');
        // $sucursal_id = $this->input->post('sucursal');
        // $datos_empresa = $this->sucursal->get_datos_empresa($sucursal_id);

        $datos = $this->reporte->get_ventas_diarias($fecha_inicio);
        $datos_egresos_total = $this->reporte->get_egresos_diarias($fecha_inicio);
        $datos_egresos_efectivo = $this->reporte->get_egreso_efectivo_diarios($fecha_inicio);
        $datos_egresos_transferencia = $this->reporte->get_egreso_transferencia_diarios($fecha_inicio);


        $lista_compras = $datos['datos'];
        $lista_egresos_total = $datos_egresos_total['datos_egresos_total'];
        $lista_egresos_efectivo = $datos_egresos_efectivo['datos_egresos_efectivo_diarios'];
        $lista_egresos_transferencia = $datos_egresos_transferencia['datos_egresos_transferencia_diarios'];
        $monto_total = 0;
        $usuario = '';


        /********************************************************************/
        //INGRESOS PLAZO & CONTADO EN EFECTIVO
        $datos_ingresos_efectivo = $this->reporte->get_ingreso_plazo_dia($fecha_inicio);
        $datos_ingresos_contado_dia = $this->reporte->get_ingreso_efectivo_contado_dia($fecha_inicio);

        $lista_ingresos_efectivo = $datos_ingresos_efectivo['datos_ingresos_efectivo_dia'];
        $lista_ingresos_contado_dia = $datos_ingresos_contado_dia['datos_ingresos_efectivo_contado_dia'];


        foreach ($lista_ingresos_contado_dia as $row_detalle) {
            $monto_total_ingresos_contado = $row_detalle->monto;
        }
        foreach ($lista_ingresos_efectivo as $row_detalle) {
            $monto_total_ingresos = $row_detalle->monto;
        }
        $monto_total_ingresos_efectivo = $monto_total_ingresos + $monto_total_ingresos_contado;
        /********************************************************************/
        //INGRESOS PLAZO & CONTADO CON TARJETA
        $datos_ingresos_plazo_tarjeta = $this->reporte->get_ingreso_tarjeta_plazo_dia($fecha_inicio);
        $datos_ingresos_contado_tarjeta = $this->reporte->get_ingreso_tarjeta_contado_dia($fecha_inicio);

        $lista_ingresos_plazo_tarjeta = $datos_ingresos_plazo_tarjeta['datos_ingresos_tarjeta_plazo_dia'];
        $lista_ingresos_contado_tarjeta = $datos_ingresos_contado_tarjeta['datos_ingresos_tarjeta_contado_dia'];

        foreach ($lista_ingresos_plazo_tarjeta as $row_detalle) {
            $monto_total_ingresos_plazo_tarjeta = $row_detalle->monto;
        }
        foreach ($lista_ingresos_contado_tarjeta as $row_detalle) {
            $monto_total_ingresos_contado_tarjeta = $row_detalle->monto;
        }
        $monto_total_ingresos_tarjeta = $monto_total_ingresos_plazo_tarjeta + $monto_total_ingresos_contado_tarjeta;

        /********************************************************************/
        //INGRESOS PLAZO & CONTADO CON CHEQUE
        $datos_ingresos_plazo_cheque = $this->reporte->get_ingreso_cheque_plazo_dia($fecha_inicio);
        $datos_ingresos_contado_cheque = $this->reporte->get_ingreso_cheque_contado_dia($fecha_inicio);

        $lista_ingresos_plazo_cheque = $datos_ingresos_plazo_cheque['datos_ingresos_cheque_plazo_dia'];
        $lista_ingresos_contado_cheque = $datos_ingresos_contado_cheque['datos_ingresos_cheque_contado_dia'];

        foreach ($lista_ingresos_plazo_cheque as $row_detalle) {
            $monto_total_ingresos_plazo_cheque = $row_detalle->monto;
        }
        foreach ($lista_ingresos_contado_cheque as $row_detalle) {
            $monto_total_ingresos_contado_cheque = $row_detalle->monto;
        }
        $monto_total_ingresos_cheque = $monto_total_ingresos_plazo_cheque + $monto_total_ingresos_contado_cheque;

        /********************************************************************/
        //INGRESOS PLAZO & CONTADO CON DEPOSITO
        $datos_ingresos_plazo_deposito = $this->reporte->get_ingreso_deposito_plazo_dia($fecha_inicio);
        $datos_ingresos_contado_deposito = $this->reporte->get_ingreso_deposito_contado_dia($fecha_inicio);

        $lista_ingresos_plazo_deposito = $datos_ingresos_plazo_deposito['datos_ingresos_deposito_plazo_dia'];
        $lista_ingresos_contado_deposito = $datos_ingresos_contado_deposito['datos_ingresos_deposito_contado_dia'];

        foreach ($lista_ingresos_plazo_deposito as $row_detalle) {
            $monto_total_ingresos_plazo_deposito = $row_detalle->monto;
        }
        foreach ($lista_ingresos_contado_deposito as $row_detalle) {
            $monto_total_ingresos_contado_deposito = $row_detalle->monto;
        }
        $monto_total_ingresos_deposito = $monto_total_ingresos_plazo_deposito + $monto_total_ingresos_contado_deposito;

        /********************************************************************/

        //TOTAL INGRESOS
        foreach ($lista_compras as $row_detalle) {
            $monto_total = $monto_total + $row_detalle->monto;
            $usuario = $row_detalle->nombre_usuario;
        }
        //TOTAL EGRESOS
        $monto_total_egresos = 0;
        foreach ($lista_egresos_total as $row_detalle) {
            $monto_total_egresos = $monto_total_egresos + $row_detalle->monto;

        }
        $monto_ingreso_egresos = $monto_total - $monto_total_egresos;
        //MONTO EGRESOS POR EFECTIVO
        foreach ($lista_egresos_efectivo as $row) {
            $monto_egreso_efectivo = $row->monto;
        }
        $monto_total_egresos_efectivo = $monto_egreso_efectivo;

        //MONTO EGRESOS POR TRANSFERENCIA
        foreach ($lista_egresos_transferencia as $row) {
            $monto_egreso_transferencia = $row->monto;
        }
        $monto_total_egresos_transferencia = $monto_egreso_transferencia;

        $this->load->library('pdf');
        $this->pdf = new Pdf('P', 'mm', 'Legal');
        $this->pdf->AddPage();

        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();

        $this->pdf->SetTitle("REPORTE");
        $var_img = base_url() . 'assets/img/logo_empresa.png';
        $this->pdf->Image($var_img, 10, 10, 50, 30);

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
        $this->pdf->Cell(30, 5, 'REPORTE DE VENTAS DIARIAS', 0, 0, 'C');
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetTextColor(0, 0, 0);/* volvemos a color de texto negro*/

        $this->pdf->Cell(110, 4, 'Av. 26 de Febrero 2do anillo Casi Centenario', 0, 0, 'C');
        $this->pdf->Cell(60, 4, '', 0);
        $this->pdf->SetFont('Arial', '', 9);

        $this->pdf->MultiCell(72, 4, '', 0, 'C');
        $this->pdf->Cell(75, 5, '', 0, 0, 'C');
        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->SetTextColor(248, 0, 0);
        $this->pdf->Cell(31, 5, 'DICARP', 0, 0, 'C');

        $this->pdf->SetTextColor(0, 0, 0);
        $this->pdf->SetFont('Arial', 'B', 7);
        $this->pdf->Cell(110, 4, 'Telf. 9302099 - 70838701', 0, 0, 'C');

        $this->pdf->Ln(10);
        $nro = 1;
        $nro = $nro + 1;

        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Ln(10);

        /*  FECHA INICIO*/
        $this->pdf->SetFont('Arial', 'B', 8);
        //$this->pdf->Cell(27, 5, utf8_decode('Fecha Búsqueda   : ' . $fecha_inicio . '                     ' . '                       Sucusal  : ' . $datos_empresa->sucursal . '                                        Fecha de Impresión   :  ' . date('d/m/Y')), 'TL');
        $this->pdf->Cell(27, 5, utf8_decode('Fecha Búsqueda   : ' . $fecha_inicio . '                     ' . '     Fecha de Impresión   :  ' . date('d/m/Y')), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);
        /*  CANTIDAD   */
        $this->pdf->Cell(27, 5, utf8_decode('Usuario                  : ' . $usuario), 'LB');
        $this->pdf->Cell(165, 5, '', 'RB');
        $this->pdf->Ln(7);

        /* Encabezado de la columna*/
        $this->pdf->Cell(25, 5, "NOTA VENTA", 1, 0, 'C');
        $this->pdf->Cell(92, 5, "CLIENTE", 1, 0, 'C');
        $this->pdf->Cell(45, 5, "FORMA PAGO", 1, 0, 'C');
        $this->pdf->Cell(30, 5, "MONTO VENTA", 1, 0, 'C');


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

            /**/
            $forma_pago_plazo = $row_detalle->forma_pago;
            $descripcion = $row_detalle->descripcion;

            $modo_pago = '';
            if ($forma_pago_plazo == 'Plazo' && $descripcion == 'forma_pago_efectivo') {
                $modo_pago = 'Efectivo';
            } else if ($forma_pago_plazo == 'Plazo' && $descripcion == 'forma_pago_tarjeta') {
                $modo_pago = 'Tarjeta';
            } else if ($forma_pago_plazo == 'Plazo' && $descripcion == 'forma_pago_cheque') {
                $modo_pago = 'Cheque';
            } else if ($forma_pago_plazo == 'Plazo' && $descripcion = 'forma_pago_deposito') {
                $modo_pago = 'Deposito';
            } else if ($forma_pago_plazo == 'Efectivo') {
                $modo_pago = 'Contado ';
            } else {
                $modo_pago = 'Contado ';
            }
            /**/

            $this->pdf->Cell(25, 4, utf8_decode('000' . $row_detalle->id), $estilo, 0, 'C');
            $this->pdf->Cell(92, 4, utf8_decode($row_detalle->nombre_cliente), $estilo, 0, 'C');
            $this->pdf->Cell(45, 4, utf8_decode($row_detalle->forma_pago . '-' . $modo_pago), $estilo, 0, 'C');
            $this->pdf->Cell(30, 4, utf8_decode($row_detalle->monto), $estilo, 0, 'C');


            $this->pdf->Ln(4);
            $nro = $nro + 1;
        }
        $this->pdf->Ln(3);
        /******************************************************************************************************************************************************************************************************************************/
        //EGRESOS DICARP
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode('                                                                                          I N R E S O S -  D I C A R P '), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);
        $this->pdf->Cell(27, 1, utf8_decode(' '), 'LB');
        $this->pdf->Cell(165, 1, '', 'RB');
        $this->pdf->Ln(5);

        //TIPO INGRESOS EFECTIVO
        $valor = ("  ");
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(7, 5, 'TOTAL INGRESOS EFECTIVO   ', 'LTB', 0, 'L');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(125, 5, '                           ' . $valor, 'TBR', 0, 'L');
        $this->pdf->Cell(5, 5, '', '', 0, 'L');
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(25, 5, 'INGRESOS Bs :', 1, 0, 'R');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(30, 5, $monto_total_ingresos_efectivo, 1, 0, 'R');
        $this->pdf->Ln(6);

        //TIPO INGRESOS TARJETA
        $valor = ("  ");
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(7, 5, 'TOTAL INGRESOS TARJETA   ', 'LTB', 0, 'L');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(125, 5, '                           ' . $valor, 'TBR', 0, 'L');
        $this->pdf->Cell(5, 5, '', '', 0, 'L');
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(25, 5, 'INGRESOS Bs :', 1, 0, 'R');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(30, 5, $monto_total_ingresos_tarjeta, 1, 0, 'R');
        $this->pdf->Ln(6);

        //TIPO INGRESOS CHEQUE
        $valor = ("  ");
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(7, 5, 'TOTAL INGRESOS CHEQUE   ', 'LTB', 0, 'L');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(125, 5, '                           ' . $valor, 'TBR', 0, 'L');
        $this->pdf->Cell(5, 5, '', '', 0, 'L');
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(25, 5, 'INGRESOS Bs :', 1, 0, 'R');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(30, 5, $monto_total_ingresos_cheque, 1, 0, 'R');
        $this->pdf->Ln(6);

        //TIPO INGRESOS DEPOSITO
        $valor = ("  ");
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(7, 5, 'TOTAL INGRESOS DEPOSITO   ', 'LTB', 0, 'L');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(125, 5, '                           ' . $valor, 'TBR', 0, 'L');
        $this->pdf->Cell(5, 5, '', '', 0, 'L');
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(25, 5, 'INGRESOS Bs :', 1, 0, 'R');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(30, 5, $monto_total_ingresos_deposito, 1, 0, 'R');
        $this->pdf->Ln(8);

        /******************************************************************************************************************************************************************************************************************************/
        //EGRESOS DICARP
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode('                                                                                          E G R E S O S -  D I C A R P '), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);
        $this->pdf->Cell(27, 1, utf8_decode(' '), 'LB');
        $this->pdf->Cell(165, 1, '', 'RB');
        $this->pdf->Ln(5);

        //TIPO EGRESO EFECTIVO
        $valor = ("  ");
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(7, 5, 'TOTAL EGRESOS EFECTIVO   ', 'LTB', 0, 'L');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(125, 5, '                           ' . $valor, 'TBR', 0, 'L');
        $this->pdf->Cell(5, 5, '', '', 0, 'L');
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(25, 5, 'EGRESOS Bs :', 1, 0, 'R');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(30, 5, $monto_total_egresos_efectivo, 1, 0, 'R');
        $this->pdf->Ln(6);

        //TIPO EGRESO TRANSFERENCIA
        $valor = ("  ");
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(7, 5, 'TOTAL EGRESOS TRANSFERENCIA   ', 'LTB', 0, 'L');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(125, 5, '                           ' . $valor, 'TBR', 0, 'L');
        $this->pdf->Cell(5, 5, '', '', 0, 'L');
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(25, 5, 'EGRESOS Bs :', 1, 0, 'R');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(30, 5, $monto_total_egresos_transferencia, 1, 0, 'R');
        $this->pdf->Ln(8);
        /******************************************************************************************************************************************************************************************************************************/

        //TOTAL DICARP
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(27, 5, utf8_decode('                                                                                          T O T A L -  D I C A R P '), 'TL');
        $this->pdf->Cell(165, 5, '', 'TR');
        $this->pdf->SetFont('Arial', 'B', 8);;
        $this->pdf->Ln(5);
        $this->pdf->Cell(27, 1, utf8_decode(' '), 'LB');
        $this->pdf->Cell(165, 1, '', 'RB');
        $this->pdf->Ln(5);

        // INGRESOS
        $valor = ("  ");
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(7, 5, 'TOTAL INGRESOS    ', 'LTB', 0, 'L');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(125, 5, '                           ' . $valor, 'TBR', 0, 'L');
        $this->pdf->Cell(5, 5, '', '', 0, 'L');
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(25, 5, 'INGRESOS Bs :', 1, 0, 'R');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(30, 5, $monto_total, 1, 0, 'R');
        //EGRESOS
        $valor = ("  ");
        $this->pdf->Ln(6);
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(7, 5, 'TOTAL EGRESOS    ', 'LTB', 0, 'L');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(125, 5, '                           ' . $valor, 'TBR', 0, 'L');
        $this->pdf->Cell(5, 5, '', '', 0, 'L');
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(25, 5, 'EGRESOS Bs :', 1, 0, 'R');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(30, 5, $monto_total_egresos, 1, 0, 'R');


        // Convertimos el monto en literal
        $this->pdf->Ln(7);
        include APPPATH . '/libraries/convertidor.php';
        $v = new EnLetras();
        $valor = $v->ValorEnLetras($monto_ingreso_egresos, " ");
        $this->pdf->Ln(2);
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(7, 5, 'MONTO TOTAL Bs  :  ', 'LTB', 0, 'L');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(125, 5, '                           ' . $valor, 'TBR', 0, 'L');
        $this->pdf->Cell(5, 5, '', '', 0, 'L');
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(25, 5, 'TOTAL Bs :', 1, 0, 'R');
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(30, 5, $monto_ingreso_egresos, 1, 0, 'R');
        $this->pdf->Ln(8);


        $this->pdf->Output("Reporte_Ventas_diarias.pdf", 'I');

    }


}