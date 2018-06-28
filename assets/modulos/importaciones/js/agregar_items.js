
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
            "Se eliminará el item "+articulo,
            function () {
                datos = {};
                $.ajax({
                    type: 'POST',
                    url: '/importaciones/borrar_item/'+id,
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

};