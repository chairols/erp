function saltar(e, id) {
    // Obtenemos la tecla pulsada
    (e.keyCode) ? k = e.keyCode : k = e.which;

    // Si la tecla pulsada es enter (codigo ascii 13)
    if (k == 13) {
        // Si la variable id contiene "submit" enviamos el formulario
        console.log(k);
        console.log(e);
        console.log(id);


        if (id == "submit") {
            document.forms[0].submit();
        } else {
            // nos posicionamos en el siguiente input
            $("#" + id).focus();
        }
    }
}

$("#actualizar").click(function () {
    datos = {
        'idarticulo': $("#idarticulo").val(),
        'numero_orden': $("#numero_orden").val(),
        'idlinea': $("#idlinea").val(),
        'despacho': $("#despacho").val(),
        'precio': $("#precio").val(),
        'stock': $("#stock").val(),
        'stock_min': $("#stock_min").val(),
        'stock_max': $("#stock_max").val(),
        'costo_fob': $("#costo_fob").val(),
        'costo_despachado': $("#costo_despachado").val(),
        'rack': $("#rack").val(),
        'observaciones': $("#observaciones").val()
    };
    $.ajax({
        type: 'POST',
        url: '/articulos/modificar_ajax/',
        data: datos,
        beforeSend: function () {
            Pace.restart();
            $("#actualizar").hide();
            $("#actualizar_loading").show();
        },
        success: function (data) {
            Pace.stop();
            $("#actualizar_loading").hide();
            $("#actualizar").show();
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
            }

        },
        error: function (xhr) { // if error occured
            $("#actualizar_loading").hide();
            $("#actualizar").show();

            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
            Pace.stop();
        }
    });
});