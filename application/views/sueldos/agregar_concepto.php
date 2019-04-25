<div class="box box-primary">
    <div class="box-header">

    </div>
    <div class="box-body">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-3">Número de Concepto</label>
                <div class="col-md-6">
                    <input type="text" id="idsueldo_concepto" class="form-control inputMask" data-inputmask="'mask' : '9{1,4}'" autofocus="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Concepto</label>
                <div class="col-md-6">
                    <input type="text" id="sueldo_concepto" class="form-control" maxlength="255">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Tipo</label>
                <div class="col-md-6">
                    <select class="form-control chosenSelect" id="tipo">
                        <option value="R">Remunerativo</option>
                        <option value="N">No Remunerativo</option>
                        <option value="D">Descuento</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Cantidad</label>
                <div class="col-md-6">
                    <input type="text" id="cantidad" class="form-control inputMask" data-inputmask="'mask' : '9{1,2}.99'">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Unidad</label>
                <div class="col-md-6">
                    <select class="form-control chosenSelect" id="unidad">
                        <option value="un">Unidad</option>
                        <option value="%">Porcentaje</option>
                    </select>
                </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="button" id="agregar" class="btn btn-primary">Agregar</button>
                    <button type="button" id="agregar_loading" class="btn btn-primary" style="display: none;"><i class="fa fa-refresh fa-spin"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>