<table class="table table-striped">
    <thead>
        <tr>
            <th>Comprobante</th>
            <th>Fecha</th>
            <th>Base Imposible</th>
            <th>Monto Retenido</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item) { ?>
            <tr>
                <td><?=$item['tipo_comprobante']?> <?= str_pad($item['punto_de_venta'], 4, '0', STR_PAD_LEFT); ?>-<?= str_pad($item['comprobante'], 8, '0', STR_PAD_LEFT); ?></td>
                <td><?= $item['fecha_formateada'] ?></td>
                <td><?= $item['base_imponible'] ?></td>
                <td><?= number_format(round((($item['base_imponible'] * $retencion['alicuota']) / 100), 2), 2) ?></td>
                <td>
                    <button class="btn btn-danger btn-xs" onclick="borrar_item(<?= $item['idretencion_item'] ?>, '<?= str_pad($item['punto_de_venta'], 4, '0', STR_PAD_LEFT); ?>-<?= str_pad($item['comprobante'], 8, '0', STR_PAD_LEFT); ?>')">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<div class="row">
    <div class="col-xs-6"></div>
    <div class="col-xs-6">
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <th style="width: 50%">Monto Retenido</th>
                        <td class="input-group input-group-sm">
                            <input type="text" id="monto_retenido" value="<?= $retencion['monto_retenido'] ?>" class="inputMask form-control" data-inputmask="'mask': '[-]9{1,12}.99'" disabled> 
                            <span class="input-group-btn" id="monto-retenido-div-boton-editar">
                                <button id="monto-retenido-editar-boton" class="btn btn-info btn-flat" type="button">Editar</button>
                            </span>
                            <span class="input-group-btn" id="monto-retenido-div-boton-guardar" style="display: none;">
                                <button id="monto-retenido-guardar-boton" class="btn btn-info btn-flat" type="button">Guardar</button>
                            </span>
                            <span class="input-group-btn" id="monto-retenido-div-boton-loading" style="display: none;">
                                <button id="monto-retenido-loading-boton" class="btn btn-info btn-flat" type="button">
                                    <i class="fa fa-refresh fa-spin"></i>
                                </button>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">



    $("#monto-retenido-editar-boton").click(function () {
        $("#monto_retenido").removeAttr("disabled");
        $("#monto-retenido-div-boton-editar").hide();
        $("#monto-retenido-div-boton-guardar").show();
    });

    $("#monto-retenido-guardar-boton").click(function () {
        $("#monto-retenido-div-boton-guardar").hide();


        datos = {
            'monto_retenido': $("#monto_retenido").val(),
            'idretencion': $("#idretencion").val()
        };
        $.ajax({
            type: 'POST',
            url: '/retenciones/update_monto_retenido/',
            data: datos,
            beforeSend: function () {
                $("#monto-retenido-div-boton-loading").show();
            },
            success: function (data) {
                resultado = $.parseJSON(data);
                if (resultado['status'] == 'error') {
                    $.notify('<strong>' + resultado['data'] + '</strong>',
                            {
                                type: 'danger',
                                allow_dismiss: false
                            });
                    $("#monto-retenido-div-boton-loading").hide();
                    $("#monto-retenido-div-boton-guardar").show();
                } else if (resultado['status'] == 'ok') {
                    $.notify('<strong>' + resultado['data'] + '</strong>',
                            {
                                type: 'success',
                                allow_dismiss: false
                            });
                    $("#monto-retenido-div-boton-loading").hide();
                    $("#monto-retenido-div-boton-editar").show();
                    $("#monto_retenido").attr("disabled", "");
                }

            },
            error: function (xhr) { // if error occured
                $("#body-tabla-items").html(xhr.responseText);
                console.log(xhr);

                $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                        {
                            type: 'danger',
                            allow_dismiss: false
                        });
            }
        });
    });
</script>