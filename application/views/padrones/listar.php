<div class="box box-primary">
    <div class="box-header">
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
                    <th>Jurisdicción</th>
                    <th>Fecha válida desde</th>
                    <th>Fecha válida hasta</th>
                    <th>Cantidad de Registros</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($padrones as $padron) { ?>
                <tr id="tr-<?=$padron['idpadron']?>">
                    <td><?=$padron['provincia']?></td>
                    <td><?=$padron['fecha_desde_formateada']?></td>
                    <td><?=$padron['fecha_hasta_formateada']?></td>
                    <td><?= number_format($padron['cantidad'], 0)?></td>
                    <td>
                        <button class="btn btn-danger btn-xs borrar_padron" id="borrar-<?=$padron['idpadron']?>" idpadron="<?=$padron['idpadron']?>" data-pacement="top" data-toggle="tooltip" data-original-title="Borrar" class="tooltips">
                            <i class="fa fa-trash-o"></i>
                        </button> 
                        <button class="btn btn-danger btn-xs" id="loading-<?=$padron['idpadron']?>" style="display: none;">
                            <i class="fa fa-refresh fa-spin"></i>
                        </button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>