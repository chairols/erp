<div class="box">
    <div class="box-header">
        <form method="GET" action="/proveedores/listar/" class="input-group input-group-sm col-md-5">
            <input class="form-control pull-left" name="proveedor" id="proveedor" placeholder="Buscar ..." type="text" value="<?=$this->input->get('proveedor')?>">
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
                    <th>#</th>
                    <th>Proveedor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($proveedores as $proveedor) { ?>
                <tr>
                    <td><?=$proveedor['idproveedor']?></td>
                    <td><?=$proveedor['proveedor']?></td>
                    <td></td>
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