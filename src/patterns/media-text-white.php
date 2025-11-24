<?php
/**
 * Title: Media & text white
 * Slug: utkwds/media-text-white
 * Description: A full width half-and-half (50/50) pattern split equally between image or video and text, on a white background. Bordered on top with a thin orange line. Options for text formatting include: heading, paragraph, lists, and links.
 * Categories: banners
 * Keywords: banner, image, single image, media, text, paragraph, list, links, white, 50/50
 * Viewport Width: 1500
 * Block Types:
 * Post Types:
 * Inserter: true
 *
 * @package utkwds
 */

?>

<!-- wp:media-text {"align":"full","mediaType":"image","metadata":{"name":"Media \u0026 text white"},"backgroundColor":"white","className":"utkwds-media-text"} -->
<div
	class="wp-block-media-text alignfull is-stacked-on-mobile utkwds-media-text has-white-background-color has-background"
>
	<figure class="wp-block-media-text__media">
		<img
			src="<?php echo esc_url( get_theme_file_uri( 'assets/images/image-placeholder-large.png' ) ); ?>"
			alt="image placeholder"
		/>
	</figure>
	<div class="wp-block-media-text__content">
		<!-- wp:heading -->
		<h2 class="wp-block-heading">Heading</h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph -->
		<p>
			This pattern can be used to set important information apart from the
			rest of the page and/or collect links related to a single subject.
		</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"className":"is-style-utkwds-single-link"} -->
		<p class="is-style-utkwds-single-link">
			<a href="https://www.utk.edu/">Single Link</a>
		</p>
		<!-- /wp:paragraph -->
	</div>
</div>
<!-- /wp:media-text -->
