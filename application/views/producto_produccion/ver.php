<?php
/**
 * Created by PhpStorm.
 * User: Juan
 * Date: 12/04/2018
 * Time: 06:30 PM
 */
?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h2 class="box-title"><i class="fa fa-database"></i> DATOS DEL INGRESO DE PRODUCTOS EN PRODUCCIÓN
                    </h2>
                    <div style="float:right">
                        <a href="<?= site_url('producto_produccion/index') ?>" class="btn btn-danger"><i
                                    class="fa fa-arrow-left"></i>&nbsp; Volver</a>
                    </div>
                </div>
                <div class="form-horizontal">
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="form-group" style="margin-bottom: 0%">
                                <div class="col-md-3">
                                    <label class="control-label"><b>Nro. Ingreso</b></label>
                                    <input type="text" id="n_ingreso" name="n_ingreso" class="form-control"
                                           value="<?= $ingreso->id ?>" readonly/>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label"><b>Fecha Ingreso</b></label>
                                    <input type="date" class="form-control"
                                           value="<?= $ingreso->fechar ?>" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label"><b>Observación</b></label>
                                    <textarea class="form-control" readonly
                                              placeholder="Escriba alguna observacion en caso de que hubiera"><?= $ingreso->observacion ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label class="control-label"><b>Almacen</b></label>
                                    <input class="form-control" value="<?= $ingreso->almacen ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label"><b>Sucursal</b></label>
                                    <input class="form-control" value="<?= $ingreso->sucursal ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table table-responsive">
                                    <table id="lista_productos_produccion" class="table table-bordered">
                                        <thead>
                                        <!--<th style="width: 20%" class="text-center">Codigo Producto</th>-->
                                        <th style="width: 20%" class="text-center">Nombre Producto</th>
                                        <th style="width: 15%" class="text-center">Cantidad</th>
                                        <th style="width: 15%" class="text-center">Estado</th>
                                        <th style="width: 10%" class="text-center">Opciones</th>

                                        </thead>
                                        <tbody>
                                        <?php
                                        $contador1 = 0;
                                        foreach ($detalle as $row) {
                                            ?>
                                            <tr>
                                                <td hidden><input type="number" step="any"
                                                                  value="<?= $row->id_producto ?>"
                                                                  id="codigo_producto" name="codigo_producto[]"/>
                                                </td>

                                                <td class="text-center">
                                                    <?= $row->nombre_item ?>
                                                </td>

                                                <td class="text-center">
                                                    <?= $row->cantidad_produccion ?>
                                                </td>

                                                <td class="text-center">
                                                    <?php

                                                    $val1 = "";
                                                    if ($row->estado_producto == 2) {
                                                        $val1 = '<option  value="2">Producción</option>;
                                                        <option  value="3">Concluido</option>';
                                                    } else {
                                                        $val1 = '<option  value="3">Concluido</option>
                                                        <option  value="2">Producción</option>';

                                                    }
                                                    ?>
                                                    <?= 'PRODUCCIÓN' ?>
                                                </td>


                                                <td class="text-center">
                                                    <a onclick="modificar_estado_producto( <?= $row->id_producto ?>);"
                                                       class="btn btn-success  "><i
                                                                class="fa fa-upload"></i> MODIFICAR</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <!--<a onclick="modificar_estado_producto( <?= $ingreso->id ?>);"
                                       class="btn btn-success  "><i
                                                class="fa fa-upload"></i> MODIFICAR</a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>
<script type="text/javascript" src="<?= base_url('js-sistema/producto_produccion.js') ?>"></script>
