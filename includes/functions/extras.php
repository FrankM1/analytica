<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       Analytica 1.0.0
 */

add_action( 'wp_head', 'analytica_pingback_header' );
/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function analytica_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

/**
 * Adds schema tags to the body classes.
 *
 * @since 1.0.0
 */
function analytica_schema_body() {

    // Check conditions.
    $is_blog = ( is_home() || is_archive() || is_attachment() || is_tax() || is_single() ) ? true : false;

    // Set up default itemtype.
    $itemtype = 'WebPage';

    // Get itemtype for the blog.
    $itemtype = ( $is_blog ) ? 'Blog' : $itemtype;

    // Get itemtype for search results.
    $itemtype = ( is_search() ) ? 'SearchResultsPage' : $itemtype;
    // Get the result.
    $result = apply_filters( 'analytica_schema_body_itemtype', $itemtype );

    // Return our HTML.
    echo apply_filters( 'analytica_schema_body', "itemtype='https://schema.org/" . esc_html( $result ) . "' itemscope='itemscope'" );
}

add_filter( 'body_class', 'analytica_body_classes' );
/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0.0
 * @param array $classes Classes for the body element.
 * @return array
 */
function analytica_body_classes( $classes ) {

    if ( wp_is_mobile() ) {
        $classes[] = 'ast-header-break-point';
    }

    // Apply separate container class to the body.
    $content_layout = analytica_get_content_layout();
    if ( 'content-boxed-container' == $content_layout ) {
        $classes[] = 'ast-separate-container';
    } elseif ( 'boxed-container' == $content_layout ) {
        $classes[] = 'ast-separate-container ast-two-container';
    } elseif ( 'page-builder' == $content_layout ) {
        $classes[] = 'ast-page-builder-template';
    } elseif ( 'plain-container' == $content_layout ) {
        $classes[] = 'ast-plain-container';
    }
    // Sidebar location.
    $page_layout = 'ast-' . analytica_page_layout();
    $classes[]   = esc_attr( $page_layout );

    $theme            = wp_get_theme();         // Get Theme data (WP 3.4+)
    $theme_version    = $theme->version;  // Theme version

    // Current Analytica verion.
    $classes[] = esc_attr( 'analytica-' . $theme_version );

    $outside_menu = analytica_get_option( 'header-display-outside-menu' );

    if ( $outside_menu ) {
        $classes[] = 'ast-header-custom-item-outside';
    } else {
        $classes[] = 'ast-header-custom-item-inside';
    }

    return $classes;
}

add_action( 'analytica_pagination', 'analytica_number_pagination' );
/**
 * Analytica Pagination
 *
 * @since 1.0.0
 * @return void            Generate & echo pagination markup.
 */
function analytica_number_pagination() {
    global $numpages;
    $enabled = apply_filters( 'analytica_pagination_enabled', true );

    if ( isset( $numpages ) && $enabled ) {
        ob_start();
        echo "<div class='ast-pagination'>";
        the_posts_pagination(
            array(
                'prev_text'    => analytica_default_strings( 'string-blog-navigation-previous', false ),
                'next_text'    => analytica_default_strings( 'string-blog-navigation-next', false ),
                'taxonomy'     => 'category',
                'in_same_term' => true,
            )
        );
        echo '</div>';
        $output = ob_get_clean();
        echo apply_filters( 'analytica_pagination_markup', $output ); // WPCS: XSS OK.
    }
}

/**
 * Return or echo site logo markup.
 *
 * @since 1.0.0
 * @param  boolean $echo Echo markup.
 * @return mixed echo or return markup.
 */
