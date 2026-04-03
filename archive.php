<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Sugar & Spice
 */

get_header(); ?>
	<?php $archive_layout = sugarspice_get_layout_option( 'ap_layout', 'excerpt' ); ?>

	<div id="primary" class="content-area">  

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
						if ( is_category() ) :
							single_cat_title();

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_author() ) :
							/* Queue the first post, that way we know
							 * what author we're dealing with (if that is the case).
							*/
							the_post();
							printf( esc_html__( 'Author: %s', 'sugarspice' ), '<span class="vcard">' . esc_html( get_the_author() ) . '</span>' );
							/* Since we called the_post() above, we need to
							 * rewind the loop back to the beginning that way
							 * we can run the loop properly, in full.
							 */
							rewind_posts();

						elseif ( is_day() ) :
							printf( esc_html__( 'Day: %s', 'sugarspice' ), '<span>' . esc_html( get_the_date() ) . '</span>' );

						elseif ( is_month() ) :
							printf( esc_html__( 'Month: %s', 'sugarspice' ), '<span>' . esc_html( get_the_date( 'F Y' ) ) . '</span>' );

						elseif ( is_year() ) :
							printf( esc_html__( 'Year: %s', 'sugarspice' ), '<span>' . esc_html( get_the_date( 'Y' ) ) . '</span>' );

						elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
							esc_html_e( 'Asides', 'sugarspice' );

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							esc_html_e( 'Images', 'sugarspice');

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							esc_html_e( 'Videos', 'sugarspice' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							esc_html_e( 'Quotes', 'sugarspice' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							esc_html_e( 'Links', 'sugarspice' );

						else :
							esc_html_e( 'Archives', 'sugarspice' );

						endif;
					?>
				</h1>
				<?php
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						echo '<div class="taxonomy-description">' . wp_kses_post( $term_description ) . '</div>';
					endif;
				?>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					if ( 'excerpt' === $archive_layout ) {
                        get_template_part( 'content', 'loop' );
					} elseif ( 'firstfull' === $archive_layout ) {
                        get_template_part( 'content', 'firstfull' );                    
                    } else {
                        get_template_part( 'content' );                    
                    }
                ?>

			<?php endwhile; ?>

			<?php sugarspice_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'archive' ); ?>

		<?php endif; ?>

	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
