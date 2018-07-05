
$("#agregar").click(function () {
    if (validador.validateFields("*"))
    {
        alertify.confirm("Se agregará el menú <strong>" + $("#menu").val() + "</strong><br><strong>¿Desea confirmar?</strong>", function (e) {
            if (e)
            {
                datos = {
                    'icono': $("#icono").val(),
                    'titulo': $("#titulo").val(),
                    'menu': $("#menu").val(),
                    'href': $("#href").val(),
                    'orden': $("#orden").val(),
                    'padre': $("#padre").val(),
                    'visible': $("#visible").is(':checked')
                };
                $.ajax({
                    type: 'POST',
                    url: '/menu/agregar_ajax/',
                    data: datos,
                    beforeSend: function () {

                    },
                    success: function (data) {
                        resultado = $.parseJSON(data);
                        if (resultado['status'] == 'error') {
                            notifyError(resultado['data']);
                        } else if (resultado['status'] == 'ok') {
                            notifySuccess("Se agregó correctamente");
                            document.getElementById("icono").value = "";
                            document.getElementById("titulo").value = "";
                            document.getElementById("menu").value = "";
                            document.getElementById("href").value = "";
                            document.getElementById("orden").value = "";
                        }
                    }
                });

            }
        });
    }
});


