# QR Code Generator - Laravel

An automatic QR code generator built with PHP Laravel that supports **19 different URL and content types**.

## Supported QR Code Types

| Type | Description |
|------|-------------|
| Website | Any website URL |
| Email | mailto: links with subject & body |
| Phone | tel: links for direct calling |
| SMS | sms: links with pre-filled message |
| WhatsApp | wa.me links with pre-filled message |
| WiFi | Auto-connect WiFi credentials (WPA/WEP) |
| vCard | Contact cards with name, phone, email, org |
| Location | Geo coordinates for maps |
| YouTube | Video URLs or IDs |
| Instagram | Profile links |
| Facebook | Page/profile links |
| Twitter/X | Profile links |
| LinkedIn | Profile links |
| PayPal | PayPal.me payment links |
| UPI | UPI payment links with amount |
| Zoom | Meeting URLs or IDs |
| Skype | Chat links |
| Calendar | iCalendar event data |
| Plain Text | Any custom text content |

## Features

- Generate QR codes for 19 different URL/content types
- Customizable QR code size (100–500px)
- Custom QR code color
- Export as SVG or PNG
- Download generated QR codes
- Responsive Bootstrap 5 UI
- High error correction (Level H)

## Requirements

- PHP 8.1+
- Composer
- PHP Extensions: `gd`, `imagick`, `mbstring`, `xml`, `curl`, `zip`, `bcmath`

## Installation

```bash
# Clone the repository
git clone https://github.com/bhavanirani/ongoingdeveenprojects.git
cd ongoingdeveenprojects

# Install dependencies
composer install

# Copy environment file and generate app key
cp .env.example .env
php artisan key:generate

# Run the development server
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## Usage

1. Select a QR code type from the grid (Website, Email, WiFi, etc.)
2. Fill in the required fields for the selected type
3. Adjust settings (size, color, format)
4. Click **Generate QR Code**
5. Download the generated QR code as SVG or PNG

## Tech Stack

- **Backend**: PHP 8.1 / Laravel 10
- **QR Library**: [simplesoftwareio/simple-qrcode](https://github.com/SimpleSoftwareIO/simple-qrcode)
- **Frontend**: Bootstrap 5, Font Awesome 6
- **Formats**: SVG, PNG

## License

MIT
