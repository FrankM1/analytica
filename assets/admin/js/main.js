/**
 * Customizer controls toggles
 *
 * @package Analytica
 */

( function( $ ) {

	/* Internal shorthand */
	var api = wp.customize;

	/**
	 * Trigger hooks
	 */
	ASTControlTrigger = {

	    /**
	     * Trigger a hook.
	     *
	     * @since 1.0.0
	     * @method triggerHook
	     * @param {String} hook The hook to trigger.
	     * @param {Array} args An array of args to pass to the hook.
		 */
	    triggerHook: function( hook, args )
	    {
	    	$( 'body' ).trigger( 'analytica-control-trigger.' + hook, args );
	    },

	    /**
	     * Add a hook.
	     *
	     * @since 1.0.0
	     * @method addHook
	     * @param {String} hook The hook to add.
	     * @param {Function} callback A function to call when the hook is triggered.
	     */
	    addHook: function( hook, callback )
	    {
	    	$( 'body' ).on( 'analytica-control-trigger.' + hook, callback );
	    },

	    /**
	     * Remove a hook.
	     *
	     * @since 1.0.0
	     * @method removeHook
	     * @param {String} hook The hook to remove.
	     * @param {Function} callback The callback function to remove.
	     */
	    removeHook: function( hook, callback )
	    {
		    $( 'body' ).off( 'analytica-control-trigger.' + hook, callback );
	    },
	};

	/**
	 * Helper class that contains data for showing and hiding controls.
	 *
	 * @since 1.0.0
	 * @class ASTCustomizerToggles
	 */
	ASTCustomizerToggles = {

		'analytica-settings[display-site-title]' :
		[
			{
				controls: [
					'analytica-settings[divider-section-header-typo-title]',
					'analytica-settings[font-size-site-title]',
				],
				callback: function( value ) {

					if ( value ) {
						return true;
					}
					return false;
				}
			},
			{
				controls: [
					'analytica-settings[logo-title-inline]',
				],
				callback: function( value ) {

					var site_tagline = api( 'analytica-settings[display-site-tagline]' ).get();
					var has_custom_logo = api( 'custom_logo' ).get();
					var has_retina_logo = api( 'analytica-settings[ast-header-retina-logo]' ).get();

					if ( ( value || site_tagline ) && ( has_custom_logo || has_retina_logo ) ) {
						return true;
					}
					return false;
				}
			},
		],

		'analytica-settings[display-site-tagline]' :
		[
			{
				controls: [
					'analytica-settings[divider-section-header-typo-tagline]',
					'analytica-settings[font-size-site-tagline]',
				],
				callback: function( value ) {

					if ( value ) {
						return true;
					}
					return false;
				}
			},
			{
				controls: [
					'analytica-settings[logo-title-inline]',
				],
				callback: function( value ) {

					var site_title = api( 'analytica-settings[display-site-title]' ).get();
					var has_custom_logo = api( 'custom_logo' ).get();
					var has_retina_logo = api( 'analytica-settings[ast-header-retina-logo]' ).get();

					if ( ( value || site_title ) && ( has_custom_logo || has_retina_logo ) ) {
						return true;
					}
					return false;
				}
			},
		],

		'analytica-settings[ast-header-retina-logo]' :
		[
			{
				controls: [
					'analytica-settings[logo-title-inline]',
				],
				callback: function( value ) {

					var has_custom_logo = api( 'custom_logo' ).get();
					var site_tagline = api( 'analytica-settings[display-site-tagline]' ).get();
					var site_title = api( 'analytica-settings[display-site-title]' ).get();

					if ( ( value || has_custom_logo ) && ( site_title || site_tagline ) ) {
						return true;
					}
					return false;
				}
			},
		],

		'custom_logo' :
		[
			{
				controls: [
					'analytica-settings[logo-title-inline]',
				],
				callback: function( value ) {

					var has_retina_logo = api( 'analytica-settings[ast-header-retina-logo]' ).get();
					var site_tagline = api( 'analytica-settings[display-site-tagline]' ).get();
					var site_title = api( 'analytica-settings[display-site-title]' ).get();

					if ( ( value || has_retina_logo ) && ( site_title || site_tagline ) ) {
						return true;
					}
					return false;
				}
			},
		],

		/**
		 * Section - Header
		 *
		 * @link  ?autofocus[section]=section-header
		 */

		/**
		 * Layout 2
		 */
		// Layout 2 > Right Section > Text / HTML
		// Layout 2 > Right Section > Search Type
		// Layout 2 > Right Section > Search Type > Search Box Type.
		'analytica-settings[header-main-rt-section]' :
		[
			{
				controls: [
					'analytica-settings[header-main-rt-section-html]'
				],
				callback: function( val ) {

					if ( 'text-html' == val ) {
						return true;
					}
					return false;
				}
			},
			{
				controls: [
					'analytica-settings[header-main-menu-label]',
					'analytica-settings[header-main-menu-label-divider]',
				],
				callback: function( custom_menu ) {
					var menu = api( 'analytica-settings[disable-primary-nav]' ).get();
					if ( !menu || 'none' !=  custom_menu) {
						return true;
					}
					return false;
				}
			},
			{
				controls: [
					'analytica-settings[header-display-outside-menu]',
				],
				callback: function( custom_menu ) {
					
					if ( 'none' !=  custom_menu ) {
						return true;
					}
					return false;
				}
			}
		],

		/**
		 * Blog
		 */
		'analytica-settings[blog-width]' :
		[
			{
				controls: [
					'analytica-settings[blog-max-width]'
				],
				callback: function( blog_width ) {

					if ( 'custom' == blog_width ) {
						return true;
					}
					return false;
				}
		}
		],
		'analytica-settings[blog-post-structure]' :
		[
			{
				controls: [
					'analytica-settings[blog-meta]',
				],
				callback: function( blog_structure ) {
					if ( jQuery.inArray ( "title-meta", blog_structure ) !== -1 ) {
						return true;
					}
					return false;
				}
			}
		],

		/**
		 * Blog Single
		 */
		 'analytica-settings[blog-single-post-structure]' :
		[
			{
				controls: [
					'analytica-settings[blog-single-meta]',
				],
				callback: function( blog_structure ) {
					if ( jQuery.inArray ( "single-title-meta", blog_structure ) !== -1 ) {
						return true;
					}
					return false;
				}
			}
		],
		'analytica-settings[blog-single-width]' :
		[
			{
				controls: [
					'analytica-settings[blog-single-max-width]'
				],
				callback: function( blog_width ) {

					if ( 'custom' == blog_width ) {
						return true;
					}
					return false;
				}
		}
		],
		'analytica-settings[blog-single-meta]' :
		[
			{
				controls: [
					'analytica-settings[blog-single-meta-comments]',
					'analytica-settings[blog-single-meta-cat]',
					'analytica-settings[blog-single-meta-author]',
					'analytica-settings[blog-single-meta-date]',
					'analytica-settings[blog-single-meta-tag]',
				],
				callback: function( enable_postmeta ) {

					if ( '1' == enable_postmeta ) {
						return true;
					}
					return false;
				}
		}
		],

		/**
		 * Small Footer
		 */
		'analytica-settings[footer-sml-layout]' :
		[
			{
				controls: [
					'analytica-settings[footer-sml-section-1]',
					'analytica-settings[footer-sml-section-2]',
					'analytica-settings[section-ast-small-footer-background-styling]',
					'analytica-settings[ast-small-footer-color]',
					'analytica-settings[ast-small-footer-link-color]',
					'analytica-settings[ast-small-footer-link-hover-color]',
					'analytica-settings[ast-small-footer-bg-img]',
					'analytica-settings[section-ast-small-footer-typography]',
					'analytica-settings[ast-small-footer-text-font]',
					'analytica-settings[footer-sml-divider]',
					'analytica-settings[section-ast-small-footer-layout-info]',
					'analytica-settings[footer-layout-width]',
					'analytica-settings[footer-color]',
					'analytica-settings[footer-link-color]',
					'analytica-settings[footer-link-h-color]',
					'analytica-settings[footer-bg-obj]',
					'analytica-settings[divider-footer-image]',
				],
				callback: function( small_footer_layout ) {

					if ( 'disabled' != small_footer_layout ) {
						return true;
					}
					return false;
				}
			},
			{
				controls: [
					'analytica-settings[footer-sml-section-1-credit]',
				],
				callback: function( small_footer_layout ) {

					var footer_section_1 = api( 'analytica-settings[footer-sml-section-1]' ).get();

					if ( 'disabled' != small_footer_layout && 'custom' == footer_section_1 ) {
						return true;
					}
					return false;
				}
			},
			{
				controls: [
					'analytica-settings[footer-sml-section-2-credit]',
				],
				callback: function( small_footer_layout ) {

					var footer_section_2 = api( 'analytica-settings[footer-sml-section-2]' ).get();

					if ( 'disabled' != small_footer_layout && 'custom' == footer_section_2 ) {
						return true;
					}
					return false;
				}
			},
			{
				controls: [
					'analytica-settings[footer-sml-divider-color]',
				],
				callback: function( small_footer_layout ) {

					var border_width = api( 'analytica-settings[footer-sml-divider]' ).get();

					if ( '1' <= border_width && 'disabled' != small_footer_layout ) {
						return true;
					}
					return false;
				}
			},
		],
		'analytica-settings[footer-sml-section-1]' :
		[
			{
				controls: [
					'analytica-settings[footer-sml-section-1-credit]',
				],
				callback: function( enabled_section_1 ) {

					var footer_layout = api( 'analytica-settings[footer-sml-layout]' ).get();

					if ( 'custom' == enabled_section_1 && 'disabled' != footer_layout ) {
						return true;
					}
					return false;
				}
			}
		],
		'analytica-settings[footer-sml-section-2]' :
		[
			{
				controls: [
					'analytica-settings[footer-sml-section-2-credit]',
				],
				callback: function( enabled_section_2 ) {

					var footer_layout = api( 'analytica-settings[footer-sml-layout]' ).get();

					if ( 'custom' == enabled_section_2 && 'disabled' != footer_layout ) {
						return true;
					}
					return false;
				}
			}
		],

		'analytica-settings[footer-sml-divider]' :
		[
			{
				controls: [
					'analytica-settings[footer-sml-divider-color]',
				],
				callback: function( border_width ) {

					var footer_layout = api( 'analytica-settings[footer-sml-layout]' ).get();

					if ( '1' <= border_width && 'disabled' != footer_layout ) {
						return true;
					}
					return false;
				}
			},
		],

		'analytica-settings[header-main-sep]' :
		[
			{
				controls: [
					'analytica-settings[header-main-sep-color]',
				],
				callback: function( border_width ) {

					if ( '1' <= border_width ) {
						return true;
					}
					return false;
				}
			},
		],

		'analytica-settings[disable-primary-nav]' :
		[
			{
				controls: [
					'analytica-settings[header-main-menu-label]',
					'analytica-settings[header-main-menu-label-divider]',
				],
				callback: function( menu ) {
					var custom_menu = api( 'analytica-settings[header-main-rt-section]' ).get();
					if ( !menu || 'none' !=  custom_menu) {
						return true;
					}
					return false;
				}
			},
		],

		/**
		 * Footer Widgets
		 */
		'analytica-settings[footer-adv]' :
		[
			{
				controls: [
					'analytica-settings[footer-adv-background-divider]',
					'analytica-settings[footer-adv-wgt-title-color]',
					'analytica-settings[footer-adv-text-color]',
					'analytica-settings[footer-adv-link-color]',
					'analytica-settings[footer-adv-link-h-color]',
					'analytica-settings[footer-adv-bg-obj]',
				],
				callback: function( footer_widget_area ) {

					if ( 'disabled' != footer_widget_area ) {
						return true;
					}
					return false;
				}
			},
		],
		'analytica-settings[shop-archive-width]' :
		[
			{
				controls: [
					'analytica-settings[shop-archive-max-width]'
				],
				callback: function( blog_width ) {

					if ( 'custom' == blog_width ) {
						return true;
					}
					return false;
				}
			}
		],
	};
} )( jQuery );
/**
 * Customizer controls
 *
 * @package Analytica
 */

