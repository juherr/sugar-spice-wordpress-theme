<?php
declare(strict_types=1);

/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package sugarspice
 */

if ( ! function_exists( 'sugarspice_content_nav' ) ) :
	/**
	 * Display navigation to next/previous pages when applicable.
	 *
	 * @param string $nav_id Navigation element ID.
	 */
	function sugarspice_content_nav( string $nav_id ): void {
		global $wp_query, $post;

		// Don't print empty markup on single pages if there's nowhere to navigate.
		if ( is_single() ) {
			$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
			$next     = get_adjacent_post( false, '', false );

			if ( ! $next && ! $previous ) {
				return;
			}
		}

		// Don't print empty markup in archives if there's only one page.
		if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
			return;
		}

		$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';

		?>
	<nav
		role="navigation"
		id="<?php echo esc_attr( $nav_id ); ?>"
		class="<?php echo esc_attr( $nav_class ); ?> section"
	>
		<h1 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'sugarspice' ); ?></h1>

		<?php if ( is_single() ) : ?>
		<h2 class="section-title"><span><?php esc_html_e( 'Navigation', 'sugarspice' ); ?></span></h2>
			<?php
			previous_post_link(
				'<div class="nav-previous">%link</div>',
				'<span class="meta-nav">'
				. wp_kses_post( _x( '&larr;', 'Previous post link', 'sugarspice' ) )
				. '</span> %title'
			);
			next_post_link(
				'<div class="nav-next">%link</div>',
				'%title <span class="meta-nav">'
				. wp_kses_post( _x( '&rarr;', 'Next post link', 'sugarspice' ) )
				. '</span>'
			);
			?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous">
			<?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'sugarspice' ) ); ?>
		</div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next">
			<?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'sugarspice' ) ); ?>
		</div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
		<?php
	}
endif; // sugarspice_content_nav

/**
 * Content pagination.
 *
 * @param string $content Current post content.
 * @return string
 */
function sugarspice_link_pages( string $content ): string {
	if ( is_single() ) {
		$content .= wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'sugarspice' ),
				'after'  => '</div>',
				'echo'   => 0,
			)
		);
	}

	return $content;
}
add_filter( 'the_content', 'sugarspice_link_pages', 10 );


