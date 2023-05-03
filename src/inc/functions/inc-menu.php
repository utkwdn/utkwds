<?php

function utkwds_register_menus() {

  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu', 'utkwds' ),
    )
  );

}

add_action( 'init', 'utkwds_register_menus' );