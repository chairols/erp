
$("#agregar").click(function () {

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
            "Se agregará el parámetro <strong>"+$("#parametro").val()+"</strong>",
            function () {
                datos = {
                    'parametro': $("#parametro").val(),
                    'tipo': $("#tipo").val()
                };
                $.ajax({
                    type: 'POST',
                    url: '/parametros/agregar_ajax/',
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
                            document.getElementById("parametro").value = "";
                        }
                    }
                });
            },
            function () {
                alertify.error("Se canceló la operación");
            }
    );

});