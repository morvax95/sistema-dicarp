$(document).ready(function(){
    listarActividad();
    /*------------------------      FORMMULARIOS PARA REGISTRAR Y MODIFICAR UNA IMPRESORA      -----------------------*/
    $('#frm_registrar_actividad').submit(function (event) {
        event.preventDefault();
        var formulario = $(this);
        var data = formulario.serialize();
        alert(data);
        registro_abm(formulario,data);
        formulario[0].reset();

    });

    $('#frm_editar_actividad').submit(function (event) {
        event.preventDefault();

        var formulario = $(this);
        var data = formulario.serialize();

        registro_abm(formulario,data);
        formulario[0].reset();
        setTimeout(function () { location.href = site_url+'actividad/index' },2000);
    });
});

/*------------------------------------      FUNCION PARA LISTAR LAS ACTIVIDADES      ---------------------------------*/
function listarActividad(){
    $('#lista-actividad').DataTable({
        'paging' : true,
        'info'   : true,
        'filter' : true,
        'stateSave': true,

        'ajax':{
            "url": site_url + "actividad/listarActividad",
            "type": "post",
            dataSrc: ''
        },

        'columns': [
            {data: 'id'},
            {data: 'nombre'},
            {data: 'direccion'},
            {data: 'telefono'},
            {data: 'email'},
            {data: 'ciudad', class: 'text-center'},
            {data: 'sucursal', class: 'text-center'},
            {data: 'estado', class: 'text-center'},
            {data: 'opciones', class: 'text-center'},
        ],
        "columnDefs":[
            {
                targets: 0,
                visible: false,
                searchable: false,
            },
            {
                targets: 7,
                visible: true,
                searchable: false,
                orderable: false,
                data: 'estado',
                "render": function (data, type, row) {
                    if(data == 0){
                        return "<span class='label label-danger'><i class='fa fa-times'></i> Desactivado</span>"
                    }else if(data == 1){
                        return "<span class='label label-success'><i class='fa fa-check'></i> Habilitado</span>"
                    }
                }
            },
            {
                targets: 8,
                searchable: false,
                orderable: false,
                render: function(data, type, row) {
                    if(row.estado != 0){
                        return get_buttons_frm('ee');
                    }else{
                        return '';
                    }
                }
            }
        ],
        "order":[[0, "asc"]],
    });
}

/*--------------------------------      FUNCION PARA SELECCIONAR UNA ACTIVIDAD      ----------------------------------*/
function editar(seleccionado){
    edit_registrer_frm(seleccionado, 'actividad/editar');
}

/*-----------------------------------------------------
    Funcion para desactivar la actividad
 ------------------------------------------------------
 */
function eliminar(seleccionado){
    delete_Registrer(seleccionado, metodo, $('#lista-actividad'));
}

function habilitarActividad(seleccionado){
    var table = $('#lista-actividad').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['id'];

    swal({
            title: "HABILITAR ACTIVIDAD",
            text: "Esta seguro de habilitar nuevamente la actividad?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, activar!",
            cancelButtonText: "No deseo activar",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: site_url + 'actividad/habilitar',
                    data: 'id_actividad=' + id,
                    type: 'post',
                    success: function (registro) {
                        if (registro == 'error') {
                            swal("Error", "Problemas al habilitar", "error");
                        } else {
                            swal("Habilitado!", "La actividad ha sido habilitada.", "success");
                            actualizarDataTable($('#lista-actividad'));
                        }
                    }
                });
            } else {
                swal("Cancelado", "Accion cancelada.", "error");
            }
        });
}
/*-------------------------------      FUNCION PARA REACTIVAR UNA IMPRESORA       ------------------------------------*/
function reactivarImpresora(seleccionado) {
    var table = $('#lista-impresora').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['imID'];
    swal({
            title: "Esta seguro que desea reactivar la impresora seleccionada?",
            text: "El estado de la impresora",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, reactivar la impresora!"        ,
            cancelButtonText: "No deseo reactivar la impresora",
            closeOnConfirm: false,
            closeOnCancel: false },
        function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: site_url+'impresora/reactivarImpresora',
                    data: 'id='+id,
                    type: 'post',
                    success: function(registro){
                        if (registro == 'error'){
                            swal("Error", "Problemas al reactivar", "error");
                        }else{
                            swal("Reactivado!", "La impresora ha sido reactivada.", "success");
                            $('#cerrar-impresora').click();
                            recargarTablaImpresora();
                        }
                    }
                });
            } else {
                swal("Cancelado", "Accion cancelada.", "error");
            }
        });
}
/*----------------------------------       FUNCION PARA ELIMINAR UNA IMPRESORA      ----------------------------------*/
function eliminarImpresora(seleccionado) {
    var table = $('#lista-impresora').DataTable();
    var celda = $(seleccionado).parent();
    var rowData = table.row(celda).data();
    var id = rowData['imID'];
    swal({
            title: "Esta seguro que desea eliminar la impresora seleccionada?",
            text: "El estado de la impresora",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, eliminar la impresora!"        ,
            cancelButtonText: "No deseo eliminar la impresora",
            closeOnConfirm: false,
            closeOnCancel: false },
        function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: site_url+'impresora/eliminarImpresora',
                    data: 'id='+id,
                    type: 'post',
                    success: function(registro){
                        if (registro == 'error'){
                            swal("Error", "Problemas al eliminar", "error");
                        }else{
                            swal("Eliminado!", "La impresora ha sido eliminada.", "success");
                            $('#cerrar-impresora').click();
                            recargarTablaImpresora();
                        }
                    }
                });
            } else {
                swal("Cancelado", "Accion cancelada.", "error");
            }
        });
}

/*----------------------------------       FUNCION PARA RECARGAR LA TABLA DEL ALMACEN       --------------------------*/
function recargarTablaActividad() {
    var tabla = $('#lista-actividad').DataTable();
    tabla.ajax.reload();
}
