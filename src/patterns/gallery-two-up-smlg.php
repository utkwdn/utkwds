<?php
/**
 * Title: Gallery Two Up Small Large
 * Slug: utkwds/gallery-two-up-smlg
 * Categories: galleries
 * Keywords: gallery, image, orange
 * Inserter: false
 * Viewport Width: 1500
 */

?>

<!-- wp:cover {"dimRatio":0,"isDark":false,"align":"full","className":"twoUp-gallery-smlg"} -->
<div class="wp-block-cover alignfull is-light twoUp-gallery-smlg">
	<span
		aria-hidden="true"
		class="wp-block-cover__background has-background-dim-0 has-background-dim"
	></span>
	<div class="wp-block-cover__inner-container">
		<!-- wp:group {"className":"twoUp-gallery ","layout":{"inherit":false}} -->
		<div class="wp-block-group twoUp-gallery">
			<!-- wp:columns -->
			<div class="wp-block-columns">
				<!-- wp:column {"verticalAlignment":"bottom","width":"40%"} -->
				<div
					class="wp-block-column is-vertically-aligned-bottom"
					style="flex-basis: 40%"
				>
					<!-- wp:image {"align":"left","sizeSlug":"full","linkDestination":"none","className":"twoUp-gallery-img-sm"} -->
					<figure
						class="wp-block-image alignleft size-full twoUp-gallery-img-sm"
					>
						<img
							src="<?php echo esc_url( get_theme_file_uri( 'assets/images/image-placeholder-large.png' ) ); ?>"
							alt="image placeholder"
						/>
					</figure>
					<!-- /wp:image -->
				</div>
				<!-- /wp:column -->

				<!-- wp:column {"verticalAlignment":"bottom","width":"60%"} -->
				<div
					class="wp-block-column is-vertically-aligned-bottom"
					style="flex-basis: 60%"
				>
					<!-- wp:image {"align":"right","sizeSlug":"large","linkDestination":"none","className":"twoUp-gallery-img-lg clipCorner-tl"} -->
					<figure
						class="wp-block-image alignright size-large twoUp-gallery-img-lg clipCorner-tl"
					>
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
