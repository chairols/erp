<div style="font-size: smaller">
    <strong>Datos de Retención</strong><hr>
    <strong>Fecha: </strong><?=$retencion['fecha_formateada']?><br>
    <strong>Jurisdicción: </strong><?=$jurisdiccion['idjurisdiccion_afip']?> - <?=$jurisdiccion['provincia']?><br>
    <strong>Comprobante: </strong><?=str_pad($retencion['punto'], 4, '0', STR_PAD_LEFT)?>-<?=str_pad($retencion['numero'], 8, '0', STR_PAD_LEFT)?><br>
    
    
    <hr>
    <strong>Agente de Retención</strong><hr>
    <strong><?=$parametro['empresa']?></strong><br>
    <strong>Dirección: </strong><?=$parametro['direccion']?><br>
    <strong>Código Postal: </strong><?=$parametro['codigo_postal']?><br>
    <strong>Localidad: </strong><?=$parametro['provincia']['provincia']?><br>
    <strong>CUIT: </strong><?=$parametro['cuit']?><br>
    <strong>Ingresos Brutos: </strong><?=$parametro['ingresos_brutos']?><br>
    <strong><?=$parametro['iva']['tipo_responsable']?></strong><br>
    
    <hr>
    <strong>Datos de Contribuyente</strong><hr>
    <strong><?=$retencion['proveedor']?></strong><br>
    <strong>Dirección: </strong><?=$retencion['direccion']?><br>
    <strong>Código Postal: </strong><?=$retencion['codigopostal']?><br>
    <strong>Localidad: </strong><?=$retencion['localidad']?><br>
    <strong>Provincia: </strong><?=$retencion['provincia']?><br>
    <strong>CUIT: </strong><?=$retencion['cuit']?><br>
    <strong>Ingresos Brutos: </strong><?=$retencion['iibb']?><br>
    
    <hr>
    <strong>Comprobantes</strong><hr>
    <table>
        <tr>
            <th style="width: 33%; text-align: right">Comprobantes</th>
            <th style="width: 33%; text-align: right">Fecha</th>
            <th style="width: 33%; text-align: right">Base Imponible</th>
            <!--<th style="width: 20%; text-align: right">Alícuota</th>
            <th style="width: 20%; text-align: right">Monto Retenido</th>-->
        </tr>
        <?php $total = 0; ?>
        <?php $total_base_imponible = 0; ?>
        <?php foreach($retencion['items'] as $item) { ?>
        <tr>
            <td style="width: 33%; text-align: right" class="bg-gray"><?=str_pad($item['punto_de_venta'], 4, '0', STR_PAD_LEFT)?>-<?=str_pad($item['comprobante'], 8, '0', STR_PAD_LEFT)?></td>
            <td style="width: 33%; text-align: right"><?=$item['fecha_formateada']?></td>
            <td style="width: 33%; text-align: right"><?=number_format($item['base_imponible'], 2)?></td>
            <!--<td style="width: 20%; text-align: right"><?=$retencion['alicuota']?> %</td>
            <td style="width: 20%; text-align: right"><?=number_format(round((($item['base_imponible']*$retencion['alicuota'])/100), 2), 2)?></td>-->
            <?php $total_base_imponible += $item['base_imponible']; ?>    
            <?php $total += round((($item['base_imponible']*$retencion['alicuota'])/100), 2); ?>
        </tr>
        <?php } ?>
        <hr>
        <tr>
            <td style="width: 33%; text-align: right"><strong>Total Base Imponible: <?= number_format($total_base_imponible, 2)?></strong></td>
            <td style="width: 33%; text-align: right"><strong>Alícuota <?=$retencion['alicuota']?> %</strong></td>
            <td style="width: 33%; text-align: right"><strong>Total Retenido: <?= $retencion['monto_retenido']?></strong></td>
        </tr>
        <hr>
    </table>
    <br><br>
    <div style="text-align: center">
        <img style="width: 150px;" src="<?=$firma['valor_sistema']?>">
    </div>
    
</div>