function analytica_logo( $echo = true ) {

    $display_site_tagline = analytica_get_option( 'display-site-tagline' );
    $display_site_title   = analytica_get_option( 'display-site-title' );
    $html                 = '';

    $has_custom_logo = apply_filters( 'analytica_has_custom_logo', has_custom_logo() );

    // Site logo.
    if ( $has_custom_logo ) {

        if ( apply_filters( 'analytica_replace_logo_width', true ) ) {
            add_filter( 'wp_get_attachment_image_src', 'analytica_replace_header_logo', 10, 4 );
        }

        $html .= '<span class="site-logo-img">';
        $html .= get_custom_logo();
        $html .= '</span>';

        if ( apply_filters( 'analytica_replace_logo_width', true ) ) {
            remove_filter( 'wp_get_attachment_image_src', 'analytica_replace_header_logo', 10 );
        }
    }

    if ( ! apply_filters( 'analytica_disable_site_identity', false ) ) {

        // Site Title.
        $tag = 'span';
        if ( is_home() || is_front_page() ) {
            $tag = 'h1';
        }

        /**
         * Filters the tags for site title.
         *
         * @since 1.3.1
         *
         * @param string $tags string containing the HTML tags for Site Title.
         */
        $tag               = apply_filters( 'analytica_site_title_tag', $tag );
        $site_title_markup = '<' . $tag . ' itemprop="name" class="site-title"> <a href="' . esc_url( home_url( '/' ) ) . '" itemprop="url" rel="home">' . get_bloginfo( 'name' ) . '</a> </' . $tag . '>';

        // Site Description.
        $site_tagline_markup = '<p class="site-description" itemprop="description">' . get_bloginfo( 'description' ) . '</p>';

        if ( $display_site_title || $display_site_tagline ) {
            /* translators: 1: Site Title Markup, 2: Site Tagline Markup */
            $html .= sprintf(
                '<div class="ast-site-title-wrap">
                        %1$s
                        %2$s
                    </div>',
                ( $display_site_title ) ? $site_title_markup : '',
                ( $display_site_tagline ) ? $site_tagline_markup : ''
            );
        }
    }
    $html = apply_filters( 'analytica_logo', $html, $display_site_title, $display_site_tagline );

    /**
     * Echo or Return the Logo Markup
     */
    if ( $echo ) {
        echo $html;
    } else {
        return $html;
    }
}

/**
 * Return the selected sections
 *
 * @since 1.0.0
 * @param  string $option Custom content type. E.g. search, text-html etc.
 * @return array         Array of Custom contents.
 */
function analytica_get_dynamic_header_content( $option ) {

    $output  = array();
    $section = analytica_get_option( $option );

    switch ( $section ) {

        case 'search':
                $output[] = analytica_get_search( $option );
            break;

        case 'text-html':
                $output[] = analytica_get_custom_html( $option . '-html' );
            break;

        case 'widget':
                $output[] = analytica_get_custom_widget( $option );
            break;

        default:
                $output[] = apply_filters( 'analytica_get_dynamic_header_content', '', $option, $section );
            break;
    }

    return $output;
}

/**
 * Adding Wrapper for Search Form.
 *
 * @since 1.0.0
 * @param  string $option   Search Option name.
 * @return mixed Search HTML structure created.
 */
function analytica_get_search( $option = '' ) {

    $search_html  = '<div class="ast-search-icon"><a class="slide-search analytica-search-icon" href="#"><span class="screen-reader-text">' . esc_html__( 'Search', 'analytica' ) . '</span></a></div>
                    <div class="ast-search-menu-icon slide-search" id="ast-search-form" >';
    $search_html .= get_search_form( false );
    $search_html .= '</div>';

    return apply_filters( 'analytica_get_search', $search_html, $option );
}

/**
 * Get custom HTML added by user.
 *
 * @since 1.0.0
 * @param  string $option_name Option name.
 * @return String TEXT/HTML added by user in options panel.
 */
function analytica_get_custom_html( $option_name = '' ) {

    $custom_html         = '';
    $custom_html_content = analytica_get_option( $option_name );

    if ( ! empty( $custom_html_content ) ) {
        $custom_html = '<div class="ast-custom-html">' . do_shortcode( $custom_html_content ) . '</div>';
    } elseif ( current_user_can( 'edit_theme_options' ) ) {
        $custom_html = '<a href="' . esc_url( admin_url( 'customize.php?autofocus[control]=' . analytica()->theme_option_name . '[' . $option_name . ']' ) ) . '">' . __( 'Add Custom HTML', 'analytica' ) . '</a>';
    }

    return $custom_html;
}

/**
 * Get custom widget added by user.
 *
 * @since  1.0.1.1
 * @param  string $option_name Option name.
 * @return Widget added by user in options panel.
 */
function analytica_get_custom_widget( $option_name = '' ) {

    ob_start();

    if ( 'header-main-rt-section' == $option_name ) {
        $widget_id = 'header-widget';
    }
    if ( 'footer-sml-section-1' == $option_name ) {
        $widget_id = 'footer-widget-1';
    } elseif ( 'footer-sml-section-2' == $option_name ) {
        $widget_id = 'footer-widget-2';
    }

    echo '<div class="ast-' . esc_attr( $widget_id ) . '-area">';
            analytica_get_sidebar( $widget_id );
    echo '</div>';

    return ob_get_clean();
}

/**
 * Function to get Small Left/Right Footer
 *
 * @since 1.0.0
 * @param string $section   Sections of Small Footer.
 * @return mixed            Markup of sections.
 */
