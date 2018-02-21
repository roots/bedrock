<?php

class ESSBSubscribeButtonWidget extends WP_Widget {

	/**
	 * Sets up a new Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array('classname' => 'widget_essb_subscribe', 'description' => __( "Draw subscribe form (opt-in form) as widget.") );
		parent::__construct('easy-subscribe-widget', __('Easy Social Share Buttons: Subscribe Form'), $widget_ops);
		$this->alt_option_name = 'widget_essb_subscribe';
	}

	/**
	 * Outputs the content for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Recent Posts widget instance.
	 */
	public function widget( $args, $instance ) {		
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$mode = ( ! empty( $instance['mode'] ) ) ? $instance['mode'] : '';
		$design = ( ! empty( $instance['design'] ) ) ? $instance['design'] : '';
		
		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		if (!empty($title)) {
			echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title'];
		}
		
		if (!class_exists('ESSBNetworks_Subscribe')) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/networks/essb-subscribe.php');
		}
			
		echo ESSBNetworks_Subscribe::draw_inline_subscribe_form($mode, $design, true, 'widget');
		
		if (!empty($title)) {
			echo $args['after_widget'];
		}
		
	}

	/**
	 * Handles updating the settings for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['mode'] = sanitize_text_field( $new_instance['mode'] );
		$instance['design'] = sanitize_text_field( $new_instance['design'] );
		return $instance;
	}

	/**
	 * Outputs the settings form for the Recent Posts widget.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$design     = isset( $instance['design'] ) ? esc_attr( $instance['design'] ) : '';
		$mode     = isset( $instance['mode'] ) ? esc_attr( $instance['mode'] ) : '';
		
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'mode' ); ?>"><?php _e( 'Form type:' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'mode' ); ?>" name="<?php echo $this->get_field_name( 'mode' ); ?>">
			<option value="form" <?php if ($mode == "form") echo 'selected="selected"'; ?>>Custom code form</option>
			<option value="mailchimp" <?php if ($mode == "mailchimp") echo 'selected="selected"'; ?>>Service integrated subscribe form</option>
		</select></p>

		<p><label for="<?php echo $this->get_field_id( 'design' ); ?>"><?php _e( 'Design:' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'design' ); ?>" name="<?php echo $this->get_field_name( 'design' ); ?>">
			<option value="design1" <?php if ($design == "design1") echo 'selected="selected"'; ?>>Design #1</option>
			<option value="design2" <?php if ($design == "design2") echo 'selected="selected"'; ?>>Design #2</option>
			<option value="design3" <?php if ($design == "design3") echo 'selected="selected"'; ?>>Design #3</option>
			<option value="design4" <?php if ($design == "design4") echo 'selected="selected"'; ?>>Design #4</option>
			<option value="design5" <?php if ($design == "design5") echo 'selected="selected"'; ?>>Design #5</option>
			<option value="design6" <?php if ($design == "design6") echo 'selected="selected"'; ?>>Design #6</option>
			<option value="design7" <?php if ($design == "design7") echo 'selected="selected"'; ?>>Design #7</option>
			<option value="design8" <?php if ($design == "design8") echo 'selected="selected"'; ?>>Design #8</option>
			<option value="design9" <?php if ($design == "design9") echo 'selected="selected"'; ?>>Design #9</option>
			
		</select></p>
		
<?php
	}
}

  function init_wp_widget_essb_subscribe_button() {
    register_widget( 'ESSBSubscribeButtonWidget' );
  }

  add_action( 'widgets_init', 'init_wp_widget_essb_subscribe_button' );

