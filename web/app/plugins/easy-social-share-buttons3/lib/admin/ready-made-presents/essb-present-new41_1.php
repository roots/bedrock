<?php
function essb_get_present_settings($position = '') {
	$result = array ();
	$result ["{$position}_activate"] = "true";
	$result ["{$position}_button_style"] = "button";
	$result ["{$position}_template"] = "6";
	$result ["{$position}_more_button_icon"] = "dots";
	$result ["{$position}_more_button_func"] = "4";
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
	
	$result ["{$position}_name_change"] = "true";
	$result ["{$position}_facebook_name"] = "Share on Facebook";
	$result ["{$position}_twitter_name"] = "Share on Twitter";
	$result ["{$position}_google_name"] = "-";
	$result ["{$position}_pinterest_name"] = "-";
	$result ["{$position}_linkedin_name"] = "-";
	$result ["{$position}_del_name"] = "-";
	$result ["{$position}_stumbleupon_name"] = "-";
	
	return $result;
}