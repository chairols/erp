<div class="box box-primary">
    <div class="box-header">
        <div class="box-tools">
            <ul class="pagination pagination-sm no-margin pull-right">
                <?= $links ?>
            </ul>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-responsive table-hover table-striped">
            <thead>
                <tr>
                    <th>Proveedor</th>
                    <th>Artículos</th>
                    <th>Registros</th>
                    <th>Moneda</th>
                    <th>Monto Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($preordenes as $preorden) { ?>
                    <tr>
                        <td><div class="badge bg-aqua"><?= $preorden['proveedor'] ?></div></td>
                        <td><div class="badge bg-fuchsia"><?= $preorden['cantidad_items'] ?></div></td>
                        <td><div class="badge bg-maroon-active"><?= $preorden['cantidad_registros'] ?></div></td>
                        <td><div class="badge bg-purple-gradient"><?= $preorden['moneda']['moneda'] ?></div></td>
                        <td><div class="badge bg-green-gradient"><?= $preorden['total'] ?></div></td>
                        <td>
                            <a href="/preordenes/modificar/<?=$preorden['idproveedor']?>/" class="hint--top-left hint--bounce hint--info" aria-label="Modificar Preorden">
                                <button class="btn btn-info btn-xs" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
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
