<ul class="todo-list ui-sortable">
    <?php
    while ($archivo = readdir($archivos)) {
        if ($archivo != '.' && $archivo != '..') {
            $flag = false;
            $array = explode('.', $archivo);
            if (strtoupper($array[1]) == 'ZIP') {
                $flag = true;
            }
            ?>
            <li>
                <span class="text"><?= $archivo ?></span>
                <div class="tools">
                    <?php if ($flag) { ?>
                        <i valor="<?= $archivo ?>" class="fa fa-file-zip-o extraer"></i>
                    <?php } ?>
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-trash-o borrar_archivo" valor="<?= $archivo ?>" class="fa fa-trash-o"></i>
                </div>
            </li>
            <?php
        }
    }
    ?>
</ul>

<script type="text/javascript">
    $(".extraer").click(function () {
        datos = {
            'archivo': this.attributes.valor.value
        };
        $.ajax({
            type: 'POST',
            url: '/archivos/extraer/',
            data: datos,
            beforeSend: function () {
                //$("#ver_archivos").html('<h1 class="text-center"><i class="fa fa-refresh fa-spin"></i></h1>');
            },
            success: function (data) {
                resultado = $.parseJSON(data);
                if (resultado['status'] == 'error') {
                    $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'danger',
                            allow_dismiss: false
                        });
                } else if (resultado['status'] == 'ok') {
                    $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'success',
                            allow_dismiss: false
                        });
                }
                cargar_archivos();
            },
            error: function (xhr) { // if error occured
                $("#ver_archivos").html(xhr.responseText);

                $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                        {
                            type: 'danger',
                            allow_dismiss: false
                        });
            }
        });
    });

    $(".borrar_archivo").click(function () {

        datos = {
            'archivo': this.attributes.valor.value
        };
        $.ajax({
            type: 'POST',
            url: '/archivos/borrar_archivo_ajax/',
            data: datos,
            beforeSend: function () {
                $("#ver_archivos").html('<h1 class="text-center"><i class="fa fa-refresh fa-spin"></i></h1>');
            },
            success: function (data) {
                cargar_archivos();
            },
            error: function (xhr) { // if error occured
                $("#ver_archivos").html(xhr.responseText);

                $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                        {
                            type: 'danger',
                            allow_dismiss: false
                        });
            }
        });

    });
</script>