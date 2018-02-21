<?php
/**
 * JigoShop integration functions
 * 
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2016 AppsCreo
 * @since 4.2
 *
 */

if (!function_exists('essb_jigoshop_integration')) {
	function essb_jigoshop_integration() {
		global $essb_options;
		
		essb_depend_load_function('essb_check_applicability_module', 'lib/core/extenders/essb-core-extender-check-applicability-module.php');
		
		if (essb_check_applicability_module('jigoshop', $essb_options, essb_option_value('display_exclude_from'))) {
			printf('%1$s<div style="clear: both;"></div>', essb_core()->generate_share_buttons('jigoshop', 'share', array('only_share' => false, 'post_type' => 'jigoshop')));
		}
	}	
}

if (!function_exists('essb_jigoshop_activate')) {
	function essb_jigoshop_activate() {
		if (essb_option_bool_value('jigoshop_top')) {
			add_action ( 'jigoshop_before_single_product_summary', 'essb_jigoshop_integration' );
		}
		if (essb_option_bool_value('jigoshop_bottom')) {
			add_action ( 'jigoshop_after_main_content', 'essb_jigoshop_integration' );
		}
	}
}