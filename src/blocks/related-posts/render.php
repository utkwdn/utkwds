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

$post_id    = get_the_ID();
$categories = wp_get_post_categories( $post_id, array( 'fields' => 'ids' ) );
$tags       = wp_get_post_tags( $post_id, array( 'fields' => 'ids' ) );

// Exit if we have no taxonomy terms to match against.
if ( empty( $categories ) && empty( $tags ) ) {
	return;
}

// Build the tax_query to find posts sharing categories or tags.
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

$related_query = new \WP_Query(
	array(
		'post_type'      => 'post',
		'posts_per_page' => 3,
		'post__not_in'   => array( $post_id ),
		'tax_query'      => $tax_query,
		'order'          => 'DESC',
		'orderby'        => 'date',
		'no_found_rows'  => true,
	)
);

// Exit if no related posts found.
if ( ! $related_query->have_posts() ) {
	wp_reset_postdata();
	return;
}

// Fallback placeholder image path.
$placeholder_img = get_parent_theme_file_uri( 'assets/images/image-placeholder-small.png' );

$wrapper_attributes = get_block_wrapper_attributes( array(
	'class' => 'wp-block-group alignfull utkwds-stack-3up has-light-background-color has-background has-global-padding is-layout-constrained wp-container-core-group-is-layout-dbf27b9b wp-block-group-is-layout-constrained',
	'style' => 'padding-top:var(--wp--preset--spacing--small);padding-right:var(--wp--preset--spacing--small);padding-bottom:var(--wp--preset--spacing--small);padding-left:var(--wp--preset--spacing--small)',
) );
?>

<div <?php echo $wrapper_attributes; ?>>

		<h2 class="wp-block-heading alignwide">Related News</h2>

		<div class="wp-block-columns alignwide is-layout-flex wp-container-core-columns-is-layout-28f84493 wp-block-columns-is-layout-flex">
			<?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>

				<div class="wp-block-column utkwds-stack has-white-background-color has-background is-layout-flow wp-container-core-column-is-layout-89fc711d wp-block-column-is-layout-flow" style="padding-bottom:var(--wp--preset--spacing--small)">

					<figure class="wp-block-image size-full">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'medium_large' ); ?>
						<?php else : ?>
							<img src="<?php echo esc_url( $placeholder_img ); ?>" alt="" />
						<?php endif; ?>
					</figure>

					<div class="wp-block-group is-vertical is-layout-flex wp-container-core-group-is-layout-f1d49814 wp-block-group-is-layout-flex" style="padding-right:var(--wp--preset--spacing--small);padding-bottom:0;padding-left:var(--wp--preset--spacing--small)">

						<h3 class="wp-block-post-title has-medium-font-size">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>

						<?php if ( has_excerpt() ) : ?>
							<p><?php echo esc_html( get_the_excerpt() ); ?></p>
						<?php endif; ?>

					</div>

				</div>

			<?php endwhile; ?>
		</div>
</div>

<?php
wp_reset_postdata();
