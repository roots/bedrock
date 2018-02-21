<?php
/**
 * EasySocialShareButtons DisplayMethod: Mobile
 *
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2016 AppsCreo
 * @since 3.6
 *
 */

class ESSBDisplayMethodMobile {
	public static function generate_sharepoint_code($options, $share_buttons, $is_shortcode, $shortcode_options = array()) {
		$output = '';
		
		$output .= '<div class="essb-mobile-sharepoint" onclick="essb.mobile_sharebar_open();">';
		$output .= '<div class="essb-mobile-sharepoint-icon"></div>';
		$output .= '</div>';
		
		$output .= '<div class="essb-mobile-sharebar-window">';
		$output .= '<div class="essb-mobile-sharebar-window-close-title" onclick="essb.mobile_sharebar_close(); return false;">';
		$output .= '<a href="#" class="essb-mobile-sharebar-window-close" ></a>';
		$output .= '</div>';
		$output .= '<div class="essb-mobile-sharebar-window-content">';
		$output .= $share_buttons;
		$output .= '</div>';
		$output .= '</div>';
		$output .= '<div class="essb-mobile-sharebar-window-shadow"></div>';
		
		return $output;
	}
	
	public static function generate_sharebar_code($options, $share_buttons, $is_shortcode, $shortcode_options = array()) {
		$output = '';
	
		$mobile_sharebar_text = ESSBOptionValuesHelper::options_value($options, 'mobile_sharebar_text');
		if ($mobile_sharebar_text == "") {
			$mobile_sharebar_text = __("Share this", 'essb');
		}
			
		$output = "";
			
		$output .= '<div class="essb-mobile-sharebar" onclick="essb.mobile_sharebar_open();">';
		$output .= sprintf ('<div class="essb-mobile-sharebar-icon"></div><div class="essb-mobile-sharebar-text">%1$s</div>', $mobile_sharebar_text);
		$output .= '</div>';
			
		$output .= '<div class="essb-mobile-sharebar-window">';
		$output .= '<div class="essb-mobile-sharebar-window-close-title" onclick="essb.mobile_sharebar_close(); return false;">';
		$output .= '<a href="#" class="essb-mobile-sharebar-window-close" ></a>';
		$output .= '</div>';
		$output .= '<div class="essb-mobile-sharebar-window-content">';
		
		$output .= $share_buttons;
		
		$output .= '</div>';
		$output .= '</div>';
		$output .= '<div class="essb-mobile-sharebar-window-shadow"></div>';
		
		return $output;
	}
}