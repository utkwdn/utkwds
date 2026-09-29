<?php
/**
 * Title: List of posts in horizontal rows with alternating backgrounds and an orange top border, respecting the category/year filters.
 * Slug: utkwds/query-post-horizontal-striped
 * Inserter: false
 *
 * @package utkwds
 */

?>

<!-- wp:query {"queryId":0,"query":{"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"perPage":10},"className":"utkwds-query-post-horizontal-striped","layout":{"type":"constrained"}} -->
<div class="wp-block-query utkwds-query-post-horizontal-striped"><!-- wp:post-template -->

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
