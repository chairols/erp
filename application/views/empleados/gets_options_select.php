<select id="<?= $id ?>" class="form-control chosenSelect">
    <?php foreach ($calificaciones as $calificacion) { ?>
        <option value="<?= $calificacion['idcalificacion'] ?>"><?= $calificacion['calificacion'] ?></option>
    <?php } ?>
</select>

<script type="text/javascript">

    function cambiar() {
        datos = {
            'idpadre': $("#idcategoria").val(),
            'id': 'idcalificacion'
        };
        $.ajax({
            type: 'POST',
            url: '/empleados/gets_options_select/',
            data: datos,
            beforeSend: function () {
                $("#calificacion_div").html("<i class='fa fa-refresh fa-spin'></i>");
            },
            success: function (data) {
                $("#calificacion_div").html(data);
            },
            error: function (xhr) { // if error occured
                $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                        {
                            type: 'danger',
                            allow_dismiss: false
                        });
            }
        });
    }

    $("#<?= $id ?>").change(function () {
        if ('<?= $id ?>' == 'idcategoria') {
            cambiar();
        }
    });

    $(document).ready(function () {
        if ('<?= $id ?>' == 'idcategoria') {
            cambiar();
        }
    });

</script>