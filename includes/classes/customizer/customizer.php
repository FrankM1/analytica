<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @category Analytica
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     http://qazana.net/
 */
namespace Analytica;

use Kirki;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * This is a wrapper class for Kirki.
 * If the Kirki plugin is installed, then all CSS & Google fonts
 * will be handled by the plugin.
 * In case the plugin is not installed, this acts as a fallback
 * ensuring that all CSS & fonts still work.
 * It does not handle the customizer options, simply the frontend CSS.
 */
class Customizer {

	/**
	 * @static
	 * @access protected
	 * @var array
	 */
	protected static $config = array();

	/**
	 * @static
	 * @access protected
	 * @var array
	 */
    protected static $fields = array();

    /**
	 * @static
	 * @access protected
	 * @var array
	 */
	protected static $defaults = array();

	/**
	 * The class constructor
	 */
	public function __construct() {

        self::$defaults = Options::defaults();

        add_filter( 'kirki_config', array( $this, 'configuration_styling' ) );
        add_action( 'after_setup_theme', array( $this, 'theme_defaults' ) );
        add_action( 'customize_register', array( $this, 'reorder_fields' ), 9999 );

        /**
         * Add the theme configuration
            */
        self::add_config( analytica()->theme_slug, array(
            'option_type'    => 'theme_mod',
            'capability'     => 'edit_theme_options',
            'disable_output' => true,
        ) );

		// If Kirki exists then there's no reason to procedd
		if ( class_exists( 'Kirki' ) ) {
            add_action( 'customize_controls_enqueue_scripts', array( $this, 'admin_js' ) );
			return;
		}

        // Add our CSS
        add_filter( 'analytica_dynamic_css_cached', array( $this, 'generate_styles' ));

        // Add google fonts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_fonts' ) );
    }

    /**
     * Here we organize the fields into one "Theme Options" section
     * @param $wp_customize
     */
    function reorder_fields( $wp_customize ) {

        $wp_customize->get_control( 'custom_logo' )->section  = 'logo-favicon';
        $wp_customize->get_control( 'custom_logo' )->priority = '1';

        $wp_customize->get_control( 'blogdescription' )->section  = 'logo-favicon';
        $wp_customize->get_control( 'blogdescription' )->priority = '2';

        $wp_customize->get_control( 'blogname' )->section  = 'logo-favicon';
        $wp_customize->get_control( 'blogname' )->priority = '3';

        $wp_customize->get_control( 'site_icon' )->section  = 'logo-favicon';
        $wp_customize->get_control( 'site_icon' )->priority = '4';

        $wp_customize->get_control( 'display_header_text' )->section  = 'logo-favicon';
        $wp_customize->get_control( 'display_header_text' )->priority = '5';
        $wp_customize->get_control( 'display_header_text' )->label = esc_html__( 'Display Site Title &amp; Tagline', 'analytica' );

		$wp_customize->get_control( 'header_textcolor' )->section  = 'logo-favicon';
		$wp_customize->get_control( 'header_textcolor' )->priority = '1';

        $site_logo_header_text = $wp_customize->get_control( 'site_logo_header_text' );

        // this field may be missing, so we need a check
        if ( ! empty( $site_logo_header_text ) ) {
            $site_logo_header_text->section = 'general';
        }

        // Add postMessage support for site title and tagline and title color.
        $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
        $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
        $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

        if ( class_exists( 'Kirki' ) ) {
			$wp_customize->get_section( 'background_image' )->panel  = 'general';
			$wp_customize->get_section( 'background_image' )->priority = '2';

			$wp_customize->get_control( 'background_color' )->panel  = 'general';
            $wp_customize->get_control( 'background_color' )->section  = 'container-style';
			$wp_customize->get_control( 'background_color' )->priority = '2';

            $wp_customize->get_control( 'header_image' )->panel  = 'site-hero';
            $wp_customize->get_control( 'header_image' )->section  = 'site-hero-background';
			$wp_customize->get_control( 'header_image' )->priority = '1';

			$wp_customize->get_control( 'header_video' )->panel  = 'site-hero';
            $wp_customize->get_control( 'header_video' )->section  = 'site-hero-background';
			$wp_customize->get_control( 'header_video' )->priority = '2';

			$wp_customize->get_control( 'external_header_video' )->panel  = 'site-hero';
            $wp_customize->get_control( 'external_header_video' )->section  = 'site-hero-background';
			$wp_customize->get_control( 'external_header_video' )->priority = '3';
        }
    }

