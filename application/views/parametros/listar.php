<div class="col-md-12">
    <div class="box">
        <div class="box-header">
            <form method="GET" class="input-group input-group-sm col-md-5">
                <input class="form-control pull-left" name="parametro" placeholder="Buscar ..." type="text">
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
                        <th>Parámetro</th>
                        <th>Tipo de Parámetro</th>
                        <th>Acciones</th>
                    </tr>
                    <?php foreach ($parametros as $parametro) { ?>
                        <tr>
                            <td><strong><?=$parametro['parametro']?></strong></td>
                            <td><span class="label label-success"><?=$parametro['parametro_tipo']?></span></td>
                            <td>&nbsp;</td>
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
</div>