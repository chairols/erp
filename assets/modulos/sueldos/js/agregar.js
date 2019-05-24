$("#agregar").click(function () {
    datos = {
        'idempleado': $("#idempleado").val(),
        'periodo_mes': $("#mes").val(),
        'periodo_anio': $("#anio").val()
    };

    $.ajax({
        type: 'POST',
        url: '/sueldos/check/',
        data: datos,
        beforeSend: function () {
            $("#agregar").hide();
            $("#agregar_loading").show();
        },
        success: function (data) {
            $("#agregar_loading").hide();
            $("#agregar").show();
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'danger'
                        });

            } else if (resultado['status'] == 'ok') {
                alertify.confirm("Ya existe un recibo con ese período y empleado. <br><strong>¿Desea Continuar?</strong>", function (e) {
                    if (e)
                    {
                        agregar();
                    }
                });
            } else if (resultado['status'] == 'agregar') {
                agregar();
            }
        },
        error: function (xhr) { // if error occured
            $("#agregar_loading").hide();
            $("#agregar").show();

            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
        }
    });

});


function agregar() {
    datos = {
        'idempleado': $("#idempleado").val(),
        'periodo_mes': $("#mes").val(),
        'periodo_anio': $("#anio").val(),
        'presentismo': $("#presentismo").val(),
        'prestamo': $("#prestamo").val()
    };
    $.ajax({
        type: 'POST',
        url: '/sueldos/agregar_ajax/',
        data: datos,
        beforeSend: function () {
            $("#agregar").hide();
            $("#agregar_loading").show();
        },
        success: function (data) {
            $("#agregar_loading").hide();
            $("#agregar").show();
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
                window.location.href = "/sueldos/modificar/" + resultado['data'] + '/';
            }
        },
        error: function (xhr) { // if error occured
            $("#agregar_loading").hide();
            $("#agregar").show();

            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
        }
    });
}

$("#idempleado").change(function() {
    get_empleado($("#idempleado").val());
});

function get_empleado() {
    datos = {
        'idempleado': $("#idempleado").val()
    };
    $.ajax({
        type: 'POST',
        url: '/sueldos/get_where_ajax/',
        data: datos,
        beforeSend: function () {
            
        },
        success: function (data) {
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
                $("#sueldo_bruto").val(resultado['empleado']['sueldo_bruto']);
            }
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
        }
    });
}

$(document).ready(function() {
    get_empleado($("#idempleado").val());
});