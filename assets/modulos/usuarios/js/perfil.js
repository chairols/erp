$("#modificar").click(function () {
    alertify.confirm("Se actualizará el usuario <strong>" + $("#usuario").val() + "</strong><br><strong>¿Desea confirmar?</strong>", function (e) {
        if (e) {
            datos = {
                'usuario': $("#usuario").val(),
                'nombre': $("#nombre").val(),
                'apellido': $("#apellido").val(),
                'email': $("#email").val(),
                'telefono': $("#telefono").val(),
                'password': $("#password").val(),
                'nuevopass': $("#nuevopass").val(),
                'nuevopassconf': $("#nuevopassconf").val()
            };
            $.ajax({
                type: 'POST',
                url: '/usuarios/perfil_ajax/',
                data: datos,
                beforeSend: function () {

                },
                success: function (data) {
                    resultado = $.parseJSON(data);
                    if (resultado['status'] == 'error') {
                        notifyError(resultado['data'], 1000);
                    } else if (resultado['status'] == 'ok') {
                        notifySuccess("Los datos se actualizaron correctamente", 1000);
                    }
                }
            });
        }
    });
});

$(document).ready(function () {
    var myDropzone = new Dropzone("#dropzone");
    myDropzone.on("success", function (file) {
        console.log(file);

        notifySuccess("Se actualizó la foto de perfil", 1000);

    });

    myDropzone.on("error", function (file) {
        console.log(file);
        notifyError("No se pudo actualizar la foto de perfil", 1000);
    });
});