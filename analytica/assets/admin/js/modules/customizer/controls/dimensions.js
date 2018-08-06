wp.customize.controlConstructor['dimensions-responsive'] = wp.customize.Control.extend({

	ready: function() {
        'use strict';

        var control = this;

        // Init the control.
		if ( ! _.isUndefined( window.kirkiControlLoader ) && _.isFunction( kirkiControlLoader ) ) {
			kirkiControlLoader( control );
		} else {
			control.initKirkiControl();
        }
    },

    initKirkiControl: function() {

        var control = this,
            subControls = control.params.choices,
			value       = {},
			i;

		for ( i = 0; i < subControls.length; i++ ) {
            value[ subControls[ i ] ] = control.setting._value[ subControls[ i ] ];
			control.updateDimensionsValue( subControls[ i ], value );
		}
    },

    /**
	 * Updates the value.
	 */
	updateDimensionsValue: function( context, value ) {
        var control = this;

		control.container.on( 'change keyup paste', 'input.dimension-' + context, function() {
			value[ context ] = jQuery( this ).val();

			// Save the value
			control.saveValue( value );
		});
    },

    /**
	 * Saves the value.
	 */
	saveValue: function( value ) {

		var control  = this,
			newValue = {};

		_.each( value, function( newSubValue, i ) {
			newValue[ i ] = newSubValue;
		});

		control.setting.set( newValue );
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
