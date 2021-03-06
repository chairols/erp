<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header"></div>
            <div class="box-body">
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

    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3>Accesos</h3>
            </div>
            <div class="box-body no-padding">
                <div class="cf nestable-lists">
                    <div class="dd" id="nestable">
                        <ol class="dd-list">
                            <?php foreach ($mmenu as $m1) { ?>
                                <li class="dd-item dd3-item" data-id="<?= $m1['idmenu'] ?>">
                                    <div class="dd-handle dd3-handle"></div>
                                    <div class="dd3-content">
                                        <input id="checkbox-<?= $m1['idmenu'] ?>" type="checkbox"<?= ($m1['idperfil']) ? " checked" : "" ?> onclick="actualizar(<?= $m1['idmenu'] ?>, <?= $perfil['idperfil'] ?>);"> <i class="<?= $m1['icono'] ?>"></i> <?= $m1['titulo'] ?> <?= ($m1['visible'] == 1) ? "<i class='text-green fa fa-eye'></i>" : "<i class='text-red fa fa-eye-slash'></i>" ?> 
                                        <span id="progreso-<?= $m1['idmenu'] ?>" style="display: none;">
                                            <i class="fa fa-refresh fa-spin"></i>
                                        </span>
                                    </div>
                                    <?php if (count($m1['submenu'])) { ?>
                                        <ol class="dd-list">
                                            <?php foreach ($m1['submenu'] as $m2) { ?>
                                                <li class="dd-item dd3-item" data-id="<?= $m2['idmenu'] ?>">
                                                    <div class="dd-handle dd3-handle"></div>
                                                    <div class="dd3-content">
                                                        <input id="checkbox-<?= $m2['idmenu'] ?>" type="checkbox"<?= ($m2['idperfil']) ? " checked" : "" ?> onclick="actualizar(<?= $m2['idmenu'] ?>, <?= $perfil['idperfil'] ?>);"> <i class="<?= $m2['icono'] ?>"></i> <?= $m2['titulo'] ?> <?= ($m2['visible'] == 1) ? "<i class='text-green fa fa-eye'></i>" : "<i class='text-red fa fa-eye-slash'></i>" ?>
                                                        <span id="progreso-<?= $m2['idmenu'] ?>" style="display: none;">
                                                            <i class="fa fa-refresh fa-spin"></i>
                                                        </span>
                                                    </div>
                                                    <?php if (count($m2['submenu'])) { ?>
                                                        <ol class="dd-list">
                                                            <?php foreach ($m2['submenu'] as $m3) { ?>
                                                                <li class="dd-item dd3-item" data-id="<?= $m3['idmenu'] ?>">
                                                                    <div class="dd-handle dd3-handle"></div>
                                                                    <div class="dd3-content">
                                                                        <input id="checkbox-<?= $m3['idmenu'] ?>" type="checkbox"<?= ($m3['idperfil']) ? " checked" : "" ?> onclick="actualizar(<?= $m3['idmenu'] ?>, <?= $perfil['idperfil'] ?>);"> <i class="<?= $m3['icono'] ?>"></i> <?= $m3['titulo'] ?> <?= ($m3['visible'] == 1) ? "<i class='text-green fa fa-eye'></i>" : "<i class='text-red fa fa-eye-slash'></i>" ?>
                                                                        <span id="progreso-<?= $m3['idmenu'] ?>" style="display: none;">
                                                                            <i class="fa fa-refresh fa-spin"></i>
                                                                        </span>
                                                                    </div>
                                                                </li>
                                                            <?php } ?>
                                                        </ol>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>
                                        </ol>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<textarea style="display: none;" id="nestable-output"></textarea>