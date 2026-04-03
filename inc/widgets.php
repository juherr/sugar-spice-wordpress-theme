<?php
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
 * Register widget areas and custom widgets.
 *
 * @return void
 */
function sugarspice_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'sugarspice' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Main widget area.', 'sugarspice' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Prefooter Area One', 'sugarspice' ),
			'id'            => 'prefooter-1',
			'description'   => __( 'First widget area above the footer.', 'sugarspice' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Prefooter Area Two', 'sugarspice' ),
			'id'            => 'prefooter-2',
			'description'   => __( 'Second widget area above the footer.', 'sugarspice' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Prefooter Area Three', 'sugarspice' ),
			'id'            => 'prefooter-3',
			'description'   => __( 'Third widget area above the footer.', 'sugarspice' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		)
	);

	register_widget( 'sugarspice_contact_widget' );
	register_widget( 'sugarspice_about_widget' );
	register_widget( 'sugarspice_archives_widget' );
	register_widget( 'sugarspice_social_widget' );
}
add_action( 'widgets_init', 'sugarspice_widgets_init' );
