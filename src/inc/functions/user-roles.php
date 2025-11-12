<?php

/* Add Gravity Forms permissions to Editor role */

add_action( 'admin_init', 'utkwds_add_gravityforms_caps_to_editor' );

function utkwds_add_gravityforms_caps_to_editor() {
	$role = get_role( 'editor' );
	$role->add_cap( 'gform_full_access' );
}
