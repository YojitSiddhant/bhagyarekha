<?php
declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';

// Routing:
// - Supports pretty URLs via .htaccess (e.g. /about)
// - Also supports query param ?page=about

$path = request_path();
$page = $_GET['page'] ?? '';
if (is_string($page) && $page !== '') {
    $slug = strtolower(trim($page));
} else {
    $slug = trim($path, '/');
    $slug = $slug === '' ? 'home' : strtolower($slug);
}

$allowed = ['home', 'about', 'services', 'gallery', 'contact'];
if (!in_array($slug, $allowed, true)) {
    http_response_code(404);
    render('pages/404.php', ['page_slug' => '404', 'db_ready' => db_table_exists('content')]);
    exit;
}

// If DB isn't installed yet, show a friendly note (but still render the page).
$dbReady = db_table_exists('content');

$data = [
    'page_slug' => $slug,
    'db_ready' => $dbReady,
];

switch ($slug) {
    case 'home':
        $data['services'] = list_services();
        $data['testimonials'] = list_testimonials();
        $data['products'] = list_products();
        $data['awards'] = list_awards();
        render('pages/home.php', $data);
        break;
    case 'about':
        $data['awards'] = list_awards();
        render('pages/about.php', $data);
        break;
    case 'services':
        $data['services'] = list_services();
        render('pages/services.php', $data);
        break;
    case 'gallery':
        $categories = list_gallery_categories();
        $data['categories'] = $categories;
        $catSlug = $_GET['cat'] ?? '';
        $catId = null;
        if (is_string($catSlug) && $catSlug !== '') {
            foreach ($categories as $c) {
                if (($c['slug'] ?? '') === $catSlug) {
                    $catId = (int) $c['id'];
                    break;
                }
            }
        }
        $data['active_cat'] = $catSlug;
        $data['items'] = list_gallery_items($catId);
        render('pages/gallery.php', $data);
        break;
    case 'contact':
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            csrf_verify();

            $name = trim((string) ($_POST['name'] ?? ''));
            $phone = trim((string) ($_POST['phone'] ?? ''));
            $email = trim((string) ($_POST['email'] ?? ''));
            $subject = trim((string) ($_POST['subject'] ?? ''));
            $message = trim((string) ($_POST['message'] ?? ''));

            $errors = [];
            if ($name === '' || mb_strlen($name) > 80) {
                $errors[] = 'Please enter your name';
            }
            if ($phone === '' || mb_strlen($phone) > 30) {
                $errors[] = 'Please enter your phone number';
            }
            if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email';
            }
            if ($message === '' || mb_strlen($message) > 2000) {
                $errors[] = 'Please enter your message';
            }

            if (!empty($errors)) {
                flash_set('contact_error', implode('. ', $errors));
                redirect(base_url() . '/contact');
            }

            if (db_table_exists('contact_messages')) {
                $stmt = db()->prepare(
                    'INSERT INTO contact_messages (name, phone, email, subject, message, ip_address, user_agent, created_at)
                     VALUES (?, ?, ?, ?, ?, ?, ?, NOW())'
                );
                $stmt->execute([
                    $name,
                    $phone,
                    $email,
                    $subject,
                    $message,
                    (string) ($_SERVER['REMOTE_ADDR'] ?? ''),
                    substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 250),
                ]);
                flash_set('contact_success', 'Thank you! We will contact you soon.');
            } else {
                flash_set('contact_success', 'Thank you! (Database not installed yet)');
            }

            redirect(base_url() . '/contact');
        }
        render('pages/contact.php', $data);
        break;
}

