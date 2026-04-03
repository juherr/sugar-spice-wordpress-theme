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

add_action( 'optionsframework_after', 'sugarspice_options_display_sidebar' );

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
