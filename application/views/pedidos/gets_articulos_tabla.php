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
                        <h4>Cantidad Pendiente</h4>
                        <input type="text" id="cantidad_pendiente_editar" class="form-control inputMask" data-inputmask="'mask': '9{1,8}'">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h4>Artículo</h4>
                        <input type="text" id="articulo_editar" class="form-control" disabled="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h4>Imprime Marca</h4>
                        <input type="text" id="descripcion_editar" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h4>Almacén</h4>
                        <input type="text" id="almacen_editar" class="form-control inputMask" data-inputmask="'mask' : '9{1,1}'">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h4>Precio</h4>
                        <input type="text" id="precio_editar" class="form-control inputMask" data-inputmask="'mask': '9{1,17}.99'">
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
</script>