<?php
declare(strict_types=1);

function list_services(): array
{
    if (!db_table_exists('services')) {
        return [];
    }
    $stmt = db()->query('SELECT * FROM services WHERE is_active = 1 ORDER BY sort_order ASC, id ASC');
    return $stmt->fetchAll();
}

function list_testimonials(): array
{
    if (!db_table_exists('testimonials')) {
        return [];
    }
    $stmt = db()->query('SELECT * FROM testimonials WHERE is_active = 1 ORDER BY sort_order ASC, id ASC');
    return $stmt->fetchAll();
}

function list_products(): array
{
    if (!db_table_exists('products')) {
        return [];
    }
    $stmt = db()->query('SELECT * FROM products WHERE is_active = 1 ORDER BY sort_order ASC, id ASC');
    return $stmt->fetchAll();
}

function list_awards(): array
{
    if (!db_table_exists('awards')) {
        return [];
    }
    $stmt = db()->query('SELECT * FROM awards WHERE is_active = 1 ORDER BY sort_order ASC, id ASC');
    return $stmt->fetchAll();
}

function list_gallery_categories(): array
{
    if (!db_table_exists('gallery_categories')) {
        return [];
    }
    return db()->query('SELECT * FROM gallery_categories ORDER BY sort_order ASC, id ASC')->fetchAll();
}

function list_gallery_items(?int $categoryId = null): array
{
    if (!db_table_exists('gallery_items')) {
        return [];
    }
    if ($categoryId) {
        $stmt = db()->prepare('SELECT * FROM gallery_items WHERE is_active = 1 AND category_id = ? ORDER BY sort_order ASC, id ASC');
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll();
    }
    return db()->query('SELECT * FROM gallery_items WHERE is_active = 1 ORDER BY sort_order ASC, id ASC')->fetchAll();
}

