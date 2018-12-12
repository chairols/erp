$("#agregar").click(function () {
    datos = {
        'moneda': $("#moneda").val(),
        'simbolo': $("#simbolo").val(),
        'codigo_afip': $("#codigo_afip").val()
    };
    $.ajax({
        type: 'POST',
        url: '/monedas/agregar_ajax/',
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
                            type: 'danger',
                            allow_dismiss: false
                        });
            } else if (resultado['status'] == 'ok') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'success',
                            allow_dismiss: false
                        });
                document.getElementById("moneda").value = "";
                document.getElementById("simbolo").value = "";
                document.getElementById("codigo_afip").value = "";
                $("#moneda").focus();
            }
            $("#agregar_loading").hide();
            $("#agregar").show();
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
            $("#div-boton-loading").hide();
            $("#div-boton-agregar").show();
        }
    });

});
