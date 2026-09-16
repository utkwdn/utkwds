<?php
/**
 *
 * Replace the site tagline block with a customizer tagline link
 *
 * @package utkwds
 */

/**
 * Render the core/site-tagline block with optional link.
 *
 * @param string $block_content The original block content.
 *
 * @return string Modified block content.
 */
function utkwds_render_block_core_tagline( $block_content ) {

	if ( get_theme_mod( 'tagline_link' ) ) {
		$block_content = "<p class='header-site-tagline'><a href='" . esc_url( get_theme_mod( 'tagline_link' ) ) . "'>" . get_bloginfo( 'description' ) . '</a></p>';
	}

	return $block_content;
}

// add_filter( 'render_block_core/site-tagline', 'utkwds_render_block_core_tagline', 10, 2 );

/**
 * Get an RSS item's source, falling back through several tag conventions.
 *
 * @param \SimplePie\Item $item RSS item.
 *
 * @return string
 */
function utkwds_rss_item_source( $item ) {

	// Standard <source> element.
	$tags = $item->get_item_tags( '', 'source' );
	if ( ! empty( $tags[0]['data'] ) ) {
		return wp_strip_all_tags( $tags[0]['data'] );
	}

	// Atom <source><title>.
	$source = $item->get_source();
	if ( $source && method_exists( $source, 'get_title' ) && $source->get_title() ) {
		return wp_strip_all_tags( $source->get_title() );
	}

	// Fall back to the item author name.
	$author = $item->get_author();
	if ( $author && $author->get_name() ) {
		return wp_strip_all_tags( $author->get_name() );
	}

	return '';
}

/**
 * Add each item's source under its title on the core/rss block, when the
 * "Display source" attribute is enabled.
 *
 * @param string $block_content The rendered block markup.
 * @param array  $block         The parsed block, including attributes.
 *
 * @return string
 */
function utkwds_render_block_core_rss( $block_content, $block ) {

	if ( empty( $block['attrs']['displaySource'] ) || empty( $block['attrs']['feedURL'] ) ) {
		return $block_content;
	}

	if ( ! function_exists( 'fetch_feed' ) ) {
		include_once ABSPATH . WPINC . '/feed.php';
	}

	$rss = fetch_feed( $block['attrs']['feedURL'] );
	if ( is_wp_error( $rss ) ) {
		return $block_content;
	}

	$items_to_show = ! empty( $block['attrs']['itemsToShow'] ) ? (int) $block['attrs']['itemsToShow'] : 5;
	$sources       = array_map( 'utkwds_rss_item_source', $rss->get_items( 0, $items_to_show ) );

	if ( ! array_filter( $sources ) ) {
		return $block_content;
	}

	$parts = explode( "<li class='wp-block-rss__item'>", $block_content );

	foreach ( $sources as $index => $source ) {
		$part_index = $index + 1;
		if ( empty( $source ) || ! isset( $parts[ $part_index ] ) ) {
			continue;
		}

		$markup = "<div class='wp-block-rss__item-source'>" . sprintf(
			/* translators: %s: RSS item source name. */
			esc_html__( 'Source: %s', 'utkwds' ),
			esc_html( $source )
		) . '</div>';

		$parts[ $part_index ] = preg_replace_callback(
			"/<div class='wp-block-rss__item-title'>.*?<\/div>/s",
			function ( $matches ) use ( $markup ) {
				return $matches[0] . $markup;
			},
			$parts[ $part_index ],
			1
		);
	}

	return implode( "<li class='wp-block-rss__item'>", $parts );
}
add_filter( 'render_block_core/rss', 'utkwds_render_block_core_rss', 10, 2 );
