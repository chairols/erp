$(".borrar_linea").click(function () {
    id = this.attributes.idlinea.value;
    linea = this.attributes.linea.value;

    alertify.confirm("Se eliminará la línea <strong>" + linea + "</strong><br><strong>¿Desea confirmar?</strong>", function (e) {
        if (e) {
            datos = {
                'idlinea': id
            };
            $.ajax({
                type: 'POST',
                url: '/lineas/borrar_ajax/',
                data: datos,
                beforeSend: function () {
                    Pace.restart();
                },
                success: function (data) {
                    Pace.stop();
                    resultado = $.parseJSON(data);
                    if (resultado['status'] == 'error') {
                        $.notify('<strong>' + resultado['data'] + '</strong>',
                                {
                                    type: 'danger',
                                    allow_dismiss: false
                                });
                    } else if (resultado['status'] == 'ok') {
                        $.notify('<strong>' + resultado['data'] + '</strong>',
                                {
                                    type: 'success',
                                    allow_dismiss: false
                                });
                        location.reload(true);
                    }
                },
                error: function (xhr) { // if error occured
                    Pace.stop();
                    $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                            {
                                type: 'danger',
                                allow_dismiss: false
                            });
                }
            });
        }
    });
});