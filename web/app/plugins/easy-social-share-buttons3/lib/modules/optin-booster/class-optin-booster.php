<?php

if (!defined('ESSB3_OFOB_PLUGIN_ROOT')) {
	define ( 'ESSB3_OFOB_PLUGIN_ROOT', ESSB3_PLUGIN_ROOT . 'lib/modules/optin-booster/' );
}

if (!defined('ESSB3_OFOB_PLUGIN_URL')) {
	define ( 'ESSB3_OFOB_PLUGIN_URL', ESSB3_PLUGIN_URL . '/lib/modules/optin-booster/' );
}

if (!defined('ESSB3_OFOB_PLUGIN_BASE_NAME')) {
	define ( 'ESSB3_OFOB_PLUGIN_BASE_NAME', plugin_basename ( __FILE__ ) );
}

if (!defined('ESSB3_OFOB_OPTIONS_NAME')) {
	define ( 'ESSB3_OFOB_OPTIONS_NAME', 'essb3-ofob' );
}

global $essb3ofob_options;

class ESSBOptinBooster {
	private static $_instance;
	private $version = "2.0";
	
	function __construct() {
		
		global $essb3ofob_options;
		
		$essb3ofob_options = get_option ( ESSB3_OFOB_OPTIONS_NAME );
				
		$demo_mode = isset($_REQUEST['optin_booster']) ? $_REQUEST['optin_booster'] : '';
		if ($demo_mode == 'true') {
			$essb3ofob_options['ofob_time'] = 'true';
			$essb3ofob_options['ofob_scroll'] = 'true';
			$essb3ofob_options['ofob_exit'] = 'true';
		}
		
		if ($this->option_bool_value('ofob_time') || $this->option_bool_value('ofob_scroll') || $this->option_bool_value('ofob_exit')) {
			add_action ( 'wp_footer', array(&$this, 'draw_forms'), 99);
			add_action('init', array(&$this, 'load_assets'), 99);
				
		}
		
	}
	
	function is_deactivated_on() {
		global $essb3ofof_options;
	
		if (is_admin ()) {
			return true;
		}
		
		if (is_search() || is_feed()) {
			return true;
		}
	
		$is_deactivated = false;
		$exclude_from = isset ( $essb3ofof_options ['ofob_exclude'] ) ? $essb3ofof_options ['ofob_exclude'] : '';
		if (! empty ( $exclude_from )) {
			$excule_from = explode ( ',', $exclude_from );
				
			$excule_from = array_map ( 'trim', $excule_from );
			if (in_array ( get_the_ID (), $excule_from, false )) {
				$is_deactivated = true;
			}
		}
		
		if ($this->option_bool_value('deactivate_homepage')) {
			if (is_home() || is_front_page()) {
				$is_deactivated = true;
			}
		}
		
		if (essb_option_bool_value('optin_booster_activate_posttypes')) {
			$posttypes = $this->option_value('posttypes');
			if (!is_array($posttypes)) {
				$posttypes = array();
			}
			
			if (!is_singular($posttypes)) {
				$is_deactivated = true;
			}
		}
		
		return $is_deactivated;
	}
	
	public function load_assets() {
		if (function_exists('essb_resource_builder')) {
			essb_resource_builder()->add_static_resource_footer(ESSB3_OFOB_PLUGIN_URL . '/assets/essb-optin-booster.js', 'essb-optin-booster', 'js');
		}
	}
	
	public function option_value($param) {
		global $essb3ofob_options;
		
		$value = isset($essb3ofob_options[$param]) ? $essb3ofob_options[$param] : '';
		
		return $value;
	}
	
	public function option_bool_value($param) {
		global $essb3ofob_options;
		
		$value = isset($essb3ofob_options[$param]) ? $essb3ofob_options[$param] : '';
		
		if ($value == 'true') {
			return true;
		}
		else {
			return false;
		}
	}
	
	/**
	 * Get static instance of class
	 *
	 * @return ESSB_Manager
	 */
	public static function getInstance() {
		if (! (self::$_instance instanceof self)) {
			self::$_instance = new self ();
		}
		
		return self::$_instance;
	}
	
	/**
	 * Cloning disabled
	 */
	private function __clone() {
	}
	
	/**
	 * Serialization disabled
	 */
	private function __sleep() {
	}
	
