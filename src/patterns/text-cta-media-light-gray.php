<?php
/**
 * Title: Text with CTA & media light gray
 * Slug: utkwds/text-cta-media-light-gray
 * Description: A full-width pattern designed to fill the hero or header area of a high-level or landing page. Contains an image, title, summary text, and call-to-action link. Large media has an offset orange background.
 * Categories: hero
 * Keywords: full-width, full width, hero, header, image, single image, media, text, CTA link, light gray
 * Viewport Width: 1500
 * Block Types:
 * Post Types:
 * Inserter: true
 *
 * @package utkwds
 */

?>

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|small","right":"var:preset|spacing|small","bottom":"var:preset|spacing|small","left":"var:preset|spacing|small"}}},"backgroundColor":"light","className":"utkwds-text-cta-media","layout":{"type":"constrained"},"metadata":{"name":"Text with CTA \u0026 media light gray"}} -->
<div class="wp-block-group alignfull utkwds-text-cta-media has-light-background-color has-background" style="padding-top:var(--wp--preset--spacing--small);padding-right:var(--wp--preset--spacing--small);padding-bottom:var(--wp--preset--spacing--small);padding-left:var(--wp--preset--spacing--small)"><!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"style":{"spacing":{"blockGap":"var:preset|spacing|small"}}} -->
<div class="wp-block-column"><!-- wp:heading -->
<h2 class="wp-block-heading">Heading</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>The Text with CTA & media pattern is designed to fill the hero area of a high-level landing page, to orient users to what your page is about.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"is-style-utkwds-cta-link"} -->
<p class="is-style-utkwds-cta-link"><a href="https://www.utk.edu/">CTA Link</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"linkDestination":"none","className":"is-style-utkwds-left-frame"} -->
<figure class="wp-block-image is-style-utkwds-left-frame"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/image-placeholder-large.png') );?>" alt="image placeholder"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
