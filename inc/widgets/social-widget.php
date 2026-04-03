<?php
declare(strict_types=1);

/**
 * Social widget.
 *
 * @package sugarspice
 */
class sugarspice_social_widget extends WP_Widget {

	/**
	 * Return default widget values.
	 *
	 * @return array<string,string>
	 */
	protected function get_defaults(): array {
		return array(
			'title'      => __( 'Follow me', 'sugarspice' ),
			'rss'        => '',
			'facebook'   => '',
			'twitter'    => '',
			'googleplus' => '',
			'pinterest'  => '',
			'instagram'  => '',
			'youtube'    => '',
			'flickr'     => '',
		);
	}

	/**
	 * Set up the widget.
	 */
	public function __construct() {
		parent::__construct(
			'sugarspice_social_widget',
			__( 'Sugar & Spice: Social media icons', 'sugarspice' ),
			array(
				'classname'   => 'sugarspice_social_widget',
				'description' => __( 'Displays icons to social media profiles.', 'sugarspice' ),
			)
		);
	}

	/**
	 * Supported social profiles.
	 *
	 * @return array
	 */
	protected function get_profiles(): array {
		return array(
			'facebook'   => array(
				'label' => __( 'Follow me on Facebook', 'sugarspice' ),
				'icon'  => 'icon-facebook',
			),
			'twitter'    => array(
				'label' => __( 'Follow me on Twitter', 'sugarspice' ),
				'icon'  => 'icon-twitter',
			),
			'googleplus' => array(
				'label' => __( 'Follow me on Google+', 'sugarspice' ),
				'icon'  => 'icon-google-plus',
			),
			'pinterest'  => array(
				'label' => __( 'Follow me on Pinterest', 'sugarspice' ),
				'icon'  => 'icon-pinterest',
			),
			'instagram'  => array(
				'label' => __( 'Follow me on Instagram', 'sugarspice' ),
				'icon'  => 'icon-instagram',
			),
			'youtube'    => array(
				'label' => __( 'Subscribe to my YouTube channel', 'sugarspice' ),
				'icon'  => 'icon-youtube',
			),
			'flickr'     => array(
				'label' => __( 'Follow me on Flickr', 'sugarspice' ),
				'icon'  => 'icon-flickr',
			),
			'rss'        => array(
				'label' => __( 'Subscribe to my RSS feed', 'sugarspice' ),
				'icon'  => 'icon-rss',
			),
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
		$before_widget = isset( $args['before_widget'] ) ? $args['before_widget'] : '';
		$after_widget  = isset( $args['after_widget'] ) ? $args['after_widget'] : '';
		$before_title  = isset( $args['before_title'] ) ? $args['before_title'] : '';
		$after_title   = isset( $args['after_title'] ) ? $args['after_title'] : '';
		$profiles      = $this->get_profiles();

		echo wp_kses_post( $before_widget );

		if ( $title ) {
			echo wp_kses_post( $before_title ) . esc_html( $title ) . wp_kses_post( $after_title );
		}
		?>
		<ul class="social">
			<?php foreach ( $profiles as $key => $profile ) : ?>
				<?php $url = $instance[ $key ] ?? ''; ?>
				<?php if ( $url ) : ?>
				<li>
					<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" class="social-icon" aria-label="<?php echo esc_attr( $profile['label'] ); ?>" title="<?php echo esc_attr( $profile['label'] ); ?>">
						<div class="icon <?php echo esc_attr( $profile['icon'] ); ?>" aria-hidden="true"></div>
					</a>
				</li>
				<?php endif; ?>
			<?php endforeach; ?>
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

		$instance = array();
		$profiles = $this->get_profiles();

		$instance['title'] = sanitize_text_field( $new_instance['title'] ?? '' );

		foreach ( array_keys( $profiles ) as $profile_key ) {
			$instance[ $profile_key ] = esc_url_raw( $new_instance[ $profile_key ] ?? '' );
		}

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
		$fields   = array(
			'facebook'   => __( 'URL address of your Facebook profile or page', 'sugarspice' ),
			'twitter'    => __( 'URL address of your Twitter profile', 'sugarspice' ),
			'googleplus' => __( 'URL address of your Google+ profile', 'sugarspice' ),
			'pinterest'  => __( 'URL address of your Pinterest profile', 'sugarspice' ),
			'instagram'  => __( 'URL address of your Instagram profile', 'sugarspice' ),
			'youtube'    => __( 'URL address of your YouTube channel', 'sugarspice' ),
			'flickr'     => __( 'URL address of your Flickr profile page', 'sugarspice' ),
			'rss'        => __( 'URL address of your RSS feed', 'sugarspice' ),
		);
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'sugarspice' ); ?>:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p><?php esc_html_e( 'Enter full URL. Leave a field empty to hide that icon.', 'sugarspice' ); ?></p>

		<?php foreach ( $fields as $field_key => $field_label ) : ?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( $field_key ) ); ?>"><?php echo esc_html( $field_label ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $field_key ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $field_key ) ); ?>" type="url" value="<?php echo esc_attr( $instance[ $field_key ] ); ?>" />
			</p>
		<?php endforeach; ?>
		<?php
	}
}
