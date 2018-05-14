<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @category Analytica
 * @package  Energia
 * @author   Franklin Gitonga
 * @link    https://qazana.net/
 */

  /**
  * Helper method to determine if an attribute is true or false.
  *
  * @since 1.0.0
  *
  * @param string|int|bool $var Attribute value.
  *
  * @return bool
  */
function analytica_is_bool( $var ) {
    return ( ! $var || in_array( strtolower( $var ), [ 'false', '0', 'no', 'n', 'off' ] ) ) ? false : true;
}

/**
  * Detect if header is active
  *
  * @since 1.0.0
  *
  * @return boolean
  */
function analytica_header_is_active() {
    $retval = false;

    if ( analytica_get_option( 'header' ) ) {
        $retval = true;
    }

    if ( analytica_detect_plugin( ['functions' => [ 'header_composer' ] ] ) ) {
        $retval = false;
    }

    return apply_filters( __FUNCTION__, $retval );
}

 /**
  * Check if header is enabled on the page
  *
  * @return boolean
  */
 function analytica_is_page_header_available() {
     $retval = true;

     $option = analytica_get_option( 'page_header_enable', 'on' );

     if ( ! analytica_is_bool( $option ) ) {
         $retval = false;
     }

     // second level override
     if ( is_search() || is_attachment() ) {
         $retval = true;
     }

     if ( is_singular( 'post' ) && ! analytica_get_option( 'show_page_header_on_posts' ) ) {
         $retval = false;
     }

     if ( is_archive() && ! analytica_get_option( 'show_page_header_on_post_archives' ) ) {
         $retval = false;
     }

     if ( 'qazana_library' === get_post_type() ) {
         $retval = false;
     }

     return apply_filters( __FUNCTION__, $retval );
 }

 /**
  * Detect if layout qazana is active
  *
  * @since 1.0.0
  *
  * @return boolean
  */
 function analytica_builder_is_active() {
     $retval = false;

     if ( analytica_detect_plugin( ['classes' => ['Vc_Manager']] ) ) {
         $retval = true;
     }

     return apply_filters( __FUNCTION__, $retval );
 }

 /**
  * Detect inline visual composer
  *
  * @since 1.0.0
  *
  * @return boolean
  */
 function analytica_vc_editor_active() {
     $retval = false;

     if ( analytica_detect_plugin( ['classes' => ['Vc_Manager']] ) ) {
         if ( is_admin() || ( isset( $_GET['vc_editable'] ) && 'true' === $_GET['vc_editable'] ) ) {
             $retval = true;
         }
     }

     return apply_filters( __FUNCTION__, $retval );
 }

 /**
  * Detect blog page.
  *
  * @since 1.0.0
  *
  * @param post_id $post_id pass post id.
  *
  * @return bool return true if blog page templates are true
  */
 function analytica_is_blog_page( $post_id = null ) {
     $post_id = $post_id ? (int) $post_id : get_the_ID();

     $retval = false;

     if ( is_page_template( 'blog.php' ) || analytica_is_blog_and_builder_page() ) {
         $retval = true;
     }

     return $retval;
 }

 /**
  * Detect blog page.
  *
  * @since 1.0.0
  *
  * @param post_id $post_id pass post id.
  *
  * @return bool return true if blog page templates are true
  */
  function analytica_is_blog_and_builder_page( $post_id = null ) {
      $post_id = $post_id ? (int) $post_id : get_the_ID();

      $retval = false;

      if ( is_page_template( 'builder-blog.php' ) ) {
          $retval = true;
      }

      return $retval;
  }

 /**
  * Detect qazana page
  *
  * @since 1.0.0
  *
  * @param post_id $post_id pass post id.
  *
  * @return bool return true if post meta or filter is true
  */
 function analytica_is_builder_page( $post_id = null ) {
     $retval = false;

     $post_id = $post_id ? (int) $post_id : get_the_ID();

    if ( 
         ( function_exists( 'qazana' ) && ( qazana()->db->has_qazana_in_post( get_the_ID() ) ) && Qazana\Utils::is_post_type_support( $post_id ) ) || 
         is_page_template( 'builder.php' ) || 
         analytica_is_blog_and_builder_page() 
    ) {
         $retval = true;
     }

     if ( is_search() ) {
         $retval = false;
     }

     return apply_filters( __FUNCTION__, $retval, $post_id );
 }

 /**
  * Detect post archive page page
  *
  * @since 1.0.0
  *
  * @param post_id $post_id pass post id.
  *
  * @return bool return true if post meta or filter is true
  */
