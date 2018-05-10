<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @category Radium\Framework
 * @package  Energia
 * @author   Franklin Gitonga
 */

add_action( 'analytica_before_footer', 'analytica_footer_markup_open', 5 );
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

     if ( ! analytica_is_footer_available() ) {
         return;
     }

     analytica_markup( array(
        'html5' => '<div %s>',
        'context' => 'site-footer',
    ) );

 }

 add_action( 'analytica_after_footer', 'analytica_footer_markup_close', 20 );
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

     if ( ! analytica_is_footer_available() ) {
         return;
     }

    analytica_markup( array(
        'html5' => '</div>',
    ));
 }

 if ( has_nav_menu( 'footer-menu' ) ) {
     add_action( 'analytica_footer', 'analytica_footer_menu_area', 17 );
 }
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

    if ( ! analytica_is_footer_available() ) {
        return;
    }

    analytica_markup( array(
        'html5' => '<div %s>',
        'context' => 'footer-menu',
    ));

    do_action( 'analytica_footer_menu' );

    analytica_markup( array(
        'html5' => '</div>',
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

    if ( ! analytica_is_footer_available() || ! analytica_footer_has_widgets() ) {
        return;
    }

    // Get footer layout
    $layout = analytica_get_option( 'site_footer_layout' );
    $container_class = analytica_get_option( 'footer-width' ) ? 'full-width' : 'container';

    $inside = '';
    $output = '';

    // Get sidebar
    $sidebar_1 = 'footer-1';
    $sidebar_2 = 'footer-2';
    $sidebar_3 = 'footer-3';
    $sidebar_4 = 'footer-4';
    $sidebar_5 = 'footer-5';

    $sidebar_before_footer_widget   = analytica_get_option( 'sidebar_before_footer_widget' );
    $sidebar_after_footer_widget    = analytica_get_option( 'sidebar_after_footer_widget' );

    if ( ! empty( $sidebar_before_footer_widget ) && is_active_sidebar( $sidebar_before_footer_widget ) ) :
        $inside .= '<div class="sidebar-before-footer">';
            $inside .= '<div class="' . $container_class . '">';
                $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_before_footer_widget );
            $inside .= '</div>';
        $inside .= '</div>';
    endif;

    if ( is_active_sidebar( $sidebar_1 ) || is_active_sidebar( $sidebar_2, $layout ) || is_active_sidebar( $sidebar_3, $layout ) || is_active_sidebar( $sidebar_4, $layout ) || is_active_sidebar( $sidebar_5, $layout ) ) :
		$inside .= '<div class="top">';
			$inside .= '<div class="top-inner">';
                $inside .= '<div class="' . $container_class . '">';
                    $inside .= '<div class="site-footer-row">';

						switch( $layout ) :
							case 'layout-1' :
								$inside .= '<div class="col-md-12">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
								$inside .= '</div>';
								break;

							case 'layout-2' :
								$inside .= '<div class="col-md-6 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
								$inside .= '</div>';
								$inside .= '<div class="col-md-6 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
								$inside .= '</div>';
								break;

							case 'layout-3' :
								$inside .= '<div class="col-md-4 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
								$inside .= '</div>';
								$inside .= '<div class="col-md-4 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
                                $inside .= '</div>';
                                if ( analytica_is_mobile() ) {
                                    $inside .= '<div class="clearfix visible-xs"></div>';
                                }
								$inside .= '<div class="col-md-4 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_3, $layout );
								$inside .= '</div>';
								break;

							case 'layout-4' :
								$inside .= '<div class="col-md-3 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
								$inside .= '</div>';
								$inside .= '<div class="col-md-3 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
                                $inside .= '</div>';
                                if ( analytica_is_mobile() ) {
                                    $inside .= '<div class="clearfix visible-xs"></div>';
                                }
								$inside .= '<div class="col-md-3 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_3, $layout );
								$inside .= '</div>';
                                $inside .= '<div class="col-md-3 col-xs-6">';
                                    $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_4, $layout );
                                $inside .= '</div>';

								break;

							case 'layout-5' :
								$inside .= '<div class="col-md-9 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
								$inside .= '</div>';
								$inside .= '<div class="col-md-3 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
								$inside .= '</div>';
								break;

							case 'layout-6' :
								$inside .= '<div class="col-md-6 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
								$inside .= '</div>';
								$inside .= '<div class="col-md-3 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
                                $inside .= '</div>';
                                if ( analytica_is_mobile() ) {
                                    $inside .= '<div class="clearfix visible-xs"></div>';
                                }
								$inside .= '<div class="col-md-3 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_3, $layout );
								$inside .= '</div>';
								break;

                            case 'layout-7' :
                                $inside .= '<div class="col-md-3 col-xs-6">';
                                    $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
                                $inside .= '</div>';
                                $inside .= '<div class="col-md-6 col-xs-6">';
                                    $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
                                $inside .= '</div>';
                                if ( analytica_is_mobile() ) {
                                    $inside .= '<div class="clearfix visible-xs"></div>';
                                }
                                $inside .= '<div class="col-md-3 col-xs-6">';
                                    $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_3, $layout );
                                $inside .= '</div>';
                                break;

							case 'layout-8' :
								$inside .= '<div class="col-md-4 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
								$inside .= '</div>';
								$inside .= '<div class="col-md-8 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
								$inside .= '</div>';
								break;

							case 'layout-9' :
								$inside .= '<div class="col-md-3 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
								$inside .= '</div>';
								$inside .= '<div class="col-md-3 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
                                $inside .= '</div>';
                                if ( analytica_is_mobile() ) {
                                    $inside .= '<div class="clearfix visible-xs"></div>';
                                }
								$inside .= '<div class="col-md-6 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_3, $layout );
								$inside .= '</div>';
								break;

                            case 'layout-10' :
								$inside .= '<div class="col-md-2-4 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
								$inside .= '</div>';
								$inside .= '<div class="col-md-2-4 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
                                $inside .= '</div>';
                                if ( analytica_is_mobile() ) {
                                    $inside .= '<div class="clearfix visible-xs"></div>';
                                }
								$inside .= '<div class="col-md-2-4 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_3, $layout );
								$inside .= '</div>';
                                $inside .= '<div class="col-md-2-4 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_4, $layout );
                                $inside .= '</div>';
                                if ( analytica_is_mobile() ) {
                                    $inside .= '<div class="clearfix visible-xs"></div>';
                                }
								$inside .= '<div class="col-md-2-4 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_5, $layout );
								$inside .= '</div>';
								break;

                            case 'layout-11' :

                                    $inside .= '<div class="col-md-4 col-xs-6">';
                                        $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
                                    $inside .= '</div>';

                                    if ( ! analytica_is_mobile() ) {
                                        $inside .= '<div class="col-md-8 col-xs-6">';
                                        $inside .= '<div class="row">';
                                    }
                                            $inside .= '<div class="col-md-4 col-xs-6">';
                                                $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
                                            $inside .= '</div>';

                                            if ( analytica_is_mobile() ) {
                                                $inside .= '<div class="clearfix visible-xs"></div>';
                                            }

                                            $inside .= '<div class="col-md-4 col-xs-6">';
                                                $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_3, $layout );
                                            $inside .= '</div>';
                                            $inside .= '<div class="col-md-4 col-xs-6">';
                                                $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_4, $layout );
                                            $inside .= '</div>';

                                    if ( ! analytica_is_mobile() ) {
                                        $inside .= '</div>';
                                        $inside .= '</div>';
                                    }
                                break;

                            case 'layout-12' :

                                if ( analytica_is_mobile() ) {
                                    $inside .= '<div class="col-md-8 col-xs-6">';
                                    $inside .= '<div class="row">';
                                }

                                $inside .= '<div class="col-md-4 col-xs-6">';
                                    $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
                                $inside .= '</div>';
                                $inside .= '<div class="col-md-4 col-xs-6">';
                                    $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
                                $inside .= '</div>';

                                if ( analytica_is_mobile() ) {
                                    $inside .= '<div class="clearfix visible-xs"></div>';
                                }

                                $inside .= '<div class="col-md-4 col-xs-6">';
                                    $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_3, $layout );
                                $inside .= '</div>';

                                if ( ! analytica_is_mobile() ) {
                                        $inside .= '</div>';
                                    $inside .= '</div>';
                                }

                                $inside .= '<div class="col-md-4 col-xs-6">';
                                    $inside .= analytica_get_dynamic_footer_sidebar( $sidebar_4, $layout );
                                $inside .= '</div>';

								break;
							default :
								$inside .= '<div class="col-md-3 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_1, $layout );
								$inside .= '</div>';
								$inside .= '<div class="col-md-3 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_2, $layout );
                                $inside .= '</div>';
                                if ( analytica_is_mobile() ) {
                                    $inside .= '<div class="clearfix visible-xs"></div>';
                                }
								$inside .= '<div class="col-md-3 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_3, $layout );
								$inside .= '</div>';
								$inside .= '<div class="col-md-3 col-xs-6">';
									$inside .= analytica_get_dynamic_footer_sidebar( $sidebar_4, $layout );
								$inside .= '</div>';
								break;
						endswitch;

                        $inside .= '</div><!-- .row -->';
				$inside .= '</div><!-- .container -->';
			$inside .= '</div><!-- .top-inner -->';
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
            'html5' => '<div %s>',
            'context' => 'footer-widgets',
        ));

        $output .= $inside;

        $output .= '</div>';
    }

    echo apply_filters( 'analytica_footer_widget_areas', $output );
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

