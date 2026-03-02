<?php
/**
 * Page content template
 *
 * @package Bhagyarekha
 */

?>
<main id="primary" class="site-main">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="page-hero">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header>
		<div class="entry-content" style="max-width: 1200px; margin: 0 auto; padding: 70px 20px;">
			<?php the_content(); ?>
		</div>
	</article>
</main>
