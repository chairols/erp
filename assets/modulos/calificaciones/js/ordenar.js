$(document).ready(function() {
    var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };

    // activate Nestable for list 1
    $('#nestable').nestable({
        group: 1,
        maxDepth: 3
    })
    .on('change', updateOutput);

    
    $("#nestable").change(function() {
        actualizar_orden();
    });

    // output initial serialised data
    updateOutput($('#nestable').data('output', $('#nestable-output')));

});

function actualizar_orden() {
    datos = {
        'orden': $("#nestable-output").val()
    };
    $.ajax({
        type: 'POST',
        url: '/calificaciones/actualizar_orden/',
        data: datos,
        beforeSend: function () {
            
        },
        success: function (data) {
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
        }
    });
}
