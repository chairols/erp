$( '#agregar' ).click( function()
{

    datos =
    {

        'cliente': $( '#cliente' ).val(),

        'cuit': $( '#cuit' ).val()

    };

    $.ajax(
    {

        type: 'POST',

        url: '/clientes/agregar_ajax/',

        data: datos,

        beforeSend: function()
        {

            $( '#agregar' ).hide();

            $( '#agregar_loading' ).show();

        },

        success: function( data )
        {

            resultado = $.parseJSON( data );

            if( resultado[ 'status' ] == 'error' )
            {

                $.notify( '<strong>' + resultado[ 'data' ] + '</strong>',
                {

                    type: 'danger',

                    allow_dismiss: true

                });

            } else if ( resultado[ 'status' ] == 'ok' ) {

                window.location.href = '/clientes/modificar/' + resultado[ 'id' ] + '/';

                $.notify( '<strong>' + resultado[ 'data' ] + '</strong>',
                {

                    type: 'success',

                    allow_dismiss: true

                });

                limpiar_campos();

            }

            $( '#agregar_loading' ).hide();

            $('#agregar' ).show();

        },

        error: function( xhr )
        { // if error occured

            $.notify( '<strong>Ha ocurrido el siguiente error:</strong><br>' + xhr.statusText,
            {

                type: 'danger',

                allow_dismiss: false

            });

            $( '#agregar_loading' ).hide();

            $( '#agregar' ).show();
        }

    });

});
