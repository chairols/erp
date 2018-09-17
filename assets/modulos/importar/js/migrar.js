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
                $("#boton-" + id).fadeIn(500);
                $("#resultado-" + id).html("<small class='btn btn-xs btn-success'><i class='fa fa-check'></i> Completado</small>");
            }
        }
    });
}

function procesar3(id, url) {
    alert(id);
    alert(url);
}

function procesar2(id, url, tabla) {
    //procesar3(id, url);
    progreso(id, url, tabla);
}

function progreso(id, url, tabla) {
    $.ajax({
        async: true,
        type: "POST",
        url: '/importar/progreso/' + tabla,
        dataType: "html",
        success: function (data) {
            resultado = $.parseJSON(data);
            //progreso(id, url, tabla);
            //setTimeout('progreso(/id/, /url/, /tabla/)', 1000);
            //$("#resultado-" + id).html(resultado['progreso']);
            $("#resultado-" + id).html('<div class="progress progress-sm active"><div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="'+resultado['progreso']+'" aria-valuemin="0" aria-valuemax="100" style="width: '+resultado['progreso']+'%"><span class="sr-only">'+resultado['progreso']+'% Completo</span></div></div>');
            if (resultado['progreso'] < 100) {
                setTimeout(function () {
                    progreso(id, url, tabla)
                }, 1000);
            }


        }
    });
}
