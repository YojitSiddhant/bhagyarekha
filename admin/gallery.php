<?php
declare(strict_types=1);

require_once __DIR__ . '/_init.php';
admin_require_login();

if (!db_table_exists('gallery_categories') || !db_table_exists('gallery_items')) {
    admin_layout_start('Gallery', 'gallery');
    echo '<div class="alert err">Tables `gallery_categories` / `gallery_items` not found. Import database first.</div>';
    admin_layout_end();
    exit;
}

$saved = ($_GET['saved'] ?? '') === '1';
$error = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    csrf_verify();
    $action = (string) ($_POST['action'] ?? '');

    if ($action === 'cat_save') {
        $id = (int) ($_POST['id'] ?? 0);
        $name = trim((string) ($_POST['name'] ?? ''));
        $slug = trim((string) ($_POST['slug'] ?? ''));
        $sort = (int) ($_POST['sort_order'] ?? 0);
        if ($name === '' || $slug === '') {
            $error = 'Category name and slug are required.';
        } else {
            if ($id > 0) {
                db()->prepare('UPDATE gallery_categories SET name=?, slug=?, sort_order=? WHERE id=?')
                    ->execute([$name, $slug, $sort, $id]);
            } else {
                db()->prepare('INSERT INTO gallery_categories (name, slug, sort_order) VALUES (?, ?, ?)')
                    ->execute([$name, $slug, $sort]);
            }
            redirect(admin_base() . '/gallery.php?saved=1');
        }
    }

    if ($action === 'cat_delete') {
        $id = (int) ($_POST['id'] ?? 0);
        db()->prepare('DELETE FROM gallery_categories WHERE id = ?')->execute([$id]);
        redirect(admin_base() . '/gallery.php?saved=1');
    }

    if ($action === 'item_save') {
        $id = (int) ($_POST['id'] ?? 0);
        $title = trim((string) ($_POST['title'] ?? ''));
        $categoryId = (int) ($_POST['category_id'] ?? 0);
        $iconText = trim((string) ($_POST['icon_text'] ?? '🖼'));
        $sort = (int) ($_POST['sort_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        $imagePath = trim((string) ($_POST['image_path'] ?? ''));

        if ($title === '') {
            $error = 'Item title is required.';
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
            $catVal = $categoryId > 0 ? $categoryId : null;
            if ($id > 0) {
                db()->prepare(
                    'UPDATE gallery_items
                     SET category_id=?, title=?, image_path=?, icon_text=?, sort_order=?, is_active=?
                     WHERE id=?'
                )->execute([$catVal, $title, $imagePath, $iconText, $sort, $isActive, $id]);
            } else {
                db()->prepare(
                    'INSERT INTO gallery_items (category_id, title, image_path, icon_text, sort_order, is_active, created_at)
                     VALUES (?, ?, ?, ?, ?, ?, NOW())'
                )->execute([$catVal, $title, $imagePath, $iconText, $sort, $isActive]);
            }
            redirect(admin_base() . '/gallery.php?saved=1');
        }
    }

    if ($action === 'item_delete') {
        $id = (int) ($_POST['id'] ?? 0);
        db()->prepare('DELETE FROM gallery_items WHERE id = ?')->execute([$id]);
        redirect(admin_base() . '/gallery.php?saved=1');
    }
}

$categories = db()->query('SELECT * FROM gallery_categories ORDER BY sort_order ASC, id ASC')->fetchAll();
$items = db()->query(
    'SELECT gi.*, gc.name AS category_name
     FROM gallery_items gi
     LEFT JOIN gallery_categories gc ON gc.id = gi.category_id
     ORDER BY gi.sort_order ASC, gi.id ASC'
)->fetchAll();

admin_layout_start('Gallery', 'gallery');
?>

<div class="card">
    <h2 style="margin:0 0 10px;">Gallery</h2>
    <div class="muted">Manage gallery categories and images. You can upload an image per item.</div>
    <?php if ($saved): ?><div class="alert ok">Saved.</div><?php endif; ?>
    <?php if ($error !== ''): ?><div class="alert err"><?= e($error) ?></div><?php endif; ?>
</div>

<div class="grid">
    <div class="card">
        <h3 style="margin:0 0 10px;">Add category</h3>
        <form method="post" action="<?= e(admin_base()) ?>/gallery.php">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="cat_save">
            <input type="hidden" name="id" value="0">
            <label>Name</label>
            <input name="name" type="text" required>
            <label>Slug</label>
            <input name="slug" type="text" placeholder="awards" required>
            <label>Sort order</label>
            <input name="sort_order" type="text" value="0">
            <div style="margin-top: 12px;">
                <button class="btn primary" type="submit">Save category</button>
            </div>
        </form>
    </div>

    <div class="card">
        <h3 style="margin:0 0 10px;">Add item</h3>
        <form method="post" enctype="multipart/form-data" action="<?= e(admin_base()) ?>/gallery.php">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="item_save">
            <input type="hidden" name="id" value="0">
            <label>Title</label>
            <input name="title" type="text" required>
            <label>Category</label>
            <select name="category_id">
                <option value="0">None</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= (int) $c['id'] ?>"><?= e((string) $c['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="grid">
                <div>
                    <label>Icon (if no image)</label>
                    <input name="icon_text" type="text" value="🖼" maxlength="8">
                </div>
                <div>
                    <label>Sort order</label>
                    <input name="sort_order" type="text" value="0">
                </div>
            </div>
            <label>Upload image (optional)</label>
            <input name="image" type="file" accept="image/png,image/jpeg,image/webp">
            <label>
                <input type="checkbox" name="is_active" value="1" checked>
                Active
            </label>
            <div style="margin-top: 12px;">
                <button class="btn primary" type="submit">Save item</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <h3 style="margin:0 0 12px;">Categories</h3>
    <table>
        <thead>
            <tr>
                <th style="width:6%;">ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th style="width:10%;">Sort</th>
                <th style="width:14%;">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $c): ?>
            <tr>
                <td><?= (int) $c['id'] ?></td>
                <td><?= e((string) $c['name']) ?></td>
                <td><code><?= e((string) $c['slug']) ?></code></td>
                <td><?= (int) $c['sort_order'] ?></td>
                <td>
                    <form method="post" action="<?= e(admin_base()) ?>/gallery.php" style="display:inline;">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="cat_delete">
                        <input type="hidden" name="id" value="<?= (int) $c['id'] ?>">
                        <button class="btn bad" type="submit" onclick="return confirm('Delete this category?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="card">
    <h3 style="margin:0 0 12px;">Items</h3>
    <table>
        <thead>
            <tr>
                <th style="width:6%;">ID</th>
                <th style="width:22%;">Preview</th>
                <th>Title</th>
                <th style="width:16%;">Category</th>
                <th style="width:8%;">Active</th>
                <th style="width:14%;">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $it): ?>
            <?php $img = (string) ($it['image_path'] ?? ''); ?>
            <tr>
                <td><?= (int) $it['id'] ?></td>
                <td>
                    <?php if ($img !== ''): ?>
                        <img src="<?= e(uploads_web_path($img)) ?>" alt="" style="width: 160px; height: 90px; object-fit: cover; border-radius: 12px; border:1px solid rgba(255,255,255,0.15);">
                    <?php else: ?>
                        <div class="muted" style="font-size: 28px;"><?= e((string) ($it['icon_text'] ?? '🖼')) ?></div>
                    <?php endif; ?>
                    <?php if ($img !== ''): ?><div class="muted" style="font-size: 12px; margin-top: 6px;"><code><?= e($img) ?></code></div><?php endif; ?>
                </td>
                <td><?= e((string) $it['title']) ?></td>
                <td class="muted"><?= e((string) ($it['category_name'] ?? '')) ?></td>
                <td><?= ((int) $it['is_active'] === 1) ? 'Yes' : 'No' ?></td>
                <td>
                    <form method="post" action="<?= e(admin_base()) ?>/gallery.php" style="display:inline;">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="item_delete">
                        <input type="hidden" name="id" value="<?= (int) $it['id'] ?>">
                        <button class="btn bad" type="submit" onclick="return confirm('Delete this item?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="muted" style="margin-top: 10px;">Edit for gallery items can be added next; for now you can delete and re-add with the correct values.</div>
</div>

<?php admin_layout_end(); ?>