    /**
     * Configuration sample for the Kirki Customizer.
    * The function's argument is an array of existing config values
    * The function returns the array with the addition of our own arguments
    * and then that result is used in the kirki_config filter
    *
    * @param $config the configuration array
    *
    * @return array
    */
    function configuration_styling( $config ) {
        return wp_parse_args( array( 'description' => wp_get_theme()->get( 'Description' ) ), $config );
    }

    /**
     * Register the customizer controls
     *
     * @param array $controls [description]
     */
    function theme_defaults() {

        $new_controls = Options::controls();

        if ( ! empty( $new_controls ) ) {
            foreach ( $new_controls as $control => $value ) {

                $args = array(
                    'type'        => $value['type'],
                    'section'     => ! empty( $value['section'] ) ? $value['section'] : 'general',
                    'default'     => ! empty( $value['default'] ) ? $value['default'] : '',
                    'label'       => ! empty( $value['title'] ) ? $value['title'] : $value['label'],
                    'description' => ! empty( $value['desc'] ) ? $value['desc'] : '',
                    'priority'    => ! empty( $value['priority'] ) ? $value['priority'] : 10,
                );

				$args = wp_parse_args( $args, $value );

                if ( ! empty( $value['options'] ) ) {
                    $args['choices'] = $value['options'];
                }

				if ( ! empty( $value['settings'] ) ) {
                    $args['settings'] = $value['settings'];
                } else {
                    $args['settings'] = $value['id'];
                }

                if ( ! empty( $value['conditions'] ) ) {
                    $args['active_callback'] = $value['conditions'];
                }

				$args['device'] = 'desktop';

                self::add_field( analytica()->theme_slug, $args );

                if ( ! empty( $value['responsive'] ) && $value['responsive'] ) {

                    $mobile_args = $args;
                    $mobile_args['settings'] = $args['settings'] . '-mobile';
                    $mobile_args['label'] = '';
                    $mobile_args['description'] = '';
                    $tablet_args['device'] = 'mobile';

                    self::add_field( analytica()->theme_slug, $mobile_args );

                    $tablet_args = $args;
                    $tablet_args['settings'] = $args['settings'] . '-tablet';
                    $tablet_args['label'] = '';
                    $tablet_args['description'] = '';
                    $tablet_args['device'] = 'tablet';

                    self::add_field( analytica()->theme_slug, $tablet_args );
                }
            }
        }
    }

    /**
     * Add Customizer scripts
     *
     * @since 1.0.0
     */
    function admin_js() {

        if ( ! is_customize_preview() ) {
            return;
        }

        wp_enqueue_style( 'analytica_customizer_style', analytica()->theme_url . '/assets/admin/css/customizer/customizer.css', null, analytica()->theme_version, false );
        wp_enqueue_script( 'analytica_customizer_general', analytica()->theme_url . '/assets/admin/js/modules/customizer/general.js', array( 'jquery' ), analytica()->theme_version, false );
        wp_enqueue_script( 'analytica_customizer_preview', analytica()->theme_url . '/assets/admin/js/modules/customizer/preview.js', array( 'jquery' ), analytica()->theme_version, false );

        wp_localize_script( 'analytica_customizer', 'RadiumCustomizerReset', array(
            'reset'   => esc_attr__( 'Reset', 'analytica' ),
            'confirm' => esc_attr__( "Attention! This will remove all customizations ever made via customizer to this theme!\n\nThis action is irreversible!", 'analytica' ),
            'nonce'   => array(
                'reset' => wp_create_nonce( 'customizer-reset' ),
            ),
        ) );

    }

