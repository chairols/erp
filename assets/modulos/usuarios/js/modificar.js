$("#modificar").click(function () {
    datos = {
        'idusuario': $("#idusuario").val(),
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
        url: '/usuarios/modificar_ajax/',
        data: datos,
        beforeSend: function () {

        },
        success: function (data) {
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                notifyError(resultado['data'], 1000);
            } else if (resultado['status'] == 'ok') {
                notifySuccess(resultado['data'], 1000);
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