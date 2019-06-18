var pendientes_global = {};
var precio_global = {};

$("#facturar").click(function () {
    actualizar_pendientes();
    actualizar_precios();

    console.log(pendientes_global);
    console.log(precio_global);

    post();
});

function actualizar_pendientes() {
    var pendientes = document.getElementsByClassName('cantidad_pendiente');
    var i;
    for (i = 0; i < pendientes.length; i++) {
        var key = pendientes[i]['attributes']['idpedido_item'].value;
        pendientes_global[key.toString()] = pendientes[i].value;
    }
}

function actualizar_precios() {
    var precios = document.getElementsByClassName('precio');
    var i;
    for (i = 0; i < precios.length; i++) {
        var key = precios[i]['attributes']['idpedido_item'].value;
        precio_global[key.toString()] = precios[i].value;
    }
}

function post() {
    datos = {
        'idcomprobante': $("#idcomprobante").val(),
        'cuit': $("#cuit").val(),
        'pendientes': pendientes_global,
        'precios': precio_global,
        'idmoneda': $("#idmoneda").val(),
        'idtipo_iva': $("#idtipo_iva").val(),
        'tipo_comprobante': $("#tipo_comprobante").val()
    };

    $.ajax({
        type: 'POST',
        url: '/facturacion/facturar_afip/',
        //url: '/prueba/post/',
        data: datos,
        beforeSend: function () {
            Pace.restart();
        },
        success: function (data) {
            Pace.stop();
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'danger',
                            allow_dismiss: false
                        });
            }
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
            Pace.stop();
        }
    });
}