( function( $ ) {

	/* Internal shorthand */
	var api = wp.customize;

	/**
	 * Helper class for the main Customizer interface.
	 *
	 * @since 1.0.0
	 * @class ASTCustomizer
	 */
	ASTCustomizer = {

		controls	: {},

		/**
		 * Initializes our custom logic for the Customizer.
		 *
		 * @since 1.0.0
		 * @method init
		 */
		init: function()
		{
			ASTCustomizer._initToggles();
		},

		/**
		 * Initializes the logic for showing and hiding controls
		 * when a setting changes.
		 *
		 * @since 1.0.0
		 * @access private
		 * @method _initToggles
		 */
		_initToggles: function()
		{
			// Trigger the Adv Tab Click trigger.
			ASTControlTrigger.triggerHook( 'analytica-toggle-control', api );

			// Loop through each setting.
			$.each( ASTCustomizerToggles, function( settingId, toggles ) {

				// Get the setting object.
				api( settingId, function( setting ) {

					// Loop though the toggles for the setting.
					$.each( toggles, function( i, toggle ) {

						// Loop through the controls for the toggle.
						$.each( toggle.controls, function( k, controlId ) {

							// Get the control object.
							api.control( controlId, function( control ) {

								// Define the visibility callback.
								var visibility = function( to ) {
									control.container.toggle( toggle.callback( to ) );
								};

								// Init visibility.
								visibility( setting.get() );

								// Bind the visibility callback to the setting.
								setting.bind( visibility );
							});
						});
					});
				});

				// Hide Section without Controls.
				$( '.customize-control *[data-customize-setting-link="' + settingId + '"]' ).on('change', function() {

					setTimeout( function() {
						$.each(toggles, function( i, toggle) {

							$.each(toggle.controls, function( k, controlId) {

								controlId = controlId.replace( 'analytica-settings[','' ).replace( ']','' );
								var parent = $( '#customize-control-analytica-settings-' + controlId ).closest( '.control-section' );
								if ( typeof parent != 'undefined' ) {

									var parentId = parent.attr( 'id' );
									var visibleIt = false;

									parent.find( ' > .customize-control' ).each(function(i,e) {
										if ( $( this ).css( 'display' ) != 'none' ) {
											visibleIt = true;
										}
									});

									if ( ! visibleIt ) {
										$( '.control-section[aria-owns="' + parentId + '"]' ).addClass( 'ast-hide' );
									} else {
										$( '.control-section[aria-owns="' + parentId + '"]' ).removeClass( 'ast-hide' );
									}
								}
							});
						});
					},300);
				});

				$.each(toggles, function( i, toggle) {

					$.each(toggle.controls, function( k, controlId) {

						controlId = controlId.replace( 'analytica-settings[','' ).replace( ']','' );
						var parent = $( '#customize-control-analytica-settings-' + controlId ).closest( '.control-section' );

						if ( typeof parent != 'undefined' ) {

							var parentId = parent.attr( 'id' );
							var visibleIt = false;

							parent.find( ' > .customize-control' ).each(function(i,e) {
								if ( $( this ).css( 'display' ) != 'none' ) {
									visibleIt = true;
								}
							});

							if ( ! visibleIt ) {
								$( '.control-section[aria-owns="' + parentId + '"]' ).addClass( 'ast-hide' );
							} else {
								$( '.control-section[aria-owns="' + parentId + '"]' ).removeClass( 'ast-hide' );
							}
						}
					});
				});

			});
		}
	};

	$( function() { ASTCustomizer.init(); } );

})( jQuery );


