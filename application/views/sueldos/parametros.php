<div class="box box-primary box-solid">
    <div class="box-header">

    </div>
    <div class="box-body">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-3">Valor Comida</label>
                <div class="col-md-3">
                    <input type="text" id="comida" class="form-control inputMask" data-inputmask="'mask' : '9{1,4}.99'" value="<?=$comida['valor']?>" autofocus="">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" value="<?=$comida['idsueldo_parametro']?>" disabled="">
                </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="button" id="actualizar" class="btn btn-primary">Actualizar</button>
                    <button type="button" id="actualizar_loading" class="btn btn-primary" style="display: none;"><i class="fa fa-refresh fa-spin"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>