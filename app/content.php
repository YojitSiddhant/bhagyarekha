<?php
declare(strict_types=1);

function content_all(): array
{
    static $cache = null;
    if (is_array($cache)) {
        return $cache;
    }

    // Safe fallbacks (so pages render even before DB install).
    $fallback = [
        'site.topbar_title' => 'ज्योतिषाचार्य राजकिशोर तिवारी',
        'site.brand_name' => 'Bhagyarekha',
        'site.brand_icon_text' => 'ज्यो',
        'site.phone_primary' => '9452884067',
        'site.phone_display' => '09452884067',
        'site.email' => 'contact@varanasiastrologer.com',
        'site.address' => 'Banaras Hindu University, Varanasi, Uttar Pradesh - 221005',
        'site.website' => 'www.varanasiastrologer.com',
        'site.whatsapp_number' => '919452884067',
        'site.maps_url' => 'https://maps.google.com/?q=Banaras+Hindu+University+Varanasi',
        'home.hero_title' => 'Want to discover your love crystal?',
        'home.hero_button' => 'Get Advice',
        'home.hero_hindi_cta' => 'अभी बात करे',
        'home.about_subtitle' => 'about us',
        'home.about_title' => 'Jyotisacharya Rajkishor Tiwari - Gold Medalist',
        'home.about_p1' => 'With over 10 years of rich and distinguished experience in the field of astrology, Jyotishacharya Rajkishore Tiwari, a recipient of the Gold Medal from the Honorable Governor of Uttar Pradesh, holds a respected position among the renowned, trustworthy, and experienced astrologers of Varanasi.',
        'home.about_p2' => 'His accurate and clear predictions, based on in-depth study, extensive experience, and Vedic traditions, have been instrumental in bringing positive changes, guidance, and solutions to the lives of many.',
        'home.about_caption' => 'Governor receiving gold medal from Uttar Pradesh Government in 2018',
        'home.help_title' => "Any Help We're Always Here",
        'home.help_text' => 'We can solve all types of problems for you without a birth chart, using palmistry, omens, and horary astrology.',
        'home.slider_images' => "https://upload.wikimedia.org/wikipedia/commons/f/f8/Zodiac_Constellations.jpg\n"
            . "https://upload.wikimedia.org/wikipedia/commons/5/5e/Zodiac_%28PSF%29.png\n"
            . "https://upload.wikimedia.org/wikipedia/commons/8/88/Celestial_map%2C_signs_of_the_Zodiac_and_lunar_mansions..JPG",
        'home.hindi_banner' => 'हमारे संस्था की ओर से काशी के वैदिक विद्वानों के द्वारा महामृत्युंजय जप, ग्रह शांति, दशमहाविद्या प्रयोग, बगलामुखी प्रयोग, कर्मकांड, यज्ञ एवं सभी प्रकार के अनुष्ठान कराया जाता है |',
        'home.pitra_title' => 'Pitra Dosh',
        'home.pitra_text' => 'In Vedic astrology, certain planetary combinations in a birth chart and lines on the palm indicate the presence of ancestral curses, known as Pitru Dosha or Matru Dosha.',
        'footer.powered_by' => 'Powered By Quartz Technologies',
        'footer.copyright' => 'Copyright @ 2026 Bhagyarekha',
    ];

    if (!db_table_exists('content')) {
        $cache = $fallback;
        return $cache;
    }

    $rows = db()->query('SELECT content_key, content_value FROM content')->fetchAll();
    $data = $fallback;
    foreach ($rows as $r) {
        $k = (string) ($r['content_key'] ?? '');
        if ($k === '') {
            continue;
        }
        $data[$k] = (string) ($r['content_value'] ?? '');
    }

    $cache = $data;
    return $cache;
}

function content_get(string $key, string $default = ''): string
{
    $all = content_all();
    return array_key_exists($key, $all) ? (string) $all[$key] : $default;
}

function content_set(string $key, string $value): void
{
    if (!db_table_exists('content')) {
        return;
    }

    $stmt = db()->prepare(
        'INSERT INTO content (content_key, content_value, updated_at)
         VALUES (?, ?, NOW())
         ON DUPLICATE KEY UPDATE content_value = VALUES(content_value), updated_at = NOW()'
    );
    $stmt->execute([$key, $value]);

    // Bust per-request cache
    $ref = new ReflectionFunction('content_all');
    $staticVars = $ref->getStaticVariables();
    if (array_key_exists('cache', $staticVars)) {
        // no-op; PHP doesn't let us set that easily without globals.
        // cache is per-request anyway.
    }
}