	/**
	 * Get the value of an option from the db.
	 *
	 * @param    string    $config_id    The ID of the configuration corresponding to this field
	 * @param    string    $field_id     The field_id (defined as 'settings' in the field arguments)
	 *
	 * @return 	mixed 	the saved value of the field.
	 */
	public static function get_option( $config_id = '', $field_id = '' ) {

		// if Kirki exists, use it.
		if ( class_exists( 'Kirki' ) && isset( self::$fields[ $field_id ] ) ) {
            return Kirki::get_option( $config_id, $field_id );
		} elseif ( ! isset( self::$fields[ $field_id ] ) && isset( self::$defaults[ $field_id ] ) ) {
            return self::$defaults[ $field_id ];
        }

        // Kirki does not exist, continue with our custom implementation.
		// Get the default value of the field
		$default = '';
		if ( isset( self::$fields[ $field_id ] ) && isset( self::$fields[ $field_id ]['default'] ) ) {
			$default = self::$fields[ $field_id ]['default'];
        }

		// Make sure the config is defined
		if ( isset( self::$config[ $config_id ] ) ) {
			if ( 'option' == self::$config[ $config_id ]['option_type'] ) {
				// check if we're using serialized options
				if ( isset( self::$config[ $config_id ]['option_name'] ) && ! empty( self::$config[ $config_id ]['option_name'] ) ) {
					// Get all our options
					$all_options = get_option( self::$config[ $config_id ]['option_name'], array() );
					// If our option is not saved, return the default value.
					if ( ! isset( $all_options[ $field_id ] ) ) {
						return $default;
					}
					// Option was set, return its value unserialized.
					return maybe_unserialize( $all_options[ $field_id ] );
				}
				// If we're not using serialized options, get the value and return it.
				// We'll be using a dummy default here to check if the option has been set or not.
				// We'll be using md5 to make sure it's randomish and impossible to be actually set by a user.
				$dummy = md5( $config_id . '_UNDEFINED_VALUE' );
				$value = get_option( $field_id, $dummy );
				// setting has not been set, return default.
				if ( $dummy == $value ) {
					return $default;
				}
				return $value;
            }

            if ( get_theme_mod( $field_id, $default ) ) {
                $defaults = Options::defaults();
                return isset( $defaults[$field_id] ) ? $defaults[$field_id] : '';
            }
			// We're not using options so fallback to theme_mod
			return get_theme_mod( $field_id, $default );
		}
	}

