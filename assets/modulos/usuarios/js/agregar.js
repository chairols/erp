
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
            "Se agregará el usuario <strong>"+$("#usuario").val()+"</strong>",
            function () {
                datos = {
                    'usuario': $("#usuario").val(),
                    'password': $("#password").val(),
                    'password2': $("#password2").val(),
                    'nombre': $("#nombre").val(),
                    'apellido': $("#apellido").val(),
                    'email': $("#email").val(),
                    'telefono': $("#telefono").val(),
                    'idperfil': $("#idperfil").val()
                };
                $.ajax({
                    type: 'POST',
                    url: '/usuarios/agregar_ajax/',
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
                            document.getElementById("usuario").value = "";
                            document.getElementById("password").value = "";
                            document.getElementById("password2").value = "";
                            document.getElementById("nombre").value = "";
                            document.getElementById("apellido").value = "";
                            document.getElementById("email").value = "";
                            document.getElementById("telefono").value = "";
                        }
                    }
                });
            },
            function () {
                alertify.error("Se canceló la operación");
            }
    );

});