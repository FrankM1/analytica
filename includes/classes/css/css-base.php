<?php
namespace Analytica;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

abstract class CSS_File {

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
    }

	public function update() {
		$this->parse_css();

		$meta = [
			'time'  => time(),
			'fonts' => $this->fonts,
        ];

		if ( empty( $this->css ) ) {
			$meta['status'] = self::CSS_STATUS_EMPTY;
			$meta['css'] = '';
		} else {
            $meta['status'] = self::CSS_STATUS_INLINE;
			$meta['css'] = $this->css;
        } 
		
		$this->update_meta( $meta );
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

        $dep = $this->get_inline_dependency();
        // If the dependency has already been printed ( like a template in footer )
        if ( wp_styles()->query( $dep, 'done' ) ) {
            echo '<style>' . $this->get_css() . '</style>'; // XSS ok.
        } else {
            wp_add_inline_style( $dep , $this->get_css() );
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

	private function parse_css() {
		$this->render_css();
		do_action( 'analytica/' . $this->get_name() . '-css-file/parse', $this );
	}
}
