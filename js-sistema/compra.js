/**
 * Created by Juan on 23/03/2018.
 */
$(document).ready(function() {
    listar_compras();


    $('#subtotal_compra').keyup(function () {
        if ($('#subtotal_compra').val() === "") {
            rellenarCero($('#subtotal_compra'));
            rellenarCero($('#subtotal_compra'));
        } else {
            var subtotal = parseFloat($('#subtotal_compra').val());
            $('#total_compra').val(subtotal);
        }
    });

    $('#descuento_compra').keyup(function () {
        var subtotal = parseFloat($('#subtotal_compra').val());
        var descuento = parseFloat($('#descuento_compra').val());
        if ($('#descuento_compra').val() == "") {
            rellenar_cero($('#descuento_compra'));
            descuento = 0.00;
        }
        total = subtotal - descuento;
        $('#total_compra').val(total.toFixed(2));
    });

    // Obtiene el nombre del producto ya registrado
    $('#detalle_compra').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: site_url + 'producto/buscar_item',
                dataType: "json",
                data: {
                    name_startsWith: request.term,
                },
                success: function (data) {
                    response($.map(data, function (item, nombre) {
                        var label = nombre.split('|');
                        return {
                            label: nombre,
                            value: label[0],
                            id: item
                        };
                    }));
                }
            });
        },
        select: function (event, ui) {
            var id_producto = ui.item.id;
            var index_producto_id = id_producto.split('|')[0];
            var datos = (ui.item.label);
            var elem = datos.split('|');
            console.log(elem)
            var precio = elem[1].split(' ');
            $('#precio_compra').val(elem[4]);
            $('#id_producto_seleccionado').val(index_producto_id);
        }
    });

    /*--------------------------------------------
     Registro de nueva compra
     --------------------------------------------*/
    $('#btn_registrar_compra').click(function (event) {
        event.preventDefault();
        var formulario = $('#frm_registro_compra');
        var data = formulario.serialize();
        formulario.attr('action',site_url+'compra/registrar');
        // console.log(formulario)
        // console.log(data);
        registro_abm(formulario,data);
       // setTimeout(function () { location.href = site_url + 'compra/nuevo'},2000);
        // formulario[0].reset();
    });


    function rellenar_cero(elemento) {
        elemento.val('0.00');
    }
});

var contador_compra = 0;
var subtotal_compra = 0;

function agregar_detalle_compra(id_formulario) {
    if($('#cantidad_compra').val() === '0.00' || $('#cantidad_compra').val() === '0' || $('#cantidad_compra').val() === ''){
        swal('No puede agregar item con cantidad cero o en blanco.');
        return;
    }
    //agrega filas a la tabla de nota de venta y suma los precios de cada producto
    contador_compra = $('#contador_compra').val();
    subtotal_compra = $('#subtotal_compra').val();
    contador_compra = contador_compra + 1;
    $('#contador_compra').val(contador_compra);
    var frm = $(id_formulario).serialize();
    $.ajax({
        url: site_url + 'compra/agregar',
        data: frm,
        type: 'post',
        success: function (registro) {
            var datos = eval(registro);
           // console.log(datos);
            $('#precio_compra').val("0.00");
            $('#cantidad_compra').val("0");

            $('#lista_detalle_compra tbody').append(datos[0]); //dataTable > tbody:first
            subtotal_compra = parseFloat(subtotal_compra) + parseFloat(datos[2]);
            $('#subtotal_compra').val(subtotal_compra.toFixed(2));
            $('#detalle_compra').focus();
            $('#detalle_compra').val('');
            cuadradar_saldos_compra();
            fn_dar_eliminar(parseFloat(datos[2]));
            return false;
        }
    });
    return false;
}

