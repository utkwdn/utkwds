<?php

function utkwds_customize_register ( $wp_customize ) {

  $wp_customize->add_section( 'post_article_settings', array(
    'title' => __('Post Article Settings', 'utkwds'),
    'description' => __('Settings for the Post Article page template and archive.', 'utkwds')
  ));


  $wp_customize->add_setting( 'show_author', array(
    'default' => 'show',
    'transport' => 'refresh'
  ));

  $wp_customize->add_control( 'show_author', array(
    'label' => __('Post Article Author', 'utkwds'),
    'section' => 'post_article_settings',
    'settings' => 'show_author',
    'default' => 'hide',
    'type' => 'radio',
    'choices' => array(
      'show' => 'Show',
      'hide' => 'Hide',
    )
  ));

  $wp_customize->add_setting( 'show_date', array(
    'default' => 'show',
    'transport' => 'refresh'
  ));

  $wp_customize->add_control( 'show_date', array(
    'label' => __('Post Article Date', 'utkwds'),
    'section' => 'post_article_settings',
    'settings' => 'show_date',
    'default' => 'hide',
    'type' => 'radio',
    'choices' => array(
      'show' => 'Show',
      'hide' => 'Hide',
    )
  ));

}

add_action( 'customize_register', 'utkwds_customize_register' );