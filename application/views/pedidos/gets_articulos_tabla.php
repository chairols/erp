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
                            gets_articulos();
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
</script>