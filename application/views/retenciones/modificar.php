<div class="innerContainer">
    <div class="invoice">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    Retención # <?=str_pad($retencion['punto'], 4, '0', STR_PAD_LEFT)?>-<?=str_pad($retencion['numero'], 8, '0', STR_PAD_LEFT)?>
                </h2>
            </div>
        </div>
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                De
                <address>
                    <strong><?=$parametro['empresa']?></strong>
                    <br>
                    <?=$parametro['direccion']?>
                    <br>
                    (<?=$parametro['codigo_postal']?>)
                    <br>
                    <?=$parametro['provincia']['provincia']?>
                    <br>
                    CUIT: <?=$parametro['cuit']?>
                    <br>
                    IIBB: <?=$parametro['ingresos_brutos']?>
                    <br>
                    <?=$parametro['iva']['tipo_responsable']?>
                </address>
            </div>
            <div class="col-sm-4 invoice-col">
                Para
                <address>
                    <strong><?=$retencion['empresa']?></strong>
                    <br>
                    <?=$retencion['direccion']?>
                    <br>
                    (<?=$retencion['codigopostal']?>) <?=$retencion['localidad']?>
                    <br>
                    <?=$retencion['provincia']?>
                    <br>
                    CUIT: <?=$retencion['cuit']?>
                    <br>
                    IIBB: <?=$retencion['iibb']?>
                    <br>
                    <?=$retencion['iva']['tipo_responsable']?>
                </address>
            </div>
            <div class="col-sm-4 invoice-col">
                Jurisdicción
                <address>
                    <strong><?=$retencion['jurisdiccion']['provincia']?></strong>
                    <br>
                    <strong>Retención # <?=str_pad($retencion['punto'], 4, '0', STR_PAD_LEFT)?>-<?=str_pad($retencion['numero'], 8, '0', STR_PAD_LEFT)?></strong>
                    <br>
                    <strong>Fecha: </strong><?=$retencion['fecha']?>
                    <br>
                    <strong>Alícuota: </strong>
                    <div class="input-group input-group-sm">
                        <input type="text" class="inputMask form-control" data-inputmask="'mask': '9.99'">
                        <span class="input-group-btn">
                            <button class="btn btn-info btn-flat" type="button">Actualizar</button>
                        </span>
                    </div>
                </address>
            </div>
        </div>
    </div>
</div>

<?php
var_dump($parametro);
var_dump($retencion); ?>
