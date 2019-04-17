<!-- Date Picker -->
<!--<link rel="stylesheet" href="/assets/vendors/datepicker/datepicker3.css">-->

<?php $total = 0; ?>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Cantidad</th>
            <th>Pendiente</th>
            <th>Artículo</th>
            <th>Marca</th>
            <th>Imprime Marca</th>
            <th>Almacén</th>
            <th>Precio Unitario</th>
            <th>Precio Total</th>
            <th>Entrega</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($articulos as $articulo) { ?>
            <tr>
                <td><?= $articulo['cantidad'] ?></td>
                <td><?= $articulo['cantidad_pendiente'] ?></td>
                <td><?= $articulo['articulo'] ?></td>
                <td><?= $articulo['marca'] ?></td>
                <td><?= $articulo['muestra_marca'] ?></td>
                <td>
                    <?php if ($articulo['almacen'] == '1') { ?>
                        <span class="badge bg-red"><?= $articulo['almacen'] ?></span>
                    <?php } else if ($articulo['almacen'] == '2') { ?>
                        <span class="badge bg-green"><?= $articulo['almacen'] ?></span>
                    <?php } ?>
                </td>
                <td class="text-right"><?= $articulo['precio'] ?></td>
                <td class="text-right"><?= number_format($articulo['cantidad_pendiente'] * $articulo['precio'], 2) ?></td>
                <td class="text-right"><?= $articulo['fecha_formateada'] ?></td>
                <td>
                    <a class="hint--top hint--bounce hint--info editar_articulo" aria-label="Modificar" idpedido_item="<?= $articulo['idpedido_item'] ?>">
                        <button type="button" id="editar" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#editar_articulo">
                            <i class="fa fa-edit"></i>
                        </button>
                    </a>
                    <button class="btn btn-danger btn-xs hint--top hint--bounce hint--error borrar_articulo" descripcion="<?= $articulo['articulo'] ?>" id="<?= $articulo['idpedido_item'] ?>" aria-label="Eliminar" type="button">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </td>
            </tr>
            <?php $total += ($articulo['cantidad_pendiente'] * $articulo['precio']); ?>
        <?php } ?>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">Total:</td>
            <td class="text-right"><?= number_format($total, 2); ?></td>
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
            <input type="hidden" id="idpedido_item_editar">
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-md-3">Cantidad</label>
                        <div class="col-md-6">
                            <input type="text" id="cantidad_editar" class="form-control inputMask" data-inputmask="'mask': '9{1,8}'">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Cantidad Pendiente</label>
                        <div class="col-md-6">
                            <input type="text" id="cantidad_pendiente_editar" class="form-control inputMask" data-inputmask="'mask': '9{1,8}'">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Artículo</label>
                        <div class="col-md-6">
                            <input type="text" id="articulo_editar" class="form-control" disabled="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Imprime Marca</label>
                        <div class="col-md-6">
                            <select id="muestra_marca_editar" class="form-control">
                                <option value="S">SI</option>
                                <option value="N">NO</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Almacén</label>
                        <div class="col-md-6">
                            <input type="text" id="almacen_editar" class="form-control inputMask" data-inputmask="'mask' : '9{1,1}'">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Precio</label>
                        <div class="col-md-6">
                            <input type="text" id="precio_editar" class="form-control inputMask" data-inputmask="'mask': '9{1,17}.99'">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Fecha de Entrega</label>
                        <div class="col-md-6">
                            <input type="text" id="fecha_entrega_editar" class="form-control" data-inputmask="'mask' : '99/99/9999'" placeholder="Seleccione una fecha">
                        </div>
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

<!-- Input Mask -->
<script src="/assets/vendors/jquery-mask/src/jquery.mask.js"></script>
<script src="/assets/vendors/inputmask3/jquery.inputmask.bundle.min.js"></script>

<script type="text/javascript">
    $(".borrar_articulo").click(function () {
        console.log(this);
        idpedido_item = this.attributes.id.value;
        descripcion = this.attributes.descripcion.value;

        alertify.confirm("Se eliminará el item <strong>" + descripcion + "</strong>", function (e) {
            if (e) {
                datos = {
                    'idpedido_item': idpedido_item
                };
                $.ajax({
                    type: 'POST',
                    url: '/pedidos/borrar_articulo_ajax/',
                    data: datos,
                    beforeSend: function () {
                        //Pace.restart();
                    },
                    success: function (data) {
                        //Pace.stop();
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
                            gets_articulos();
                        }
                    },
                    error: function (xhr) { // if error occured
                        $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                                {
                                    type: 'danger'
                                });
                        //Pace.stop();
                    }
                });
            }
        });

    });

    $(".editar_articulo").click(function () {
        datos = {
            'idpedido_item': this.attributes.idpedido_item.value
        };

        $.ajax({
            type: 'POST',
            url: '/pedidos/get_articulo_where_json/',
            data: datos,
            beforeSend: function () {
                Pace.restart();
            },
            success: function (data) {
                Pace.stop();
                resultado = $.parseJSON(data);
                $("#idpedido_item_editar").val(resultado['idpedido_item']);
                $("#cantidad_editar").val(resultado['cantidad']);
                $("#cantidad_pendiente_editar").val(resultado['cantidad_pendiente']);
                $("#articulo_editar").val(resultado['articulo']['articulo']);
                $("#muestra_marca_editar").val(resultado['muestra_marca']);
                $("#almacen_editar").val(resultado['almacen']);
                $("#precio_editar").val(resultado['precio']);
                $("#fecha_entrega_editar").val(resultado['fecha_formateada']);
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

    
    $(document).ready(function () {
        $("#fecha_entrega_editar").inputmask();
    });
    
    $("#modificar_item").click(function () {
        datos = {
            'idpedido': $("#idpedido").val(),
            'idpedido_item': $("#idpedido_item_editar").val(),
            'cantidad': $("#cantidad_editar").val(),
            'cantidad_pendiente': $("#cantidad_pendiente_editar").val(),
            'muestra_marca': $("#muestra_marca_editar").val(),
            'almacen': $("#almacen_editar").val(),
            'precio': $("#precio_editar").val(),
            'fecha_entrega': $("#fecha_entrega_editar").val()
        };

        $.ajax({
            type: 'POST',
            url: '/pedidos/modificar_item_ajax/',
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
        gets_articulos();
        $(".modal-backdrop").hide();
    });
    
</script>

