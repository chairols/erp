<div class="box box-primary box-solid collapsed-box">
    <div class="box-header bg-light-blue-gradient">
        <input type="hidden" id="idpedido" value="<?= $pedido['idpedido'] ?>">
        <h3 class="box-title"><?= $pedido['cliente'] ?> - <?= $pedido['sucursal'] ?> - <?= $pedido['moneda']['moneda'] ?> - <?= $pedido['orden_de_compra'] ?></h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" style="margin-right: 5px;">
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="box-body no-padding">
        <br>
        <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-3">Cliente</label>
                <div class="col-md-6">
                    <input type="text" id="TextAutoCompletecliente" name="TextAutoCompletecliente" placeholder="Cliente" placeholderauto="Cliente Inexistente" class="form-control TextAutoComplete" value="<?= $pedido['cliente'] ?>" objectauto="clientes" actionauto="gets_clientes_ajax" iconauto="ship">
                    <input type="hidden" id="cliente" name="cliente" value="<?= $pedido['idcliente'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Sucursal</label>
                <div class="col-md-6" id="sucursal">
                    <select id="idcliente_sucursal" class="form-control chosenSelect">

                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Transporte</label>
                <div class="col-md-6" id="transporte">
                    <select id="idtransporte" class="form-control chosenSelect">

                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Condición de Venta</label>
                <div class="col-md-6" id="condicion">
                    <select id="idcondicion_de_venta" class="form-control chosenSelect" disabled="">

                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Comisiones</label>
                <div class="col-md-6">

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Imprime Despacho</label>
                <div class="col-md-6" id="despacho">
                    <select id="imprime_despacho" class="form-control chosenSelect">
                        <option value="S"<?= ($pedido['imprime_despacho'] == 'S') ? " selected" : "" ?>>SI</option>
                        <option value="N"<?= ($pedido['imprime_despacho'] == 'N') ? " selected" : "" ?>>NO</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Orden de Compra</label>
                <div class="col-md-6">
                    <input class="form-control" id="orden_de_compra" maxlength="50" value="<?= $pedido['orden_de_compra'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Moneda</label>
                <div class="col-md-6" id="monedas">
                    <select id="idmoneda" class="form-control chosenSelect">
                        <?php foreach ($monedas as $moneda) { ?>
                            <option value="<?= $moneda['idmoneda'] ?>"<?= ($moneda['idmoneda'] == $pedido['idmoneda']) ? " selected" : "" ?>><?= $moneda['moneda'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Dólar Oficial</label>
                <div class="col-md-6">
                    <input type="text" id="dolar_oficial" class="form-control inputMask" value="<?= $pedido['dolar_oficial'] ?>" data-inputmask="'mask': '9{1,2}.999999'">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Factor de Corrección</label>
                <div class="col-md-6">
                    <input type="text" id="factor_correccion" class="form-control inputMask" value="<?= $pedido['factor_correccion'] ?>" data-inputmask="'mask': '9{1,2}.99'">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Porcentaje de IVA</label>
                <div class="col-md-6">
                    <select id="idtipo_iva" class="form-control chosenSelect">
                        <?php foreach ($tipos_iva as $tipo_iva) { ?>
                            <option value="<?= $tipo_iva['idtipo_iva'] ?>"<?= ($tipo_iva['idtipo_iva'] == $pedido['idtipo_iva']) ? " selected" : "" ?>><?= $tipo_iva['porcentaje'] ?> %</option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Concepto a Facturar</label>
                <div class="col-md-6">

                </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="button" id="actualizar" class="btn btn-primary">Actualizar</button>
                    <button type="button" id="actualizar_loading" class="btn btn-primary" style="display: none;"><i class="fa fa-refresh fa-spin"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary box-solid">
    <div class="box-header bg-light-blue-gradient">
        <h3 class="box-title">Artículos</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" style="margin-right: 5px;">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body no-padding">
        <br>
        <div class="form-horizontal">
            <div class="col-lg-4 col-xs-12 text-center">
                <label class="control-label">Artículo</label>
            </div>
            <div class="col-lg-1 col-xs-12 text-center">
                <label class="control-label">Marca</label>
            </div>
            <div class="col-lg-1 col-xs-12 text-center">
                <label class="control-label">Almacén</label>
            </div>
            <div class="col-lg-1 col-xs-12 text-center">
                <label class="control-label">Cantidad</label>
            </div>
            <div class="col-lg-2 col-xs-12 text-center">
                <label class="control-label">Precio</label>
            </div>
            <div class="col-lg-2 col-xs-12 text-center">
                <label class="control-label">Fecha Entrega</label>
            </div>
            <div class="col-lg-4 col-xs-12">
                <input type="text" id="TextAutoCompletearticulo" name="TextAutoCompletearticulo" placeholder="Seleccionar Artículo" placeholderauto="Artículo inexistente" class="form-control input-sm TextAutoComplete" objectauto="articulos" actionauto="gets_articulos_ajax_stock_y_precio" varsauto="estado:=A" iconauto="ship" onkeyup="saltar(event, 'marca');" autofocus="">
                <input type="hidden" id="articulo" name="articulo" value="">
            </div>
            <div class="col-lg-1 col-xs-12">
                <select id="marca" class="form-control input-sm" onkeyup="saltar(event, 'almacen');">
                    <option value="S">SI</option>
                    <option value="N">NO</option>
                </select>
            </div>
            <div class="col-lg-1 col-xs-12">
                <input type="text" id="almacen" class="form-control input-sm inputMask" onkeyup="saltar(event, 'cantidad');" data-inputmask="'mask' : '9{1,1}'">
            </div>
            <div class="col-md-1 col-xs-12">
                <input type="text" id="cantidad" class="form-control input-sm inputMask" data-inputmask="'mask': '9{1,8}'" onkeyup="saltar(event, 'precio');">
            </div>
            <div class="col-md-2 col-xs-12">
                <input type="text" id="precio" class="form-control input-sm inputMask" data-inputmask="'mask': '9{1,17}.99'" onkeyup="saltar(event, 'agregar');">
            </div>
            <div class="col-md-2 col-xs-12">
                <input type="text" id="fecha_entrega" value="<?= date("d/m/Y", strtotime("+".$dias_entrega['valor_sistema']." day")) ?>" class="form-control input-sm datePicker" placeholder="Seleccione una fecha">
            </div>
            <div class="col-md-1 col-xs-12">
                <button type="button" id="agregar" class="btn btn-sm btn-primary">Agregar</button>
                <button type="button" id="agregar_loading" class="btn btn-sm btn-primary" style="display: none;">
                    <i class="fa fa-refresh fa-spin"></i>
                </button>
            </div>
        </div>
        <br><br><br><br>
        <div id="articulos">
            
        </div>
        <div id="articulos_loading" class="text-center" style="display: none;">
            <h2>
                <i class="fa fa-refresh fa-spin"></i>
            </h2>
        </div>
    </div>
</div>
