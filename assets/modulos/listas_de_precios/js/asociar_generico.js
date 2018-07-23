$(".ac22222222").autoComplete({
    source: function (term, response) {

        console.log(term);

        datos = {
            'marca': term
        };
        $.ajax({
            type: 'POST',
            url: '/marcas/gets_marcas_ajax/',
            data: datos,
            beforeSend: function () {

            },
            success: function (data) {
                resultado = $.parseJSON(data);
                console.log(resultado);
            }
        });

    }
});

$(".ac").on('focusin', function () {
    id = this.attributes.identificador.value;
    $(".ac").autoComplete({
        minChars: 1,
        delay: 600,
        source: function (term, response) {
            try {
                xhr.abort();
            } catch (e) {
            }
            xhr = $.post('/marcas/gets_marcas_ajax/', {marca: term}, function (data) {
                //console.log(data);
                data = JSON.parse(data);
                console.log(data);
                response(data);
            });
        },
        renderItem: function (item, search) {
            //console.log(item);
            console.log(item);
            
            var key = item.text;
            var text = item.text;
            var id = item.id;
            
            return '<div class="autocomplete-suggestion" data-key="' + key + '" data-id="' + id + '" data-val="' + search + '">' + text + '</div>';
        }
    });
});