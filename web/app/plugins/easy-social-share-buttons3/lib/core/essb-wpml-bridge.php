<?php

/**
 * ESSBWpmlBridge
 * 
 * Provide sameless integration with WPML to translate build in plugin settings
 *
 * @author appscreo
 * @since 4.1
 * @package EasySocialShareButtons
 *
 */
class ESSBWpmlBridge {
	public static function isWpmlActive() {
		if (class_exists ( 'SitePress' ))
			return (true);
		else
			return (false);
	}
	
	public static function getLanguages() {
		global $sitepress;
		
		$response = array ();
		
		if (class_exists ( 'SitePress' )) {
			//$wpml = new SitePress ();
			$arrLangs = $sitepress->get_active_languages ();
			
			foreach ( $arrLangs as $code => $arrLang ) {
				$name = $arrLang ['native_name'];
				$response [$code] = $name;
			}
		}
		
		if (function_exists('pll_languages_list')) {
			$languages = pll_languages_list();
			foreach ($languages as $lang) {
				$response[$lang] = $lang;
 			}
 		}
		return ($response);
	}
	
	public static function getLanguagesSimplified() {
		global $sitepress;
		$response = array ();
		
		if (class_exists ( 'SitePress' )) {
			//$wpml = new SitePress ();
			$arrLangs = $sitepress->get_active_languages ();
				
			foreach ( $arrLangs as $code => $arrLang ) {
				$name = $arrLang ['native_name'];
				$response [] = '['.$code .'] '. $name;
			}
		}
		
		if (function_exists('pll_languages_list')) {
			$response = pll_languages_list();
		}
		
		return ($response);
		
	}
	
	private function getLangDetails($code) {
		global $wpdb;
		
		$details = $wpdb->get_row ( "SELECT * FROM " . $wpdb->prefix . "icl_languages WHERE code='$code'" );
		
		if (! empty ( $details ))
			$details = ( array ) $details;
		
		return ($details);
	}
	
	/**
	 * get language title by code
	 */
	public static function getLangTitle($code) {
		
		$langs = self::getLanguages ();
		
		if ($code == 'all')
			return (__ ( 'All Languages', 'essb' ));
		
		if (array_key_exists ( $code, $langs ))
			return ($langs [$code]);
		
		$details = self::getLangDetails ( $code );
		if (! empty ( $details ))
			return ($details ['english_name']);
		
		return ('');
	
	}
	
	/**
	 * get current language
	 */
	public static function getCurrentLang() {
		global $sitepress;
		$lang = '';
		
		if (class_exists('SitePress')) {
			//$wpml = new SitePress ();
			if (is_admin ())
				$lang = $sitepress->get_default_language ();
			else
				$lang = ICL_LANGUAGE_CODE;
		}
		
		return ($lang);
	}
	
	public static function getFrontEndLanugage() {
		if (class_exists('SitePress')) {
			return ICL_LANGUAGE_CODE;
		}
		if (function_exists('pll_current_language')) {
			return pll_current_language();
		}
	}
}


if (!function_exists('essb_wpml_option_value')) {
	function essb_wpml_option_value($param, $code = '') {
		global $essb_translate_options;
				
		if ($code == '')
			$code = ESSBWpmlBridge::getCurrentLang();

		$param .= '_'.$code;
		
		return isset($essb_translate_options[$param]) ? $essb_translate_options[$param] : '';
		
	}
}