function analytica_get_small_footer( $section = '' ) {

    $small_footer_type = analytica_get_option( $section );
    $output            = null;

    switch ( $small_footer_type ) {
        case 'menu':
                $output = analytica_get_small_footer_menu();
            break;

        case 'custom':
                $output = analytica_get_small_footer_custom_text( $section . '-credit' );
            break;

        case 'widget':
                $output = analytica_get_custom_widget( $section );
            break;
    }

    return $output;
}

/**
 * Function to get Small Footer Custom Text
 *
 * @since 1.0.14
 * @param string $option Custom text option name.
 * @return mixed         Markup of custom text option.
 */
function analytica_get_small_footer_custom_text( $option = '' ) {

    $output = $option;

    if ( '' != $option ) {
        $output = analytica_get_option( $option );
        $output = str_replace( '[current_year]', date_i18n( 'Y' ), $output );
        $output = str_replace( '[site_title]', '<span class="ast-footer-site-title">' . get_bloginfo( 'name' ) . '</span>', $output );

        $theme_author = apply_filters(
            'analytica_theme_author', array(
                'theme_name'       => __( 'Analytica', 'analytica' ),
                'theme_author_url' => 'http://wpanalytica.com/',
            )
        );

        $output = str_replace( '[theme_author]', '<a href="' . esc_url( $theme_author['theme_author_url'] ) . '">' . $theme_author['theme_name'] . '</a>', $output );
    }

    return do_shortcode( $output );
}

/**
 * Function to get Footer Menu
 *
 * @since 1.0.0
 * @return html
 */
function analytica_get_small_footer_menu() {

    ob_start();

    if ( has_nav_menu( 'footer_menu' ) ) {
        wp_nav_menu(
            array(
                'container'       => 'div',
                'container_class' => 'footer-primary-navigation',
                'theme_location'  => 'footer_menu',
                'menu_class'      => 'nav-menu',
                'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'depth'           => 1,
            )
        );
    } else {
        if ( is_user_logged_in() && current_user_can( 'edit_theme_options' ) ) {
            ?>
                <a href="<?php echo esc_url( admin_url( '/nav-menus.php?action=locations' ) ); ?>"><?php esc_html_e( 'Assign Footer Menu', 'analytica' ); ?></a>
            <?php
        }
    }

    return ob_get_clean();
}

add_action( 'analytica_header', 'analytica_header_markup' );
/**
 * Site Header - <header>
 *
 * @since 1.0.0
 */
function analytica_header_markup() {
    ?>

    <header itemtype="https://schema.org/WPHeader" itemscope="itemscope" id="masthead" <?php analytica_header_classes(); ?> role="banner">

        <?php do_action( 'analytica_masthead_top' ); ?>

        <?php do_action( 'analytica_masthead' ); ?>

        <?php do_action( 'analytica_masthead_bottom' ); ?>

    </header><!-- #masthead -->
    <?php
}

add_action( 'analytica_masthead_content', 'analytica_site_branding_markup', 8 );
/**
 * Site Title / Logo
 *
 * @since 1.0.0
 */
function analytica_site_branding_markup() {
    ?>

    <div class="site-branding">
        <div class="ast-site-identity" itemscope="itemscope" itemtype="https://schema.org/Organization">
            <?php analytica_logo(); ?>
        </div>
    </div>
    <!-- .site-branding -->
    <?php
}

add_action( 'analytica_masthead_content', 'analytica_toggle_buttons_markup', 9 );
/**
 * Toggle Button Markup
 *
 * @since 1.0.0
 */
function analytica_toggle_buttons_markup() {
    $disable_primary_navigation = analytica_get_option( 'disable-primary-nav' );
    $custom_header_section      = analytica_get_option( 'header-main-rt-section' );
    $menu_bottons               = true;
    if ( $disable_primary_navigation && 'none' == $custom_header_section ) {
        $menu_bottons = false;
    }
    if ( apply_filters( 'analytica_enable_mobile_menu_buttons', $menu_bottons ) ) {
    ?>
    <div class="ast-mobile-menu-buttons">

        <?php do_action( 'analytica_masthead_toggle_buttons_before' ); ?>

        <?php do_action( 'analytica_masthead_toggle_buttons' ); ?>

        <?php do_action( 'analytica_masthead_toggle_buttons_after' ); ?>

    </div>
    <?php
    }
}

add_action( 'analytica_masthead_content', 'analytica_primary_navigation_markup', 10 );
/**
 * Site Title / Logo
 *
 * @since 1.0.0
 */
