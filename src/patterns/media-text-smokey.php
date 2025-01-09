<?php
/**
 * Title: Media & text Smokey
 * Slug: utkwds/media-text-smokey
 * Description: A full width half-and-half (50/50) pattern split equally between image or video and text, on a Smokey background. Bordered on top with a thin orange line. Options for text formatting include: heading, paragraph, lists, and links. This component is intended for limited use on the page.
 * Categories: banners
 * Keywords: banner, image, single image, media, text, paragraph, list, links, smokey, 50/50
 * Viewport Width: 1500
 * Block Types: 
 * Post Types: 
 * Inserter: true
 */

?>

<!-- wp:media-text {"align":"full","mediaType":"image","metadata":{"name":"Media \u0026 text Smokey"},"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"backgroundColor":"smokey","textColor":"white","className":"utkwds-media-text is-style-smokey"} -->
<div class="wp-block-media-text alignfull is-stacked-on-mobile utkwds-media-text is-style-smokey has-white-color has-smokey-background-color has-text-color has-background has-link-color"><figure class="wp-block-media-text__media"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/image-placeholder-large.png') );?>" alt="image placeholder"/></figure><div class="wp-block-media-text__content"><!-- wp:heading {"textColor":"white"} -->
<h2 class="wp-block-heading has-white-color has-text-color">Heading</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>This pattern can be used to set important information apart from the rest of the page and/or collect links related to a single subject.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"is-style-utkwds-single-link"} -->
<p class="is-style-utkwds-single-link"><a href="https://www.utk.edu/">Single Link</a></p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:media-text -->