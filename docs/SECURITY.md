# Security Notes

Implemented:

- PDO prepared statements (SQL injection protection)
- Output encoding with `e()` helper (XSS protection for text fields)
- CSRF tokens on admin + contact form
- Session hardening (HttpOnly, SameSite=Lax, strict mode)
- Upload validation: image-only + size limit + random filenames
- Upload execution blocked via `uploads/.htaccess`
- Basic security headers via `app/security.php`

Operational checklist:

- Use HTTPS in production (then you can enable HSTS in `app/security.php`)
- Change the seeded admin password (`admin123`)
- Keep `uploads/` non-executable (already done for Apache)
- Regularly backup DB + uploads

