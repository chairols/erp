<div class="box box-primary">
    <div class="box-header">
        <input type="hidden" id="idproveedor" value="<?=$idproveedor?>">
        <input type="hidden" id="idmoneda" value="<?=$idmoneda?>">
        <div class="col-xs-12">
            <?php if (count($preorden)) { ?>
                <h2 class="text-center"><?= $preorden[0]['proveedor'] ?></h2>
            <?php } ?>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-striped table-responsive">
            <thead>
                <tr>
                    <th class="text-right">Cantidad</th>
                    <th class="text-right">Stock Disponible</th>
                    <th class="text-right">Artículo</th>
                    <th class="text-right">Marca</th>
                    <th class="text-right">Precio Unitario</th>
                    <th class="text-right">Precio Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($preorden as $p) { ?>
                <?php if($p['cantidad'] > 0) { ?>
                <tr class="text-right">
                    <td class="pull-right">
                        <input type="text" idpreorden="<?=$p['idpre_orden']?>" class="form-control text-right cantidad" id="cantidad-<?=$p['idpre_orden']?>" value="<?=$p['cantidad']?>">
                    </td>
                    <td><?=$p['stock']?></td>
                    <td><?=$p['articulo']?></td>
                    <td><?=$p['marca']?></td>
                    <td>
                        <input type="text" class="form-control text-right" id="precio-<?=$p['idpre_orden']?>" value="<?=number_format($p['precio'], 2)?>" disabled="">
                    </td>
                    <td>
                        <input type="text" class="form-control text-right" id="total-<?=$p['idpre_orden']?>" value="<?= number_format($p['cantidad']*$p['precio'], 2)?>" disabled>
                        <div class="form-control" id="total-loading-<?=$p['idpre_orden']?>" style="display: none;" disabled>
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </td>
                </tr>
                <?php } ?>
                <?php } ?>
            </tbody>
        </table>
        <div class="row">
            <div class="col-xs-12">
                <h3 class="text-right">Total Pre-Orden</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h3 class="pull-right" id="total"><?=number_format($total['total'], 2);?></h3>
            </div>
        </div>
        <div class="row text-center">
            <button type="button" id="generar_orden" class="btn btn-success">
                Generar Orden
            </button>
            <button type="button" id="generar_orden_loading" class="btn btn-success" style="display: none;">
                <i class="fa fa-spin fa-refresh"></i>
            </button>
        </div>
    </div>
</div>