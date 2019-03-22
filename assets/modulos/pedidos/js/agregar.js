$("#TextAutoCompletecliente").focusout(function() {
    gets_sucursales();
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