<?php
/**
 * Title: Sidebar Navigation
 * Slug: utkwds/sidebar-navigation
 * Description: Use this pattern to place a dynamic sidebar menu onto pages that aren’t included in the main navigation at the top of your site.
 * Categories: links
 * Keywords: sidebar, navigation, columns, secondary
 * Viewport Width: 1500
 * Block Types:
 * Post Types:
 * Inserter: true
 *
 * @package utkwds
 */

?>

<!-- wp:columns {"metadata":{"name":"Sidebar Navigation"},"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|medium"},"margin":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium"}}},"className":"utkwds-sidebar-navigation is-style-columns-reverse"} -->
<div
	class="wp-block-columns utkwds-sidebar-navigation is-style-columns-reverse"
	style="
		margin-top: var( --wp--preset--spacing--medium );
		margin-bottom: var( --wp--preset--spacing--medium );
	"
>
	<!-- wp:column {"width":"66.6%","layout":{"type":"constrained","justifyContent":"left"}} -->
	<div class="wp-block-column" style="flex-basis: 66.6%">
		<!-- wp:paragraph {"className":"is-style-utkwds-paragraph-large"} -->
		<p class="is-style-utkwds-paragraph-large">
			For pages at level three and below in your site structure, use the
			Sidebar Navigation pattern as the first block at the top.
		</p>
		<!-- /wp:paragraph -->

		<!-- wp:heading -->
		<h2 class="wp-block-heading">How it works</h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph -->
		<p>
			This will place a dynamic sidebar menu onto the page to make sure
			users can access pages that aren't included in the top-of-site menu.
			The Sidebar Navigation pattern populates based on the structure you
			assign to each page in the “Parent” field, either inside the Page
			settings menu when creating or editing the page, or from the Quick
			Edit in the All Pages view of the dashboard.
		</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->

	<!-- wp:column {"width":"33.3%","layout":{"type":"constrained"}} -->
	<div class="wp-block-column" style="flex-basis: 33.3%">
		<!-- wp:utkwds/secondary-navigation /-->
	</div>
	<!-- /wp:column -->
</div>
<!-- /wp:columns -->
