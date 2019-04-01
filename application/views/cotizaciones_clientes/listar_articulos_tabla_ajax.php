<table class="table table-hover table-responsive table-striped table-condensed">
    <thead>
        <tr>
            <th class="text-right">Cantidad</th>
            <th class="text-right">Artículo</th>
            <th class="text-right">Descripción</th>
            <th class="text-right">Precio</th>
            <th class="text-right">Días de Entrega</th>
            <th class="text-right">Total</th>
            <th class="text-right">Observaciones</th>
            <th class="text-right">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php $total = 0; ?>
        <?php foreach ($articulos as $articulo) { ?>
            <tr>
                <td class="text-right"><?= $articulo['cantidad'] ?></td>
                <td class="text-right"><?= $articulo['articulo']['articulo'] ?> - <?= $articulo['marca']['marca'] ?></td>
                <td class="text-right"><?= $articulo['descripcion'] ?></td>
                <td class="text-right"><?= $articulo['precio'] ?></td>
                <td class="text-right"><?= $articulo['dias_entrega'] ?></td>
                <td class="text-right"><?= number_format($articulo['precio'] * $articulo['cantidad'], 2) ?></td>
                <td class="text-right"><?= $articulo['observaciones_item'] ?></td>
                <td class="text-right">
                    <a class="hint--top hint--bounce hint--info editar_articulo" aria-label="Modificar" idcotizacion_cliente_item="<?= $articulo['idcotizacion_cliente_item'] ?>">
                        <button type="button" id="editar" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#editar_articulo">
                            <i class="fa fa-edit"></i>
                        </button>
                    </a>
                    <a class="hint--top hint--bounce hint--error borrar_articulo" descripcion="<?= $articulo['descripcion'] ?>" id="<?= $articulo['idcotizacion_cliente_item'] ?>" aria-label="Eliminar">
                        <button class="btn btn-danger btn-xs" type="button">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </a>
                </td>
                <?php $total += $articulo['precio'] * $articulo['cantidad']; ?>
            </tr>
        <?php } ?>
        <tr>
            <td class="text-right">&nbsp;</td>
            <td class="text-right">&nbsp;</td>
            <td class="text-right">&nbsp;</td>
            <td class="text-right">&nbsp;</td>
            <td class="text-right">&nbsp;</td>
            <td class="text-right"><strong><?= number_format($total, 2) ?></strong></td>
            <td class="text-right">&nbsp;</td>
            <td class="text-right">&nbsp;</td>
        </tr>
    </tbody>
</table>

