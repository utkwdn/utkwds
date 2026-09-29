<?php
/**
 * Title: Single post featured image from customizer.
 * Slug: utkwds/single-featured-image
 * Inserter: false
 *
 * @package utkwds
 */

?>

<?php

if ( get_theme_mod( 'show_featured_image' ) !== 'show' ) {
	return;
}

?>

<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
	<!-- wp:post-featured-image /-->
</div>
<!-- /wp:group -->
