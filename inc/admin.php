<?php
/**
 * Theme admin and options framework integration.
 *
 * @package sugarspice
 */

/**
 * Load the bundled options framework.
 */
if ( ! function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/options-framework/' );
	require_once get_template_directory() . '/inc/options-framework/options-framework.php';
}

add_filter( 'optionsframework_menu', 'sugarspice_hide_optionsframework_menu' );

add_action( 'optionsframework_after', 'sugarspice_options_display_sidebar' );

/**
 * Hide the legacy Options Framework menu now that settings live in the Customizer.
 *
 * @param array $menu Existing menu settings.
 * @return array
 */
function sugarspice_hide_optionsframework_menu( $menu ) {
	$menu['capability'] = 'do_not_allow';

	return $menu;
}

/**
 * Redirect legacy options page requests to the Customizer.
 */
function sugarspice_redirect_legacy_theme_options() {
	if ( ! is_admin() || ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	if ( empty( $_GET['page'] ) || 'options-framework' !== $_GET['page'] ) {
		return;
	}

	wp_safe_redirect( admin_url( 'customize.php' ) );
	exit;
}
add_action( 'admin_init', 'sugarspice_redirect_legacy_theme_options' );

/**
 * Show a migration notice on the themes screen.
 */
function sugarspice_customizer_migration_notice() {
	$screen = get_current_screen();

	if ( ! $screen || 'themes' !== $screen->id || ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	?>
	<div class="notice notice-info is-dismissible">
		<p>
			<?php esc_html_e( 'Sugar & Spice settings now live in the Customizer. Legacy Options Framework values are still read as fallbacks during the migration.', 'sugarspice' ); ?>
			<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"><?php esc_html_e( 'Open the Customizer', 'sugarspice' ); ?></a>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'sugarspice_customizer_migration_notice' );

/**
 * Render the options framework sidebar.
 */
function sugarspice_options_display_sidebar() {
	?>
	<div id="optionsframework-sidebar">
		<div class="metabox-holder">
			<div class="postbox">
				<h3><?php esc_html_e( 'Support', 'sugarspice' ); ?></h3>
				<div class="inside">
					<p><?php echo wp_kses_post( __( 'The best way to contact me with <b>support questions</b> and <b>bug reports</b> is via the', 'sugarspice' ) ); ?> <a href="https://wordpress.org/support/theme/sugar-and-spice"><?php esc_html_e( 'WordPress support forums', 'sugarspice' ); ?></a>.</p>
					<p><?php esc_html_e( 'If you like this theme, I\'d appreciate if you could', 'sugarspice' ); ?>
					<a href="https://wordpress.org/support/view/theme-reviews/sugar-and-spice"><?php esc_html_e( 'rate Sugar & Spice at WordPress.org', 'sugarspice' ); ?></a><br /><b><?php esc_html_e( 'Thanks!', 'sugarspice' ); ?></b></p>
				</div>
			</div>
		</div>
	</div>
	<?php
}
