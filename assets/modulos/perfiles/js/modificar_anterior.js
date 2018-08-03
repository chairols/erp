
$("#actualizar").click(function () {
    if (validador.validateFields("*"))
    {
        alertify.confirm("Se actualizará el perfil <strong>" + $("#perfil").val() + "</strong><br><strong>¿Desea confirmar?</strong>", function (e) {
            if (e)
            {
                datos = {
                    'perfil': $("#perfil").val(),
                    'idperfil': $("#idperfil").val(),
                    'menues': $("#menues").val()
                };
                $.ajax({
                    type: 'POST',
                    url: '/perfiles/modificar_ajax/',
                    data: datos,
                    beforeSend: function () {

                    },
                    success: function (data) {
                        resultado = $.parseJSON(data);
                        if (resultado['status'] == 'error') {
                            notifyError(resultado['data']);
                        } else if (resultado['status'] == 'ok') {
                            notifySuccess("Se actualizó correctamente");
                        }
                    }
                });

            }
        });
    }
});


