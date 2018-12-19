<table class="table table-condensed table-striped table-hover table-responsive table-bordered">
    <thead>
        <tr>
            <th>Archivo</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($archivos as $archivo) { ?>
            <tr>
                <td><?= $archivo['nombre'] ?></td>
                <td>
                    <a href="<?= $archivo['url'] ?>" target="_blank" class="hint--top hint--bounce hint--info" aria-label="Descargar">
                        <button class="btn btn-primary btn-xs" type="button">
                            <i class="fa fa-download"></i>
                        </button>
                    </a>
                    <a class="hint--top hint--bounce hint--error borrar_archivo" id="<?= $archivo['idcotizacion_proveedor_archivo'] ?>" aria-label="Eliminar">
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
    $(".borrar_archivo").click(function () {
        datos = {
            'idcotizacion_proveedor_archivo': this.id
        };
        console.log(datos);
        
        $.ajax({
            type: 'POST',
            url: '/cotizaciones_proveedores/borrar_archivo_ajax/',
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
                    actualizar_archivos();
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