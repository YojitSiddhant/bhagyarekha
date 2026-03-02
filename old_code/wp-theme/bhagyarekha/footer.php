<?php
/**
 * Footer template
 *
 * @package Bhagyarekha
 */

$phone = get_theme_mod( 'bhagyarekha_phone', '09452884067' );
?>

<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) : ?>
	<footer class="site-footer">
		<div class="footer-inner">
			<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
				<div class="footer-col"><?php dynamic_sidebar( 'footer-1' ); ?></div>
			<?php else : ?>
				<div class="footer-col">
					<div class="footer-logo">
						<span class="footer-logo-icon"><i class="fas fa-om"></i></span>
						<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
					</div>
					<p><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
				</div>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
				<div class="footer-col"><?php dynamic_sidebar( 'footer-2' ); ?></div>
			<?php else : ?>
				<div class="footer-col">
					<h4><?php esc_html_e( 'Quick Links', 'bhagyarekha' ); ?></h4>
					<?php
					wp_nav_menu( array(
						'theme_location' => 'footer',
						'menu_class'     => 'footer-menu',
						'container'      => false,
					) );
					if ( ! has_nav_menu( 'footer' ) ) :
						?>
						<ul>
							<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'bhagyarekha' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>"><?php esc_html_e( 'About Us', 'bhagyarekha' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/services' ) ); ?>"><?php esc_html_e( 'Our Service', 'bhagyarekha' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/gallery' ) ); ?>"><?php esc_html_e( 'Gallery', 'bhagyarekha' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Contact Us', 'bhagyarekha' ); ?></a></li>
						</ul>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
				<div class="footer-col"><?php dynamic_sidebar( 'footer-3' ); ?></div>
			<?php else : ?>
				<div class="footer-col footer-contact">
					<h4><?php esc_html_e( 'Get In Touch', 'bhagyarekha' ); ?></h4>
					<p><i class="fas fa-map-marker-alt"></i> Banaras Hindu University, Varanasi, Uttar Pradesh - 221005</p>
					<p><i class="fas fa-phone"></i> +91-<?php echo esc_html( $phone ); ?></p>
					<p><i class="fas fa-envelope"></i> <?php echo esc_html( get_option( 'admin_email' ) ); ?></p>
					<p><i class="fas fa-globe"></i> <?php echo esc_html( parse_url( home_url(), PHP_URL_HOST ) ); ?></p>
				</div>
			<?php endif; ?>
		</div>
		<div class="footer-bottom">
			<?php
			printf(
				/* translators: 1: Theme name, 2: Year */
				esc_html__( 'Copyright @ %2$s %1$s | Powered By Techvanta Labs Pvt Ltd', 'bhagyarekha' ),
				esc_html( get_bloginfo( 'name' ) ),
				date( 'Y' )
			);
			?>
		</div>
	</footer>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
