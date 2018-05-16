<?php
/**
 * This file is a part of the analytica Framework core.
 * Please be cautious editing this file,
 *
 * @category Analytica
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     http://qazana.net/
 */
namespace Analytica;

class Page_Hero {

    /**
     * Unique id
     *
     * @var string
     */
    protected $uniqid;

    /**
     * Run actions
     */
    public function __construct() {
        $this->uniqid = uniqid( 'analytica-hero-' );
        $this->get_config();
        $this->add_action();
    }

    protected function get_config() {
        $this->align           = analytica_get_option( 'hero_text_alignment', 'text-center' );
        $this->breadcrumbs     = analytica_get_option( 'hero_breadcrumbs' );
        $this->color_base      = analytica_get_option( 'hero_bg_color_base', 'light' );
        $this->hero_show_title    = analytica_get_option( 'hero_show_title' );
        $this->hero_show_subtitle = analytica_get_option( 'hero_show_subtitle' );
        $this->height          = analytica_get_option( 'hero_custom_height', 300 );
        $this->height          = wp_is_mobile() ? 110 : $this->height;
        $this->full_height     = analytica_get_option( 'hero_full_height', '' );
        $this->full_height     = wp_is_mobile() ? 500 : $this->full_height;
        $this->parallax        = analytica_is_bool( analytica_get_option( 'hero_parallax', 'on' ) );
        $this->background      = [
            'color'    => analytica_get_option( 'hero_bg_color' ),
            'fixed'    => analytica_get_option( 'hero_bg_fixed' ),
            'position' => analytica_get_option( 'hero_bg_img_position' ),
            'repeat'   => analytica_get_option( 'hero_bg_repeat' ),
            'size'     => analytica_get_option( 'hero_background_size', 'cover' ),
        ];
        $this->image_active   = analytica_is_bool( analytica_get_option( 'hero_bg_img_enable', 'on' ) );
        $this->image_inherit  = analytica_get_option( 'hero_bg_img_inherit', true );
        $this->content = $this->content();
    }

    public function add_action() {
        add_action( 'analytica_do_before_hero_wrapper',     [ $this, 'do_background' ] );
        add_action( 'analytica_do_hero_content',            [ $this, 'do_title' ] );
        add_action( 'analytica_do_hero_content',            [ $this, 'do_subtitle' ] );
        add_action( 'analytica_do_hero_content',            [ $this, 'do_breadcrumbs' ] );
        add_filter( 'analytica_style_inline',               [ $this, 'do_hero_css' ] );
        add_filter( 'analytica_attr_hero',                  [ $this, 'attributes_hero' ] );
    }
 
