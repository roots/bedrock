<?php

/**
 * ESSBLightModeHelper
 * 
 * Provides predefined variables and designs for Easy Mode
 * 
 * @package EasySocialShareButtons
 * @author appscreo
 * @since 3.4.2
 *
 */
class ESSBLightModeHelper {
	
	public static function apply_global_options($options = array()) {
		
		$options['twitter_message_tags_to_hashtags'] = 'false';
		$options['twitter_message_optimize'] = 'false';
		$options['facebookadvanced'] = 'false';
		$options['pinterest_sniff_disable'] = 'false';
		$options['mail_function'] = 'link';
		$options['activate_ga_tracking'] = 'false';
		$options['activate_ga_campaign_tracking'] = '';
		$options['sso_apply_the_content'] = 'false';
		$options['native_active'] = 'false';
		$options['esml_active'] = 'false';
		
		return $options;
	}
	
	public static function position_with_predefined_options($position = '') {
		if ($position == 'postfloat' || $position == 'sidebar' || $position == 'popup' || $position == 'flyin') {
			return true;
		}
		else {
			return false;
		}
	}
	
	public static function apply_position_predefined_settings($position = '', $style = array()) {
		if ($position == 'flyin' || $position == 'popup') {
			$style['button_style'] = 'button';
			$style['button_width'] = 'column';
			
			if ($position == 'popup') {
				$style['button_width_columns'] = '3';
			}
			if ($position == 'flyin') {
				$style['button_width_columns'] = '2';
			}
			
			if ($style['show_counter']) {
				$style['counter_pos'] = 'insidename';
				$style['total_counter_pos'] = 'before';
			}
		}
		
		if ($position == 'sidebar' || $position == 'postfloat') {
			$style['button_width'] = '';
			
			if ($style['show_counter']) {
				$style['button_style'] = 'button';
				
				if ($position == 'sidebar') {
					$style['counter_pos'] = 'bottom';
					$style['total_counter_post'] = 'leftbig';
				}
				if ($position == 'postfloat') {
					$style['counter_pos'] = 'inside';
					$style['button_width'] = 'fixed';
					$style['button_width_fixed_value'] = '50';
					$style['button_width_fixed_align'] = 'right';
					$style['total_counter_pos'] = 'hidden';
				}
			}
			else {
				$style['button_style'] = 'icon_hover';
			}
		}
		
		return $style;
	}
	
}