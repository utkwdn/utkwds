<?php
/**
 * Title: Posts 2up + image light gray
 * Slug: utkwds/posts-2up-image-light-gray
 * Description:
 * Categories: dynamic-content
 * Keywords: news, light
 * Viewport Width: 1500 
 * Block Types: 
 * Post Types: 
 * Inserter: true
 */

?>

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|small","right":"var:preset|spacing|small","bottom":"var:preset|spacing|small","left":"var:preset|spacing|small"},"blockGap":"var:preset|spacing|medium"}},"backgroundColor":"light","className":"utkwds-posts-2up","layout":{"type":"constrained"},"metadata":{"name":"Posts 2up + image light gray"}} -->
<div class="wp-block-group alignfull utkwds-posts-2up has-light-background-color has-background" style="padding-top:var(--wp--preset--spacing--small);padding-right:var(--wp--preset--spacing--small);padding-bottom:var(--wp--preset--spacing--small);padding-left:var(--wp--preset--spacing--small)"><!-- wp:heading {"align":"wide","fontSize":"large"} -->
<h2 class="wp-block-heading alignwide has-large-font-size"></h2>
<!-- /wp:heading -->

<!-- wp:query {"queryId":0,"query":{"perPage":"2","pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false},"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"align":"wide","style":{"elements":{"link":{"color":{"text":"var:preset|color|smokey"}}}},"textColor":"smokey","layout":{"type":"grid","columnCount":2}} -->
<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:post-featured-image {"aspectRatio":"1","width":"158px","height":"158px","sizeSlug":"medium","style":{"layout":{"selfStretch":"fixed","flexSize":"158px"}}} /-->

<!-- wp:group {"className":"utkwds-post-2up-meta","layout":{"type":"default"}} -->
<div class="wp-block-group utkwds-post-2up-meta"><!-- wp:post-title {"level":3,"isLink":true,"fontSize":"medium"} /-->

<!-- wp:post-date {"style":{"typography":{"textTransform":"uppercase"},"spacing":{"margin":{"bottom":"var:preset|spacing|x-small","top":"0"}}},"fontSize":"x-small"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->