<?php if (!defined('ABSPATH')) exit; ?>

<!-- Website -->
<div class="qcg-section active" id="qcg-section-website">
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('Website URL', 'qr-code-generator'); ?></label>
        <input type="text" name="website_url" class="form-control" placeholder="https://example.com">
    </div>
</div>

<!-- Email -->
<div class="qcg-section" id="qcg-section-email">
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('Email Address', 'qr-code-generator'); ?></label>
        <input type="email" name="email_address" class="form-control" placeholder="user@example.com">
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('Subject (optional)', 'qr-code-generator'); ?></label>
        <input type="text" name="email_subject" class="form-control" placeholder="Email subject">
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('Body (optional)', 'qr-code-generator'); ?></label>
        <textarea name="email_body" class="form-control" rows="2" placeholder="Email body"></textarea>
    </div>
</div>

<!-- Phone -->
<div class="qcg-section" id="qcg-section-phone">
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('Phone Number', 'qr-code-generator'); ?></label>
        <input type="text" name="phone_number" class="form-control" placeholder="+1234567890">
    </div>
</div>

<!-- SMS -->
<div class="qcg-section" id="qcg-section-sms">
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('Phone Number', 'qr-code-generator'); ?></label>
        <input type="text" name="sms_number" class="form-control" placeholder="+1234567890">
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('Message (optional)', 'qr-code-generator'); ?></label>
        <textarea name="sms_message" class="form-control" rows="2" placeholder="Your message"></textarea>
    </div>
</div>

<!-- WhatsApp -->
<div class="qcg-section" id="qcg-section-whatsapp">
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('WhatsApp Number (with country code)', 'qr-code-generator'); ?></label>
        <input type="text" name="whatsapp_number" class="form-control" placeholder="+1234567890">
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('Pre-filled Message (optional)', 'qr-code-generator'); ?></label>
        <textarea name="whatsapp_message" class="form-control" rows="2" placeholder="Hello!"></textarea>
    </div>
</div>

<!-- WiFi -->
<div class="qcg-section" id="qcg-section-wifi">
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('Network Name (SSID)', 'qr-code-generator'); ?></label>
        <input type="text" name="wifi_ssid" class="form-control" placeholder="MyWiFiNetwork">
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('Password', 'qr-code-generator'); ?></label>
        <input type="text" name="wifi_password" class="form-control" placeholder="password123">
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold"><?php esc_html_e('Encryption', 'qr-code-generator'); ?></label>
            <select name="wifi_encryption" class="form-select">
                <option value="WPA">WPA/WPA2</option>
                <option value="WEP">WEP</option>
                <option value="nopass"><?php esc_html_e('None', 'qr-code-generator'); ?></option>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold"><?php esc_html_e('Hidden Network', 'qr-code-generator'); ?></label>
            <div class="form-check mt-2">
                <input type="checkbox" name="wifi_hidden" class="form-check-input" id="qcg_wifi_hidden" value="1">
                <label class="form-check-label" for="qcg_wifi_hidden"><?php esc_html_e('Yes, hidden', 'qr-code-generator'); ?></label>
            </div>
        </div>
    </div>
</div>

<!-- vCard -->
<div class="qcg-section" id="qcg-section-vcard">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold"><?php esc_html_e('Full Name', 'qr-code-generator'); ?></label>
            <input type="text" name="vcard_name" class="form-control" placeholder="John Doe">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold"><?php esc_html_e('Phone', 'qr-code-generator'); ?></label>
            <input type="text" name="vcard_phone" class="form-control" placeholder="+1234567890">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold"><?php esc_html_e('Email', 'qr-code-generator'); ?></label>
            <input type="email" name="vcard_email" class="form-control" placeholder="john@example.com">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold"><?php esc_html_e('Organization', 'qr-code-generator'); ?></label>
            <input type="text" name="vcard_org" class="form-control" placeholder="Company Inc.">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold"><?php esc_html_e('Job Title', 'qr-code-generator'); ?></label>
            <input type="text" name="vcard_title" class="form-control" placeholder="Software Engineer">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold"><?php esc_html_e('Website', 'qr-code-generator'); ?></label>
            <input type="text" name="vcard_website" class="form-control" placeholder="https://example.com">
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('Address', 'qr-code-generator'); ?></label>
        <input type="text" name="vcard_address" class="form-control" placeholder="123 Main St, City, Country">
    </div>
</div>

