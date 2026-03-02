<?php
/**
 * Demo Import for Bhagyarekha Theme
 *
 * @package Bhagyarekha
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add admin menu for demo import
 */
function bhagyarekha_import_menu() {
	add_theme_page(
		__( 'Import Demo', 'bhagyarekha' ),
		__( 'Import Demo', 'bhagyarekha' ),
		'manage_options',
		'bhagyarekha-import',
		'bhagyarekha_import_page'
	);
}
add_action( 'admin_menu', 'bhagyarekha_import_menu' );

/**
 * Import page content
 */
function bhagyarekha_import_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( isset( $_POST['bhagyarekha_import_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bhagyarekha_import_nonce'] ) ), 'bhagyarekha_import' ) ) {
		bhagyarekha_do_import();
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Bhagyarekha - Import Demo Content', 'bhagyarekha' ); ?></h1>
		<div class="notice notice-success">
			<p><strong><?php esc_html_e( 'One-Click Import:', 'bhagyarekha' ); ?></strong> <?php esc_html_e( 'All pages will be created with full pre-built content. No Elementor required.', 'bhagyarekha' ); ?></p>
		</div>

		<div class="card" style="max-width: 600px; padding: 20px; margin-top: 20px;">
			<h2><?php esc_html_e( 'One-Click Import', 'bhagyarekha' ); ?></h2>
			<p><?php esc_html_e( 'This will create:', 'bhagyarekha' ); ?></p>
			<ul style="list-style: disc; margin-left: 20px;">
				<li><?php esc_html_e( 'Home, About, Services, Gallery, Contact pages with full content', 'bhagyarekha' ); ?></li>
				<li><?php esc_html_e( 'Primary menu with navigation links', 'bhagyarekha' ); ?></li>
				<li><?php esc_html_e( 'Pre-built design templates (Hero, Services, Testimonials, etc.)', 'bhagyarekha' ); ?></li>
				<li><?php esc_html_e( 'Set Home page as front page', 'bhagyarekha' ); ?></li>
			</ul>
			<form method="post" style="margin-top: 20px;">
				<?php wp_nonce_field( 'bhagyarekha_import', 'bhagyarekha_import_nonce' ); ?>
				<button type="submit" class="button button-primary button-hero">
					<?php esc_html_e( 'Import Demo Content', 'bhagyarekha' ); ?>
				</button>
			</form>
		</div>

		<div class="card" style="max-width: 600px; padding: 20px; margin-top: 20px;">
			<h2><?php esc_html_e( 'After Import', 'bhagyarekha' ); ?></h2>
			<p><?php esc_html_e( 'All pages will have full content. You can edit any page with Elementor (if installed) or use the default WordPress editor. Customize contact info from Appearance > Customize > Contact Info.', 'bhagyarekha' ); ?></p>
		</div>
	</div>
	<?php
}

/**
 * Execute import
 */
function bhagyarekha_do_import() {
	$pages = array(
		'home' => array(
			'title'    => 'Home',
			'content'  => '',
			'template' => 'elementor_canvas',
		),
		'about' => array(
			'title'    => 'About Us',
			'content'  => '',
			'template' => 'elementor_canvas',
		),
		'services' => array(
			'title'    => 'Our Service',
			'content'  => '',
			'template' => 'elementor_canvas',
		),
		'gallery' => array(
			'title'    => 'Gallery',
			'content'  => '',
			'template' => 'elementor_canvas',
		),
		'contact' => array(
			'title'    => 'Contact Us',
			'content'  => '',
			'template' => 'elementor_canvas',
		),
	);

	$menu_items = array();
	$created_pages = array();

	$templates = array(
		'home'     => 'page-templates/template-full-design.php',
		'about'    => 'page-templates/template-about.php',
		'services' => 'page-templates/template-services.php',
		'gallery'  => 'page-templates/template-gallery.php',
		'contact'  => 'page-templates/template-contact.php',
	);

	foreach ( $pages as $slug => $page_data ) {
		$slug_check = get_page_by_path( $slug );
		if ( $slug_check ) {
			$created_pages[ $slug ] = $slug_check->ID;
			// Update template for existing pages (fix for content not showing)
			if ( isset( $templates[ $slug ] ) ) {
				update_post_meta( $slug_check->ID, '_wp_page_template', $templates[ $slug ] );
			}
			continue;
		}

		$page_id = wp_insert_post( array(
			'post_title'   => $page_data['title'],
			'post_name'    => $slug,
			'post_content' => $page_data['content'],
			'post_status'  => 'publish',
			'post_type'   => 'page',
			'post_author'  => get_current_user_id(),
		) );

		if ( $page_id && ! is_wp_error( $page_id ) ) {
			$created_pages[ $slug ] = $page_id;
			if ( isset( $templates[ $slug ] ) ) {
				update_post_meta( $page_id, '_wp_page_template', $templates[ $slug ] );
			}
		}
	}

	// Create menu
	$menu_name = 'Primary Menu';
	$menu_exists = wp_get_nav_menu_object( $menu_name );

	if ( ! $menu_exists ) {
		$menu_id = wp_create_nav_menu( $menu_name );

		$menu_order = array( 'home', 'about', 'services', 'gallery', 'contact' );
		$position = 0;
		foreach ( $menu_order as $slug ) {
			if ( isset( $created_pages[ $slug ] ) ) {
				wp_update_nav_menu_item( $menu_id, 0, array(
					'menu-item-title'     => $pages[ $slug ]['title'],
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $created_pages[ $slug ],
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
					'menu-item-position'  => $position++,
				) );
			}
		}

		$locations = get_theme_mod( 'nav_menu_locations' );
		$locations['primary'] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	// Set front page
	if ( isset( $created_pages['home'] ) ) {
		update_option( 'page_on_front', $created_pages['home'] );
		update_option( 'show_on_front', 'page' );
	}

	// Set site title
	update_option( 'blogname', 'Ganapati Jyotish Sodh Sadan' );
	update_option( 'blogdescription', 'Jyotisacharya Rajkishor Tiwari - Gold Medalist Astrologer' );

	add_action( 'admin_notices', function() {
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Demo content imported successfully!', 'bhagyarekha' ) . '</p></div>';
	} );
}
