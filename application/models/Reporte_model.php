<?php

class Reporte_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_deudas($fecha_inicio, $fecha_fin, $sucursal)
    {

        $this->db->select("v.id, date(v.fecha) as fecha, c.id as cliente_id, c.nombre_cliente, v.total, sum(p.monto) as total_pagado, (v.total - sum(p.monto))as saldo, p.estado");
        $this->db->from("cliente c, venta v, venta_pago p,sucursal s")
            ->where("c.id = v.cliente_id")
            ->where("v.id = p.venta_id")
            ->where("v.sucursal_id = s.id")
            ->where("p.forma_pago = 'plazo'")
            ->where("p.estado != 'Cancelado'")
            ->where("s.id=", $sucursal)
            ->where("v.fecha>=", $fecha_inicio)
            ->where("v.fecha<=", $fecha_fin)
            ->where("v.estado=1")
            ->group_by("v.id,c.id,p.estado,v.fecha,c.nombre_cliente,v.total");
        $resultado['datos'] = $this->db->get()->result();
        return $resultado;

    }

    public function sum_saldo($fecha_inicio, $fecha_fin, $sucursal)
    {
        $this->db->select("(v.total - sum(p.monto))as saldo");
        $this->db->from("venta_pago p,venta v,sucursal s")
            ->where("v.id = p.venta_id")
            ->where("v.sucursal_id = s.id")
            ->where("s.id=", $sucursal)
            ->where("v.fecha>=", $fecha_inicio)
            ->where("v.fecha<=", $fecha_fin)
            ->where("v.estado=1")
            ->where("p.estado='Debe'")
            ->where("p.saldo>0")
            ->group_by("v.id");
        $resultado['datos_total_saldo'] = $this->db->get()->result();
        return $resultado;

    }

    public function getNitEmpresa()
    {
        return $this->db->get('sucursal')->row();
    }


    public function get_ventas_emitidas($fecha_inicio, $fecha_fin)
    {
        $this->db->select("pr.id,pr.nombre_item as producto ,date(pr.fecha_registro) as fecha ,sum(dv.cantidad  + dv.cantidad_produccion) as cantidad,sum(dv.precio_venta) as precio,dv.precio_venta,sum(dv.precio_venta) as total");
        $this->db->from("venta v,detalle_venta dv,producto pr");
        $this->db->where("v.id=dv.venta_id");
        $this->db->where("pr.id=dv.producto_id");
        $this->db->where("v.estado=1");
        $this->db->group_by("pr.id");


        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $this->db->where("v.fecha >='" . $fecha_inicio . "' and v.fecha <='" . $fecha_fin . "'");
        }
        $resultado['datos'] = $this->db->get()->result();

        return $resultado;
    }

    public function get_ventas_emitidas_sumatoria($fecha_inicio, $fecha_fin)
    {
        $this->db->select("sum(v.total) as suma_subtotal");
        $this->db->from("venta v");
        //$this->db->where("v.id=dv.venta_id");
        $this->db->where("v.estado=1");
        //$this->db->group_by("v.id");

        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $this->db->where("v.fecha >='" . $fecha_inicio . "' and v.fecha <='" . $fecha_fin . "'");
        }
        $resultado['datos_sumatoria'] = $this->db->get()->result();
        return $resultado;
    }

    public function get_ingreso_total($fecha_inicio, $fecha_fin)
    {
        $this->db->select("sum(vp.monto) as monto,vp.descripcion");
        $this->db->from("venta v,venta_pago vp");
        $this->db->where("vp.venta_id=v.id");
        $this->db->where("v.estado=1");
        // $this->db->where("vp.descripcion ='forma_pago_efectivo' && vp.forma_pago ='Plazo' ");

        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $this->db->where("vp.fecha_registro >='" . $fecha_inicio . "' and vp.fecha_registro <='" . $fecha_fin . "'");
        }
        $resultado['datos'] = $this->db->get()->result();
        return $resultado;
    }

    //EFECTIVO
    public function get_ingreso_efectivo_plazo($fecha_inicio, $fecha_fin)
    {
        $this->db->select("sum(vp.monto) as monto,vp.descripcion,vp.forma_pago");
        $this->db->from("venta v,venta_pago vp");
        $this->db->where("vp.venta_id=v.id");
        $this->db->where("v.estado=1");
        $this->db->where("vp.descripcion ='forma_pago_efectivo' && vp.forma_pago ='Plazo' ");
        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $this->db->where("vp.fecha_registro >='" . $fecha_inicio . "' and vp.fecha_registro <='" . $fecha_fin . "'");
        }
        $resultado['datos_ingresos_efectivo_plazo'] = $this->db->get()->result();
        return $resultado;
    }

    public function get_ingreso_efectivo_contado($fecha_inicio, $fecha_fin)
    {
        $this->db->select("sum(vp.monto) as monto,vp.descripcion,vp.forma_pago");
        $this->db->from("venta v,venta_pago vp");
        $this->db->where("vp.venta_id=v.id");
        $this->db->where("v.estado=1");
        $this->db->where("vp.descripcion ='forma_pago_efectivo' && vp.forma_pago ='Efectivo' ");
        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $this->db->where("vp.fecha_registro >='" . $fecha_inicio . "' and vp.fecha_registro <='" . $fecha_fin . "'");
        }
        $resultado['datos_ingresos_efectivo_contado'] = $this->db->get()->result();
        return $resultado;
    }

    //TARJETA
    public function get_ingreso_tarjeta_plazo($fecha_inicio, $fecha_fin)
    {
        $this->db->select("sum(vp.monto) as monto,vp.descripcion,vp.forma_pago");
        $this->db->from("venta v,venta_pago vp");
        $this->db->where("vp.venta_id=v.id");
        $this->db->where("v.estado=1");
        $this->db->where("vp.descripcion ='forma_pago_tarjeta' && vp.forma_pago ='Plazo' ");
        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $this->db->where("vp.fecha_registro >='" . $fecha_inicio . "' and vp.fecha_registro <='" . $fecha_fin . "'");
        }
        $resultado['datos_ingresos_tarjeta_plazo'] = $this->db->get()->result();
        return $resultado;
    }

    public function get_ingreso_tarjeta_contado($fecha_inicio, $fecha_fin)
    {
        $this->db->select("sum(vp.monto) as monto,vp.descripcion,vp.forma_pago");
        $this->db->from("venta v,venta_pago vp");
        $this->db->where("vp.venta_id=v.id");
        $this->db->where("v.estado=1");
        $this->db->where("vp.descripcion ='forma_pago_efectivo' && vp.forma_pago ='Tarjeta' ");
        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $this->db->where("vp.fecha_registro >='" . $fecha_inicio . "' and vp.fecha_registro <='" . $fecha_fin . "'");
        }
        $resultado['datos_ingresos_tarjeta_contado'] = $this->db->get()->result();
        return $resultado;
    }

    //CHEQUE
    public function get_ingreso_cheque_plazo($fecha_inicio, $fecha_fin)
    {
        $this->db->select("sum(vp.monto) as monto,vp.descripcion,vp.forma_pago");
        $this->db->from("venta v,venta_pago vp");
        $this->db->where("vp.venta_id=v.id");
        $this->db->where("v.estado=1");
        $this->db->where("vp.descripcion ='forma_pago_cheque' && vp.forma_pago ='Plazo' ");
        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $this->db->where("vp.fecha_registro >='" . $fecha_inicio . "' and vp.fecha_registro <='" . $fecha_fin . "'");
        }
        $resultado['datos_ingresos_cheque_plazo'] = $this->db->get()->result();
        return $resultado;
    }

    public function get_ingreso_cheque_contado($fecha_inicio, $fecha_fin)
    {
        $this->db->select("sum(vp.monto) as monto,vp.descripcion,vp.forma_pago");
        $this->db->from("venta v,venta_pago vp");
        $this->db->where("vp.venta_id=v.id");
        $this->db->where("v.estado=1");
        $this->db->where("vp.descripcion ='forma_pago_efectivo' && vp.forma_pago ='Cheque' ");
        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $this->db->where("vp.fecha_registro >='" . $fecha_inicio . "' and vp.fecha_registro <='" . $fecha_fin . "'");
        }
        $resultado['datos_ingresos_cheque_contado'] = $this->db->get()->result();
        return $resultado;
    }

    //DEPOSITO BANCARIO
    public function get_ingreso_deposito_plazo($fecha_inicio, $fecha_fin)
    {
        $this->db->select("sum(vp.monto) as monto,vp.descripcion,vp.forma_pago");
        $this->db->from("venta v,venta_pago vp");
        $this->db->where("vp.venta_id=v.id");
        $this->db->where("v.estado=1");
        $this->db->where("vp.descripcion ='forma_pago_deposito' && vp.forma_pago ='Plazo' ");
        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $this->db->where("vp.fecha_registro >='" . $fecha_inicio . "' and vp.fecha_registro <='" . $fecha_fin . "'");
        }
        $resultado['datos_ingresos_deposito_plazo'] = $this->db->get()->result();
        return $resultado;
    }

    public function get_ingreso_deposito_contado($fecha_inicio, $fecha_fin)
    {
        $this->db->select("sum(vp.monto) as monto,vp.descripcion,vp.forma_pago");
        $this->db->from("venta v,venta_pago vp");
        $this->db->where("vp.venta_id=v.id");
        $this->db->where("v.estado=1");
        $this->db->where("vp.descripcion ='forma_pago_efectivo' && vp.forma_pago ='deposito' ");
        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $this->db->where("vp.fecha_registro >='" . $fecha_inicio . "' and vp.fecha_registro <='" . $fecha_fin . "'");
        }
        $resultado['datos_ingresos_deposito_contado'] = $this->db->get()->result();
        return $resultado;
    }

    //EGRESO EFECTIVO
    public function get_egreso_efectivo($fecha_inicio, $fecha_fin)
    {
        $this->db->select("sum(e.monto) as monto");
        $this->db->from("egreso_caja e");
        $this->db->where("e.forma_egreso=1");
        $this->db->where("e.estado=1");
        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $this->db->where("e.fecha_registro >='" . $fecha_inicio . "' and e.fecha_registro <='" . $fecha_fin . "'");
        }
        $resultado['datos_egresos_efectivo'] = $this->db->get()->result();
        return $resultado;
    }

    //EGRESO TRANSEFERENCIA BANCARIA
    public function get_egreso_trasferencia_bancaria($fecha_inicio, $fecha_fin)
    {
        $this->db->select("sum(e.monto) as monto");
        $this->db->from("egreso_caja e");
        $this->db->where("e.forma_egreso =2");
        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $this->db->where("date(e.fecha_registro) >='" . $fecha_inicio . "' and date(e.fecha_registro) <='" . $fecha_fin . "'");
        }
        $resultado['datos_egresos_transferencia'] = $this->db->get()->result();
        return $resultado;
    }

    //EGRESO TOTAL
    public function get_flujo_caja_egreso($fecha_inicio, $fecha_fin)
    {
        $this->db->select("sum(e.monto) as monto_egreso");
        $this->db->from("egreso_caja e");
        $this->db->where("e.estado=1");
        //$this->db->group_by("pr.id");

        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $this->db->where("e.fecha_registro >='" . $fecha_inicio . "' and e.fecha_registro <='" . $fecha_fin . "'");
        }
        $resultado['datos_egresos'] = $this->db->get()->result();

        return $resultado;
    }

    public function get_ventas_diarias($fecha_inicio)
    {
        $this->db->select("v.id,n.nro_nota,date(v.fecha) as fecha,cl.telefono,cl.nombre_cliente,cl.ci_nit,s.sucursal,v.total,u.nombre_usuario,vp.forma_pago,sum(vp.monto) as monto,vp.descripcion");
        $this->db->from("venta v,cliente cl,sucursal s,nota_venta n,usuario u,venta_pago vp");
        $this->db->where("cl.id=v.cliente_id");
        $this->db->where("s.id=v.sucursal_id");
        $this->db->where("n.venta_id=v.id ");
        $this->db->where("u.id=v.usuario_id ");
        $this->db->where("v.id=vp.venta_id ");
        $this->db->where("v.estado=1 ");
        $this->db->group_by("v.id ");

        if (!empty($fecha_inicio)) {
            $this->db->where("date(vp.fecha_registro) ='" . $fecha_inicio . "' and v.sucursal_id='" . 2 . "'");

        }
        $resultado['datos'] = $this->db->get()->result();
        return $resultado;
    }

    //consulta egresos por dia
    public function get_egresos_diarias($fecha_inicio)
    {
        $this->db->select("sum(e.monto) as monto");
        $this->db->from("egreso_caja e");
        $this->db->where("e.estado=1 ");
        //$this->db->group_by("v.id ");

        if (!empty($fecha_inicio)) {
            $this->db->where("date(e.fecha_registro) ='" . $fecha_inicio . "' and e.sucursal_id='" . 2 . "'");

        }
        $resultado['datos_egresos_total'] = $this->db->get()->result();
        return $resultado;
    }

    //EGRESO EFECTIVO
    public function get_egreso_efectivo_diarios($fecha_inicio)
    {
        $this->db->select("sum(e.monto) as monto");
        $this->db->from("egreso_caja e");
        $this->db->where("e.forma_egreso=1");
        $this->db->where("e.estado=1");
        if (!empty($fecha_inicio)) {
            $this->db->where("date(e.fecha_registro) ='" . $fecha_inicio . "' and e.sucursal_id ='" . 2 . "'");
        }
        $resultado['datos_egresos_efectivo_diarios'] = $this->db->get()->result();
        return $resultado;
    }

    //EGRESO EFECTIVO
    public function get_egreso_transferencia_diarios($fecha_inicio)
    {
        $this->db->select("sum(e.monto) as monto");
        $this->db->from("egreso_caja e");
        $this->db->where("e.forma_egreso=2");
        if (!empty($fecha_inicio)) {
            $this->db->where("date(e.fecha_registro) ='" . $fecha_inicio . "' and e.sucursal_id ='" . 2 . "'");
        }
        $resultado['datos_egresos_transferencia_diarios'] = $this->db->get()->result();
        return $resultado;
    }

    public function vacio($data)
    {
        if (empty($data)) {
            $data = '%';
        }
        return $data;
    }

    public function get_ventas_usuario($inicio, $fin)
    {
        $this->db->select("v.id, DATE_FORMAT(f.fecha,'%d/%m/%Y')as fecha, f.nro_factura,f.monto_total,f.subtotal,f.estado, c.ci_nit, c. nombre_cliente");
        $this->db->from("cliente c, venta v, factura f, usuario u");
        $this->db->where("c.id = v.cliente_id");
        $this->db->where("v.id = f.venta_id");
        $this->db->where("v.usuario_id = u.id");
        $this->db->where("f.fecha BETWEEN '" . $inicio . "' and '" . $fin . "'");

        $resultado['datos'] = $this->db->get()->result();

        $this->db->select("SUM(f.monto_total) total");
        $this->db->from("cliente c, venta v, factura f, usuario u");
        $this->db->where("c.id = v.cliente_id");
        $this->db->where("v.id = f.venta_id");
        $this->db->where("v.usuario_id = u.id");
        $this->db->where("f.fecha BETWEEN '" . $inicio . "' and '" . $fin . "'");
        $resultado['total'] = $this->db->get()->row();
        return $resultado;
    }

    public function get_ventas($inicio, $fin)
    {
        $this->db->select("v.id, to_char(v.fecha,'dd/mm/yyyy')as fecha, v.hora, n.nro_nota, v.subtotal, v.descuento, v.total, v.tipo_venta,
      v.estado, c.ci_nit, c.nombre_cliente, u.nombre_usuario, s.sucursal");
        $this->db->from("cliente c, venta v, nota_venta n, usuario u, sucursal s");
        $this->db->where("c.id = v.cliente_id");
        $this->db->where("v.id = n.venta_id");
        $this->db->where("v.usuario_id = u.id");
        $this->db->where("v.sucursal_id = s.id");
        $this->db->where("v.fecha BETWEEN '" . $inicio . "' and '" . $fin . "'");

        $resultado['datos'] = $this->db->get()->result();

        $this->db->select("SUM(v.total) total");
        $this->db->from("cliente c, venta v");
        $this->db->where("c.id = v.cliente_id");
        $this->db->where("v.fecha BETWEEN '" . $inicio . "' and '" . $fin . "'");
        $resultado['total'] = $this->db->get()->row();
        return $resultado;
    }

    //clientes
    public function get_clientes($fecha_inicio, $fecha_fin)
    {

        $this->db->select("*,date(c.fecha_registro) as fechar");
        $this->db->from("cliente c");
        if (!empty($fecha_inicio)) {
            $this->db->where("c.fecha_registro >=", $fecha_inicio);
        }
        if (!empty($fecha_fin)) {
            $this->db->where('c.fecha_registro <=', $fecha_fin);
        }
        $resultado['datos'] = $this->db->get()->result();

        return $resultado;
    }

    //cuentas por clientes
    public function get_cuentas_clientes($cliente, $fecha_inicio, $fecha_fin)
    {
        $this->db->select("c.nombre_cliente AS cliente,c.telefono,v.id,(vp.monto)  AS monto_pagado,v.total  AS total_venta,date(v.fecha) as fecha,dt.cantidad as cantidad_producto");
        $this->db->from("venta_pago vp,venta v,cliente c,detalle_venta dt");
        $this->db->where("vp.venta_id=v.id");
        $this->db->where("c.id=v.cliente_id");
        $this->db->where("v.id=dt.venta_id");
        $this->db->where("v.estado=1");
        $this->db->group_by("v.id");

        if (!empty($cliente)) {
            $this->db->where("c.id =", $cliente);
        }
        if (!empty($fecha_inicio)) {
            $this->db->where("v.fecha >=", $fecha_inicio);
        }
        if (!empty($fecha_fin)) {
            $this->db->where("v.fecha <=", $fecha_fin);
        }
        $resultado['datos'] = $this->db->get()->result();
        return $resultado;
    }

    //cuentas por clientes
    public function get_cuentas_cliente_sumatoria($cliente, $fecha_inicio, $fecha_fin)
    {
        $this->db->select("(v.total) as monto_total,sum(vp.monto) as monto");
        $this->db->from("venta_pago vp,venta v");
        $this->db->where("vp.venta_id=v.id");
        $this->db->where("v.estado=1");
        $this->db->group_by("v.id");

        if (!empty($cliente)) {
            $this->db->where("v.cliente_id =", $cliente);
        }
        if (!empty($fecha_inicio)) {
            $this->db->where("v.fecha >=", $fecha_inicio);
        }
        if (!empty($fecha_fin)) {
            $this->db->where("v.fecha <=", $fecha_fin);
        }
        $resultado['datos_sumatoria'] = $this->db->get()->result();
        return $resultado;
    }

    public function reporte_stock_minimo($id_sucursal)
    {
        $this->db->select("*, CASE WHEN (cantidad <= stock_minimo) THEN 'STOCK MINIMO'
            WHEN (cantidad = 0) THEN 'AGOTADO'     
          END as estado_inventario")
            ->from("inventario")
            ->where('id_sucursal', $id_sucursal)
            ->where('(cantidad <= stock_minimo)');
        $json_data = $this->db->get()->result();
        //   $json_data['datos'] = $this->db->get()->result();
        return $json_data;

    }

    //consulta para el reporte de traspaso de mercaderia
    public function reporte_solicitud_traspaso($fecha)
    {
        $this->db->select("ts.nombre as tipo_salida,si.id,al.descripcion as almacen_origen,alm.descripcion as almacen_destino,si.fecha_salida
            ,us.nombre_usuario,pr.nombre_item as producto,dts.cantidad as cantidad.date(si.fecha_salida) as fecha_salida")
            ->from('salida_inventario si,tipo_salida_inventario ts,usuario us,almacen al,almacen alm ,detalle_salida_inventario dts,producto pr')
            ->where("si.tipo_salida_inventario_id=ts.id")
            ->where("us.id=si.usuario_id")
            ->where("al.id=si.almacen_origen_id")
            ->where("alm.id=si.almacen_destino_id")
            ->where("dts.id=si.id")
            ->where("pr.id=dts.producto_inventario_id")
            ->where('date(si.fecha_salida)' . $fecha);
        $json_data = $this->db->get()->result();
        return $json_data;

    }

    public function reporte_inventario($id_sucursal)
    {
        $this->db->select("*,CASE WHEN (cantidad <= stock_minimo) THEN 'STOCK MINIMO' WHEN (cantidad = 0) THEN 'AGOTADO'  ELSE 'DISPONIBLE'
        END as estado_inventario")
            ->from("inventario")
            ->where('id_sucursal', $id_sucursal);
        $json_data = $this->db->get()->result();
        return $json_data;

    }

    public function reporte_material($id_sucursal)
    {
        $this->db->select("*,CASE WHEN (cantidad <= stock_minimo) THEN 'STOCK MINIMO' WHEN (cantidad = 0) THEN 'AGOTADO'  ELSE 'DISPONIBLE'
          END as estado_inventario")
            ->from("inventario i")
            ->where('i.id_sucursal', $id_sucursal);
        $json_data = $this->db->get()->result();
        return $json_data;
    }

    //ingresos efectivo plazo diarios
    public function get_ingreso_plazo_dia($fecha_inicio)
    {
        $this->db->select("sum(vp.monto) as monto,vp.descripcion,vp.forma_pago");
        $this->db->from("venta v,venta_pago vp");
        $this->db->where("vp.venta_id=v.id");
        $this->db->where("v.estado=1");
        $this->db->where("vp.descripcion ='forma_pago_efectivo' && vp.forma_pago ='Plazo' ");
        if (!empty($fecha_inicio)) {
            $this->db->where("vp.fecha_pago ='" . $fecha_inicio . "' and v.sucursal_id ='" . 2 . "'");
        }
        $resultado['datos_ingresos_efectivo_dia'] = $this->db->get()->result();
        return $resultado;
    }

    //ingresos efectivo contado diarios
    public function get_ingreso_efectivo_contado_dia($fecha_inicio)
    {
        $this->db->select("sum(vp.monto) as monto,vp.descripcion,vp.forma_pago");
        $this->db->from("venta v,venta_pago vp");
        $this->db->where("vp.venta_id=v.id");
        $this->db->where("v.estado=1");
        $this->db->where("vp.descripcion ='forma_pago_efectivo' && vp.forma_pago ='Efectivo' ");
        if (!empty($fecha_inicio)) {
            $this->db->where("vp.fecha_registro ='" . $fecha_inicio . "' and v.sucursal_id ='" . 2 . "'");
        }
        $resultado['datos_ingresos_efectivo_contado_dia'] = $this->db->get()->result();
        return $resultado;
    }

    //TARJETA
    public function get_ingreso_tarjeta_plazo_dia($fecha_inicio)
    {
        $this->db->select("sum(vp.monto) as monto,vp.descripcion,vp.forma_pago");
        $this->db->from("venta v,venta_pago vp");
        $this->db->where("vp.venta_id=v.id");
        $this->db->where("v.estado=1");
        $this->db->where("vp.descripcion ='forma_pago_tarjeta' && vp.forma_pago ='Plazo' ");
        if (!empty($fecha_inicio)) {
            $this->db->where("vp.fecha_registro ='" . $fecha_inicio . "' and v.sucursal_id ='" . 2 . "'");
        }
        $resultado['datos_ingresos_tarjeta_plazo_dia'] = $this->db->get()->result();
        return $resultado;
    }

    public function get_ingreso_tarjeta_contado_dia($fecha_inicio)
    {
        $this->db->select("sum(vp.monto) as monto,vp.descripcion,vp.forma_pago");
        $this->db->from("venta v,venta_pago vp");
        $this->db->where("vp.venta_id=v.id");
        $this->db->where("v.estado=1");
        $this->db->where("vp.descripcion ='forma_pago_efectivo' && vp.forma_pago ='Tarjeta' ");
        if (!empty($fecha_inicio)) {
            $this->db->where("vp.fecha_registro ='" . $fecha_inicio . "' and v.sucursal_id ='" . 2 . "'");
        }
        $resultado['datos_ingresos_tarjeta_contado_dia'] = $this->db->get()->result();
        return $resultado;
    }

    //CHEQUE
    public function get_ingreso_cheque_plazo_dia($fecha_inicio)
    {
        $this->db->select("sum(vp.monto) as monto,vp.descripcion,vp.forma_pago");
        $this->db->from("venta v,venta_pago vp");
        $this->db->where("vp.venta_id=v.id");
        $this->db->where("v.estado=1");
        $this->db->where("vp.descripcion ='forma_pago_cheque' && vp.forma_pago ='Plazo' ");
        if (!empty($fecha_inicio)) {
            $this->db->where("vp.fecha_registro ='" . $fecha_inicio . "' and v.sucursal_id ='" . 2 . "'");
        }
        $resultado['datos_ingresos_cheque_plazo_dia'] = $this->db->get()->result();
        return $resultado;
    }

    public function get_ingreso_cheque_contado_dia($fecha_inicio)
    {
        $this->db->select("sum(vp.monto) as monto,vp.descripcion,vp.forma_pago");
        $this->db->from("venta v,venta_pago vp");
        $this->db->where("vp.venta_id=v.id");
        $this->db->where("v.estado=1");
        $this->db->where("vp.descripcion ='forma_pago_efectivo' && vp.forma_pago ='Cheque' ");
        if (!empty($fecha_inicio)) {
            $this->db->where("vp.fecha_registro ='" . $fecha_inicio . "' and v.sucursal_id ='" . 2 . "'");
        }
        $resultado['datos_ingresos_cheque_contado_dia'] = $this->db->get()->result();
        return $resultado;
    }

    //DEPOSITO BANCARIO
    public function get_ingreso_deposito_plazo_dia($fecha_inicio)
    {
        $this->db->select("sum(vp.monto) as monto,vp.descripcion,vp.forma_pago");
        $this->db->from("venta v,venta_pago vp");
        $this->db->where("vp.venta_id=v.id");
        $this->db->where("v.estado=1");
        $this->db->where("vp.descripcion ='forma_pago_deposito' && vp.forma_pago ='Plazo' ");
        if (!empty($fecha_inicio)) {
            $this->db->where("vp.fecha_registro ='" . $fecha_inicio . "' and v.sucursal_id ='" . 2 . "'");
        }
        $resultado['datos_ingresos_deposito_plazo_dia'] = $this->db->get()->result();
        return $resultado;
    }

    public function get_ingreso_deposito_contado_dia($fecha_inicio)
    {
        $this->db->select("sum(vp.monto) as monto,vp.descripcion,vp.forma_pago");
        $this->db->from("venta v,venta_pago vp");
        $this->db->where("vp.venta_id=v.id");
        $this->db->where("v.estado=1");
        $this->db->where("vp.descripcion ='forma_pago_efectivo' && vp.forma_pago ='deposito' ");
        if (!empty($fecha_inicio)) {
            $this->db->where("vp.fecha_registro ='" . $fecha_inicio . "' and v.sucursal_id ='" . 2 . "'");
        }
        $resultado['datos_ingresos_deposito_contado_dia'] = $this->db->get()->result();
        return $resultado;
    }


}