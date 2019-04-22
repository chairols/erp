$("#TextAutoCompletecliente").focusout(function() {
    datos = {
        'idcliente': $("#cliente").val()
    };

    $.ajax({
        type: 'POST',
        url: '/facturacion/gets_pedidos_ajax/',
        data: datos,
        beforeSend: function () {
            Pace.restart();
        },
        success: function (data) {
            Pace.stop();
            $("#resultado").html(data);
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>' + xhr.statusText + '</strong>',
                    {
                        type: 'error',
                        z_index: 2000
                    });

            console.log(xhr);
            Pace.stop();
        }
    });
});

$("#crear").click(function() {
    datos = {
        'idpedido': $("#idpedido").val()
    };
    
    $.ajax({
        type: 'POST',
        url: '/facturacion/pedidos_ajax/',
        data: datos,
        beforeSend: function () {
            Pace.restart();
            $("#crear").hide();
            $("#crear_loading").show();
        },
        success: function (data) {
            Pace.stop();
            $("#crear_loading").hide();
            $("#crear").show();
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'danger',
                            z_index: 2000
                        });
            } else {
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
            $("#crear_loading").hide();
            $("#crear").show();
            console.log(xhr);
            Pace.stop();
        }
    });
});