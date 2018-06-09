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
        add_filter( 'analytica_dynamic_css_cached', array( $this, 'add_container_css' ));
        add_filter( 'analytica_dynamic_css_cached', array( $this, 'custom_background' ));
        add_filter( 'analytica_dynamic_css_cached', array( $this, 'generate_site_css' ));
    }

    /**
     * Site backgrounds
     *
     * @since 1.0.0
     */
    function custom_background( $css ) {
        // $background is the saved custom image, or the default image.
        $background = set_url_scheme( get_background_image() );
    
        // $color is the saved custom color.
        // A default has to be specified in style.css. It will not be printed here.
        $color = get_background_color();
    
        if ( $color === get_theme_support( 'custom-background', 'default-color' ) ) {
            $color = false;
        }
    
        if ( ! $background && ! $color ) {
            return $css;
        }

        $style = $color ? "background-color: #$color;" : '';
    
        if ( $background ) {
            $image = ' background-image: url("' . esc_url_raw( $background ) . '");';
    
            // Background Position.
            $position_x = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );
            $position_y = get_theme_mod( 'background_position_y', get_theme_support( 'custom-background', 'default-position-y' ) );
    
            if ( ! in_array( $position_x, array( 'left', 'center', 'right' ), true ) ) {
                $position_x = 'left';
            }
    
            if ( ! in_array( $position_y, array( 'top', 'center', 'bottom' ), true ) ) {
                $position_y = 'top';
            }
    
            $position = " background-position: $position_x $position_y;";
    
            // Background Size.
            $size = get_theme_mod( 'background_size', get_theme_support( 'custom-background', 'default-size' ) );
    
            if ( ! in_array( $size, array( 'auto', 'contain', 'cover' ), true ) ) {
                $size = 'auto';
            }
    
            $size = " background-size: $size;";
    
            // Background Repeat.
            $repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );
    
            if ( ! in_array( $repeat, array( 'repeat-x', 'repeat-y', 'repeat', 'no-repeat' ), true ) ) {
                $repeat = 'repeat';
            }
    
            $repeat = " background-repeat: $repeat;";
    
            // Background Scroll.
            $attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );
    
            if ( 'fixed' !== $attachment ) {
                $attachment = 'scroll';
            }
    
            $attachment = " background-attachment: $attachment;";
    
            $style .= $image . $position . $size . $repeat . $attachment;
        }

        $css .= 'body.custom-background {'. $style . '}';

        return $css;
    }

    function generate_site_css( $parse_css ) {
        $link_color                    = analytica_get_option( 'site-link-color' );
        $text_color                    = analytica_get_option( 'site-text-color' );
        $accent_color                  = analytica_get_option( 'site-accent-color' );
        $link_hover_color              = analytica_get_option( 'site-link-highlight-color' );
        $content_background_color      = analytica_get_option( 'site-content-background-color' );
        $body_font                     = analytica_get_option( 'font-base' );
        $body_font_size                = $body_font['font-size'];
        
        $highlight_theme_color         = analytica_get_foreground_color( $accent_color );

        if ( is_array( $body_font_size ) ) {
            $body_font_size = ! empty( $body_font_size ) ?   intval( $body_font_size ) : 15;
        } else {
            $body_font_size = ( '' != $body_font_size ) ? intval( $body_font_size ) : 15;
        }

        /**
         * Apply text color depends on link color
         */
        $btn_text_color = analytica_get_option( 'button-text-color' );
        if ( empty( $btn_text_color ) ) {
            $btn_text_color = analytica_get_foreground_color( $accent_color );
        }

        /**
         * Apply text hover color depends on link hover color
         */
        $btn_text_hover_color = analytica_get_option( 'button-h-color' );
        if ( empty( $btn_text_hover_color ) ) {
            $btn_text_hover_color = analytica_get_foreground_color( $link_hover_color );
        }
 
        $btn_bg_color       = analytica_get_option( 'button-background-color', $accent_color );
        $btn_bg_hover_color = analytica_get_option( 'button-background-h-color', $link_hover_color );
        
        // Button Styling.
        $btn_border_radius      = analytica_get_option( 'button-radius' );
        $btn_vertical_padding   = analytica_get_option( 'button-v-padding' );
        $btn_horizontal_padding = analytica_get_option( 'button-h-padding' );
        $highlight_link_color   = analytica_get_foreground_color( $link_color );
        $highlight_theme_color  = analytica_get_foreground_color( $accent_color );

        $css_output = array(

            // Global CSS.
            '::selection'                             => array(
                'background-color' => esc_attr( $accent_color ),
                'color'            => esc_attr( $highlight_theme_color ),
            ),

            'a:hover, a:focus'                        => array(
                'color' => esc_attr( $link_hover_color ),
            ),

            '.nav-horizontal .dl-menu, .nav-horizontal > .main_menu > .sub-menu, .nav-horizontal ul > li > ul.sub-menu' => array(
                'border-top-color'     => esc_attr( $accent_color ),
            ),

            '.nav-horizontal .analytica_mega:after, .nav-horizontal > .sub-menu:after' => array(
                'border-bottom-color'     => esc_attr( $accent_color ),
            ),

            'mark, ins' => array(
                'color'            => analytica_get_foreground_color( $accent_color ),
                'background-color'     => esc_attr( $accent_color ),
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
            '.nav-horizontal .analytica_mega>li.current-menu-ancestor>a, .nav-horizontal .analytica_mega>li.current-menu-ancestor>a .menu-title-outer, .nav-horizontal .analytica_mega>li.current-menu-item>a, .nav-horizontal .analytica_mega>li.current-menu-item>a .menu-title-outer, .nav-horizontal .analytica_mega>li:hover>a, .nav-horizontal .analytica_mega>li>a.open-mega-a, .nav-horizontal .analytica_mega>li>a.open-sub-a, .nav-horizontal>ul>li.current-menu-ancestor>a, .nav-horizontal>ul>li.current-menu-ancestor>a .menu-title-outer, .nav-horizontal>ul>li.current-menu-item>a, .nav-horizontal>ul>li.current-menu-item>a .menu-title-outer, .nav-horizontal>ul>li:hover>a, .nav-horizontal>ul>li>a.open-mega-a, .nav-horizontal>ul>li>a.open-sub-a, .single .nav-links .nav-previous, .single .nav-links .nav-next, .single .analytica-author-details .author-title, .analytica-comment-meta' => array(
                'color' => esc_attr( $link_color ),
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

            '.calendar_wrap #today > a'               => array(
                'color' => analytica_get_foreground_color( $link_color ),
            ),

            // Pagination.
            '.analytica-pagination a, .page-links .page-link, .single .post-navigation a' => array(
                'color' => esc_attr( $link_color ),
            ),
                
            'blockquote'                              => array(
                'border-color' => analytica_hex_to_rgba( $link_color, 0.05 ),
                'color' => analytica_adjust_brightness( $text_color, 75, 'darken' ),
            ),

            'pre' => array(
                'background-color' => analytica_adjust_brightness( $content_background_color, 75, 'reverse' ),
                'color'            => analytica_get_foreground_color( $content_background_color ),
            ),

            '.analytica-pagination a:hover, .analytica-pagination a:focus, .analytica-pagination > span:hover:not(.dots), .analytica-pagination > span.current, .page-links > .page-link, .page-links .page-link:hover, .post-navigation a:hover' => array(
                'color' => esc_attr( $link_hover_color ),
            ),
               
            '.entry-meta a:hover, .entry-meta a:hover *, .entry-meta a:focus, .entry-meta a:focus *' => array(
                'color' => esc_attr( $link_hover_color ),
            ),
        );

        /* Parse CSS from array() */
        $parse_css .= $this->parse_css( $css_output );

        $buttons_css_output = array(
            // Button Typography.
            '.menu-trigger, button, .analytica-button, .button, input#submit, input[type="button"], input[type="submit"], input[type="reset"], #comments .submit' => array(
                'border-radius'    => analytica_get_css_value( $btn_border_radius, 'px' ),
                'padding'          => analytica_get_css_value( $btn_vertical_padding, 'px' ) . ' ' . analytica_get_css_value( $btn_horizontal_padding, 'px' ),
                'color'            => esc_attr( $btn_text_color ),
                'border-color'     => esc_attr( $btn_bg_color ),
                'background-color' => esc_attr( $btn_bg_color ),
            ),
            '.menu-trigger, button, .analytica-button, .button, input#submit, input[type="button"], input[type="submit"], input[type="reset"]' => array(
                'border-radius'    => analytica_get_css_value( $btn_border_radius, 'px' ),
                'padding'          => analytica_get_css_value( $btn_vertical_padding, 'px' ) . ' ' . analytica_get_css_value( $btn_horizontal_padding, 'px' ),
                'color'            => esc_attr( $btn_text_color ),
                'border-color'     => esc_attr( $btn_bg_color ),
                'background-color' => esc_attr( $btn_bg_color ),
            ),
            'button:focus, .menu-trigger:hover, button:hover, .analytica-button:hover, .button:hover, input[type=reset]:hover, input[type=reset]:focus, input#submit:hover, input#submit:focus, input[type="button"]:hover, input[type="button"]:focus, input[type="submit"]:hover, input[type="submit"]:focus' => array(
                'color'            => esc_attr( $btn_text_hover_color ),
                'border-color'     => esc_attr( $btn_bg_hover_color ),
                'background-color' => esc_attr( $btn_bg_hover_color ),
            ),
            '.search-submit, .search-submit:hover, .search-submit:focus' => array(
                'color'            => analytica_get_foreground_color( $link_color ),
                'background-color' => esc_attr( $link_color ),
            ),
        );

        /* Parse CSS from array() */
        $parse_css .= $this->parse_css( $buttons_css_output );

        return $parse_css;
    }

    /**
     * Css customization helper for more complex styling that can't be generated using kirki.
     *
     * @since 1.0.0
     */
    function add_container_css( $css ) {
        $site_layout                        = analytica_get_option( 'site-layout' );
        $accent_color                       = analytica_get_option( 'site-accent-color' );
        $footer_border                      = analytica_get_option( 'site-footer-border' );
        $footer_colophon_border             = analytica_get_option( 'footer-colophon-border' );
        $offset                             = intval( analytica_get_option( 'site-layout-offset' ) );
        $single_post_site_container_width   = intval( analytica_get_option( 'single-post-site-container-width' ) );
        $single_post_site_sidebar_width     = intval( analytica_get_option( 'single-post-site-sidebar-width' ) );
        $site_container_width               = intval( analytica_get_option( 'site-content-width' ) );
        $site_sidebar_width                 = intval( analytica_get_option( 'site-sidebar-width' ) );
        $text_color       = analytica_get_option( 'site-text-color' );
        $link_color       = analytica_get_option( 'site-link-color' );

        $css .= 'a, .nav-horizontal ul > li > ul.sub-menu .current_page_item a { color: ' . esc_attr( $link_color ) .'}';

        if ( 'site-boxed' === $site_layout ) {

            $css .= '@media (min-width: 1200px) {';
                if ( $site_container_width > 0 ) {
                    $css .= '.site-boxed .site-container { max-width: ' . esc_attr( $site_container_width ) . 'px; margin: 0 auto; }';
                }

                if ( $single_post_site_container_width > 0 ) {
                    $css .= '.single-attachment .site-inner .analytica-container { width: ' . esc_attr( $single_post_site_container_width ) . 'px; }';
                }

                if ( $offset && $offset > 0) {
                    $css .= '.site-boxed .site-container { margin-top: ' . esc_attr( $offset ) . 'px; margin-bottom: ' . esc_attr( $offset ) . 'px; }';
                }

            $css .= '}';

        } else {

            $css .= '@media (min-width: 1200px) {';
                if ( $site_container_width > 0 ) {
                    $css .= '.site-header .analytica-container, .analytica-container, .site-inner, .site-footer-boxed.has-container { max-width:' . esc_attr( $site_container_width ) . 'px;}';
                }
            $css .= '}';

        }

        // Section
        if ( $site_container_width > 0 ) {
            $css .= '.site-inner { max-width: ' . esc_attr( $site_container_width ) . 'px; }';
        }

        $css .= '@media (min-width: 992px) {';

            if ( $site_sidebar_width > 100 ) {
                $css .= '.site-main-sidebar-sidebar .site-main,
                .site-main-sidebar .site-main,
                .sidebar-content-sidebar .site-main, 
                .sidebar-content .site-main, 
                .sidebar-sidebar-content .site-main { width: calc(100% - ' . $site_sidebar_width . 'px) }';
                
                $css .= '.site-sidebar .widget-area-inner {
                    width: ' . $site_sidebar_width . 'px;
                }';
            }

            if ( $single_post_site_sidebar_width > 100 ) {
                $css .= '.single-post .site-sidebar .widget-area-inner {
                    width: ' . $single_post_site_sidebar_width . 'px;
                }';
            }

        $css .= '}';
  
        $css .= '@media (min-width: 768px) {';
            if ( ! empty( $footer_colophon_border ) ) {
                $css .= '.site-colophon {';
                    $css .= ! empty( $footer_colophon_border['top'] ) ? 'border-top-width: ' . esc_attr( $footer_colophon_border['top'] ) . ';' : '';
                    $css .= ! empty( $footer_colophon_border['left'] ) ? 'border-left-width: ' . esc_attr( $footer_colophon_border['left'] ) . ';': '';
                    $css .= ! empty( $footer_colophon_border['bottom'] ) ? 'border-bottom-width: ' . esc_attr( $footer_colophon_border['bottom'] ) . ';': '';
                    $css .= ! empty( $footer_colophon_border['right'] ) ? 'border-right-width: ' . esc_attr( $footer_colophon_border['right'] ) . ';': '';
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
    
    public function generate_hero_css() {
        $css_rules = $extra_css = null;

        if ( get_header_image() ) {

            $hero = [
                'url'  => get_header_image(),
                'size' => [
                    get_custom_header()->width,
                    get_custom_header()->height,
                ],
            ];

            $hero = $this->get_background_url();

            if ( ! empty( $hero ) || $hero['url'] ) {
                $css_rules .= 'background-image: url(' . esc_url( $hero['url'] ) . ');';
            }

            if ( $css_rules != '' ) {
                $css_rules = '.site-hero-background-container {' . $css_rules . '}';
            }
        }

        if ( $this->args['height'] ) {
            $css_rules .= '@media only screen and (min-width: 768px) {';
                $css_rules .= '.site-hero, .site-hero-wrapper { min-height: ' . esc_attr( preg_replace( '/[^0-9,.-]/', '', $this->args['height'] ) ) . 'px; }';
            $css_rules .= '}';
        }

        $css = $css_rules . $extra_css;

        return esc_js( $css );
    }
}