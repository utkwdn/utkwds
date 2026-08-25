<?php
/**
 * Elective blocks & patterns.
 *
 * Provides an admin-only settings page (Settings > Torch Settings) where
 * administrators and super admins can enable specific blocks and patterns on a
 * per-site basis. Everything registered here is off by default and is only
 * registered when explicitly enabled for the current site.
 *
 * State is stored in the per-site option `utkwds_enabled_elective_components`
 * as a flat array of enabled slugs. Because this is a normal option, each site
 * in the network keeps its own list automatically.
 *
 * @package utkwds
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Name of the per-site option that stores the enabled component slugs.
 */
const UTKWDS_ELECTIVE_OPTION = 'utkwds_enabled_elective_components';

/**
 * Capability required to access the Torch settings page.
 *
 * On a multisite network that has super admins, restrict to super admins.
 * Otherwise fall back to site administrators.
 *
 * @return string Capability slug.
 */
function utkwds_torch_settings_cap() {
	if ( is_multisite() && ! empty( get_super_admins() ) ) {
		return 'manage_network';
	}

	return 'manage_options';
}

/**
 * Elective components to enable or disable.
 *
 *
 * @return array{blocks: array<string, array{label: string, dir: string}>, patterns: array<string, array{label: string}>}
 */
function utkwds_elective_components() {

	return array(

		// Elective blocks. Key = block "name" from block.json, `dir` = folder under /blocks/.
		'blocks'   => array(
			'utk-wds/news-home-hero' => array(
				'label' => __( 'News Home Hero', 'utkwds' ),
				'dir'   => 'news-home-hero',
			),
		),

		// Elective patterns. Key = pattern slug from the file's "Slug:" header.
		'patterns' => array(
			'utkwds/cta-category-listing' => array(
				'label' => __( 'CTA & Category Listing', 'utkwds' ),
			),
		),
	);
}

/**
 * Get the enabled components for the current site.
 *
 * @return string[] Array of enabled slugs (block names and/or pattern slugs).
 */
function utkwds_get_enabled_components() {
	$enabled = get_option( UTKWDS_ELECTIVE_OPTION, array() );

	return is_array( $enabled ) ? $enabled : array();
}

/**
 * Register any custom blocks that are enabled for this site.
 */
function utkwds_register_enabled_elective_blocks() {
	$components = utkwds_elective_components();

	foreach ( $components['blocks'] as $block_name => $block ) {
		if ( ! in_array( $block_name, utkwds_get_enabled_components(), true ) ) {
			continue;
		}

		$path = get_theme_file_path( '/blocks/' . $block['dir'] );

		if ( is_dir( $path ) ) {
			register_block_type( $path );
		}
	}
}
// Priority 20 so it runs after the theme's utkwds_block_init() .
add_action( 'init', 'utkwds_register_enabled_elective_blocks', 20 );

/**
 * Unregister any patterns that are not enabled for this site.
 */
function utkwds_gate_elective_patterns() {
	if ( ! class_exists( 'WP_Block_Patterns_Registry' ) ) {
		return;
	}

	$registry   = WP_Block_Patterns_Registry::get_instance();
	$components = utkwds_elective_components();

	foreach ( $components['patterns'] as $slug => $pattern ) {
		if ( in_array( $slug, utkwds_get_enabled_components(), true ) ) {
			continue;
		}

		if ( $registry->is_registered( $slug ) ) {
			unregister_block_pattern( $slug );
		}
	}
}
add_action( 'init', 'utkwds_gate_elective_patterns', 20 );

/*
-------------------------------------------------------------------------
 * Settings page (Settings > Torch Settings).
-------------------------------------------------------------------------
*/

/**
 * Add the Torch Settings page under the Settings menu.
 */
function utkwds_torch_settings_menu() {
	add_options_page(
		__( 'Torch Settings', 'utkwds' ),
		__( 'Torch Settings', 'utkwds' ),
		utkwds_torch_settings_cap(),
		'utkwds-torch-settings',
		'utkwds_torch_settings_page'
	);
}
add_action( 'admin_menu', 'utkwds_torch_settings_menu' );

/**
 * Render the settings page.
 */
function utkwds_torch_settings_page() {

	if ( ! current_user_can( utkwds_torch_settings_cap() ) ) {
		wp_die( esc_html__( 'You do not have permission to manage these settings.', 'utkwds' ) );
	}

	$components   = utkwds_elective_components();
	$all_slugs    = array_merge( array_keys( $components['blocks'] ), array_keys( $components['patterns'] ) );
	$saved_notice = false;

	// Handle form submission.
	if ( isset( $_POST['utkwds_elective_components_submit'] ) ) {

		check_admin_referer( 'utkwds_elective_components_save', 'utkwds_elective_components_nonce' );

		$submitted = isset( $_POST['utkwds_components'] ) ? (array) wp_unslash( $_POST['utkwds_components'] ) : array();
		$submitted = array_map( 'sanitize_text_field', $submitted );

		// Only store slugs listed in utkwds_elective_components().
		$enabled = array_values( array_intersect( $all_slugs, $submitted ) );

		update_option( UTKWDS_ELECTIVE_OPTION, $enabled );
		$saved_notice = true;
	}

	$enabled = utkwds_get_enabled_components();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Torch Settings', 'utkwds' ); ?></h1>

		<?php if ( $saved_notice ) : ?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_html_e( 'Settings saved.', 'utkwds' ); ?></p>
			</div>
		<?php endif; ?>

		<div style="background: #fdfdfd;padding: 20px;margin-top: 20px;border: 1px solid #d4d4d4;">
			<h2 style="margin: 0 0 5px;"><?php esc_html_e( 'Elective Components', 'utkwds' ); ?></h2>

			<p class="description">
				<?php esc_html_e( 'These blocks and patterns are hidden on this site by default. Enable only the ones this site needs. Changes apply to this site only.', 'utkwds' ); ?>
			</p>

			<form method="post" action="">
				<?php wp_nonce_field( 'utkwds_elective_components_save', 'utkwds_elective_components_nonce' ); ?>

				<?php if ( ! empty( $components['blocks'] ) ) : ?>
					<div style="margin: 20px 0;padding-bottom: 20px;border-bottom: 1px solid #d4d4d4;">
						<p style="font-size: 1.2em;"><strong><?php esc_html_e( 'Blocks', 'utkwds' ); ?></strong></p>

						<?php foreach ( $components['blocks'] as $slug => $block ) : ?>
							<input type="checkbox" name="utkwds_components[]" value="<?php echo esc_attr( $slug ); ?>" <?php checked( in_array( $slug, $enabled, true ) ); ?> />
							<?php echo esc_html( $block['label'] ); ?>
						<?php endforeach; ?>
					</div>

				<?php endif; ?>

				<?php if ( ! empty( $components['patterns'] ) ) : ?>
					<div style="margin-bottom: 20px; padding-bottom: 20px;  border-bottom: 1px solid #d4d4d4;">
						<p style="font-size: 1.2em;"><strong><?php esc_html_e( 'Patterns', 'utkwds' ); ?></strong></p>

						<?php foreach ( $components['patterns'] as $slug => $pattern ) : ?>

							<input type="checkbox" name="utkwds_components[]" value="<?php echo esc_attr( $slug ); ?>" <?php checked( in_array( $slug, $enabled, true ) ); ?> />
							<?php echo esc_html( $pattern['label'] ); ?>

						<?php endforeach; ?>
					</div>

				<?php endif; ?>

				<?php submit_button( __( 'Save Changes', 'utkwds' ), 'primary', 'utkwds_elective_components_submit', false ); ?>
			</form>
		</div>
	</div>
	<?php
}