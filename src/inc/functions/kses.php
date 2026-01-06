<?php
/**
 * Allow SVG tags and attributes in wp_kses.
 *
 * @package utkwds
 */

/**
 * Adds support for SVG and path elements with allowed attributes.
 *
 * @param array $tags Allowed HTML tags.
 *
 * @return array Allowed tags with SVG added.
 */
function utkwds_allow_svg( $tags ) {
	$tags['svg'] = array(
		'class'       => true,
		'aria-hidden' => true,
		'role'        => true,
		'xmlns'       => true,
		'width'       => true,
		'height'      => true,
		'viewbox'     => true,
		'fill'        => true,
		'xmlns:xlink' => true,
	);

	$tags['path'] = array(
		'd'    => true,
		'fill' => true,
	);

	return $tags;
}

add_filter( 'wp_kses_allowed_html', 'utkwds_allow_svg', 10, 2 );