( function( api ) {
    // Extends our custom analytica-pro section.
    api.sectionConstructor['analytica-pro'] = api.Section.extend( {
        // No events for this type of section.
        attachEvents: function () {},
        // Always make the section active.
        isContextuallyActive: function () {
            return true;
        }
    } );
} )( wp.customize );
/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 *
 * @package Analytica
 */

/**
 * Generate font size in PX & REM
 */
function analytica_font_size_rem( size, with_rem, device ) {

	var css = '';

	if( size != '' ) {

		var device = ( typeof device != undefined ) ? device : 'desktop';

		// font size with 'px'.
		css = 'font-size: ' + size + 'px;';

		// font size with 'rem'.
		if ( with_rem ) {
			var body_font_size = wp.customize( 'analytica-settings[font-size-body]' ).get();

			body_font_size['desktop'] 	= ( body_font_size['desktop'] != '' ) ? body_font_size['desktop'] : 15;
			body_font_size['tablet'] 	= ( body_font_size['tablet'] != '' ) ? body_font_size['tablet'] : body_font_size['desktop'];
			body_font_size['mobile'] 	= ( body_font_size['mobile'] != '' ) ? body_font_size['mobile'] : body_font_size['tablet'];

			css += 'font-size: ' + ( size / body_font_size[device] ) + 'rem;';
		}
	}

	return css;
}

/**
 * Responsive Font Size CSS
 */
function analytica_responsive_font_size( control, selector ) {

	wp.customize( control, function( value ) {
		value.bind( function( value ) {

			if ( value.desktop || value.mobile || value.tablet ) {
				// Remove <style> first!
				control = control.replace( '[', '-' );
				control = control.replace( ']', '' );
				jQuery( 'style#' + control ).remove();

				var fontSize = '',
					TabletFontSize = '',
					MobileFontSize = '';


				if ( '' != value.desktop ) {
					fontSize = 'font-size: ' + value.desktop + value['desktop-unit'];
				}
				if ( '' != value.tablet ) {
					TabletFontSize = 'font-size: ' + value.tablet + value['tablet-unit'];
				}
				if ( '' != value.mobile ) {
					MobileFontSize = 'font-size: ' + value.mobile + value['mobile-unit'];
				}

				if( value['desktop-unit'] == 'px' ) {
					fontSize = analytica_font_size_rem( value.desktop, true, 'desktop' );
				}

				// Concat and append new <style>.
				jQuery( 'head' ).append(
					'<style id="' + control + '">'
					+ selector + '	{ ' + fontSize + ' }'
					+ '@media (max-width: 768px) {' + selector + '	{ ' + TabletFontSize + ' } }'
					+ '@media (max-width: 544px) {' + selector + '	{ ' + MobileFontSize + ' } }'
					+ '</style>'
				);

			} else {

				jQuery( 'style#' + control ).remove();
			}

		} );
	} );
}

/**
 * Responsive Spacing CSS
 */
function analytica_responsive_spacing( control, selector, type, side ) {

	wp.customize( control, function( value ) {
		value.bind( function( value ) {
			var sidesString = "";
			var spacingType = "padding";
			if ( value.desktop.top || value.desktop.right || value.desktop.bottom || value.desktop.left || value.tablet.top || value.tablet.right || value.tablet.bottom || value.tablet.left || value.mobile.top || value.mobile.right || value.mobile.bottom || value.mobile.left ) {
				if ( typeof side != undefined ) {
					sidesString = side + "";
					sidesString = sidesString.replace(/,/g , "-");
				}
				if ( typeof type != undefined ) {
					spacingType = type + "";
				}
				// Remove <style> first!
				control = control.replace( '[', '-' );
				control = control.replace( ']', '' );
				jQuery( 'style#' + control + '-' + spacingType + '-' + sidesString ).remove();

				var desktopPadding = '',
					tabletPadding = '',
					mobilePadding = '';

				var paddingSide = ( typeof side != undefined ) ? side : [ 'top','bottom','right','left' ];

				jQuery.each(paddingSide, function( index, sideValue ){
					if ( '' != value['desktop'][sideValue] ) {
						desktopPadding += spacingType + '-' + sideValue +': ' + value['desktop'][sideValue] + value['desktop-unit'] +';';
					}
				});

				jQuery.each(paddingSide, function( index, sideValue ){
					if ( '' != value['tablet'][sideValue] ) {
						tabletPadding += spacingType + '-' + sideValue +': ' + value['tablet'][sideValue] + value['tablet-unit'] +';';
					}
				});

				jQuery.each(paddingSide, function( index, sideValue ){
					if ( '' != value['mobile'][sideValue] ) {
						mobilePadding += spacingType + '-' + sideValue +': ' + value['mobile'][sideValue] + value['mobile-unit'] +';';
					}
				});

				// Concat and append new <style>.
				jQuery( 'head' ).append(
					'<style id="' + control + '-' + spacingType + '-' + sidesString + '">'
					+ selector + '	{ ' + desktopPadding +' }'
					+ '@media (max-width: 768px) {' + selector + '	{ ' + tabletPadding + ' } }'
					+ '@media (max-width: 544px) {' + selector + '	{ ' + mobilePadding + ' } }'
					+ '</style>'
				);

			} else {
				wp.customize.preview.send( 'refresh' );
				jQuery( 'style#' + control + '-' + spacingType + '-' + sidesString ).remove();
			}

		} );
	} );
}

/**
 * CSS
 */
function analytica_css_font_size( control, selector ) {

	wp.customize( control, function( value ) {
		value.bind( function( size ) {

			if ( size ) {

				// Remove <style> first!
				control = control.replace( '[', '-' );
				control = control.replace( ']', '' );
				jQuery( 'style#' + control ).remove();

				var fontSize = 'font-size: ' + size;
				if ( ! isNaN( size ) || size.indexOf( 'px' ) >= 0 ) {
					size = size.replace( 'px', '' );
					fontSize = analytica_font_size_rem( size, true );
				}

				// Concat and append new <style>.
				jQuery( 'head' ).append(
					'<style id="' + control + '">'
					+ selector + '	{ ' + fontSize + ' }'
					+ '</style>'
				);

			} else {

				jQuery( 'style#' + control ).remove();
			}

		} );
	} );
}

/**
 * Return get_hexdec()
 */
function get_hexdec( hex ) {
	var hexString = hex.toString( 16 );
	return parseInt( hexString, 16 );
}

/**
 * Apply CSS for the element
 */
function analytica_css( control, css_property, selector, unit ) {

	wp.customize( control, function( value ) {
		value.bind( function( new_value ) {

			// Remove <style> first!
			control = control.replace( '[', '-' );
			control = control.replace( ']', '' );

			if ( new_value ) {

				/**
				 *	If ( unit == 'url' ) then = url('{VALUE}')
				 *	If ( unit == 'px' ) then = {VALUE}px
				 *	If ( unit == 'em' ) then = {VALUE}em
				 *	If ( unit == 'rem' ) then = {VALUE}rem.
				 */
				if ( 'undefined' != typeof unit) {

					if ( 'url' === unit ) {
						new_value = 'url(' + new_value + ')';
					} else {
						new_value = new_value + unit;
					}
				}

				// Remove old.
				jQuery( 'style#' + control ).remove();

				// Concat and append new <style>.
				jQuery( 'head' ).append(
					'<style id="' + control + '">'
					+ selector + '	{ ' + css_property + ': ' + new_value + ' }'
					+ '</style>'
				);

			} else {

				wp.customize.preview.send( 'refresh' );

				// Remove old.
				jQuery( 'style#' + control ).remove();
			}

		} );
	} );
}


