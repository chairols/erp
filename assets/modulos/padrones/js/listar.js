$(".borrar_padron").click(function() {
    datos = {
        'idpadron': this.attributes.idpadron.value
    };
    id = this.attributes.idpadron.value;
    
    alertify.confirm("Se eliminará el padrón del proveedor<br><strong>¿Desea confirmar?</strong>", function (e) {
        if (e) {
            $.ajax({
                type: 'POST',
                url: '/padrones/borrar_ajax/',
                data: datos,
                beforeSend: function () {
                    $("#borrar-"+id).hide();
                    $("#loading-"+id).show();
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
                        $("#tr-"+id).fadeOut(1000);
                    }
                },
                error: function (xhr) { // if error occured
                    $("#body-tabla-items").html(xhr.responseText);
                    console.log(xhr);

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