function analytica_primary_navigation_markup() {

    $disable_primary_navigation = analytica_get_option( 'disable-primary-nav' );
    $custom_header_section      = analytica_get_option( 'header-main-rt-section' );

    if ( $disable_primary_navigation ) {

        $display_outside = analytica_get_option( 'header-display-outside-menu' );

        if ( 'none' != $custom_header_section && ! $display_outside ) {
            echo '<div class="main-header-bar-navigation ast-header-custom-item ast-flex ast-justify-content-flex-end">';
            echo analytica_masthead_get_menu_items();
            echo '</div>';
        }
    } else {

        $submenu_class = apply_filters( 'primary_submenu_border_class', ' submenu-with-border' );

        // Fallback Menu if primary menu not set.
        $fallback_menu_args = array(
            'theme_location' => 'primary',
            'menu_id'        => 'primary-menu',
            'menu_class'     => 'main-navigation',
            'container'      => 'div',

            'before'         => '<ul class="main-header-menu ast-flex ast-justify-content-flex-end' . $submenu_class . '">',
            'after'          => '</ul>',
        );

        $items_wrap  = '<nav itemtype="https://schema.org/SiteNavigationElement" itemscope="itemscope" id="site-navigation" class="ast-flex-grow-1" role="navigation" aria-label="' . esc_attr( 'Site Navigation', 'analytica' ) . '">';
        $items_wrap .= '<div class="main-navigation">';
        $items_wrap .= '<ul id="%1$s" class="%2$s">%3$s</ul>';
        $items_wrap .= '</div>';
        $items_wrap .= '</nav>';

        // Primary Menu.
        $primary_menu_args = array(
            'theme_location'  => 'primary',
            'menu_id'         => 'primary-menu',
            'menu_class'      => 'main-header-menu ast-flex ast-justify-content-flex-end' . $submenu_class,
            'container'       => 'div',
            'container_class' => 'main-header-bar-navigation',
            'items_wrap'      => $items_wrap,
        );

        if ( has_nav_menu( 'primary' ) ) {
            // To add default alignment for navigation which can be added through any third party plugin.
            // Do not add any CSS from theme except header alignment.
            echo '<div class="ast-main-header-bar-alignment">';
                wp_nav_menu( $primary_menu_args );
            echo  '</div>';
        } else {

            echo '<div class="main-header-bar-navigation">';
                echo '<nav itemtype="https://schema.org/SiteNavigationElement" itemscope="itemscope" id="site-navigation" class="ast-flex-grow-1" role="navigation" aria-label="' . esc_attr( 'Site Navigation', 'analytica' ) . '">';
                    wp_page_menu( $fallback_menu_args );
                echo  '</nav>';
            echo  '</div>';
        }
    }

}

/**
 * Function to get Header Breakpoint
 *
 * @since 1.0.0
 * @return number
 */
function analytica_header_break_point() {
    return absint( apply_filters( 'analytica_header_break_point', 921 ) );
}

/**
 * Function to get Body Font Family
 *
 * @since 1.0.0
 * @return string
 */
function analytica_body_font_family() {

    $font_family = analytica_get_option( 'body-font-family' );

    // Body Font Family.
    if ( 'inherit' == $font_family ) {
        $font_family = '-apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen-Sans, Ubuntu, Cantarell, Helvetica Neue, sans-serif';
    }

    return apply_filters( 'analytica_body_font_family', $font_family );
}

/**
 * Function to get Edit Post Link
 *
 * @since 1.0.0
 * @param string $text      Anchor Text.
 * @param string $before    Anchor Text.
 * @param string $after     Anchor Text.
 * @param int    $id           Anchor Text.
 * @param string $class     Anchor Text.
 * @return void
 */
function analytica_edit_post_link( $text, $before = '', $after = '', $id = 0, $class = 'post-edit-link' ) {

    if ( apply_filters( 'analytica_edit_post_link', false ) ) {
        edit_post_link( $text, $before, $after, $id, $class );
    }
}

/**
 * Function to get Header Classes
 *
 * @since 1.0.0
 */
function analytica_header_classes() {

    $classes                  = array( 'site-header' );
    $menu_logo_location       = analytica_get_option( 'header-layouts' );
    $mobile_header_alignment  = analytica_get_option( 'header-main-menu-align' );
    $primary_menu_disable     = analytica_get_option( 'disable-primary-nav' );
    $primary_menu_custom_item = analytica_get_option( 'header-main-rt-section' );
    $logo_title_inline        = analytica_get_option( 'logo-title-inline' );

    if ( $menu_logo_location ) {
        $classes[] = $menu_logo_location;
    }

    if ( $primary_menu_disable ) {

        $classes[] = 'ast-primary-menu-disabled';

        if ( 'none' == $primary_menu_custom_item ) {
            $classes[] = 'ast-no-menu-items';
        }
    }
    // Add class if Inline Logo & Site Title.
    if ( $logo_title_inline ) {
        $classes[] = 'ast-logo-title-inline';
    }

    $classes[] = 'ast-mobile-header-' . $mobile_header_alignment;

    $classes = array_unique( apply_filters( 'analytica_header_class', $classes ) );

    $classes = array_map( 'sanitize_html_class', $classes );

    echo 'class="' . esc_attr( join( ' ', $classes ) ) . '"';
}

