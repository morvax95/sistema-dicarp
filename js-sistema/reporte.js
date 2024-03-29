/**
 * Created by Juan on 23/03/2018.
 */
$(document).ready(function () {
});

//exportar a pdf clientes
function imprimir_clientes(element) {

    var inicio = $('#fecha_inicio').val();
    var fin = $('#fecha_fin').val();

    location.href = site_url + 'reporte/imprimir_clientes' + '/' + inicio + '/' + fin;
    $.redirect(site_url + 'reporte/imprimir_clientes', {
        fecha_inicio: inicio,
        fecha_fin: fin,

    }, 'POST', '_self');
}
//exportar a pdf cuentas corriente
function imprimir_cuenta_corriente(element) {

    var cliente = $('#cliente').val();
    var inicio = $('#fecha_inicio').val();
    var fin = $('#fecha_fin').val();

    location.href = site_url + 'reporte/imprimir_cuentas_corrientes' + '/' + cliente + '/' + inicio + '/' + fin;
    $.redirect(site_url + 'reporte/imprimir_cuentas_corrientes', {
        cliente: cliente,
        fecha_inicio: inicio,
        fecha_fin: fin,

    }, 'POST', '_self');
}
//exportar a pdf inventario
function imprimir_inventario1(element) {

    var sucursal = $('#sucursales').val();
    $.redirect(site_url + 'reporte/imprimir_inventario', {sucursales: sucursal}, 'POST', '_self');
}


//exportar a pdf deudas
function imprimir_deudas(element) {

    $.redirect(site_url + 'reporte/imprimir_deudas', {
        fecha_inicio: $('#fecha_inicio').val(),
        fecha_fin: $('#fecha_fin').val(),
        sucursal: $('#sucursales').val()

    }, 'POST', '_self');

}

//exportar a pdf ventas
function imprimir_ventas() {

    $.redirect(site_url + 'reporte/imprimir_ventas', {
        fecha_inicio: $('#fecha_inicio').val(),
        fecha_fin: $('#fecha_fin').val(),
        // sucursal: $('#sucursales').val(),
    }, 'POST', '_self');

}
//exportar a pdf ingresos
function imprimir_ingresos() {

    $.redirect(site_url + 'reporte/imprimir_ingresos', {
        fecha_inicio: $('#fecha_inicio').val(),
        fecha_fin: $('#fecha_fin').val(),
        // sucursal: $('#sucursales').val(),
    }, 'POST', '_self');

}
//exportar a pdf ventas
function imprimir_ventas_diarias() {

    var inicio = $('#fecha_inicio').val();
    $.redirect(site_url + 'reporte/imprimir_ventas_diarias', {
        fecha_inicio: inicio,
        sucursal: $('#sucursales').val()
    }, 'POST', '_self');
}

