<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary box-solid">
            <div class="box-header">
                Plan de Cuentas
            </div>
            <div class="box-body no-padding">
                <div class="row">
                    <div class="col-md-12">
                        <div class="cf nestable-lists">
                            <div class="dd" id="nestable">
                                <ol class="dd-list">
                                    <?php

                                    function bucle($cuentas) {
                                        foreach ($cuentas as $cuenta) {
                                            ?>
                                            <li class="dd-item dd3-item" data-id="<?= $cuenta['idplan_de_cuenta'] ?>">
                                                <div class="dd-handle dd3-handle"></div>
                                                <div class="dd3-content">
                                                    <?= $cuenta['plan_de_cuenta'] ?> - (<?= $cuenta['idplan_de_cuenta'] ?>)
                                                </div>
                                                <?php if (count($cuenta['hijos'])) { ?>
                                                    <ol class="dd-list">
                                                        <?php bucle($cuenta['hijos']); ?>
                                                    </ol>
                                                <?php } ?>
                                            </li>
                                            <?php
                                        }
                                    }

                                    bucle($cuentas);
                                    ?>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
</div>

<textarea style="display: none;" id="nestable-output"></textarea>


