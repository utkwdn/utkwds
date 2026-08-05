<?php
/**
 * Title: Contact single large image light gray
 * Slug: utkwds/contact-single-large-image-light-gray
 * Description: A pattern used to display the name, organizational role, email address, phone number, and/or current photograph of members of a campus department. Each card is bordered on top with a thin orange line.
 * Categories: contact-cards
 * Keywords: contact card, card, image, email, light gray, profile, bio
 * Viewport Width: 500
 * Block Types:
 * Post Types:
 * Inserter: true
 *
 * @package utkwds
 */

?>

<!-- wp:group {"metadata":{"name":"Contact single large image light gray","categories":["contact-cards"],"patternName":"utkwds/contact-single-large-image-light-gray"},"className":"utkwds-contact-single utkwds-contact-single--large","backgroundColor":"light","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left"}} -->
<div class="wp-block-group utkwds-contact-single utkwds-contact-single--large has-light-background-color has-background"><!-- wp:image -->
<figure class="wp-block-image"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/person-placeholder.jpeg' ) ); ?>" alt="person placeholder"/></figure>
<!-- /wp:image -->

<!-- wp:group {"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:group {"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Heading</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Title</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:paragraph -->
<p><a href="tel:+18659741234">865-974-1234</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"utkwds-cta-link"} -->
<p class="utkwds-cta-link"><a href="mailto:email@utk.edu">email@utk.edu</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"is-style-utkwds-single-link"} -->
<p class="is-style-utkwds-single-link"><a href="#">View Profile</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
