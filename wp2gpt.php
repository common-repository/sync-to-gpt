<?php
/**
 * Plugin Name: Sync to GPT: Connect Posts to ChatGPT
 * Plugin URI: https://wordpress.org/plugins/sync-to-gpt
 * Description: Sync to GPT allows ChatGPT to access your WordPress posts for content analysis and generation, or to share your content with millions of users on ChatGPT.
 * Version: 1.1
 * Author: Virgiliu Diaconu
 * Author URI: https://virgiliudiaconu.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Plugin version.
define('WP2GPT_VERSION', '1.1');

// Custom API.
include_once plugin_dir_path( __FILE__ ) . 'includes/class-api.php';

// Plugin settings.
include_once plugin_dir_path( __FILE__ ) . 'includes/class-settings.php';

// Styles and scripts.
include_once plugin_dir_path( __FILE__ ) . 'includes/class-assets.php';
