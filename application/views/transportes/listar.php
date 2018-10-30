<div class="box box-primary">
    <div class="box-header">
        <form method="GET" action="/transportes/listar/" class="input-group input-group-sm col-md-5">
            <input class="form-control pull-left" name="transporte" id="transporte" placeholder="Buscar ..." type="text">
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
                    <th>Transporte</th>
                    <th>Dirección</th>
                    <th>Localidad</th>
                    <th>Provincia</th>
                    <th>Teléfono</th>
                    <th>Horarios</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($transportes as $transporte) { ?>
                <tr>
                    <td><?=$transporte['transporte']?></td>
                    <td><?=$transporte['direccion']?></td>
                    <td><?=$transporte['localidad']?></td>
                    <td><?=$transporte['jurisdiccion']?></td>
                    <td><?=$transporte['telefono']?></td>
                    <td><?=$transporte['horario_desde']?> - <?=$transporte['horario_hasta']?></td>
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
