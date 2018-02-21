<?php

/**
 * ESSB Social Skinned Native Buttons Class
 *
 * @package EasySocialShareButtons
 * @since 3.0
 * @author appscreo
 * @version 2.0
 *
 */

class ESSBSkinnedNativeButtons {
	
	private static $extension_version = "2.0";

	public static $text_replace = array();
	public static $resouce_files = array();
	
	public static function generate_skinned_custom_css () {
		global $essb_options;
		$network_list = essb_default_native_buttons();
		
		$options = $essb_options;
		$css = "";
		
		foreach ($network_list as $net) {
			$color = isset($options['skinned_'.$net.'_color']) ? $options['skinned_'.$net.'_color'] : '';
			$hovercolor = isset($options['skinned_'.$net.'_hovercolor']) ? $options['skinned_'.$net.'_hovercolor'] : '';
			$textcolor = isset($options['skinned_'.$net.'_textcolor']) ? $options['skinned_'.$net.'_textcolor'] : '';
			$width = isset($options['skinned_'.$net.'_width']) ? $options['skinned_'.$net.'_width'] : '';
			
			$selector = $net;
			if ($net == "fb") { $selector = "facebook"; }

			if ($color != '') {
				$css .= '.essb-native-'.$selector.' .essb-native-text { background-color: '.$color.'!important;}';
			}
			if ($hovercolor != '') {
				$css .= '.essb-native-'.$selector.' { background-color: '.$hovercolor.'!important;}';
			}
			if ($textcolor != '') {
				$css .= '.essb-native-'.$selector.' .essb-native-text { color: '.$textcolor.'!important;}';
			}
			if ($width != '') {
				$css .= '.essb-native-'.$selector.' { width: '.$width.'px!important;}';
			}
			
			$text = isset($options['skinned_'.$net.'_text']) ? $options['skinned_'.$net.'_text'] : '';
			
			if ($text != '') {
				self::$text_replace[$selector] = $text;
			}
		}
		
		return $css;
	}
	
	public static function generate_skinned_button($type, $code, $text = '', $force_text = '', $width = '', $user_skin) {
		
		$text_replace = isset(self::$text_replace[$type]) ? self::$text_replace[$type] : '';
		
		if ($text_replace != '') { $text = $text_replace; }
		
		if ($force_text != '') { $text = $force_text; }
		
		if ($user_skin != '') { $user_skin = ' '.$user_skin; }
		
		$output = "";
		
		$css_width = "";
		if ($width != '') { $css_width = ' style="width:'.$width.'px!important;"'; }
		
		$output = '<div class="essb-native-skinned-button'.$user_skin.'">';
		$output .= '<div class="essb-native-outsite'.$user_skin.' essb-native-' . $type . '"'.$css_width.'>';
		
		$output_text = "";
		
		if ($text != '') {
			$output_text = '<span class="essb-native-text-inner">' . $text . '</span>';
		}
		
		$output .= '<div class="essb-native-text'.$user_skin.'"><span class="' . self::get_icon( $type ) . '"></span>' . $output_text . '</div>';
		$output .= '<div class="essb-native-click">' . $code . '</div>';
		
		$output .= '</div>';
		$output .= '</div>';
		
		return $output;
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
	
	public static function get_assets() {
		global $essb_options;
		
		$deactivate_fa = ESSBOptionValuesHelper::options_bool_value($essb_options, 'deactivate_fa');
		
		self::$resouce_files[] = array("key" => "easy-social-share-buttons-nativeskinned", "file" => ESSB3_PLUGIN_URL . '/assets/css/essb-native-skinned.min.css', "type" => "css");
		//if (!$deactivate_fa) {
		//	self::$resouce_files[] = array("key" => "essb-fontawsome", "file" => ESSB3_PLUGIN_URL . '/assets/css/font-awesome.min.css', "type" => "css");
		//}

		return self::$resouce_files;
	}

}

?>