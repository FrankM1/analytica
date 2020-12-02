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

class Site_Hero {

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
		$this->content();
		$this->add_action();
    }

    protected function get_config() {
        $this->args['align']         = analytica_get_option( 'site-hero-text-alignment' );
        $this->args['breadcrumbs']   = analytica_get_option( 'site-hero-breadcrumbs' );
        $this->args['color-base']    = analytica_get_option( 'site-hero-background-color-base' );
        $this->args['fullheight']    = wp_is_mobile() ? false : analytica_get_option( 'site-hero-fullheight' );
        $this->args['show-subtitle'] = analytica_get_option( 'site-hero-show-subtitle' );
        $this->args['show-title']    = analytica_get_option( 'site-hero-show-title' );
		$this->args['has-image']     = get_header_image();

    }

    public function add_action() {
        add_action( 'analytica_do_before_site_hero_wrapper',     [ $this, 'do_background' ] );
        add_action( 'analytica_do_site_hero_content',            [ $this, 'do_title' ] );
        add_action( 'analytica_do_site_hero_content',            [ $this, 'do_subtitle' ] );
        add_action( 'analytica_do_site_hero_content',            [ $this, 'do_breadcrumbs' ] );
        add_filter( 'analytica_attr_site-hero',             [ $this, 'attributes_hero' ] );
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
			$header_title = get_the_archive_title();

        } elseif ( is_search() ) {

            global $wp_query;
            $number_of_results = $wp_query->found_posts;

            /* translators: %1$s: Search results count, %2$s: Search query  */
            $header_title = '<span class="search-results-icon"></span>' . sprintf( esc_html__( 'Found %1$s results for: &ldquo;%2$s&rdquo;', 'analytica' ), $number_of_results, get_search_query() );

        } elseif ( 'post' == get_post_type() && (is_front_page() || ( get_option( 'show_on_front' ) == 'posts' && is_singular( 'post' ) ) ) ) {

            $header_title = analytica_get_option( 'archive-frontpage-title' );

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
            $header_title = esc_html__( 'Post', 'analytica' );
        }

		$this->page_title = apply_filters( 'analytica_site_hero_title', $header_title );

		if ( $this->args['show-subtitle'] ) {
			$this->page_subtitle = apply_filters( 'analytica_site_hero_subtitle', analytica_get_option( 'site-hero-subtitle' ) );
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
        $attributes['class'] = 'site-hero entry-image';
        return $attributes;
    }

    public function do_header() {
        echo '<div class="site-hero' . esc_attr( $this->get_site_hero_classes() ) . '">';

            do_action( 'analytica_do_before_site_hero_wrapper' );

                analytica_structural_wrap( 'site-hero', 'open' );

                    analytica_markup([
                        'element'   => '<div %s>',
                        'context' => 'site-hero-wrapper',
                    ]);

                        echo '<div class="page-title-inner">';

                            do_action( 'analytica_do_before_site_hero_content' );

                            echo '<div class="page-title-inner-wrap">';
                                do_action( 'analytica_do_site_hero_content' );
                            echo '</div>';

                            do_action( 'analytica_do_after_site_hero_content' );

                        echo '</div>';

                    analytica_markup([
                        'element' => '</div>',
                    ]);

                analytica_structural_wrap( 'site-hero', 'close' );

            do_action( 'analytica_do_after_site_hero_wrapper' );

        echo '</div>';
    }

    public function get_site_hero_classes() {
        $classes = null;

        if ( $this->args['align'] ) {
            $classes .= ' ' . $this->args['align'];
        }

        if ( $this->args['color-base'] && $this->args['has-image'] ) {
            $classes .= ' has-background base-color-' . $this->args['color-base'];
            if ( $this->args['fullheight'] ) {
                $classes .= ' site-hero-height-full';
            }
        }

        return $classes;
    }

    public function do_breadcrumbs() {
        if ( $this->args['breadcrumbs'] ) {
            do_action( 'analytica_do_breadcrumbs' );
        }
    }

    public function do_title() {
        if ( $this->args['show-title'] && ! empty( $this->page_title ) ) {
            ?><h1 class = "site-hero-header"><?php echo wp_kses( $this->page_title, analytica_get_allowed_tags() ); ?></h1><?php
        }
    }

    public function do_subtitle() {
        if ( ! empty( $this->page_subtitle ) && $this->args['show-subtitle'] ) {
            ?><h3 class = "site-hero-subheader"><?php echo wp_kses( $this->page_subtitle, analytica_get_allowed_tags() ); ?></h3><?php
        }
    }

    /**
     * Generate page header css
     */
    public function do_background() {
        echo '<div class="site-hero-background-container">';
            echo '<div class="site-hero-background"></div>';
            do_action( 'analytica_do_site_hero_do_background' );
        echo '</div>';
    }
}
