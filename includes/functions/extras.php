<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        https://qazana.net/
 * @since       Analytica 1.0.0
 */
 
add_action( 'analytica_template_parts_content_bottom', 'analytica_number_pagination' );
/**
 * Analytica Pagination
 *
 * @since 1.0.0
 * @return void            Generate & echo pagination markup.
 */
function analytica_number_pagination() {
    global $numpages;
    
    $enabled = apply_filters( 'analytica_pagination_enabled', true );

    if ( ! isset( $numpages ) || ! $enabled || ! analytica_is_post_archive_page() ) {
        return;
    }

    ob_start();
    echo "<div class='analytica-pagination'>";
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
 
/**
 * Adding Wrapper for Search Form.
 *
 * @since 1.0.0
 * @param  string $option   Search Option name.
 * @return mixed Search HTML structure created.
 */
function analytica_get_search( $option = '' ) {

    $search_html  = '<div class="analytica-search-icon"><a class="slide-search analytica-search-icon" href="#"><span class="screen-reader-text">' . esc_html__( 'Search', 'analytica' ) . '</span></a></div>
                    <div class="analytica-search-menu-icon slide-search" id="analytica-search-form" >';
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
        $custom_html = '<div class="analytica-custom-html">' . do_shortcode( $custom_html_content ) . '</div>';
    } elseif ( current_user_can( 'edit_theme_options' ) ) {
        $custom_html = '<a href="' . esc_url( admin_url( 'customize.php?autofocus[control]=' . analytica()->option_name . '[' . $option_name . ']' ) ) . '">' . __( 'Add Custom HTML', 'analytica' ) . '</a>';
    }

    return $custom_html;
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

    $fields['author'] = '<div class="analytica-comment-formwrap"><p class="comment-form-author analytica-col-xs-12 analytica-col-sm-12 analytica-col-md-4 analytica-col-lg-4">' .
                '<label for="author" class="screen-reader-text">' . esc_html( analytica_default_strings( 'string-comment-label-name', false ) ) . '</label><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
                '" placeholder="' . esc_attr( analytica_default_strings( 'string-comment-label-name', false ) ) . '" size="30"' . $aria_req . ' /></p>';
    $fields['email']  = '<p class="comment-form-email analytica-col-xs-12 analytica-col-sm-12 analytica-col-md-4 analytica-col-lg-4">' .
                '<label for="email" class="screen-reader-text">' . esc_html( analytica_default_strings( 'string-comment-label-email', false ) ) . '</label><input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) .
                '" placeholder="' . esc_attr( analytica_default_strings( 'string-comment-label-email', false ) ) . '" size="30"' . $aria_req . ' /></p>';
    $fields['url']    = '<p class="comment-form-url analytica-col-xs-12 analytica-col-sm-12 analytica-col-md-4 analytica-col-lg-4"><label for="url">' .
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

    $args['id_form']           = 'analytica-commentform';
    $args['title_reply']       = analytica_default_strings( 'string-comment-title-reply', false );
    $args['cancel_reply_link'] = analytica_default_strings( 'string-comment-cancel-reply-link', false );
    $args['label_submit']      = analytica_default_strings( 'string-comment-label-submit', false );
    $args['comment_field']     = '<div class="comment-textarea"><fieldset class="comment-form-comment"><div class="comment-form-textarea"><label for="comment" class="screen-reader-text">' . esc_html( analytica_default_strings( 'string-comment-label-message', false ) ) . '</label><textarea id="comment" name="comment" placeholder="' . esc_attr( analytica_default_strings( 'string-comment-label-message', false ) ) . '" cols="45" rows="8" aria-required="true"></textarea></div></fieldset></div>';

    return apply_filters( 'analytica_comment_form_default_markup', $args );
}

/**
 * Display Blog Post Excerpt
 *
 * @since 1.0.0
 */
function analytica_the_excerpt() {

    $excerpt_type = analytica_get_option( 'archive-post-content'             );

    do_action( 'analytica_the_excerpt_before', $excerpt_type );

    if ( 'full-content' == $excerpt_type ) {
        the_content();
    } else {
        the_excerpt();
    }

    do_action( 'analytica_the_excerpt_after', $excerpt_type );
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
        $classes[] = 'analytica-header-without-markup';
    } else {

        if ( empty( $title_markup ) ) {
            $classes[] = 'analytica-no-title';
        }

        if ( empty( $thumb_markup ) ) {
            $classes[] = 'analytica-no-thumbnail';
        }

        if ( is_page() || empty( $post_meta_markup ) ) {
            $classes[] = 'analytica-no-meta';
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

    $is_featured_image = analytica_get_option( 'featured-image' );

    if ( 'disabled' === $is_featured_image ) {
        $featured_image = false;
    }

    $featured_image = apply_filters( 'analytica_featured_image_enabled', $featured_image );
    $blog_post_thumb   = analytica_get_option( 'archive-content-structure'            , [] );
    $single_post_thumb = analytica_get_option( 'single-post-structure', [] );

    if ( ( ( ! $check_is_singular && in_array( 'image', $blog_post_thumb ) ) || ( is_single() && in_array( 'single-image', $single_post_thumb ) ) || is_page() ) && has_post_thumbnail() ) {

        if ( $featured_image && ( ! ( $check_is_singular ) || ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) ) ) {

            $post_thumb = get_the_post_thumbnail(
                get_the_ID(),
                apply_filters( 'analytica_post_thumbnail_default_size', 'blog-featured' ),
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
    return apply_filters( 'analytica_theme_name', __( 'Analytica', 'analytica' ) );
}
