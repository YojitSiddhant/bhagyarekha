<?php
declare(strict_types=1);

/** @var string $page_slug */
/** @var array $services */
/** @var array $testimonials */
/** @var array $products */
/** @var array $awards */

$wa = content_get('site.whatsapp_number');
$phonePrimary = content_get('site.phone_primary');
$heroBg = content_get('home.hero_bg', '');
$aboutImg = content_get('home.about_image', '');
$pitraImg = content_get('home.pitra_image', '');
$sliderRaw = content_get('home.slider_images', '');
$sliderImages = array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $sliderRaw ?: ''))));
$sliderCount = !empty($sliderImages) ? count($sliderImages) : 3;

$heroStyle = '';
if ($heroBg !== '') {
    // Use a CSS variable so the CSS stays close to the reference design.
    $u = url_to($heroBg);
    $heroStyle = " style=\"--hero-bg-url: url('" . e($u) . "')\"";
}

// Extra homepage images to match the screenshot layout
$topBanner = content_get('home.top_banner_image', '');
$midBanner = content_get('home.mid_banner_image', '');
$productsSecondTitle = content_get('home.products_second_title', 'Our Product');
?>

<div class="home-slider" data-interval="4500">
    <div class="home-slider-track">
        <?php if (!empty($sliderImages)): ?>
            <?php foreach ($sliderImages as $i => $img): ?>
                <div class="home-slide<?= $i === 0 ? ' is-active' : '' ?>">
                    <img src="<?= e(url_to($img)) ?>" alt="Home slider image <?= $i + 1 ?>" loading="<?= $i === 0 ? 'eager' : 'lazy' ?>" decoding="async">
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <?php for ($i = 1; $i <= 3; $i++): ?>
                <div class="home-slide<?= $i === 1 ? ' is-active' : '' ?>">
                    <div class="home-slide-placeholder">
                        <span><?= e(content_get('home.slider_placeholder_title', 'Home Slider Placeholder')) ?> <?= $i ?></span>
                        <small><?= e(content_get('home.slider_placeholder_note', 'Add images in Admin → Content (home.slider_images)')) ?></small>
                    </div>
                </div>
            <?php endfor; ?>
        <?php endif; ?>
    </div>
    <div class="home-slider-overlay">
        <div class="home-slider-content">
            <div class="home-slider-pill"><?= e(content_get('home.slider_pill', 'Astrology · Vedic Guidance · Remedies')) ?></div>
            <h1><?= e(content_get('home.hero_title')) ?></h1>
            <p><?= e(content_get('home.slider_subtitle', content_get('home.about_p1'))) ?></p>
            <div class="home-slider-actions">
                <a href="tel:+<?= e($wa) ?>" class="btn btn-light"><?= e(content_get('home.slider_primary_btn', 'Call Now')) ?></a>
                <a href="<?= e(base_url()) ?>/contact" class="btn btn-outline-light"><?= e(content_get('home.slider_secondary_btn', 'Request a Call')) ?></a>
            </div>
            <div class="home-slider-meta">
                <span><?= e(content_get('home.slider_meta_left', 'Fast response within 24 hours')) ?></span>
                <span>+91-<?= e($phonePrimary) ?></span>
            </div>
        </div>
        <div class="home-slider-card">
            <h3><?= e(content_get('home.slider_card_title', 'Why Choose Us')) ?></h3>
            <p><?= e(content_get('home.slider_card_subtitle', 'Trusted guidance, personalized remedies, and years of experience.')) ?></p>
            <ul>
                <li><?= e(content_get('home.slider_card_li_1', '10+ years of consultation')) ?></li>
                <li><?= e(content_get('home.slider_card_li_2', '5000+ satisfied clients')) ?></li>
                <li><?= e(content_get('home.slider_card_li_3', 'Online & in-person sessions')) ?></li>
            </ul>
            <div class="home-slider-card-stats">
                <div><strong><?= e(content_get('home.slider_stat_1_value', '10+')) ?></strong><span><?= e(content_get('home.slider_stat_1_label', 'Years')) ?></span></div>
                <div><strong><?= e(content_get('home.slider_stat_2_value', '5k+')) ?></strong><span><?= e(content_get('home.slider_stat_2_label', 'Clients')) ?></span></div>
                <div><strong><?= e(content_get('home.slider_stat_3_value', '24/7')) ?></strong><span><?= e(content_get('home.slider_stat_3_label', 'Support')) ?></span></div>
            </div>
        </div>
    </div>
    <div class="home-slider-dots" role="tablist" aria-label="Slider pagination">
        <?php for ($i = 0; $i < $sliderCount; $i++): ?>
            <button class="home-slider-dot<?= $i === 0 ? ' is-active' : '' ?>" type="button" aria-label="Go to slide <?= $i + 1 ?>"></button>
        <?php endfor; ?>
    </div>
    <div class="home-slider-controls" aria-label="Slider controls">
        <button class="home-slider-btn prev" type="button" aria-label="Previous slide">&#10094;</button>
        <button class="home-slider-btn next" type="button" aria-label="Next slide">&#10095;</button>
    </div>
