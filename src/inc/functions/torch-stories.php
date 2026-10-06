<?php
/**
 * Torch Stories block: data helpers.
 *
 * The block (src/blocks/torch-stories) pulls stories from this site,
 * filtered by a category, tag or location term.
 *
 * @package utkwds
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Internal taxonomies editors may filter by.
 *
 * @return array<string, string> Taxonomy slug => label.
 */
function utkwds_torch_stories_internal_taxonomies() {
	return array(
		'category'  => __( 'Category', 'utkwds' ),
		'post_tag'  => __( 'Tag', 'utkwds' ),
		'locations' => __( 'Location', 'utkwds' ),
	);
}

/**
 * An empty story.
 *
 * @return array
 */
function utkwds_torch_stories_empty_story() {
	return array(
		'title'        => '',
		'url'          => '',
		'excerpt'      => '',
		'date'         => '',
		'date_display' => '',
		'image_id'     => 0,
		'categories'   => array(),
	);
}

/**
 * Trim excerpt text to 20 words.
 *
 * @param string $text Raw excerpt (may contain HTML/entities).
 * @return string
 */
function utkwds_torch_stories_trim_excerpt( $text ) {
	$text = html_entity_decode( wp_strip_all_tags( (string) $text ), ENT_QUOTES, 'UTF-8' );

	/**
	 * Filter the number of words shown in Torch Stories excerpts.
	 *
	 * @param int $length Word count. Default 20 (matches the Category 3up pattern).
	 */
	$length = (int) apply_filters( 'utkwds_torch_stories_excerpt_length', 20 );

	// Plain-text ellipsis: the result is escaped with esc_html() on output.
	return wp_trim_words( $text, $length, "\u{2026}" );
}

/**
 * Get stories from this site.
 *
 * @param string $taxonomy Taxonomy slug (category, post_tag, locations).
 * @param int    $term_id  Term ID, or 0 for the most recent posts.
 * @param int    $count    Number of stories.
 * @return array[] Stories.
 */
function utkwds_torch_stories_get_local_stories( $taxonomy, $term_id, $count = 3 ) {
	$args = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => $count,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'orderby'             => 'date',
		'order'               => 'DESC',
	);

	if ( $term_id && array_key_exists( $taxonomy, utkwds_torch_stories_internal_taxonomies() ) ) {
		$args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery
			array(
				'taxonomy' => $taxonomy,
				'field'    => 'term_id',
				'terms'    => array( (int) $term_id ),
			),
		);
	}

	$stories = array();

	foreach ( get_posts( $args ) as $post ) {
		$story = utkwds_torch_stories_empty_story();

		$story['title']        = get_the_title( $post );
		$story['url']          = get_permalink( $post );
		$story['excerpt']      = utkwds_torch_stories_trim_excerpt( get_the_excerpt( $post ) );
		$story['date']         = get_the_date( 'c', $post );
		$story['date_display'] = get_the_date( '', $post );
		$story['image_id']     = (int) get_post_thumbnail_id( $post );

		$terms = get_the_terms( $post, 'category' );

		if ( is_array( $terms ) ) {
			foreach ( $terms as $term ) {
				$link = get_term_link( $term );

				$story['categories'][] = array(
					'name' => $term->name,
					'url'  => is_wp_error( $link ) ? '' : $link,
				);
			}
		}

		$stories[] = $story;
	}

	return $stories;
}

/**
 * Number of stories a block shows for its layout.
 *
 * @param array $attributes Block attributes.
 * @return int 3 for the default 3up layout, 2 for "2up alternating".
 */
function utkwds_torch_stories_story_count( $attributes ) {
	return isset( $attributes['displayStyle'] ) && '2up-alternating' === $attributes['displayStyle'] ? 2 : 3;
}

/**
 * Resolve the stories for a block instance.
 *
 * @param array $attributes Block attributes.
 * @return array[] Up to three stories.
 */
function utkwds_torch_stories_get_block_stories( $attributes ) {
	$count = utkwds_torch_stories_story_count( $attributes );

	$posts = utkwds_torch_stories_get_local_stories(
		isset( $attributes['taxonomy'] ) ? $attributes['taxonomy'] : 'category',
		isset( $attributes['termId'] ) ? (int) $attributes['termId'] : 0
	);

	return array_slice( $posts, 0, $count );
}
