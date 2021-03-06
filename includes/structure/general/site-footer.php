<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @category Analytica
 * @package  Energia
 * @author   Franklin Gitonga
 */

add_action( 'analytica_footer_before', 'analytica_footer_markup_open', 5 );
 /**
  * Echo the opening div tag for the footer.
  *
  * Also optionally adds wrapping div opening tag.
  *
  * @since 1.0.0
  *
  * @uses analytica_markup()          Apply contextual markup.
  */
 function analytica_footer_markup_open() {

     if ( ! analytica_site_footer_is_active() ) {
         return;
     }

     analytica_markup( array(
        'element' => '<div %s>',
        'context' => 'site-footer',
    ) );

 }

 add_action( 'analytica_footer_after', 'analytica_footer_markup_close', 20 );
 /**
  * Echo the closing div tag for the footer.
  *
  * Also optionally adds wrapping div closing tag.
  *
  * @since 1.0.0
  *
  * @uses analytica_markup()          Apply contextual markup.
  */
 function analytica_footer_markup_close() {

    if ( ! analytica_site_footer_is_active() ) {
        return;
    }

    analytica_markup( array(
        'element' => '</div>',
    ));
 }

add_action( 'analytica_footer', 'analytica_footer_menu_area', 17 );
/**
 * Echo the opening div tag for the footer.
 *
 * Also optionally adds wrapping div opening tag.
 *
 * @since 1.0.0
 *
 * @uses analytica_markup()          Apply contextual markup.
 */
function analytica_footer_menu_area() {

    if ( ! analytica_site_footer_is_active() || ! has_nav_menu( 'footer-menu' ) ) {
        return;
    }

    analytica_markup( array(
        'element' => '<div %s>',
        'context' => 'site-footer-menu',
    ));

    do_action( 'analytica_footer_menu' );

    analytica_markup( array(
        'element' => '</div>',
    ));
}

add_action( 'analytica_footer', 'analytica_footer_widget_areas' );
/**
 * Echo the markup necessary to facilitate the footer widget areas.
 *
 * Check for a numerical parameter given when adding theme support - if none is found, then the function returns early.
 *
 * The child theme must style the widget areas.
 *
 * Applies the `analytica_footer_widget_areas` filter.
 *
 * @since 1.0.0
 */
