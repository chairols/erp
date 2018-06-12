<div class="col-md-12">
    <div class="box">
        <div class="box-header">
            <form method="GET" class="input-group input-group-sm col-md-5">
                <input class="form-control pull-left" name="titulo" placeholder="Buscar ..." type="text">
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
                        <th>Ícono</th>
                        <th>Título</th>
                        <th>Link</th>
                        <th>Visible</th>
                        <th>Padre</th>
                        <th>Acciones</th>
                    </tr>
                    <?php foreach ($menues as $m) { ?>
                        <tr>
                            <td><strong><i class="<?= $m['icono'] ?>"></i></strong></td>
                            <td><?= $m['titulo'] ?></td>
                            <td><?= $m['href'] ?></td>
                            <td>
                                <?php if ($m['visible'] == 1) { ?>
                                    <span class="label label-success">SI</span>
                                <?php } else { ?>
                                    <span class="label label-danger">NO</span>
                                <?php } ?>
                            </td>
                            <td><?php if ($m['padre'] != null) { ?>
                                    <span class="label label-success"><?= $m['padre']['titulo'] ?></span>
                                <?php } else { ?>
                                    <span class="label label-danger">No tiene</span>
                                <?php } ?>
                            </td>
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