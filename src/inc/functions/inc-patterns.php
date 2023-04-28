<?php

function utkwds_register_block_pattern_categories() {

  $block_pattern_categories = array(

    'cards' => array(
			'label'       => __( 'Cards', 'utkwds' ),
      'description' => __( 'Card groups and patterns', 'utkwds' ),
		),
    'divider' => array(
      'label'       => __( 'Divider', 'utkwds' ),
      'description' => __( 'Separate sections of content', 'utkwds' ),
    )
  );

  foreach ( $block_pattern_categories as $name => $properties ) {
		register_block_pattern_category( $name, $properties );
	}
}

add_action( 'init', 'utkwds_register_block_pattern_categories' );