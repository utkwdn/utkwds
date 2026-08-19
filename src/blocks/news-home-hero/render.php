<?php
/**
 * Server render for the News Home Hero block.
 *
 * The following variables are exposed to the file:
 *   $attributes (array): The block attributes.
 *   $content (string): The block default content.
 *   $block (WP_Block): The block instance.
 *
 * @package utkwds
 */

namespace UTK\WebDesignSystem;

if ( ! function_exists( __NAMESPACE__ . '\\nhh_get_section_posts' ) ) {

	/**
	 * Get the posts for a story section.
	 *
	 * Selection rules:
	 *  - The top story is a sticky post when one exists.
	 *  - Remaining slots are filled with the most recent posts matching category AND location.
	 *  - If no posts in the chosen category are tagged with the chosen location, the whole
	 *    section falls back to the most recent posts in the category only.
	 *
	 * @param int  $category_id Category term ID (0 = none).
	 * @param int  $location_id Locations term ID (0 = none).
	 * @param int  $count       Number of posts to return.
	 * @param bool $use_sticky  Whether to promote a matching sticky post to the top.
	 *
	 * @return \WP_Post[] Ordered array of posts.
	 */
	function nhh_get_section_posts( $category_id, $location_id, $count = 3, $use_sticky = true ) {

		$category_id = (int) $category_id;
		$location_id = (int) $location_id;

		if ( ! $category_id && ! $location_id ) {
			return array();
		}

		$base_args = array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'orderby'             => 'date',
			'order'               => 'DESC',
			'no_found_rows'       => true,
			'suppress_filters'    => false,
		);

		// Build the "category AND location" tax query.
		$tax_query = array();
		if ( $category_id ) {
			$tax_query[] = array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => array( $category_id ),
			);
		}
		if ( $location_id ) {
			$tax_query[] = array(
				'taxonomy' => 'locations',
				'field'    => 'term_id',
				'terms'    => array( $location_id ),
			);
		}
		if ( count( $tax_query ) > 1 ) {
			$tax_query['relation'] = 'AND';
		}

		// If nothing matches category AND location, use category only.
		if ( $category_id && $location_id ) {
			$post_results = get_posts(
				array_merge(
					$base_args,
					array(
						'fields'         => 'ids',
						'posts_per_page' => 1,
						'tax_query'      => $tax_query, // phpcs:ignore WordPress.DB.SlowDBQuery
					)
				)
			);

			if ( empty( $post_results ) ) {
				$tax_query = array(
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => array( $category_id ),
					),
				);
			}
		}

		$selected = array();

		// Promote a matching sticky post into the top spot.
		if ( $use_sticky ) {
			$sticky = get_option( 'sticky_posts' );
			if ( ! empty( $sticky ) ) {
				$sticky_match = get_posts(
					array_merge(
						$base_args,
						array(
							'posts_per_page' => 1,
							'post__in'       => $sticky,
							'tax_query'      => $tax_query, // phpcs:ignore WordPress.DB.SlowDBQuery
						)
					)
				);
				if ( ! empty( $sticky_match ) ) {
					$selected[] = $sticky_match[0];
				}
			}
		}

		$exclude   = wp_list_pluck( $selected, 'ID' );
		$remaining = $count - count( $selected );

		if ( $remaining > 0 ) {
			$recent   = get_posts(
				array_merge(
					$base_args,
					array(
						'posts_per_page' => $remaining,
						'post__not_in'   => $exclude,
						'tax_query'      => $tax_query, // phpcs:ignore WordPress.DB.SlowDBQuery
					)
				)
			);
			$selected = array_merge( $selected, $recent );
		}

		return $selected;
	}

	/**
	 * Render a single story used inside a three-story section.
	 *
	 * @param \WP_Post $story      The post to render.
	 * @param bool     $show_image Whether to render the featured image (first story only).
	 *
	 * @return string
	 */
	function nhh_render_story( $story, $show_image = false ) {

		$permalink = get_permalink( $story );
		$has_image = $show_image && has_post_thumbnail( $story );

		$classes = 'news-home-hero__story';
		if ( $has_image ) {
			$classes .= ' news-home-hero__story--featured';
		}

		ob_start();
		?>
		<article class="<?php echo esc_attr( $classes ); ?>">
			<?php if ( $has_image ) : ?>
				<a class="news-home-hero__story-image" href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true">
					<?php echo get_the_post_thumbnail( $story, 'medium_large' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</a>
			<?php endif; ?>
			<h6 class="news-home-hero__story-title">
				<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( get_the_title( $story ) ); ?></a>
			</h6>
			<time class="news-home-hero__story-date" datetime="<?php echo esc_attr( get_the_date( 'c', $story ) ); ?>">
				<?php echo esc_html( get_the_date( '', $story ) ); ?>
			</time>
		</article>
		<?php
		return ob_get_clean();
	}

	/**
	 * Render a three-story section (heading and up to three stories, first with image).
	 *
	 * @param int $category_id Category term ID.
	 * @param int $location_id Locations term ID.
	 *
	 * @return string
	 */
	function nhh_render_story_section( $category_id, $location_id ) {

		$stories = nhh_get_section_posts( $category_id, $location_id, 3, true );
		if ( empty( $stories ) ) {
			return '';
		}

		$heading = $category_id ? get_cat_name( (int) $category_id ) : '';

		ob_start();
		?>
		<div class="news-home-hero__section">
			<?php if ( $heading ) : ?>
				<h3 class="news-home-hero__heading utkwds-eyebrow"><?php echo esc_html( $heading ); ?></h3>
			<?php endif; ?>
			<div class="news-home-hero__stories">
				<?php
				foreach ( $stories as $index => $story ) {
					echo nhh_render_story( $story, 0 === $index ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Render the single featured (center column) story.
	 *
	 * @param int $category_id Category term ID.
	 * @param int $location_id Locations term ID.
	 *
	 * @return string
	 */
	function nhh_render_featured_story( $category_id, $location_id ) {

		$stories = nhh_get_section_posts( $category_id, $location_id, 1, false );
		if ( empty( $stories ) ) {
			return '';
		}

		$story     = $stories[0];
		$permalink = get_permalink( $story );

		ob_start();
		?>
		<article class="news-home-hero__featured">
			<h1 class="news-home-hero__featured-title">
				<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( get_the_title( $story ) ); ?></a>
			</h1>
			<?php if ( has_post_thumbnail( $story ) ) : ?>
				<a class="news-home-hero__featured-image" href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true">
					<?php echo get_the_post_thumbnail( $story, 'large' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</a>
			<?php endif; ?>
			<time class="news-home-hero__featured-date" datetime="<?php echo esc_attr( get_the_date( 'c', $story ) ); ?>">
				<?php echo esc_html( get_the_date( '', $story ) ); ?>
			</time>
			<?php $excerpt = get_the_excerpt( $story ); ?>
			<?php if ( $excerpt ) : ?>
				<p class="news-home-hero__featured-excerpt"><?php echo esc_html( $excerpt ); ?></p>
			<?php endif; ?>
			<?php
			$terms = get_the_term_list( $story->ID, 'category', '', '', '' );
			if ( $terms && ! is_wp_error( $terms ) ) :
				?>
				<div class="news-home-hero__featured-terms wp-block-group is-content-justification-left is-nowrap is-layout-flex wp-block-group-is-layout-flex">
					<div class="taxonomy-category wp-block-post-terms"><?php echo wp_kses_post( $terms ); ?></div>
				</div>
			<?php endif; ?>
		</article>
		<?php
		return ob_get_clean();
	}

	/**
	 * Fetch RSS feed items.
	 *
	 * @param string $url   Feed URL.
	 * @param int    $count Number of items to return.
	 *
	 * @return array Array of RSS item objects (empty on failure).
	 */
	function nhh_get_rss_items( $url, $count = 4 ) {

		$url = trim( (string) $url );
		if ( empty( $url ) ) {
			return array();
		}

		if ( ! function_exists( 'fetch_feed' ) ) {
			include_once ABSPATH . WPINC . '/feed.php';
		}

		$feed = fetch_feed( $url );
		if ( is_wp_error( $feed ) ) {
			return array();
		}

		$max = $feed->get_item_quantity( $count );
		if ( ! $max ) {
			return array();
		}

		return $feed->get_items( 0, $max );
	}

	/**
	 * Get source with fallbacks if 'source' tag doesn't exist in RSS item.
	 *
	 * @param Item|object $item RSS item.
	 *
	 * @return string
	 */
	function nhh_rss_item_source( $item ) {

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
}

/*
 * ---------------------------------------------------------------------------
 * Gather data.
 * ---------------------------------------------------------------------------
 */

$left_category      = isset( $attributes['leftCategory'] ) ? (int) $attributes['leftCategory'] : 0;
$left_location      = isset( $attributes['leftLocation'] ) ? (int) $attributes['leftLocation'] : 0;
$center_category    = isset( $attributes['centerCategory'] ) ? (int) $attributes['centerCategory'] : 0;
$center_location    = isset( $attributes['centerLocation'] ) ? (int) $attributes['centerLocation'] : 0;
$right_category_one = isset( $attributes['rightCategoryOne'] ) ? (int) $attributes['rightCategoryOne'] : 0;
$right_location_one = isset( $attributes['rightLocationOne'] ) ? (int) $attributes['rightLocationOne'] : 0;
$right_category_two = isset( $attributes['rightCategoryTwo'] ) ? (int) $attributes['rightCategoryTwo'] : 0;
$right_location_two = isset( $attributes['rightLocationTwo'] ) ? (int) $attributes['rightLocationTwo'] : 0;
$rss_feed_url       = isset( $attributes['rssFeedUrl'] ) ? (string) $attributes['rssFeedUrl'] : '';

$left_section      = nhh_render_story_section( $left_category, $left_location );
$right_section_one = nhh_render_story_section( $right_category_one, $right_location_one );
$right_section_two = nhh_render_story_section( $right_category_two, $right_location_two );
$featured_story    = nhh_render_featured_story( $center_category, $center_location );

$parent_categories = get_categories(
	array(
		'parent'     => 0,
		'hide_empty' => true,
		'orderby'    => 'name',
		'order'      => 'ASC',
	)
);

$rss_items = nhh_get_rss_items( $rss_feed_url, 4 );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'has-orange-background-color has-background',
	)
);
?>
<div <?php echo wp_kses_data( $wrapper_attributes ); ?>>
	<div class="news-home-hero__inner has-white-background-color has-background">
		<div class="news-home-hero__columns">

			<!-- Left column -->
			<div class="news-home-hero__column news-home-hero__column--left">
				<div class="news-home-hero__area news-home-hero__area--left-stories">
					<?php echo $left_section; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>

				<hr class="news-home-hero__separator separator-one" />

				<div class="news-home-hero__area news-home-hero__area--topics">
				<div class="news-home-hero__topics">
					<div class="news-home-hero__topics-icon">
						<svg width="126" height="125" viewBox="0 0 126 125" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Torch icon"><path d="M72.57 22.67c5.19 5.19 8.05 12.1 8.05 19.44v.52h-9.54c-3.56-.15-6.49-4.09-7.01-7.63a11.94 11.94 0 0 1-.03-3.22c.35-2.69 1.69-5.16 3.6-7.07l3.49-3.48 1.44 1.44Z" fill="#FF8200"></path><path d="M94.69 31.47c0 6.16-5 11.16-11.16 11.16h-1.24v-.52c0-7.79-3.03-15.12-8.54-20.62l-1.44-1.44.18-.18 1.1-1.17 1.28-1.28V7.79l17.08 17.09a9.268 9.268 0 0 1 2.74 6.59ZM67.01 60.91h-1.65v.01h1.65v-.01Zm22.16 0-2.26 9.37H68.92v-9.37h20.25Zm10.08-7.47h-39.4v4.98h39.4v-4.98Zm-20.88 48.73-5.26 20.36h-3.17l-.06-20.36h8.49Z" fill="#FF8200"></path><path d="M93.7 23.12 70.95.37c-.35-.36-.9-.47-1.36-.27-.46.19-.76.64-.76 1.15v16.18l-7.54 7.54a11.74 11.74 0 0 0-3.46 8.35c0 6.52 5.3 11.82 11.82 11.82l.01-.02h13.86c7.53 0 13.65-6.12 13.65-13.65 0-3.15-1.22-6.12-3.47-8.35ZM71.33 4.25h.01v.01l3.53 3.53 17.08 17.09a9.268 9.268 0 0 1 2.74 6.59c0 6.16-5 11.16-11.16 11.16h-1.24v-.52c0-7.79-3.03-15.12-8.54-20.62l-2.73-2.73c.2-.23.32-.51.32-.82V4.26l-.01-.01Zm-1.67 38.38c-5.15 0-9.33-4.18-9.33-9.33 0-2.49.97-4.84 2.73-6.6l.01.02 6.77-6.78 2.73 2.73c5.19 5.19 8.05 12.1 8.05 19.44v.52H69.66Zm30.85 8.32H54.99c-.68 0-1.24.55-1.24 1.24v7.47c0 .69.56 1.24 1.24 1.24h7.87v9.37h-5.18c-3.31 0-5.99 2.69-5.99 6v12.36l-27.44 36.36h3.36l26.23-35.04c.21-.24.32-.53.32-.83V76.27c0-1.94 1.58-3.51 3.51-3.51h22.19l-4.84 20.99 1.62.38 4.92-21.37h6.31c.39 0 .62.22.72.36.18.22.23.5.17.78L82.27 99c-.1.4-.46.67-.87.67H63.72c-.45 0-.86.25-1.08.65L50.53 125h2.86l10.55-21.88v20.64c0 .69.55 1.24 1.23 1.24h8.91c.57 0 1.06-.38 1.21-.93l5.65-21.91h.47c1.55 0 2.9-1.05 3.28-2.54l6.49-25.1c.27-1.03.04-2.09-.6-2.93-.32-.42-.73-.75-1.18-.98l2.33-9.71h8.77c.68 0 1.24-.55 1.24-1.24v-7.47c0-.69-.56-1.24-1.23-1.24Zm-34.1 51.22h11.96l-5.26 20.36h-6.7v-20.36Zm20.5-31.89H65.36v-9.37h23.81l-2.26 9.37Zm12.34-11.86H56.24v-4.98h43.01v4.98Z" fill="#4B4B4B"></path></svg>
					</div>
					<h3 class="news-home-hero__topics-heading utkwds-eyebrow">TOPICS</h3>
					<?php if ( ! empty( $parent_categories ) ) : ?>
						<ul class="news-home-hero__topics-list has-condensed-font-family">
							<?php foreach ( $parent_categories as $parent_category ) : ?>
								<li>
									<a href="<?php echo esc_url( get_category_link( $parent_category ) ); ?>">
										<?php echo esc_html( $parent_category->name ); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
				</div>
			</div>

			<!-- Center column -->
			<div class="news-home-hero__column news-home-hero__column--center">
				<div class="news-home-hero__area news-home-hero__area--featured">
					<h3 class="news-home-hero__latest-heading utkwds-eyebrow">LATEST</h3>

					<?php echo $featured_story; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>

				<hr class="news-home-hero__separator separator-two" />

				<div class="news-home-hero__area news-home-hero__area--rss">
				<h3 class="news-home-hero__rss-heading utkwds-eyebrow">UT IN THE NEWS</h3>

				<?php if ( ! empty( $rss_items ) ) : ?>
					<div class="news-home-hero__rss">
						<?php foreach ( $rss_items as $item ) : ?>
							<?php
							$item_title  = wp_strip_all_tags( $item->get_title() );
							$item_link   = $item->get_permalink();
							$item_source = nhh_rss_item_source( $item );
							?>
							<div class="news-home-hero__rss-item">
								<h6 class="news-home-hero__rss-item-title">
									<a href="<?php echo esc_url( $item_link ); ?>" target="_blank" rel="noopener noreferrer">
										<?php echo esc_html( $item_title ); ?>
									</a>
								</h6>
								<?php if ( $item_source ) : ?>
									<p class="news-home-hero__rss-item-source">Source: <?php echo esc_html( $item_source ); ?></p>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
				</div>
			</div>

			<!-- Right column -->
			<div class="news-home-hero__column news-home-hero__column--right">
				<div class="news-home-hero__area news-home-hero__area--right-top">
					<?php echo $right_section_one; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>

				<hr class="news-home-hero__separator separator-three" />

				<div class="news-home-hero__area news-home-hero__area--right-bottom">
					<?php echo $right_section_two; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			</div>

			<hr class="news-home-hero__separator separator-four" />
			<hr class="news-home-hero__separator separator-five" />

		</div>
	</div>
</div>
