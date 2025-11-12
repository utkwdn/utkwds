<?php

// Register your footer sidebar.
add_action( 'widgets_init', 'utkwds_sidebar' );
function utkwds_sidebar() {
	$theme_mods = get_theme_mods();
	if ( isset( $theme_mods['wp_classic_sidebars'] ) ) {
		remove_theme_mod( 'wp_classic_sidebars' );
	}

	register_sidebar(
		array(
			'id'            => 'utkwds_footer',
			'name'          => __( 'Footer Sidebar' ),
			'description'   => __( 'Add contact information here.' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	/* Repeat register_sidebar() code for multiple sidebars. */
}
