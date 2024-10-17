<?php 

add_filter( 'wp_kses_allowed_html', 'utkwds_allow_svg', 10, 2 );

function utkwds_allow_svg ( $tags ) {
  $tags['svg'] = array(
    'class' => true,
    'aria-hidden' => true,
    'role' => true,
    'xmlns' => true,
    'width' => true,
    'height' => true,
    'viewbox' => true,
    'fill' => true,
    'xmlns:xlink' => true,
  );

  $tags['path'] = array(
    'd' => true,
    'fill' => true,
  );

  $tags['button'] = array(
   'aria-selected' => true,
  );

  return $tags;
}