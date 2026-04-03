<?php
declare(strict_types=1);

/**
 * Widget loading and sidebar registration.
 *
 * @package sugarspice
 */

require_once get_template_directory() . '/inc/widgets/contact-widget.php';
require_once get_template_directory() . '/inc/widgets/about-widget.php';
require_once get_template_directory() . '/inc/widgets/archives-widget.php';
require_once get_template_directory() . '/inc/widgets/social-widget.php';

/**
 * Return shared sidebar arguments.
 *
 * @param string $name Sidebar name.
 * @param string $id Sidebar ID.
 * @param string $description Sidebar description.
 * @return array<string,string>
 */
function sugarspice_get_sidebar_args( string $name, string $id, string $description ): array {
	return array(
		'name'          => $name,
		'id'            => $id,
		'description'   => $description,
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	);
}

/**
 * Register widget areas and custom widgets.
 */
function sugarspice_widgets_init(): void {
	$sidebars = array(
		sugarspice_get_sidebar_args(
			__( 'Sidebar', 'sugarspice' ),
			'sidebar-1',
			__( 'Main widget area.', 'sugarspice' )
		),
		sugarspice_get_sidebar_args(
			__( 'Prefooter Area One', 'sugarspice' ),
			'prefooter-1',
			__( 'First widget area above the footer.', 'sugarspice' )
		),
		sugarspice_get_sidebar_args(
			__( 'Prefooter Area Two', 'sugarspice' ),
			'prefooter-2',
			__( 'Second widget area above the footer.', 'sugarspice' )
		),
		sugarspice_get_sidebar_args(
			__( 'Prefooter Area Three', 'sugarspice' ),
			'prefooter-3',
			__( 'Third widget area above the footer.', 'sugarspice' )
		),
	);

	foreach ( $sidebars as $sidebar ) {
		register_sidebar( $sidebar );
	}

	register_widget( 'sugarspice_contact_widget' );
	register_widget( 'sugarspice_about_widget' );
	register_widget( 'sugarspice_archives_widget' );
	register_widget( 'sugarspice_social_widget' );
}
add_action( 'widgets_init', 'sugarspice_widgets_init' );