    /**
     * get hero content.
     *
     * @since  1.0.0
     */
    function content() {
        global $post;

        $post_id = $post ? $post->ID : 0;

        if ( is_archive() ) { // A few checks for archives

            if ( is_tag() ) {

                $header_title = sprintf( esc_html__( 'Tag: %s', 'energia' ), '<span>' . single_tag_title( '', false ) . '</span>' );

                $tag_description = tag_description();

                if ( ! empty( $tag_description ) ) {
                    $header_subtitle = apply_filters( 'tag_archive_meta', '<div class="tag-archive-meta">' . $tag_description . '</div>' );
                }

            } elseif ( is_category() ) {

                $header_title = '<span>' . single_cat_title( '', false ) . '</span>';

                $category_description = category_description();

                if ( ! empty( $category_description ) ) {
                    $header_subtitle = apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
                }
            } elseif ( is_day() ) {
                $header_title = sprintf( esc_html__( 'Daily: %s', 'energia' ), '<span>' . get_the_date() . '</span>' );
            } elseif ( is_month() ) {
                $header_title = sprintf( esc_html__( 'Monthly: %s', 'energia' ), '<span>' . get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'energia' ) ) .'</span>' );
            } elseif ( is_year() ) {
                $header_title = sprintf( esc_html__( 'Yearly: %s', 'energia' ), '<span>' . get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'energia' ) ) . '</span>' );
            } elseif ( is_author() ) {
                $header_title = esc_html__( 'Author: ', 'energia' ) . get_the_author();
            } else {
                $header_title = sprintf( esc_html__( 'Archive', 'energia' ) );
            }

        } elseif ( is_search() ) {

            global $wp_query;
            $number_of_results = $wp_query->found_posts;

            $header_title = '<span class="search-results-icon">' . analytica_get_ui_icons( 'search' ) . '</span>' . sprintf( esc_html__( 'Found %s results for: &ldquo;%s&rdquo;', 'energia' ), $number_of_results, get_search_query() );

        } elseif ( 'post' == get_post_type() && (is_front_page() || ( get_option( 'show_on_front' ) == 'posts' && is_singular( 'post' ) ) ) ) {
            
            $header_title = analytica_get_option( 'content_archive_all_posts_title' );
        
        } elseif ( 'post' == get_post_type() ) {

            // Get Blog Post Page ID, extract and show the title
            $blog = get_post( get_option( 'page_for_posts' ) );

            $header_title = $blog->post_title;

        } elseif ( 'page' == get_post_type() && is_front_page() ) {

            // Get Frontpage Page ID, extract and show the title
            $frontpage = get_post( get_option( 'page_on_front' ) );

            $header_title = $frontpage->post_title;

        } else {

            $header_title = get_the_title( $post_id );

        }

        if ( 'post' == get_post_type() && is_single() ) {
            $header_title = esc_html__( 'Post', 'energia' );
        }

        $title = apply_filters( 'analytica_hero_title', $header_title );
        $subtitle = apply_filters( 'analytica_hero_subtitle', analytica_get_option( 'hero_subtitle' ) );

        $header = array(
            'title' => $title,
            'subtitle' => $subtitle,
        );

        return $header;
    }

    public function get_post_image_data( $image_id ) {
        $image_args = [
            'src' => true,
            'options' => [
                'w' => 'auto',
                'h' => ( $this->height * 2 ),
            ],
        ];

        $image_args['img_id'] = $image_id;

        $image = wp_get_attachment_image_src( $image_args['img_id'], 'full' );

        $image_args['options']['w'] = $image[1];

        $hero = [
            'url'  => analytica_get_thumb_img( $image_args ),
            'size' => [
                $image[1],
                $this->height,
            ],
        ];

        return $hero;
    }

    /**
     * Get default image as fallback
     *
     * @return void
     */
    public function get_default_background() {
        $image_id = analytica_get_option( 'hero_bg_img' );

        if ( ! is_numeric( $image_id ) ) {
            $image_id = analytica_get_attachment_id_from_url( $image_id );
        }

        if ( $image_id && is_numeric( $image_id ) ) {
            return $this->get_post_image_data( $image_id );
        } else {
            return [
                'url'  => \Analytica\Options::defaults()['hero_bg_img'],
                'size' => [
                    1000,
                    $this->height,
                ],
            ];
        }
    }

    /**
     * Helper function to retreive background image
     *
     * @return void
     */
    public function get_background_url() {
        if ( $this->image_inherit && $image_id = get_post_meta( get_the_ID(), '_analytica_hero_bg_img', true ) ) {
            return $this->get_post_image_data( $image_id );
        } elseif ( $this->image_inherit && $image_id = analytica_get_post_thumbnail_id() ) {
            return $this->get_post_image_data( $image_id );
        } else {
            return $this->get_default_background();
        }

    }

    /**
     * Add attributes for page header.
     *
     * @since 1.0.0
     *
     * @param array $attributes Existing attributes.
     *
     * @return array Amended attributes.
     */
    public function attributes_hero( $attributes ) {
        $attributes['class'] = 'hero entry-image';
        return $attributes;
    }

    public function do_header() {
        echo '<div class="hero' . esc_attr( $this->get_hero_classes() ) . '">';

            do_action( 'analytica_do_before_hero_wrapper' );

                analytica_structural_wrap( 'hero', 'open' );

                    analytica_markup([
                        'element'   => '<div %s>',
                        'context' => 'hero-wrapper',
                    ]);

                        echo '<div class="page-title-inner">';

                            do_action( 'analytica_do_before_hero_content' );

                            echo '<div class="page-title-inner-wrap">';
                                do_action( 'analytica_do_hero_content' );
                            echo '</div>';

                            do_action( 'analytica_do_after_hero_content' );

                        echo '</div>';

                    analytica_markup([
                        'element' => '</div>',
                    ]);

                analytica_structural_wrap( 'hero', 'close' );

            do_action( 'analytica_do_after_hero_wrapper' );

        echo '</div>';
    }

    public function get_hero_classes() {
        $classes = null;

        if ( $this->align ) {
            $classes .= ' ' . $this->align;
        }

        if ( $this->color_base ) {
            $classes .= ' has-background base-color-' . $this->color_base;
        }

        if ( $this->parallax ) {
            $classes .= ' hero-parallax';
        }

        if ( $this->full_height === 'on') {
            $classes .= ' hero-height-full';
        }

        return $classes;
    }

    public function do_breadcrumbs() {
        if ( $this->breadcrumbs !== 'off' ) {
            do_action( 'analytica_do_breadcrumbs' );
        }
    }

    public function do_title() {
        if ( $this->hero_show_title !== 'off' && ! empty( $this->content['title'] ) ) {
            ?><h1 class = "header"><?php echo $this->content['title'];  // WPCS: XSS ok. ?></h1><?php
        }
    }

    public function do_subtitle() {
        if ( ! empty( $this->content['subtitle'] ) && $this->hero_show_subtitle !== 'off' ) {
            ?><h3 class = "subheader"><?php echo $this->content['subtitle'];  // WPCS: XSS ok. ?></h3><?php
        }
    }

    /**
     * Generate page header css
     */
    public function do_background() {
        $classes = $data_atts = '';

        if ( $this->parallax && $this->image_active ) {
            $hero = $this->get_background_url();

            $options = [
				'backgroundUrl'    => $hero['url'],
				'backgroundSize'   => $hero['size'],
				'backgroundSizing' => 'original',        // $settings[ 'parallax_background_display' ] === 'parallax-original' ? 'original' : 'scaled',
				'limitMotion'      => 'auto',            // $settings[ 'parallax-motion' ] ? floatval( $settings[ 'parallax-motion' ] ) : 'auto',
			];

            $classes .= ' hero-vertical-parallax';

            $data_atts .= ' data-parallax="true"';
            $data_atts .= " data-parallax-options='" . json_encode( $options ) . "'";
        }

        echo '<div class="hero-bg-container' . esc_attr( $classes ) . '" ' . $data_atts . '>';
            echo '<div class="hero-overlay-color"></div>';
            do_action( 'analytica_do_hero_do_background' );
        echo '</div>';
    }

    public function do_hero_css( $css ) {
        $css_rules = $extra_css = null;

        if ( $this->image_active ) {

            $hero = $this->get_background_url();

            if ( ! empty( $hero ) || $hero['url'] ) {
                $css_rules .= 'background-image: url(' . esc_url( $hero['url'] ) . ');';
            }

            if ( $this->background['color'] ) {
                $css_rules .= 'background-color: ' . $this->background['color'] . ';';
            }

            if ( $this->background['size'] ) {
                $css_rules .= 'background-size: ' . $this->background['size'] . ';';
            }

            if ( $this->background['position'] ) {
                $css_rules .= 'background-position: ' . $this->background['position'] . ';';
            }

            if ( $this->background['fixed'] ) {
                $css_rules .= 'background-attachment: ' . $this->background['fixed'] . ';';
                if ( $this->background['fixed'] === 'fixed') {
                    $extra_css .= '.hero-bg-container.hero-vertical-parallax {'
                        . '-webkit-transform: -webkit-translate3d(0,0,0);'
                        . '-moz-transform: -moz-translate3d(0,0,0);'
                        . '-ms-transform: -ms-translate3d(0,0,0);'
                        . '-o-transform: -o-translate3d(0,0,0);'
                        . 'transform: translate3d(0,0,0);'
                    . '}';
                }
            }

            if ( $this->background['repeat'] ) {
                $css_rules .= 'background-repeat: ' . $this->background['repeat'] . ';';
            }

            if ( $css_rules != '' ) {
                $css_rules = '.hero .hero-bg-container {' . $css_rules . '}';
            }
        }

        if ( $this->height ) {
            $css_rules .= '@media only screen and (min-width: 768px) {';
                $css_rules .= '.hero, .hero .hero-wrapper { min-height: ' . esc_attr( preg_replace( '/[^0-9,.-]/', '', $this->height ) ) . 'px; }';
            $css_rules .= '}';
        }

        $css .= $css_rules . $extra_css;

        return esc_js( $css );
    }
}
