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

	$only_id = str_replace('form_', '', $esc_id);

	$script_url = $esc_register_url . '?id=' . $only_id . '&amp;output=embed&amp;div=' . $esc_id;

  wp_enqueue_script(
    "slate-form-{$esc_id}",
    $script_url,
    array(),
    $only_id,
    array(
      'strategy' => 'async',
      'in_footer' => true,
    )
  );

	return 
		"<div class='utkwds-slate-form wp-block-group' id='{$esc_id}'>Loading...</div>";

}
add_shortcode( 'slate_form', 'utkwds_slate_form_embed' );

//add localist widget shortcode


function utkwds_localist_widget( $atts ) {

  // Attributes
  $atts = shortcode_atts(
    array(
      'results' => '10',
      'card' => 'false',
    ),
    $atts,
    'localist_widget'
  );

  $esc_results = esc_attr( $atts['results'] );

  $rand_id = wp_rand(1000000, 9999999);
  $script_url = 'https://calendar.utk.edu/widget/view?schools=utk&days=31&num='. $esc_results . '&container=localist-widget-' . $rand_id;

  if ( $atts['card'] === 'true' ) {
    $script_url .= '&template=card';
  }

  wp_enqueue_script(
    "localist-widget",
    $script_url,
    array(),
    $rand_id,
    array(
      'strategy' => 'defer',
      'in_footer' => true,
    )
  );

  return 
    "<div id='localist-widget-{$rand_id}' class='utkwds-localist-widget wp-block-group localist-widget'></div>";
}

add_shortcode( 'localist_widget', 'utkwds_localist_widget' );