<?php
/**
 * About Us page content
 *
 * @package Bhagyarekha
 */

$phone = get_theme_mod( 'bhagyarekha_phone', '09452884067' );
$phone_clean = preg_replace( '/\D/', '', $phone );
?>
<section class="page-hero">
	<h1><?php esc_html_e( 'About Us', 'bhagyarekha' ); ?></h1>
	<p><?php esc_html_e( 'Jyotisacharya Rajkishor Tiwari - Gold Medalist Astrologer', 'bhagyarekha' ); ?></p>
</section>

<section class="about-section" style="background: var(--white);">
	<div class="about-content">
		<div class="about-text">
			<h2><?php esc_html_e( 'Jyotisacharya Rajkishor Tiwari - Gold Medalist', 'bhagyarekha' ); ?></h2>
			<p><?php esc_html_e( 'With over 10 years of rich and distinguished experience in the field of astrology, Jyotishacharya Rajkishore Tiwari, a recipient of the Gold Medal from the Honorable Governor of Uttar Pradesh, holds a respected position among the renowned, trustworthy, and experienced astrologers of Varanasi.', 'bhagyarekha' ); ?></p>
			<p><?php esc_html_e( 'He is currently serving as a government teacher (lecturer) in an inter college. His profound understanding, scholarly approach, and disciplined study in both education and astrology set him apart.', 'bhagyarekha' ); ?></p>
			<div class="highlight-box">
				<p style="margin:0;"><?php esc_html_e( 'His accurate and clear predictions, based on in-depth study, extensive experience, and Vedic traditions, have been instrumental in bringing positive changes, guidance, and solutions to the lives of many. This is why he is considered a center of trust and reverence among the general public.', 'bhagyarekha' ); ?></p>
			</div>
			<a href="tel:+91<?php echo esc_attr( $phone_clean ); ?>" class="btn"><?php printf( esc_html__( 'Call Now: %s', 'bhagyarekha' ), esc_html( $phone ) ); ?></a>
		</div>
		<div>
			<div class="about-image placeholder"><i class="fas fa-medal"></i></div>
			<p class="about-caption"><?php esc_html_e( 'Governor receiving gold medal from Uttar Pradesh Government in 2018', 'bhagyarekha' ); ?></p>
		</div>
	</div>
</section>

<section style="padding: 70px 20px; max-width: 1200px; margin: 0 auto;">
	<div class="section-title">
		<h2><?php esc_html_e( 'Awards & Recognition', 'bhagyarekha' ); ?></h2>
		<div class="accent-line"></div>
	</div>
	<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
		<div class="award-mini" style="background: var(--cream); padding: 25px; border-radius: 12px; text-align: center;"><i class="fas fa-award" style="font-size: 36px; color: var(--red); margin-bottom: 12px;"></i><h4><?php esc_html_e( 'Conference Certificate', 'bhagyarekha' ); ?></h4></div>
		<div class="award-mini" style="background: var(--cream); padding: 25px; border-radius: 12px; text-align: center;"><i class="fas fa-medal" style="font-size: 36px; color: var(--red); margin-bottom: 12px;"></i><h4><?php esc_html_e( 'Gold Medal', 'bhagyarekha' ); ?></h4></div>
		<div class="award-mini" style="background: var(--cream); padding: 25px; border-radius: 12px; text-align: center;"><i class="fas fa-university" style="font-size: 36px; color: var(--red); margin-bottom: 12px;"></i><h4><?php esc_html_e( 'BHU Varanasi', 'bhagyarekha' ); ?></h4></div>
		<div class="award-mini" style="background: var(--cream); padding: 25px; border-radius: 12px; text-align: center;"><i class="fas fa-trophy" style="font-size: 36px; color: var(--red); margin-bottom: 12px;"></i><h4><?php esc_html_e( 'First Position Acharya', 'bhagyarekha' ); ?></h4></div>
	</div>
</section>

<div class="contact-cta">
	<h3><?php esc_html_e( "Any Help We're Always Here", 'bhagyarekha' ); ?></h3>
	<a href="tel:+91<?php echo esc_attr( $phone_clean ); ?>" class="phone">+91-<?php echo esc_html( $phone ); ?></a>
</div>
