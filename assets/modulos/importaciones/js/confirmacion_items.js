$(document).ready(function () {
    refrescar_items_backorder();
    refrescar_items_confirmados();
});

function refrescar_items_confirmados() {

    datos = {
        'idimportacion_confirmacion': $("#idimportacion_confirmacion").val()
    };
    $.ajax({

        type: 'POST',
        url: '/importaciones/confirmacion_items_ajax/',
        data: datos,
        beforeSend: function () {
            $("#items_confirmados").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
        },
        success: function (data) {
            $("#items_confirmados").html(data);
        }
    });
}

function refrescar_items_backorder() {
    datos = {
        'idproveedor': $("#idproveedor").val()
    };
    $.ajax({

        type: 'POST',
        url: '/importaciones/items_backorder_ajax/',
        data: datos,
        beforeSend: function () {
            $("#items_backorder").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
        },
        success: function (data) {
            $("#items_backorder").html(data);
        }
    });
}

function agregar(idimportacion_item) {
    datos = {
        'idimportacion_item': idimportacion_item,
        'idimportacion_confirmacion': $("#idimportacion_confirmacion").val(),
        'cantidad': $("#cantidad-" + idimportacion_item).val(),
        'fecha_confirmacion': $("#fecha_confirmacion-" + idimportacion_item).val()
    };

    $.ajax({

        type: 'POST',
        url: '/importaciones/confirmar_item_de_pedido_ajax/',
        data: datos,
        beforeSend: function () {

        },
        success: function (data) {
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                notifyError(resultado['data']);
            } else if (resultado['status'] == 'ok') {
                refrescar_items_backorder();
                refrescar_items_confirmados();
            }
        }
    });
}

function borrar_item_confirmado(idimportacion_confirmacion_item) {
    datos = {
        'idimportacion_confirmacion_item': idimportacion_confirmacion_item,
    };
    
    $.ajax({

        type: 'POST',
        url: '/importaciones/borrar_item_confirmado_ajax/',
        data: datos,
        beforeSend: function () {

        },
        success: function (data) {
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                notifyError(resultado['data']);
            } else if (resultado['status'] == 'ok') {
                notifySuccess("Se agregó correctamente");
                refrescar_items_backorder();
                refrescar_items_confirmados();
            }
        }
    });
}