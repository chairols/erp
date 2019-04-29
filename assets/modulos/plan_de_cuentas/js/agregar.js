$("#agregar").click(function() {
    datos = {
        'idplan_de_cuenta': $("#idplan_de_cuenta").val(),
        'plan_de_cuenta': $("#plan_de_cuenta").val(),
        'idpadre': $("#plan").val(),
        'imputa_caja': $("#imputa_caja").val(),
        'imputa_mayor': $("#imputa_mayor").val(),
        'cuenta_corriente': $("#cuenta_corriente").val(),
        'ajuste': $("#ajuste").val()
    };
    $.ajax({
        type: 'POST',
        url: '/plan_de_cuentas/agregar_ajax/',
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
                $("#idplan_de_cuenta").val("");
                $("#plan_de_cuenta").val("");
                $("#TextAutoCompleteplan").val("");
                $("#plan").val("");
                $("#idplan_de_cuenta").focus();
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