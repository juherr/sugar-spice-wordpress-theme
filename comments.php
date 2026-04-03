<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to sugarspice_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package Sugar & Spice
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

if ( post_password_required() ) {
	return;
}
?>

	<div id="comments" class="comments-area section">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title section-title">
		<span>
			<?php
				/* translators: %1$s: number of comments. */
				$comments_title = _nx(
					'%1$s comment',
					'%1$s comments',
					get_comments_number(),
					'comments title',
					'sugarspice'
				);

				printf(
					esc_html( $comments_title ),
					esc_html( number_format_i18n( get_comments_number() ) )
				);
			?>
		</span>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'sugarspice' ); ?></h1>
			<div class="nav-previous">
				<?php previous_comments_link( esc_html__( '&larr; Older Comments', 'sugarspice' ) ); ?>
			</div>
			<div class="nav-next">
				<?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'sugarspice' ) ); ?>
			</div>
		</nav><!-- #comment-nav-above -->
		<?php endif; ?>

		<ol class="comment-list">
			<?php
				/*
				Loop through and list the comments. Tell wp_list_comments()
				 * to use sugarspice_comment() to format the comments.
				 * If you want to override this in a child theme, then you can
				 * define sugarspice_comment() and that will be used instead.
				 * See sugarspice_comment() in inc/template-tags.php for more.
				 */
				wp_list_comments(
					array(
						'callback'    => 'sugarspice_comment',
						'avatar_size' => 60,
					)
				);
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'sugarspice' ); ?></h1>
			<div class="nav-previous">
				<?php previous_comments_link( esc_html__( '&larr; Older Comments', 'sugarspice' ) ); ?>
			</div>
			<div class="nav-next">
				<?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'sugarspice' ) ); ?>
			</div>
		</nav><!-- #comment-nav-below -->
		<?php endif; ?>

	<?php endif; ?>

	<?php
		// Show a note when comments are closed but existing comments are still visible.
	if ( ! comments_open() && 0 !== get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'sugarspice' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'comment_notes_before' => '',
			'comment_notes_after'  => '',
		)
	);
	?>

</div><!-- #comments -->
