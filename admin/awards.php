<?php
declare(strict_types=1);

require_once __DIR__ . '/_init.php';
admin_require_login();

if (!db_table_exists('awards')) {
    admin_layout_start('Awards', 'awards');
    echo '<div class="alert err">Table `awards` not found. Import database first.</div>';
    admin_layout_end();
    exit;
}

$error = '';
$saved = ($_GET['saved'] ?? '') === '1';
$editId = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
$editing = null;

if ($editId > 0) {
    $st = db()->prepare('SELECT * FROM awards WHERE id = ? LIMIT 1');
    $st->execute([$editId]);
    $editing = $st->fetch() ?: null;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    csrf_verify();
    $action = (string) ($_POST['action'] ?? '');

    if ($action === 'delete') {
        $id = (int) ($_POST['id'] ?? 0);
        db()->prepare('DELETE FROM awards WHERE id = ?')->execute([$id]);
        redirect(admin_base() . '/awards.php?saved=1');
    }

    if ($action === 'save') {
        $id = (int) ($_POST['id'] ?? 0);
        $title = trim((string) ($_POST['title'] ?? ''));
        $imagePath = trim((string) ($_POST['image_path'] ?? ''));
        $iconText = trim((string) ($_POST['icon_text'] ?? '🏆'));
        $sortOrder = (int) ($_POST['sort_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if ($title === '') {
            $error = 'Title is required.';
        } else {
            if (!empty($_FILES['image']['name'] ?? '')) {
                $up = store_uploaded_image('image');
                if (!($up['ok'] ?? false)) {
                    $error = (string) ($up['error'] ?? 'Upload failed');
                } else {
                    $imagePath = (string) ($up['file_path'] ?? '');
                }
            }
        }

        if ($error === '') {
            if ($id > 0) {
                db()->prepare('UPDATE awards SET title=?, image_path=?, icon_text=?, sort_order=?, is_active=? WHERE id=?')
                    ->execute([$title, $imagePath, $iconText, $sortOrder, $isActive, $id]);
            } else {
                db()->prepare(
                    'INSERT INTO awards (title, image_path, icon_text, sort_order, is_active, created_at)
                     VALUES (?, ?, ?, ?, ?, NOW())'
                )->execute([$title, $imagePath, $iconText, $sortOrder, $isActive]);
            }
            redirect(admin_base() . '/awards.php?saved=1');
        }
    }
}

$rows = db()->query('SELECT * FROM awards ORDER BY sort_order ASC, id ASC')->fetchAll();

admin_layout_start('Awards', 'awards');
?>

<div class="card">
    <h2 style="margin:0 0 10px;">Awards</h2>
    <div class="muted">Shown on the Home page and About page.</div>
    <?php if ($saved): ?><div class="alert ok">Saved.</div><?php endif; ?>
    <?php if ($error !== ''): ?><div class="alert err"><?= e($error) ?></div><?php endif; ?>
</div>

<div class="card">
    <h3 style="margin:0 0 10px;"><?= $editing ? 'Edit award' : 'Add award' ?></h3>
    <form method="post" enctype="multipart/form-data" action="<?= e(admin_base()) ?>/awards.php">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="save">
        <input type="hidden" name="id" value="<?= e((string) ($editing['id'] ?? 0)) ?>">

        <div class="grid">
            <div>
                <label for="title">Title</label>
                <input id="title" name="title" type="text" value="<?= e((string) ($editing['title'] ?? '')) ?>" required>
            </div>
            <div>
                <label for="icon_text">Icon (single char/emoji)</label>
                <input id="icon_text" name="icon_text" type="text" value="<?= e((string) ($editing['icon_text'] ?? '🏆')) ?>" maxlength="8">
            </div>
        </div>

        <label for="image_path">Image path (optional)</label>
        <input id="image_path" name="image_path" type="text" value="<?= e((string) ($editing['image_path'] ?? '')) ?>" placeholder="uploads/2026-02/xxxx.webp">
        <label for="image">Upload image (optional)</label>
        <input id="image" name="image" type="file" accept="image/png,image/jpeg,image/webp">

        <div class="grid">
            <div>
                <label for="sort_order">Sort order</label>
                <input id="sort_order" name="sort_order" type="text" value="<?= e((string) ($editing['sort_order'] ?? 0)) ?>">
            </div>
            <div>
                <label>
                    <input type="checkbox" name="is_active" value="1" <?= ((int) ($editing['is_active'] ?? 1) === 1) ? 'checked' : '' ?>>
                    Active
                </label>
            </div>
        </div>

        <div style="margin-top: 12px;" class="row-actions">
            <button class="btn primary" type="submit">Save</button>
            <?php if ($editing): ?><a class="btn" href="<?= e(admin_base()) ?>/awards.php">Cancel</a><?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <h3 style="margin:0 0 12px;">All awards</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 6%;">ID</th>
                <th>Title</th>
                <th style="width: 10%;">Active</th>
                <th style="width: 18%;">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $r): ?>
            <tr>
                <td><?= (int) $r['id'] ?></td>
                <td><?= e((string) $r['title']) ?></td>
                <td><?= ((int) $r['is_active'] === 1) ? 'Yes' : 'No' ?></td>
                <td>
                    <div class="row-actions">
                        <a class="btn" href="<?= e(admin_base()) ?>/awards.php?edit=<?= (int) $r['id'] ?>">Edit</a>
                        <form method="post" action="<?= e(admin_base()) ?>/awards.php" style="display:inline;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                            <button class="btn bad" type="submit" onclick="return confirm('Delete this award?')">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php admin_layout_end(); ?>

