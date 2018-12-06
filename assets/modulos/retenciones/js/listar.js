$(".borrar_retencion").click(function () {
    id = this.attributes.idretencion.value;
    retencion = this.attributes.retencion.value;
    proveedor = this.attributes.proveedor.value;

    alertify.confirm("Se eliminará la retención <strong>" + retencion + "</strong> del proveedor <strong>" + proveedor + "</strong><br><strong>¿Desea confirmar?</strong>", function (e) {
        if (e) {
            datos = {
                'idretencion': id
            };
            $.ajax({
                type: 'POST',
                url: '/retenciones/borrar_retencion_ajax/',
                data: datos,
                beforeSend: function () {

                },
                success: function (data) {
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

function confirmar_mail(idretencion) {

    email = '';

    datos = {
        'idretencion': idretencion
    };
    $.ajax({
        type: 'POST',
        url: '/retenciones/get_retencion_ajax/',
        data: datos,
        beforeSend: function () {

        },
        success: function (data) {
            resultado = $.parseJSON(data);
            email = resultado['p']['email'];

            alertify.confirm("<p><strong>Confirmar Correo para enviar Retención</strong></p><div class='col-md-12'><input type='text' value='" + email + "' class='form-control'></div><br><br>", function (e) {
                if (e) {
                    enviar_mail(email, idretencion);
                }



            });
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
        }
    });

}

function enviar_mail(email, idretencion) {
    datos = {
        'email': email,
        'idretencion': idretencion
    };

    $.ajax({
        type: 'POST',
        url: '/retenciones/enviar_mail/',
        data: datos,
        beforeSend: function () {

        },
        success: function (data) {
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
}