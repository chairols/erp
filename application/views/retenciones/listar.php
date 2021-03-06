<div class="box">
    <div class="box-header">
        <form method="GET" action="/retenciones/listar/" class="input-group input-group-sm col-md-5">
            <input class="form-control pull-left" name="proveedor" id="proveedor" placeholder="Buscar ..." type="text" value="<?= $this->input->get('proveedor') ?>">
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
                    <th>Estado Email</th>
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
                        <td><?= $retencion['monto_retenido'] ?></td>
                        <td id="estado_mail<?=$retencion['idretencion']?>">
                            <?php
                            switch ($retencion['estado_mail']) {
                                case 'S': // Sin Enviar ?>
                            <span class="badge bg-red">Sin Enviar</span>
                            <?php
                                    break;
                                case 'E': // Enviado ?>
                            <span class="badge bg-yellow">Enviado</span>
                            <?php
                                    break;
                                case 'R': // Recibido ?>
                            <span class="badge bg-green">Recibido</span>
                            <?php
                                    break;
                            }
                            ?>
                        </td>
                        <td>
                            <a href="/retenciones/modificar/<?= $retencion['idretencion'] ?>/" class="hint--top-right hint--bounce hint--info" aria-label="Modificar">
                                <button class="btn btn-primary btn-xs" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </a>
                            <a href="/retenciones/pdf/<?= $retencion['idretencion'] ?>/" class="hint--top hint--bounce hint--error" aria-label="Ver PDF" target="_blank">
                                <button class="btn btn-google btn-xs">
                                    <i class="fa fa-file-pdf-o"></i>
                                </button>
                            </a>
                            <a onclick="confirmar_mail(<?= $retencion['idretencion'] ?>);" class="hint--top hint--bounce hint--info" aria-label="Enviar por Email">
                                <button class="btn btn-info btn-xs">
                                    <i class="fa fa-envelope-o"></i>
                                </button>
                            </a>
                            <a class="hint--top-left hint--bounce hint--error" aria-label="Eliminar">
                                <button class="btn btn-danger btn-xs borrar_retencion" idretencion="<?= $retencion['idretencion'] ?>" retencion="<?= str_pad($retencion['punto'], 4, '0', STR_PAD_LEFT) ?>-<?= str_pad($retencion['numero'], 8, '0', STR_PAD_LEFT) ?>" proveedor="<?= $retencion['proveedor'] ?>">
                                    <i class="fa fa-trash-o"></i>
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