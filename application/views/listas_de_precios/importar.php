<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="fa fa-hdd-o"></i> Importar Lista de Precios
        </h3>
        <div class="box-tools pull-right">
            <a class="btn btn-sm btn-primary btn-flat" href="/upload/plantillas/plantilla_importacion.xls">
                <i class="fa fa-download"></i> Descargar Plantilla de Importación
            </a>
        </div>
    </div>
    <form method="POST" enctype="multipart/form-data">
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12 col-sm-5 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                    <input type="text" id="TextAutoCompleteproveedor" name="TextAutoCompleteproveedor" placeholder="Seleccionar Proveedor" placeholderauto="Proveedor inexistente" class="form-control TextAutoComplete" value="" validateEmpty="Seleccione un proveedor." objectauto="proveedores" actionauto="gets_proveedores_ajax" varsauto="" iconauto="ship">
                    <input type="hidden" id="proveedor" name="proveedor" value="">
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-12 col-sm-5 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                    <input type="text" id="TextAutoCompletemarca" name="TextAutoCompletemarca" placeholder="Seleccionar Marca" placeholderauto="Proveedor inexistente" class="form-control TextAutoComplete" objectauto="marcas" actionauto="gets_marcas_ajax" iconauto="ship">
                    <input type="hidden" id="marca" name="marca" value="">
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-12 col-sm-5 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                    <input type="text" id="fecha" name="fecha" class="form-control datePicker" validateEmpty="Seleccione una Fecha" placeholder="Seleccione una fecha">
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-12 col-sm-5 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                    <select name="moneda" id="moneda" class="form-control chosenSelect">
                        <?php foreach($monedas as $moneda) { ?>
                        <option value="<?=$moneda['idmoneda']?>"><?=$moneda['moneda']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <hr>
            <div class="row form-group">
                <div class="col-xs-12 col-sm-5 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                    <input id="archivo" readonly="readonly" name="archivo" placeholder="Seleccionar Archivo" validateEmpty="Seleccione un Archivo" type="file">
                </div>
            </div>
            <hr>
            <div class="row form-group">
                <div class="col-xs-12 col-sm-5 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                    <textarea id="comentarios" class="form-control" name="comentarios" placeholder="Notas y comentarios"></textarea>
                </div>
            </div>
        </div>
        <div class="box-footer txC">
            <button class="btn btn-sm btn-success" type="submit">
                Continuar <i class="fa fa-arrow-right"></i>
            </button>
        </div>
    </form>
</div>