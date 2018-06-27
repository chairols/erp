<div class="innerContainer">
    <form method="POST">
        <h4 class="subTitleB"><i class="fa fa-plane"></i> Proveedor</h4>
        <div class="row form-group inline-form-custom">
            <div class="col-xs-12">
                <!-- Autocomplete Empresas -->
                <input type="text" id="TextAutoCompleteempresa" name="TextAutoCompleteempresa" placeholder="Proveedor" placeholderauto="Proveedor inexistente" class="form-control TextAutoComplete" value="" validateEmpty="Seleccione un proveedor." objectauto="Empresas" actionauto="gets_empresas_ajax" varsauto="proveedor:=Y" iconauto="ship">
                <input type="hidden" id="empresa" name="empresa" value="">
            </div>
        </div>
        <h4 class="subTitleB"><i class="fa fa-calendar"></i> Fecha de Pedido</h4>
        <div class="row form-group inline-form-custom">
            <div class="col-xs-12">
                <input type="text" name="fecha_pedido" value="<?=date('d/m/Y')?>" class="form-control datePicker" validateEmpty="Seleccione una Fecha" placeholder="Seleccione una fecha">
            </div>
        </div>
        <div class="row txC">
            <button type="submit" class="btn btn-success btnGreen" confirmacion="¿Desea crear la Importación?" id="BtnCreate"><i class="fa fa-plus"></i> Crear Cotizaci&oacute;n</button>
        </div>
    </form>
</div>