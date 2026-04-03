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
 * Return the legacy option storage key.
 *
 * @return string
 */
function sugarspice_get_legacy_options_key() {
	$stylesheet = (string) get_option( 'stylesheet' );

	return preg_replace( '/\W/', '_', strtolower( $stylesheet ) );
}

/**
 * Return all legacy Options Framework values.
 *
 * @return array<string,mixed>
 */
function sugarspice_get_legacy_options() {
	$options = get_option( sugarspice_get_legacy_options_key(), array() );

	return is_array( $options ) ? $options : array();
}

/**
 * Return a normalized legacy theme option value.
 *
 * @param string $name Option key.
 * @param mixed  $default Default value.
 * @return mixed
 */
function sugarspice_get_theme_option( $name, $default = false ) {
	$legacy_options = sugarspice_get_legacy_options();

	if ( array_key_exists( $name, $legacy_options ) ) {
		return $legacy_options[ $name ];
	}

	return $default;
}

/**
 * Return a theme setting with Customizer-first fallback to legacy options.
 *
 * @param string $name Setting key.
 * @param mixed  $default Default value.
 * @return mixed
 */
function sugarspice_get_setting( $name, $default = false ) {
	$theme_mod = get_theme_mod( $name, null );

	if ( null !== $theme_mod ) {
		return $theme_mod;
	}

	if ( 'disable_responsive' === $name ) {
		return 1 == sugarspice_get_theme_option( 'responsive', 0 );
	}

	if ( 0 === strpos( $name, 'display_post_meta_' ) ) {
		$meta_key = str_replace( 'display_post_meta_', '', $name );
		$legacy_meta = sugarspice_get_theme_option( 'meta_data', array() );

		if ( is_array( $legacy_meta ) && array_key_exists( $meta_key, $legacy_meta ) ) {
			return ! empty( $legacy_meta[ $meta_key ] );
		}

		return true;
	}

	return sugarspice_get_theme_option( $name, $default );
}

/**
 * Return the legacy logo image URL fallback.
 *
 * @return string
 */
function sugarspice_get_legacy_logo_url() {
	$logo_url = sugarspice_get_theme_option( 'logo_image', '' );

	return is_string( $logo_url ) ? $logo_url : '';
}

/**
 * Return the legacy favicon URL fallback.
 *
 * @return string
 */
function sugarspice_get_legacy_favicon_url() {
	$favicon_url = sugarspice_get_theme_option( 'favicon', '' );

	return is_string( $favicon_url ) ? $favicon_url : '';
}

/**
 * Return the signature image URL from the new or legacy settings.
 *
 * @return string
 */
function sugarspice_get_signature_image_url() {
	$attachment_id = (int) sugarspice_get_setting( 'signature_image_id', 0 );

	if ( $attachment_id > 0 ) {
		$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );

		if ( $image_url ) {
			return $image_url;
		}
	}

	$legacy_url = sugarspice_get_theme_option( 'signature_image', '' );

	return is_string( $legacy_url ) ? $legacy_url : '';
}

/**
 * Return whether a post meta element should be displayed.
 *
 * @param string $key Meta key.
 * @return bool
 */
function sugarspice_show_post_meta( $key ) {
	$allowed = array( 'author', 'date', 'comments' );

	if ( ! in_array( $key, $allowed, true ) ) {
		return false;
	}

	return (bool) sugarspice_get_setting( 'display_post_meta_' . $key, true );
}

/**
 * Return a validated layout option.
 *
 * @param string $name Option key.
 * @param string $default Default layout.
 * @return string
 */
function sugarspice_get_layout_option( $name, $default = 'full' ) {
	$layout = (string) sugarspice_get_setting( $name, $default );
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
