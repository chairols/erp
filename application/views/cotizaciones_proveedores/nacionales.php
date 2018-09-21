
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
                        <th>Total</th>
                        <th>Entrega</th>
                        <th>Acciones</th>
                    </tr>
                    <?php foreach ($cotizaciones as $cotizacion) { ?>
                        <tr>
                            <td><strong><?= $cotizacion['empresa'] ?></strong></td>
                            <td><?= $cotizacion['total_formateado'] ?></td>
                            <td><?= $cotizacion['fecha_entrega'] ?></td>

                            <td>&nbsp;</td>
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
        <pre>
            <?php print_r($cotizaciones) ?>
        </pre>
    </div>
