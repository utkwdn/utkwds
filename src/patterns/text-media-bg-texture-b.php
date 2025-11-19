<?php
/**
 * Title: Text & media + bg texture B
 * Slug: utkwds/text-media-bg-texture-b
 * Description: This pattern collects an image, text, and a single link. Choose from three grayscale background images that add texture and visual interest to this pattern. The background image in Variation B is an aerial photo of campus.
 * Categories: banners
 * Keywords: campus, text, media, image, single image, light gray, campus, overhead, aerial, bridge
 * Viewport Width: 1500
 * Block Types:
 * Post Types:
 * Inserter: true
 *
 * @package utkwds
 */

?>

<!-- wp:cover {"url":"<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/campus_aerial_sky_bg_1.jpg","dimRatio":0,"focalPoint":{"x":0.5,"y":0},"contentPosition":"top center","isDark":false,"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","right":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|medium"}}},"className":"utkwds-text-media-bg-texture"} -->
<div
	class="wp-block-cover alignfull is-light has-custom-content-position is-position-top-center utkwds-text-media-bg-texture"
	style="
		padding-top: var( --wp--preset--spacing--medium );
		padding-right: var( --wp--preset--spacing--medium );
		padding-bottom: var( --wp--preset--spacing--medium );
		padding-left: var( --wp--preset--spacing--medium );
	"
>
	<span
		aria-hidden="true"
		class="wp-block-cover__background has-background-dim-0 has-background-dim"
	></span
	><img
		class="wp-block-cover__image-background"
		alt=""
		src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/campus_aerial_sky_bg_1.jpg"
		style="object-position: 50% 0%"
		data-object-fit="cover"
		data-object-position="50% 0%"
	/>
	<div class="wp-block-cover__inner-container">
		<!-- wp:group {"textColor":"smokey","layout":{"type":"constrained"}} -->
		<div class="wp-block-group has-smokey-color has-text-color">
			<!-- wp:columns {"align":"wide"} -->
			<div class="wp-block-columns alignwide">
				<!-- wp:column {"style":{"spacing":{"blockGap":"var:preset|spacing|small"}}} -->
				<div class="wp-block-column">
					<!-- wp:heading -->
					<h2 class="wp-block-heading">Heading</h2>
					<!-- /wp:heading -->

					<!-- wp:paragraph -->
					<p>
						This pattern can be used to set important information
						apart from the rest of the page and collect links
						related to a single subject. Works well positioned above
						a footer.
					</p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"className":"is-style-utkwds-single-link"} -->
					<p class="is-style-utkwds-single-link">
						<a href="https://www.utk.edu/">Single Link</a>
					</p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:column -->

				<!-- wp:column -->
				<div class="wp-block-column">
					<!-- wp:image {"linkDestination":"none","className":"is-style-utkwds-left-frame"} -->
					<figure class="wp-block-image is-style-utkwds-left-frame">
						<img
							src="<?php echo esc_url( get_theme_file_uri( 'assets/images/image-placeholder-large.png' ) ); ?>"
							alt="image placeholder"
						/>
					</figure>
					<!-- /wp:image -->
				</div>
				<!-- /wp:column -->
			</div>
			<!-- /wp:columns -->
		</div>
		<!-- /wp:group -->
	</div>
</div>
<!-- /wp:cover -->
