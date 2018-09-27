$("#agregar").click(function () {
    datos = {
        'jurisdiccion': $("#jurisdiccion").val(),
        'archivo': $("#archivo").val()
    };

    $.ajax({
        type: 'POST',
        url: '/padrones/procesar_ajax/',
        data: datos,
        beforeSend: function () {
            $("#procesar").hide();
            $("#agregar_loading").attr("disabled", "");
            $("#procesar_loading").show();
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
            $("#procesar").show();
            $("#procesar_loading").hide();
        },
        error: function (xhr) { // if error occured
            $("#body-tabla-items").html(xhr.responseText);
            console.log(xhr);

            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
        }
    });
});