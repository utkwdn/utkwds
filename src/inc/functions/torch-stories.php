<?php
/**
 * Torch Stories block: data helpers.
 *
 * The block (src/blocks/torch-stories) pulls stories from:
 *  - This site, filterable by a category, tag or location term
 *  - Another WordPress site (with at least one taxonomy at
 *    its /wp-json/wp/v2/taxonomies endpoint)
 *
 * Remote requests are always made from the server, not the browser
 * and cached in transients
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

/*
-------------------------------------------------------------------------
 * Remote site helpers.
-------------------------------------------------------------------------
*/

/**
 * Normalize a site URL typed by an editor.
 *
 * Adds a scheme when missing, drops query strings/fragments and any pasted
 * /wp-json suffix and keeps the path so multisite subdirectory sites work.
 *
 * @param string $url Raw URL.
 * @return string Normalized URL without trailing slash, or '' when invalid.
 */
function utkwds_torch_stories_normalize_site_url( $url ) {
	$url = trim( (string) $url );

	if ( '' === $url ) {
		return '';
	}

	if ( ! preg_match( '#^https?://#i', $url ) ) {
		$url = 'https://' . $url;
	}

	$parts = wp_parse_url( $url );

	if ( empty( $parts['host'] ) || empty( $parts['scheme'] ) ) {
		return '';
	}

	$normalized = strtolower( $parts['scheme'] ) . '://' . strtolower( $parts['host'] );

	if ( ! empty( $parts['port'] ) ) {
		$normalized .= ':' . (int) $parts['port'];
	}

	$path = isset( $parts['path'] ) ? $parts['path'] : '';
	$path = preg_replace( '#/wp-json(/.*)?$#', '', $path );

	return esc_url_raw( untrailingslashit( $normalized . $path ), array( 'http', 'https' ) );
}

/**
 * Build a URL for a REST route on a remote site.
 *
 * Supports both `/wp-json/` and `?rest_route=` REST roots.
 *
 * @param string $root  REST root URL.
 * @param string $route Route, e.g. `/wp/v2/posts`.
 * @param array  $args  Query args (scalar values).
 * @return string
 */
function utkwds_torch_stories_route_url( $root, $route, $args = array() ) {
	$route = '/' . ltrim( $route, '/' );

	if ( false !== strpos( $root, 'rest_route=' ) ) {
		$url = add_query_arg( 'rest_route', $route, $root );
	} else {
		$url = trailingslashit( $root ) . ltrim( $route, '/' );
	}

	if ( ! empty( $args ) ) {
		$url = add_query_arg( array_map( 'rawurlencode', array_map( 'strval', $args ) ), $url );
	}

	return $url;
}

/**
 * Limit a curl handle to IPv4 name resolution because WP Engine
 * does not support IPv6.
 *
 * @param resource|CurlHandle $handle cURL handle.
 */
