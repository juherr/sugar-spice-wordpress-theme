<?php
declare(strict_types=1);

/**
 * Theme admin integration.
 *
 * @package sugarspice
 */

/**
 * Redirect legacy options page requests to the Customizer.
 *
 * @return void
 */
function sugarspice_redirect_legacy_theme_options(): void {
	if ( ! is_admin() || ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only admin page routing.
	$page = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';

	if ( 'options-framework' !== $page ) {
		return;
	}

	wp_safe_redirect( admin_url( 'customize.php' ) );
	exit;
}
add_action( 'admin_init', 'sugarspice_redirect_legacy_theme_options' );

/**
 * Show a migration notice on the themes screen.
 *
 * @return void
 */
function sugarspice_customizer_migration_notice(): void {
	$screen = get_current_screen();

	if ( ! $screen || 'themes' !== $screen->id || ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	?>
	<div class="notice notice-info is-dismissible">
		<p>
			<?php
				esc_html_e( 'Sugar & Spice settings now live in the Customizer. Legacy theme option values are still read as fallbacks during the migration.', 'sugarspice' );
			?>
			<a
				href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"
			>
				<?php esc_html_e( 'Open the Customizer', 'sugarspice' ); ?>
			</a>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'sugarspice_customizer_migration_notice' );
