<?php
namespace Analytica\Extensions\Page_Builder;

/**
 * This file is a part of the Analytica core.
 * Please be cautious editing this file,
 *
 * @package  Analytica\Extensions\Page_Builder\Qazana
 * @subpackage  Analytica
 * @author   Franklin Gitonga
 * @link     https://qazana.net/
 */

/**
 * Qazana Compatibility
 *
 * @since 1.0.0
 */
class Qazana {

    /**
     * Constructor
     */
    public function __construct() {
        if ( ! $this->is_builder_activated() ) {
            return;
        }
        add_filter( 'qazana/widgets/black_list', [ $this, 'wp_widget_black_list'] );
        add_filter( 'analytica_is_builder_page', [ $this, 'is_builder_page'], 10, 2 );
        add_filter( 'analytica_builder_is_active', [ $this, 'is_builder_activated'] );
        add_action( 'customize_save_after', [ $this, 'reset_schemes'], 100 );

		add_filter( 'pre_option_qazana_page_title_selector', [ $this, 'page_title_selector'] );

		add_filter( 'qazana/core/settings/page-settings/selector', [ $this, 'page_selector' ], 10, 2 );

        add_filter( 'qazana/schemes/default_color_picker_schemes', [ $this, 'default_color_picker_schemes'] );
        add_filter( 'qazana/schemes/system_color_schemes', [ $this, 'system_color_schemes'] );
        add_filter( 'qazana/schemes/default_color_schemes', [ $this, 'default_colors'] );
		add_filter( 'qazana/schemes/default_fonts', [ $this, 'reset_default_font'] );
		add_filter( 'qazana/footers/get_injection_hook', [ $this, 'site_footer_support' ] );

		add_filter( 'analytica_dynamic_css_cached', array( $this, 'add_container_css' ));
    }

    /**
     * Clean up qazana widgets
     *
     * @method analytica_qazana_hero
     * @return [type]                    [description]
     */
    function wp_widget_black_list( $widgets ) {

        $widgets[] = 'WP_Widget_Media_Audio';
        $widgets[] = 'WP_Widget_Media_Image';
        $widgets[] = 'WP_Widget_Media_Video';
        $widgets[] = 'WP_Widget_Meta';
        $widgets[] = 'WP_Widget_Search';
        $widgets[] = 'WP_Widget_Categories';
        $widgets[] = 'WP_Widget_Recent_Posts';
        $widgets[] = 'WP_Widget_Recent_Comments';
        $widgets[] = 'WP_Widget_Tag_Cloud';
        $widgets[] = 'WP_Widget_Custom_HTML';

        return $widgets;
	}

	/**
     * Add page selector to qazana
     *
     * @return string css selector
     */
    function page_selector( $base_selector, $model ) {
        return $base_selector . '.site-mono-container .site-container, ' . $base_selector . '.site-dual-containers .site-container, ' . $base_selector . '.site-container-detach .site-container';
	}

	/**
     * Add container css
     *
     * @return string css selector
     */
	function add_container_css( $css ) {
		$site_container_width               = intval( analytica_get_option( 'site-content-width' ) );
		$site_sidebar_width                 = intval( analytica_get_option( 'site-sidebar-width' ) );

		if ( $site_container_width > 0 ) {
			$css .= '.qazana-section.qazana-section-boxed > .qazana-container { max-width: ' . esc_attr( $site_container_width + $site_sidebar_width  ) . 'px; }';
		}

		return $css;
	}

    /**
     * Add hero title selector to qazana
     *
     * @return string css selector
     */
    function page_title_selector(){
        return ' .site-hero h1.heading';
    }

    /**
     * Detect qazana page
     *
     * @since 1.0.0
     *
     * @return boolean
     */
    function reset_default_font( $locations ) {

        $font_base = analytica_get_option( 'font-base' );

        $fonts = array(
            '1' => array(
                'font_family' => '',
                'font_weight' => '',
            ),
            '2' => array(
                'font_family' => '',
                'font_weight' => '',
            ),
            '3' => array(
                'font_family' => '',
                'font_weight' => '',
            ),
            '4' => array(
                'font_family' => '',
                'font_weight' => '',
            ),
        );

        return $fonts;
    }

