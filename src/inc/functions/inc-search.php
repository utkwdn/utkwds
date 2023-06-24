<?php

/**
 * Functions and hooks related to site search.
 */

 function utk_wds_google_search() {
    do_action('qm/debug', 'utk_wds_google_search');
     wp_enqueue_script( 'utk-googlecse-script',  'https://cse.google.com/cse.js?cx=da48cf0836de1c946', array(), null, true );
 }
 add_action( 'wp_enqueue_scripts', 'utk_wds_google_search' );