<?php
/**
 * Bhagyarekha Theme Functions and Definitions
 *
 * @package Bhagyarekha
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BHAGYAREKHA_VERSION', '1.0.0' );
define( 'BHAGYAREKHA_DIR', get_template_directory() );
define( 'BHAGYAREKHA_URI', get_template_directory_uri() );

/**
 * Theme Setup
 */
function bhagyarekha_setup() {
	load_theme_textdomain( 'bhagyarekha', BHAGYAREKHA_DIR . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 400,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );

	register_nav_menus( array(
		'primary'   => __( 'Primary Menu', 'bhagyarekha' ),
		'top-bar'   => __( 'Top Bar Menu', 'bhagyarekha' ),
		'footer'    => __( 'Footer Menu', 'bhagyarekha' ),
	) );
}
add_action( 'after_setup_theme', 'bhagyarekha_setup' );

/**
 * Enqueue Scripts and Styles
 */
function bhagyarekha_scripts() {
	wp_enqueue_style(
		'bhagyarekha-google-fonts',
		'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Source+Sans+3:wght@300;400;500;600;700&display=swap',
		array(),
		null
	);
	wp_enqueue_style(
		'font-awesome',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
		array(),
		'6.4.0'
	);
	wp_enqueue_style(
		'bhagyarekha-main',
		BHAGYAREKHA_URI . '/assets/css/styles.css',
		array(),
		BHAGYAREKHA_VERSION
	);

	wp_enqueue_script(
		'bhagyarekha-main',
		BHAGYAREKHA_URI . '/assets/js/main.js',
		array( 'jquery' ),
		BHAGYAREKHA_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'bhagyarekha_scripts' );

/**
 * Elementor Support
 */
function bhagyarekha_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_all_core_location();
}
add_action( 'elementor/theme/register_locations', 'bhagyarekha_register_elementor_locations' );

/**
 * Register Elementor Locations for theme
 */
function bhagyarekha_elementor_support() {
	add_theme_support( 'elementor' );
	add_theme_support( 'elementor-header-footer' );
}
add_action( 'after_setup_theme', 'bhagyarekha_elementor_support' );

/**
 * Content Width
 */
function bhagyarekha_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bhagyarekha_content_width', 1200 );
}
add_action( 'after_setup_theme', 'bhagyarekha_content_width', 0 );

/**
 * Widget Areas
 */
function bhagyarekha_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer 1', 'bhagyarekha' ),
		'id'            => 'footer-1',
		'description'   => __( 'Footer column 1', 'bhagyarekha' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 2', 'bhagyarekha' ),
		'id'            => 'footer-2',
		'description'   => __( 'Footer column 2 - Quick Links', 'bhagyarekha' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 3', 'bhagyarekha' ),
		'id'            => 'footer-3',
		'description'   => __( 'Footer column 3 - Contact', 'bhagyarekha' ),
		'before_widget' => '<div id="%1$s" class="widget footer-contact %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'bhagyarekha_widgets_init' );

/**
 * Customizer settings for theme options
 */
function bhagyarekha_customize_register( $wp_customize ) {
	// Phone Number
	$wp_customize->add_section( 'bhagyarekha_contact', array(
		'title'    => __( 'Contact Info', 'bhagyarekha' ),
		'priority' => 30,
	) );
	$wp_customize->add_setting( 'bhagyarekha_phone', array(
		'default'           => '09452884067',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bhagyarekha_phone', array(
		'label'   => __( 'Phone Number', 'bhagyarekha' ),
		'section' => 'bhagyarekha_contact',
		'type'    => 'text',
	) );
	$wp_customize->add_setting( 'bhagyarekha_whatsapp', array(
		'default'           => '919452884067',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bhagyarekha_whatsapp', array(
		'label'   => __( 'WhatsApp Number (with country code, no +)', 'bhagyarekha' ),
		'section' => 'bhagyarekha_contact',
		'type'    => 'text',
	) );
}
add_action( 'customize_register', 'bhagyarekha_customize_register' );

/**
 * Include theme files
 */
require_once BHAGYAREKHA_DIR . '/inc/template-tags.php';
require_once BHAGYAREKHA_DIR . '/inc/demo-import.php';