if (!function_exists('essb_wpml_translatable_fields')) {
	function essb_wpml_translatable_fields() {
		$result = array();
		
		$result['menu3'] = array('type' => 'menu', 'title' => __('Social Networks', 'essb'));
		$result['networks'] = array('type' => 'networks', 'group' => 'menu3');
		
		$result['menu2'] = array('type' => 'menu', 'title' => __('E-mail Message', 'essb'));
		$result['heading1'] = array('type' => 'heading', 'group' => 'menu2', 'title' => __('Email message customization'));
		$result['mail_captcha'] = array('type' => 'field', 'group' => 'menu2', 'tab_id' => 'social', 'menu_id' => 'share-1');
		$result['mail_captcha_answer'] = array('type' => 'field', 'group' => 'menu2', 'tab_id' => 'social', 'menu_id' => 'share-1');
		$result['mail_subject'] = array('type' => 'field', 'group' => 'menu2', 'tab_id' => 'social', 'menu_id' => 'share-1');
		$result['mail_body'] = array('type' => 'field', 'group' => 'menu2', 'tab_id' => 'social', 'menu_id' => 'share-1');		
		
		$result['menu0'] = array('type' => 'menu', 'title' => __('Counter texts', 'essb'));
		$result['counter_total_text'] = array('type' => 'field', 'group' => 'menu0', 'tab_id' => 'social', 'menu_id' => 'sharecnt');
		$result['activate_total_counter_text'] = array('type' => 'field', 'group' => 'menu0', 'tab_id' => 'social', 'menu_id' => 'sharecnt');
		$result['total_counter_afterbefore_text'] = array('type' => 'field', 'group' => 'menu0', 'tab_id' => 'social', 'menu_id' => 'sharecnt');
		
		$result['menu1'] = array('type' => 'menu', 'title' => __('Message with Buttons', 'essb'));
		$result['message_share_before_buttons'] = array('type' => 'field', 'group' => 'menu1', 'tab_id' => 'social', 'menu_id' => 'message');
		$result['message_above_share_buttons'] = array('type' => 'field', 'group' => 'menu1', 'tab_id' => 'social', 'menu_id' => 'message');

		$result['menu4'] = array('type' => 'menu', 'title' => __('Localization texts', 'essb'));
		$result['heading2'] = array('type' => 'heading', 'group' => 'menu4', 'title' => __('Email form customization'));
		$result['translate_mail_title'] = array('type' => 'field', 'group' => 'menu4', 'tab_id' => 'advanced', 'menu_id' => 'localization');
		$result['translate_mail_email'] = array('type' => 'field', 'group' => 'menu4', 'tab_id' => 'advanced', 'menu_id' => 'localization');
		$result['translate_mail_recipient'] = array('type' => 'field', 'group' => 'menu4', 'tab_id' => 'advanced', 'menu_id' => 'localization');
		$result['translate_mail_custom'] = array('type' => 'field', 'group' => 'menu4', 'tab_id' => 'advanced', 'menu_id' => 'localization');
		$result['translate_mail_cancel'] = array('type' => 'field', 'group' => 'menu4', 'tab_id' => 'advanced', 'menu_id' => 'localization');
		$result['translate_mail_send'] = array('type' => 'field', 'group' => 'menu4', 'tab_id' => 'advanced', 'menu_id' => 'localization');
		$result['translate_mail_message_sent'] = array('type' => 'field', 'group' => 'menu4', 'tab_id' => 'advanced', 'menu_id' => 'localization');
		$result['translate_mail_message_invalid_captcha'] = array('type' => 'field', 'group' => 'menu4', 'tab_id' => 'advanced', 'menu_id' => 'localization');
		$result['translate_mail_message_error_send'] = array('type' => 'field', 'group' => 'menu4', 'tab_id' => 'advanced', 'menu_id' => 'localization');

		$result['heading3'] = array('type' => 'heading', 'group' => 'menu4', 'title' => __('Love this texts'));
		$result['translate_love_thanks'] = array('type' => 'field', 'group' => 'menu4', 'tab_id' => 'advanced', 'menu_id' => 'localization');
		$result['translate_love_loved'] = array('type' => 'field', 'group' => 'menu4', 'tab_id' => 'advanced', 'menu_id' => 'localization');

		$result['heading4'] = array('type' => 'heading', 'group' => 'menu4', 'title' => __('Translate Click To Tweet text'));
		$result['translate_clicktotweet'] = array('type' => 'field', 'group' => 'menu4', 'tab_id' => 'advanced', 'menu_id' => 'localization');
		
		$result['menu5'] = array('type' => 'menu', 'title' => __('Subscribe Forms', 'essb'));
		$result['heading51'] = array('type' => 'heading', 'group' => 'menu5', 'title' => __('Customize MailChimp List'));
		$result['subscribe_mc_list'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-1');
		$result['heading5'] = array('type' => 'heading', 'group' => 'menu5', 'title' => __('Easy Opt-in Design #1'));
		$result['subscribe_mc_title'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-2');
		$result['subscribe_mc_text'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-2');
		$result['subscribe_mc_name'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-2');
		$result['subscribe_mc_email'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-2');
		$result['subscribe_mc_button'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-2');
		$result['subscribe_mc_footer'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-2');
		$result['subscribe_mc_success'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-2');
		$result['subscribe_mc_error'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-2');

		$result['heading6'] = array('type' => 'heading', 'group' => 'menu5', 'title' => __('Easy Opt-in Design #2'));
		$result['subscribe_mc_title2'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-3');
		$result['subscribe_mc_text2'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-3');
		$result['subscribe_mc_name2'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-3');
		$result['subscribe_mc_email2'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-3');
		$result['subscribe_mc_button2'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-3');
		$result['subscribe_mc_footer2'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-3');
		$result['subscribe_mc_success2'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-3');
		$result['subscribe_mc_error2'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-3');

		$result['heading7'] = array('type' => 'heading', 'group' => 'menu5', 'title' => __('Easy Opt-in Design #3'));
		$result['subscribe_mc_title3'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-4');
		$result['subscribe_mc_text3'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-4');
		$result['subscribe_mc_name3'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-4');
		$result['subscribe_mc_email3'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-4');
		$result['subscribe_mc_button3'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-4');
		$result['subscribe_mc_footer3'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-4');
		$result['subscribe_mc_success3'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-4');
		$result['subscribe_mc_error3'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-4');

		$result['heading8'] = array('type' => 'heading', 'group' => 'menu5', 'title' => __('Easy Opt-in Design #4'));
		$result['subscribe_mc_title4'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-5');
		$result['subscribe_mc_text4'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-5');
		$result['subscribe_mc_name4'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-5');
		$result['subscribe_mc_email4'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-5');
		$result['subscribe_mc_button4'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-5');
		$result['subscribe_mc_footer4'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-5');
		$result['subscribe_mc_success4'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-5');
		$result['subscribe_mc_error4'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-5');

		$result['heading9'] = array('type' => 'heading', 'group' => 'menu5', 'title' => __('Easy Opt-in Design #5'));
		$result['subscribe_mc_title5'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-6');
		$result['subscribe_mc_text5'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-6');
		$result['subscribe_mc_name5'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-6');
		$result['subscribe_mc_email5'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-6');
		$result['subscribe_mc_button5'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-6');
		$result['subscribe_mc_footer5'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-6');
		$result['subscribe_mc_success5'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-6');
		$result['subscribe_mc_error5'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-6');

		$result['heading10'] = array('type' => 'heading', 'group' => 'menu5', 'title' => __('Easy Opt-in Design #6'));
		$result['subscribe_mc_title6'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-7');
		$result['subscribe_mc_text6'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-7');
		$result['subscribe_mc_name6'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-7');
		$result['subscribe_mc_email6'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-7');
		$result['subscribe_mc_button6'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-7');
		$result['subscribe_mc_footer6'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-7');
		$result['subscribe_mc_success6'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-7');
		$result['subscribe_mc_error6'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-7');

		$result['heading11'] = array('type' => 'heading', 'group' => 'menu5', 'title' => __('Easy Opt-in Design #7'));
		$result['subscribe_mc_title7'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-8');
		$result['subscribe_mc_text7'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-8');
		$result['subscribe_mc_name7'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-8');
		$result['subscribe_mc_email7'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-8');
		$result['subscribe_mc_button7'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-8');
		$result['subscribe_mc_footer7'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-8');
		$result['subscribe_mc_success7'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-8');
		$result['subscribe_mc_error7'] = array('type' => 'field', 'group' => 'menu5', 'tab_id' => 'display', 'menu_id' => 'optin-8');
		
		$result['menu6'] = array('type' => 'menu', 'title' => __('Display Methods', 'essb'));
		$result['heading12'] = array('type' => 'heading', 'group' => 'menu6', 'title' => __('Pop-up'));
		$result['popup_window_title'] = array('type' => 'field', 'group' => 'menu6', 'tab_id' => 'where', 'menu_id' => 'display-11');
		$result['popup_user_message'] = array('type' => 'field', 'group' => 'menu6', 'tab_id' => 'where', 'menu_id' => 'display-11');

		$result['heading14'] = array('type' => 'heading', 'group' => 'menu6', 'title' => __('Top Bar'));
		$result['topbar_usercontent'] = array('type' => 'field', 'group' => 'menu6', 'tab_id' => 'where', 'menu_id' => 'display-9');
		
		$result['heading15'] = array('type' => 'heading', 'group' => 'menu6', 'title' => __('Bottom Bar'));
		$result['bottombar_usercontent'] = array('type' => 'field', 'group' => 'menu6', 'tab_id' => 'where', 'menu_id' => 'display-10');
		
		// @since 5.0 followers counter integration
		if (class_exists('ESSBSocialFollowersCounterHelper')) {
			$result['menu7'] = array('type' => 'menu', 'title' => __('Followers Counter', 'essb'));
				
			$network_list = ESSBSocialFollowersCounterHelper::available_social_networks();
			foreach ($network_list as $key => $name) {
				$result['socialheading_'.$key] = array('type' => 'heading', 'group' => 'menu7', 'title' => $name);
				$result['essb3fans_'.$key.'_text'] = array('type' => 'field', 'group' => 'menu7', 'tab_id' => 'display', 'menu_id' => 'follow-2', 'followers' => 'true');
				
			}
		}
		
		return $result;
	}
}


if (!function_exists('essb4_options_multilanguage_load')) {
	function essb4_options_multilanguage_load($options) {
		
		$site_language = ESSBWpmlBridge::getFrontEndLanugage();
		
		$translatable_options = essb_wpml_translatable_fields();
		foreach ($translatable_options as $key => $data) {
			$type = isset($data['type']) ? $data['type'] : '';
			if ($type == 'field') {
				
				$is_followers = isset($data['followers']) ? $data['followers'] : '';
				if ($is_followers == 'true') { 
					continue;
				}
				
				$translation = essb_wpml_option_value('wpml_'.$key, $site_language);
				if ($translation != '') {
					$options[$key] = $translation;
				}
			}
			if ($type == 'networks') {
				$networks_list = essb_available_social_networks();
				foreach ($networks_list as $network => $network_data) {
					$translation = essb_wpml_option_value('wpml_user_network_name_'.$network, $site_language);
					if ($translation != '') {
						$options['user_network_name_'.$network] = $translation;
					}
					
					$translation = essb_wpml_option_value('wpml_hovertext_'.$network, $site_language);
					if ($translation != '') {
						$options['hovertext_'.$network] = $translation;
					}
				}
				
			}
		}
		
		return $options;
	}
	
	add_filter('essb4_options_multilanguage', 'essb4_options_multilanguage_load');
	
	function essb4_followeroptions_multilanguage_load($options) {
		
		global $essb_socialfans_options;
		
		$site_language = ESSBWpmlBridge::getFrontEndLanugage();
		
		$translatable_options = essb_wpml_translatable_fields();
		foreach ($translatable_options as $key => $data) {
			$type = isset($data['type']) ? $data['type'] : '';
			if ($type == 'field') {
		
				$is_followers = isset($data['followers']) ? $data['followers'] : '';
				if ($is_followers != 'true') {
					continue;
				}
		
				$translate_key = 'wpml_'.$key.'_'.$site_language;
				
				$translation = isset($essb_socialfans_options[$translate_key]) ? $essb_socialfans_options[$translate_key] : '';
				
				if ($translation != '') {
					$options[$key] = $translation;
				}
			}			
		}		
		
		return $options;
	}
	
	add_filter('essb4_followeroptions_multilanguage', 'essb4_followeroptions_multilanguage_load');
}