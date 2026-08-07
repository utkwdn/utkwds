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

	// Adjustable weights.
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

	// Score each post.
	$scored = array();
	$now    = time();

	foreach ( $related_posts_query->posts as $post ) {

		$score = 0.0;

		// Category match score.
		if ( ! empty( $categories ) ) {
			$post_cat_ids  = wp_get_post_categories( $post->ID, array( 'fields' => 'ids' ) );
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
		$age_in_days    = ( $now - strtotime( $post->post_date_gmt ) ) / DAY_IN_SECONDS;
		$recency_points = max( 0, $recency_weight * ( 1 - $age_in_days / $recency_window ) );
		$score         += $recency_points;

		$scored[] = array(
			'post'  => $post,
			'score' => $score,
		);
	}

	// Sort by score DESC then by date DESC.
	usort(
		$scored,
		function ( $a, $b ) {
			if ( abs( $a['score'] - $b['score'] ) < 0.001 ) {
				// More recent first.
				return strcmp( $b['post']->post_date_gmt, $a['post']->post_date_gmt );
			}
			return ( $b['score'] <=> $a['score'] );
		}
	);

	// Return the top $count posts.
	$top = array_slice( $scored, 0, $count );

	return wp_list_pluck( $top, 'post' );
}

$current_post_id = get_the_ID();
$categories      = wp_get_post_categories( $current_post_id, array( 'fields' => 'ids' ) );
$tags            = wp_get_post_tags( $current_post_id, array( 'fields' => 'ids' ) );

// Exit if we have no categories or tags to match against.
if ( empty( $categories ) && empty( $tags ) ) {
	return;
}

$related_posts = get_weighted_related_posts( $current_post_id, $categories, $tags, 3 );

// Exit if less than 3 related posts are found.
if ( count( $related_posts ) < 3 ) {
	return;
}

$post_horizontal_pattern = \WP_Block_Patterns_Registry::get_instance()->get_registered( 'utkwds/post-horizontal-categories' );
$post_horizontal_blocks  = $post_horizontal_pattern ? parse_blocks( $post_horizontal_pattern['content'] ) : array();

// The <ul> markup below mimics core/post-template's output, but since no actual
// core/post-template block is ever rendered, its style handle is never auto-enqueued.
wp_enqueue_style( 'wp-block-post-template' );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-block-group has-light-background-color has-background has-global-padding is-layout-constrained wp-block-group-is-layout-constrained',
	)
);
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?>>
	<h2 class="wp-block-heading">Related News</h2>
	<div class="wp-block-query utkwds-query-post-horizontal has-global-padding is-layout-constrained wp-block-query-is-layout-constrained">
		<ul class="wp-block-post-template">
			<?php
			foreach ( $related_posts as $related ) :
				$related_post_id      = $related->ID;
				$filter_block_context = static function ( $context ) use ( $related_post_id ) {
					$context['postType'] = 'post';
					$context['postId']   = $related_post_id;
					return $context;
				};

				add_filter( 'render_block_context', $filter_block_context, 1 );

				global $post;
				$post = $related;
				setup_postdata( $post );

				$post_content = '';
				foreach ( $post_horizontal_blocks as $parsed_block ) {
					$post_content .= ( new \WP_Block( $parsed_block ) )->render();
				}

				wp_reset_postdata();
				remove_filter( 'render_block_context', $filter_block_context, 1 );

				$post_classes = implode( ' ', get_post_class( 'wp-block-post', $related ) );
				?>
				<li class="<?php echo esc_attr( $post_classes ); ?>"><?php echo wp_kses_post( $post_content ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
