$("#modificar").click(function() {
    datos = {
        'idlinea': $("#idlinea").val(),
        'linea': $("#linea").val(),
        'nombre_corto': $("#nombre_corto").val()
    };
    $.ajax({
        type: 'POST',
        url: '/lineas/modificar_ajax/',
        data: datos,
        beforeSend: function () {
            Pace.restart();
            $("#modificar").hide();
            $("#modificar_loading").show();
        },
        success: function (data) {
            Pace.stop();
            $("#modificar_loading").hide();
            $("#modificar").show();
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
            }
        },
        error: function (xhr) { // if error occured
            Pace.stop();
            $("#modificar_loading").hide();
            $("#modificar").show();

            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
        }
    });
});