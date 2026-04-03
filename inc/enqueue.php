<?php
declare(strict_types=1);

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
 */
function sugarspice_get_asset_version( string $relative_path ): string {
	$asset_path = get_template_directory() . '/' . ltrim( $relative_path, '/' );

	if ( file_exists( $asset_path ) ) {
		return (string) filemtime( $asset_path );
	}

	return sugarspice_get_theme_version();
}

/**
 * Register theme scripts and styles.
 */
function sugarspice_register_assets(): void {
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

	$fonts_url = sugarspice_fonts_url();

	if ( '' !== $fonts_url ) {
		wp_register_style(
			'sugarspice-fonts',
			$fonts_url,
			array(),
			sugarspice_get_theme_version()
		);
	}

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
 */
function sugarspice_enqueue_scripts(): void {
	wp_enqueue_script( 'sugarspice-skip-link-focus-fix' );
	wp_enqueue_script( 'sugarspice-theme' );

	wp_localize_script(
		'sugarspice-theme',
		'sugarspiceTheme',
		array(
			'menuLabel' => __( 'Menu', 'sugarspice' ),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'sugarspice-keyboard-image-navigation' );
	}
}
add_action( 'wp_enqueue_scripts', 'sugarspice_enqueue_scripts' );

/**
 * Return the Google font stylesheet URL when at least one font is enabled.
 */
function sugarspice_fonts_url(): string {
	$font_families = array();

	if ( 'off' !== _x( 'on', 'Niconne font: on or off', 'sugarspice' ) ) {
		$font_families[] = 'Niconne';
	}

	if ( 'off' !== _x( 'on', 'PT Serif font: on or off', 'sugarspice' ) ) {
		$font_families[] = 'PT+Serif:400,700';
	}

	if ( 'off' !== _x( 'on', 'Raleway font: on or off', 'sugarspice' ) ) {
		$font_families[] = 'Raleway:400,600';
	}

	if ( array() === $font_families ) {
		return '';
	}

	return esc_url_raw(
		(string) add_query_arg(
			array(
				'family' => implode( '|', $font_families ),
				'subset' => 'latin,latin-ext',
			),
			'https://fonts.googleapis.com/css'
		)
	);
}

/**
 * Enqueue frontend styles.
 */
function sugarspice_enqueue_styles(): void {
	if ( wp_style_is( 'sugarspice-fonts', 'registered' ) ) {
		wp_enqueue_style( 'sugarspice-fonts' );
	}

	wp_enqueue_style( 'sugarspice-style' );

	if ( ! sugarspice_get_setting( 'disable_responsive', false ) ) {
		wp_enqueue_style( 'sugarspice-responsive' );
	}

	wp_enqueue_style( 'sugarspice-icofont' );
}
add_action( 'wp_enqueue_scripts', 'sugarspice_enqueue_styles' );
