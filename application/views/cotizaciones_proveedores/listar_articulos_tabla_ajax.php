<table class="table table-hover table-responsive table-striped table-condensed">
    <thead>
        <tr>
            <th class="text-right">Artículo</th>
            <th class="text-right">Precio</th>
            <th class="text-right">Cantidad</th>
            <th class="text-right">Fecha de Entrega</th>
            <th class="text-right">Total</th>
            <th class="text-right">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($articulos as $articulo) { ?>
        <tr>
            <td class="text-right"><?=$articulo['articulo']['articulo']?> - <?=$articulo['marca']['marca']?></td>
            <td class="text-right"><?=$articulo['precio']?></td>
            <td class="text-right"><?=$articulo['cantidad']?></td>
            <td class="text-right"><?=$articulo['fecha_formateada']?></td>
            <td class="text-right"><?= number_format($articulo['precio']*$articulo['cantidad'], 2)?></td>
            <td class="text-right"></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

