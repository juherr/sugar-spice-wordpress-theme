<?php
/**
 * Content template for the first full post layout.
 *
 * @package Sugar & Spice
 */
?>

<?php
	global $wp_query;

// Display the first post on the home page in full, then switch to excerpts.
if ( ! is_paged() && isset( $wp_query->current_post ) && 0 === (int) $wp_query->current_post ) :

	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'firstfull' ); ?>>
		<header class="entry-header">
		<h1 class="entry-title">
			<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>

			<div class="entry-meta">
				<?php sugarspice_posted_on(); ?>
			</div><!-- .entry-meta -->
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->

		<footer class="entry-meta bottom">
			<?php sugarspice_post_meta(); ?>

		</footer><!-- .entry-meta -->
	</article><!-- #post-## -->
	<?php
else :
	get_template_part( 'content', 'loop' );
endif;
