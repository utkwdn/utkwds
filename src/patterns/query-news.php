<?php
/**
 * Title: List of posts in one column.
 * Slug: utkwds/query-news
 * Inserter: false
 */
?>

<!-- wp:query {"queryId":0,"query":{"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"perPage":3},"displayLayout":{"type":"list"},"className":"utkwds-query-news","layout":{"type":"constrained"}} -->
<div class="wp-block-query utkwds-query-news">
	<!-- wp:post-template -->
	<!-- wp:columns -->
	<div class="wp-block-columns">
		<!-- wp:column {"width":"30%"} -->
		<div class="wp-block-column" style="flex-basis: 30%">
			<!-- wp:post-featured-image {"isLink":true} /-->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"70%"} -->
		<div class="wp-block-column" style="flex-basis: 70%">
			<!-- wp:group {"style":{"spacing":{"blockGap":"10px"}}} -->
			<div class="wp-block-group">
				<!-- wp:post-title {"isLink":true,"fontSize":"medium"} /-->

				<!-- wp:group {"style":{"spacing":{"blockGap":"5px","margin":{"bottom":"30px"}},"typography":{"fontSize":"18px"}},"className":"post-meta","layout":{"type":"flex"}} -->
				<div
					class="wp-block-group post-meta"
					style="margin-bottom: 30px; font-size: 18px"
				>
					<?php if ( get_theme_mod( 'show_date' ) == 'show' ) : ?>
					<!-- wp:post-date /-->
					<?php endif; ?> <?php if ( get_theme_mod( 'show_author' ) ==
					'show' ) : ?>
					<!-- wp:post-author-name {"isLink":true} /-->
					<?php endif; ?>
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->

			<!-- wp:post-excerpt /-->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:separator {"backgroundColor":"gray2","className":"is-style-wide"} -->
	<hr
		class="wp-block-separator has-text-color has-gray-2-color has-alpha-channel-opacity has-gray-2-background-color has-background is-style-wide"
	/>
	<!-- /wp:separator -->

	<!-- /wp:post-template -->

	<!-- wp:query-pagination -->
	<!-- wp:query-pagination-previous /-->

	<!-- wp:query-pagination-numbers /-->

	<!-- wp:query-pagination-next /-->
	<!-- /wp:query-pagination -->
</div>
<!-- /wp:query -->
