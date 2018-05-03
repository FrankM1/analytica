<?php
/**
 * Template parts
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       Analytica 1.0.0
 */

add_action( 'analytica_masthead_toggle_buttons', 'analytica_masthead_toggle_buttons_primary' );
add_action( 'analytica_masthead', 'analytica_masthead_primary_template' );
add_filter( 'wp_page_menu_args', 'analytica_masthead_custom_page_menu_items', 10, 2 );
add_filter( 'wp_nav_menu_items', 'analytica_masthead_custom_nav_menu_items', 10, 2 );
add_action( 'analytica_footer_content', 'analytica_footer_small_footer_template', 5 );
add_action( 'analytica_entry_content_single', 'analytica_entry_content_single_template' );
add_action( 'analytica_entry_content_blog', 'analytica_entry_content_blog_template' );
add_action( 'analytica_entry_content_404_page', 'analytica_entry_content_404_page_template' );
add_action( 'analytica_footer_content', 'analytica_advanced_footer_markup', 1 );
add_action( 'analytica_masthead_content', 'analytica_header_custom_item_outside_menu', 10 );

/**
 * Header Custom Menu Item
 */
if ( ! function_exists( 'analytica_masthead_get_menu_items' ) ) :

	/**
	 * Custom Menu Item Markup
	 *
	 * => Used in hooks:
	 *
	 * @see analytica_masthead_get_menu_items
	 * @see analytica_masthead_custom_nav_menu_items
	 * @param boolean $display_outside_markup Outside / Inside markup.
	 *
	 * @since 1.0.0
	 */
	function analytica_masthead_get_menu_items( $display_outside_markup = false ) {

		// Get selected custom menu items.
		$markup = '';

		$section                    = analytica_get_option( 'header-main-rt-section' );
		$sections                   = analytica_get_dynamic_header_content( 'header-main-rt-section' );
		$disable_primary_navigation = analytica_get_option( 'disable-primary-nav' );
		$html_element               = 'li';

		if ( $disable_primary_navigation || $display_outside_markup ) {
			$html_element = 'div';
		}

		if ( array_filter( $sections ) ) {
			ob_start();
			$menu_item_classes = apply_filters( 'analytica_masthead_custom_menu_item', array( 'ast-masthead-custom-menu-items', $section . '-custom-menu-item' ), $section );
			?>
			<<?php echo esc_attr( $html_element ); ?> class="<?php echo esc_attr( join( ' ', $menu_item_classes ) ); ?>">
				<?php
				foreach ( $sections as $key => $value ) {
					if ( ! empty( $value ) ) {
						echo $value;
					}
				}
				?>
			</<?php echo esc_attr( $html_element ); ?>>
			<?php
			$markup = ob_get_clean();
		}

		return apply_filters( 'analytica_masthead_get_menu_items', $markup );
	}

endif;

/**
 * Header Custom Menu Item
 */
if ( ! function_exists( 'analytica_masthead_custom_page_menu_items' ) ) :

	/**
	 * Header Custom Menu Item
	 *
	 * => Used in files:
	 *
	 * /header.php
	 *
	 * @since 1.0.0
	 * @param  array $args Array of arguments.
	 * @return array       Modified menu item array.
	 */
	function analytica_masthead_custom_page_menu_items( $args ) {

		if ( isset( $args['theme_location'] ) && ! analytica_get_option( 'header-display-outside-menu' ) ) {

			if ( 'primary' === $args['theme_location'] ) {

				$markup = analytica_masthead_get_menu_items();

				if ( $markup ) {
					$args['after'] = $markup . '</ul>';
				}
			}
		}

		return $args;
	}

endif;

/**
 * Header Custom Menu Item
 */
if ( ! function_exists( 'analytica_masthead_custom_nav_menu_items' ) ) :

	/**
	 * Header Custom Menu Item
	 *
	 * => Used in files:
	 *
	 * /header.php
	 *
	 * @since 1.0.0
	 * @param  array $items Nav menu item array.
	 * @param  array $args  Nav menu item arguments array.
	 * @return array       Modified menu item array.
	 */
	function analytica_masthead_custom_nav_menu_items( $items, $args ) {

		if ( isset( $args->theme_location ) && ! analytica_get_option( 'header-display-outside-menu' ) ) {

			if ( 'primary' === $args->theme_location ) {

				$markup = analytica_masthead_get_menu_items();

				if ( $markup ) {
					$items .= $markup;
				}
			}
		}

		return $items;
	}

endif;

/**
 * Header toggle buttons
 */
