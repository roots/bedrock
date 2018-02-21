<?php

class ESSBOptionValuesHelper {
	public static function options_value($optionsContainer, $param, $default = '') {
		return isset ( $optionsContainer [$param] ) ? $optionsContainer [$param]  : $default;
	}
	
	public static function options_bool_value($optionsContainer, $param) {
		$value = isset ( $optionsContainer [$param] ) ? $optionsContainer [$param]  : 'false';
	
		if ($value == "true") {
			return true;
		}
		else {
			return false;
		}
	
	}	
	
	public static function is_active_module($module = '') {
		global $essb_options;
		
		$is_active = false;
		
		switch ($module) {			
			case "imageshare":
				$positions = essb_options_value('button_position');
				
				if (is_array($positions)) {
					if (in_array('onmedia', $positions)) {
						$is_active = true;
					}
				}
				break;
			case "cachedcounters":
				$counter_mode = essb_options_value('counter_mode');
				
				// changed since version 4 to different from empty
				if ($counter_mode != "") {
					$is_active = true;
				}
				break;
			case "sharingwidget":
				$button_positions = essb_options_value('button_position');
				if (is_array($button_positions)) {
					if (in_array('widget', $button_positions)) {
						$is_active = true;
					}
				}
				break;
		}
		
		return $is_active;
	}
	
	
	public static function advanced_array_to_simple_array($values) {
		$new = array();
		
		foreach ($values as $key => $text) {
			$new[] = $key;
		}
		
		return $new;
	}
	
	public static function unified_true($value) {
		$result = '';
		
		if ($value == 'true' || $value == 'yes') {
			$result = true;
		}
		else {
			$result = false;		
		}
		
		return $result;
	}	
}


function essb_apply_position_network_names($position, $network_names) {
	
	$networks = essb_available_social_networks();
	
	foreach ($networks as $key => $object) {
		$search_for = $position."_".$key."_name";
		$user_network_name = essb_option_value($search_for);
		if ($user_network_name != '') {
			$network_names[$key] = $user_network_name;
		}
	}

	return $network_names;
}

function essb_active_position_settings ($position = '') {
	if (essb_option_bool_value($position.'_activate')) {
		return true;
	}
	else {
		return false;
	}
}


function essb_apply_position_style_settings($postion, $basic_style) {
	// global variables in pro mode that can be applied for position	
	
	if (!defined('ESSB3_LIGHTMODE')) {
		if (essb_option_value($postion.'_template') != "") {
			$basic_style['template'] = essb_option_value($postion.'_template');
		}

		$basic_style['button_align'] = essb_option_value($postion.'_button_pos');
		$basic_style['button_width'] = essb_option_value($postion.'_button_width');
		$basic_style['button_width_fixed_value'] = essb_option_value($postion.'_fixed_width_value');
		$basic_style['button_width_fixed_align'] = essb_option_value($postion.'_fixed_width_align');
		$basic_style['button_width_full_container'] = essb_option_value($postion.'_fullwidth_share_buttons_container');
		$basic_style['button_width_full_button'] = essb_option_value($postion.'_fullwidth_share_buttons_correction');
		$basic_style['button_width_full_button_mobile'] = essb_option_value($postion.'_fullwidth_share_buttons_correction_mobile');
		$basic_style['button_width_columns'] = essb_option_value($postion.'_fullwidth_share_buttons_columns');

		$basic_style['fullwidth_align'] = essb_option_value( $postion.'_fullwidth_align');
		$basic_style['fullwidth_share_buttons_columns_align'] = essb_option_value( $postion.'_fullwidth_share_buttons_columns_align');
			
		// @since 3.0.3
		$more_button_icon = essb_option_value($postion.'_more_button_icon');
		if ($more_button_icon != '') {
			$basic_style['more_button_icon'] = $more_button_icon;
		}
			
		// @since 3.3
		$more_button_func = essb_option_value($postion.'_more_button_func');
		if ($more_button_func != '') {
			$basic_style['location_more_button_func'] = $more_button_func;
		}
			
		if (intval($basic_style['button_width_full_container']) == 0) {
			$basic_style['button_width_full_container'] = "100";
		}
			
		// @since 3.5 we add animations
		$position_animation = essb_option_value($postion.'_css_animations');
		if (!empty($position_animation)) {
			$basic_style['button_animation'] = $position_animation;
		}
	}

	$basic_style['button_style'] = essb_option_value($postion.'_button_style');
	$basic_style['nospace'] = essb_option_value($postion.'_nospace');

	$basic_style['show_counter'] = essb_option_value($postion.'_show_counter');
	$basic_style['counter_pos'] = essb_option_value($postion.'_counter_pos');
	$basic_style['total_counter_pos'] = essb_option_value($postion.'_total_counter_pos');

	$basic_style['share_button_func'] = essb_option_value($postion.'_share_button_func');
	$basic_style['share_button_icon'] = essb_option_value($postion.'_share_button_icon');
	$basic_style['share_button_style'] = essb_option_value($postion.'_share_button_style');
	$basic_style['share_button_counter'] = essb_option_value($postion.'_share_button_counter');
	
	
	return $basic_style;
}

