<?php
namespace Analytica;

/**
 * Custom Styling output for Analytica Theme.
 *
 * @package     Analytica
 * @subpackage  Class
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        https://qazana.net/
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
        // add_filter( 'analytica_dynamic_css_cached', array( $this, 'return_output' ));
        add_filter( 'analytica_dynamic_css_cached', array( $this, 'add_container_css' ));
    }

    /**
     * Css customization helper for more complex styling that can't be generated using kirki.
     *
     * @since 1.0.0
     */
    function add_container_css( $css ) {
        $site_layout                        = analytica_get_option( 'site-layout' );
        $accent_color                       = analytica_get_option( 'accent-color' );
        $site_header_color                  = analytica_get_option( 'header-background-color' );
        $footer_border                      = analytica_get_option( 'site-footer-border' );
        $footer_colophon_border             = analytica_get_option( 'footer-colophon-border' );
        $offset                             = intval( analytica_get_option( 'site-layout-offset' ) );
        $single_post_site_container_width   = intval( analytica_get_option( 'single-post-site-container-width' ) );
        $single_post_site_sidebar_width     = intval( analytica_get_option( 'single-post-site-sidebar-width' ) );
        $site_container_width               = intval( analytica_get_option( 'site-content-width' ) );
        $site_sidebar_width                 = intval( analytica_get_option( 'site-sidebar-width' ) );

        analytica_write_log( $site_sidebar_width );

        if ( 'site-boxed' === $site_layout ) {
            $css .= '@media (min-width: 1200px) {';
                if ( $site_container_width > 0 ) {
                    $css .= '.site-boxed .site-container, 
                        .site-boxed .site-footer, 
                        .site-boxed .container, 
                        .site-boxed .site-content,
                        .site-boxed .site-colophon.has-container, 
                        .site-boxed .site-header.has-container { max-width: ' . esc_attr( $site_container_width ) . 'px; margin: 0 auto; }';
                }

                if ( $single_post_site_container_width > 0 ) {
                    $css .= '.site-boxed.single-post.full-width-content .site-inner .analytica-container, .single-post.full-width-content .site-inner .analytica-container, .single-attachment .site-inner .analytica-container { width: ' . esc_attr( $single_post_site_container_width ) . 'px; }';
                }

                if ( $offset && $offset > 0) {
                    $css .= '.site-boxed .site-container { margin-top: ' . esc_attr( $offset ) . 'px; margin-bottom: ' . esc_attr( $offset ) . 'px; }';
                }

            $css .= '}';
        }

        $css .= '@media (min-width: 1200px) {';
            if ( $site_container_width > 0 ) {
                $css .= '.analytica-container { width:' . esc_attr( $site_container_width ) . 'px;}';
            }

            if ( $offset && $offset > 0) {
                $css .= '.site-header .site-container { background-color: ' . esc_attr( $site_header_color ) . '; }';
            }

        $css .= '}';

        // Section
        if ( $site_container_width > 0 ) {
            $css .= '.qazana-section.qazana-section-boxed  > .qazana-container, 
            .page-content .qazana-section.qazana-section-boxed > .qazana-container, 
            .content-sidebar-wrap, .content-sidebar-wrap .row, 
            .full-width-content .single-post-classic .content-sidebar-wrap, 
            .post-title-featured, 
            .site-fullwidth .single-post-overlay .content-sidebar-wrap>.content>.entry-post-wrapper { max-width: ' . esc_attr( $site_container_width ) . 'px; }';
        }

        $css .= '@media (min-width: 992px) {';
            
            $css .= '.content-sidebar-sidebar .content-sidebar-wrap .content,
             .content-sidebar .content-sidebar-wrap .content,
              .sidebar-content-sidebar .content-sidebar-wrap .content, 
              .sidebar-content .content-sidebar-wrap .content, 
              .sidebar-sidebar-content .content-sidebar-wrap .content,
            .content-sidebar-sidebar .content-sidebar-wrap .next_post_infinite, 
            .content-sidebar .content-sidebar-wrap .next_post_infinite, 
            .sidebar-content-sidebar .content-sidebar-wrap .next_post_infinite, 
            .sidebar-content .content-sidebar-wrap .next_post_infinite, 
            .sidebar-sidebar-content .content-sidebar-wrap .next_post_infinite { width: calc(100% - ' . $site_sidebar_width . 'px) }';
            
            $css .= '.sidebar-primary {
                width: ' . $site_sidebar_width . 'px;
            }';
            
            $css .= '.single-post .sidebar-primary {
                width: ' . $single_post_site_sidebar_width . 'px;
            }';

        $css .= '}';
  
        $css .= '@media (min-width: 768px) {';
            if ( ! empty( $footer_colophon_border ) ) {
                $css .= '.site-colophon {';
                    $css .= 'border-top-width: ' . esc_attr( $footer_colophon_border['top'] ) . ';';
                    $css .= 'border-left-width: ' . esc_attr( $footer_colophon_border['left'] ) . ';';
                    $css .= 'border-bottom-width: ' . esc_attr( $footer_colophon_border['bottom'] ) . ';';
                    $css .= 'border-right-width: ' . esc_attr( $footer_colophon_border['right'] ) . ';';
                $css .= '}';
            }

            if ( ! empty( $footer_border ) ) {
                $css .= '.site-footer {';
                    $css .= 'border-top-width: ' . esc_attr( $footer_border['top'] ) . ';';
                    $css .= 'border-left-width: ' . esc_attr( $footer_border['left'] ) . ';';
                    $css .= 'border-bottom-width: ' . esc_attr( $footer_border['bottom'] ) . ';';
                    $css .= 'border-right-width: ' . esc_attr( $footer_border['right'] ) . ';';
                $css .= '}';
            }

            $css .= '#quickpop #close-quickpop:hover { color: ' . $accent_color . '}';

            $css .= '.site-widgets-style-4 .section-title .widget-title:after, .site-widgets-style-8 .section-title .widget-title span:after { background-color: ' . $accent_color . '; }';
            $css .= '.site-widgets-style-5 .section-title .widget-title, .site-widgets-style-6 .section-title .widget-title { border-left-color: ' . $accent_color . '; }';
            $css .= '.archive-pagination .active a { border-color: ' . $accent_color . '; color: ' . $accent_color . '; }';
        
        $css .= '}';

        return $css;
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
        $header_logo_width  = analytica_get_option( 'analytica-header-responsive-logo-width' );

     
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
 
        // Button Styling.
        $btn_border_radius      = analytica_get_option( 'button-radius' );
        $btn_vertical_padding   = analytica_get_option( 'button-v-padding' );
        $btn_horizontal_padding = analytica_get_option( 'button-h-padding' );
        $highlight_link_color   = analytica_get_foreground_color( $link_color );
        $highlight_theme_color  = analytica_get_foreground_color( $theme_color );

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

            'a, .page-title'                          => array(
                'color' => esc_attr( $link_color ),
            ),
            'a:hover, a:focus'                        => array(
                'color' => esc_attr( $link_hover_color ),
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
            '.analytica-logo-svg'                         => array(
                'width' => analytica_get_css_value( $header_logo_width['desktop'], 'px' ),
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
            '.analytica-comment-list #cancel-comment-reply-link' => array(
                'font-size' => analytica_responsive_font( $body_font_size, 'desktop' ),
            ),
            '.analytica-single-post .entry-title, .page-title' => array(
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

            // Input tags.
            'input:focus, input[type="text"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="password"]:focus, input[type="reset"]:focus, input[type="search"]:focus, textarea:focus' => array(
                'border-color' => esc_attr( $link_color ),
            ),
            'input[type="radio"]:checked, input[type=reset], input[type="checkbox"]:checked, input[type="checkbox"]:hover:checked, input[type="checkbox"]:focus:checked, input[type=range]::-webkit-slider-thumb' => array(
                'border-color'     => esc_attr( $link_color ),
                'background-color' => esc_attr( $link_color ),
                'box-shadow'       => 'none',
            ),

            // Single Post Meta.
            '.analytica-comment-meta'                       => array(
                'line-height' => '1.666666667',
                'font-size'   => analytica_get_font_css_value( (int) $body_font_size_desktop * 0.8571428571 ),
            ),
            '.single .nav-links .nav-previous, .single .nav-links .nav-next, .single .analytica-author-details .author-title, .analytica-comment-meta' => array(
                'color' => esc_attr( $link_color ),
            ),

            // Button Typography.
            '.menu-toggle, button, .analytica-button, .button, input#submit, input[type="button"], input[type="submit"], input[type="reset"]' => array(
                'border-radius'    => analytica_get_css_value( $btn_border_radius, 'px' ),
                'padding'          => analytica_get_css_value( $btn_vertical_padding, 'px' ) . ' ' . analytica_get_css_value( $btn_horizontal_padding, 'px' ),
                'color'            => esc_attr( $btn_text_color ),
                'border-color'     => esc_attr( $btn_bg_color ),
                'background-color' => esc_attr( $btn_bg_color ),
            ),
            '.menu-toggle, button, .analytica-button, .button, input#submit, input[type="button"], input[type="submit"], input[type="reset"]' => array(
                'border-radius'    => analytica_get_css_value( $btn_border_radius, 'px' ),
                'padding'          => analytica_get_css_value( $btn_vertical_padding, 'px' ) . ' ' . analytica_get_css_value( $btn_horizontal_padding, 'px' ),
                'color'            => esc_attr( $btn_text_color ),
                'border-color'     => esc_attr( $btn_bg_color ),
                'background-color' => esc_attr( $btn_bg_color ),
            ),
            'button:focus, .menu-toggle:hover, button:hover, .analytica-button:hover, .button:hover, input[type=reset]:hover, input[type=reset]:focus, input#submit:hover, input#submit:focus, input[type="button"]:hover, input[type="button"]:focus, input[type="submit"]:hover, input[type="submit"]:focus' => array(
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
            '.analytica-404-layout-1 .analytica-404-text'         => array(
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
            '.secondary .calendar_wrap #today, .analytica-progress-val span' => array(
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
            '.analytica-pagination a, .page-links .page-link, .single .post-navigation a' => array(
                'color' => esc_attr( $link_color ),
            ),
            '.analytica-pagination a:hover, .analytica-pagination a:focus, .analytica-pagination > span:hover:not(.dots), .analytica-pagination > span.current, .page-links > .page-link, .page-links .page-link:hover, .post-navigation a:hover' => array(
                'color' => esc_attr( $link_hover_color ),
            ),
        );

        /* Parse CSS from array() */
        $parse_css = $this->parse_css( $css_output );

        /* Width for Comments for Full Width / Stretched Template */
        $page_builder_comment = array(
            '.analytica-page-builder-template .comments-area, .single.analytica-page-builder-template .entry-header, .single.analytica-page-builder-template .post-navigation' => array(
                'max-width'    => analytica_get_css_value( $site_content_width + 40, 'px' ),
                'margin-left'  => 'auto',
                'margin-right' => 'auto',
            ),
        );

        /* Parse CSS from array()*/
        $parse_css .= $this->parse_css( $page_builder_comment, '545' );
      
        $tablet_typo = array();

        if ( isset( $body_font_size['tablet'] ) && '' != $body_font_size['tablet'] ) {

                $tablet_typo = array(
                    '.comment-reply-title' => array(
                        'font-size' => analytica_get_font_css_value( (int) $body_font_size['tablet'] * 1.66666, 'px', 'tablet' ),
                    ),
                    // Single Post Meta.
                    '.analytica-comment-meta'    => array(
                        'font-size' => analytica_get_font_css_value( (int) $body_font_size['tablet'] * 0.8571428571, 'px', 'tablet' ),
                    ),
                    // Widget Title.
                    '.widget-title'        => array(
                        'font-size' => analytica_get_font_css_value( (int) $body_font_size['tablet'] * 1.428571429, 'px', 'tablet' ),
                    ),
                );
        }

        /* Site width Responsive */
        $site_width = array(
            '.analytica-container' => array(
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
                $blog_css     .= '.blog .site-content > .analytica-container, .archive .site-content > .analytica-container, .search .site-content > .analytica-container{';
                    $blog_css .= 'max-width:' . esc_attr( $blog_max_width ) . 'px;';
                $blog_css     .= '}';
            $blog_css         .= '}';
            $parse_css        .= $blog_css;
        endif;

        /* Single Blog */
        if ( 'custom' === $single_post_max ) :
                $single_blog_css  = '@media (min-width:769px) {';
                $single_blog_css .= '.single-post .site-content > .analytica-container{';
                $single_blog_css .= 'max-width:' . esc_attr( $single_post_max_width ) . 'px;';
                $single_blog_css .= '}';
                $single_blog_css .= '}';
                $parse_css       .= $single_blog_css;
        endif;

        /* 404 Page */
        $parse_css .= $this->parse_css(
            array(
                '.analytica-404-layout-1 .analytica-404-text' => array(
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