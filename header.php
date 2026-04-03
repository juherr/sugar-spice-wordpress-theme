<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Sugar & Spice
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
    <?php $favicon = sugarspice_get_legacy_favicon_url(); ?>
    <?php if ( $favicon && ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) ) : ?>
    <link rel="shortcut icon" href="<?php echo esc_url( $favicon ); ?>">
    <?php endif; ?>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="header" class="site-header" role="banner">
		<div class="site-branding">

		<?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) : ?>

			<?php the_custom_logo(); ?>

		<?php elseif ( sugarspice_get_legacy_logo_url() ) : ?>
		<?php $logo_image = sugarspice_get_legacy_logo_url(); ?>
        
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-img"><img src="<?php echo esc_url( $logo_image ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" /></a>
            
        <?php else : ?>

        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a></h1>
        <h2 class="site-description"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></h2>
        
        <?php endif; ?>
        
		</div>
        <div id="nav-wrapper">
            <div class="ribbon-left"></div>
            <nav id="main-nav" class="main-navigation" role="navigation">
                <div class="skip-link"><a class="screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'sugarspice' ); ?></a></div>
                <?php 
                if ( has_nav_menu( 'primary' ) ) {
                    wp_nav_menu( array( 
                        'theme_location'=> 'primary', 
                        'container'     => false,
                        'menu_id'       => 'nav',
                        'fallback_cb'   => 'wp_page_menu',
                        'depth'         => 2,
                    ) ); 
                } else {
                ?>
                    <ul id="nav">
                        <?php wp_list_pages( 'title_li=' ); ?>
                    </ul>
                <?php
                }
                ?>
            </nav><!-- #site-navigation -->
            <div class="ribbon-right"></div>
        </div>
	</header><!-- #header -->

	<div id="main" class="site-main">
 
