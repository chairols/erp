<div class="table-responsive">
    <table class="table no-margin table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th class="text-sm">Cantidad</th>
                <th class="text-sm">Artículo</th>
                <th class="text-sm">Fecha Prometida</th>
                <th class="text-sm">Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item) { ?>
                <tr>
                    <td class="text-sm"><?= $item['cantidad'] ?></td>
                    <td class="text-sm"><strong><?= $item['articulo'] ?> <?= $item['marca'] ?></strong></td>
                    <td class="text-sm"><?= $item['fecha_confirmacion'] ?></td>
                    <td class="text-sm">
                        <a onclick="borrar_item_confirmado(<?=$item['idimportacion_confirmacion_item'] ?>)" data-pacement="top" data-toggle="tooltip" data-original-title="Eliminar" class="tooltips">
                            <button class="btn btn-danger btn-xs">
                                <i class="fa fa-trash-o"></i>
                            </button>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>