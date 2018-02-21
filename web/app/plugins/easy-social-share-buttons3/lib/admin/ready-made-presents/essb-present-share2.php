<?php
function essb_get_present_settings($position = '') {
	$result = array ();
	$result ["{$position}_activate"] = "true";
	$result ["{$position}_button_style"] = "icon";
	$result ["{$position}_more_button_icon"] = "plus";
	$result ["{$position}_more_button_func"] = "1";
	$result ["{$position}_show_counter"] = "true";
	$result ["{$position}_counter_pos"] = "hidden";
	$result ["{$position}_total_counter_pos"] = "hidden";
	$result ["{$position}_fullwidth_align"] = "center";
	$result ["{$position}_button_width"] = "auto";
	$result ["{$position}_networks"] = array ("share", "facebook", "twitter", "google", "pinterest", "buffer", "love" );
	$result ["{$position}_nospace"] = "";
	$result ["{$position}_share_button_icon"] = "share-alt-square";
	$result ["{$position}_share_button_func"] = "1";
	$result ["{$position}_share_button_style"] = "button";
	$result ["{$position}_share_button_counter"] = "insidename";
	
	
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
	
	$result ["{$position}_name_change"] = "true";
	$result ["{$position}_share_name"] = "Share";	
	return $result;
}