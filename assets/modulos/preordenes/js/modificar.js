$(".cantidad").change(function() {
    datos = {
        'idpreorden': this.attributes.idpreorden.value,
        'cantidad': this.value
    };
    
    idpreorden = this.attributes.idpreorden.value;
    
    
    $.ajax({
        type: 'POST',
        url: '/preordenes/modificar_cantidad_ajax/',
        data: datos,
        beforeSend: function() {
            $("#total-"+idpreorden).hide();
            $("#total-loading-"+idpreorden).show();
        },
        success: function(data) {
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
                $("#total-"+idpreorden).val(resultado['subtotal']);
                $("#total").html(resultado['total']);
                //$("#total-"+idpreorden).val(  ($("#cantidad-"+idpreorden).val() * $("#precio-"+idpreorden).val()).toFixed(2)   );
                $("#total-"+idpreorden).show();
                $("#total-loading-"+idpreorden).hide();
            }
            
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

$("#generar_orden").click(function() {
    datos = {
        'idproveedor': $("#idproveedor").val(),
        'idmoneda': $("#idmoneda").val()
    };
    
    $.ajax({
        type: 'POST',
        url: '/preordenes/generar_orden_ajax/',
        data: datos,
        beforeSend: function() {
            $("#generar_orden").hide();
            $("#generar_orden_loading").show();
        },
        success: function(data) {
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
            }
            $("#generar_orden_loading").hide();
            $("#generar_orden").show();
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
            $("#generar_orden_loading").hide();
            $("#generar_orden").show();
        }
    });
});