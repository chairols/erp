<div class="invoice">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                Retención # <?= str_pad($retencion['punto'], 4, '0', STR_PAD_LEFT) ?>-<?= str_pad($retencion['numero'], 8, '0', STR_PAD_LEFT) ?>
                <input type="hidden" id="idretencion" value="<?= $retencion['idretencion'] ?>">
            </h2>
        </div>
    </div>
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            De
            <address>
                <strong><?= $parametro['empresa'] ?></strong>
                <br>
                <?= $parametro['direccion'] ?>
                <br>
                (<?= $parametro['codigo_postal'] ?>)
                <br>
                <?= $parametro['provincia']['provincia'] ?>
                <br>
                CUIT: <?= $parametro['cuit'] ?>
                <br>
                IIBB: <?= $parametro['ingresos_brutos'] ?>
                <br>
                <?= $parametro['iva']['tipo_responsable'] ?>
            </address>
        </div>
        <div class="col-sm-4 invoice-col">
            Para
            <address>
                <strong><?= $retencion['proveedor'] ?></strong>
                <br>
                <?= $retencion['direccion'] ?>
                <br>
                (<?= $retencion['codigopostal'] ?>) <?= $retencion['localidad'] ?>
                <br>
                <?= $retencion['provincia'] ?>
                <br>
                CUIT: <?= $retencion['cuit'] ?>
                <br>
                IIBB: <?= $retencion['iibb'] ?>
                <br>
                <?= $retencion['iva']['tipo_responsable'] ?>
            </address>
        </div>
        <div class="col-sm-4 invoice-col">
            Jurisdicción
            <address>
                <strong><?= $retencion['jurisdiccion']['provincia'] ?></strong>
                <br>
                <strong>Retención # <?= str_pad($retencion['punto'], 4, '0', STR_PAD_LEFT) ?>-<?= str_pad($retencion['numero'], 8, '0', STR_PAD_LEFT) ?></strong>
                <br>
                <strong>Fecha: </strong><?= $retencion['fecha'] ?>
                <br>
                <strong>Alícuota: </strong>
                <div class="input-group input-group-sm">
                    <input type="text" id="alicuota" value="<?= $retencion['alicuota'] ?>" class="inputMask form-control" data-inputmask="'mask': '9.99'" disabled>
                    <span class="input-group-btn" id="alicuota-div-boton-editar">
                        <button id="alicuota-editar-boton" class="btn btn-info btn-flat" type="button">Editar</button>
                    </span>
                    <span class="input-group-btn" id="alicuota-div-boton-guardar" style="display: none;">
                        <button id="alicuota-guardar-boton" class="btn btn-info btn-flat" type="button">Guardar</button>
                    </span>
                    <span class="input-group-btn" id="alicuota-div-boton-loading" style="display: none;">
                        <button id="alicuota-loading-boton" class="btn btn-info btn-flat" type="button">
                            <i class="fa fa-refresh fa-spin"></i>
                        </button>
                    </span>
                </div>
            </address>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3 txC">
            <strong>Tipo de Comprobante</strong>
            <select id="tipo_comprobante" class="form-control chosenSelect">
                <?php foreach($tipos_comprobantes as $tipo_comprobante) { ?>
                <option value="<?=$tipo_comprobante['idtipo_comprobante']?>"><?=$tipo_comprobante['tipo_comprobante']?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-xs-2 txC">
            <strong>Punto de Venta</strong><br>
            <input type="text" id="punto_de_venta" class="form-control input-sm inputMask" data-inputmask="'mask': '9{1,4}'">
        </div>
        <div class="col-xs-2 txC">
            <strong>Comprobante</strong><br>
            <input type="text" id="comprobante" class="form-control input-sm inputMask" data-inputmask="'mask': '9{1,8}'">
        </div>
        <div class="col-xs-2 txC">
            <strong>Fecha</strong><br>
            <input type="text" id="fecha" value="<?= date('d/m/Y') ?>" class="form-control input-sm datePicker" placeholder="Seleccione una fecha">
        </div>
        <div class="col-xs-2 txC">
            <strong>Base Imponible</strong><br>
            <input type="text" id="base_imponible" class="form-control input-sm inputMask" data-inputmask="'mask': '[-]9{1,17}.99'">
        </div>
        <div class="col-xs-1">
            <br>
            <span id="div-boton-agregar" class="input-group-btn">
                <button id="agregar" class="btn btn-info btn-sm btn-flat" type="button">Agregar</button>
            </span>
            <span id="div-boton-loading" class="input-group-btn" style="display: none;">
                <button class="btn btn-info btn-sm btn-flat" type="button">
                    <i class="fa fa-refresh fa-spin"></i>
                </button>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 table-responsive" id="body-tabla-items">

        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <a href="/retenciones/pdf/<?= $retencion['idretencion'] ?>/" target="_blank">
                <button class="btn btn-primary pull-right" type="button" style="margin-right: 5px;">
                    <i class="fa fa-download"></i> Generar PDF
                </button>
            </a>
        </div>
    </div>
</div>