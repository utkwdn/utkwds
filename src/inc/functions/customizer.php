<?php

function utkwds_customize_register ( $wp_customize ) {

  $wp_customize->add_setting( 'parent_label', array(
    'default' => '',
    'sanitize_callback' => 'wp_filter_nohtml_kses',
  ));

  $wp_customize->add_control( 'parent_label', array(
    'label' => __('Parent Label', 'utkwds'),
    'section' => 'title_tagline',
    'type' => 'text',
  ));

  $wp_customize->add_setting( 'parent_link', array(
    'default' => '',
    'sanitize_callback' => 'esc_url_raw',
  ));

  $wp_customize->add_control( 'parent_link', array(
    'label' => __('Parent Link', 'utkwds'),
    'section' => 'title_tagline',
    'type' => 'url',
  ));

  $wp_customize->add_section( 'post_article_settings', array(
    'title' => __('Post Article Settings', 'utkwds'),
    'description' => __('Settings for the Post Article page template and archive.', 'utkwds')
  ));

  $wp_customize->add_setting( 'show_author', array(
    'default' => 'show',
    'sanitize_callback' => 'utkwds_sanitize_radio'
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

  $wp_customize->add_setting( 'show_categories', array(
    'default' => 'show',
    'sanitize_callback' => 'utkwds_sanitize_radio'
  ));

  $wp_customize->add_control( 'show_categories', array(
    'label' => __('Post Article Categories', 'utkwds'),
    'section' => 'post_article_settings',
    'settings' => 'show_categories',
    'default' => 'hide',
    'type' => 'radio',
    'choices' => array(
      'show' => 'Show',
      'hide' => 'Hide',
    )
  ));

  $wp_customize->add_setting( 'show_date', array(
    'default' => 'show',
    'sanitize_callback' => 'utkwds_sanitize_radio'
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


  // Utility Menu Settings
  $wp_customize->add_section( 'utility_menu_settings', array(
    'title' => __('Utility Menu Settings', 'utkwds'),
    'description' => __('Change the default urls for the Utility Menu.', 'utkwds')
  ));

  $wp_customize->add_setting( 'utility_menu_request_info', array(
    'default' => '',
    'sanitize_callback' => 'esc_url_raw',
  ));

  $wp_customize->add_control( 'utility_menu_request_info', array(
    'label' => __('Request Info', 'utkwds'),
    'section' => 'utility_menu_settings',
    'type' => 'url',
  ));

  $wp_customize->add_setting( 'utility_menu_visit', array(
    'default' => '',
    'sanitize_callback' => 'esc_url_raw',
  ));

  $wp_customize->add_control( 'utility_menu_visit', array(
    'label' => __('Visit', 'utkwds'),
    'section' => 'utility_menu_settings',
    'type' => 'url',
  ));

  $wp_customize->add_setting( 'utility_menu_apply', array(
    'default' => '',
    'sanitize_callback' => 'esc_url_raw',
  ));

  $wp_customize->add_control( 'utility_menu_apply', array(
    'label' => __('Apply', 'utkwds'),
    'section' => 'utility_menu_settings',
    'type' => 'url',
  ));

  $wp_customize->add_setting( 'utility_menu_give', array(
    'default' => '',
    'sanitize_callback' => 'esc_url_raw',
  ));

  $wp_customize->add_control( 'utility_menu_give', array(
    'label' => __('Give', 'utkwds'),
    'section' => 'utility_menu_settings',
    'type' => 'url',
  ));

  // Contact Info Settings
  $wp_customize->add_section( 'contact_info_settings', array(
    'title' => __('Contact Info Settings', 'utkwds'),
    'description' => __('Settings for the Contact Info in the Footer.', 'utkwds')
  ));
  
  $wp_customize->add_setting( 'address', array(
    'default' => '',
    'sanitize_callback' => 'wp_kses_post',
  ));

  $wp_customize->add_control( 'address', array(
    'label' => __('Address', 'utkwds'),
    'section' => 'contact_info_settings',
    'type' => 'textarea',
  ));

  $wp_customize->add_setting( 'email_label', array(
    'default' => 'Email',
    'sanitize_callback' => 'wp_filter_nohtml_kses',
  ));

  $wp_customize->add_control( 'email_label', array(
    'label' => __('Email Label', 'utkwds'),
    'default' => 'Email',
    'section' => 'contact_info_settings',
    'type' => 'text',
  ));

  $wp_customize->add_setting( 'email_address', array(
    'default' => '',
    'sanitize_callback' => 'sanitize_email',
  ));

  $wp_customize->add_control( 'email_address', array(
    'label' => __('Email Address', 'utkwds'),
    'section' => 'contact_info_settings',
    'type' => 'email',
  ));

  $wp_customize->add_setting( 'phone_label_1', array(
    'default' => '',
    'sanitize_callback' => 'wp_filter_nohtml_kses',
  ));

  $wp_customize->add_control( 'phone_label_1', array(
    'label' => __('Phone Label 1', 'utkwds'),
    'section' => 'contact_info_settings',
    'type' => 'text',
  ));

  $wp_customize->add_setting( 'phone_number_1', array(
    'default' => '',
    'sanitize_callback' => 'sanitize_text_field',
  ));
  
  $wp_customize->add_control( 'phone_number_1', array(
    'label' => __('Phone Number 1', 'utkwds'),
    'section' => 'contact_info_settings',
    'type' => 'tel',
  ));

  $wp_customize->add_setting( 'phone_label_2', array(
    'default' => '',
    'sanitize_callback' => 'wp_filter_nohtml_kses',
  ));

  $wp_customize->add_control( 'phone_label_2', array(
    'label' => __('Phone Label 2', 'utkwds'),
    'section' => 'contact_info_settings',
    'type' => 'text',
  ));

  $wp_customize->add_setting( 'phone_number_2', array(
    'default' => '',
    'sanitize_callback' => 'sanitize_text_field',
  ));
  
  $wp_customize->add_control( 'phone_number_2', array(
    'label' => __('Phone Number 2', 'utkwds'),
    'section' => 'contact_info_settings',
    'type' => 'tel',
  ));

  $wp_customize->add_setting( 'phone_label_3', array(
    'default' => '',
    'sanitize_callback' => 'wp_filter_nohtml_kses',
  ));

  $wp_customize->add_control( 'phone_label_3', array(
    'label' => __('Phone Label 3', 'utkwds'),
    'section' => 'contact_info_settings',
    'type' => 'text',
  ));

  $wp_customize->add_setting( 'phone_number_3', array(
    'default' => '',
    'sanitize_callback' => 'sanitize_text_field',
  ));
  
  $wp_customize->add_control( 'phone_number_3', array(
    'label' => __('Phone Number 3', 'utkwds'),
    'section' => 'contact_info_settings',
    'type' => 'tel',
  ));

  $wp_customize->add_setting( 'social_url_x', array(
    'default' => '',
    'sanitize_callback' => 'esc_url_raw',
  ));

  $wp_customize->add_control( 'social_url_x', array(
    'label' => __('Twitter/X URL', 'utkwds'),
    'section' => 'contact_info_settings',
    'type' => 'url',
  ));

  $wp_customize->add_setting( 'social_url_facebook', array(
    'default' => '',
    'sanitize_callback' => 'esc_url_raw',
  ));

  $wp_customize->add_control( 'social_url_facebook', array(
    'label' => __('Facebook URL', 'utkwds'),
    'section' => 'contact_info_settings',
    'type' => 'url',
  ));

  $wp_customize->add_setting( 'social_url_youtube', array(
    'default' => '',
    'sanitize_callback' => 'esc_url_raw',
  ));

  $wp_customize->add_control( 'social_url_youtube', array(
    'label' => __('YouTube URL', 'utkwds'),
    'section' => 'contact_info_settings',
    'type' => 'url',
  ));

  $wp_customize->add_setting( 'social_url_instagram', array(
    'default' => '',
    'sanitize_callback' => 'esc_url_raw',
  ));

  $wp_customize->add_control( 'social_url_instagram', array(
    'label' => __('Instagram URL', 'utkwds'),
    'section' => 'contact_info_settings',
    'type' => 'url',
  ));
  
  $wp_customize->add_setting( 'social_url_linkedin', array(
    'default' => '',
    'sanitize_callback' => 'esc_url_raw',
  ));

  $wp_customize->add_control( 'social_url_linkedin', array(
    'label' => __('LinkedIn URL', 'utkwds'),
    'section' => 'contact_info_settings',
    'type' => 'url',
  ));

}

add_action( 'customize_register', 'utkwds_customize_register' );

//radio box sanitization function
function utkwds_sanitize_radio( $input, $setting ){
          
  //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
  $input = sanitize_key($input);

  //get the list of possible radio box options 
  $choices = $setting->manager->get_control( $setting->id )->choices;
                    
  //return input if valid or return default option
  return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
    
}
