<?php
/**
 * Widget and sidebars related functions
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       Analytica 1.0.0
 */

/**
 * WordPress filter - Widget Tags
 */
if ( ! function_exists( 'analytica_widget_tag_cloud_args' ) ) :

	/**
	 * WordPress filter - Widget Tags
	 *
	 * @param  array $args Tag arguments.
	 * @return array       Modified tag arguments.
	 */
	function analytica_widget_tag_cloud_args( $args = array() ) {

		$sidebar_link_font_size            = analytica_get_option( 'font-size-body' );
		$sidebar_link_font_size['desktop'] = ( '' != $sidebar_link_font_size['desktop'] ) ? $sidebar_link_font_size['desktop'] : 15;

		$args['smallest'] = intval( $sidebar_link_font_size['desktop'] ) - 2;
		$args['largest']  = intval( $sidebar_link_font_size['desktop'] ) + 3;
		$args['unit']     = 'px';

		return apply_filters( 'analytica_widget_tag_cloud_args', $args );
	}
	add_filter( 'widget_tag_cloud_args', 'analytica_widget_tag_cloud_args', 90 );

endif;

/**
 * WordPress filter - Widget Categories
 */
if ( ! function_exists( 'analytica_filter_widget_tag_cloud' ) ) :

	/**
	 * WordPress filter - Widget Categories
	 *
	 * @param  array $tags_data Tags data.
	 * @return array            Modified tags data.
	 */
	function analytica_filter_widget_tag_cloud( $tags_data ) {

		if ( is_tag() ) {
			foreach ( $tags_data as $key => $tag ) {
				if ( get_queried_object_id() === (int) $tags_data[ $key ]['id'] ) {
					$tags_data[ $key ]['class'] = $tags_data[ $key ]['class'] . ' current-item';
				}
			}
		}

		return apply_filters( 'analytica_filter_widget_tag_cloud', $tags_data );
	}
	add_filter( 'wp_generate_tag_cloud_data', 'analytica_filter_widget_tag_cloud' );

endif;

/**
 * Register widget area.
 */
if ( ! function_exists( 'analytica_widgets_init' ) ) :

	/**
	 * Register widget area.
	 *
	 * @see https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
	 */
	function analytica_widgets_init() {

		/**
		 * Register Main Sidebar
		 */
		register_sidebar(
			apply_filters(
				'analytica_widgets_init', array(
					'name'          => esc_html__( 'Main Sidebar', 'analytica' ),
					'id'            => 'sidebar-1',
					'description'   => '',
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h2 class="widget-title">',
					'after_title'   => '</h2>',
				)
			)
		);

		/**
		 * Register Header Widgets area
		 */
		register_sidebar(
			apply_filters(
				'analytica_header_widgets_init', array(
					'name'          => esc_html__( 'Header', 'analytica' ),
					'id'            => 'header-widget',
					'description'   => '',
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h2 class="widget-title">',
					'after_title'   => '</h2>',
				)
			)
		);

		/**
		 * Register Footer Bar Widgets area
		 */
		register_sidebar(
			apply_filters(
				'analytica_footer_1_widgets_init', array(
					'name'          => esc_html__( 'Footer Bar Section 1', 'analytica' ),
					'id'            => 'footer-widget-1',
					'description'   => '',
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h2 class="widget-title">',
					'after_title'   => '</h2>',
				)
			)
		);

		register_sidebar(
			apply_filters(
				'analytica_footer_2_widgets_init', array(
					'name'          => esc_html__( 'Footer Bar Section 2', 'analytica' ),
					'id'            => 'footer-widget-2',
					'description'   => '',
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h2 class="widget-title">',
					'after_title'   => '</h2>',
				)
			)
		);

		/**
		 * Register Footer Widgets area
		 */
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer Widget Area 1', 'analytica' ),
				'id'            => 'advanced-footer-widget-1',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);

		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer Widget Area 2', 'analytica' ),
				'id'            => 'advanced-footer-widget-2',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);

		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer Widget Area 3', 'analytica' ),
				'id'            => 'advanced-footer-widget-3',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);

		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer Widget Area 4', 'analytica' ),
				'id'            => 'advanced-footer-widget-4',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}
	add_action( 'widgets_init', 'analytica_widgets_init' );

endif;
