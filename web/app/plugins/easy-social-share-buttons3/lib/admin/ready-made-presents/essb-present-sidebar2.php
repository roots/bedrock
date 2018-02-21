<?php
function essb_get_present_settings($position = '') {
	$result = array ();
	$result ["{$position}_activate"] = "true";
	$result ["{$position}_button_style"] = "icon";
	$result ["{$position}_template"] = "23";
	$result ["{$position}_more_button_icon"] = "dots";
	$result ["{$position}_more_button_func"] = "2";
	$result ["{$position}_show_counter"] = "true";
	$result ["{$position}_counter_pos"] = "bottom";
	$result ["{$position}_total_counter_pos"] = "hidden";
	$result ["{$position}_fullwidth_align"] = "left";
	$result ["{$position}_button_width"] = "auto";
	$result ["{$position}_nospace"] = "true";

	$result ["{$position}_name_change"] = "";

	return $result;
}