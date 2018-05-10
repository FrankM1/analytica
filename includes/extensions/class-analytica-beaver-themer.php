<?php
/**
 * Beaver Themer Compatibility File.
 *
 * @package Analytica
 */

// If plugin - 'Beaver Themer' not exist then return.
if ( ! class_exists( 'FLThemeBuilderLoader' ) || ! class_exists( 'FLThemeBuilderLayoutData' ) ) {
	return;
}

/**
 * Analytica Beaver Themer Compatibility
 *
 * @since 1.0.0
 */
class Analytica_Beaver_Themer {

    /**
     * Member Variable
     *
     * @var object instance
     */
    private static $instance;

    /**
     * Initiator
     */
    public static function get_instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'after_setup_theme', array( $this, 'header_footer_support' ) );
        add_action( 'wp', array( $this, 'theme_header_footer_render' ) );
        add_filter( 'fl_theme_builder_part_hooks', array( $this, 'register_part_hooks' ) );
        add_filter( 'post_class', array( $this, 'render_post_class' ), 99 );
        add_action( 'fl_theme_builder_before_render_content', array( $this, 'builder_before_render_content' ), 10, 1 );
        add_action( 'fl_theme_builder_after_render_content', array( $this, 'builder_after_render_content' ), 10, 1 );
    }

    /**
     * Builder Template Content layout set as Full Width / Stretched
     *
     * @param  string $layout Content Layout.
     * @return string
     * @since  1.0.2
     */
    function builder_template_content_layout( $layout ) {

        $ids       = FLThemeBuilderLayoutData::get_current_page_content_ids();
        $post_type = get_post_type();

        if ( 'fl-theme-layout' == $post_type ) {
            remove_action( 'analytica_entry_after', 'analytica_single_post_navigation_markup' );
        }

        if ( empty( $ids ) && 'fl-theme-layout' != $post_type ) {
            return $layout;
        }

        return 'page-builder';
    }

    /**
     * Remove theme post's default classes
     *
     * @param  array $classes Post Classes.
     * @return array
     * @since  1.0.2
     */
    function render_post_class( $classes ) {

        $post_class = array( 'fl-post-grid-post', 'fl-post-gallery-post', 'fl-post-feed-post' );
        $result     = array_intersect( $classes, $post_class );

        if ( count( $result ) > 0 ) {
            $classes = array_diff( $classes, array( 'ast-col-sm-12', 'ast-article-post' ) );
            add_filter( 'analytica_post_link_enabled', '__return_false' );
        }
        return $classes;
    }

    /**
     * Function to add Theme Support
     *
     * @since 1.0.0
     */
    function header_footer_support() {

        add_theme_support( 'fl-theme-builder-headers' );
        add_theme_support( 'fl-theme-builder-footers' );
        add_theme_support( 'fl-theme-builder-parts' );
    }

    /**
     * Function to update Atra header/footer with Beaver template
     *
     * @since 1.0.0
     */
    function theme_header_footer_render() {

        // Get the header ID.
        $header_ids = FLThemeBuilderLayoutData::get_current_page_header_ids();

        // If we have a header, remove the theme header and hook in Theme Builder's.
        if ( ! empty( $header_ids ) ) {
            remove_action( 'analytica_header', 'analytica_header_markup' );
            add_action( 'analytica_header', 'FLThemeBuilderLayoutRenderer::render_header' );
        }

        // Get the footer ID.
        $footer_ids = FLThemeBuilderLayoutData::get_current_page_footer_ids();

        // If we have a footer, remove the theme footer and hook in Theme Builder's.
        if ( ! empty( $footer_ids ) ) {
            remove_action( 'analytica_footer', 'analytica_footer_markup' );
            add_action( 'analytica_footer', 'FLThemeBuilderLayoutRenderer::render_footer' );
        }

        // BB Themer Support.
        $template_ids = FLThemeBuilderLayoutData::get_current_page_content_ids();

        if ( ! empty( $template_ids ) ) {

            $template_id   = $template_ids[0];
            $template_type = get_post_meta( $template_id, '_fl_theme_layout_type', true );

            if ( 'archive' === $template_type || 'singular' === $template_type || '404' === $template_type ) {

                $sidebar = get_post_meta( $template_id, 'site-sidebar-layout', true );

                if ( 'default' !== $sidebar ) {
                    add_filter(
                        'analytica_page_layout', function( $page_layout ) use ( $sidebar ) {

                            return $sidebar;
                        }
                    );
                }

                $content_layout = get_post_meta( $template_id, 'site-content-layout', true );
                if ( 'default' !== $content_layout ) {
                    add_filter(
                        'analytica_get_content_layout', function( $layout ) use ( $content_layout ) {

                            return $content_layout;
                        }
                    );
                }

                $main_header_display = get_post_meta( $template_id, 'ast-main-header-display', true );
                if ( 'disabled' === $main_header_display ) {

                    if ( 'archive' === $template_type ) {
                        remove_action( 'analytica_masthead', 'analytica_masthead_primary_template' );
                    } else {
                        add_filter(
                            'ast_main_header_display', function( $display_header ) {

                                return 'disabled';
                            }
                        );
                    }
                }

                $footer_layout = get_post_meta( $template_id, 'footer-sml-layout', true );
                if ( 'disabled' === $footer_layout ) {

                    add_filter(
                        'ast_footer_sml_layout', function( $is_footer ) {

                            return 'disabled';
                        }
                    );
                }

                // Override! Footer Widgets.
                $footer_widgets = get_post_meta( $template_id, 'footer-adv-display', true );
                if ( 'disabled' === $footer_widgets ) {
                    add_filter(
                        'analytica_advanced_footer_disable', function() {
                            return true;
                        }
                    );
                }
            }
        }
    }

    /**
     * Function to Analytica theme parts
     *
     * @since 1.0.0
     */
    function register_part_hooks() {

        return array(
            array(
                'label' => 'Page',
                'hooks' => array(
                    'analytica_body_top'    => __( 'Before Page', 'analytica' ),
                    'analytica_body_bottom' => __( 'After Page', 'analytica' ),
                ),
            ),
            array(
                'label' => 'Header',
                'hooks' => array(
                    'analytica_header_before' => __( 'Before Header', 'analytica' ),
                    'analytica_header_after'  => __( 'After Header', 'analytica' ),
                ),
            ),
            array(
                'label' => 'Content',
                'hooks' => array(
                    'analytica_primary_content_top'    => __( 'Before Content', 'analytica' ),
                    'analytica_primary_content_bottom' => __( 'After Content', 'analytica' ),
                ),
            ),
            array(
                'label' => 'Footer',
                'hooks' => array(
                    'analytica_footer_before' => __( 'Before Footer', 'analytica' ),
                    'analytica_footer_after'  => __( 'After Footer', 'analytica' ),
                ),
            ),
            array(
                'label' => 'Sidebar',
                'hooks' => array(
                    'analytica_sidebars_before' => __( 'Before Sidebar', 'analytica' ),
                    'analytica_sidebars_after'  => __( 'After Sidebar', 'analytica' ),
                ),
            ),
            array(
                'label' => 'Posts',
                'hooks' => array(
                    'loop_start'                 => __( 'Loop Start', 'analytica' ),
                    'analytica_entry_top'            => __( 'Before Post', 'analytica' ),
                    'analytica_entry_content_before' => __( 'Before Post Content', 'analytica' ),
                    'analytica_entry_content_after'  => __( 'After Post Content', 'analytica' ),
                    'analytica_entry_bottom'         => __( 'After Post', 'analytica' ),
                    'analytica_comments_before'      => __( 'Before Comments', 'analytica' ),
                    'analytica_comments_after'       => __( 'After Comments', 'analytica' ),
                    'loop_end'                   => __( 'Loop End', 'analytica' ),
                ),
            ),
        );
    }

    /**
     * Function to theme before render content
     *
     * @param int $post_id Post ID.
     * @since 1.0.28
     */
    function builder_before_render_content( $post_id ) {

    ?>
        <?php if ( 'left-sidebar' === analytica_page_layout() ) : ?>

            <?php get_sidebar(); ?>

        <?php endif ?>

        <div id="primary" <?php analytica_primary_class(); ?>>
    <?php
    }

    /**
     * Function to theme after render content
     *
     * @param int $post_id Post ID.
     * @since 1.0.28
     */
    function builder_after_render_content( $post_id ) {

    ?>
        </div><!-- #primary -->

        <?php if ( 'right-sidebar' === analytica_page_layout() ) : ?>

            <?php get_sidebar(); ?>

        <?php endif ?>

    <?php
    }
}

/**
 * Kicking this off by calling 'get_instance()' method
 */
Analytica_Beaver_Themer::get_instance();
