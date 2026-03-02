<?php
declare(strict_types=1);

function seo_get(string $pageSlug): array
{
    $defaults = [
        'title' => 'Bhagyarekha Astrology',
        'description' => '',
        'keywords' => '',
        'canonical_url' => '',
        'robots' => 'index,follow',
        'og_title' => '',
        'og_description' => '',
        'og_image' => '',
        'og_type' => 'website',
        'og_url' => '',
        'twitter_card' => 'summary_large_image',
        'twitter_title' => '',
        'twitter_description' => '',
        'twitter_image' => '',
    ];

    if (!db_table_exists('seo_meta')) {
        // Basic fallback titles for known pages.
        $map = [
            'home' => 'Jyotisacharya Rajkishor Tiwari - Gold Medalist | Varanasi Astrologer',
            'about' => 'About Us | Varanasi Astrologer',
            'services' => 'Our Services | Varanasi Astrologer',
            'gallery' => 'Gallery | Varanasi Astrologer',
            'contact' => 'Contact Us | Varanasi Astrologer',
        ];
        $defaults['title'] = $map[$pageSlug] ?? $defaults['title'];
        $defaults['canonical_url'] = base_url() . ($pageSlug === 'home' ? '/' : ('/' . $pageSlug));
        $defaults['og_url'] = $defaults['canonical_url'];
        return $defaults;
    }

    $stmt = db()->prepare('SELECT * FROM seo_meta WHERE page_slug = ? LIMIT 1');
    $stmt->execute([$pageSlug]);
    $row = $stmt->fetch();
    if (!$row) {
        $defaults['canonical_url'] = base_url() . ($pageSlug === 'home' ? '/' : ('/' . $pageSlug));
        $defaults['og_url'] = $defaults['canonical_url'];
        return $defaults;
    }

    foreach ($defaults as $k => $v) {
        if (array_key_exists($k, $row) && $row[$k] !== null) {
            $defaults[$k] = (string) $row[$k];
        }
    }

    if ($defaults['canonical_url'] === '') {
        $defaults['canonical_url'] = base_url() . ($pageSlug === 'home' ? '/' : ('/' . $pageSlug));
    }
    if ($defaults['og_url'] === '') {
        $defaults['og_url'] = $defaults['canonical_url'];
    }
    if ($defaults['og_title'] === '') {
        $defaults['og_title'] = $defaults['title'];
    }
    if ($defaults['twitter_title'] === '') {
        $defaults['twitter_title'] = $defaults['title'];
    }
    if ($defaults['twitter_description'] === '') {
        $defaults['twitter_description'] = $defaults['description'];
    }
    if ($defaults['og_description'] === '') {
        $defaults['og_description'] = $defaults['description'];
    }

    return $defaults;
}

function seo_render_meta(string $pageSlug): string
{
    $m = seo_get($pageSlug);

    $out = [];
    $out[] = '<title>' . e($m['title']) . '</title>';
    if ($m['description'] !== '') {
        $out[] = '<meta name="description" content="' . e($m['description']) . '">';
    }
    if ($m['keywords'] !== '') {
        $out[] = '<meta name="keywords" content="' . e($m['keywords']) . '">';
    }
    if ($m['robots'] !== '') {
        $out[] = '<meta name="robots" content="' . e($m['robots']) . '">';
    }
    if ($m['canonical_url'] !== '') {
        $out[] = '<link rel="canonical" href="' . e($m['canonical_url']) . '">';
    }

    // OpenGraph
    $out[] = '<meta property="og:type" content="' . e($m['og_type']) . '">';
    $out[] = '<meta property="og:title" content="' . e($m['og_title']) . '">';
    if ($m['og_description'] !== '') {
        $out[] = '<meta property="og:description" content="' . e($m['og_description']) . '">';
    }
    if ($m['og_url'] !== '') {
        $out[] = '<meta property="og:url" content="' . e($m['og_url']) . '">';
    }
    if ($m['og_image'] !== '') {
        $out[] = '<meta property="og:image" content="' . e($m['og_image']) . '">';
    }

    // Twitter
    $out[] = '<meta name="twitter:card" content="' . e($m['twitter_card']) . '">';
    $out[] = '<meta name="twitter:title" content="' . e($m['twitter_title']) . '">';
    if ($m['twitter_description'] !== '') {
        $out[] = '<meta name="twitter:description" content="' . e($m['twitter_description']) . '">';
    }
    if ($m['twitter_image'] !== '') {
        $out[] = '<meta name="twitter:image" content="' . e($m['twitter_image']) . '">';
    }

    return implode("\n    ", $out);
}

