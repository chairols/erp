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
            $("#"+id).focus();
        }
    }
}

$("#actualizar").click(function() {
    datos = {
        'idpedido': $("#idpedido").val(),
        'idcliente': $("#cliente").val(),
        'idcliente_sucursal': $("#idcliente_sucursal").val(),
        'idtransporte': $("#idtransporte").val(),
        'idcondicion_de_venta': $("#idcondicion_de_venta").val(),
        // Comisiones
        'imprime_despacho': $("#imprime_despacho").val(),
        'orden_de_compra': $("#orden_de_compra").val(),
        'idmoneda': $("#idmoneda").val(),
        'dolar_oficial': $("#dolar_oficial").val(),
        'factor_correccion': $("#factor_correccion").val(),
        'idtipo_iva': $("#idtipo_iva").val()
        // Concepto a facturar
    };
    
    $.ajax({
        type: 'POST',
        url: '/pedidos/actualizar_cabecera_ajax/',
        data: datos,
        beforeSend: function () {
            $("#actualizar").hide();
            $("#actualizar_loading").show();
            Pace.restart();
        },
        success: function (data) {
            $("#actualizar_loading").hide();
            $("#actualizar").show();
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
            }
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>' + xhr.statusText + '</strong>',
                    {
                        type: 'error',
                        z_index: 2000
                    });
            
            console.log(xhr);
            $("#actualizar_loading").hide();
            $("#actualizar").show();
            Pace.stop();
        }
    }); 
});

$("#agregar").click(function() {
    datos = {
        'idpedido': $("#idpedido").val(),
        'idarticulo': $("#articulo").val(),
        'muestra_marca': $("#marca").val(),
        'almacen': $("#almacen").val(),
        'cantidad': $("#cantidad").val(),
        'precio': $("#precio").val()
    };
    
    $.ajax({
        type: 'POST',
        url: '/pedidos/agregar_articulo_ajax/',
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
            }
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>' + xhr.statusText + '</strong>',
                    {
                        type: 'error',
                        z_index: 2000
                    });
            
            console.log(xhr);
            $("#agregar_loading").hide();
            $("#agregar").show();
            Pace.stop();
        }
    }); 
    
});