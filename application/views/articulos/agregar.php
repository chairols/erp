<div class="box box-primary box-solid">
    <div class="box-header">
        <h3 class="box-title"><?=$title?></h3>
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
                <label class="control-label col-md-3">Artículo</label>
                <div class="col-md-6">
                    <input type="text" id="articulo" class="form-control" maxlength="255" onkeyup="saltar(event, 'idmarca');" autofocus="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Marca</label>
                <div class="col-md-6">
                    <select id="idmarca" class="form-control chosenSelect" onkeyup="saltar(event, 'numero_orden');">
                        <?php foreach($marcas as $marca) { ?>
                        <option value="<?=$marca['idmarca']?>"><?=$marca['marca']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Número de Orden</label>
                <div class="col-md-6">
                    <input type="text" id="numero_orden" class="form-control" onkeyup="saltar(event, 'idlinea');">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Línea</label>
                <div class="col-md-6">
                    <select id="idlinea" class="form-control chosenSelect">
                        <?php foreach($lineas as $linea) { ?>
                        <option value="<?=$linea['idlinea']?>"><?=$linea['linea']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Despacho Aduana</label>
                <div class="col-md-6">
                    <input type="text" id="despacho" class="form-control" maxlength="255" onkeyup="saltar(event, 'precio');">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Precio de Venta</label>
                <div class="col-md-6">
                    <input type="text" id="precio" class="form-control inputMask" data-inputmask="'mask': '9{1,10}.99'" onkeyup="saltar(event, 'stock');">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Stock</label> 
                <div class="col-md-6">
                    <input type="text" id="stock" class="form-control inputMask" data-inputmask="'mask': '9{1,10}'" onkeyup="saltar(event, 'stock_min');">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Stock Mínimo y Máximo</label>
                <div class="col-md-3">
                    <input type="text" id="stock_min" class="form-control inputMask" data-inputmask="'mask': '9{1,10}'" onkeyup="saltar(event, 'stock_max');">
                </div>
                <div class="col-md-3">
                    <input type="text" id="stock_max" class="form-control inputMask" data-inputmask="'mask': '9{1,10}'" onkeyup="saltar(event, 'costo_fob');">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Costo FOB y Despachado</label>
                <div class="col-md-3">
                    <input type="text" id="costo_fob" class="form-control inputMask" data-inputmask="'mask': '9{1,10}.99'" onkeyup="saltar(event, 'costo_despachado');">
                </div>
                <div class="col-md-3">
                    <input type="text" id="costo_despachado" class="form-control inputMask" data-inputmask="'mask': '9{1,10}.99'" onkeyup="saltar(event, 'rack');">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Estantería</label>
                <div class="col-md-6">
                    <input type="text" id="rack" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Observaciones</label>
                <div class="col-md-6">
                    <textarea id="observaciones" class="form-control"></textarea>
                </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="button" id="agregar" class="btn btn-primary">Agregar</button>
                    <button type="button" id="agregar_loading" class="btn btn-primary" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>