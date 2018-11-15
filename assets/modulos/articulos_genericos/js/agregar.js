$("#agregar").click(function() {
    datos = {
        'idlinea': $("#linea").val(),
        'articulo_generico': $("#articulo_generico").val(),
        'numero_orden': $("#numero_orden").val()
    };
    
    $.ajax({
        type: 'POST',
        url: '/articulos_genericos/agregar_ajax/',
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
                $("#loading").hide();
                $("#agregar").show();
            } else if (resultado['status'] == 'ok') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'success',
                            allow_dismiss: false
                        });
                $("#linea").val("");
                $("#articulo_generico").val("");
                $("#numero_orden").val("");
                $("#linea").focus();
                $("#loading").hide();
                $("#agregar").show();
            }
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