<?php
declare(strict_types=1);

/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package sugarspice
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Menu arguments.
 * @return array
 */
function sugarspice_page_menu_args( array $args ): array {
	$args['show_home'] = true;

	return $args;
}
add_filter( 'wp_page_menu_args', 'sugarspice_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Body classes.
 * @return array
 */
function sugarspice_body_classes( array $classes ): array {
	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'full-width-page.php' ) || is_page_template( 'full-width-no-title-page.php' ) ) {
		$classes[] = 'full-width';
	}

	// Add a group-blog class on multi-author sites.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'sugarspice_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @param string $url Attachment URL.
 * @param int    $id  Attachment ID.
 * @return string
 */
function sugarspice_enhanced_image_navigation( string $url, int $id ): string {
	if ( ! is_attachment() || ! wp_attachment_is_image( $id ) ) {
		return $url;
	}

	$image = get_post( $id );

	if ( $image && ! empty( $image->post_parent ) && (int) $image->post_parent !== (int) $id ) {
		$url .= '#main';
	}

	return $url;
}
add_filter( 'attachment_link', 'sugarspice_enhanced_image_navigation', 10, 2 );


/**
 * Add signature at the bottom of post
 *
 * @param string $signature Existing content.
 * @return string
 */
function sugarspice_aftercontent( string $signature = '' ): string {
	$post = get_post();

	if ( ! $post instanceof WP_Post || 'post' !== $post->post_type || is_home() ) {
		return $signature;
	}

	$signature_image = sugarspice_get_signature_image_url();

	if ( $signature_image ) {
		$signature .= '<div class="post_signature"><img src="' . esc_url( $signature_image ) . '" alt="" loading="lazy" /></div>';
	}

	return $signature;
}
add_filter( 'the_content', 'sugarspice_aftercontent' );

/**
 * Output color scheme CSS in header
 *
 * @return void
 */
function sugarspice_color_scheme(): void {
	$colors = array(
		'green'    => '#97C379',
		'emerald'  => '#36AB8A',
		'mint'     => '#9ED6BB',
		'peach'    => '#F9AA89',
		'pink'     => '#F8AFB8',
		'red'      => '#F03B42',
		'violet'   => '#BB86B4',
		'babyblue' => '#A7DBD8',
		'orange'   => '#F66B40',
		'yellow'   => '#fff568',
	);

	$main_color_key   = sanitize_key( (string) sugarspice_get_setting( 'main_color', 'emerald' ) );
	$accent_color_key = sanitize_key( (string) sugarspice_get_setting( 'accent_color', 'peach' ) );
	$main_color       = $colors[ $main_color_key ] ?? $colors['emerald'];
	$accent_color     = $colors[ $accent_color_key ] ?? $colors['peach'];
	$basic_color      = '#797979';
	$rgb              = sugarspice_hex_to_rgb( $main_color );

	$output  = '';
	$output .= sugarspice_css_output( 'a, a:visited', $main_color );
	$output .= sugarspice_css_output( '.entry-meta a', $basic_color );
	$output .= '#nav-wrapper .ribbon-left, #nav-wrapper .ribbon-right { background-image: url("' . esc_url_raw( get_template_directory_uri() . '/images/ribbon-' . $accent_color_key . '.png' ) . '"); }' . "\n";
	$output .= 'a:hover, a:focus, nav#main-nav > ul > li > a:hover { color: rgba(' . (int) $rgb['r'] . ', ' . (int) $rgb['g'] . ', ' . (int) $rgb['b'] . ', 0.7); }' . "\n";
	$output .= sugarspice_css_output( 'nav#main-nav > ul > li.current_page_item > a, nav#main-nav > ul > li.current_page_ancestor > a, nav#main-nav > ul > li.current-menu-item > a', $main_color );
	$output .= sugarspice_css_output( '.widget-title em', $accent_color );
	$output .= sugarspice_css_output( '.widget_calendar table td#today', '', $accent_color );
	$output .= sugarspice_css_output( 'blockquote cite', $main_color );
	$output .= 'blockquote { border-left-color: ' . $accent_color . '; }' . "\n";
	$output .= '.button:hover, button:hover, a.social-icon:hover , input[type="submit"]:hover, input[type="reset"]:hover, input[type="button"]:hover { background: rgba(' . (int) $rgb['r'] . ', ' . (int) $rgb['g'] . ', ' . (int) $rgb['b'] . ', 0.7); }' . "\n";

	if ( sugarspice_get_setting( 'disable_responsive', false ) ) {
		$output .= '.tinynav { display: none; }' . "\n";
	}

	if ( $output ) {
		wp_add_inline_style( 'sugarspice-style', $output );
	}
}
add_action( 'wp_enqueue_scripts', 'sugarspice_color_scheme', 20 );