//exportar a excel compras
function exportar_excel_compras() {
    var proveedor = $('#proveedor').val();
    var sucursal = $('#sucursal').val();
    location.href = site_url + 'reporte/exportar_excel_compras' + '/' + proveedor + '/' + sucursal;
    $.redirect(site_url + 'reporte/exportar_excel_compras', {
        proveedor: proveedor,
        sucursal: sucursal,
    }, 'POST', '_self');

}
//exportar a excel clientes
function exportar_excel_clientes() {
    var inicio = $('#fecha_inicio').val();
    var fin = $('#fecha_fin').val();
    var talla_pantalon = $('#talla_pantalon').val();
    var talla_camisa = $('#talla_camisa').val();
    var talla_saco = $('#talla_saco').val();
    $.redirect(site_url + 'reporte/exportar_excel_clientes', {
        fecha_inicio: inicio,
        fecha_fin: fin,
        talla_pantalon: talla_pantalon,
        talla_saco: talla_saco,
        talla_camisa: talla_camisa
    }, 'POST', '_self');
}
//buscar compras
function buscarCompras() {
    var frm = $('#datos_busqueda').serialize();
    console.log(frm);
    $.ajax({
        url: site_url + 'reporte/get_compras',
        data: frm,
        type: 'post',
        success: function (registro) {
            var datos = JSON.parse(registro);
            console.log(datos)

            $('#lista_reporte_ventas tbody').empty();
            $('#lista_reporte_ventas tfoot').empty();
            $.each(datos.datos, function (i, item) {
                $('#lista_reporte_ventas tbody').append(
                    '<tr>' +
                    '<td class="text-center">' + item.fecha_compra + '</td>' +
                    '<td class="text-center">' + item.subtotal + '</td>' +
                    '<td class="text-center">' + item.descuento + '</td>' +
                    '<td class="text-center">' + item.monto_total + '</td>' +
                    '<td class="text-center">' + item.nombre + '</td>' +
                    '<td class="text-center">' + item.sucursal + '</td>' +

                    '</tr>' +
                    '</table>'
                );
            });

        }
    });
}
//buscar materias
function buscarMaterias() {
    var frm = $('#datos_busqueda').serialize();
    console.log(frm);
    $.ajax({
        url: site_url + 'reporte/get_materias',
        data: frm,
        type: 'post',
        success: function (registro) {
            var datos = JSON.parse(registro);
            console.log(datos)

            $('#lista_reporte_materias tbody').empty();
            $('#lista_reporte_materias tfoot').empty();
            $.each(datos.datos, function (i, item) {
                $('#lista_reporte_materias tbody').append(
                    '<tr>' +
                    '<td class="text-center">' + item.nombre_item + '</td>' +
                    '<td class="text-center">' + item.nombre_item + '</td>' +
                    '<td class="text-center">' + item.nombre_item + '</td>' +
                    '<td class="text-center">' + item.nombre_item + '</td>' +
                    '<td class="text-center">' + item.nombre_item + '</td>' +
                    '<td class="text-center">' + item.nombre_item + '</td>' +
                    '<td class="text-center">' + item.nombre_item + '</td>' +

                    '</tr>' +
                    '</table>'
                );
            });

        }
    });
}
//buscar cliente
function buscarClientes() {
    var frm = $('#datos_busqueda').serialize();
    console.log(frm);
    $.ajax({
        url: site_url + 'reporte/get_clientes',
        data: frm,
        type: 'post',
        success: function (registro) {
            var datos = JSON.parse(registro);
            console.log(datos)

            $('#lista_reporte_ventas tbody').empty();
            $('#lista_reporte_ventas tfoot').empty();
            $.each(datos.datos, function (i, item) {
                $('#lista_reporte_ventas tbody').append(
                    '<tr>' +
                    '<td class="text-center">' + parseFloat(i + 1) + '</td>' +
                    '<td class="text-center">' + item.ci_nit + '</td>' +
                    '<td class="text-center">' + item.nombre_cliente + '</td>' +
                    '<td class="text-center">' + item.telefono + '</td>' +
                    '<td class="text-center">' + item.fechar + '</td>' +

                    '</tr>' +
                    '</table>'
                );
            })

        }
    });
}


function buscar() {
    var mes = $('#mes').val();
    var anio = $('#anio').val();
    var suc = $('#sucursal_lcv').val();

    var frm = 'mes=' + mes + '&anio=' + anio + '&sucursal=' + suc;
    $.ajax({
        url: site_url + 'reporte/getFacturasLCV',
        data: frm,
        type: 'post',
        success: function (registro) {

            $('#lista_lcv tbody').empty();
            var datos = JSON.parse(registro);
            if (jQuery.isEmptyObject(datos)) {
                $('#lista_lcv tbody').append(
                    '<tr>' +
                    '<td colspan="7">Datos no entontrados</td>' +
                    '</tr>'
                );
            } else {
                $('#lista_lcv tbody').empty();
                $.each(datos, function (i, item) {
                    $('#lista_lcv tbody').append(
                        '<tr>' +
                        '<td class="text-center">' + item.nro_factura + '</td>' +
                        '<td class="text-center">' + item.autorizacion + '</td>' +
                        '<td class="text-center">' + item.fecha + '</td>' +
                        '<td class="text-center">' + item.ci_nit + '</td>' +
                        '<td >' + item.nombre_cliente + '</td>' +
                        '<td class="text-right">' + item.monto_total + '</td>' +
                        '<td class="text-center">' + item.sucursal + '</td>' +
                        '</tr>' +
                        '</table>'
                    );
                });
            }
        }
    });
}

