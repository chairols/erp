
$("#agregar").click(function () {

    alertify.confirm("Se agregará la línea <strong>" + $("#linea").val() + "</strong><br><strong>¿Desea confirmar?</strong>", function (e) {
        if (e)
        {
            var datos = {
                'linea': $("#linea").val(),
                'nombre_corto': $("#nombre_corto").val()
            };
            $.ajax({
                type: 'POST',
                url: '/lineas/agregar_ajax/',
                data: datos,
                beforeSend: function () {

                },
                success: function (data) {
                    resultado = $.parseJSON(data);
                    if (resultado['status'] == 'error') {
                        notifyError('<strong>ERROR</strong>');
                        console.log(resultado['data']);
                    } else if (resultado['status'] == 'ok') {
                        notifySuccess("Se agregó correctamente");
                        document.getElementById("linea").value = "";
                        document.getElementById("nombre_corto").value = "";
                    }
                }
            });

        }
    });

});
