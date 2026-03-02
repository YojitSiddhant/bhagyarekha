<?php
declare(strict_types=1);

require_once __DIR__ . '/_init.php';
admin_require_login();

if (!db_table_exists('uploads')) {
    admin_layout_start('Media', 'media');
    echo '<div class="alert err">Table `uploads` not found. Import database first.</div>';
    admin_layout_end();
    exit;
}

$msg = '';
$err = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    csrf_verify();
    $action = (string) ($_POST['action'] ?? '');

    if ($action === 'upload') {
        $res = store_uploaded_image('image');
        if (!($res['ok'] ?? false)) {
            $err = (string) ($res['error'] ?? 'Upload failed');
        } else {
            $id = (int) ($res['upload_id'] ?? 0);
            $msg = 'Uploaded. ID: ' . $id;
        }
    }

    if ($action === 'delete') {
        $id = (int) ($_POST['id'] ?? 0);
        $st = db()->prepare('SELECT file_path FROM uploads WHERE id = ? LIMIT 1');
        $st->execute([$id]);
        $row = $st->fetch();
        if ($row) {
            $file = uploads_dir() . '/' . (string) $row['file_path'];
            if (is_file($file)) {
                @unlink($file);
            }
            $del = db()->prepare('DELETE FROM uploads WHERE id = ?');
            $del->execute([$id]);
            $msg = 'Deleted.';
        }
    }
}

$rows = db()->query('SELECT id, file_path, original_name, mime_type, file_size, created_at FROM uploads ORDER BY id DESC LIMIT 50')->fetchAll();

admin_layout_start('Media', 'media');
?>

<div class="card">
    <h2 style="margin:0 0 10px;">Media (Uploads)</h2>
    <div class="muted">Upload JPG/PNG/WebP. Use the `file_path` in Gallery items or SEO images.</div>
    <?php if ($msg !== ''): ?><div class="alert ok"><?= e($msg) ?></div><?php endif; ?>
    <?php if ($err !== ''): ?><div class="alert err"><?= e($err) ?></div><?php endif; ?>

    <form method="post" enctype="multipart/form-data" action="<?= e(admin_base()) ?>/media.php" style="margin-top: 10px;">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="upload">
        <label for="image">Select image</label>
        <input id="image" name="image" type="file" accept="image/png,image/jpeg,image/webp" required>
        <div style="margin-top: 12px;">
            <button class="btn primary" type="submit">Upload</button>
        </div>
    </form>
</div>

<div class="card">
    <h3 style="margin:0 0 12px;">Recent uploads</h3>
    <table>
        <thead>
            <tr>
                <th style="width:8%;">ID</th>
                <th style="width:22%;">Preview</th>
                <th>Path</th>
                <th style="width:18%;">Created</th>
                <th style="width:14%;">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $r): ?>
            <?php $path = (string) $r['file_path']; ?>
            <tr>
                <td><?= (int) $r['id'] ?></td>
                <td>
                    <img src="<?= e(uploads_web_path($path)) ?>" alt="" style="width: 160px; height: 90px; object-fit: cover; border-radius: 12px; border:1px solid rgba(255,255,255,0.15);">
                </td>
                <td>
                    <div><code><?= e($path) ?></code></div>
                    <div class="muted" style="margin-top:6px; font-size: 12px;"><?= e((string) ($r['original_name'] ?? '')) ?></div>
                </td>
                <td class="muted"><?= e((string) ($r['created_at'] ?? '')) ?></td>
                <td>
                    <form method="post" action="<?= e(admin_base()) ?>/media.php" onsubmit="return confirm('Delete this file?')">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                        <button class="btn bad" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php admin_layout_end(); ?>

