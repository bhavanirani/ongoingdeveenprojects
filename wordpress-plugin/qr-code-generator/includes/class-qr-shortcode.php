<?php
if (!defined('ABSPATH')) {
    exit;
}

class QCG_Shortcode {

    public static function init() {
        add_shortcode('qr_code_generator', array(__CLASS__, 'render_shortcode'));
        add_action('wp_enqueue_scripts', array(__CLASS__, 'enqueue_frontend_assets'));
    }

    public static function enqueue_frontend_assets() {
        global $post;
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'qr_code_generator')) {
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
                'qcg-frontend-style',
                QCG_PLUGIN_URL . 'assets/css/frontend.css',
                array(),
                QCG_VERSION
            );

            wp_enqueue_script(
                'qcg-frontend-script',
                QCG_PLUGIN_URL . 'assets/js/frontend.js',
                array('jquery'),
                QCG_VERSION,
                true
            );

            wp_localize_script('qcg-frontend-script', 'qcg_ajax', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce'    => wp_create_nonce('qcg_generate_nonce'),
            ));
        }
    }

    public static function render_shortcode($atts) {
        $atts = shortcode_atts(array(
            'title' => __('QR Code Generator', 'qr-code-generator'),
        ), $atts, 'qr_code_generator');

        ob_start();
        include QCG_PLUGIN_DIR . 'templates/frontend-form.php';
        return ob_get_clean();
    }
}
