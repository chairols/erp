$("#agregar").click(function() {
    datos = {
        'cargo': $("#cargo").val()
    };
    
    $.ajax({
        type: 'POST',
        url: '/cargos/agregar_ajax/',
        data: datos,
        beforeSend: function () {
            $("#agregar").hide();
            $("#agregar_loading").show();
            Pace.restart();
        },
        success: function (data) {
            Pace.stop();
            $("#agregar_loading").hide();
            $("#agregar").show();
            
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'danger'
                        });
                $("#cargo").focus();
                
            } else if (resultado['status'] == 'ok') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'success'
                        });
                $("#cargo").val("");
                $("#cargo").focus();
            }
            
        },
        error: function (xhr) { // if error occured
            console.log(xhr);
            $("#agregar_loading").hide();
            $("#agregar").show();
            
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
        }
    });
});