<div class="modal fade" id="editar_articulo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Modificar Artículo</h4>
            </div>
            <input type="hidden" id="idcotizacion_cliente_item_editar">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <h4>Cantidad</h4>
                        <input type="text" id="cantidad_editar" class="form-control inputMask" data-inputmask="'mask': '9{1,8}'">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h4>Artículo (No se muestra)</h4>
                        <input type="text" id="articulo_editar" class="form-control" disabled="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h4>Descripción</h4>
                        <input type="text" id="descripcion_editar" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h4>Precio</h4>
                        <input type="text" id="precio_editar" class="form-control inputMask" data-inputmask="'mask': '9{1,17}.99'">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h4>Días de Entrega</h4>
                        <input type="text" id="dias_entrega_editar" class="form-control inputMask" data-inputmask="'mask': '9{1,8}'">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h4>Observaciones (No se muestra)</h4>
                        <textarea id="observaciones_item_editar" class="form-control"></textarea>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-2 col-xs-12 col-lg-offset-5">
                        <button type="button" class="btn btn-primary" id="modificar_item">
                            Actualizar
                        </button>
                        <button type="button" class="btn btn-primary" id="modificar_item_loading" style="display: none;">
                            <i class="fa fa-refresh fa-spin"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(".borrar_articulo").click(function () {
        console.log(this);
        idcotizacion_cliente_item = this.attributes.id.value;
        descripcion = this.attributes.descripcion.value;

        alertify.confirm("Se eliminará el item <strong>" + descripcion + "</strong>", function (e) {
            if (e) {
                datos = {
                    'idcotizacion_cliente_item': idcotizacion_cliente_item
                };
                $.ajax({
                    type: 'POST',
                    url: '/cotizaciones_clientes/borrar_articulo_ajax/',
                    data: datos,
                    beforeSend: function () {
                        Pace.restart();
                    },
                    success: function (data) {
                        Pace.stop();
                        resultado = $.parseJSON(data);
                        if (resultado['status'] == 'error') {
                            $.notify('<strong>' + resultado['data'] + '</strong>',
                                    {
                                        type: 'danger'
                                    });
                        } else if (resultado['status'] == 'ok') {
                            $.notify('<strong>' + resultado['data'] + '</strong>',
                                    {
                                        type: 'success'
                                    });
                            actualizar_articulos();
                        }
                    },
                    error: function (xhr) { // if error occured
                        $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                                {
                                    type: 'danger'
                                });
                        Pace.stop();
                    }
                });
            }
        });

    });

    $(".editar_articulo").click(function () {
        datos = {
            'idcotizacion_cliente_item': this.attributes.idcotizacion_cliente_item.value
        };

        $.ajax({
            type: 'POST',
            url: '/cotizaciones_clientes/get_articulo_where_json/',
            data: datos,
            beforeSend: function () {
                Pace.restart();
            },
            success: function (data) {
                Pace.stop();
                resultado = $.parseJSON(data);
                $("#idcotizacion_cliente_item_editar").val(resultado['idcotizacion_cliente_item']);
                $("#cantidad_editar").val(resultado['cantidad']);
                $("#articulo_editar").val(resultado['articulo']['articulo']);
                $("#descripcion_editar").val(resultado['descripcion']);
                $("#precio_editar").val(resultado['precio']);
                $("#dias_entrega_editar").val(resultado['dias_entrega']);
                $("#observaciones_item_editar").val(resultado['observaciones_item']);
            },
            error: function (xhr) { // if error occured
                $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                        {
                            type: 'danger',
                            z_index: 2000
                        });
                Pace.stop();
            }
        });
    });

    $("#modificar_item").click(function () {
        datos = {
            'idcotizacion_cliente_item': $("#idcotizacion_cliente_item_editar").val(),
            'cantidad': $("#cantidad_editar").val(),
            'descripcion': $("#descripcion_editar").val(),
            'precio': $("#precio_editar").val(),
            'dias_entrega': $("#dias_entrega_editar").val(),
            'observaciones_item': $("#observaciones_item_editar").val()
        };

        $.ajax({
            type: 'POST',
            url: '/cotizaciones_clientes/modificar_articulo_ajax/',
            data: datos,
            beforeSend: function () {
                $("#modificar_item").hide();
                $("#modificar_item_loading").show();
                Pace.restart();
            },
            success: function (data) {
                Pace.stop();
                $("#modificar_item_loading").hide();
                $("#modificar_item").show();
                resultado = $.parseJSON(data);
                if (resultado['status'] == 'error') {
                    $.notify('<strong>' + resultado['data'] + '</strong>',
                            {
                                type: 'danger',
                            z_index: 2000
                            });
                } else if (resultado['status'] == 'ok') {
                    $.notify('<strong>' + resultado['data'] + '</strong>',
                            {
                                type: 'success',
                            z_index: 2000
                            });
                }

            },
            error: function (xhr) { // if error occured
                $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                        {
                            type: 'danger',
                            z_index: 2000
                        });
                $("#modificar_item_loading").hide();
                $("#modificar_item").show();
                Pace.stop();
            }
        });
    });
    
    $(document).on('hide.bs.modal','#editar_articulo', function() {
        actualizar_articulos();
    });
</script>