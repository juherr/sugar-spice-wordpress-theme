<?php
declare(strict_types=1);

/**
 * Sugar & Spice Theme Customizer
 *
 * @package sugarspice
 */

/**
 * Return available color scheme choices.
 *
 * @return array<string,string>
 */
function sugarspice_get_color_scheme_choices(): array {
	return array(
		'green'    => __( 'Green', 'sugarspice' ),
		'emerald'  => __( 'Emerald', 'sugarspice' ),
		'mint'     => __( 'Mint', 'sugarspice' ),
		'peach'    => __( 'Peach', 'sugarspice' ),
		'pink'     => __( 'Pink', 'sugarspice' ),
		'red'      => __( 'Red', 'sugarspice' ),
		'violet'   => __( 'Violet', 'sugarspice' ),
		'babyblue' => __( 'Baby Blue', 'sugarspice' ),
		'orange'   => __( 'Orange', 'sugarspice' ),
		'yellow'   => __( 'Yellow', 'sugarspice' ),
	);
}

/**
 * Return available layout choices.
 *
 * @return array<string,string>
 */
function sugarspice_get_layout_choices(): array {
	return array(
		'excerpt'   => __( 'Excerpts only', 'sugarspice' ),
		'full'      => __( 'Full posts', 'sugarspice' ),
		'firstfull' => __( 'First post full, rest as excerpts', 'sugarspice' ),
	);
}

/**
 * Sanitize a color scheme key.
 *
 * @param string $value Submitted value.
 * @return string
 */
function sugarspice_sanitize_color_scheme_key( string $value ): string {
	$choices = array_keys( sugarspice_get_color_scheme_choices() );

	return in_array( $value, $choices, true ) ? $value : 'emerald';
}

/**
 * Sanitize a layout option.
 *
 * @param string $value Submitted value.
 * @return string
 */
function sugarspice_sanitize_layout( string $value ): string {
	$choices = array_keys( sugarspice_get_layout_choices() );

	return in_array( $value, $choices, true ) ? $value : 'full';
}

/**
 * Sanitize a checkbox.
 *
 * @param mixed $checked Submitted value.
 * @return bool
 */
function sugarspice_sanitize_checkbox( $checked ): bool {
	return (bool) $checked;
}

/**
 * Sanitize an attachment ID.
 *
 * @param mixed $value Submitted value.
 * @return int
 */
function sugarspice_sanitize_attachment_id( $value ): int {
	return max( 0, absint( $value ) );
}

/**
 * Migrate a legacy option into a theme mod when missing.
 *
 * @param string   $theme_mod Theme mod key.
 * @param callable $callback Callback returning the migrated value.
 */
