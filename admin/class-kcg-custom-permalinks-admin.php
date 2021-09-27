<?php
/**
 * KCG Custom Permalinks Admin.
 *
 * @package CustomPermalinks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create admin menu, add privacy policy etc.
 */
class Custom_Permalinks_Admin {
	/**
	 * Css file suffix extension.
	 *
	 * @var string
	 */
	private $css_file_suffix = '.min.css';

	/**
	 * Initializes WordPress hooks.
	 */
	public function __construct() {
		/*
		 * Css file suffix (version number with extension).
		 */
		$this->css_file_suffix = '-' . KCG_CUSTOM_PERMALINKS_VERSION . '.min.css';

		add_action( 'admin_init', array( $this, 'privacy_policy' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		
	}

	/**
	 * Added Pages in Menu for Settings.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return void
	 */
	public function admin_menu() {
		add_menu_page(
			'KCG Custom Permalinks',
			'KCG Custom Permalinks',
			'cp_view_post_permalinks',
			'cp-post-permalinks',
			array( $this, 'post_permalinks_page' ),
			'dashicons-admin-links'
		);
		$post_permalinks_hook     = add_submenu_page(
			'cp-post-permalinks',
			'Post Types Permalinks',
			'Post Types Permalinks',
			'cp_view_post_permalinks',
			'cp-post-permalinks',
			array( $this, 'post_permalinks_page' )
		);
	

		// add_action(
		// 	'load-' . $post_permalinks_hook,
		// 	'Custom_Permalinks_Post_Types_Table::instance'
		// );
		
		
	}

	/**
	 * Add about page style.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function add_about_style() {
		wp_enqueue_style(
			'custom-permalinks-about-style',
			plugins_url(
				'/assets/css/about-plugins' . $this->css_file_suffix,
				KCG_CUSTOM_PERMALINKS_FILE
			),
			array(),
			KCG_CUSTOM_PERMALINKS_VERSION
		);
	}

	/**
	 * Calls another Function which shows the Post Types Permalinks Page.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return void
	 */

	public  function output(){
		print <<< FOOBAR
		<div class="wrap">
			<h1 class="wp-heading-inline">
				Thank you For Installing KCG Custom Permalinks
			</h1>
				<div class="">
					<div>
						<h2>Documentation</h2>
						<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, incidunt.
						</p>
					</div>
					<div>
						<h2>Uses Guide</h2>
						<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, incidunt.
						</p>
					</div>
				</div>
			</div>
FOOBAR;
	}

	public function post_permalinks_page() {
		//Custom_Permalinks_Post_Types_Table::output();
		$this->output();
		add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ), 1 );
	}

	/**
	 * Calls another Function which shows the Taxonomies Permalinks Page.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return void
	 */
	

	/**
	 * Add About Plugins Page.
	 *
	 * @since 1.2.11
	 * @access public
	 *
	 * @return void
	 */
	

	/**
	 * Add Plugin Support and Follow Message in the footer of Admin Pages.
	 *
	 * @since 1.2.11
	 * @access public
	 *
	 * @return string Shows version, website link and twitter.
	 */
	public function admin_footer_text() {
		$cp_footer_text = __( 'KCG Custom Permalinks version', 'kcg-custom-permalinks' ) .
		' ' . KCG_CUSTOM_PERMALINKS_VERSION . ' ' .
		__( 'by', 'kcg-custom-permalinks' ) .
		' <a href="www.kingscrestglobal.com" target="_blank">' .
			__( 'kingscrestglobal.com', 'kcg-custom-permalinks' ) .
		'</a>' .
		' - ' .
		'Visit Us:' .
		' <a href="https://www.kingscrestglobal.com" target="_blank">' .
			__( 'kingscrestglobal', 'kcg-custom-permalinks' ) .
		'</a>';

		return $cp_footer_text;
	}

	/**
	 * Add About and Premium Settings Page Link on the Plugin Page under the
	 * Plugin Name.
	 *
	 * @since 1.2.11
	 * @access public
	 *
	 * @param array $links Contains the Plugin Basic Link (Activate/Deactivate/Delete).
	 *
	 * @return array Plugin Basic Links and added some custome link for Settings,
	 * Contact, and About.
	 */


	/**
	 * Add Privacy Policy about the Plugin.
	 *
	 * @since 1.2.23
	 * @access public
	 *
	 * @return void
	 */
	public function privacy_policy() {
		if ( ! function_exists( 'wp_add_privacy_policy_content' ) ) {
			return;
		}

		$cp_privacy = esc_html__(
			'This plugin doesn\'t collect any user related information.',
			'custom-permalinks'
		);
		$cp_privacy = $cp_privacy .
		' <a href="https://www.custompermalinks.com/contact-us/" target="_blank">' .
			esc_html__( 'contact us', 'custom-permalinks' ) .
		'</a>';

		wp_add_privacy_policy_content(
			'KCG Custom Permalinks',
			wp_kses_post( wpautop( $cp_privacy, false ) )
		);
	}
}

new Custom_Permalinks_Admin();
