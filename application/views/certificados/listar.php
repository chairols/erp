<div class="box box-primary">
    <div class="box-header">
        <div class="box-tools">
            <ul class="pagination pagination-sm no-margin pull-right">
                <?= $links ?>
            </ul>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha Desde</th>
                    <th>Fecha Hasta</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($certificados as $certificado) { ?>
                    <tr>
                        <td><?= $certificado['nombre'] ?></td>
                        <td><?= $certificado['fecha_desde_formateada'] ?></td>
                        <td><?= $certificado['fecha_hasta_formateada'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>