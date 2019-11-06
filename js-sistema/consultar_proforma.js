/**
 * Created by Juan on 22/10/2018.
 */

$(document).ready(function () {
    get_note_sales();
});

function obtenerListaFacturas() {
    $('#lista_facturas').DataTable({
        'paging': true,
        'info': true,
        'filter': true,
        'stateSave': true,
        'responsive': true,
        'processing': true,
        'serverSide': true,

        'ajax': {
            "url": site_url + "consultar_venta/get_user_in_list",
            "type": "post",
            // dataSrc: ''
        },

        'columns': [
            {data: 'venta_id'},
            {data: 'nro_factura', class: 'text-center'},
            {data: 'autorizacion', class: 'text-center'},
            {data: 'fecha_transaccion', class: 'text-center'},
            {data: 'nombre_cliente'},
            {data: 'monto_total',class: 'text-center'},
            {data: 'imprimir', class: 'text-center'},
            {data: 'imprimir', class: 'text-center'},
            {data: 'anular', class: 'text-center'},
        ],
        "columnDefs": [
            {
                targets: 0,
                visible: false,
                searchable: false,
            },
            {
                targets: 6,
                searchable: false,
                orderable: false,
                render: function (data, type, row) {
                    if (row.nombre_cliente != 'ANULADO') {
                        return '<a role="button"  onclick="reimprimirFacturaOriginal(this)"  ><img width="30" height="30" src="'+base_url+'/assets/img/imprimir.png" title="Buscar"></a>&nbsp;&nbsp;';

                    }
                    return '';
                }
            },
            {
                targets: 7,
                searchable: false,
                orderable: false,
                render: function (data, type, row) {
                    if (row.nombre_cliente != 'ANULADO') {
                        return '<a role="button"  onclick="reimprimirFacturaCopia(this)"  ><img width="30" height="30" src="'+base_url+'/assets/img/imprimir.png" title="Buscar"></a>&nbsp;&nbsp;';

                    }
                    return '';
                }
            },
            {
                targets: 8,
                searchable: false,
                orderable: false,
                render: function (data, type, row) {
                    if (row.nombre_cliente != 'ANULADO') {
                        return '<a  role="button"  onclick="anularFactura(this)" ><img width="30" height="30" src="'+base_url+'/assets/img/anular.png" title="Anular"></a>&nbsp;&nbsp;';

                    }
                    return '';
                }
            }
        ],
        "order": [[0, "asc"]],
    });

}

function get_note_sales() {
    $('#lista_nota').DataTable({
        'paging': true,
        'info': true,
        'filter': true,
        'stateSave': true,
        'responsive': true,
        'processing': true,
        'serverSide': true,

        'ajax': {
            "url": site_url + "consultar_proforma/get_all",
            "type": "post",
            // dataSrc: ''
        },
        'columns': [
            {data: 'id'},
            {data: 'nro_proforma',class: 'text-center'},
            {data: 'nombre_cliente',class: 'text-center'},
            {data: 'fecha', class: 'text-center'},
            {data: 'total',class: 'text-center'},
            {data: 'descuento',class: 'text-center'},
            {data: 'opciones', class: 'text-center'},
        ],
        "columnDefs": [
            {
                targets: 0,
                visible: false,
                searchable: false,
            },
            {
                targets: 6,
                searchable: false,
                orderable: false,
                render: function (data, type, row) {
                    return get_buttons_frm_proforma('ver');
                }
            }
        ],
        "order": [[0, "desc"]],
    });

}

function get_buttons_frm_proforma() {
    var buttons = '';
    buttons = '<div class="btn-group">' +
        '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">     ' +
        'OPCIONES <span class="caret"></span> ' +
        '</button><ul class="dropdown-menu">';
        buttons = buttons + '<li><a onclick="print_proforma(this);"><i class="fa fa-print"></i> Imprimir</a></li>' +
                        /*'<li><a onclick="consolidate_sale(this);"><i class="fa fa-wpforms"></i> Consolidar</a></li>'+*/
                    '</ul> ' +
                '</div>';
    return buttons;
}

function print_proforma(element) {
    var table = $(element).closest('table').DataTable();
    var fila = $(element).parents('tr');
    if (fila.hasClass('child')) {
        fila = fila.prev();
    }
    var rowData = table.row(fila).data();
    var id = rowData['id'];
    var url = site_url + 'proforma/print_proforma/'+id;
    $.redirect(url, {id: id}, 'POST', '_blank');
}

function consolidate_sale(element) {
    var table = $(element).closest('table').DataTable();
    var fila = $(element).parents('tr');
    if (fila.hasClass('child')) {
        fila = fila.prev();
    }
    var rowData = table.row(fila).data();
    var id = rowData['id'];
    var url = site_url + 'proforma/consolidate_sale';
    $.redirect(url, {id: id}, 'POST', '');
}

function anular_venta(seleccionado) {
    var table = $('#lista_nota').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id']
    swal({
            title: "ANULAR VENTA " + rowData['nro_nota'],
            text: "Esta seguro de anular esta venta?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, anular!",
            cancelButtonText: "No deseo anular",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: site_url + 'consultar_venta/anular_venta',
                    data: 'id=' + id,
                    type: 'post',
                    success: function (registro) {
                        if (registro) {
                            swal("Anulada!", "Factura anulada", "success");
                            actualizarDataTable($('#lista_nota'));
                        } else {
                            swal("Error", "Problemas al anular", "error");
                        }
                    }
                });
            } else {
                swal("Cancelado", "Accion cancelada.", "error");
            }
        });
}

function anularFactura(seleccionado) {
    var table = $('#lista_facturas').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id']
    swal({
            title: "ANULAR FACTURA " + rowData['nro_factura'],
            text: "Esta seguro de anular esta factura?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, anular!",
            cancelButtonText: "No deseo anular",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: site_url + 'consultar_venta/anularFactura',
                    data: 'id_venta=' + id,
                    type: 'post',
                    success: function (registro) {
                        if (registro) {
                            swal("Anulada!", "Factura anulada", "success");
                            actualizarDataTable($('#lista_facturas'));
                        } else {
                            swal("Error", "Problemas al anular", "error");
                        }
                    }
                });
            } else {
                swal("Cancelado", "Accion cancelada.", "error");
            }
        });
}

function reimprimirFacturaCopia(seleccionado) {
    var table = $('#lista_facturas').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id']
    mostrar_ventana_consulta(site_url + 'consultar_venta/imprimirCopiaFactura/' + id, 'Copia factura','1000', '700');
}

function reimprimir_nota_venta(seleccionado) {
    var table = $('#lista_nota').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id']
    mostrar_ventana_consulta(site_url + 'consultar_venta/imprimir_nota_venta/' + id, 'Nota de Venta','1000', '700');
}

function reimprimirFacturaOriginal(seleccionado) {
    var table = $('#lista_facturas').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id']
    mostrar_ventana_consulta(site_url + 'venta/imprimirFactura/' + id, 'Copia factura','1000', '700');
}

function mostrar_ventana_consulta(url, title, w, h) {
    var left = 200;
    var top = 50;

    window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}

function ver_registro(seleccionado) {
    var table = $(seleccionado).closest('table').DataTable();
    var current_row = $(seleccionado).parents('tr');
    if (current_row.hasClass('child')) {
        current_row = current_row.prev();
    }
    var data = table.row(current_row).data();

    $.redirect(site_url + 'proforma/consolidar_proforma', { id: data['id'] }, 'POST', '_self');
}