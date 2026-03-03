<?php
/**
 * Title: Full-Width Hero
 * Slug: utkwds/hero-full-width
 * Description: A full-width pattern—with space for a large, dramatic photo—designed to fill the top header area of a high-level or landing page. The text area has a white background that overlaps the photo as well as the edges of the first item placed below it on a page. There is an orange bar beneath this pattern.
 * Categories: hero
 * Keywords: full-width, full width, header, hero, image, large image, single image, link, CTA, CTA link, cover, title
 * Viewport Width: 1500
 * Inserter: true
 *
 * @package utkwds
 */

?>

<!-- wp:group {"metadata":{"name":"Full-Width Hero"},"align":"full","className":"utkwds-hero-full-width","layout":{"type":"constrained"}} -->
<div class="wp-block-group utkwds-hero-full-width alignfull"><!-- wp:cover {"url":"<?php echo esc_html( get_stylesheet_directory_uri() ); ?>/assets/images/repeat-placeholder-1700x700.jpg","dimRatio":0,"isUserOverlayColor":true,"minHeight":30,"minHeightUnit":"vh","contentPosition":"bottom center","align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-cover utkwds-hero-full-width-image alignfull has-custom-content-position is-position-bottom-center" style="min-height:30vh"><img class="wp-block-cover__image-background" src="<?php echo esc_html( get_stylesheet_directory_uri() ); ?>/assets/images/repeat-placeholder-1700x700.jpg" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph -->
<p></p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover -->

<!-- wp:pattern {"slug":"utkwds/orange-bar"} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"backgroundColor":"white","textColor":"smokey","layout":{"type":"constrained"}} -->
<div class="wp-block-group utkwds-hero-full-width-content has-smokey-color has-white-background-color has-text-color has-background"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xx-small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"metadata":{"name":"Superhead"},"className":"utkwds-superhead"} -->
<p class="utkwds-superhead">Optional superheading</p>
<!-- /wp:paragraph -->

<!-- wp:post-title {"level":1,"style":{"typography":{"textTransform":"uppercase"}}} /--></div>
<!-- /wp:group -->

<!-- wp:paragraph -->
<p><strong>Optional subheading</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Paragraph 25 words or fewer. Use to orient users or unblock any barriers that would keep them from clicking a CTA link.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"is-style-utkwds-cta-link"} -->
<p class="is-style-utkwds-cta-link"><a href="https://www.utk.edu/">Optional CTA Link</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