/**
 * Dynamic Internal/Embedded Style for a Control
 */
function analytica_add_dynamic_css( control, style ) {
	control = control.replace( '[', '-' );
	control = control.replace( ']', '' );
	jQuery( 'style#' + control ).remove();

	jQuery( 'head' ).append(
		'<style id="' + control + '">' + style + '</style>'
	);
}

/**
 * Generate background_obj CSS
 */
function analytica_background_obj_css( wp_customize, bg_obj, ctrl_name, style ) {

	var gen_bg_css 	= '';
	var bg_img		= bg_obj['background-image'];
	var bg_color	= bg_obj['background-color'];

	if( '' === bg_color && '' === bg_img ) {
		wp_customize.preview.send( 'refresh' );
	}else{
		if ( '' !== bg_img && '' !== bg_color) {
			if ( undefined !== bg_color ) {
				gen_bg_css = 'background-image: linear-gradient(to right, ' + bg_color + ', ' + bg_color + '), url(' + bg_img + ');';
			}
		}else if ( '' !== bg_img ) {
			gen_bg_css = 'background-image: url(' + bg_img + ');';
		}else if ( '' !== bg_color ) {
			gen_bg_css = 'background-color: ' + bg_color + ';';
			gen_bg_css += 'background-image: none;';
		}
		
		if ( '' !== bg_img ) {

			gen_bg_css += 'background-repeat: ' + bg_obj['background-repeat'] + ';';
			gen_bg_css += 'background-position: ' + bg_obj['background-position'] + ';';
			gen_bg_css += 'background-size: ' + bg_obj['background-size'] + ';';
			gen_bg_css += 'background-attachment: ' + bg_obj['background-attachment'] + ';';
		}

		var dynamicStyle = style.replace( "{{css}}", gen_bg_css );

		analytica_add_dynamic_css( ctrl_name, dynamicStyle );
	}
}

