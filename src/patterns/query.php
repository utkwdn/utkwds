<?php
/**
 * Title: List of posts in one column.
 * Slug: utkwds/query
 * Inserter: false
 *
 * @package utkwds
 */

?>

<!-- wp:query {"queryId":0,"query":{"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"perPage":3},"displayLayout":{"type":"list"},"className":"utkwds-query","layout":{"type":"constrained"},"editorskit":{"devices":false,"desktop":true,"tablet":true,"mobile":true,"loggedin":true,"loggedout":true,"acf_visibility":"","acf_field":"","acf_condition":"","acf_value":"","migrated":false,"unit_test":false}} -->
<div class="wp-block-query utkwds-query">
<!-- wp:query-no-results -->
<div class="gs-webResult gs-result gs-no-results-result"><div class="gs-snippet">No Results</div></div>
<!-- /wp:query-no-results -->

<!-- wp:post-template -->
<!-- wp:group {"style":{"spacing":{"blockGap":"10px"}},"editorskit":{"devices":false,"desktop":true,"tablet":true,"mobile":true,"loggedin":true,"loggedout":true,"acf_visibility":"","acf_field":"","acf_condition":"","acf_value":"","migrated":false,"unit_test":false}} -->
<div class="wp-block-group"><!-- wp:post-title {"isLink":true,"level":3} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"5px","margin":{"bottom":"30px"}},"typography":{"fontSize":"18px"}},"className":"post-meta","layout":{"type":"flex"}} -->
<div class="wp-block-group post-meta" style="margin-bottom:30px;font-size:18px">

<!-- wp:post-date /-->

</div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:post-excerpt /-->

<!-- wp:separator {"backgroundColor":"gray2","className":"is-style-wide"} -->
<hr class="wp-block-separator has-text-color has-gray-2-color has-alpha-channel-opacity has-gray-2-background-color has-background is-style-wide"/>
<!-- /wp:separator -->

<!-- /wp:post-template -->

<!-- wp:query-pagination -->
	<!-- wp:query-pagination-numbers /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query -->
