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
$err = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    csrf_verify();
    $action = (string) ($_POST['action'] ?? 'save');

    // bulk_save removed to keep UI simple (inline row editing only)

    if ($action === 'save') {
        $key = trim((string) ($_POST['content_key'] ?? ''));
        $value = (string) ($_POST['content_value'] ?? '');

        if ($key === '' || strlen($key) > 191) {
            $err = 'Invalid key.';
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

    if ($action === 'delete') {
        $key = trim((string) ($_POST['content_key'] ?? ''));
        if ($key === '') {
            $err = 'Invalid key.';
        } else {
            $stmt = db()->prepare('DELETE FROM content WHERE content_key = ?');
            $stmt->execute([$key]);
            redirect(admin_base() . '/content.php?deleted=1');
        }
    }

    if ($action === 'slider_save') {
        $value = (string) ($_POST['slider_images'] ?? '');
        $stmt = db()->prepare(
            'INSERT INTO content (content_key, content_value, updated_at)
             VALUES (?, ?, NOW())
             ON DUPLICATE KEY UPDATE content_value = VALUES(content_value), updated_at = NOW()'
        );
        $stmt->execute(['home.slider_images', $value]);
        redirect(admin_base() . '/content.php?slider_saved=1');
    }

    if ($action === 'slider_upload') {
        $res = store_uploaded_image('slider_image');
        if (!($res['ok'] ?? false)) {
            $err = (string) ($res['error'] ?? 'Upload failed');
        } else {
            $path = (string) ($res['file_path'] ?? '');
            $cur = content_get('home.slider_images', '');
            $lines = array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $cur ?: ''))));
            $lines[] = $path;
            $value = implode("\n", $lines);
            $stmt = db()->prepare(
                'INSERT INTO content (content_key, content_value, updated_at)
                 VALUES (?, ?, NOW())
                 ON DUPLICATE KEY UPDATE content_value = VALUES(content_value), updated_at = NOW()'
            );
            $stmt->execute(['home.slider_images', $value]);
            redirect(admin_base() . '/content.php?slider_saved=1');
        }
    }

    if ($action === 'slider_remove') {
        $idx = (int) ($_POST['index'] ?? -1);
        $cur = content_get('home.slider_images', '');
        $lines = array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $cur ?: ''))));
        if ($idx >= 0 && $idx < count($lines)) {
            array_splice($lines, $idx, 1);
            $value = implode("\n", $lines);
            $stmt = db()->prepare(
                'INSERT INTO content (content_key, content_value, updated_at)
                 VALUES (?, ?, NOW())
                 ON DUPLICATE KEY UPDATE content_value = VALUES(content_value), updated_at = NOW()'
            );
            $stmt->execute(['home.slider_images', $value]);
            redirect(admin_base() . '/content.php?slider_saved=1');
        }
    }
}

$saved = ($_GET['saved'] ?? '') === '1';
$deleted = ($_GET['deleted'] ?? '') === '1';
$sliderSaved = ($_GET['slider_saved'] ?? '') === '1';
$rows = db()->query('SELECT content_key, content_value, updated_at FROM content ORDER BY content_key ASC')->fetchAll();
$rowMap = [];
foreach ($rows as $r) {
    $k = (string) ($r['content_key'] ?? '');
    if ($k === '') {
        continue;
    }
    $rowMap[$k] = $r;
}

