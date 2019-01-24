<div class="box">
    <div class="box-header">
        <form method="GET" class="input-group input-group-sm col-md-5">
            <select name="idproveedor" id="idproveedor" class="form-control chosenSelect">
                <?php foreach($proveedores as $proveedor) { ?>
                <option value="<?=$proveedor['idproveedor']?>"<?=($this->input->get('idproveedor')==$proveedor['idproveedor'])?" selected":""?>><?=$proveedor['proveedor']?></option>
                <?php } ?>
            </select>
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
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Artículo</th>
                    <th>Marca</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Otros Precios</th>
                    <th>Ordenar</th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($items)) { ?>
                    <?php foreach($items as $item) { ?>
                <tr>
                    <td><?=$item['articulo']?></td>
                    <td><?=$item['marca']?></td>
                    <td><?=$item['stock']?></td>
                    <td>
                        <span class="label label-success">
                            <?=$item['minimo_precio']?>
                        </span>
                    </td>
                    <td>
                        <?php foreach($item['items'] as $i) { ?>
                        <span class="label label-danger hint--top hint--bounce hint--error" aria-label="<?=$i['proveedor']?> - <?=$i['articulo']?> - <?=$i['marca']?>">
                            <?=$i['precio']?>
                        </span>
                        <?php } ?>
                    </td>
                    <td>
                        <input type="text" class="form-control text-center cantidad_pedida" value="<?=(isset($item['cantidad_preorden']['cantidad']))?$item['cantidad_preorden']['cantidad']:''?>" iditem="<?=$item['idlista_de_precios_comparacion_item']?>">
                    </td>
                </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <pre>
        <?php print_r($items); ?>
    </pre>
    <div class="box-footer clearfix">
        <div class="pull-left">
            <strong>Total <?=(isset($total_rows))?$total_rows:"0"?> registros.</strong>
        </div>
        <div class="box-tools">
            <ul class="pagination pagination-sm no-margin pull-right">
<?= $links ?>
            </ul>
        </div>
    </div>
</div>
    