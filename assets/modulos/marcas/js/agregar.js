$(document).ready(function () {
    $(".my-colorpicker").colorpicker();
});

$("#agregar").click(function () {
    datos = {
        'marca': $("#marca").val(),
        'nombre_corto': $("#nombre_corto").val(),
        'color_fondo': $("#color_fondo").val(),
        'color_letra': $("#color_letra").val()
    };
    $.ajax({
        type: 'POST',
        url: '/marcas/agregar_ajax/',
        data: datos,
        beforeSend: function () {
            Pace.restart();
            $("#agregar").hide();
            $("#agregar_loading").show();
        },
        success: function (data) {
            Pace.stop();
            $("#agregar_loading").hide();
            $("#agregar").show();
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
                $("#marca").val("");
                $("#nombre_corto").val("");
                $("#color_fondo").val("");
                $("#color_letra").val("");
                $("#marca").focus();
            }

        },
        error: function (xhr) { // if error occured
            $("#agregar_loading").hide();
            $("#agregar").show();

            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
            Pace.stop();
        }
    });
});