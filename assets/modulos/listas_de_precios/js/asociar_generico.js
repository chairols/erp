$(".autocompletemarca").on('focusin', function () {
    id = this.attributes.identificador.value;
    $(".autocompletemarca").autoComplete({
        minChars: 1,
        //delay: 300,
        cache: false,
        source: function (term, response) {
            try {
                xhr.abort();
            } catch (e) {
            }
            xhr = $.post('/marcas/gets_marcas_ajax/', {marca: term}, function (data) {
                data = JSON.parse(data);
                if (!data[0])
                {
                    data = [{key: "", text: "Sin Resultados"}];
                }
                response(data);
            });
        },
        renderItem: function (item, search) {
            var key = item.text;
            var text = item.text;
            var id = item.id;

            return '<div class="autocomplete-suggestion" data-key="' + key + '" data-id="' + id + '" data-val="' + search + '">' + text + '</div>';
        },
        onSelect: function (e, term, item) {
            $("#TextAutoCompletemarca_" + id).val(item.context.dataset.key);
            $("#TextAutoCompletemarca_" + id).attr('idmarca', item.context.dataset.id);
            $("#marca_" + id).val(item.context.dataset.id);
        }
    });
});

$(".autocompletemarca").focusout(function () {
    idmarca = $(this).attr('idmarca');
    iditem = $(this).attr('identificador');

    datos = {
        'idmarca': idmarca,
        'idlista_de_precios_item': iditem
    };
    $.ajax({
        type: 'POST',
        url: '/listas_de_precios/update_item_marca/',
        data: datos,
        beforeSend: function () {
            $("#progressmarca_" + iditem).show();
            $("#progressmarca_" + iditem).html("<br><i class='fa fa-refresh fa-spin text-yellow'></i>");
        },
        success: function (data) {
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                notifyError('<strong>ERROR</strong>' + resultado['data'], 5000);
                $("#progressmarca_" + iditem).show();
                $("#progressmarca_" + iditem).html("<br><i class='fa fa-warning text-red'></i>");
            } else if (resultado['status'] == 'ok') {
                $("#progressmarca_" + iditem).show();
                $("#progressmarca_" + iditem).html("<br><i class='fa fa-check text-green'></i>");
                $("#progressmarca_" + iditem).fadeOut(3000);
            }
        }
    });
});

$(".autocompletegenerico").on('focusin', function () {
    id = this.attributes.identificador.value;
    $(".autocompletegenerico").autoComplete({
        minChars: 1,
        //delay: 300,
        cache: false,
        source: function (term, response) {
            try {
                xhr.abort();
            } catch (e) {
            }
            xhr = $.post('/articulos_genericos/gets_articulos_ajax/', {articulo_generico: term}, function (data) {
                data = JSON.parse(data);
                if (!data[0])
                {
                    data = [{key: "", text: "Sin Resultados"}];
                }
                response(data);
            });
        },
        renderItem: function (item, search) {
            var key = item.text;
            var text = item.text;
            var id = item.id;

            return '<div class="autocomplete-suggestion" data-key="' + key + '" data-id="' + id + '" data-val="' + search + '">' + text + '</div>';
        },
        onSelect: function (e, term, item) {
            $("#TextAutoCompletegenerico_" + id).val(item.context.dataset.key);
            $("#TextAutoCompletegenerico_" + id).attr('idarticulo_generico', item.context.dataset.id);
        }
    });
});

