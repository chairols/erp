<div class="innerContainer">
    <h4 class="subTitleB"><i class="fa fa-building"></i> Proveedor</h4>
    <div class="row form-group inline-form-custom">
        <div class="col-xs-12">
            <!-- Autocomplete Empresas -->
            <input type="text" id="TextAutoCompleteproveedor" name="TextAutoCompleteproveedor" placeholder="Proveedor" placeholderauto="Proveedor inexistente" class="form-control TextAutoComplete" value="" objectauto="proveedores" actionauto="gets_proveedores_ajax" varsauto="internacional:=Y" iconauto="ship">
            <input type="hidden" id="proveedor" name="proveedor" value="">
        </div>
    </div>
    <h4 class="subTitleB"><i class="fa fa-money"></i> Moneda</h4>
    <div class="row form-group inline-form-custom">
        <div class="col-xs-12">
            <select name="moneda" id="moneda" class="form-control chosenSelect">
                <?php foreach ($monedas as $moneda) { ?>
                    <option value="<?= $moneda['idmoneda'] ?>"><?= $moneda['moneda'] ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <h4 class="subTitleB"><i class="fa fa-calendar"></i> Fecha de Pedido</h4>
    <div class="row form-group inline-form-custom">
        <div class="col-xs-12">
            <input type="text" name="fecha" id="fecha" value="<?= date('d/m/Y') ?>" class="form-control datePicker" placeholder="Seleccione una fecha">
        </div>
    </div>
    <div class="row txC">
        <button type="button" id="agregar" class="btn btn-primary">
            <i class="fa fa-plus"></i> Crear Importación
        </button>
        <button type="button" id="loading" class="btn btn-primary" style="display: none;">
            <i class="fa fa-refresh fa-spin"></i>
        </button>
    </div>
</div>