if ( ! function_exists( 'sugarspice_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @param WP_Comment $comment Current comment object.
	 * @param array      $args    Comment display arguments.
	 * @param int        $depth   Current comment depth.
	 */
	function sugarspice_comment( $comment, $args, $depth ) {
		// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited -- Required for classic comment template tags.
		$GLOBALS['comment'] = $comment;

		if ( 'pingback' === $comment->comment_type || 'trackback' === $comment->comment_type ) :
			?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php esc_html_e( 'Pingback:', 'sugarspice' ); ?>
			<?php comment_author_link(); ?>
			<?php
			edit_comment_link( __( 'Edit', 'sugarspice' ), '<span class="edit-link">', '</span>' );
			?>
		</div>

		<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<div class="comment-author vcard">
					<?php
					if ( 0 !== (int) $args['avatar_size'] ) {
						echo get_avatar( $comment, (int) $args['avatar_size'] );
					}
					?>
				</div><!-- .comment-author -->
				<div class="comment-box">
					<?php
					/* translators: %s: comment author link. */
					$comment_author_format = __(
						'%s <span class="says">says:</span>',
						'sugarspice'
					);

					echo wp_kses_post(
						sprintf(
							$comment_author_format,
							sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() )
						)
					);
					?>
					<span class="comment-meta">
						<small>
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
								<time datetime="<?php echo esc_attr( get_comment_time( 'c' ) ); ?>">
									<?php
									/* translators: 1: comment date, 2: comment time. */
									$comment_datetime = esc_html_x(
										'%1$s at %2$s',
										'comment date and time',
										'sugarspice'
									);

									echo esc_html(
										sprintf( $comment_datetime, get_comment_date(), get_comment_time() )
									);
									?>
								</time>
						</a>
						<?php
						edit_comment_link( __( 'Edit', 'sugarspice' ), '<span class="edit-link">', '</span>' );
						?>
						</small>
					<?php if ( '0' === $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation">
						<?php esc_html_e( 'Your comment is awaiting moderation.', 'sugarspice' ); ?>
					</p>
					<?php endif; ?>
					</span><!-- .comment-meta -->

					<div class="comment-content">
						<?php comment_text(); ?>
					</div><!-- .comment-content -->



			<?php
				comment_reply_link(
					array_merge(
						$args,
						array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<div class="reply">',
							'after'     => '</div>',
						)
					)
				);
			?>
		</article><!-- .comment-body -->

			<?php
		endif;
	}
endif; // ends check for sugarspice_comment()

if ( ! function_exists( 'sugarspice_the_attached_image' ) ) :
	/**
	 * Prints the attached image with a link to the next attached image.
	 */
	function sugarspice_the_attached_image(): void {
		$post                = get_post();
		$next_id             = 0;
		$attachment_size     = apply_filters( 'sugarspice_attachment_size', array( 1200, 1200 ) );
		$next_attachment_url = wp_get_attachment_url();

		if ( ! $post ) {
			return;
		}

		/**
		 * Grab the IDs of all the image attachments in a gallery so we can get the
		 * URL of the next adjacent image in a gallery, or the first image (if
		 * we're looking at the last image in a gallery), or, in a gallery of one,
		 * just the link to that image file.
		 */
		$attachment_ids = get_posts(
			array(
				'post_parent'    => $post->post_parent,
				'fields'         => 'ids',
				'numberposts'    => -1,
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => 'ASC',
				'orderby'        => 'menu_order ID',
			)
		);

		// If there is more than 1 attachment in a gallery...
		if ( count( $attachment_ids ) > 1 ) {
			foreach ( $attachment_ids as $attachment_id ) {
				if ( $attachment_id === $post->ID ) {
					$next_id = current( $attachment_ids );
					break;
				}
			}

			// get the URL of the next image attachment...
			if ( $next_id ) {
				$next_attachment_url = get_attachment_link( $next_id );

				// or get the URL of the first image attachment.
			} else {
				$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
			}
		}

		printf(
			'<a href="%1$s" rel="attachment">%2$s</a>',
			esc_url( $next_attachment_url ),
			wp_get_attachment_image( $post->ID, $attachment_size )
		);
	}
endif;

/**
 * Filter the image caption shortcode markup.
 *
 * @param string      $val     Current caption shortcode output.
 * @param array       $attr    Caption shortcode attributes.
 * @param string|null $content Caption inner content.
 * @return string
 */
function sugarspice_caption_shortcode_filter( string $val, array $attr, ?string $content = null ): string {
	$attributes = shortcode_atts(
		array(
			'id'      => '',
			'align'   => 'alignnone',
			'width'   => '',
			'caption' => '',
		),
		$attr,
		'caption'
	);

	$id      = (string) $attributes['id'];
	$align   = (string) $attributes['align'];
	$width   = (string) $attributes['width'];
	$caption = (string) $attributes['caption'];

	if ( 1 > (int) $width || empty( $caption ) ) {
		return $val;
	}

	$id_attribute = '';

	if ( $id ) {
		$id_attribute = 'id="' . esc_attr( $id ) . '" ';
	}

	return sprintf(
		'<div %1$sclass="wp-caption %2$s" style="width: %3$dpx;">%4$s<p class="wp-caption-text">%5$s</p></div>',
		$id_attribute,
		esc_attr( $align ),
		(int) $width,
		do_shortcode( $content ),
		wp_kses_post( $caption )
	);
}

add_filter( 'img_caption_shortcode', 'sugarspice_caption_shortcode_filter', 10, 3 );

if ( ! function_exists( 'sugarspice_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function sugarspice_posted_on(): void {
		$time_string = '<span class="posted-on"><a href="%1$s" title="%2$s" rel="bookmark">'
			. '<time class="entry-date published updated" datetime="%3$s">%4$s</time></a></span>';

		$time_string = sprintf(
			$time_string,
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

		$num_comments = get_comments_number();

		if ( comments_open() ) {
			$comments = sprintf(
				/* translators: %s: comment count */
				esc_html( _n( '%s Comment', '%s Comments', $num_comments, 'sugarspice' ) ),
				number_format_i18n( $num_comments )
			);
		} else {
			$comments = __( 'Comments off', 'sugarspice' );
		}

		$comments_string = '<span class="comments"><a href="%1$s"><i class="icon-comment"></i> %2$s</a></span>';

		$comments_string = sprintf(
			$comments_string,
			esc_url( get_comments_link() ),
			esc_html( $comments )
		);

		$author_string = '<span class="byline"> %1$s <span class="author vcard">'
			. '<a href="%2$s" title="%3$s" rel="author" class="fn">%4$s</a></span></span>';

		/* translators: %s: post author name. */
		$author_posts_title = esc_html__(
			'View all posts by %s',
			'sugarspice'
		);

		$author_string = sprintf(
			$author_string,
			/* translators: this text appears next to author name */
			esc_html__( 'by', 'sugarspice' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( $author_posts_title, get_the_author() ) ),
			esc_html( get_the_author() )
		);

		$meta_data = array();

		$display_author   = sugarspice_show_post_meta( 'author' );
		$display_date     = sugarspice_show_post_meta( 'date' );
		$display_comments = sugarspice_show_post_meta( 'comments' );

		if ( $display_author ) {
			$meta_data[] = $author_string;
		}

		if ( $display_date ) {
			$meta_data[] = $time_string;
		}

		if ( $display_comments ) {
			$meta_data[] = $comments_string;
		}

		if ( empty( $meta_data ) ) {
			return;
		}

		echo wp_kses_post( implode( ' // ', $meta_data ) );
	}
endif;

if ( ! function_exists( 'sugarspice_post_meta' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function sugarspice_post_meta(): void {
		/* translators: used between list items, there is a space after the comma */
		$category_list = get_the_category_list( __( ', ', 'sugarspice' ) );

		/* translators: used between list items, there is a space after the comma */
		$tag_list  = get_the_tag_list( '', __( ', ', 'sugarspice' ) );
		$meta_text = '';

		if ( ! sugarspice_categorized_blog() ) {
			if ( '' !== $tag_list ) {
				/* translators: %2$s: list of post tags. */
				$meta_text = __( 'This entry was tagged %2$s.', 'sugarspice' );
			}
		} elseif ( '' !== $tag_list ) {
			/* translators: 1: list of post categories, 2: list of post tags. */
			$meta_text = __(
				'This entry was posted in %1$s and tagged %2$s.',
				'sugarspice'
			);
		} else {
			/* translators: %1$s: list of post categories. */
			$meta_text = __( 'This entry was posted in %1$s.', 'sugarspice' );
		}

		if ( '' === $meta_text ) {
			return;
		}

		printf(
			wp_kses_post( $meta_text ),
			wp_kses_post( $category_list ),
			wp_kses_post( $tag_list )
		);
	}
endif;
/**
 * Filter post_gallery to display gallery as slideshow.
 */
if ( ! function_exists( 'sugarspice_post_gallery' ) ) :
	/**
	 * Render the legacy gallery shortcode as a Flexslider gallery.
	 *
	 * @param string $output Existing gallery output.
	 * @param array  $attr   Gallery shortcode attributes.
	 * @return string
	 */
	function sugarspice_post_gallery( string $output, array $attr ): string {
		global $post;

		static $instance = 0;
		++$instance;

		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );

			if ( ! $attr['orderby'] ) {
				unset( $attr['orderby'] );
			}
		}

		// Let Jetpack keep control of its own gallery output.
		if ( isset( $attr['type'] ) ) {
			return $output;
		}

		$defaults = array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post ? $post->ID : 0,
			'itemtag'    => 'li',
			'icontag'    => 'div',
			'captiontag' => 'div',
			'columns'    => 3,
			'size'       => array( 620, 350 ),
			'include'    => '',
			'exclude'    => '',
			'link'       => '',
		);

		$attributes = shortcode_atts( $defaults, $attr, 'gallery' );
		$order      = (string) $attributes['order'];
		$orderby    = (string) $attributes['orderby'];
		$id         = (int) $attributes['id'];
		$itemtag    = (string) $attributes['itemtag'];
		$captiontag = (string) $attributes['captiontag'];
		$size       = $attributes['size'];
		$include    = (string) $attributes['include'];
		$exclude    = (string) $attributes['exclude'];
		$link       = (string) $attributes['link'];

		if ( 'RAND' === $order ) {
			$orderby = 'none';
		}

		if ( '' !== $include ) {
			$include      = (string) preg_replace( '/[^0-9,]+/', '', $include );
			$_attachments = get_posts(
				array(
					'include'        => $include,
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'order'          => $order,
					'orderby'        => $orderby,
				)
			);

			$attachments = array();

			foreach ( $_attachments as $attachment ) {
				$attachments[ $attachment->ID ] = $attachment;
			}
		} elseif ( '' !== $exclude ) {
			$exclude     = (string) preg_replace( '/[^0-9,]+/', '', $exclude );
			$attachments = get_children(
				array(
					'post_parent'    => $id,
					'exclude'        => $exclude,
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'order'          => $order,
					'orderby'        => $orderby,
				)
			);
		} else {
			$attachments = get_children(
				array(
					'post_parent'    => $id,
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'order'          => $order,
					'orderby'        => $orderby,
				)
			);
		}

		if ( empty( $attachments ) ) {
			return '';
		}

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment ) {
				unset( $attachment );
				$output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
			}

			return $output;
		}

		$itemtag    = tag_escape( $itemtag );
		$selector   = 'slider-' . $instance;
		$captiontag = tag_escape( $captiontag );

		$output .= '<div id="' . esc_attr( $selector ) . '" class="flexslider slider-' . (int) $id . '">';

		$i       = 0;
		$output .= '<ul class="slides">';
		foreach ( $attachments as $attachment_id => $attachment ) {
			$itemclass = ( 0 === $i ) ? 'item active' : 'item';

			if ( 'none' === $link ) {
				$image = wp_get_attachment_image( $attachment_id, $size );
			} elseif ( 'media' === $link ) {
				$image = sprintf(
					'<a href="%1$s" rel="attachment">%2$s</a>',
					esc_url( wp_get_attachment_url( $attachment_id ) ),
					wp_get_attachment_image( $attachment_id, $size )
				);
			} else {
				$image = wp_get_attachment_link( $attachment_id, $size, true, false );
			}

			$output .= '<' . $itemtag . ' class="' . esc_attr( $itemclass ) . '">';
			$output .= $image;

			if ( $captiontag && trim( $attachment->post_excerpt ) ) {
				$output .= '<' . $captiontag . ' class="flex-caption">'
					. wp_kses_post( wptexturize( $attachment->post_excerpt ) )
					. '</' . $captiontag . '>';
			}

			$output .= '</' . $itemtag . '>';
			++$i;
		}

		$output .= '</ul>';
		$output .= '</div>';

		return $output;
	}
endif;
add_filter( 'post_gallery', 'sugarspice_post_gallery', 10, 2 );

/**
 * Remove Gallery Inline Styling
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Returns true if a blog has more than 1 category
 */
function sugarspice_categorized_blog(): bool {
	$all_the_cool_cats = get_transient( 'all_the_cool_cats' );

	if ( false === $all_the_cool_cats ) {
		$all_the_cool_cats = count(
			get_categories(
				array(
					'hide_empty' => 1,
				)
			)
		);

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	return 1 !== (int) $all_the_cool_cats;
}

/**
 * Flush out the transients used in sugarspice_categorized_blog
 */
function sugarspice_category_transient_flusher(): void {
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'sugarspice_category_transient_flusher' );
add_action( 'save_post', 'sugarspice_category_transient_flusher' );
