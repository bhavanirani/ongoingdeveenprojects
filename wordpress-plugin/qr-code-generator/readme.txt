=== QR Code Generator ===
Contributors: bhavanirani
Tags: qr code, qr generator, qrcode, barcode, url qr code, wifi qr, vcard qr, social media qr
Requires at least: 5.0
Tested up to: 6.5
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Automatic QR Code Generator for all types of URLs — Website, Email, Phone, SMS, WhatsApp, WiFi, vCard, Social Media, Payments, and more.

== Description ==

**QR Code Generator** is a powerful WordPress plugin that lets you generate QR codes for **19 different types of URLs and content** — right from your WordPress dashboard or any page/post using a shortcode.

= Supported QR Code Types =

* **Website** — Any website URL
* **Email** — mailto: links with subject & body
* **Phone** — tel: links for direct calling
* **SMS** — sms: links with pre-filled message
* **WhatsApp** — wa.me links with pre-filled message
* **WiFi** — Auto-connect WiFi credentials (WPA/WEP)
* **vCard** — Contact cards with name, phone, email, organization
* **Location** — Geo coordinates for maps
* **YouTube** — Video URLs or IDs
* **Instagram** — Profile links
* **Facebook** — Page/profile links
* **Twitter/X** — Profile links
* **LinkedIn** — Profile links
* **PayPal** — PayPal.me payment links
* **UPI** — UPI payment links with amount
* **Zoom** — Meeting URLs or IDs
* **Skype** — Chat links
* **Calendar** — iCalendar event data
* **Plain Text** — Any custom text content

= Features =

* Generate QR codes via AJAX (no page reload)
* Customizable QR code size (100–500px)
* Custom QR code color
* Download as SVG file
* Use from WordPress admin dashboard
* Use on any page/post with shortcode `[qr_code_generator]`
* No external API dependencies — QR codes generated on your server
* No imagick or special PHP extensions required
* Responsive design — works on mobile and desktop
* Translation-ready

== Installation ==

= Method 1: Upload via WordPress Admin (Recommended) =

1. Download the plugin ZIP file
2. Go to **Plugins → Add New → Upload Plugin** in your WordPress admin
3. Choose the ZIP file and click **Install Now**
4. Click **Activate Plugin**

= Method 2: Manual Upload via FTP/File Manager =

1. Download and unzip the plugin
2. Upload the `qr-code-generator` folder to `/wp-content/plugins/`
3. Go to **Plugins** in your WordPress admin
4. Find "QR Code Generator" and click **Activate**

= Method 3: Using XAMPP (Local Development) =

1. Download and unzip the plugin
2. Copy the `qr-code-generator` folder to `C:\xampp\htdocs\your-site\wp-content\plugins\`
3. Open your WordPress admin (e.g., http://localhost/your-site/wp-admin/)
4. Go to **Plugins** and activate "QR Code Generator"

== Usage ==

= Admin Dashboard =

After activation, you'll see **"QR Generator"** in your WordPress admin sidebar menu.

1. Click **QR Generator** in the sidebar
2. Select a QR code type (Website, Email, WiFi, etc.)
3. Fill in the required fields
4. Adjust size and color in Settings
5. Click **Generate QR Code**
6. Click **Download SVG** to save the QR code

= Shortcode (for Pages/Posts) =

Add the QR Code Generator to any page or post using:

`[qr_code_generator]`

You can also customize the title:

`[qr_code_generator title="Create Your QR Code"]`

= Example: Adding to a Page =

1. Go to **Pages → Add New**
2. Add the shortcode `[qr_code_generator]` in the content
3. Publish the page
4. Your visitors can now generate QR codes!

== Frequently Asked Questions ==

= Does this plugin require any special PHP extensions? =

No! The plugin uses a pure PHP QR code library (phpqrcode) that works without any special extensions like imagick or GD.

= Can visitors on my site generate QR codes? =

Yes! Use the shortcode `[qr_code_generator]` on any page or post to let visitors generate their own QR codes.

= Are the QR codes generated on my server? =

Yes, all QR codes are generated locally on your server. No external APIs or services are used, ensuring privacy and reliability.

= Can I customize the QR code colors? =

Yes, you can choose any color for your QR code using the built-in color picker.

= What format are the QR codes downloaded in? =

QR codes are downloaded as SVG (Scalable Vector Graphics) files, which can be resized to any size without losing quality.

== Screenshots ==

1. Admin dashboard — QR Code Generator interface
2. Type selection grid showing all 19 supported types
3. Generated QR code with download button
4. Frontend shortcode display on a page

== Changelog ==

= 1.0.0 =
* Initial release
* Support for 19 URL/content types
* Admin dashboard page
* Frontend shortcode support
* AJAX-based generation (no page reload)
* SVG download support
* Custom size and color options