function sugarspice_maybe_set_theme_mod_from_legacy( string $theme_mod, callable $callback ): void {
	if ( null !== get_theme_mod( $theme_mod, null ) ) {
		return;
	}

	set_theme_mod( $theme_mod, $callback() );
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function sugarspice_customize_register( WP_Customize_Manager $wp_customize ): void {
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

	$wp_customize->add_section(
		'sugarspice_theme_colors',
		array(
			'title'    => __( 'Theme Colors', 'sugarspice' ),
			'priority' => 35,
		)
	);

	$wp_customize->add_setting(
		'main_color',
		array(
			'default'           => 'emerald',
			'sanitize_callback' => 'sugarspice_sanitize_color_scheme_key',
		)
	);

	$wp_customize->add_control(
		'main_color',
		array(
			'label'   => __( 'Main color', 'sugarspice' ),
			'section' => 'sugarspice_theme_colors',
			'type'    => 'select',
			'choices' => sugarspice_get_color_scheme_choices(),
		)
	);

	$wp_customize->add_setting(
		'accent_color',
		array(
			'default'           => 'peach',
			'sanitize_callback' => 'sugarspice_sanitize_color_scheme_key',
		)
	);

	$wp_customize->add_control(
		'accent_color',
		array(
			'label'   => __( 'Accent color', 'sugarspice' ),
			'section' => 'sugarspice_theme_colors',
			'type'    => 'select',
			'choices' => sugarspice_get_color_scheme_choices(),
		)
	);

	$wp_customize->add_section(
		'sugarspice_layout_options',
		array(
			'title'    => __( 'Theme Layout', 'sugarspice' ),
			'priority' => 40,
		)
	);

	$wp_customize->add_setting(
		'hp_layout',
		array(
			'default'           => 'full',
			'sanitize_callback' => 'sugarspice_sanitize_layout',
		)
	);

	$wp_customize->add_control(
		'hp_layout',
		array(
			'label'   => __( 'Home page layout', 'sugarspice' ),
			'section' => 'sugarspice_layout_options',
			'type'    => 'select',
			'choices' => sugarspice_get_layout_choices(),
		)
	);

	$wp_customize->add_setting(
		'ap_layout',
		array(
			'default'           => 'excerpt',
			'sanitize_callback' => 'sugarspice_sanitize_layout',
		)
	);

	$wp_customize->add_control(
		'ap_layout',
		array(
			'label'   => __( 'Archive layout', 'sugarspice' ),
			'section' => 'sugarspice_layout_options',
			'type'    => 'select',
			'choices' => sugarspice_get_layout_choices(),
		)
	);

	$wp_customize->add_setting(
		'disable_responsive',
		array(
			'default'           => false,
			'sanitize_callback' => 'sugarspice_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'disable_responsive',
		array(
			'label'   => __( 'Disable responsive layout', 'sugarspice' ),
			'section' => 'sugarspice_layout_options',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_section(
		'sugarspice_post_options',
		array(
			'title'    => __( 'Post Display', 'sugarspice' ),
			'priority' => 45,
		)
	);

	foreach ( array( 'author', 'date', 'comments' ) as $meta_key ) {
		$label_map = array(
			'author'   => __( 'Display post author', 'sugarspice' ),
			'date'     => __( 'Display post date', 'sugarspice' ),
			'comments' => __( 'Display post comments', 'sugarspice' ),
		);

		$wp_customize->add_setting(
			'display_post_meta_' . $meta_key,
			array(
				'default'           => true,
				'sanitize_callback' => 'sugarspice_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'display_post_meta_' . $meta_key,
			array(
				'label'   => $label_map[ $meta_key ],
				'section' => 'sugarspice_post_options',
				'type'    => 'checkbox',
			)
		);
	}

	$wp_customize->add_setting(
		'signature_image_id',
		array(
			'default'           => 0,
			'sanitize_callback' => 'sugarspice_sanitize_attachment_id',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'signature_image_id',
			array(
				'label'     => __( 'Signature image', 'sugarspice' ),
				'section'   => 'sugarspice_post_options',
				'mime_type' => 'image',
			)
		)
	);
}
add_action( 'customize_register', 'sugarspice_customize_register' );

/**
 * Migrate legacy options framework values to the Customizer.
 */
function sugarspice_maybe_migrate_legacy_theme_options(): void {
	if ( get_option( 'sugarspice_customizer_migrated' ) ) {
		return;
	}

	sugarspice_maybe_set_theme_mod_from_legacy(
		'main_color',
		static function () {
			return sugarspice_sanitize_color_scheme_key( (string) sugarspice_get_theme_option( 'main_color', 'emerald' ) );
		}
	);

	sugarspice_maybe_set_theme_mod_from_legacy(
		'accent_color',
		static function () {
			return sugarspice_sanitize_color_scheme_key( (string) sugarspice_get_theme_option( 'accent_color', 'peach' ) );
		}
	);

	sugarspice_maybe_set_theme_mod_from_legacy(
		'hp_layout',
		static function () {
			return sugarspice_sanitize_layout( (string) sugarspice_get_theme_option( 'hp_layout', 'full' ) );
		}
	);

	sugarspice_maybe_set_theme_mod_from_legacy(
		'ap_layout',
		static function () {
			return sugarspice_sanitize_layout( (string) sugarspice_get_theme_option( 'ap_layout', 'excerpt' ) );
		}
	);

	sugarspice_maybe_set_theme_mod_from_legacy(
		'disable_responsive',
		static function () {
			return '1' === (string) sugarspice_get_theme_option( 'responsive', 0 );
		}
	);

	$legacy_meta = sugarspice_get_theme_option(
		'meta_data',
		array(
			'author'   => '1',
			'date'     => '1',
			'comments' => '1',
		)
	);

	foreach ( array( 'author', 'date', 'comments' ) as $meta_key ) {
		$enabled = true;

		if ( is_array( $legacy_meta ) && array_key_exists( $meta_key, $legacy_meta ) ) {
			$enabled = ! empty( $legacy_meta[ $meta_key ] );
		}

		sugarspice_maybe_set_theme_mod_from_legacy(
			'display_post_meta_' . $meta_key,
			static function () use ( $enabled ) {
				return $enabled;
			}
		);
	}

	$sig_url = sugarspice_get_theme_option( 'signature_image', '' );
	if ( null === get_theme_mod( 'signature_image_id', null ) && is_string( $sig_url ) && $sig_url ) {
		$sig_id = attachment_url_to_postid( $sig_url );
		if ( $sig_id > 0 ) {
			set_theme_mod( 'signature_image_id', $sig_id );
		}
	}

	$saved_custom_logo = get_theme_mod( 'custom_logo' );
	if ( ! $saved_custom_logo ) {
		$logo_url = sugarspice_get_theme_option( 'logo_image', '' );
		if ( is_string( $logo_url ) && $logo_url ) {
			$logo_id = attachment_url_to_postid( $logo_url );
			if ( $logo_id > 0 ) {
				set_theme_mod( 'custom_logo', $logo_id );
			}
		}
	}

	if ( ! get_option( 'site_icon' ) ) {
		$favicon_url = sugarspice_get_theme_option( 'favicon', '' );
		if ( is_string( $favicon_url ) && $favicon_url ) {
			$favicon_id = attachment_url_to_postid( $favicon_url );
			if ( $favicon_id > 0 ) {
				update_option( 'site_icon', $favicon_id );
			}
		}
	}

	update_option( 'sugarspice_customizer_migrated', 1 );
}
add_action( 'after_setup_theme', 'sugarspice_maybe_migrate_legacy_theme_options', 20 );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @return void
 */
function sugarspice_customize_preview_js(): void {
	wp_enqueue_script(
		'sugarspice-customizer',
		get_template_directory_uri() . '/js/customizer.js',
		array( 'customize-preview' ),
		sugarspice_get_asset_version( 'js/customizer.js' ),
		true
	);
}
add_action( 'customize_preview_init', 'sugarspice_customize_preview_js' );
