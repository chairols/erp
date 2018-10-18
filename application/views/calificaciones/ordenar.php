<div class="box box-primary">
    <div class="box-header">

    </div>
    <div class="box-body">
        <div class="cf nestable-lists">
            <div class="dd" id="nestable">
                <ol class="dd-list">
                    <?php foreach ($calificaciones as $calificacion) { ?>
                        <li class="dd-item dd3-item" data-id="<?= $calificacion['idcalificacion'] ?>">
                            <div class="dd-handle dd3-handle"></div>
                            <div class="dd3-content">
                                <?= $calificacion['calificacion'] ?>
                            </div>
                            <?php if (count($calificacion['calificaciones'])) { ?>
                                <ol class="dd-list">
                                    <?php foreach ($calificacion['calificaciones'] as $calificacion2) { ?>
                                        <li class="dd-item dd3-item" data-id="<?= $calificacion2['idcalificacion'] ?>">
                                            <div class="dd-handle dd3-handle"></div>
                                            <div class="dd3-content">
                                                <?= $calificacion2['calificacion'] ?>
                                            </div>
                                            <?php if (count($calificacion2['calificaciones'])) { ?>
                                                <ol class="dd-list">
                                                    <?php foreach ($calificacion2['calificaciones'] as $calificacion3) { ?>
                                                        <li class="dd-item dd3-item" data-id="<?= $calificacion3['idcalificacion'] ?>">
                                                            <div class="dd-handle dd3-handle"></div>
                                                            <div class="dd3-content">
                                                                <?= $calificacion3['calificacion'] ?>
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

<textarea style="display: none;" id="nestable-output"></textarea>