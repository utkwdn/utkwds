<?php
/**
 * Title: News 3up White
 * Slug: utkwds/news-3up-white
 * Description:
 * Categories: dynamic-content
 * Keywords: news, white
 * Viewport Width: 1500 
 * Block Types: 
 * Post Types: 
 * Inserter: true
 */

?>

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","right":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|60"}}},"backgroundColor":"white","className":"utkwds-news-3up","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull utkwds-news-3up has-white-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--60)"><!-- wp:spacer {"height":"70px"} -->
<div style="height:70px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:heading {"fontSize":"large"} -->
<h2 class="wp-block-heading has-large-font-size">News 3up</h2>
<!-- /wp:heading -->

<!-- wp:query {"queryId":0,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"displayLayout":{"type":"flex","columns":3},"layout":{"type":"constrained"}} -->
<div class="wp-block-query"><!-- wp:post-template {"style":{"elements":{"link":{"color":{"text":"var:preset|color|smokey"}}}},"textColor":"smokey"} -->
<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"medium"} /-->

<!-- wp:post-date {"style":{"typography":{"textTransform":"uppercase"}},"fontSize":"x-small"} /-->
<!-- /wp:post-template --></div>
<!-- /wp:query -->

<!-- wp:spacer {"height":"70px"} -->
<div style="height:70px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div>
<!-- /wp:group -->