$keyMeta = [
    'Home Slider' => [
        ['key' => 'home.slider_pill', 'label' => 'Pill Text'],
        ['key' => 'home.slider_subtitle', 'label' => 'Subtitle Text'],
        ['key' => 'home.slider_primary_btn', 'label' => 'Primary Button'],
        ['key' => 'home.slider_secondary_btn', 'label' => 'Secondary Button'],
        ['key' => 'home.slider_meta_left', 'label' => 'Meta Left Text'],
        ['key' => 'home.slider_card_title', 'label' => 'Card Title'],
        ['key' => 'home.slider_card_subtitle', 'label' => 'Card Subtitle'],
        ['key' => 'home.slider_card_li_1', 'label' => 'Card Bullet 1'],
        ['key' => 'home.slider_card_li_2', 'label' => 'Card Bullet 2'],
        ['key' => 'home.slider_card_li_3', 'label' => 'Card Bullet 3'],
    ],
    'Home Sections' => [
        ['key' => 'home.about_title', 'label' => 'About Title'],
        ['key' => 'home.about_p1', 'label' => 'About Paragraph 1'],
        ['key' => 'home.about_p2', 'label' => 'About Paragraph 2'],
        ['key' => 'home.about_caption', 'label' => 'About Caption'],
        ['key' => 'home.about_cta', 'label' => 'About CTA'],
        ['key' => 'home.help_title', 'label' => 'Help Title'],
        ['key' => 'home.help_text', 'label' => 'Help Text'],
        ['key' => 'home.hindi_banner', 'label' => 'Hindi Banner Text'],
    ],
    'About Page' => [
        ['key' => 'about.page_title', 'label' => 'Page Title'],
        ['key' => 'about.help_title', 'label' => 'Help Title'],
        ['key' => 'about.highlight_title', 'label' => 'Highlight Title'],
        ['key' => 'about.call_cta', 'label' => 'Call CTA'],
        ['key' => 'about.awards_title', 'label' => 'Awards Title'],
        ['key' => 'about.awards_subtitle', 'label' => 'Awards Subtitle'],
        ['key' => 'about.awards_placeholder_title1', 'label' => 'Awards Placeholder 1'],
        ['key' => 'about.awards_placeholder_title2', 'label' => 'Awards Placeholder 2'],
    ],
    'Services Page' => [
        ['key' => 'services.page_title', 'label' => 'Page Title'],
        ['key' => 'services.page_subtitle', 'label' => 'Page Subtitle'],
        ['key' => 'services.highlight_1_title', 'label' => 'Highlight 1 Title'],
        ['key' => 'services.highlight_1_desc', 'label' => 'Highlight 1 Desc'],
        ['key' => 'services.highlight_2_title', 'label' => 'Highlight 2 Title'],
        ['key' => 'services.highlight_2_desc', 'label' => 'Highlight 2 Desc'],
        ['key' => 'services.highlight_3_title', 'label' => 'Highlight 3 Title'],
        ['key' => 'services.highlight_3_desc', 'label' => 'Highlight 3 Desc'],
    ],
    'Contact Page' => [
        ['key' => 'contact.page_title', 'label' => 'Page Title'],
        ['key' => 'contact.page_subtitle', 'label' => 'Page Subtitle'],
        ['key' => 'contact.section_title', 'label' => 'Section Title'],
        ['key' => 'contact.section_subtitle', 'label' => 'Section Subtitle'],
        ['key' => 'contact.urgent_title', 'label' => 'Urgent Title'],
        ['key' => 'contact.urgent_subtitle', 'label' => 'Urgent Subtitle'],
    ],
    'Gallery Page' => [
        ['key' => 'gallery.page_title', 'label' => 'Page Title'],
        ['key' => 'gallery.page_subtitle', 'label' => 'Page Subtitle'],
        ['key' => 'gallery.section_title', 'label' => 'Section Title'],
        ['key' => 'gallery.section_desc', 'label' => 'Section Description'],
    ],
    'Popup' => [
        ['key' => 'popup.tag', 'label' => 'Popup Tag'],
        ['key' => 'popup.title', 'label' => 'Popup Title'],
        ['key' => 'popup.subtitle', 'label' => 'Popup Subtitle'],
        ['key' => 'popup.form_title', 'label' => 'Popup Form Title'],
    ],
    'Topbar & Footer' => [
        ['key' => 'topbar.whatsapp_label', 'label' => 'Topbar WhatsApp'],
        ['key' => 'topbar.call_label', 'label' => 'Topbar Call'],
        ['key' => 'topbar.direction_label', 'label' => 'Topbar Direction'],
        ['key' => 'topbar.request_call_label', 'label' => 'Topbar Request Call'],
        ['key' => 'footer.quick_links', 'label' => 'Footer Quick Links'],
        ['key' => 'footer.get_in_touch', 'label' => 'Footer Get In Touch'],
        ['key' => 'footer.copyright', 'label' => 'Footer Copyright'],
        ['key' => 'footer.powered_by', 'label' => 'Footer Powered By'],
    ],
];
$sliderRaw = content_get('home.slider_images', '');
$sliderImages = array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $sliderRaw ?: ''))));

