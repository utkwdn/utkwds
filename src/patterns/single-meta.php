<?php
/**
 * Title: Single post meta settings from customizer.
 * Slug: utkwds/single-meta
 * Inserter: false
 */
?>

<!-- wp:group {"layout":{"type":"flex"},"style":{"spacing":{"blockGap":"5px","margin":{"bottom":"30px"}},"typography":{"fontSize":"18px"}},"className":"post-meta"} -->
<div
	class="wp-block-group post-meta"
	style="margin-bottom: 30px; font-size: 18px"
>
	<?php if ( get_theme_mod( 'show_date' ) == 'show' ) : ?>
	<!-- wp:post-date /-->
	<?php endif; ?> <?php if ( get_theme_mod( 'show_author' ) == 'show' ) : ?>
	<!-- wp:post-author-name {"isLink":true} /-->
	<?php endif; ?>
</div>
<!-- /wp:group -->
