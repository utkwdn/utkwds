<?php
/**
 * Title: Subject 2up white
 * Slug: utkwds/subject-2up-white
 * Description: Two Image & Subject cards, side-by-side, on a white background with a surrounding light gray background.
 * Categories: content-cards
 * Keywords: image, multiple images, links, white
 * Viewport Width: 1500
 * Block Types:
 * Post Types:
 * Inserter: true
 *
 * @package utkwds
 */

?>

<!-- wp:group {"align":"full","backgroundColor":"light","layout":{"type":"constrained"},"metadata":{"name":"Subject 2up white"}} -->
<div class="wp-block-group alignfull has-light-background-color has-background">
	<!-- wp:columns {"className":"utkwds-subject-2up"} -->
	<div class="wp-block-columns utkwds-subject-2up">
		<!-- wp:column {"backgroundColor":"white"} -->
		<div class="wp-block-column has-white-background-color has-background">
			<!-- wp:pattern {"slug":"utkwds/subject-white"} /-->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"backgroundColor":"white"} -->
		<div class="wp-block-column has-white-background-color has-background">
			<!-- wp:pattern {"slug":"utkwds/subject-white"} /-->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
