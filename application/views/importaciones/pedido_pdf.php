<style>
    @import url(/assets/template/css/bootstrap.min.css);
    @import url(/assets/vendors/font-awesome-4.7.0/css/font-awesome.min.css);
    @import url(/assets/template/css/AdminLTE.css);
    
</style>
<div style="font-size: smaller">
    <strong>Pedido de Importacion N° <?=str_pad($importacion['idimportacion'], 8, '0', STR_PAD_LEFT)?></strong>
    
    <br>
    <hr>
    <strong>Proveedor</strong>
    <hr>
    <strong><?=$proveedor['proveedor']?></strong><br>
    <strong>Dirección: </strong><?=$proveedor['domicilio']?><br>
    <strong>Localidad: </strong><?=$proveedor['localidad']?><br>
    <strong>Pais: </strong><?=$proveedor['pais']?><br><br>
    
    <hr>
    <strong>Items</strong>
    <hr>
    <table class="table table-striped table-responsive">
        <thead>
            <tr>
                <th style="width: 15%; text-align: right"><strong>Cantidad</strong></th>
                <th style="width: 35%; text-align: right"><strong>Artículos</strong></th>
                <th style="width: 25%; text-align: right"><strong>P.U.</strong></th>
                <th style="width: 25%; text-align: right"><strong>Total</strong></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($items as $item) { ?>
            <tr>
                <td style="width: 15%; text-align: right"><?=$item['cantidad']?></td>
                <td style="width: 35%; text-align: right"><?=$item['articulo']?></td>
                <td style="width: 25%; text-align: right"><?= number_format($item['costo_fob'], 2);?></td>
                <td style="width: 25%; text-align: right"><?= number_format(($item['cantidad']*$item['costo_fob']), 2); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <hr>
    <?php var_dump($items) ?>
</div>

