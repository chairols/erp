<table class="table table-striped">
    <thead>
        <tr>
            <th>Comprobante</th>
            <th>Fecha</th>
            <th>Base Imposible</th>
            <th>Monto Retenido</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($items as $item) { ?>
        <tr>
            <td><?=str_pad($item['punto_de_venta'], 4, '0', STR_PAD_LEFT);?>-<?=str_pad($item['comprobante'], 8, '0', STR_PAD_LEFT);?></td>
            <td><?=$item['fecha_formateada']?></td>
            <td><?=$item['base_imponible']?></td>
            <td><?= number_format(round((($item['base_imponible']*$retencion['alicuota'])/100), 2), 2)?></td>
            <td>
                <button class="btn btn-danger btn-xs">
                    <i class="fa fa-trash-o"></i>
                </button>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<div class="row">
    <div class="col-xs-6"></div>
    <div class="col-xs-6">
        <?php
        $total = 0;
        foreach($items as $item) {
            $total += round((($item['base_imponible']*$retencion['alicuota'])/100), 2);
        }
        ?>
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <th style="width: 50%">Monto Retenido</th>
                        <td><?= number_format($total, 2);?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>