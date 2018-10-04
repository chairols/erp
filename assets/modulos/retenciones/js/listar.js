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