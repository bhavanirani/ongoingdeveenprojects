<?php if (!defined('ABSPATH')) exit; ?>
<div class="qcg-frontend-wrap">
    <div class="qcg-header">
        <h2><i class="fas fa-qrcode"></i> <?php echo esc_html($atts['title']); ?></h2>
        <p><?php esc_html_e('Generate QR codes for any type of URL or content', 'qr-code-generator'); ?></p>
    </div>
    <div class="qcg-body">
        <div class="qcg-error"></div>
        <div class="row">
            <div class="col-md-7">
                <div class="qcg-form">
                    <input type="hidden" id="qcg_url_type" name="url_type" value="website">

                    <h5 class="fw-bold mb-3"><?php esc_html_e('Select Type', 'qr-code-generator'); ?></h5>
                    <div class="qcg-type-grid">
                        <div class="qcg-type-btn active" data-type="website"><i class="fas fa-globe"></i>Website</div>
                        <div class="qcg-type-btn" data-type="email"><i class="fas fa-envelope"></i>Email</div>
                        <div class="qcg-type-btn" data-type="phone"><i class="fas fa-phone"></i>Phone</div>
                        <div class="qcg-type-btn" data-type="sms"><i class="fas fa-comment-sms"></i>SMS</div>
                        <div class="qcg-type-btn" data-type="whatsapp"><i class="fab fa-whatsapp"></i>WhatsApp</div>
                        <div class="qcg-type-btn" data-type="wifi"><i class="fas fa-wifi"></i>WiFi</div>
                        <div class="qcg-type-btn" data-type="vcard"><i class="fas fa-address-card"></i>vCard</div>
                        <div class="qcg-type-btn" data-type="geo"><i class="fas fa-map-marker-alt"></i>Location</div>
                        <div class="qcg-type-btn" data-type="youtube"><i class="fab fa-youtube"></i>YouTube</div>
                        <div class="qcg-type-btn" data-type="instagram"><i class="fab fa-instagram"></i>Instagram</div>
                        <div class="qcg-type-btn" data-type="facebook"><i class="fab fa-facebook"></i>Facebook</div>
                        <div class="qcg-type-btn" data-type="twitter"><i class="fab fa-twitter"></i>Twitter/X</div>
                        <div class="qcg-type-btn" data-type="linkedin"><i class="fab fa-linkedin"></i>LinkedIn</div>
                        <div class="qcg-type-btn" data-type="paypal"><i class="fab fa-paypal"></i>PayPal</div>
                        <div class="qcg-type-btn" data-type="upi"><i class="fas fa-money-bill-wave"></i>UPI</div>
                        <div class="qcg-type-btn" data-type="zoom"><i class="fas fa-video"></i>Zoom</div>
                        <div class="qcg-type-btn" data-type="skype"><i class="fab fa-skype"></i>Skype</div>
                        <div class="qcg-type-btn" data-type="calendar"><i class="fas fa-calendar-alt"></i>Calendar</div>
                        <div class="qcg-type-btn" data-type="text"><i class="fas fa-font"></i>Plain Text</div>
                    </div>

                    <?php include QCG_PLUGIN_DIR . 'templates/form-fields.php'; ?>

                    <div class="qcg-settings">
                        <h6 class="fw-bold mb-3"><i class="fas fa-cog"></i> <?php esc_html_e('Settings', 'qr-code-generator'); ?></h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold"><?php esc_html_e('Size (px)', 'qr-code-generator'); ?></label>
                                <input type="number" name="size" class="form-control" value="300" min="100" max="500" step="50">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold"><?php esc_html_e('Color', 'qr-code-generator'); ?></label>
                                <input type="color" name="color" class="form-control form-control-color w-100" value="#000000">
                            </div>
                        </div>
                    </div>

                    <button type="button" class="qcg-btn-generate">
                        <i class="fas fa-qrcode"></i> <?php esc_html_e('Generate QR Code', 'qr-code-generator'); ?>
                    </button>
                </div>
            </div>

            <div class="col-md-5 mt-4 mt-md-0">
                <div class="qcg-preview">
                    <div class="qcg-loading">
                        <div class="qcg-spinner"></div>
                        <p><?php esc_html_e('Generating QR Code...', 'qr-code-generator'); ?></p>
                    </div>
                    <div class="qcg-result" style="display:none;">
                        <h5 class="fw-bold mb-3" style="color:#16a34a;"><i class="fas fa-check-circle"></i> <?php esc_html_e('QR Code Generated!', 'qr-code-generator'); ?></h5>
                        <img src="" alt="QR Code" class="qcg-qr-image mb-3">
                        <p class="qcg-url-display"></p>
                        <button type="button" class="qcg-btn-download">
                            <i class="fas fa-download"></i> <?php esc_html_e('Download SVG', 'qr-code-generator'); ?>
                        </button>
                    </div>
                    <div class="qcg-placeholder">
                        <i class="fas fa-qrcode" style="font-size:4rem;opacity:0.2;"></i>
                        <p class="mt-3"><?php esc_html_e('Your QR code will appear here', 'qr-code-generator'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