admin_layout_start('Content', 'content');
?>

<div class="card">
    <h2 style="margin:0 0 10px;">Content Editor</h2>
    <div class="muted">Edit values directly in the list below. Use search to find a key.</div>

    <?php if ($saved): ?>
        <div class="alert ok">Saved.</div>
    <?php endif; ?>
    <?php if ($deleted): ?>
        <div class="alert ok">Deleted.</div>
    <?php endif; ?>
    <?php if ($sliderSaved): ?>
        <div class="alert ok">Slider updated.</div>
    <?php endif; ?>
    <?php if ($err !== ''): ?>
        <div class="alert err"><?= e($err) ?></div>
    <?php endif; ?>

    <div class="muted">Use the table below to edit content.</div>
</div>

<div class="card">
    <details>
        <summary class="btn" style="display:inline-flex;">Advanced: Add / Delete Single Key</summary>
        <div style="margin-top:12px;">
            <form method="post" class="card" action="<?= e(admin_base()) ?>/content.php">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="save">
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
    </details>
</div>

<div class="card">
    <h2 style="margin:0 0 10px;">Home Slider Images</h2>
    <div class="muted">Upload images or paste URLs/paths. One per line. Uses key <code>home.slider_images</code>.</div>

    <form method="post" enctype="multipart/form-data" action="<?= e(admin_base()) ?>/content.php" style="margin-top: 12px;">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="slider_upload">
        <label for="slider_image">Upload image</label>
        <input id="slider_image" name="slider_image" type="file" accept="image/png,image/jpeg,image/webp" required>
        <div style="margin-top: 12px;">
            <button class="btn primary" type="submit">Upload & Add</button>
        </div>
    </form>

    <form method="post" action="<?= e(admin_base()) ?>/content.php" style="margin-top: 18px;">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="slider_save">
        <label for="slider_images">Image list</label>
        <textarea id="slider_images" name="slider_images" rows="6" placeholder="one image per line"><?= e($sliderRaw) ?></textarea>
        <div style="margin-top: 12px;">
            <button class="btn primary" type="submit">Save Slider List</button>
        </div>
    </form>

    <?php if (!empty($sliderImages)): ?>
        <div style="margin-top: 18px;">
            <h4 style="margin:0 0 10px;">Current images</h4>
            <table>
                <thead>
                    <tr>
                        <th style="width: 22%;">Preview</th>
                        <th>Path / URL</th>
                        <th style="width: 12%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($sliderImages as $i => $img): ?>
                    <tr>
                        <td>
                            <img src="<?= e(url_to($img)) ?>" alt="" style="width: 180px; height: 100px; object-fit: cover; border-radius: 10px; border:1px solid rgba(0,0,0,0.08);">
                        </td>
                        <td><code><?= e($img) ?></code></td>
                        <td>
                            <form method="post" action="<?= e(admin_base()) ?>/content.php" onsubmit="return confirm('Remove this image from slider?')">
                                <?= csrf_field() ?>
                                <input type="hidden" name="action" value="slider_remove">
                                <input type="hidden" name="index" value="<?= (int) $i ?>">
                                <button class="btn bad" type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<div class="card">
    <h3 style="margin:0 0 12px;">Existing keys</h3>
    <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:12px;">
        <input id="contentSearch" type="text" placeholder="Search by label or key..." style="max-width:320px;">
        <span class="muted">Edit value and click Save.</span>
    </div>

    <?php foreach ($keyMeta as $section => $items): ?>
        <div class="form-section content-section">
            <h3><?= e($section) ?></h3>
            <table>
                <thead>
                    <tr>
                        <th style="width: 26%;">Label</th>
                        <th style="width: 22%;">Key</th>
                        <th>Value</th>
                        <th style="width: 16%;">Updated</th>
                        <th style="width: 10%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($items as $it): ?>
                    <?php
                        $k = (string) $it['key'];
                        $label = (string) $it['label'];
                        $row = $rowMap[$k] ?? null;
                        $val = $row ? (string) ($row['content_value'] ?? '') : content_get($k);
                        $updated = $row ? (string) ($row['updated_at'] ?? '') : '';
                        $search = strtolower($label . ' ' . $k);
                    ?>
                    <tr class="content-row" data-search="<?= e($search) ?>">
                        <td><?= e($label) ?></td>
                        <td><code><?= e($k) ?></code></td>
                        <td>
                            <form method="post" action="<?= e(admin_base()) ?>/content.php" class="row-form">
                                <?= csrf_field() ?>
                                <input type="hidden" name="action" value="save">
                                <input type="hidden" name="content_key" value="<?= e($k) ?>">
                                <textarea name="content_value" rows="2"><?= e($val) ?></textarea>
                                <div class="row-actions">
                                    <button class="btn primary" type="submit">Save</button>
                                </div>
                            </form>
                        </td>
                        <td class="muted"><?= e($updated) ?></td>
                        <td>
                            <form method="post" action="<?= e(admin_base()) ?>/content.php" onsubmit="return confirm('Delete this key?')">
                                <?= csrf_field() ?>
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="content_key" value="<?= e($k) ?>">
                                <button class="btn bad" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>

    <div class="form-section content-section">
        <h3>Other Keys</h3>
        <div class="muted" style="margin-bottom:8px;">Keys not listed above.</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 22%;">Key</th>
                    <th>Value</th>
                    <th style="width: 16%;">Updated</th>
                    <th style="width: 10%;">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $knownKeys = [];
                foreach ($keyMeta as $items) {
                    foreach ($items as $it) {
                        $knownKeys[$it['key']] = true;
                    }
                }
                foreach ($rows as $r):
                    $k = (string) ($r['content_key'] ?? '');
                    if ($k === '' || isset($knownKeys[$k])) {
                        continue;
                    }
                    $search = strtolower($k);
            ?>
                <tr class="content-row" data-search="<?= e($search) ?>">
                    <td><code><?= e($k) ?></code></td>
                    <td>
                        <form method="post" action="<?= e(admin_base()) ?>/content.php" class="row-form">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="save">
                            <input type="hidden" name="content_key" value="<?= e($k) ?>">
                            <textarea name="content_value" rows="2"><?= e((string) ($r['content_value'] ?? '')) ?></textarea>
                            <div class="row-actions">
                                <button class="btn primary" type="submit">Save</button>
                            </div>
                        </form>
                    </td>
                    <td class="muted"><?= e((string) ($r['updated_at'] ?? '')) ?></td>
                    <td>
                        <form method="post" action="<?= e(admin_base()) ?>/content.php" onsubmit="return confirm('Delete this key?')">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="content_key" value="<?= e($k) ?>">
                            <button class="btn bad" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
(() => {
  const input = document.getElementById('contentSearch');
  if (!input) return;
  const rows = Array.from(document.querySelectorAll('.content-row'));
  input.addEventListener('input', () => {
    const q = input.value.trim().toLowerCase();
    rows.forEach((row) => {
      const text = row.getAttribute('data-search') || '';
      row.style.display = text.includes(q) ? '' : 'none';
    });
  });
})();
</script>

<?php admin_layout_end(); ?>

