<?php
/**
 * Title: Split Hero
 * Slug: utkwds/hero-split
 * Description: A split media and content pattern—with space to fill the top header area of a high-level or landing page.
 * Categories: hero
 * Keywords: full-width, full width, header, hero, image, large image, single image, link, CTA, CTA link, cover, title
 * Viewport Width: 1500
 * Inserter: true
 *
 * @package utkwds
 */

?>

<!-- wp:group {"metadata":{"name":"Split Hero"},"align":"full","className":"utkwds-hero-split","layout":{"type":"constrained"}} -->
<div class="wp-block-group utkwds-hero-split alignfull"><!-- wp:media-text {"align":"wide","mediaLink":"<?php echo esc_html( get_stylesheet_directory_uri() ); ?>/assets/images/repeat-placeholder-1700x700.jpg","mediaType":"image"} -->
<div class="wp-block-media-text alignwide is-stacked-on-mobile"><figure class="wp-block-media-text__media"><img src="<?php echo esc_html( get_stylesheet_directory_uri() ); ?>/assets/images/repeat-placeholder-1700x700.jpg" /></figure><div class="wp-block-media-text__content"><!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"utkwds-superhead"} -->
<p class="utkwds-superhead">Optional superheading</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Heading Goes here</h1>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:paragraph -->
<p>Paragraph 25 words or fewer. Use to orient users or unblock any barriers that would keep them from clicking a CTA link.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"is-style-utkwds-cta-link"} -->
<p class="is-style-utkwds-cta-link"><a href="https://www.utk.edu/">Optional CTA Link</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div></div>
<!-- /wp:media-text --></div>
<!-- /wp:group -->