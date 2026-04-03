<?php
/**
 * Social widget.
 *
 * @package sugarspice
 */

class sugarspice_social_widget extends WP_Widget {

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
	protected function get_profiles() {
		return array(
			'facebook'   => array( 'label' => __( 'Follow me on Facebook', 'sugarspice' ), 'icon' => 'icon-facebook' ),
			'twitter'    => array( 'label' => __( 'Follow me on Twitter', 'sugarspice' ), 'icon' => 'icon-twitter' ),
			'googleplus' => array( 'label' => __( 'Follow me on Google+', 'sugarspice' ), 'icon' => 'icon-google-plus' ),
			'pinterest'  => array( 'label' => __( 'Follow me on Pinterest', 'sugarspice' ), 'icon' => 'icon-pinterest' ),
			'instagram'  => array( 'label' => __( 'Follow me on Instagram', 'sugarspice' ), 'icon' => 'icon-instagram' ),
			'youtube'    => array( 'label' => __( 'Subscribe to my YouTube channel', 'sugarspice' ), 'icon' => 'icon-youtube' ),
			'flickr'     => array( 'label' => __( 'Follow me on Flickr', 'sugarspice' ), 'icon' => 'icon-flickr' ),
			'rss'        => array( 'label' => __( 'Subscribe to my RSS feed', 'sugarspice' ), 'icon' => 'icon-rss' ),
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
		$before_widget = isset( $args['before_widget'] ) ? $args['before_widget'] : '';
		$after_widget  = isset( $args['after_widget'] ) ? $args['after_widget'] : '';
		$before_title  = isset( $args['before_title'] ) ? $args['before_title'] : '';
		$after_title   = isset( $args['after_title'] ) ? $args['after_title'] : '';
		$profiles = $this->get_profiles();

		echo $before_widget; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( $title ) {
			echo $before_title . esc_html( $title ) . $after_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
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
		$defaults = array(
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
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'sugarspice' ); ?>:</label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:90%;" />
		</p>
        
		<p><?php esc_html_e( 'Enter full URL. Leave a field empty to hide that icon.', 'sugarspice' ); ?></p>
		
		<!-- Facebook URL -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>"><?php esc_html_e( 'URL address of your Facebook profile or page', 'sugarspice' ); ?>:</label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'facebook' ) ); ?>" value="<?php echo esc_attr( $instance['facebook'] ); ?>" style="width:90%;" />
		</p>
        
		<!-- Twitter URL -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>"><?php esc_html_e( 'URL address of your Twitter profile', 'sugarspice' ); ?>:</label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter' ) ); ?>" value="<?php echo esc_attr( $instance['twitter'] ); ?>" style="width:90%;" />
		</p>
        
		<!-- Google Plus URL -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'googleplus' ) ); ?>"><?php esc_html_e( 'URL address of your Google+ profile', 'sugarspice' ); ?>:</label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'googleplus' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'googleplus' ) ); ?>" value="<?php echo esc_attr( $instance['googleplus'] ); ?>" style="width:90%;" />
		</p>    
        
		<!-- Pinterest URL -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'pinterest' ) ); ?>"><?php esc_html_e( 'URL address of your Pinterest profile', 'sugarspice' ); ?>:</label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'pinterest' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'pinterest' ) ); ?>" value="<?php echo esc_attr( $instance['pinterest'] ); ?>" style="width:90%;" />
		</p>

		<!-- Instagram URL -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>"><?php esc_html_e( 'URL address of your Instagram profile', 'sugarspice' ); ?>:</label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'instagram' ) ); ?>" value="<?php echo esc_attr( $instance['instagram'] ); ?>" style="width:90%;" />
		</p>
        
		<!-- YouTube URL -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>"><?php esc_html_e( 'URL address of your YouTube channel', 'sugarspice' ); ?>:</label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'youtube' ) ); ?>" value="<?php echo esc_attr( $instance['youtube'] ); ?>" style="width:90%;" />
		</p>
        
		<!-- Flickr URL -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'flickr' ) ); ?>"><?php esc_html_e( 'URL address of your Flickr profile page', 'sugarspice' ); ?>:</label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'flickr' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'flickr' ) ); ?>" value="<?php echo esc_attr( $instance['flickr'] ); ?>" style="width:90%;" />
		</p>
        
		<!-- RSS URL -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'rss' ) ); ?>"><?php esc_html_e( 'URL address of your RSS feed', 'sugarspice' ); ?>:</label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'rss' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'rss' ) ); ?>" value="<?php echo esc_attr( $instance['rss'] ); ?>" style="width:90%;" />
		</p>
	<?php
	}
}
