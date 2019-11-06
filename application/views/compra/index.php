<?php
/**
 * Created by PhpStorm.
 * User: Ariel
 * Date: 19/09/2017
 * Time: 11:51 AM
 */
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-address-book-o fa-2x"></i> <b>LISTADO DE TUS COMPRAS</b></h3>
                    <div style="float:right">
                        <a href="<?= site_url('compra/nuevo') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Nueva Compra</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="lista_compra" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th style="width: 15%" class="text-center">Fecha Compra</th>
                            <th style="width: 25%" class="text-center">Observacion</th>
                            <th style="width: 15%" class="text-center">Proveedor</th>
                            <th style="width: 15%" class="text-center">Sucursal</th>
                            <th style="width: 10%" class="text-center">Total</th>
                            <th style="width: 10%" class="text-center">Estado</th>
                            <th style="width: 15%" class="text-center">Opciones</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</section>
<script src="<?= base_url('js-sistema/compra.js') ?>"></script>
