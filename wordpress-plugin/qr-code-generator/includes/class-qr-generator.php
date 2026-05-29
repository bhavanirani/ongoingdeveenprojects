<?php
if (!defined('ABSPATH')) {
    exit;
}

class QCG_Generator {

    public static function generate($data, $size = 300, $color = '#000000') {
        $content = self::build_content($data);

        if (empty($content)) {
            return new WP_Error('empty_content', __('Please provide valid content for QR code generation.', 'qr-code-generator'));
        }

        $rgb = self::hex_to_rgb($color);
        return self::generate_svg($content, $size, $rgb);
    }

    public static function generate_png_data($data, $size = 300) {
        $content = self::build_content($data);
        if (empty($content)) {
            return '';
        }

        self::load_qr_library();
        if (!class_exists('QRcode')) {
            return '';
        }

        ob_start();
        QRcode::png($content, false, QR_ECLEVEL_H, max(1, intval($size / 50)), 4);
        return ob_get_clean();
    }

    public static function build_content($data) {
        $type = isset($data['url_type']) ? sanitize_text_field($data['url_type']) : '';

        switch ($type) {
            case 'website':
                return self::build_website_url($data);
            case 'email':
                return self::build_email_url($data);
            case 'phone':
                return self::build_phone_url($data);
            case 'sms':
                return self::build_sms_url($data);
            case 'whatsapp':
                return self::build_whatsapp_url($data);
            case 'wifi':
                return self::build_wifi_string($data);
            case 'vcard':
                return self::build_vcard_string($data);
            case 'geo':
                return self::build_geo_url($data);
            case 'youtube':
                return self::build_youtube_url($data);
            case 'instagram':
                return self::build_instagram_url($data);
            case 'facebook':
                return self::build_facebook_url($data);
            case 'twitter':
                return self::build_twitter_url($data);
            case 'linkedin':
                return self::build_linkedin_url($data);
            case 'paypal':
                return self::build_paypal_url($data);
            case 'upi':
                return self::build_upi_url($data);
            case 'zoom':
                return self::build_zoom_url($data);
            case 'skype':
                return self::build_skype_url($data);
            case 'calendar':
                return self::build_calendar_event($data);
            case 'text':
                return isset($data['text_content']) ? sanitize_textarea_field($data['text_content']) : '';
            default:
                return '';
        }
    }

    private static function build_website_url($data) {
        $url = isset($data['website_url']) ? esc_url_raw($data['website_url']) : '';
        if ($url && !preg_match('/^https?:\/\//', $url)) {
            $url = 'https://' . $url;
        }
        return $url;
    }

    private static function build_email_url($data) {
        $email = isset($data['email_address']) ? sanitize_email($data['email_address']) : '';
        if (empty($email)) return '';

        $subject = isset($data['email_subject']) ? sanitize_text_field($data['email_subject']) : '';
        $body = isset($data['email_body']) ? sanitize_textarea_field($data['email_body']) : '';

        $url = 'mailto:' . $email;
        $params = array();
        if ($subject) $params[] = 'subject=' . rawurlencode($subject);
        if ($body) $params[] = 'body=' . rawurlencode($body);
        if (!empty($params)) $url .= '?' . implode('&', $params);

        return $url;
    }

    private static function build_phone_url($data) {
        $phone = isset($data['phone_number']) ? sanitize_text_field($data['phone_number']) : '';
        return $phone ? 'tel:' . $phone : '';
    }

    private static function build_sms_url($data) {
        $phone = isset($data['sms_number']) ? sanitize_text_field($data['sms_number']) : '';
        if (empty($phone)) return '';

        $message = isset($data['sms_message']) ? sanitize_textarea_field($data['sms_message']) : '';
        $url = 'sms:' . $phone;
        if ($message) $url .= '?body=' . rawurlencode($message);

        return $url;
    }

