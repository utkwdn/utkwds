<?php
/**
 * Title: Single post tags.
 * Slug: utkwds/single-tags
 * Inserter: false
 *
 * @package utkwds
 */

if ( ! has_tag() ) {
	return;
}
?>

<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
	<!-- wp:group {"className":"utkwds-single-meta-section","layout":{"type":"constrained"}} -->
	<div class="wp-block-group utkwds-single-meta-section">
		<!-- wp:paragraph {"className":"utkwds-single-meta-label"} -->
		<p class="utkwds-single-meta-label">See more on:</p>
		<!-- /wp:paragraph -->
		<!-- wp:post-terms {"term":"post_tag"} /-->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
