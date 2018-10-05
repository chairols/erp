$("#confirmar").click(function () {
    datos = {
        'idproveedor': $("#idproveedor").val(),
        'fecha_confirmacion': $("#fecha_confirmacion").val()
    };
    $.ajax({
        type: 'POST',
        url: '/importaciones/confirmacion_ajax/',
        data: datos,
        beforeSend: function () {
            $("#confirmar").hide();
            $("#confirmar_loading").show();
        },
        success: function (data) {
            $("#confirmar").show();
            $("#confirmar_loading").hide();
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
                        window.location.href = "/importaciones/confirmacion_items/" + resultado['id'] + "/";
            }
        },
        error: function (xhr) { // if error occured
            $("#confirmar").show();
            $("#confirmar_loading").hide();

            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });

        }
    });

});