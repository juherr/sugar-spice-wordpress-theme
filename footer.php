<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Sugar & Spice
 */
?>
		<?php
		$has_prefooter = is_active_sidebar( 'prefooter-1' )
			|| is_active_sidebar( 'prefooter-2' )
			|| is_active_sidebar( 'prefooter-3' );
		?>
	</div><!-- #main -->
		<?php if ( $has_prefooter ) : ?>
			<div id="prefooter">
				<div id="prefooter-inner" class="row">

				<?php if ( is_active_sidebar( 'prefooter-1' ) ) : ?>
				<div <?php sugarspice_prefooter_class(); ?> role="complementary">
					<?php dynamic_sidebar( 'prefooter-1' ); ?>
				</div><!-- #first .widget-area -->
				<?php endif; ?>

				<?php if ( is_active_sidebar( 'prefooter-2' ) ) : ?>
				<div <?php sugarspice_prefooter_class(); ?> role="complementary">
					<?php dynamic_sidebar( 'prefooter-2' ); ?>
				</div><!-- #second .widget-area -->
				<?php endif; ?>

				<?php if ( is_active_sidebar( 'prefooter-3' ) ) : ?>
				<div <?php sugarspice_prefooter_class(); ?> role="complementary">
					<?php dynamic_sidebar( 'prefooter-3' ); ?>
				</div><!-- #third .widget-area -->
				<?php endif; ?>
								
				</div>
			</div><!-- #prefooter -->
		<?php endif; ?>
		</div><!-- #page -->

		<footer id="footer" class="site-footer" role="contentinfo">
			<?php
			if ( has_nav_menu( 'footer' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_id'        => 'footer-nav',
						'fallback_cb'    => 'wp_page_menu',
						'depth'          => 1,
					)
				);
			}
			?>
			<div class="site-info">
				<?php do_action( 'sugarspice_credits' ); ?>
				<a href="https://wordpress.org/" rel="generator">
					<?php
					/* translators: %s: WordPress. */
					printf( esc_html__( 'Proudly powered by %s', 'sugarspice' ), 'WordPress' );
					?>
				</a>
				<span class="sep"> | </span>
				<?php
				/* translators: 1: theme name, 2: theme author link. */
				$theme_credit = __( 'Theme: %1$s by %2$s.', 'sugarspice' );

				printf(
					wp_kses_post( $theme_credit ),
					'Sugar &amp; Spice',
					'<a href="https://webtuts.pl" rel="designer noopener noreferrer">WebTuts</a>'
				);
				?>
			</div><!-- .site-info -->
		</footer>

<?php wp_footer(); ?>

</body>
</html>
