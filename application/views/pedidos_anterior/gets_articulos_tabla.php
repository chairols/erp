<?php $total = 0; ?>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Cantidad</th>
            <th>Pendiente</th>
            <th>Artículo</th>
            <th>Marca</th>
            <th>Imprime Marca</th>
            <th>Almacén</th>
            <th>Precio Unitario</th>
            <th>Precio Total</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($articulos as $articulo) { ?>
        <tr>
            <td><?=$articulo['cantidad']?></td>
            <td><?=$articulo['cantidad_pendiente']?></td>
            <td><?=$articulo['articulo']?></td>
            <td><?=$articulo['marca']?></td>
            <td><?=$articulo['muestra_marca']?></td>
            <td>
                <?php if($articulo['almacen'] == '1') { ?>
                <span class="badge bg-red"><?=$articulo['almacen']?></span>
                <?php } else if($articulo['almacen'] == '2') { ?>
                <span class="badge bg-green"><?=$articulo['almacen']?></span>
                <?php } ?>
            </td>
            <td class="text-right"><?=$articulo['precio']?></td>
            <td class="text-right"><?=number_format($articulo['cantidad_pendiente']*$articulo['precio'], 2)?></td>
            <td></td>
        </tr>
        <?php $total += ($articulo['cantidad_pendiente']*$articulo['precio']); ?>
        <?php } ?>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">Total:</td>
            <td class="text-right"><?=number_format($total, 2);?></td>
        </tr>
    </tbody>
</table>