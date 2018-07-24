$(".autocompletemarca").on('focusin', function () {
    id = this.attributes.identificador.value;
    $(".autocompletemarca").autoComplete({
        minChars: 1,
        delay: 600,
        cache: false,
        source: function (term, response) {
            try {
                xhr.abort();
            } catch (e) {
            }
            xhr = $.post('/marcas/gets_marcas_ajax/', {marca: term}, function (data) {
                data = JSON.parse(data);
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
            $("#progressmarca_"+iditem).show();
            $("#progressmarca_"+iditem).html("<br><i class='fa fa-refresh fa-spin text-yellow'></i>");
        },
        success: function (data) {
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                notifyError('<strong>ERROR</strong>'+resultado['data']);
                $("#progressmarca_"+iditem).show();
                $("#progressmarca_"+iditem).html("<br><i class='fa fa-warning text-red'></i>");
            } else if (resultado['status'] == 'ok') {
                $("#progressmarca_"+iditem).show();
                $("#progressmarca_"+iditem).html("<br><i class='fa fa-check text-green'></i>");
                $("#progressmarca_"+iditem).fadeOut(3000);
            }
        }
    });
});

$(".autocompletegenerico").on('focusin', function () {
    id = this.attributes.identificador.value;
    $(".autocompletegenerico").autoComplete({
        minChars: 1,
        delay: 600,
        cache: false,
        source: function (term, response) {
            try {
                xhr.abort();
            } catch (e) {
            }
            xhr = $.post('/articulos_genericos/gets_articulos_ajax/', {articulo_generico: term}, function (data) {
                data = JSON.parse(data);
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

$(".autocompletegenerico").focusout(function() {
    idarticulo_generico = $(this).attr('idarticulo_generico');
    iditem = $(this).attr('identificador');
    
    datos = {
        'idarticulo_generico': idarticulo_generico,
        'idlista_de_precios_item': iditem
    };
    $.ajax({
        type: 'POST',
        url: '/listas_de_precios/update_item_articulo_generico/',
        data: datos,
        beforeSend: function () {
            $("#progressgenerico_"+iditem).show();
            $("#progressgenerico_"+iditem).html("<br><i class='fa fa-refresh fa-spin text-yellow'></i>");
        },
        success: function (data) {
            resultado = $.parseJSON(data);
            if (resultado['status'] == 'error') {
                notifyError('<strong>ERROR</strong>'+resultado['data']);
                $("#progressgenerico_"+iditem).show();
                $("#progressgenerico_"+iditem).html("<br><i class='fa fa-warning text-red'></i>");
            } else if (resultado['status'] == 'ok') {
                $("#progressgenerico_"+iditem).show();
                $("#progressgenerico_"+iditem).html("<br><i class='fa fa-check text-green'></i>");
                $("#progressgenerico_"+iditem).fadeOut(3000);
            }
        }
    });
});