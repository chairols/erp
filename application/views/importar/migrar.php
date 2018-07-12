<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Seleccionar tabla a migrar</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-xs-8">
                <strong>Migrar product a articulos (debe existir la tabla product, pero no necesariamente la tabla articulos)</strong>
            </div>
            <div class="col-xs-2" id="boton-1">
                <button class="btn btn-xs btn-primary" onclick="procesar(1, '/importar/migrar_product_articulos/');">
                    <i class="fa fa-database"></i> Comenzar >>
                </button>
            </div>
            <div class="col-xs-2" id="resultado-1">

            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-8">
                <strong>Migrar product_abstract a articulos_genericos (debe existir la tabla product_abstract, pero no necesariamente la tabla articulos_genericos)</strong>
            </div>
            <div class="col-xs-2" id="boton-2">
                <button class="btn btn-xs btn-primary" onclick="procesar(2, '/importar/migrar_product_abstract_articulos_genericos/');">
                    <i class="fa fa-database"></i> Comenzar >>
                </button>
            </div>
            <div class="col-xs-2" id="resultado-2">

            </div>
        </div>
    </div>
</div>