<?php

/**
 * Register block styles.
 *
 * @since 0.9.2
 */
function utkwds_register_block_styles() {

	$block_styles = array(
		'core/columns' => array(
			'columns-reverse' => __( 'Reverse', 'utkwds' ),
		),
    'core/image' => array(
      'utkwds-left-frame' => __( 'Left Frame', 'utkwds' ),
      'utkwds-right-frame' => __( 'Right Frame', 'utkwds' ),
    ),
		'core/list' => array(
			'no-disc' => __( 'No Disc', 'utkwds' ),
		),
		'core/navigation-link' => array(
			'outline' => __( 'Outline', 'utkwds' ),
		),
    'core/separator' => array(
      'utkwds-orange-separator' => __( 'Orange', 'utkwds' ),
    ),
		'core/social-links' => array(
			'outline' => __( 'Outline', 'utkwds' ),
		),
	);

	foreach ( $block_styles as $block => $styles ) {
		foreach ( $styles as $style_name => $style_label ) {
			register_block_style(
				$block,
				array(
					'name'  => $style_name,
					'label' => $style_label,
				)
			);
		}
	}
}
add_action( 'init', 'utkwds_register_block_styles' );


/**
 * Unregister block styles.
 */

function utkwds_unregister_block_styles() {
  wp_enqueue_script(
    'utkwds-unregister',
    get_stylesheet_directory_uri() . '/js/unregister.js',
    array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),
    UTKDS_VERSION,
    true
  );
}

add_action( 'enqueue_block_editor_assets', 'utkwds_unregister_block_styles' );