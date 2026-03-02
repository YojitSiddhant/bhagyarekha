<?php
declare(strict_types=1);

require_once __DIR__ . '/_init.php';
admin_require_login();

if (!db_table_exists('seo_meta')) {
    admin_layout_start('SEO', 'seo');
    echo '<div class="alert err">Table `seo_meta` not found. Import database first.</div>';
    admin_layout_end();
    exit;
}

$pages = ['home', 'about', 'services', 'gallery', 'contact'];
$saved = ($_GET['saved'] ?? '') === '1';
$error = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    csrf_verify();

    $slug = (string) ($_POST['page_slug'] ?? '');
    if (!in_array($slug, $pages, true)) {
        $error = 'Invalid page.';
    } else {
        $fields = [
            'title', 'description', 'keywords', 'canonical_url', 'robots',
            'og_title', 'og_description', 'og_image', 'og_type', 'og_url',
            'twitter_card', 'twitter_title', 'twitter_description', 'twitter_image',
        ];

        $data = ['page_slug' => $slug];
        foreach ($fields as $f) {
            $data[$f] = trim((string) ($_POST[$f] ?? ''));
        }

        $stmt = db()->prepare(
            'INSERT INTO seo_meta
                (page_slug, title, description, keywords, canonical_url, robots,
                 og_title, og_description, og_image, og_type, og_url,
                 twitter_card, twitter_title, twitter_description, twitter_image, updated_at)
             VALUES
                (:page_slug, :title, :description, :keywords, :canonical_url, :robots,
                 :og_title, :og_description, :og_image, :og_type, :og_url,
                 :twitter_card, :twitter_title, :twitter_description, :twitter_image, NOW())
             ON DUPLICATE KEY UPDATE
                title=VALUES(title),
                description=VALUES(description),
                keywords=VALUES(keywords),
                canonical_url=VALUES(canonical_url),
                robots=VALUES(robots),
                og_title=VALUES(og_title),
                og_description=VALUES(og_description),
                og_image=VALUES(og_image),
                og_type=VALUES(og_type),
                og_url=VALUES(og_url),
                twitter_card=VALUES(twitter_card),
                twitter_title=VALUES(twitter_title),
                twitter_description=VALUES(twitter_description),
                twitter_image=VALUES(twitter_image),
                updated_at=NOW()'
        );
        $stmt->execute($data);

        redirect(admin_base() . '/seo.php?page=' . urlencode($slug) . '&saved=1');
    }
}

$active = $_GET['page'] ?? 'home';
if (!is_string($active) || !in_array($active, $pages, true)) {
    $active = 'home';
}

$stmt = db()->prepare('SELECT * FROM seo_meta WHERE page_slug = ? LIMIT 1');
$stmt->execute([$active]);
$current = $stmt->fetch() ?: [];

admin_layout_start('SEO', 'seo');
?>

<div class="card">
    <h2 style="margin:0 0 10px;">SEO Meta + OG Tags</h2>
    <div class="muted">Manage per-page meta tags for Lighthouse + social sharing.</div>
    <?php if ($saved): ?>
        <div class="alert ok">Saved.</div>
    <?php endif; ?>
    <?php if ($error !== ''): ?>
        <div class="alert err"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= e(admin_base()) ?>/seo.php">
        <?= csrf_field() ?>

        <label for="page_slug">Page</label>
        <select id="page_slug" name="page_slug" onchange="location.href='<?= e(admin_base()) ?>/seo.php?page='+this.value">
            <?php foreach ($pages as $p): ?>
                <option value="<?= e($p) ?>" <?= $active === $p ? 'selected' : '' ?>><?= e($p) ?></option>
            <?php endforeach; ?>
        </select>

        <div class="grid">
            <div>
                <label for="title">Title</label>
                <input id="title" name="title" type="text" value="<?= e((string) ($current['title'] ?? '')) ?>" maxlength="200">
            </div>
            <div>
                <label for="canonical_url">Canonical URL</label>
                <input id="canonical_url" name="canonical_url" type="text" value="<?= e((string) ($current['canonical_url'] ?? '')) ?>" maxlength="255">
            </div>
        </div>

        <label for="description">Description</label>
        <textarea id="description" name="description" maxlength="500"><?= e((string) ($current['description'] ?? '')) ?></textarea>

        <div class="grid">
            <div>
                <label for="keywords">Keywords</label>
                <input id="keywords" name="keywords" type="text" value="<?= e((string) ($current['keywords'] ?? '')) ?>" maxlength="500">
            </div>
            <div>
                <label for="robots">Robots</label>
                <input id="robots" name="robots" type="text" value="<?= e((string) ($current['robots'] ?? 'index,follow')) ?>" maxlength="60">
            </div>
        </div>

        <div class="card">
            <h3 style="margin:0 0 10px;">OpenGraph</h3>
            <div class="grid">
                <div>
                    <label for="og_title">OG Title</label>
                    <input id="og_title" name="og_title" type="text" value="<?= e((string) ($current['og_title'] ?? '')) ?>" maxlength="200">
                </div>
                <div>
                    <label for="og_type">OG Type</label>
                    <input id="og_type" name="og_type" type="text" value="<?= e((string) ($current['og_type'] ?? 'website')) ?>" maxlength="50">
                </div>
            </div>
            <label for="og_description">OG Description</label>
            <textarea id="og_description" name="og_description" maxlength="500"><?= e((string) ($current['og_description'] ?? '')) ?></textarea>
            <div class="grid">
                <div>
                    <label for="og_url">OG URL</label>
                    <input id="og_url" name="og_url" type="text" value="<?= e((string) ($current['og_url'] ?? '')) ?>" maxlength="255">
                </div>
                <div>
                    <label for="og_image">OG Image URL</label>
                    <input id="og_image" name="og_image" type="text" value="<?= e((string) ($current['og_image'] ?? '')) ?>" maxlength="255">
                </div>
            </div>
        </div>

        <div class="card">
            <h3 style="margin:0 0 10px;">Twitter</h3>
            <div class="grid">
                <div>
                    <label for="twitter_card">Twitter Card</label>
                    <input id="twitter_card" name="twitter_card" type="text" value="<?= e((string) ($current['twitter_card'] ?? 'summary_large_image')) ?>" maxlength="50">
                </div>
                <div>
                    <label for="twitter_image">Twitter Image URL</label>
                    <input id="twitter_image" name="twitter_image" type="text" value="<?= e((string) ($current['twitter_image'] ?? '')) ?>" maxlength="255">
                </div>
            </div>
            <div class="grid">
                <div>
                    <label for="twitter_title">Twitter Title</label>
                    <input id="twitter_title" name="twitter_title" type="text" value="<?= e((string) ($current['twitter_title'] ?? '')) ?>" maxlength="200">
                </div>
                <div>
                    <label for="twitter_description">Twitter Description</label>
                    <textarea id="twitter_description" name="twitter_description" maxlength="500"><?= e((string) ($current['twitter_description'] ?? '')) ?></textarea>
                </div>
            </div>
        </div>

        <div style="margin-top: 12px;">
            <button class="btn primary" type="submit">Save SEO</button>
        </div>
    </form>
</div>

<?php admin_layout_end(); ?>

