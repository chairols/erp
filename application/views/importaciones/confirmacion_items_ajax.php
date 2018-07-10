<div class="table-responsive">
    <table class="table no-margin table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>Cantidad</th>
                <th>Artículo</th>
                <th>Fecha Prometida</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($items as $item) { ?>
            <tr>
                <td><?=$item['cantidad']?></td>
                <td><strong><?=$item['articulo']?> <?=$item['marca']?></strong></td>
                <td><?=$item['fecha_confirmacion']?></td>
                <td></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>