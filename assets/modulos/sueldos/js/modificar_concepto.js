$("#modificar").click(function() {
    datos = {
        'idsueldo_concepto': $("#idsueldo_concepto").val(),
        'sueldo_concepto': $("#sueldo_concepto").val(),
        'tipo': $("#tipo").val(),
        'cantidad': $("#cantidad").val(),
        'unidad': $("#unidad").val()
    };
    $.ajax({
        type: 'POST',
        url: '/sueldos/conceptos_modificar_ajax/',
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
            $("#modificar_loading").hide();
            $("#modificar").show();
            Pace.stop();
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
        }
    });
});