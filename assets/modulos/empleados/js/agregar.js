$(document).ready(function () {
    actualizar_legajo();
    $("#idseccion").change();
});

$("#idseccion").change(function () {
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

$("#agregar").click(function () {
    datos = {
        'nombre': $("#nombre").val(),
        'apellido': $("#apellido").val(),
        'legajo': $("#legajo").val(),
        'fecha_ingreso': $("#fecha_ingreso").val(),
        'sueldo_bruto': $("#sueldo_bruto").val(),
        'osecac': $("#osecac").val(),
        'idcalificacion': $("#idcalificacion").val(),
        'idusuario': $("#idusuario").val()
    };

    $.ajax({
        type: 'POST',
        url: '/empleados/agregar_ajax/',
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
                $("#nombre").val("");
                $("#apellido").val("");
                actualizar_legajo();
                $("#nombre").focus();
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