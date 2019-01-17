$("#actualizar").click(function () {

    datos = {
        'idimportacion': $("#idimportacion").val(),
        'idproveedor': $("#proveedor").val(),
        'idmoneda': $("#moneda").val(),
        'fecha_pedido': $("#fecha_pedido").val()
    };

    $.ajax({
        type: 'POST',
        url: '/importaciones/actualizar_cabecera_importacion_ajax/',
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
                            type: 'danger',
                            allow_dismiss: false
                        });

            } else if (resultado['status'] == 'ok') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'success',
                            allow_dismiss: false
                        });
            }
            $("#actualizar").show();
            $("#actualizar_loading").hide();
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
            $("#actualizar").show();
            $("#actualizar_loading").hide();
        }
    });
});

$("#agregar_item").click(function () {
    datos = {
        'idimportacion': $("#idimportacion").val(),
        'idarticulo': $("#articulo").val(),
        'cantidad': $("#cantidad").val(),
        'costo_fob': $("#costo_fob").val()
    };

    $.ajax({
        type: 'POST',
        url: '/importaciones/agregar_item_ajax/',
        data: datos,
        beforeSend: function () {
            $("#agregar_item").hide();
            $("#agregar_item_loading").show();
        },
        success: function (data) {
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'danger',
                            allow_dismiss: false
                        });

            } else if (resultado['status'] == 'ok') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'success',
                            allow_dismiss: false
                        });
                gets_items();
                $("#TextAutoCompletearticulo").val("");
                $("#articulo").val("");
                $("#cantidad").val("");
                $("#costo_fob").val("");
                $("#TextAutoCompletearticulo").focus();
            }
            $("#agregar_item").show();
            $("#agregar_item_loading").hide();
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
            $("#agregar_item").show();
            $("#agregar_item_loading").hide();
        }
    });
});

function gets_items() {
    datos = {
        'idimportacion': $("#idimportacion").val()
    };
    $.ajax({
        type: 'POST',
        url: '/importaciones/gets_items_pedido_ajax/',
        data: datos,
        beforeSend: function () {
            $("#items").html('<h1 class="text-center"><i class="fa fa-refresh fa-spin"></i></h1>');
        },
        success: function (data) {
            $("#items").html(data);
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
            $("#agregar_item").show();
            $("#agregar_item_loading").hide();
        }
    });
}

$(document).ready(function () {
    gets_items();
});

function borrar_item(articulo, id) {

    alertify.confirm("Se eliminará el artículo <strong>" + articulo + "</strong><br><strong>¿Desea confirmar?</strong>", function (e) {
        if (e) {
            datos = {
                'idimportacion_item': id
            };
            $.ajax({
                type: 'POST',
                url: '/importaciones/borrar_item/',
                data: datos,
                beforeSend: function () {

                },
                success: function (data) {
                    resultado = $.parseJSON(data);
                    if (resultado['status'] == 'error') {
                        $.notify('<strong>' + resultado['data'] + '</strong>',
                                {
                                    type: 'danger',
                                    allow_dismiss: false
                                });
                    } else if (resultado['status'] == 'ok') {
                        $.notify('<strong>' + resultado['data'] + '</strong>',
                                {
                                    type: 'success',
                                    allow_dismiss: false
                                });
                        gets_items();
                    }
                },
                error: function (xhr) { // if error occured
                    $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                            {
                                type: 'danger',
                                allow_dismiss: false
                            });
                    $("#agregar_item").show();
                    $("#agregar_item_loading").hide();
                }
            });
        }
    });
}
