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
      'departments' => '',
      'groups' => '',
      'days' => '7',
      'tags' => '',
      'target' => '',
    ),
    $atts,
    'localist_widget'
  );

  $esc_results = esc_attr( $atts['results'] );
  $esc_departments = esc_attr( $atts['departments'] );
  $esc_groups = esc_attr( $atts['groups'] );
  $esc_days = esc_attr( $atts['days'] );
  $esc_tags = esc_attr( $atts['tags'] );
  $esc_target = esc_attr( $atts['target'] );

  if ( ! is_numeric( $esc_results ) ) {
    $esc_results = 10;
  }

  if ( $esc_results > 10 ) {
    $esc_results = 10;
  }

  $rand_id = wp_rand(1000000, 9999999);
  $script_url = 'https://calendar.utk.edu/widget/view?schools=utk&container=localist-widget-' . $rand_id;

  if ($esc_results != '10') {
    $script_url .= '&num=' . $esc_results;
  }

  if ($esc_days != '7') {
    $script_url .= '&days=' . $esc_days;
  }

  if ($esc_departments) {
    $script_url .= '&departments=' . $esc_departments;
  }

  if ($esc_groups) {
    $script_url .= '&groups=' . $esc_groups;
  }

  if ($esc_target) {
    $script_url .= '&target_blank=1';
  }

  if ($esc_tags) {

    $esc_tags = str_replace(' ', '+', $esc_tags);
    $esc_tags = str_replace(',', '%2C', $esc_tags);

    $script_url .= '&tags=' . $esc_tags;
  }

  $script_url .= '&template=modern';
  $script_url .= '&image_size=square_300';

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