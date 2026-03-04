<?php
declare(strict_types=1);

$wa = content_get('site.whatsapp_number');
$phonePrimary = content_get('site.phone_primary');
$err = flash_get('contact_error');
$ok = flash_get('contact_success');
?>

<section class="page-hero">
    <h1><?= e(content_get('contact.page_title', 'Contact Us')) ?></h1>
    <p><?= e(content_get('contact.page_subtitle', 'Get in touch for astrological consultation and guidance')) ?></p>
</section>

<div class="help-strip">
    <div class="help-strip-inner">
        <div class="help-strip-title"><?= e(content_get('contact.help_title', 'Need Any Help?')) ?></div>
        <div class="help-strip-text"><?= e(content_get('home.help_text')) ?></div>
        <div class="help-strip-actions">
            <a href="tel:+<?= e($wa) ?>">+91-<?= e($phonePrimary) ?></a>
            <a href="https://wa.me/<?= e($wa) ?>" rel="noopener"><?= e(content_get('contact.help_whatsapp_label', 'Chat on WhatsApp')) ?></a>
        </div>
    </div>
</div>

<section>
    <div class="section-title">
        <h2><?= e(content_get('contact.section_title', 'Get In Touch')) ?></h2>
        <p class="subtitle"><?= e(content_get('contact.section_subtitle', 'We are here to help you')) ?></p>
    </div>

    <?php if ($err !== ''): ?>
        <div class="alert alert-error"><?= e($err) ?></div>
    <?php endif; ?>
    <?php if ($ok !== ''): ?>
        <div class="alert alert-success"><?= e($ok) ?></div>
    <?php endif; ?>

    <div class="contact-quick">
        <div class="contact-quick-card">
            <div class="contact-quick-title"><?= e(content_get('contact.quick_call_title', 'Call Now')) ?></div>
            <a href="tel:+<?= e($wa) ?>" class="contact-quick-value">+91-<?= e($phonePrimary) ?></a>
        </div>
        <div class="contact-quick-card">
            <div class="contact-quick-title"><?= e(content_get('contact.quick_whatsapp_title', 'WhatsApp')) ?></div>
            <a href="https://wa.me/<?= e($wa) ?>" class="contact-quick-value" rel="noopener"><?= e(content_get('contact.quick_whatsapp_label', 'Chat on WhatsApp')) ?></a>
        </div>
        <div class="contact-quick-card">
            <div class="contact-quick-title"><?= e(content_get('contact.quick_email_title', 'Email')) ?></div>
            <a href="mailto:<?= e(content_get('site.email')) ?>" class="contact-quick-value"><?= e(content_get('site.email')) ?></a>
        </div>
    </div>

    <div class="contact-wrapper">
        <div>
            <div class="contact-info-card">
                <h3><?= e(content_get('contact.info_title', 'Contact Information')) ?></h3>
                <div class="contact-item">
                    <div class="contact-item-icon" aria-hidden="true">📍</div>
                    <div>
                        <h4><?= e(content_get('contact.label_address', 'Address')) ?></h4>
                        <p><?= e(content_get('site.address')) ?></p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-item-icon" aria-hidden="true">☎</div>
                    <div>
                        <h4><?= e(content_get('contact.label_phone', 'Phone')) ?></h4>
                        <a href="tel:+<?= e($wa) ?>" class="contact-strong">+91-<?= e($phonePrimary) ?></a>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-item-icon" aria-hidden="true">✉</div>
                    <div>
                        <h4><?= e(content_get('contact.label_email', 'Email')) ?></h4>
                        <a href="mailto:<?= e(content_get('site.email')) ?>"><?= e(content_get('site.email')) ?></a>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-item-icon" aria-hidden="true">🌐</div>
                    <div>
                        <h4><?= e(content_get('contact.label_website', 'Website')) ?></h4>
                        <a href="<?= e(base_url()) ?>/"><?= e(content_get('site.website')) ?></a>
                    </div>
                </div>
            </div>

            <div class="contact-highlight">
                <div class="consultation-hours">
                    <p><strong><?= e(content_get('contact.hours_label', 'Consultation Hours:')) ?></strong> <?= e(content_get('contact.hours', '5:00 PM to 10:00 PM')) ?></p>
                    <p style="margin-top: 10px;"><?= e(content_get('contact.dakshina_note', 'After giving Dakshina voluntarily, you will be provided with Astrological Consultation.')) ?></p>
                    <p style="margin-top: 10px;"><strong><?= e(content_get('contact.gpay_label', 'Google Pay:')) ?></strong> <?= e(content_get('contact.gpay', $phonePrimary)) ?></p>
                </div>
            </div>
        </div>

        <div class="contact-form">
            <h3><?= e(content_get('contact.form_title', 'Send us a Message')) ?></h3>
            <form action="<?= e(base_url()) ?>/contact" method="post" autocomplete="on">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="name"><?= e(content_get('contact.form_name_label', 'Your Name *')) ?></label>
                    <input type="text" id="name" name="name" required maxlength="80" placeholder="<?= e(content_get('contact.form_name_ph', 'Enter your name')) ?>">
                </div>
                <div class="form-group">
                    <label for="phone"><?= e(content_get('contact.form_phone_label', 'Phone Number *')) ?></label>
                    <input type="tel" id="phone" name="phone" required maxlength="30" placeholder="<?= e(content_get('contact.form_phone_ph', 'Enter your phone')) ?>">
                </div>
                <div class="form-group">
                    <label for="email"><?= e(content_get('contact.form_email_label', 'Email')) ?></label>
                    <input type="email" id="email" name="email" maxlength="120" placeholder="<?= e(content_get('contact.form_email_ph', 'Enter your email')) ?>">
                </div>
                <div class="form-group">
                    <label for="subject"><?= e(content_get('contact.form_subject_label', 'Subject')) ?></label>
                    <input type="text" id="subject" name="subject" maxlength="120" placeholder="<?= e(content_get('contact.form_subject_ph', 'e.g. Palmistry, Marriage, etc.')) ?>">
                </div>
                <div class="form-group">
                    <label for="message"><?= e(content_get('contact.form_message_label', 'Your Message *')) ?></label>
                    <textarea id="message" name="message" required maxlength="2000" placeholder="<?= e(content_get('contact.form_message_ph', 'Describe your concern or query...')) ?>"></textarea>
                </div>
                <button type="submit" class="btn" style="width: 100%;"><?= e(content_get('contact.form_submit', 'Send Message')) ?></button>
            </form>
        </div>
    </div>
</section>

<section class="contact-urgent">
    <div class="contact-urgent-inner">
        <h2><?= e(content_get('contact.urgent_title', 'Need Immediate Help?')) ?></h2>
        <p><?= e(content_get('contact.urgent_subtitle', 'Call now for free astrological advice')) ?></p>
        <div class="contact-buttons">
            <a href="tel:+<?= e($wa) ?>" class="btn"><span aria-hidden="true">☎</span> +91-<?= e($phonePrimary) ?></a>
            <a href="https://wa.me/<?= e($wa) ?>" class="btn btn-outline" rel="noopener"><span aria-hidden="true">WA</span> <?= e(content_get('contact.urgent_whatsapp_label', 'WhatsApp')) ?></a>
        </div>
    </div>
</section>

