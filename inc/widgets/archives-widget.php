<?php
/**
 * Archives widget.
 */

class sugarspice_archives_widget extends WP_Widget {

	public function __construct() {
	    parent::__construct(
    	    'sugarspice_archives_widget',
        	__('Sugar & Spice: Archives / Categories / Pages List', 'sugarspice'),
        	array(
	            'classname' => 'sugarspice_archives_widget',
    	        'description' => __('Displays a list of monthly archives, categories or pages in two columns.', 'sugarspice')
        	)
    	);
	}

	/**
	 * Widget setup.
	 */
	//function sugarspice_archives_widget() {
		/* Widget settings. */
	//	$widget_ops = array( 'classname' => 'sugarspice_archives_widget', 'description' => __('Displays a list of monthly archives, categories or pages in two columns.', 'sugarspice') );

		/* Widget control settings. */
	//	$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'sugarspice_archives_widget' );

		/* Create the widget. */
	//	$this->WP_Widget( 'sugarspice_archives_widget', __('Sugar & Spice: Archives / Categories / Pages List', 'sugarspice'), $widget_ops, $control_ops );
	//}

	/**
	 * How to display the widget on the screen.
	 */
	public function widget( $args, $instance ) {
		$title         = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '' );
		$type          = isset( $instance['type'] ) ? $instance['type'] : 'archives';
		$before_widget = isset( $args['before_widget'] ) ? $args['before_widget'] : '';
		$after_widget  = isset( $args['after_widget'] ) ? $args['after_widget'] : '';
		$before_title  = isset( $args['before_title'] ) ? $args['before_title'] : '';
		$after_title   = isset( $args['after_title'] ) ? $args['after_title'] : '';

		echo $before_widget;

		if ( $title ) {
			echo $before_title . esc_html( $title ) . $after_title;
		}

		$items = $this->get_items_by_type( $type );
		$page_n = count( $items );
		$page_col = (int) ceil( $page_n / 2 );
		$page_left = array_slice( $items, 0, $page_col );
		$page_right = array_slice( $items, $page_col );
		?>
		<div class="archive-list">
			<ul class="archive-left">
				<?php echo implode( '', $page_left ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</ul>
			<ul class="archive-right">
				<?php echo implode( '', $page_right ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</ul>
		</div>
		<?php

		echo $after_widget;
	}

	/**
	 * Get widget items for the selected list type.
	 *
	 * @param string $type Selected list type.
	 * @return array<int,string>
	 */
	protected function get_items_by_type( $type ) {
		$type = in_array( $type, array( 'archives', 'categories', 'pages' ), true ) ? $type : 'archives';

		if ( 'pages' === $type ) {
			$markup = wp_list_pages( 'title_li=&echo=0&depth=1&style=list' );
		} elseif ( 'categories' === $type ) {
			$markup = wp_list_categories( 'show_count=0&title_li=&echo=0&depth=-1&style=list' );
		} else {
			$markup = wp_get_archives( 'type=monthly&echo=0' );
		}

		$items = preg_split( '/<\/li>\s*/', trim( (string) $markup ) );
		$items = array_filter( (array) $items );

		return array_map(
			static function ( $item ) {
				return $item . '</li>';
			},
			$items
		);
	}

	/**
	 * Update the widget settings.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['type'] = in_array( $new_instance['type'], array( 'archives', 'categories', 'pages' ), true ) ? $new_instance['type'] : 'archives';

		return $instance;
	}


	public function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __( 'Archives', 'sugarspice' ), 'type' => 'archives' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'sugarspice' ); ?>:</label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:90%;" />
		</p>


		<!-- Type -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php esc_html_e( 'Type', 'sugarspice' ); ?>:</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>" class="widefat type" style="width:100%;">
				<option value="archives" <?php selected( 'archives', $instance['type'] ); ?>><?php esc_html_e( 'archives', 'sugarspice' ); ?></option>
				<option value="categories" <?php selected( 'categories', $instance['type'] ); ?>><?php esc_html_e( 'categories', 'sugarspice' ); ?></option>
				<option value="pages" <?php selected( 'pages', $instance['type'] ); ?>><?php esc_html_e( 'pages', 'sugarspice' ); ?></option>
			</select>
		</p>


	<?php
	}
}
