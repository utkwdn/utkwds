<?php
/**
 * Title: Contact single white
 * Slug: utkwds/contact-single-white
 * Description:
 * Categories: contact-cards
 * Keywords: profile, card, bio, white
 * Viewport Width: 500
 * Block Types:
 * Post Types:
 * Inserter: false
 */

?>

<!-- wp:group {"metadata":{"name":"Contact single white"},"backgroundColor":"white","textColor":"smokey","className":"utkwds-contact-single","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left"}} -->
<div
	class="wp-block-group utkwds-contact-single has-smokey-color has-white-background-color has-text-color has-background"
>
	<!-- wp:image -->
	<figure class="wp-block-image">
		<img
			src="<?php echo esc_url( get_theme_file_uri( 'assets/images/person-placeholder.jpeg' ) ); ?>"
			alt="person placeholder"
		/>
	</figure>
	<!-- /wp:image -->

	<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"top"}} -->
	<div class="wp-block-group">
		<!-- wp:heading {"level":3,"textColor":"smokey"} -->
		<h3 class="wp-block-heading has-smokey-color has-text-color">
			Heading
		</h3>
		<!-- /wp:heading -->

		<!-- wp:separator {"className":"is-style-utkwds-orange-separator"} -->
		<hr
			class="wp-block-separator has-alpha-channel-opacity is-style-utkwds-orange-separator"
		/>
		<!-- /wp:separator -->

		<!-- wp:paragraph {"fontSize":"x-small"} -->
		<p class="has-x-small-font-size">Title</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"fontSize":"x-small"} -->
		<p class="has-x-small-font-size">Phone</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"className":"utkwds-cta-link","fontSize":"x-small"} -->
		<p class="utkwds-cta-link has-x-small-font-size">
			<a href="mailto:email@utk.edu">email@utk.edu</a>
		</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
