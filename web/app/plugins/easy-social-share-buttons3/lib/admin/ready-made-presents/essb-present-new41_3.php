<?php
function essb_get_present_settings($position = '') {
	$result = array ();
	$result ["{$position}_activate"] = "true";
	$result ["{$position}_button_style"] = "icon";
	$result ["{$position}_template"] = "54";
	$result ["{$position}_more_button_icon"] = "dots";
	$result ["{$position}_more_button_func"] = "2";
	$result ["{$position}_show_counter"] = "true";
	$result ["{$position}_counter_pos"] = "hidden";
	$result ["{$position}_total_counter_pos"] = "leftbig";
	$result ["{$position}_fullwidth_align"] = "left";
	$result ["{$position}_button_width"] = "auto";
	$result ["{$position}_networks"] = array ("facebook", "twitter", "more", "google", "linkedin", "stumbleupon", "pinterest" );
	$result ["{$position}_nospace"] = "";
	
	$all_networks = essb_available_social_networks();
	
	$result ["{$position}_networks_order"] = array();
	foreach ($result["{$position}_networks"] as $network) {
		$data = isset($all_networks[$network]) ? $all_networks[$network] : array("name" => $network);
		$result["{$position}_networks_order"][] = $network."|".$data["name"]; 
	}
	
	foreach ($all_networks as $key => $data) {
		if (!in_array($key, $result["{$position}_networks"])) {
			$result["{$position}_networks_order"][] = $key."|".$data["name"];
		}
	}
	
	$result ["{$position}_name_change"] = "false";

	$result ["more_button_popstyle"] = "modern";
	$result ["more_button_poptemplate"] = "18";
	
	return $result;
}