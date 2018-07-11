
$("#agregar").click(function () {
    if (validador.validateFields("*"))
    {
        alertify.confirm("Se agregará la moneda <strong>" + $("#moneda").val() + "</strong><br><strong>¿Desea confirmar?</strong>", function (e) {
            if (e)
            {
                datos = {
                    'moneda': $("#moneda").val(),
                    'simbolo': $("#simbolo").val(),
                    'codigo_afip': $("#codigo_afip").val()
                };
                $.ajax({
                    type: 'POST',
                    url: '/monedas/agregar_ajax/',
                    data: datos,
                    beforeSend: function () {

                    },
                    success: function (data) {
                        resultado = $.parseJSON(data);
                        if (resultado['status'] == 'error') {
                            notifyError(resultado['data']);
                        } else if (resultado['status'] == 'ok') {
                            notifySuccess("Se agregó correctamente");
                            document.getElementById("moneda").value = "";
                            document.getElementById("simbolo").value = "";
                            document.getElementById("codigo_afip").value = "";
                        }
                    }
                });

            }
        });
    }
});
