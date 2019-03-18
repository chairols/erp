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
                        Pace.stop();
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