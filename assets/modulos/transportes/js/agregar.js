$(document).ready(function() {
    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false,
      showMeridian: false
    });
});

$("#agregar").click(function() {
    datos = {
        'transporte': $("#transporte").val(),
        'direccion': $("#direccion").val(),
        'codigo_postal': $("#codigo_postal").val(),
        'localidad': $("#localidad").val(),
        'idprovincia': $("#idprovincia").val(),
        'telefono': $("#telefono").val(),
        'idtipo_responsable': $("#idtipo_responsable").val(),
        'cuit': $("#cuit").val(),
        'horario_desde': $("#horario_desde").val(),
        'horario_hasta': $("#horario_hasta").val(),
        'observaciones': $("#observaciones").val()
    };
    
    $.ajax({
        type: 'POST',
        url: '/transportes/agregar_ajax/',
        data: datos,
        beforeSend: function () {
            $("#agregar").hide();
            $("#agregar_loading").show();
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
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'success',
                            allow_dismiss: false
                        });
                $("#transporte").val("");
                $("#direccion").val("");
                $("#codigo_postal").val("");
                $("#localidad").val("");
                $("#telefono").val("");
                $("#cuit").val("");
                $("#observaciones").val("");
                $("#transporte").focus();
            }
            $("#agregar_loading").hide();
            $("#agregar").show();
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
            $("#agregar_loading").hide();
            $("#agregar").show();
        }
    });
});