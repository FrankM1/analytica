jQuery( document ).ready( function( $ ) {

    $( '.customize-control.has-switchers' ).each( function( index ) {
		var $control 		= $( this ),
            $devices 	= $control.find( '.responsive-switchers' );
        if ( $devices.length >= 1 ) {
            $control.parent().find( '#' + $control.attr( 'id' ) ).addClass( 'active' );
            $control.parent().find( '#' + $control.attr( 'id' ) + '_mobile' ).removeClass( 'active' );
            $control.parent().find( '#' + $control.attr( 'id' ) + '_tablet' ).removeClass( 'active' );
        }
    });

	// Responsive switchers
	$( '.customize-control .responsive-switchers button' ).on( 'click', function( event ) {

		// Set up variables
		var $this 		= $( this ),
			$devices 	= $( '.responsive-switchers' ),
			$device 	= $( event.currentTarget ).data( 'device' ),
			$control 	= $( '.customize-control.has-switchers' ),
			$body 		= $( '.wp-full-overlay' ),
			$footer_devices = $( '.wp-full-overlay-footer .devices' );

		// Button class
		$devices.find( 'button' ).removeClass( 'active' );
		$devices.find( 'button.preview-' + $device ).addClass( 'active' );

		// Control class
        $control.removeClass( 'active' );

        if ( $device === 'desktop' ) {
            $control.parent().find( '#' + $control.attr( 'id' ) ).addClass( 'active' );
        } else {
            $control.parent().find( '#' + $control.attr( 'id' ) + '_' + $device ).addClass( 'active' );
        }

		$control.removeClass( 'control-device-desktop control-device-tablet control-device-mobile' ).addClass( 'control-device-' + $device );

		// Wrapper class
		$body.removeClass( 'preview-desktop preview-tablet preview-mobile' ).addClass( 'preview-' + $device );

		// Panel footer buttons
		$footer_devices.find( 'button' ).removeClass( 'active' ).attr( 'aria-pressed', false );
		$footer_devices.find( 'button.preview-' + $device ).addClass( 'active' ).attr( 'aria-pressed', true );

		// Open switchers
		if ( $this.hasClass( 'preview-desktop' ) ) {
			$control.toggleClass( 'responsive-switchers-open' );
		}

	});

	// If panel footer buttons clicked
	$( '.wp-full-overlay-footer .devices button' ).on( 'click', function( event ) {

		// Set up variables
		var $this 		= $( this ),
			$devices 	= $( '.customize-control.has-switchers .responsive-switchers' ),
			$device 	= $( event.currentTarget ).data( 'device' ),
			$control 	= $( '.customize-control.has-switchers' );

		// Button class
		$devices.find( 'button' ).removeClass( 'active' );
		$devices.find( 'button.preview-' + $device ).addClass( 'active' );

        // Control class
        $control.removeClass( 'active' );

        if ( $device === 'desktop' ) {
            $control.parent().find( '#' + $control.attr( 'id' ) ).addClass( 'active' );
        } else {
            $control.parent().find( '#' + $control.attr( 'id' ) + '_' + $device ).addClass( 'active' );
        }

		$control.removeClass( 'control-device-desktop control-device-tablet control-device-mobile' ).addClass( 'control-device-' + $device );

		// Open switchers
		if ( ! $this.hasClass( 'preview-desktop' ) ) {
			$control.addClass( 'responsive-switchers-open' );
		} else {
			$control.removeClass( 'responsive-switchers-open' );
		}

	});

});


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

wp.customize.controlConstructor['analytica-icon'] = wp.customize.Control.extend({

	ready: function() {

		'use strict';

		var control = this;

		// Change the value
		this.container.on( 'change', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});

	}

});