    private static function build_whatsapp_url($data) {
        $phone = isset($data['whatsapp_number']) ? sanitize_text_field($data['whatsapp_number']) : '';
        if (empty($phone)) return '';

        $phone = preg_replace('/[^0-9]/', '', $phone);
        $message = isset($data['whatsapp_message']) ? sanitize_textarea_field($data['whatsapp_message']) : '';

        $url = 'https://wa.me/' . $phone;
        if ($message) $url .= '?text=' . rawurlencode($message);

        return $url;
    }

    private static function build_wifi_string($data) {
        $ssid = isset($data['wifi_ssid']) ? sanitize_text_field($data['wifi_ssid']) : '';
        if (empty($ssid)) return '';

        $password = isset($data['wifi_password']) ? $data['wifi_password'] : '';
        $encryption = isset($data['wifi_encryption']) ? sanitize_text_field($data['wifi_encryption']) : 'WPA';
        $hidden = !empty($data['wifi_hidden']) ? 'true' : 'false';

        return "WIFI:T:{$encryption};S:{$ssid};P:{$password};H:{$hidden};;";
    }

    private static function build_vcard_string($data) {
        $name = isset($data['vcard_name']) ? sanitize_text_field($data['vcard_name']) : '';
        if (empty($name)) return '';

        $vcard = "BEGIN:VCARD\nVERSION:3.0\nFN:{$name}\n";

        $fields = array(
            'vcard_phone' => 'TEL',
            'vcard_email' => 'EMAIL',
            'vcard_org'   => 'ORG',
            'vcard_title' => 'TITLE',
            'vcard_website' => 'URL',
            'vcard_address' => 'ADR',
        );

        foreach ($fields as $key => $label) {
            $val = isset($data[$key]) ? sanitize_text_field($data[$key]) : '';
            if ($val) $vcard .= "{$label}:{$val}\n";
        }

        $vcard .= "END:VCARD";
        return $vcard;
    }

    private static function build_geo_url($data) {
        $lat = isset($data['geo_latitude']) ? sanitize_text_field($data['geo_latitude']) : '';
        $lng = isset($data['geo_longitude']) ? sanitize_text_field($data['geo_longitude']) : '';
        return ($lat && $lng) ? "geo:{$lat},{$lng}" : '';
    }

    private static function build_youtube_url($data) {
        $url = isset($data['youtube_url']) ? sanitize_text_field($data['youtube_url']) : '';
        if (empty($url)) return '';
        if (preg_match('/^https?:\/\//', $url)) return esc_url_raw($url);
        return 'https://www.youtube.com/watch?v=' . $url;
    }

    private static function build_instagram_url($data) {
        $u = isset($data['instagram_username']) ? sanitize_text_field($data['instagram_username']) : '';
        return $u ? 'https://www.instagram.com/' . ltrim($u, '@') : '';
    }

    private static function build_facebook_url($data) {
        $p = isset($data['facebook_url']) ? sanitize_text_field($data['facebook_url']) : '';
        if (empty($p)) return '';
        if (preg_match('/^https?:\/\//', $p)) return esc_url_raw($p);
        return 'https://www.facebook.com/' . $p;
    }

    private static function build_twitter_url($data) {
        $u = isset($data['twitter_username']) ? sanitize_text_field($data['twitter_username']) : '';
        return $u ? 'https://twitter.com/' . ltrim($u, '@') : '';
    }

    private static function build_linkedin_url($data) {
        $u = isset($data['linkedin_url']) ? sanitize_text_field($data['linkedin_url']) : '';
        if (empty($u)) return '';
        if (preg_match('/^https?:\/\//', $u)) return esc_url_raw($u);
        return 'https://www.linkedin.com/in/' . $u;
    }

    private static function build_paypal_url($data) {
        $e = isset($data['paypal_email']) ? sanitize_text_field($data['paypal_email']) : '';
        return $e ? 'https://www.paypal.me/' . $e : '';
    }

