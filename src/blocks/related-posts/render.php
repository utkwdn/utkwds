<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *   $attributes (array): The block attributes.
 *   $content (string): The block default content.
 *   $block (WP_Block): The block instance.
 *
 * @package utkwds
 */

namespace UTK\WebDesignSystem;

/**
 * Get weighted related posts.
 *
 * @param int   $post_id     The current post ID.
 * @param array $categories  Array of category term IDs for the current post.
 * @param array $tags        Array of tag term IDs for the current post.
 * @param int   $count       Number of related posts to return (default 3).
 *
 * @return \WP_Post[] Array of related WP_Post objects, sorted by relevance score.
 */
function get_weighted_related_posts( int $post_id, array $categories, array $tags, int $count = 3 ): array {

	// Adjustable weights
	$tag_weight      = 2;    // Points per matching tag.
	$category_weight = 1;    // Points per matching category.
	$recency_weight  = 2;    // Max points for a new post.
	$recency_window  = 90;   // How many days back to add recency points.
	$post_count      = 50;   // How many posts to fetch before scoring.

	// Build the tax_query.
	$tax_query = array( 'relation' => 'OR' );

	if ( ! empty( $categories ) ) {
		$tax_query[] = array(
			'taxonomy' => 'category',
			'field'    => 'term_id',
			'terms'    => $categories,
		);
	}

	if ( ! empty( $tags ) ) {
		$tax_query[] = array(
			'taxonomy' => 'post_tag',
			'field'    => 'term_id',
			'terms'    => $tags,
		);
	}

	// Fetch larger group of posts to rank and sort.
	$related_posts_query = new \WP_Query(
		array(
			'post_type'      => 'post',
			'posts_per_page' => $post_count,
			'post__not_in'   => array( $post_id ),
			'tax_query'      => $tax_query,   // phpcs:ignore WordPress.DB.SlowDBQuery
			'orderby'        => 'date',
			'order'          => 'DESC',
			'no_found_rows'  => true,
		)
	);

	if ( ! $related_posts_query->have_posts() ) {
		return array();
	}

	// Score each post
	$scored = array();
	$now    = time();

	foreach ( $related_posts_query->posts as $post ) {

		$score = 0.0;

		$post_cat_terms    = get_the_category( $post->ID );
		$post_cat_ids      = wp_list_pluck( $post_cat_terms, 'term_id' );
		$post_cat_map      = array_combine(
			wp_list_pluck( $post_cat_terms, 'slug' ),
			wp_list_pluck( $post_cat_terms, 'name' )
		);

		// Category match score.
		if ( ! empty( $categories ) ) {
			$matching_cats = array_intersect( $categories, $post_cat_ids );
			$score        += count( $matching_cats ) * $category_weight;
		}

		// Tag match score.
		if ( ! empty( $tags ) ) {
			$post_tags     = wp_get_post_tags( $post->ID, array( 'fields' => 'ids' ) );
			$matching_tags = array_intersect( $tags, $post_tags );
			$score        += count( $matching_tags ) * $tag_weight;
		}

		// Recency score. More recent = more points (up to $recency_weight).
		$age_in_days     = ( $now - strtotime( $post->post_date_gmt ) ) / DAY_IN_SECONDS;
		$recency_points  = max( 0, $recency_weight * ( 1 - $age_in_days / $recency_window ) );
		$score          += $recency_points;

		$scored[] = array(
			'post'            => $post,
			'score'           => $score,
			'category_map' => $post_cat_map,
		);
	}

	// Sort by score DESC then by date DESC
	usort( $scored, function ( $a, $b ) {
		if ( abs( $a['score'] - $b['score'] ) < 0.001 ) {
			// More recent first.
			return strcmp( $b['post']->post_date_gmt, $a['post']->post_date_gmt );
		}
		return ( $b['score'] <=> $a['score'] );
	});

	// Return the top $count posts
	$top = array_slice( $scored, 0, $count );

	return array_map( function ( $item ) {
		$item['post']->related_categories = $item['category_map'];
		return $item['post'];
	}, $top );
}

$post_id    = get_the_ID();
$categories = wp_get_post_categories( $post_id, array( 'fields' => 'ids' ) );
$tags       = wp_get_post_tags( $post_id, array( 'fields' => 'ids' ) );

// Exit if we have no categories or tags to match against.
if ( empty( $categories ) && empty( $tags ) ) {
	return;
}

$related_posts = get_weighted_related_posts( $post_id, $categories, $tags, 3 );

error_log(print_r($related_posts, true));

// Exit if less than 3 related posts are found
if ( count( $related_posts ) < 3 ) {
	return;
}

$wrapper_attributes = get_block_wrapper_attributes( array(
	'class' => 'wp-block-group alignfull utkwds-stack-3up has-light-background-color has-background has-global-padding is-layout-constrained wp-container-core-group-is-layout-dbf27b9b wp-block-group-is-layout-constrained',
	'style' => 'padding-top:var(--wp--preset--spacing--small);padding-right:var(--wp--preset--spacing--small);padding-bottom:var(--wp--preset--spacing--small);padding-left:var(--wp--preset--spacing--small);margin-bottom: calc(-1 * var(--wp--preset--spacing--large));',
) );
?>

<div <?php echo $wrapper_attributes; ?>>

		<h2 class="wp-block-heading alignwide">Related News</h2>

		<div class="wp-block-columns alignwide is-layout-flex wp-container-core-columns-is-layout-28f84493 wp-block-columns-is-layout-flex">
			<?php foreach ( $related_posts as $related ) : ?>

				<div class="wp-block-column utkwds-stack has-white-background-color has-background is-layout-flow wp-container-core-column-is-layout-89fc711d wp-block-column-is-layout-flow" style="padding-bottom:var(--wp--preset--spacing--small)">

					<?php if ( has_post_thumbnail( $related->ID ) ) : ?>
						<figure class="wp-block-image size-full">
							<?php echo get_the_post_thumbnail( $related->ID, 'medium_large' ); ?>
						</figure>
					<?php endif; ?>

					<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-f1d49814 wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--small);padding-bottom:0;padding-left:var(--wp--preset--spacing--small)">

						<h3 class="wp-block-post-title has-medium-font-size">
							<a href="<?php echo esc_url( get_permalink( $related->ID ) ); ?>">
								<?php echo esc_html( get_the_title( $related->ID ) ); ?>
							</a>
						</h3>

						<?php if ( has_excerpt( $related->ID ) ) : ?>
							<p><?php echo esc_html( get_the_excerpt( $related->ID ) ); ?></p>
						<?php endif; ?>

						<div class="wp-block-group" style="display:block;width:100%;">
							<?php foreach ( $related->related_categories as $cat_slug => $cat_name ) : ?>
								<div class="taxonomy-category wp-block-post-terms">
									<a href="<?php echo '/category/' . esc_attr( $cat_slug ); ?>" rel="tag">
										<?php echo esc_html( $cat_name ); ?>
									</a>
								</div>
								
							<?php endforeach; ?>
						</div>

					</div>

				</div>

			<?php endforeach; ?>
		</div>
</div>
