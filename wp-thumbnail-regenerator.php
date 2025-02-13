<?php
/**
 * Plugin Name: WP Thumbnail Regenerator
 * Plugin URI:  https://wbcl-innovation.com/
 * Description: Regenerates thumbnails and tracks progress with a clean admin UI.
 * Version:     1.0.0
 * Author:      WBCL Innovation Labs
 * Author URI:  https://wbcl-innovation.com/
 * License:     GPL v2 or later
 * Text Domain: wp-thumbnail-regenerator
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Define plugin path
define('WPTR_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('WPTR_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include necessary files
require_once WPTR_PLUGIN_PATH . 'includes/class-thumbnail-regenerator.php';
require_once WPTR_PLUGIN_PATH . 'includes/class-admin-ui.php';
require_once WPTR_PLUGIN_PATH . 'includes/functions.php';

// Initialize the plugin
function wptr_init_plugin() {
    new WPTR_Admin_UI();
}
add_action('plugins_loaded', 'wptr_init_plugin');
