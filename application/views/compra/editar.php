<?php
/**
 * Created by PhpStorm.
 * User: Ariel
 * Date: 20/09/2017
 * Time: 07:28 PM
 */
?>
<section class="content">
    <div class="row">
        <form id="frm_editar_compra" class="form-horizontal" role="form" method="post" action="javascript: agregar_detalle_compra(<?= isset($compra) ? 'frm_editar_compra' : '' ?>);">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h2 class="box-title">EDITA TU COMPRA SELECCIONADA</h2>
                    </div>
                    <div class="form-horizontal">
                        <?php $this->load->view('compra/formulario') ?>
        </form>
</section>
<script type="text/javascript" src="<?= base_url('js-sistema/compra.js') ?>"></script>