/**
 * Function to get Footer Classes
 *
 * @since 1.0.0
 */
function analytica_footer_classes() {

    $classes = array_unique( apply_filters( 'analytica_footer_class', array( 'site-footer' ) ) );

    $classes = array_map( 'sanitize_html_class', $classes );

    echo 'class="' . esc_attr( join( ' ', $classes ) ) . '"';
}

add_action( 'wp_enqueue_scripts', 'analytica_header_breakpoint_style' );
/**
 * Function to Add Header Breakpoint Style
 *
 * @since 1.0.0
 */
function analytica_header_breakpoint_style() {

    // Header Break Point.
    $header_break_point = analytica_header_break_point();

    ob_start();
    ?>
    .main-header-bar-wrap {
        content: '<?php echo esc_html( $header_break_point ); ?>';
    }

    @media all and ( min-width: <?php echo esc_html( $header_break_point ); ?>px ) {
        .main-header-bar-wrap {
            content: '';
        }
    }
    <?php

    $analytica_header_width = analytica_get_option( 'header-main-layout-width' );

    /* Width for Header */
    if ( 'content' != $analytica_header_width ) {
        $genral_global_responsive = array(
            '#masthead .ast-container' => array(
                'max-width'     => '100%',
                'padding-left'  => '35px',
                'padding-right' => '35px',
            ),
        );

        /* Parse CSS from array()*/
        echo analytica_parse_css( $genral_global_responsive, $header_break_point );
    }

    $dynamic_css = ob_get_clean();

    // trim white space for faster page loading.
    $dynamic_css = Analytica\Frontend::trim_css( $dynamic_css );

    wp_add_inline_style( 'analytica-theme-css', $dynamic_css );
}


add_filter( 'comment_form_default_fields', 'analytica_comment_form_default_fields_markup' );
/**
 * Function filter comment form's default fields
 *
 * @since 1.0.0
 * @param array $fields Array of comment form's default fields.
 * @return array        Comment form fields.
 */
function analytica_comment_form_default_fields_markup( $fields ) {

    $commenter = wp_get_current_commenter();
    $req       = get_option( 'require_name_email' );
    $aria_req  = ( $req ? " aria-required='true'" : '' );

    $fields['author'] = '<div class="ast-comment-formwrap ast-row"><p class="comment-form-author ast-col-xs-12 ast-col-sm-12 ast-col-md-4 ast-col-lg-4">' .
                '<label for="author" class="screen-reader-text">' . esc_html( analytica_default_strings( 'string-comment-label-name', false ) ) . '</label><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
                '" placeholder="' . esc_attr( analytica_default_strings( 'string-comment-label-name', false ) ) . '" size="30"' . $aria_req . ' /></p>';
    $fields['email']  = '<p class="comment-form-email ast-col-xs-12 ast-col-sm-12 ast-col-md-4 ast-col-lg-4">' .
                '<label for="email" class="screen-reader-text">' . esc_html( analytica_default_strings( 'string-comment-label-email', false ) ) . '</label><input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) .
                '" placeholder="' . esc_attr( analytica_default_strings( 'string-comment-label-email', false ) ) . '" size="30"' . $aria_req . ' /></p>';
    $fields['url']    = '<p class="comment-form-url ast-col-xs-12 ast-col-sm-12 ast-col-md-4 ast-col-lg-4"><label for="url">' .
                '<label for="url" class="screen-reader-text">' . esc_html( analytica_default_strings( 'string-comment-label-website', false ) ) . '</label><input id="url" name="url" type="text" value="' . esc_url( $commenter['comment_author_url'] ) .
                '" placeholder="' . esc_attr( analytica_default_strings( 'string-comment-label-website', false ) ) . '" size="30" /></label></p></div>';

    return apply_filters( 'analytica_comment_form_default_fields_markup', $fields );
}


add_filter( 'comment_form_defaults', 'analytica_comment_form_default_markup' );
/**
 * Function filter comment form arguments
 *
 * @since 1.0.0
 * @param array $args   Comment form arguments.
 * @return array
 */
