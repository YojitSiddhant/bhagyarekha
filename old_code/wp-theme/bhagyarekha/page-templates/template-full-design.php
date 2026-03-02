<?php
/**
 * Template Name: Full Design (Pre-built)
 * Full astrologer design - use for Home or copy structure to Elementor
 *
 * @package Bhagyarekha
 */

get_header();

$phone = get_theme_mod( 'bhagyarekha_phone', '09452884067' );
$whatsapp = get_theme_mod( 'bhagyarekha_whatsapp', '919452884067' );
$phone_clean = preg_replace( '/\D/', '', $phone );
?>
<main id="primary" class="site-main">
	<?php get_template_part( 'template-parts/content', 'full-design' ); ?>
</main>
<?php get_footer();
