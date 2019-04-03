<div class="box">
    <div class="box-header">
        <form method="GET" action="/corredores/listar/" class="input-group input-group-sm col-lg-12">
            <div class="row">
                <div class="form-group col-lg-4">
                    <input class="form-control pull-left" name="nombre" id="nombre" placeholder="Nombre" type="text" value="<?=$this->input->get('nombre')?>">
                </div>
                <div class="form-group col-lg-4">
                    <input class="form-control" name="apellido" id="apellido" placeholder="Apellido" type="text" value="<?=$this->input->get('apellido')?>">
                </div>
                <div class="form-group col-lg-2">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
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
                    <th>Corredor</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($corredores as $corredor) { ?>
                <tr>
                    <td><?=$corredor['idcorredor']?></td>
                    <td><?=$corredor['nombre']?> <?=$corredor['apellido']?></td>
                    <td>
                        <?php if($corredor['estado'] == 'A') { ?>
                        <span class="badge bg-green">ACTIVO</span>
                        <?php } elseif($corredor['estado'] == 'I') { ?>
                        <span class="badge bg-red">INACTIVO</span>
                        <?php } ?>
                    </td>
                    <td>
                        <a href="/corredores/modificar/<?=$corredor['idcorredor']?>/" class="hint--top-right hint--bounce hint--info" aria-label="Modificar">
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
