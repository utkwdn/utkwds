<?php
/**
 * Title: Contact 2up white on Smokey
 * Slug: utkwds/contact-2up-white-smokey
 * Description: A pattern used to display the name, organizational role, email address, phone number, and/or current photograph of members of a campus department. Each card is bordered on top with a thin orange line. Two white cards, side by side, on Smokey background.
 * Categories: contact-cards
 * Keywords: profile, bio, contact card, card, image, email, white
 * Viewport Width: 1500
 * Block Types:
 * Post Types:
 * Inserter: true
 */

?>

<!-- wp:group {"align":"full","backgroundColor":"smokey","layout":{"type":"constrained"},"metadata":{"name":"Contact 2up white on Smokey"}} -->
<div
	class="wp-block-group alignfull has-smokey-background-color has-background"
>
	<!-- wp:group {"className":"utkwds-contact-2up","layout":{"type":"constrained"}} -->
	<div class="wp-block-group utkwds-contact-2up">
		<!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"white"} -->
		<h2
			class="wp-block-heading has-white-color has-text-color has-link-color"
		>
			Contact 2up white on Smokey
		</h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"white"} -->
		<p class="has-white-color has-text-color has-link-color">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
			gravida dui a aliquet egestas. Class aptent taciti sociosqu ad
			litora torquent per conubia nostra
		</p>
		<!-- /wp:paragraph -->

		<!-- wp:columns -->
		<div class="wp-block-columns">
			<!-- wp:column -->
			<div class="wp-block-column">
				<!-- wp:pattern {"slug":"utkwds/contact-single-white"} /-->
			</div>
			<!-- /wp:column -->

			<!-- wp:column -->
			<div class="wp-block-column">
				<!-- wp:pattern {"slug":"utkwds/contact-single-white"} /-->
			</div>
			<!-- /wp:column -->
		</div>
		<!-- /wp:columns -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
