$(document).ready(function() {
    
});

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
    
    /*
    $.ajax({
        type: 'POST',
        url: '/retenciones/agregar_ajax/',
        data: datos,
        beforeSend: function () {
            $("#div-boton-agregar").hide();
            $("#div-boton-loading").show();
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
                window.location.href = "/retenciones/modificar/" + resultado['data'] + '/';
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
    });*/
});