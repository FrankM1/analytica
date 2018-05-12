<?php
namespace Analytica;

/**
 * Custom Styling output for Analytica Theme.
 *
 * @package     Analytica
 * @subpackage  Class
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       Analytica 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dynamic CSS
 */
class Dynamic_CSS {

    public function __construct() {
        add_filter( 'analytica_dynamic_css_cached', array( $this, 'return_output' ));
        add_filter( 'analytica_dynamic_css_cached', array( $this, 'return_meta_output' ));
        add_filter( 'analytica_dynamic_css_cached', array( $this, 'header_breakpoint_style' ));
    }

    /**
     * Function to Add Header Breakpoint Style
     *
     * @since 1.0.0
     */
    function header_breakpoint_style( $original_css ) {

        // Header Break Point.
        $header_break_point = analytica_header_break_point();

        ob_start();
        ?>
        .main-header-bar-wrap {
            content: '<?php echo esc_html( $header_break_point ); ?>';
        }

        @media all and ( min-width: <?php echo esc_html( $header_break_point ); ?>px ) {
            .main-header-bar-wrap {
                content: '';
            }
        }
        <?php

        $analytica_header_width = analytica_get_option( 'header-main-layout-width' );

        /* Width for Header */
        if ( 'content' != $analytica_header_width ) {
            $genral_global_responsive = array(
                '#masthead .ast-container' => array(
                    'max-width'     => '100%',
                    'padding-left'  => '35px',
                    'padding-right' => '35px',
                ),
            );

            /* Parse CSS from array()*/
            echo $this->parse_css( $genral_global_responsive, $header_break_point );
        }

        $css = ob_get_clean();

        // trim white space for faster page loading.
        $css = $this->trim_css( $css );

        return $original_css . $css;
    }

	/**
	 * Parse CSS
	 *
	 * @param  array  $css_output Array of CSS.
	 * @param  string $min_media  Min Media breakpoint.
	 * @param  string $max_media  Max Media breakpoint.
	 * @return string             Generated CSS.
	 */
	public function parse_css( $css_output = array(), $min_media = '', $max_media = '' ) {

		$parse_css = '';
		if ( is_array( $css_output ) && count( $css_output ) > 0 ) {

			foreach ( $css_output as $selector => $properties ) {

				if ( ! count( $properties ) ) {
					continue; }

				$temp_parse_css   = $selector . '{';
				$properties_added = 0;

				foreach ( $properties as $property => $value ) {

					if ( '' === $value ) {
						continue; }

					$properties_added++;
					$temp_parse_css .= $property . ':' . $value . ';';
				}

				$temp_parse_css .= '}';

				if ( $properties_added > 0 ) {
					$parse_css .= $temp_parse_css;
				}
			}

			if ( '' != $parse_css && ( '' !== $min_media || '' !== $max_media ) ) {

				$media_css       = '@media ';
				$min_media_css   = '';
				$max_media_css   = '';
				$media_separator = '';

				if ( '' !== $min_media ) {
					$min_media_css = '(min-width:' . $min_media . 'px)';
				}
				if ( '' !== $max_media ) {
					$max_media_css = '(max-width:' . $max_media . 'px)';
				}
				if ( '' !== $min_media && '' !== $max_media ) {
					$media_separator = ' and ';
				}

				$media_css .= $min_media_css . $media_separator . $max_media_css . '{' . $parse_css . '}';

				return $media_css;
			}
		}

		return $parse_css;
	}

