<?php
function essb_get_present_settings($position = '') {
	$result = array ();
	$result ["{$position}_activate"] = "true";
	$result ["{$position}_button_style"] = "button";
	$result ["{$position}_more_button_icon"] = "plus";
	$result ["{$position}_more_button_func"] = "1";
	$result ["{$position}_show_counter"] = "";
	$result ["{$position}_counter_pos"] = "insidebeforename";
	$result ["{$position}_total_counter_pos"] = "hidden";
	$result ["{$position}_fixed_width_align"] = "right";
	$result ["{$position}_fixed_width_value"] = "90";
	$result ["{$position}_button_width"] = "fixed";
	$result ["{$position}_nospace"] = "true";	
	
	return $result;
}