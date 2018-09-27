$(".borrar_padron").click(function() {
    datos = {
        'idpadron': this.attributes.idpadron.value
    };
    
    $.ajax({
        type: 'POST',
        url: '/padrones/borrar_ajax/',
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
            $("#body-tabla-items").html(xhr.responseText);
            console.log(xhr);

            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
        }
    });
});