# QR Code Generator — WordPress Plugin

A WordPress plugin that generates QR codes for **19 different types of URLs and content**. Works from the admin dashboard and on any page/post via shortcode.

---

## Quick Start Guide

### Step 1: Install the Plugin

**Option A — Via WordPress Admin (Recommended):**
1. Download the `qr-code-generator` folder as a ZIP
2. In WordPress admin, go to **Plugins → Add New → Upload Plugin**
3. Upload the ZIP and click **Install Now**
4. Click **Activate Plugin**

**Option B — Manual Upload (XAMPP / FTP):**
1. Copy the `qr-code-generator` folder to your WordPress plugins directory:
   - **XAMPP**: `C:\xampp\htdocs\your-site\wp-content\plugins\`
   - **Server**: `/var/www/html/your-site/wp-content/plugins/`
2. Go to WordPress admin → **Plugins**
3. Find "QR Code Generator" and click **Activate**

### Step 2: Use the Plugin

**From Admin Dashboard:**
1. Look for **"QR Generator"** in the WordPress admin sidebar (left menu)
2. Click it to open the QR Code Generator
3. Select a type → Fill in details → Click **Generate QR Code**
4. Download the QR code as SVG

**From Any Page/Post (for visitors):**
1. Go to **Pages → Add New** (or edit an existing page)
2. Add this shortcode in the content: `[qr_code_generator]`
3. Publish/Update the page
4. Visitors can now generate QR codes on that page!

---

## Supported QR Code Types (19 Total)

| # | Type | What It Does | Example Input |
|---|------|-------------|---------------|
| 1 | **Website** | Opens a website URL | `https://google.com` |
| 2 | **Email** | Opens email client with pre-filled fields | `user@example.com` |
| 3 | **Phone** | Initiates a phone call | `+1234567890` |
| 4 | **SMS** | Opens SMS app with pre-filled message | `+1234567890` |
| 5 | **WhatsApp** | Opens WhatsApp chat | `+919876543210` |
| 6 | **WiFi** | Auto-connects to WiFi network | SSID + Password |
| 7 | **vCard** | Saves contact to phone | Name, Phone, Email |
| 8 | **Location** | Opens maps at coordinates | Lat: `40.7128`, Lng: `-74.0060` |
| 9 | **YouTube** | Opens YouTube video | Video URL or ID |
| 10 | **Instagram** | Opens Instagram profile | `@username` |
| 11 | **Facebook** | Opens Facebook page | Page URL or username |
| 12 | **Twitter/X** | Opens Twitter profile | `@username` |
| 13 | **LinkedIn** | Opens LinkedIn profile | Profile URL or username |
| 14 | **PayPal** | Opens PayPal.me payment page | PayPal username |
| 15 | **UPI** | Opens UPI payment app (India) | UPI ID like `user@upi` |
| 16 | **Zoom** | Opens Zoom meeting | Meeting URL or ID |
| 17 | **Skype** | Opens Skype chat | Skype username |
| 18 | **Calendar** | Adds event to calendar | Title + Date/Time |
| 19 | **Plain Text** | Encodes any text | Any text content |

---

## Features

- **No External Dependencies** — QR codes are generated on your server using PHP (no API calls)
- **No Special PHP Extensions Needed** — Works with basic PHP (no imagick/GD required)
- **AJAX Generation** — QR codes appear instantly without page reload
- **Custom Size** — Choose between 100px and 500px
- **Custom Color** — Pick any color for your QR code
- **SVG Download** — Download as scalable vector graphic (perfect quality at any size)
- **Admin + Frontend** — Use from dashboard or let visitors generate via shortcode
- **Mobile Responsive** — Works on phones, tablets, and desktops
- **Translation Ready** — All strings are translatable

---

## Shortcode Options

| Shortcode | Description |
|-----------|-------------|
| `[qr_code_generator]` | Default QR Code Generator |
| `[qr_code_generator title="My QR Tool"]` | Custom title |

---

## File Structure

```
qr-code-generator/
├── qr-code-generator.php      # Main plugin file
├── readme.txt                  # WordPress.org readme
├── includes/
│   ├── class-qr-generator.php # QR code generation logic
│   ├── class-qr-admin.php     # Admin page setup
│   ├── class-qr-shortcode.php # Shortcode handler
│   ├── class-qr-ajax.php      # AJAX handlers
│   └── phpqrcode/             # PHP QR Code library (bundled)
├── assets/
│   ├── css/
│   │   ├── admin.css           # Admin page styles
│   │   └── frontend.css        # Frontend shortcode styles
│   └── js/
│       ├── admin.js            # Admin JavaScript
│       └── frontend.js         # Frontend JavaScript
├── templates/
│   ├── admin-page.php          # Admin page template
│   ├── frontend-form.php       # Shortcode form template
│   └── form-fields.php         # Shared form fields
└── languages/                  # Translation files
```

---

## XAMPP Setup (Step-by-Step for Beginners)

If you're running WordPress locally on XAMPP:

1. **Make sure XAMPP is running** — Open XAMPP Control Panel, start **Apache** and **MySQL**

2. **Copy the plugin folder**:
   ```
   Copy: qr-code-generator/
   To:   C:\xampp\htdocs\your-wordpress-site\wp-content\plugins\
   ```

3. **Activate the plugin**:
   - Open browser: `http://localhost/your-wordpress-site/wp-admin/`
   - Go to **Plugins** in the sidebar
   - Find **"QR Code Generator"** and click **Activate**

4. **Use the plugin**:
   - Click **"QR Generator"** in the admin sidebar
   - Or add `[qr_code_generator]` to any page

---

## Troubleshooting

| Problem | Solution |
|---------|----------|
| Plugin not showing in admin | Make sure you copied the folder to `wp-content/plugins/` and activated it |
| QR code not generating | Check browser console (F12) for JavaScript errors |
| "500 Internal Server Error" | Check PHP error logs; make sure PHP 7.4+ is installed |
| Shortcode shows as text | Make sure the plugin is activated |
| QR code too small/large | Adjust the Size setting (100-500px) |

---

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- No special PHP extensions required

---

## License

GPL v2 or later — [https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html)
