<?php
/**
 * Theme hooks and filters.
 *
 * @package sugarspice
 */

if ( ! function_exists( 'sugarspice_excerpt_length' ) ) {
	/**
	 * Set the excerpt length.
	 *
	 * @param int $length Existing excerpt length.
	 * @return int
	 */
	function sugarspice_excerpt_length( $length ) {
		return 40;
	}
}
add_filter( 'excerpt_length', 'sugarspice_excerpt_length', 999 );

if ( ! function_exists( 'sugarspice_excerpt_more' ) ) {
	/**
	 * Set the excerpt suffix.
	 *
	 * @param string $more Existing excerpt suffix.
	 * @return string
	 */
	function sugarspice_excerpt_more( $more ) {
		return '...';
	}
}
add_filter( 'excerpt_more', 'sugarspice_excerpt_more' );
