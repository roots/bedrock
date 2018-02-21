<?php

/**
 * Subsctibe Button Class
 *
 * @since 3.6
 *
 * @package EasySocialShareButtons
 * @author  appscreo <http://codecanyon.net/user/appscreo/portfolio>
 */

class ESSBNetworks_Subscribe {
	private static $version = "1.0";	
	public static $assets_registered = false;
	
	
	public static function register_assets() { 
		if (!self::$assets_registered) {
			//essb_resource_builder()->add_static_resource_footer(ESSB3_PLUGIN_URL .'/assets/js/essb-subscribe'.(ESSBGlobalSettings::$use_minified_js ? ".min": "").'.js', 'easy-social-share-buttons-subscribe', 'js');
			essb_resource_builder()->add_static_resource_footer(ESSB3_PLUGIN_URL .'/assets/css/essb-subscribe'.(ESSBGlobalSettings::$use_minified_css ? ".min": "").'.css', 'easy-social-share-buttons-subscribe', 'css');
			self::$assets_registered = true;
		}
	}
	
	public static function draw_subscribe_form($position, $salt, $subscribe_position = '') {
		$output = '';
		$popup_mode = ($position != 'top' && $position != 'bottom' && $position != 'shortcode') ? true : false;
		
		$output .= '<div class="essb-subscribe-form essb-subscribe-form-'.$salt.($popup_mode ? " essb-subscribe-form-popup": " essb-subscribe-form-inline").'" data-popup="'.$popup_mode.'" style="display: none;">';
				
		if (ESSBGlobalSettings::$subscribe_function == "form") {
			$output .= do_shortcode(ESSBGlobalSettings::$subscribe_content);
		}
		else {
			$output .= self::draw_integrated_subscribe_form($salt, $popup_mode, '', false, $subscribe_position);
		}
		
		if ($popup_mode) {
			$output .= '<button type="button" class="essb-subscribe-form-close" onclick="essb.subscribe_popup_close(\''.$salt.'\');">x</button>';
		}
		
		$output .= '</div>';
		
		if ($popup_mode) {
			$output .= '<div class="essb-subscribe-form-overlay essb-subscribe-form-overlay-'.$salt.'" onclick="essb.subscribe_popup_close(\''.$salt.'\');"></div>';
		}
		
		if (!self::$assets_registered) {
			self::register_assets();
		}
		
		return $output;
	}
	
	public static function draw_inline_subscribe_form($mode = '', $design = '', $is_widget = false, $position = '') {
		if (empty($mode)) $mode = ESSBGlobalSettings::$subscribe_function;
		$salt = mt_rand();
		
		$output = '<div class="essb-subscribe-form essb-subscribe-form-'.$salt.' essb-subscribe-form-inline">';
				
		if ($mode == "form") {
			$output .= do_shortcode(ESSBGlobalSettings::$subscribe_content);
		}
		else {
			$output .= self::draw_integrated_subscribe_form($salt, false, $design, $is_widget, $position);
		}
		
		$output .= '</div>';
		
		if (!self::$assets_registered) {
			self::register_assets();
		}
		
		return $output;
	}
	
	
	public static function draw_aftershare_popup_subscribe_form($design = '', $position = '') {
		$mode = "mailchimp";
	
		$salt = mt_rand();
	
		$output = '<script type="text/javascript">var after_share_easyoptin = "'.$salt.'";</script>';
		$output .= '<div class="essb-subscribe-form essb-subscribe-form-'.$salt.' essb-subscribe-form-popup" style="display:none;" '.($two_step_inline == 'true' ? 'data-popup="0"' : 'data-popup="1"').'>';
	
		if ($mode == "form") {
			$output .= do_shortcode(ESSBGlobalSettings::$subscribe_content);
		}
		else {
			$output .= self::draw_integrated_subscribe_form($salt, false, $design, false, $position);
		}
	
		$output .= '<button type="button" class="essb-subscribe-form-close" onclick="essb.subscribe_popup_close(\''.$salt.'\');">x</button>';
		$output .= '</div>';
		$output .= '<div class="essb-subscribe-form-overlay essb-subscribe-form-overlay-'.$salt.'" onclick="essb.subscribe_popup_close(\''.$salt.'\');"></div>';
	
		if (!self::$assets_registered) {
			self::register_assets();
		}
	
		return $output;
	}
	
	/**
	 * Draw two step subscribe from
	 * ---
	 * draw_inline_subscribe_form_twostep
	 * 
	 * @param string $mode
	 * @param string $design
	 * @param string $open_link_content
	 * @param boolean $is_widget
	 * @return string
	 * @since 3.7
	 */
	public static function draw_inline_subscribe_form_twostep($mode = '', $design = '', $open_link_content = '', $two_step_inline = '', $is_widget = false) {
		
		// if we have not link content to act like regular inline subscribe form
		if ($open_link_content == '') {
			return ESSBNetworks_Subscribe::draw_inline_subscribe_form($mode, $design);
		}
		
		if (empty($mode)) $mode = ESSBGlobalSettings::$subscribe_function;
		$salt = mt_rand();
	
		$output = '<a href="#" onclick="essb.toggle_subscribe(\''.$salt.'\'); return false;" data-twostep-subscribe="true" data-salt="'.$salt.'" class="essb-twostep-subscribe">'.$open_link_content.'</a>';
		$output .= '<div class="essb-subscribe-form essb-subscribe-form-'.$salt.' essb-subscribe-form-popup" style="display:none;" '.($two_step_inline == 'true' ? 'data-popup="0"' : 'data-popup="1"').'>';
	
		if ($mode == "form") {
			$output .= do_shortcode(ESSBGlobalSettings::$subscribe_content);
		}
		else {
			$output .= self::draw_integrated_subscribe_form($salt, false, $design, $is_widget, 'twostep');
		}
	
		$output .= '<button type="button" class="essb-subscribe-form-close" onclick="essb.subscribe_popup_close(\''.$salt.'\');">x</button>';
		$output .= '</div>';
		$output .= '<div class="essb-subscribe-form-overlay essb-subscribe-form-overlay-'.$salt.'" onclick="essb.subscribe_popup_close(\''.$salt.'\');"></div>';

		if (!self::$assets_registered) {
			self::register_assets();
		}
	
		return $output;
	}
	
