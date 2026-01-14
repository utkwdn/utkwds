<?php
/**
 * Title: Contact single light gray
 * Slug: utkwds/contact-single-light-gray
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

<!-- wp:group {"metadata":{"name":"Contact single light gray"},"backgroundColor":"light","className":"utkwds-contact-single","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left"}} -->
<div class="wp-block-group utkwds-contact-single has-light-background-color has-background"><!-- wp:image -->
<figure class="wp-block-image"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/person-placeholder.jpeg') );?>" alt="person placeholder"/></figure>
<!-- /wp:image -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Heading</h3>
<!-- /wp:heading -->

<!-- wp:separator {"className":"is-style-utkwds-orange-separator"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-utkwds-orange-separator"/>
<!-- /wp:separator -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size">Title</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size">Phone</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"utkwds-cta-link","fontSize":"small"} -->
<p class="utkwds-cta-link has-small-font-size"><a href="mailto:email@utk.edu">email@utk.edu</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
