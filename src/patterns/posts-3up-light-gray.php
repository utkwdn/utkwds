<?php
/**
 * Title: Posts 3up light gray
 * Slug: utkwds/posts-3up-light-gray
 * Description: Dynamic feed highlighting three recent posts (e.g. news articles, announcements, etc.), showing title, date of publication, and an animated orange arrow, on a light gray background.
 * Categories: dynamic-content
 * Keywords: posts, news, feed, articles, announcements, light gray
 * Viewport Width: 1500 
 * Block Types: 
 * Post Types: 
 * Inserter: true
 */

?>

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|small","right":"var:preset|spacing|small","bottom":"var:preset|spacing|small","left":"var:preset|spacing|small"},"blockGap":"var:preset|spacing|medium"}},"backgroundColor":"light","className":"utkwds-posts-3up","layout":{"type":"constrained"},"metadata":{"name":"Posts 3up light gray"}} -->
<div class="wp-block-group alignfull utkwds-posts-3up has-light-background-color has-background" style="padding-top:var(--wp--preset--spacing--small);padding-right:var(--wp--preset--spacing--small);padding-bottom:var(--wp--preset--spacing--small);padding-left:var(--wp--preset--spacing--small)"><!-- wp:heading {"align":"wide","fontSize":"large"} -->
<h2 class="wp-block-heading alignwide has-large-font-size">Posts 3up light gray</h2>
<!-- /wp:heading -->

<!-- wp:query {"queryId":0,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false},"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"align":"wide","style":{"elements":{"link":{"color":{"text":"var:preset|color|smokey"}}}},"textColor":"smokey","layout":{"type":"grid","columnCount":3}} -->
<!-- wp:post-title {"level":3,"isLink":true,"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"fontSize":"medium"} /-->

<!-- wp:post-date {"style":{"typography":{"textTransform":"uppercase"},"spacing":{"margin":{"bottom":"var:preset|spacing|x-small"}}},"fontSize":"x-small"} /-->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->