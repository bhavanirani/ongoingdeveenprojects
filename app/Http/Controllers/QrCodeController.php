<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function index()
    {
        return view('qrcode.generator');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'url_type' => 'required|string',
            'size' => 'required|integer|min:100|max:500',
            'color' => 'required|string',
            'format' => 'required|in:svg,png',
        ]);

        $urlType = $request->input('url_type');
        $size = $request->input('size', 200);
        $color = $request->input('color', '#000000');
        $format = $request->input('format', 'svg');

        $url = $this->buildUrl($urlType, $request);

        if (empty($url)) {
            return back()->withErrors(['url' => 'Please provide a valid URL or content.'])->withInput();
        }

        $rgb = $this->hexToRgb($color);

        $qrCode = QrCode::format($format)
            ->size($size)
            ->color($rgb['r'], $rgb['g'], $rgb['b'])
            ->errorCorrection('H')
            ->generate($url);

        if ($format === 'svg') {
            $qrCodeData = 'data:image/svg+xml;base64,' . base64_encode($qrCode);
        } else {
            $qrCodeData = 'data:image/png;base64,' . base64_encode($qrCode);
        }

        return view('qrcode.generator', [
            'qrCode' => $qrCodeData,
            'url' => $url,
            'format' => $format,
        ]);
    }

    public function download(Request $request)
    {
        $request->validate([
            'url' => 'required|string',
            'size' => 'required|integer|min:100|max:500',
            'color' => 'required|string',
            'format' => 'required|in:svg,png',
        ]);

        $url = $request->input('url');
        $size = $request->input('size', 200);
        $color = $request->input('color', '#000000');
        $format = $request->input('format', 'svg');

        $rgb = $this->hexToRgb($color);

        $qrCode = QrCode::format($format)
            ->size($size)
            ->color($rgb['r'], $rgb['g'], $rgb['b'])
            ->errorCorrection('H')
            ->generate($url);

        $filename = 'qrcode_' . time() . '.' . $format;
        $contentType = $format === 'svg' ? 'image/svg+xml' : 'image/png';

        return response($qrCode)
            ->header('Content-Type', $contentType)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    private function buildUrl(string $type, Request $request): string
    {
        return match ($type) {
            'website' => $this->buildWebsiteUrl($request),
            'email' => $this->buildEmailUrl($request),
            'phone' => $this->buildPhoneUrl($request),
            'sms' => $this->buildSmsUrl($request),
            'whatsapp' => $this->buildWhatsAppUrl($request),
            'wifi' => $this->buildWifiString($request),
            'vcard' => $this->buildVCardString($request),
            'geo' => $this->buildGeoUrl($request),
            'youtube' => $this->buildYouTubeUrl($request),
            'instagram' => $this->buildInstagramUrl($request),
            'facebook' => $this->buildFacebookUrl($request),
            'twitter' => $this->buildTwitterUrl($request),
            'linkedin' => $this->buildLinkedInUrl($request),
            'paypal' => $this->buildPayPalUrl($request),
            'upi' => $this->buildUpiUrl($request),
            'zoom' => $this->buildZoomUrl($request),
            'skype' => $this->buildSkypeUrl($request),
            'calendar' => $this->buildCalendarEvent($request),
            'text' => $request->input('text_content', ''),
            default => '',
        };
    }

    private function buildWebsiteUrl(Request $request): string
    {
        $url = $request->input('website_url', '');
        if ($url && !preg_match('/^https?:\/\//', $url)) {
            $url = 'https://' . $url;
        }
        return $url;
    }

    private function buildEmailUrl(Request $request): string
    {
        $email = $request->input('email_address', '');
        $subject = $request->input('email_subject', '');
        $body = $request->input('email_body', '');

        if (empty($email)) {
            return '';
        }

        $url = 'mailto:' . $email;
        $params = [];
        if ($subject) {
            $params[] = 'subject=' . rawurlencode($subject);
        }
        if ($body) {
            $params[] = 'body=' . rawurlencode($body);
        }
        if (!empty($params)) {
            $url .= '?' . implode('&', $params);
        }

        return $url;
    }

    private function buildPhoneUrl(Request $request): string
    {
        $phone = $request->input('phone_number', '');
        return $phone ? 'tel:' . $phone : '';
    }

    private function buildSmsUrl(Request $request): string
    {
        $phone = $request->input('sms_number', '');
        $message = $request->input('sms_message', '');

        if (empty($phone)) {
            return '';
        }

        $url = 'sms:' . $phone;
        if ($message) {
            $url .= '?body=' . rawurlencode($message);
        }

        return $url;
    }

    private function buildWhatsAppUrl(Request $request): string
    {
        $phone = $request->input('whatsapp_number', '');
        $message = $request->input('whatsapp_message', '');

        if (empty($phone)) {
            return '';
        }

        $phone = preg_replace('/[^0-9]/', '', $phone);
        $url = 'https://wa.me/' . $phone;
        if ($message) {
            $url .= '?text=' . rawurlencode($message);
        }

        return $url;
    }

    private function buildWifiString(Request $request): string
    {
        $ssid = $request->input('wifi_ssid', '');
        $password = $request->input('wifi_password', '');
        $encryption = $request->input('wifi_encryption', 'WPA');
        $hidden = $request->input('wifi_hidden') ? 'true' : 'false';

        if (empty($ssid)) {
            return '';
        }

        return "WIFI:T:{$encryption};S:{$ssid};P:{$password};H:{$hidden};;";
    }

    private function buildVCardString(Request $request): string
    {
        $name = $request->input('vcard_name', '');
        $phone = $request->input('vcard_phone', '');
        $email = $request->input('vcard_email', '');
        $org = $request->input('vcard_org', '');
        $title = $request->input('vcard_title', '');
        $website = $request->input('vcard_website', '');
        $address = $request->input('vcard_address', '');

        if (empty($name)) {
            return '';
        }

        $vcard = "BEGIN:VCARD\nVERSION:3.0\n";
        $vcard .= "FN:{$name}\n";
        if ($phone) {
            $vcard .= "TEL:{$phone}\n";
        }
        if ($email) {
            $vcard .= "EMAIL:{$email}\n";
        }
        if ($org) {
            $vcard .= "ORG:{$org}\n";
        }
        if ($title) {
            $vcard .= "TITLE:{$title}\n";
        }
        if ($website) {
            $vcard .= "URL:{$website}\n";
        }
        if ($address) {
            $vcard .= "ADR:{$address}\n";
        }
        $vcard .= "END:VCARD";

        return $vcard;
    }

    private function buildGeoUrl(Request $request): string
    {
        $latitude = $request->input('geo_latitude', '');
        $longitude = $request->input('geo_longitude', '');

        if (empty($latitude) || empty($longitude)) {
            return '';
        }

        return "geo:{$latitude},{$longitude}";
    }

    private function buildYouTubeUrl(Request $request): string
    {
        $videoId = $request->input('youtube_url', '');
        if (empty($videoId)) {
            return '';
        }
        if (preg_match('/^https?:\/\//', $videoId)) {
            return $videoId;
        }
        return 'https://www.youtube.com/watch?v=' . $videoId;
    }

    private function buildInstagramUrl(Request $request): string
    {
        $username = $request->input('instagram_username', '');
        return $username ? 'https://www.instagram.com/' . ltrim($username, '@') : '';
    }

    private function buildFacebookUrl(Request $request): string
    {
        $page = $request->input('facebook_url', '');
        if (empty($page)) {
            return '';
        }
        if (preg_match('/^https?:\/\//', $page)) {
            return $page;
        }
        return 'https://www.facebook.com/' . $page;
    }

    private function buildTwitterUrl(Request $request): string
    {
        $username = $request->input('twitter_username', '');
        return $username ? 'https://twitter.com/' . ltrim($username, '@') : '';
    }

    private function buildLinkedInUrl(Request $request): string
    {
        $profileUrl = $request->input('linkedin_url', '');
        if (empty($profileUrl)) {
            return '';
        }
        if (preg_match('/^https?:\/\//', $profileUrl)) {
            return $profileUrl;
        }
        return 'https://www.linkedin.com/in/' . $profileUrl;
    }

    private function buildPayPalUrl(Request $request): string
    {
        $email = $request->input('paypal_email', '');
        return $email ? 'https://www.paypal.me/' . $email : '';
    }

    private function buildUpiUrl(Request $request): string
    {
        $upiId = $request->input('upi_id', '');
        $name = $request->input('upi_name', '');
        $amount = $request->input('upi_amount', '');

        if (empty($upiId)) {
            return '';
        }

        $url = 'upi://pay?pa=' . $upiId;
        if ($name) {
            $url .= '&pn=' . rawurlencode($name);
        }
        if ($amount) {
            $url .= '&am=' . $amount;
        }

        return $url;
    }

    private function buildZoomUrl(Request $request): string
    {
        $meetingUrl = $request->input('zoom_url', '');
        if (empty($meetingUrl)) {
            return '';
        }
        if (preg_match('/^https?:\/\//', $meetingUrl)) {
            return $meetingUrl;
        }
        return 'https://zoom.us/j/' . $meetingUrl;
    }

    private function buildSkypeUrl(Request $request): string
    {
        $username = $request->input('skype_username', '');
        return $username ? 'skype:' . $username . '?chat' : '';
    }

    private function buildCalendarEvent(Request $request): string
    {
        $title = $request->input('cal_title', '');
        $start = $request->input('cal_start', '');
        $end = $request->input('cal_end', '');
        $location = $request->input('cal_location', '');
        $description = $request->input('cal_description', '');

        if (empty($title) || empty($start)) {
            return '';
        }

        $startFormatted = str_replace(['-', ':', ' '], ['', '', 'T'], $start) . '00';
        $endFormatted = $end ? str_replace(['-', ':', ' '], ['', '', 'T'], $end) . '00' : $startFormatted;

        $event = "BEGIN:VEVENT\n";
        $event .= "SUMMARY:{$title}\n";
        $event .= "DTSTART:{$startFormatted}\n";
        $event .= "DTEND:{$endFormatted}\n";
        if ($location) {
            $event .= "LOCATION:{$location}\n";
        }
        if ($description) {
            $event .= "DESCRIPTION:{$description}\n";
        }
        $event .= "END:VEVENT";

        return $event;
    }

    private function hexToRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');

        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2)),
        ];
    }
}
