<?php
/**
 * Title: Contact single Smokey
 * Slug: utkwds/contact-single-smokey
 * Description: A pattern used to display the name, organizational role, email address, phone number, and/or current photograph of members of a campus department. Each card is bordered on top with a thin orange line. Contact cards may be appear alone or in rows of two cards each.
 * Categories: contact-cards
 * Keywords: contact card, card, image, email, Smokey, profile, bio
 * Viewport Width: 500
 * Block Types:
 * Post Types:
 * Inserter: true
 *
 * @package utkwds
 */

?>

<!-- wp:group {"metadata":{"name":"Contact single Smokey"},"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"backgroundColor":"smokey","textColor":"white","className":"utkwds-contact-single","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left"}} -->
<div class="wp-block-group utkwds-contact-single has-white-color has-smokey-background-color has-text-color has-background has-link-color"><!-- wp:image -->
<figure class="wp-block-image"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/person-placeholder.jpeg' ) ); ?>" alt="person placeholder"/></figure>
<!-- /wp:image -->

<!-- wp:group {"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:group {"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3,"textColor":"white"} -->
<h3 class="wp-block-heading has-white-color has-text-color">Heading</h3>
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
