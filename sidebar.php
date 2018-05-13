<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Analytica
 * @since 1.0.0
 */

$sidebar = apply_filters( 'analytica_get_sidebar', 'sidebar-1' );
?>

<div itemtype="https://schema.org/WPSideBar" itemscope="itemscope" id="secondary" <?php analytica_secondary_class(); ?> role="complementary">

	<div class="sidebar-main">

		<?php do_action( 'analytica_sidebars_before' ); ?>

		<?php if ( is_active_sidebar( $sidebar ) ) : ?>

			<?php dynamic_sidebar( $sidebar ); ?>

		<?php endif; ?>

		<?php do_action( 'analytica_sidebars_after' ); ?>

	</div><!-- .sidebar-main -->
</div><!-- #secondary -->
<?php

//* Output primary sidebar structure
analytica_markup( array(
    'element'   => '<aside %s><div class="widget-area-inner">',
    'context' => 'sidebar-primary',
) );

do_action( 'analytica_before_sidebar_widget_area' );
do_action( 'analytica_sidebar' );
do_action( 'analytica_after_sidebar_widget_area' );

analytica_markup( array(
    'element' => '</div></aside>', //* end .sidebar-primary
) );
