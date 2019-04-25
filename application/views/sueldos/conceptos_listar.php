<div class="box">
    <div class="box-header">
        <form method="GET" action="/retenciones/listar/" class="input-group input-group-sm col-md-5">
            <input class="form-control pull-left" name="proveedor" id="proveedor" placeholder="Buscar ..." type="text" value="<?= $this->input->get('proveedor') ?>">
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
                    <th>Concepto</th>
                    <th>Tipo</th>
                    <th>Unidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($conceptos as $concepto) { ?>
                    <tr>
                        <td><?= str_pad($concepto['idsueldo_concepto'], 4, '0', STR_PAD_LEFT) ?></td>
                        <td><?= $concepto['sueldo_concepto'] ?></td>
                        <td><?php
                            switch ($concepto['tipo']) {
                                case 'R':
                                    echo "Remunerativo";
                                    break;
                                case 'N':
                                    echo "No Remunerativo";
                                    break;
                                case 'D':
                                    echo "Descuento";
                                    break;
                            }
                            ?></td>
                        <td>
                        <?php if($concepto['cantidad'] > 0) {
                            echo $concepto['cantidad'].' '.$concepto['unidad'];
                         } ?>
                        </td>
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