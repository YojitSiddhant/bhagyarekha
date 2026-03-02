<?php
declare(strict_types=1);

require_once __DIR__ . '/_init.php';
admin_require_login();

if (!db_table_exists('contact_messages')) {
    admin_layout_start('Messages', 'messages');
    echo '<div class="alert err">Table `contact_messages` not found. Import database first.</div>';
    admin_layout_end();
    exit;
}

$rows = db()->query(
    'SELECT id, name, phone, email, subject, message, ip_address, created_at
     FROM contact_messages
     ORDER BY id DESC
     LIMIT 200'
)->fetchAll();

admin_layout_start('Messages', 'messages');
?>

<div class="card">
    <h2 style="margin:0 0 10px;">Contact Messages</h2>
    <div class="muted">Latest 200 messages submitted from the website contact form.</div>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th style="width: 6%;">ID</th>
                <th style="width: 18%;">Name</th>
                <th style="width: 16%;">Phone</th>
                <th style="width: 20%;">Email</th>
                <th>Message</th>
                <th style="width: 16%;">Created</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $r): ?>
            <tr>
                <td><?= (int) $r['id'] ?></td>
                <td><?= e((string) $r['name']) ?></td>
                <td><?= e((string) $r['phone']) ?></td>
                <td><?= e((string) $r['email']) ?></td>
                <td style="white-space: pre-wrap;">
                    <?php if ((string) $r['subject'] !== ''): ?>
                        <div><strong><?= e((string) $r['subject']) ?></strong></div>
                    <?php endif; ?>
                    <?= e((string) $r['message']) ?>
                </td>
                <td class="muted"><?= e((string) $r['created_at']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php admin_layout_end(); ?>