</div>

<?php if ($topBanner !== ''): ?>
    <div class="home-top-banner">
        <img src="<?= e(url_to($topBanner)) ?>" alt="" loading="eager" decoding="async" fetchpriority="high">
    </div>
<?php elseif (empty($sliderImages)): ?>
    <div class="hero-banner"<?= $heroStyle ?>>
        <div class="hero-content">
            <h1><?= e(content_get('home.hero_title')) ?></h1>
            <a href="tel:+<?= e($wa) ?>" class="btn"><?= e(content_get('home.hero_button')) ?></a>
        </div>
        <div class="hero-cta-bar">
            <span class="contact-no"><?= e(content_get('home.hero_contact_label', 'CONTACT NO.')) ?> <?= e($phonePrimary) ?></span>
            <a href="tel:+<?= e($wa) ?>" class="talk-now" lang="hi"><?= e(content_get('home.hero_hindi_cta')) ?></a>
        </div>
    </div>
<?php endif; ?>

<section class="about-section">
    <div class="about-content">
        <div class="about-text">
            <p class="section-subtitle"><?= e(content_get('home.about_subtitle')) ?></p>
            <h2><?= e(content_get('home.about_title')) ?></h2>
            <p><?= e(content_get('home.about_p1')) ?></p>
            <p><?= e(content_get('home.about_p2')) ?></p>
            <span class="phone-large"><?= e($phonePrimary) ?></span>
            <a href="tel:+<?= e($wa) ?>" class="btn"><?= e(content_get('home.about_cta', 'Request a Call')) ?></a>
        </div>
        <div>
            <?php if ($aboutImg !== ''): ?>
                <div class="about-image">
                    <img src="<?= e(url_to($aboutImg)) ?>" alt="<?= e(content_get('home.about_caption')) ?>" loading="lazy" decoding="async">
                </div>
            <?php else: ?>
                <div class="about-image placeholder" aria-hidden="true"><?= e(content_get('home.about_placeholder_icon', '🏅')) ?></div>
            <?php endif; ?>
            <p class="about-caption"><?= e(content_get('home.about_caption')) ?></p>
        </div>
    </div>
</section>

<section class="home-action-section">
    <div class="home-action-grid">
        <div class="action-card">
            <div class="action-card-title" lang="hi"><?= e(content_get('home.action_left_title', 'राशिफल')) ?></div>
            <div class="action-card-body"><?= e(content_get('home.action_left_text', 'अपनी राशि जानने के लिए संपर्क करें')) ?></div>
            <a class="btn" href="<?= e(base_url()) ?>/contact"><?= e(content_get('home.action_left_btn', 'Contact Now')) ?></a>
        </div>
        <div class="action-card action-card-whatsapp">
            <div class="action-card-title"><?= e(content_get('home.action_right_title', 'WhatsApp')) ?></div>
            <div class="action-card-body"><?= e(content_get('home.action_right_text', 'Free advice on WhatsApp')) ?></div>
            <a class="btn btn-green" href="https://wa.me/<?= e($wa) ?>" rel="noopener"><?= e(content_get('home.action_right_btn', 'WhatsApp Now')) ?></a>
        </div>
    </div>
