<div class="innerContainer">
    <h4 class="subTitleB"><i class="fa fa-building"></i> Proveedor</h4>
    <div class="row form-group inline-form-custom">
        <div class="col-xs-12">
            <!-- Autocomplete Empresas -->
            <input type="text" id="TextAutoCompleteproveedor" name="TextAutoCompleteproveedor" placeholder="Proveedor" placeholderauto="Proveedor inexistente" class="form-control TextAutoComplete" value="" objectauto="proveedores" actionauto="gets_proveedores_ajax" iconauto="ship">
            <input type="hidden" id="proveedor" name="proveedor" value="">
        </div>
    </div>
    <h4 class="subTitleB"><i class="fa fa-map-signs"></i> Jurisdicción</h4>
    <div class="row form-group inline-form-custom">
        <div class="col-xs-12">
            <select id="idjurisdiccion" class="form-control chosenSelect">
                <?php foreach ($jurisdicciones as $jurisdiccion) { ?>
                    <option value="<?= $jurisdiccion['idjurisdiccion_afip'] ?>"><?= $jurisdiccion['idjurisdiccion_afip'] ?> - <?= $jurisdiccion['provincia'] ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <h4 class="subTitleB"><i class="fa fa-calendar"></i> Fecha</h4>
    <div class="row form-group inline-form-custom">
        <div class="col-xs-12">
            <input type="text" id="fecha" value="<?= date('d/m/Y') ?>" class="form-control datePicker" placeholder="Seleccione una fecha">
        </div>
    </div>
    <div id="div-boton-agregar" class="row txC">
        <button type="submit" class="btn btn-success btnGreen" id="agregar">Crear Retención</button>
    </div>
    <div id="div-boton-loading" class="row txC" style="display: none;">
        <button type="button" class="btn btn-success btnGreen" id="loading">
            <i class="fa fa-refresh fa-spin"></i>
        </button>
    </div>
</div>
