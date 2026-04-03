<?php
/**
 * Archives widget.
 *
 * @package sugarspice
 */

class sugarspice_archives_widget extends WP_Widget {

	/**
	 * Set up the widget.
	 */
	public function __construct() {
		parent::__construct(
			'sugarspice_archives_widget',
			__( 'Sugar & Spice: Archives / Categories / Pages List', 'sugarspice' ),
			array(
				'classname'   => 'sugarspice_archives_widget',
				'description' => __( 'Displays a list of monthly archives, categories or pages in two columns.', 'sugarspice' ),
			)
		);
	}

	/**
	 * How to display the widget on the screen.
	 *
	 * @param array $args     Display arguments.
	 * @param array $instance Saved values.
	 * @return void
	 */
	public function widget( $args, $instance ) {
		$title         = apply_filters( 'widget_title', $instance['title'] ?? '', $instance, $this->id_base );
		$type          = $instance['type'] ?? 'archives';
		$before_widget = isset( $args['before_widget'] ) ? $args['before_widget'] : '';
		$after_widget  = isset( $args['after_widget'] ) ? $args['after_widget'] : '';
		$before_title  = isset( $args['before_title'] ) ? $args['before_title'] : '';
		$after_title   = isset( $args['after_title'] ) ? $args['after_title'] : '';

		echo $before_widget; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( $title ) {
			echo $before_title . esc_html( $title ) . $after_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
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

		echo $after_widget; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
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
	 *
	 * @param array $new_instance New values.
	 * @param array $old_instance Old values.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title'] = sanitize_text_field( $new_instance['title'] ?? '' );
		$instance['type']  = in_array( $new_instance['type'] ?? '', array( 'archives', 'categories', 'pages' ), true ) ? $new_instance['type'] : 'archives';

		return $instance;
	}

	/**
	 * Display the widget form in the admin area.
	 *
	 * @param array $instance Current values.
	 * @return void
	 */
	public function form( $instance ) {
		$defaults = array(
			'title' => __( 'Archives', 'sugarspice' ),
			'type'  => 'archives',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'sugarspice' ); ?>:</label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:90%;" />
		</p>


		<!-- Type -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php esc_html_e( 'Type', 'sugarspice' ); ?>:</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>" class="widefat type" style="width:100%;">
				<option value="archives" <?php selected( 'archives', $instance['type'] ); ?>><?php esc_html_e( 'Archives', 'sugarspice' ); ?></option>
				<option value="categories" <?php selected( 'categories', $instance['type'] ); ?>><?php esc_html_e( 'Categories', 'sugarspice' ); ?></option>
				<option value="pages" <?php selected( 'pages', $instance['type'] ); ?>><?php esc_html_e( 'Pages', 'sugarspice' ); ?></option>
			</select>
		</p>


	<?php
	}
}
