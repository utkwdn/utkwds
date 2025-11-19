<?php
/**
 * Title: Callout
 * Slug: utkwds/callout
 * Description: A full width image featuring a floating text box.
 * Categories: banners
 * Keywords: callout, cover, full width, full-width, image, text
 * Viewport Width: 1500
 * Block Types:
 * Post Types:
 * Inserter: true
 *
 * @package utkwds
 */

?>

<!-- wp:cover {"templateLock": "contentOnly","url":"https://images.utk.edu/wds/gallery-2up-placeholder-large.png","dimRatio":0,"contentPosition":"bottom right","isDark":false,"metadata":{"name":"Callout"},"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|large","right":"var:preset|spacing|large","bottom":"var:preset|spacing|large","left":"var:preset|spacing|large"}}},"className":"utkwds-callout"} -->
<div
	class="wp-block-cover alignfull is-light has-custom-content-position is-position-bottom-right utkwds-callout"
	style="
		margin-top: 0;
		margin-bottom: 0;
		padding-top: var( --wp--preset--spacing--large );
		padding-right: var( --wp--preset--spacing--large );
		padding-bottom: var( --wp--preset--spacing--large );
		padding-left: var( --wp--preset--spacing--large );
	"
>
	<span
		aria-hidden="true"
		class="wp-block-cover__background has-background-dim-0 has-background-dim"
	></span
	><img
		class="wp-block-cover__image-background"
		alt=""
		src="https://images.utk.edu/wds/gallery-2up-placeholder-large.png"
		data-object-fit="cover"
	/>
	<div class="wp-block-cover__inner-container">
		<!-- wp:paragraph {"align":"left","placeholder":"Write title…","style":{"spacing":{"margin":{"top":"0","right":"0","bottom":"0","left":"0"},"padding":{"top":"var:preset|spacing|small","right":"var:preset|spacing|small","bottom":"var:preset|spacing|small","left":"var:preset|spacing|small"}}},"textColor":"white","fontSize":"small"} -->
		<p
			class="has-text-align-left has-white-color has-text-color has-small-font-size"
			style="
				margin-top: 0;
				margin-right: 0;
				margin-bottom: 0;
				margin-left: 0;
				padding-top: var( --wp--preset--spacing--small );
				padding-right: var( --wp--preset--spacing--small );
				padding-bottom: var( --wp--preset--spacing--small );
				padding-left: var( --wp--preset--spacing--small );
			"
		>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
			gravida dui a aliquet egestas. Class aptent taciti sociosqu ad
			litora torquent per conubia nostra
		</p>
		<!-- /wp:paragraph -->
	</div>
</div>
<!-- /wp:cover -->
