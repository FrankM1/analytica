<?php
/**
 * This file is a part of the analytica Framework core.
 * Please be cautious editing this file,
 *
 * @category analytica\Framework
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     https://qazana.net/
 */

 /**
  * Template for default widget area content.
  *
  * @since 1.0.0
  *
  * @param string $name Name of the widget area e.g. `esc_html__( 'Secondary Widget Area', 'analytica' )`.
  */
 function analytica_default_widget_area_content( $name ) {

     echo '<div class="analytica-qazana-widget widget widget_text">';
     echo '<div class="widget-wrap">';

         printf( '<div class="section-title"><h5 class="widget-title"><span>%s</span></h5></div>', esc_html( $name ) );
         echo '<div class="textwidget"><p>';
            echo esc_html__( 'This is the', 'analytica' ) . ' ' . esc_html( $name ) . '. ' . esc_html__( 'You can add content to this area by visiting your', 'analytica' ) . ' <a href="' . esc_url( admin_url( 'widgets.php' ) ) . '">' . esc_html__( 'Widgets Panel', 'analytica' ) . ' </a> ' . esc_html__( 'and adding new widgets to this area.', 'analytica' );
         echo '</p></div>';

     echo '</div>';
     echo '</div>';

 }

 add_action( 'analytica_sidebar', 'analytica_do_sidebar' );
 /**
  * Echo primary sidebar default content.
  *
  * Only shows if sidebar is empty, and current user has the ability to edit theme options (manage widgets).
  *
  * @since 1.0.0
  *
  * @uses analytica_default_widget_area_content() Template for default widget are content.
  */
 function analytica_do_sidebar() {

     if ( ! dynamic_sidebar( 'sidebar' ) && current_user_can( 'edit_theme_options' ) ) {
         analytica_default_widget_area_content( esc_html__( 'Primary Widget Area', 'analytica' ) );
     }

 }

 add_action( 'analytica_sidebar_alt', 'analytica_do_sidebar_alt' );
 /**
  * Echo alternate sidebar default content.
  *
  * Only shows if sidebar is empty, and current user has the ability to edit theme options (manage widgets).
  *
  * @since 1.0.0
  *
  * @uses analytica_default_widget_area_content() Template for default widget are content.
  */
 function analytica_do_sidebar_alt() {

     if ( ! dynamic_sidebar( 'sidebar-alt' ) && current_user_can( 'edit_theme_options' ) ) {
         analytica_default_widget_area_content( esc_html__( 'Secondary Widget Area', 'analytica' ) );
     }

 }

add_action( 'analytica_left_sidebar', 'analytica_get_sidebar' );
/**
 * Output the sidebar.php file if layout allows for it.
 *
 * @since 1.0.0
 *
 * @uses analytica_site_layout() Return the site layout for different contexts.
 */
function analytica_get_sidebar() {

    $site_layout = analytica_site_layout();

    // Don't load sidebar on pages that don't need it
    if ( _analytica_return_full_width_content() === $site_layout ) {
        return;
    }

    get_sidebar();

}

add_action( 'analytica_right_sidebar', 'analytica_get_sidebar_alt' );
/**
 * Output the sidebar_alt.php file if layout allows for it.
 *
 * @since 1.0.0
 *
 * @uses analytica_site_layout() Return the site layout for different contexts.
 */
function analytica_get_sidebar_alt() {

    $site_layout = analytica_site_layout();

    // Don't load sidebar-alt on pages that don't need it
    if ( in_array( $site_layout, array( _analytica_return_content_sidebar(), _analytica_return_sidebar_content(), _analytica_return_full_width_content() ) ) ) {
        return;
    }

    get_sidebar( 'alt' );

}