    private static function build_upi_url($data) {
        $id = isset($data['upi_id']) ? sanitize_text_field($data['upi_id']) : '';
        if (empty($id)) return '';

        $url = 'upi://pay?pa=' . $id;
        $name = isset($data['upi_name']) ? sanitize_text_field($data['upi_name']) : '';
        $amount = isset($data['upi_amount']) ? sanitize_text_field($data['upi_amount']) : '';
        if ($name) $url .= '&pn=' . rawurlencode($name);
        if ($amount) $url .= '&am=' . $amount;

        return $url;
    }

    private static function build_zoom_url($data) {
        $u = isset($data['zoom_url']) ? sanitize_text_field($data['zoom_url']) : '';
        if (empty($u)) return '';
        if (preg_match('/^https?:\/\//', $u)) return esc_url_raw($u);
        return 'https://zoom.us/j/' . $u;
    }

    private static function build_skype_url($data) {
        $u = isset($data['skype_username']) ? sanitize_text_field($data['skype_username']) : '';
        return $u ? 'skype:' . $u . '?chat' : '';
    }

    private static function build_calendar_event($data) {
        $title = isset($data['cal_title']) ? sanitize_text_field($data['cal_title']) : '';
        $start = isset($data['cal_start']) ? sanitize_text_field($data['cal_start']) : '';
        if (empty($title) || empty($start)) return '';

        $end = isset($data['cal_end']) ? sanitize_text_field($data['cal_end']) : '';
        $location = isset($data['cal_location']) ? sanitize_text_field($data['cal_location']) : '';
        $description = isset($data['cal_description']) ? sanitize_textarea_field($data['cal_description']) : '';

        $s = str_replace(array('-', ':', ' '), array('', '', 'T'), $start) . '00';
        $e = $end ? str_replace(array('-', ':', ' '), array('', '', 'T'), $end) . '00' : $s;

        $event = "BEGIN:VEVENT\nSUMMARY:{$title}\nDTSTART:{$s}\nDTEND:{$e}\n";
        if ($location) $event .= "LOCATION:{$location}\n";
        if ($description) $event .= "DESCRIPTION:{$description}\n";
        $event .= "END:VEVENT";

        return $event;
    }

    private static function hex_to_rgb($hex) {
        $hex = ltrim($hex, '#');
        return array(
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2)),
        );
    }

    private static function load_qr_library() {
        if (!class_exists('QRcode')) {
            require_once QCG_PLUGIN_DIR . 'includes/phpqrcode/qrlib.php';
        }
    }

    private static function generate_svg($content, $size, $rgb) {
        self::load_qr_library();
        if (!class_exists('QRcode')) {
            return '';
        }

        $matrix = QRcode::text($content, false, QR_ECLEVEL_H);

        if (!is_array($matrix) || empty($matrix)) {
            return '';
        }

        $module_count = count($matrix);
        $module_size = max(1, floor($size / ($module_count + 8)));
        $margin = $module_size * 4;
        $total = $module_count * $module_size + $margin * 2;
        $color = sprintf('rgb(%d,%d,%d)', $rgb['r'], $rgb['g'], $rgb['b']);

        $svg = '<?xml version="1.0" encoding="UTF-8"?>';
        $svg .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" ';
        $svg .= 'width="' . $total . '" height="' . $total . '" viewBox="0 0 ' . $total . ' ' . $total . '">';
        $svg .= '<rect width="100%" height="100%" fill="#ffffff"/>';

        for ($r = 0; $r < $module_count; $r++) {
            $row = $matrix[$r];
            for ($c = 0; $c < strlen($row); $c++) {
                if ($row[$c] === '1') {
                    $x = $margin + $c * $module_size;
                    $y = $margin + $r * $module_size;
                    $svg .= '<rect x="' . $x . '" y="' . $y . '" width="' . $module_size . '" height="' . $module_size . '" fill="' . $color . '"/>';
                }
            }
        }

        $svg .= '</svg>';
        return $svg;
    }
}