    /**
     * Return CSS Output
     *
     * @return string Generated CSS.
     */
    public function return_output( $css ) {

        $css = '';

        /**
         *
         * Contents
         * - Variable Declaration
         * - Global CSS
         * - Typography
         * - Page Layout
         *   - Sidebar Positions CSS
         *      - Full Width Layout CSS
         *   - Fluid Width Layout CSS
         *   - Box Layout CSS
         *   - Padded Layout CSS
         * - Blog
         *   - Single Blog
         * - Typography of Headings
         * - Header
         * - Footer
         *   - Main Footer CSS
         *     - Small Footer CSS
         * - 404 Page
         * - Secondary
         * - Global CSS
         */

        /**
         * - Variable Declaration
         */
        $site_content_width = analytica_get_option( 'site-content-width', 1200 );
        $header_logo_width  = analytica_get_option( 'ast-header-responsive-logo-width' );

        // Site Background Color.
        $box_bg_obj = analytica_get_option( 'site-layout-outside-bg-obj' );

        // Color Options.
        $text_color       = analytica_get_option( 'text-color' );
        $theme_color      = analytica_get_option( 'theme-color' );
        $link_color       = analytica_get_option( 'link-color', $theme_color );
        $link_hover_color = analytica_get_option( 'link-h-color' );

        // Typography.
        $body_font_size                  = analytica_get_option( 'font-size-body' );
        $body_line_height                = analytica_get_option( 'body-line-height' );
        $para_margin_bottom              = analytica_get_option( 'para-margin-bottom' );
        $body_text_transform             = analytica_get_option( 'body-text-transform' );
        $headings_font_family            = analytica_get_option( 'headings-font-family' );
        $headings_font_weight            = analytica_get_option( 'headings-font-weight' );
        $headings_text_transform         = analytica_get_option( 'headings-text-transform' );
        $site_title_font_size            = analytica_get_option( 'font-size-site-title' );
        $site_tagline_font_size          = analytica_get_option( 'font-size-site-tagline' );
        $single_post_title_font_size     = analytica_get_option( 'font-size-entry-title' );
        $archive_summary_title_font_size = analytica_get_option( 'font-size-archive-summary-title' );
        $archive_post_title_font_size    = analytica_get_option( 'font-size-page-title' );
        $heading_h1_font_size            = analytica_get_option( 'font-size-h1' );
        $heading_h2_font_size            = analytica_get_option( 'font-size-h2' );
        $heading_h3_font_size            = analytica_get_option( 'font-size-h3' );
        $heading_h4_font_size            = analytica_get_option( 'font-size-h4' );
        $heading_h5_font_size            = analytica_get_option( 'font-size-h5' );
        $heading_h6_font_size            = analytica_get_option( 'font-size-h6' );

        // Button Styling.
        $btn_border_radius      = analytica_get_option( 'button-radius' );
        $btn_vertical_padding   = analytica_get_option( 'button-v-padding' );
        $btn_horizontal_padding = analytica_get_option( 'button-h-padding' );
        $highlight_link_color   = analytica_get_foreground_color( $link_color );
        $highlight_theme_color  = analytica_get_foreground_color( $theme_color );

        // Footer Bar Colors.
        $footer_bg_obj       = analytica_get_option( 'footer-bg-obj' );
        $footer_color        = analytica_get_option( 'footer-color' );
        $footer_link_color   = analytica_get_option( 'footer-link-color' );
        $footer_link_h_color = analytica_get_option( 'footer-link-h-color' );

        // Color.
        $footer_adv_bg_obj             = analytica_get_option( 'footer-adv-bg-obj' );
        $footer_adv_text_color         = analytica_get_option( 'footer-adv-text-color' );
        $footer_adv_widget_title_color = analytica_get_option( 'footer-adv-wgt-title-color' );
        $footer_adv_link_color         = analytica_get_option( 'footer-adv-link-color' );
        $footer_adv_link_h_color       = analytica_get_option( 'footer-adv-link-h-color' );

        /**
         * Apply text color depends on link color
         */
        $btn_text_color = analytica_get_option( 'button-color' );
        if ( empty( $btn_text_color ) ) {
            $btn_text_color = analytica_get_foreground_color( $theme_color );
        }

        /**
         * Apply text hover color depends on link hover color
         */
        $btn_text_hover_color = analytica_get_option( 'button-h-color' );
        if ( empty( $btn_text_hover_color ) ) {
            $btn_text_hover_color = analytica_get_foreground_color( $link_hover_color );
        }
        $btn_bg_color       = analytica_get_option( 'button-bg-color', $theme_color );
        $btn_bg_hover_color = analytica_get_option( 'button-bg-h-color', $link_hover_color );

        // Spacing of Big Footer.
        $small_footer_divider_color = analytica_get_option( 'footer-sml-divider-color' );
        $small_footer_divider       = analytica_get_option( 'footer-sml-divider' );

        /**
         * Small Footer Styling
         */
        $small_footer_layout = analytica_get_option( 'footer-sml-layout', 'footer-sml-layout-1' );
        $analytica_footer_width  = analytica_get_option( 'footer-layout-width' );

        // Blog Post Title Typography Options.
        $single_post_max       = analytica_get_option( 'blog-single-width' );
        $single_post_max_width = analytica_get_option( 'blog-single-max-width' );
        $blog_width            = analytica_get_option( 'blog-width' );
        $blog_max_width        = analytica_get_option( 'blog-max-width' );

        $css_output = array();
        // Body Font Family.
        $body_font_family = analytica_body_font_family();
        $body_font_weight = analytica_get_option( 'body-font-weight' );

        if ( is_array( $body_font_size ) ) {
            $body_font_size_desktop = ( isset( $body_font_size['desktop'] ) && '' != $body_font_size['desktop'] ) ? $body_font_size['desktop'] : 15;
        } else {
            $body_font_size_desktop = ( '' != $body_font_size ) ? $body_font_size : 15;
        }

        $css_output = array(

            // HTML.
            'html'                                    => array(
                'font-size' => analytica_get_font_css_value( (int) $body_font_size_desktop * 6.25, '%' ),
            ),
            'a, .page-title'                          => array(
                'color' => esc_attr( $link_color ),
            ),
            'a:hover, a:focus'                        => array(
                'color' => esc_attr( $link_hover_color ),
            ),
            'body, button, input, select, textarea'   => array(
                'font-family'    => analytica_get_font_family( $body_font_family ),
                'font-weight'    => esc_attr( $body_font_weight ),
                'font-size'      => analytica_responsive_font( $body_font_size, 'desktop' ),
                'line-height'    => esc_attr( $body_line_height ),
                'text-transform' => esc_attr( $body_text_transform ),
            ),
            'blockquote'                              => array(
                'border-color' => analytica_hex_to_rgba( $link_color, 0.05 ),
            ),
            'p, .entry-content p'                     => array(
                'margin-bottom' => analytica_get_css_value( $para_margin_bottom, 'em' ),
            ),
            'h1, .entry-content h1, .entry-content h1 a, h2, .entry-content h2, .entry-content h2 a, h3, .entry-content h3, .entry-content h3 a, h4, .entry-content h4, .entry-content h4 a, h5, .entry-content h5, .entry-content h5 a, h6, .entry-content h6, .entry-content h6 a, .site-title, .site-title a' => array(
                'font-family'    => analytica_get_css_value( $headings_font_family, 'font' ),
                'font-weight'    => analytica_get_css_value( $headings_font_weight, 'font' ),
                'text-transform' => esc_attr( $headings_text_transform ),
            ),
            '.site-title'                             => array(
                'font-size' => analytica_responsive_font( $site_title_font_size, 'desktop' ),
            ),
            '#masthead .site-logo-img .custom-logo-link img' => array(
                'max-width' => analytica_get_css_value( $header_logo_width['desktop'], 'px' ),
            ),
            '.analytica-logo-svg'                         => array(
                'width' => analytica_get_css_value( $header_logo_width['desktop'], 'px' ),
            ),
            '.ast-archive-description .ast-archive-title' => array(
                'font-size' => analytica_responsive_font( $archive_summary_title_font_size, 'desktop' ),
            ),
            '.site-header .site-description'          => array(
                'font-size' => analytica_responsive_font( $site_tagline_font_size, 'desktop' ),
            ),
            '.entry-title'                            => array(
                'font-size' => analytica_responsive_font( $archive_post_title_font_size, 'desktop' ),
            ),
            '.comment-reply-title'                    => array(
                'font-size' => analytica_get_font_css_value( (int) $body_font_size_desktop * 1.66666 ),
            ),
            '.ast-comment-list #cancel-comment-reply-link' => array(
                'font-size' => analytica_responsive_font( $body_font_size, 'desktop' ),
            ),
            'h1, .entry-content h1, .entry-content h1 a' => array(
                'font-size' => analytica_responsive_font( $heading_h1_font_size, 'desktop' ),
            ),
            'h2, .entry-content h2, .entry-content h2 a' => array(
                'font-size' => analytica_responsive_font( $heading_h2_font_size, 'desktop' ),
            ),
            'h3, .entry-content h3, .entry-content h3 a' => array(
                'font-size' => analytica_responsive_font( $heading_h3_font_size, 'desktop' ),
            ),
            'h4, .entry-content h4, .entry-content h4 a' => array(
                'font-size' => analytica_responsive_font( $heading_h4_font_size, 'desktop' ),
            ),
            'h5, .entry-content h5, .entry-content h5 a' => array(
                'font-size' => analytica_responsive_font( $heading_h5_font_size, 'desktop' ),
            ),
            'h6, .entry-content h6, .entry-content h6 a' => array(
                'font-size' => analytica_responsive_font( $heading_h6_font_size, 'desktop' ),
            ),
            '.ast-single-post .entry-title, .page-title' => array(
                'font-size' => analytica_responsive_font( $single_post_title_font_size, 'desktop' ),
            ),
            '#secondary, #secondary button, #secondary input, #secondary select, #secondary textarea' => array(
                'font-size' => analytica_responsive_font( $body_font_size, 'desktop' ),
            ),

            // Global CSS.
            '::selection'                             => array(
                'background-color' => esc_attr( $theme_color ),
                'color'            => esc_attr( $highlight_theme_color ),
            ),
            'body, h1, .entry-title a, .entry-content h1, .entry-content h1 a, h2, .entry-content h2, .entry-content h2 a, h3, .entry-content h3, .entry-content h3 a, h4, .entry-content h4, .entry-content h4 a, h5, .entry-content h5, .entry-content h5 a, h6, .entry-content h6, .entry-content h6 a' => array(
                'color' => esc_attr( $text_color ),
            ),

            // Typography.
            '.tagcloud a:hover, .tagcloud a:focus, .tagcloud a.current-item' => array(
                'color'            => analytica_get_foreground_color( $link_color ),
                'border-color'     => esc_attr( $link_color ),
                'background-color' => esc_attr( $link_color ),
            ),

            // Header - Main Header CSS.
            '.main-header-menu a, .ast-header-custom-item a' => array(
                'color' => esc_attr( $text_color ),
            ),

            // Main - Menu Items.
            '.main-header-menu li:hover > a, .main-header-menu li:hover > .ast-menu-toggle, .main-header-menu .ast-masthead-custom-menu-items a:hover, .main-header-menu li.focus > a, .main-header-menu li.focus > .ast-menu-toggle, .main-header-menu .current-menu-item > a, .main-header-menu .current-menu-ancestor > a, .main-header-menu .current_page_item > a, .main-header-menu .current-menu-item > .ast-menu-toggle, .main-header-menu .current-menu-ancestor > .ast-menu-toggle, .main-header-menu .current_page_item > .ast-menu-toggle' => array(
                'color' => esc_attr( $link_color ),
            ),

            // Input tags.
            'input:focus, input[type="text"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="password"]:focus, input[type="reset"]:focus, input[type="search"]:focus, textarea:focus' => array(
                'border-color' => esc_attr( $link_color ),
            ),
            'input[type="radio"]:checked, input[type=reset], input[type="checkbox"]:checked, input[type="checkbox"]:hover:checked, input[type="checkbox"]:focus:checked, input[type=range]::-webkit-slider-thumb' => array(
                'border-color'     => esc_attr( $link_color ),
                'background-color' => esc_attr( $link_color ),
                'box-shadow'       => 'none',
            ),

            // Small Footer.
            '.site-footer a:hover + .post-count, .site-footer a:focus + .post-count' => array(
                'background'   => esc_attr( $link_color ),
                'border-color' => esc_attr( $link_color ),
            ),

            '.ast-small-footer'                       => array(
                'color' => esc_attr( $footer_color ),
            ),
            '.ast-small-footer > .ast-footer-overlay' => analytica_get_background_obj( $footer_bg_obj ),

            '.ast-small-footer a'                     => array(
                'color' => esc_attr( $footer_link_color ),
            ),
            '.ast-small-footer a:hover'               => array(
                'color' => esc_attr( $footer_link_h_color ),
            ),

            // Advanced Fotter colors/fonts.
            '.footer-adv .widget-title,.footer-adv .widget-title a' => array(
                'color' => esc_attr( $footer_adv_widget_title_color ),
            ),

            '.footer-adv'                             => array(
                'color' => esc_attr( $footer_adv_text_color ),
            ),

            '.footer-adv a'                           => array(
                'color' => esc_attr( $footer_adv_link_color ),
            ),

            '.footer-adv .tagcloud a:hover, .footer-adv .tagcloud a.current-item' => array(
                'border-color'     => esc_attr( $footer_adv_link_color ),
                'background-color' => esc_attr( $footer_adv_link_color ),
            ),

            '.footer-adv a:hover, .footer-adv .no-widget-text a:hover, .footer-adv a:focus, .footer-adv .no-widget-text a:focus' => array(
                'color' => esc_attr( $footer_adv_link_h_color ),
            ),

            '.footer-adv .calendar_wrap #today, .footer-adv a:hover + .post-count' => array(
                'background-color' => esc_attr( $footer_adv_link_color ),
            ),

            '.footer-adv-overlay'                     => analytica_get_background_obj( $footer_adv_bg_obj ),

            // Single Post Meta.
            '.ast-comment-meta'                       => array(
                'line-height' => '1.666666667',
                'font-size'   => analytica_get_font_css_value( (int) $body_font_size_desktop * 0.8571428571 ),
            ),
            '.single .nav-links .nav-previous, .single .nav-links .nav-next, .single .ast-author-details .author-title, .ast-comment-meta' => array(
                'color' => esc_attr( $link_color ),
            ),

            // Button Typography.
            '.menu-toggle, button, .ast-button, .button, input#submit, input[type="button"], input[type="submit"], input[type="reset"]' => array(
                'border-radius'    => analytica_get_css_value( $btn_border_radius, 'px' ),
                'padding'          => analytica_get_css_value( $btn_vertical_padding, 'px' ) . ' ' . analytica_get_css_value( $btn_horizontal_padding, 'px' ),
                'color'            => esc_attr( $btn_text_color ),
                'border-color'     => esc_attr( $btn_bg_color ),
                'background-color' => esc_attr( $btn_bg_color ),
            ),
            '.menu-toggle, button, .ast-button, .button, input#submit, input[type="button"], input[type="submit"], input[type="reset"]' => array(
                'border-radius'    => analytica_get_css_value( $btn_border_radius, 'px' ),
                'padding'          => analytica_get_css_value( $btn_vertical_padding, 'px' ) . ' ' . analytica_get_css_value( $btn_horizontal_padding, 'px' ),
                'color'            => esc_attr( $btn_text_color ),
                'border-color'     => esc_attr( $btn_bg_color ),
                'background-color' => esc_attr( $btn_bg_color ),
            ),
            'button:focus, .menu-toggle:hover, button:hover, .ast-button:hover, .button:hover, input[type=reset]:hover, input[type=reset]:focus, input#submit:hover, input#submit:focus, input[type="button"]:hover, input[type="button"]:focus, input[type="submit"]:hover, input[type="submit"]:focus' => array(
                'color'            => esc_attr( $btn_text_hover_color ),
                'border-color'     => esc_attr( $btn_bg_hover_color ),
                'background-color' => esc_attr( $btn_bg_hover_color ),
            ),
            '.search-submit, .search-submit:hover, .search-submit:focus' => array(
                'color'            => analytica_get_foreground_color( $link_color ),
                'background-color' => esc_attr( $link_color ),
            ),

            // Blog Post Meta Typography.
            '.entry-meta, .entry-meta *'              => array(
                'line-height' => '1.45',
                'color'       => esc_attr( $link_color ),
            ),
            '.entry-meta a:hover, .entry-meta a:hover *, .entry-meta a:focus, .entry-meta a:focus *' => array(
                'color' => esc_attr( $link_hover_color ),
            ),

            // Blockquote Text Color.
            'blockquote, blockquote a'                => array(
                'color' => analytica_adjust_brightness( $text_color, 75, 'darken' ),
            ),

            // 404 Page.
            '.ast-404-layout-1 .ast-404-text'         => array(
                'font-size' => analytica_get_font_css_value( '200' ),
            ),

            // Widget Title.
            '.widget-title'                           => array(
                'font-size' => analytica_get_font_css_value( (int) $body_font_size_desktop * 1.428571429 ),
                'color'     => esc_attr( $text_color ),
            ),
            '#cat option, .secondary .calendar_wrap thead a, .secondary .calendar_wrap thead a:visited' => array(
                'color' => esc_attr( $link_color ),
            ),
            '.secondary .calendar_wrap #today, .ast-progress-val span' => array(
                'background' => esc_attr( $link_color ),
            ),
            '.secondary a:hover + .post-count, .secondary a:focus + .post-count' => array(
                'background'   => esc_attr( $link_color ),
                'border-color' => esc_attr( $link_color ),
            ),
            '.calendar_wrap #today > a'               => array(
                'color' => analytica_get_foreground_color( $link_color ),
            ),

            // Pagination.
            '.ast-pagination a, .page-links .page-link, .single .post-navigation a' => array(
                'color' => esc_attr( $link_color ),
            ),
            '.ast-pagination a:hover, .ast-pagination a:focus, .ast-pagination > span:hover:not(.dots), .ast-pagination > span.current, .page-links > .page-link, .page-links .page-link:hover, .post-navigation a:hover' => array(
                'color' => esc_attr( $link_hover_color ),
            ),
        );

        /* Parse CSS from array() */
        $parse_css = $this->parse_css( $css_output );

        // Foreground color.
        if ( ! empty( $footer_adv_link_color ) ) {
            $footer_adv_tagcloud = array(
                '.footer-adv .tagcloud a:hover, .footer-adv .tagcloud a.current-item' => array(
                    'color' => analytica_get_foreground_color( $footer_adv_link_color ),
                ),
                '.footer-adv .calendar_wrap #today' => array(
                    'color' => analytica_get_foreground_color( $footer_adv_link_color ),
                ),
            );
            $parse_css          .= $this->parse_css( $footer_adv_tagcloud );
        }

        /* Width for Footer */
        if ( 'content' != $analytica_footer_width ) {
            $genral_global_responsive = array(
                '.ast-small-footer .ast-container' => array(
                    'max-width'     => '100%',
                    'padding-left'  => '35px',
                    'padding-right' => '35px',
                ),
            );

            /* Parse CSS from array()*/
            $parse_css .= $this->parse_css( $genral_global_responsive, '769' );
        }

        /* Width for Comments for Full Width / Stretched Template */
        $page_builder_comment = array(
            '.ast-page-builder-template .comments-area, .single.ast-page-builder-template .entry-header, .single.ast-page-builder-template .post-navigation' => array(
                'max-width'    => analytica_get_css_value( $site_content_width + 40, 'px' ),
                'margin-left'  => 'auto',
                'margin-right' => 'auto',
            ),
        );

        /* Parse CSS from array()*/
        $parse_css .= $this->parse_css( $page_builder_comment, '545' );

        $separate_container_css = array(
            'body, .ast-separate-container' => analytica_get_background_obj( $box_bg_obj ),
        );
        
        $parse_css             .= $this->parse_css( $separate_container_css );

        $tablet_typo = array();

        if ( isset( $body_font_size['tablet'] ) && '' != $body_font_size['tablet'] ) {

                $tablet_typo = array(
                    '.comment-reply-title' => array(
                        'font-size' => analytica_get_font_css_value( (int) $body_font_size['tablet'] * 1.66666, 'px', 'tablet' ),
                    ),
                    // Single Post Meta.
                    '.ast-comment-meta'    => array(
                        'font-size' => analytica_get_font_css_value( (int) $body_font_size['tablet'] * 0.8571428571, 'px', 'tablet' ),
                    ),
                    // Widget Title.
                    '.widget-title'        => array(
                        'font-size' => analytica_get_font_css_value( (int) $body_font_size['tablet'] * 1.428571429, 'px', 'tablet' ),
                    ),
                );
        }

        /* Tablet Typography */
        $tablet_typography = array(
            'body, button, input, select, textarea' => array(
                'font-size' => analytica_responsive_font( $body_font_size, 'tablet' ),
            ),
            '.ast-comment-list #cancel-comment-reply-link' => array(
                'font-size' => analytica_responsive_font( $body_font_size, 'tablet' ),
            ),
            '#secondary, #secondary button, #secondary input, #secondary select, #secondary textarea' => array(
                'font-size' => analytica_responsive_font( $body_font_size, 'tablet' ),
            ),
            '.site-title'                           => array(
                'font-size' => analytica_responsive_font( $site_title_font_size, 'tablet' ),
            ),
            '.ast-archive-description .ast-archive-title' => array(
                'font-size' => analytica_responsive_font( $archive_summary_title_font_size, 'tablet', 40 ),
            ),
            '.site-header .site-description'        => array(
                'font-size' => analytica_responsive_font( $site_tagline_font_size, 'tablet' ),
            ),
            '.entry-title'                          => array(
                'font-size' => analytica_responsive_font( $archive_post_title_font_size, 'tablet', 30 ),
            ),
            'h1, .entry-content h1, .entry-content h1 a' => array(
                'font-size' => analytica_responsive_font( $heading_h1_font_size, 'tablet', 30 ),
            ),
            'h2, .entry-content h2, .entry-content h2 a' => array(
                'font-size' => analytica_responsive_font( $heading_h2_font_size, 'tablet', 25 ),
            ),
            'h3, .entry-content h3, .entry-content h3 a' => array(
                'font-size' => analytica_responsive_font( $heading_h3_font_size, 'tablet', 20 ),
            ),
            'h4, .entry-content h4, .entry-content h4 a' => array(
                'font-size' => analytica_responsive_font( $heading_h4_font_size, 'tablet' ),
            ),
            'h5, .entry-content h5, .entry-content h5 a' => array(
                'font-size' => analytica_responsive_font( $heading_h5_font_size, 'tablet' ),
            ),
            'h6, .entry-content h6, .entry-content h6 a' => array(
                'font-size' => analytica_responsive_font( $heading_h6_font_size, 'tablet' ),
            ),
            '.ast-single-post .entry-title, .page-title' => array(
                'font-size' => analytica_responsive_font( $single_post_title_font_size, 'tablet', 30 ),
            ),
            '#masthead .site-logo-img .custom-logo-link img' => array(
                'max-width' => analytica_get_css_value( $header_logo_width['tablet'], 'px' ),
            ),
            '.analytica-logo-svg'                       => array(
                'width' => analytica_get_css_value( $header_logo_width['tablet'], 'px' ),
            ),
        );

        /* Parse CSS from array()*/
        $parse_css .= $this->parse_css( array_merge( $tablet_typo, $tablet_typography ), '', '768' );

        $mobile_typo = array();
        if ( isset( $body_font_size['mobile'] ) && '' != $body_font_size['mobile'] ) {
            $mobile_typo = array(
                '.comment-reply-title' => array(
                    'font-size' => analytica_get_font_css_value( (int) $body_font_size['mobile'] * 1.66666, 'px', 'mobile' ),
                ),
                // Single Post Meta.
                '.ast-comment-meta'    => array(
                    'font-size' => analytica_get_font_css_value( (int) $body_font_size['mobile'] * 0.8571428571, 'px', 'mobile' ),
                ),
                // Widget Title.
                '.widget-title'        => array(
                    'font-size' => analytica_get_font_css_value( (int) $body_font_size['mobile'] * 1.428571429, 'px', 'mobile' ),
                ),
            );
        }

        /* Mobile Typography */
        $mobile_typography = array(
            'body, button, input, select, textarea' => array(
                'font-size' => analytica_responsive_font( $body_font_size, 'mobile' ),
            ),
            '.ast-comment-list #cancel-comment-reply-link' => array(
                'font-size' => analytica_responsive_font( $body_font_size, 'mobile' ),
            ),
            '#secondary, #secondary button, #secondary input, #secondary select, #secondary textarea' => array(
                'font-size' => analytica_responsive_font( $body_font_size, 'mobile' ),
            ),
            '.site-title'                           => array(
                'font-size' => analytica_responsive_font( $site_title_font_size, 'mobile' ),
            ),
            '.ast-archive-description .ast-archive-title' => array(
                'font-size' => analytica_responsive_font( $archive_summary_title_font_size, 'mobile', 40 ),
            ),
            '.site-header .site-description'        => array(
                'font-size' => analytica_responsive_font( $site_tagline_font_size, 'mobile' ),
            ),
            '.entry-title'                          => array(
                'font-size' => analytica_responsive_font( $archive_post_title_font_size, 'mobile', 30 ),
            ),
            'h1, .entry-content h1, .entry-content h1 a' => array(
                'font-size' => analytica_responsive_font( $heading_h1_font_size, 'mobile', 30 ),
            ),
            'h2, .entry-content h2, .entry-content h2 a' => array(
                'font-size' => analytica_responsive_font( $heading_h2_font_size, 'mobile', 25 ),
            ),
            'h3, .entry-content h3, .entry-content h3 a' => array(
                'font-size' => analytica_responsive_font( $heading_h3_font_size, 'mobile', 20 ),
            ),
            'h4, .entry-content h4, .entry-content h4 a' => array(
                'font-size' => analytica_responsive_font( $heading_h4_font_size, 'mobile' ),
            ),
            'h5, .entry-content h5, .entry-content h5 a' => array(
                'font-size' => analytica_responsive_font( $heading_h5_font_size, 'mobile' ),
            ),
            'h6, .entry-content h6, .entry-content h6 a' => array(
                'font-size' => analytica_responsive_font( $heading_h6_font_size, 'mobile' ),
            ),
            '.ast-single-post .entry-title, .page-title' => array(
                'font-size' => analytica_responsive_font( $single_post_title_font_size, 'mobile', 30 ),
            ),
            '.ast-header-break-point .site-branding img, .ast-header-break-point #masthead .site-logo-img .custom-logo-link img' => array(
                'max-width' => analytica_get_css_value( $header_logo_width['mobile'], 'px' ),
            ),
            '.analytica-logo-svg'                       => array(
                'width' => analytica_get_css_value( $header_logo_width['mobile'], 'px' ),
            ),
        );

        /* Parse CSS from array()*/
        $parse_css .= $this->parse_css( array_merge( $mobile_typo, $mobile_typography ), '', '544' );

        // Tablet Font Size for HTML tag.
        if ( '' == $body_font_size['tablet'] ) {
            $html_tablet_typography = array(
                'html' => array(
                    'font-size' => analytica_get_font_css_value( (int) $body_font_size_desktop * 5.7, '%' ),
                ),
            );
            $parse_css             .= $this->parse_css( $html_tablet_typography, '', '768' );
        }
        // Mobile Font Size for HTML tag.
        if ( '' == $body_font_size['mobile'] ) {
            $html_mobile_typography = array(
                'html' => array(
                    'font-size' => analytica_get_font_css_value( (int) $body_font_size_desktop * 5.7, '%' ),
                ),
            );
        } else {
            $html_mobile_typography = array(
                'html' => array(
                    'font-size' => analytica_get_font_css_value( (int) $body_font_size_desktop * 6.25, '%' ),
                ),
            );
        }

        /* Parse CSS from array()*/
        $parse_css .= $this->parse_css( $html_mobile_typography, '', '544' );

        /* Site width Responsive */
        $site_width = array(
            '.ast-container' => array(
                'max-width' => analytica_get_css_value( $site_content_width + 40, 'px' ),
            ),
        );

        /* Parse CSS from array()*/
        $parse_css .= $this->parse_css( $site_width, '769' );

        /**
         * Analytica Fonts
         */
        if ( apply_filters( 'analytica_enable_default_fonts', true ) ) {
            $analytica_fonts          = '@font-face {';
                $analytica_fonts     .= 'font-family: "Analytica";';
                $analytica_fonts     .= 'src: url( ' . analytica()->theme_url . '/assets/fonts/analytica.woff) format("woff"),';
                    $analytica_fonts .= 'url( ' . analytica()->theme_url . '/assets/fonts/analytica.ttf) format("truetype"),';
                    $analytica_fonts .= 'url( ' . analytica()->theme_url . '/assets/fonts/analytica.svg#analytica) format("svg");';
                $analytica_fonts     .= 'font-weight: normal;';
                $analytica_fonts     .= 'font-style: normal;';
            $analytica_fonts         .= '}';
            $parse_css           .= $analytica_fonts;
        }

        /* Blog */
        if ( 'custom' === $blog_width ) :
            $blog_css          = '@media (min-width:769px) {';
                $blog_css     .= '.blog .site-content > .ast-container, .archive .site-content > .ast-container, .search .site-content > .ast-container{';
                    $blog_css .= 'max-width:' . esc_attr( $blog_max_width ) . 'px;';
                $blog_css     .= '}';
            $blog_css         .= '}';
            $parse_css        .= $blog_css;
        endif;

        /* Single Blog */
        if ( 'custom' === $single_post_max ) :
                $single_blog_css  = '@media (min-width:769px) {';
                $single_blog_css .= '.single-post .site-content > .ast-container{';
                $single_blog_css .= 'max-width:' . esc_attr( $single_post_max_width ) . 'px;';
                $single_blog_css .= '}';
                $single_blog_css .= '}';
                $parse_css       .= $single_blog_css;
        endif;

        /* Small Footer CSS */
        if ( 'disabled' != $small_footer_layout ) :
            $sml_footer_css      = '.ast-small-footer {';
                $sml_footer_css .= 'border-top-style:solid;';
                $sml_footer_css .= 'border-top-width:' . esc_attr( $small_footer_divider ) . 'px;';
                $sml_footer_css .= 'border-top-color:' . esc_attr( $small_footer_divider_color );
            $sml_footer_css     .= '}';
            if ( 'footer-sml-layout-2' != $small_footer_layout ) {
                $sml_footer_css     .= '.ast-small-footer-wrap{';
                    $sml_footer_css .= 'text-align: center;';
                $sml_footer_css     .= '}';
            }
            $parse_css .= $sml_footer_css;
        endif;

        /* 404 Page */
        $parse_css .= $this->parse_css(
            array(
                '.ast-404-layout-1 .ast-404-text' => array(
                    'font-size' => analytica_get_font_css_value( 100 ),
                ),
            ), '', '920'
        );

        $css = $parse_css;
        $custom_css  = analytica_get_option( 'custom-css' );

        if ( '' != $custom_css ) {
            $css .= $custom_css;
        }

        // trim white space for faster page loading.
        $css = $this->trim_css( $css );

        return $css . $css;
    }

