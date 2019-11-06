<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 15/02/2018
 * Time: 01:05 AM
 */
?>
<div class="box-body">
    <div class="form-group">


        <label class="col-sm-3 control-label">Cedula de Identidad/Nit </label>
        <div class="col-sm-8">
            <input type="text" id="id_cliente" name="id_cliente" value="<?= isset($cliente) ? $cliente->id : '' ?>"
                   hidden>
            <input type="number" class="form-control" id="ci_nit" name="ci_nit"
                   value="<?= isset($cliente) ? $cliente->ci_nit : '' ?>"
                   placeholder="Escriba en nro de carnet o NIT">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Nombre Completo *</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente"
                   value="<?= isset($cliente) ? $cliente->nombre_cliente : '' ?>"
                   placeholder="Escriba el nombre completo">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Número Telefono *</label>
        <div class="col-sm-8">
            <input type="number" class="form-control" id="telefono" name="telefono"
                   value="<?= isset($cliente) ? $cliente->telefono : '' ?>"
                   placeholder="Escriba el nro de telefono o celular">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Correo Electronico</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="correo" name="correo"
                   value="<?= isset($cliente) ? $cliente->correo : '' ?>"
                   placeholder="Ingrese un correo electronico">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Direccion Domicilio</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="direccion" name="direccion"
                   value="<?= isset($cliente) ? $cliente->direccion : '' ?>"
                   placeholder="Ingrese la direccion actual de su domicilio">
        </div>
    </div>


    <div class="form-group">
        <label class="col-sm-3 control-label">Lugar de Trabajo</label>

        <div class="col-sm-8">
            <input type="text" class="form-control" id="trabajo" name="trabajo"
                   value="<?= isset($cliente) ? $cliente->trabajo : '' ?>" placeholder="Escriba el lugar de trabajo">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Nombre Contacto</label>

        <div class="col-sm-8">
            <input type="text" class="form-control" id="nombre_contacto" name="nombre_contacto"
                   value="<?= isset($cliente) ? $cliente->nombre_contacto : '' ?>"
                   placeholder="Escriba el nombre de referencia de alguna persona">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Numero Contacto</label>

        <div class="col-sm-8">
            <input type="text" class="form-control" id="numero_contacto" name="numero_contacto"
                   value="<?= isset($cliente) ? $cliente->numero_contacto : '' ?>"
                   placeholder="Escriba el numero de celular de referencia de alguna persona">
        </div>
    </div>


    <div class="col-lg-offset-1 col-lg-10">
        <div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-info"></i> Aviso!</h4>
            Los campos con (*) son requidos.
        </div>
    </div>
</div>
<div class="box-footer text-center">
    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Guardar</button>
    <a href="<?= site_url('cliente/index') ?>" class="btn btn-danger"><i class="fa fa-times"></i>
        Salir</a>
</div>
