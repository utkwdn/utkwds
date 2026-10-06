<?php
/**
 * Server render for the Torch Stories block.
 *
 * Markup based on the Category 3up with Image pattern (patterns/category-3up-image.php)
 * Story data comes from inc/functions/torch-stories.php.
 *
 * @package utkwds
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Block content (unused).
 * @var WP_Block $block      Block instance.
 */

if ( ! function_exists( 'utkwds_torch_stories_get_block_stories' ) ) {
	return;
}

if ( ! function_exists( 'utkwds_torch_stories_render_image' ) ) {

	/**
	 * Render a story's image.
	 *
	 * @param array $story Normalized story.
	 * @return string
	 */
	function utkwds_torch_stories_render_image( $story ) {
		$img_style = 'width:100%;height:100%;object-fit:cover;aspect-ratio:3/2;';

		if ( ! empty( $story['image_id'] ) ) {
			$img = wp_get_attachment_image(
				$story['image_id'],
				'large',
				false,
				array(
					'style'   => $img_style,
					'loading' => 'lazy',
					'sizes'   => '(min-width: 600px) 33vw, 100vw',
				)
			);
		} else {
			return '';
		}

		if ( ! $img ) {
			return '';
		}

		return '<figure style="aspect-ratio:3/2;" class="wp-block-post-featured-image torch-stories__image">' . $img . '</figure>';
	}
}

$heading_style   = isset( $attributes['headingStyle'] ) ? $attributes['headingStyle'] : 'link';
$display_style   = isset( $attributes['displayStyle'] ) && '2up-alternating' === $attributes['displayStyle'] ? '2up-alternating' : '3up';
$color_scheme    = isset( $attributes['colorScheme'] ) && in_array( $attributes['colorScheme'], array( 'light-gray', 'smokey' ), true ) ? $attributes['colorScheme'] : 'white';
$heading         = isset( $attributes['heading'] ) ? wp_kses( $attributes['heading'], array( 'br' => array() ) ) : '';
$link_text       = isset( $attributes['linkText'] ) ? wp_kses( $attributes['linkText'], array() ) : '';
$link_url        = isset( $attributes['linkUrl'] ) ? $attributes['linkUrl'] : '';
$description     = isset( $attributes['description'] ) ? wp_kses_post( $attributes['description'] ) : '';
$show_date       = ! isset( $attributes['showDate'] ) || $attributes['showDate'];
$show_categories = ! isset( $attributes['showCategories'] ) || $attributes['showCategories'];
$is_editor       = defined( 'REST_REQUEST' ) && REST_REQUEST;

$stories = utkwds_torch_stories_get_block_stories( $attributes );

if ( empty( $stories ) ) {
	if ( $is_editor ) {
		printf(
			'<div %1$s><p class="torch-stories__empty">%2$s</p></div>',
			get_block_wrapper_attributes(), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			esc_html__( 'No stories found for this source. Choose a different taxonomy or term.', 'utkwds' )
		);
	}

	return;
}

// Color schemes use the theme's preset color classes, matching the light gray and smokey patterns.
$color_classes = array(
	'white'      => '',
	'light-gray' => 'has-background has-light-background-color',
	'smokey'     => 'has-background has-smokey-background-color has-text-color has-white-color',
);

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => trim( 'torch-stories torch-stories--heading-' . sanitize_html_class( $heading_style ) . ' torch-stories--layout-' . $display_style . ' torch-stories--color-' . $color_scheme . ' ' . $color_classes[ $color_scheme ] ),
	)
);
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

	<?php if ( 'link' === $heading_style && ( $heading || ( $link_text && $link_url ) ) ) : ?>
		<div class="torch-stories__heading torch-stories__heading--link">
			<?php if ( $heading ) : ?>
				<h2 class="wp-block-heading torch-stories__title"><?php echo $heading; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
			<?php endif; ?>
			<?php if ( $link_text && $link_url ) : ?>
				<p class="is-style-utkwds-single-link torch-stories__link"><a href="<?php echo esc_url( $link_url ); ?>"><?php echo $link_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></p>
			<?php endif; ?>
		</div>
	<?php elseif ( 'description' === $heading_style && ( $heading || $description ) ) : ?>
		<div class="torch-stories__heading torch-stories__heading--description">
			<div class="torch-stories__heading-col torch-stories__heading-col--title">
				<?php if ( $heading ) : ?>
					<h2 class="wp-block-heading torch-stories__title"><?php echo $heading; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
				<?php endif; ?>
			</div>
			<div class="torch-stories__heading-col torch-stories__heading-col--description">
				<?php if ( $description ) : ?>
					<p class="torch-stories__description"><?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

	<ul class="torch-stories__grid wp-block-post-template" role="list">
		<?php foreach ( $stories as $index => $story ) : ?>
			<?php
			// 2up alternating: the second story image comes after the text.
			$image_last = '2up-alternating' === $display_style && 1 === $index;
			?>
			<li class="torch-stories__story wp-block-post">
				<div class="torch-stories__card<?php echo $image_last ? ' torch-stories__card--image-last' : ''; ?>">
					<?php
					if ( ! $image_last ) {
						echo utkwds_torch_stories_render_image( $story ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
					?>

					<h3 class="wp-block-post-title heading-style--h6 torch-stories__story-title">
						<?php if ( $story['url'] ) : ?>
							<a href="<?php echo esc_url( $story['url'] ); ?>" target="_self"><?php echo esc_html( $story['title'] ); ?></a>
						<?php else : ?>
							<?php echo esc_html( $story['title'] ); ?>
						<?php endif; ?>
					</h3>

					<?php if ( $show_date && $story['date_display'] ) : ?>
						<div class="wp-block-post-date has-x-small-font-size">
							<time datetime="<?php echo esc_attr( $story['date'] ); ?>"><?php echo esc_html( $story['date_display'] ); ?></time>
						</div>
					<?php endif; ?>

					<?php if ( $story['excerpt'] ) : ?>
						<div class="wp-block-post-excerpt">
							<p class="wp-block-post-excerpt__excerpt"><?php echo esc_html( $story['excerpt'] ); ?></p>
						</div>
					<?php endif; ?>

					<?php if ( $show_categories && ! empty( $story['categories'] ) ) : ?>
						<div class="taxonomy-category wp-block-post-terms">
							<?php
							$links = array();
							foreach ( $story['categories'] as $category ) {
								$links[] = $category['url']
									? '<a href="' . esc_url( $category['url'] ) . '" rel="tag">' . esc_html( $category['name'] ) . '</a>'
									: '<span>' . esc_html( $category['name'] ) . '</span>';
							}
							echo implode( '<span class="wp-block-post-terms__separator">, </span>', $links ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
						</div>
					<?php endif; ?>

					<?php
					if ( $image_last ) {
						echo utkwds_torch_stories_render_image( $story ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
					?>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</div>