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
                    <th>#</th>
                    <th>Proveedor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($confirmaciones as $confirmacion) { ?>
                <tr>
                    <td><?=$confirmacion['idimportacion_confirmacion']?></td>
                    <td><?=$confirmacion['proveedor']?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php var_dump($confirmaciones); ?>