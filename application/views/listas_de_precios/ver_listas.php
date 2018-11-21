<div class="box">
    <div class="box-header">
        <form method="GET" action="/retenciones/listar/" class="input-group input-group-sm col-md-5">
            <input class="form-control pull-left" name="proveedor" id="proveedor" placeholder="Buscar ..." type="text">
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>
        <div class="box-tools">
            <ul class="pagination pagination-sm no-margin pull-right">
                <?= $links ?>
            </ul>
        </div>
    </div>
    <div class="box-body no-padding">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Proveedor</th>
                    <th>Moneda</th>
                    <th>Fecha</th>
                    <th>Artículos</th>
                    <th>Asociados</th>
                    <th>Pendientes</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listas as $lista) { ?>
                    <tr id="lista-<?= $lista['idlista_de_precios'] ?>">
                        <td><strong><?= $lista['proveedor'] ?></strong></td>
                        <td><strong><span class="label label-success"><?= $lista['moneda'] ?></span></strong></td>
                        <td><strong><span class="label label-brown"><?= $lista['fecha'] ?></span></strong></td>
                        <td><strong><span class="label label-info"><?= $lista['cantidad'] ?></span></strong></td>
                        <td><strong><span class="label label-warning"><?= $lista['asociados'] ?></span></strong></td>
                        <td><strong><span class="label label-danger"><?= $lista['cantidad'] - $lista['asociados'] ?></span></strong></td>
                        <td>
                            <a href="/listas_de_precios/asociar_generico/<?= $lista['idlista_de_precios'] ?>/" class="hint--top hint--bounce hint--info" aria-label="Editar">
                                <button type="button" class="btn btn-xs btnBlue"><i class="fa fa-pencil"></i></button>
                            </a>
                            <a class="hint--bottom hint--bounce hint--top" aria-label="Eliminar" url="#" campo="idsucursal" success="" error="" id="delete_<?= $lista['idlista_de_precios'] ?>">
                                <button type="button" class="btn btn-xs btnRed"><i class="fa fa-trash"></i></button>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="box-footer clearfix">
        <div class="pull-left">
            <strong>Total <?= $total_rows ?> registros.</strong>
        </div>
        <div class="box-tools">
            <ul class="pagination pagination-sm no-margin pull-right">
                <?= $links ?>
            </ul>
        </div>
    </div>
</div>
