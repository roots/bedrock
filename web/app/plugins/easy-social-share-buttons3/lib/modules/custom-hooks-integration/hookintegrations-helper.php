<?php
/**
 * Parse and generate custom hooks integration registered by plugin
 * 
 * @since 5.0
 * @package EasySocialShareButtons
 * @author appscreo
 * 
 */

if (!function_exists('essb_hook_integration_draw')) {
	
	/**
	 * Generate and draw custom position share buttons inside plugin
	 * 
	 * @param string $position
	 */
	
	function essb_hook_integration_draw($position = '') {
		echo essb_hook_integration_generate($position);
	}
}

if (!function_exists('essb_hook_integration_generate')) {
	
	/**
	 * Generate the custom share buttons based on the provided custom key for position
	 * 
	 * @param string $position
	 * @return string
	 */
	function essb_hook_integration_generate($position = '') {
		$r = '';
		if (function_exists('essb_core')) {
			$general_options = essb_core()->get_general_options();
				
			if (is_array($general_options)) {
				if (in_array($position, $general_options['button_position'])) {
					$r = essb_core()->generate_share_buttons($position);
				}
			}
		}
		
		return $r;
	}
}

if (!function_exists('essb_hook_draw_share_buttons')) {
	
	/**
	 * Generate share buttons code without checking if position is activated from settings
	 * 
	 * @param string $position
	 * @return string
	 */
	
	function essb_hook_draw_share_buttons($position = '') {
		$r = '';

		if (function_exists('essb_core')) {
			$r = essb_core()->generate_share_buttons($position);
		}
		
		return $r;
	}
}

