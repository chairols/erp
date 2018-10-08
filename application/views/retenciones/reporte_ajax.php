<h3 class="text-center">
    <strong>
        Jurisdicción: <?=$provincia['idjurisdiccion_afip']?> - <?=$provincia['provincia']?>
    </strong>
</h3>
<table class="table table-striped table-hover table-responsive">
    <thead>
        <tr>
            <th class="text-right">Retención</th>
            <th class="text-right">Fecha</th>
            <th class="text-right">Proveedor</th>
            <th class="text-right">Alícuota</th>
            <th class="text-right">Monto Retenido</th>
            <th class="text-right">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php $subtotal = 0; ?>
        <?php foreach($retenciones as $retencion) { ?>
        <?php $subtotal += $retencion['monto_retenido']; ?>
        <tr class="text-right">
            <td><?=str_pad($retencion['punto'], 4, '0', STR_PAD_LEFT)?>-<?=str_pad($retencion['numero'], 8, '0', STR_PAD_LEFT)?></td>
            <td><?=$retencion['fecha_formateada']?></td>
            <td><?=$retencion['proveedor']?></td>
            <td><?=$retencion['alicuota']?></td>
            <td><?= number_format($retencion['monto_retenido'], 2)?></td>
            <td><?= number_format($subtotal, 2)?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>