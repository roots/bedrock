<?php

add_action( 'widgets_init' , create_function( '' , 'return register_widget( "ESSBSocialProfilesWidget" );' ) );

if (!defined('ESSB3_SOCIALPROFILES_ACTIVE')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-profiles/essb-social-profiles.php');
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-profiles/essb-social-profiles-helper.php');
	define('ESSB3_SOCIALPROFILES_ACTIVE', 'true');
	$template_url = ESSB3_PLUGIN_URL . '/lib/modules/social-followers-counter/assets/css/essb-followers-counter.min.css';
	essb_resource_builder()->add_static_footer_css($template_url, 'essb-social-followers-counter');
}

class ESSBSocialProfilesWidget extends WP_Widget {
	
	protected $widget_slug = "easy-social-profile-buttons";

	public function __construct() {

		$options = array( 'description' => __( 'Social Profiles' , 'essb' ), 'classname' => $this->widget_slug."-class" );

		parent::__construct( false , __( 'Easy Social Share Buttons: Social Profiles' , 'essb' ) , $options );

	}
	
	public function form( $instance ) {
		
		$defaults = array(
				'title' => __('Follow us', 'essb') ,
				'template' => 'flat' ,
				'animation' => '' ,
				'nospace' => 0,
				'show_title' => 1
		);
		
		$profile_networks = array();
		$profile_networks = ESSBOptionValuesHelper::advanced_array_to_simple_array(essb_available_social_profiles());
		
		foreach ($profile_networks as $network) {
			$defaults['profile_'.$network] = '';
		}
		
		/*foreach ($profile_networks as $network) {
			$defaults['profile_text_'.$network] = '';
		}*/
	
		$instance = wp_parse_args( ( array ) $instance , $defaults );

		
		$instance_template = isset($instance['template']) ? $instance['template'] : '';
		$instance_animation = isset($instance['animation']) ? $instance['animation'] : '';
		
		?>
		
<p>
  <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title' , 'essb' ); ?>:</label>
  <input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>" id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" value="<?php echo $instance['title']; ?>" />
</p>
	
<p>
  <label for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php echo __( 'Display widget title' , 'essb' ); ?>:</label>
  <input type="checkbox" name="<?php echo $this->get_field_name( 'show_title' ); ?>" id="<?php echo $this->get_field_id( 'show_title' ); ?>" value="1" <?php if ( 1 == $instance['show_title'] ) { echo ' checked="checked"'; } ?> />
</p>

<p>
  <label for="<?php echo $this->get_field_id( 'template' ); ?>"><?php echo __( 'Template' , 'essb' ); ?>:</label>
  <select name="<?php echo $this->get_field_name( 'template' ); ?>" id="<?php echo $this->get_field_id( 'template' ); ?>" class="widefat">
<?php 
foreach (ESSBSocialProfilesHelper::available_templates() as $key => $text) {
	$selected = ($key == $instance_template) ? " selected='selected'" : '';
	
	printf('<option value="%1$s" %2$s>%3$s</option>', $key, $selected, $text);
}
?>
  </select>
</p>

<p>
  <label for="<?php echo $this->get_field_id( 'animation' ); ?>"><?php echo __( 'Animation' , 'essb' ); ?>:</label>
  <select name="<?php echo $this->get_field_name( 'animation' ); ?>" id="<?php echo $this->get_field_id( 'animation' ); ?>" class="widefat">
<?php 
foreach (ESSBSocialProfilesHelper::available_animations() as $key => $text) {
	$selected = ($key == $instance_animation) ? " selected='selected'" : '';
	
	printf('<option value="%1$s" %2$s>%3$s</option>', $key, $selected, $text);
}
?>
  </select>
</p>


<p>
  <label for="<?php echo $this->get_field_id( 'nospace' ); ?>"><?php echo __( 'Remove space between buttons' , 'essb' ); ?>:</label>
  <input type="checkbox" name="<?php echo $this->get_field_name( 'nospace' ); ?>" id="<?php echo $this->get_field_id( 'nospace' ); ?>" value="1" <?php if ( 1 == $instance['nospace'] ) { echo ' checked="checked"'; } ?> />
</p>
		<?php

		foreach (essb_available_social_profiles() as $network => $display) {
			$network_value = $instance['profile_'.$network];
			?>
<p>
  <label for="<?php echo $this->get_field_id('profile_'.$network ); ?>"><?php echo __( $display , 'essb' ); ?>:</label>
  <input type="text" name="<?php echo $this->get_field_name( 'profile_'.$network ); ?>" id="<?php echo $this->get_field_id( 'profile_'.$network ); ?>" class="widefat" value="<?php echo $network_value ?>" />
</p>


			<?php 
		}
		
		?>
		


		<?php 
	}
	
	public function update( $new_instance , $old_instance ) {
		
		$instance = $old_instance;
		
		$profile_networks = array();
		$profile_networks = ESSBOptionValuesHelper::advanced_array_to_simple_array(essb_available_social_profiles());
		
		$instance['title'] = $new_instance['title'];
		$instance['template'] = $new_instance['template'];
		$instance['animation'] = $new_instance['animation'];
		$instance['nospace'] = $new_instance['nospace'];
		$instance['show_title'] = $new_instance['show_title'];
		
		
		foreach ($profile_networks as $network) {
			$instance['profile_'.$network] = $new_instance['profile_'.$network];
		}

		
		return $instance;
	}
	
	public function widget( $args, $instance ) {
		global $essb_options;
		
		if (essb_is_module_deactivated_on('profiles')) {
			return "";
		}
		
		extract($args);
		
		$before_widget = $args['before_widget'];
		$before_title  = $args['before_title'];
		$after_title   = $args['after_title'];
		$after_widget  = $args['after_widget'];
		
		$show_title = $instance['show_title'];
		$title = $instance['title'];
		
		$sc_template = isset($instance['template']) ? $instance['template'] : 'flat';
		$sc_animation = isset($instance['animation']) ? $instance['animation'] : '';
		$sc_nospace = $instance['nospace'];
		
		if (!empty($sc_nospace) && $sc_nospace != '0') {
			$sc_nospace = "true";
		}
		else {
			$sc_nospace = "false";
		}
		$sc_nospace = ESSBOptionValuesHelper::unified_true($sc_nospace);
		
		
		$profile_networks = array();
		$profile_networks = ESSBOptionValuesHelper::advanced_array_to_simple_array(essb_available_social_profiles());
		
		$profiles_order = essb_option_value('profile_networks_order');
		$profiles_order = ESSBSocialProfilesHelper::simplify_order_list($profiles_order);
		if (is_array($profiles_order)) {
			
			if (!in_array('xing', $profiles_order)) {
				$profiles_order[] = 'xing';
			} 
			
			$profile_networks = $profiles_order;
		}
		
		$sc_network_address = array();
		foreach ($profile_networks as $network) {
			$value = isset($instance['profile_'.$network]) ? $instance['profile_'.$network] : '';
			
			if (!empty($value)) {
				$sc_network_address[$network] = $value;
			}
		}
		
		
		if (!empty($show_title)) {
			echo $before_widget . $before_title . $title . $after_title;
		}
		
		// if module is not activated include the code
		
		$options = array(
				'position' => '',
				'template' => $sc_template,
				'animation' => $sc_animation,
				'nospace' => $sc_nospace,
				'networks' => $sc_network_address
		);
		
		echo ESSBSocialProfiles::draw_social_profiles($options);
		
		if (!empty($show_title)) {
			echo $after_widget;
		}
	}
}

?>