//buscar deudas
function buscar_deudas() {
    var frm = $('#datos_busqueda_deudas').serialize();
    console.log(frm);
    $.ajax({
        url: site_url + 'reporte/get_deudas',
        data: frm,
        type: 'post',
        success: function (registro) {
            var datos = JSON.parse(registro);
            console.log(datos)
            if (datos == '') {
                $('#lista_deudas_reporte tbody').empty();
                $('#lista_deudas_reporte tbody').append(
                    '<tr>' +
                    '<td colspan="8" style="color: red;font-weight: bold"><em>Datos no entontrados</em></td>' +
                    '</tr>'
                );
            } else {

                $('#lista_deudas_reporte tbody').empty();
                $('#lista_deudas_reporte tfoot').empty();
                $.each(datos.datos, function (i, item) {
                    $('#lista_deudas_reporte tbody').append(
                        '<tr>' +
                        '<td class="text-center">' + parseFloat(i + 1) + '</td>' +
                        '<td class="text-center">' + item.fecha + '</td>' +
                        '<td class="text-center">' + item.nombre_cliente + '</td>' +
                        '<td class="text-center">' + item.total + '</td>' +
                        '<td class="text-center">' + item.total_pagado + '</td>' +
                        '<td class="text-center">' + item.saldo + '</td>' +
                        '<td class="text-center">' + item.estado + '</td>' +

                        '</tr>' +
                        '</table>'
                    );
                })
            }
        }
    });
}

function buscarVentas_diaria() {
    var frm = $('#datos_busqueda').serialize();
    $.ajax({
        url: site_url + 'reporte/get_ventas_diarias',
        data: frm,
        type: 'post',
        success: function (registro) {
            var datos = JSON.parse(registro);
            console.log(datos)
            if (datos.datos == '') {
                $('#lista_reporte_ventas tbody').append(
                    '<tr>' +
                    '<td colspan="8" style="color: red;font-weight: bold"><em>Datos no entontrados</em></td>' +
                    '</tr>'
                );
            } else {
                $('#lista_reporte_ventas tbody').empty();
                $('#lista_reporte_ventas tfoot').empty();
                $.each(datos.datos, function (i, item) {
                    $('#lista_reporte_ventas tbody').append(
                        '<tr>' +
                        '<td class="text-center">' + item.nro_nota + '</td>' +
                        '<td class="text-center">' + item.nombre_cliente + '</td>' +
                        '<td class="text-center">' + item.forma_pago + '</td>' +
                        '<td class="text-center">' + item.fecha + '</td>' +
                        '<td class="text-center">' + item.monto + '</td>' +
                        '</tr>' +
                        '</table>'
                    );
                });
                $.each(datos.total, function (i, value) {
                    console.log(value)

                })
            }
        }
    });
}
function buscarIngresos() {
    var frm = $('#datos_busqueda').serialize();
    $.ajax({
        url: site_url + 'reporte/get_flujo_caja_ingreso',
        data: frm,
        type: 'post',
        success: function (registro) {
            var datos = JSON.parse(registro);
            console.log(datos)
            if (datos.datos == '') {
                $('#lista_reporte_ventas tbody').append(
                    '<tr>' +
                    '<td colspan="8" style="color: red;font-weight: bold"><em>Datos no entontrados</em></td>' +
                    '</tr>'
                );
            } else {
                $('#lista_reporte_ventas tbody').empty();
                $('#lista_reporte_ventas tfoot').empty();
                $.each(datos.datos, function (i, item) {
                    $('#lista_reporte_ventas tbody').append(
                        '<tr>' +
                        '<td class="text-center">' + parseFloat(i + 1) + '</td>' +
                        '<td class="text-center">' + item.monto + '</td>' +
                        '<td class="text-center">' + item.descripcion + '</td>' +
                        '<td class="text-center">' + item.monto + '</td>' +

                        // '<td class="text-center">' + item.precio_venta * item.cantidad+ '</td>' +
                        '<td class="text-center">' + item.monto + '</td>' +
                        '</tr>' +
                        '</table>'
                    );
                });
                $.each(datos.total, function (i, value) {
                    console.log(value)

                })
            }
        }
    });
}
function buscarVentas() {
    var frm = $('#datos_busqueda').serialize();
    $.ajax({
        url: site_url + 'reporte/get_ventas_emitidas',
        data: frm,
        type: 'post',
        success: function (registro) {
            var datos = JSON.parse(registro);
            console.log(datos)
            if (datos.datos == '') {
                $('#lista_reporte_ventas tbody').append(
                    '<tr>' +
                    '<td colspan="8" style="color: red;font-weight: bold"><em>Datos no entontrados</em></td>' +
                    '</tr>'
                );
            } else {
                $('#lista_reporte_ventas tbody').empty();
                $('#lista_reporte_ventas tfoot').empty();
                $.each(datos.datos, function (i, item) {
                    $('#lista_reporte_ventas tbody').append(
                        '<tr>' +
                        '<td class="text-center">' + parseFloat(i + 1) + '</td>' +
                        '<td class="text-center">' + item.producto + '</td>' +
                        '<td class="text-center">' + item.precio_venta + '</td>' +
                        '<td class="text-center">' + item.cantidad + '</td>' +

                        '<td class="text-center">' + item.precio_venta * item.cantidad + '</td>' +
                        '</tr>' +
                        '</table>'
                    );
                });
                $.each(datos.total, function (i, value) {
                    console.log(value)

                })
            }
        }
    });
}