( function( $ ) {

	/*
	 * Site Identity Logo Width
	 */
	wp.customize( 'analytica-settings[ast-header-responsive-logo-width]', function( setting ) {
		setting.bind( function( logo_width ) {
			if ( logo_width['desktop'] != '' || logo_width['tablet'] != '' || logo_width['mobile'] != '' ) {
				var dynamicStyle = '#masthead .site-logo-img .custom-logo-link img { max-width: ' + logo_width['desktop'] + 'px;} .analytica-logo-svg{width: ' + logo_width['desktop'] + 'px;} @media( max-width: 768px ) { #masthead .site-logo-img .custom-logo-link img { max-width: ' + logo_width['tablet'] + 'px;} .analytica-logo-svg{width: ' + logo_width['tablet'] + 'px; } } @media( max-width: 544px ) { .ast-header-break-point .site-branding img, .ast-header-break-point #masthead .site-logo-img .custom-logo-link img { max-width: ' + logo_width['mobile'] + 'px;} .analytica-logo-svg{width: ' + logo_width['mobile'] + 'px; } }';
				analytica_add_dynamic_css( 'ast-header-responsive-logo-width', dynamicStyle );
			}
			else{
				wp.customize.preview.send( 'refresh' );
			}
		} );
	} );

	/*
	 * Full width layout
	 */
	wp.customize( 'analytica-settings[site-content-width]', function( setting ) {
		setting.bind( function( width ) {


				var dynamicStyle = '@media (min-width: 554px) {';
				dynamicStyle += '.ast-container, .fl-builder #content .entry-header { max-width: ' + ( 40 + parseInt( width ) ) + 'px } ';
				dynamicStyle += '}';
				if (  jQuery( 'body' ).hasClass( 'ast-page-builder-template' ) ) {
					dynamicStyle += '@media (min-width: 554px) {';
					dynamicStyle += '.ast-page-builder-template .comments-area { max-width: ' + ( 40 + parseInt( width ) ) + 'px } ';
					dynamicStyle += '}';
				}

				analytica_add_dynamic_css( 'site-content-width', dynamicStyle );

		} );
	} );

	/*
	 * Full width layout
	 */
	wp.customize( 'analytica-settings[header-main-menu-label]', function( setting ) {
		setting.bind( function( label ) {
			if( $('button.main-header-menu-toggle .mobile-menu-wrap .mobile-menu').length > 0 ) {
				if ( label != '' ) {
					$('button.main-header-menu-toggle .mobile-menu-wrap .mobile-menu').text(label);
				} else {
					$('button.main-header-menu-toggle .mobile-menu-wrap').remove();
				}
			} else {
				var html = $('button.main-header-menu-toggle').html();
				if( '' != label ) {
					html += '<div class="mobile-menu-wrap"><span class="mobile-menu">'+ label +'</span> </div>';
				}
				$('button.main-header-menu-toggle').html( html )
			}
		} );
	} );

	/*
	 * Layout Body Background
	 */
	wp.customize( 'analytica-settings[site-layout-outside-bg-obj]', function( value ) {
		value.bind( function( bg_obj ) {

			var dynamicStyle = 'body,.ast-separate-container { {{css}} }';
			
			analytica_background_obj_css( wp.customize, bg_obj, 'site-layout-outside-bg-obj', dynamicStyle );
		} );
	} );

	/*
	 * Blog Custom Width
	 */
	wp.customize( 'analytica-settings[blog-max-width]', function( setting ) {
		setting.bind( function( width ) {

			var dynamicStyle = '@media all and ( min-width: 921px ) {';

			if ( ! jQuery( 'body' ).hasClass( 'ast-woo-shop-archive' ) ) {
			dynamicStyle += '.blog .site-content > .ast-container,.archive .site-content > .ast-container{ max-width: ' + (  parseInt( width ) ) + 'px } ';
			}

			if (  jQuery( 'body' ).hasClass( 'ast-fluid-width-layout' ) ) {
				dynamicStyle += '.blog .site-content > .ast-container,.archive .site-content > .ast-container{ padding-left:20px; padding-right:20px; } ';
			}
				dynamicStyle += '}';
				analytica_add_dynamic_css( 'blog-max-width', dynamicStyle );

		} );
	} );

	/*
	 * Single Blog Custom Width
	 */
	wp.customize( 'analytica-settings[blog-single-max-width]', function( setting ) {
		setting.bind( function( width ) {

				var dynamicStyle = '@media all and ( min-width: 921px ) {';

				dynamicStyle += '.single-post .site-content > .ast-container{ max-width: ' + ( 40 + parseInt( width ) ) + 'px } ';

			if (  jQuery( 'body' ).hasClass( 'ast-fluid-width-layout' ) ) {
				dynamicStyle += '.single-post .site-content > .ast-container{ padding-left:20px; padding-right:20px; } ';
			}
				dynamicStyle += '}';
				analytica_add_dynamic_css( 'blog-single-max-width', dynamicStyle );

		} );
	} );

	/**
	 * Primary Width Option
	 */
	wp.customize( 'analytica-settings[site-sidebar-width]', function( setting ) {
		setting.bind( function( width ) {

			if ( ! jQuery( 'body' ).hasClass( 'ast-no-sidebar' ) && width >= 15 && width <= 50 ) {

				var dynamicStyle = '@media (min-width: 769px) {';

				dynamicStyle += '#primary { width: ' + ( 100 - parseInt( width ) ) + '% } ';
				dynamicStyle += '#secondary { width: ' + width + '% } ';
				dynamicStyle += '}';

				analytica_add_dynamic_css( 'site-sidebar-width', dynamicStyle );
			}

		} );
	} );

	/**
	 * Header Bottom Border
	 */
	wp.customize( 'analytica-settings[header-main-sep]', function( setting ) {
		setting.bind( function( border ) {

			var dynamicStyle = 'body.ast-header-break-point .site-header { border-bottom-width: ' + border + 'px }';

			dynamicStyle += 'body:not(.ast-header-break-point) .main-header-bar {';
			dynamicStyle += 'border-bottom-width: ' + border + 'px';
			dynamicStyle += '}';

			analytica_add_dynamic_css( 'header-main-sep', dynamicStyle );

		} );
	} );

	/**
	 * Small Footer Top Border
	 */
	wp.customize( 'analytica-settings[footer-sml-divider]', function( value ) {
		value.bind( function( border_width ) {
			jQuery( '.ast-small-footer' ).css( 'border-top-width', border_width + 'px' );
		} );
	} );

	/**
	 * Small Footer Top Border Color
	 */
	wp.customize( 'analytica-settings[footer-sml-divider-color]', function( value ) {
		value.bind( function( border_color ) {
			jQuery( '.ast-small-footer' ).css( 'border-top-color', border_color );
		} );
	} );

	/**
	 * Button Border Radius
	 */
	wp.customize( 'analytica-settings[button-radius]', function( setting ) {
		setting.bind( function( border ) {

			var dynamicStyle = '.menu-toggle,button,.ast-button,input#submit,input[type="button"],input[type="submit"],input[type="reset"] { border-radius: ' + ( parseInt( border ) ) + 'px } ';
			if (  jQuery( 'body' ).hasClass( 'woocommerce' ) ) {
				dynamicStyle += '.woocommerce a.button, .woocommerce button.button, .woocommerce .product a.button, .woocommerce .woocommerce-message a.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce input.button,.woocommerce input.button:disabled, .woocommerce input.button:disabled[disabled] { border-radius: ' + ( parseInt( border ) ) + 'px } ';
			}
			analytica_add_dynamic_css( 'button-radius', dynamicStyle );

		} );
	} );

	/**
	 * Button Vertical Padding
	 */
	wp.customize( 'analytica-settings[button-v-padding]', function( setting ) {
		setting.bind( function( padding ) {

			var dynamicStyle = '.menu-toggle,button,.ast-button,input#submit,input[type="button"],input[type="submit"],input[type="reset"] { padding-top: ' + ( parseInt( padding ) ) + 'px; padding-bottom: ' + ( parseInt( padding ) ) + 'px } ';
			
			if (  jQuery( 'body' ).hasClass( 'woocommerce' ) ) {
				dynamicStyle += '.woocommerce a.button, .woocommerce button.button, .woocommerce .product a.button, .woocommerce .woocommerce-message a.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce input.button,.woocommerce input.button:disabled, .woocommerce input.button:disabled[disabled] { padding-top: ' + ( parseInt( padding ) ) + 'px; padding-bottom: ' + ( parseInt( padding ) ) + 'px } ';
			}
			analytica_add_dynamic_css( 'button-v-padding', dynamicStyle );

		} );
	} );

	/**
	 * Button Horizontal Padding
	 */
	wp.customize( 'analytica-settings[button-h-padding]', function( setting ) {
		setting.bind( function( padding ) {

			var dynamicStyle = '.menu-toggle,button,.ast-button,input#submit,input[type="button"],input[type="submit"],input[type="reset"] { padding-left: ' + ( parseInt( padding ) ) + 'px; padding-right: ' + ( parseInt( padding ) ) + 'px } ';
			if (  jQuery( 'body' ).hasClass( 'woocommerce' ) ) {
				dynamicStyle += '.woocommerce a.button, .woocommerce button.button, .woocommerce .product a.button, .woocommerce .woocommerce-message a.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce input.button,.woocommerce input.button:disabled, .woocommerce input.button:disabled[disabled] { padding-left: ' + ( parseInt( padding ) ) + 'px; padding-right: ' + ( parseInt( padding ) ) + 'px } ';
			}
			analytica_add_dynamic_css( 'button-h-padding', dynamicStyle );

		} );
	} );

	/**
	 * Header Bottom Border width
	 */
	wp.customize( 'analytica-settings[header-main-sep]', function( value ) {
		value.bind( function( border ) {

			var dynamicStyle = ' body.ast-header-break-point .site-header { border-bottom-width: ' + border + 'px } ';

			dynamicStyle += 'body:not(.ast-header-break-point) .main-header-bar {';
			dynamicStyle += 'border-bottom-width: ' + border + 'px';
			dynamicStyle += '}';

			analytica_add_dynamic_css( 'header-main-sep', dynamicStyle );

		} );
	} );

	/**
	 * Header Bottom Border color
	 */
	wp.customize( 'analytica-settings[header-main-sep-color]', function( value ) {
		value.bind( function( color ) {
			if (color == '') {
				wp.customize.preview.send( 'refresh' );
			}

			if ( color ) {

				var dynamicStyle = ' body:not(.ast-header-break-point) .main-header-bar { border-bottom-color: ' + color + '; } ';
					dynamicStyle += ' body.ast-header-break-point .site-header { border-bottom-color: ' + color + '; } ';

				analytica_add_dynamic_css( 'header-main-sep-color', dynamicStyle );
			}

		} );
	} );


	analytica_responsive_font_size( 'analytica-settings[font-size-site-tagline]', '.site-header .site-description' );
	analytica_responsive_font_size( 'analytica-settings[font-size-site-title]', '.site-title' );
	analytica_responsive_font_size( 'analytica-settings[font-size-entry-title]', '.ast-single-post .entry-title, .page-title' );
	analytica_responsive_font_size( 'analytica-settings[font-size-archive-summary-title]', '.ast-archive-description .ast-archive-title' );
	analytica_responsive_font_size( 'analytica-settings[font-size-page-title]', 'body:not(.ast-single-post) .entry-title' );
	analytica_responsive_font_size( 'analytica-settings[font-size-h1]', 'h1, .entry-content h1, .entry-content h1 a' );
	analytica_responsive_font_size( 'analytica-settings[font-size-h2]', 'h2, .entry-content h2, .entry-content h2 a' );
	analytica_responsive_font_size( 'analytica-settings[font-size-h3]', 'h3, .entry-content h3, .entry-content h3 a' );
	analytica_responsive_font_size( 'analytica-settings[font-size-h4]', 'h4, .entry-content h4, .entry-content h4 a' );
	analytica_responsive_font_size( 'analytica-settings[font-size-h5]', 'h5, .entry-content h5, .entry-content h5 a' );
	analytica_responsive_font_size( 'analytica-settings[font-size-h6]', 'h6, .entry-content h6, .entry-content h6 a' );

	analytica_css( 'analytica-settings[body-line-height]', 'line-height', 'body, button, input, select, textarea' );
	// paragraph margin bottom.
	wp.customize( 'analytica-settings[para-margin-bottom]', function( value ) {
		value.bind( function( marginBottom ) {
			if ( marginBottom == '' ) {
				wp.customize.preview.send( 'refresh' );
			}

			if ( marginBottom ) {
				var dynamicStyle = ' p, .entry-content p { margin-bottom: ' + marginBottom + 'em; } ';
				analytica_add_dynamic_css( 'para-margin-bottom', dynamicStyle );
			}

		} );
	} );

	analytica_css( 'analytica-settings[body-text-transform]', 'text-transform', 'body, button, input, select, textarea' );

	analytica_css( 'analytica-settings[headings-text-transform]', 'text-transform', 'h1, .entry-content h1, .entry-content h1 a, h2, .entry-content h2, .entry-content h2 a, h3, .entry-content h3, .entry-content h3 a, h4, .entry-content h4, .entry-content h4 a, h5, .entry-content h5, .entry-content h5 a, h6, .entry-content h6, .entry-content h6 a' );

	// Footer Bar.
	analytica_css( 'analytica-settings[footer-color]', 'color', '.ast-small-footer' );
	analytica_css( 'analytica-settings[footer-link-color]', 'color', '.ast-small-footer a' );
	analytica_css( 'analytica-settings[footer-link-h-color]', 'color', '.ast-small-footer a:hover' );

	wp.customize( 'analytica-settings[footer-bg-obj]', function( value ) {
		value.bind( function( bg_obj ) {

			var dynamicStyle = ' .ast-small-footer > .ast-footer-overlay { {{css}} }';
			
			analytica_background_obj_css( wp.customize, bg_obj, 'footer-bg-obj', dynamicStyle );
		} );
	} );

	// Footer Widgets.
	analytica_css( 'analytica-settings[footer-adv-wgt-title-color]', 'color', '.footer-adv .widget-title, .footer-adv .widget-title a' );
	analytica_css( 'analytica-settings[footer-adv-text-color]', 'color', '.footer-adv' );

	wp.customize( 'analytica-settings[footer-adv-bg-obj]', function( value ) {
		value.bind( function( bg_obj ) {
			
			var dynamicStyle = ' .footer-adv-overlay { {{css}} }';
			
			analytica_background_obj_css( wp.customize, bg_obj, 'footer-adv-bg-obj', dynamicStyle );
		} );
	} );

	/*
	 * Woocommerce Shop Archive Custom Width
	 */
	wp.customize( 'analytica-settings[shop-archive-max-width]', function( setting ) {
		setting.bind( function( width ) {

			var dynamicStyle = '@media all and ( min-width: 921px ) {';

			dynamicStyle += '.ast-woo-shop-archive .site-content > .ast-container{ max-width: ' + (  parseInt( width ) ) + 'px } ';

			if (  jQuery( 'body' ).hasClass( 'ast-fluid-width-layout' ) ) {
				dynamicStyle += '.ast-woo-shop-archive .site-content > .ast-container{ padding-left:20px; padding-right:20px; } ';
			}
				dynamicStyle += '}';
				analytica_add_dynamic_css( 'shop-archive-max-width', dynamicStyle );

		} );
	} );

} )( jQuery );