</section>

<div class="hindi-banner hindi-banner-compact">
    <p lang="hi"><?= e(content_get('home.hindi_banner')) ?></p>
    <div class="hindi-banner-help">
        <p class="section-subtitle"><?= e(content_get('home.help_title')) ?></p>
        <p class="cta-text"><?= e(content_get('home.help_text')) ?></p>
        <div class="hindi-banner-actions">
            <a class="btn" href="tel:+<?= e($wa) ?>"><?= e(content_get('home.hindi_banner_cta', 'Call Now')) ?></a>
            <a class="btn btn-whatsapp" href="https://wa.me/<?= e($wa) ?>" rel="noopener">
                <i class="fab fa-whatsapp" aria-hidden="true"></i>
                <?= e(content_get('home.hindi_banner_whatsapp_label', 'WhatsApp')) ?>
            </a>
        </div>
        <div class="hindi-banner-phone">+91-<?= e($phonePrimary) ?></div>
    </div>
</div>

<section>
    <div class="section-title">
        <p class="section-subtitle"><?= e(content_get('home.services_subtitle', 'Come with')) ?></p>
        <h2><?= e(content_get('home.services_title', 'Astrologer Services')) ?></h2>
    </div>
    <div class="services-grid">
        <?php if (empty($services)): ?>
            <div class="service-card">
                <div class="offer-tag"><?= e(content_get('home.services_placeholder_tag', 'offer')) ?></div>
                <div class="icon" aria-hidden="true">✋</div>
                <h3><?= e(content_get('home.services_placeholder_title', 'Palmistry')) ?></h3>
                <p><?= e(content_get('home.services_placeholder_desc', 'Manage these cards from the admin panel.')) ?></p>
                <a href="<?= e(base_url()) ?>/admin/" class="btn"><?= e(content_get('home.services_placeholder_btn', 'Open Admin')) ?></a>
            </div>
        <?php else: ?>
            <?php foreach ($services as $s): ?>
                <?php $img = (string) ($s['image_path'] ?? ''); ?>
                <div class="service-card">
                    <div class="offer-tag"><?= e((string) ($s['offer_tag'] ?? 'offer')) ?></div>
                    <?php if ($img !== ''): ?>
                        <div class="service-thumb">
                            <img src="<?= e(uploads_web_path($img)) ?>" alt="<?= e((string) ($s['title'] ?? '')) ?>" loading="lazy" decoding="async">
                        </div>
                    <?php else: ?>
                        <div class="icon" aria-hidden="true"><?= e((string) ($s['icon_text'] ?? '✦')) ?></div>
                    <?php endif; ?>
                    <h3><?= e((string) ($s['title'] ?? '')) ?></h3>
                    <p><?= e((string) ($s['description'] ?? '')) ?></p>
                    <a href="tel:+<?= e($wa) ?>" class="btn"><?= e((string) ($s['cta_text'] ?? 'Call Now Get Free Advice')) ?></a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?php if ($midBanner !== ''): ?>
    <div class="home-mid-banner">
        <img src="<?= e(url_to($midBanner)) ?>" alt="" loading="lazy" decoding="async">
    </div>
<?php endif; ?>