function analytica_comment_form_default_markup( $args ) {

    $args['id_form']           = 'ast-commentform';
    $args['title_reply']       = analytica_default_strings( 'string-comment-title-reply', false );
    $args['cancel_reply_link'] = analytica_default_strings( 'string-comment-cancel-reply-link', false );
    $args['label_submit']      = analytica_default_strings( 'string-comment-label-submit', false );
    $args['comment_field']     = '<div class="ast-row comment-textarea"><fieldset class="comment-form-comment"><div class="comment-form-textarea ast-col-lg-12"><label for="comment" class="screen-reader-text">' . esc_html( analytica_default_strings( 'string-comment-label-message', false ) ) . '</label><textarea id="comment" name="comment" placeholder="' . esc_attr( analytica_default_strings( 'string-comment-label-message', false ) ) . '" cols="45" rows="8" aria-required="true"></textarea></div></fieldset></div>';

    return apply_filters( 'analytica_comment_form_default_markup', $args );

}


/**
 * Function filter comment form arguments
 *
 * @since 1.0.0
 * @param array $layout     Comment form arguments.
 * @return array
 */
function analytica_404_page_layout( $layout ) {

    if ( is_404() ) {
        $layout = 'no-sidebar';
    }

    return apply_filters( 'analytica_404_page_layout', $layout );
}

add_filter( 'analytica_page_layout', 'analytica_404_page_layout', 10, 1 );

/**
 * Return current content layout
 *
 * @since 1.0.0
 * @return boolean  content layout.
 */
function analytica_get_content_layout() {

    $value = false;

    if ( is_singular() ) {

        // If post meta value is empty,
        // Then get the POST_TYPE content layout.
        $content_layout = analytica_get_option_meta( 'site-content-layout', '', true );

        if ( empty( $content_layout ) ) {

            $post_type = get_post_type();

            if ( 'post' === $post_type || 'page' === $post_type ) {
                $content_layout = analytica_get_option( 'single-' . get_post_type() . '-content-layout' );
            }

            if ( 'default' == $content_layout || empty( $content_layout ) ) {

                // Get the GLOBAL content layout value.
                // NOTE: Here not used `true` in the below function call.
                $content_layout = analytica_get_option( 'site-content-layout', 'full-width' );
            }
        }
    } else {

        $content_layout = '';
        $post_type      = get_post_type();

        if ( 'post' === $post_type ) {
            $content_layout = analytica_get_option( 'archive-' . get_post_type() . '-content-layout' );
        }

        if ( is_search() ) {
            $content_layout = analytica_get_option( 'archive-post-content-layout' );
        }

        if ( 'default' == $content_layout || empty( $content_layout ) ) {

            // Get the GLOBAL content layout value.
            // NOTE: Here not used `true` in the below function call.
            $content_layout = analytica_get_option( 'site-content-layout', 'full-width' );
        }
    }

    return apply_filters( 'analytica_get_content_layout', $content_layout );
}

/**
 * Display Blog Post Excerpt
 *
 * @since 1.0.0
 */
function analytica_the_excerpt() {

    $excerpt_type = analytica_get_option( 'blog-post-content' );

    do_action( 'analytica_the_excerpt_before', $excerpt_type );

    if ( 'full-content' == $excerpt_type ) {
        the_content();
    } else {
        the_excerpt();
    }

    do_action( 'analytica_the_excerpt_after', $excerpt_type );
}

/**
 * Get Sidebar
 *
 * @since 1.0.1.1
 * @param  string $sidebar_id   Sidebar Id.
 * @return void
 */
function analytica_get_sidebar( $sidebar_id ) {
    if ( is_active_sidebar( $sidebar_id ) ) {
        dynamic_sidebar( $sidebar_id );
    } elseif ( current_user_can( 'edit_theme_options' ) ) {
    ?>
        <div class="widget ast-no-widget-row">
            <p class='no-widget-text'>
                <a href='<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>'>
                    <?php esc_html_e( 'Add Widget', 'analytica' ); ?>
                </a>
            </p>
        </div>
        <?php
    }
}

/**
 * Get Footer Default Sidebar
 *
 * @param  string $sidebar_id   Sidebar Id..
 * @return void
 */
function analytica_get_footer_widget( $sidebar_id ) {

    if ( is_active_sidebar( $sidebar_id ) ) {
        dynamic_sidebar( $sidebar_id );
    } elseif ( current_user_can( 'edit_theme_options' ) ) {

        global $wp_registered_sidebars;
        $sidebar_name = '';
        if ( isset( $wp_registered_sidebars[ $sidebar_id ] ) ) {
            $sidebar_name = $wp_registered_sidebars[ $sidebar_id ]['name'];
        }
        ?>
        <div class="widget ast-no-widget-row">
            <h2 class='widget-title'><?php echo esc_html( $sidebar_name ); ?></h2>

            <p class='no-widget-text'>
                <a href='<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>'>
                    <?php esc_html_e( 'Click here to assign a widget for this area.', 'analytica' ); ?>
                </a>
            </p>
        </div>
        <?php
    }
}

