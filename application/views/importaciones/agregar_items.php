<div class="innerContainer">

    <input type="hidden" id="idimportacion" value="<?=$importacion['idimportacion']?>">
    <h4 class="subTitleB"><i class="fa fa-plane"></i> Proveedor</h4>
    <div class="row form-group inline-form-custom">
        <div class="col-xs-12">
            <!-- Autocomplete Empresas -->
            <input type="text" value="<?= $proveedor['proveedor'] ?>" id="TextAutoCompleteproveedor" name="TextAutoCompleteproveedor" placeholder="Proveedor" placeholderauto="Proveedor inexistente" class="form-control TextAutoComplete" objectauto="proveedores" actionauto="gets_proveedores_ajax" varsauto="internacional:=Y" iconauto="ship">
            <input type="hidden" id="proveedor" name="proveedor" value="<?= $importacion['idproveedor'] ?>">
        </div>
    </div>
    <h4 class="subTitleB"><i class="fa fa-money"></i> Moneda</h4>
    <div class="row form-group inline-form-custom">
        <div class="col-xs-12">
            <select id="moneda" class="form-control chosenSelect">
                <?php foreach ($monedas as $moneda) { ?>
                    <option value="<?= $moneda['idmoneda'] ?>"<?= ($moneda['idmoneda'] == $importacion['idmoneda']) ? " selected" : "" ?>><?= $moneda['moneda'] ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <h4 class="subTitleB"><i class="fa fa-calendar"></i> Fecha de Pedido</h4>
    <div class="row form-group inline-form-custom">
        <div class="col-xs-12">
            <input type="text" value="<?= $importacion['fecha_pedido'] ?>" id="fecha_pedido" value="<?= date('d/m/Y') ?>" class="form-control datePicker" placeholder="Seleccione una fecha">
        </div>
    </div>
    <div class="row txC">
        <button type="button" id="actualizar" class="btn btn-primary">Actualizar Datos</button>
        <button type="button" id="actualizar_loading" class="btn btn-primary" style="display: none;"><i class="fa fa-refresh fa-spin"></i></button>
    </div>

    <h4 class="subTitleB">
        <i class="fa fa-cubes"></i> Artículos
    </h4>
    <div class="row form-group inline-form-custom bg-brown">
        <div class="col-xs-8 txC">
            <strong>Artículo</strong>
        </div>
        <div class="col-xs-2 txC">
            <strong>Cantidad</strong>
        </div>
        <div class="col-xs-2 txC">
            <strong>Costo FOB</strong>
        </div>
    </div>
    <hr style="margin-top:0px!important;margin-bottom:0px!important;">

    <div class="row form-group inline-form-custom">
        <div class="col-xs-8 txC">
            <input type="text" id="TextAutoCompletearticulo" name="TextAutoCompletearticulo" placeholder="Artículo" placeholderauto="Artículo inexistente" class="form-control input-sm TextAutoComplete" value="" validateEmpty="Seleccione un artículo." objectauto="articulos" actionauto="gets_articulos_ajax" varsauto="estado:=A" iconauto="cube" autofocus>
            <input type="hidden" id="articulo" name="idarticulo" value="">
        </div>
        <div class="col-xs-2 txC">
            <input type="text" id="cantidad" placeholder="Cantidad" class="form-control input-sm inputMask" data-inputmask="'mask': '9{1,11}'">
        </div>
        <div class="col-xs-2 txC">
            <input type="text" id="costo_fob" placeholder="Costo FOB" class="form-control input-sm inputMask" data-inputmask="'mask': '[-]9{1,17}.99'">
        </div>
    </div>
    <div class="row txC">
        <button type="button" class="btn btn-primary" id="agregar_item">Agregar Item</button>
        <button type="button" class="btn btn-primary" id="agregar_item_loading" style="display: none;">
            <i class="fa fa-refresh fa-spin"></i>
        </button>
    </div>

    <h4 class="subTitleB">
        <i class="fa fa-list-ul"></i> Items Agregados
    </h4>
    
    <div id="items">
        
    </div>
</div>