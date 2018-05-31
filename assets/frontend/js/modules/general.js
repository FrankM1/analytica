jQuery( function( $ ) {
    jQuery( 'body' ).removeClass( 'no-js' );
    jQuery( window ).on( 'scroll', function() {
        if ( window.pageYOffset >= 100 ) {
            jQuery( 'body' ).addClass( 'page-scrolling' );
        } else {
            jQuery( 'body' ).removeClass( 'page-scrolling' );
        }
    });
});
