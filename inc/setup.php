<?php
/**
 * Theme setup and registration.
 *
 * @package sugarspice
 */

/**
 * Set the default content width.
 *
 * This runs early so plugins can still filter it during setup.
 *
 * @return void
 */
function sugarspice_set_content_width() {
	$GLOBALS['content_width'] = (int) apply_filters( 'sugarspice_content_width', 600 );
}
add_action( 'after_setup_theme', 'sugarspice_set_content_width', 0 );

if ( ! function_exists( 'sugarspice_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @return void
	 */
	function sugarspice_setup() {
		load_theme_textdomain( 'sugarspice', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'style.css' );
		set_post_thumbnail_size( 210, 210, true );

		add_theme_support(
			'custom-logo',
			array(
				'height'      => 120,
				'width'       => 400,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'sugarspice' ),
				'footer'  => __( 'Footer Menu', 'sugarspice' ),
			)
		);

		add_theme_support(
			'custom-background',
			apply_filters(
				'sugarspice_custom_background_args',
				array(
					'default-color' => '',
					'default-image' => get_template_directory_uri() . '/images/bg.png',
				)
			)
		);

		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	}
endif;
add_action( 'after_setup_theme', 'sugarspice_setup' );

/**
 * Adjust content width depending on the current template layout.
 *
 * @return void
 */
function sugarspice_content_width() {
	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'full-width-page.php' ) ) {
		$GLOBALS['content_width'] = (int) apply_filters( 'sugarspice_wide_content_width', 940 );
	}
}
add_action( 'template_redirect', 'sugarspice_content_width' );
