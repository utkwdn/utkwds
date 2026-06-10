<?php
/**
 *
 * Updates to user roles.
 *
 * @package utkwds
 */

/**
 * Add Gravity Forms permissions to Editor role
 */
function utkwds_add_gravityforms_caps_to_editor() {
	$editor_role = get_role( 'editor' );

	if ( ! $editor_role ) {
		return;
	}

	// Remove full gravity form access if granted.
	$editor_role->remove_cap( 'gform_full_access' );

	// Add form access.
	$editor_role->add_cap( 'gravityforms_create_form' );
	$editor_role->add_cap( 'gravityforms_delete_forms' );
	$editor_role->add_cap( 'gravityforms_edit_forms' );
	$editor_role->add_cap( 'gravityforms_preview_forms' );

	// Add entries access.
	$editor_role->add_cap( 'gravityforms_view_entries' );
	$editor_role->add_cap( 'gravityforms_edit_entries' );
	$editor_role->add_cap( 'gravityforms_delete_entries' );

	// Add notes access.
	$editor_role->add_cap( 'gravityforms_view_entry_notes' );
	$editor_role->add_cap( 'gravityforms_edit_entry_notes' );

	// Add import/export access.
	$editor_role->add_cap( 'gravityforms_export_entries' );
}

add_action( 'admin_init', 'utkwds_add_gravityforms_caps_to_editor' );


// ---------------------------------------------------------------------------------
// Bump version number to trigger WDS role rebuild if role definitions below change.
// ---------------------------------------------------------------------------------
define( 'WDS_CUSTOM_ROLES_VERSION', '1.1.0' );


/**
 * WDS Custom Role Definitions (adapted from PublishPress Capabilities export).
 */
