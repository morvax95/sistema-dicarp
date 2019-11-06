/**
 * Created by Juan Carlos on 17/02/2018.
 */
$(document).ready(function () {
    listar_items();
});

//Lista todos los productos, usa procesamiento de dt (prueba correcta)
function listar_items() {
    $('#lista_nota').DataTable({
        'paging': true,
        'info': true,
        'filter': true,
        'stateSave': true,
        'responsive': true,
        'processing': true,
        'serverSide': true,

        'ajax': {
            "url": site_url + "venta_proceso/get_all_items_in_production",
            "type": "post",
            // dataSrc: ''
        },
        'columns': [
            {data: 'id'},
            {data: 'nombre_cliente', class: 'text-center'},
            {data: 'nombre_item', class: 'text-center'},
            {data: 'cantidad_total', class: 'text-center'},
            {data: 'fecha', class: 'text-center'},
            {data: 'venta_id', class: 'text-center'},
            //  {data: 'anular', class: 'text-center'},
        ],
        "columnDefs": [
            {
                targets: 0,
                visible: false,
                searchable: false,
            },
            {
                targets: 5,
                searchable: false,
                orderable: false,
                render: function (data, type, row) {
                    if (row.nombre_cliente != 'ANULADO') {
                        if (row.estado != '2') {
                            return '<a role="button"  onclick="cambiar_reimprimir_nota_venta(this)"  ><img width="30" height="30" src="' + base_url + '/assets/img/imprimir.png" title="Buscar"></a>&nbsp;&nbsp;';
                        } else {
                            return '<label style="color: red;"><b>Esta anulado</b></label>';
                        }
                    }
                }
            }
            , {
                targets: 2,
                data: "nombre_cliente",
                render: function (data, type, row) {
                    return "<spam style='color:#0d6aad; font-weight: bold;'> " + data + "</spam>"
                }
            }
        ],
        "order": [[0, "desc"]],
    });

}

function cambiar_reimprimir_nota_venta(seleccionado) {

    var table = $('#lista_nota').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];

    swal({
            title: "Solictud Entregada",
            text: "Esta solicitud será Entregada, esta seguro?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, Entregar solicitud!",
            cancelButtonText: "No Entregar la solicitud ",
            closeOnConfirm: false,
            closeOnCancel: false
        },

        function (isConfirm) {

            if (isConfirm) {

                ajaxStart('Guardando datos...');

                $.ajax({
                    url: site_url + 'venta_proceso/modificar_estado_solicitud_cancelada',
                    data: 'id_solicitud=' + id,
                    type: 'post',

                    success: function (registro) {
                        if (registro == 'error') {
                            ajaxStop();
                            swal("Error", "Problemas al devolver", "error");
                        } else {
                            ajaxStop();
                            swal("Devuelta!", "La Solicitud ha sido devuelta.", "success");
                            actualizarDataTable($('#lista_nota'));
                            reimprimir_nota_ventas(seleccionado) //SACA LA NOTA DE LA VENTA CORRESPONDIENTE
                        }
                    }
                });
            } else {
                swal("Cancelado", "Accion cancelada.", "error");
            }
        }
    )
    ;
}

function reimprimir_nota_ventas(seleccionado) {

    var table = $('#lista_nota').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['venta_id']

    var forma_pago = rowData['forma_pago']
    if (forma_pago == 'Plazo') {
        // mostrar_ventana_consulta(site_url + 'venta/imprimir_nota_ventas_plazos/' + id, 'Nota de Venta', '1000', '700');//para imprimir en tamaño carta el comprobante de venta
        mostrar_ventana_consulta(site_url + 'venta/imprimir_nota_entrega/' + id, 'Nota de Venta', '1000', '700');//para imprimir en tamaño carta el comprobante de venta
    } else if (forma_pago == 'Deposito' || 'Efectivo' || 'Tarjeta' || 'Cheque') {
        //mostrar_ventana_consulta(site_url + 'venta/imprimir_nota_ventas_contado/' + id, 'Nota de Venta', '1000', '700');//para imprimir en tamaño carta el comprobante de venta

        mostrar_ventana_consulta(site_url + 'venta/imprimir_nota_entrega/' + id, 'Nota de Venta', '1000', '700');//para imprimir en tamaño carta el comprobante de venta
    }

}


function mostrar_ventana_consulta(url, title, w, h) {
    var left = 200;
    var top = 50;

    window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
}