add_action( 'analytica_after_footer', 'analytica_back_to_top', 99 );
/**
 * Add theme credits
 *
 * @since 1.0.0
 */
function analytica_back_to_top() {

    // Filter the text strings
    $backtotop_text = apply_filters( 'analytica_footer_backtotop_text', '<a href="#site-container" rel="nofollow">'. esc_html__( 'Back to top', 'analytica' ) .'</a>' );

    $backtotop = $backtotop_text && analytica_get_option( 'footer-back-to-top' ) ? sprintf( '<div id="gototop"><div class="cross"><span class="bloc-h"></span><span class="bloc-v"></span></div><span class="ricon-arrow-top"></span>%s</div>', $backtotop_text ) : '';

    echo apply_filters( __FUNCTION__, $backtotop );

}

add_action( 'analytica_footer', 'analytica_footer_markup' );
/**
 * Site Footer - <footer>
 *
 * @since 1.0.0
 */
function analytica_footer_markup() {
    ?>

    <footer itemtype="https://schema.org/WPFooter" itemscope="itemscope" id="colophon" <?php analytica_footer_classes(); ?> role="contentinfo"><?php

	    do_action( 'analytica_footer_content_top' );

	    do_action( 'analytica_footer_content' );

	    do_action( 'analytica_footer_content_bottom' );

    ?></footer><!-- #colophon -->
    <?php
}