/**
 * Analytica entry header class
 *
 * @since 1.0.15
 */
function analytica_entry_header_class() {

    $post_id          = analytica_get_post_id();
    $classes          = array();
    $title_markup     = analytica_the_title( '', '', $post_id, false );
    $thumb_markup     = analytica_get_post_thumbnail( '', '', false );
    $post_meta_markup = analytica_single_get_post_meta( '', '', false );

    if ( empty( $title_markup ) && empty( $thumb_markup ) && ( is_page() || empty( $post_meta_markup ) ) ) {
        $classes[] = 'ast-header-without-markup';
    } else {

        if ( empty( $title_markup ) ) {
            $classes[] = 'ast-no-title';
        }

        if ( empty( $thumb_markup ) ) {
            $classes[] = 'ast-no-thumbnail';
        }

        if ( is_page() || empty( $post_meta_markup ) ) {
            $classes[] = 'ast-no-meta';
        }
    }

    $classes = array_unique( apply_filters( 'analytica_entry_header_class', $classes ) );
    $classes = array_map( 'sanitize_html_class', $classes );

    echo esc_attr( join( ' ', $classes ) );
}

/**
 * Analytica get post thumbnail image
 *
 * @since 1.0.15
 * @param string  $before Markup before thumbnail image.
 * @param string  $after  Markup after thumbnail image.
 * @param boolean $echo   Output print or return.
 * @return string|void
 */
function analytica_get_post_thumbnail( $before = '', $after = '', $echo = true ) {

    $output = '';

    $check_is_singular = is_singular();

    $featured_image = true;

    if ( $check_is_singular ) {
        $is_featured_image = analytica_get_option_meta( 'ast-featured-img' );
    } else {
        $is_featured_image = analytica_get_option( 'ast-featured-img' );
    }

    if ( 'disabled' === $is_featured_image ) {
        $featured_image = false;
    }

    $featured_image = apply_filters( 'analytica_featured_image_enabled', $featured_image );

    $blog_post_thumb   = analytica_get_option( 'blog-post-structure' );
    $single_post_thumb = analytica_get_option( 'blog-single-post-structure' );

    if ( ( ( ! $check_is_singular && in_array( 'image', $blog_post_thumb ) ) || ( is_single() && in_array( 'single-image', $single_post_thumb ) ) || is_page() ) && has_post_thumbnail() ) {

        if ( $featured_image && ( ! ( $check_is_singular ) || ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) ) ) {

            $post_thumb = get_the_post_thumbnail(
                get_the_ID(),
                apply_filters( 'analytica_post_thumbnail_default_size', 'full' ),
                array(
                    'itemprop' => 'image',
                )
            );

            if ( '' != $post_thumb ) {
                $output .= '<div class="post-thumb-img-content post-thumb">';
                if ( ! $check_is_singular ) {
                    $output .= '<a href="' . esc_url( get_permalink() ) . '" >';
                }
                $output .= $post_thumb;
                if ( ! $check_is_singular ) {
                    $output .= '</a>';
                }
                $output .= '</div>';
            }
        }
    }

    if ( ! $check_is_singular ) {
        $output = apply_filters( 'analytica_blog_post_featured_image_after', $output );
    }

    $output = apply_filters( 'analytica_get_post_thumbnail', $output, $before, $after );

    if ( $echo ) {
        echo $before . $output . $after; // WPCS: XSS OK.
    } else {
        return $before . $output . $after;
    }
}

/**
 * Function to check if it is Internet Explorer.
 *
 * @return true | false boolean
 */
function analytica_check_is_ie() {

    $is_ie = false;

    $ua = htmlentities( $_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, 'UTF-8' );
    if ( strpos( $ua, 'Trident/7.0' ) !== false ) {
        $is_ie = true;
    }

    return apply_filters( 'analytica_check_is_ie', $is_ie );
}

/**
 * Replace header logo.
 *
 * @param array  $image Size.
 * @param int    $attachment_id Image id.
 * @param sting  $size Size name.
 * @param string $icon Icon.
 *
 * @return array Size of image
 */
function analytica_replace_header_logo( $image, $attachment_id, $size, $icon ) {

    $custom_logo_id = get_theme_mod( 'custom_logo' );

    if ( ! is_customize_preview() && $custom_logo_id == $attachment_id && 'full' == $size ) {

        $data = wp_get_attachment_image_src( $attachment_id, 'ast-logo-size' );

        if ( false != $data ) {
            $image = $data;
        }
    }

    return apply_filters( 'analytica_replace_header_logo', $image );
}

