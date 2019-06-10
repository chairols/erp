<div class="box box-primary box-solid">
    <div class="box-header bg-light-blue-gradient">
        <input type="hidden" id="idmarca" value="<?=$marca['idmarca']?>">
        <h3 class="box-title"><?= $title ?></h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" style="margin-right: 5px;">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body no-padding">
        <br>
        <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-3">Marca</label>
                <div class="col-md-6">
                    <input type="text" id="marca" placeholder="Marca" class="form-control" value="<?=$marca['marca']?>" autofocus="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Nombre Corto</label>
                <div class="col-md-6">
                    <input type="text" id="nombre_corto" placeholder="Nombre Corto" class="form-control" value="<?=$marca['nombre_corto']?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Color de Fondo</label>
                <div class="col-md-6">
                    <div class="input-group my-colorpicker">
                        <input type="text" id="color_fondo" class="form-control" value="<?=$marca['color_fondo']?>">
                        <div class="input-group-addon">
                            <i></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Color de Letra</label>
                <div class="col-md-6">
                    <div class="input-group my-colorpicker">
                        <input type="text" id="color_letra" class="form-control" value="<?=$marca['color_letra']?>">
                        <div class="input-group-addon">
                            <i></i>
                        </div>
                    </div>
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