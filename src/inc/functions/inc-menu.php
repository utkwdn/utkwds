<?php

function utkwds_register_menus() {

  register_nav_menus(
    array(
      'primary' => __( 'Main Nav Menu', 'utkwds' ),
      'utility' => __( 'Utility Nav Menu', 'utkwds' ),
      'footer' => __( 'Footer Links Menu', 'utkwds' ),
    )
  );

}

add_action( 'after_setup_theme', 'utkwds_register_menus' );

function utkwds_register_naviation_limit_script( $hook ){
	
	wp_register_script( 'utkwds-navigation-limit-depth', false );
	wp_add_inline_script(
		'utkwds-navigation-limit-depth',
		'if ( typeof wpNavMenu.options.globalMaxDepth !== "undefined" ){
			wpNavMenu.options.globalMaxDepth = 1;
		}',
		'before'
	);
	
	if ( $hook == 'nav-menus.php' ) {
		wp_enqueue_script( 'utkwds-navigation-limit-depth' );
	}
}
add_action( 'admin_enqueue_scripts', 'utkwds_register_naviation_limit_script');