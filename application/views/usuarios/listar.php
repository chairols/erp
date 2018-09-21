
<div class="box">
    <div class="box-header">
        <form method="GET" class="input-group input-group-sm col-md-5">
            <input class="form-control pull-left" name="codigo" placeholder="Buscar ..." type="text">
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
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Perfil</th>
                    <th>Acciones</th>
                </tr>
                <?php foreach ($usuarios as $usuario) { ?>
                    <tr>
                        <td><?= $usuario['usuario'] ?></td>
                        <td><?= $usuario['nombre'] ?></td>
                        <td><?= $usuario['apellido'] ?></td>
                        <td><?= $usuario['email'] ?></td>
                        <td><span class="label label-success"><?= $usuario['perfil'] ?></span></td>
                        <td>
                            <a href="/usuarios/modificar/<?= $usuario['idusuario'] ?>" data-pacement="top" data-toggle="tooltip" data-original-title="Modificar" class="tooltips">
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
