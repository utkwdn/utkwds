<?php
/**
 * Title: Video & text with CTA white
 * Slug: utkwds/video-text-cta-white
 * Description: A full-width pattern designed to fill the hero or header area of a high-level or landing page. Contains a video, title, summary text, and call-to-action link. Large media has an offset orange background.
 * Categories: hero
 * Keywords: full-width, full width, hero, header, video, media, text, CTA link, white
 * Viewport Width: 1500
 * Block Types:
 * Post Types:
 * Inserter: true
 */

?>

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|small","right":"var:preset|spacing|small","bottom":"var:preset|spacing|small","left":"var:preset|spacing|small"}}},"className":"utkwds-media-text-cta","layout":{"type":"constrained"},"metadata":{"name":"Video \u0026 text with CTA white"}} -->
<div
	class="wp-block-group alignfull utkwds-media-text-cta"
	style="
		padding-top: var( --wp--preset--spacing--small );
		padding-right: var( --wp--preset--spacing--small );
		padding-bottom: var( --wp--preset--spacing--small );
		padding-left: var( --wp--preset--spacing--small );
	"
>
	<!-- wp:columns {"align":"wide"} -->
	<div class="wp-block-columns alignwide">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:embed {"providerNameSlug":"youtube","responsive":true,"className":"is-style-utkwds-left-frame wp-embed-aspect-16-9 wp-has-aspect-ratio"} /-->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"style":{"spacing":{"blockGap":"var:preset|spacing|small"}}} -->
		<div class="wp-block-column">
			<!-- wp:heading -->
			<h2 class="wp-block-heading">Heading</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>
				The Video & Text with CTA pattern is designed to fill the hero
				area of a high-level landing page, to orient users to what your
				page is about.
			</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"className":"is-style-utkwds-cta-link"} -->
			<p class="is-style-utkwds-cta-link">
				<a href="https://www.utk.edu/">CTA Link</a>
			</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