$(".autocompletegenerico").focusout(function () {
    idarticulo_generico = $(this).attr('idarticulo_generico');
    iditem = $(this).attr('identificador');

    datos = null;
    if ($(this).context.value == '') {
        datos = {
            'idarticulo_generico': 0,
            'idlista_de_precios_item': iditem
        };
    } else {
        datos = {
            'idarticulo_generico': idarticulo_generico,
            'idlista_de_precios_item': iditem
        };
    }
    $.ajax({
        type: 'POST',
        url: '/listas_de_precios/update_item_articulo_generico/',
        data: datos,
        beforeSend: function () {
            $("#progressgenerico_" + iditem).show();
            $("#progressgenerico_" + iditem).html("<br><i class='fa fa-refresh fa-spin text-yellow'></i>");
        },
        success: function (data) {
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                notifyError('<strong>ERROR</strong>' + resultado['data'], 5000);
                $("#progressgenerico_" + iditem).show();
                $("#progressgenerico_" + iditem).html("<br><i class='fa fa-warning text-red'></i>");
            } else if (resultado['status'] == 'ok') {
                $("#progressgenerico_" + iditem).show();
                $("#progressgenerico_" + iditem).html("<br><i class='fa fa-check text-green'></i>");
                $("#progressgenerico_" + iditem).fadeOut(3000);

            }
        }
    });
});

$(".borraritem").click(function () {
    url = this.baseURI;
    idlista_de_precios_item = this.attributes.iditem.value;

    alertify.confirm("Se borrará el artículo <strong>" + $("#codigo_" + idlista_de_precios_item).val() + "</strong><br><strong>¿Desea confirmar?</strong>", function (e) {
        if (e)
        {
            var datos = {
                'idlista_de_precios_item': idlista_de_precios_item
            };
            $.ajax({
                type: 'POST',
                url: '/listas_de_precios/borrar_item_ajax/',
                data: datos,
                beforeSend: function () {

                },
                success: function (data) {
                    resultado = $.parseJSON(data);
                    if (resultado['status'] == 'error') {
                        notifyError('<strong>ERROR</strong>' + resultado['data']);
                    } else if (resultado['status'] == 'ok') {
                        location.reload();
                    }
                }
            });

        }
    });


});

function borrarSeleccionados() {


    datos = {
        'selected_ids': $("#selected_ids").val()
    };
    $.ajax({
        type: 'POST',
        url: '/listas_de_precios/borrar_items_lista_de_precios_ajax/',
        data: datos,
        beforeSend: function () {

        },
        success: function (data) {
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                notifyError('<strong>ERROR</strong>' + resultado['data'], 5000);
            } else if (resultado['status'] == 'ok') {
                notifySuccess("OK", 1000);
                location.reload();
            }
        }
    });
}

$("#creargenerico").click(function () {
    datos = {
        'idlinea': $("#linea").val(),
        'articulo_generico': $("#codigo").val(),
        'numero_orden': $("#numero_orden").val()
    };
    $.ajax({
        type: 'POST',
        url: '/articulos_genericos/agregar_ajax/',
        data: datos,
        beforeSend: function () {
            $("#creargenerico").hide();
            $("#creargenerico_loading").show();
            //$("#creargenerico").attr('disabled', 'disabled');
        },
        success: function (data) {
            //$("#creargenerico").removeAttr('disabled');
            $("#creargenerico_loading").hide();
            $("#creargenerico").show();
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'danger',
                            z_index: 2000
                        });
            } else if (resultado['status'] == 'ok') {
                $.notify('<strong>' + resultado['data'] + '</strong>',
                        {
                            type: 'success',
                            z_index: 2000
                        });
                $("#TextAutoCompletelinea").val("");
                $("#linea").val("");
                $("#codigo").val("");
                $("#numero_orden").val("");
                
            }
        },
        error: function (xhr) { // if error occured
            $("#creargenerico_loading").hide();
            $("#creargenerico").show();
            $.notify('<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
                    {
                        type: 'danger'
                    });
        }
    });

});

$("#buscador").keyup(function () {
    buscador = $("#buscador").val();
    if (buscador.length > 0) {
        datos = {
            'articulo_generico': buscador
        };
        $.ajax({
            type: 'POST',
            url: '/articulos_genericos/gets_articulos_tabla_ajax/',
            data: datos,
            beforeSend: function () {
                $("#resultadobusqueda").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
            },
            success: function (data) {
                $("#resultadobusqueda").html(data);
            }
        });
    } else {
        $("#resultadobusqueda").html("");
    }

});

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
            $("#"+id).focus();
        }
    }
}