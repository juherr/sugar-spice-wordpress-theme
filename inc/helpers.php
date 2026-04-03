<?php
/**
 * Theme helper functions.
 *
 * @package sugarspice
 */

declare(strict_types=1);

/**
 * Echo the prefooter layout class based on active sidebars.
 */
function sugarspice_prefooter_class() {
	$count = 0;

	if ( is_active_sidebar( 'prefooter-1' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'prefooter-2' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'prefooter-3' ) ) {
		$count++;
	}

	$class = '';

	if ( 2 === $count ) {
		$class = 'one-half';
	} elseif ( 3 === $count ) {
		$class = 'one-third';
	}

	if ( $class ) {
		echo 'class="' . esc_attr( $class ) . '"';
	}
}

/**
 * Return a safe theme version for assets.
 *
 * @return string
 */
function sugarspice_get_theme_version() {
	$theme = wp_get_theme();
	$version = $theme->get( 'Version' );

	return $version ? $version : '1.0.0';
}

/**
 * Return a normalized theme option value.
 *
 * @param string $name Option key.
 * @param mixed  $default Default value.
 * @return mixed
 */
function sugarspice_get_theme_option( $name, $default = false ) {
	if ( function_exists( 'of_get_option' ) ) {
		return of_get_option( $name, $default );
	}

	return $default;
}

/**
 * Return a validated layout option.
 *
 * @param string $name Option key.
 * @param string $default Default layout.
 * @return string
 */
function sugarspice_get_layout_option( $name, $default = 'full' ) {
	$layout = (string) sugarspice_get_theme_option( $name, $default );
	$allowed_layouts = array( 'excerpt', 'full', 'firstfull' );

	if ( ! in_array( $layout, $allowed_layouts, true ) ) {
		return $default;
	}

	return $layout;
}

/**
 * Build color CSS output.
 *
 * @param string $selectors CSS selector list.
 * @param string $color Optional text color.
 * @param string $background Optional background color.
 * @return string
 */
function sugarspice_css_output( $selectors, $color = '', $background = '' ) {
	$output = $selectors . ' {';

	if ( $color ) {
		$output .= ' color:' . $color . '; ';
	} elseif ( $background ) {
		$output .= ' background:' . $background . '; ';
	}

	$output .= '}';
	$output .= "\n";

	return $output;
}

/**
 * Convert a hex color to RGB values.
 *
 * @param string $hex Hex color value.
 * @return array<string,int>
 */
function sugarspice_hex_to_rgb( $hex ) {
	$hex = preg_replace( '/#/', '', (string) $hex );

	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}

	if ( 6 !== strlen( $hex ) ) {
		return array(
			'r' => 0,
			'g' => 0,
			'b' => 0,
		);
	}

	return array(
		'r' => hexdec( substr( $hex, 0, 2 ) ),
		'g' => hexdec( substr( $hex, 2, 2 ) ),
		'b' => hexdec( substr( $hex, 4, 2 ) ),
	);
}
