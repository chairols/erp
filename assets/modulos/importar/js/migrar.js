function procesar(id, url) {

    $.ajax({

        type: 'POST',
        url: url,
        beforeSend: function () {
            $("#boton-" + id).fadeOut(500);
            $("#resultado-" + id).html("<i class='fa fa-refresh fa-spin'></i>");
        },
        success: function (data) {
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'ok') {
                notifySuccess("Se completó la operación");
                $("#boton-"+id).fadeIn(500);
                $("#resultado-"+id).html("<small class='btn btn-xs btn-success'><i class='fa fa-check'></i> Completado</small>");
            } 
        }
    });
}