<?php

// Widget action
add_action( 'widgets_init', create_function( '', 'register_widget("LayerSlider_Widget");' ) );

class LayerSlider_Widget extends WP_Widget {

	function __construct() {

		$widget_ops = array( 'classname' => 'layerslider_widget', 'description' => __('Insert a slider with LayerSlider WP Widget', 'LayerSlider') );
		$control_ops = array( 'id_base' => 'layerslider_widget' );
		parent::__construct( 'layerslider_widget', __('LayerSlider WP Widget', 'LayerSlider'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract($args);

		$title = apply_filters('widget_title', $instance['title']);
		$title = !empty($title) ? $before_title . $title . $after_title : $title;

		echo $before_widget, $title, LS_Shortcode::handleShortcode($instance), $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['id'] = strip_tags( $new_instance['id'] );
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}

	function form( $instance ) {

		$defaults = array( 'title' => __('LayerSlider', 'LayerSlider'));
		$instance = wp_parse_args( (array) $instance, $defaults );
		$sliders = LS_Sliders::find(array('limit' => 100));
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'id' ); ?>"><?php _e('Choose a slider:', 'LayerSlider') ?></label><br>
			<?php if($sliders != null && !empty($sliders)) { ?>
			<select id="<?php echo $this->get_field_id( 'id' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'id' ); ?>">
				<?php foreach($sliders as $item) : ?>
				<?php $name = empty($item['name']) ? 'Unnamed' : htmlspecialchars($item['name']); ?>
				<?php if($item['id'] == $instance['id']) { ?>
				<option value="<?php echo $item['id'] ?>" selected="selected"><?php echo $name ?> | #<?php echo $item['id'] ?></option>
				<?php } else { ?>
				<option value="<?php echo $item['id'] ?>"><?php echo $name ?> | #<?php echo $item['id'] ?></option>
				<?php } ?>
				<?php endforeach; ?>
			</select>
			<?php } else { ?>
			<?php _e("You didn't create any slider yet.", "LayerSlider", "LayerSlider") ?>
			<?php } ?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'LayerSlider'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>">
		</p>
	<?php
	}
}
?>
