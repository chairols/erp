<div class="innerContainer main_form">
    <form method="POST" confirmacion="¿Desea crear el embarque?">
        <h4 class="subTitleB"><i class="fa fa-ship"></i> Proveedor</h4>
        <div class="row form-group inline-form-custom">
            <div class="col-xs-12">
                <select name="proveedor" id="proveedor" class="form-control chosenSelect" validateEmpty="Debe seleccionar un proveedor">
                    <?php foreach($empresas as $empresa) { ?>
                    <option value="<?=$empresa['idproveedor']?>"><?=$empresa['empresa']?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <h4 class="subTitleB"><i class="fa fa-calendar"></i> Fecha de Confirmación</h4>
        <div class="row form-group inline-form-custom">
            <div class="col-xs-12">
                <input type="text" id="fecha_pedido" name="fecha_pedido" value="<?=date('d/m/Y')?>" class="form-control datePicker" validateEmpty="Seleccione una Fecha" placeholder="Seleccione una fecha">
            </div>
        </div>
        <div class="row txC">
            <button type="submit" class="btn btn-success btnGreen" confirmacion="¿Desea crear la Importación?" id="BtnCreate"><i class="fa fa-plus"></i> Crear Embarque</button>
        </div>
    </form>
</div>
