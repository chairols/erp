$(document).ready(function() {
    $("#cantidad").focus();
    actualizar_articulos();
});

$("#actualizar").click(function () {
    datos = {
        'idcotizacion_cliente': $("#idcotizacion_cliente").val(),
        'idcliente': $("#cliente").val(),
        'idmoneda': $("#idmoneda").val(),
        'fecha': $("#fecha").val(),
        'observaciones': $("#observaciones").val()
    };
    $.ajax({
        type: 'POST',
        url: '/cotizaciones_clientes/actualizar_cabecera_ajax/',
        data: datos,
        beforeSend: function () {
            $("#actualizar").hide();
            $("#actualizar_loading").show();
        },
        success: function (data) {
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'danger'
                        });
                $("#actualizar_loading").hide();
                $("#actualizar").show();
            } else if (resultado['status'] == 'ok') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'success'
                        });
                $("#actualizar_loading").hide();
                $("#actualizar").show();
            }
        },
        error: function (xhr) { // if error occured
            $("#actualizar_loading").hide();
            $("#actualizar").show();

            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
        }
    });
});

function actualizar_articulos() {
    datos = {
        'idcotizacion_cliente': $("#idcotizacion_cliente").val()
    };
    $.ajax({
        type: 'POST',
        url: '/cotizaciones_clientes/listar_articulos_tabla_ajax/',
        data: datos,
        beforeSend: function () {
            $("#articulos_agregados").html('<h1 class="text-center"><i class="fa fa-refresh fa-spin"></i></h1>');
        },
        success: function (data) {
            $("#articulos_agregados").html(data);
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
        }
    });
}