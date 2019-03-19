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
                    curl https://erp.rollerservice.com.ar/migrar/actualizar_articulos/ARTICULO.TXT (ideal para evitar timeout)
                    Eliminar cabeceras del archivo TXT
                </strong>
            </div>
            <div class="col-xs-2" id="boton-3">
                <button class="btn btn-xs btn-primary" onclick="procesar(3, '/importar/actualizar_articulos/ARTICULO.TXT');">
                    <i class="fa fa-database"></i> Comenzar >>
                </button>
            </div>
            <div class="col-xs-2" id="resultado-3">

            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-8">
                <strong>Actualizar tabla <label class="label label-success">comprobantes_notas_varias_items</label> mediante TXT de Sistema anterior. <br>
                    php index.php importar agregar_comprobantes_notas_varias_items ITEM-NOT.TXT <br>
                    curl https://erp.rollerservice.com.ar/importar/agregar_comprobantes_notas_varias_items/ITEM-NOT.TXT (ideal para evitar timeout) <br>
                    Eliminar cabeceras del archivo TXT
                </strong>
            </div>
            <div class="col-xs-2" id="boton-4">
                <button class="btn btn-xs btn-primary" onclick="procesar(4, '/importar/agregar_comprobantes_notas_varias_items/ITEM-NOT.TXT');">
                    <i class="fa fa-database"></i> Comenzar >>
                </button>
            </div>
            <div class="col-xs-2" id="resultado-4">

            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-8">
                <strong>Actualizar tabla <label class="label label-success">comprobantes</label> mediante TXT de Sistema anterior. <br>
                    php index.php importar migrar_comprobantes FACTURAS.TXT <br>
                    curl https://erp.rollerservice.com.ar/importar/migrar_comprobantes/FACTURAS.TXT <br>
                    Eliminar cabeceras del archivo TXT
                </strong>
            </div>
            <div class="col-xs-2" id="boton-5">
                <button class="btn btn-xs btn-primary" onclick="procesar(5, '/importar/migrar_comprobantes/FACTURAS.TXT')">
                    <i class="fa fa-database"></i> Comenzar >>
                </button>
            </div>
            <div class="col-xs-2" id="resultado-5">

            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-8">
                <strong>Actualiza las tablas <label class="label label-success">clientes</label> <label class="label label-success">clientes_sucursales</label> y <label class="label label-success">clientes_agentes</label> mediante archivo CLIENTES.TXT de Sistema anterior.<br>
                php index.php importar clientes CLIENTES.TXT <br>
                Se ejecuta desde acá, no es necesario eliminar cabeceras, descarta las 2 primeras líneas por default. (totalmente transparente).<br>
                Hace truncate a clientes, clientes_sucursales y clientes_agentes
                
                </strong>
            </div>
            <div class="col-xs-2" id="boton-6">
                <button class="btn btn-xs btn-primary" onclick="procesar(6, '/importar/clientes/CLIENTES.TXT');">
                    <i class="fa fa-database"></i> Comenzar >>
                </button>
            </div>
            <div class="col-xs-2" id="resultado-6">
                
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-8">
                <strong>Actualiza la tabla <label class="label label-success">proveedores</label> mediante archivo PROVEDOR.TXT de Sistema anterior.<br>
                    php index.php importar proveedores PROVEDOR.TXT<br>
                    Se ejecuta desde acá, no es necesario eliminar cabeceras, descarta las 2 primeras líneas por default. (totalmente transparente)<br>
                    No hace truncate, solamente agrega los proveedores donde no existe el ID.
                </strong>
            </div>
            <div class="col-xs-2" id="boton-7">
                <button class="btn btn-xs btn-primary" onclick="procesar(7, '/importar/proveedores/PROVEDOR.TXT');">
                    <i class="fa fa-database"></i> Comenzar >>
                </button>
            </div>
            <div class="col-xs-2" id="resultado-7">
                
            </div>
        </div>
    </div>
</div>

