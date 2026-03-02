<?php
/**
 * Default front page content when Elementor is not used
 *
 * @package Bhagyarekha
 */

$phone = get_theme_mod( 'bhagyarekha_phone', '09452884067' );
$whatsapp = get_theme_mod( 'bhagyarekha_whatsapp', '919452884067' );
?>
<main id="primary" class="site-main">
	<?php the_content(); ?>

	<?php if ( ! get_the_content() ) : ?>
	<!-- Hero -->
	<div class="hero-banner">
		<div class="hero-content">
			<h1><?php esc_html_e( 'Want to discover your love crystal?', 'bhagyarekha' ); ?></h1>
			<a href="tel:+91<?php echo esc_attr( preg_replace( '/\D/', '', $phone ) ); ?>" class="btn"><?php esc_html_e( 'Get Advice', 'bhagyarekha' ); ?></a>
		</div>
		<div class="hero-cta-bar">
			<span class="contact-no"><?php printf( esc_html__( 'CONTACT NO. %s', 'bhagyarekha' ), esc_html( $phone ) ); ?></span>
			<a href="tel:+91<?php echo esc_attr( preg_replace( '/\D/', '', $phone ) ); ?>" class="talk-now"><?php esc_html_e( 'अभी बात करे', 'bhagyarekha' ); ?></a>
		</div>
	</div>

	<p style="text-align: center; padding: 40px 20px;">
		<?php
		printf(
			/* translators: %s: link to customizer */
			esc_html__( 'Edit this page with %s or import demo content from Appearance > Import Demo.', 'bhagyarekha' ),
			'<a href="' . esc_url( admin_url( 'plugin-install.php?s=elementor&tab=search' ) ) . '">Elementor</a>'
		);
		?>
	</p>
	<?php endif; ?>
</main>
