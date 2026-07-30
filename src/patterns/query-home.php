<?php
/**
 * Title: List of posts in horizontal rows, respecting the category/year filters.
 * Slug: utkwds/query-home
 * Inserter: false
 *
 * @package utkwds
 */

?>

<!-- wp:query {"queryId":0,"query":{"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"perPage":10},"className":"utkwds-query-home","layout":{"type":"constrained"}} -->
<div class="wp-block-query utkwds-query-home"><!-- wp:post-template -->

<!-- wp:pattern {"slug":"utkwds/post-horizontal"} /-->

<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph -->
<p>No posts match the selected filters.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results -->

<!-- wp:query-pagination -->
	<!-- wp:query-pagination-numbers {"midSize": 1} /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query -->
