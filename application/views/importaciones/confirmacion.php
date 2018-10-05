<div class="innerContainer">
    <h4 class="subTitleB"><i class="fa fa-building"></i> Proveedor</h4>
    <div class="row form-group inline-form-custom">
        <div class="col-xs-12">
            <select name="idproveedor" id="idproveedor" class="form-control chosenSelect">
                <?php foreach ($proveedores as $proveedor) { ?>
                    <option value="<?= $proveedor['idproveedor'] ?>"><?= $proveedor['proveedor'] ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <h4 class="subTitleB"><i class="fa fa-calendar"></i> Fecha de Confirmación</h4>
    <div class="row form-group inline-form-custom">
        <div class="col-xs-12">
            <input type="text" id="fecha_confirmacion" name="fecha_confirmacion" value="<?= date('d/m/Y') ?>" class="form-control datePicker" placeholder="Seleccione una fecha">
        </div>
    </div>
    <div class="row txC">
        <button type="button" class="btn btn-primary" id="confirmar">Crear Confirmación</button>
        <button type="button" class="btn btn-primary" id="confirmar_loading" style="display: none;">
            <i class="fa fa-refresh fa-spin"></i>
        </button>
    </div>
</div>