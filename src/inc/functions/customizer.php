<?php

function utkwds_customize_register ( $wp_customize ) {

  $wp_customize->add_section( 'news_article_settings', array(
    'title' => __('News Article Settings', 'utkwds'),
    'description' => __('Settings for the News Article page template and archive.', 'utkwds')
  ));


  $wp_customize->add_setting( 'show_author', array(
    'default' => 'show',
    'transport' => 'refresh'
  ));

  $wp_customize->add_control( 'show_author', array(
    'label' => __('News Article Author', 'utkwds'),
    'section' => 'news_article_settings',
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
    'label' => __('News Article Date', 'utkwds'),
    'section' => 'news_article_settings',
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