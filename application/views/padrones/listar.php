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
                <tr>
                    <td><?=$padron['provincia']?></td>
                    <td><?=$padron['fecha_desde_formateada']?></td>
                    <td><?=$padron['fecha_hasta_formateada']?></td>
                    <td><?= number_format($padron['cantidad'], 0)?></td>
                    <td></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>