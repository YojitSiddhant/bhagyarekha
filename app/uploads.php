<?php
declare(strict_types=1);

function uploads_dir(): string
{
    return __DIR__ . '/../uploads';
}

function uploads_web_path(string $relativePath): string
{
    $relativePath = ltrim(str_replace('\\', '/', $relativePath), '/');
    return base_url() . '/uploads/' . $relativePath;
}

function store_uploaded_image(string $fileField, int $maxBytes = 2_500_000): array
{
    if (empty($_FILES[$fileField]) || !is_array($_FILES[$fileField])) {
        return ['ok' => false, 'error' => 'No file uploaded'];
    }

    $f = $_FILES[$fileField];
    if (($f['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'error' => 'Upload error'];
    }

    $tmp = (string) ($f['tmp_name'] ?? '');
    $size = (int) ($f['size'] ?? 0);
    $name = (string) ($f['name'] ?? '');

    if ($size <= 0 || $size > $maxBytes) {
        return ['ok' => false, 'error' => 'File too large'];
    }

    $info = @getimagesize($tmp);
    if (!$info || empty($info['mime'])) {
        return ['ok' => false, 'error' => 'Invalid image'];
    }

    $mime = (string) $info['mime'];
    $ext = match ($mime) {
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        default => '',
    };
    if ($ext === '') {
        return ['ok' => false, 'error' => 'Only JPG/PNG/WebP allowed'];
    }

    $safeBase = bin2hex(random_bytes(16));
    $subdir = date('Y-m');
    $dir = uploads_dir() . '/' . $subdir;
    if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
        return ['ok' => false, 'error' => 'Cannot create uploads directory'];
    }

    $relative = $subdir . '/' . $safeBase . '.' . $ext;
    $dest = uploads_dir() . '/' . $relative;

    if (!move_uploaded_file($tmp, $dest)) {
        return ['ok' => false, 'error' => 'Failed to store upload'];
    }

    // Save metadata (optional; if table not created yet, skip).
    $uploadId = null;
    if (db_table_exists('uploads')) {
        $stmt = db()->prepare(
            'INSERT INTO uploads (file_path, original_name, mime_type, file_size, created_at)
             VALUES (?, ?, ?, ?, NOW())'
        );
        $stmt->execute([$relative, $name, $mime, $size]);
        $uploadId = (int) db()->lastInsertId();
    }

    return [
        'ok' => true,
        'upload_id' => $uploadId,
        'file_path' => $relative,
        'mime' => $mime,
    ];
}

