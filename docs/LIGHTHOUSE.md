# Lighthouse Notes

This build avoids external CDNs (fonts/icons) for better Lighthouse scores.

To reach 100s in a real environment:

- Use optimized images (WebP, correct dimensions)
- Set proper `base_url` in `config/config.php` (for canonical/OG URLs)
- Enable gzip/brotli + caching headers in Apache
- Serve over HTTPS

SEO:

- Per-page meta tags are managed in Admin -> SEO (`admin/seo.php`)

