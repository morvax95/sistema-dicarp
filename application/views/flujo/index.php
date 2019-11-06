<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-files-o fa-2x"></i> <b>CONSULTA EGRESOS</b></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="nav-tabs-custom">
                        <div class="tab-content">
                            <!--FLUJO DE CAJA DETALLADO -->
                            <form class="form-horizontal">
                                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-5">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4 col-md-4" for="fecha-inicio-detalle">Fecha
                                            inicio:</label>
                                        <div class="col-lg-8 col-md-8">
                                            <input type="date" class="form-control" id="fecha-inicio-detalle"
                                                   name="fecha-inicio-detalle" value="<?= $fecha_inicio ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-4 col-md-4" for="fecha-fin-detalle">Fecha
                                            fin:</label>
                                        <div class="col-lg-8 col-md-8">
                                            <input type="date" class="form-control" id="fecha-fin-detalle"
                                                   name="fecha-fin-detalle" value="<?= $fecha_actual ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-7">
                                    <a id="buscar-datos-detalle">
                                        <img src="<?= base_url('assets/img/buscar.png') ?>" title="Buscar">
                                    </a>
                                    <a onclick="imprimir_flujo_caja_detallado" target="_blank" hidden>
                                        <img src="<?= base_url('assets/img/pdf.png') ?>" title="Exportar a PDF">
                                    </a>
                                    <a class="btn btn-warning btn-sm" onclick="imprimir_flujo_caja_detallado()"
                                       href="" target="_blank"
                                       title="Exportacion a archivo PDF">
                                        <i class="fa fa-file-pdf-o"></i> PDF
                                    </a class="btn">
                                    <a onclick="exportar_excel_detallado()" target="_blank" hidden>
                                        <img src="<?= base_url('assets/img/excel.png') ?>" title="Exportar a EXCEL">
                                    </a>
                                </div>
                            </form>
                            <div id="div-tabla">
                                <table class="table table-bordered table-hover" style="margin-bottom: 3px">

                                    <tr>
                                        <td style="vertical-align:middle;">E G R E S O S</td>
                                        <td>
                                            <?php
                                            $lista_egreso = $egreso['lista_egresos'];
                                            foreach ($lista_egreso as $row_egreso):?>
                                                <table class="table table-bordered table-hover"
                                                       style="margin-bottom: 3px">
                                                    <tr>
                                                        <td style="width: 30%;vertical-align:middle;"><?= $row_egreso['descripcion'] ?></td>
                                                        <td>
                                                            <table class="table table-bordered table-hover"
                                                                   style="margin-bottom: 3px">
                                                                <tr>
                                                                    <td style="background-color:#c0c0c0;color:#ffffff">
                                                                        Fecha
                                                                    </td>
                                                                    <td style="background-color:#c0c0c0;color:#ffffff">
                                                                        Usuario
                                                                    </td>
                                                                    <td style="background-color:#c0c0c0;color:#ffffff">
                                                                        Concepto
                                                                    </td>
                                                                    <td style="background-color:#c0c0c0;color:#ffffff">
                                                                        Monto
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $lista = $row_egreso['lista'];
                                                                $monto_egreso = 0;
                                                                foreach ($lista as $row):
                                                                    ?>
                                                                    <tr>
                                                                        <td><?= $row->fecha_registro ?></td>
                                                                        <td><?= $row->nombre_usuario ?></td>
                                                                        <td><?= $row->detalle ?></td>
                                                                        <td style="text-align: right"><?= $row->monto ?></td>
                                                                    </tr>
                                                                    <?php $monto_egreso = $monto_egreso + $row->monto; endforeach; ?>
                                                                <tr>
                                                                    <td colspan="2" style="text-align: right"> Monto
                                                                        total
                                                                    </td>
                                                                    <td style="text-align: right"><?= number_format($monto_egreso, 2) ?></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            <?php endforeach; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="<?= base_url('js-sistema/flujo.js') ?>"></script>