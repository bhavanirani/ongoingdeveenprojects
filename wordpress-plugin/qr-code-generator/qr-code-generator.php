<?php
/**
 * Plugin Name: QR Code Generator
 * Plugin URI: https://github.com/bhavanirani/ongoingdeveenprojects
 * Description: Automatic QR Code Generator for all types of URLs — Website, Email, Phone, SMS, WhatsApp, WiFi, vCard, Social Media, Payments, and more. Use the shortcode [qr_code_generator] or the admin page.
 * Version: 1.0.0
 * Author: Bhavani Rani
 * Author URI: https://github.com/bhavanirani
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: qr-code-generator
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) {
    exit;
}

define('QCG_VERSION', '1.0.0');
define('QCG_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('QCG_PLUGIN_URL', plugin_dir_url(__FILE__));
define('QCG_PLUGIN_BASENAME', plugin_basename(__FILE__));

require_once QCG_PLUGIN_DIR . 'includes/class-qr-generator.php';
require_once QCG_PLUGIN_DIR . 'includes/class-qr-admin.php';
require_once QCG_PLUGIN_DIR . 'includes/class-qr-shortcode.php';
require_once QCG_PLUGIN_DIR . 'includes/class-qr-ajax.php';

function qcg_init() {
    QCG_Admin::init();
    QCG_Shortcode::init();
    QCG_Ajax::init();
}
add_action('plugins_loaded', 'qcg_init');

function qcg_activate() {
    add_option('qcg_default_size', 300);
    add_option('qcg_default_color', '#000000');
    add_option('qcg_default_format', 'svg');
}
register_activation_hook(__FILE__, 'qcg_activate');

function qcg_deactivate() {
    // Cleanup if needed
}
register_deactivation_hook(__FILE__, 'qcg_deactivate');
