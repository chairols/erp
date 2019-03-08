<div class="box">
    <div class="box-header">
        <form method="GET" action="/cargos/listar/" class="input-group input-group-sm col-md-5">
            <input class="form-control pull-left" name="cargo" id="cargo" placeholder="Buscar ..." type="text" value="<?= $this->input->get('cargo') ?>">
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
                    <th>Cargo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($cargos as $cargo) { ?>
                <tr>
                    <td><?=$cargo['idcargo']?></td>
                    <td><?=$cargo['cargo']?></td>
                    <td></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>