<input type="hidden" id="idmoneda" value="<?=$moneda['idmoneda']?>">


    <div class="box">
        <div class="box-header">

        </div>

        <div class="box-body no-padding">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-md-3">Moneda</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="100" class="form-control" id="moneda" value="<?=$moneda['moneda']?>" placeholder="Euro" autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Símbolo</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="10" class="form-control" id="simbolo" value="<?=$moneda['simbolo']?>" placeholder="€">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Código AFIP</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="3" class="form-control" id="codigo_afip" value="<?=$moneda['codigo_afip']?>" placeholder="060">
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="button" id="actualizar" class="btn btn-success">Actualizar</button>
                        <button type="reset" class="btn btn-primary">Limpiar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