function analytica_is_post_archive_page( $post_id = null ) {
    $retval = false;

    $post_id = $post_id ? (int) $post_id : get_the_ID();

    if (
        analytica_is_blog_page() ||
        is_archive() ||
        is_search() ||
        is_home()
    ) {
        $retval = true;
    }

    return apply_filters( __FUNCTION__, $retval, $post_id );
}

 /**
  * Detect active plugin by constant, class or function existence.
  *
  * @since 1.0.0
  *
  * @param array $plugins Array of array for constants, classes and / or functions to check for plugin existence.
  *
  * @return bool True if plugin exists or false if plugin constant, class or function not detected.
  */
 function analytica_detect_plugin( array $plugins ) {
     // Check for classes
     if ( isset( $plugins['classes'] ) ) {
         foreach ( $plugins['classes'] as $name ) {
             if ( class_exists( $name ) ) {
                 return true;
             }
         }
     }

     // Check for functions
     if ( isset( $plugins['functions'] ) ) {
         foreach ( $plugins['functions'] as $name ) {
             if ( function_exists( $name ) ) {
                 return true;
             }
         }
     }

     // Check for constants
     if ( isset( $plugins['constants'] ) ) {
         foreach ( $plugins['constants'] as $name ) {
             if ( defined( $name ) ) {
                 return true;
             }
         }
     }

     // No class, function or constant found to exist
     return false;
 }

 /**
  * Check that we're targeting a specific Radium admin page.
  *
  * The `$pagehook` argument is expected to be one of 'analytica', 'seo-settings' or 'analytica-import-export' although
  * others can be accepted.
  *
  * @since 1.0.0
  *
  * @global string $page_hook Page hook for current page.
  *
  * @param string $pagehook Page hook string to check.
  *
  * @return bool Return true if the global $page_hook matches given $pagehook. False otherwise.
  */
 function analytica_is_menu_page( $pagehook = '' ) {
     global $page_hook;

     if ( isset( $page_hook ) && $page_hook === $pagehook ) {
         return true;
     }

     // May be too early for $page_hook
     if ( isset( $_REQUEST['page'] ) && $_REQUEST['page'] === $pagehook ) {
         return true;
     }

     return false;
 }

 /**
  * Check whether we are currently viewing the site via the WordPress Customizer.
  *
  * @since 1.0.0
  *
  * @global $wp_customize Customizer.
  *
  * @return bool Return true if viewing page via Customizer, false otherwise.
  */
 function analytica_is_customizer() {
     global $wp_customize;
     return is_a( $wp_customize, 'WP_Customize_Manager' ) && $wp_customize->is_preview();
 }

/**
 * Check if footer is enabled on the page
 *
 * @return boolean
 */
function analytica_is_footer_available() {
    $retval = true;

    $option = analytica_get_option( 'footer' );

    if ( ! analytica_is_bool( $option ) ) {
        $retval = false;
    }

    return apply_filters( __FUNCTION__, $retval );
}

/**
 * Check if colophon is enabled on the page
 *
 * @return boolean
 */
function analytica_is_colophon_available() {
    $retval = true;

    $option = analytica_get_option( 'footer-colophon' );

    if ( ! analytica_is_bool( $option ) || ! analytica_is_footer_available() ) {
        $retval = false;
    }

    return apply_filters( __FUNCTION__, $retval );
}

/**
 * Check if footer is enabled on the page
 *
 * @return boolean
 */
function analytica_footer_has_widgets() {
    $retval = true;

    $option = analytica_get_option( 'footer-widgets' );

    if ( ! analytica_is_bool( $option ) ) {
        $retval = false;
    }

    return apply_filters( __FUNCTION__, $retval );
}
