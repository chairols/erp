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
    <?php if($item['cantidad'] > 0) { ?>
    <?php $cantidad += $item['cantidad'] ?>
    <?php $total += ($item['cantidad'] * $item['precio']) ?>
    <div class="row form-group inline-form-custom">
        <div class="col-xs-4 txC">
            <input type="text" value="<?= $item['articulo'] ?> - <?= $item['marca'] ?>" class="form-control" disabled="">
        </div>
        <div class="col-xs-2 txC">
            <input type="text" value="<?= $item['cantidad'] ?>" class="form-control txR" disabled="">
        </div> 
        <div class="col-xs-2 txC">
            <input type="text" value="<?= number_format($item['precio'], 2) ?>" class="form-control txR" disabled="">
        </div> 
        <div class="col-xs-2 txC">
            <input type="text" value="<?= number_format($item['cantidad'] * $item['precio'], 2) ?>" class="form-control txR" disabled="">
        </div>
        <div class="col-xs-2 txC">
            <a href="/importaciones/modificar_item/<?= $item['idimportacion_item'] ?>/" data-pacement="top" data-toggle="tooltip" data-original-title="Modificar <?= $item['articulo'] ?>" class="tooltips">
                <button class="btn btn-primary btn-xs">
                    <i class="fa fa-edit"></i>
                </button>
            </a>
            <button onclick="borrar_item('<?= $item['articulo'] ?> - <?=$item['marca']?>', '<?= $item['idimportacion_item'] ?>');" class="btn btn-danger btn-xs tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Eliminar <?= $item['articulo'] ?>">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    </div>
    <?php } ?>
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

