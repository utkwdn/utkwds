<?php

declare( strict_types=1 );

/**
 * Class UTKWDS_Kitchensink_Command
 *
 * This CLI command adds or removes kitchensink content to the database.
 * This is useful for testing and development.
 *
 * wp-env run cli wp utkwds kitchen-sink add
 * wp-env run cli wp utkwds kitchen-sink remove
 * wp-env run cli wp post list --post_type=page --meta_key=kitchensink --fields=ID,url,post_title --format=json > exported_pages.json
 *
 * @package UTKWDS_HDS\Blocks\Commands
 */
class UTKWDS_Kitchensink_Command {

	/**
	 * Post types to generate kitchen-sink pages for.
	 *
	 * @var array
	 */
	private array $post_types = array( 'page' );

	/**
	 * Array of block patterns.
	 *
	 * @var array
	 */
	private array $patterns;

	/**
	 * Get the patterns and post types we are dealing with.
	 */
	public function __construct() {
		$this->patterns = $this->get_patterns();
		foreach ( $this->patterns as $pattern ) {
			$pattern['postTypes'] = array( 'page' );
		}
	}

	/**
	 * Add a whole mess o' pages.
	 *
	 * @return void
	 */
	public function add() {
		// Initialize a counter.
		$count = 0;

		// If we are running this again start from a clean slate.
		$this->remove();

		// Add all patterns for a page.
		foreach ( $this->post_types as $post_type ) {
			$id = wp_insert_post(
				array(
					'post_title'   => sprintf( __( '%s All Patterns KitchenSink', 'utkwds-hds' ), ucfirst( $post_type ) ),
					// 'post_type'    => $post_type,
					'post_type'    => 'page',
					'post_status'  => 'publish',
					'post_content' => $this->get_content( $post_type ),
				)
			);

			update_post_meta( $id, 'kitchensink', true );
			++$count;
			\WP_CLI::log( 'Created Kitchen Sink' );
		}

		$amount   = count( $this->patterns );
		$progress = \WP_CLI\Utils\make_progress_bar( 'Generating pattern pages', $amount );

		// Add 1 page for each pattern.
		foreach ( $this->patterns as $pattern ) {

			$id = wp_insert_post(
				array(
					'post_title'    => sprintf( __( '%s Pattern KitchenSink', 'utkwds-hds' ), esc_attr( $pattern['title'] ) ),
					// 'post_type'    => current( $pattern['postTypes'] ),
						'post_type' => 'page',
					'post_status'   => 'publish',
					'post_content'  => $pattern['content'],
				)
			);

			update_post_meta( $id, 'kitchensink', true );
			++$count;
			$progress->tick();

		}

		$progress->finish();

		\WP_CLI::success( "Added {$count} pages." );
	}

	/**
	 * Remove whatever we added via this.
	 *
	 * @return void
	 */
	public function remove() {
		$posts = get_posts( // phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.get_posts_get_posts
			array(
				'post_status' => 'publish',
				'numberposts' => 500, // phpcs:ignore WordPress.WP.PostsPerPage.posts_per_page_numberposts
				'meta_key'    => 'kitchensink',
				'post_type'   => 'any',
				'meta_value'  => true, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
			)
		);
		foreach ( $posts as $post ) {
			wp_delete_post( $post->ID, true );
		}

		\WP_CLI::success( 'Removed all pages.' );
	}

	/**
	 * Retrieve all usable patterns.
	 *
	 * @return array
	 */
	private function get_patterns(): array {

		// Get all utkwds patterns in block pattern category.
		$get_patterns = \WP_Block_Patterns_Registry::get_instance()->get_all_registered();

		// Check the category (utkwds-patterns/block-name).
		$pattern_names = array_map(
			function ( array $pattern ) {

				if ( $pattern['inserter'] == false ) {
					return null;
				}

				return $pattern;
			},
			$get_patterns
		);

		// Remove null values.
		return array_filter( $pattern_names );
	}

	/**
	 * Get combined content for a post type.
	 *
	 * @param string $post_type Post type.
	 *
	 * @return string
	 */
	private function get_content( $post_type ): string {
		$content = '';
		foreach ( $this->patterns as $pattern ) {
			$content .= $pattern['content'];
		}

		return $content;
	}
}

WP_CLI::add_command( 'utkwds kitchen-sink', 'UTKWDS_Kitchensink_Command' );
