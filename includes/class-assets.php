<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WP2GPT_Assets {
    /**
     * Register the hooks.
     */
    public static function register() {
        add_action('admin_enqueue_scripts', array('WP2GPT_Assets', 'enqueue_admin_assets'));
    }

    /**
     * Enqueues styles and scripts for the admin area.
     *
     * @param string $hook The current admin page hook.
     */
    public static function enqueue_admin_assets($hook) {
        if ($hook != 'settings_page_wp2gpt_settings') {
            return;
        }

        $version = '1.1';

        $dist_url = plugin_dir_url(__DIR__) . 'dist/';

        // Enqueue the Tailwind CSS for the admin area.
        wp_enqueue_style('wp2gpt-tailwind-admin', $dist_url . 'output.min.css', array(), WP2GPT_VERSION);

        // Enqueue the minified JavaScript for the admin area.
        wp_enqueue_script('wp2gpt-admin-js', $dist_url . 'admin.min.js', array(), WP2GPT_VERSION, true);
    }
}

WP2GPT_Assets::register();
