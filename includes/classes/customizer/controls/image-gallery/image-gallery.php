<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Control
 *
 * @package CustomizeObjectSelector
 */
class Kirki_Controls_Image_Gallery_Control extends Kirki_Control_Base {

    /**
     * Control type.
     *
     * @access public
     * @var string
     */
    public $type = 'image_gallery';

    /**
     * Gallery file type.
     *
     * @var string
     */
    public $file_type = 'image';

    /**
     * Button labels.
     *
     * @var array
     */
    public $button_labels = array();

    /**
     * Constructor for Image Gallery control.
     *
     * @param \WP_Customize_Manager $manager Customizer instance.
     * @param string                $id      Control ID.
     * @param array                 $args    Optional. Arguments to override class property defaults.
     */
    public function __construct( $manager, $id, $args = array() ) {
        parent::__construct( $manager, $id, $args );

        $this->button_labels = wp_parse_args( $this->button_labels, array(
            'select'       => __( 'Select Images', 'analytica' ),
            'change'       => __( 'Modify Gallery', 'analytica' ),
            'default'      => __( 'Default', 'analytica' ),
            'remove'       => __( 'Remove', 'analytica' ),
            'placeholder'  => __( 'No images selected', 'analytica' ),
            'frame_title'  => __( 'Select Gallery Images', 'analytica' ),
            'frame_button' => __( 'Choose Images', 'analytica' ),
        ) );
    }
    
    /**
     * Enqueue control related scripts/styles.
     *
     * @access public
     */
    public function enqueue() {
        wp_enqueue_script( 'analytica-image-gallery', analytica()->theme_url . '/assets/admin/js/modules/customizer/controls/image-gallery.js', array( 'jquery', 'customize-base' ), false, true );
        wp_enqueue_style( 'analytica-image-gallery', analytica()->theme_url . '/assets/admin/css/customizer/controls/image-gallery.min.css', null );
    }

    /**
     * An Underscore (JS) template for this control's content (but not its container).
     *
     * Class variables for this control class are available in the `data` JS object;
     * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
     *
     * @see WP_Customize_Control::print_template()
     */
    protected function content_template() {
        $data = $this->json();
        ?>
        <#

        _.defaults( data, <?php echo wp_json_encode( $data ) ?> );
        data.input_id = 'input-' + String( Math.random() );
        #>
            <span class="customize-control-title"><label for="{{ data.input_id }}">{{ data.label }}</label></span>
        <# if ( data.attachments ) { #>
            <div class="image-gallery-attachments">
                <# _.each( data.attachments, function( attachment ) { #>
                    <div class="image-gallery-thumbnail-wrapper" data-post-id="{{ attachment.id }}">
                        <img class="attachment-thumb" src="{{ attachment.url }}" draggable="false" alt="" />
                    </div>
                <#	} ) #>
            </div>
            <# } #>
            <div>
                <button type="button" class="button upload-button" id="image-gallery-modify-gallery">{{ data.button_labels.change }}</button>
            </div>
            <div class="customize-control-notifications"></div>

        <?php

    }

    /**
     * Send the parameters to the JavaScript via JSON.
     *
     * @see \WP_Customize_Control::to_json()
     */
    public function to_json() {
        parent::to_json();
        $this->json['label'] = html_entity_decode( $this->label, ENT_QUOTES, get_bloginfo( 'charset' ) );
        $this->json['file_type'] = $this->file_type;
        $this->json['button_labels'] = $this->button_labels;
    }

}

add_action( 'customize_register', 'analytica_customize_register_image_gallery_controls' );
// Register control with kirki
function analytica_customize_register_image_gallery_controls( $wp_customize ) {
    $wp_customize->register_control_type( 'Kirki_Controls_Image_Gallery_Control' );
}

add_filter( 'kirki_control_types', 'analytica_register_image_gallery_kirki_control_type' );
// Register our custom control with Kirki
function analytica_register_image_gallery_kirki_control_type( $controls ) {
    $controls['image_gallery'] = 'Kirki_Controls_Image_Gallery_Control';
    return $controls;
}