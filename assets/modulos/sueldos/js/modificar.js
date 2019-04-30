$(document).ready(function() {
    actualizar_items();
});

function actualizar_items() {
    datos = {
        'idsueldo': $("#idsueldo").val()
    };
    $.ajax({
        type: 'POST',
        url: '/sueldos/gets_items_tabla/',
        data: datos,
        beforeSend: function () {
            Pace.restart();
            $("#items").html('<h1 class="text-center"><i class="fa fa-refresh fa-spin"></i></h1>');
        },
        success: function (data) {
            Pace.stop();
            $("#items").html(data);
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
            Pace.stop();
        }
    });
}