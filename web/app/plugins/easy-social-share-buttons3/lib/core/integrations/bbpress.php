<?php
/**
 * bbPress integration functions
 * 
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2016 AppsCreo
 * @since 4.2
 *
 */

if (!function_exists('essb_bbpress_integration')) {
	function essb_bbpress_integration() {
		global $essb_options;
		
		essb_depend_load_function('essb_check_applicability_module', 'lib/core/extenders/essb-core-extender-check-applicability-module.php');
		
		if (essb_check_applicability_module('bbpress', $essb_options, essb_option_value('display_exclude_from'))) {
			printf('%1$s<div style="clear: both;"></div>', essb_core()->generate_share_buttons('bbpress', 'share', array('only_share' => false, 'post_type' => 'bbpress')));
		}
	}	
}

if (!function_exists('essb_bbpress_activate')) {
	function essb_bbpress_activate() {
		if (essb_option_bool_value('bbpress_forum')) {
			add_action ( 'bbp_template_before_topics_loop', 'essb_bbpress_integration' );
		}
		if (essb_option_bool_value('bbpress_topic')) {
			add_action ( 'bbp_template_before_replies_loop', 'essb_bbpress_integration' );
		}
	}
}