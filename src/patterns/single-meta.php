<?php
/**
 * Title: Single post meta settings from customizer.
 * Slug: utkwds/single-meta
 * Inserter: false
 *
 * @package utkwds
 */

?>

<?php

$show_date   = get_theme_mod( 'show_date' ) === 'show';
$show_author = get_theme_mod( 'show_author' ) === 'show';
$show_social = get_theme_mod( 'show_social' ) === 'show';

if ( ! $show_date && ! $show_author && ! $show_social ) {
	return;
}

$x_share_url = sprintf(
	'https://x.com/intent/post?url=%s&text=%s',
	rawurlencode( get_permalink() ),
	rawurlencode( get_the_title() )
);

$facebook_share_url = sprintf(
	'https://www.facebook.com/sharer/sharer.php?u=%s',
	rawurlencode( get_permalink() )
);

$linkedin_share_url = sprintf(
	'https://www.linkedin.com/sharing/share-offsite/?url=%s',
	rawurlencode( get_permalink() )
);

?>

<!-- wp:group {"layout":{"type":"flex"},"className":"post-meta"} -->
<div class="wp-block-group post-meta">
	<?php if ( $show_date ) : ?>
		<!-- wp:post-date /-->
	<?php endif; ?>

	<?php if ( $show_author ) : ?>
		<!-- wp:post-author-name {"isLink":true} /-->
	<?php endif; ?>

	<?php if ( $show_social ) : ?>
		<!-- wp:group {"className":"wp-block-post-author-social","style":{"spacing":{"blockGap":"var:preset|spacing|xx-small"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
		<div class="wp-block-post-social">
			<p>Share: </p>
			<!-- wp:social-links {"openInNewTab":true,"iconColor":"gray2","iconColorValue":"var(--wp--preset--color--smokey)","className":"is-style-logos-only"} -->
			<ul
				class="wp-block-social-links has-icon-color is-style-logos-only"
			>
				<!-- wp:social-link {"url":"<?php echo esc_url( $x_share_url ); ?>","service":"x"} /-->
				<!-- wp:social-link {"url":"<?php echo esc_url( $facebook_share_url ); ?>","service":"facebook"} /-->
				<!-- wp:social-link {"url":"<?php echo esc_url( $linkedin_share_url ); ?>","service":"linkedin"} /-->
			</ul>
			<!-- /wp:social-links -->
		</div>
		<!-- /wp:group -->
	<?php endif; ?>
</div>
<!-- /wp:group -->
