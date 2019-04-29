$("#agregar").click(function() {
    datos = {
        'idempleado': $("#idempleado").val(),
        'periodo_mes': $("#mes").val(),
        'periodo_anio': $("#anio").val()
    };
    $.ajax({
        type: 'POST',
        url: '/sueldos/agregar_ajax/',
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
                window.location.href = "/sueldos/modificar/" + resultado['data'] + '/';
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