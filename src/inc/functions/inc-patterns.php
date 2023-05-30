<?php

function utkwds_register_block_pattern_categories() {

  $block_pattern_categories = array(

    'card' => array(
			'label'       => __( 'Card', 'utkwds' ),
      'description' => __( 'Card groups and patterns', 'utkwds' ),
		),
    'content' => array(
      'label'       => __( 'Content', 'utkwds' ),
      'description' => __( 'Content patterns', 'utkwds' ),
    ),
    'divider' => array(
      'label'       => __( 'Divider', 'utkwds' ),
      'description' => __( 'Separate sections of content', 'utkwds' ),
    ),
    'hero' => array(
      'label'       => __( 'Hero', 'utkwds' ),
      'description' => __( 'Hero patterns', 'utkwds' ),
    ),
    'quote' => array(
      'label'       => __( 'Quote', 'utkwds' ),
      'description' => __( 'Quote patterns', 'utkwds' ),
    ),
  );

  foreach ( $block_pattern_categories as $name => $properties ) {
		register_block_pattern_category( $name, $properties );
	}
}

add_action( 'init', 'utkwds_register_block_pattern_categories' );