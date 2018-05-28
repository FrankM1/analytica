wp.customize.controlConstructor['dimensions-responsive'] = wp.customize.Control.extend({

	ready: function() {
		'use strict';

		var control = this;

		control.container.on( 'change keyup paste', '.dimension-top', function() {
			control.settings.desktop.top.set( jQuery( this ).val() );
		});

		control.container.on( 'change keyup paste', '.dimension-right', function() {
			control.settings.desktop.right.set( jQuery( this ).val() );
		});

		control.container.on( 'change keyup paste', '.dimension-bottom', function() {
			control.settings.desktop.bottom.set( jQuery( this ).val() );
		});

		control.container.on( 'change keyup paste', '.dimension-left', function() {
			control.settings.desktop.left.set( jQuery( this ).val() );
		});

		control.container.on( 'change keyup paste', '.dimension-tablet_top', function() {
			control.settings.tablet.top.set( jQuery( this ).val() );
		});

		control.container.on( 'change keyup paste', '.dimension-tablet_right', function() {
			control.settings.tablet.right.set( jQuery( this ).val() );
		});

		control.container.on( 'change keyup paste', '.dimension-tablet_bottom', function() {
			control.settings.tablet.bottom.set( jQuery( this ).val() );
		});

		control.container.on( 'change keyup paste', '.dimension-tablet_left', function() {
			control.settings.tablet.left.set( jQuery( this ).val() );
		});

		control.container.on( 'change keyup paste', '.dimension-mobile_top', function() {
			control.settings.mobile.top.set( jQuery( this ).val() );
		});

		control.container.on( 'change keyup paste', '.dimension-mobile_right', function() {
			control.settings.mobile.right.set( jQuery( this ).val() );
		});

		control.container.on( 'change keyup paste', '.dimension-mobile_bottom', function() {
			control.settings.mobile.bottom.set( jQuery( this ).val() );
		});

		control.container.on( 'change keyup paste', '.dimension-mobile_left', function() {
			control.settings.mobile.left.set( jQuery( this ).val() );
        });
	}

});

jQuery( document ).ready( function( $ ) {

	// Linked button
	$( '.analytica-linked' ).on( 'click', function() {

		// Set up variables
		var $this = $( this );

		// Remove linked class
		$this.parent().parent( '.dimension-wrap' ).prevAll().slice( 0, 4 ).find( 'input' ).removeClass( 'linked' ).attr( 'data-element', '' );

		// Remove class
		$this.parent( '.link-dimensions' ).removeClass( 'unlinked' );

	});

	// Unlinked button
	$( '.analytica-unlinked' ).on( 'click', function() {

		// Set up variables
		var $this 		= $( this ),
			$element 	= $this.data( 'element' );

		// Add linked class
		$this.parent().parent( '.dimension-wrap' ).prevAll().slice( 0, 4 ).find( 'input' ).addClass( 'linked' ).attr( 'data-element', $element );

		// Add class
		$this.parent( '.link-dimensions' ).addClass( 'unlinked' );

	});

	// Values linked inputs
	$( '.dimension-wrap' ).on( 'input', '.linked', function() {

		var $data 	= $( this ).attr( 'data-element' ),
			$val 	= $( this ).val();

		$( '.linked[ data-element="' + $data + '" ]' ).each( function( key, value ) {
			$( this ).val( $val ).change();
		});

	});

});
