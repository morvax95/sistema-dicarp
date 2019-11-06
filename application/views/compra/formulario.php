<?php
/**
 * Created by PhpStorm.
 * User: Ariel
 * Date: 19/09/2017
 * Time: 03:37 PM
 */
?>
<div class="box-body">
    <div class="form-group">
        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><b>Fecha Compra *</b></label>
        <div class="col-lg-4 col-md-4 col-xs-12">
            <input type="date" id="fecha_compra" name="fecha_compra" class="form-control"
                   value="<?= isset($compra) ? $compra->fecha_compra : date('Y-m-d') ?>"/>
            <input type="text" id="id_compra" name="id_compra" value="<?= isset($compra) ? $compra->id : '' ?>" hidden/>
        </div>
        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><b>Proveedor *</b></label>
        <div class="col-lg-4 col-md-4 col-xs-12">
            <select id="proveedor" name="proveedor" class="form-control">
                <?php
                foreach ($proveedores as $row) {
                    ?>
                    <option value="<?= $row->id ?>" <?= isset($compra) ? is_selected($compra->proveedor_id, $row->id) : '' ?>><?= $row->nombre ?></option>
                    <?php
                }
                ?>
            </select>
            <!--  @todo Falta un link de registro rapido de proveedor  -->
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><b>Factura/Recibo</b></label>
        <div class="col-lg-4 col-md-4 col-xs-12">
            <input type="text" id="nro_fiscal" name="nro_fiscal" class="form-control"
                   value="<?= isset($compra) ? $compra->nro_fiscal : '' ?>"
                   title="Ingrese numero de factura, recibo o comprobante de compra"
                   placeholder="Ingrese Nro. de factura, recibo o comprobante de compra"/>
        </div>
        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><b>Tipo Egreso</b></label>
        <div class="col-lg-4 col-md-4 col-xs-12">
            <select id="egreso_compra" name="egreso_compra" class="form-control">
                <?php
                foreach ($tipo_egreso as $row) {
                    ?>
                    <option value="<?= $row->id ?>" <?= isset($compra) ? is_selected($compra->tipo_egreso_id, $row->id) : '' ?>><?= $row->descripcion ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><b>Observacion</b></label>
        <div class="col-lg-10 col-md-10 col-xs-12">
            <textarea id="observacion" name="observacion" class="form-control"
                      placeholder="Escriba alguna observacion en caso de que hubiera" required><?= isset($compra) ? $compra->observacion : '' ?></textarea>
        </div>
    </div>
    <hr>
    <div class="col-xs-12 table-responsive no-padding">
        <table id="lista_detalle_compra" class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center" style="width: 50%"><b>Producto</b></th>
                <th class="text-center" style="width: 20%"><b>Cantidad</b></th>
                <th class="text-center" style="width: 15%"><b>Precio Bs.</b></th>
                <th class="text-center" style="width: 15%"><b>SubTotal Bs.</b></th>
                <th class="text-center"><b>Opcion</b></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (isset($detalle)) {
                $contador = 0;
                $cont = count($detalle);
                foreach ($detalle as $row) {
                    $contador++;
                    $subtotal = round($row->cantidad * $row->precio_compra);
                    ?>
                    <tr>
                        <td><input type="text" value="<?= $row->id ?>" id="producto_id" name="producto_id[]" hidden/><?= $row->nombre_item ?></td>
                        <td><input type="text" value="<?= $row->cantidad ?>" id="cantidad<?= $contador ?>" name="cantidad[]" onkeyup="modificar_detalle(<?= $contador ?>)" onclick="modificar_detalle(<?= $contador ?>)" style="width: 55%; padding: 1.4%;text-align: right"/>
                            <select id="unidad_seleccionada" name="unidad_seleccionada[]" style="width: 40%; padding: 1%; float: right;">
                                <?= get_combo_unidad($row->unidad_id) ?>
                            </select>
                        </td>
                        <td class="text-right"><input type="number" step="any" value="<?= $row->precio_compra ?>" id="precio<?= $contador ?>" name="precio[]" hidden/><?= $row->precio_compra ?></td>
                        <td class="text-right"><input type="text" value="<?= $subtotal ?>" id="monto<?= $contador ?>" name="monto[]" size="4" style="text-align: right" hidden/><?= $subtotal ?></td>
                        <td class="text-center"><a title="Borra esta fila" onclick="eliminar_detalle(<?= $contador ?>)" class="elimina"><i class="fa fa-trash-o fa-2x"></i></a></td>
                    </tr>
                    <?php
                }
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <td>
                    <input id="detalle_compra" name="detalle_compra" type="text" style="width: 100%; padding: 1%"
                           placeholder="Escriba el nombre del producto"/>
                    <input type="text" id="contador_compra" name="contador_compra" value="<?= isset($detalle) ? count($detalle) : '' ?>" hidden/>
                    <!--CONTADOR DE FILAS DE LA TABLA -->
                    <input type="text" id="id_producto_seleccionado" name="id_producto_seleccionado" hidden/>
                    <!--CODIGO DE PRODUCTO-->
                </td>
                <td>
                    <input type="number" id="cantidad_compra" name="cantidad_compra"
                           style="width: 55%; padding: 1.4%;text-align: right"/>
                    <select id="unidad" name="unidad" style="width: 40%; padding: 1.4%; float: right;">
                        <?php
                        foreach ($unidades as $row) {
                            ?>
                            <option value="<?= $row->id ?>"><?= $row->abreviatura ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <input type="number" step="any" id="precio_compra" name="precio_compra"
                           style="text-align: right"/>
                </td>
                <td></td>
                <td>
                    <button type="submit" id="agregar_compra" name="agregar_compra" class="btn btn-primary">
                        <i class="fa fa-plus-square"></i>
                        Agregar
                    </button>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
</div>
</div>
</div>
<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <div class="box box-success">
        <div class="box-body">
            <label class="control-label" style="font-size: 14pt"><b>SUBTOTAL Bs.</b></label>
            <input style="font-size: 18pt;" type="number" step="any" id="subtotal_compra" name="subtotal_compra"
                   class="form-control" value="<?= isset($compra) ? $compra->subtotal : '0.00' ?>" readonly/>
            <label class="control-label" style="font-size: 14pt"><b>DESCUENTO Bs.</b></label>
            <input style="font-size: 18pt;" type="number" step="any" id="descuento_compra"
                   name="descuento_compra"
                   class="form-control" value="<?= isset($compra) ? $compra->descuento : '0.00' ?>"/>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-dollar"></i></span>
        <div class="info-box-content">
            <span class="info-box-text" style="font-size: 14pt"><b>TOTAL</b></span>
            <span class="info-box-number">
                        <input readonly style="border:0px; font-size: 18pt; background-color: transparent" type="number"
                               step="any" id="total_compra" name="total_compra"
                               class="form-control"
                               value="<?= isset($compra) ? $compra->monto_total : '0.00' ?>"/></span>
        </div>
    </div>
    <div class="box box-success">
        <div class="box-body">
            <?php
            if (isset($compra)) {
                ?>
                <a type="submit" id="btn_editar_compra" name="btn_editar_compra" class="btn btn-block btn-warning"><i
                            class="fa fa-save"></i> Guardar Datos
                </a>
                <?php
            } else {
                ?>
                <a type="submit" id="btn_registrar_compra" name="btn_registrar_compra"
                   class="btn btn-block btn-success"><i class="fa fa-save"></i> Guardar Datos
                </a>
                <?php
            }
            ?>
            <a href="<?= site_url('compra/index') ?>" class="btn btn-block btn-danger"><i class="fa fa-times"></i> Salir</a>
        </div>
    </div>
</div>
