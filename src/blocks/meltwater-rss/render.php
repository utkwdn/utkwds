<?php
/**
 * Render callback for the Meltwater RSS block.
 *
 * Pulls items from a remote RSS feed and outputs them as a list of
 * post-style entries showing the title (linked to the source article),
 * the source name and the description.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 *
 * @package utkwds
 *
 * @var array $attributes Block attributes.
 */

if ( ! function_exists( 'utk_wds_meltwater_rss_render_callback' ) ) {
	/**
	 * Fetch, parse and render the Meltwater RSS block.
	 *
	 * @param array $attributes Block attributes (feedUrl, itemsToShow).
	 * @return string Rendered HTML, or an empty string when nothing can be shown.
	 */
	function utk_wds_meltwater_rss_render_callback( $attributes ) {
		$feed_url = isset( $attributes['feedUrl'] ) ? esc_url_raw( trim( $attributes['feedUrl'] ) ) : '';

		// Limit the requested number of items to the supported 3-20 range.
		$number = isset( $attributes['itemsToShow'] ) ? absint( $attributes['itemsToShow'] ) : 10;
		$number = max( 3, min( 20, $number ) );

		if ( empty( $feed_url ) ) {
			return '';
		}

		// Cache the raw feed body so we don't hit the remote source on every request.
		$cache_key = 'meltwater_rss_' . md5( $feed_url );
		$body      = get_transient( $cache_key );

		if ( false === $body ) {
			$response = wp_remote_get(
				$feed_url,
				array(
					'timeout'    => 10,
					'user-agent' => 'Meltwater RSS block; ' . home_url(),
				)
			);

			if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
				return '';
			}

			$body = wp_remote_retrieve_body( $response );
			set_transient( $cache_key, $body, 15 * MINUTE_IN_SECONDS );
		}

		if ( empty( $body ) ) {
			return '';
		}

		$previous = libxml_use_internal_errors( true );
		$rss      = simplexml_load_string( $body );
		libxml_clear_errors();
		libxml_use_internal_errors( $previous );

		if ( false === $rss || ! isset( $rss->channel->item ) ) {
			return '';
		}

		$items  = array();
		$count  = 0;
		$markup = '';

		foreach ( $rss->channel->item as $item ) {
			if ( $count >= $number ) {
				break;
			}

			$title  = isset( $item->title ) ? wp_strip_all_tags( (string) $item->title ) : '';
			$link   = isset( $item->link ) ? trim( (string) $item->link ) : '';
			$desc   = isset( $item->description ) ? wp_strip_all_tags( (string) $item->description ) : '';
			$source = isset( $item->source ) ? wp_strip_all_tags( (string) $item->source ) : '';

			// Skip empty entries.
			if ( '' === $title && '' === $desc ) {
				continue;
			}

			$markup .= '<li class="wp-block-post">';
			$markup .= '<div class="wp-block-group wp-block-group-is-layout-constrained">';

			$markup .= '<div class="wp-block-post-title meltwater-rss-title heading-style--h3 is-style-utkwds-external-link">';
			if ( ! empty( $link ) ) {
				$markup .= '<a href="' . esc_url( $link ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $title ) . '</a>';
			} else {
				$markup .= esc_html( $title );
			}
			$markup .= '</div>';

			if ( ! empty( $source ) ) {
				$markup .= '<p class="meltwater-rss-source has-x-small-font-size">' . esc_html__( 'Source:', 'meltwater-rss' ) . ' ' . esc_html( $source ) . '</p>';
			}

			if ( ! empty( $desc ) ) {
				$markup .= '<p class="wp-block-post-excerpt">' . esc_html( $desc ) . '</p>';
			}

			$markup .= '</div>';
			$markup .= '</li>';

			++$count;
		}

		unset( $items );

		if ( 0 === $count ) {
			return '';
		}

		$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'wp-block-post-template' ) );

		return sprintf( '<ul %1$s>%2$s</ul>', $wrapper_attributes, $markup );
	}
}

// Output the rendered HTML. Each dynamic value is escaped as it is assembled above.
echo utk_wds_meltwater_rss_render_callback( $attributes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
