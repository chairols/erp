$(document).ready(function() {
    actualizar_legajo();
});

$("#idseccion").change(function() {
    
});

function actualizar_legajo() {
    $.ajax({
        type: 'POST',
        url: '/empleados/get_proximo_legajo_input_ajax/',
        beforeSend: function () {
            $("#legajo_div").html("<i class='fa fa-refresh fa-spin'></i>");
        },
        success: function (data) {
            $("#legajo_div").html(data);
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


