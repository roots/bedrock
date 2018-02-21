<?php

class ESSBSocialProfiles {
	private static $instance = null;
	
	private $activated = true;
	
	public static function get_instance() {
	
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	
	} // end get_instance;
	
	function __construct() {
		$is_active = false;
		
		if (essb_option_bool_value('profiles_display')) {
			$profiles_display_position = essb_option_value('profiles_display_position');
			
			if ($profiles_display_position != 'widget') {
				$is_active = true;
				
				if (essb_option_bool_value('profiles_mobile_deactivate')) {
					if (essb_is_mobile()) {
						$is_active = false;
					}
				}
			}
		}
				
		if ($is_active) {
			add_action( 'wp_enqueue_scripts' , array ( $this , 'register_front_assets' ), 1);
			add_action( 'wp_footer', array($this, 'display_profiles'));
		}
	}	
	
	public function register_front_assets() {
		if (essb_is_plugin_deactivated_on() || essb_is_module_deactivated_on('profiles')) {
			$this->activated = false;
			return;
		}
		
		essb_resource_builder()->add_static_resource(ESSB3_PLUGIN_URL . '/lib/modules/social-followers-counter/assets/css/essb-followers-counter.min.css', 'essb-social-followers-counter', 'css');
		essb_resource_builder()->activate_resource('profiles_css');
	
	}
	
	function display_profiles() {
		if (essb_is_plugin_deactivated_on() || essb_is_module_deactivated_on('profiles')) {
			return "";
		}
		
		
		$profiles_display_position = essb_option_value('profiles_display_position');
		$profiles_template = essb_option_value('profiles_template');
		$profiles_animation = essb_option_value('profiles_animation');
		$profiles_nospace = essb_option_bool_value('profiles_nospace');

		$profile_networks = ESSBSocialProfilesHelper::get_active_networks();
		
		if (!is_array($profile_networks)) {
			$profile_networks = array();
		}
		
		$profile_networks_order = ESSBSocialProfilesHelper::get_active_networks_order();
		
		if (!is_array($profile_networks_order)) {
			$profile_networks_order = array();
		}
		
		$profiles = array();
		foreach ($profile_networks_order as $network) {
			
			if (in_array($network, $profile_networks)) {
				$value_address = essb_option_value('profile_'.$network);
				
				if (!empty($value_address)) {
					$profiles[$network] = $value_address;
				}
			}
		}		
		
		$options = array(
				'position' => $profiles_display_position,
				'template' => $profiles_template,
				'animation' => $profiles_animation,
				'nospace' => $profiles_nospace,
				'networks' => $profiles
				);
		
		echo $this->draw_social_profiles($options);
	}
	
