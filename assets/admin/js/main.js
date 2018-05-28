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


/**
 * Alpha Color Picker JS
 *
 * This file includes several helper functions and the core control JS.
 */

/**
 * Override the stock color.js toString() method to add support for
 * outputting RGBa or Hex.
 */
Color.prototype.toString = function( flag ) {

	// If our no-alpha flag has been passed in, output RGBa value with 100% opacity.
	// This is used to set the background color on the opacity slider during color changes.
	if ( 'no-alpha' == flag ) {
		return this.toCSS( 'rgba', '1' ).replace( /\s+/g, '' );
	}

	// If we have a proper opacity value, output RGBa.
	if ( 1 > this._alpha ) {
		return this.toCSS( 'rgba', this._alpha ).replace( /\s+/g, '' );
	}

	// Proceed with stock color.js hex output.
	var hex = parseInt( this._color, 10 ).toString( 16 );
	if ( this.error ) { return ''; }
	if ( hex.length < 6 ) {
		for ( var i = 6 - hex.length - 1; i >= 0; i-- ) {
			hex = '0' + hex;
		}
	}

	return '#' + hex;
};

/**
 * Given an RGBa, RGB, or hex color value, return the alpha channel value.
 */
function acp_get_alpha_value_from_color( value ) {
	var alphaVal;

	// Remove all spaces from the passed in value to help our RGBa regex.
	value = value.replace( / /g, '' );

	if ( value.match( /rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/ ) ) {
		alphaVal = parseFloat( value.match( /rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/ )[1] ).toFixed(2) * 100;
		alphaVal = parseInt( alphaVal );
	} else {
		alphaVal = 100;
	}

	return alphaVal;
}

/**
 * Force update the alpha value of the color picker object and maybe the alpha slider.
 */
 function acp_update_alpha_value_on_color_control( alpha, $control, $alphaSlider, update_slider ) {
	var iris, colorPicker, color;

	iris = $control.data( 'a8cIris' );
	colorPicker = $control.data( 'wpWpColorPicker' );

	// Set the alpha value on the Iris object.
	iris._color._alpha = alpha;

	// Store the new color value.
	color = iris._color.toString();

	// Set the value of the input.
	$control.val( color );

	// Update the background color of the color picker.
	colorPicker.toggler.css({
		'background-color': color
	});

	// Maybe update the alpha slider itself.
	if ( update_slider ) {
		acp_update_alpha_value_on_alpha_slider( alpha, $alphaSlider );
	}

	// Update the color value of the color picker object.
	$control.wpColorPicker( 'color', color );
}

/**
 * Update the slider handle position and label.
 */
function acp_update_alpha_value_on_alpha_slider( alpha, $alphaSlider ) {
	$alphaSlider.slider( 'value', alpha );
	$alphaSlider.find( '.ui-slider-handle' ).text( alpha.toString() );
}

/**
 * Initialization trigger.
 */
