$("#TextAutoCompletecliente").focusout(function() {
    gets_sucursales();
    gets_condiciones_de_venta();
    gets_monedas();
    gets_imprime_despacho();
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
        'idcliente_sucursal': $("#idcliente_sucursal").val()
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

function gets_imprime_despacho() {
    datos = {
        'idcliente': $("#cliente").val()
    };
    
    $.ajax({
        type: 'POST',
        url: '/clientes/gets_imprime_despacho_select/',
        data: datos,
        beforeSend: function () {
            $("#div-imprime-despacho").html("<i class='fa fa-refresh fa-spin'></i>");
        },
        success: function (data) {
            $("#div-imprime-despacho").html(data);
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

$("#agregar").click(function() {
    datos = {
        'idcliente': $("#cliente").val(),
        'idcliente_sucursal': $("#idcliente_sucursal").val(),
        'idtransporte': $("#idtransporte").val(),
        'idcondicion_de_venta': $("#idcondicion_de_venta").val(),
        'imprime_despacho': $("#imprime_despacho").val(),
        'orden_de_compra': $("#orden_de_compra").val(),
        'idmoneda': $("#idmoneda").val(),
        'dolar_oficial': $("#dolar_oficial").val(),
        'factor_correccion': $("#factor_correccion").val(),
        'idtipo_iva': $("#idtipo_iva").val()
    };
    
    $.ajax({
        type: 'POST',
        url: '/pedidos/agregar_ajax/',
        data: datos,
        beforeSend: function () {
            $("#agregar").hide();
            $("#agregar_loading").show();
            Pace.restart();
        },
        success: function (data) {
            $("#agregar_loading").hide();
            $("#agregar").show();
            Pace.stop();
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'danger',
                            z_index: 2000
                        });
            } else if (resultado['status'] == 'ok') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'success',
                            z_index: 2000
                        });
                window.location.href = "/pedidos/modificar/" + resultado['data'] + '/';
            }
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
            $("#agregar_loading").hide();
            $("#agregar").show();
            Pace.stop();
        }
    });
});

function saltar(e, id) {
    // Obtenemos la tecla pulsada
    (e.keyCode) ? k = e.keyCode : k = e.which;

    // Si la tecla pulsada es enter (codigo ascii 13)
    if (k == 13) {
        // Si la variable id contiene "submit" enviamos el formulario
        console.log(k);
        console.log(e);
        console.log(id);


        if (id == "submit") {
            document.forms[0].submit();
        } else {
            // nos posicionamos en el siguiente input
            $("#" + id).focus();
        }
    }
}