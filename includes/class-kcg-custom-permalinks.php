<?php
/**
 * KCG Custom Permalinks setup.
 *
 * @package KCGCustomPermalinks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main KCG Custom Permalinks class.
 */
class KCG_Custom_Permalinks {
	/**
	 * KCG Custom Permalinks version.
	 *
	 * @var string
	 */
	public $version = '0.0.1';

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->define_constants();
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Define KCG Custom Permalinks Constants.
	 *
	 * @since 2.0.0
	 * @access private
	 */
	private function define_constants() {
		$this->define( 'CUSTOM_PERMALINKS_BASENAME', plugin_basename( KCG_CUSTOM_PERMALINKS_FILE ) );
		$this->define( 'KCG_CUSTOM_PERMALINKS_PATH', plugin_dir_path( KCG_CUSTOM_PERMALINKS_FILE ) );
		$this->define( 'KCG_CUSTOM_PERMALINKS_VERSION', $this->version );
	}

	/**
	 * Define constant if not set already.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @param string      $name  Constant name.
	 * @param string|bool $value Constant value.
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 *
	 * @since 1.2.18
	 * @access private
	 */
	private function includes() {
		include_once KCG_CUSTOM_PERMALINKS_PATH . 'includes/class-kcg-custom-permalinks-form.php';
		include_once KCG_CUSTOM_PERMALINKS_PATH . 'includes/class-kcg-custom-permalinks-frontend.php';
		include_once KCG_CUSTOM_PERMALINKS_PATH . 'admin/class-kcg-custom-permalinks-admin.php';

		$cp_form = new Custom_Permalinks_Form();
		$cp_form->init();

		$cp_frontend = new Custom_Permalinks_Frontend();
		$cp_frontend->init();
	}

	/**
	 * Hook into actions and filters.
	 *
	 * @since 2.0.0
	 * @access private
	 */
	private function init_hooks() {
		register_activation_hook(
			KCG_CUSTOM_PERMALINKS_FILE,
			array( 'KCG_Custom_Permalinks', 'add_roles' )
		);
		add_action( 'plugins_loaded', array( $this, 'check_loaded_plugins' ) );
	}

	
	public static function add_roles() {
		$admin_role      = get_role( 'administrator' );
		$cp_role         = get_role( 'kcg_custom_permalinks_manager' );
		$current_version = get_option( 'custom_permalinks_plugin_version', -1 );

		if ( ! empty( $admin_role ) ) {
			$admin_role->add_cap( 'kcg_cp_view_post_permalinks' );
			$admin_role->add_cap( 'kcg_cp_view_category_permalinks' );
		}

		if ( empty( $cp_role ) ) {
			add_role(
				'kcg_custom_permalinks_manager',
				__( 'KCG Custom Permalinks Manager' ),
				array(
					'kcg_cp_view_post_permalinks'     => true,
					'kcg_cp_view_category_permalinks' => true,
				)
			);
		}
	}

	public function check_loaded_plugins() {
		if ( is_admin() ) {
			$current_version = get_option( 'custom_permalinks_plugin_version', -1 );

			if ( -1 === $current_version
				|| $current_version < KCG_CUSTOM_PERMALINKS_VERSION
			) {
				
				self::add_roles();
			}
		}

		load_plugin_textdomain(
			'custom-permalinks',
			false,
			basename( dirname( KCG_CUSTOM_PERMALINKS_FILE ) ) . '/languages/'
		);
	}
}

new KCG_Custom_Permalinks();
