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
                document.getElementById("idjurisdiccion").value = resultado['idjurisdiccion_afip'];
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
        'idjurisdiccion': $("#idjurisdiccion").val(),
        'jurisdiccion': $("#jurisdiccion").val()
    };
    $.ajax({
        type: 'POST',
        url: '/jurisdicciones/agregar_ajax/',
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
                document.getElementById("codigo").value = "";
                document.getElementById("comunidad").value = "";
                document.getElementById("direccion").value = "";
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