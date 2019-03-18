$("#cliente").change(function() {
    actualizar_sucursal($("#cliente").val());
})

function actualizar_sucursal(id) {
    datos = {
        'idcliente': id
    };
    
    $.ajax({
        type: 'POST',
        url: '/clientes/gets_sucursales_select/',
        data: datos,
        beforeSend: function () {
            Pace.restart();
        },
        success: function (data) {
            $("#sucursal").html(data);
            Pace.stop();
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
            Pace.stop();
        }
    });
}

$("#agregar").click(function() {
    datos = {
        'idcliente': $("#cliente").val(),
        'idsucursal': $("#idsucursal").val(),
        'idmoneda': $("#idmoneda").val(),
        'atencion': $("#atencion").val(),
        'fecha': $("#fecha").val(),
        'observaciones': $("#observaciones").val()
    };
    $.ajax({
        type: 'POST',
        url: '/cotizaciones_clientes/agregar_ajax/',
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
                $("#agregar_loading").hide();
                $("#agregar").show();
            } else if (resultado['status'] == 'ok') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'success'
                        });
                window.location.href = "/cotizaciones_clientes/modificar/" + resultado['data'] + '/';
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