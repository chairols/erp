$("#comparar").click(function () {

    if ($("#proveedores").val() == null || $("#proveedores").val().length == 1) {
        notifyError("Debe seleccionar al menos 2 proveedores", 5000);
    } else {
        comparar();
    }
});

function comparar() {
    proveedores = $("#proveedores").val();
    marcas = $("#marcas").val();

    datos = {
        'proveedores': proveedores,
        'marcas': marcas
    };
    $.ajax({
        xhr: function () {
            var xhr = new window.XMLHttpRequest();

            
            // Download progress
            xhr.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    // Do something with download progress
                    console.log(percentComplete);
                }
            }, false);

            return xhr;
        },
        type: 'POST',
        url: '/listas_de_precios/nueva_comparacion_ajax/',
        data: datos,
        beforeSend: function () {
            $("#comparar").html("<i class='fa fa-refresh fa-spin'></i> Comparar");
            $("#comparar").attr('disabled', 'disabled');
        },
        success: function (data) {
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                notifyError('<strong>ERROR</strong>' + resultado['data'], 2000);
                $("#comparar").html("<i class='fa fa-copy'></i> Comparar")
                $("#comparar").removeAttr('disabled');
            } else if (resultado['status'] == 'ok') {
                notifySuccess("OK", 2000);
            }
        }
    });
}