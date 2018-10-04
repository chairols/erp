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

function borrar_item(articulo, id) {

    alertify.defaults.transition = "slide";
    alertify.defaults.theme.ok = "btn btn-success";
    alertify.defaults.theme.cancel = "btn btn-danger";
    alertify.defaults.theme.input = "form-control";
    alertify.defaults.notifier = {
        delay: 3,
        position: 'bottom-right',
        closeButton: false
    };
    alertify.defaults.glossary = {
        ok: "Agregar",
        cancel: "Cancelar"
    };

    alertify.confirm(
            "<strong>¿Desea confirmar?</strong>",
            "Se eliminará el item " + articulo,
            function () {
                datos = {};
                $.ajax({
                    type: 'POST',
                    url: '/importaciones/borrar_item/' + id,
                    data: datos,
                    beforeSend: function () {

                    },
                    success: function (data) {
                        alertify.defaults.glossary = {
                            ok: "Aceptar",
                        };
                        resultado = $.parseJSON(data);
                        if (resultado['status'] == 'error') {
                            alertify.alert('<strong>ERROR</strong>', resultado['data']);
                        } else if (resultado['status'] == 'ok') {
                            alertify.success("Se borró correctamente");
                            location.reload();
                        }
                    }
                });
            },
            function () {
                alertify.error("Se canceló la operación");
            }
    );

}
;