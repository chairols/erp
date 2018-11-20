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
                    <th>Comprobante</th>
                    <th>Proveedor</th>
                    <th>Fecha</th>
                    <th>Jurisdicción</th>
                    <th>Monto Retenido</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($retenciones as $retencion) { ?>
                    <tr>
                        <td><?= str_pad($retencion['punto'], 4, '0', STR_PAD_LEFT) ?>-<?= str_pad($retencion['numero'], 8, '0', STR_PAD_LEFT) ?></td>
                        <td><?= $retencion['proveedor'] ?></td>
                        <td><?= $retencion['fecha'] ?></td>
                        <td><?= $retencion['idjurisdiccion_afip'] ?> - <?= $retencion['jurisdiccion'] ?></td>
                        <td><?= $retencion['monto_retenido']?></td>
                        <td>
                            <a href="/retenciones/modificar/<?=$retencion['idretencion']?>/" class="hint--top-right hint--bounce hint--info" aria-label="Modificar">
                                <button class="btn btn-primary btn-xs" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </a>
                            <a href="/retenciones/pdf/<?=$retencion['idretencion']?>/" class="hint--top hint--bounce hint--error" aria-label="Ver PDF">
                                
                            </a>
                            <a href="/retenciones/pdf/<?= $retencion['idretencion'] ?>/" target="_blank" data-pacement="top" data-toggle="tooltip" data-original-title="Ver PDF" class="tooltips">
                                <button class="btn btn-google btn-xs">
                                    <i class="fa fa-file-pdf-o"></i>
                                </button>
                            </a>
                            <button class="btn btn-danger btn-xs borrar_retencion" idretencion="<?= $retencion['idretencion'] ?>" retencion="<?= str_pad($retencion['punto'], 4, '0', STR_PAD_LEFT) ?>-<?= str_pad($retencion['numero'], 8, '0', STR_PAD_LEFT) ?>" proveedor="<?= $retencion['proveedor'] ?>" data-pacement="top" data-toggle="tooltip" data-original-title="Eliminar" class="tooltips">
                                <i class="fa fa-trash-o"></i>
                            </button>
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