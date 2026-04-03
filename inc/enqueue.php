<?php
/**
 * Frontend asset loading.
 *
 * @package sugarspice
 */

/**
 * Return a version string for a theme asset.
 *
 * Uses the file modification time when available so changed assets are
 * cache-busted automatically during development and deployment.
 *
 * @param string $relative_path Path relative to the theme directory.
 * @return string
 */
function sugarspice_get_asset_version( $relative_path ) {
	$asset_path = get_template_directory() . '/' . ltrim( $relative_path, '/' );

	if ( file_exists( $asset_path ) ) {
		return (string) filemtime( $asset_path );
	}

	return sugarspice_get_theme_version();
}

/**
 * Register theme scripts and styles.
 *
 * @return void
 */
function sugarspice_register_assets() {
	wp_register_script(
		'sugarspice-skip-link-focus-fix',
		get_template_directory_uri() . '/js/skip-link-focus-fix.js',
		array(),
		sugarspice_get_asset_version( 'js/skip-link-focus-fix.js' ),
		true
	);

	wp_register_script(
		'sugarspice-tinynav',
		get_template_directory_uri() . '/js/tinynav.min.js',
		array( 'jquery' ),
		sugarspice_get_asset_version( 'js/tinynav.min.js' ),
		true
	);

	wp_register_script(
		'sugarspice-flexslider',
		get_template_directory_uri() . '/js/jquery.flexslider-min.js',
		array( 'jquery' ),
		sugarspice_get_asset_version( 'js/jquery.flexslider-min.js' ),
		true
	);

	wp_register_script(
		'sugarspice-theme',
		get_template_directory_uri() . '/js/theme.js',
		array( 'jquery', 'sugarspice-tinynav', 'sugarspice-flexslider' ),
		sugarspice_get_asset_version( 'js/theme.js' ),
		true
	);

	wp_register_script(
		'sugarspice-keyboard-image-navigation',
		get_template_directory_uri() . '/js/keyboard-image-navigation.js',
		array(),
		sugarspice_get_asset_version( 'js/keyboard-image-navigation.js' ),
		true
	);

	wp_register_style(
		'sugarspice-fonts',
		sugarspice_fonts_url(),
		array(),
		null
	);

	wp_register_style(
		'sugarspice-style',
		get_stylesheet_uri(),
		array(),
		sugarspice_get_asset_version( 'style.css' )
	);

	wp_register_style(
		'sugarspice-responsive',
		get_template_directory_uri() . '/responsive.css',
		array( 'sugarspice-style' ),
		sugarspice_get_asset_version( 'responsive.css' )
	);

	wp_register_style(
		'sugarspice-icofont',
		get_template_directory_uri() . '/fonts/icofont.css',
		array(),
		sugarspice_get_asset_version( 'fonts/icofont.css' )
	);
}
add_action( 'wp_enqueue_scripts', 'sugarspice_register_assets', 5 );

/**
 * Enqueue frontend scripts.
 *
 * @return void
 */
function sugarspice_scripts() {
	wp_enqueue_script( 'sugarspice-skip-link-focus-fix' );
	wp_enqueue_script( 'sugarspice-theme' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_localize_script(
		'sugarspice-theme',
		'sugarspiceTheme',
		array(
			'menuLabel' => __( 'Menu', 'sugarspice' ),
		)
	);

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'sugarspice-keyboard-image-navigation' );
	}
}
add_action( 'wp_enqueue_scripts', 'sugarspice_scripts' );

/**
 * Returns the Google font stylesheet URL, if available.
 *
 * @return string
 */
function sugarspice_fonts_url() {
	$fonts_url = '';

	$niconne = _x( 'on', 'Niconne font: on or off', 'sugarspice' );
	$ptserif = _x( 'on', 'PT Serif font: on or off', 'sugarspice' );
	$raleway = _x( 'on', 'Raleway font: on or off', 'sugarspice' );

	if ( 'off' !== $niconne || 'off' !== $ptserif || 'off' !== $raleway ) {
		$font_families = array();

		if ( 'off' !== $niconne ) {
			$font_families[] = 'Niconne';
		}

		if ( 'off' !== $ptserif ) {
			$font_families[] = 'PT+Serif:400,700';
		}

		if ( 'off' !== $raleway ) {
			$font_families[] = 'Raleway:400,600';
		}

		$query_args = array(
			'family' => implode( '|', $font_families ),
			'subset' => 'latin,latin-ext',
		);

		$fonts_url = (string) add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Enqueue frontend styles.
 *
 * @return void
 */
function sugarspice_css() {
	$fonts_url = sugarspice_fonts_url();

	if ( $fonts_url ) {
		wp_enqueue_style( 'sugarspice-fonts' );
	}

	wp_enqueue_style( 'sugarspice-style' );

	if ( ! sugarspice_get_setting( 'disable_responsive', false ) ) {
		wp_enqueue_style( 'sugarspice-responsive' );
	}

	wp_enqueue_style( 'sugarspice-icofont' );
}
add_action( 'wp_enqueue_scripts', 'sugarspice_css' );
