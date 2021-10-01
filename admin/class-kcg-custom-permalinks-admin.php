<?php
/**
 * KCG Custom Permalinks Admin.
 *
 * @package KCGCustomPermalinks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create admin menu, add privacy policy etc.
 */
class Custom_Permalinks_Admin {

	public function __construct() {
		
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		
	}

	public function admin_menu() {
		add_menu_page(
			'KCG Custom Permalinks',
			'KCG Custom Permalinks',
			'cp_view_post_permalinks',
			'kcg-cp-permalinks',
			array( $this, 'post_permalinks_page' ),
			'dashicons-admin-links'
		);
		$post_permalinks_hook     = add_submenu_page(
			'kcg-cp-permalinks',
			'Post Types Permalinks',
			'Post Types Permalinks',
			'cp_view_post_permalinks',
			'kcg-cp-permalinks',
			array( $this, 'post_permalinks_page' )
		);
		
		
	}

	public function kcg_load_style() {
		wp_enqueue_style(
			'custom-permalinks-about-style',
			plugins_url(
				'/assets/css/kcg-plugins.min.css',
				KCG_CUSTOM_PERMALINKS_FILE
			),
			array(),
			KCG_CUSTOM_PERMALINKS_VERSION
		);
	}

	
	public  function kcg_admin_content(){
		$content = '<div class="wrap">
			<h1 class="wp-heading-inline">
				Thank you For Installing KCG Custom Permalinks '.KCG_CUSTOM_PERMALINKS_VERSION.'
			</h1>
			
			<hr>
				<div class="kcg_admin_parent_container">
					<div class="kcg_admin_container">
						<h2>Documentation </h2>
						<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, incidunt.
						</p>
					</div>
					<div class="kcg_admin_container">
						<h2>Uses Guide</h2>
						<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, incidunt.
						</p>
					</div>
				</div>
			</div>';
			echo  $content;
	}

	public function post_permalinks_page() {
		$this->kcg_load_style();
		$this->kcg_admin_content();
		
		add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ), 5 );
		
	}

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
	
}

new Custom_Permalinks_Admin();


