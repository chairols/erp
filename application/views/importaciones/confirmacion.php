<div class="innerContainer">
    <form method="POST" confirmacion="¿Desea confirmar el pedido?">
        <h4 class="subTitleB"><i class="fa fa-building"></i> Proveedor</h4>
        <div class="row form-group inline-form-custom">
            <div class="col-xs-12">
                <select name="idproveedor" id="idproveedor" class="form-control chosenSelect" validateEmpty="Seleccione un proveedor">
                    <?php foreach($proveedores as $proveedor) { ?>
                    <option value="<?=$proveedor['idproveedor']?>"><?=$proveedor['empresa']?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <h4 class="subTitleB"><i class="fa fa-calendar"></i> Fecha de Confirmación</h4>
        <div class="row form-group inline-form-custom">
            <div class="col-xs-12">
                <input type="text" id="fecha_confirmacion" name="fecha_confirmacion" value="<?=date('d/m/Y')?>" class="form-control datePicker" validateEmpty="Seleccione una Fecha" placeholder="Seleccione una fecha">
            </div>
        </div>
        <div class="row txC">
            <button type="submit" class="btn btn-success btnGreen" confirmacion="¿Desea crear la Importación?" id="BtnCreate"><i class="fa fa-plus"></i> Crear Importación</button>
        </div>
    </form>
</div>