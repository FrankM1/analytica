<?php
namespace Analytica\Metabox;

/**
 * Analytica Meta Box Operations
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        https://qazana.net/
 * @since       Analytica 1.0.0
 */

/**
 * Meta Box
 */
class Actions {

    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'wp', array( $this, 'add_action' ) );
    }

    /**
     * Metabox Hooks
     */
    function add_action() {
        if ( is_singular() ) {
            add_filter( 'analytica_site_header_is_active', array( $this, 'site_header' ) );
        }
    }

    /**
     * Site Header
     */
    function site_header( $retval ) {

        if ( 'disabled' == get_post_meta( get_the_ID(), '_analytica_site_header', true ) ) {
			$retval = false;
		}

		return $retval;
    }
}
