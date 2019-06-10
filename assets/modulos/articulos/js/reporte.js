$("#buscar").click(function() {
    datos = {
        'articulo': $("#articulo").val(),
        'numero_orden': $("#numero_orden").val(),
        'idmarca': $("#idmarca").val(),
        'idlinea': $("#idlinea").val(),
        'stock': $("#stock").val(),
        'precio': $("#precio").val()
    };
    $.ajax({
        type: 'GET',
        url: '/articulos/reporte_ajax/',
        data: datos,
        beforeSend: function () {
            $("#resultado").html("<h1 class='text-center'><i class='fa fa-refresh fa-spin'></i></h1>");
        },
        success: function (data) {
            $("#resultado").html(data);
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
            
            $("#resultado").html(xhr.statusText);
        }
    });
});