function analytica_footer_widget_areas() {

    if ( ! analytica_site_footer_is_active() || ! analytica_site_footer_has_widgets() ) {
        return;
    }

    // Get footer layout
    $layout = analytica_get_option( 'site-footer-layout' );
    $container_class = ( ! analytica_get_option( 'site-footer-width' ) ) ? 'site-footer-boxed has-container' : 'site-footer-fullwidth';

    $inside = '';
    $output = '';

    // Get sidebar
    $sidebar_1 = 'footer-1';
    $sidebar_2 = 'footer-2';
    $sidebar_3 = 'footer-3';
    $sidebar_4 = 'footer-4';
    $sidebar_5 = 'footer-5';

    $sidebar_before_footer_widget   = analytica_get_option( 'sidebar-before-footer-widget' );
    $sidebar_after_footer_widget    = analytica_get_option( 'sidebar-after-footer-widget' );

    if ( ! empty( $sidebar_before_footer_widget ) && is_active_sidebar( $sidebar_before_footer_widget ) ) :
        $inside .= '<div class="sidebar-before-footer">';
            $inside .= '<div class="' . $container_class . '">';
                $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_before_footer_widget );
            $inside .= '</div>';
        $inside .= '</div>';
    endif;

    if ( is_active_sidebar( $sidebar_1 ) || is_active_sidebar( $sidebar_2, $layout ) || is_active_sidebar( $sidebar_3, $layout ) || is_active_sidebar( $sidebar_4, $layout ) || is_active_sidebar( $sidebar_5, $layout ) ) :
		$inside .= '<div class="site-footer-top">';
			$inside .= '<div class="site-footer-top-inner">';
                $inside .= '<div class="' . $container_class . '">';
                    $inside .= '<div class="analytica-row">';

						switch( $layout ) :
							case 'layout-1' :
								$inside .= '<div class="analytica-col-md-12">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
								$inside .= '</div>';
								break;

							case 'layout-2' :
								$inside .= '<div class="analytica-col-md-6 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
								$inside .= '</div>';
								$inside .= '<div class="analytica-col-md-6 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
								$inside .= '</div>';
								break;

							case 'layout-3' :
								$inside .= '<div class="analytica-col-md-4 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
								$inside .= '</div>';
								$inside .= '<div class="analytica-col-md-4 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
                                $inside .= '</div>';
                                if ( wp_is_mobile() ) {
                                    $inside .= '<div class="clearfix visible-xs"></div>';
                                }
								$inside .= '<div class="analytica-col-md-4 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_3, $layout );
								$inside .= '</div>';
								break;

							case 'layout-4' :
								$inside .= '<div class="analytica-col-md-3 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
								$inside .= '</div>';
								$inside .= '<div class="analytica-col-md-3 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
                                $inside .= '</div>';
                                if ( wp_is_mobile() ) {
                                    $inside .= '<div class="clearfix visible-xs"></div>';
                                }
								$inside .= '<div class="analytica-col-md-3 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_3, $layout );
								$inside .= '</div>';
                                $inside .= '<div class="analytica-col-md-3 analytica-col-xs-6">';
                                    $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_4, $layout );
                                $inside .= '</div>';

								break;

							case 'layout-5' :
								$inside .= '<div class="analytica-col-md-9 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
								$inside .= '</div>';
								$inside .= '<div class="analytica-col-md-3 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
								$inside .= '</div>';
								break;

							case 'layout-6' :
								$inside .= '<div class="analytica-col-md-6 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
								$inside .= '</div>';
								$inside .= '<div class="analytica-col-md-3 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
                                $inside .= '</div>';
                                if ( wp_is_mobile() ) {
                                    $inside .= '<div class="clearfix visible-xs"></div>';
                                }
								$inside .= '<div class="analytica-col-md-3 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_3, $layout );
								$inside .= '</div>';
								break;

                            case 'layout-7' :
                                $inside .= '<div class="analytica-col-md-3 analytica-col-xs-6">';
                                    $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
                                $inside .= '</div>';
                                $inside .= '<div class="analytica-col-md-6 analytica-col-xs-6">';
                                    $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
                                $inside .= '</div>';
                                if ( wp_is_mobile() ) {
                                    $inside .= '<div class="clearfix visible-xs"></div>';
                                }
                                $inside .= '<div class="analytica-col-md-3 analytica-col-xs-6">';
                                    $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_3, $layout );
                                $inside .= '</div>';
                                break;

							case 'layout-8' :
								$inside .= '<div class="analytica-col-md-4 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
								$inside .= '</div>';
								$inside .= '<div class="analytica-col-md-8 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
								$inside .= '</div>';
								break;

							case 'layout-9' :
								$inside .= '<div class="analytica-col-md-3 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
								$inside .= '</div>';
								$inside .= '<div class="analytica-col-md-3 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
                                $inside .= '</div>';
                                if ( wp_is_mobile() ) {
                                    $inside .= '<div class="clearfix visible-xs"></div>';
                                }
								$inside .= '<div class="analytica-col-md-6 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_3, $layout );
								$inside .= '</div>';
								break;

                            case 'layout-10' :
								$inside .= '<div class="analytica-col-md-2-4 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
								$inside .= '</div>';
								$inside .= '<div class="analytica-col-md-2-4 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
                                $inside .= '</div>';
                                if ( wp_is_mobile() ) {
                                    $inside .= '<div class="clearfix visible-xs"></div>';
                                }
								$inside .= '<div class="analytica-col-md-2-4 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_3, $layout );
								$inside .= '</div>';
                                $inside .= '<div class="analytica-col-md-2-4 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_4, $layout );
                                $inside .= '</div>';
                                if ( wp_is_mobile() ) {
                                    $inside .= '<div class="clearfix visible-xs"></div>';
                                }
								$inside .= '<div class="analytica-col-md-2-4 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_5, $layout );
								$inside .= '</div>';
								break;

                            case 'layout-11' :

                                    $inside .= '<div class="analytica-col-md-4 analytica-col-xs-6">';
                                        $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
                                    $inside .= '</div>';

                                    if ( ! wp_is_mobile() ) {
                                        $inside .= '<div class="analytica-col-md-8 analytica-col-xs-6">';
                                        $inside .= '<div class="row">';
                                    }
                                            $inside .= '<div class="analytica-col-md-4 analytica-col-xs-6">';
                                                $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
                                            $inside .= '</div>';

                                            if ( wp_is_mobile() ) {
                                                $inside .= '<div class="clearfix visible-xs"></div>';
                                            }

                                            $inside .= '<div class="analytica-col-md-4 analytica-col-xs-6">';
                                                $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_3, $layout );
                                            $inside .= '</div>';
                                            $inside .= '<div class="analytica-col-md-4 analytica-col-xs-6">';
                                                $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_4, $layout );
                                            $inside .= '</div>';

                                    if ( ! wp_is_mobile() ) {
                                        $inside .= '</div>';
                                        $inside .= '</div>';
                                    }
                                break;

                            case 'layout-12' :

                                if ( wp_is_mobile() ) {
                                    $inside .= '<div class="analytica-col-md-8 analytica-col-xs-6">';
                                    $inside .= '<div class="row">';
                                }

                                $inside .= '<div class="analytica-col-md-4 analytica-col-xs-6">';
                                    $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
                                $inside .= '</div>';
                                $inside .= '<div class="analytica-col-md-4 analytica-col-xs-6">';
                                    $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
                                $inside .= '</div>';

                                if ( wp_is_mobile() ) {
                                    $inside .= '<div class="clearfix visible-xs"></div>';
                                }

                                $inside .= '<div class="analytica-col-md-4 analytica-col-xs-6">';
                                    $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_3, $layout );
                                $inside .= '</div>';

                                if ( ! wp_is_mobile() ) {
                                        $inside .= '</div>';
                                    $inside .= '</div>';
                                }

                                $inside .= '<div class="analytica-col-md-4 analytica-col-xs-6">';
                                    $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_4, $layout );
                                $inside .= '</div>';

								break;
							default :
								$inside .= '<div class="analytica-col-md-3 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
								$inside .= '</div>';
								$inside .= '<div class="analytica-col-md-3 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
                                $inside .= '</div>';
                                if ( wp_is_mobile() ) {
                                    $inside .= '<div class="clearfix visible-xs"></div>';
                                }
								$inside .= '<div class="analytica-col-md-3 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_3, $layout );
								$inside .= '</div>';
								$inside .= '<div class="analytica-col-md-3 analytica-col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_4, $layout );
								$inside .= '</div>';
								break;
						endswitch;

                        $inside .= '</div><!-- .row -->';
				$inside .= '</div><!-- .analytica-row -->';
			$inside .= '</div><!-- .site-footer-top-inner -->';
		$inside .= '</div>';
	endif;

    if ( ! empty( $sidebar_after_footer_widget ) && is_active_sidebar( $sidebar_after_footer_widget ) ) :
        $inside .= '<div class="sidebar-after-footer">';
            $inside .= '<div class="' . $container_class . '">';
                $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_after_footer_widget );
            $inside .= '</div>';
        $inside .= '</div>';
    endif;

    if ( $inside ) {

        $output .= analytica_markup(array(
            'element' => '<div %s>',
            'context' => 'site-footer-widgets',
        ));

        $output .= analytica_structural_wrap( 'site-footer', 'open', false );

        $output .= $inside;

        $output .= analytica_structural_wrap( 'site-footer', 'close', false  );

        $output .= '</div>';
    }

    echo $output; // escaping not needed here. Output is html and escaped elsewhere
}

