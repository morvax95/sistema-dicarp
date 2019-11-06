/**
 * Created by Juan Carlos on 17/02/2018.
 */




$(document).ready(function () {
    listar_items();


});

//Lista todos los productos, usa procesamiento de dt (prueba correcta)
function listar_items() {
    $('#lista_item').DataTable({
        'lengthMenu': [[20, 60, 150, 250, 300], [20, 60, 150, 250, 300]],
        'paging': true,
        'info': true,
        'filter': true,
        'stateSave': true,
        'processing': true,
        'serverSide': true,

        'ajax': {
            "url": site_url + 'producto_produccion/get_all_items',
            "type": 'post',
        },
        'columns': [
            {data: 'id'},
            {data: 'id', 'class': 'text-center'},
            {data: 'nombre_almacen', 'class': 'text-center'},
            {data: 'fecha_ingreso', 'class': 'text-center'},
            {data: 'nombre_usuario', 'class': 'text-center'},
            {data: 'opciones', 'class': 'text-center'},
            {data: 'id', 'class': 'text-center'},
        ],
        "columnDefs": [
            {
                targets: 0,
                visible: false,
                searchable: false
            },
            {
                targets: 6,
                visible: false,
                searchable: false
            },

            {
                targets: 1,
                searchable: false,
                orderable: false,
            },
            {
                targets: 2,
                searchable: false,
                orderable: false,
            },
            {
                targets: 3,
                searchable: false,
                orderable: false,
            },
            {
                targets: 4,
                searchable: false,
                orderable: false,
            },

            {
                targets: 5,
                render: function (data, type, row) {
                    return '<a  role="button" onclick="enviar_datos(this);" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> Ver Ingreso</a>&nbsp;&nbsp;'
                }
            }
            ,
            {
                targets: 2,
                data: "nombre_almacen",
                render: function (data, type, row) {
                    return "<spam style='color:#0d6aad; font-weight: bold;'> " + data + "</spam>"
                }
            }

        ],

        "order": [[0, "asc"]],
    });
}

function enviar_datos(seleccionado) {
    var table = $(seleccionado).closest('table').DataTable();
    var current_row = $(seleccionado).parents('tr');
    if (current_row.hasClass('child')) {
        current_row = current_row.prev();
    }
    var data = table.row(current_row).data();
    $.redirect(site_url + 'producto_produccion/ver_datos', {id: data['id']}, 'POST', '_self');

}
function modificar_estado_producto(IdProducto) {
    var n_ingreso = $('#n_ingreso').val();
    var IdProducto1 = $('#codigo_producto').val();
    // alert("ingr " + n_ingreso + "pro " + IdProducto1);

    ajaxStart('Guardando datos...');
    $.ajax({
            url: site_url + 'producto/modificar_estado_producto',

            data: "idIngre=" + n_ingreso + "&idProducto=" + IdProducto1,

            type: 'post',
            success: function (registro) {
                if (registro == 'error') {
                    ajaxStop();
                    swal("Error", "Problemas al habilitar", "error");
                } else {
                    ajaxStop();
                    swal("Habilitado!", "El estado ha sido habilitado.", "success");

                }
            }
        }
    )
    ;
}
