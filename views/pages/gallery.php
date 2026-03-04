<?php
declare(strict_types=1);

/** @var array $categories */
/** @var array $items */
/** @var string $active_cat */
?>

<section class="page-hero">
    <h1><?= e(content_get('gallery.page_title', 'Gallery')) ?></h1>
    <p><?= e(content_get('gallery.page_subtitle', 'Images from our astrological practice and ceremonies')) ?></p>
</section>

<div class="help-strip">
    <div class="help-strip-inner">
        <div class="help-strip-title"><?= e(content_get('gallery.help_title', 'Need Any Help?')) ?></div>
        <div class="help-strip-text"><?= e(content_get('home.help_text')) ?></div>
        <div class="help-strip-actions">
            <a href="tel:+<?= e(content_get('site.whatsapp_number')) ?>">+91-<?= e(content_get('site.phone_primary')) ?></a>
            <a href="https://wa.me/<?= e(content_get('site.whatsapp_number')) ?>" rel="noopener"><?= e(content_get('gallery.help_whatsapp_label', 'Chat on WhatsApp')) ?></a>
        </div>
    </div>
</div>

<section>
    <div class="section-title">
        <p class="section-subtitle"><?= e(content_get('gallery.section_subtitle', 'latest')) ?></p>
        <h2><?= e(content_get('gallery.section_title', 'Our Gallery')) ?></h2>
        <p class="subtitle"><?= e(content_get('gallery.section_desc', 'Moments from consultations, ceremonies and awards')) ?></p>
    </div>

    <div class="gallery-categories">
        <a href="<?= e(base_url()) ?>/gallery" class="<?= $active_cat === '' ? 'active' : '' ?>"><?= e(content_get('gallery.category_all', 'All')) ?></a>
        <?php foreach (($categories ?: []) as $c): ?>
            <?php $slug = (string) ($c['slug'] ?? ''); ?>
            <a href="<?= e(base_url()) ?>/gallery?cat=<?= e($slug) ?>" class="<?= $active_cat === $slug ? 'active' : '' ?>"><?= e((string) ($c['name'] ?? '')) ?></a>
        <?php endforeach; ?>
    </div>

    <div class="gallery-grid">
        <?php foreach (($items ?: []) as $it): ?>
            <?php
                $title = (string) ($it['title'] ?? '');
                $filePath = (string) ($it['image_path'] ?? '');
                $thumb = $filePath !== '' ? '<img src="' . e(uploads_web_path($filePath)) . '" alt="' . e($title) . '" loading="lazy">' : e((string) ($it['icon_text'] ?? content_get('gallery.item_placeholder_icon', '🖼')));
            ?>
            <div class="gallery-item">
                <div class="thumb"><?= $thumb ?></div>
                <div class="caption"><h3><?= e($title) ?></h3></div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($items)): ?>
            <div class="gallery-item">
                <div class="thumb" aria-hidden="true"><?= e(content_get('gallery.empty_icon', '🏅')) ?></div>
                <div class="caption"><h3><?= e(content_get('gallery.empty_title', 'Gold Medal Award')) ?></h3></div>
            </div>
        <?php endif; ?>
    </div>
</section>

<div class="contact-cta">
    <h3><?= e(content_get('gallery.cta_title', 'Need Astrological Guidance?')) ?></h3>
    <a href="tel:+<?= e(content_get('site.whatsapp_number')) ?>" class="phone">+91-<?= e(content_get('site.phone_primary')) ?></a>
</div>