	/**
	 * draw_social_profiles
	 * 
	 * @param array $options
	 * @since 4.0
	 */
	public static function draw_social_profiles($options) {
		
		$instance_position = isset ( $options ['position'] ) ? $options ['position'] : '';
		$instance_new_window = 1;
		$instance_nofollow = 1;
		$instance_template = isset ( $options ['template'] ) ? $options ['template'] : 'flat';
		$instance_animation = isset ( $options ['animation'] ) ? $options ['animation'] : '';
		$instance_nospace = isset ( $options ['nospace'] ) ? $options ['nospace'] : 0;
		$instance_networks = isset($options['networks']) ? $options['networks'] : array();

		// compatibility with previous template slugs
		if (!empty($instance_template)) {
			if ($instance_template == "lite") {
				$instance_template = "light";
			}
			if ($instance_template == "grey-transparent") {
				$instance_template = "grey";
			}
			if ($instance_template == "color-transparent") {
				$instance_template = "color";
			}
		}
		
		$names = ESSBSocialProfilesHelper::get_text_of_buttons();
		
		$class_template = (! empty ( $instance_template )) ? " essbfc-template-" . $instance_template : '';
		$class_animation = (! empty ( $instance_animation )) ? " essbfc-icon-" . $instance_animation : '';
		$class_columns = 'essbfc-col-profiles';
		$class_nospace = (intval ( $instance_nospace ) == 1) ? " essbfc-nospace" : "";
				
		$class_position = ($instance_position != '') ? ' essbfc-profiles-bar essbfc-profiles-'.$instance_position : '';
		
		$link_nofollow = (intval ( $instance_nofollow ) == 1) ? ' rel="nofollow"' : '';
		$link_newwindow = (intval ( $instance_new_window ) == 1) ? ' target="_blank"' : '';
		
		// loading animations
		if (! empty ( $class_animation )) {
			essb_resource_builder ()->add_static_footer_css ( ESSB3_PLUGIN_URL . '/lib/modules/social-followers-counter/assets/css/hover.css', 'essb-social-followers-counter-animations', 'css' );
		}
		
		$code = '';
		// followers main element
		$code .= sprintf ( '<div class="essbfc-container essbfc-container-profiles %1$s%2$s%3$s%4$s%5$s">', '', $class_columns, $class_template, $class_nospace, $class_position );
		
		
		$code .= '<ul>';
		
		foreach ( $instance_networks as $social => $url ) {
			$social_display = $social;
			if ($social_display == "instgram") {
				$social_display = "instagram";
			}

			$social_custom_icon = '';
			
			if ($social == 'xing') {
				$social_custom_icon = ' essb_icon_xing';
			}
		
			$code .= sprintf ( '<li class="essbfc-%1$s">', $social_display );
			
			$link_title = isset($names[$social]) ? ' title="'.$names[$social].'"' : '';
			
			$network_nofollow = $link_nofollow;
			if ($social == 'rss') {
				$deactivate_trigger = false;
				$deactivate_trigger = apply_filters('essb5_remove_profile_rss_nofollow', $deactivate_trigger);
				
				if ($deactivate_trigger) {
					$network_nofollow = '';
				}
			}
		
			$follow_url = $url;
			if (! empty ( $follow_url )) {
				$code .= sprintf ( '<a href="%1$s"%2$s%3$s%4$s>', $follow_url, $link_newwindow, $network_nofollow, $link_title );
			}
		
			$code .= '<div class="essbfc-network">';
			$code .= sprintf ( '<i class="essbfc-icon essbfc-icon-%1$s%2$s%3$s"></i>', $social_display, $class_animation, $social_custom_icon );
			$code .= '</div>';
		
			if (! empty ( $follow_url )) {
				$code .= '</a>';
			}
			$code .= '</li>';
		}
		
		$code .= '</ul>';
		
		$code .= '</div>';
		
		return $code;
	}
	
	public static function _deprecated_generate_social_profile_icons($profiles = array(), $button_type = 'square', 
			$button_size = 'small', $button_fill = 'colored', $nospace = true, $position = '', $profiles_text = false, 
			$profiles_texts = array(), $button_width = '') {
		
		$output = "";
		
		
		$nospace_class = ($nospace) ? " essb-profiles-nospace" : "";
		$position_classs = (!empty($position)) ? " essb-profiles-".$position : "";
		
		if (!empty($position)) {
			if ($position != "left" && $position != "right") {
				$position_classs .= " essb-profiles-horizontal";
			}
 		}
 		
 		$single_width = "";
 		// @since 3.0.4
 		if (!$profiles_text) {
 			$button_width = "";
 		}
 		
 		if (!empty($button_width)) {
 			if (strpos($button_width, 'px') === false && strpos($button_width, '%') === false) {
 				$button_width .= 'px';
 			}
 			
 			$button_width = ' style="width:'.$button_width.'; display: inline-block;"';
 			$single_width = ' style="width:100%"';
 		}
		
		$output .= sprintf('<div class="essb-profiles essb-profiles-%1$s essb-profiles-size-%2$s%3$s%4$s">', $button_type, $button_size,
				$nospace_class, $position_classs);
		
		$output .= '<ul class="essb-profile">';
				
		
		foreach ($profiles as $network => $address) {
			
			if ($profiles_text) {
				$text = isset($profiles_texts[$network]) ? $profiles_texts[$network] : '';
				
				if (!empty($text)) {
					$text = '<span class="essb-profile-text">'.$text.'</span>';
				}
				
				$output .= sprintf('<li class="essb-single-profile" %6$s><a href="%1$s" target="_blank" rel="nofollow" class="essb-profile-all essb-profile-%2$s-%3$s" %5$s><span class="essb-profile-icon essb-profile-%2$s"></span>%4$s</a></li>', $address, $network, $button_fill, $text, $single_width, $button_width);
			}
			else {
				$output .= sprintf('<li class="essb-single-profile"><a href="%1$s" target="_blank" rel="nofollow" class="essb-profile-all essb-profile-%2$s-%3$s"><span class="essb-profile-icon essb-profile-%2$s"></span></a></li>', $address, $network, $button_fill);
			}
		}
		
		$output .= '</ul>';
		$output .= "</div>";

		return $output;
	}
	
}

?>