	/**
	 * De-serialization disabled
	 */
	private function __wakeup() {
	}
	
	
	public function draw_forms() {
		
		if (essb_is_plugin_deactivated_on()) {
			return;
		}
		
		if ($this->is_deactivated_on()) {
			return;
		}
		
		$ofob_single = $this->option_bool_value('ofob_single');
		$ofob_creditlink = $this->option_bool_value('ofob_creditlink');
		
		if ($this->option_bool_value('ofob_time')) {
			$ofob_time_delay = $this->option_value('ofob_time_delay');
			$of_time_design = $this->option_value('of_time_design');
			$of_time_bgcolor = $this->option_value('of_time_bgcolor');
			
			if ($ofob_time_delay != '') {
				$callback = ' data-delay="'.$ofob_time_delay.'" data-single="'.$ofob_single.'"';
				$this->draw_form_code('time', $of_time_design, $of_time_bgcolor, $callback, $ofob_creditlink);
			}
		}
		
		if ($this->option_bool_value('ofob_scroll')) {
			$ofob_scroll_percent = $this->option_value('ofob_scroll_percent');
			$of_scroll_design = $this->option_value('of_scroll_design');
			$of_scroll_bgcolor = $this->option_value('of_scroll_bgcolor');
				
			if ($ofob_scroll_percent != '') {
				$callback = ' data-scroll="'.$ofob_scroll_percent.'" data-single="'.$ofob_single.'"';
				$this->draw_form_code('scroll', $of_scroll_design, $of_scroll_bgcolor, $callback, $ofob_creditlink);
			}
		}
		
		if ($this->option_bool_value('ofob_exit')) {			
			$of_exit_design = $this->option_value('of_exit_design');
			$of_exit_bgcolor = $this->option_value('of_exit_bgcolor');				
			$callback = ' data-exit="1" data-single="'.$ofob_single.'"';
			$this->draw_form_code('exit', $of_exit_design, $of_exit_bgcolor, $callback, $ofob_creditlink);
				
		}
	}
	
	public function draw_form_code($event = '', $design = '', $overlay_color = '', $event_fire = '', $credit_link = false) {
		$output = '';
		
		$affiliate_user = $this->option_value('ofob_creditlink_user');
		if ($affiliate_user == '') {
			$affiliate_user = 'appscreo';
		}
		
		$close_type = $this->option_value('of_'.$event.'_close');
		$close_color = $this->option_value('of_'.$event.'_closecolor');
		$close_text = $this->option_value('of_'.$event.'_closetext');
		
		$css_color = '';
		if ($close_color != '') {
			$css_color = ' style="color:'.$close_color.'!important;"';
		}
		
		if ($close_type == '') {
			$close_type = 'icon';
		}
		
		if ($close_text == '') {
			$close_text = __("No thanks. I don't want.");
		}
		
		$output .= '<div class="essb-optinbooster essb-optinbooster-'.$event.'" '.$event_fire.'>';
		
		if ($close_type == 'icon') {
			$output .= '<div class="essb-optinbooster-close essb-optinbooster-closeicon" '.$css_color.'><i class="essb_icon_close"></i></div>';
		}
		
		$output .= do_shortcode('[easy-subscribe design="'.$design.'" mode="mailchimp" conversion="booster-'.$event.'"]');
		if ($close_type != 'icon') {
			$output .= '<div class="essb-optinbooster-close essb-optinbooster-closetext" '.$css_color.'>'.$close_text.'</div>';
		}
		
		$output .= '</div>';
		$output .= '<div class="essb-optinbooster-overlay essb-optinbooster-overlay-'.$event.'"'.($overlay_color != '' ? ' style="background-color:'.$overlay_color.'!important;"' : '').'>';
		if ($credit_link) {
			$output .= '<div class="promo">Powered by <a href="http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476?ref='.$affiliate_user.'" target="_blank">Best Social Sharing Plugin for WordPress</a> Easy Social Share Buttons</div>';
		}
		
		$output .= '</div>';
		
		echo $output;
	}
}

/**
 * main code *
 */
global $essb_ofob;
function essb_optin_booster() {
	global $essb_ofob;
	
	if (! isset ( $essb_ofob )) {
		$essb_ofob = ESSBOptinBooster::getInstance ();
	}
}

add_action ( 'init', 'essb_optin_booster', 9 );