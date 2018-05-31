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

/**
 * Meta Boxes setup
 */
class MetaBoxes {

    /**
     * Instance
     *
     * @var $instance
     */
    private static $instance;

    /**
     * Meta Option
     *
     * @var $meta_option
     */
    private static $meta_option;

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

        add_action( 'load-post.php', array( $this, 'init_metabox' ) );
        add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
        add_action( 'do_meta_boxes', array( $this, 'remove_metabox' ) );
    }

    /**
     * Check if layout is bb themer's layout
     */
    public static function is_bb_themer_layout() {

        $is_layout = false;

        $post_type = get_post_type();
        $post_id   = get_the_ID();

        if ( 'fl-theme-layout' === $post_type && $post_id ) {

            $is_layout = true;
        }

        return $is_layout;
    }

    /**
     *  Remove Metabox for beaver themer specific layouts
     */
    public function remove_metabox() {

        $post_type = get_post_type();
        $post_id   = get_the_ID();

        if ( 'fl-theme-layout' === $post_type && $post_id ) {

            $template_type = get_post_meta( $post_id, '_fl_theme_layout_type', true );

            if ( ! ( 'archive' === $template_type || 'singular' === $template_type || '404' === $template_type ) ) {

                remove_meta_box( 'analytica_settings_meta_box', 'fl-theme-layout', 'side' );
            }
        }
    }

    /**
     *  Init Metabox
     */
    public function init_metabox() {

        add_action( 'add_meta_boxes', array( $this, 'setup_meta_box' ) );
        add_action( 'save_post', array( $this, 'save_meta_box' ) );

        /**
         * Set metabox options
         *
         * @see http://php.net/manual/en/filter.filters.sanitize.php
         */
        self::$meta_option = apply_filters(
            'analytica_meta_box_options', array(
                'site-post-title'         => array(
                    'sanitize' => 'FILTER_DEFAULT',
                ),
                'site-sidebar-layout'     => array(
                    'default'  => 'default',
                    'sanitize' => 'FILTER_DEFAULT',
                ),
                'featured-image'        => array(
                    'sanitize' => 'FILTER_DEFAULT',
                ),
            )
        );
    }

    /**
     *  Setup Metabox
     */
    function setup_meta_box() {

        // Get all public posts.
        $post_types = get_post_types( array( 'public' => true, ) );

        $post_types['fl-theme-layout'] = 'fl-theme-layout';

        $metabox_name = analytica_get_theme_name() . __( ' Settings', 'analytica' );
        // Enable for all posts.
        foreach ( $post_types as $type ) {
            if ( 'attachment' !== $type ) {
                add_meta_box( 'analytica_settings_meta_box', $metabox_name, array( $this, 'markup_meta_box' ), $type, 'side', 'default' );
            }
        }
    }

    /**
     * Get metabox options
     */
    public static function get_meta_option() {
        return self::$meta_option;
    }

    /**
     * Metabox Markup
     *
     * @param  object $post Post object.
     * @return void
     */
    function markup_meta_box( $post ) {

        wp_nonce_field( basename( __FILE__ ), 'analytica_settings_meta_box' );
        $stored = get_post_meta( $post->ID );

        // Set stored and override defaults.
        foreach ( $stored as $key => $value ) {
            self::$meta_option[ $key ]['default'] = ( isset( $stored[ $key ][0] ) ) ? $stored[ $key ][0] : '';
        }

        // Get defaults.
        $meta = self::get_meta_option();

        /**
         * Get options
         */
        $site_sidebar        = ( isset( $meta['site-sidebar-layout']['default'] ) ) ? $meta['site-sidebar-layout']['default'] : 'default';
        $site_content_layout = ( isset( $meta['site-content-layout']['default'] ) ) ? $meta['site-content-layout']['default'] : 'default';
        $site_post_title     = ( isset( $meta['site-post-title']['default'] ) ) ? $meta['site-post-title']['default'] : '';
        $ast_featured_img    = ( isset( $meta['featured-image']['default'] ) ) ? $meta['featured-image']['default'] : '';

        $show_meta_field = ! self::is_bb_themer_layout();

        do_action( 'analytica_meta_box_markup_before', $meta );

        /**
         * Option: Sidebar
         */
        ?>
        <div class="site-sidebar-layout-meta-wrap">
            <p class="post-attributes-label-wrapper" >
                <strong> <?php esc_html_e( 'Sidebar', 'analytica' ); ?> </strong>
            </p>
            <select name="site-sidebar-layout" id="site-sidebar-layout">
                <option value="default" <?php selected( $site_sidebar, 'default' ); ?> > <?php esc_html_e( 'Customizer Setting', 'analytica' ); ?></option>
                <option value="sidebar-content" <?php selected( $site_sidebar, 'sidebar-content' ); ?> > <?php esc_html_e( 'Left Sidebar', 'analytica' ); ?></option>
                <option value="content-sidebar" <?php selected( $site_sidebar, 'content-sidebar' ); ?> > <?php esc_html_e( 'Right Sidebar', 'analytica' ); ?></option>
                <option value="fullwidth" <?php selected( $site_sidebar, 'fullwidth' ); ?> > <?php esc_html_e( 'No Sidebar', 'analytica' ); ?></option>
            </select>
        </div>
        <?php
        /**
         * Option: Sidebar
         */
        ?>
        <div class="site-content-layout-meta-wrap">
            <p class="post-attributes-label-wrapper" >
                <strong> <?php esc_html_e( 'Content Layout', 'analytica' ); ?> </strong>
            </p>
            <select name="site-content-layout" id="site-content-layout">
                <option value="default" <?php selected( $site_content_layout, 'default' ); ?> > <?php esc_html_e( 'Customizer Setting', 'analytica' ); ?></option>
                <option value="boxed-container" <?php selected( $site_content_layout, 'boxed-container' ); ?> > <?php esc_html_e( 'Boxed', 'analytica' ); ?></option>
                <option value="content-boxed-container" <?php selected( $site_content_layout, 'content-boxed-container' ); ?> > <?php esc_html_e( 'Content Boxed', 'analytica' ); ?></option>
                <option value="plain-container" <?php selected( $site_content_layout, 'plain-container' ); ?> > <?php esc_html_e( 'Full Width / Contained', 'analytica' ); ?></option>
                <option value="page-builder" <?php selected( $site_content_layout, 'page-builder' ); ?> > <?php esc_html_e( 'Full Width / Stretched', 'analytica' ); ?></option>
            </select>
        </div>
        <?php
        /**
         * Option: Disable Sections - Primary Header, Title, Footer Widgets, Footer Bar
         */
        ?>
        <div class="disable-section-meta-wrap">
            <p class="post-attributes-label-wrapper">
                <strong> <?php esc_html_e( 'Disable Sections', 'analytica' ); ?> </strong>
            </p>
            <div class="disable-section-meta">
                <?php do_action( 'analytica_meta_box_markup_disable_sections_before', $meta ); ?>

                <?php if ( $show_meta_field ) { ?>
                    <div class="site-post-title-option-wrap">
                        <label for="site-post-title">
                            <input type="checkbox" id="site-post-title" name="site-post-title" value="disabled" <?php checked( $site_post_title, 'disabled' ); ?> />
                            <?php esc_html_e( 'Disable Title', 'analytica' ); ?>
                        </label>
                    </div>

                    <div class="analytica-featured-img-option-wrap">
                        <label for="analytica-featured-img">
                            <input type="checkbox" id="analytica-featured-img" name="analytica-featured-img" value="disabled" <?php checked( $ast_featured_img, 'disabled' ); ?> />
                            <?php esc_html_e( 'Disable Featured Image', 'analytica' ); ?>
                        </label>
                    </div>
                <?php } ?>

                <?php do_action( 'analytica_meta_box_markup_disable_sections_after', $meta ); ?>
            </div>
        </div>
        <?php

        do_action( 'analytica_meta_box_markup_after', $meta );
    }

    /**
     * Metabox Save
     *
     * @param  number $post_id Post ID.
     * @return void
     */
    function save_meta_box( $post_id ) {

        // Checks save status.
        $is_autosave    = wp_is_post_autosave( $post_id );
        $is_revision    = wp_is_post_revision( $post_id );
        $is_valid_nonce = ( isset( $_POST['analytica_settings_meta_box'] ) && wp_verify_nonce( sanitize_key( $_POST['analytica_settings_meta_box'] ), basename( __FILE__ ) ) ) ? true : false;

        // Exits script depending on save status.
        if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
            return;
        }

        /**
         * Get meta options
         */
        $post_meta = self::get_meta_option();

        foreach ( $post_meta as $key => $data ) {

            // Sanitize values.
            $sanitize_filter = ( isset( $data['sanitize'] ) ) ? $data['sanitize'] : 'FILTER_DEFAULT';

            switch ( $sanitize_filter ) {

                case 'FILTER_SANITIZE_STRING':
                        $meta_value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );
                    break;

                case 'FILTER_SANITIZE_URL':
                        $meta_value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_URL );
                    break;

                case 'FILTER_SANITIZE_NUMBER_INT':
                        $meta_value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_NUMBER_INT );
                    break;

                default:
                        $meta_value = filter_input( INPUT_POST, $key, FILTER_DEFAULT );
                    break;
            }

            // Store values.
            if ( $meta_value ) {
                update_post_meta( $post_id, $key, $meta_value );
            } else {
                delete_post_meta( $post_id, $key );
            }
        }

    }
}
    
/**
 * Kicking this off by calling 'get_instance()' method
 */
MetaBoxes::get_instance();
