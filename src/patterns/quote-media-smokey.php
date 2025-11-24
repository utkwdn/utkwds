<?php
/**
 * Title: Quote & media Smokey
 * Slug: utkwds/quote-media-smokey
 * Description: Large, formatted quote indicated by an orange quotation mark and large text. Quote block with image on Smokey background.
 * Categories: quotes
 * Keywords: quote, image, smokey, 50/50, media
 * Viewport Width: 1500
 * Block Types:
 * Post Types:
 * Inserter: true
 *
 * @package utkwds
 */

?>

<!-- wp:media-text {"align":"wide","mediaPosition":"right","mediaType":"image","metadata":{"name":"Quote \u0026 media Smokey"},"backgroundColor":"smokey","className":"utkwds-media-quote"} -->
<div
	class="wp-block-media-text alignwide has-media-on-the-right is-stacked-on-mobile utkwds-media-quote has-smokey-background-color has-background"
>
	<div class="wp-block-media-text__content">
		<!-- wp:quote {"textColor":"white","className":"utkwds-quote is-style-default"} -->
		<blockquote
			class="wp-block-quote utkwds-quote is-style-default has-white-color has-text-color"
		>
			<!-- wp:paragraph -->
			<p>
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
				gravida dui a aliquet egestas. Class aptent taciti sociosqu ad
				litora torquent per conubia nostra
			</p>
			<!-- /wp:paragraph --><cite
				><span class="name">Person Name</span><br /><span class="title"
					>Title</span
				><br /><span class="college">Name of College</span></cite
			>
		</blockquote>
		<!-- /wp:quote -->
	</div>
	<figure class="wp-block-media-text__media">
		<img
			src="<?php echo esc_url( get_theme_file_uri( 'assets/images/image-placeholder-large.png' ) ); ?>"
			alt="image placeholder"
		/>
	</figure>
</div>
<!-- /wp:media-text -->
