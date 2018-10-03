$("#agregar").click(function() {
    datos = {
        'idproveedor': $("#proveedor").val(),
        'idmoneda': $("#moneda").val(),
        'fecha': $("#fecha").val()
    };
    $.ajax({
        type: 'POST',
        url: '/importaciones/agregar_ajax/',
        data: datos,
        beforeSend: function () {
            $("#agregar").hide();
            $("#loading").show();
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
                window.location.href = "/importaciones/agregar_items/" + resultado['id'] + '/';
            }
            $("#loading").hide();
            $("#agregar").show();
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
            $("#loading").hide();
            $("#agregar").show();
        }
    });
});