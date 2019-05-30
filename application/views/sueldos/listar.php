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
                    <th>Empleado</th>
                    <th>Período</th>
                    <th>Sueldo Bruto</th>
                    <th>Remunerativo</th>
                    <th>No Remunerativo</th>
                    <th>Descuentos</th>
                    <th>Sueldo Neto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sueldos as $sueldo) { ?>
                    <tr>
                        <td><?= $sueldo['empleado'] ?></td>
                        <td><?= $sueldo['periodo_mes'] ?>/<?=$sueldo['periodo_anio']?></td>
                        <td class="text-right"><span class="label label-primary"><?= number_format($sueldo['sueldo_bruto'], 2) ?></span></td>
                        <?php 
                        $remunerativo = 0;
                        $no_remunerativo = 0;
                        $descuentos = 0;
                        $sueldo_neto = 0;
                        foreach($sueldo['items'] as $item) {
                            switch ($item['tipo']) {
                                case 'R':
                                    $remunerativo += $item['valor'];
                                    $sueldo_neto += $item['valor'];
                                    break;
                                case 'N':
                                    $no_remunerativo += $item['valor'];
                                    $sueldo_neto += $item['valor'];
                                    break;
                                case 'D':
                                    $descuentos += $item['valor'];
                                    $sueldo_neto -= $item['valor'];
                                    break;
                            }
                        }
                        ?>
                        <td class="text-right"><span class="label label-success"><?= number_format($remunerativo, 2); ?></span></td>
                        <td class="text-right"><span class="label label-info"><?= number_format($no_remunerativo, 2); ?></span></td>
                        <td class="text-right"><span class="label label-danger"><?= number_format($descuentos, 2); ?></span></td>
                        <td class="text-right"><span class="label label-success"><?= number_format($sueldo_neto, 2); ?></span></td>
                        <td>
                            <a href="/sueldos/modificar/<?= $sueldo['idsueldo'] ?>/" class="hint--top hint--bounce hint--info" aria-label="Modificar">
                                <button class="btn btn-primary btn-xs" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </a>
                            <a href="/sueldos/pdf/<?= $sueldo['idsueldo'] ?>/I/" class="hint--top hint--bounce hint--error" aria-label="Ver PDF" target="_blank">
                                <button class="btn btn-google btn-xs">
                                    <i class="fa fa-file-pdf-o"></i>
                                </button>
                            </a>
                            <a class="hint--top hint--bounce hint--error" aria-label="Eliminar">
                                <button class="btn btn-danger btn-xs borrar_recibo" idsueldo="<?= $sueldo['idsueldo'] ?>" empleado="<?= $sueldo['empleado'] ?>">
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