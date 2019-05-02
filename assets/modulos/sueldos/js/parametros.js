$("#actualizar").click(function() {
    datos = {
        'comida': $("#comida").val()
    };
    $.ajax({
        type: 'POST',
        url: '/sueldos/parametros_ajax/',
        data: datos,
        beforeSend: function () {
            $("#actualizar").hide();
            $("#actualizar_loading").show();
            Pace.restart();
        },
        success: function (data) {
            $("#actualizar_loading").hide();
            $("#actualizar").show();
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
            }
        },
        error: function (xhr) { // if error occured
            $("#actualizar_loading").hide();
            $("#actualizar").show();
            Pace.stop();

            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
        }
    });
});