$("#agregar").click(function () {
    datos = {
        'idproveedor': $("#proveedor").val(),
        'idmoneda': $("#idmoneda").val(),
        'fecha': $("#fecha").val()
    };
    $.ajax({
        type: 'POST',
        url: '/cotizaciones_proveedores/agregar_ajax/',
        data: datos,
        beforeSend: function () {
            $("#agregar").hide();
            $("#agregar_loading").show();
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

            }
            $("#agregar_loading").hide();
            $("#agregar").show();
        },
        error: function (xhr) { // if error occured
            $("#agregar_loading").hide();
            $("#agregar").show();

            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
        }
    });
});