function buscarVentasUsuario() {
    var frm = $('#datos_busqueda_usuario').serialize();
    $.ajax({
        url: site_url + 'reporte/get_ventas_usuario',
        data: frm,
        type: 'post',
        success: function (registro) {
            var datos = JSON.parse(registro);
            if (jQuery.isEmptyObject(datos)) {
                $('#ventas_usuarios tbody').append(
                    '<tr>' +
                    '<td colspan="7">Datos no entontrados</td>' +
                    '</tr>'
                );
            } else {
                $('#ventas_usuarios tbody').empty();
                $.each(datos.datos, function (i, item) {
                    $('#ventas_usuarios tbody').append(
                        '<tr>' +
                        '<td class="text-center">' + parseFloat(i + 1) + '</td>' +
                        '<td class="text-center">' + item.nro_factura + '</td>' +
                        '<td class="text-center">' + item.fecha + '</td>' +
                        '<td class="text-center">' + item.ci_nit + '</td>' +
                        '<td >' + item.nombre_cliente + '</td>' +
                        '<td class="text-center">' + item.monto_total + '</td>' +
                        '</tr>' +
                        '</table>'
                    );
                });
            }
        }
    });
}

function exportar_txt_lcv() {
    var mes = $('#mes').val();
    var anio = $('#anio').val();
    var sucursal = $('#sucursal_lcv').val();
    location.href = site_url + 'reporte/getTxt' + '/' + mes + '/' + anio + '/' + sucursal;
}

function exportar_excel_lcv() {
    var mes = $('#mes').val();
    var anio = $('#anio').val();
    var sucursal = $('#sucursal_lcv').val();
    location.href = site_url + 'reporte/getExcel' + '/' + mes + '/' + anio + '/' + sucursal;
}


function exportar_excel_ventas_emitidas() {


    $.redirect(site_url + 'reporte/exportar_excel_ventas_emitidas', {
        fecha_inicio: $('#fecha_inicio').val(),
        fecha_fin: $('#fecha_fin').val(),
        sucursal: $('#sucursales').val(),
        forma_pagos: $('#forma_pagos').val()
    }, 'POST', '_self');
}
function exportar_excel_ventas_diarias() {
    var inicio = $('#fecha_inicio').val();
    location.href = site_url + 'reporte/exportar_excel_ventas_diarias' + '/' + inicio;
    $.redirect(site_url + 'reporte/exportar_excel_ventas_diarias', {
        fecha_inicio: inicio,
        sucursal: $('#sucursales').val()
    }, 'POST', '_self');
}


