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
