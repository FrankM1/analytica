<?php
namespace Analytica;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Global_CSS_File extends CSS_File {

	const META_KEY = 'analytica_global_css';

	const FILE_HANDLER_ID = 'analytica-global';

	public function get_name() {
		return 'global';
	}

	/**
	 * @return array
	 */
	protected function load_meta() {
		return get_option( self::META_KEY );
	}

	/**
	 * @param string $meta
	 */
	protected function update_meta( $meta ) {
		update_option( self::META_KEY, $meta );
	}

	/**
	 * @return string
	 */
	protected function get_file_handle_id() {
		return self::FILE_HANDLER_ID;
	}

	protected function render_css() {
        $this->render_schemes_css();
	}

     /**
      * Generate a unique filename prefix
      *
      * @since 1.0.0
	  * @return string
      */
    protected function get_file_name() {
		return 'global';
    }

	protected function get_enqueue_dependencies() {
		return [ 'analytica-frontend' ];
	}

	protected function get_inline_dependency() {
		return 'analytica-frontend';
	}

	/**
	 * @return bool
	 */
	protected function is_update_required() {
		$file_last_updated = $this->get_meta( 'time' );

		$analytica_settings_last_updated = analytica_get_option( 'site-settings-update-time' );

		if ( $file_last_updated < $analytica_settings_last_updated ) {
			return true;
		}

		return false;
    }

    private function render_schemes_css() {}

}
