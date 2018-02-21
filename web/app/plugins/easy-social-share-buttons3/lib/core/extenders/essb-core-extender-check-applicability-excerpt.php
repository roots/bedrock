<?php
/**
 * EasySocialShareButtons CoreExtender: Check Applicability Excerpt
 *
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2016 AppsCreo
 * @since 3.6
 *
 */

if (!function_exists('essb_check_applicability_excerpt')) {
	function essb_check_applicability_excerpt($post_types = array(), $location = '', $options, $general_options) {
		global $post;
		
		// @since 3.4.2 - check to ensure buttons will not appear in feed or search
		if (is_search() || is_feed()) {
			return false;
		}
		
		$current_active_post_type = "";
		if ($general_options['reset_posttype'] && isset($post)) {
			$current_active_post_type = isset($post->post_type) ? $post->post_type : "";
		}
		
		if ($general_options['reset_postdata']) {
			wp_reset_postdata();
		}
		
		// @since 3.0
		// another check to avoid buttons appear on unwanted post types
		
		$is_exclusive_active = false;
		if (isset($post)) {
			$is_exclusive_active = essb_is_plugin_activated_on();
		}
		
		if ($general_options['reset_posttype'] && !empty($current_active_post_type)) {
			if (!in_array($current_active_post_type, $post_types)) {
				if (!$is_exclusive_active) {
					return false;
				}
			}
		}
		
		
		$is_all_lists = in_array('all_lists', $post_types);
		$is_set_list = count($post_types) > 0 ?  true: false;
		
		unset($post_types['all_lists']);
		$is_lists_authorized = (is_archive() || is_front_page() || is_search() || is_tag() || is_post_type_archive() || is_home());
		$is_singular = is_singular($post_types);
		if ($is_singular && !$is_set_list) {
			$is_singular = false;
		}
		
		if (isset($post)) {
			if (!in_array($post->post_type, $post_types, false)) {
				$is_lists_authorized = false;
				$is_singular = false;
			}
		}
		
		if ($general_options['deactivate_homepage']) {
			if (is_home() || is_front_page()) {
				$is_lists_authorized = false;
				$is_singular = false;
			}
		}
		
		
		
		if ($general_options['display_exclude_from'] != "") {
			$excule_from = explode(',', $general_options['display_exclude_from']);
		
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
		
		if ($is_exclusive_active) {
			$is_singular = true;
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