$("#login").click(function() {
    datos = {
        'usuario': $("#usuario").val(),
        'password': $("#password").val(),
        'remember': $("#remember").prop('checked')
    };
    
    
    $.ajax({
        type: 'POST',
        url: '/usuarios/login_ajax/',
        data: datos,
        beforeSend: function () {
            $("#login").hide();
            $("#login_loading").show();
        },
        success: function (data) {
            $("#login_loading").hide();
            $("#login").show();
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                $.notify('<strong>'+resultado['data']+'</strong><br>',
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
            } else if (resultado['status'] == 'ok') {
                $.notify('<strong>'+resultado['data']+'</strong><br>',
                    {
                        type: 'success',
                        allow_dismiss: false
                    });
                window.location.href = "/dashboard/";
            }
        },
        error: function (xhr) { // if error occured
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger',
                        allow_dismiss: false
                    });
            $("#login_loading").hide();
            $("#login").show();
        }
    });
});