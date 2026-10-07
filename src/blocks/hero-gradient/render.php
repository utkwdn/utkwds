<?php
/**
 * Server render for the Gradient Hero block.
 *
 * The following variables are exposed to the file:
 *   $attributes (array): The block attributes.
 *   $content (string): The block default content.
 *   $block (WP_Block): The block instance.
 *
 * Markup is mirrored in edit.js so style.scss applies in both places. The
 * data-animate attribute only exists here, so the hidden pre-animation state
 * never applies in the editor.
 *
 * @package utkwds
 */

$utkwds_hg_media_id   = isset( $attributes['mediaId'] ) ? absint( $attributes['mediaId'] ) : 0;
$utkwds_hg_media_url  = isset( $attributes['mediaUrl'] ) ? $attributes['mediaUrl'] : '';
$utkwds_hg_fade       = ! empty( $attributes['smokeyFade'] );
$utkwds_hg_heading    = isset( $attributes['heading'] ) ? $attributes['heading'] : '';
$utkwds_hg_body       = isset( $attributes['body'] ) ? $attributes['body'] : '';
$utkwds_hg_video_url  = isset( $attributes['videoUrl'] ) ? trim( $attributes['videoUrl'] ) : '';
$utkwds_hg_video_text = isset( $attributes['videoText'] ) ? $attributes['videoText'] : '';

// Decorative, above-the-fold image: empty alt, no lazy loading, high priority.
$utkwds_hg_image = '';
if ( $utkwds_hg_media_id ) {
	$utkwds_hg_image = wp_get_attachment_image(
		$utkwds_hg_media_id,
		'full',
		false,
		array(
			'class'         => 'hero-gradient__image',
			'alt'           => '',
			'sizes'         => '100vw',
			'loading'       => false,
			'fetchpriority' => 'high',
		)
	);
}

// Fall back to the stored URL if the attachment is gone, then to the theme
// placeholder (matches edit.js) so the hero never renders without a photo.
if ( ! $utkwds_hg_image ) {
	if ( ! $utkwds_hg_media_url ) {
		$utkwds_hg_media_url = get_theme_file_uri( 'assets/images/repeat-placeholder-1700x700.jpg' );
	}

	$utkwds_hg_image = sprintf(
		'<img class="hero-gradient__image" src="%s" alt="" fetchpriority="high" />',
		esc_url( $utkwds_hg_media_url )
	);
}

$utkwds_hg_overlay_class = 'hero-gradient__overlay';
if ( $utkwds_hg_fade ) {
	$utkwds_hg_overlay_class .= ' hero-gradient__overlay--smokey-fade';
}

$utkwds_hg_wrapper_attributes = get_block_wrapper_attributes(
	array( 'data-animate' => '' )
);
?>
<div <?php echo $utkwds_hg_wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php echo $utkwds_hg_image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<span class="<?php echo esc_attr( $utkwds_hg_overlay_class ); ?>" aria-hidden="true"></span>
	<div class="hero-gradient__content">
		<?php if ( '' !== trim( wp_strip_all_tags( $utkwds_hg_heading ) ) ) : ?>
			<h1 class="wp-block-heading hero-gradient__title"><?php echo wp_kses_post( $utkwds_hg_heading ); ?></h1>
		<?php endif; ?>

		<?php if ( '' !== trim( wp_strip_all_tags( $utkwds_hg_body ) ) ) : ?>
			<p class="is-style-utkwds-paragraph-large hero-gradient__body"><?php echo wp_kses_post( $utkwds_hg_body ); ?></p>
		<?php endif; ?>

		<?php if ( $utkwds_hg_video_url && '' !== trim( wp_strip_all_tags( $utkwds_hg_video_text ) ) ) : ?>
			<p class="hero-gradient__video">
				<a class="hero-gradient__video-link" href="<?php echo esc_url( $utkwds_hg_video_url ); ?>"><?php echo wp_kses_post( $utkwds_hg_video_text ); ?></a>
			</p>
		<?php endif; ?>
	</div>
</div>
