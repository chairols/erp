
$("#modificar").click(function () {
    if (validador.validateFields("*"))
    {
        alertify.confirm("Se modificarán los parámetros de Sistema<br><strong>¿Desea confirmar?</strong>", function (e) {
            if (e)
            {
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