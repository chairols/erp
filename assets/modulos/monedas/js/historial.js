$("#buscar").click(function () {
    datos = {
        'moneda': $("#moneda").val(),
        'desde': $("#desde").val(),
        'hasta': $("#hasta").val()
    };
    $.ajax({
        type: 'POST',
        url: '/monedas/historial_ajax_grafico/',
        data: datos,
        beforeSend: function () {
            $("#grafico").html("<div class='overlay txC'><i class='fa fa-refresh fa-spin'></i></div>");
        },
        success: function (data) {
            $("#grafico").html(data);
        }
    });
    
    $.ajax({
        type: 'POST',
        url: '/monedas/historial_ajax_datatable/',
        data: datos,
        beforeSend: function () {
            $("#tabla").html("<div class='overlay txC'><i class='fa fa-refresh fa-spin'></i></div>");
        },
        success: function (data) {
            $("#tabla").html(data);
        }
    });

});

$(".datatable").dataTable();
