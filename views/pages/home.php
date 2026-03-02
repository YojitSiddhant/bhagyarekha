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
                        <span>Home Slider Placeholder <?= $i ?></span>
                        <small>Add images in Admin → Content (`home.slider_images`)</small>
                    </div>
                </div>
            <?php endfor; ?>
        <?php endif; ?>
    </div>
</div>

<?php if ($topBanner !== ''): ?>
    <div class="home-top-banner">
        <img src="<?= e(url_to($topBanner)) ?>" alt="" loading="eager" decoding="async" fetchpriority="high">
    </div>
<?php else: ?>
    <div class="hero-banner"<?= $heroStyle ?>>
        <div class="hero-content">
            <h1><?= e(content_get('home.hero_title')) ?></h1>
            <a href="tel:+<?= e($wa) ?>" class="btn"><?= e(content_get('home.hero_button')) ?></a>
        </div>
        <div class="hero-cta-bar">
            <span class="contact-no">CONTACT NO. <?= e($phonePrimary) ?></span>
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
            <a href="tel:+<?= e($wa) ?>" class="btn">Request a Call</a>
        </div>
        <div>
            <?php if ($aboutImg !== ''): ?>
                <div class="about-image">
                    <img src="<?= e(url_to($aboutImg)) ?>" alt="<?= e(content_get('home.about_caption')) ?>" loading="lazy" decoding="async">
                </div>
            <?php else: ?>
                <div class="about-image placeholder" aria-hidden="true">🏅</div>
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
            <a class="btn" href="tel:+<?= e($wa) ?>">Call Now</a>
            <a class="btn btn-whatsapp" href="https://wa.me/<?= e($wa) ?>" rel="noopener">
                <i class="fab fa-whatsapp" aria-hidden="true"></i>
                WhatsApp
            </a>
        </div>
        <div class="hindi-banner-phone">+91-<?= e($phonePrimary) ?></div>
    </div>
</div>

<section>
    <div class="section-title">
        <p class="section-subtitle">Come with</p>
        <h2>Astrologer Services</h2>
    </div>
    <div class="services-grid">
        <?php if (empty($services)): ?>
            <div class="service-card">
                <div class="offer-tag">offer</div>
                <div class="icon" aria-hidden="true">✋</div>
                <h3>Palmistry</h3>
                <p>Manage these cards from the admin panel.</p>
                <a href="<?= e(base_url()) ?>/admin/" class="btn">Open Admin</a>
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
                <a href="tel:+<?= e($wa) ?>" class="btn">Call Now</a>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="section-title">
        <p class="section-subtitle">latest</p>
        <h2>Our Product</h2>
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
    ['quote' => 'Guruji gives enough time to explain and guide us clearly. We felt positive changes soon.', 'author' => 'Neha Sharma', 'role' => 'Customer'],
    ['quote' => 'Accurate predictions and practical remedies. Very humble and patient.', 'author' => 'Rohit Verma', 'role' => 'Customer'],
    ['quote' => 'Our family issues improved after consultation. Highly recommended.', 'author' => 'Pooja Singh', 'role' => 'Customer'],
    ['quote' => 'Clear guidance for career and education. Very satisfied with the advice.', 'author' => 'Amit Patel', 'role' => 'Customer'],
    ['quote' => 'Detailed explanation and honest suggestions. Helped me a lot.', 'author' => 'Kavita Mishra', 'role' => 'Customer'],
    ['quote' => 'Great experience. The remedies were simple and effective.', 'author' => 'Sandeep Yadav', 'role' => 'Customer'],
    ['quote' => 'Very knowledgeable and kind. Gave time to understand the problem.', 'author' => 'Rina Gupta', 'role' => 'Customer'],
    ['quote' => 'Professional and reliable. We got the right direction.', 'author' => 'Vikram Chauhan', 'role' => 'Customer'],
];
?>

<section class="testimonials-section testimonials-light">
    <div class="section-title">
        <p class="section-subtitle">Some Words</p>
        <h2>Testimonial</h2>
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
        <p class="section-subtitle">latest</p>
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
        <p class="section-subtitle">latest</p>
        <h2>Awards</h2>
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
                <div class="award-info"><h3>Awarded with gold medal</h3></div>
            </div>
        <?php endif; ?>
    </div>
    <p style="text-align: center; margin-top: 35px;">
        <a href="tel:+<?= e($wa) ?>" class="btn" style="padding: 16px 45px; font-size: 18px;">GET ADVICE</a>
    </p>
</section>

