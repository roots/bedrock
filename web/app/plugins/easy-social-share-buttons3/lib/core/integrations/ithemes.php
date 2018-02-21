<?php
/**
 * iThemes integration functions
 * 
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2016 AppsCreo
 * @since 4.2
 *
 */

if (!function_exists('essb_ithemes_integration')) {
	function essb_ithemes_integration() {
		global $essb_options;
		
		essb_depend_load_function('essb_check_applicability_module', 'lib/core/extenders/essb-core-extender-check-applicability-module.php');
		
		if (essb_check_applicability_module('ithemes', $essb_options, essb_option_value('display_exclude_from'))) {
			printf('%1$s<div style="clear: both;"></div>', essb_core()->generate_share_buttons('ithemes', 'share', array('only_share' => false, 'post_type' => 'ithemes')));
		}
	}	
}

if (!function_exists('essb_ithemes_integration_purchase')) {
	function essb_ithemes_integration_purchase() {
		global $essb_options;

		essb_depend_load_function('essb_check_applicability_module', 'lib/core/extenders/essb-core-extender-check-applicability-module.php');

		if (essb_check_applicability_module('ithemes', $essb_options, essb_option_value('display_exclude_from'))) {
			$activity_link = it_exchange( 'transaction', 'product-attribute', array( 'attribute' => 'product_id', 'return' => true ) );
			$activity_title =  it_exchange( 'transaction', 'product-attribute', array( 'attribute' => 'title', 'return' => true ) );
			$activity_link = get_permalink($activity_link);
				
			printf('%1$s<div style="clear: both;"></div>', essb_core()->generate_share_buttons('ithemes', 'share', array('only_share' => false, 'post_type' => 'ithemes', 'url' => $activity_link, 'title' => $activity_title)));
			
		}
	}
}

if (!function_exists('essb_ithemes_activate')) {
	function essb_ithemes_activate() {
		if (essb_option_bool_value('ithemes_after_title')) {
			add_action ( 'it_exchange_content_product_before_wrap', 'essb_ithemes_integration' );
		}
		if (essb_option_bool_value('ithemes_before_desc')) {
			add_action ( 'it_exchange_content_product_before_description_element', 'essb_ithemes_integration' );
		}

		if (essb_option_bool_value('ithemes_after_desc')) {
			add_action ( 'it_exchange_content_product_after_description_element', 'essb_ithemes_integration' );
		}
		if (essb_option_bool_value('ithemes_after_product')) {
			add_action ( 'it_exchange_content_product_end_wrap', 'essb_ithemes_integration' );
		}
		if (essb_option_bool_value('ithemes_after_purchase')) {
			add_action ( 'it_exchange_content_confirmation_after_product_title', 'essb_ithemes_integration_purchase' );
		}
		
	}
}