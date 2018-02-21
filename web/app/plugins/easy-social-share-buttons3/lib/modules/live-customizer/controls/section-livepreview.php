<?php
$list = isset($_REQUEST['list']) ? $_REQUEST['list'] : '';
global $debug_output, $networks, $networks_order;
$debug_output = array();
if ($list != '') {
	$params = explode('|', $list);
		
	foreach ($params as $param) {
		$value = isset($_REQUEST[$param]) ? $_REQUEST[$param] : '';

		if (is_array($value)) {
			$update_at = $value['update'];
				
			if ($update_at == 'options') {
				$debug_output[$param] = isset($value['value']) ? $value['value'] : '';
			}
		}
		
	}
}

$position = isset($debug_output['position']) ? $debug_output['position'] : '';

$networks = isset($debug_output[$position.'_networks']) ? $debug_output[$position.'_networks'] : array();
$networks_order = isset($debug_output[$position.'_networks_order']) ? $debug_output[$position.'_networks_order'] : '';

if (is_array($networks)) {
	add_filter('essb4_draw_customize_networks', 'essb_add_livepreview_networks');
	
	function essb_add_livepreview_networks($current_networks) {
		global $networks;
		
		return $networks;
	}
}

if (is_array($networks_order)) {
	add_filter('essb4_draw_customize_networks_order', 'essb_add_livepreview_networks_order');
	
	function essb_add_livepreview_networks_order($current_networks) {
		global $networks_order;
		
		$current_networks = array();
		
		foreach ($networks_order as $text_values) {
			$key_array = explode('|', $text_values);
			$network_key = $key_array[0];
				
			$current_networks[] = $network_key;
		}
	
		return $current_networks;
	}
	
}


//echo '<pre>';
//var_dump($debug_output);
//echo '</pre>';

add_filter('essb4_draw_style_details', essb_livepreview_styles);

function essb_debugdata_livepreview($styles, $debug_data, $styles_key, $debug_key, $bool_value = false) {
	$styles_value = isset($styles[$styles_key]) ? $styles[$styles_key] : '';
	$debug_value = isset($debug_data[$debug_key]) ? $debug_data[$debug_key] : '';
	
	if ($bool_value && $debug_value == '') {
		$debug_value = '';
	}
	
	if ($bool_value) {
		return $debug_value;
	}
	else {
		if ($debug_value != ''){
			return $debug_value;
		}
		else {
			return $styles_value;
		}
	}
}

function essb_livepreview_styles($basic_style) {
	global $debug_output;
	
	$position = isset($debug_output['position']) ? $debug_output['position'] : '';
	
	$basic_style['template'] = essb_debugdata_livepreview($basic_style, $debug_output, 'template', $position.'_template');
	
	$basic_style['button_align'] = essb_debugdata_livepreview($basic_style, $debug_output, 'button_align', $position.'_button_pos');
	$basic_style['button_width'] = essb_debugdata_livepreview($basic_style, $debug_output, 'button_width', $position.'_button_width');
	
	$basic_style['button_width_fixed_value'] = essb_debugdata_livepreview($basic_style, $debug_output, 'button_width_fixed_value', $position.'_fixed_width_value');
	$basic_style['button_width_fixed_align'] = essb_debugdata_livepreview($basic_style, $debug_output, 'button_width_fixed_align', $position.'_fixed_width_align');
	$basic_style['button_width_full_button'] = essb_debugdata_livepreview($basic_style, $debug_output, 'button_width_full_button', $position.'_fullwidth_share_buttons_correction');
	
	$basic_style['button_width_columns'] = essb_debugdata_livepreview($basic_style, $debug_output, 'button_width_columns', $position.'_fullwidth_share_buttons_columns');
	$basic_style['fullwidth_align'] = essb_debugdata_livepreview($basic_style, $debug_output, 'fullwidth_align', $position.'_fullwidth_align');
	$basic_style['fullwidth_share_buttons_columns_align'] = essb_debugdata_livepreview($basic_style, $debug_output, 'fullwidth_share_buttons_columns_align', $position.'_fullwidth_share_buttons_columns_align');
	$basic_style['button_animation'] = essb_debugdata_livepreview($basic_style, $debug_output, 'button_animation', $position.'_css_animations');
	$basic_style['button_style'] = essb_debugdata_livepreview($basic_style, $debug_output, 'button_style', $position.'_button_style');
	$basic_style['nospace'] = essb_debugdata_livepreview($basic_style, $debug_output, 'nospace', $position.'_nospace', true);
	
	$basic_style['show_counter'] = essb_debugdata_livepreview($basic_style, $debug_output, 'show_counter', $position.'_show_counter', true);
	$basic_style['counter_pos'] = essb_debugdata_livepreview($basic_style, $debug_output, 'counter_pos', $position.'_counter_pos');
	$basic_style['total_counter_pos'] = essb_debugdata_livepreview($basic_style, $debug_output, 'total_counter_pos', $position.'_total_counter_pos');
	
	//var_dump($basic_style);
	
	return $basic_style;
}

echo essb_core()->generate_share_buttons($position, 'share', array("only_share" => true));

essb_resource_builder()->generate_custom_footer_css();

?>
