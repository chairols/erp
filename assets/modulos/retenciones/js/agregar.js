$("#agregar").click(function () {
    datos = {
        'idempresa': $("#empresa").val(),
        'idjurisdiccion': $("#idjurisdiccion").val(),
        'fecha': $("#fecha").val()
    };
    $.ajax({
        type: 'POST',
        url: '/retenciones/agregar_ajax/',
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
                $.notify(resultado['data'], 
                {   type: 'success',
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
});