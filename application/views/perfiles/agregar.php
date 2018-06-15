<input type="hidden" id="menues" value="<?=$ids?>">

<div id="treeview-checkbox">
    <?php foreach ($mmenu as $m) { ?>
        <ul>
            <li data-value="<?= $m['idmenu'] ?>">
                <i class="<?= $m['icono'] ?>"></i> <?= $m['titulo'] ?>
                <?php foreach ($m['submenu'] as $m1) { ?>
                    <ul>
                        <li data-value="<?= $m1['idmenu'] ?>">
                            <i class="<?= $m1['icono'] ?>"></i> <?= $m1['titulo'] ?>
                            <?php foreach ($m1['submenu'] as $m2) { ?>
                                <ul>
                                    <li data-value="<?= $m2['idmenu'] ?>">
                                        <i class="<?= $m2['icono'] ?>"></i> <?= $m2['titulo'] ?>
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

<?php var_dump($ids) ?>
