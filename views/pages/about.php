<?php
declare(strict_types=1);

/** @var array $awards */
?>

<section class="page-hero">
    <h1>About Us</h1>
    <p><?= e(content_get('home.about_title')) ?></p>
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

<section class="about-main">
    <div class="about-grid">
        <div class="about-copy">
            <p class="section-subtitle">about us</p>
            <h2><?= e(content_get('home.about_title')) ?></h2>
            <p><?= e(content_get('home.about_p1')) ?></p>
            <p><?= e(content_get('home.about_p2')) ?></p>
            <div class="about-highlights">
                <div class="about-highlight">
                    <div class="about-highlight-title">Why People Trust Us</div>
                    <div class="about-highlight-body"><?= e(content_get('about.highlight', content_get('home.pitra_text'))) ?></div>
                </div>
                <div class="about-highlight about-highlight-contact">
                    <div class="about-highlight-title">Call Now</div>
                    <div class="about-highlight-body">+91-<?= e(content_get('site.phone_primary')) ?></div>
                    <a href="tel:+<?= e(content_get('site.whatsapp_number')) ?>" class="btn">Get Advice</a>
                </div>
            </div>
        </div>
        <div class="about-media">
            <?php $aboutImg = content_get('home.about_image', ''); ?>
            <?php if ($aboutImg !== ''): ?>
                <div class="about-image">
                    <img src="<?= e(url_to($aboutImg)) ?>" alt="<?= e(content_get('home.about_caption')) ?>" loading="lazy" decoding="async">
                </div>
            <?php else: ?>
                <div class="about-img-placeholder" aria-hidden="true">🏛</div>
            <?php endif; ?>
            <div class="about-caption"><?= e(content_get('home.about_caption')) ?></div>
        </div>
    </div>
</section>

<section class="about-awards">
    <div class="section-title">
        <p class="section-subtitle">latest</p>
        <h2>Awards & Recognition</h2>
    </div>
    <div class="awards-row">
        <?php foreach (($awards ?: []) as $a): ?>
            <div class="award-mini">
                <div class="award-mini-icon" aria-hidden="true"><?= e((string) ($a['icon_text'] ?? '🏆')) ?></div>
                <h4><?= e((string) ($a['title'] ?? '')) ?></h4>
            </div>
        <?php endforeach; ?>
        <?php if (empty($awards)): ?>
            <div class="award-mini">
                <div class="award-mini-icon" aria-hidden="true">🏆</div>
                <h4>Gold Medal</h4>
            </div>
            <div class="award-mini">
                <div class="award-mini-icon" aria-hidden="true">🎓</div>
                <h4>BHU Varanasi</h4>
            </div>
        <?php endif; ?>
    </div>
</section>

<div class="contact-cta">
    <h3><?= e(content_get('home.help_title')) ?></h3>
    <a href="tel:+<?= e(content_get('site.whatsapp_number')) ?>" class="phone">+91-<?= e(content_get('site.phone_primary')) ?></a>
</div>