function wds_get_role_definitions() {
	return [

		// -----------------------------------------------------------------
		// WDS Administrator — cloned from "administrator"
		// -----------------------------------------------------------------
		'wds_administrator' => [
			'clone_from'   => 'administrator',
			'display_name' => 'WDS Administrator',

			// Capabilities to add on top of the cloned role.
			'add' => [
				// Gravity Forms.
				'gravityforms_create_form'      => true,
				'gravityforms_delete_entries'   => true,
				'gravityforms_delete_forms'     => true,
				'gravityforms_edit_entries'     => true,
				'gravityforms_edit_entry_notes' => true,
				'gravityforms_edit_forms'       => true,
				'gravityforms_export_entries'   => true,
				'gravityforms_preview_forms'    => true,
				'gravityforms_view_entries'     => true,
				'gravityforms_view_entry_notes' => true,
			],

			// Capabilities to remove.
			'remove' => [
				// Core administration.
				'manage_options'          => false,
				'moderate_comments'       => false,
				'import'                  => false,
				'export'                  => false,
				'unfiltered_html'         => false,
				'unfiltered_upload'       => false,
				'update_core'             => false,
				'view_site_health_checks' => false,
				'view_stats'              => false,

				// Users.
				'create_users'          => false,
				'delete_users'          => false,
				'edit_users'            => false,
				'promote_users'         => false,
				'remove_users'          => false,

				// Themes.
				'switch_themes'         => false,
				'edit_themes'           => false,
				'install_themes'        => false,
				'update_themes'         => false,
				'delete_themes'         => false,

				// Plugins.
				'activate_plugins'      => false,
				'edit_plugins'          => false,
				'install_plugins'       => false,
				'update_plugins'        => false,
				'delete_plugins'        => false,

				// Multisite.
				'create_sites'           => false,
				'delete_sites'           => false,
				'manage_network'         => false,
				'manage_sites'           => false,
				'manage_network_users'   => false,
				'manage_network_plugins' => false,
				'manage_network_themes'  => false,
				'manage_network_options' => false,
				'upgrade_network'        => false,
				'setup_network'          => false,

				// Gravity Forms.
				'gform_full_access'           => false,
				'gravityforms_api_settings'   => false,
				'gravityforms_edit_settings'  => false,
				'gravityforms_logging'        => false,
				'gravityforms_system_status'  => false,
				'gravityforms_uninstall'      => false,
				'gravityforms_view_addons'    => false,
				'gravityforms_view_settings'  => false,
				'gravityforms_view_updates'   => false,
				'gravityforms_feed'           => false,

				// Gravity SMTP (all)
				'gravitysmtp_delete_debug_log'                => false,
				'gravitysmtp_delete_email_log'                => false,
				'gravitysmtp_delete_email_log_details'        => false,
				'gravitysmtp_edit_alerts'                     => false,
				'gravitysmtp_edit_alerts_slack_settings'      => false,
				'gravitysmtp_edit_alerts_twilio_settings'     => false,
				'gravitysmtp_edit_debug_log'                  => false,
				'gravitysmtp_edit_debug_log_settings'         => false,
				'gravitysmtp_edit_email_log'                  => false,
				'gravitysmtp_edit_email_log_details'          => false,
				'gravitysmtp_edit_email_log_settings'         => false,
				'gravitysmtp_edit_email_management_settings'  => false,
				'gravitysmtp_edit_email_suppression_settings' => false,
				'gravitysmtp_edit_experimental_features'      => false,
				'gravitysmtp_edit_general_settings'           => false,
				'gravitysmtp_edit_integrations'               => false,
				'gravitysmtp_edit_license_key'                => false,
				'gravitysmtp_edit_notifications_settings'     => false,
				'gravitysmtp_edit_test_mode'                  => false,
				'gravitysmtp_edit_uninstall'                  => false,
				'gravitysmtp_edit_usage_analytics'            => false,
				'gravitysmtp_view_alerts'                     => false,
				'gravitysmtp_view_alerts_slack_settings'      => false,
				'gravitysmtp_view_alerts_twilio_settings'     => false,
				'gravitysmtp_view_dashboard'                  => false,
				'gravitysmtp_view_debug_log'                  => false,
				'gravitysmtp_view_debug_log_settings'         => false,
				'gravitysmtp_view_email_log'                  => false,
				'gravitysmtp_view_email_log_details'          => false,
				'gravitysmtp_view_email_log_preview'          => false,
				'gravitysmtp_view_email_log_settings'         => false,
				'gravitysmtp_view_email_management_settings'  => false,
				'gravitysmtp_view_email_suppression_settings' => false,
				'gravitysmtp_view_experimental_features'      => false,
				'gravitysmtp_view_general_settings'           => false,
				'gravitysmtp_view_integrations'               => false,
				'gravitysmtp_view_license_key'                => false,
				'gravitysmtp_view_notifications_settings'     => false,
				'gravitysmtp_view_test_mode'                  => false,
				'gravitysmtp_view_tools'                      => false,
				'gravitysmtp_view_tools_sendatest'            => false,
				'gravitysmtp_view_tools_systemreport'         => false,
				'gravitysmtp_view_uninstall'                  => false,
				'gravitysmtp_view_usage_analytics'            => false,
			],
		],

		// -----------------------------------------------------------------
		// WDS Editor — cloned from "editor"
		// -----------------------------------------------------------------
		'wds_editor' => [
			'clone_from'   => 'editor',
			'display_name' => 'WDS Editor',

			'add' => [],

			'remove' => [
				// Core administration.
				'moderate_comments'       => false,
				'manage_options'          => false,
				'unfiltered_html'         => false,
				'import'                  => false,
				'export'                  => false,
				'update_core'             => false,
				'edit_theme_options'      => false,
				'view_site_health_checks' => false,
				'view_stats'              => false,

				// Users.
				'create_users'          => false,
				'delete_users'          => false,
				'edit_users'            => false,
				'list_users'            => false,
				'promote_users'         => false,
				'remove_users'          => false,

				// Themes.
				'switch_themes'         => false,
				'edit_themes'           => false,
				'install_themes'        => false,
				'update_themes'         => false,
				'delete_themes'         => false,

				// Plugins
				'activate_plugins'      => false,
				'edit_plugins'          => false,
				'install_plugins'       => false,
				'update_plugins'        => false,
				'delete_plugins'        => false,

				// Multisite.
				'create_sites'           => false,
				'delete_sites'           => false,
				'manage_network'         => false,
				'manage_sites'           => false,
				'manage_network_users'   => false,
				'manage_network_plugins' => false,
				'manage_network_themes'  => false,
				'manage_network_options' => false,
				'upgrade_network'        => false,
				'setup_network'          => false,

				// Yoast SEO.
				'wpseo_manage_options'  => false,

				// Gravity Forms.
				'gform_full_access'           => false,
				'gravityforms_api_settings'   => false,
				'gravityforms_edit_settings'  => false,
				'gravityforms_logging'        => false,
				'gravityforms_system_status'  => false,
				'gravityforms_uninstall'      => false,
				'gravityforms_view_addons'    => false,
				'gravityforms_view_settings'  => false,
				'gravityforms_view_updates'   => false,
				'gravityforms_feed'           => false,
			],
		],
	];
}


/**
 * Role Creation - runs once per version bump
 * Clones all capabilities from the base role, then adds and removes specified capabilities.
 */
function wds_create_custom_roles() {
	foreach ( wds_get_role_definitions() as $slug => $def ) {
		// Remove the old version of this role.
		remove_role( $slug );

		// Get the base role to clone from.
		$base_role = get_role( $def['clone_from'] );
		if ( ! $base_role ) {
			return; // Exit before updating 'wds_custom_roles_version'.
		}

		// Start with a copy of the base role's caps.
		$capabilities = $base_role->capabilities;

		// Add any additional caps.
		foreach ( ( $def['add'] ?? [] ) as $cap => $value ) {
			$capabilities[ $cap ] = true;
		}

		// Remove any specified caps.
		foreach ( ( $def['remove'] ?? [] ) as $cap => $value ) {
			unset( $capabilities[ $cap ] );
		}

		add_role( $slug, $def['display_name'], $capabilities );
	}

	update_option( 'wds_custom_roles_version', WDS_CUSTOM_ROLES_VERSION );
}

