<?php
declare(strict_types=1);

/**
 * Contact widget.
 *
 * @package sugarspice
 */
class sugarspice_contact_widget extends WP_Widget {

	/**
	 * Return default widget values.
	 *
	 * @return array<string,string>
	 */
	protected function get_defaults(): array {
		return array(
			'title'   => __( 'Contact', 'sugarspice' ),
			'address' => '',
			'phone'   => '',
			'email'   => '',
		);
	}

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
		$instance      = wp_parse_args( (array) $instance, $this->get_defaults() );
		$title         = apply_filters( 'widget_title', $instance['title'] ?? '', $instance, $this->id_base );
		$address       = $instance['address'];
		$phone         = $instance['phone'];
		$email         = $instance['email'];
		$before_widget = isset( $args['before_widget'] ) ? $args['before_widget'] : '';
		$after_widget  = isset( $args['after_widget'] ) ? $args['after_widget'] : '';
		$before_title  = isset( $args['before_title'] ) ? $args['before_title'] : '';
		$after_title   = isset( $args['after_title'] ) ? $args['after_title'] : '';

		echo wp_kses_post( $before_widget );

		if ( $title ) {
			echo wp_kses_post( $before_title ) . esc_html( $title ) . wp_kses_post( $after_title );
		}

		$email_address = antispambot( $email );
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
				<a href="mailto:<?php echo esc_attr( $email_address ); ?>"><?php echo esc_html( $email_address ); ?></a>
			</li>
			<?php endif; ?>
		</ul>
		<?php
		echo wp_kses_post( $after_widget );
	}

	/**
	 * Update the widget settings.
	 *
	 * @param array $new_instance New values.
	 * @param array $old_instance Old values.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		unset( $old_instance );

		$instance            = array();
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
		$instance = wp_parse_args( (array) $instance, $this->get_defaults() );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'sugarspice' ); ?>:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>"><?php esc_html_e( 'Address', 'sugarspice' ); ?>:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'address' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['address'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>"><?php esc_html_e( 'Phone', 'sugarspice' ); ?>:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'phone' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['phone'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"><?php esc_html_e( 'Email', 'sugarspice' ); ?>:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" type="email" value="<?php echo esc_attr( $instance['email'] ); ?>" />
		</p>        
		<?php
	}
}