/**
 * Extend Customizer Panel
 *
 * @package Analytica
 */

( function( $ ) {

  var api = wp.customize;

  api.bind( 'pane-contents-reflowed', function() {

    // Reflow sections
    var sections = [];

    api.section.each( function( section ) {

      if (
        'ast_section' !== section.params.type ||
        'undefined' === typeof section.params.section
      ) {

        return;

      }

      sections.push( section );

    });

    sections.sort( api.utils.prioritySort ).reverse();

    $.each( sections, function( i, section ) {

      var parentContainer = $( '#sub-accordion-section-' + section.params.section );

      parentContainer.children( '.section-meta' ).after( section.headContainer );

    });

    // Reflow panels
    var panels = [];

    api.panel.each( function( panel ) {

      if (
        'ast_panel' !== panel.params.type ||
        'undefined' === typeof panel.params.panel
      ) {

        return;

      }

      panels.push( panel );

    });

    panels.sort( api.utils.prioritySort ).reverse();

    $.each( panels, function( i, panel ) {

      var parentContainer = $( '#sub-accordion-panel-' + panel.params.panel );

      parentContainer.children( '.panel-meta' ).after( panel.headContainer );

    });

  });


  // Extend Panel
  var _panelEmbed = wp.customize.Panel.prototype.embed;
  var _panelIsContextuallyActive = wp.customize.Panel.prototype.isContextuallyActive;
  var _panelAttachEvents = wp.customize.Panel.prototype.attachEvents;

  wp.customize.Panel = wp.customize.Panel.extend({
    attachEvents: function() {

      if (
        'ast_panel' !== this.params.type ||
        'undefined' === typeof this.params.panel
      ) {

        _panelAttachEvents.call( this );

        return;

      }

      _panelAttachEvents.call( this );

      var panel = this;

      panel.expanded.bind( function( expanded ) {

        var parent = api.panel( panel.params.panel );

        if ( expanded ) {

          parent.contentContainer.addClass( 'current-panel-parent' );

        } else {

          parent.contentContainer.removeClass( 'current-panel-parent' );

        }

      });

      panel.container.find( '.customize-panel-back' )
        .off( 'click keydown' )
        .on( 'click keydown', function( event ) {

          if ( api.utils.isKeydownButNotEnterEvent( event ) ) {

            return;

          }

          event.preventDefault(); // Keep this AFTER the key filter above

          if ( panel.expanded() ) {

            api.panel( panel.params.panel ).expand();

          }

        });

    },
    embed: function() {

      if (
        'ast_panel' !== this.params.type ||
        'undefined' === typeof this.params.panel
      ) {

        _panelEmbed.call( this );

        return;

      }

      _panelEmbed.call( this );

      var panel = this;
      var parentContainer = $( '#sub-accordion-panel-' + this.params.panel );

      parentContainer.append( panel.headContainer );

    },
    isContextuallyActive: function() {

      if (
        'ast_panel' !== this.params.type
      ) {

        return _panelIsContextuallyActive.call( this );

      }

      var panel = this;
      var children = this._children( 'panel', 'section' );

      api.panel.each( function( child ) {

        if ( ! child.params.panel ) {

          return;

        }

        if ( child.params.panel !== panel.id ) {

          return;

        }

        children.push( child );

      });

      children.sort( api.utils.prioritySort );

      var activeCount = 0;

      _( children ).each( function ( child ) {

        if ( child.active() && child.isContextuallyActive() ) {

          activeCount += 1;

        }

      });

      return ( activeCount !== 0 );

    }

  });


  // Extend Section
  var _sectionEmbed = wp.customize.Section.prototype.embed;
  var _sectionIsContextuallyActive = wp.customize.Section.prototype.isContextuallyActive;
  var _sectionAttachEvents = wp.customize.Section.prototype.attachEvents;

  wp.customize.Section = wp.customize.Section.extend({
    attachEvents: function() {

      if (
        'ast_section' !== this.params.type ||
        'undefined' === typeof this.params.section
      ) {

        _sectionAttachEvents.call( this );

        return;

      }

      _sectionAttachEvents.call( this );

      var section = this;

      section.expanded.bind( function( expanded ) {

        var parent = api.section( section.params.section );

        if ( expanded ) {

          parent.contentContainer.addClass( 'current-section-parent' );

        } else {

          parent.contentContainer.removeClass( 'current-section-parent' );

        }

      });

      section.container.find( '.customize-section-back' )
        .off( 'click keydown' )
        .on( 'click keydown', function( event ) {

          if ( api.utils.isKeydownButNotEnterEvent( event ) ) {

            return;

          }

          event.preventDefault(); // Keep this AFTER the key filter above

          if ( section.expanded() ) {

            api.section( section.params.section ).expand();

          }

        });

    },
    embed: function() {

      if (
        'ast_section' !== this.params.type ||
        'undefined' === typeof this.params.section
      ) {

        _sectionEmbed.call( this );

        return;

      }

      _sectionEmbed.call( this );

      var section = this;
      var parentContainer = $( '#sub-accordion-section-' + this.params.section );

      parentContainer.append( section.headContainer );

    },
    isContextuallyActive: function() {

      if (
        'ast_section' !== this.params.type
      ) {

        return _sectionIsContextuallyActive.call( this );

      }

      var section = this;
      var children = this._children( 'section', 'control' );

      api.section.each( function( child ) {

        if ( ! child.params.section ) {

          return;

        }

        if ( child.params.section !== section.id ) {

          return;

        }

        children.push( child );

      });

      children.sort( api.utils.prioritySort );

      var activeCount = 0;

      _( children ).each( function ( child ) {

        if ( 'undefined' !== typeof child.isContextuallyActive ) {

          if ( child.active() && child.isContextuallyActive() ) {

            activeCount += 1;

          }

        } else {

          if ( child.active() ) {

            activeCount += 1;

          }

        }

      });

      return ( activeCount !== 0 );

    }

  });

})( jQuery );
/**!
 * wp-color-picker-alpha
 *
 * Overwrite Automattic Iris for enabled Alpha Channel in wpColorPicker
 * Only run in input and is defined data alpha in true
 *
 * Version: 2.0
 * https://github.com/kallookoo/wp-color-picker-alpha
 * Licensed under the GPLv2 license.
 */
