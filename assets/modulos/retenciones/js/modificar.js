$("#punto_de_venta").focusout(function () {
    valor = $("#punto_de_venta").val();
    largo = valor.length;
    for (i = 4; i > largo; i--) {
        valor = '0' + valor;
        $("#punto_de_venta").val(valor);
    }
});

$("#comprobante").focusout(function () {
    valor = $("#comprobante").val();
    largo = valor.length;
    for (i = 8; i > largo; i--) {
        valor = '0' + valor;
        $("#comprobante").val(valor);
    }
});

$("#alicuota-editar-boton").click(function () {
    $("#alicuota").removeAttr("disabled");
    $("#alicuota-div-boton-editar").hide();
    $("#alicuota-div-boton-guardar").show();
    $("#alicuota").focus();

});

$("#alicuota-guardar-boton").click(function () {
    $("#alicuota").attr("disabled", "");
    $("#alicuota-div-boton-guardar").hide();

    datos = {
        'alicuota': $("#alicuota").val(),
        'idretencion': $("#idretencion").val()
    };
    $.ajax({
        type: 'POST',
        url: '/retenciones/update_ajax/',
        data: datos,
        beforeSend: function () {
            $("#alicuota-div-boton-guardar").hide();
            $("#alicuota-div-boton-editar").hide();
            $("#alicuota-div-boton-loading").show();
        },
        success: function (data) {
            $("#alicuota-div-boton-loading").hide();
            $("#alicuota-div-boton-editar").show();
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
                get_items_tabla();
            }
        },
        error: function (xhr) { // if error occured
            $("#alicuota-div-boton-loading").hide();
            $("#alicuota-div-boton-editar").show();

            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
        }
    });
});

function get_items_tabla() {
    datos = {
        'idretencion': $("#idretencion").val()
    };
    $.ajax({
        type: 'POST',
        url: '/retenciones/gets_items_table_body_ajax/',
        data: datos,
        beforeSend: function () {
            $("#body-tabla-items").html('<h1 class="text-center"><i class="fa fa-refresh fa-spin"></i></h1>');
        },
        success: function (data) {
            $("#body-tabla-items").html(data);
        },
        error: function (xhr) { // if error occured
            $("#body-tabla-items").html(xhr.responseText);
            console.log(xhr);

            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
        }
    });
}

$("#agregar").click(function () {
    datos = {
        'idtipo_comprobante': $("#tipo_comprobante").val(),
        'idretencion': $("#idretencion").val(),
        'punto_de_venta': $("#punto_de_venta").val(),
        'comprobante': $("#comprobante").val(),
        'fecha': $("#fecha").val(),
        'base_imponible': $("#base_imponible").val()
    };
    $.ajax({
        type: 'POST',
        url: '/retenciones/agregar_item_ajax/',
        data: datos,
        beforeSend: function () {
            $("#div-boton-agregar").hide();
            $("#div-boton-loading").show();
        },
        success: function (data) {
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'danger',
                            allow_dismiss: false
                        });
                $("#div-boton-loading").hide();
                $("#div-boton-agregar").show();
            } else if (resultado['status'] == 'ok') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'success',
                            allow_dismiss: false
                        });
                $("#punto_de_venta").val("");
                $("#comprobante").val("");
                //$("#fecha").val("");
                $("#base_imponible").val("");
                $("#div-boton-loading").hide();
                $("#div-boton-agregar").show();
                get_items_tabla();
            }
            $("#punto_de_venta").focus();
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
        }
    });

});

function borrar_item(idretencion_item, comprobante) {

    alertify.confirm("Se eliminará el comprobante <strong>" + comprobante + "</strong><br><strong>¿Desea confirmar?</strong>", function (e) {
        if (e) {
            datos = {
                'idretencion_item': idretencion_item
            };
            $.ajax({
                type: 'POST',
                url: '/retenciones/borrar_item/',
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
                        get_items_tabla();
                    }
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

$(document).ready(function () {
    get_items_tabla();
});