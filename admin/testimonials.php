<?php
declare(strict_types=1);

require_once __DIR__ . '/_init.php';
admin_require_login();

if (!db_table_exists('testimonials')) {
    admin_layout_start('Testimonials', 'testimonials');
    echo '<div class="alert err">Table `testimonials` not found. Import database first.</div>';
    admin_layout_end();
    exit;
}

$error = '';
$saved = ($_GET['saved'] ?? '') === '1';
$editId = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
$editing = null;

if ($editId > 0) {
    $st = db()->prepare('SELECT * FROM testimonials WHERE id = ? LIMIT 1');
    $st->execute([$editId]);
    $editing = $st->fetch() ?: null;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    csrf_verify();
    $action = (string) ($_POST['action'] ?? '');

    if ($action === 'delete') {
        $id = (int) ($_POST['id'] ?? 0);
        db()->prepare('DELETE FROM testimonials WHERE id = ?')->execute([$id]);
        redirect(admin_base() . '/testimonials.php?saved=1');
    }

    if ($action === 'save') {
        $id = (int) ($_POST['id'] ?? 0);
        $quote = trim((string) ($_POST['quote'] ?? ''));
        $author = trim((string) ($_POST['author'] ?? ''));
        $role = trim((string) ($_POST['role'] ?? 'Customer'));
        $sortOrder = (int) ($_POST['sort_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if ($quote === '') {
            $error = 'Quote is required.';
        } else {
            if ($id > 0) {
                db()->prepare('UPDATE testimonials SET quote=?, author=?, role=?, sort_order=?, is_active=? WHERE id=?')
                    ->execute([$quote, $author, $role, $sortOrder, $isActive, $id]);
            } else {
                db()->prepare(
                    'INSERT INTO testimonials (quote, author, role, sort_order, is_active, created_at)
                     VALUES (?, ?, ?, ?, ?, NOW())'
                )->execute([$quote, $author, $role, $sortOrder, $isActive]);
            }
            redirect(admin_base() . '/testimonials.php?saved=1');
        }
    }
}

$rows = db()->query('SELECT * FROM testimonials ORDER BY sort_order ASC, id ASC')->fetchAll();

admin_layout_start('Testimonials', 'testimonials');
?>

<div class="card">
    <h2 style="margin:0 0 10px;">Testimonials</h2>
    <div class="muted">Shown on the Home page.</div>
    <?php if ($saved): ?><div class="alert ok">Saved.</div><?php endif; ?>
    <?php if ($error !== ''): ?><div class="alert err"><?= e($error) ?></div><?php endif; ?>
</div>

<div class="card">
    <h3 style="margin:0 0 10px;"><?= $editing ? 'Edit testimonial' : 'Add testimonial' ?></h3>
    <form method="post" action="<?= e(admin_base()) ?>/testimonials.php">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="save">
        <input type="hidden" name="id" value="<?= e((string) ($editing['id'] ?? 0)) ?>">

        <label for="quote">Quote</label>
        <textarea id="quote" name="quote" required><?= e((string) ($editing['quote'] ?? '')) ?></textarea>

        <div class="grid">
            <div>
                <label for="author">Author</label>
                <input id="author" name="author" type="text" value="<?= e((string) ($editing['author'] ?? '')) ?>">
            </div>
            <div>
                <label for="role">Role</label>
                <input id="role" name="role" type="text" value="<?= e((string) ($editing['role'] ?? 'Customer')) ?>">
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
            <?php if ($editing): ?><a class="btn" href="<?= e(admin_base()) ?>/testimonials.php">Cancel</a><?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <h3 style="margin:0 0 12px;">All testimonials</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 6%;">ID</th>
                <th style="width: 18%;">Author</th>
                <th>Quote</th>
                <th style="width: 10%;">Active</th>
                <th style="width: 18%;">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $r): ?>
            <tr>
                <td><?= (int) $r['id'] ?></td>
                <td><?= e((string) $r['author']) ?></td>
                <td class="muted"><?= e((string) $r['quote']) ?></td>
                <td><?= ((int) $r['is_active'] === 1) ? 'Yes' : 'No' ?></td>
                <td>
                    <div class="row-actions">
                        <a class="btn" href="<?= e(admin_base()) ?>/testimonials.php?edit=<?= (int) $r['id'] ?>">Edit</a>
                        <form method="post" action="<?= e(admin_base()) ?>/testimonials.php" style="display:inline;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                            <button class="btn bad" type="submit" onclick="return confirm('Delete this testimonial?')">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php admin_layout_end(); ?>

