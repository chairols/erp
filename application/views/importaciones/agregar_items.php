<div class="innerContainer">
    <form method="POST">
        <h4 class="subTitleB"><i class="fa fa-plane"></i> Proveedor</h4>
        <div class="row form-group inline-form-custom">
            <div class="col-xs-12">
                <!-- Autocomplete Empresas -->
                <input type="text" value="<?= $proveedor['empresa'] ?>" id="TextAutoCompleteempresa" name="TextAutoCompleteempresa" placeholder="Proveedor" placeholderauto="Proveedor inexistente" class="form-control TextAutoComplete" value="" validateEmpty="Seleccione un proveedor." objectauto="Empresas" actionauto="gets_empresas_ajax" varsauto="proveedor:=Y///internacional:=Y" iconauto="ship">
                <input type="hidden" id="empresa" name="empresa" value="<?= $importacion['idproveedor'] ?>">
            </div>
        </div>
        <h4 class="subTitleB"><i class="fa fa-money"></i> Moneda</h4>
        <div class="row form-group inline-form-custom">
            <div class="col-xs-12">
                <select name="moneda" class="form-control chosenSelect">
                    <?php foreach ($monedas as $moneda) { ?>
                        <option value="<?= $moneda['idmoneda'] ?>"<?= ($moneda['idmoneda'] == $importacion['idmoneda']) ? " selected" : "" ?>><?= $moneda['moneda'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <h4 class="subTitleB"><i class="fa fa-calendar"></i> Fecha de Pedido</h4>
        <div class="row form-group inline-form-custom">
            <div class="col-xs-12">
                <input type="text" value="<?= $importacion['fecha_pedido'] ?>" name="fecha_pedido" value="<?= date('d/m/Y') ?>" class="form-control datePicker" validateEmpty="Seleccione una Fecha" placeholder="Seleccione una fecha">
            </div>
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
                <input type="text" id="TextAutoCompletearticulo" name="TextAutoCompletearticulo" placeholder="Artículo" placeholderauto="Artículo inexistente" class="form-control TextAutoComplete" value="" validateEmpty="Seleccione un artículo." objectauto="articulos" actionauto="gets_articulos_ajax" varsauto="estado:=A" iconauto="cube" autofocus>
                <input type="hidden" id="articulo" name="idarticulo" value="">
            </div>
            <div class="col-xs-2 txC">
                <input type="text" name="cantidad" placeholder="Cantidad" id="cantidad" class="form-control" validateEmpty="Ingrese Cantidad" validateOnlyNumbers="El valor debe ser numérico entero">
            </div>
            <div class="col-xs-2 txC">
                <input type="text" name="costo_fob" placeholder="Costo FOB" id="costo_fob" class="form-control" validateEmpty="Ingrese Costo Fob" validateOnlyNumbers="El valor debe ser numérico">
            </div>
        </div>
        <div class="row txC">
            <button type="submit" class="btn btn-success btnGreen" id="BtnCreate"><i class="fa fa-plus"></i> Agregar Item</button>
        </div>
    </form>

    <h4 class="subTitleB">
        <i class="fa fa-list-ul"></i> Items Agregados
    </h4>
    <div class="row form-group inline-form-custom bg-brown">
        <div class="col-xs-4 txC">
            <strong>Artículo</strong>
        </div>
        <div class="col-xs-2 txC">
            <strong>Cantidad</strong>
        </div>
        <div class="col-xs-2 txC">
            <strong>Costo FOB</strong>
        </div>
        <div class="col-xs-2 txC">
            <strong>Subtotal</strong>
        </div>
        <div class="col-xs-2 txC">
            <strong>Acciones</strong>
        </div>
    </div>
    <hr style="margin-top:0px!important;margin-bottom:0px!important;">


    <?php $cantidad = 0; ?>
    <?php $total = 0; ?>
    <?php foreach ($items as $item) { ?>
        <?php $cantidad += $item['cantidad'] ?>
        <?php $total += ($item['cantidad'] * $item['costo_fob']) ?>
        <div class="row form-group inline-form-custom">
            <div class="col-xs-4 txC">
                <input type="text" value="<?= $item['articulo'] ?> - <?= $item['marca'] ?>" class="form-control" disabled="">
            </div>
            <div class="col-xs-2 txC">
                <input type="text" value="<?= $item['cantidad'] ?>" class="form-control txR" disabled="">
            </div> 
            <div class="col-xs-2 txC">
                <input type="text" value="<?= number_format($item['costo_fob'], 2) ?>" class="form-control txR" disabled="">
            </div> 
            <div class="col-xs-2 txC">
                <input type="text" value="<?= number_format($item['cantidad'] * $item['costo_fob'], 2) ?>" class="form-control txR" disabled="">
            </div>
            <div class="col-xs-2 txC">
                <a href="/importaciones/modificar_item/<?= $item['idimportacion_item'] ?>/" data-pacement="top" data-toggle="tooltip" data-original-title="Modificar <?= $item['articulo'] ?>" class="tooltips">
                    <button class="btn btn-primary btn-xs">
                        <i class="fa fa-edit"></i>
                    </button>
                </a>
                <button onclick="borrar_item('<?= $item['articulo'] ?>', '<?= $item['idimportacion_item'] ?>');" class="btn btn-danger btn-xs tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Eliminar <?= $item['articulo'] ?>">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
    <?php } ?>

    <div class="row form-group inline-form-custom bg-brown">
        <div class="col-xs-4 txC">
            <strong>Artículos Totales: <?= count($items) ?></strong>
        </div>
        <div class="col-xs-2 txC">
            <strong>Cantidad: <?= $cantidad ?></strong>
        </div>
        <div class="col-xs-2 txC">
            <strong>&nbsp;</strong>
        </div>
        <div class="col-xs-2 txC">
            <strong>Total: <?= number_format($total, 2) ?></strong>
        </div>
    </div>



</div>