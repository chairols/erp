<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Seleccionar tabla a migrar</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-xs-8">
                <strong>Migrar <label class="label label-warning">product</label> a <label class="label label-success">articulos</label> (debe existir la tabla product, pero no necesariamente la tabla articulos)</strong>
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
                <strong>Migrar <label class="label label-warning">product_abstract</label> a <label class="label label-success">articulos_genericos</label> (debe existir la tabla product_abstract, pero no necesariamente la tabla articulos_genericos)</strong>
            </div>
            <div class="col-xs-2" id="boton-2">
                <button class="btn btn-xs btn-primary" onclick="procesar(2, '/importar/migrar_product_abstract_articulos_genericos/');">
                    <i class="fa fa-database"></i> Comenzar >>
                </button>
            </div>
            <div class="col-xs-2" id="resultado-2">

            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-8">
                <strong>Actualizar tabla <label class="label label-success">articulos</label> mediante TXT de Sistema anterior. <br>
                    php index.php migrar actualizar_articulos ARTICULO.TXT <br>
                    curl https://erp.rollerservice.com.ar/migrar/actualizar_articulos/ARCHIVO.TXT (ideal para evitar timeout)
                    Eliminar cabeceras del archivo TXT
                </strong>
            </div>
            <div class="col-xs-2" id="boton-3">
                <label class="label label-warning">Debe ejecutarse por consola</label>
            </div>
            <div class="col-xs-2" id="resultado-3">

            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-8">
                <strong>Actualizar tabla <label class="label label-success">comprobantes_notas_varias_items</label> mediante TXT de Sistema anterior. <br>
                    php index.php migrar agregar_comprobantes_notas_varias_items ITEM-NOT.TXT <br>
                    curl https://erp.rollerservice.com.ar/migrar/agregar_comprobantes_notas_varias_items/ITEM-NOT.TXT (ideal para evitar timeout) <br>
                    Eliminar cabeceras del archivo TXT
                </strong>
            </div>
            <div class="col-xs-2" id="boton-3">
                <label class="label label-warning">Debe ejecutarse por consola</label>
            </div>
            <div class="col-xs-2" id="resultado-4">

            </div>
        </div>
    </div>
</div>