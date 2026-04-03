<?php
/**
 * Contact widget.
 *
 * @package sugarspice
 */

class sugarspice_contact_widget extends WP_Widget {

	/**
	 * Set up the widget.
	 */
	public function __construct() {
		parent::__construct(
			'sugarspice_contact_widget',
			__( 'Sugar & Spice: Contact widget', 'sugarspice' ),
			array(
				'classname'   => 'sugarspice_contact_widget',
				'description' => __( 'Displays contact info with icons', 'sugarspice' ),
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
		$address       = $instance['address'] ?? '';
		$phone         = $instance['phone'] ?? '';
		$email         = $instance['email'] ?? '';
		$before_widget = isset( $args['before_widget'] ) ? $args['before_widget'] : '';
		$after_widget  = isset( $args['after_widget'] ) ? $args['after_widget'] : '';
		$before_title  = isset( $args['before_title'] ) ? $args['before_title'] : '';
		$after_title   = isset( $args['after_title'] ) ? $args['after_title'] : '';

		echo $before_widget; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( $title ) {
			echo $before_title . esc_html( $title ) . $after_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		?>
		<ul>
			<?php if ( $address ) : ?>
			<li>
				<i class="icon-home" aria-hidden="true"></i>
				<b><?php esc_html_e( 'Address', 'sugarspice' ); ?>:</b> <?php echo esc_html( $address ); ?>
			</li>
			<?php endif; ?>
			<?php if ( $phone ) : ?>
			<li>
				<i class="icon-phone" aria-hidden="true"></i>
				<b><?php esc_html_e( 'Phone', 'sugarspice' ); ?>:</b> <?php echo esc_html( $phone ); ?>
			</li>
			<?php endif; ?>
			<?php if ( $email ) : ?>
			<li>
				<i class="icon-envelope-alt" aria-hidden="true"></i>
				<b><?php esc_html_e( 'Email', 'sugarspice' ); ?>:</b>
				<a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a>
			</li>
			<?php endif; ?>
		</ul>
		<?php
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
		$instance['title']   = sanitize_text_field( $new_instance['title'] ?? '' );
		$instance['address'] = sanitize_text_field( $new_instance['address'] ?? '' );
		$instance['phone']   = sanitize_text_field( $new_instance['phone'] ?? '' );
		$instance['email']   = sanitize_email( $new_instance['email'] ?? '' );

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
			'title'   => __( 'Contact', 'sugarspice' ),
			'address' => '',
			'phone'   => '',
			'email'   => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		
		<!-- Widget Title -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'sugarspice' ); ?>:</label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:90%;" />
		</p>
		<!-- Addres -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>"><?php esc_html_e( 'Address', 'sugarspice' ); ?>:</label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'address' ) ); ?>" value="<?php echo esc_attr( $instance['address'] ); ?>" style="width:90%;" />
		</p>
		<!-- Phone -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>"><?php esc_html_e( 'Phone', 'sugarspice' ); ?>:</label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'phone' ) ); ?>" value="<?php echo esc_attr( $instance['phone'] ); ?>" style="width:90%;" />
		</p>
		<!-- Email -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"><?php esc_html_e( 'Email', 'sugarspice' ); ?>:</label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" value="<?php echo esc_attr( $instance['email'] ); ?>" style="width:90%;" />
		</p>        
	<?php
	}
}
