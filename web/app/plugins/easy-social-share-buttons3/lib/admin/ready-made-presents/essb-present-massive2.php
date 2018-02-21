<?php
function essb_get_present_settings($position = '') {
	$result = array ();
	$result ["{$position}_activate"] = "true";
	$result ["{$position}_button_style"] = "button";
	$result ["{$position}_template"] = "50";
	$result ["{$position}_more_button_icon"] = "plus";
	$result ["{$position}_more_button_func"] = "1";
	$result ["{$position}_show_counter"] = "";
	$result ["{$position}_counter_pos"] = "hidden";
	$result ["{$position}_total_counter_pos"] = "leftbig";
	$result ["{$position}_fullwidth_align"] = "center";
	$result ["{$position}_button_width"] = "full";
	$result ["{$position}_fullwidth_share_buttons_correction"] = "97";
	$result ["{$position}_networks"] = array ("facebook", "twitter", "google" );
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
	
	$result ["{$position}_name_change"] = "true";
	$result ["{$position}_facebook_name"] = "SHARE ON FACEBOOK";
	$result ["{$position}_twitter_name"] = "SHARE ON TWITTER";
	$result ["{$position}_google_name"] = "SHARE ON GOOGLE+";
	
	return $result;
}