<section class="pitra-section">
    <div class="section-title">
        <h2><?= e(content_get('home.pitra_title')) ?></h2>
    </div>
    <div class="pitra-content">
        <div class="pitra-media">
        <?php if ($pitraImg !== ''): ?>
            <div class="pitra-image pitra-image-photo">
                <img src="<?= e(url_to($pitraImg)) ?>" alt="<?= e(content_get('home.pitra_title')) ?>" loading="lazy" decoding="async">
            </div>
        <?php else: ?>
            <div class="pitra-image" aria-hidden="true">🤲</div>
        <?php endif; ?>
        </div>
        <div class="pitra-text">
            <p><?= e(content_get('home.pitra_text')) ?></p>
            <div class="pitra-actions">
                <span class="phone-large"><?= e($phonePrimary) ?></span>
                <a href="tel:+<?= e($wa) ?>" class="btn"><?= e(content_get('home.pitra_cta', 'Call Now')) ?></a>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="section-title">
        <p class="section-subtitle"><?= e(content_get('home.products_subtitle', 'latest')) ?></p>
        <h2><?= e(content_get('home.products_title', 'Our Product')) ?></h2>
    </div>
    <div class="products-grid products-grid-hero">
        <?php foreach (($products ?: []) as $p): ?>
            <?php $pimg = (string) ($p['image_path'] ?? ''); ?>
            <div class="product-card product-card-banner">
                <?php if ($pimg !== ''): ?>
                    <img class="product-banner-img" src="<?= e(uploads_web_path($pimg)) ?>" alt="<?= e((string) ($p['title'] ?? '')) ?>" loading="lazy" decoding="async">
                <?php else: ?>
                    <div class="product-img" aria-hidden="true"><?= e((string) ($p['icon_text'] ?? '📜')) ?></div>
                <?php endif; ?>
                <div class="product-info">
                    <h3><?= e((string) ($p['title'] ?? '')) ?></h3>
                    <p><?= e((string) ($p['description'] ?? '')) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php
$testimonialItems = $testimonials ?: [
    ['quote' => content_get('home.testimonial_1_quote', 'Guruji gives enough time to explain and guide us clearly. We felt positive changes soon.'), 'author' => content_get('home.testimonial_1_author', 'Neha Sharma'), 'role' => content_get('home.testimonial_1_role', 'Customer')],
    ['quote' => content_get('home.testimonial_2_quote', 'Accurate predictions and practical remedies. Very humble and patient.'), 'author' => content_get('home.testimonial_2_author', 'Rohit Verma'), 'role' => content_get('home.testimonial_2_role', 'Customer')],
    ['quote' => content_get('home.testimonial_3_quote', 'Our family issues improved after consultation. Highly recommended.'), 'author' => content_get('home.testimonial_3_author', 'Pooja Singh'), 'role' => content_get('home.testimonial_3_role', 'Customer')],
    ['quote' => content_get('home.testimonial_4_quote', 'Clear guidance for career and education. Very satisfied with the advice.'), 'author' => content_get('home.testimonial_4_author', 'Amit Patel'), 'role' => content_get('home.testimonial_4_role', 'Customer')],
    ['quote' => content_get('home.testimonial_5_quote', 'Detailed explanation and honest suggestions. Helped me a lot.'), 'author' => content_get('home.testimonial_5_author', 'Kavita Mishra'), 'role' => content_get('home.testimonial_5_role', 'Customer')],
    ['quote' => content_get('home.testimonial_6_quote', 'Great experience. The remedies were simple and effective.'), 'author' => content_get('home.testimonial_6_author', 'Sandeep Yadav'), 'role' => content_get('home.testimonial_6_role', 'Customer')],
    ['quote' => content_get('home.testimonial_7_quote', 'Very knowledgeable and kind. Gave time to understand the problem.'), 'author' => content_get('home.testimonial_7_author', 'Rina Gupta'), 'role' => content_get('home.testimonial_7_role', 'Customer')],
    ['quote' => content_get('home.testimonial_8_quote', 'Professional and reliable. We got the right direction.'), 'author' => content_get('home.testimonial_8_author', 'Vikram Chauhan'), 'role' => content_get('home.testimonial_8_role', 'Customer')],
];
?>

