$("#comenzar").click(function() {
    $("#articulos_sin_asociar").html("Pendiente ...");
    $("#articulos_duplicados").html("Pendiente ...");
    $("#optimizar_base_de_datos").html("Pendiente ...");
    
    $("#comenzar").hide();
    $("#comenzar_loading").show();
    
    proceso(1, 'articulos_sin_asociar');
});


function proceso(idproceso, destino) {
    datos = {
        'idproceso': idproceso
    };
    $.ajax({
        type: 'POST',
        url: '/optimizar/sistema_ajax/',
        data: datos,
        beforeSend: function () {
            Pace.restart();
            $("#tr_proceso_"+idproceso).addClass('bg-yellow-gradient');
            $("#"+destino).html("<i class='fa fa-refresh fa-spin'></i>");
        },
        success: function (data) {
            Pace.stop();
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'danger'
                        });
            } else if (resultado['status'] == 'ok') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'success'
                        });
                $("#" + destino).html(resultado['data']);
                $("#tr_proceso_"+idproceso).removeClass('bg-yellow-gradient');
                $("#tr_proceso_"+idproceso).addClass('bg-green-gradient');
                proceso(resultado['next_proceso'], resultado['next_destino']);
            }
        },
        error: function (xhr) { // if error occured
            Pace.stop();
            $("#comenzar_loading").hide();
            $("#comenzar").show();
            $("#tr_proceso_"+idproceso).removeClass('bg-yellow-gradient');
            $("#tr_proceso_"+idproceso).addClass('bg-red');
            $("#" + destino).html(xhr.statusText);

            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
        }
    });
}