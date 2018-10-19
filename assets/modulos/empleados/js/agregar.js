$(document).ready(function() {
    actualizar_legajo();
    $("#idseccion").change();
});

$("#idseccion").change(function() {
    datos = {
        'idpadre': $("#idseccion").val(),
        'id': 'idcategoria'
    };
    $.ajax({
        type: 'POST',
        url: '/empleados/gets_options_select/',
        data: datos,
        beforeSend: function () {
            $("#categoria_div").html("<i class='fa fa-refresh fa-spin'></i>");
        },
        success: function (data) {
            $("#categoria_div").html(data);
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
        }
    });
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

$("#agregar").click(function() {
    console.log($("#idcalificacion").val());
});