( function( $ ) {
	// Variable for some backgrounds ( grid )
	var image   = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAIAAAHnlligAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAHJJREFUeNpi+P///4EDBxiAGMgCCCAGFB5AADGCRBgYDh48CCRZIJS9vT2QBAggFBkmBiSAogxFBiCAoHogAKIKAlBUYTELAiAmEtABEECk20G6BOmuIl0CIMBQ/IEMkO0myiSSraaaBhZcbkUOs0HuBwDplz5uFJ3Z4gAAAABJRU5ErkJggg==',
	// html stuff for wpColorPicker copy of the original color-picker.js
		_before = '<button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text"></span></button>',
		_after = '<div class="wp-picker-holder" />',
		_wrap = '<div class="wp-picker-container" />',
		_button = '<input type="button" class="button button-small" />',
		_wrappingLabel = '<label></label>',
		_wrappingLabelText = '<span class="screen-reader-text"></span>';

	/**
	 * Overwrite Color
	 * for enable support rbga
	 */
	Color.fn.toString = function() {
		if ( this._alpha < 1 )
			return this.toCSS( 'rgba', this._alpha ).replace( /\s+/g, '' );

		var hex = parseInt( this._color, 10 ).toString( 16 );

		if ( this.error )
			return '';

		if ( hex.length < 6 )
			hex = ( '00000' + hex ).substr( -6 );

		return '#' + hex;
	};

	/**
	 * Overwrite wpColorPicker
	 */
	$.widget( 'wp.wpColorPicker', $.wp.wpColorPicker, {
		/**
		 * @summary Creates the color picker.
		 *
		 * Creates the color picker, sets default values, css classes and wraps it all in HTML.
		 *
		 * @since 3.5.0
		 *
		 * @access private
		 *
		 * @returns {void}
		 */
		_create: function() {
			// Return early if Iris support is missing.
			if ( ! $.support.iris ) {
				return;
			}

			var self = this,
				el = self.element;

			// Override default options with options bound to the element.
			$.extend( self.options, el.data() );

			// Create a color picker which only allows adjustments to the hue.
			if ( self.options.type === 'hue' ) {
				return self._createHueOnly();
			}

			// Bind the close event.
			self.close = $.proxy( self.close, self );

			self.initialValue = el.val();

			// Add a CSS class to the input field.
			el.addClass( 'wp-color-picker' );

			/*
			 * Check if there's already a wrapping label, e.g. in the Customizer.
			 * If there's no label, add a default one to match the Customizer template.
			 */
			if ( ! el.parent( 'label' ).length ) {
				// Wrap the input field in the default label.
				el.wrap( _wrappingLabel );
				// Insert the default label text.
				self.wrappingLabelText = $( _wrappingLabelText )
					.insertBefore( el )
					.text( wpColorPickerL10n.defaultLabel );
			}

			/*
			 * At this point, either it's the standalone version or the Customizer
			 * one, we have a wrapping label to use as hook in the DOM, let's store it.
			 */
			self.wrappingLabel = el.parent();

			// Wrap the label in the main wrapper.
			self.wrappingLabel.wrap( _wrap );
			// Store a reference to the main wrapper.
			self.wrap = self.wrappingLabel.parent();
			// Set up the toggle button and insert it before the wrapping label.
			self.toggler = $( _before )
				.insertBefore( self.wrappingLabel )
				.css( { backgroundColor: self.initialValue } );
			// Set the toggle button span element text.
			self.toggler.find( '.wp-color-result-text' ).text( wpColorPickerL10n.pick );
			// Set up the Iris container and insert it after the wrapping label.
			self.pickerContainer = $( _after ).insertAfter( self.wrappingLabel );
			// Store a reference to the Clear/Default button.
			self.button = $( _button );

			// Set up the Clear/Default button.
			if ( self.options.defaultColor ) {
				self.button
					.addClass( 'wp-picker-default' )
					.val( wpColorPickerL10n.defaultString )
					.attr( 'aria-label', wpColorPickerL10n.defaultAriaLabel );
			} else {
				self.button
					.addClass( 'wp-picker-clear' )
					.val( wpColorPickerL10n.clear )
					.attr( 'aria-label', wpColorPickerL10n.clearAriaLabel );
			}

			// Wrap the wrapping label in its wrapper and append the Clear/Default button.
			self.wrappingLabel
				.wrap( '<span class="wp-picker-input-wrap hidden" />' )
				.after( self.button );

			/*
			 * The input wrapper now contains the label+input+Clear/Default button.
			 * Store a reference to the input wrapper: we'll use this to toggle
			 * the controls visibility.
			 */
			self.inputWrapper = el.closest( '.wp-picker-input-wrap' );

			/*
			 * CSS for support < 4.9
			 */
			self.toggler.css({
				'height': '24px',
				'margin': '0 6px 6px 0',
				'padding': '0 0 0 30px',
				'font-size': '11px'
			});

			self.toggler.find( '.wp-color-result-text' ).css({
				'background': '#f7f7f7',
				'border-radius': '0 2px 2px 0',
				'border-left': '1px solid #ccc',
				'color': '#555',
				'display': 'block',
				'line-height': '22px',
				'padding': '0 6px',
				'text-align': 'center'
			});

			el.iris( {
				target: self.pickerContainer,
				hide: self.options.hide,
				width: self.options.width,
				mode: self.options.mode,
				palettes: self.options.palettes,
				/**
				 * @summary Handles the onChange event if one has been defined in the options.
				 *
				 * Handles the onChange event if one has been defined in the options and additionally
				 * sets the background color for the toggler element.
				 *
				 * @since 3.5.0
				 *
				 * @param {Event} event    The event that's being called.
				 * @param {HTMLElement} ui The HTMLElement containing the color picker.
				 *
				 * @returns {void}
				 */
				change: function( event, ui ) {
					if ( self.options.alpha ) {
						self.toggler.css( {
							'background-image' : 'url(' + image + ')',
							'position' : 'relative'
						} );
						if ( self.toggler.find('span.color-alpha').length == 0 ) {
							self.toggler.append('<span class="color-alpha" />');
						}
						self.toggler.find( 'span.color-alpha' ).css( {
							'width'                     : '30px',
							'height'                    : '24px',
							'position'                  : 'absolute',
							'top'                       : 0,
							'left'                      : 0,
							'border-top-left-radius'    : '2px',
							'border-bottom-left-radius' : '2px',
							'background'                : ui.color.toString()
						} );
					} else {
						self.toggler.css( { backgroundColor : ui.color.toString() } );
					}

					if ( $.isFunction( self.options.change ) ) {
						self.options.change.call( this, event, ui );
					}
				}
			} );

			el.val( self.initialValue );
			self._addListeners();

			// Force the color picker to always be closed on initial load.
			if ( ! self.options.hide ) {
				self.toggler.click();
			}
		},
		/**
		 * @summary Binds event listeners to the color picker.
		 *
		 * @since 3.5.0
		 *
		 * @access private
		 *
		 * @returns {void}
		 */
		_addListeners: function() {
			var self = this;

			/**
			 * @summary Prevent any clicks inside this widget from leaking to the top and closing it.
			 *
			 * @since 3.5.0
			 *
			 * @param {Event} event The event that's being called.
			 *
			 * @returs {void}
			 */
			self.wrap.on( 'click.wpcolorpicker', function( event ) {
				event.stopPropagation();
			});

			/**
			 * @summary Open or close the color picker depending on the class.
			 *
			 * @since 3.5
			 */
			self.toggler.click( function(){
				if ( self.toggler.hasClass( 'wp-picker-open' ) ) {
					self.close();
				} else {
					self.open();
				}
			});

			/**
			 * @summary Checks if value is empty when changing the color in the color picker.
			 *
			 * Checks if value is empty when changing the color in the color picker.
			 * If so, the background color is cleared.
			 *
			 * @since 3.5.0
			 *
			 * @param {Event} event The event that's being called.
			 *
			 * @returns {void}
			 */
			self.element.on( 'change', function( event ) {
				// Empty or Error = clear
				if ( $( this ).val() === '' || self.element.hasClass( 'iris-error' ) ) {
					if ( self.options.alpha ) {
						self.toggler.find( 'span.color-alpha' ).css( 'backgroundColor', '' );
					} else {
						self.toggler.css( 'backgroundColor', '' );
					}

					// fire clear callback if we have one
					if ( $.isFunction( self.options.clear ) )
						self.options.clear.call( this, event );
				}
			} );

			/**
			 * @summary Enables the user to clear or revert the color in the color picker.
			 *
			 * Enables the user to either clear the color in the color picker or revert back to the default color.
			 *
			 * @since 3.5.0
			 *
			 * @param {Event} event The event that's being called.
			 *
			 * @returns {void}
			 */
			self.button.on( 'click', function( event ) {
				if ( $( this ).hasClass( 'wp-picker-clear' ) ) {
					self.element.val( '' );
					if ( self.options.alpha ) {
						self.toggler.find( 'span.color-alpha' ).css( 'backgroundColor', '' );
					} else {
						self.toggler.css( 'backgroundColor', '' );
					}

					if ( $.isFunction( self.options.clear ) )
						self.options.clear.call( this, event );

				} else if ( $( this ).hasClass( 'wp-picker-default' ) ) {
					self.element.val( self.options.defaultColor ).change();
				}
			});
		},
	});

	/**
	 * Overwrite iris
	 */
	$.widget( 'a8c.iris', $.a8c.iris, {
		_create: function() {
			this._super();

			// Global option for check is mode rbga is enabled
			this.options.alpha = this.element.data( 'alpha' ) || false;

			// Is not input disabled
			if ( ! this.element.is( ':input' ) )
				this.options.alpha = false;

			if ( typeof this.options.alpha !== 'undefined' && this.options.alpha ) {
				var self       = this,
					el         = self.element,
					_html      = '<div class="iris-strip iris-slider iris-alpha-slider"><div class="iris-slider-offset iris-slider-offset-alpha"></div></div>',
					aContainer = $( _html ).appendTo( self.picker.find( '.iris-picker-inner' ) ),
					aSlider    = aContainer.find( '.iris-slider-offset-alpha' ),
					controls   = {
						aContainer : aContainer,
						aSlider    : aSlider
					};

				if ( typeof el.data( 'custom-width' ) !== 'undefined' ) {
					self.options.customWidth = parseInt( el.data( 'custom-width' ) ) || 0;
				} else {
					self.options.customWidth = 100;
				}

				// Set default width for input reset
				self.options.defaultWidth = el.width();

				// Update width for input
				if ( self._color._alpha < 1 || self._color.toString().indexOf('rgb') != -1 )
					el.width( parseInt( self.options.defaultWidth + self.options.customWidth ) );

				// Push new controls
				$.each( controls, function( k, v ) {
					self.controls[k] = v;
				} );

				// Change size strip and add margin for sliders
				self.controls.square.css( { 'margin-right': '0' } );
				var emptyWidth   = ( self.picker.width() - self.controls.square.width() - 20 ),
					stripsMargin = ( emptyWidth / 6 ),
					stripsWidth  = ( ( emptyWidth / 2 ) - stripsMargin );

				$.each( [ 'aContainer', 'strip' ], function( k, v ) {
					self.controls[v].width( stripsWidth ).css( { 'margin-left' : stripsMargin + 'px' } );
				} );

				// Add new slider
				self._initControls();

				// For updated widget
				self._change();
			}
		},
		_initControls: function() {
			this._super();

			if ( this.options.alpha ) {
				var self     = this,
					controls = self.controls;

				controls.aSlider.slider({
					orientation : 'vertical',
					min         : 0,
					max         : 100,
					step        : 1,
					value       : parseInt( self._color._alpha * 100 ),
					slide       : function( event, ui ) {
						// Update alpha value
						self._color._alpha = parseFloat( ui.value / 100 );
						self._change.apply( self, arguments );
					}
				});
			}
		},
		_change: function() {
			this._super();

			var self = this,
				el   = self.element;

			if ( this.options.alpha ) {
				var	controls     = self.controls,
					alpha        = parseInt( self._color._alpha * 100 ),
					color        = self._color.toRgb(),
					gradient     = [
						'rgb(' + color.r + ',' + color.g + ',' + color.b + ') 0%',
						'rgba(' + color.r + ',' + color.g + ',' + color.b + ', 0) 100%'
					],
					defaultWidth = self.options.defaultWidth,
					customWidth  = self.options.customWidth,
					target       = self.picker.closest( '.wp-picker-container' ).find( '.wp-color-result' );

				// Generate background slider alpha, only for CSS3 old browser fuck!! :)
				controls.aContainer.css( { 'background' : 'linear-gradient(to bottom, ' + gradient.join( ', ' ) + '), url(' + image + ')' } );

				if ( target.hasClass( 'wp-picker-open' ) ) {
					// Update alpha value
					controls.aSlider.slider( 'value', alpha );

					/**
					 * Disabled change opacity in default slider Saturation ( only is alpha enabled )
					 * and change input width for view all value
					 */
					if ( self._color._alpha < 1 ) {
						controls.strip.attr( 'style', controls.strip.attr( 'style' ).replace( /rgba\(([0-9]+,)(\s+)?([0-9]+,)(\s+)?([0-9]+)(,(\s+)?[0-9\.]+)\)/g, 'rgb($1$3$5)' ) );
						el.width( parseInt( defaultWidth + customWidth ) );
					} else {
						el.width( defaultWidth );
					}
				}
			}

			var reset = el.data( 'reset-alpha' ) || false;

			if ( reset ) {
				self.picker.find( '.iris-palette-container' ).on( 'click.palette', '.iris-palette', function() {
					self._color._alpha = 1;
					self.active        = 'external';
					self._change();
				} );
			}
		},
		_addInputListeners: function( input ) {
			var self            = this,
				debounceTimeout = 100,
				callback        = function( event ) {
					var color = new Color( input.val() ),
						val   = input.val();

					input.removeClass( 'iris-error' );
					// we gave a bad color
					if ( color.error ) {
						// don't error on an empty input
						if ( val !== '' )
							input.addClass( 'iris-error' );
					} else {
						if ( color.toString() !== self._color.toString() ) {
							// let's not do this on keyup for hex shortcodes
							if ( ! ( event.type === 'keyup' && val.match( /^[0-9a-fA-F]{3}$/ ) ) )
								self._setOption( 'color', color.toString() );
						}
					}
				};

			input.on( 'change', callback ).on( 'keyup', self._debounce( callback, debounceTimeout ) );

			// If we initialized hidden, show on first focus. The rest is up to you.
			if ( self.options.hide ) {
				input.on( 'focus', function() {
					self.show();
				} );
			}
		}
	} );
}( jQuery ) );

// Auto Call plugin is class is color-picker
jQuery( document ).ready( function( $ ) {
	$( '.color-picker' ).wpColorPicker();
} );