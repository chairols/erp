$("#buscar").click(function() {
    datos = {
        'fecha_desde': $("#fecha_desde").val(),
        'fecha_hasta': $("#fecha_hasta").val(),
        'idjurisdiccion_afip': $("#idjurisdiccion").val()
    };
    $.ajax({
        type: 'POST',
        url: '/retenciones/reporte_ajax/',
        data: datos,
        beforeSend: function () {
            $("#resultado").html("<h1 class='text-center'><i class='fa fa-refresh fa-spin'></i></h1>")
        },
        success: function (data) {
            $("#resultado").html(data);
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
            
            $("#resultado").html(xhr.statusText);
        }
    });
});