<!-- Geo Location -->
<div class="qcg-section" id="qcg-section-geo">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold"><?php esc_html_e('Latitude', 'qr-code-generator'); ?></label>
            <input type="text" name="geo_latitude" class="form-control" placeholder="40.7128">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold"><?php esc_html_e('Longitude', 'qr-code-generator'); ?></label>
            <input type="text" name="geo_longitude" class="form-control" placeholder="-74.0060">
        </div>
    </div>
</div>

<!-- YouTube -->
<div class="qcg-section" id="qcg-section-youtube">
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('YouTube Video URL or ID', 'qr-code-generator'); ?></label>
        <input type="text" name="youtube_url" class="form-control" placeholder="https://youtube.com/watch?v=...">
    </div>
</div>

<!-- Instagram -->
<div class="qcg-section" id="qcg-section-instagram">
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('Instagram Username', 'qr-code-generator'); ?></label>
        <input type="text" name="instagram_username" class="form-control" placeholder="@username">
    </div>
</div>

<!-- Facebook -->
<div class="qcg-section" id="qcg-section-facebook">
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('Facebook Page URL or Username', 'qr-code-generator'); ?></label>
        <input type="text" name="facebook_url" class="form-control" placeholder="https://facebook.com/page or username">
    </div>
</div>

<!-- Twitter -->
<div class="qcg-section" id="qcg-section-twitter">
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('Twitter/X Username', 'qr-code-generator'); ?></label>
        <input type="text" name="twitter_username" class="form-control" placeholder="@username">
    </div>
</div>

<!-- LinkedIn -->
<div class="qcg-section" id="qcg-section-linkedin">
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('LinkedIn Profile URL or Username', 'qr-code-generator'); ?></label>
        <input type="text" name="linkedin_url" class="form-control" placeholder="https://linkedin.com/in/username">
    </div>
</div>

<!-- PayPal -->
<div class="qcg-section" id="qcg-section-paypal">
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('PayPal.me Username', 'qr-code-generator'); ?></label>
        <input type="text" name="paypal_email" class="form-control" placeholder="username">
    </div>
</div>

<!-- UPI -->
<div class="qcg-section" id="qcg-section-upi">
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('UPI ID', 'qr-code-generator'); ?></label>
        <input type="text" name="upi_id" class="form-control" placeholder="user@upi">
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold"><?php esc_html_e('Payee Name (optional)', 'qr-code-generator'); ?></label>
            <input type="text" name="upi_name" class="form-control" placeholder="John Doe">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold"><?php esc_html_e('Amount (optional)', 'qr-code-generator'); ?></label>
            <input type="number" name="upi_amount" class="form-control" placeholder="100" step="0.01">
        </div>
    </div>
</div>

<!-- Zoom -->
<div class="qcg-section" id="qcg-section-zoom">
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('Zoom Meeting URL or ID', 'qr-code-generator'); ?></label>
        <input type="text" name="zoom_url" class="form-control" placeholder="https://zoom.us/j/... or meeting ID">
    </div>
</div>

<!-- Skype -->
<div class="qcg-section" id="qcg-section-skype">
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('Skype Username', 'qr-code-generator'); ?></label>
        <input type="text" name="skype_username" class="form-control" placeholder="username">
    </div>
</div>

<!-- Calendar Event -->
<div class="qcg-section" id="qcg-section-calendar">
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('Event Title', 'qr-code-generator'); ?></label>
        <input type="text" name="cal_title" class="form-control" placeholder="Team Meeting">
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold"><?php esc_html_e('Start Date & Time', 'qr-code-generator'); ?></label>
            <input type="datetime-local" name="cal_start" class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold"><?php esc_html_e('End Date & Time', 'qr-code-generator'); ?></label>
            <input type="datetime-local" name="cal_end" class="form-control">
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('Location (optional)', 'qr-code-generator'); ?></label>
        <input type="text" name="cal_location" class="form-control" placeholder="Conference Room A">
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('Description (optional)', 'qr-code-generator'); ?></label>
        <textarea name="cal_description" class="form-control" rows="2" placeholder="Meeting details"></textarea>
    </div>
</div>

<!-- Plain Text -->
<div class="qcg-section" id="qcg-section-text">
    <div class="mb-3">
        <label class="form-label fw-semibold"><?php esc_html_e('Text Content', 'qr-code-generator'); ?></label>
        <textarea name="text_content" class="form-control" rows="3" placeholder="Enter any text to encode"></textarea>
    </div>
</div>
