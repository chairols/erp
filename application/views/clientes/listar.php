<div class="box">
    <div class="box-header">
        <form method="GET" action="/clientes/listar/" class="input-group input-group-sm col-md-5">
            <input class="form-control pull-left" name="cliente" id="cliente" placeholder="Buscar ..." type="text" value="<?=$this->input->get('cliente')?>">
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
                    <th>Clientes</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($clientes as $cliente) { ?>
                <tr>
                    <td><?=$cliente['idcliente']?></td>
                    <td><?=$cliente['cliente']?></td>
                    <td>
                        <a href="/clientes/modificar/<?=$cliente['idcliente']?>/" class="hint--top-right hint--bounce hint--info" aria-label="Modificar">
                            <button class="btn btn-primary btn-xs">
                                <i class="fa fa-edit"></i>
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
