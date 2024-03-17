(function($) {

    $( '.zchimp-widget-form' ).submit( function( e ) {
        e.preventDefault();
        var form = $( this );
        var url = $( this ).attr( 'action' );
        var data = $( this ).serializeArray();
        var submit = $( this ).find( 'input[type=submit]' );
        $( '.zchimp-widget-error' ).fadeOut( 250 );
        submit.prop( 'disabled', true );
        $.post( url, data, function( response ) {
            response = $.parseJSON( response );
            console.log( response );
            if( typeof response.id != 'undefined' ){
                console.log( 'success' );
                form.fadeOut( 250, function() {
                    $( '.zchimp-widget-success' ).fadeIn( 250 );
                });
            } else {
                console.log( 'error' );
                if (response.title == 'Member Exists') {
                    $( '.zchimp-widget-error' ).text( "You're already signed up!" );
                } else {
                    $( '.zchimp-widget-error' ).text( 'There was an error' );
                }

                $( '.zchimp-widget-error' ).fadeIn( 250 );
                submit.prop( 'disabled', false );
            }
        });
    });

})( jQuery );
