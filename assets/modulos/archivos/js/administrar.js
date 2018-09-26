

function cargar_archivos() {
    $.ajax({
        type: 'POST',
        url: '/archivos/listar_archivos/',
        beforeSend: function () {
            $("#ver_archivos").html('<h1 class="text-center"><i class="fa fa-refresh fa-spin"></i></h1>');
        },
        success: function (data) {
            $("#ver_archivos").html(data);
        },
        error: function (xhr) { // if error occured
            $("#ver_archivos").html(xhr.responseText);
            
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
        }
    });
}


$(document).ready(function() {
    cargar_archivos();
});
