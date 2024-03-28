<?php

/**
 * Theme update based on https://rudrastyh.com/wordpress/theme-updates-from-custom-server.html.
 */

add_filter( 'site_transient_update_themes', 'utkwds_update_theme' );

function utkwds_update_theme( $transient ) {

  $stylesheet = get_template();

  $theme = wp_get_theme();
  $version = $theme->get( 'Version' );
  
  if ( false == $remote = get_transient( 'utkwds_update_theme'.$version ) ) {

    $remote = wp_remote_get(
      'https://raw.githubusercontent.com/utkwdn/utkwds/main/info.json',
      array(
        'timeout' => 10,
        'headers' => array(
          'Accept' => 'application/json'
        )
      )
    );
        
    if( is_wp_error( $remote ) 
      || 200 !== wp_remote_retrieve_response_code( $remote )
      || empty( wp_remote_retrieve_body( $remote ) )
    ) {
      return $transient;
    }
          
    // encode the response body
    $remote = json_decode( wp_remote_retrieve_body( $remote ) );
      
    if( ! $remote ) {
      return $transient; // who knows, maybe JSON is not valid
    }
      
    // set the response transient for theme performance, 12 hours
    set_transient( 'utkwds_update_theme'.$version, $remote, 43200);

  }
      
  $data = array(
    'theme'        => $stylesheet,
    'url'          => $remote->details_url,
    'new_version'  => $remote->version,
    'package'      => $remote->download_url
  );

  if ( ! is_array( $transient->response ) ) {
    $transient = new \stdClass();
  }

  if( $remote && version_compare( $version, $remote->version, '<' ) ) {
    
    $transient->response[ $stylesheet ] = $data;
  } else {

    $transient->no_update[ $stylesheet ] = $data;
  }

  return $transient;

}