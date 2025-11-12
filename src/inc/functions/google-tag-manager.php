<?php

// https://support.google.com/tagmanager/answer/14847097?sjid=6409053857287148349-NC
// https://www.simoahava.com/gtm-tips/multiple-gtm-containers-on-the-page/

function utkwds_google_tag_manager() {
	$google_tag_manager_id_1 = get_theme_mod( 'google_tag_manager_id_1' );

	if ( $google_tag_manager_id_1 ) {
		echo '<!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\'gtm.start\':
        new Date().getTime(),event:\'gtm.js\'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!=\'dataLayer\'?\'&l=\'+l:\'\';j.async=true;j.src=
        \'https://www.googletagmanager.com/gtm.js?id=\'+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,\'script\',\'dataLayer\',\'' . esc_attr( $google_tag_manager_id_1 ) . '\');</script>
        <!-- End Google Tag Manager -->';
	}
	$google_tag_manager_id_2 = get_theme_mod( 'google_tag_manager_id_2' );
	if ( $google_tag_manager_id_2 ) {
		echo '<!-- Google Tag Manager 2 -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\'gtm.start\':
        new Date().getTime(),event:\'gtm.js\'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!=\'dataLayer\'?\'&l=\'+l:\'\';j.async=true;j.src=
        \'https://www.googletagmanager.com/gtm.js?id=\'+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,\'script\',\'dataLayer\',\'' . esc_attr( $google_tag_manager_id_2 ) . '\');</script>
        <!-- End Google Tag Manager 2 -->';
	}
}

add_action( 'wp_head', 'utkwds_google_tag_manager' );

function utkwds_google_tag_manager_noscript() {
	$google_tag_manager_id_1 = get_theme_mod( 'google_tag_manager_id_1' );
	if ( $google_tag_manager_id_1 ) {
		echo '<!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=' . esc_attr( $google_tag_manager_id_1 ) . '"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->';
	}
	$google_tag_manager_id_2 = get_theme_mod( 'google_tag_manager_id_2' );

	if ( $google_tag_manager_id_2 ) {
		echo '<!-- Google Tag Manager 2 (noscript) -->
      <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=' . esc_attr( $google_tag_manager_id_2 ) . '"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
      <!-- End Google Tag Manager 2 (noscript) -->';
	}
}

add_action( 'wp_body_open', 'utkwds_google_tag_manager_noscript' );
