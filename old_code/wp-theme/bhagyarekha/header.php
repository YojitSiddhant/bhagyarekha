<?php
/**
 * Header template
 *
 * @package Bhagyarekha
 */

$phone = get_theme_mod( 'bhagyarekha_phone', '09452884067' );
$whatsapp = get_theme_mod( 'bhagyarekha_whatsapp', '919452884067' );
$maps_url = 'https://maps.google.com/?q=Banaras+Hindu+University+Varanasi';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) : ?>
	<!-- Top Bar -->
	<div class="top-bar">
		<div class="container">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="top-bar-brand">
				<span class="logo-icon" style="width:28px;height:28px;border-radius:50%;background:rgba(255,255,255,0.2);display:inline-flex;align-items:center;justify-content:center;font-size:14px;">ज्यो</span>
				<span><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
			</a>
			<div class="top-links">
				<a href="https://wa.me/<?php echo esc_attr( $whatsapp ); ?>"><i class="fab fa-whatsapp wa-icon"></i> <?php esc_html_e( 'Whatsapp', 'bhagyarekha' ); ?></a>
				<a href="tel:+91<?php echo esc_attr( preg_replace( '/\D/', '', $phone ) ); ?>"><i class="fas fa-phone"></i> <?php esc_html_e( 'Call Us', 'bhagyarekha' ); ?></a>
				<a href="<?php echo esc_url( $maps_url ); ?>"><i class="fas fa-map-marker-alt"></i> <?php esc_html_e( 'Direction', 'bhagyarekha' ); ?></a>
				<a href="tel:+91<?php echo esc_attr( preg_replace( '/\D/', '', $phone ) ); ?>"><i class="fas fa-phone-alt"></i> <?php esc_html_e( 'Request a call', 'bhagyarekha' ); ?></a>
			</div>
		</div>
	</div>

	<header class="site-header">
		<div class="header-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
				<span class="logo-icon"><i class="fas fa-om"></i></span>
				<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
			</a>
			<button class="menu-toggle" aria-label="<?php esc_attr_e( 'Toggle menu', 'bhagyarekha' ); ?>"><i class="fas fa-bars"></i></button>
			<nav class="main-navigation">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_class'     => 'nav-menu',
					'container'      => false,
					'fallback_cb'    => 'bhagyarekha_fallback_menu',
				) );
				?>
			</nav>
			<div class="header-phone-btn">
				<span class="header-phone"><?php echo esc_html( $phone ); ?></span>
				<a href="tel:+91<?php echo esc_attr( preg_replace( '/\D/', '', $phone ) ); ?>" class="btn-call"><?php esc_html_e( 'Request a call', 'bhagyarekha' ); ?></a>
			</div>
		</div>
	</header>
<?php endif; ?>
