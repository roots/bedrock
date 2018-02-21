<?php

/**
 * ESSB Social Privacy Native Buttons Class
 * 
 * @package EasySocialShareButtons
 * @since 3.0 
 * @author appscreo
 * @version 2.0
 * 
 */

class ESSBSocialPrivacyNativeButtons {
	
	public static $version = "2.0";
	
	private static $instance = null;
	
	protected $options;
	
	protected $active = false;
	
	protected $state_facebook = false;
	protected $state_google = false;
	protected $state_twitter = false;
	protected $state_pinterest = false;
	protected $state_linkedin = false;
	protected $state_vk = false;
	
	public $resource_files = array();
	
	function __construct() {
		global $essb_options;

		$this->options = $essb_options;		
		$this->active = ESSBOptionValuesHelper::options_bool_value($this->options, 'native_privacy_active');
		
		if (ESSB3_DEMO_MODE) {
			$is_active_option = isset($_REQUEST['nativemode']) ? $_REQUEST['nativemode'] : '';
			if ($is_active_option == 'privacy') {
				$this->active = true;
			}
		}
		
		if ($this->active) {
			$this->get_state();
			$this->register_css();	
			if (!defined('ESSB3_SOCIAL_PRIVACY_ACTIVE')) {	
				define('ESSB3_SOCIAL_PRIVACY_ACTIVE', true);	
			}	
		}
	}
		
	public static function get_instance() {
	
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	
	} // end get_instance;
	
	public function get_state() {
		$this->state_facebook = isset($_COOKIE['essb_socialprivacy_facebook']) ? true : false;
		$this->state_google = isset($_COOKIE['essb_socialprivacy_google']) ? true : false;
		$this->state_twitter = isset($_COOKIE['essb_socialprivacy_twitter']) ? true : false;
		$this->state_pinterest = isset($_COOKIE['essb_socialprivacy_pinterest']) ? true : false;
		$this->state_linkedin = isset($_COOKIE['essb_socialprivacy_linkedin']) ? true : false;
		$this->state_vk = isset($_COOKIE['essb_socialprivacy_vk']) ? true : false;
		
	}
	
	public function is_active($network) {
		return $this->is_activated($network);
	}
	
	public function is_activated($network) {
		// if module is not active return always true
		if (!$this->active) { return true; }
		
		$result = false;
		
		switch ($network) {
			case "facebook":
				$result = $this->state_facebook;
				break;
			case "google":
				$result = $this->state_google;
				break;
			case "twitter":
				$result = $this->state_twitter;
				break;
			case "pinterest":
				$result = $this->state_pinterest;
				break;
			case "linkedin":
				$result = $this->state_linkedin;
				break;
			case "vk":
				$result = $this->state_vk;
				break;			
		}
		
		return $result;
	}
	
	public static function get_icon($type) {
		$icon = "";
		
		switch ($type) {
			case "google" :
				$icon = "essb_icon_google";
				break;
			
			case "facebook" :
				$icon = "essb_icon_facebook";
				break;
			
			case "twitter" :
				$icon = "essb_icon_twitter";
				break;
			
			case "pinterest" :
				$icon = "essb_icon_pinterest";
				break;
			
			case "youtube" :
				$icon = "essb_icon_youtube";
				break;
			case "vk" :
				$icon = "essb_icon_vk";
				break;		
			case "linkedin" :
				$icon = "essb_icon_linkedin";
				break;		
		}
		
		return $icon;
	}
	
	public function generate_button($type, $text = '', $width = '', $user_skin = 'metro') {
		$output = "";
		if ($user_skin != '') {
			$user_skin = ' '.$user_skin;
		}
		$check_type = $type;
		if ($text == '') {
			$options_text = isset($this->options['skinned_'.$check_type.'_privacy_text']) ? $this->options['skinned_'.$check_type.'_privacy_text'] : '';
			if ($options_text != '') { $text = $options_text;}
		}
		if ($width == '') {
			$options_text = isset($this->options['skinned_'.$check_type.'_privacy_width']) ? $this->options['skinned_'.$check_type.'_privacy_width'] : '';
			if ($options_text != '') {
				$width = $options_text;
			}
		}
		
		$css_width = "";
		if ($width != '') {
			$css_width = ' style="width:'.$width.'px!important;"';
		}
		
		$output = '<div class="essb-privacy-button'.$user_skin.'" data-button-type="'.$type.'">';
		$output .= '<div class="essb-privacy-outsite'.$user_skin.' essb-privacy-' . $type . '"'.$css_width.'>';
		
		$output_text = "";
		
		if ($text != '') {
			$output_text = '<span class="essb-privacy-text-inner">' . $text . '</span>';
		}
		
		$output .= '<div class="essb-privacy-text'.$user_skin.'"><span class="essb-privacy-icon ' . $this->get_icon($type) . '"></span>' . $output_text . '</div>';
		
		$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
	
	public function register_css() {
		$this->resource_files[] = array("key" => "essb-native-privacy", "file" => ESSB3_PLUGIN_URL . '/assets/css/essb-native-privacy.css', "type" => "css");
		$this->resource_files[] = array("key" => "essb-socialprivacy-script", "file" => ESSB3_PLUGIN_URL . '/assets/js/essb-social-privacy.min.js', "type" => "js");
	}
}

?>