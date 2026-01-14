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
