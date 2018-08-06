<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Analytica
 * @since 1.0.0
 */
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
