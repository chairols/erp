<div class="box">
    <div class="box-header">
        <form method="GET" target="/retenciones/listar/" class="input-group input-group-sm col-md-5">
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
            <tbody>
                <tr>
                    <th>Comprobante</th>
                    <th>Proveedor</th>
                    <th>Fecha</th>
                    <th>Jurisdicción</th>
                    <th>Acciones</th>
                </tr>
                <?php foreach ($retenciones as $retencion) { ?>
                    <tr>
                        <td><?= str_pad($retencion['punto'], 4, '0', STR_PAD_LEFT) ?>-<?= str_pad($retencion['numero'], 8, '0', STR_PAD_LEFT) ?></td>
                        <td><?= $retencion['proveedor'] ?></td>
                        <td><?= $retencion['fecha'] ?></td>
                        <td><?= $retencion['idjurisdiccion_afip'] ?> - <?= $retencion['jurisdiccion'] ?></td>
                        <td>

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