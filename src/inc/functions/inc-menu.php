<?php

function utkwds_register_menus() {

  register_nav_menus(
    array(
      'primary' => __( 'Main Nav Menu', 'utkwds' ),
      'utility' => __( 'Utility Nav Menu', 'utkwds' ),
    )
  );

}

add_action( 'after_setup_theme', 'utkwds_register_menus' );