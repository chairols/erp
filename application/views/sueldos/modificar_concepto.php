<div class="box box-primary">
    <div class="box-header">

    </div>
    <div class="box-body">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-3">Número de Concepto</label>
                <div class="col-md-6">
                    <input type="text" id="idsueldo_concepto" class="form-control inputMask" data-inputmask="'mask' : '9{1,4}'" value="<?=$sueldo_concepto['idsueldo_concepto']?>" disabled="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Concepto</label>
                <div class="col-md-6">
                    <input type="text" id="sueldo_concepto" class="form-control" maxlength="255" value="<?=$sueldo_concepto['sueldo_concepto']?>" autofocus="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Tipo</label>
                <div class="col-md-6">
                    <select class="form-control chosenSelect" id="tipo">
                        <option value="R"<?=($sueldo_concepto['tipo']=='R')?" selected":""?>>Remunerativo</option>
                        <option value="N"<?=($sueldo_concepto['tipo']=='N')?" selected":""?>>No Remunerativo</option>
                        <option value="D"<?=($sueldo_concepto['tipo']=='D')?" selected":""?>>Descuento</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Cantidad</label>
                <div class="col-md-6">
                    <input type="text" id="cantidad" class="form-control inputMask" data-inputmask="'mask' : '9{1,2}.99'" value="<?=$sueldo_concepto['cantidad']?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Unidad</label>
                <div class="col-md-6">
                    <select class="form-control chosenSelect" id="unidad">
                        <option value="un"<?=($sueldo_concepto['unidad']=='un')?" selected":""?>>Unidad</option>
                        <option value="%"<?=($sueldo_concepto['unidad']=='%')?" selected":""?>>Porcentaje</option>
                    </select>
                </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="button" id="modificar" class="btn btn-primary">Modificar</button>
                    <button type="button" id="modificar_loading" class="btn btn-primary" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>