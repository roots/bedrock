<?php
function essb_get_present_settings($position = '') {
	$result = array ();
	$result ["{$position}_activate"] = "true";
	$result ["{$position}_button_style"] = "icon_hover";
	$result ["{$position}_button_pos"] = "center";
	$result ["{$position}_more_button_icon"] = "plus";
	$result ["{$position}_more_button_func"] = "1";
	$result ["{$position}_show_counter"] = "true";
	$result ["{$position}_counter_pos"] = "insidehover";
	$result ["{$position}_total_counter_pos"] = "leftbig";
	$result ["{$position}_fullwidth_align"] = "left";
	$result ["{$position}_button_width"] = "flex";
	$result ["{$position}_nospace"] = "";
	
	$result ["{$position}_name_change"] = "";
	
	return $result;
}