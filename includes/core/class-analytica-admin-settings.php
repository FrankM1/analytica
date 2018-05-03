<?php
/**
 * Admin settings helper
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       Analytica 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Analytica_Admin_Settings' ) ) {

	/**
	 * Analytica Admin Settings
	 */
	class Analytica_Admin_Settings {

		/**
		 * View all actions
		 *
		 * @since 1.0
		 * @var array $view_actions
		 */
		static public $view_actions = array();

		/**
		 * Menu page title
		 *
		 * @since 1.0
		 * @var array $menu_page_title
		 */
		static public $menu_page_title = 'Analytica Theme';

		/**
		 * Page title
		 *
		 * @since 1.0
		 * @var array $page_title
		 */
		static public $page_title = 'Analytica';

		/**
		 * Plugin slug
		 *
		 * @since 1.0
		 * @var array $plugin_slug
		 */
		static public $plugin_slug = 'analytica';

		/**
		 * Default Menu position
		 *
		 * @since 1.0
		 * @var array $default_menu_position
		 */
		static public $default_menu_position = 'themes.php';

		/**
		 * Parent Page Slug
		 *
		 * @since 1.0
		 * @var array $parent_page_slug
		 */
		static public $parent_page_slug = 'general';

		/**
		 * Current Slug
		 *
		 * @since 1.0
		 * @var array $current_slug
		 */
		static public $current_slug = 'general';

		/**
		 * Constructor
		 */
		function __construct() {

			if ( ! is_admin() ) {
				return;
			}

			add_action( 'after_setup_theme', __CLASS__ . '::init_admin_settings', 99 );
		}

		/**
		 * Admin settings init
		 */
		static public function init_admin_settings() {
			self::$menu_page_title = apply_filters( 'analytica_menu_page_title', __( 'Analytica Options', 'analytica' ) );
			self::$page_title      = apply_filters( 'analytica_page_title', __( 'Analytica', 'analytica' ) );

			if ( isset( $_REQUEST['page'] ) && strpos( $_REQUEST['page'], self::$plugin_slug ) !== false ) {

				add_action( 'admin_enqueue_scripts', __CLASS__ . '::styles_scripts' );

				// Let extensions hook into saving.
				do_action( 'analytica_admin_settings_scripts' );

				self::save_settings();
			}

			add_action( 'admin_enqueue_scripts', __CLASS__ . '::admin_scripts' );

			add_action( 'customize_controls_enqueue_scripts', __CLASS__ . '::customizer_scripts' );

			add_action( 'admin_menu', __CLASS__ . '::add_admin_menu', 99 );

			add_action( 'analytica_menu_general_action', __CLASS__ . '::general_page' );

			add_action( 'analytica_header_right_section', __CLASS__ . '::top_header_right_section' );

			add_filter( 'admin_title', __CLASS__ . '::analytica_admin_title', 10, 2 );

			add_action( 'analytica_welcome_page_right_sidebar_content', __CLASS__ . '::analytica_welcome_page_starter_sites_section', 10 );
			add_action( 'analytica_welcome_page_right_sidebar_content', __CLASS__ . '::analytica_welcome_page_knowledge_base_scetion', 11 );
			add_action( 'analytica_welcome_page_right_sidebar_content', __CLASS__ . '::analytica_welcome_page_community_scetion', 12 );
			add_action( 'analytica_welcome_page_right_sidebar_content', __CLASS__ . '::analytica_welcome_page_five_star_scetion', 13 );
			add_action( 'analytica_welcome_page_right_sidebar_content', __CLASS__ . '::analytica_welcome_page_cloudways_scetion', 14 );

			add_action( 'analytica_welcome_page_content', __CLASS__ . '::analytica_welcome_page_content' );

			// AJAX.
			add_action( 'wp_ajax_analytica-sites-plugin-activate', __CLASS__ . '::required_plugin_activate' );
		}

		/**
		 * View actions
		 */
		static public function get_view_actions() {

			if ( empty( self::$view_actions ) ) {

				$actions            = array(
					'general' => array(
						'label' => __( 'Welcome', 'analytica' ),
						'show'  => ! is_network_admin(),
					),
				);
				self::$view_actions = apply_filters( 'analytica_menu_options', $actions );
			}

			return self::$view_actions;
		}

		/**
		 * Save All admin settings here
		 */
		static public function save_settings() {

			// Only admins can save settings.
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			// Let extensions hook into saving.
			do_action( 'analytica_admin_settings_save' );
		}

		/**
		 * Load the scripts and styles in the customizer controls.
		 *
		 * @since 1.2.1
		 */
		static public function customizer_scripts() {
			$color_palettes = json_encode( analytica_color_palette() );
			wp_add_inline_script( 'wp-color-picker', 'jQuery.wp.wpColorPicker.prototype.options.palettes = ' . $color_palettes . ';' );
		}

		/**
		 * Enqueues the needed CSS/JS for Backend.
		 *
		 * @since 1.0
		 */
		static public function admin_scripts() {

			// Styles.
			wp_enqueue_style( 'analytica-admin', ANALYTICA_THEME_URI . 'includes/assets/css/analytica-admin.css', array(), ANALYTICA_THEME_VERSION );

			/* Directory and Extension */
			$file_prefix = ( SCRIPT_DEBUG ) ? '' : '.min';
			$dir_name    = ( SCRIPT_DEBUG ) ? 'unminified' : 'minified';

			$assets_js_uri = ANALYTICA_THEME_URI . 'assets/js/' . $dir_name . '/';

			wp_enqueue_script( 'analytica-color-alpha', $assets_js_uri . 'wp-color-picker-alpha' . $file_prefix . '.js', array( 'jquery', 'customize-base', 'wp-color-picker' ), ANALYTICA_THEME_VERSION, true );
		}

		/**
		 * Enqueues the needed CSS/JS for the builder's admin settings page.
		 *
		 * @since 1.0
		 */
		static public function styles_scripts() {

			// Styles.
			wp_enqueue_style( 'analytica-admin-settings', ANALYTICA_THEME_URI . 'includes/assets/css/analytica-admin-menu-settings.css', array(), ANALYTICA_THEME_VERSION );
			// Script.
			wp_enqueue_script( 'analytica-admin-settings', ANALYTICA_THEME_URI . 'includes/assets/js/analytica-admin-menu-settings.js', array( 'jquery', 'wp-util', 'updates' ), ANALYTICA_THEME_VERSION );

			$localize = array(
				'ajaxUrl'             => admin_url( 'admin-ajax.php' ),
				'btnActivating'       => __( 'Activating Importer Plugin ', 'analytica' ) . '&hellip;',
				'analyticaSitesLink'      => admin_url( 'themes.php?page=analytica-sites' ),
				'analyticaSitesLinkTitle' => __( 'See Library »', 'analytica' ),
			);
			wp_localize_script( 'analytica-admin-settings', 'analytica', apply_filters( 'analytica_theme_js_localize', $localize ) );
		}

		/**
		 * Update Admin Title.
		 *
		 * @since 1.0.19
		 *
		 * @param string $admin_title Admin Title.
		 * @param string $title Title.
		 * @return string
		 */
		static public function analytica_admin_title( $admin_title, $title ) {

			$screen = get_current_screen();
			if ( 'appearance_page_analytica' == $screen->id ) {

				$view_actions = self::get_view_actions();

				$current_slug = isset( $_GET['action'] ) ? esc_attr( $_GET['action'] ) : self::$current_slug;
				$active_tab   = str_replace( '_', '-', $current_slug );

				if ( 'general' != $active_tab && isset( $view_actions[ $active_tab ]['label'] ) ) {
					$admin_title = str_replace( $title, $view_actions[ $active_tab ]['label'], $admin_title );
				}
			}

			return $admin_title;
		}


		/**
		 * Get and return page URL
		 *
		 * @param string $menu_slug Menu name.
		 * @since 1.0
		 * @return  string page url
		 */
		static public function get_page_url( $menu_slug ) {

			$parent_page = self::$default_menu_position;

			if ( strpos( $parent_page, '?' ) !== false ) {
				$query_var = '&page=' . self::$plugin_slug;
			} else {
				$query_var = '?page=' . self::$plugin_slug;
			}

			$parent_page_url = admin_url( $parent_page . $query_var );

			$url = $parent_page_url . '&action=' . $menu_slug;

			return esc_url( $url );
		}

		/**
		 * Add main menu
		 *
		 * @since 1.0
		 */
		static public function add_admin_menu() {

			$parent_page    = self::$default_menu_position;
			$page_title     = self::$menu_page_title;
			$capability     = 'manage_options';
			$page_menu_slug = self::$plugin_slug;
			$page_menu_func = __CLASS__ . '::menu_callback';

			if ( apply_filters( 'analytica_dashboard_admin_menu', true ) ) {
				add_theme_page( $page_title, $page_title, $capability, $page_menu_slug, $page_menu_func );
			} else {
				do_action( 'asta_register_admin_menu', $parent_page, $page_title, $capability, $page_menu_slug, $page_menu_func );
			}
		}

		/**
		 * Menu callback
		 *
		 * @since 1.0
		 */
		static public function menu_callback() {

			$current_slug = isset( $_GET['action'] ) ? esc_attr( $_GET['action'] ) : self::$current_slug;

			$active_tab   = str_replace( '_', '-', $current_slug );
			$current_slug = str_replace( '-', '_', $current_slug );

			$ast_icon           = apply_filters( 'analytica_page_top_icon', true );
			$ast_visit_site_url = apply_filters( 'analytica_site_url', 'https://wpanalytica.com' );
			$ast_wrapper_class  = apply_filters( 'analytica_welcome_wrapper_class', array( $current_slug ) );

			?>
			<div class="ast-menu-page-wrapper wrap ast-clear <?php echo esc_attr( implode( ' ', $ast_wrapper_class ) ); ?>">
					<div class="ast-theme-page-header">
						<div class="ast-container ast-flex">
							<div class="ast-theme-title">
								<a href="<?php echo esc_url( $ast_visit_site_url ); ?>" target="_blank" rel="noopener" >
								<?php if ( $ast_icon ) { ?>
									<img src="<?php echo esc_url( ANALYTICA_THEME_URI . 'includes/assets/images/analytica.svg' ); ?>" class="ast-theme-icon" alt="<?php echo esc_attr( self::$page_title ); ?> " >
								<?php } ?>
								<?php do_action( 'analytica_welcome_page_header_title' ); ?>
								</a>
							</div>

							<?php do_action( 'analytica_header_right_section' ); ?>

						</div>
					</div>

				<?php do_action( 'analytica_menu_' . esc_attr( $current_slug ) . '_action' ); ?>
			</div>
			<?php
		}

		/**
		 * Include general page
		 *
		 * @since 1.0
		 */
		static public function general_page() {
			require_once ANALYTICA_THEME_DIR . 'includes/core/view-general.php';
		}

		/**
		 * Include Welcome page right starter sites content
		 *
		 * @since 1.2.4
		 */
		static public function analytica_welcome_page_starter_sites_section() {
			?>

			<div class="postbox">
				<h2 class="hndle ast-normal-cusror">
					<span class="dashicons dashicons-admin-customizer"></span>
					<span><?php echo esc_html( apply_filters( 'analytica_sites_menu_page_title', __( 'Import Starter Site', 'analytica' ) ) ); ?></span>
				</h2>
				<div class="inside">
					<p>
						<?php
							$analytica_starter_sites_doc_link      = apply_filters( 'analytica_starter_sites_documentation_link', analytica_get_pro_url( 'https://wpanalytica.com/ready-websites/installing-importing-analytica-sites/', 'analytica-dashboard', 'how-analytica-sites-works', 'welcome-page' ) );
							$analytica_starter_sites_doc_link_text = apply_filters( 'analytica_starter_sites_doc_link_text', __( 'Starter Site Templates?', 'analytica' ) );
							printf(
								/* translators: %1$s: Starter site link. */
								esc_html__( 'Did you know %1$s offers a free library of %2$s ', 'analytica' ),
								self::$page_title,
								! empty( $analytica_starter_sites_doc_link ) ? '<a href=' . esc_url( $analytica_starter_sites_doc_link ) . ' target="_blank" rel="noopener">' . esc_html( $analytica_starter_sites_doc_link_text ) . '</a>' :
								esc_html( $analytica_starter_sites_doc_link_text )
							);
						?>
					</p>
					<p>
						<?php
							esc_html_e( 'Import your favorite site one click and start your project in style!', 'analytica' );
						?>
					</p>
						<?php
						// Analytica Sites - Installed but Inactive.
						// Analytica Premium Sites - Inactive.
						if ( file_exists( WP_PLUGIN_DIR . '/analytica-sites/analytica-sites.php' ) && is_plugin_inactive( 'analytica-sites/analytica-sites.php' ) && is_plugin_inactive( 'analytica-pro-sites/analytica-pro-sites.php' ) ) {

							$class       = 'button ast-sites-inactive';
							$button_text = __( 'Activate Importer Plugin', 'analytica' );
							$data_slug   = 'analytica-sites';
							$data_init   = '/analytica-sites/analytica-sites.php';

							// Analytica Sites - Not Installed.
							// Analytica Premium Sites - Inactive.
						} elseif ( ! file_exists( WP_PLUGIN_DIR . '/analytica-sites/analytica-sites.php' ) && is_plugin_inactive( 'analytica-pro-sites/analytica-pro-sites.php' ) ) {

							$class       = 'button ast-sites-notinstalled';
							$button_text = __( 'Install Importer Plugin', 'analytica' );
							$data_slug   = 'analytica-sites';
							$data_init   = '/analytica-sites/analytica-sites.php';

							// Analytica Premium Sites - Active.
						} elseif ( is_plugin_active( 'analytica-pro-sites/analytica-pro-sites.php' ) ) {
							$class       = 'active';
							$button_text = __( 'See Library »', 'analytica' );
							$link        = admin_url( 'themes.php?page=analytica-sites' );
						} else {
							$class       = 'active';
							$button_text = __( 'See Library »', 'analytica' );
							$link        = admin_url( 'themes.php?page=analytica-sites' );
						}

						printf(
							'<a class="%1$s" %2$s %3$s %4$s> %5$s </a>',
							esc_attr( $class ),
							isset( $link ) ? 'href="' . esc_url( $link ) . '"' : '',
							isset( $data_slug ) ? 'data-slug="' . esc_attr( $data_slug ) . '"' : '',
							isset( $data_init ) ? 'data-init="' . esc_attr( $data_init ) . '"' : '',
							esc_html( $button_text )
						);
						?>
					<div>
					</div>
				</div>
			</div>

		<?php
		}

		/**
		 * Include Welcome page right side knowledge base content
		 *
		 * @since 1.2.4
		 */
		static public function analytica_welcome_page_knowledge_base_scetion() {
			?>

			<div class="postbox">
				<h2 class="hndle ast-normal-cusror">
					<span class="dashicons dashicons-book"></span>
					<span><?php esc_html_e( 'Knowledge Base', 'analytica' ); ?></span>
				</h2>
				<div class="inside">
					<p>
						<?php esc_html_e( 'Not sure how something works? Take a peek at the knowledge base and learn.', 'analytica' ); ?>
					</p>
					<?php
					$analytica_knowledge_base_doc_link      = apply_filters( 'analytica_knowledge_base_documentation_link', analytica_get_pro_url( 'https://wpanalytica.com/docs/', 'analytica-dashboard', 'visit-documentation', 'welcome-page' ) );
					$analytica_knowledge_base_doc_link_text = apply_filters( 'analytica_knowledge_base_documentation_link_text', __( 'Visit Knowledge Base »', 'analytica' ) );

					printf(
						/* translators: %1$s: Analytica Knowledge doc link. */
						'%1$s',
						! empty( $analytica_knowledge_base_doc_link ) ? '<a href=' . esc_url( $analytica_knowledge_base_doc_link ) . ' target="_blank" rel="noopener">' . esc_html( $analytica_knowledge_base_doc_link_text ) . '</a>' :
						esc_html( $analytica_knowledge_base_doc_link_text )
					);
					?>
				</div>
			</div>
		<?php
		}

		/**
		 * Include Welcome page right side Analytica community content
		 *
		 * @since 1.2.4
		 */
		static public function analytica_welcome_page_community_scetion() {
			?>

			<div class="postbox">
				<h2 class="hndle ast-normal-cusror">
					<span class="dashicons dashicons-groups"></span>
					<span>
						<?php
						printf(
							/* translators: %1$s: Analytica Theme name. */
							esc_html__( '%1$s Community', 'analytica' ),
							self::$page_title
						);
						?>
				</h2>
				<div class="inside">
					<p>
						<?php
						printf(
							/* translators: %1$s: Analytica Theme name. */
							esc_html__( 'Join the community of super helpful %1$s users. Say hello, ask questions, give feedback and help each other!', 'analytica' ),
							self::$page_title
						);
						?>
					</p>
					<?php
					$analytica_community_group_link      = apply_filters( 'analytica_community_group_link', 'https://www.facebook.com/groups/wpanalytica' );
					$analytica_community_group_link_text = apply_filters( 'analytica_community_group_link_text', __( 'Join Our Facebook Group »', 'analytica' ) );

					printf(
						/* translators: %1$s: Analytica Knowledge doc link. */
						'%1$s',
						! empty( $analytica_community_group_link ) ? '<a href=' . esc_url( $analytica_community_group_link ) . ' target="_blank" rel="noopener">' . esc_html( $analytica_community_group_link_text ) . '</a>' :
						esc_html( $analytica_community_group_link_text )
					);
					?>
				</div>
			</div>
		<?php
		}

		/**
		 * Include Welcome page right side Five Star Support
		 *
		 * @since 1.2.4
		 */
		static public function analytica_welcome_page_five_star_scetion() {
			?>

			<div class="postbox">
				<h2 class="hndle ast-normal-cusror">
					<span class="dashicons dashicons-sos"></span>
					<span><?php esc_html_e( 'Five Star Support', 'analytica' ); ?></span>
				</h2>
				<div class="inside">
					<p>
						<?php
						printf(
							/* translators: %1$s: Analytica Theme name. */
							esc_html__( 'Got a question? Get in touch with %1$s developers. We\'re happy to help!', 'analytica' ),
							self::$page_title
						);
						?>
					</p>
					<?php
						$analytica_support_link      = apply_filters( 'analytica_support_link', analytica_get_pro_url( 'https://wpanalytica.com/contact/', 'analytica-dashboard', 'submit-a-ticket', 'welcome-page' ) );
						$analytica_support_link_text = apply_filters( 'analytica_support_link_text', __( 'Submit a Ticket »', 'analytica' ) );

						printf(
							/* translators: %1$s: Analytica Knowledge doc link. */
							'%1$s',
							! empty( $analytica_support_link ) ? '<a href=' . esc_url( $analytica_support_link ) . ' target="_blank" rel="noopener">' . esc_html( $analytica_support_link_text ) . '</a>' :
							esc_html( $analytica_support_link_text )
						);
					?>
				</div>
			</div>
		<?php
		}

		/**
		 * Include Welcome page right side Cloudways
		 *
		 * @since 1.2.6
		 */
		static public function analytica_welcome_page_cloudways_scetion() {
			?>

			<div class="postbox">
				<h2 class="hndle">
					<span class="dashicons dashicons-heart"></span>
					<span><?php esc_html_e( 'Recommended Hosting', 'analytica' ); ?></span>
				</h2>
					<div class="inside">
						<p>
							<?php esc_html_e( 'A fast theme gets faster with a great host!', 'analytica' ); ?>
						</p>
						<p>
							<?php
								printf(
									/* translators: %1$s: Analytica Theme name. */
									esc_html__( '%1$s proudly recommends Cloudways to anyone looking for speedy hosting.', 'analytica' ),
									self::$page_title
								);
							?>
						</p>
						<?php
						$analytica_cloudways_link      = apply_filters( 'analytica_cloudways_link', 'http://pxlme.me/ETClRjv5' );
						$analytica_cloudways_link_text = apply_filters( 'analytica_analytica_cloudways_link_text', __( 'Check Cloudways Hosting »', 'analytica' ) );

						printf(
							/* translators: %1$s: Analytica Cloudways Hosting link. */
							'%1$s',
							! empty( $analytica_cloudways_link ) ? '<a href=' . esc_url( $analytica_cloudways_link ) . ' target="_blank" rel="noopener">' . esc_html( $analytica_cloudways_link_text ) . '</a>' :
							esc_html( $analytica_cloudways_link_text )
						);
						?>
				</div>
			</div>
		<?php
		}


		/**
		 * Include Welcome page content
		 *
		 * @since 1.2.4
		 */
		static public function analytica_welcome_page_content() {

			$analytica_addon_tagline = apply_filters( 'analytica_addon_list_tagline', __( 'More Options Available with Analytica Pro!', 'analytica' ) );

			// Quick settings.
			$quick_settings = apply_filters(
				'analytica_quick_settings', array(
					'logo-favicon' => array(
						'title'     => __( 'Upload Logo', 'analytica' ),
						'dashicon'  => 'dashicons-format-image',
						'quick_url' => admin_url( 'customize.php?autofocus[control]=custom_logo' ),
					),
					'colors'       => array(
						'title'     => __( 'Set Colors', 'analytica' ),
						'dashicon'  => 'dashicons-admin-customizer',
						'quick_url' => admin_url( 'customize.php?autofocus[panel]=panel-colors-background' ),
					),
					'typography'   => array(
						'title'     => __( 'Customize Fonts', 'analytica' ),
						'dashicon'  => 'dashicons-editor-textcolor',
						'quick_url' => admin_url( 'customize.php?autofocus[panel]=panel-typography' ),
					),
					'layout'       => array(
						'title'     => __( 'Layout Options', 'analytica' ),
						'dashicon'  => 'dashicons-layout',
						'quick_url' => admin_url( 'customize.php?autofocus[panel]=panel-layout' ),
					),
					'header'       => array(
						'title'     => __( 'Header Options', 'analytica' ),
						'dashicon'  => 'dashicons-align-center',
						'quick_url' => admin_url( 'customize.php?autofocus[section]=section-header' ),
					),
					'blog-layout'  => array(
						'title'     => __( 'Blog Layouts', 'analytica' ),
						'dashicon'  => 'dashicons-welcome-write-blog',
						'quick_url' => admin_url( 'customize.php?autofocus[section]=section-blog-group' ),
					),
					'footer'       => array(
						'title'     => __( 'Footer Settings', 'analytica' ),
						'dashicon'  => 'dashicons-admin-generic',
						'quick_url' => admin_url( 'customize.php?autofocus[section]=section-footer-group' ),
					),
					'sidebars'     => array(
						'title'     => __( 'Sidebar Options', 'analytica' ),
						'dashicon'  => 'dashicons-align-left',
						'quick_url' => admin_url( 'customize.php?autofocus[section]=section-sidebars' ),
					),
				)
			);

			$extensions = apply_filters(
				'analytica_addon_list', array(
					'colors-and-background' => array(
						'title'     => __( 'Colors & Background', 'analytica' ),
						'class'     => 'ast-addon',
						'title_url' => analytica_get_pro_url( 'https://wpanalytica.com/docs/colors-background-module/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
						'links'     => array(
							array(
								'link_class'   => 'ast-learn-more',
								'link_url'     => analytica_get_pro_url( 'https://wpanalytica.com/docs/colors-background-module/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
								'link_text'    => __( 'Learn More »', 'analytica' ),
								'target_blank' => true,
							),
						),
					),
					'typography'            => array(
						'title'     => __( 'Typography', 'analytica' ),
						'class'     => 'ast-addon',
						'title_url' => analytica_get_pro_url( 'https://wpanalytica.com/docs/typography-module/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
						'links'     => array(
							array(
								'link_class'   => 'ast-learn-more',
								'link_url'     => analytica_get_pro_url( 'https://wpanalytica.com/docs/typography-module/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
								'link_text'    => __( 'Learn More »', 'analytica' ),
								'target_blank' => true,
							),
						),
					),
					'spacing'               => array(
						'title'     => __( 'Spacing', 'analytica' ),
						'class'     => 'ast-addon',
						'title_url' => analytica_get_pro_url( 'https://wpanalytica.com/docs/spacing-addon-overview/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
						'links'     => array(
							array(
								'link_class'   => 'ast-learn-more',
								'link_url'     => analytica_get_pro_url( 'https://wpanalytica.com/docs/spacing-addon-overview/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
								'link_text'    => __( 'Learn More »', 'analytica' ),
								'target_blank' => true,
							),
						),
					),
					'blog-pro'              => array(
						'title'     => __( 'Blog Pro', 'analytica' ),
						'class'     => 'ast-addon',
						'title_url' => analytica_get_pro_url( 'https://wpanalytica.com/docs/blog-pro-overview/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
						'links'     => array(
							array(
								'link_class'   => 'ast-learn-more',
								'link_url'     => analytica_get_pro_url( 'https://wpanalytica.com/docs/blog-pro-overview/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
								'link_text'    => __( 'Learn More »', 'analytica' ),
								'target_blank' => true,
							),
						),
					),
					'header-sections'       => array(
						'title'     => __( 'Header Sections', 'analytica' ),
						'class'     => 'ast-addon',
						'title_url' => analytica_get_pro_url( 'https://wpanalytica.com/docs/header-sections-pro/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
						'links'     => array(
							array(
								'link_class'   => 'ast-learn-more',
								'link_url'     => analytica_get_pro_url( 'https://wpanalytica.com/docs/header-sections-pro/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
								'link_text'    => __( 'Learn More »', 'analytica' ),
								'target_blank' => true,
							),
						),
					),
					'transparent-header'    => array(
						'title'     => __( 'Transparent Header', 'analytica' ),
						'class'     => 'ast-addon',
						'title_url' => analytica_get_pro_url( 'https://wpanalytica.com/docs/transparent-header-pro/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
						'links'     => array(
							array(
								'link_class'   => 'ast-learn-more',
								'link_url'     => analytica_get_pro_url( 'https://wpanalytica.com/docs/transparent-header-pro/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
								'link_text'    => __( 'Learn More »', 'analytica' ),
								'target_blank' => true,
							),
						),
					),
					'sticky-header'         => array(
						'title'     => __( 'Sticky Header', 'analytica' ),
						'class'     => 'ast-addon',
						'title_url' => analytica_get_pro_url( 'https://wpanalytica.com/docs/sticky-header-pro/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
						'links'     => array(
							array(
								'link_class'   => 'ast-learn-more',
								'link_url'     => analytica_get_pro_url( 'https://wpanalytica.com/docs/sticky-header-pro/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
								'link_text'    => __( 'Learn More »', 'analytica' ),
								'target_blank' => true,
							),
						),
					),
					'advanced-headers'      => array(
						'title'           => __( 'Page Headers', 'analytica' ),
						// 'icon'            => ANALYTICA_EXT_URI . 'assets/img/advanced-headers.png',
						'description'     => __( 'Make your header layouts look more appealing and sexy!', 'analytica' ),
						'manage_settings' => true,
						'class'           => 'ast-addon',
						'title_url'       => analytica_get_pro_url( 'https://wpanalytica.com/pro', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
						'links'           => array(
							array(
								'link_class'   => 'ast-learn-more',
								'link_url'     => analytica_get_pro_url( 'https://wpanalytica.com/pro', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
								'link_text'    => __( 'Learn More »', 'analytica' ),
								'target_blank' => true,
							),
						),
					),
					'advanced-hooks'        => array(
						'title'           => __( 'Custom Layouts', 'analytica' ),
						// 'icon'            => ANALYTICA_EXT_URI . 'assets/img/analytica-advanced-hooks.png',
						'description'     => __( 'Add content conditionally in the various hook areas of the theme.', 'analytica' ),
						'manage_settings' => true,
						'class'           => 'ast-addon',
						'title_url'       => analytica_get_pro_url( 'https://wpanalytica.com/docs/custom-layouts-pro/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
						'links'           => array(
							array(
								'link_class'   => 'ast-learn-more',
								'link_url'     => analytica_get_pro_url( 'https://wpanalytica.com/docs/custom-layouts-pro/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
								'link_text'    => __( 'Learn More »', 'analytica' ),
								'target_blank' => true,
							),
						),
					),
					'site-layouts'          => array(
						'title'     => __( 'Site Layouts', 'analytica' ),
						'class'     => 'ast-addon',
						'title_url' => analytica_get_pro_url( 'https://wpanalytica.com/docs/site-layout-overview/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
						'links'     => array(
							array(
								'link_class'   => 'ast-learn-more',
								'link_url'     => analytica_get_pro_url( 'https://wpanalytica.com/docs/site-layout-overview/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
								'link_text'    => __( 'Learn More »', 'analytica' ),
								'target_blank' => true,
							),
						),
					),
					'advanced-footer'       => array(
						'title'     => __( 'Footer Widgets', 'analytica' ),
						'class'     => 'ast-addon',
						'title_url' => analytica_get_pro_url( 'https://wpanalytica.com/docs/footer-widgets-analytica-pro/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
						'links'     => array(
							array(
								'link_class'   => 'ast-learn-more',
								'link_url'     => analytica_get_pro_url( 'https://wpanalytica.com/docs/footer-widgets-analytica-pro/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
								'link_text'    => __( 'Learn More »', 'analytica' ),
								'target_blank' => true,
							),
						),
					),
					'scroll-to-top'         => array(
						'title'     => __( 'Scroll To Top', 'analytica' ),
						'class'     => 'ast-addon',
						'title_url' => analytica_get_pro_url( 'https://wpanalytica.com/docs/scroll-to-top-pro/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
						'links'     => array(
							array(
								'link_class'   => 'ast-learn-more',
								'link_url'     => analytica_get_pro_url( 'https://wpanalytica.com/docs/scroll-to-top-pro/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
								'link_text'    => __( 'Learn More »', 'analytica' ),
								'target_blank' => true,
							),
						),
					),
					'woocommerce'           => array(
						'title'     => __( 'WooCommerce', 'analytica' ),
						'class'     => 'ast-addon',
						'title_url' => analytica_get_pro_url( 'https://wpanalytica.com/docs/woocommerce-module-overview/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
						'links'     => array(
							array(
								'link_class'   => 'ast-learn-more',
								'link_url'     => analytica_get_pro_url( 'https://wpanalytica.com/docs/woocommerce-module-overview/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
								'link_text'    => __( 'Learn More »', 'analytica' ),
								'target_blank' => true,
							),
						),
					),
					'learndash'             => array(
						'title'       => __( 'LearnDash', 'analytica' ),
						'description' => __( 'Supercharge your LearnDash website with amazing design features.', 'analytica' ),
						'class'       => 'ast-addon',
						'title_url'   => analytica_get_pro_url( 'https://wpanalytica.com/docs/learndash-integration-overview/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
						'links'       => array(
							array(
								'link_class'   => 'ast-learn-more',
								'link_url'     => analytica_get_pro_url( 'https://wpanalytica.com/docs/lifterlms-module-pro/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
								'link_text'    => __( 'Learn More »', 'analytica' ),
								'target_blank' => true,
							),
						),
					),
					'lifterlms'             => array(
						'title'     => __( 'LifterLMS', 'analytica' ),
						'class'     => 'ast-addon',
						'title_url' => analytica_get_pro_url( 'https://wpanalytica.com/docs/lifterlms-module-pro/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
						'links'     => array(
							array(
								'link_class'   => 'ast-learn-more',
								'link_url'     => analytica_get_pro_url( 'https://wpanalytica.com/docs/lifterlms-module-pro/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
								'link_text'    => __( 'Learn More »', 'analytica' ),
								'target_blank' => true,
							),
						),
					),
					'white-label'           => array(
						'title'     => __( 'White Label', 'analytica' ),
						'class'     => 'ast-addon',
						'title_url' => analytica_get_pro_url( 'https://wpanalytica.com/introducing-white-label/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
						'links'     => array(
							array(
								'link_class'   => 'ast-learn-more',
								'link_url'     => analytica_get_pro_url( 'https://wpanalytica.com/introducing-white-label/', 'analytica-dashboard', 'learn-more', 'welcome-page' ),
								'link_text'    => __( 'Learn More »', 'analytica' ),
								'target_blank' => true,
							),
						),
					),

				)
			);
			?>
			<div class="postbox">
				<h2 class="hndle ast-normal-cusror"><span><?php esc_html_e( 'Links to Customizer Settings:', 'analytica' ); ?></span></h2>
					<div class="ast-quick-setting-section">
						<?php
						if ( ! empty( $quick_settings ) ) :
							?>
							<div class="ast-quick-links">
								<ul class="ast-flex">
									<?php
									foreach ( (array) $quick_settings as $key => $link ) {
										echo '<li class=""><span class="dashicons ' . esc_attr( $link['dashicon'] ) . '"></span><a class="ast-quick-setting-title" href="' . esc_url( $link['quick_url'] ) . '" target="_blank" rel="noopener">' . esc_html( $link['title'] ) . '</a></li>';
									}
									?>
								</ul>
							</div>
						<?php endif; ?>
					</div>
			</div>

			<!-- Notice for Older version of Analytica Addon -->
			<?php self::min_addon_version_message(); ?>

			<div class="postbox">
				<h2 class="hndle ast-normal-cusror ast-addon-heading ast-flex"><span><?php echo esc_html( $analytica_addon_tagline ); ?></span>
					<?php do_action( 'analytica_addon_bulk_action' ); ?>
				</h2>
					<div class="ast-addon-list-section">
						<?php
						if ( ! empty( $extensions ) ) :
							?>
							<div>
								<ul class="ast-addon-list">
									<?php
									foreach ( (array) $extensions as $addon => $info ) {
										$title_url     = ( isset( $info['title_url'] ) && ! empty( $info['title_url'] ) ) ? 'href="' . esc_url( $info['title_url'] ) . '"' : '';
										$anchor_target = ( isset( $info['title_url'] ) && ! empty( $info['title_url'] ) ) ? "target='_blank' rel='noopener'" : '';

										echo '<li id="' . esc_attr( $addon ) . '"  class="' . esc_attr( $info['class'] ) . '"><a class="ast-addon-title"' . $title_url . $anchor_target . ' >' . esc_html( $info['title'] ) . '</a><div class="ast-addon-link-wrapper">';

										foreach ( $info['links'] as $key => $link ) {
											printf(
												'<a class="%1$s" %2$s %3$s> %4$s </a>',
												esc_attr( $link['link_class'] ),
												isset( $link['link_url'] ) ? 'href="' . esc_url( $link['link_url'] ) . '"' : '',
												( isset( $link['target_blank'] ) && $link['target_blank'] ) ? 'target="_blank" rel="noopener"' : '',
												esc_html( $link['link_text'] )
											);
										}
										echo '</div></li>';
									}
									?>
								</ul>
							</div>
						<?php endif; ?>
					</div>
			</div>

		<?php
		}

		/**
		 * Required Plugin Activate
		 *
		 * @since 1.2.4
		 */
		static public function required_plugin_activate() {

			if ( ! current_user_can( 'install_plugins' ) || ! isset( $_POST['init'] ) || ! $_POST['init'] ) {
				wp_send_json_error(
					array(
						'success' => false,
						'message' => __( 'No plugin specified', 'analytica' ),
					)
				);
			}

			$plugin_init = ( isset( $_POST['init'] ) ) ? esc_attr( $_POST['init'] ) : '';

			$activate = activate_plugin( $plugin_init, '', false, true );

			if ( is_wp_error( $activate ) ) {
				wp_send_json_error(
					array(
						'success' => false,
						'message' => $activate->get_error_message(),
					)
				);
			}

			wp_send_json_success(
				array(
					'success' => true,
					'message' => __( 'Plugin Successfully Activated', 'analytica' ),
				)
			);

		}

		/**
		 * Check compatible theme version.
		 *
		 * @since 1.2.4
		 */
		static public function min_addon_version_message() {

			$analytica_global_options = get_option( 'analytica-settings' );

			if ( isset( $analytica_global_options['analytica-addon-auto-version'] ) && defined( 'ANALYTICA_EXT_VER' ) ) {

				if ( version_compare( $analytica_global_options['analytica-addon-auto-version'], '1.2.1' ) < 0 ) {

					// If addon is not updated & White Label for Addon is added then show the white labelewd pro name.
					$analytica_addon_name        = analytica_get_addon_name();
					$update_analytica_addon_link = analytica_get_pro_url( 'https://wpanalytica.com/?p=25258', 'analytica-dashboard', 'update-to-analytica-pro', 'welcome-page' );
					if ( class_exists( 'Analytica_Ext_White_Label_Markup' ) ) {
						$plugin_data = Analytica_Ext_White_Label_Markup::$branding;
						if ( ! empty( $plugin_data['analytica-pro']['name'] ) ) {
							$update_analytica_addon_link = '';
						}
					}

					$class   = 'ast-notice ast-notice-error';
					$message = sprintf(
						/* translators: %1$1s: Addon Name, %2$2s: Minimum Required version of the Analytica Addon */
						__( 'Update to the latest version of %1$2s to make changes in settings below.', 'analytica' ),
						( ! empty( $update_analytica_addon_link ) ) ? '<a href=' . esc_url( $update_analytica_addon_link ) . ' target="_blank" rel="noopener">' . $analytica_addon_name . '</a>' : $analytica_addon_name
					);

					printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
				}
			}
		}

		/**
		 * Analytica Header Right Section Links
		 *
		 * @since 1.2.4
		 */
		static public function top_header_right_section() {

			$top_links = apply_filters(
				'analytica_header_top_links', array(
					'analytica-theme-info' => array(
						'title' => __( 'Stylish, Lightning Fast & Easily Customizable Theme!', 'analytica' ),
					),
				)
			);

			if ( ! empty( $top_links ) ) {
				?>
				<div class="ast-top-links">
					<ul>
						<?php
						foreach ( (array) $top_links as $key => $info ) {
							/* translators: %1$s: Top Link URL wrapper, %2$s: Top Link URL, %3$s: Top Link URL target attribute */
							printf(
								'<li><%1$s %2$s %3$s > %4$s </%1$s>',
								isset( $info['url'] ) ? 'a' : 'span',
								isset( $info['url'] ) ? 'href="' . esc_url( $info['url'] ) . '"' : '',
								isset( $info['url'] ) ? 'target="_blank" rel="noopener"' : '',
								esc_html( $info['title'] )
							);
						}
						?>
						</ul>
					</div>
				<?php
			}
		}
	}

	new Analytica_Admin_Settings;
}
