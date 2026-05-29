<?php
if (!defined('ABSPATH')) {
    exit;
}

class QCG_Ajax {

    public static function init() {
        add_action('wp_ajax_qcg_generate', array(__CLASS__, 'handle_generate'));
        add_action('wp_ajax_nopriv_qcg_generate', array(__CLASS__, 'handle_generate'));
        add_action('wp_ajax_qcg_download', array(__CLASS__, 'handle_download'));
        add_action('wp_ajax_nopriv_qcg_download', array(__CLASS__, 'handle_download'));
    }

    public static function handle_generate() {
        check_ajax_referer('qcg_generate_nonce', 'nonce');

        $data = array();
        // Sanitize all input fields
        $fields = array(
            'url_type', 'website_url', 'email_address', 'email_subject', 'email_body',
            'phone_number', 'sms_number', 'sms_message', 'whatsapp_number', 'whatsapp_message',
            'wifi_ssid', 'wifi_password', 'wifi_encryption', 'wifi_hidden',
            'vcard_name', 'vcard_phone', 'vcard_email', 'vcard_org', 'vcard_title', 'vcard_website', 'vcard_address',
            'geo_latitude', 'geo_longitude', 'youtube_url', 'instagram_username',
            'facebook_url', 'twitter_username', 'linkedin_url', 'paypal_email',
            'upi_id', 'upi_name', 'upi_amount', 'zoom_url', 'skype_username',
            'cal_title', 'cal_start', 'cal_end', 'cal_location', 'cal_description',
            'text_content',
        );

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $data[$field] = wp_unslash($_POST[$field]);
            }
        }

        $size = isset($_POST['size']) ? absint($_POST['size']) : 300;
        $size = max(100, min(500, $size));
        $color = isset($_POST['color']) ? sanitize_hex_color(wp_unslash($_POST['color'])) : '#000000';
        if (!$color) $color = '#000000';

        $svg = QCG_Generator::generate($data, $size, $color);

        if (is_wp_error($svg)) {
            wp_send_json_error(array('message' => $svg->get_error_message()));
        }

        $content = QCG_Generator::build_content($data);
        $svg_data = 'data:image/svg+xml;base64,' . base64_encode($svg);

        wp_send_json_success(array(
            'qr_image' => $svg_data,
            'content'  => $content,
        ));
    }

    public static function handle_download() {
        check_ajax_referer('qcg_generate_nonce', 'nonce');

        $data = array();
        $fields = array(
            'url_type', 'website_url', 'email_address', 'email_subject', 'email_body',
            'phone_number', 'sms_number', 'sms_message', 'whatsapp_number', 'whatsapp_message',
            'wifi_ssid', 'wifi_password', 'wifi_encryption', 'wifi_hidden',
            'vcard_name', 'vcard_phone', 'vcard_email', 'vcard_org', 'vcard_title', 'vcard_website', 'vcard_address',
            'geo_latitude', 'geo_longitude', 'youtube_url', 'instagram_username',
            'facebook_url', 'twitter_username', 'linkedin_url', 'paypal_email',
            'upi_id', 'upi_name', 'upi_amount', 'zoom_url', 'skype_username',
            'cal_title', 'cal_start', 'cal_end', 'cal_location', 'cal_description',
            'text_content',
        );

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $data[$field] = wp_unslash($_POST[$field]);
            }
        }

        $size = isset($_POST['size']) ? absint($_POST['size']) : 300;
        $color = isset($_POST['color']) ? sanitize_hex_color(wp_unslash($_POST['color'])) : '#000000';
        if (!$color) $color = '#000000';

        $svg = QCG_Generator::generate($data, $size, $color);

        if (is_wp_error($svg)) {
            wp_send_json_error(array('message' => $svg->get_error_message()));
        }

        wp_send_json_success(array(
            'svg_data' => base64_encode($svg),
            'filename' => 'qrcode_' . time() . '.svg',
        ));
    }
}
