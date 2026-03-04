<?php
declare(strict_types=1);

/** @var array $services */
?>

<section class="page-hero">
    <h1><?= e(content_get('services.page_title', 'Astrologer Services')) ?></h1>
    <p><?= e(content_get('services.page_subtitle', "Comprehensive Vedic astrology solutions for life's challenges")) ?></p>
</section>

<div class="help-strip">
    <div class="help-strip-inner">
        <div class="help-strip-title"><?= e(content_get('services.help_title', 'Need Any Help?')) ?></div>
        <div class="help-strip-text"><?= e(content_get('home.help_text')) ?></div>
        <div class="help-strip-actions">
            <a href="tel:+<?= e(content_get('site.whatsapp_number')) ?>">+91-<?= e(content_get('site.phone_primary')) ?></a>
            <a href="https://wa.me/<?= e(content_get('site.whatsapp_number')) ?>" rel="noopener"><?= e(content_get('services.help_whatsapp_label', 'Chat on WhatsApp')) ?></a>
        </div>
    </div>
</div>

<div class="services-intro">
    <p><?= e(content_get('services.intro', content_get('home.help_text'))) ?></p>
</div>

<section class="services-highlights">
    <div class="highlights-grid">
        <div class="highlight-card">
            <div class="highlight-title"><?= e(content_get('services.highlight_1_title', 'Experienced Guidance')) ?></div>
            <p><?= e(content_get('services.highlight_1_desc', 'Decades of Vedic practice and trusted consultations.')) ?></p>
        </div>
        <div class="highlight-card">
            <div class="highlight-title"><?= e(content_get('services.highlight_2_title', 'Personal Remedies')) ?></div>
            <p><?= e(content_get('services.highlight_2_desc', 'Focused solutions for career, health, family, and relationships.')) ?></p>
        </div>
        <div class="highlight-card">
            <div class="highlight-title"><?= e(content_get('services.highlight_3_title', 'Confidential & Respectful')) ?></div>
            <p><?= e(content_get('services.highlight_3_desc', 'Your concerns are handled with care and privacy.')) ?></p>
        </div>
    </div>
</section>

<section>
    <div class="section-title">
        <p class="section-subtitle"><?= e(content_get('services.section_subtitle', 'Come with')) ?></p>
        <h2><?= e(content_get('services.section_title', 'Astrologer Services')) ?></h2>
    </div>
    <div class="services-grid">
        <?php foreach (($services ?: []) as $s): ?>
            <div class="service-card">
                <div class="offer-tag"><?= e((string) ($s['offer_tag'] ?? 'offer')) ?></div>
                <div class="icon" aria-hidden="true"><?= e((string) ($s['icon_text'] ?? '✦')) ?></div>
                <h3><?= e((string) ($s['title'] ?? '')) ?></h3>
                <p><?= e((string) ($s['description'] ?? '')) ?></p>
                <div class="service-actions">
                    <a href="tel:+<?= e(content_get('site.whatsapp_number')) ?>" class="btn">
                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                        <?= e((string) ($s['cta_text'] ?? 'Call Now Get Free Advice')) ?>
                    </a>
                    <a href="https://wa.me/<?= e(content_get('site.whatsapp_number')) ?>" class="btn btn-outline" rel="noopener">
                        <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                        <?= e(content_get('services.cta_whatsapp_label', 'WhatsApp')) ?>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (empty($services)): ?>
            <div class="service-card">
                <div class="offer-tag"><?= e(content_get('services.empty_tag', 'offer')) ?></div>
                <div class="icon" aria-hidden="true"><?= e(content_get('services.empty_icon', '✦')) ?></div>
                <h3><?= e(content_get('services.empty_title', 'No services yet')) ?></h3>
                <p><?= e(content_get('services.empty_desc', 'Create services from the admin panel.')) ?></p>
                <div class="service-actions">
                    <a href="<?= e(base_url()) ?>/admin/" class="btn"><?= e(content_get('services.empty_btn', 'Open Admin')) ?></a>
                    <a href="https://wa.me/<?= e(content_get('site.whatsapp_number')) ?>" class="btn btn-outline" rel="noopener">
                        <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                        <?= e(content_get('services.cta_whatsapp_label', 'WhatsApp')) ?>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="services-featured">
    <div class="section-title">
        <p class="section-subtitle"><?= e(content_get('services.featured_subtitle', 'featured')) ?></p>
        <h2><?= e(content_get('home.pitra_title', 'Pitra Dosh')) ?></h2>
    </div>
    <div class="featured-card">
        <div class="featured-text">
            <p><?= e(content_get('home.pitra_text')) ?></p>
            <div class="featured-actions">
                <a href="tel:+<?= e(content_get('site.whatsapp_number')) ?>" class="btn">
                    <i class="fa-solid fa-phone" aria-hidden="true"></i>
                    <?= e(content_get('services.featured_call', 'Call Now')) ?>
                </a>
                <a href="https://wa.me/<?= e(content_get('site.whatsapp_number')) ?>" class="btn btn-outline" rel="noopener">
                    <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                    <?= e(content_get('services.cta_whatsapp_label', 'WhatsApp')) ?>
                </a>
            </div>
        </div>
        <div class="featured-media">
            <?php $pitraImg = content_get('home.pitra_image', ''); ?>
            <?php if ($pitraImg !== ''): ?>
                <img src="<?= e(url_to($pitraImg)) ?>" alt="<?= e(content_get('home.pitra_title')) ?>" loading="lazy" decoding="async">
            <?php else: ?>
                <div class="featured-placeholder" aria-hidden="true"><?= e(content_get('services.featured_placeholder_icon', '🤲')) ?></div>
            <?php endif; ?>
        </div>
    </div>
</section>

<div class="hindi-banner">
    <p lang="hi"><?= e(content_get('home.hindi_banner')) ?></p>
    <p class="hindi-banner-cta"><?= e(content_get('services.hindi_cta_prefix', 'need any help?')) ?> <a href="tel:+<?= e(content_get('site.whatsapp_number')) ?>">+91-<?= e(content_get('site.phone_primary')) ?></a></p>
</div>

