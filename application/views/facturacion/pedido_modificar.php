<div class="box box-primary box-solid collapsed-box">
    <div class="box-header">
        <input type="hidden" id="idcliente" value="<?=$comprobante['idcliente']?>">
        <h3 class="box-title"><?=$comprobante['cliente']?> - <?=$comprobante['orden_de_compra']?> - <?=$comprobante['moneda']['moneda']?></h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-3">Cliente</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" value="<?=$comprobante['cliente']?>" disabled="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Sucursal</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" value="<?=$comprobante['sucursal']?>" disabled="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Pedido</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" value="<?=$comprobante['idpedido']?>" disabled="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Orden de Compra</label>
                <div class="col-md-6">
                    <input type="text" maxlength="50" class="form-control" value="<?=$comprobante['orden_de_compra']?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Condición de Venta</label>
                <div class="col-md-6">
                    <select class="form-control chosenSelect">
                        <?php foreach($condiciones as $condicion) { ?>
                        <option value="<?=$condicion['idcondicion_de_venta']?>"<?=($condicion['idcondicion_de_venta']==$comprobante['idcondicion_de_venta'])?" selected":""?>><?=$condicion['condicion_de_venta']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Transporte</label>
                <div class="col-md-6">
                    <select class="form-control chosenSelect">
                        <?php foreach($transportes as $transporte) { ?>
                        <option value="<?=$transporte['idtransporte']?>"<?=($transporte['idtransporte']==$comprobante['idtransporte'])?" selected":""?>><?=$transporte['transporte']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Imprime Despacho</label>
                <div class="col-md-6">
                    <select class="form-control chosenSelect">
                        <option value="S"<?=($comprobante['imprime_despacho']=='S')?" selected":""?>>SI</option>
                        <option value="N"<?=($comprobante['imprime_despacho']=='N')?" selected":""?>>NO</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Moneda</label>
                <div class="col-md-6">
                    <select class="form-control chosenSelect">
                        <?php foreach($monedas as $moneda) { ?>
                        <option value="<?=$moneda['idmoneda']?>"<?=($moneda['idmoneda']==$comprobante['idmoneda'])?" selected":""?>><?=$moneda['moneda']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Cotización Dolar</label>
                <div class="col-md-6">
                    <input type="text" id="dolar_oficial" class="form-control inputMask" value="<?=$dolar['valor']?>" data-inputmask="'mask': '9{1,2}.999999'">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Factor de Corrección</label>
                <div class="col-md-6">
                    <input type="text" id="factor_correccion" class="form-control inputMask" value="<?=$parametro['factor_correccion']?>" data-inputmask="'mask': '9{1,2}.99'">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Porcentaje de IVA</label>
                <div class="col-md-6">
                    <select id="idtipo_iva" class="form-control chosenSelect">
                        <?php foreach($tipos_iva as $tipo_iva) { ?>
                        <option value="<?=$tipo_iva['idtipo_iva']?>"<?=($tipo_iva['idtipo_iva']==$comprobante['idtipo_iva'])?" selected":""?>><?=$tipo_iva['porcentaje']?> %</option>
                        <?php } ?>
                    </select>
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
    <div class="box-header">
        <h3 class="box-title">Artículos</h3>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-hover table-striped table-responsive">
            <thead>
                <tr>
                    <th>Artículo</th>
                    <th>Marca</th>
                    <th>Imprime Marca</th>
                    <th>Almacén</th>
                    <th>Cantidad Total</th>
                    <th>Cantidad Pendiente</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($comprobante['items'] as $item) { ?>
                <tr>
                    <td><?=$item['articulo']?></td>
                    <td><?=$item['marca']?></td>
                    <td><?=$item['muestra_marca']?></td>
                    <td><?=$item['almacen']?></td>
                    <td><?=$item['cantidad']?></td>
                    <td>
                        <input type="text" id="cantidad_pendiente_<?=$item['idpedido_item']?>" idpedido_item="<?=$item['idpedido_item']?>" class="form-control inputMask cantidad_pendiente" value="<?=$item['cantidad_pendiente']?>" data-inputmask="'mask': '9{1,10}'">
                    </td>
                    <td>
                        <input type="text" id="precio_<?=$item['idpedido_item']?>" idpedido_item="<?=$item['idpedido_item']?>" class="form-control inputMask precio" value="<?=$item['precio']?>" data-inputmask="'mask': '9{1,16}.99'">
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="text-center">
            <button type="button" id="facturar" class="btn btn-primary">Facturar</button>
        </div>
    </div>
</div>