<?php
declare(strict_types=1);

/** @var string $content */
/** @var string $page_slug */
/** @var bool $db_ready */

$phonePrimary = content_get('site.phone_primary');
$phoneDisplay = content_get('site.phone_display', $phonePrimary);
$wa = content_get('site.whatsapp_number');
$maps = content_get('site.maps_url');
$brand = content_get('site.brand_name');
$topbarTitle = content_get('site.topbar_title');
$brandIconText = content_get('site.brand_icon_text', 'ज्यो');

$nav = [
    'home' => ['label' => 'home', 'href' => base_url() . '/', 'icon' => 'fa-home'],
    'about' => ['label' => 'About Us', 'href' => base_url() . '/about', 'icon' => 'fa-user-astronaut'],
    'services' => ['label' => 'Our Service', 'href' => base_url() . '/services', 'icon' => 'fa-spa'],
    'gallery' => ['label' => 'Gallery', 'href' => base_url() . '/gallery', 'icon' => 'fa-images'],
    'contact' => ['label' => 'contact us', 'href' => base_url() . '/contact', 'icon' => 'fa-phone-volume'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= seo_render_meta($page_slug === 'home' ? 'home' : $page_slug) ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" referrerpolicy="no-referrer">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Source+Sans+3:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <?php $cssVer = @filemtime(__DIR__ . '/../../assets/css/styles.css') ?: time(); ?>
    <link rel="stylesheet" href="<?= e(base_url()) ?>/assets/css/styles.css?v=<?= e((string) $cssVer) ?>">
</head>
<body>
    <div class="top-bar">
        <div class="container">
            <a href="<?= e(base_url()) ?>/" class="top-brand">
                <span class="logo-icon top-logo-icon" lang="hi"><?= e($brandIconText) ?></span>
                <span lang="hi"><?= e($topbarTitle) ?></span>
            </a>
            <div class="top-links">
                <a href="https://wa.me/<?= e($wa) ?>" rel="noopener"><i class="fa-brands fa-whatsapp"></i> <?= e(content_get('topbar.whatsapp_label', 'Whatsapp')) ?></a>
                <a href="tel:+<?= e($wa) ?>"><i class="fa-solid fa-phone-volume"></i> <?= e(content_get('topbar.call_label', 'Call Us')) ?></a>
                <a href="<?= e($maps) ?>" rel="noopener"><i class="fa-solid fa-location-dot"></i> <?= e(content_get('topbar.direction_label', 'Direction')) ?></a>
                <a href="tel:+<?= e($wa) ?>"><i class="fa-solid fa-headset"></i> <?= e(content_get('topbar.request_call_label', 'Request a call')) ?></a>
            </div>
        </div>
    </div>

    <header>
        <div class="header-inner">
            <a href="<?= e(base_url()) ?>/" class="logo logo-only">
                <span class="logo-icon logo-img">
                    <img src="<?= e(base_url()) ?>/assets/img/logo.png" alt="<?= e($brand) ?>" loading="eager" decoding="async">
                </span>
            </a>
            <button class="menu-toggle" aria-label="Toggle menu" aria-expanded="false"><i class="fas fa-bars" aria-hidden="true"></i></button>
            <nav>
                <ul id="mainNav">
                    <?php foreach ($nav as $slug => $item): ?>
                        <li>
                            <a href="<?= e($item['href']) ?>" class="<?= $page_slug === $slug ? 'active' : '' ?>">
                                <?php if (!empty($item['icon'])): ?>
                                    <i class="fa-solid <?= e($item['icon']) ?>" aria-hidden="true"></i>
                                <?php endif; ?>
                                <span><?= e($item['label']) ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
            <div class="header-phone-btn">
                <span class="header-phone"><?= e($phoneDisplay) ?></span>
                <a href="tel:+<?= e($wa) ?>" class="btn-call"><?= e(content_get('header.request_call_label', 'Request a call')) ?></a>
            </div>
        </div>
    </header>

    <?php if (!$db_ready): ?>
        <div class="install-note">
            <div class="install-note-inner">
                <strong>Database not installed yet.</strong>
                Import `database/bhagyarekha.sql`, then login at `<?= e(base_url()) ?>/admin/`.
            </div>
        </div>
    <?php endif; ?>

    <?php if ($page_slug === 'home'): ?>
        <div class="popup-overlay" id="leadPopup" aria-hidden="true">
            <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="popupTitle">
                <button class="popup-close" type="button" aria-label="Close popup">&times;</button>
                <div class="popup-visual">
                    <div class="visual-tag"><?= e(content_get('popup.tag', 'Get Expert Advice')) ?></div>
                    <h3><?= e(content_get('popup.title', 'Personal Guidance, Fast')) ?></h3>
                    <p><?= e(content_get('popup.subtitle', 'Trusted Vedic astrology for accurate predictions and clear remedies.')) ?></p>
                </div>
                <div class="popup-content">
                    <div class="popup-header">
                        <h2 id="popupTitle"><?= e(content_get('popup.form_title', 'Talk To Our Expert')) ?></h2>
                        <p><?= e(content_get('popup.form_subtitle', 'Fill the form and we will call you back shortly.')) ?></p>
                    </div>
                    <form class="popup-form" action="<?= e(base_url()) ?>/contact" method="post" autocomplete="on">
                        <?= csrf_field() ?>
                        <input type="text" name="name" required maxlength="80" placeholder="<?= e(content_get('popup.name_ph', 'Name*')) ?>">
                        <input type="tel" name="phone" required maxlength="30" placeholder="<?= e(content_get('popup.phone_ph', 'Phone*')) ?>">
                        <input type="email" name="email" maxlength="120" placeholder="<?= e(content_get('popup.email_ph', 'Email')) ?>">
                        <input type="text" name="subject" maxlength="120" placeholder="<?= e(content_get('popup.subject_ph', 'Subject (optional)')) ?>">
                        <textarea name="message" required maxlength="2000" placeholder="<?= e(content_get('popup.message_ph', 'Your message...')) ?>"></textarea>
                        <button type="submit" class="btn popup-submit"><?= e(content_get('popup.submit', 'Submit Now')) ?></button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?= $content ?>

    <footer>
        <div class="footer-inner">
            <div>
                <div class="footer-logo footer-logo-only">
                    <span class="footer-logo-icon footer-logo-img">
                        <img src="<?= e(base_url()) ?>/assets/img/logo.png" alt="<?= e($brand) ?>" loading="lazy" decoding="async">
                    </span>
                </div>
                <p style="opacity: 0.9; font-size: 14px;"><?= e(content_get('home.about_title')) ?></p>
            </div>
            <div>
                <h4><i class="fa-solid fa-link" aria-hidden="true"></i> <?= e(content_get('footer.quick_links', 'Quick Links')) ?></h4>
                <ul class="footer-links">
                    <?php foreach ($nav as $item): ?>
                        <li>
                            <a href="<?= e($item['href']) ?>">
                                <?php if (!empty($item['icon'])): ?>
                                    <i class="fa-solid <?= e($item['icon']) ?>" aria-hidden="true"></i>
                                <?php endif; ?>
                                <span><?= e(ucwords((string) $item['label'])) ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="footer-contact">
                <h4><?= e(content_get('footer.get_in_touch', 'Get In Touch')) ?></h4>
                <p><i class="fa-solid fa-location-dot" aria-hidden="true"></i> <?= e(content_get('site.address')) ?></p>
                <p><i class="fa-solid fa-phone-volume" aria-hidden="true"></i> +91-<?= e($phonePrimary) ?></p>
                <p><i class="fa-solid fa-envelope" aria-hidden="true"></i> <?= e(content_get('site.email')) ?></p>
                <p><i class="fa-solid fa-globe" aria-hidden="true"></i> <?= e(content_get('site.website')) ?></p>
            </div>
        </div>
        <div class="footer-bottom"><?= e(content_get('footer.copyright')) ?> | <?= e(content_get('footer.powered_by')) ?></div>
    </footer>

    <?php $jsVer = @filemtime(__DIR__ . '/../../assets/js/main.js') ?: time(); ?>
    <script src="<?= e(base_url()) ?>/assets/js/main.js?v=<?= e((string) $jsVer) ?>" defer></script>
</body>
</html>