    /**
     * Detect qazana page
     *
     * @since 1.0.0
     *
     * @return boolean
     */
    function default_colors( $locations ) {

        $font_base = analytica_get_option( 'font-base' );
        $font_secondary = analytica_get_option( 'font-secondary-base' );
        $accent_color = analytica_get_option( 'site-accent-color' );

        $font_secondary_color = ! empty( $font_secondary['color'] ) ? $font_secondary['color'] : '';
        $font_base_color = ! empty( $font_base['color'] ) ? $font_base['color'] : '';

        $colors = [
            '1' => $font_secondary_color, // Title colors
            '2' => $font_base_color, // Meta color
            '3' => $font_base_color,
            '4' => $accent_color, // Accents color, buttons etc
        ];

        return $colors;
    }

    /**
     * Detect qazana page
     *
     * @since 1.0.0
     *
     * @return boolean
     */
    function system_color_schemes( $locations ) {

        $font_base = analytica_get_option( 'font-base' );
        $font_secondary = analytica_get_option( 'font-secondary-base' );
        $accent_color = analytica_get_option( 'site-accent-color' );

        $font_secondary_color = ! empty( $font_secondary['color'] ) ? $font_secondary['color'] : '';
        $font_base_color = ! empty( $font_base['color'] ) ? $font_base['color'] : '';

        $schemes = [
            'analytica' => [
                'title' => 'Energia',
                'items' => [
                    '1' => $font_secondary_color, // Title colors
                    '2' => $font_base_color, // Meta color
                    '3' => $font_base_color,
                    '4' => $accent_color, // Accents color, buttons etc
                ],
            ],
        ];

        return $schemes;
    }


    /**
     * Detect qazana page
     *
     * @since 1.0.0
     *
     * @return boolean
     */
    function default_color_picker_schemes( $schemes ) {

        $font_base = analytica_get_option( 'font-base' );
        $font_secondary = analytica_get_option( 'font-secondary-base' );
        $accent_color = analytica_get_option( 'site-accent-color' );

        $font_secondary_color = ! empty( $font_secondary['color'] ) ? $font_secondary['color'] : '';
        $font_base_color = ! empty( $font_base['color'] ) ? $font_base['color'] : '';

        $schemes = [
            'analytica' => [
                'title' => wp_get_theme()->get( 'Name' ),
                'items' => analytica_default_color_palettes(),
            ],
        ];

        return $schemes;
    }

    /**
     * Reset the qazana preset schemes to make layouts more theme friendly
     *
     * @since 1.0.0
     *
     * @return boolean
     */
    function reset_schemes( $locations ) {

        foreach ( qazana()->schemes_manager->get_registered_schemes() as $scheme ) {

            if ( $scheme::get_type() === 'typography' ) {

                update_option( 'qazana_scheme_typography', array() );

            } elseif ( $scheme::get_type() === 'color' ) {

                $font_base = analytica_get_option( 'font-base' );
                $font_secondary = analytica_get_option( 'font-secondary-base' );
                $accent_color = analytica_get_option( 'site-accent-color' );

                $font_secondary_color = ! empty( $font_secondary['color'] ) ? $font_secondary['color'] : '';
                $font_base_color = ! empty( $font_base['color'] ) ? $font_base['color'] : '';

                update_option( 'qazana_scheme_color', [
                    '1' => $font_secondary_color, // Title colors
                    '2' => $font_base_color, // Meta color
                    '3' => $font_base_color,
                    '4' => $accent_color, // Accents color, buttons etc
                ] );
            }
		}

        update_option( \Qazana\Scheme_Base::LAST_UPDATED_META, time() );
    }

    /**
     * Detect if layout qazana is active
     *
     * @since 1.0.0
     *
     * @return boolean
     */
    function is_builder_activated( $retval = false ) {
        if ( analytica_detect_plugin( array( 'classes' => array( 'Qazana\Plugin' ) ) ) ) {
            return true;
        }
        return $retval;
    }

    /**
     * Detect qazana page
     *
     * @since 1.0.0
     *
     * @return boolean
     */
    function is_builder_page( $retval, $post_id ) {
        if ( get_post_meta( $post_id, '_qazana_edit_mode', true ) || \Qazana\Template_Library\Source_Local::CPT === get_post_type( $post_id ) || qazana()->is_edit_mode( $post_id ) ) {
            $retval = true;
        }

        return $retval;
	}

	/**
	 * Site Footer
	 *
     * @since 1.0.0
     *
     * @return boolean
     */
	public function site_footer_support( $option ) {
		return 'analytica_footer';
	}
}
