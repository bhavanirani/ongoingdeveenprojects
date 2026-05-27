<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
        }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        .main-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #fff;
            padding: 2rem;
            text-align: center;
        }
        .header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        .header p {
            opacity: 0.85;
            margin: 0;
            font-size: 0.95rem;
        }
        .url-type-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
            gap: 10px;
            margin-bottom: 1.5rem;
        }
        .url-type-btn {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: #fff;
            font-size: 0.8rem;
        }
        .url-type-btn:hover {
            border-color: var(--primary);
            background: #f0f0ff;
        }
        .url-type-btn.active {
            border-color: var(--primary);
            background: #eef2ff;
            color: var(--primary);
            font-weight: 600;
        }
        .url-type-btn i {
            display: block;
            font-size: 1.4rem;
            margin-bottom: 6px;
            color: var(--primary);
        }
        .form-section {
            display: none;
        }
        .form-section.active {
            display: block;
        }
        .qr-preview {
            background: #f8fafc;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            min-height: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .qr-preview img {
            max-width: 300px;
            border-radius: 8px;
        }
        .btn-generate {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            padding: 12px 32px;
            font-size: 1.05rem;
            border-radius: 10px;
            color: #fff;
            font-weight: 600;
            transition: transform 0.2s;
        }
        .btn-generate:hover {
            transform: translateY(-2px);
            color: #fff;
        }
        .btn-download {
            border: 2px solid var(--primary);
            color: var(--primary);
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.2s;
            background: #fff;
        }
        .btn-download:hover {
            background: var(--primary);
            color: #fff;
        }
        .settings-panel {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="main-card">
                    <div class="header">
                        <h1><i class="fas fa-qrcode me-2"></i>QR Code Generator</h1>
                        <p>Generate QR codes for any type of URL or content</p>
                    </div>

                    <div class="p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-7">
                                <form method="POST" action="{{ route('qrcode.generate') }}" id="qrForm">
                                    @csrf
                                    <input type="hidden" name="url_type" id="url_type" value="{{ old('url_type', 'website') }}">

                                    <h5 class="fw-bold mb-3">Select Type</h5>
                                    <div class="url-type-grid">
                                        <div class="url-type-btn active" data-type="website">
                                            <i class="fas fa-globe"></i>Website
                                        </div>
                                        <div class="url-type-btn" data-type="email">
                                            <i class="fas fa-envelope"></i>Email
                                        </div>
                                        <div class="url-type-btn" data-type="phone">
                                            <i class="fas fa-phone"></i>Phone
                                        </div>
                                        <div class="url-type-btn" data-type="sms">
                                            <i class="fas fa-comment-sms"></i>SMS
                                        </div>
                                        <div class="url-type-btn" data-type="whatsapp">
                                            <i class="fab fa-whatsapp"></i>WhatsApp
                                        </div>
                                        <div class="url-type-btn" data-type="wifi">
                                            <i class="fas fa-wifi"></i>WiFi
                                        </div>
                                        <div class="url-type-btn" data-type="vcard">
                                            <i class="fas fa-address-card"></i>vCard
                                        </div>
                                        <div class="url-type-btn" data-type="geo">
                                            <i class="fas fa-map-marker-alt"></i>Location
                                        </div>
                                        <div class="url-type-btn" data-type="youtube">
                                            <i class="fab fa-youtube"></i>YouTube
                                        </div>
                                        <div class="url-type-btn" data-type="instagram">
                                            <i class="fab fa-instagram"></i>Instagram
                                        </div>
                                        <div class="url-type-btn" data-type="facebook">
                                            <i class="fab fa-facebook"></i>Facebook
                                        </div>
                                        <div class="url-type-btn" data-type="twitter">
                                            <i class="fab fa-twitter"></i>Twitter/X
                                        </div>
                                        <div class="url-type-btn" data-type="linkedin">
                                            <i class="fab fa-linkedin"></i>LinkedIn
                                        </div>
                                        <div class="url-type-btn" data-type="paypal">
                                            <i class="fab fa-paypal"></i>PayPal
                                        </div>
                                        <div class="url-type-btn" data-type="upi">
                                            <i class="fas fa-money-bill-wave"></i>UPI
                                        </div>
                                        <div class="url-type-btn" data-type="zoom">
                                            <i class="fas fa-video"></i>Zoom
                                        </div>
                                        <div class="url-type-btn" data-type="skype">
                                            <i class="fab fa-skype"></i>Skype
                                        </div>
                                        <div class="url-type-btn" data-type="calendar">
                                            <i class="fas fa-calendar-alt"></i>Calendar
                                        </div>
                                        <div class="url-type-btn" data-type="text">
                                            <i class="fas fa-font"></i>Plain Text
                                        </div>
                                    </div>

                                    {{-- Website --}}
                                    <div class="form-section active" id="section-website">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Website URL</label>
                                            <input type="text" name="website_url" class="form-control" placeholder="https://example.com" value="{{ old('website_url') }}">
                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="form-section" id="section-email">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Email Address</label>
                                            <input type="email" name="email_address" class="form-control" placeholder="user@example.com" value="{{ old('email_address') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Subject (optional)</label>
                                            <input type="text" name="email_subject" class="form-control" placeholder="Email subject" value="{{ old('email_subject') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Body (optional)</label>
                                            <textarea name="email_body" class="form-control" rows="2" placeholder="Email body">{{ old('email_body') }}</textarea>
                                        </div>
                                    </div>

                                    {{-- Phone --}}
                                    <div class="form-section" id="section-phone">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Phone Number</label>
                                            <input type="text" name="phone_number" class="form-control" placeholder="+1234567890" value="{{ old('phone_number') }}">
                                        </div>
                                    </div>

                                    {{-- SMS --}}
                                    <div class="form-section" id="section-sms">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Phone Number</label>
                                            <input type="text" name="sms_number" class="form-control" placeholder="+1234567890" value="{{ old('sms_number') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Message (optional)</label>
                                            <textarea name="sms_message" class="form-control" rows="2" placeholder="Your message">{{ old('sms_message') }}</textarea>
                                        </div>
                                    </div>

                                    {{-- WhatsApp --}}
                                    <div class="form-section" id="section-whatsapp">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">WhatsApp Number (with country code)</label>
                                            <input type="text" name="whatsapp_number" class="form-control" placeholder="+1234567890" value="{{ old('whatsapp_number') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Pre-filled Message (optional)</label>
                                            <textarea name="whatsapp_message" class="form-control" rows="2" placeholder="Hello!">{{ old('whatsapp_message') }}</textarea>
                                        </div>
                                    </div>

                                    {{-- WiFi --}}
                                    <div class="form-section" id="section-wifi">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Network Name (SSID)</label>
                                            <input type="text" name="wifi_ssid" class="form-control" placeholder="MyWiFiNetwork" value="{{ old('wifi_ssid') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Password</label>
                                            <input type="text" name="wifi_password" class="form-control" placeholder="password123" value="{{ old('wifi_password') }}">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Encryption</label>
                                                <select name="wifi_encryption" class="form-select">
                                                    <option value="WPA" {{ old('wifi_encryption') == 'WPA' ? 'selected' : '' }}>WPA/WPA2</option>
                                                    <option value="WEP" {{ old('wifi_encryption') == 'WEP' ? 'selected' : '' }}>WEP</option>
                                                    <option value="nopass" {{ old('wifi_encryption') == 'nopass' ? 'selected' : '' }}>None</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Hidden Network</label>
                                                <div class="form-check mt-2">
                                                    <input type="checkbox" name="wifi_hidden" class="form-check-input" id="wifiHidden" {{ old('wifi_hidden') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="wifiHidden">Yes, this network is hidden</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- vCard --}}
                                    <div class="form-section" id="section-vcard">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Full Name</label>
                                                <input type="text" name="vcard_name" class="form-control" placeholder="John Doe" value="{{ old('vcard_name') }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Phone</label>
                                                <input type="text" name="vcard_phone" class="form-control" placeholder="+1234567890" value="{{ old('vcard_phone') }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Email</label>
                                                <input type="email" name="vcard_email" class="form-control" placeholder="john@example.com" value="{{ old('vcard_email') }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Organization</label>
                                                <input type="text" name="vcard_org" class="form-control" placeholder="Company Inc." value="{{ old('vcard_org') }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Job Title</label>
                                                <input type="text" name="vcard_title" class="form-control" placeholder="Software Engineer" value="{{ old('vcard_title') }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Website</label>
                                                <input type="text" name="vcard_website" class="form-control" placeholder="https://example.com" value="{{ old('vcard_website') }}">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Address</label>
                                            <input type="text" name="vcard_address" class="form-control" placeholder="123 Main St, City, Country" value="{{ old('vcard_address') }}">
                                        </div>
                                    </div>

                                    {{-- Geo Location --}}
                                    <div class="form-section" id="section-geo">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Latitude</label>
                                                <input type="text" name="geo_latitude" class="form-control" placeholder="40.7128" value="{{ old('geo_latitude') }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Longitude</label>
                                                <input type="text" name="geo_longitude" class="form-control" placeholder="-74.0060" value="{{ old('geo_longitude') }}">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- YouTube --}}
                                    <div class="form-section" id="section-youtube">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">YouTube Video URL or ID</label>
                                            <input type="text" name="youtube_url" class="form-control" placeholder="https://youtube.com/watch?v=... or video ID" value="{{ old('youtube_url') }}">
                                        </div>
                                    </div>

                                    {{-- Instagram --}}
                                    <div class="form-section" id="section-instagram">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Instagram Username</label>
                                            <input type="text" name="instagram_username" class="form-control" placeholder="@username" value="{{ old('instagram_username') }}">
                                        </div>
                                    </div>

                                    {{-- Facebook --}}
                                    <div class="form-section" id="section-facebook">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Facebook Page URL or Username</label>
                                            <input type="text" name="facebook_url" class="form-control" placeholder="https://facebook.com/page or username" value="{{ old('facebook_url') }}">
                                        </div>
                                    </div>

                                    {{-- Twitter --}}
                                    <div class="form-section" id="section-twitter">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Twitter/X Username</label>
                                            <input type="text" name="twitter_username" class="form-control" placeholder="@username" value="{{ old('twitter_username') }}">
                                        </div>
                                    </div>

                                    {{-- LinkedIn --}}
                                    <div class="form-section" id="section-linkedin">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">LinkedIn Profile URL or Username</label>
                                            <input type="text" name="linkedin_url" class="form-control" placeholder="https://linkedin.com/in/username or username" value="{{ old('linkedin_url') }}">
                                        </div>
                                    </div>

                                    {{-- PayPal --}}
                                    <div class="form-section" id="section-paypal">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">PayPal.me Username</label>
                                            <input type="text" name="paypal_email" class="form-control" placeholder="username" value="{{ old('paypal_email') }}">
                                        </div>
                                    </div>

                                    {{-- UPI --}}
                                    <div class="form-section" id="section-upi">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">UPI ID</label>
                                            <input type="text" name="upi_id" class="form-control" placeholder="user@upi" value="{{ old('upi_id') }}">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Payee Name (optional)</label>
                                                <input type="text" name="upi_name" class="form-control" placeholder="John Doe" value="{{ old('upi_name') }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Amount (optional)</label>
                                                <input type="number" name="upi_amount" class="form-control" placeholder="100" step="0.01" value="{{ old('upi_amount') }}">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Zoom --}}
                                    <div class="form-section" id="section-zoom">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Zoom Meeting URL or ID</label>
                                            <input type="text" name="zoom_url" class="form-control" placeholder="https://zoom.us/j/... or meeting ID" value="{{ old('zoom_url') }}">
                                        </div>
                                    </div>

                                    {{-- Skype --}}
                                    <div class="form-section" id="section-skype">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Skype Username</label>
                                            <input type="text" name="skype_username" class="form-control" placeholder="username" value="{{ old('skype_username') }}">
                                        </div>
                                    </div>

                                    {{-- Calendar Event --}}
                                    <div class="form-section" id="section-calendar">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Event Title</label>
                                            <input type="text" name="cal_title" class="form-control" placeholder="Team Meeting" value="{{ old('cal_title') }}">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Start Date & Time</label>
                                                <input type="datetime-local" name="cal_start" class="form-control" value="{{ old('cal_start') }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">End Date & Time</label>
                                                <input type="datetime-local" name="cal_end" class="form-control" value="{{ old('cal_end') }}">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Location (optional)</label>
                                            <input type="text" name="cal_location" class="form-control" placeholder="Conference Room A" value="{{ old('cal_location') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Description (optional)</label>
                                            <textarea name="cal_description" class="form-control" rows="2" placeholder="Meeting details">{{ old('cal_description') }}</textarea>
                                        </div>
                                    </div>

                                    {{-- Plain Text --}}
                                    <div class="form-section" id="section-text">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Text Content</label>
                                            <textarea name="text_content" class="form-control" rows="3" placeholder="Enter any text to encode">{{ old('text_content') }}</textarea>
                                        </div>
                                    </div>

                                    {{-- Settings --}}
                                    <div class="settings-panel">
                                        <h6 class="fw-bold mb-3"><i class="fas fa-cog me-1"></i> Settings</h6>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-semibold">Size (px)</label>
                                                <input type="number" name="size" class="form-control" value="{{ old('size', 300) }}" min="100" max="500" step="50">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-semibold">Color</label>
                                                <input type="color" name="color" class="form-control form-control-color w-100" value="{{ old('color', '#000000') }}">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-semibold">Format</label>
                                                <select name="format" class="form-select">
                                                    <option value="svg" {{ old('format', 'svg') == 'svg' ? 'selected' : '' }}>SVG (Recommended)</option>
                                                    <option value="png" {{ old('format') == 'png' ? 'selected' : '' }}>PNG (requires imagick)</option>
                                                    <option value="eps" {{ old('format') == 'eps' ? 'selected' : '' }}>EPS</option>
                                                </select>
                                                <small class="text-muted">SVG works without extra extensions</small>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-generate w-100">
                                        <i class="fas fa-qrcode me-2"></i>Generate QR Code
                                    </button>
                                </form>
                            </div>

                            <div class="col-md-5 mt-4 mt-md-0">
                                <div class="qr-preview">
                                    @if(isset($qrCode))
                                        @if(isset($imagickAvailable) && !$imagickAvailable && request('format') === 'png')
                                            <div class="alert alert-warning small mb-2">PNG requires the imagick extension. Generated as SVG instead.</div>
                                        @endif
                                        <h5 class="fw-bold mb-3 text-success"><i class="fas fa-check-circle me-1"></i> QR Code Generated!</h5>
                                        <img src="{{ $qrCode }}" alt="QR Code" class="mb-3">
                                        <p class="text-muted small mb-3" style="word-break: break-all;">{{ Str::limit($url, 80) }}</p>
                                        <form method="POST" action="{{ route('qrcode.download') }}">
                                            @csrf
                                            <input type="hidden" name="url" value="{{ $url }}">
                                            <input type="hidden" name="size" value="{{ old('size', 300) }}">
                                            <input type="hidden" name="color" value="{{ old('color', '#000000') }}">
                                            <input type="hidden" name="format" value="{{ $format }}">
                                            <button type="submit" class="btn btn-download">
                                                <i class="fas fa-download me-1"></i> Download {{ strtoupper($format) }}
                                            </button>
                                        </form>
                                    @else
                                        <div class="text-muted">
                                            <i class="fas fa-qrcode" style="font-size: 4rem; opacity: 0.2;"></i>
                                            <p class="mt-3">Your QR code will appear here</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="text-center text-white mt-3 opacity-75 small">
                    QR Code Generator &mdash; Supports 19 different URL/content types
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.url-type-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.url-type-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const type = this.dataset.type;
                document.getElementById('url_type').value = type;

                document.querySelectorAll('.form-section').forEach(s => s.classList.remove('active'));
                document.getElementById('section-' + type).classList.add('active');
            });
        });

        // Restore active tab on page reload
        const currentType = document.getElementById('url_type').value;
        if (currentType) {
            document.querySelectorAll('.url-type-btn').forEach(b => {
                b.classList.remove('active');
                if (b.dataset.type === currentType) b.classList.add('active');
            });
            document.querySelectorAll('.form-section').forEach(s => s.classList.remove('active'));
            const section = document.getElementById('section-' + currentType);
            if (section) section.classList.add('active');
        }
    </script>
</body>
</html>