function buscar_stock_minimo() {
    var frm = $('#datos_busqueda_stock').serialize();
    $.ajax({
        url: site_url + 'reporte/reporte_stock_minimo',
        data: frm,
        type: 'post',
        success: function (registro) {
            var datos = JSON.parse(registro);
            console.log(datos)
            if (datos == '') {
                $('#lista_reporte_stock tbody').append(
                    '<tr>' +
                    '<td colspan="8" style="color: red;font-weight: bold"><em>Datos no entontrados</em></td>' +
                    '</tr>'
                );
            } else {
                $('#lista_reporte_stock tbody').empty();
                $.each(datos, function (i, item) {
                    $('#lista_reporte_stock tbody').append(
                        '<tr>' +
                        '<td class="text-center">' + parseFloat(i + 1) + '</td>' +
                        '<td class="text-center">' + item.codigo_barra + '</td>' +
                        '<td class="text-center">' + item.nombre_item + '</td>' +
                        '<td class="text-center">' + item.color + '</td>' +
                        '<td class="text-center">' + item.talla + '</td>' +
                        '<td class="text-center">' + item.precio_venta + '</td>' +
                        '<td class="text-center">' + item.cantidad + '</td>' +
                        // '<td class="text-center">' + item.almacen + '</td>' +
                        '<td class="text-center">' + item.estado_inventario + '</td>' +

                        '</tr>' +
                        '</table>'
                    );
                });
            }
        }
    });
}
function buscar_inventario() {
    var frm = $('#datos_busqueda_stock').serialize();
    $.ajax({
        url: site_url + 'reporte/reporte_inventario1',
        data: frm,
        type: 'post',
        success: function (registro) {
            var datos = JSON.parse(registro);
            console.log(datos)
            if (datos == '') {
                $('#lista_reporte_stock tbody').append(
                    '<tr>' +
                    '<td colspan="8" style="color: red;font-weight: bold"><em>Datos no entontrados</em></td>' +
                    '</tr>'
                );
            } else {
                $('#lista_reporte_stock tbody').empty();
                $.each(datos, function (i, item) {
                    $('#lista_reporte_stock tbody').append(
                        '<tr>' +
                        '<td class="text-center">' + parseFloat(i + 1) + '</td>' +
                        '<td class="text-center">' + item.codigo_barra + '</td>' +
                        '<td class="text-center">' + item.nombre_item + '</td>' +
                        '<td class="text-center">' + item.color + '</td>' +
                        // '<td class="text-center">' + item.precio + '</td>' +
                        //'<td class="text-center">' + item.talla + '</td>' +
                        '<td class="text-center">' + item.cantidad + '</td>' +
                        '<td class="text-center">' + item.almacen + '</td>' +
                        '<td class="text-center">' + item.estado_inventario + '</td>' +

                        '</tr>' +
                        '</table>'
                    );
                });
            }
        }
    });
}
function buscar_Material() {
    var frm = $('#datos_busqueda_stock').serialize();
    $.ajax({
        url: site_url + 'reporte/reporte_material',
        data: frm,
        type: 'post',
        success: function (registro) {
            var datos = JSON.parse(registro);
            console.log(datos)
            if (datos == '') {
                $('#lista_reporte_stock tbody').append(
                    '<tr>' +
                    '<td colspan="8" style="color: red;font-weight: bold"><em>Datos no entontrados</em></td>' +
                    '</tr>'
                );
            } else {
                $('#lista_reporte_stock tbody').empty();
                $.each(datos, function (i, item) {
                    $('#lista_reporte_stock tbody').append(
                        '<tr>' +
                        '<td class="text-center">' + parseFloat(i + 1) + '</td>' +
                        '<td class="text-center">' + item.codigo_barra + '</td>' +
                        '<td class="text-center">' + item.nombre_item + '</td>' +
                        '<td class="text-center">' + item.tipo_producto + '</td>' +
                        '<td class="text-center">' + item.cantidad + '</td>' +
                        '<td class="text-center">' + item.almacen + '</td>' +

                        '</tr>' +
                        '</table>'
                    );
                });
            }
        }
    });
}

function exportar_excel_stock_minimo() {
    var sucursal = $('#sucursales').val();
    $.redirect(site_url + 'reporte/exportar_stock_minimo', {sucursales: sucursal}, 'POST', '_self');
}

function exportar_excel_inventario() {
    var sucursal = $('#sucursales').val();
    $.redirect(site_url + 'reporte/exportar_inventario', {sucursales: sucursal}, 'POST', '_self');
}
function exportar_excel_material() {
    var sucursal = $('#sucursales').val();
    $.redirect(site_url + 'reporte/exportar_material', {sucursales: sucursal}, 'POST', '_self');
}
