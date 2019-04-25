$("#agregar").click(function() {
    datos = {
        'idsueldo_concepto': $("#idsueldo_concepto").val(),
        'sueldo_concepto': $("#sueldo_concepto").val(),
        'tipo': $("#tipo").val(),
        'cantidad': $("#cantidad").val(),
        'unidad': $("#unidad").val()
    };
    $.ajax({
        type: 'POST',
        url: '/sueldos/agregar_concepto_ajax/',
        data: datos,
        beforeSend: function () {
            $("#agregar").hide();
            $("#agregar_loading").show();
        },
        success: function (data) {
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
                $("#idsueldo_concepto").val("");
                $("#sueldo_concepto").val("");
                $("#cantidad").val("");
                $("#idsueldo_concepto").focus();
            }
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