<?php
/**
 * Custom template tags for Bhagyarekha theme
 *
 * @package Bhagyarekha
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fallback menu when no menu is set
 */
function bhagyarekha_fallback_menu() {
	echo '<ul class="nav-menu">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'home', 'bhagyarekha' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/about' ) ) . '">' . esc_html__( 'About Us', 'bhagyarekha' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/services' ) ) . '">' . esc_html__( 'Our Service', 'bhagyarekha' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/gallery' ) ) . '">' . esc_html__( 'Gallery', 'bhagyarekha' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/contact' ) ) . '">' . esc_html__( 'contact us', 'bhagyarekha' ) . '</a></li>';
	echo '</ul>';
}

/**
 * Add current menu item class
 */
function bhagyarekha_nav_menu_css_class( $classes, $item ) {
	if ( in_array( 'current-menu-item', $classes, true ) ) {
		$classes[] = 'active';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'bhagyarekha_nav_menu_css_class', 10, 2 );
