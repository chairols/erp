<table class="table table-condensed table-bordered table-striped">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Cotización</th>
            <th>Cantidad</th>
            <th>Artículo</th>
            <th>Precio</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($articulos as $articulo) { ?>
        <tr>
            <td><?=$articulo['fecha_formateada']?></td>
            <td><?=str_pad($articulo['idcotizacion_cliente'], 8, '0', STR_PAD_LEFT)?></td>
            <td><?=$articulo['cantidad']?></td>
            <td><?=$articulo['descripcion']?></td>
            <td><?=$articulo['simbolo']?> <?=$articulo['precio']?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
