<?php
/**
 * Title: Image & text light gray
 * Slug: utkwds/image-text-light-gray
 * Description: A full-width pattern featuring a left-aligned image and a text area that is wider than the image. Includes a call-to-action link to direct users to additional information. 
 * Categories: banners
 * Keywords: single image, CTA, content, light gray, information, banner
 * Viewport Width: 1500
 * Block Types: 
 * Post Types: 
 * Inserter: true
 */

?>

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","right":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|60"}}},"backgroundColor":"light","className":"utkwds-image-text","layout":{"type":"constrained"},"metadata":{"name":"Image \u0026 text light gray"}} -->
<div class="wp-block-group alignfull utkwds-image-text has-light-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--60)"><!-- wp:columns {"verticalAlignment":null} -->
<div class="wp-block-columns">
  
<!-- wp:column {"verticalAlignment":"top","width":"30%"} -->
<div class="wp-block-column is-vertically-aligned-top" style="flex-basis:30%">

<!-- wp:image {"align":"center","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image aligncenter size-full"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/image-placeholder-small-square.png') );?>" alt="image placeholder"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"70%"} -->
<div class="wp-block-column" style="flex-basis:70%"><!-- wp:heading -->
<h2 class="wp-block-heading"></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec gravida dui a aliquet egestas. Class aptent taciti sociosqu ad litora torquent per conubia nostra</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"is-style-utkwds-cta-link"} -->
<p class="is-style-utkwds-cta-link"><a href="https://www.utk.edu/">CTA Link</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->