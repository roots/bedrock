<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}


if (!function_exists('essb_manager')) {
	function essb_manager() {
		return ESSB_Manager::getInstance();
	}
}

if (!function_exists('essb_core')) {
	function essb_core() {
		return essb_manager()->essb();
	}
}

if (!function_exists('essb_resource_builder')) {
	function essb_resource_builder() {
		return essb_manager()->resourceBuilder();
	}
}

if (!function_exists('easy_share_deactivate')) {
	function easy_share_deactivate() {
		essb_manager()->deactiveExecution();
	}
}

if (!function_exists('easy_share_reactivate')) {
	function easy_share_reactivate() {
		essb_manager()->reactivateExecution();
	}
}

if (!function_exists('essb_native_privacy')) {
	function essb_native_privacy() {
		return essb_manager()->privacyNativeButtons();
	}
}

if (!function_exists ('essb_options_value')) {
	function essb_options_value($param, $default = '') {
		return essb_option_value($param);
	}
}

if (!function_exists('essb_options_bool_value')) {
	function essb_options_bool_value($param) {
		return essb_option_bool_value($param);
	}
}

if (!function_exists('essb_options')) {
	function essb_options() {
		return essb_manager()->essbOptions();
	}
}

if (!function_exists('essb_followers_counter')) {
	function essb_followers_counter() {
		return essb_manager()->socialFollowersCounter();
	}
}

if (!function_exists('essb_is_mobile')) {
	function essb_is_mobile() {
		return essb_manager()->isMobile();
	}
}

if (!function_exists('essb_is_tablet')) {
	function essb_is_tablet() {
		return essb_manager()->isTablet();
	}
}

if (!function_exists('essb_is_plugin_activated_on')) {
	function essb_is_plugin_activated_on() {
		if (is_admin()) {
			return;
		}
		
		//display_deactivate_on
		$is_activated = false;
		$display_include_on = essb_options_value('display_include_on');
		if ($display_include_on != '') {
			$excule_from = explode(',', $display_include_on);
	
			$excule_from = array_map('trim', $excule_from);
			if (in_array(get_the_ID(), $excule_from, false)) {
				$is_activated = true;
			}
		}
		return $is_activated;
	}
}

if (!function_exists('essb_is_plugin_deactivated_on')) {
	function essb_is_plugin_deactivated_on() {
		if (is_admin()) {
			return;
		}
		
		//display_deactivate_on
		$is_deactivated = false;
		$display_deactivate_on = essb_options_value('display_deactivate_on');
		if ($display_deactivate_on != '') {
			$excule_from = explode(',', $display_deactivate_on);
				
			$excule_from = array_map('trim', $excule_from);
			if (in_array(get_the_ID(), $excule_from, false)) {
				$is_deactivated = true;
			}
		}
		
		if (!$is_deactivated) {
			if (essb_is_mobile() && essb_option_bool_value('deactivate_mobile')) {
				$is_deactivated = true;
			}
		}
		
		return $is_deactivated;
	}
}

if (!function_exists('essb_is_module_deactivated_on')) {
	function essb_is_module_deactivated_on($module = 'share') {
		if (is_admin()) {
			return;
		}
		
		$is_deactivated = false;
		$exclude_from = essb_options_value( 'deactivate_on_'.$module);
		if (!empty($exclude_from)) {
			$excule_from = explode(',', $exclude_from);
		
			$excule_from = array_map('trim', $excule_from);
			if (in_array(get_the_ID(), $excule_from, false)) {
				$is_deactivated = true;
			}
		}
		return $is_deactivated;
	}
}

if (!function_exists('essb_option_bool_value')) {
	function essb_option_bool_value($param, $options = null) {
		global $essb_options;
		
		if (!$options || !is_array($options)) {
			$options = $essb_options;
		}
		
		$value = isset ( $options [$param] ) ? $options [$param]  : 'false';
		
		if ($value == 'true') {
			return true;
		}
		else {
			return false;
		}
	}
}

if (!function_exists('essb_option_value')) {
	function essb_option_value($param, $options = null) {
		global $essb_options;

		if (!$options || !is_array($options)) {
			$options = $essb_options;
		}

		return isset($options[$param]) ? $options[$param] : '';
	}
}

if (!function_exists('essb_object_value')) {
	function essb_object_value($object, $param, $default = '') {
		return isset($object[$param]) ? $object[$param] : ($default != '' ? $default : '');
	}
}

if (!function_exists('essb_is_test')) {
	function essb_is_test() {
		$automated_test = isset($_REQUEST['P3_NOCACHE']) ? $_REQUEST['P3_NOCACHE'] : '';
		if ($automated_test != '') {
			return true;
		}
		else {
			return false;
		}
	}
}

if (!function_exists('essb_depend_load_function')) {
	function essb_depend_load_function($function, $path) {
		if (!function_exists($function)) {
			include_once ESSB3_PLUGIN_ROOT.$path;
		}
	}
}

if (!function_exists('essb_depend_load_class')) {
	function essb_depend_load_class($class, $path) {
		if (!class_exists($class)) {
			include_once ESSB3_PLUGIN_ROOT.$path;
		}
	}
}

if (!function_exists('essb_installed_wpml')) {
	function essb_installed_wpml() {
		if (class_exists ( 'SitePress' ))
			return (true);
		else
			return (false);
	}
}

if (!function_exists('essb_installed_polylang')) {
	function essb_installed_polylang() {
		if (function_exists('pll_languages_list')) {
			return true;
		}
		else {
			return false;
		}
	}
}

if (!function_exists('essb_show_welcome')) {
	function essb_show_welcome() {
		if (!ESSB3_WELCOME_TAB) {
			return false;
		}
		else if (defined('ESSB3_SETTING5')) {
			return false;
		}
		else {
			$user_disable_welcome = essb_option_bool_value('disable_welcome');			
			
			if (!$user_disable_welcome) {
				return true;
			}
			else {
				return false;
			}
		}
	}
}

if (!function_exists('essb_live_customizer_can_run')) {
	function essb_live_customizer_can_run() {
		$can_run = false;
		if (is_user_logged_in()) {
			if (current_user_can('administrator')) {
				$can_run = true;
			}
		}
		
		if ($can_run) {
			if (essb_option_bool_value('live_customizer_disabled')) {
				$can_run = false;
			}
		}
				
		return apply_filters('essb_live_customizer_can_run', $can_run);
	}
}

if (!function_exists('essb_is_amp_page')) {
	function essb_is_amp_page(){
		// Defined in https://wordpress.org/plugins/amp/ is_amp_endpoint()
	
		if (  function_exists('is_amp_endpoint') && is_amp_endpoint()){
			return true;
		}
		return false;
	}
}

if (!function_exists('essb_internal_cache_set')) {
	function essb_internal_cache_set($key, $value) {
		ESSBGlobalSettings::$internal_cache[$key] = $value;
	}
}

if (!function_exists('essb_internal_cache_get')) {
	function essb_internal_cache_get($key) {
		return isset(ESSBGlobalSettings::$internal_cache[$key]) ? ESSBGlobalSettings::$internal_cache[$key] : '';
	}
}

if (!function_exists('essb_internal_cache_remove')) {
	function essb_internal_cache_remove($key) {
		if (isset(ESSBGlobalSettings::$internal_cache[$key])) {
			unset(ESSBGlobalSettings::$internal_cache[$key]);
		}
	}
}

if (!function_exists('essb_internal_cache_flush')) {
	function essb_internal_cache_flush() {
		ESSBGlobalSettings::$internal_cache = array();
	}
}