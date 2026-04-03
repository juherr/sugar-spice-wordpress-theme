<?php
/**
 * Frontend asset loading.
 *
 * @package sugarspice
 */

declare(strict_types=1);

/**
 * Enqueue scripts.
 */
function sugarspice_scripts() {
	$theme_version = sugarspice_get_theme_version();

	wp_enqueue_script( 'sugarspice-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), $theme_version, true );

	wp_register_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.min.js', array(), '2.6.2', true );
	wp_enqueue_script( 'modernizr' );

	wp_register_script( 'tinynav', get_template_directory_uri() . '/js/tinynav.min.js', array( 'jquery' ), '1.1', true );
	wp_enqueue_script( 'tinynav' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'sugarspice-flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery' ), '2.2.0', true );
	wp_enqueue_script( 'sugarspice-theme', get_template_directory_uri() . '/js/theme.js', array( 'jquery', 'tinynav', 'sugarspice-flexslider' ), $theme_version, true );
	wp_localize_script(
		'sugarspice-theme',
		'sugarspiceTheme',
		array(
			'menuLabel' => __( 'Menu', 'sugarspice' ),
		)
	);

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'sugarspice-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
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
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

/**
 * Enqueue styles.
 */
function sugarspice_css() {
	$theme_version = sugarspice_get_theme_version();
	$fonts_url = sugarspice_fonts_url();

	if ( $fonts_url ) {
		wp_enqueue_style( 'sugarspice-fonts', $fonts_url, array(), null );
	}

	wp_enqueue_style( 'sugarspice-style', get_stylesheet_uri(), array(), $theme_version );

	if ( 0 == sugarspice_get_theme_option( 'responsive' ) ) {
		wp_enqueue_style( 'sugarspice-responsive', get_template_directory_uri() . '/responsive.css', array( 'sugarspice-style' ), $theme_version );
	}

	wp_register_style( 'sugarspice-icofont', get_template_directory_uri() . '/fonts/icofont.css', array(), $theme_version );
	wp_enqueue_style( 'sugarspice-icofont' );
}
add_action( 'wp_enqueue_scripts', 'sugarspice_css' );
