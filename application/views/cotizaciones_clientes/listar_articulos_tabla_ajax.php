<table class="table table-hover table-responsive table-striped table-condensed">
    <thead>
        <tr>
            <th class="text-right">Cantidad</th>
            <th class="text-right">Artículo</th>
            <th class="text-right">Descripción</th>
            <th class="text-right">Precio</th>
            <th class="text-right">Fecha de Entrega</th>
            <th class="text-right">Total</th>
            <th class="text-right">Observaciones</th>
            <th class="text-right">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($articulos as $articulo) { ?>
            <tr>
                <td class="text-right"><?= $articulo['articulo']['articulo'] ?> - <?= $articulo['marca']['marca'] ?></td>
                <td class="text-right"><?= $articulo['precio'] ?></td>
                <td class="text-right"><?= $articulo['cantidad'] ?></td>
                <td class="text-right"><?= $articulo['fecha_formateada'] ?></td>
                <td class="text-right"><?= number_format($articulo['precio'] * $articulo['cantidad'], 2) ?></td>
                <td class="text-right">
                    <a class="hint--top hint--bounce hint--error borrar_articulo" id="<?= $articulo['idcotizacion_proveedor_item']?>" aria-label="Eliminar">
                        <button class="btn btn-danger btn-xs" type="button">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
    $(".borrar_articulo").click(function () {
        datos = {
            'idcotizacion_proveedor_item': this.id
        };
        console.log(datos);
        
        $.ajax({
            type: 'POST',
            url: '/cotizaciones_proveedores/borrar_articulo_ajax/',
            data: datos,
            beforeSend: function () {
                
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
            },
            error: function (xhr) { // if error occured
                $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                        {
                            type: 'danger'
                        });
            }
        });
    });
</script>