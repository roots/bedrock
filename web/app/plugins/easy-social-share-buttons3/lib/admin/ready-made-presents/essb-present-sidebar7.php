<?php
function essb_get_present_settings($position = '') {
	$result = array ();
	$result ["{$position}_activate"] = "true";
	$result ["{$position}_button_style"] = "icon_hover";
	$result ["{$position}_template"] = "49";
	$result ["{$position}_more_button_icon"] = "plus";
	$result ["{$position}_more_button_func"] = "1";
	$result ["{$position}_show_counter"] = "true";
	$result ["{$position}_counter_pos"] = "insidebeforename";
	$result ["{$position}_total_counter_pos"] = "hidden";
	$result ["{$position}_button_width"] = "auto";
	$result ["{$position}_nospace"] = "";
	
	
	$result ["{$position}_name_change"] = "";
	
	return $result;
}