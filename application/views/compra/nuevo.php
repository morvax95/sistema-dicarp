<?php
/**
 * Created by PhpStorm.
 * User: Ariel
 * Date: 19/09/2017
 * Time: 12:31 PM
 */
?>
<section class="content">
    <div class="row">
        <form id="frm_registro_compra" class="form-horizontal" role="form" method="post" action="javascript: agregar_detalle_compra(<?= isset($compra) ? '' : 'frm_registro_compra' ?>);">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h2 class="box-title">REGISTRA TUS COMPRAS</h2>
                    </div>
                    <div class="form-horizontal">
                    <?php $this->load->view('compra/formulario') ?>
        </form>
</section>
<script type="text/javascript" src="<?= base_url('js-sistema/compra.js') ?>"></script>