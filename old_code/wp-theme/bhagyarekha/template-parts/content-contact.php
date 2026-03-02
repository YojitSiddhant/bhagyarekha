<?php
/**
 * Contact Us page content
 *
 * @package Bhagyarekha
 */

$phone = get_theme_mod( 'bhagyarekha_phone', '09452884067' );
$whatsapp = get_theme_mod( 'bhagyarekha_whatsapp', '919452884067' );
$phone_clean = preg_replace( '/\D/', '', $phone );
?>
<section class="page-hero">
	<h1><?php esc_html_e( 'Contact Us', 'bhagyarekha' ); ?></h1>
	<p><?php esc_html_e( 'Get in touch for astrological consultation and guidance', 'bhagyarekha' ); ?></p>
</section>

<section>
	<div class="section-title">
		<h2><?php esc_html_e( 'Get In Touch', 'bhagyarekha' ); ?></h2>
		<p class="subtitle"><?php esc_html_e( 'We are here to help you', 'bhagyarekha' ); ?></p>
		<div class="accent-line"></div>
	</div>
	<div class="contact-wrapper">
		<div>
			<div class="contact-info-card">
				<h3><?php esc_html_e( 'Contact Information', 'bhagyarekha' ); ?></h3>
				<div class="contact-item">
					<i class="fas fa-map-marker-alt"></i>
					<div>
						<h4><?php esc_html_e( 'Address', 'bhagyarekha' ); ?></h4>
						<p><?php esc_html_e( 'Banaras Hindu University, Varanasi, Uttar Pradesh - 221005', 'bhagyarekha' ); ?></p>
					</div>
				</div>
				<div class="contact-item">
					<i class="fas fa-phone"></i>
					<div>
						<h4><?php esc_html_e( 'Phone', 'bhagyarekha' ); ?></h4>
						<a href="tel:+91<?php echo esc_attr( $phone_clean ); ?>" style="font-size: 18px; font-weight: 600; color: var(--red);">+91-<?php echo esc_html( $phone ); ?></a>
					</div>
				</div>
				<div class="contact-item">
					<i class="fas fa-envelope"></i>
					<div>
						<h4><?php esc_html_e( 'Email', 'bhagyarekha' ); ?></h4>
						<a href="mailto:<?php echo esc_attr( get_option( 'admin_email' ) ); ?>"><?php echo esc_html( get_option( 'admin_email' ) ); ?></a>
					</div>
				</div>
				<div class="contact-item">
					<i class="fas fa-globe"></i>
					<div>
						<h4><?php esc_html_e( 'Website', 'bhagyarekha' ); ?></h4>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( parse_url( home_url(), PHP_URL_HOST ) ); ?></a>
					</div>
				</div>
			</div>
			<div class="consultation-hours">
				<p><strong><?php esc_html_e( 'Consultation Hours:', 'bhagyarekha' ); ?></strong> 5:00 PM to 10:00 PM</p>
				<p style="margin-top: 10px;"><?php esc_html_e( 'After giving Dakshina voluntarily, you will be provided with Astrological Consultation.', 'bhagyarekha' ); ?></p>
				<p style="margin-top: 10px;"><strong><?php esc_html_e( 'Google Pay:', 'bhagyarekha' ); ?></strong> <?php echo esc_html( $phone ); ?></p>
			</div>
		</div>
		<div class="contact-form">
			<h3><?php esc_html_e( 'Send us a Message', 'bhagyarekha' ); ?></h3>
			<?php if ( shortcode_exists( 'contact-form-7' ) ) : ?>
				<?php echo do_shortcode( '[contact-form-7 id="contact-form" title="Contact form 1"]' ); ?>
			<?php else : ?>
			<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
				<input type="hidden" name="action" value="bhagyarekha_contact">
				<?php wp_nonce_field( 'bhagyarekha_contact', 'bhagyarekha_contact_nonce' ); ?>
				<div class="form-group">
					<label for="name"><?php esc_html_e( 'Your Name *', 'bhagyarekha' ); ?></label>
					<input type="text" id="name" name="name" required placeholder="<?php esc_attr_e( 'Enter your name', 'bhagyarekha' ); ?>">
				</div>
				<div class="form-group">
					<label for="phone"><?php esc_html_e( 'Phone Number *', 'bhagyarekha' ); ?></label>
					<input type="tel" id="phone" name="phone" required placeholder="<?php esc_attr_e( 'Enter your phone', 'bhagyarekha' ); ?>">
				</div>
				<div class="form-group">
					<label for="email"><?php esc_html_e( 'Email', 'bhagyarekha' ); ?></label>
					<input type="email" id="email" name="email" placeholder="<?php esc_attr_e( 'Enter your email', 'bhagyarekha' ); ?>">
				</div>
				<div class="form-group">
					<label for="subject"><?php esc_html_e( 'Subject', 'bhagyarekha' ); ?></label>
					<input type="text" id="subject" name="subject" placeholder="<?php esc_attr_e( 'e.g. Palmistry, Marriage, etc.', 'bhagyarekha' ); ?>">
				</div>
				<div class="form-group">
					<label for="message"><?php esc_html_e( 'Your Message *', 'bhagyarekha' ); ?></label>
					<textarea id="message" name="message" required placeholder="<?php esc_attr_e( 'Describe your concern or query...', 'bhagyarekha' ); ?>"></textarea>
				</div>
				<button type="submit" class="btn"><?php esc_html_e( 'Send Message', 'bhagyarekha' ); ?></button>
			</form>
			<?php endif; ?>
		</div>
	</div>
</section>

<section style="background: var(--cream); padding: 50px 20px;">
	<div style="max-width: 800px; margin: 0 auto; text-align: center;">
		<h2 style="margin-bottom: 20px;"><?php esc_html_e( 'Need Immediate Help?', 'bhagyarekha' ); ?></h2>
		<p style="color: var(--text-light); margin-bottom: 25px;"><?php esc_html_e( 'Call now for free astrological advice', 'bhagyarekha' ); ?></p>
		<div class="contact-buttons">
			<a href="tel:+91<?php echo esc_attr( $phone_clean ); ?>" class="btn" style="font-size: 18px; padding: 15px 40px;"><i class="fas fa-phone" style="margin-right: 10px;"></i>+91-<?php echo esc_html( $phone ); ?></a>
			<a href="https://wa.me/<?php echo esc_attr( $whatsapp ); ?>" class="btn btn-outline" style="font-size: 18px; padding: 15px 40px;"><i class="fab fa-whatsapp" style="margin-right: 10px;"></i>WhatsApp</a>
		</div>
	</div>
</section>
