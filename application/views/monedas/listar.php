<div class="col-md-12">
    <div class="box">
        <div class="box-header">
            <form method="GET" class="input-group input-group-sm col-md-5">
                <input class="form-control pull-left" name="moneda" placeholder="Moneda" type="text">
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
                <tbody>
                    <tr>
                        <th>Moneda</th>
                        <th>Símbolo</th>
                        <th>Código AFIP</th>
                        <th>Acciones</th>
                    </tr>
                    <?php foreach ($monedas as $moneda) { ?>
                        <tr>
                            <td><?= $moneda['moneda'] ?></td>
                            <td><?= $moneda['simbolo'] ?></td>
                            <td><?= $moneda['codigo_afip'] ?></td>
                            <td>
                                <a href="/monedas/modificar/<?= $moneda['idmoneda'] ?>" data-pacement="top" data-toggle="tooltip" data-original-title="Modificar" class="tooltips">
                                    <button class="btn btn-primary btn-xs">
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
</div>