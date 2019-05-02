<table class="table table-bordered table-responsive table-hover table-striped">
    <thead>
        <tr>
            <th>Concepto</th>
            <th>Unidades</th>
            <th>Remuneraciones</th>
            <th>Remuneraciones Exentas</th>
            <th>Descuentos</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php $remuneraciones = 0; ?>
        <?php $remuneraciones_exentas = 0; ?>
        <?php $descuentos = 0; ?>
        <?php foreach($items as $item) { ?>
        <tr>
            <td><?=str_pad($item['idsueldo_concepto'], 4, '0', STR_PAD_LEFT);?> <?=$item['concepto']?></td>
            <td><?=($item['cantidad'] > 0)?$item['cantidad'].' '.$item['unidad']:""?></td>
            <td class="text-right">
                <?php if($item['tipo'] == 'R') { 
                    $remuneraciones += $item['valor'];
                    echo $item['valor'];
                 } ?>
            </td>
            <td class="text-right">
                 <?php if($item['tipo'] == 'N') { 
                     $remuneraciones_exentas += $item['valor'];
                     echo $item['valor'];
                 } ?>
            </td>
            <td class="text-right">
                 <?php if($item['tipo'] == 'D') {
                     $descuentos += $item['valor'];
                     echo $item['valor'];
                 } ?>
            </td>
            <td></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<pre>
    <?php print_r($items); ?>
</pre>