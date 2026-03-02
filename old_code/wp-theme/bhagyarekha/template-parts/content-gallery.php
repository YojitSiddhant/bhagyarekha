<?php
/**
 * Gallery page content
 *
 * @package Bhagyarekha
 */

$gallery_items = array(
	array( 'icon' => 'fa-medal', 'title' => 'Gold Medal Award 2018' ),
	array( 'icon' => 'fa-image', 'title' => 'International Astrology Conference' ),
	array( 'icon' => 'fa-university', 'title' => 'Banaras Hindu University' ),
	array( 'icon' => 'fa-scroll', 'title' => 'Handwritten Janmkundali' ),
	array( 'icon' => 'fa-hands-praying', 'title' => 'Vedic Ceremony' ),
	array( 'icon' => 'fa-award', 'title' => 'Acharya Certificate' ),
);
?>
<section class="page-hero">
	<h1><?php esc_html_e( 'Gallery', 'bhagyarekha' ); ?></h1>
	<p><?php esc_html_e( 'Images from our astrological practice and ceremonies', 'bhagyarekha' ); ?></p>
</section>

<section>
	<div class="section-title">
		<h2><?php esc_html_e( 'Our Gallery', 'bhagyarekha' ); ?></h2>
		<p class="subtitle"><?php esc_html_e( 'Moments from consultations, ceremonies and awards', 'bhagyarekha' ); ?></p>
		<div class="accent-line"></div>
	</div>
	<div class="gallery-categories">
		<a href="#" class="active"><?php esc_html_e( 'All', 'bhagyarekha' ); ?></a>
		<a href="#"><?php esc_html_e( 'Awards', 'bhagyarekha' ); ?></a>
		<a href="#"><?php esc_html_e( 'Consultations', 'bhagyarekha' ); ?></a>
		<a href="#"><?php esc_html_e( 'Ceremonies', 'bhagyarekha' ); ?></a>
	</div>
	<div class="gallery-grid">
		<?php foreach ( $gallery_items as $item ) : ?>
		<div class="gallery-item">
			<div class="thumb">
				<i class="fas <?php echo esc_attr( $item['icon'] ); ?>"></i>
			</div>
			<div class="caption"><h3><?php echo esc_html( $item['title'] ); ?></h3></div>
		</div>
		<?php endforeach; ?>
	</div>
</section>

<div class="contact-cta">
	<h3><?php esc_html_e( 'Need Astrological Guidance?', 'bhagyarekha' ); ?></h3>
	<a href="tel:+91<?php echo esc_attr( preg_replace( '/\D/', '', get_theme_mod( 'bhagyarekha_phone', '09452884067' ) ) ); ?>" class="phone">+91-<?php echo esc_html( get_theme_mod( 'bhagyarekha_phone', '09452884067' ) ); ?></a>
</div>
