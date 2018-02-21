<?php
function essb_get_present_settings($position = '') {
	$result = array ();
	$result ["mobile_positions"] = "true";
	$result ["button_position_mobile"] = array("sharebottom");
	$result ['mobile_button_style'] = 'button';
	$result ['sharebottom_activate'] = 'true';
	$result ["sharebottom_template"] = "31";
	$result ['mobile_sharebuttonsbar_count'] = "4";
	$result ['mobile_sharebuttonsbar_names'] = '';
	$result ['mobile_sharebuttonsbar_total'] = '';
	$result ["{$position}_more_button_icon"] = "plus";
	$result ["{$position}_more_button_func"] = "1";
	$result ["{$position}_show_counter"] = "true";
	$result ["{$position}_counter_pos"] = "bottom";
	$result ["{$position}_total_counter_pos"] = "hidden";
	$result ["{$position}_fullwidth_align"] = "left";
	$result ["{$position}_button_width"] = "fixed";
	$result ["{$position}_fixed_width_value"] = "48";
	$result ["{$position}_fixed_width_align"] = "center";
	$result ["mobile_networks"] = array ("facebook", "twitter", "google", "pinterest", "whatsapp", "sms", "viber", "telegram", "skype", "messenger" );
	$result ["{$position}_nospace"] = "";
	
	$all_networks = essb_available_social_networks();
	
	$result ["mobile_networks_order"] = array();
	foreach ($result["mobile_networks_order"] as $network) {
		$data = isset($all_networks[$network]) ? $all_networks[$network] : array("name" => $network);
		$result["mobile_networks_order"][] = $network."|".$data["name"]; 
	}
	
	foreach ($all_networks as $key => $data) {
		if (!in_array($key, $result["mobile_networks_order"])) {
			$result["mobile_networks_order"][] = $key."|".$data["name"];
		}
	}
	
	return $result;
}