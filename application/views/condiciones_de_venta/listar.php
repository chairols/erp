<div class="box">
    <div class="box-header">
        <form method="GET" action="/condiciones_de_venta/listar/" class="input-group input-group-sm col-md-5">
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
                    <th>Condición de Venta</th>
                    <th>Días</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($condiciones as $condicion) { ?>
                <tr>
                    <th><?=$condicion['condicion_de_venta']?></th>
                    <th><span class="label label-success"><?= $condicion['dias'] ?></span></th>
                    <th></th>
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
