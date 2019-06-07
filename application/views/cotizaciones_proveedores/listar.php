<div class="box">
    <div class="box-header">
        <form method="GET" action="/cotizaciones_proveedores/listar/" class="input-group input-group-sm col-md-5">
            <input class="form-control pull-left" name="articulo" id="articulo" placeholder="Buscar ..." type="text" value="<?= $this->input->get('articulo') ?>">
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>
        <div class="box-tools">
            <ul class="pagination pagination-sm no-margin pull-right">
                <?= $links ?>
            </ul>
        </div>
    </div>
    <div class="box-body no-padding">
        <?php foreach ($cotizaciones as $cotizacion) { ?>
            <div class="row listRow listRow2 txC">
                <div class="col-lg-4 col-md-5 col-sm-5 col-xs-3">
                    <div class="listRowInner">
                        <span class="listTextStrong"><?=$cotizacion['proveedor']['proveedor']?></span>
                        <span class="smallTitle">(ID: <?=$cotizacion['idproveedor']?>)</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-2 col-sm-2 col-xs-3">
                    <div class="listRowInner">
                        <span class="smallTitle">Total</span>
                        <span class="listTextStrong">
                            <?php $total = 0; ?>
                            <?php foreach($cotizacion['items'] as $item) {
                                $total += ($item['cantidad'] * $item['precio']);
                            } ?>
                            <span class="label label-brown"><?=$cotizacion['moneda']['simbolo']?> <?=number_Format($total, 2)?></span>
                        </span>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                    <div class="listRowInner">
                        <span class="smallTitle">Fecha Cotización</span>
                        <span class="listTextStrong">
                            <span class="label label-info"><?=$cotizacion['fecha_formateada']?></span>
                        </span>
                    </div>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 hideMobile990"></div>
                <div class="animated DetailedInformation col-md-12">
                    <div class="list-margin-top">
                        <?php foreach($cotizacion['items'] as $item) { ?>
                        <div class="row bg-gray" style="padding: 5px">
                            <div class="col-lg-4 col-sm-5 col-xs-12">
                                <div class="listRowInner">
                                    <span class="listTextStrong"><?=$item['articulo']['articulo']?></span>
                                    <span class="smallTitle"><?=$item['articulo']['linea']['linea']?> (<?=$item['articulo']['marca']['marca']?>)</span>
                                </div>
                            </div>
                            <div class="col-sm-2 col-xs-12">
                                <div class="listRowInner">
                                    <span class="smallTitle">Precio</span>
                                    <span class="listTextStrong">
                                        <span class="label label-brown"><?=$cotizacion['moneda']['simbolo']?> <?=$item['precio']?></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-2 col-xs-12">
                                <div class="listRowInner">
                                    <span class="smallTitle">Precio en Dólares</span>
                                    <span class="listTextStrong">
                                        <span class="label label-success">U$S <?=number_format($item['precio']/$cotizacion['cotizacion_dolar']['valor']*$cotizacion['cotizacion_moneda']['valor'], 2)?></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-1 col-xs-12">
                                <div class="listRowInner">
                                    <span class="smallTitle">Cantidad</span>
                                    <span class="listTextStrong">
                                        <span class="label bg-navy"><?=$item['cantidad']?></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-2 col-xs-12">
                                <div class="listRowInner">
                                    <span class="smallTitle">Fecha Entrega</span>
                                    <span class="listTextStrong">
                                        <span class="label bg-blue-gradient"><?=$item['fecha_formateada']?></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="listActions flex-justify-center">
                    <div>
                        <span class="roundItemActionsGroup">
                            <a class="hint--top hint--bounce hint--info" href="/cotizaciones_proveedores/modificar/<?=$cotizacion['idcotizacion_proveedor']?>/" aria-label="Modificar">
                                <button class="btn btn-primary" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="box-footer clearfix">
        <div class="pull-left">
            <strong>Total <?= $total_rows ?> registros.</strong>
        </div>
        <div class="box-tools">
            <ul class="pagination pagination-sm no-margin pull-right">
                <?= $links ?>
            </ul>
        </div>
    </div>
</div>