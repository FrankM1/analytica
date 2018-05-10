<?php
/**
 * Analytica Theme About Page logic.
 *
 * @package Analytica
 */

add_action('after_setup_theme', 'analytica_admin_setup');
/**
 * Theme setup wizard
 *
 * @return void
 */
function analytica_admin_setup() {
	/**
	 * Load the About page class
	 */
	require_once 'ti-about-page/class-ti-about-page.php';

	/*
	* About page instance
	*/
	$config = array(
		// Menu name under Appearance.
		'menu_name' => esc_html__( 'About Analytica', 'analytica' ),
		// Page title.
		'page_name' => esc_html__( 'About Analytica', 'analytica' ),
		// Main welcome title
		'welcome_title' => sprintf( esc_html__( 'Welcome to %s! - Version ', 'analytica' ), 'Analytica' ),
		// Main welcome content
		'welcome_content' => esc_html__( ' Analytica is a free magazine-style theme with clean type, smart layouts and a design flexibility that makes it perfect for publishers of all kinds.', 'analytica' ),
		/**
		 * Tabs array.
		 *
		 * The key needs to be ONLY consisted from letters and underscores. If we want to define outside the class a function to render the tab,
		 * the will be the name of the function which will be used to render the tab content.
		 */
		'tabs'                    => array(
			'getting_started'     => esc_html__( 'Getting Started', 'analytica' ),
			'recommended_actions' => esc_html__( 'Recommended Actions', 'analytica' ),
			'recommended_plugins' => esc_html__( 'Useful Plugins','analytica' ),
			'support'             => esc_html__( 'Support', 'analytica' ),
			'changelog'           => esc_html__( 'Changelog', 'analytica' ),
		),
		// Support content tab.
		'support_content'      => array(
			'first' => array (
				'title'        => esc_html__( 'Contact Support','analytica' ),
				'icon'         => 'dashicons dashicons-sos',
				'text'         => __( 'We want to make sure you have the best experience using Analytica. Please post your question in our community forums.','analytica' ),
				'button_label' => esc_html__( 'Contact Support','analytica' ),
				'button_link'  => esc_url( 'https://wordpress.org/support/theme/analytica' ),
				'is_button'    => true,
				'is_new_tab'   => true
			),
			'second' => array(
				'title'        => esc_html__( 'Documentation','analytica' ),
				'icon'         => 'dashicons dashicons-book-alt',
				'text'         => esc_html__( 'Need more details? Please check our full documentation for detailed information on how to use Analytica.','analytica' ),
				'button_label' => esc_html__( 'Read The Documentation','analytica' ),
				'button_link'  => 'https://qazana.net/analytica-documentation/',
				'is_button'    => false,
				'is_new_tab'   => true
			)
		),
		// Getting started tab
		'getting_started' => array(
			'first' => array(
				'title'               => esc_html__( 'Go to Customizer','analytica' ),
				'text'                => esc_html__( 'Using the WordPress Customizer you can easily customize every aspect of the theme.','analytica' ),
				'button_label'        => esc_html__( 'Go to Customizer','analytica' ),
				'button_link'         => esc_url( admin_url( 'customize.php' ) ),
				'is_button'           => true,
				'recommended_actions' => false,
				'is_new_tab'          => true
			),
			'second' => array (
				'title'               => esc_html__( 'Recommended actions','analytica' ),
				'text'                => esc_html__( 'We have compiled a list of steps for you, to take make sure the experience you will have using one of our products is very easy to follow.','analytica' ),
				'button_label'        => esc_html__( 'Recommended actions','analytica' ),
				'button_link'         => esc_url( admin_url( 'themes.php?page=analytica-welcome&tab=recommended_actions' ) ),
				'button_ok_label'     => esc_html__( 'You are good to go!','analytica' ),
				'is_button'           => false,
				'recommended_actions' => true,
				'is_new_tab'          => false
			),
			'third' => array(
				'title'               => esc_html__( 'Read the documentation','analytica' ),
				'text'                => esc_html__( 'Need more details? Please check our full documentation for detailed information on how to use Analytica.','analytica' ),
				'button_label'        => esc_html__( 'Documentation','analytica' ),
				'button_link'         => 'https://qazana.net/analytica-documentation/',
				'is_button'           => false,
				'recommended_actions' => false,
				'is_new_tab'          => true
			)
		),
		// Plugins array.
		'recommended_plugins'        => array(
			'already_activated_message' => esc_html__( 'Already activated', 'analytica' ),
			'version_label'             => esc_html__( 'Version: ', 'analytica' ),
			'install_label'             => esc_html__( 'Install and Activate', 'analytica' ),
			'activate_label'            => esc_html__( 'Activate', 'analytica' ),
			'deactivate_label'          => esc_html__( 'Deactivate', 'analytica' ),
			'content'                   => array(
				array(
					'slug' => 'qazana'
				),
			),
		),
		// Required actions array.
		'recommended_actions'        => array(
			'install_label'    => esc_html__( 'Install and Activate', 'analytica' ),
			'activate_label'   => esc_html__( 'Activate', 'analytica' ),
			'deactivate_label' => esc_html__( 'Deactivate', 'analytica' ),
			'content'          => array(
				'kirki' => array(
					'title'       => 'Kirki',
					'description' => __( 'It is highly recommended that you install Kirki so you can access more customizer options.', 'hive-lite' ),
					'check'       => class_exists( 'Kirki' ),
					'plugin_slug' => 'kirki',
					'id'          => 'kirki'
				),
			),
		),
    );
    
	TI_About_Page::init( $config );
}