<section class="testimonials-section testimonials-light">
    <div class="section-title">
        <p class="section-subtitle"><?= e(content_get('home.testimonial_subtitle', 'Some Words')) ?></p>
        <h2><?= e(content_get('home.testimonial_title', 'Testimonial')) ?></h2>
    </div>
    <div class="testimonials-marquee" aria-label="Testimonials">
        <div class="testimonials-track">
            <?php foreach ($testimonialItems as $t): ?>
                <div class="testimonial-card">
                    <p><?= e((string) ($t['quote'] ?? '')) ?></p>
                    <div class="author"><?= e((string) ($t['author'] ?? '')) ?></div>
                    <div class="role"><?= e((string) ($t['role'] ?? 'Customer')) ?></div>
                </div>
            <?php endforeach; ?>
            <?php foreach ($testimonialItems as $t): ?>
                <div class="testimonial-card">
                    <p><?= e((string) ($t['quote'] ?? '')) ?></p>
                    <div class="author"><?= e((string) ($t['author'] ?? '')) ?></div>
                    <div class="role"><?= e((string) ($t['role'] ?? 'Customer')) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="products-second">
    <div class="section-title">
        <p class="section-subtitle"><?= e(content_get('home.products_second_subtitle', 'latest')) ?></p>
        <h2><?= e($productsSecondTitle) ?></h2>
    </div>
    <div class="products-grid products-grid-compact">
        <?php foreach (($products ?: []) as $p): ?>
            <?php $pimg2 = (string) ($p['image_path'] ?? ''); ?>
            <div class="product-card product-card-compact">
                <?php if ($pimg2 !== ''): ?>
                    <div class="product-compact-img">
                        <img src="<?= e(uploads_web_path($pimg2)) ?>" alt="<?= e((string) ($p['title'] ?? '')) ?>" loading="lazy" decoding="async">
                    </div>
                <?php else: ?>
                    <div class="product-compact-img product-compact-placeholder" aria-hidden="true"><?= e((string) ($p['icon_text'] ?? '📜')) ?></div>
                <?php endif; ?>
                <div class="product-info">
                    <h3><?= e((string) ($p['title'] ?? '')) ?></h3>
                    <p><?= e((string) ($p['description'] ?? '')) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section>
    <div class="section-title">
        <p class="section-subtitle"><?= e(content_get('home.awards_subtitle', 'latest')) ?></p>
        <h2><?= e(content_get('home.awards_title', 'Awards')) ?></h2>
    </div>
    <div class="awards-grid">
        <?php foreach (($awards ?: []) as $a): ?>
            <div class="award-card">
                <?php $aimg = (string) ($a['image_path'] ?? ''); ?>
                <?php if ($aimg !== ''): ?>
                    <div class="award-img award-img-photo">
                        <img src="<?= e(uploads_web_path($aimg)) ?>" alt="<?= e((string) ($a['title'] ?? '')) ?>" loading="lazy" decoding="async">
                    </div>
                <?php else: ?>
                    <div class="award-img" aria-hidden="true"><?= e((string) ($a['icon_text'] ?? '🏆')) ?></div>
                <?php endif; ?>
                <div class="award-info"><h3><?= e((string) ($a['title'] ?? '')) ?></h3></div>
            </div>
        <?php endforeach; ?>
        <?php if (empty($awards)): ?>
            <div class="award-card">
                <div class="award-img" aria-hidden="true">🏆</div>
                <div class="award-info"><h3><?= e(content_get('home.awards_placeholder_title', 'Awarded with gold medal')) ?></h3></div>
            </div>
        <?php endif; ?>
    </div>
    <p style="text-align: center; margin-top: 35px;">
        <a href="tel:+<?= e($wa) ?>" class="btn" style="padding: 16px 45px; font-size: 18px;"><?= e(content_get('home.awards_cta', 'GET ADVICE')) ?></a>
    </p>
</section>