/**
 * Replace header logo.
 *
 * @param array  $attr Image.
 * @param object $attachment Image obj.
 * @param sting  $size Size name.
 *
 * @return array Image attr.
 */
function analytica_replace_header_attr( $attr, $attachment, $size ) {

    $custom_logo_id = get_theme_mod( 'custom_logo' );

    if ( $custom_logo_id == $attachment->ID ) {

        $attach_data = array();
        if ( ! is_customize_preview() ) {
            $attach_data = wp_get_attachment_image_src( $attachment->ID, 'ast-logo-size' );

            if ( isset( $attach_data[0] ) ) {
                $attr['src'] = $attach_data[0];
            }
        }

        $file_type      = wp_check_filetype( $attr['src'] );
        $file_extension = $file_type['ext'];

        if ( 'svg' == $file_extension ) {
            $attr['class'] = 'analytica-logo-svg';
        }

        $retina_logo = analytica_get_option( 'ast-header-retina-logo' );

        $attr['srcset'] = '';

        if ( apply_filters( 'analytica_main_header_retina', true ) && '' !== $retina_logo ) {
            $cutom_logo     = wp_get_attachment_image_src( $custom_logo_id, 'full' );
            $cutom_logo_url = $cutom_logo[0];

            if ( analytica_check_is_ie() ) {
                // Replace header logo url to retina logo url.
                $attr['src'] = $retina_logo;
            }

            $attr['srcset'] = $cutom_logo_url . ' 1x, ' . $retina_logo . ' 2x';

        }
    }

    return apply_filters( 'analytica_replace_header_attr', $attr );
}

add_filter( 'wp_get_attachment_image_attributes', 'analytica_replace_header_attr', 10, 3 );

/**
 * Analytica Color Palletes.
 *
 * @return array Color Palletes.
 */
function analytica_color_palette() {

    $color_palette = array(
        '#000000',
        '#ffffff',
        '#dd3333',
        '#dd9933',
        '#eeee22',
        '#81d742',
        '#1e73be',
        '#8224e3',
    );

    return apply_filters( 'analytica_color_palettes', $color_palette );
}

/**
 * Get theme name.
 *
 * @return string Theme Name.
 */
function analytica_get_theme_name() {

    $theme_name = __( 'Analytica', 'analytica' );

    return apply_filters( 'analytica_theme_name', $theme_name );
}

/**
 * Strpos over an array.
 *
 * @since  1.2.4
 * @param  String  $haystack The string to search in.
 * @param  Array   $needles  Array of needles to be passed to strpos().
 * @param  integer $offset   If specified, search will start this number of characters counted from the beginning of the string. If the offset is negative, the search will start this number of characters counted from the end of the string.
 *
 * @return bool            True if haystack if part of any of the $needles.
 */
function analytica_strposa( $haystack, $needles, $offset = 0 ) {

    if ( ! is_array( $needles ) ) {
        $needles = array( $needles );
    }

    foreach ( $needles as $query ) {

        if ( strpos( $haystack, $query, $offset ) !== false ) {
            // stop on first true result.
            return true;
        }
    }

    return false;
}

/**
 * Get Addon name.
 *
 * @return string Addon Name.
 */
function analytica_get_addon_name() {

    $pro_name = __( 'Analytica Pro', 'analytica' );
    // If addon is not updated & White Label added for Addon then show the updated addon name.
    if ( class_exists( 'Analytica_Ext_White_Label_Markup' ) ) {

        $plugin_data = Analytica_Ext_White_Label_Markup::$branding;

        if ( '' != $plugin_data['analytica-pro']['name'] ) {
            $pro_name = $plugin_data['analytica-pro']['name'];
        }
    }

    return apply_filters( 'analytica_addon_name', $pro_name );
}

/**
 * Get a specific property of an array without needing to check if that property exists.
 *
 * Provide a default value if you want to return a specific value if the property is not set.
 *
 * @since  1.0.0
 * @access public
 * @author Gravity Forms - Easiest Tool to Create Advanced Forms for Your WordPress-Powered Website.
 * @link  https://www.gravityforms.com/
 *
 * @param array  $array   Array from which the property's value should be retrieved.
 * @param string $prop    Name of the property to be retrieved.
 * @param string $default Optional. Value that should be returned if the property is not set or empty. Defaults to null.
 *
 * @return null|string|mixed The value
 */
function astar( $array, $prop, $default = null ) {

    if ( ! is_array( $array ) && ! ( is_object( $array ) && $array instanceof ArrayAccess ) ) {
        return $default;
    }

    if ( isset( $array[ $prop ] ) ) {
        $value = $array[ $prop ];
    } else {
        $value = '';
    }

    return empty( $value ) && null !== $default ? $default : $value;
}
