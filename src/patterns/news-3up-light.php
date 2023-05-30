<?php
/**
 * Title: News 3up Light
 * Slug: utkwds/news-3up-light
 * Description:
 * Categories: content
 * Keywords: news, light
 * Viewport Width: 1500 
 * Block Types: 
 * Post Types: 
 * Inserter: true
 */

?>

<!-- wp:group {"align":"full","backgroundColor":"light","className":"utkwds-news-3up","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull utkwds-news-3up has-light-background-color has-background"><!-- wp:spacer -->
<div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
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

<!-- wp:spacer -->
<div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div>
<!-- /wp:group -->