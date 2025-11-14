<?php
/**
 * Title: In-Page Notice
 * Slug: utkwds/in-page-notice
 * Description: For calling attention to deadlines or special instructions within the page content. Best for temporary use, and only once per page.
 * Categories: banners
 * Keywords: notice, alert, banner, box, deadline, callout, information
 * Viewport Width: 1500
 * Block Types:
 * Post Types:
 * Inserter: true
 */

?>

<!-- wp:group {"templateLock": "contentOnly","metadata":{"name":"In-Page Notice","categories":["banners"],"patternName":"utkwds/in-page-notice"},"className":"utkwds-in-page-notice","style":{"spacing":{"padding":{"top":"var:preset|spacing|small","bottom":"var:preset|spacing|small","left":"var:preset|spacing|small","right":"var:preset|spacing|small"},"margin":{"top":"var:preset|spacing|small","bottom":"var:preset|spacing|small"}},"border":{"width":"4px"}},"backgroundColor":"light","borderColor":"orange","layout":{"type":"constrained","justifyContent":"left"}} -->
<div
	class="wp-block-group utkwds-in-page-notice has-border-color has-orange-border-color has-light-background-color has-background"
	style="
		border-width: 4px;
		margin-top: var( --wp--preset--spacing--small );
		margin-bottom: var( --wp--preset--spacing--small );
		padding-top: var( --wp--preset--spacing--small );
		padding-right: var( --wp--preset--spacing--small );
		padding-bottom: var( --wp--preset--spacing--small );
		padding-left: var( --wp--preset--spacing--small );
	"
>
	<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|x-small"}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group">
		<!-- wp:paragraph {"className":"utkwds-notice-heading"} -->
		<p class="utkwds-notice-heading"><strong>In-Page Notice</strong></p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph -->
		<p>
			Make a message stand out on a page of details, so deadlines and
			special instructions don’t get lost in a wall of text. Only use once
			per page, remove it once its date passes, and aim not to leave up
			for more than a month, to avoid causing
			<a
				href="https://www.nngroup.com/articles/banner-blindness-old-and-new-findings/"
				>banner blindness</a
			>
			for your site users.
		</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
