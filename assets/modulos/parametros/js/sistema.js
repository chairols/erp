
$("#modificar").click(function () {

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
            "Se modificarán los parámetros de Sistema",
            function () {
                datos = {
                    'empresa': $("#empresa").val(),
                    'actividad': $("#actividad").val(),
                    'direccion': $("#direccion").val(),
                    'codigo_postal': $("#codigo_postal").val(),
                    'idprovincia': $("#idprovincia").val(),
                    'telefono': $("#telefono").val(),
                    'email': $("#email").val(),
                    'idtipo_responsable': $("#idtipo_responsable").val(),
                    'cuit': $("#cuit").val(),
                    'ingresos_brutos': $("#ingresos_brutos").val(),
                    'numero_importador': $("#numero_importador").val(),
                    'factor_correccion': $("#factor_correccion").val()
                };
                $.ajax({
                    type: 'POST',
                    url: '/parametros/sistema_modificar_ajax/',
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
                            alertify.success("Se agregó correctamente");
                        }
                    }
                });
            },
            function () {
                alertify.error("Se canceló la operación");
            }
    );

});