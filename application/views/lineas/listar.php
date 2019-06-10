
    <div class="box">
        <div class="box-header">
            <form method="GET" class="input-group input-group-sm col-md-5">
                <input class="form-control pull-left" name="linea" placeholder="Línea" type="text">
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
                        <th>Línea</th>
                        <th>Nombre Corto</th>
                        <th>Acciones</th>
                    </tr>
                    <?php foreach ($lineas as $linea) { ?>
                        <tr>
                            <td><?= $linea['linea'] ?></td>
                            <td><?= $linea['nombre_corto'] ?></td>
                            <td>
                                <a href="/lineas/modificar/<?= $linea['idlinea'] ?>/" class="hint--top hint--bounce hint--info" aria-label="Modificar">
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
