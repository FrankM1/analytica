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

( function() {

    var self = this;

    this.events = function() {

        // Add parent class to items with sub-menus
        jQuery( 'ul.sub-menu' ).parent().addClass( 'parent' );

        var mobilemenu_instance = jQuery( '.nav-horizontal' ).data( 'dlmenu' );

        if ( window.matchMedia("screen and (max-width: 1023px)") ) {

            if ( ! mobilemenu_instance ) {
                jQuery( '.nav-horizontal' ).dlmenu();
            }

        } else {

            // action for screen widths below 768 pixels
            if ( mobilemenu_instance ) {
                jQuery( '.nav-horizontal' ).dlmenu( 'destroy' ); // kill it
            }

            // Enable hover dropdowns for window size above tablet width
            jQuery( '.nav-horizontal' ).find( '.menu li.parent' ).hoverIntent({
                sensitivity: 3, // number = sensitivity threshold (must be 1 or higher)
                interval: 100, // number = milliseconds for onMouseOver polling interval
                timeout: 200, // number = milliseconds delay before onMouseOut
                over: function() {
                    jQuery( this ).find( 'ul.sub-menu' ).first().addClass( 'open' );
                },
                out: function() {
                    jQuery( this ).find( 'ul.sub-menu' ).first().removeClass( 'open' );
                }
            });

        }
    };

    this.init = function() {

        if ( typeof jQuery.fn.dlmenu === 'undefined' ) {
            return;
        }

        self.events();

        window.addEventListener( 'orientationchange', function() {
            self.events();
        }, true );

        jQuery( window ).smartresize( function() {
            self.events();
        });
    };

    jQuery( document ).ready( function() {
        self.init();
    });


}() );

/**
 * File skip-link-focus-fix.js
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://github.com/Automattic/_s/pull/136
 *
 * @package Analytica
 */

( function() {
	var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
	    is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' ) > -1,
	    is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' ) > -1;

	if ( ( is_webkit || is_opera || is_ie ) && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}
}() );
