<?php
/**
 * EasySocialShareButtons CoreExtender: Check Applicability Modules
 *
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2016 AppsCreo
 * @since 3.6
 *
 */

if (!function_exists('essb_check_applicability_module')) {
	function essb_check_applicability_module($location = '', $options, $display_exclude_from) {
		$is_singular = true;
		$is_lists_authorized = true;
		
		// @since 3.4.2 - check to ensure buttons will not appear in feed or search
		if (is_feed()) {
			return false;
		}
		
		if ($display_exclude_from != "") {
			$excule_from = explode(',', $display_exclude_from);
		
			$excule_from = array_map('trim', $excule_from);
		
			if (in_array(get_the_ID(), $excule_from, false)) {
				$is_singular = false;
				$is_lists_authorized = false;
			}
		}
		
		if (essb_is_module_deactivated_on('share')) {
			$is_singular = false;
			$is_lists_authorized = false;
		}
		
		// additional plugin hacks
		$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
		if ($request_uri != '') {
			$exist_ai1ec_export = strpos($request_uri, 'ai1ec_exporter_controller');
			if ($exist_ai1ec_export !== false) {
				$is_singular = false; $is_lists_authorized = false;
			}
		
			$exist_tribe_cal = strpos($request_uri, 'ical=');
			if ($exist_tribe_cal !== false) {
				$is_singular = false; $is_lists_authorized = false;
			}
		}
		
		// check post meta for turned off
		$essb_off = get_post_meta(get_the_ID(),'essb_off',true);
		
		if ($essb_off == "true") {
			$is_lists_authorized = false;
			$is_singular = false;
		}
		
		// deactivate on mobile devices if selected
		if (essb_is_mobile()) {
			if (ESSBOptionValuesHelper::options_value($options, $location.'_mobile_deactivate')) {
				$is_singular = false;
				$is_lists_authorized = false;
			}
		}
		
		// check current location settings
		if ($is_singular || $is_lists_authorized) {
			return true;
		}
		else {
			return false;
		}
	}
}