<?php
declare(strict_types=1);

require_once __DIR__ . '/_init.php';
admin_require_login();

if (!db_table_exists('services')) {
    admin_layout_start('Services', 'services');
    echo '<div class="alert err">Table `services` not found. Import database first.</div>';
    admin_layout_end();
    exit;
}

$error = '';
$saved = ($_GET['saved'] ?? '') === '1';
$editId = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
$editing = null;

if ($editId > 0) {
    $st = db()->prepare('SELECT * FROM services WHERE id = ? LIMIT 1');
    $st->execute([$editId]);
    $editing = $st->fetch() ?: null;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    csrf_verify();
    $action = (string) ($_POST['action'] ?? '');

    if ($action === 'delete') {
        $id = (int) ($_POST['id'] ?? 0);
        $st = db()->prepare('DELETE FROM services WHERE id = ?');
        $st->execute([$id]);
        redirect(admin_base() . '/services.php?saved=1');
    }

    if ($action === 'save') {
        $id = (int) ($_POST['id'] ?? 0);
        $title = trim((string) ($_POST['title'] ?? ''));
        $description = trim((string) ($_POST['description'] ?? ''));
        $imagePath = trim((string) ($_POST['image_path'] ?? ''));
        $offerTag = trim((string) ($_POST['offer_tag'] ?? 'offer 1'));
        $iconText = trim((string) ($_POST['icon_text'] ?? '✦'));
        $ctaText = trim((string) ($_POST['cta_text'] ?? 'Call Now Get Free Advice'));
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
                $st = db()->prepare(
                    'UPDATE services
                     SET title=?, description=?, image_path=?, offer_tag=?, icon_text=?, cta_text=?, sort_order=?, is_active=?
                     WHERE id=?'
                );
                $st->execute([$title, $description, $imagePath, $offerTag, $iconText, $ctaText, $sortOrder, $isActive, $id]);
            } else {
                $st = db()->prepare(
                    'INSERT INTO services (title, description, image_path, offer_tag, icon_text, cta_text, sort_order, is_active, created_at)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())'
                );
                $st->execute([$title, $description, $imagePath, $offerTag, $iconText, $ctaText, $sortOrder, $isActive]);
            }
            redirect(admin_base() . '/services.php?saved=1');
        }
    }
}

$rows = db()->query('SELECT * FROM services ORDER BY sort_order ASC, id ASC')->fetchAll();

admin_layout_start('Services', 'services');
?>

<div class="card">
    <h2 style="margin:0 0 10px;">Services</h2>
    <div class="muted">These cards appear on Home and Services pages.</div>
    <?php if ($saved): ?>
        <div class="alert ok">Saved.</div>
    <?php endif; ?>
    <?php if ($error !== ''): ?>
        <div class="alert err"><?= e($error) ?></div>
    <?php endif; ?>
</div>

<div class="card">
    <h3 style="margin:0 0 10px;"><?= $editing ? 'Edit service' : 'Add service' ?></h3>
    <form method="post" enctype="multipart/form-data" action="<?= e(admin_base()) ?>/services.php">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="save">
        <input type="hidden" name="id" value="<?= e((string) ($editing['id'] ?? 0)) ?>">

        <div class="grid">
            <div>
                <label for="title">Title</label>
                <input id="title" name="title" type="text" value="<?= e((string) ($editing['title'] ?? '')) ?>" required>
            </div>
            <div>
                <label for="offer_tag">Offer tag</label>
                <input id="offer_tag" name="offer_tag" type="text" value="<?= e((string) ($editing['offer_tag'] ?? 'offer 1')) ?>">
            </div>
        </div>

        <label for="description">Description</label>
        <textarea id="description" name="description"><?= e((string) ($editing['description'] ?? '')) ?></textarea>

        <label for="image_path">Image path (optional)</label>
        <input id="image_path" name="image_path" type="text" value="<?= e((string) ($editing['image_path'] ?? '')) ?>" placeholder="uploads/2026-02/xxxx.webp">
        <label for="image">Upload image (optional)</label>
        <input id="image" name="image" type="file" accept="image/png,image/jpeg,image/webp">

        <div class="grid">
            <div>
                <label for="icon_text">Icon (single char/emoji)</label>
                <input id="icon_text" name="icon_text" type="text" value="<?= e((string) ($editing['icon_text'] ?? '✦')) ?>" maxlength="8">
            </div>
            <div>
                <label for="cta_text">Button text</label>
                <input id="cta_text" name="cta_text" type="text" value="<?= e((string) ($editing['cta_text'] ?? 'Call Now Get Free Advice')) ?>">
            </div>
        </div>

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
            <?php if ($editing): ?>
                <a class="btn" href="<?= e(admin_base()) ?>/services.php">Cancel</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <h3 style="margin:0 0 12px;">All services</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 8%;">ID</th>
                <th style="width: 20%;">Title</th>
                <th>Description</th>
                <th style="width: 10%;">Active</th>
                <th style="width: 18%;">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $r): ?>
            <tr>
                <td><?= (int) $r['id'] ?></td>
                <td><?= e((string) $r['title']) ?></td>
                <td class="muted"><?= e((string) $r['description']) ?></td>
                <td><?= ((int) $r['is_active'] === 1) ? 'Yes' : 'No' ?></td>
                <td>
                    <div class="row-actions">
                        <a class="btn" href="<?= e(admin_base()) ?>/services.php?edit=<?= (int) $r['id'] ?>">Edit</a>
                        <form method="post" action="<?= e(admin_base()) ?>/services.php" style="display:inline;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                            <button class="btn bad" type="submit" onclick="return confirm('Delete this service?')">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php admin_layout_end(); ?>

