<div class="col-md-12">
    <div class="box">
        <div class="box-header">
            <form method="POST" class="input-group input-group-sm col-md-5">
                    <input class="form-control pull-left" name="perfil" placeholder="Buscar ..." type="text">
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
                        <th>Perfil</th>
                        <th>Acciones</th>
                    </tr>
                    <?php foreach($perfiles as $perfil) { ?>
                    <tr>
                        <td><?=$perfil['perfil']?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>