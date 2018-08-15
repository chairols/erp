<table class="table table-bordered table-condensed table-hover table-responsive table-striped">
    <thead>
        <tr>
            <th>Genérico</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($articulos as $articulo) { ?>
            <tr>
                <td><?= $articulo['text'] ?></td>
                <td>
                    <button class="btn btn-xs btn-danger borrargenerico hint--bottom hint--bounce hint--error" aria-label="Eliminar <?= $articulo['text'] ?>" idgenerico="<?= $articulo['id'] ?>">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
    $(".borrargenerico").click(function () {
        console.log(this.attributes.idgenerico.value);

        datos = {
            'idarticulo_generico': this.attributes.idgenerico.value
        };
        $.ajax({
            type: 'POST',
            url: '/articulos_genericos/borrar_ajax/',
            data: datos,
            beforeSend: function () {

            },
            success: function (data) {
                resultado = $.parseJSON(data);
                if (resultado['status'] == 'error') {
                    notificarErrorEnModal(resultado['data']);
                } else if (resultado['status'] == 'ok') {
                    notificarOKEnModal(resultado['data']);
                    $("#buscador").keyup();
                }
            }
        });
    });
</script>