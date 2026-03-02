<?php
/**
 * Page template
 *
 * @package Bhagyarekha
 */

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		if ( did_action( 'elementor/loaded' ) && class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->db->is_built_with_elementor( get_the_ID() ) ) {
			the_content();
		} else {
			get_template_part( 'template-parts/content', 'page' );
		}
	endwhile;
endif;

get_footer();
