<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class WPTR_Admin_UI {

    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'load_admin_assets']);
    }

    public function add_admin_menu() {
        add_menu_page(
            __('Thumbnail Regenerator', 'wp-thumbnail-regenerator'),
            __('Thumbnail Regenerator', 'wp-thumbnail-regenerator'),
            'manage_options',
            'wptr-main',
            [$this, 'settings_page'],
            'dashicons-images-alt2',
            90
        );

        add_submenu_page(
            'wptr-main',
            __('Regeneration Process', 'wp-thumbnail-regenerator'),
            __('Process', 'wp-thumbnail-regenerator'),
            'manage_options',
            'wptr-process',
            [$this, 'process_page']
        );
    }

    public function settings_page() {
        include WPTR_PLUGIN_PATH . 'templates/settings-page.php';
    }

    public function process_page() {
        include WPTR_PLUGIN_PATH . 'templates/process-page.php';
    }

    public function load_admin_assets($hook) {
        if (strpos($hook, 'wptr') === false) return;

        wp_enqueue_style('wptr-admin-style', WPTR_PLUGIN_URL . 'assets/css/admin-style.css');
        wp_enqueue_script('wptr-admin-script', WPTR_PLUGIN_URL . 'assets/js/admin-script.js', ['jquery'], false, true);
        wp_localize_script('wptr-admin-script', 'WPTR_Ajax', ['ajaxurl' => admin_url('admin-ajax.php')]);
    }
}

new WPTR_Admin_UI();
