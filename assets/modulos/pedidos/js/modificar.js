$(document).ready(function() {
    actualizar_sucursal($("#cliente").val());
    gets_condiciones_de_venta();
});

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
            gets_transportes();
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

function gets_transportes() {
    datos = {
        'idcliente_sucursal': $("#idcliente_sucursal").val()
    };
    
    $.ajax({
        type: 'POST',
        url: '/clientes/gets_transportes_select/',
        data: datos,
        beforeSend: function () {
            $("#transporte").html("<i class='fa fa-refresh fa-spin'></i>");
        },
        success: function (data) {
            $("#transporte").html(data);
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
        }
    });
    
}

function gets_condiciones_de_venta() {
    datos = {
        'idcliente': $("#cliente").val()
    };
    
    $.ajax({
        type: 'POST',
        url: '/clientes/gets_condiciones_de_venta_select/',
        data: datos,
        beforeSend: function () {
            $("#condicion").html("<i class='fa fa-refresh fa-spin'></i>");
        },
        success: function (data) {
            $("#condicion").html(data);
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
        }
    });
    
}