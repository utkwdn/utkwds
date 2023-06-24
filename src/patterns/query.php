<?php
/**
 * Title: List of posts in one column.
 * Slug: utkwds/query
 * Inserter: false
 */
?>
<!-- wp:query {"queryId":0,"query":{"pages":0,"offset":0,"postType":"post","categoryIds":[],"tagIds":[],"order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true},"layout":{"type":"constrained"}} -->
<div class="wp-block-query">
<!-- wp:query-no-results -->
<!-- wp:paragraph {"placeholder":"Add text or blocks that will display when a query returns no results."} -->
<p>No results found for your search.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results -->
<!-- wp:post-template -->
<!-- wp:group {"style":{"spacing":{"blockGap":"10px"}}} -->
<div class="wp-block-group">
<!-- wp:post-title {"isLink":true} /-->
<!-- wp:group {"style":{"spacing":{"blockGap":"5px","margin":{"bottom":"30px"}},"typography":{"fontSize":"18px"}},"className":"post-meta","layout":{"type":"flex"}} -->
<div class="wp-block-group post-meta" style="margin-bottom:30px;font-size:18px">
<!-- wp:post-date /-->
<!-- wp:paragraph -->
<p>·</p>
<!-- /wp:paragraph -->
<!-- wp:post-author-name {"isLink":true} /-->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
<!-- wp:post-excerpt {"moreText":"Read More"} /-->
<!-- /wp:post-template -->
<!-- wp:query-pagination -->
<!-- wp:query-pagination-previous /-->
<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination -->
</div>
<!-- /wp:query -->
