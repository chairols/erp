$("#TextAutoCompletecliente").focusout(function() {
    gets_sucursales();
    gets_condiciones_de_venta();
    gets_monedas();
});


function gets_sucursales() {
    datos = {
        'idcliente': $("#cliente").val()
    };
    $.ajax({
        type: 'POST',
        url: '/clientes/gets_sucursales_select/',
        data: datos,
        beforeSend: function () {
            $("#div-sucursal").html("<i class='fa fa-refresh fa-spin'></i>");
        },
        success: function (data) {
            $("#div-sucursal").html(data);
            gets_transportes();
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

function gets_transportes() {
    datos = {
        'idsucursal': $("#idsucursal").val()
    };
    
    $.ajax({
        type: 'POST',
        url: '/clientes/gets_transportes_select/',
        data: datos,
        beforeSend: function () {
            $("#div-transportes").html("<i class='fa fa-refresh fa-spin'></i>");
        },
        success: function (data) {
            $("#div-transportes").html(data);
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
            $("#div-condiciones").html("<i class='fa fa-refresh fa-spin'></i>");
        },
        success: function (data) {
            $("#div-condiciones").html(data);
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

function gets_monedas() {
    datos = {
        'idcliente': $("#cliente").val()
    };
    
    $.ajax({
        type: 'POST',
        url: '/clientes/gets_monedas_select/',
        data: datos,
        beforeSend: function () {
            $("#div-monedas").html("<i class='fa fa-refresh fa-spin'></i>");
        },
        success: function (data) {
            $("#div-monedas").html(data);
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