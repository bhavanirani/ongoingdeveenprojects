<?php
if (!defined('ABSPATH')) {
    exit;
}

class QCG_Admin {

    public static function init() {
        add_action('admin_menu', array(__CLASS__, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueue_assets'));
    }

    public static function add_admin_menu() {
        add_menu_page(
            __('QR Code Generator', 'qr-code-generator'),
            __('QR Generator', 'qr-code-generator'),
            'manage_options',
            'qr-code-generator',
            array(__CLASS__, 'render_admin_page'),
            'dashicons-smartphone',
            30
        );
    }

    public static function enqueue_assets($hook) {
        if ($hook !== 'toplevel_page_qr-code-generator') {
            return;
        }

        wp_enqueue_style(
            'qcg-bootstrap',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
            array(),
            '5.3.0'
        );

        wp_enqueue_style(
            'qcg-fontawesome',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
            array(),
            '6.4.0'
        );

        wp_enqueue_style(
            'qcg-admin-style',
            QCG_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            QCG_VERSION
        );

        wp_enqueue_script(
            'qcg-admin-script',
            QCG_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery'),
            QCG_VERSION,
            true
        );

        wp_localize_script('qcg-admin-script', 'qcg_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('qcg_generate_nonce'),
        ));
    }

    public static function render_admin_page() {
        include QCG_PLUGIN_DIR . 'templates/admin-page.php';
    }
}
