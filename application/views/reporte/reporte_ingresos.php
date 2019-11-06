<?php

$data_user = $this->session->userdata('usuario_sesion');
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-files-o fa-2x"></i> <b>REPORTE DE INGRESOS</b>
                    </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="panel panel-default">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <form id="datos_busqueda">
                                            <?php
                                            if ($data_user['cargo'] == 1) {
                                                ?>

                                                <div class="col-md-2" hidden>
                                                    <label class="control-label"><b>Producto</b></label>
                                                    <select id="sucursales" name="sucursales" class="form-control">
                                                        <?php
                                                        foreach ($producto as $row) {
                                                            ?>
                                                            <option value="<?= $row->id ?>"><?= $row->nombre_item ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                            <div class="col-md-2">
                                                <label class="control-label"><b>Fecha desde</b></label>
                                                <input type="date" class="form-control" id="fecha_inicio"
                                                       name="fecha_inicio" value="<?= $fecha_inicio ?>">

                                            </div>
                                            <div class="col-md-2">
                                                <label class="control-label"><b>Fecha Hasta</b></label>
                                                <input type="date" class="form-control" id="fecha_fin"
                                                       name="fecha_fin" value="<?= $fecha_actual ?>">

                                            </div>
                                        </form>
                                        <div class="col-md-1" style="width: 8%" hidden>
                                            <button class="btn btn-danger btn-sm" onclick="buscarIngresos();"
                                                    title="Busqueda de los datos"><i
                                                        class="fa fa-search"></i> Buscar
                                            </button>
                                        </div>
                                        <div class="col-md-1" style="width: 7%" hidden>
                                            <a class="btn btn-success btn-sm" onclick="exportar_excel_ventas_emitidas()"
                                               title="Exportacion a archivo excel">
                                                <i class="fa fa-file-excel-o"></i> Excel
                                            </a class="btn">
                                        </div>
                                        <div class="col-md-1">
                                            <a class="btn btn-warning btn-sm" onclick="imprimir_ingresos()"
                                               href="" target="_blank"
                                               title="Exportacion a archivo PDF">
                                                <i class="fa fa-file-pdf-o"></i> PDF
                                            </a class="btn">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default" hidden>
                        <div class="panel-body">
                            <table class="table table-bordered" id="lista_reporte_ventas">
                                <thead>
                                <th class="text-center" style="width: 3%">NRO</th>
                                <th class="text-center" style="width: 36%">INGRESO</th>
                                <th class="text-center" style="width: 16%">FORMA</th>
                                <th class="text-center" style="width: 15%">EGRESO</th>
                                <th class="text-center" style="width: 20%">TOTAL</th>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="<?= base_url('js-sistema/reporte.js') ?>"></script>
