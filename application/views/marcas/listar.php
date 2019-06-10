<div class="box">
    <div class="box-header">
        <form method="GET" action="/marcas/listar/" class="input-group input-group-sm col-md-5">
            <input class="form-control pull-left" name="marca" id="marca" placeholder="Buscar ..." type="text" value="<?=$this->input->post('marca')?>">
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
                    <th>Marca</th>
                    <th>Nombre Corto</th>
                    <th>Acciones</th>
                </tr>
                <?php foreach ($marcas as $marca) { ?>
                    <tr>
                        <td><?= $marca['marca'] ?></td>
                        <td><?= $marca['nombre_corto'] ?></td>
                        <td>
                            <a href="/marcas/modificar/<?= $marca['idmarca'] ?>/" class="hint--top hint--bounce hint--info" aria-label="Modificar">
                                <button class="btn btn-primary btn-xs" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </a>
                            <a class="hint--top hint--bounce hint--error borrar_marca" aria-label="Eliminar" idmarca="<?=$marca['idmarca']?>" marca="<?=$marca['marca']?>">
                                <button class="btn btn-danger btn-xs" type="button">
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
