<div style="font-size: 8;">
    <table class="table table-striped table-hover table-responsive table-bordered">
        <thead>
            <tr>
                <th style="width: 12%; text-align: right"><strong>Retención</strong></th>
                <th style="width: 12%; text-align: right"><strong>Fecha</strong></th>
                <th style="width: 52%; text-align: right"><strong>Proveedor</strong></th>
                <th style="width: 12%; text-align: right"><strong>Retenido</strong></th>
                <th style="width: 12%; text-align: right"><strong>Subtotal</strong></th>
            </tr>
        </thead>
        <tbody>
            <?php $subtotal = 0; ?>
            <?php foreach ($retenciones as $retencion) { ?>
                <?php $subtotal += $retencion['monto_retenido']; ?>
                <tr style="text-align: right">
                    <td style="width: 12%"><?= str_pad($retencion['punto'], 4, '0', STR_PAD_LEFT) ?>-<?= str_pad($retencion['numero'], 8, '0', STR_PAD_LEFT) ?></td>
                    <td style="width: 12%"><?= $retencion['fecha_formateada'] ?></td>
                    <td style="width: 52%"><?= $retencion['proveedor'] ?></td>
                    <td style="width: 12%"><?= number_format($retencion['monto_retenido'], 2) ?></td>
                    <td style="width: 12%"><?= number_format($subtotal, 2) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>