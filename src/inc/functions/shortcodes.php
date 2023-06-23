<?php

function utkwds_slate_form_embed( $atts ) {

	// Attributes
	$atts = shortcode_atts(
		array(
			'id' => '',
			'register_url' => '',
		),
		$atts,
		'slate_form'
	);

	$esc_id = esc_attr( $atts['id'] );
	$esc_register_url = esc_attr( $atts['register_url'] );

	$just_id = str_replace('form_', '', $esc_id);

	$script_url = $esc_register_url . '?id=' . $just_id . '&amp;output=embed&amp;div=' . $esc_id;

	return 
		"<div id='{$esc_id}'>Loading...</div>
		<script async='async' src='{$script_url}'></script>";

}
add_shortcode( 'slate_form', 'utkwds_slate_form_embed' );