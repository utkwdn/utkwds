<?php
/**
 * Title: Full-Width Hero
 * Slug: utkwds/full-width-hero
 * Description: A full-width pattern—with space for a large, dramatic photo—designed to fill the top header area of a high-level or landing page. The text area has a white background that overlaps the photo as well as the edges of the first item placed below it on a page. There is a textured orange bar beneath this pattern.
 * Categories: hero
 * Keywords: full-width, full width, header, hero, image, large image, single image, link, CTA, CTA link, cover, title
 * Viewport Width: 1500
 * Template Types: blank, no-title, no-title-or-breadcrumbs
 * Inserter: true
 */

?>
<!-- wp:group {"metadata":{"name":"Full-Width Hero"},"align":"full","className":"utkwds-full-width-hero","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull utkwds-full-width-hero"><!-- wp:cover {"url":"<?php echo get_stylesheet_directory_uri(); ?>/assets/images/repeat-placeholder-1700x700.jpg","dimRatio":0,"isUserOverlayColor":true,"minHeight":60,"minHeightUnit":"vh","contentPosition":"bottom center","align":"full","style":{"dimensions":{"aspectRatio":"16/9"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull has-custom-content-position is-position-bottom-center" style="min-height:60vh"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><img class="wp-block-cover__image-background" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/repeat-placeholder-1700x700.jpg" alt="Repeat Placeholder" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|small"}},"backgroundColor":"white","textColor":"smokey","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-smokey-color has-white-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--medium)">
  
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xx-small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
  <!-- wp:paragraph {"metadata":{"name":"Superhead"},"className":"utkwds-superhead","style":{"typography":{"textTransform":"uppercase","fontStyle":"italic","fontWeight":"400","lineHeight":"1.1"}},"fontSize":"medium","fontFamily":"condensed"} -->
<p class="utkwds-superhead has-condensed-font-family has-medium-font-size" style="font-style:italic;font-weight:400;line-height:1.1;text-transform:uppercase">Optional superheading</p>
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
<!-- /wp:group --></div></div>
<!-- /wp:cover -->

<!-- wp:pattern {"slug":"utkwds/orange-bar-texture"} /-->

</div>
<!-- /wp:group -->

<!-- wp:paragraph -->
<p></p>
<!-- /wp:paragraph -->