jQuery( document ).ready( function( $ ) {

	// Loop over each control and transform it into our color picker.
	$( '.alpha-color-control' ).each( function() {

		// Scope the vars.
		var $control, startingColor, showOpacity, defaultColor, colorPickerOptions,
			$container, $alphaSlider, alphaVal, sliderOptions;

		// Store the control instance.
        $control = $( this );
        
		// Get a clean starting value for the option.
		startingColor = $control.val().replace( /\s+/g, '' );

		// Get some data off the control.
		showOpacity  = $control.attr( 'data-show-opacity' );
		defaultColor = $control.attr( 'data-default-color' );

		// Set up the options that we'll pass to wpColorPicker().
		colorPickerOptions = {
			change: function( event, ui ) {
				var key, value, alpha, $transparency;

				key = $control.attr( 'data-customize-setting-link' );
				value = $control.wpColorPicker( 'color' );

				// Set the opacity value on the slider handle when the default color button is clicked.
				if ( defaultColor == value ) {
					alpha = acp_get_alpha_value_from_color( value );
					$alphaSlider.find( '.ui-slider-handle' ).text( alpha );
				}

				// Send ajax request to wp.customize to trigger the Save action.
				wp.customize( key, function( obj ) {
					obj.set( value );
				});

				$transparency = $container.find( '.transparency' );

				// Always show the background color of the opacity slider at 100% opacity.
				$transparency.css( 'background-color', ui.color.toString( 'no-alpha' ) );
			},
			palettes: analyticaLocalize.colorPalettes // Use the passed in palette.
		};

		// Create the colorpicker.
		$control.wpColorPicker( colorPickerOptions );

		$container = $control.parents( '.wp-picker-container:first' );

		// Insert our opacity slider.
		$( '<div class="alpha-color-picker-container">' +
				'<div class="min-click-zone click-zone"></div>' +
				'<div class="max-click-zone click-zone"></div>' +
				'<div class="alpha-slider"></div>' +
				'<div class="transparency"></div>' +
			'</div>' ).appendTo( $container.find( '.wp-picker-holder' ) );

		$alphaSlider = $container.find( '.alpha-slider' );

		// If starting value is in format RGBa, grab the alpha channel.
		alphaVal = acp_get_alpha_value_from_color( startingColor );

		// Set up jQuery UI slider() options.
		sliderOptions = {
			create: function( event, ui ) {
				var value = $( this ).slider( 'value' );

				// Set up initial values.
				$( this ).find( '.ui-slider-handle' ).text( value );
				$( this ).siblings( '.transparency ').css( 'background-color', startingColor );
			},
			value: alphaVal,
			range: 'max',
			step: 1,
			min: 0,
			max: 100,
			animate: 300
		};

		// Initialize jQuery UI slider with our options.
		$alphaSlider.slider( sliderOptions );

		// Maybe show the opacity on the handle.
		if ( 'true' == showOpacity ) {
			$alphaSlider.find( '.ui-slider-handle' ).addClass( 'show-opacity' );
		}

		// Bind event handlers for the click zones.
		$container.find( '.min-click-zone' ).on( 'click', function() {
			acp_update_alpha_value_on_color_control( 0, $control, $alphaSlider, true );
		});
		$container.find( '.max-click-zone' ).on( 'click', function() {
			acp_update_alpha_value_on_color_control( 100, $control, $alphaSlider, true );
		});

		// Bind event handler for clicking on a palette color.
		$container.find( '.iris-palette' ).on( 'click', function(e) {
			e.preventDefault();

			var color, alpha;

			color = $( this ).css( 'background-color' );
			alpha = acp_get_alpha_value_from_color( color );

			acp_update_alpha_value_on_alpha_slider( alpha, $alphaSlider );

			// Sometimes Iris doesn't set a perfect background-color on the palette,
			// for example rgba(20, 80, 100, 0.3) becomes rgba(20, 80, 100, 0.298039).
			// To compensante for this we round the opacity value on RGBa colors here
			// and save it a second time to the color picker object.
			if ( alpha != 100 ) {
				color = color.replace( /[^,]+(?=\))/, ( alpha / 100 ).toFixed( 2 ) );
			}

			$control.wpColorPicker( 'color', color );
		});

		// Bind event handler for clicking on the 'Clear' button.
		$container.find( '.button.wp-picker-clear' ).on( 'click', function(e) {
			e.preventDefault();

			var key = $control.attr( 'data-customize-setting-link' );

			// The #fff color is delibrate here. This sets the color picker to white instead of the
			// defult black, which puts the color picker in a better place to visually represent empty.
			$control.wpColorPicker( 'color', '#ffffff' );

			// Set the actual option value to empty string.
			wp.customize( key, function( obj ) {
				obj.set( '' );
			});

			acp_update_alpha_value_on_alpha_slider( 100, $alphaSlider );
		});

		// Bind event handler for clicking on the 'Default' button.
		$container.find( '.button.wp-picker-default' ).on( 'click', function(e) {
			e.preventDefault();

			var alpha = acp_get_alpha_value_from_color( defaultColor );

			acp_update_alpha_value_on_alpha_slider( alpha, $alphaSlider );
		});

		// Bind event handler for typing or pasting into the input.
		$control.on( 'input', function(e) {
			e.preventDefault();

			var value = $( this ).val();
			var alpha = acp_get_alpha_value_from_color( value );

			acp_update_alpha_value_on_alpha_slider( alpha, $alphaSlider );
		});

		// Update all the things when the slider is interacted with.
		$alphaSlider.slider().on( 'slide', function( event, ui ) {
			var alpha = parseFloat( ui.value ) / 100.0;

			acp_update_alpha_value_on_color_control( alpha, $control, $alphaSlider, false );

			// Change value shown on slider handle.
			$( this ).find( '.ui-slider-handle' ).text( ui.value );
		});

		// Fix Safari issue on input click
		$( '.iris-picker, .alpha-color-control' ).on( 'click', function(e) {
			e.preventDefault();
		});

	});
});

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