if ( ! function_exists( 'analytica_masthead_toggle_buttons_primary' ) ) {

	/**
	 * Header toggle buttons
	 *
	 * => Used in files:
	 *
	 * /header.php
	 *
	 * @since 1.0.0
	 */
	function analytica_masthead_toggle_buttons_primary() {

		$disable_primary_navigation = analytica_get_option( 'disable-primary-nav' );
		$custom_header_section      = analytica_get_option( 'header-main-rt-section' );
		$display_outside_menu       = analytica_get_option( 'header-display-outside-menu' );

		if ( ! $disable_primary_navigation || ( 'none' != $custom_header_section && ! $display_outside_menu ) ) {
			$menu_title          = trim( apply_filters( 'analytica_main_menu_toggle_label', analytica_get_option( 'header-main-menu-label' ) ) );
			$menu_icon           = apply_filters( 'analytica_main_menu_toggle_icon', 'menu-toggle-icon' );
			$menu_label_class    = '';
			$screen_reader_title = __( 'Main Menu', 'analytica' );
			if ( '' !== $menu_title ) {
				$menu_label_class    = 'ast-menu-label';
				$screen_reader_title = $menu_title;
			}
		?>
		<div class="ast-button-wrap">
			<button type="button" class="menu-toggle main-header-menu-toggle <?php echo esc_attr( $menu_label_class ); ?>" rel="main-menu" aria-controls='primary-menu' aria-expanded='false'>
				<span class="screen-reader-text"><?php echo esc_html( $screen_reader_title ); ?></span>
				<i class="<?php echo esc_attr( $menu_icon ); ?>"></i>
				<?php if ( '' != $menu_title ) { ?>

					<span class="mobile-menu-wrap">
						<span class="mobile-menu"><?php echo esc_html( $menu_title ); ?></span>
					</span>

				<?php } ?>
			</button>
		</div>
	<?php
		}
	}
}

/**
 * Small Footer
 */
if ( ! function_exists( 'analytica_footer_small_footer_template' ) ) {

	/**
	 * Small Footer
	 *
	 * => Used in files:
	 *
	 * /footer.php
	 *
	 * @since 1.0.0
	 */
	function analytica_footer_small_footer_template() {

		$small_footer_layout = analytica_get_option_meta( 'footer-sml-layout', 'footer-sml-layout-2' );
		$small_footer_layout = apply_filters( 'ast_footer_sml_layout', $small_footer_layout );

		if ( 'disabled' != $small_footer_layout ) {

			$small_footer_layout = str_replace( 'footer-sml-layout-', '', $small_footer_layout );

			// Default footer layout 1 is ast-footer-layout.
			if ( '1' == $small_footer_layout ) {
				$small_footer_layout = '';
			}
			get_template_part( 'template-parts/footer/footer-sml-layout', $small_footer_layout );
		}
	}
}

/**
 * Primary Header
 */
if ( ! function_exists( 'analytica_masthead_primary_template' ) ) {

	/**
	 * Primary Header
	 *
	 * => Used in files:
	 *
	 * /header.php
	 *
	 * @since 1.0.0
	 */
	function analytica_masthead_primary_template() {
		get_template_part( 'template-parts/header/header-main-layout' );
	}
}

/**
 * Single post markup
 */
if ( ! function_exists( 'analytica_entry_content_single_template' ) ) {

	/**
	 * Single post markup
	 *
	 * => Used in files:
	 *
	 * /template-parts/content-single.php
	 *
	 * @since 1.0.0
	 */
	function analytica_entry_content_single_template() {
		get_template_part( 'template-parts/single/single-layout' );
	}
}

/**
 * Blog post list markup for blog & search page
 */
if ( ! function_exists( 'analytica_entry_content_blog_template' ) ) {

	/**
	 * Blog post list markup for blog & search page
	 *
	 * => Used in files:
	 *
	 * /template-parts/content-blog.php
	 * /template-parts/content-search.php
	 *
	 * @since 1.0.0
	 */
	function analytica_entry_content_blog_template() {
		get_template_part( 'template-parts/blog/blog-layout' );
	}
}

/**
 * 404 markup
 */
if ( ! function_exists( 'analytica_entry_content_404_page_template' ) ) {

	/**
	 * 404 markup
	 *
	 * => Used in files:
	 *
	 * /template-parts/content-404.php
	 *
	 * @since 1.0.0
	 */
	function analytica_entry_content_404_page_template() {

		$layout_404 = analytica_get_option( 'ast-404-layout' );
		$layout_404 = str_replace( '404-layout-', '', $layout_404 );

		// Default 404 is nothing but the 404 layout 1.
		if ( '1' == $layout_404 ) {
			$layout_404 = '';
		}

		get_template_part( 'template-parts/404/404-layout', $layout_404 );
	}
}

/**
 * Footer widgets markup
 */
if ( ! function_exists( 'analytica_advanced_footer_markup' ) ) {

	/**
	 * Footer widgets markup
	 *
	 * Loads appropriate template file based on the style option selected in options panel.
	 *
	 * @since 1.0.12
	 */
	function analytica_advanced_footer_markup() {

		$advanced_footer_layout = analytica_get_option( 'footer-adv' );
		$advanced_footer_meta   = analytica_get_option_meta( 'footer-adv-display' );

		if ( apply_filters( 'analytica_advanced_footer_disable', false ) || 'layout-4' !== $advanced_footer_layout || 'disabled' == $advanced_footer_meta ) {
			return;
		}

		// Add markup.
		get_template_part( 'template-parts/advanced-footer/layout-4' );
	}
}


/**
 * Header menu item outside custom menu
 */
if ( ! function_exists( 'analytica_header_custom_item_outside_menu' ) ) {

	/**
	 * Footer widgets markup
	 *
	 * Loads appropriate template file based on the style option selected in options panel.
	 *
	 * @since 1.0.12
	 */
	function analytica_header_custom_item_outside_menu() {

		if ( analytica_get_option( 'header-display-outside-menu' ) ) {
			$markup = analytica_masthead_get_menu_items( true );

			echo $markup;
		}
	}
}
