<?php
declare(strict_types=1);

/** @var array $services */
?>

<section class="page-hero">
    <h1>Astrologer Services</h1>
    <p>Comprehensive Vedic astrology solutions for life's challenges</p>
</section>

<div class="help-strip">
    <div class="help-strip-inner">
        <div class="help-strip-title">Need Any Help?</div>
        <div class="help-strip-text"><?= e(content_get('home.help_text')) ?></div>
        <div class="help-strip-actions">
            <a href="tel:+<?= e(content_get('site.whatsapp_number')) ?>">+91-<?= e(content_get('site.phone_primary')) ?></a>
            <a href="https://wa.me/<?= e(content_get('site.whatsapp_number')) ?>" rel="noopener">Chat on WhatsApp</a>
        </div>
    </div>
</div>

<div class="services-intro">
    <p><?= e(content_get('services.intro', content_get('home.help_text'))) ?></p>
</div>

<section class="services-highlights">
    <div class="highlights-grid">
        <div class="highlight-card">
            <div class="highlight-title">Experienced Guidance</div>
            <p>Decades of Vedic practice and trusted consultations.</p>
        </div>
        <div class="highlight-card">
            <div class="highlight-title">Personal Remedies</div>
            <p>Focused solutions for career, health, family, and relationships.</p>
        </div>
        <div class="highlight-card">
            <div class="highlight-title">Confidential & Respectful</div>
            <p>Your concerns are handled with care and privacy.</p>
        </div>
    </div>
</section>

<section>
    <div class="section-title">
        <p class="section-subtitle">Come with</p>
        <h2>Astrologer Services</h2>
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
                        WhatsApp
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (empty($services)): ?>
            <div class="service-card">
                <div class="offer-tag">offer</div>
                <div class="icon" aria-hidden="true">✦</div>
                <h3>No services yet</h3>
                <p>Create services from the admin panel.</p>
                <div class="service-actions">
                    <a href="<?= e(base_url()) ?>/admin/" class="btn">Open Admin</a>
                    <a href="https://wa.me/<?= e(content_get('site.whatsapp_number')) ?>" class="btn btn-outline" rel="noopener">
                        <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                        WhatsApp
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="services-featured">
    <div class="section-title">
        <p class="section-subtitle">featured</p>
        <h2><?= e(content_get('home.pitra_title', 'Pitra Dosh')) ?></h2>
    </div>
    <div class="featured-card">
        <div class="featured-text">
            <p><?= e(content_get('home.pitra_text')) ?></p>
            <div class="featured-actions">
                <a href="tel:+<?= e(content_get('site.whatsapp_number')) ?>" class="btn">
                    <i class="fa-solid fa-phone" aria-hidden="true"></i>
                    Call Now
                </a>
                <a href="https://wa.me/<?= e(content_get('site.whatsapp_number')) ?>" class="btn btn-outline" rel="noopener">
                    <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                    WhatsApp
                </a>
            </div>
        </div>
        <div class="featured-media">
            <?php $pitraImg = content_get('home.pitra_image', ''); ?>
            <?php if ($pitraImg !== ''): ?>
                <img src="<?= e(url_to($pitraImg)) ?>" alt="<?= e(content_get('home.pitra_title')) ?>" loading="lazy" decoding="async">
            <?php else: ?>
                <div class="featured-placeholder" aria-hidden="true">ðŸ¤²</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<div class="hindi-banner">
    <p lang="hi"><?= e(content_get('home.hindi_banner')) ?></p>
    <p class="hindi-banner-cta">need any help? <a href="tel:+<?= e(content_get('site.whatsapp_number')) ?>">+91-<?= e(content_get('site.phone_primary')) ?></a></p>
</div>