add_action( 'analytica_do_colophon', 'analytica_colophon_content', 15 );
/**
 * Get colophon content
 *
 * @since 1.0.0
 */
function analytica_colophon_content() {

    $core = analytica();

    $creds_text = str_replace( '[year]', date( 'Y' ), analytica_get_option( 'footer-copyright-text' ) );

    $site_copyright = $creds_text ? sprintf( '<div class="site-copyright">%s</div>', $creds_text ) : '';

    $theme_credits = analytica_get_option( 'show-theme-badge' ) ? '<div class="theme-credits">'. esc_html__( 'Powered by', 'analytica' ) .' <a href="'. esc_url( $core->theme_page_url ) .'" target="_blank">' . $core->theme_title .'</a> <span>and</span> WordPress.</div>': '';

    $output = $site_copyright || $theme_credits ? '<div class="site-creds" role="contentinfo">' . $site_copyright . $theme_credits . '</div>' : '';

    echo apply_filters( __FUNCTION__, $output );

}

add_action( 'analytica_footer', 'analytica_do_colophon', 20 );
/**
 * Echo the contents of the colophon.
 *
 * Applies 'analytica_footer_backtotop_text', 'analytica_footer_creds_text' and 'analytica_footer_output' filters.
 *
 * For HTML5 themes, only the credits text is used (back-to-top link is dropped).
 *
 * @since 1.0.0
 */
function analytica_do_colophon() {

    if ( ! analytica_is_colophon_available() ) {
        return;
    }

    analytica_markup( array(
        'html5' => '<footer %s>',
        'context' => 'site-colophon',
    ) );

    do_action( 'analytica_do_colophon' );

    analytica_markup( array(
        'html5' => '</footer>',
    ) );
}

add_filter( 'analytica_footer_scripts', 'do_shortcode' );
add_action( 'wp_footer', 'analytica_footer_scripts' );
/**
 * Echo the footer scripts, defined in Theme Settings.
 *
 * Applies the 'analytica_footer_scripts' filter to the value returns from the footer_scripts option.
 *
 * @since 1.0.0
 *
 * @uses analytica_get_option() Get theme setting value.
 */
function analytica_footer_scripts() {
    echo apply_filters( 'analytica_footer_scripts', analytica_get_option( 'footer-custom-scripts' ) );
}

add_filter( 'admin_footer_text', 'analytica_footer_admin' );
/**
 * Admin Footer Credits.
 *
 * @since 1.0.0
 */
function analytica_footer_admin() {
    echo esc_html__( 'Thank you for theming with', 'analytica' ) . ' <a href="' . esc_url( analytica()->theme_main_site_url ) . '" target="blank">Qazana</a>.';
}

add_action( 'analytica_after_footer', 'analytica_before_markup_globals', 99 );
/**
 * Global Markup Used by ajax alerts.
 *
 * @since 1.0.0
 */
function analytica_before_markup_globals() {
    ?><div id="global-loading" class="loading-dots"><span class="dot-1"></span><span class="dot-2"></span><span class="dot-3"></span></div><div id="global-alert" class="alert alert-message"></div><?php
}
