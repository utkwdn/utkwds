<?php

remove_action( 'enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets' );

// TODO remove various block appearnce settings from editors
// https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-appearance

function utkwds_filter_theme_json_data_theme( $theme_json ) {

  $is_administrator = current_user_can( 'edit_theme_options' );

  if ( $is_administrator ) {
    return $theme_json;
  }

  $new_data = array(
    "settings" => array(
      "appearanceTools" => false,
      "border" => array(
        "color" => false,
        "radius" => false,
        "style" => false,
        "width" => false,
      ),
      "color" => array(
        "custom" => false,
        "customDuotone" => false,
        "customGradient" => false,
        "defaultDuotone" => false,
        "defaultGradient" => false,
        "defaultPalette" => false,
      ),
    ),
  );
  
  return $theme_json->update_with( $new_data );
}

add_filter( 'wp_theme_json_data_theme', 'utkwds_filter_theme_json_data_theme' );