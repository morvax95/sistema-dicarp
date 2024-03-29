<?php
/**
 * Created by PhpStorm.
 * User: Ariel
 * Date: 17/03/2017
 * Time: 17:17 PM
 */
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-user fa-2x"></i> <b>LISTA DE USUARIOS</b></h3>
                    <div style="float:right">
                        <a href="<?= site_url('usuario/nuevo') ?>" class="btn btn-success"><i class="fa fa-plus"></i>
                            Nuevo
                            usuario</a>
                    </div>
                </div>
                    <div class="box-body">
                        <table id="lista_usuario" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="text-center"><b>ID</b></th>
                                <th class="text-center"><b>CI</b></th>
                                <th class="text-center"><b>NOMBRE</b></th>
                                <th class="text-center"><b>CARGO</b></th>
                                <th class="text-center"><b>TELÉFONO</b></th>
                                <th class="text-center"><b>USUARIO</b></th>
                                <th class="text-center"><b>ESTADO</b></th>
                                <th class="text-center"><b>OPCIONES</b></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</section>
<script src="<?= base_url('js-sistema/usuario.js') ?>"></script>
