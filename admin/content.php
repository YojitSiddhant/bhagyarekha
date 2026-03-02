<?php
declare(strict_types=1);

require_once __DIR__ . '/_init.php';
admin_require_login();

if (!db_table_exists('content')) {
    admin_layout_start('Content', 'content');
    echo '<div class="alert err">Table `content` not found. Import database first.</div>';
    admin_layout_end();
    exit;
}

$msg = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    csrf_verify();
    $key = trim((string) ($_POST['content_key'] ?? ''));
    $value = (string) ($_POST['content_value'] ?? '');

    if ($key === '' || strlen($key) > 191) {
        $msg = 'Invalid key.';
    } else {
        $stmt = db()->prepare(
            'INSERT INTO content (content_key, content_value, updated_at)
             VALUES (?, ?, NOW())
             ON DUPLICATE KEY UPDATE content_value = VALUES(content_value), updated_at = NOW()'
        );
        $stmt->execute([$key, $value]);
        redirect(admin_base() . '/content.php?saved=1');
    }
}

$saved = ($_GET['saved'] ?? '') === '1';
$rows = db()->query('SELECT content_key, content_value, updated_at FROM content ORDER BY content_key ASC')->fetchAll();

admin_layout_start('Content', 'content');
?>

<div class="card">
    <h2 style="margin:0 0 10px;">Content (Key/Value)</h2>
    <div class="muted">All editable texts used on the frontend. Use dotted keys like `home.hero_title`.</div>

    <?php if ($saved): ?>
        <div class="alert ok">Saved.</div>
    <?php endif; ?>
    <?php if ($msg !== ''): ?>
        <div class="alert err"><?= e($msg) ?></div>
    <?php endif; ?>

    <form method="post" class="card" action="<?= e(admin_base()) ?>/content.php">
        <?= csrf_field() ?>
        <div class="grid">
            <div>
                <label for="content_key">Key</label>
                <input id="content_key" name="content_key" type="text" placeholder="e.g. home.hero_title" required maxlength="191">
            </div>
            <div>
                <label for="content_value">Value</label>
                <textarea id="content_value" name="content_value" placeholder="Text shown on the website"></textarea>
            </div>
        </div>
        <div style="margin-top: 12px;">
            <button class="btn primary" type="submit">Save</button>
        </div>
    </form>
</div>

<div class="card">
    <h3 style="margin:0 0 12px;">Existing keys</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 28%;">Key</th>
                <th>Value</th>
                <th style="width: 18%;">Updated</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $r): ?>
            <tr>
                <td><code><?= e((string) $r['content_key']) ?></code></td>
                <td style="white-space: pre-wrap;"><?= e((string) $r['content_value']) ?></td>
                <td class="muted"><?= e((string) ($r['updated_at'] ?? '')) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php admin_layout_end(); ?>

