<?php
/**
 * WP e-Commerce integration functions
 * 
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2016 AppsCreo
 * @since 4.2
 *
 */

if (!function_exists('essb_wpecommerce_integration')) {
	function essb_wpecommerce_integration() {
		global $essb_options;
		
		essb_depend_load_function('essb_check_applicability_module', 'lib/core/extenders/essb-core-extender-check-applicability-module.php');
		
		if (essb_check_applicability_module('wpecommerce', $essb_options, essb_option_value('display_exclude_from'))) {
			printf('%1$s<div style="clear: both;"></div>', essb_core()->generate_share_buttons('wpecommerce', 'share', array('only_share' => false, 'post_type' => 'wpecommerce')));
		}
	}	
}

if (!function_exists('essb_wpecommerce_activate')) {
	function essb_wpecommerce_activate() {
		if (essb_option_bool_value('wpec_before_desc')) {
			add_action ( 'wpsc_product_before_description', 'essb_wpecommerce_integration' );
		}
		if (essb_option_bool_value('wpec_after_desc')) {
			add_action ( 'wpsc_product_addons', 'essb_wpecommerce_integration' );
		}
		if (essb_option_bool_value('wpec_theme_footer')) {
			add_action ( 'wpsc_theme_footer', 'essb_wpecommerce_integration' );
		}
	}
}