	/**
	 * Create a new panel
	 *
	 * @param   string      the ID for this panel
	 * @param   array       the panel arguments
	 */
	public static function add_panel( $id = '', $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			Kirki::add_panel( $id, $args );
		}
		// If Kirki does not exist then there's no reason to add any panels.
	}

	/**
	 * Create a new section
	 *
	 * @param   string      the ID for this section
	 * @param   array       the section arguments
	 */
	public static function add_section( $id, $args ) {
		if ( class_exists( 'Kirki' ) ) {
			Kirki::add_section( $id, $args );
		}
		// If Kirki does not exist then there's no reason to add any sections.
	}

	/**
	 * Sets the configuration options.
	 *
	 * @param    string    $config_id    The configuration ID
	 * @param    array     $args         The configuration arguments
	 */
	public static function add_config( $config_id, $args = array() ) {
		// if Kirki exists, use it.
		if ( class_exists( 'Kirki' ) ) {
			Kirki::add_config( $config_id, $args );
		}
		// Kirki does not exist, set the config arguments
		$config[ $config_id ] = $args;
		// Make sure an option_type is defined
		if ( ! isset( self::$config[ $config_id ]['option_type'] ) ) {
			self::$config[ $config_id ]['option_type'] = 'theme_mod';
		}
	}

	/**
	 * Create a new field
	 *
	 * @param    string    $config_id    The configuration ID
	 * @param    array     $args         The field's arguments
	 */
	public static function add_field( $config_id, $args ) {
		// if Kirki exists, use it.
		if ( class_exists( 'Kirki' ) ) {
			Kirki::add_field( $config_id, $args );
		}
		// Kirki was not located, so we'll need to add our fields here.
		// check that the "settings" & "type" arguments have been defined
		if ( isset( $args['settings'] ) && isset( $args['type'] ) ) {
			// Make sure we add the config_id to the field itself.
			// This will make it easier to get the value when generating the CSS later.
			if ( ! isset( $args['kirki_config'] ) ) {
				$args['kirki_config'] = $config_id;
			}
			self::$fields[ $args['settings'] ] = $args;
		}
	}

	/**
	 * Enqueues the stylesheet
	 */
	public function generate_styles( $css ) {
		// If Kirki exists there's no need to proceed any further
		if ( class_exists( 'Kirki' ) ) {
			return $css;
		}
		// Get our inline styles
		$css .= $this->get_styles();

        return $css;
	}

	/**
	 * Gets all our styles and returns them as a string.
	 */
	public function get_styles() {
		// Get an array of all our fields
		$fields = self::$fields;
		// Check if we need to exit early
		if ( empty( self::$fields ) || ! is_array( $fields ) ) {
			return;
		}
		// initially we're going to format our styles as an array.
		// This is going to make processing them a lot easier
		// and make sure there are no duplicate styles etc.
		$css = array();
		// start parsing our fields
		foreach ( $fields as $field ) {
			// No need to process fields without an output, or an improperly-formatted output
			if ( ! isset( $field['output'] ) || empty( $field['output'] ) || ! is_array( $field['output'] ) ) {
				continue;
			}
			// Get the value of this field
			$value = self::get_option( $field['kirki_config'], $field['settings'] );
			// start parsing the output arguments of the field
			foreach ( $field['output'] as $output ) {
				$defaults = array(
					'element'       => '',
					'property'      => '',
					'media_query'   => 'global',
					'prefix'        => '',
					'units'         => '',
					'suffix'        => '',
					'value_pattern' => '$',
					'choice'        => '',
				);
				$output = wp_parse_args( $output, $defaults );
				// If element is an array, convert it to a string
				if ( is_array( $output['element'] ) ) {
					$output['element'] = array_unique( $output['element'] );
					sort( $output['element'] );
					$output['element'] = implode( ',', $output['element'] );
				}
				// Simple fields
				if ( ! is_array( $value ) ) {
					$value = str_replace( '$', $value, $output['value_pattern'] );
					if ( ! empty( $output['element'] ) && ! empty( $output['property'] ) ) {
						$css[ $output['media_query'] ][ $output['element'] ][ $output['property'] ] = $output['prefix'] . $value . $output['units'] . $output['suffix'];
					}
				} else {
					if ( 'typography' == $field['type'] ) {
						foreach ( $value as $key => $subvalue ) {
							// exclude subsets as a property
							if ( 'subsets' == $key ) {
								continue;
							}
							// add double quotes if needed to font-families
							if ( 'font-family' == $key && false !== strpos( $subvalue, ' ' ) && false === strpos( $subvalue, '"' ) ) {
								$css[ $output['media_query'] ][ $output['element'] ]['font-family'] = '"' . $subvalue . '"';
							}
							// variants contain both font-weight & italics
							if ( 'variant' == $key ) {
								$font_weight = str_replace( 'italic', '', $subvalue );
								$font_weight = ( in_array( $font_weight, array( '', 'regular' ) ) ) ? '400' : $font_weight;
								$css[ $output['media_query'] ][ $output['element'] ]['font-weight'] = $font_weight;
								// Is this italic?
								$is_italic = ( false !== strpos( $subvalue, 'italic' ) );
								if ( $is_italic ) {
									$css[ $output['media_query'] ][ $output['element'] ]['font-style'] = 'italic';
								}
							} else {
								$css[ $output['media_query'] ][ $output['element'] ][ $key ] = $subvalue;
							}
						}
					} elseif ( 'multicolor' == $field['type'] ) {
						if ( ! empty( $output['element'] ) && ! empty( $output['property'] ) && ! empty( $output['choice'] ) ) {
							$css[ $output['media_query'] ][ $output['element'] ][ $output['property'] ] = $output['prefix'] . $value[ $output['choice'] ] . $output['units'] . $output['suffix'];
						}
					} else {
						foreach ( $value as $key => $subvalue ) {
							$property = $key;
							if ( false !== strpos( $output['property'], '%%' ) ) {
								$property = str_replace( '%%', $key, $output['property'] );
							} elseif ( ! empty( $output['property'] ) ) {
								$output['property'] = $output['property'] . '-' . $key;
							}
							if ( 'background-image' === $output['property'] && false === strpos( $subvalue, 'url(' ) ) {
								$subvalue = 'url("' . $subvalue . '")';
							}
							if ( $subvalue ) {
								$css[ $output['media_query'] ][ $output['element'] ][ $property ] = $subvalue;
							}
						}
					}
				}
			}
		}
		// Process the array of CSS properties and produce the final CSS
		$final_css = '';
		if ( ! is_array( $css ) || empty( $css ) ) {
			return '';
		}
		// Parse the generated CSS array and create the CSS string for the output.
		foreach ( $css as $media_query => $styles ) {
			// Handle the media queries
			$final_css .= ( 'global' != $media_query ) ? $media_query . '{' : '';
			foreach ( $styles as $style => $style_array ) {
				$final_css .= $style . '{';
					foreach ( $style_array as $property => $value ) {
						$value = ( is_string( $value ) ) ? $value : '';
						// Make sure background-images are properly formatted
						if ( 'background-image' == $property ) {
							if ( false === strrpos( $value, 'url(' ) ) {
								$value = 'url("' . esc_url_raw( $value ) . '")';
							}
						} else {
							$value = esc_textarea( $value );
						}
						$final_css .= $property . ':' . $value . ';';
					}
				$final_css .= '}';
			}
			$final_css .= ( 'global' != $media_query ) ? '}' : '';
		}
		return $final_css;
	}

	public function enqueue_fonts() {
		// Check if we need to exit early
		if ( empty( self::$fields ) || ! is_array( self::$fields ) ) {
			return;
		}
		foreach ( self::$fields as $field ) {
			// Process typography fields
			if ( isset( $field['type'] ) && 'typography' == $field['type'] ) {
				// Check if we've got everything we need
				if ( ! isset( $field['kirki_config'] ) || ! isset( $field['settings'] ) ) {
					continue;
				}
				$value = self::get_option( $field['kirki_config'], $field['settings'] );
				if ( isset( $value['font-family'] ) ) {
					$url = '//fonts.googleapis.com/css?family=' . str_replace( ' ', '+', $value['font-family'] );
					if ( ! isset( $value['variant'] ) ) {
						$value['variant'] = '';
					}
					if ( ! empty( $value['variant'] ) ) {
						$url .= ':' . $value['variant'];
					}
					if ( ! isset( $value['subset'] ) ) {
						$value['subset'] = '';
					}
					if ( ! empty( $value['subset'] ) ) {
						if ( is_array( $value['subset'] ) ) {
							$value['subset'] = implode( ',', $value['subsets'] );
						}
						$url .= '&subset=' . $value['subset'];
					}
					$key = md5( $value['font-family'] . $value['variant'] . $value['subset'] );
					// check that the URL is valid. we're going to use transients to make this faster.
					$url_is_valid = get_transient( $key );
					if ( false === $url_is_valid ) { // transient does not exist
						$response = wp_remote_get( 'https:' . $url );
						if ( ! is_array( $response ) ) {
							// the url was not properly formatted,
							// cache for 12 hours and continue to the next field
							set_transient( $key, null, 12 * HOUR_IN_SECONDS );
							continue;
						}
						// check the response headers.
						if ( isset( $response['response'] ) && isset( $response['response']['code'] ) ) {
							if ( 200 == $response['response']['code'] ) {
								// URL was ok
								// set transient to true and cache for a week
								set_transient( $key, true, 7 * 24 * HOUR_IN_SECONDS );
								$url_is_valid = true;
							}
						}
					}
					// If the font-link is valid, enqueue it.
					if ( $url_is_valid ) {
						wp_enqueue_style( $key, $url, null, null );
					}
				}
			}
		}
	}
}
