$(document).ready(function () {
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
            Pace.restart();
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
            Pace.stop();
        },
        error: function (xhr) { // if error occured
            $("#actualizar_loading").hide();
            $("#actualizar").show();

            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
            Pace.stop();
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
            Pace.restart();
            $("#articulos_agregados").html('<h1 class="text-center"><i class="fa fa-refresh fa-spin"></i></h1>');
        },
        success: function (data) {
            $("#articulos_agregados").html(data);
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

$("#TextAutoCompletearticulo").keyup(function () {
    $("#descripcion").val($("#TextAutoCompletearticulo").val());
});

$("#TextAutoCompletearticulo").focusout(function () {
    datos = {
        'idarticulo': $("#articulo").val(),
        'estado': 'A'
    };
    $.ajax({
        type: 'POST',
        url: '/articulos/get_where_json/',
        data: datos,
        beforeSend: function () {
            Pace.restart();
        },
        success: function (data) {
            resultado = $.parseJSON(data);
            $("#descripcion").val(resultado['linea']['nombre_corto'] + " " + resultado['articulo'] + " - " + resultado['marca']['marca']);
            $("#precio").val(resultado['precio']);
            Pace.stop();
            if ($("#idmoneda").val() == '2') {
                get_factor_correccion();
            }
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
            Pace.stop();
        }
    });
});

$("#agregar").click(function () {
    datos = {
        'idcotizacion_cliente': $("#idcotizacion_cliente").val(),
        'cantidad': $("#cantidad").val(),
        'idarticulo': $("#articulo").val(),
        'descripcion': $("#descripcion").val(),
        'precio': $("#precio").val(),
        'fecha': $("#fecha_articulo").val(),
        'observaciones_item': $("#observaciones_item").val()
    };
    $.ajax({
        type: 'POST',
        url: '/cotizaciones_clientes/agregar_articulo_ajax/',
        data: datos,
        beforeSend: function () {
            Pace.restart();
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
                $("#agregar_loading").hide();
                $("#agregar").show();

                $("#TextAutoCompletearticulo").val("");
                $("#cantidad").val("");
                $("#articulo").val("");
                $("#descripcion").val("");
                $("#precio").val("");
                $("#TextAutoCompletearticulo").focus();

                actualizar_articulos();

                $("#cantidad").focus();
            }
            Pace.stop();
        },
        error: function (xhr) { // if error occured
            $("#agregar_loading").hide();
            $("#agregar").show();

            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
            Pace.stop();
        }
    });
});

function get_factor_correccion() {
    $.ajax({
        type: 'POST',
        url: '/parametros/get_parametros_empresa_json/',
        beforeSend: function () {
            Pace.restart();
        },
        success: function (data) {
            resultado = $.parseJSON(data);
            nuevo_precio = $("#precio").val() * resultado['factor_correccion'];

            $("#precio").val(Number(nuevo_precio).toFixed(2));
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

$("#trazabilidad").click(function () {
    datos = {
        'idcliente': $("#cliente").val(),
        'idarticulo': $("#articulo").val()
    };
    $.ajax({
        data: datos,
        type: 'POST',
        url: '/cotizaciones_clientes/gets_antecedentes_ajax_tabla/',
        beforeSend: function () {
            $("#trazabilidad-cotizaciones-loading").show();
            $("#trazabilidad-cotizaciones").hide();
        },
        success: function (data) {
            //resultado = $.parseJSON(data);
            $("#trazabilidad-cotizaciones-loading").hide();
            $("#trazabilidad-cotizaciones").html(data);
            $("#trazabilidad-cotizaciones").show();
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
            Pace.stop();
        }
    });
});