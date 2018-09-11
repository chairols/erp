$(document).ready(function() {
    $("#provincia").change();
});

$("#provincia").change(function() {
    actualizar($("#provincia").val());
});


function actualizar(idprovincia) {
    datos = {
        'idprovincia': idprovincia
    };
    $.ajax({
        type: 'POST',
        url: '/provincias/get_provincia_ajax/',
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
                $("#idjurisdiccion").val(resultado['idjurisdiccion_afip']);
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

$("#agregar").click(function () {
    datos = {
        'idprovincia': $("#provincia").val(),
        'idjurisdiccion': $("#idjurisdiccion").val()
    };
    $.ajax({
        type: 'POST',
        url: '/jurisdicciones/actualizar_ajax/',
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