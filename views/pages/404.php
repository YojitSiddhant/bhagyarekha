<?php
declare(strict_types=1);
?>

<section class="page-hero">
    <h1><?= e(content_get('error.404_title', 'Page not found')) ?></h1>
    <p><?= e(content_get('error.404_subtitle', 'The page you requested does not exist.')) ?></p>
    <p style="margin-top: 18px;"><a class="btn" href="<?= e(base_url()) ?>/"><?= e(content_get('error.404_cta', 'Go to Home')) ?></a></p>
</section>

