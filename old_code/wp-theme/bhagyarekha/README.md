# Bhagyarekha - Astrologer WordPress Theme

Professional WordPress theme for Jyotisacharya Rajkishor Tiwari - Gold Medalist Astrologer. Elementor compatible with one-click demo import.

## Installation

1. **Copy theme to WordPress**
   - Copy the `bhagyarekha` folder to `wp-content/themes/`
   - Or zip the `bhagyarekha` folder and upload via Appearance > Themes > Add New > Upload

2. **Activate the theme**
   - Go to Appearance > Themes
   - Activate "Bhagyarekha - Astrologer"

3. **Install Elementor (Recommended)**
   - Go to Plugins > Add New
   - Search for "Elementor" and install
   - Activate Elementor

4. **Import Demo Content**
   - Go to Appearance > Import Demo
   - Click "Import Demo Content"
   - This creates: Home, About, Services, Gallery, Contact pages + Primary menu
   - Sets Home as front page
   - Sets site title to "Ganapati Jyotish Sodh Sadan"

## Customization

### Contact Info (Appearance > Customize > Contact Info)
- **Phone Number**: Default 09452884067
- **WhatsApp Number**: With country code (e.g., 919452884067)

### Menus (Appearance > Menus)
- **Primary Menu**: Main navigation (header)
- **Footer Menu**: Footer links
- **Top Bar Menu**: Optional top bar links

### Elementor
- Edit any page with "Edit with Elementor"
- Theme provides Header and Footer locations - you can replace with Elementor templates
- Design CSS classes available: `hero-banner`, `service-card`, `contact-cta`, `section-title`, etc.

## Design Tokens (for Elementor/Custom CSS)

```css
--red: #b71c1c
--red-dark: #8b0000
--brown: #5d4037
--brown-dark: #3e2723
--gradient-dark: linear-gradient(135deg, #5d4037 0%, #3e2723 50%, #4e342e 100%)
```

## File Structure

```
bhagyarekha/
├── style.css          # Theme info
├── functions.php      # Theme setup
├── header.php         # Header template
├── footer.php         # Footer template
├── front-page.php     # Home page
├── page.php           # Page template
├── index.php          # Blog index
├── inc/
│   ├── template-tags.php
│   └── demo-import.php
├── template-parts/
│   ├── content-front-page.php
│   ├── content-page.php
│   └── ...
├── assets/
│   ├── css/styles.css
│   └── js/main.js
└── demo-import/
    └── elementor/     # Elementor import docs
```

## Requirements

- WordPress 5.0+
- PHP 7.4+
- Elementor (optional, for page builder)

## Support

Theme by Techvanta Labs Pvt Ltd (https://techvantalabs.com) for Ganapati Jyotish Sodh Sadan.
