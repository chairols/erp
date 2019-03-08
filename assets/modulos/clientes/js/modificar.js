$("#modificar").click(function () {
    datos = {
        'idcliente': $("#idcliente").val(),
        'cliente': $("#cliente").val(),
        'cuit': $("#cuit").val(),
        'codigo_postal': $("#codigo_postal").val(),
        'idtipo_responsable': $("#idtipo_responsable").val(),
        'idempresa_tipo': $("#idempresa_tipo").val(),
        'iibb': $("#iibb").val(),
        'vat': $("#vat").val(),
        'saldo_cuenta_corriente': $("#saldo_cuenta_corriente").val(),
        'saldo_inicial': $("#saldo_inicial").val(),
        'saldo_a_cuenta': $("#saldo_a_cuenta").val(),
        'idmoneda': $("#idmoneda").val(),
        'web': $("#web").val(),
        'idcondicion_de_venta': $("#condicion").val(),
        'idmoneda_limite': $("#idmoneda_limite").val(),
        'limite_credito': $("#limite_credito").val(),
        'observaciones': $("#observaciones").val()
    };
    $.ajax({
        type: 'POST',
        url: '/clientes/modificar_ajax/',
        data: datos,
        beforeSend: function () {
            $("#modificar").hide();
            $("#modificar_loading").show();
            Pace.restart();
        },
        success: function (data) {
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'danger',
                            allow_dismiss: true
                        });
            } else if (resultado['status'] == 'ok') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'success',
                            allow_dismiss: true
                        });
            }
            $("#modificar_loading").hide();
            $("#modificar").show();
            Pace.stop();
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
            $("#modificar_loading").hide();
            $("#modificar").show();
            Pace.stop();
        }
    });
});

$('#agregar_sucursal').click(function () {

    if ($('#nombre_nueva_sucursal').val())
    {

        var datos =
                {

                    'idcliente': $('#idcliente').val(),

                    'nombre': $('#nombre_nueva_sucursal').val()

                };

        $.ajax(
                {

                    type: 'POST',

                    url: '/clientes/nueva_sucursal_ajax/',

                    data: datos,

                    beforeSend: function ()
                    {

                        $('#agregar_sucursal').hide();

                        $('#agregar_sucursal_loading').show();

                    },

                    success: function (data)
                    {

                        resultado = $.parseJSON(data);

                        if (resultado[ 'status' ] == 'error')
                        {

                            console.log(resultado);

                            $.notify('<strong>' + resultado[ 'data' ] + '</strong>',
                                    {

                                        type: 'danger',

                                        allow_dismiss: true

                                    });

                        } else if (resultado[ 'status' ] == 'ok') {

                            $('.contenedor-sucursal').each(function ()
                            {

                                $(this).hide();

                            });

                            $('.boton_sucursal_menu').each(function ()
                            {

                                $(this).removeClass('info-box-number');

                            });

                            $('#sucursales').append(resultado[ 'html' ]);

                            $('#contenedor_nueva_sucursal').before(resultado[ 'menu_html' ]);

                            $.notify('<strong>' + resultado[ 'data' ] + '</strong>',
                                    {

                                        type: 'success',

                                        allow_dismiss: true

                                    });

                        }

                        cambiarSucursal();

                        modificarSucursal();

                        eliminarSucursal();

                        iCheck();

                        actualizarCheckboxes();

                        $('#nombre_nueva_sucursal').val('');

                        $('#agregar_sucursal_loading').hide();

                        $('#agregar_sucursal').show();

                    },
                    error: function (xhr)
                    { // if error occured

                        console.log(xhr.statusText);

                        $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                                {

                                    type: 'danger',

                                    allow_dismiss: false

                                });

                        $('#agregar_sucursal_loading').hide();

                        $('#agregar_sucursal').show();
                    }

                });

    }

});

$(document).ready(function ()
{

    cambiarSucursal();

    modificarSucursal();

    eliminarSucursal();

    actualizarCheckboxes();
    
    actualizar_horarios();

    $('.timepicker').timepicker({
        showInputs: false
    });
});

function cambiarSucursal()
{

    $('.boton_sucursal_menu').click(function ()
    {

        var sucursal = $(this).attr('sucursal');

        $('.boton_sucursal_menu').each(function ()
        {

            $(this).removeClass('info-box-number');

        });

        $(this).addClass('info-box-number');

        $('.contenedor-sucursal').hide();

        $('#' + sucursal).show();

    });

}