function utkwds_torch_stories_curl_ipv4( $handle ) {
	curl_setopt( $handle, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_setopt
}

/**
 * Make a safe remote request for this block.
 *
 * @param string $method GET or HEAD.
 * @param string $url    URL.
 * @param array  $args   Request args.
 * @return array|WP_Error
 */
function utkwds_torch_stories_http_request( $method, $url, $args ) {
	/**
	 * Whether to force IPv4 name resolution for Torch Stories remote requests.
	 *
	 * @param bool $force Default true on macOS, false elsewhere.
	 */
	$force_ipv4 = (bool) apply_filters( 'utkwds_torch_stories_force_ipv4', 'Darwin' === PHP_OS_FAMILY );

	if ( $force_ipv4 ) {
		add_action( 'http_api_curl', 'utkwds_torch_stories_curl_ipv4' );
	}

	$response = 'HEAD' === $method ? wp_safe_remote_head( $url, $args ) : wp_safe_remote_get( $url, $args );

	if ( $force_ipv4 ) {
		remove_action( 'http_api_curl', 'utkwds_torch_stories_curl_ipv4' );
	}

	return $response;
}

/**
 * GET a remote URL and decode its JSON body.
 *
 * @param string $url URL to fetch.
 * @return array|WP_Error Decoded JSON (associative array) or error.
 */
function utkwds_torch_stories_remote_json( $url ) {
	$response = utkwds_torch_stories_http_request(
		'GET',
		$url,
		array(
			'timeout'     => 15,
			'redirection' => 3,
			'headers'     => array( 'Accept' => 'application/json' ),
			'user-agent'  => 'UTKWDS Torch Stories; ' . home_url(),
		)
	);

	if ( is_wp_error( $response ) ) {
		return new WP_Error(
			'utkwds_torch_stories_unreachable',
			/* translators: %s: underlying HTTP error, e.g. a cURL timeout message. */
			sprintf( __( 'The site could not be reached (%s).', 'utkwds' ), $response->get_error_message() ),
			array( 'url' => $url )
		);
	}

	$code = (int) wp_remote_retrieve_response_code( $response );

	if ( 200 !== $code ) {
		// Include the REST error message when the site sends one (e.g. rest_forbidden).
		$body    = json_decode( wp_remote_retrieve_body( $response ), true );
		$reason  = is_array( $body ) && ! empty( $body['message'] ) ? ' ' . wp_strip_all_tags( $body['message'] ) : '';
		$message = in_array( $code, array( 401, 403 ), true )
			/* translators: 1: HTTP status code, 2: URL, 3: remote error message. */
			? __( 'The site refused the request (HTTP %1$d at %2$s). It may require a login, or a firewall may be blocking server-to-server requests.%3$s', 'utkwds' )
			/* translators: 1: HTTP status code, 2: URL, 3: remote error message. */
			: __( 'The site responded with an error (HTTP %1$d at %2$s).%3$s', 'utkwds' );

		return new WP_Error(
			'utkwds_torch_stories_http_error',
			sprintf( $message, $code, $url, $reason ),
			array( 'code' => $code )
		);
	}

	$data = json_decode( wp_remote_retrieve_body( $response ), true );

	if ( ! is_array( $data ) ) {
		return new WP_Error(
			'utkwds_torch_stories_invalid_json',
			/* translators: %s: URL. */
			sprintf( __( 'The site did not return a valid WordPress REST API response at %s.', 'utkwds' ), $url )
		);
	}

	return $data;
}

/**
 * Find the REST API root for a site.
 *
 * Tries `/wp-json/` first, then the `Link: rel="https://api.w.org/"` header on
 * the home page, then `?rest_route=/`.
 *
 * @param string $site_url Normalized site URL.
 * @return array|WP_Error { root: string, index: array } or error.
 */
function utkwds_torch_stories_find_rest_root( $site_url ) {
	$candidates  = array( trailingslashit( $site_url ) . 'wp-json/' );
	$tried_link  = false;
	$first_error = null;

	while ( ! empty( $candidates ) ) {
		$root  = array_shift( $candidates );
		$index = utkwds_torch_stories_remote_json(
			utkwds_torch_stories_route_url( $root, '/', array( '_fields' => 'name,description,url,home,namespaces' ) )
		);

		if ( ! is_wp_error( $index ) && isset( $index['namespaces'] ) ) {
			return array(
				'root'  => $root,
				'index' => $index,
			);
		}

		if ( ! $first_error ) {
			$first_error = is_wp_error( $index )
				? $index
				: new WP_Error( 'utkwds_torch_stories_invalid_json', __( 'The response did not look like a WordPress REST API index.', 'utkwds' ) );
		}

		// Fall back to if the default location fails.
		if ( ! $tried_link ) {
			$tried_link = true;
			$home       = utkwds_torch_stories_http_request(
				'HEAD',
				trailingslashit( $site_url ),
				array(
					'timeout'     => 8,
					'redirection' => 3,
				)
			);

			if ( ! is_wp_error( $home ) ) {
				$links = (array) wp_remote_retrieve_header( $home, 'link' );

				foreach ( $links as $link ) {
					if ( preg_match( '#<([^>]+)>\s*;\s*rel="https://api\.w\.org/"#', $link, $match ) ) {
						$candidates[] = esc_url_raw( $match[1] );
						break;
					}
				}
			}

			$candidates[] = add_query_arg( 'rest_route', '/', trailingslashit( $site_url ) );
		}
	}

	// If fallback fails, report why.
	if ( $first_error && 'utkwds_torch_stories_invalid_json' !== $first_error->get_error_code() ) {
		return $first_error;
	}

	return new WP_Error(
		'utkwds_torch_stories_no_rest_api',
		__( 'No WordPress REST API was found at that URL.', 'utkwds' )
	);
}

/**
 * Validate a remote site and describe what it returns.
 *
 * @param string $site_url Site URL (any form an editor might type).
 * @param bool   $force    Skip the cache.
 * @return array|WP_Error {
 *     url: string, root: string, name: string, description: string,
 *     taxonomies: array<int, array{slug: string, name: string, rest_base: string}>
 * }
 */
function utkwds_torch_stories_get_remote_site( $site_url, $force = false ) {
	$typed_scheme = (bool) preg_match( '#^\s*https?://#i', (string) $site_url );
	$site_url     = utkwds_torch_stories_normalize_site_url( $site_url );

	if ( '' === $site_url ) {
		return new WP_Error( 'utkwds_torch_stories_invalid_url', __( 'Enter a valid site URL.', 'utkwds' ) );
	}

	$cache_key = 'utkwds_torch_stories_site_' . md5( $site_url );

	if ( ! $force ) {
		$cached = get_transient( $cache_key );
		if ( is_array( $cached ) ) {
			return $cached;
		}
	}

	$found = utkwds_torch_stories_find_rest_root( $site_url );

	// Try plain HTTP before giving up.
	if ( is_wp_error( $found ) && ! $typed_scheme ) {
		$http_url   = preg_replace( '#^https://#', 'http://', $site_url );
		$http_found = utkwds_torch_stories_find_rest_root( $http_url );

		if ( ! is_wp_error( $http_found ) ) {
			$found     = $http_found;
			$site_url  = $http_url;
			$cache_key = 'utkwds_torch_stories_site_' . md5( $site_url );
		}
	}

	if ( is_wp_error( $found ) ) {
		return $found;
	}

	$root  = $found['root'];
	$index = $found['index'];

	$taxonomies_raw = utkwds_torch_stories_remote_json(
		utkwds_torch_stories_route_url( $root, '/wp/v2/taxonomies', array( 'type' => 'post' ) )
	);

	if ( is_wp_error( $taxonomies_raw ) ) {
		return new WP_Error(
			'utkwds_torch_stories_no_taxonomies_endpoint',
			/* translators: %s: underlying error message. */
			sprintf( __( 'The site’s /wp-json/wp/v2/taxonomies endpoint could not be read: %s', 'utkwds' ), $taxonomies_raw->get_error_message() )
		);
	}

	// Keep Category, Tag and Location first, then anything else attached to posts.
	$preferred  = array_keys( utkwds_torch_stories_internal_taxonomies() );
	$taxonomies = array();

	foreach ( $taxonomies_raw as $slug => $taxonomy ) {
		if ( empty( $taxonomy['rest_base'] ) || 'post_format' === $slug ) {
			continue;
		}

		// Taxonomies registered by plugins may live outside wp/v2 (WP 5.9+).
		$namespace = isset( $taxonomy['rest_namespace'] ) ? preg_replace( '#[^a-z0-9_/.-]#i', '', trim( $taxonomy['rest_namespace'], '/' ) ) : '';

		$taxonomies[] = array(
			'slug'           => sanitize_key( $slug ),
			'name'           => sanitize_text_field( isset( $taxonomy['name'] ) ? $taxonomy['name'] : $slug ),
			'rest_base'      => sanitize_key( $taxonomy['rest_base'] ),
			'rest_namespace' => $namespace ? $namespace : 'wp/v2',
		);
	}

	if ( empty( $taxonomies ) ) {
		return new WP_Error(
			'utkwds_torch_stories_no_taxonomies',
			__( 'This site does not list any taxonomies for its posts, so there is nothing to filter stories by.', 'utkwds' )
		);
	}

	usort(
		$taxonomies,
		function ( $a, $b ) use ( $preferred ) {
			$a_pos = array_search( $a['slug'], $preferred, true );
			$b_pos = array_search( $b['slug'], $preferred, true );
			$a_pos = false === $a_pos ? 99 : $a_pos;
			$b_pos = false === $b_pos ? 99 : $b_pos;

			return $a_pos === $b_pos ? strcmp( $a['name'], $b['name'] ) : $a_pos - $b_pos;
		}
	);

	$site = array(
		'url'         => $site_url,
		'root'        => esc_url_raw( $root ),
		'name'        => isset( $index['name'] ) ? sanitize_text_field( html_entity_decode( $index['name'], ENT_QUOTES, 'UTF-8' ) ) : '',
		'description' => isset( $index['description'] ) ? sanitize_text_field( html_entity_decode( $index['description'], ENT_QUOTES, 'UTF-8' ) ) : '',
		'taxonomies'  => $taxonomies,
	);

	set_transient( $cache_key, $site, 12 * HOUR_IN_SECONDS );

	return $site;
}

/**
 * Get the REST base for a taxonomy on a validated remote site.
 *
 * @param array  $site      Result of utkwds_torch_stories_get_remote_site().
 * @param string $rest_base Requested REST base.
 * @return string Matching REST base, or '' when the site does not offer it.
 */
function utkwds_torch_stories_remote_rest_base( $site, $rest_base ) {
	$taxonomy = utkwds_torch_stories_remote_taxonomy( $site, $rest_base );

	return $taxonomy ? $taxonomy['rest_base'] : '';
}

/**
 * Get a taxonomy record from a validated remote site by REST base.
 *
 * @param array  $site      Result of utkwds_torch_stories_get_remote_site().
 * @param string $rest_base Requested REST base.
 * @return array|null { slug, name, rest_base, rest_namespace } or null.
 */
function utkwds_torch_stories_remote_taxonomy( $site, $rest_base ) {
	foreach ( $site['taxonomies'] as $taxonomy ) {
		if ( $taxonomy['rest_base'] === $rest_base ) {
			if ( empty( $taxonomy['rest_namespace'] ) ) {
				$taxonomy['rest_namespace'] = 'wp/v2';
			}
			return $taxonomy;
		}
	}

	return null;
}

/**
 * List terms for a taxonomy on a remote site.
 *
 * @param string $site_url  Site URL.
 * @param string $rest_base Taxonomy REST base (e.g. `categories`).
 * @param string $search    Optional search string.
 * @return array|WP_Error List of { id, name, count }.
 */
function utkwds_torch_stories_get_remote_terms( $site_url, $rest_base, $search = '' ) {
	$site = utkwds_torch_stories_get_remote_site( $site_url );

	if ( is_wp_error( $site ) ) {
		return $site;
	}

	$rest_base = utkwds_torch_stories_remote_rest_base( $site, sanitize_key( $rest_base ) );

	if ( '' === $rest_base ) {
		return new WP_Error( 'utkwds_torch_stories_invalid_taxonomy', __( 'That taxonomy is not available on the selected site.', 'utkwds' ) );
	}

	$search    = sanitize_text_field( $search );
	$cache_key = 'utkwds_torch_stories_terms_' . md5( $site['url'] . '|' . $rest_base . '|' . $search );
	$cached    = get_transient( $cache_key );

	// Use cached terms if already saved.
	if ( is_array( $cached ) ) {
		return $cached;
	}

	$args = array(
		'per_page'   => 100,
		'hide_empty' => 'true',
		'orderby'    => 'count',
		'order'      => 'desc',
		'_fields'    => 'id,name,count',
	);

	if ( '' !== $search ) {
		$args['search']  = $search;
		$args['orderby'] = 'name';
		$args['order']   = 'asc';
	}

	$taxonomy = utkwds_torch_stories_remote_taxonomy( $site, $rest_base );
	$raw      = utkwds_torch_stories_remote_json( utkwds_torch_stories_route_url( $site['root'], '/' . $taxonomy['rest_namespace'] . '/' . $rest_base, $args ) );

	if ( is_wp_error( $raw ) ) {
		return $raw;
	}

	$terms = array();

	foreach ( $raw as $term ) {
		if ( empty( $term['id'] ) ) {
			continue;
		}

		$terms[] = array(
			'id'    => (int) $term['id'],
			'name'  => sanitize_text_field( html_entity_decode( isset( $term['name'] ) ? $term['name'] : '', ENT_QUOTES, 'UTF-8' ) ),
			'count' => isset( $term['count'] ) ? (int) $term['count'] : 0,
		);
	}

	// Cache terms for 1 hour.
	set_transient( $cache_key, $terms, HOUR_IN_SECONDS );

	return $terms;
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
 * Pick the best image data from an embedded REST media object.
 *
 * @param array $media `_embedded['wp:featuredmedia'][0]`.
 * @return array|null
 */
function utkwds_torch_stories_remote_image( $media ) {
	if ( empty( $media['source_url'] ) ) {
		return null;
	}

	$sizes  = isset( $media['media_details']['sizes'] ) && is_array( $media['media_details']['sizes'] ) ? $media['media_details']['sizes'] : array();
	$chosen = null;

	foreach ( array( 'large', 'medium_large', 'full' ) as $size ) {
		if ( ! empty( $sizes[ $size ]['source_url'] ) ) {
			$chosen = $sizes[ $size ];
			break;
		}
	}

	$srcset = array();

	foreach ( $sizes as $name => $size ) {
		if ( 'thumbnail' === $name || empty( $size['source_url'] ) || empty( $size['width'] ) ) {
			continue;
		}
		$srcset[ (int) $size['width'] ] = esc_url_raw( $size['source_url'] ) . ' ' . (int) $size['width'] . 'w';
	}

	ksort( $srcset );

	return array(
		'url'    => esc_url_raw( $chosen ? $chosen['source_url'] : $media['source_url'] ),
		'alt'    => isset( $media['alt_text'] ) ? sanitize_text_field( $media['alt_text'] ) : '',
		'width'  => $chosen && ! empty( $chosen['width'] ) ? (int) $chosen['width'] : ( isset( $media['media_details']['width'] ) ? (int) $media['media_details']['width'] : 0 ),
		'height' => $chosen && ! empty( $chosen['height'] ) ? (int) $chosen['height'] : ( isset( $media['media_details']['height'] ) ? (int) $media['media_details']['height'] : 0 ),
		'srcset' => implode( ', ', $srcset ),
	);
}

/**
 * Handle caching of stories from remote site.
 *
 * Fresh results are cached for 15 minutes.
 * A stale copy is kept for a week and used when the remote site can't be reached.
 *
 * @param string $site_url  Site URL.
 * @param string $rest_base Taxonomy REST base (e.g. `categories`).
 * @param int    $term_id   Remote term ID, or 0 for the most recent posts.
 * @param int    $count     Number of stories.
 * @return array[] Stories (empty on failure with no stale copy).
 */
function utkwds_torch_stories_get_remote_stories( $site_url, $rest_base, $term_id, $count = 3 ) {
	$site_url  = utkwds_torch_stories_normalize_site_url( $site_url );
	$rest_base = sanitize_key( $rest_base );
	$term_id   = (int) $term_id;

	if ( '' === $site_url ) {
		return array();
	}

	$key       = md5( $site_url . '|' . $rest_base . '|' . $term_id . '|' . $count );
	$fresh_key = 'utkwds_torch_stories_posts_' . $key;
	$stale_key = 'utkwds_torch_stories_posts_stale_' . $key;

	$cached = get_transient( $fresh_key );

	if ( is_array( $cached ) ) {
		return $cached;
	}

	$stories = utkwds_torch_stories_fetch_remote_stories( $site_url, $rest_base, $term_id, $count );

	if ( is_wp_error( $stories ) ) {
		$stale = get_transient( $stale_key );

		// Retry in 5 minutes rather than on every page view.
		$fallback = is_array( $stale ) ? $stale : array();
		set_transient( $fresh_key, $fallback, 5 * MINUTE_IN_SECONDS );

		return $fallback;
	}

	set_transient( $fresh_key, $stories, 15 * MINUTE_IN_SECONDS );
	set_transient( $stale_key, $stories, WEEK_IN_SECONDS );

	return $stories;
}

/**
 * Fetch stories from a remote site.
 *
 * @param string $site_url  Normalized site URL.
 * @param string $rest_base Taxonomy REST base.
 * @param int    $term_id   Remote term ID or 0.
 * @param int    $count     Number of stories.
 * @return array[]|WP_Error
 */
function utkwds_torch_stories_fetch_remote_stories( $site_url, $rest_base, $term_id, $count ) {
	$site = utkwds_torch_stories_get_remote_site( $site_url );

	if ( is_wp_error( $site ) ) {
		return $site;
	}

	$args = array(
		'per_page' => $count,
		'orderby'  => 'date',
		'order'    => 'desc',
		'_embed'   => 'wp:featuredmedia,wp:term',
	);

	if ( $term_id ) {
		$rest_base = utkwds_torch_stories_remote_rest_base( $site, $rest_base );

		if ( '' === $rest_base ) {
			return new WP_Error( 'utkwds_torch_stories_invalid_taxonomy', 'Taxonomy not available on remote site.' );
		}

		$args[ $rest_base ] = $term_id;
	}

	$posts = utkwds_torch_stories_remote_json( utkwds_torch_stories_route_url( $site['root'], '/wp/v2/posts', $args ) );

	if ( is_wp_error( $posts ) ) {
		return $posts;
	}

	$date_format = get_option( 'date_format' );
	$stories     = array();

	foreach ( $posts as $post ) {
		if ( ! is_array( $post ) || empty( $post['link'] ) ) {
			continue;
		}

		$story = utkwds_torch_stories_empty_story();

		$story['title']   = html_entity_decode( wp_strip_all_tags( isset( $post['title']['rendered'] ) ? $post['title']['rendered'] : '' ), ENT_QUOTES, 'UTF-8' );
		$story['url']     = esc_url_raw( $post['link'] );
		$story['excerpt'] = utkwds_torch_stories_trim_excerpt( isset( $post['excerpt']['rendered'] ) ? $post['excerpt']['rendered'] : '' );

		if ( ! empty( $post['date'] ) ) {
			$timestamp = strtotime( $post['date'] );

			if ( $timestamp ) {
				$story['date']         = gmdate( 'Y-m-d\TH:i:s', $timestamp );
				$story['date_display'] = date_i18n( $date_format, $timestamp );
			}
		}

		if ( ! empty( $post['_embedded']['wp:featuredmedia'][0] ) ) {
			$story['image'] = utkwds_torch_stories_remote_image( $post['_embedded']['wp:featuredmedia'][0] );
		}

		if ( ! empty( $post['_embedded']['wp:term'] ) && is_array( $post['_embedded']['wp:term'] ) ) {
			foreach ( $post['_embedded']['wp:term'] as $group ) {
				foreach ( (array) $group as $term ) {
					if ( isset( $term['taxonomy'] ) && 'category' === $term['taxonomy'] && ! empty( $term['name'] ) ) {
						$story['categories'][] = array(
							'name' => html_entity_decode( $term['name'], ENT_QUOTES, 'UTF-8' ),
							'url'  => isset( $term['link'] ) ? esc_url_raw( $term['link'] ) : '',
						);
					}
				}
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

	$source = isset( $attributes['sourceType'] ) && 'external' === $attributes['sourceType'] ? 'external' : 'internal';

	if ( 'external' === $source ) {
		$posts = empty( $attributes['externalUrl'] )
			? array()
			: utkwds_torch_stories_get_remote_stories(
				$attributes['externalUrl'],
				isset( $attributes['externalTaxonomy'] ) ? $attributes['externalTaxonomy'] : 'categories',
				isset( $attributes['externalTermId'] ) ? (int) $attributes['externalTermId'] : 0
			);
	} else {
		$posts = utkwds_torch_stories_get_local_stories(
			isset( $attributes['taxonomy'] ) ? $attributes['taxonomy'] : 'category',
			isset( $attributes['termId'] ) ? (int) $attributes['termId'] : 0
		);
	}

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

/**
 * Register REST routes used by the block editor UI
 * and proxy remote requests through the server to prevent
 * cross-site CORS issues.
 */
function utkwds_torch_stories_register_rest_routes() {
	$permission = function () {
		return current_user_can( 'edit_posts' );
	};

	register_rest_route(
		'utk-wds/v1',
		'/torch-stories/site',
		array(
			'methods'             => WP_REST_Server::READABLE,
			'permission_callback' => $permission,
			'args'                => array(
				'url'     => array(
					'type'     => 'string',
					'required' => true,
				),
				'refresh' => array(
					'type'    => 'boolean',
					'default' => false,
				),
			),
			'callback'            => function ( WP_REST_Request $request ) {
				$site = utkwds_torch_stories_get_remote_site( $request['url'], (bool) $request['refresh'] );

				if ( is_wp_error( $site ) ) {
					$site->add_data( array( 'status' => 400 ) );
					return $site;
				}

				unset( $site['root'] );

				return rest_ensure_response( $site );
			},
		)
	);

	register_rest_route(
		'utk-wds/v1',
		'/torch-stories/terms',
		array(
			'methods'             => WP_REST_Server::READABLE,
			'permission_callback' => $permission,
			'args'                => array(
				'url'      => array(
					'type'     => 'string',
					'required' => true,
				),
				'taxonomy' => array(
					'type'     => 'string',
					'required' => true,
				),
				'search'   => array(
					'type'    => 'string',
					'default' => '',
				),
			),
			'callback'            => function ( WP_REST_Request $request ) {
				$terms = utkwds_torch_stories_get_remote_terms( $request['url'], $request['taxonomy'], $request['search'] );

				if ( is_wp_error( $terms ) ) {
					$terms->add_data( array( 'status' => 400 ) );
					return $terms;
				}

				return rest_ensure_response( $terms );
			},
		)
	);
}
add_action( 'rest_api_init', 'utkwds_torch_stories_register_rest_routes' );
