
$("#agregar").click(function () {

    if (validador.validateFields("*"))
    {
        alertify.confirm("Se modificarán los parámetros de Sistema<br><strong>¿Desea confirmar?</strong>", function (e) {
            if (e)
            {
                datos = {
                    'parametro': $("#parametro").val(),
                    'identificador': $("#identificador").val(),
                    'tipo': $("#tipo").val()
                };
                $.ajax({
                    type: 'POST',
                    url: '/parametros/agregar_ajax/',
                    data: datos,
                    beforeSend: function () {

                    },
                    success: function (data) {
                        resultado = $.parseJSON(data);
                        if (resultado['status'] == 'error') {
                            notifyError(resultado['data']);
                        } else if (resultado['status'] == 'ok') {
                            notifySuccess("Se actualizó correctamente");
                            document.getElementById("parametro").value = "";
                            document.getElementById("identificador").value = "";
                        }
                    }
                });
            }
        });
    }

});