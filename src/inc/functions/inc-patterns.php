<?php

function utkwds_register_block_pattern_categories() {

  $block_pattern_categories = array(

    'banners' => array(
      'label'       => __( 'Banners', 'utkwds' ),
      'description' => __( 'Banner patterns', 'utkwds' ),
    ),
    'contact-cards' => array(
			'label'       => __( 'Contact Cards', 'utkwds' ),
      'description' => __( 'Contact card groups and patterns', 'utkwds' ),
		),
    'content-cards' => array(
      'label'       => __( 'Content Cards', 'utkwds' ),
      'description' => __( 'Content card patterns', 'utkwds' ),
    ),
    'data-elements' => array(
      'label'       => __( 'Data Elements', 'utkwds' ),
      'description' => __( 'Data element patterns', 'utkwds' ),
    ),
    'divider' => array(
      'label'       => __( 'Divider', 'utkwds' ),
      'description' => __( 'Separate sections of content', 'utkwds' ),
    ),
    'dynamic-content' => array(
      'label'       => __( 'Dynamic Content', 'utkwds' ),
      'description' => __( 'Dynamic content patterns', 'utkwds' ),
    ),
    'galleries' => array(
      'label'       => __( 'Galleries', 'utkwds' ),
      'description' => __( 'Gallery patterns', 'utkwds' ),
    ),
    'hero' => array(
      'label'       => __( 'Hero', 'utkwds' ),
      'description' => __( 'Hero patterns', 'utkwds' ),
    ),
    'links' => array(
      'label'       => __( 'Links', 'utkwds' ),
      'description' => __( 'Link patterns', 'utkwds' ),
    ),
    'quotes' => array(
      'label'       => __( 'Quotes', 'utkwds' ),
      'description' => __( 'Quote patterns', 'utkwds' ),
    ),
  );

  foreach ( $block_pattern_categories as $name => $properties ) {
		register_block_pattern_category( $name, $properties );
	}
}

add_action( 'init', 'utkwds_register_block_pattern_categories' );

// Remove WordPress pattern directory
add_filter( 'should_load_remote_block_patterns', '__return_false' );
