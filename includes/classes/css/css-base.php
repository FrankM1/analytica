<?php
namespace Analytica;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

abstract class CSS_File {

	const FILE_BASE_DIR = '/analytica/css';

    // %s: Base folder; %s: file name
	const FILE_NAME_PATTERN = '%s/%s.css';

	const CSS_STATUS_FILE   = 'file';
	const CSS_STATUS_INLINE = 'inline';
	const CSS_STATUS_EMPTY  = 'empty';

	/**
	 * @var string
	 */
	private $path;

	/**
	 * @var string
	 */
	private $url;

	/**
	 * @var string
	 */
	private $css;

	/**
	 * @var array
	 */
	public $fonts = [];

	abstract public function get_name();

	/**
	 * CSS_File constructor.
	 */
	public function __construct() {
        if ( $this->use_external_file() ) {
			$this->set_path_and_url();
		}
    }

    /**
	 * @since 1.0.0
	 * @access protected
	 */
	protected function use_external_file() {
        return 'internal' !== analytica_get_option( 'css_print_method' );
	}

	public function update() {
		$this->parse_css();

		$meta = [
			'time'  => time(),
			'fonts' => $this->fonts,
        ];

		if ( empty( $this->css ) ) {
			$this->delete();

			$meta['status'] = self::CSS_STATUS_EMPTY;
			$meta['css'] = '';
		} else {
			$file_created = false;
			$use_external_file = $this->use_external_file();

			if ( $use_external_file && wp_is_writable( dirname( $this->path ) ) ) {
                global $wp_filesystem;

                // Instantiate the Wordpress filesystem.
                if ( empty( $wp_filesystem ) ) {
                    require_once( ABSPATH . '/wp-admin/includes/file.php' );
                    WP_Filesystem();
                }

                // Since we've already checked if the file is writable in the wp_is_writable()
                // it's safe to continue without any additional checks as to the validity of the file.
                $file_created = $wp_filesystem->put_contents( $this->path, $this->css, FS_CHMOD_FILE );
            }

			if ( $file_created ) {
				$meta['status'] = self::CSS_STATUS_FILE;
			} else {
				$meta['status'] = self::CSS_STATUS_INLINE;
				$meta['css'] = $this->css;
			}
        }
        
		$this->update_meta( $meta );
	}

	public function delete() {
		if ( file_exists( $this->path ) ) {
			unlink( $this->path );
		}
	}

	public function enqueue() {
        $meta = $this->get_meta();

		if ( self::CSS_STATUS_EMPTY === $meta['status'] ) {
			return;
		}

		// First time after clear cache and etc.
		if ( '' === $meta['status'] || $this->is_update_required() ) {
			$this->update();

			$meta = $this->get_meta();
		}

        if ( self::CSS_STATUS_INLINE === $meta['status'] ) {
            $dep = $this->get_inline_dependency();
			// If the dependency has already been printed ( like a template in footer )
			if ( wp_styles()->query( $dep, 'done' ) ) {
				echo '<style>' . $this->get_css() . '</style>'; // XSS ok.
			} else {
				wp_add_inline_style( $dep , $meta['css'] );
			}
		} else {

            if ( ! file_exists( $this->path ) && current_user_can( 'edit_posts' ) ) {
                $this->update();
                $meta = $this->get_meta();
            }

			wp_enqueue_style( $this->get_file_handle_id(), $this->url, $this->get_enqueue_dependencies(), $meta['time'] );
        }
	}

	/**
	 * @return string
	 */
	public function get_css() {
		if ( empty( $this->css ) ) {
			$this->parse_css();
		}

		return $this->css;
    }

    /**
	 * @return string
	 */
    public function add_css( $css ) {
		$this->css = $css;
	}

	public function get_meta( $property = null ) {
		$defaults = [
			'status' => '',
			'time' => 0,
		];

		$meta = array_merge( $defaults, (array) $this->load_meta() );

		if ( $property ) {
			return isset( $meta[ $property ] ) ? $meta[ $property ] : null;
        }

		return $meta;
	}

	/**
	 * @return array
	 */
	abstract protected function load_meta();

	/**
	 * @param string $meta
	 */
	abstract protected function update_meta( $meta );

	/**
	 * @return string
	 */
	abstract protected function get_file_handle_id();

	abstract protected function render_css();

	/**
	 * @return string
	 */
	abstract protected function get_file_name();

	/**
	 * @return array
	 */
	protected function get_enqueue_dependencies() {
		return [];
	}

	/**
	 * @return string
	 */
	protected function get_inline_dependency() {
		return '';
	}

	/**
	 * @return bool
	 */
	protected function is_update_required() {
		return false;
	}

	private function set_path_and_url() {
		$wp_upload_dir = wp_upload_dir( null, false );

		$relative_path = sprintf( self::FILE_NAME_PATTERN, self::FILE_BASE_DIR, $this->get_file_name() );

		$this->path = $wp_upload_dir['basedir'] . $relative_path;

		$this->url = set_url_scheme( $wp_upload_dir['baseurl'] . $relative_path );
	}

	private function parse_css() {
		$this->render_css();
		do_action( 'analytica/' . $this->get_name() . '-css-file/parse', $this );
	}
}
