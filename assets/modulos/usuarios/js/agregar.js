
$("#agregar").click(function () {

    alertify.confirm("Se agregará el usuario <strong>" + $("#usuario").val() + "</strong><br><strong>¿Desea confirmar?</strong>", function (e) {
        if (e) {
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
                        notifyError(resultado['data'], 1000);
                    } else if (resultado['status'] == 'ok') {
                        notifySuccess("Se agregó correctamente", 1000);
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
        }
    });
});

