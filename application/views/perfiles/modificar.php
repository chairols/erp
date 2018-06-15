<input type="hidden" id="menues" value="<?= $ids ?>">
<input type="hidden" id="idperfil" value="<?=$perfil['idperfil']?>">

<div class="row">
    <div class="col-md-5 col-md-offset-1">
        <div class="box">
            <div class="box-header">

            </div>
            <div class="box-body no-padding">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-md-3">Perfil</label>
                        <div class="col-md-6">
                            <input type="text" maxlength="50" class="form-control" id="perfil" name="perfil" value="<?= $perfil['perfil'] ?>" autofocus>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="button" id="actualizar" class="btn btn-success">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5 ">
        <div class="box">
            <div class="box-header">
                <h3>Accesos</h3>
            </div>
            <div class="box-body no-padding">
                <div id="treeview-checkbox">
                    <?php foreach ($mmenu as $m) { ?>
                        <ul>
                            <li data-value="<?= $m['idmenu'] ?>">
                                <i class="<?= $m['icono'] ?>"></i> <?= $m['titulo'] ?> 
                                <?= ($m['visible'] == 1) ? "<i class='text-green fa fa-eye'></i>" : "<i class='text-red fa fa-eye-slash'></i>" ?>
                                <?php foreach ($m['submenu'] as $m1) { ?>
                                    <ul>
                                        <li data-value="<?= $m1['idmenu'] ?>">
                                            <i class="<?= $m1['icono'] ?>"></i> <?= $m1['titulo'] ?> 
                                            <?= ($m1['visible'] == 1) ? "<i class='text-green fa fa-eye'></i>" : "<i class='text-red fa fa-eye-slash'></i>" ?>
                                            <?php foreach ($m1['submenu'] as $m2) { ?>
                                                <ul>
                                                    <li data-value="<?= $m2['idmenu'] ?>">
                                                        <i class="<?= $m2['icono'] ?>"></i> <?= $m2['titulo'] ?> 
                                                        <?= ($m2['visible'] == 1) ? "<i class='text-green fa fa-eye'></i>" : "<i class='text-red fa fa-eye-slash'></i>" ?>
                                                    </li>
                                                </ul>
                                            <?php } ?>
                                        </li>
                                    </ul>
                                <?php } ?>
                            </li> 
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </div>


    </div>

</div>