/**
 * Check on admin_init whether we need to rebuild roles.
 * Runs on theme switch (after_switch_theme) and on any admin page load if the version has changed.
 */
add_action( 'after_switch_theme', 'wds_create_custom_roles' );
add_action( 'admin_init', function () {
	if ( get_option( 'wds_custom_roles_version' ) !== WDS_CUSTOM_ROLES_VERSION ) {
		wds_create_custom_roles();
	}
} );

/**
 * Admin Menu Restrictions
 * Hook into admin_menu at a late priority (9999) so all plugin menus are registered.
 */
add_action( 'admin_menu', 'wds_restrict_admin_menus', 9999 );

function wds_restrict_admin_menus() {
	$user = wp_get_current_user();
	if ( ! $user || ! $user->exists() ) {
		return;
	}

	// Top-level menus to remove for each role.
	$hidden_menus = [
		'wds_administrator' => [
			'edit-comments.php',
			'tools.php',
			'options-general.php',
		],
		'wds_editor' => [
			'edit-comments.php',
			'users.php',
			'tools.php',
			'wpseo_dashboard',
		],
	];

	// Submenus to remove for each role.
	$hidden_submenus = [
		'wds_administrator' => [
			'themes.php' => [
				'themes.php',
				'site-editor.php',
				'font-library.php',
			],
			'users.php' => [
				'user-new.php',
				'profile.php',
			],
			'tools.php' => [
				'tools.php',
				'import.php',
				'export.php',
				'site-health.php',
				'export-personal-data.php',
				'erase-personal-data.php',
				'action-scheduler',
				'wpseo_redirects_tools',
			],
			'options-general.php' => [
				'options-general.php',
				'options-writing.php',
				'options-reading.php',
				'options-discussion.php',
				'options-media.php',
				'options-permalink.php',
				'options-privacy.php',
				'akismet-key-config',
				'tinymce-advanced',
			],
			'wpseo_dashboard' => [
				'wpseo_integrations',
				'wpseo_licenses',
				'wpseo_workouts',
				'wpseo_redirects',
				'wpseo_upgrade_sidebar',
				'wpseo_brand_insights',
			],
		],
		'wds_editor' => [
			'users.php' => [
				'users.php',
				'user-new.php',
				'profile.php',
			],
			'tools.php' => [
				'tools.php',
				'import.php',
				'export.php',
				'site-health.php',
				'export-personal-data.php',
				'erase-personal-data.php',
				'action-scheduler',
				'wpseo_redirects_tools',
			],
		],
	];

	// Determine which role-based restrictions apply to this user.
	foreach ( $hidden_menus as $role_slug => $menus ) {
		if ( ! in_array( $role_slug, $user->roles, true ) ) {
			continue;
		}

		// Remove top-level menus.
		foreach ( $menus as $menu_slug ) {
			remove_menu_page( $menu_slug );
		}

		// Remove submenus.
		if ( isset( $hidden_submenus[ $role_slug ] ) ) {
			foreach ( $hidden_submenus[ $role_slug ] as $parent_slug => $children ) {
				foreach ( $children as $child_slug ) {
					remove_submenu_page( $parent_slug, $child_slug );
				}
			}
		}
	}
}

/**
 * Remove the "Edit site" button from the admin bar for WDS custom roles.
 */
add_action( 'admin_bar_menu', 'wds_restrict_admin_bar', 999 );

function wds_restrict_admin_bar( WP_Admin_Bar $wp_admin_bar ) {
	$user = wp_get_current_user();
	if ( ! $user || ! $user->exists() ) {
		return;
	}

	// Roles that should not see the Site Editor button in the admin bar.
	$restricted_roles = [ 'wds_administrator', 'wds_editor' ];

	if ( array_intersect( $restricted_roles, $user->roles ) ) {
		$wp_admin_bar->remove_node( 'site-editor' );
	}
}

/**
 * Block direct access to the Site Editor screen for WDS custom roles.
 */
add_action(
	'current_screen',
	function () {
		if ( ! function_exists( 'get_current_screen' ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( ! $screen || 'site-editor' !== $screen->id ) {
			return;
		}

		$user = wp_get_current_user();
		if ( ! $user || ! $user->exists() ) {
			return;
		}

		$restricted_roles = [ 'wds_administrator', 'wds_editor' ];

		if ( array_intersect( $restricted_roles, $user->roles ) ) {
			wp_die(
				esc_html__( 'You do not have permission to access the Site Editor.', 'utkwds' ),
				esc_html__( 'Forbidden', 'utkwds' ),
				[ 'response' => 403 ]
			);
		}
	},
	1
);