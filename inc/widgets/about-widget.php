<?php
/**
 * About widget.
 *
 * @package sugarspice
 */

class sugarspice_about_widget extends WP_Widget {

	/**
	 * Set up the widget.
	 */
	public function __construct() {
		parent::__construct(
			'sugarspice_about_widget',
			__( 'Sugar & Spice: About', 'sugarspice' ),
			array(
				'classname'   => 'sugarspice_about_widget',
				'description' => __( 'About section with author image', 'sugarspice' ),
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
		$text          = $instance['text'] ?? '';
		$image         = $instance['image'] ?? '';
		$url           = $instance['url'] ?? '';
		$read_more     = $instance['read_more'] ?? '';
		$before_widget = isset( $args['before_widget'] ) ? $args['before_widget'] : '';
		$after_widget  = isset( $args['after_widget'] ) ? $args['after_widget'] : '';
		$before_title  = isset( $args['before_title'] ) ? $args['before_title'] : '';
		$after_title   = isset( $args['after_title'] ) ? $args['after_title'] : '';

		echo $before_widget; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( $title ) {
			echo $before_title . esc_html( $title ) . $after_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		if ( $image ) {
			?><img src="<?php echo esc_url( $image ); ?>" class="profile" alt="" loading="lazy" /><?php
		}

		if ( $text ) {
			echo wp_kses_post( wpautop( $text ) );
		}

		if ( $url && $read_more ) {
			?><a href="<?php echo esc_url( $url ); ?>" class="button"><?php echo esc_html( $read_more ); ?></a><?php
		}

		echo $after_widget; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
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

		$instance['title']     = sanitize_text_field( $new_instance['title'] ?? '' );
		$instance['image']     = esc_url_raw( $new_instance['image'] ?? '' );
		$instance['url']       = esc_url_raw( $new_instance['url'] ?? '' );
		$instance['read_more'] = sanitize_text_field( $new_instance['read_more'] ?? '' );
		$instance['text']      = wp_kses_post( $new_instance['text'] ?? '' );

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
			'title'     => __( 'About', 'sugarspice' ),
			'text'      => '',
			'image'     => '',
			'url'       => '',
			'read_more' => __( 'Read more', 'sugarspice' ),
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'sugarspice' ); ?>:</label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:90%;" />
		</p>

		<!-- About text -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'About the author text', 'sugarspice' ); ?>:</label>
			<textarea id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" style="width:96%;" rows="6"><?php echo esc_textarea( $instance['text'] ); ?></textarea>
		</p>

		<!-- Image -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php esc_html_e( 'Author image URL', 'sugarspice' ); ?>:</label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" value="<?php echo esc_attr( $instance['image'] ); ?>" style="width:90%;" />
			<small><?php esc_html_e( 'Suggested image dimensions: 120x120px or 100x100px. Image will be rounded automatically!', 'sugarspice' ); ?></small>
		</p>
		<!-- URL -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php esc_html_e( 'Read more URL', 'sugarspice' ); ?>:</label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" value="<?php echo esc_attr( $instance['url'] ); ?>" style="width:90%;" />
		</p>
		<!-- Read more -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'read_more' ) ); ?>"><?php esc_html_e( 'Read more button text', 'sugarspice' ); ?>:</label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'read_more' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'read_more' ) ); ?>" value="<?php echo esc_attr( $instance['read_more'] ); ?>" style="width:90%;" />
		</p>

	<?php
	}
}