function modificarSucursal() {
    $('.modificarSucursal').click(function () {
        var sucursal = $(this).attr('sucursal');

        var casa_central = 'N';
        if ($('#sucursal_casa_central_' + sucursal).is(':checked')) {
            casa_central = 'S';
        }

        var datos = {
            'idcliente': $('#idcliente').val(),
            'idcliente_sucursal': sucursal,
            'sucursal': $('#sucursal_' + sucursal).val(),
            'idpais': $('#sucursal_idpais_' + sucursal).val(),
            'idprovincia': $('#sucursal_idprovincia_' + sucursal).val(),
            'localidad': $('#sucursal_localidad_' + sucursal).val(),
            'direccion': $('#sucursal_direccion_' + sucursal).val(),
            'codigo_postal': $('#sucursal_codigo_postal_' + sucursal).val(),
            'telefono': $("#sucursal_telefono_" + sucursal).val(),
            'idtransporte': $("#sucursal_idtransporte_" + sucursal).val(),
            'casa_central': casa_central,
            'observaciones': $("#sucursal_observaciones_" + sucursal).val()
        };

        $.ajax({
            type: 'POST',
            url: '/clientes/modificar_sucursal_ajax/',
            data: datos,
            beforeSend: function () {
                $('#modificar_sucursal_' + sucursal).hide();
                $('#modificar_sucursal_loading_' + sucursal).show();
                Pace.restart();
            },
            success: function (data) {
                resultado = $.parseJSON(data);

                if (resultado[ 'status' ] == 'error') {
                    $.notify('<strong>' + resultado[ 'data' ] + '</strong>',
                            {
                                type: 'danger',
                                allow_dismiss: true
                            });
                } else if (resultado[ 'status' ] == 'ok') {
                    $.notify('<strong>' + resultado[ 'data' ] + '</strong>',
                            {
                                type: 'success',
                                allow_dismiss: true
                            });
                }
                $('#modificar_sucursal_loading_' + sucursal).hide();
                $('#modificar_sucursal_' + sucursal).show();
                Pace.stop();
            },
            error: function (xhr)
            { // if error occured
                console.log(xhr.statusText);
                $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                        {
                            type: 'danger',
                            allow_dismiss: false
                        });
                $('#modificar_sucursal_loading_' + sucursal).hide();
                $('#modificar_sucursal_' + sucursal).show();
                Pace.stop();
            }
        });
    });
}


function eliminarSucursal() {
    $('.eliminarSucursal').click(function () {
        var id = $(this).attr('sucursal');
        var sucursal = $('#sucursal_' + id).val();

        alertify.confirm('Está a punto de eliminar la sucursal <strong>' + sucursal + '</strong><br><strong>¿Desea continuar?</strong>', function (e) {
            if (e) {
                var datos = {
                    'idcliente': $('#idcliente').val(),
                    'idcliente_sucursal': id,
                    'sucursal': sucursal
                };

                $.ajax({
                    type: 'POST',
                    url: '/clientes/eliminar_sucursal_ajax/',
                    data: datos,
                    beforeSend: function () {
                        $('#eliminar_sucursal_' + id).hide();
                        $('#eliminar_sucursal_loading_' + id).show();
                    },
                    success: function (data) {
                        resultado = $.parseJSON(data);
                        if (resultado[ 'status' ] == 'error') {
                            console.log(resultado);
                            $.notify('<strong>' + resultado[ 'data' ] + '</strong>',
                                    {
                                        type: 'danger',
                                        allow_dismiss: true
                                    });
                            $('#eliminar_sucursal_loading_' + id).hide();
                            $('#eliminar_sucursal_' + id).show();
                        } else if (resultado[ 'status' ] == 'ok') {
                            $.notify('<strong>' + resultado[ 'data' ] + '</strong>',
                                    {
                                        type: 'success',
                                        allow_dismiss: true
                                    });
                            $('#boton_sucursal_menu_' + id).remove();
                            $('#' + id).remove();
                            $('.boton_sucursal_menu').first().addClass('info-box-number');
                            id = $('.boton_sucursal_menu').first().attr('sucursal');
                            $('#' + id).show();
                        }
                    },
                    error: function (xhr) { // if error occured
                        console.log(xhr.statusText);
                        $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                                {
                                    type: 'danger',
                                    allow_dismiss: false
                                });
                        $('#eliminar_sucursal_loading_' + id).hide();
                        $('#eliminar_sucursal_' + id).show();
                    }
                });
            }
        });
    });
}

function actualizarCheckboxes() {
    $('.casaCentral').on('ifChecked', function (event) {
        var id = $(this).attr('id');
        $('.casaCentral').each(function () {
            if ($(this).attr('id') != id) {
                $(this).iCheck('uncheck');
            }
        })
    });
}

$("#agregar_horario").click(function () {
    datos = {
        'idcliente': $("#idcliente").val(),
        'iddia': $("#iddia").val(),
        'desde': $("#horario_desde").val(),
        'hasta': $("#horario_hasta").val(),
        'idtipo_horario': $("#idtipo_horario").val(),
        'observaciones': $("#horario_observaciones").val()
    };

    $.ajax({
        type: 'POST',
        url: '/clientes/agregar_horario_ajax/',
        data: datos,
        beforeSend: function () {
            $('#agregar_horario').hide();
            $('#agregar_horario_loading').show();
            Pace.restart();
        },
        success: function (data) {
            resultado = $.parseJSON(data);
            if (resultado[ 'status' ] == 'error') {
                console.log(resultado);
                $.notify('<strong>' + resultado[ 'data' ] + '</strong>',
                        {
                            type: 'danger',
                            allow_dismiss: true
                        });
            } else if (resultado[ 'status' ] == 'ok') {
                $.notify('<strong>' + resultado[ 'data' ] + '</strong>',
                        {
                            type: 'success',
                            allow_dismiss: true
                        });
                actualizar_horarios();
            }
            $('#agregar_horario_loading').hide();
            $('#agregar_horario').show();
            Pace.stop();
        },
        error: function (xhr) { // if error occured
            console.log(xhr.statusText);
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
            $('#agregar_horario_loading').hide();
            $('#agregar_horario').show();
            Pace.stop();
        }
    });
});

function actualizar_horarios() {
    datos = {
        'idcliente': $("#idcliente").val()
    };

    $.ajax({
        type: 'POST',
        url: '/clientes/gets_horarios_tabla/',
        data: datos,
        beforeSend: function () {
            $("#horarios").html("<h2 class='txC'><i class='fa fa-refresh fa-spin'></i></h2>");
            Pace.restart();
        },
        success: function (data) {
            $("#horarios").html(data);
            Pace.stop();
        },
        error: function (xhr) { // if error occured
            console.log(xhr.statusText);
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
            Pace.stop();
        }
    });
} 
