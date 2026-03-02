/**
 * Bhagyarekha Theme - Main JavaScript
 */
(function($) {
	'use strict';

	// Mobile menu toggle
	$('.menu-toggle').on('click', function() {
		$('.nav-menu, .main-navigation ul').toggleClass('active');
	});

})(jQuery);
