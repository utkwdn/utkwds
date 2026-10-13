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
		'image'        => null,
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
 * Placeholder story used for an override until the editor fills it in.
 *
 * @return array Story with dummy title/excerpt and the theme placeholder image.
 */
function utkwds_torch_stories_placeholder_story() {
	$story = utkwds_torch_stories_empty_story();

	$story['title']   = __( 'Story Title', 'utkwds' );
	$story['excerpt'] = __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'utkwds' );
	$story['image']   = array(
		'url'    => get_theme_file_uri( 'assets/images/image-placeholder-large.png' ),
		'alt'    => '',
		'width'  => 1108,
		'height' => 736,
		'srcset' => '',
	);

	return $story;
}

/**
 * Resolve the three stories for a block instance, applying manual overrides if set.
 *
 * An enabled override pushes post stories to the next position.
 * If any override is enabled, date and categories are disabled for all stories.
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

	$overrides  = isset( $attributes['overrides'] ) && is_array( $attributes['overrides'] ) ? $attributes['overrides'] : array();
	$stories    = array();
	$has_manual = false;
	$next_post  = 0; // Index of the next source post to place.

	for ( $i = 0; $i < $count; $i++ ) {
		$override = isset( $overrides[ $i ] ) && is_array( $overrides[ $i ] ) ? $overrides[ $i ] : array();

		if ( ! empty( $override['enabled'] ) ) {
			$story      = utkwds_torch_stories_placeholder_story();
			$has_manual = true;

			if ( ! empty( $override['title'] ) ) {
				$story['title'] = sanitize_text_field( $override['title'] );
			}

			if ( ! empty( $override['excerpt'] ) ) {
				$story['excerpt'] = sanitize_textarea_field( $override['excerpt'] );
			}

			if ( ! empty( $override['imageId'] ) && wp_attachment_is_image( (int) $override['imageId'] ) ) {
				$story['image_id'] = (int) $override['imageId'];
				$story['image']    = null;
			}

			if ( ! empty( $override['url'] ) ) {
				$story['url'] = esc_url_raw( trim( $override['url'] ) );
			}
		} else {
			// Source posts are pushed past overridden positions, not replaced.
			$story = isset( $posts[ $next_post ] ) ? $posts[ $next_post ] : null;
			++$next_post;
		}

		if ( $story && '' !== $story['title'] ) {
			$stories[] = $story;
		}
	}

	// A manual story has no date or categories, so hide them on every story to keep the three cards consistent.
	if ( $has_manual ) {
		foreach ( $stories as $index => $story ) {
			$stories[ $index ]['date']         = '';
			$stories[ $index ]['date_display'] = '';
			$stories[ $index ]['categories']   = array();
		}
	}

	return $stories;
}
