<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 06/03/2018
 * Time: 12:17 PM
 */
$usuario_sesion = $this->session->userdata('usuario_sesion');
$cargo = $usuario_sesion['cargo'];
?>
<section class="content">
    <div class="row">
        <div class=" col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-print fa-2x"></i> <b>CONSULTAR VENTAS ANULADAS</b></h3>
                </div>
                <!-- /.box-header -->

                <div class="box-body">

                    <div class="col-lg-12">
                        <div class="alert alert-success alert-dismissible">
                            <h4><i class="icon fa fa-info"></i> Aviso!</h4>
                            <i class="fa fa-info"></i>&nbsp; Los datos que se listan a continuación son registros de
                            la sucursal con la que inicio sesión.
                        </div>
                    </div>

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab">Ventas</a></li>
                        </ul>
                        <?php

                        if ($cargo == '1') {
                            ?>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1" style="padding: 1%">
                                    <table class="table table-bordered table-striped" id="lista_nota_adm">
                                        <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">NRO. NOTA</th>
                                            <th class="text-center">CLIENTE</th>
                                            <th class="text-center">FECHA</th>
                                            <th class="text-center">MONTO TOTAL</th>
                                            <th class="text-center">FORMA PAGO</th>
                                            <th class="text-center">ESTADO</th>

                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="alert alert-success alert-dismissible">
                                <h4><i class="icon fa fa-info"></i> Aviso!</h4>
                                <i class="fa fa-info"></i>&nbsp; USTED NO TIENE ACCESO A ESTA PARTE DEL SISTEMA.
                            </div>

                            <?php
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="<?= base_url('js-sistema/consultar_venta_anulada.js') ?>"></script>