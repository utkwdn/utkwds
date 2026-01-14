<?php
/**
 * Houses the static \UTK\WebDesignSystem\Navigation class
 *
 * @package utkwds
 */

namespace UTK\WebDesignSystem;

use WP_Post;

require_once 'Navigation.php';

/**
 * Breadcrumbs
 *
 * Generates an array of breadcrumb links based on the current post and post type.
 */
class Breadcrumbs {
	/**
	 * Post object for the current post (if applicable)
	 * Should be set to 0 if the current query is not a post.
	 *
	 * @var WP_Post|0
	 */
	protected $post;
	/**
	 * Post type for the current post (if applicable))
	 *
	 * @var string|null
	 */
	protected $post_type;

	/** $links
	 * Array of links to be used in the menu.
	 * Items should be of the format array( 'title' => string, 'url' => string, 'isCurrent' => true|false )
	 *
	 * @var array
	 */
	protected $links;

	/**
	 * Constructor.
	 *
	 * @param WP_Post|int $custom_post Optional custom post ID or object.
	 */
	public function __construct( WP_Post|int $custom_post = 0 ) {
		global $post_type;

		$this->post = Navigation::get_current_post( $custom_post );

		if ( $post_type ) {
			$this->post_type = $post_type;
		} else {
			$this->post_type = null;
		}

		$this->links = $this->default_breadcrumb_links();
	}

	/**
	 * Get the generated breadcrumb links.
	 *
	 * @return array
	 */
	public function get_links(): array {
		return $this->links;
	}

	/**
	 * Returns the initial breadcrumb links (usually just Home).
	 *
	 * @return array
	 */
	protected function default_initial_links(): array {
		return array(
			array(
				'title'     => __( 'Home', 'utk-web-design-system' ),
				'url'       => home_url(),
				'isCurrent' => false,
			),
		);
	}

	/**
	 * Adds the current page or search results link to the breadcrumb.
	 *
	 * @param array $links Existing breadcrumb links.
	 *
	 * @return array
	 */
	protected function add_current_link( array $links ): array {
		if ( is_singular() ) {
			$current_link = Navigation::convert_post_to_link( $this->post, get_the_ID( $this->post ) );
			return array_merge( $links, array( $current_link ) );
		}

		if ( is_search() ) {
			$current_link = array(
				'title'     => __( 'Search Results', 'utk-web-design-system' ),
				'url'       => get_search_link(),
				'isCurrent' => true,
			);
			return array_merge( $links, array( $current_link ) );
		}

		return $links;
	}

	/**
	 * Generates the default breadcrumb links based on ancestors, post type, and current post.
	 *
	 * @return array
	 */
	protected function default_breadcrumb_links(): array {

		if ( ! $this->post && ! $this->post_type ) {
			do_action( 'qm/debug', 'No post or post type found for breadcrumbs.' );
			return array();
		}

		$initial_links = static::default_initial_links();

		if ( is_search() ) {
			$ancestors = array();
		} else {
			$ancestors = get_post_ancestors( $this->post );
		}

		$breadcrumb_links = array();

		if ( is_array( $ancestors ) && count( $ancestors ) > 0 ) {
			$ancestor_links   = array_map(
				function ( $ancestor ) {
					return Navigation::convert_post_to_link( $ancestor, get_the_ID( $this->post ) );
				},
				$ancestors
			);
			$breadcrumb_links = array_merge( $breadcrumb_links, $ancestor_links );
		}

		if ( $this->post_type && ! ( 'page' === $this->post_type || 'post' === $this->post_type ) ) {
			$post_type_archive_url = get_post_type_archive_link( $this->post_type );
			if ( $post_type_archive_url ) {
				$archive_links    = array(
					array(
						'title'     => get_post_type_object( $this->post_type )->labels->name,
						'url'       => $post_type_archive_url,
						'isCurrent' => is_post_type_archive( $this->post_type ) ? true : false,
					),
				);
				$breadcrumb_links = array_merge( $breadcrumb_links, $archive_links );
			}
		}

		$breadcrumb_links = array_reverse( $breadcrumb_links );

		return $this->add_current_link( array_merge( $initial_links, $breadcrumb_links ) );
	}
}
