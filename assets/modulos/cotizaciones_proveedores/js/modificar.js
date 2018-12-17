$(document).ready(function() {
    $('#dz1').dropzone({
        url: '/modelos/agregar_fotos_ajax/',
        margin: 20,
        allowedFileTypes: 'jpg',
        params:{
            'action': 'save',
            'idmodelo': $("#idmodelo").val()
        },
        uploadOnDrop: true,
        uploadOnPreview: false,
        success: function(res, index){
            //console.log(res, index);
            $("#idfoto").val(res.response);
            console.log(res);
            crear_thumb();
            //gets_archivos();
        }
    });
});

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