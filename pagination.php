<!-- pagination -->
<?php
if ( function_exists( 'wp_pagenavi' ) ) :
	wp_pagenavi();
else :
	?>
	<div class="wp-pagenavi">
		<div class="alignleft">
			<?php next_posts_link( '&laquo; ' . esc_html__( 'Older posts', 'sugarspice' ) ); ?>
		</div>
		<div class="alignright">
			<?php previous_posts_link( esc_html__( 'Newer posts', 'sugarspice' ) . ' &raquo;' ); ?>
		</div>
	</div>
	<?php
endif;
?>
<!-- /pagination -->
