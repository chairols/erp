$("#agregar").click(function() {
    datos = {
        'proveedor': $("#proveedor").val(),
        'cuit': $("#cuit").val(),
        'domicilio': $("#domicilio").val(),
        'codigo_postal' : $("#codigo_postal").val(),
        'localidad': $("#localidad").val(),
        'idprovincia': $("#idprovincia").val(),
        'idpais': $("#idpais").val(),
        'telefono': $("#telefono").val(),
        'email': $("#email").val(),
        'contacto': $("#contacto").val(),
        'idtipo_responsable': $("#idtipo_responsable").val(),
        'iibb': $("#iibb").val(),
        'vat': $("#vat").val(),
        'saldo_cuenta_corriente': $("#saldo_cuenta_corriente").val(),
        'saldo_inicial': $("#saldo_inicial").val(),
        'saldo_a_cuenta': $("#saldo_a_cuenta").val(),
        'idmoneda': $("#idmoneda").val(),
        'web': $("#web").val(),
        'observaciones': $("#observaciones").val()
    };
    $.ajax({
        type: 'POST',
        url: '/proveedores/agregar_ajax/',
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
                            allow_dismiss: true
                        });
            } else if (resultado['status'] == 'ok') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'success',
                            allow_dismiss: true
                        });
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
            $("#agregar_loading").hide();
            $("#agregar").show();        
        }
    });
});