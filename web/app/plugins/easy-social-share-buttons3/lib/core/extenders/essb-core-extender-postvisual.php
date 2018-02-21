<?php

/**
 * EasySocialShareButtons CoreExtender: PostVisualOptions
 * 
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2016 AppsCreo
 * @since 3.4
 * 
 */

class ESSBCoreExtenderPostVisualOptions {
	
	/**
	 * 
	 * 
	 * @param unknown_type $post
	 * @param unknown_type $global_button_positions
	 * @return multitype:multitype:string boolean  multitype:string unknown  multitype:string Ambigous <string, boolean>  multitype:string multitype:unknown
	 */
	public static function get($post, $global_button_positions) {
		global $essb_options;
		
		$essb_post_button_style = get_post_meta($post->ID, 'essb_post_button_style', true);
		$essb_post_template = get_post_meta($post->ID, 'essb_post_template', true);
		$essb_post_counters = get_post_meta($post->ID, 'essb_post_counters', true);
		$essb_post_counter_pos = get_post_meta($post->ID, 'essb_post_counter_pos', true);
		$essb_post_total_counter_pos = get_post_meta($post->ID, 'essb_post_total_counter_pos', true);
		$essb_post_animations = get_post_meta($post->ID, 'essb_post_animations', true);
		$essb_post_optionsbp = get_post_meta($post->ID, 'essb_post_optionsbp', true);
		$essb_post_content_position = get_post_meta($post->ID, 'essb_post_content_position', true);
			
		$essb_post_button_position = array();
		foreach ( essb_available_button_positions() as $position => $name ) {
			$position_value =  get_post_meta($post->ID, 'essb_post_button_position_'.$position, true);
			if ($position_value != '') {
				$essb_post_button_position[$position] = $position_value;
			}
		}
			
		$essb_post_native = get_post_meta($post->ID, 'essb_post_native', true);
		$essb_post_native_skin = get_post_meta($post->ID, 'essb_post_native_skin', true);
		
		// generate array with post modifiers
		$output_modifier = array();
		
		if (!empty($essb_post_button_style)) {
			$output_modifier[] = array("type" => "design_options", "param" => "button_style", "value" => $essb_post_button_style);
		}
		if (!empty($essb_post_counters)) {
			$output_modifier[] = array("type" => "button_style", "param" => "show_counter", "value" => ESSBOptionValuesHelper::unified_true($essb_post_counters));
		}
		if (!empty($essb_post_counter_pos)) {
			$output_modifier[] = array("type" => "button_style", "param" => "counter_pos", "value" => $essb_post_counter_pos);
		}
		if (!empty($essb_post_total_counter_pos)) {
			$output_modifier[] = array("type" => "button_style", "param" => "total_counter_pos", "value" => $essb_post_total_counter_pos);
		}
		
		// native activate or deactivate based on post settings
		if (!empty($essb_post_native)) {
			$essb_options['native_active'] = ESSBOptionValuesHelper::unified_true($essb_post_native);
		
			if ($essb_options['native_active']) {
				// manually activate and deactivate native buttons
				if (!defined('ESSB3_NATIVE_ACTIVE')) {
					
					//$resource_builder = ESSBResourceBuilder::get_instance();
					
					include_once (ESSB3_PLUGIN_ROOT . 'lib/core/native-buttons/essb-skinned-native-button.php');
					include_once (ESSB3_PLUGIN_ROOT . 'lib/core/native-buttons/essb-social-privacy.php');
					include_once (ESSB3_PLUGIN_ROOT . 'lib/core/native-buttons/essb-native-buttons-helper.php');
					define('ESSB3_NATIVE_ACTIVE', true);
		
					$essb_spb = ESSBSocialPrivacyNativeButtons::get_instance();
					ESSBNativeButtonsHelper::$essb_spb = $essb_spb;
					foreach ($essb_spb->resource_files as $key => $object) {
						essb_resource_builder()->add_static_resource($object["file"], $object["key"], $object["type"]);
					}
					foreach (ESSBSkinnedNativeButtons::get_assets() as $key => $object) {
						essb_resource_builder()->add_static_resource($object["file"], $object["key"], $object["type"]);
					}
					essb_resource_builder()->add_css(ESSBSkinnedNativeButtons::generate_skinned_custom_css(), 'essb-skinned-native-buttons');
						
					// asign instance of native buttons privacy class to helper
						
					// register active social network apis
					foreach (ESSBNativeButtonsHelper::get_list_of_social_apis() as $key => $code) {
						essb_resource_builder()->add_social_api($key);
					}
				}
			}
			else {
				define('ESSB3_NATIVE_DEACTIVE', true);
			}
		}
		
		// end native buttons loader
		if (!empty($essb_post_native_skin)) {
			$essb_options['skin_native'] = ESSBOptionValuesHelper::unified_true($essb_post_native_skin);
		}
		
		// change active button positions
		$modified_global_button_position = false;
		$new_button_positions_set = array();
		foreach ($essb_post_button_position as $position => $active) {
			if (ESSBOptionValuesHelper::unified_true($active)) {
				$new_button_positions_set[] = $position;
				$modified_global_button_position = true;
			}
		}
		foreach ($global_button_positions as $settings_position) {
			if (!isset($essb_post_button_position[$settings_position])) {
				$new_button_positions_set[] = $settings_position;
			}
		}
			
		if ($modified_global_button_position) {
			$output_modifier[] = array("type" => "general_options", "param" => "button_position", "value" => $new_button_positions_set);
			$output_modifier[] = array("type" => "global", "param" => "modified_locations", "value" => true);
				
		}
		
		if (!empty($essb_post_template)) {
			$output_modifier[] = array("type" => "global", "param" => "post_template", "value" => $essb_post_template);
		}
		if (!empty($essb_post_animations)) {
			$output_modifier[] = array("type" => "global", "param" => "post_animations", "value" => $essb_post_animations);
		}
		if (!empty($essb_post_content_position)) {
			$output_modifier[] = array("type" => "general_options", "param" => "content_position", "value" => $essb_post_content_position);
		}
		
		return $output_modifier;
	}
	
	
}

?>