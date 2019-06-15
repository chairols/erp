var pendientes_global = {};
var precio_global = {};

$("#facturar").click(function() {
    actualizar_pendientes();
    actualizar_precios();
    
    console.log(pendientes_global);
    console.log(precio_global);
    
    post();
});

function actualizar_pendientes() {
    var pendientes = document.getElementsByClassName('cantidad_pendiente');
    var i;
    for(i=0; i < pendientes.length; i++) {
        var key = pendientes[i]['attributes']['idpedido_item'].value;
        pendientes_global[key.toString()] = pendientes[i].value;
    }
}

function actualizar_precios() {
    var precios = document.getElementsByClassName('precio');
    var i;
    for(i=0; i < precios.length; i++) {
        var key = precios[i]['attributes']['idpedido_item'].value;
        precio_global[key.toString()] = precios[i].value;
    }
}

function post() {
    datos = {
        'pendientes': pendientes_global,
        'precios': precio_global
    };
    
    $.ajax({
        type: 'POST',
        url: '/prueba/post/',
        data: datos,
        beforeSend: function () {
            Pace.restart();
        },
        success: function (data) {
            Pace.stop();
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