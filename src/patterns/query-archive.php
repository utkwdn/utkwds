<?php
/**
 * Title: List of posts in two columns.
 * Slug: utkwds/query-archive
 * Inserter: false
 */
?>

<!-- wp:query {"queryId":0,"query":{"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"perPage":10},"className":"utkwds-query-archive","layout":{"type":"constrained"}} -->
<div class="wp-block-query utkwds-query-archive"><!-- wp:post-template {"layout":{"type":"grid","columnCount":2}} -->
<!-- wp:group {"style":{"spacing":{"padding":{"bottom":"var:preset|spacing|small"},"blockGap":"var:preset|spacing|small"}},"backgroundColor":"light","className":"utkwds-stack","layout":{"type":"constrained"}} -->
<div class="wp-block-group utkwds-stack has-light-background-color has-background" style="padding-bottom:var(--wp--preset--spacing--small)"><!-- wp:post-featured-image {"isLink":true} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|x-small","padding":{"right":"var:preset|spacing|small","bottom":"0","left":"var:preset|spacing|small"}}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group" style="padding-right:var(--wp--preset--spacing--small);padding-bottom:0;padding-left:var(--wp--preset--spacing--small)"><!-- wp:post-title {"isLink":true,"fontSize":"medium"} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"5px"},"typography":{"fontSize":"18px"}},"className":"post-meta","layout":{"type":"flex"}} -->
<div class="wp-block-group post-meta" style="font-size:18px">

<?php if ( get_theme_mod( 'show_date' ) == 'show' ) : ?>
<!-- wp:post-date {"textColor":"smokey"} /-->
<?php endif; ?>

<?php if ( get_theme_mod( 'show_author' ) == 'show' ) : ?>
<!-- wp:post-author-name {"isLink":true} /-->
<?php endif; ?>

</div>
<!-- /wp:group -->

<!-- wp:post-excerpt /-->

<?php if ( get_theme_mod( 'show_categories' ) == 'show' ) : ?>
<!-- wp:post-terms {"term":"category","separator":"","style":{"spacing":{"margin":{"top":"var:preset|spacing|x-small"}}},"fontSize":"x-small"} /-->
<?php endif; ?>

</div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:separator {"style":{"spacing":{"margin":{"top":"var:preset|spacing|large","bottom":"var:preset|spacing|small"}}},"backgroundColor":"gray2","className":"is-style-wide"} -->
<hr class="wp-block-separator has-text-color has-gray-2-color has-alpha-channel-opacity has-gray-2-background-color has-background is-style-wide" style="margin-top:var(--wp--preset--spacing--large);margin-bottom:var(--wp--preset--spacing--small)"/>
<!-- /wp:separator -->

<!-- wp:query-pagination -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query -->