$(document).ready(function() {
    $('#dz1').dropzone({
        url: '/cotizaciones_proveedores/agregar_archivos_ajax/',
        margin: 20,
        allowedFileTypes: '*',
        params:{
            'action': 'save',
            'idcotizacion_proveedor': $("#idcotizacion_proveedor").val()
        },
        uploadOnDrop: true,
        uploadOnPreview: false,
        success: function(res, index){
            //console.log(res, index);
            //$("#idfoto").val(res.response);
            console.log(res);
            actualizar_archivos();
        }
    });
    
    actualizar_archivos();
});

function actualizar_archivos() {
    datos = {
        'idcotizacion_proveedor': $("#idcotizacion_proveedor").val()
    };
    $.ajax({
        type: 'POST',
        url: '/cotizaciones_proveedores/listar_archivos_tabla_ajax/',
        data: datos,
        beforeSend: function () {
            $("#archivos_adjuntos").html('<h1 class="text-center"><i class="fa fa-refresh fa-spin"></i></h1>');
        },
        success: function (data) {
            $("#archivos_adjuntos").html(data);
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
        }
    });
}

$("#actualizar").click(function () {
    datos = {
        'idcotizacion_proveedor': $("#idcotizacion_proveedor").val(),
        'idproveedor': $("#proveedor").val(),
        'idmoneda': $("#idmoneda").val(),
        'fecha': $("#fecha").val(),
        'observaciones': $("#observaciones").val()
    };
    $.ajax({
        type: 'POST',
        url: '/cotizaciones_proveedores/actualizar_cabecera_ajax/',
        data: datos,
        beforeSend: function () {
            $("#actualizar").hide();
            $("#actualizar_loading").show();
        },
        success: function (data) {
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'danger'
                        });
                $("#actualizar_loading").hide();
                $("#actualizar").show();
            } else if (resultado['status'] == 'ok') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'success'
                        });
                $("#actualizar_loading").hide();
                $("#actualizar").show();
            }
        },
        error: function (xhr) { // if error occured
            $("#actualizar_loading").hide();
            $("#actualizar").show();

            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
        }
    });
});

$("#agregar").click(function() {
    datos = {
        'idcotizacion_proveedor': $("#idcotizacion_proveedor").val(),
        'idarticulo': $("#articulo").val(),
        'precio': $("#precio").val(),
        'cantidad': $("#cantidad").val(),
        'fecha': $("#fecha_articulo").val()
    };
    $.ajax({
        type: 'POST',
        url: '/cotizaciones_proveedores/agregar_articulo_ajax/',
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
                            type: 'danger'
                        });
                $("#agregar_loading").hide();
                $("#agregar").show();
            } else if (resultado['status'] == 'ok') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'success'
                        });
                $("#agregar_loading").hide();
                $("#agregar").show();
                
                $("#TextAutoCompletearticulo").val("");
                $("#articulo").val("");
                $("#precio").val("");
                $("#cantidad").val("");
                $("#TextAutoCompletearticulo").focus();
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