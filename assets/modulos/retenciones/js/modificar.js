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

$("#agregar").click(function() {
    datos = {
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
                        $("#punto_de_venta").val("");
                        $("#comprobante").val("");
                        $("#fecha").val("");
                        $("#base_imponible").val("");
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
    
});

$(document).ready(function() {
    get_items_tabla();
});