<div class="box">
    <div class="box-header">
        <form method="GET" class="input-group input-group-sm col-md-3">
            <input class="form-control pull-left" name="empresa" placeholder="Empresa" type="text" value="<?= $this->input->get('empresa') ?>">
            <select class="form-control chosenSelect" name="importaciones_estado">
                <option value="">Todas</option>
                <option value="P"<?= ($this->input->get('importaciones_estado') == 'P') ? " selected" : "" ?>>Pedido</option>
                <option value="C"<?= ($this->input->get('importaciones_estado') == 'C') ? " selected" : "" ?>>Confirmado</option>
                <option value="E"<?= ($this->input->get('importaciones_estado') == 'E') ? " selected" : "" ?>>Embarcado</option>
                <option value="D"<?= ($this->input->get('importaciones_estado') == 'D') ? " selected" : "" ?>>Despachado</option>
            </select>
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
                    <th>Moneda</th>
                    <th># Items</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($importaciones as $importacion) { ?>
                    <tr>
                        <td><?= $importacion['idimportacion'] ?></td>
                        <td><?= $importacion['empresa'] ?></td>
                        <td><span class="label label-success"><?= $importacion['moneda'] ?></span></td>
                        <td><span class="label label-brown"><?= $importacion['cantidad_items'] ?></span></td>
                        <td>
                            <?php
                            switch ($importacion['importaciones_estado']) {
                                case 'P':
                                    echo "<span class='label label-danger'>PEDIDO</span>";
                                    break;
                                case 'C':
                                    echo "<span class='label label-warning'>CONFIRMADO</span>";
                                    break;
                                case 'E':
                                    echo "<span class='label label-primary'>EMBARCADO</span>";
                                    break;
                                case 'D':
                                    echo "<span class='label label-success'>DESPACHADO</span>";
                                    break;
                                default:
                                    break;
                            }
                            ?>
                        </td>
                        <td>
                            <a href="/importaciones/agregar_items/<?= $importacion['idimportacion'] ?>/" data-pacement="top" data-toggle="tooltip" data-original-title="Modificar" class="tooltips">
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