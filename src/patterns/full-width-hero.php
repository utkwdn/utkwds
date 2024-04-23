<?php
/**
 * Title: Full-Width Hero
 * Slug: utkwds/full-width-hero
 * Description: Bold, large-image page header
 * Categories: hero
 * Keywords: hero, cover, header, head, heading, title, full-width, full width, full bleed
 * Viewport Width: 1500
 * Block Types: 
 * Post Types: 
 * Inserter: true
 */

?>
<!-- wp:group {"metadata":{"name":"Full-Width Hero"},"align":"full","className":"utkwds-full-width-hero","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull utkwds-full-width-hero"><!-- wp:cover {"url":"<?php echo get_stylesheet_directory_uri(); ?>/assets/images/repeat-placeholder-2000x2000.png","dimRatio":0,"isUserOverlayColor":true,"minHeight":700,"contentPosition":"bottom center","align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull has-custom-content-position is-position-bottom-center" style="min-height:700px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><img class="wp-block-cover__image-background" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/repeat-placeholder-2000x2000.png" alt="Repeat Placeholder" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|small"}},"backgroundColor":"white","textColor":"smokey","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-smokey-color has-white-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|x-small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"metadata":{"name":"Superhead"},"style":{"typography":{"textTransform":"uppercase","fontStyle":"italic","fontWeight":"400","lineHeight":"0.9"}},"className":"utkwds-superhead","fontSize":"large","fontFamily":"condensed"} -->
<p class="utkwds-superhead has-condensed-font-family has-large-font-size" style="font-style:italic;font-weight:400;line-height:0.9;text-transform:uppercase">Optional superheading</p>
<!-- /wp:paragraph -->

<!-- wp:post-title {"level":1} /-->

<!-- wp:paragraph -->
<p><strong>Optional subheading</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Paragraph 25 words or fewer. Use to orient users or unblock any barriers that would keep them from clicking a CTA link.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"is-style-utkwds-fancy-link"} -->
<p class="is-style-utkwds-fancy-link"><a href="https://www.utk.edu/">Optional CTA Link</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->

<!-- wp:pattern {"slug":"utkwds/orange-bar-texture"} /-->

</div>
<!-- /wp:group -->