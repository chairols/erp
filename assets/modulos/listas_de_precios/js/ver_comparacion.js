$(".borraritems").click(function() {
    console.log($("#selected_ids").val());
});

$(".cantidad_pedida").change(function() {
    datos = {
        'cantidad': this.value,
        'idlista_de_precios_comparacion_item': this.attributes.iditem.value
    };
    $.ajax({
        type: 'POST',
        url: '/preordenes/agregar_modificar_item_ajax/',
        data: datos,
        beforeSend: function () {
            //$("#div-boton-agregar").hide();
            //$("#div-boton-loading").show();
        },
        success: function (data) {
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'danger',
                            allow_dismiss: false
                        });
                $("#div-boton-loading").hide();
                $("#div-boton-agregar").show();
            } else if (resultado['status'] == 'ok') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'success',
                            allow_dismiss: false
                        });
            }
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
            $("#div-boton-loading").hide();
            $("#div-boton-agregar").show();
        }
    });
});