	public static function draw_integrated_subscribe_form($salt, $popup_mode = false, $option_design = '', $is_widget = false, $position = '') {
		global $essb_options;
		
		
		$design_inline = ESSBOptionValuesHelper::options_value($essb_options, 'subscribe_optin_design', 'design1');
		$design_popup = ESSBOptionValuesHelper::options_value($essb_options, 'subscribe_optin_design_popup', 'design1');
		
		$user_design = $popup_mode ? $design_popup : $design_inline;
		
		if ($option_design != '') {
			$user_design = $option_design;
		}
				
		
		if ($user_design == '') { $user_design = 'design1'; }
		
		if ($user_design == 'design1') {
			return self::draw_mailchimp_subscribe($salt, $is_widget, $position);
		}
		else if ($user_design == 'design2') {
			return self::draw_mailchimp_subscribe2($salt, $is_widget, $position);
		}
		else if ($user_design == 'design3') {
			return self::draw_mailchimp_subscribe3($salt, $is_widget, $position);
		}
		else if ($user_design == 'design4') {
			return self::draw_mailchimp_subscribe4($salt, $is_widget, $position);
		}
		else if ($user_design == 'design5') {
			return self::draw_mailchimp_subscribe5($salt, $is_widget, $position);
		}
		else if ($user_design == 'design6') {
			return self::draw_mailchimp_subscribe6($salt, $is_widget, $position);
		}
		else if ($user_design == 'design7') {
			return self::draw_mailchimp_subscribe7($salt, $is_widget, $position);
		}
		else if ($user_design == 'design8') {
			return self::draw_mailchimp_subscribe8($salt, $is_widget, $position);
		}
		else if ($user_design == 'design9') {
			return self::draw_mailchimp_subscribe9($salt, $is_widget, $position);
		}
		else {
			return self::draw_mailchimp_subscribe($salt, $is_widget, $position);
		}
	}
	
	public static function draw_mailchimp_subscribe($salt, $is_widget = false, $position = '') {

		if (!function_exists('essb_subscribe_form_design1')) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/networks/essb-subscribe-design1.php');
		}
		
		return essb_subscribe_form_design1($salt, $is_widget, $position);
	}
	
	public static function draw_mailchimp_subscribe2($salt, $is_widget = false, $position = '') {
		
		if (!function_exists('essb_subscribe_form_design2')) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/networks/essb-subscribe-design2.php');
		}
		
		return essb_subscribe_form_design2($salt, $is_widget, $position);
	}

	public static function draw_mailchimp_subscribe3($salt, $is_widget = false, $position = '') {
		if (!function_exists('essb_subscribe_form_design3')) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/networks/essb-subscribe-design3.php');
		}
		
		return essb_subscribe_form_design3($salt, $is_widget, $position);
	}
	
	
	public static function draw_mailchimp_subscribe4($salt, $is_widget = false, $position = '') {
		if (!function_exists('essb_subscribe_form_design4')) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/networks/essb-subscribe-design4.php');
		}
		
		return essb_subscribe_form_design4($salt, $is_widget, $position);
	}

	public static function draw_mailchimp_subscribe5($salt, $is_widget = false, $position = '') {
		if (!function_exists('essb_subscribe_form_design5')) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/networks/essb-subscribe-design5.php');
		}
		
		return essb_subscribe_form_design5($salt, $is_widget, $position);
	}
	
	public static function draw_mailchimp_subscribe6($salt, $is_widget = false, $position = '') {
		if (!function_exists('essb_subscribe_form_design6')) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/networks/essb-subscribe-design6.php');
		}
	
		return essb_subscribe_form_design6($salt, $is_widget, $position);
	}

	public static function draw_mailchimp_subscribe7($salt, $is_widget = false, $position = '') {
		if (!function_exists('essb_subscribe_form_design7')) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/networks/essb-subscribe-design7.php');
		}
	
		return essb_subscribe_form_design7($salt, $is_widget, $position);
	}

	public static function draw_mailchimp_subscribe8($salt, $is_widget = false, $position = '') {
		if (!function_exists('essb_subscribe_form_design8')) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/networks/essb-subscribe-design8.php');
		}
	
		return essb_subscribe_form_design8($salt, $is_widget, $position);
	}
	
	public static function draw_mailchimp_subscribe9($salt, $is_widget = false, $position = '') {
		if (!function_exists('essb_subscribe_form_design9')) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/networks/essb-subscribe-design9.php');
		}
	
		return essb_subscribe_form_design9($salt, $is_widget, $position);
	}	
}