/**
 * Load footer widget
 *
 * @return [type] [description]
 */
function analytica_get_dynamic_footer_sidebar( $sidebar, $layout ) {

    $inside = '';

    // Darn you, WordPress! Gotta output buffer.
    ob_start();
    dynamic_sidebar( $sidebar );
    $widgets = ob_get_clean();

    $inside .= sprintf( '<div class="footer-widgets-%s widget-area widget-%s">%s</div>', $layout, $sidebar, $widgets );
    return $inside;

}

add_action( 'analytica_do_colophon', 'analytica_colophon_content', 15 );
/**
 * Get colophon content
 *
 * @since 1.0.0
 */
function analytica_colophon_content() {
    $output = $theme_credits = $site_copyright = null;

    if ( analytica_get_option( 'site-footer-copyright-text' ) ) {
        $site_copyright = sprintf( '<div class="site-copyright">%s</div>', str_replace( '[year]', date( 'Y' ), analytica_get_option( 'site-footer-copyright-text' ) ) );
    }

    if ( analytica_get_option( 'site-theme-badge' ) ) {
        $theme_credits = '<div class="theme-credits">'. esc_html__( 'Powered by', 'analytica' ) .' <a href="https://qazana.net/" target="_blank">' . analytica()->theme_title .'</a> <span>and</span> WordPress.</div>';
    }

    if ( $site_copyright || $theme_credits ) {
        $output = '<div class="site-creds" role="contentinfo">' . $site_copyright . $theme_credits . '</div>';
    }

    echo wp_kses( apply_filters( __FUNCTION__, $output ), analytica_get_allowed_tags() );

}

add_action( 'analytica_footer', 'analytica_do_colophon', 20 );
/**
 * Echo the contents of the colophon.
 *
 * Applies 'analytica_footer_creds_text' and 'analytica_footer_output' filters.
 *
 * For HTML5 themes, only the credits text is used.
 *
 * @since 1.0.0
 */
function analytica_do_colophon() {

    if ( ! analytica_is_site_colophon_available() ) {
        return;
    }

    analytica_markup( array(
        'element' => '<footer %s>',
        'context' => 'site-colophon',
    ) );

   analytica_structural_wrap( 'site-footer', 'open' );

    do_action( 'analytica_do_colophon' );

    analytica_structural_wrap( 'site-footer', 'close' );

    analytica_markup( array(
        'element' => '</footer>',
    ) );
}
