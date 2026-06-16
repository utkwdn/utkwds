<?php
/**
 * Sets up a custom Featured Locations taxonomy for UTKWDS.
 *
 * @package utkwds
 */

/**
 * Register Featured Locations Taxonom.
 */
function utkwds_register_featured_locations_tax() {

	$labels = array(
		'name'                       => __( 'Featured Locations', 'taxonomy general name' ),
		'singular_name'              => __( 'Featured Location', 'taxonomy general name' ),
		'search_items'               => __( 'Search Featured Locations' ),
		'all_items'                  => __( 'All Featured Locations' ),
		'edit_item'                  => __( 'Edit Featured Location' ),
		'update_item'                => __( 'Update Featured Location' ),
		'add_new_item'               => __( 'Add Featured Location' ), 
		'new_item_name'              => __( 'New Featured Location Name' ),
		'separate_items_with_commas' => __( 'Separate featured locations with commas' ),
		'add_or_remove_items'        => __( 'Add or remove featured locations' ),
		'choose_from_most_used'      => __( 'Choose from the most used featured locations' ),
		'not_found'                  => __( 'No featured locations found.' ),
		'menu_name'                  => __( 'Featured Locations' ),
	);

	$args = array(
		'labels'                => $labels,
		'public'                => false,
		'publicly_queryable'    => true,
		'has_archive'           => false,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'query_var'             => false,
		'rewrite'               => array(
			'slug'       => 'featured_locations',
			'with_front' => true,
		),
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'show_tagcloud'         => false,
		'rest_base'             => 'featured_locations',
		'show_in_quick_edit'    => true,
		'sort'                  => false,
		'default_term'          => false,
	);
	register_taxonomy( 'featured_locations', 'post', $args );

}

add_action( 'init', 'utkwds_register_featured_locations_tax' );

/**
 * Create featured location terms.
 */
// function utkwds_create_default_terms() {

// 	$default_terms = array(
// 		'Homepage',
// 		'Stories',
// 	);
// 	foreach ( $default_terms as $term ) {
// 		if ( ! term_exists( $term, 'featured_locations' ) ) {
// 			wp_insert_term( $term, 'featured_locations' );
// 		}
// 	}

// }

// add_action( 'init', 'utkwds_create_default_terms' );