    /**
     * Return post meta CSS
     *
     * @param  boolean $return_css Return the CSS.
     * @return mixed              Return on print the CSS.
     */
    public function return_meta_output( $css ) {

        /**
         * - Page Layout
         *
         *   - Sidebar Positions CSS
         */
        $secondary_width = analytica_get_option( 'site-sidebar-width' );
        $primary_width   = absint( 100 - $secondary_width );
        $meta_style      = '';

        // Header Separator.
        $header_separator       = analytica_get_option( 'header-main-sep' );
        $header_separator_color = analytica_get_option( 'header-main-sep-color' );

        $meta_style .= '.ast-header-break-point .site-header {';
        $meta_style .= 'border-bottom-width:' . analytica_get_css_value( $header_separator, 'px' ) . ';';
        $meta_style .= 'border-bottom-color:' . esc_attr( $header_separator_color ) . ';';
        $meta_style .= '}';
        $meta_style .= '@media (min-width: 769px) {';
        $meta_style .= '.main-header-bar {';
        $meta_style .= 'border-bottom-width:' . analytica_get_css_value( $header_separator, 'px' ) . ';';
        $meta_style .= 'border-bottom-color:' . esc_attr( $header_separator_color ) . ';';
        $meta_style .= '}';
        $meta_style .= '}';

        if ( 'no-sidebar' !== analytica_page_layout() ) :
            $meta_style .= '@media (min-width: 769px) {';
            $meta_style .= '#primary {';
            $meta_style .= 'width:' . esc_attr( $primary_width ) . '%;';
            $meta_style .= '}';
            $meta_style .= '#secondary {';
            $meta_style .= 'width:' . esc_attr( $secondary_width ) . '%;';
            $meta_style .= '}';
            $meta_style .= '}';
        endif;

        return $css . $meta_style;
    }

    /**
     * Trim CSS
     *
     * @since 1.0.0
     * @param string $css CSS content to trim.
     * @return string
     */
    public function trim_css( $css = '' ) {

        // Trim white space for faster page loading.
        if ( ! empty( $css ) ) {
            $css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
            $css = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $css ); // Remove whitespace
            $css = str_replace( ', ', ',', $css );
            $css = str_replace(': ', ':', $css);  // Remove space after colons
            $css = preg_replace( "/\s*([\{\}>~:;,])\s*/", "$1", $css ); // Remove spaces that might still be left where we know they aren't needed
        }

        return $css;
    }
}