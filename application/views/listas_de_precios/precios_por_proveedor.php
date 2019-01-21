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
                </tr>
            </thead>
            <tbody>
                <?php if(isset($items)) { ?>
                    <?php foreach($items as $item) { ?>
                <tr>
                    <td><?=$item['articulo']?></td>
                    <td><?=$item['marca']?></td>
                    <td><?=$item['stock']?></td>
                    <td><?=$item['minimo_precio']?></td>
                </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
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
    