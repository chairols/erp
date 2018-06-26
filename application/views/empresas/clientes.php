
    <div class="box">
        <div class="box-header">
            <form method="GET" class="input-group input-group-sm col-md-3">
                <input class="form-control pull-left" name="empresa" placeholder="Empresa" type="text">
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
                        <th>Empresa</th>
                        <th>CUIT</th>
                        <th>Tipo</th>
                        <th>Locación</th>
                        <th>Actividad</th>
                        <th>Acciones</th>
                    </tr>
                    <?php foreach ($empresas as $empresa) { ?>
                        <tr>
                            <td><strong><?= $empresa['idempresa'] ?> - <?= $empresa['empresa'] ?></strong></td>
                            <td><?= $empresa['cuit'] ?></td>
                            <td>
                                <?php if ($empresa['cliente'] == 'Y') { ?>
                                    <span class="label label-success">Cliente</span>
                                <?php } ?>
                                <?php if ($empresa['proveedor'] == 'Y') { ?>
                                    <span class="label label-warning">Proveedor</span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($empresa['internacional'] == 'Y') { ?>
                                    <span class="label label-warning">Internacional</span>
                                <?php } else { ?>
                                    <span class="label label-info">Nacional</span>
                                <?php } ?>
                            </td>
                            <td>
                                <span class="label label-default"><?=$empresa['empresa_tipo']?></span>
                            </td>
                            <td>
                                <a href="#" data-pacement="top" data-toggle="tooltip" data-original-title="Modificar" class="tooltips">
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
