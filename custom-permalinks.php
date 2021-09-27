<?php
/**
 * Plugin Name: KCG KCG Custom Permalinks
 * Plugin URI: https://www.kingscrestglobal.com/kcg/custom-permalinks
 * Description: Set KCG Custom Permalinks on a per-post page basis.
 * Version: 0.0.1
 * Requires at least: 2.6
 * Requires PHP: 5.4
 * Author: kingscrestglobal
 * Author URI: https://www.kingscrestglobal.com
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * Text Domain: kcg-custom-permalinks
 * Domain Path: /languages/
 *
 * @package KCGCustomPermalinks
 */



if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'KCG_CUSTOM_PERMALINKS_FILE' ) ) {
	define( 'KCG_CUSTOM_PERMALINKS_FILE', __FILE__ );
}

// Include the main KCG Custom Permalinks class.
require_once plugin_dir_path( KCG_CUSTOM_PERMALINKS_FILE ) . 'includes/class-kcg-custom-permalinks.php';