function essb_apply_mobile_position_style_settings($postion, $basic_style) {

	if (essb_option_value($postion.'_template') != "") {
		$basic_style['template'] = essb_option_value($postion.'_template');
	}

	if ($postion != 'sharebottom') {
		$basic_style['nospace'] = essb_option_value($postion.'_nospace');
		$basic_style['show_counter'] = essb_option_value($postion.'_show_counter');
		$basic_style['counter_pos'] = essb_option_value($postion.'_counter_pos');
		$basic_style['total_counter_pos'] = essb_option_value($postion.'_total_counter_pos');
	}
	return $basic_style;
}

function essb_apply_required_mobile_style_settings($position, $button_style) {
	
	if ($position == 'sharebar' || $position == 'sharepoint') {
		$button_style['button_style'] = "button";
		if ($button_style['show_counter']) {
			if (strpos($button_style['counter_pos'], 'inside') === false && strpos($button_style['counter_pos'], 'hidden') === false) {
				$button_style['counter_pos'] = "insidename";
			}
		
			if ($button_style['total_counter_pos'] != 'hidden' && $button_style['total_counter_pos'] != 'after') {
				$button_style['total_counter_pos'] = "before";
			}
		}
		$button_style['button_width'] = "column";
		$button_style['button_width_columns'] = "1";
	}
	
	return $button_style;
}


function essb_apply_postbar_position_style_settings($postion, $basic_style) {
	if (essb_option_value($postion.'_template') != "") {
		$basic_style['template'] = essb_option_value($postion.'_template');
	}

	$basic_style['nospace'] = essb_option_value($postion.'_nospace');
	$basic_style['show_counter'] = essb_option_value($postion.'_show_counter');
	$basic_style['counter_pos'] = essb_option_value($postion.'_counter_pos');
	$basic_style['total_counter_pos'] = 'hidden';
	$basic_style['button_style'] = essb_option_value($postion.'_button_style');

	if ($basic_style['button_style'] == 'recommended') {
		$basic_style['button_style'] = 'icon';
	}

	return $basic_style;
}

function essb_apply_point_position_style_settings($postion, $basic_style) {
	// point setup to select best display values
	$point_display_style = essb_option_value('point_style');
	if ($point_display_style == "") { $point_display_style = "simple"; }
	$is_demo_advanced = false;
	if (ESSB3_DEMO_MODE) {
		$demo_style = isset($_REQUEST['point_style']) ? $_REQUEST['point_style'] : '';
		if ($demo_style != '') {
			$point_display_style = $demo_style;
			$is_demo_advanced = true;
		}
	}

	if (essb_option_value($postion.'_template') != "") {
		$basic_style['template'] = essb_option_value($postion.'_template');
	}

	$basic_style['nospace'] = essb_option_value($postion.'_nospace');
	$basic_style['show_counter'] = essb_option_value($postion.'_show_counter');
	$basic_style['counter_pos'] = essb_option_value($postion.'_counter_pos');
	$basic_style['total_counter_pos'] = 'hidden';
	$basic_style['button_style'] = essb_option_value($postion.'_button_style');

	if ($basic_style['button_style'] == 'recommended') {
		if ($point_display_style == 'simple') {
			$basic_style['button_style'] = 'icon';
		}
		else {
			$basic_style['button_style'] = 'button';
		}
	}

	$basic_style['button_width'] = "column";
	$basic_style['button_width_columns'] = "1";

	// specific display styling
	if ($point_display_style == 'simple') {
		if ($basic_style['counter_pos'] == 'insidename' || $basic_style['counter_pos'] == 'insidebeforename') {
			$basic_style['counter_pos'] = 'inside';
		}
			
		$basic_style['button_width'] = 'fixed';
		$basic_style['button_width_fixed_value'] = '36';
		$basic_style['button_width_fixed_align'] = 'center';

			
		if ($basic_style['show_counter'] && ($basic_style['counter_pos'] == 'inside' || $basic_style['counter_pos'] == 'bottom')) {
			$basic_style['button_style'] = 'button';

			if ($basic_style['counter_pos'] == 'inside') {
				$basic_style['button_width_fixed_value'] = '85';
				$basic_style['button_width_fixed_align'] = 'right';
			}
		}
	}

	if ($is_demo_advanced) {
		$basic_style['counter_pos'] = 'insidename';
	}

	return $basic_style;
}

function essb_get_active_social_networks_by_position($position) {
	$result = array();

	$result = essb_option_value($position.'_networks');
	if (!is_array($result)) {
		return array();
	}
	else {
		return $result;
	}
}

function essb_get_order_of_social_networks_by_position($position) {
	
	$result = array();
	
	$result = essb_option_value($position.'_networks');
	if (!is_array($result)) {
		return array();
	}
	else {
		return $result;
	}
}