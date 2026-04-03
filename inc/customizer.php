<?php
/**
 * Sugar & Spice Theme Customizer
 *
 * @package sugarspice
 */

declare(strict_types=1);

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function sugarspice_customize_register( $wp_customize ) {
	$blogname = $wp_customize->get_setting( 'blogname' );
	$blogdescription = $wp_customize->get_setting( 'blogdescription' );
	$header_textcolor = $wp_customize->get_setting( 'header_textcolor' );

	if ( $blogname ) {
		$blogname->transport = 'postMessage';
	}

	if ( $blogdescription ) {
		$blogdescription->transport = 'postMessage';
	}

	if ( $header_textcolor ) {
		$header_textcolor->transport = 'postMessage';
	}
}
add_action( 'customize_register', 'sugarspice_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function sugarspice_customize_preview_js() {
	wp_enqueue_script( 'sugarspice_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), sugarspice_get_theme_version(), true );
}
add_action( 'customize_preview_init', 'sugarspice_customize_preview_js' );
