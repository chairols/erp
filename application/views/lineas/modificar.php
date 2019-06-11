<div class="box box-primary box-solid">
    <div class="box-header">
        <input type="hidden" id="idlinea" value="<?=$linea['idlinea']?>">
        <h3 class="box-title"><?=$title?></h3>
    </div>

    <div class="box-body">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-3">Línea</label>
                <div class="col-md-6">
                    <input type="text" maxlength="100" class="form-control" id="linea" placeholder="RODAMIENTO" value="<?=$linea['linea']?>" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Nombre Corto</label>
                <div class="col-md-6">
                    <input type="text" maxlength="25" class="form-control" id="nombre_corto" placeholder="ROD" value="<?=$linea['nombre_corto']?>">
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
