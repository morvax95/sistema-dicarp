<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 16/02/2018
 * Time: 11:02 AM
 */
?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-address-book-o fa-2x"></i> <b>GESTIÓN DE EMPRESA</b>
                    </h3>
                    <div style="float:right">
                        <!-- <a href="<?= site_url('sucursal/nuevo') ?>" class="btn btn-success "><i
                                    class="fa fa-plus"></i>
                            Nuevo cliente</a>-->

                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <table class="table table-bordered table-striped" id="lista_sucursal">
                        <thead>
                        <tr>
                            <th class="">ID</th>
                            <th class="">NOMBRE</th>
                            <th class="">DIRECCIÓN</th>
                            <th class="">TELÉFONO</th>
                            <th class="">EMAIL</th>
                            <th class="">SUCURSAL</th>
                            <th class="">ESTADO</th>
                            <th class="">OPCIONES</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->

            </div>
        </div>
        <center>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3799.2430496558623!2d-63.19539788525913!3d-17.780270787844387!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x93f1e7c9af4af877%3A0x5a91b1289321bd3e!2sDICARP+Colchones+y+Complementos!5e0!3m2!1ses-419!2sbo!4v1539179652258"
                    width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
        </center>
    </div>

</section>
<div id="modal_ver_cliente" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="panel-heading cabecera_frm bg-primary" style="color: white"><b> DATOS DE LA
                            EMPRESA</b>
                    </h4></center>
            </div>
            <form id="frm_ver_cliente" class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b>NOMBRE</b></label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="ver_nombre" name="ver_nombre" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b>TELEFONO</b></label>
                        <div class="col-md-7">
                            <input type="text" id="ver_telefono" name="ver_telefono" class="form-control" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label text-right"><b>DIRECCION</b></label>
                        <div class="col-md-7">
                            <input type="text" id="ver_direccion" name="ver_direccion" class="form-control" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="direc_cliente" class="col-sm-3 control-label">EMAIL</label>

                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="ver_email" name="ver_email" readonly>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <a id="btn_cerrar-_modal_ver" class="btn btn-danger" data-dismiss="modal"><i
                                class="fa fa-times"></i> Cerrar
                    </a>
                </div>
            </form>
        </div>
    </div>
    <style>
        label {
            color: black;
        }
    </style>
</div>

<script src="<?= base_url('js-sistema/sucursal.js') ?>"></script>
