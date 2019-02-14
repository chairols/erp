$("#modificar").click(function() {
    datos = {
        'idcliente': $("#idcliente").val(),
        'cliente': $("#cliente").val(),
        'cuit': $("#cuit").val(),
        'domicilio_fiscal': $("#domicilio_fiscal").val(),
        'codigo_postal' : $("#codigo_postal").val(),
        'localidad': $("#localidad").val(),
        'idprovincia': $("#idprovincia").val(),
        // 'idpais': $("#idpais").val(),
        // 'telefono': $("#telefono").val(),
        // 'email': $("#email").val(),
        // 'contacto': $("#contacto").val(),
        'idtipo_responsable': $("#idtipo_responsable").val(),
        'iibb': $("#iibb").val(),
        'vat': $("#vat").val(),
        'saldo_cuenta_corriente': $("#saldo_cuenta_corriente").val(),
        'saldo_inicial': $("#saldo_inicial").val(),
        'saldo_a_cuenta': $("#saldo_a_cuenta").val(),
        'idmoneda': $("#idmoneda").val(),
        'web': $("#web").val()
        // 'observaciones': $("#observaciones").val()
    };
    $.ajax({
        type: 'POST',
        url: '/clientes/modificar_ajax/',
        data: datos,
        beforeSend: function () {
            $("#modificar").hide();
            $("#modificar_loading").show();
        },
        success: function (data) {
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'danger',
                            allow_dismiss: true
                        });
            } else if (resultado['status'] == 'ok') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'success',
                            allow_dismiss: true
                        });
            }
            $("#modificar_loading").hide();
            $("#modificar").show();
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
            $("#modificar_loading").hide();
            $("#modificar").show();
        }
    });
});