function fn_dar_eliminar(contador) { //Elimina las filas de la tabla de nota de venta y resta el subtotal
    var monto_total = $('#monto'+contador).val();
    if (monto_total != null){
        dato = monto_total;
    }
    contador_compra = $('#contador_compra').val();
    subtotal_compra = $('#subtotal_compra').val();
    $("a.elimina").click(function () {
        $(this).parents("tr").fadeOut("normal", function () {
            $(this).remove();
            subtotal_compra = parseFloat($('#subtotal_compra').val()) - dato;
            saldo = parseFloat($('#subtotal_compra').val()) - dato;
            $('#subtotal_compra').val(saldo.toFixed(2));
            $('#total_compra').val($('#subtotal_compra').val());
            contador_compra = contador_compra -1;
            $('#contador_compra').val(contador_compra);
        });
    });
}

function eliminar_detalle(contador) { //Elimina las filas de la tabla de nota de venta y resta el subtotal
    $("a.elimina").click(function () {
        $(this).parents("tr").fadeOut("normal", function () {
            var monto_total = $('#monto'+contador).val();
            contador_compra = $('#contador_compra').val();
            // alert($('#monto'+contador).val())
            // alert(contador_compra)
            $(this).remove();
            subtotal_saldo = parseFloat($('#subtotal_compra').val()) - parseFloat(monto_total);
            $('#subtotal_compra').val(subtotal_saldo);
            $('#total_compra').val($('#subtotal_compra').val());
            contador_compra = contador_compra - 1;
            $('#contador_compra').val(contador_compra);
        });
    });
}

function modificar_detalle(contador) {
    var cant = $("#cantidad" + contador).val();
    if ($.isNumeric(cant)) {
        var precio = $('#precio' + contador).val();
        var monto = parseFloat(cant) * parseFloat(precio);
        modiSub = $("#monto" + contador).val();
        $('#monto' + contador).val(monto);
        var monto1 = parseFloat(modiSub);
        var st = $('#subtotal_compra').val();
        st = parseFloat(st) - monto1;
        var subTotal = st + monto;
        $('#subtotal_compra').val(subTotal.toFixed(2));
        $('#total_compra').val(subTotal.toFixed(2));
        subtotal_compra = subTotal;
    }
}

function cuadradar_saldos_compra() {
    if ($('#subtotal_compra').val() === "") {
        rellenarCero($('#subtotal_compra'));
        rellenarCero($('#subtotal_compra'));
    } else {
        var subtotal = parseFloat($('#subtotal_compra').val());
        $('#descuento_compra').val('0.00');
        $('#total_compra').val(subtotal.toFixed(2));
    }
}

function listar_compras() {
    $('#lista_compra').DataTable({
        'lengthMenu': [[20,60,150,250,300],[20,60,150,250,300]],
        'paging': true,
        'info': true,
        'filter': true,
        'stateSave': true,
        'processing': true,
        'serverSide': true,

        'ajax': {
            "url": site_url + 'compra/get_all',
            "type": 'post',
        },
        'columns': [
            {data: 'id'},
            {data: 'fecha_compra', 'class': 'text-center'},
            {data: 'observacion'},
            {data: 'nombre', 'class': 'text-center'},
            {data: 'sucursal', 'class': 'text-center'},
            {data: 'monto_total', 'class': 'text-right'},
            {data: 'estado', 'class': 'text-center'},
            {data: 'opciones', 'class': 'text-center'},
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
                "render": function (data, type, row) {
                    var monto = parseInt(row.monto_total);
                    return monto.toFixed(2);
                }
            },
            {
                targets: 6,
                searchable: false,
                orderable: false,
                data: 'estado',
                "render": function (data, type, row) {
                    if (data == 0) {
                        return "<span class='label label-danger'><i class='fa fa-times'></i> Inactivo</span>"
                    } else if (data == 1) {
                        return "<span class='label label-success'><i class='fa fa-check'></i> Habilitado</span>"
                    }
                }
            },
            {
                targets: 7,
                searchable: false,
                orderable: false,
                render: function (data, type, row) {
                    if (row.estado === '1') {
                        var opciones = get_buttons_frm('edit-delete');
                        return opciones;
                    } else {
                        return '';
                    }
                }
            }
        ],
        "order": [[0, "asc"]],
    });
}

function editar(seleccionado) {
    edit_registrer_frm(seleccionado,'compra/editar');
}

function eliminar(seleccionado) {
    delete_registrer(seleccionado,'compra/eliminar')
}