<?php
$breadcrumbs = array();
foreach ($menu['menu'] as $m1) {
    if ($m1['active'] == 1) {
        $breadcrumbs[0]['icono'] = $m1['icono'];
        $breadcrumbs[0]['titulo'] = $m1['titulo'];
    }
    if (count($m1['submenu']) > 0) {
        foreach ($m1['submenu'] as $m2) {
            if ($m2['active'] == 1) {
                $breadcrumbs[1]['icono'] = $m2['icono'];
                $breadcrumbs[1]['titulo'] = $m2['titulo'];
            }
            if (count($m2['submenu']) > 0) {
                foreach ($m2['submenu'] as $m3) {
                    if ($m3['active'] == 1) {
                        $breadcrumbs[2]['icono'] = $m3['icono'];
                        $breadcrumbs[2]['titulo'] = $m3['titulo'];
                    }
                }
            }
        }
    }
}
?>
    <section class="content-header">
        <h1>
            <?=$title?>
        </h1>
        <ol class="breadcrumb">
            <?php foreach ($breadcrumbs as $b) { ?>
                <li>
                    <i class="<?= $b['icono'] ?>"></i>
                    <?= $b['titulo'] ?>
                </li>
            <?php } ?>
        </ol>
    </section>
    <br>
