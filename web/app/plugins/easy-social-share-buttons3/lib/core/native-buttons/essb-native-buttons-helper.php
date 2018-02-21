<?php

class ESSBNativeButtonsHelper {
	
	public static $essb_spb;
	
	public static function get_list_of_social_apis() {
		global $essb_options;

		$social_apis = array();

		if (!defined('ESSB3_NATIVE_ACTIVE')) {
			return $social_apis;
		}		
		
		if (essb_is_module_deactivated_on('native')) {
			return $social_apis;
		}
		
		if (ESSBOptionValuesHelper::options_value($essb_options, 'facebook_like_button') && !ESSBOptionValuesHelper::options_bool_value($essb_options, 'facebook_like_button_api')) {
			if (self::$essb_spb->is_active('facebook')) {
				$social_apis['facebook'] = "facebook";
			}
		}

		if (ESSBOptionValuesHelper::options_value($essb_options, 'googleplus') || ESSBOptionValuesHelper::options_bool_value($essb_options, 'youtubesub')) {
			if (self::$essb_spb->is_active('google') || self::$essb_spb->is_active('youtube')) {
				$social_apis['google'] = "google";
			}
		}

		if (ESSBOptionValuesHelper::options_value($essb_options, 'vklike')) {
			if (self::$essb_spb->is_active('vk')) {
				$social_apis['vk'] = "vk";
			}
		}
		
		
		if (ESSBOptionValuesHelper::options_value($essb_options, 'twitterfollow')) {
			if (self::$essb_spb->is_active('twitter')) {
				$social_apis['twitter'] = "twitter";
			}
		}
		
		if (ESSBOptionValuesHelper::options_bool_value($essb_options, 'pinterestfollow')) {
			if (self::$essb_spb->is_active('pinterest')) {
				$social_apis['pinterest'] = "pinterest";
			}
		}
		
		return $social_apis;
	}
	
	public static function is_active_network ($network) {
		if (self::$essb_spb->is_active($network)) {
			return true;	
		}
		else {
			return false;
		}
	}
	
	public static function active_native_buttons() {
		global $essb_options;
		
		$current_order = ESSBOptionValuesHelper::options_value($essb_options, 'native_order');
		
		$active_networks = array();
		
		if (is_array($current_order)) {
			foreach ($current_order as $network) {
				if ($network == "facebook" && ESSBOptionValuesHelper::options_bool_value($essb_options, 'facebook_like_button')) {
					$active_networks[] = 'facebook';
				}
				if ($network == "google" && ESSBOptionValuesHelper::options_bool_value($essb_options, 'googleplus')) {
					$active_networks[] = 'google';
				}
				if ($network == "twitter" && ESSBOptionValuesHelper::options_bool_value($essb_options, 'twitterfollow')) {
					$active_networks[] = 'twitter';
				}
				if ($network == "youtube" && ESSBOptionValuesHelper::options_bool_value($essb_options, 'youtubesub')) {
					$active_networks[] = 'youtube';
				}
				if ($network == "pinterest" && ESSBOptionValuesHelper::options_bool_value($essb_options, 'pinterestfollow')) {
					$active_networks[] = 'pinterest';
				}
				if ($network == "linkedin" && ESSBOptionValuesHelper::options_bool_value($essb_options, 'linkedin_follow')) {
					$active_networks[] = 'linkedin';
				}
				if ($network == "managewp" && ESSBOptionValuesHelper::options_bool_value($essb_options, 'managedwp_button')) {
					$active_networks[] = 'managewp';
				}
				if ($network == "vk" && ESSBOptionValuesHelper::options_bool_value($essb_options, 'vklike')) {
					$active_networks[] = 'vk';
				}
				
			}
		}
		
		return $active_networks;
	}
	
	public static function native_button_defaults() {
		global $essb_options;
		
		$defaults = array();
		
		$facebook_type = ESSBOptionValuesHelper::options_value($essb_options, 'facebook_like_type', 'like');
		$facebook_url = '';
		if ($facebook_type == 'like') {
			$facebook_url = ESSBOptionValuesHelper::options_value($essb_options, 'custom_url_like_address');
		}
		else {
			$facebook_url = ESSBOptionValuesHelper::options_value($essb_options, 'facebook_follow_profile');
		}
		
		$defaults['facebook_type'] = $facebook_type;
		$defaults['facebook_url'] = $facebook_url;

		$google_type = ESSBOptionValuesHelper::options_value($essb_options, 'google_like_type', 'plus');
		$google_url = '';
		if ($google_type == 'plus') {
			$google_url = ESSBOptionValuesHelper::options_value($essb_options, 'custom_url_plusone_address');
		}
		else {
			$google_url = ESSBOptionValuesHelper::options_value($essb_options, 'google_follow_profile');
		}
		
		$defaults['google_type'] = $google_type;
		$defaults['google_url'] = $google_url;
		
		$twitter_type = ESSBOptionValuesHelper::options_value($essb_options, 'twitter_tweet');
		$twitter_user = ESSBOptionValuesHelper::options_value($essb_options, 'twitterfollowuser');
		
		$defaults['twitter_type'] = $twitter_type;
		$defaults['twitter_user'] = $twitter_user;
		
		$pinterest_type = ESSBOptionValuesHelper::options_value($essb_options, 'pinterest_native_type');
		$pinterest_url = ESSBOptionValuesHelper::options_value($essb_options, 'pinterestfollow_url');
		$pinterest_text = ESSBOptionValuesHelper::options_value($essb_options, 'pinterestfollow_disp');
		
		$defaults['pinterest_type'] = $pinterest_type;
		$defaults['pinterest_url'] = $pinterest_url;
		$defaults['pinterest_display'] = $pinterest_text;
		
		$linkedin_company = ESSBOptionValuesHelper::options_value($essb_options, 'linkedin_follow_id');
		$defaults['linkedin_company'] = $linkedin_company;
		
		$youtube_channel = ESSBOptionValuesHelper::options_value($essb_options, 'youtubechannel');
		$defaults['youtube_channel'] = $youtube_channel;
		
		$defaults['sameline'] = ESSBOptionValuesHelper::options_bool_value($essb_options, 'otherbuttons_sameline');
		$defaults['counters'] = ESSBOptionValuesHelper::options_bool_value($essb_options, 'allnative_counters');
		$defaults['skinned'] = ESSBOptionValuesHelper::options_bool_value($essb_options, 'skin_native');
		
		return $defaults;
	}
	
	public static function draw_native_buttons($settings = array(), $active_buttons = array(), $counters = false, $same_line = false, $skinned_buttons = false) {
		global $essb_options;
		
		if (!isset($settings['skin']) || empty($settings['skin'])) {
			$settings['skin'] = ESSBOptionValuesHelper::options_value($essb_options, 'skin_native_skin');
		}
		
		if (!isset( $settings['image'])) {
			$settings['image'] = "";
		}
		if (!isset( $settings['title'])) {
			$settings['title'] = "";
		}
		if (!isset( $settings['url'])) {
			$settings['url'] = "";
		}
		if (!isset( $settings['short_url'])) {
			$settings['short_url'] = "";
		}		
		$output = '';
		
		$with_share_buttons = isset($settings['withshare']) ? $settings['withshare'] : false;
		
		if (!$same_line) {
			$output .= '<div class="essb_native_buttons'.($with_share_buttons ? " essb_native_after_share" : "").'">';
			
			if (isset($settings['message_like_buttons']) && !empty($settings['message_like_buttons'])) {
				$settings ['message_like_buttons'] = preg_replace(array('#%title%#', '#%siteurl%#', '#%permalink%#', '#%image%#', '#%shorturl%#'), array($settings['title'], get_site_url(), $settings['url'], $settings['image'], $settings['short_url']), $settings ['message_like_buttons']);
				$output .= sprintf ( '<div class="essb_message_above_like">%1$s</div>', stripslashes ( $settings ['message_like_buttons'] ) );
			}

			$output .= '<ul class="essb_links">';
		}
		
		foreach ($active_buttons as $network) {
			$skinned_class = ($skinned_buttons) ? " essb_native_item_skinned" : "";
			$output .= sprintf('<li class="essb_item essb_native_item essb_native_item_%1$s%2$s">', $network, $skinned_class);
			
			if (self::$essb_spb->is_active($network)) {
				$button_code = self::single_native_button($network, $settings, $counters, $skinned_buttons);
				
				if ($skinned_buttons) {
					$skinned_text = isset($settings[$network.'_text']) ? $settings[$network.'_text'] : '';
					$skinned_width = isset($settings[$network.'_width']) ? $settings[$network.'_width'] : '';
					
					if (empty($skinned_text)) {
						$skinned_text = ESSBOptionValuesHelper::options_value($essb_options, 'skinned_'.$network.'_text', $network);
					}
					if (empty($skinned_text)) {
						$skinned_width = ESSBOptionValuesHelper::options_value($essb_options, 'skinned_'.$network.'_width', '80');
					}
					
					$output .= ESSBSkinnedNativeButtons::generate_skinned_button($network, $button_code, $network, $skinned_text, $skinned_width, $settings['skin']);
				}
				else {
					$output .= $button_code;
				}
			}
			else {
				// if not activated in privacy mode the display privacy button
				$output .= self::$essb_spb->generate_button($network, '');
			}
			
			$output .= '</li>';
		}
		
		if (!$same_line) {
			$output .= "</ul></div>";
		}
		
		return $output;
	}
	
	public static function draw_single_native_button($network, $settings = array(), $counters = false, $skinned_buttons = false, $size = '') {
		global $essb_options;
		
		$output = "";
		
		if (self::$essb_spb->is_active($network)) {
			$button_code = self::single_native_button($network, $settings, $counters, $skinned_buttons, $size);
		
			if ($skinned_buttons) {
				$skinned_text = isset($settings[$network.'_text']) ? $settings[$network.'_text'] : '';
				$skinned_width = isset($settings[$network.'_width']) ? $settings[$network.'_width'] : '';
					
				if (empty($skinned_text)) {
					$skinned_text = ESSBOptionValuesHelper::options_value($essb_options, 'skinned_'.$network.'_text', $network);
				}
				if (empty($skinned_text)) {
					$skinned_width = ESSBOptionValuesHelper::options_value($essb_options, 'skinned_'.$network.'_width', '80');
				}
					
				$output .= ESSBSkinnedNativeButtons::generate_skinned_button($network, $button_code, $network, $skinned_text, $skinned_width, $settings['skin']);
			}
			else {
				$output .= $button_code;
			}
		}
		else {
			// if not activated in privacy mode the display privacy button
			$output .= self::$essb_spb->generate_button($network, '');
		}
		
		return $output;
	}
	
	public static function single_native_button ($network, $settings = array(), $counters = false, $skinned= false, $size = '') {
		$code = "";

		switch ($network) {
			case "facebook":
				$code = self::facebook_button_code($settings, $counters, $size);
				break;
			case "google":
				$code = self::google_button_code($settings, $counters, $size);
				break;
			case "twitter":
				$code = self::twitter_button_code($settings, $counters);
				break;
			case "linkedin":
				$code = self::linkedin_button_code($settings, $counters);
				break;
			case "pinterest":
				$code = self::pinterest_button_code($settings, $counters);
				break;
			case "youtube":
				$code = self::yourbute_button_code($settings, $counters);
				break;
			case "managewp":
				$code = self::managedwp_button_code($settings, $counters);
				break;
			case "vk":
				$code = self::vk_button_code($settings, $counters);
				break;
		}
		
		return $code;
	}
	
	public static function facebook_button_css_fixer ($css, $height, $margin_top) {
		$css_object = explode(';', $css);
		$output = "";
	
		$injected_margintop = false;
		$injected_height = false;
		$injected_maxheight = false;
	
		foreach ($css_object as $singleRule) {
				
			$pos_height = strpos($singleRule, 'height');
			$pos_maxheight = strpos($singleRule, 'max-height');
			$pos_margintop = strpos($singleRule, 'margin-top');
				
			if (($pos_height === false) && ($pos_maxheight === false) && ($pos_margintop === false)) {
				$output .= $singleRule.';';
			}
			else {
				$newAppendValue = "";
				if ($pos_margintop !== false) {
					if ($margin_top != '') {
						$injected_margintop = true;
						$newAppendValue = "margin-top:".$margin_top.'px !important';
					}
					else {
						$newAppendValue = $singleRule;
					}
				}
	
				if ($pos_height !== false) {
					if ($height != '') {
						$injected_height = true;
						$newAppendValue = "height:".$height. 'px !important';
					}
					else {
						$newAppendValue = $singleRule;
					}
				}
	
				if ($pos_height !== false) {
					if ($height != '') {
						$injected_maxheight = true;
						$newAppendValue = "max-height:".$height. 'px !important';
					}
					else {
						$newAppendValue = $singleRule;
					}
				}
	
				$output .= $newAppendValue . ';';
			}
		}
	
		if ($margin_top != '' && !$injected_margintop) {
			$output .= 'margin-top:'.$margin_top.'px !important;';
		}
		if ($height != '' && !$injected_height) {
			$output .= 'height:'.$height.'px !important;';
		}
		if ($height != '' && !$injected_maxheight) {
			$output .= 'max-height:'.$height.'px !important;';
		}
	
		return $output;
	}
	
	public static function facebook_button_code($settings = array(), $counters = false, $size = '') {
		global $essb_options;
		
		$facebook_type = isset($settings['facebook_type']) ? $settings['facebook_type'] : 'like';
		$facebook_url = isset($settings['facebook_url']) ? $settings['facebook_url'] : '';
	
		$facebook_margin_top = ESSBOptionValuesHelper::options_value($essb_options, 'facebook_like_button_margin_top');
		$facebook_height = ESSBOptionValuesHelper::options_value($essb_options, 'facebook_like_button_height');
		$facebook_width = ESSBOptionValuesHelper::options_value($essb_options, 'facebook_like_button_width');
		
		$facebook_share_button = essb_option_bool_value('facebook_like_button_share');
		$fb_share_tag = "false";
		if ($facebook_share_button) {
			$fb_share_tag = "true";
		}
		
		$button_size = ($counters ? "button_count" : "button");
		if ($size == 'big') {
			$button_size = 'box_count';
		}
		
		if (trim($facebook_width) != "") {
			$facebook_width = "width:".$facebook_width.'px;';
		}
		
		$code = '<div style="'.self::facebook_button_css_fixer('display: inline-block; height: 24px; max-height: 24px; '.$facebook_width.'vertical-align: top;', $facebook_height, $facebook_margin_top).'">';				
		
		if ($size == 'big') {
			$code = '<div style="'.self::facebook_button_css_fixer('display: inline-block; '.$facebook_width.'vertical-align: top;', $facebook_height, $facebook_margin_top).'">';				
		}
		
		if ($facebook_type == "like") {
			$code .= '<div class="fb-like" data-href="'.$facebook_url.'" data-layout="'.$button_size.'" data-action="like" data-show-faces="false" data-share="'.$fb_share_tag.'" data-width="292" style="vertical-align: top; zoom: 1;display: inline;"></div>';
		}
		else {
			$code .= '<div class="fb-follow" data-href="'.$facebook_url.'" data-layout="'.$button_size.'" data-show-faces="false"></div>';
		}

		$code .= '</div>';
		
		return $code;
	}
	
	public static function google_button_code($settings = array(), $counters = false, $size = '') {
		$google_type = isset($settings['google_type']) ? $settings['google_type'] : 'plus';
		$google_url = isset($settings['google_url']) ? $settings['google_url'] : '';
		
		$code = "";	
		
		if ($google_type == "plus") {
			$code = '<div class="g-plusone" data-size="'.($size == 'big' ? 'tall' : 'medium').'" data-href="' . $google_url . '" '.($counters ? '' : 'data-annotation="none"').'></div>';
		}
		else {
			$code .= '<div class="g-follow" data-size="'.($size == 'big' ? 'tall' : 'medium').'" data-href="' . $google_url . '" '.($counters ? '' : 'data-annotation="none"').' data-rel="publisher"></div>';		
		}
		
		//print 'data-size="'.($size == 'big' ? 'tall' : 'medium').'" data-href="' . $google_url . '" '.($counters ? '' : 'data-annotation="none"');
		
		return $code;
	}
	
	public static function twitter_button_code($settings = array(), $counters = false) {
		$twitter_type = isset($settings['twitter_type']) ? $settings['twitter_type'] : 'follow';
		$twitter_user = isset($settings['twitter_user']) ? $settings['twitter_user'] : '';
		
		$button_url = isset($settings['url']) ? $settings['url'] : '';
		$button_text = isset($settings['twitter_tweet']) ? $settings['twitter_tweet'] : '';
		
		$code = '';
		
		if ($twitter_type == 'follow') {
			//$code = '<iframe allowtransparency="true" frameborder="0" scrolling="no" src="//platform.twitter.com/widgets/follow_button.html?screen_name='.$twitter_user.'&show_count='.($counters ? "true" :"false").'&show_screen_name=false&lang=en" style="height:20px;"></iframe>';
			$code = '<a href="https://twitter.com/'.$twitter_user.'" class="twitter-follow-button" '.($counters ? "" : 'data-show-count="false"').' data-lang="en" data-show-screen-name="false">Follow</a>';
		}
		else {
			$code = '<a href="https://twitter.com/share" class="twitter-share-button" data-via="'.$twitter_user.'" data-lang="'.'en'.'" '.($counters ? "" : 'data-count="none"').' data-text="'.$button_text.'" data-url="'.$button_url.'">Tweeter</a>';
		}
		
		return $code;
	}
	
	public static function managedwp_button_code($settings = array(), $counters = false) {
		$button_url = isset($settings['url']) ? $settings['url'] : '';
		$button_text = isset($settings['text']) ? $settings['text'] : '';
		
		return '<script src="http://managewp.org/share.js" data-type="small" data-title="'.$button_text.'" data-url="'.$button_url.'"></script>';
	}
	
	public static function pinterest_button_code($settings = array(), $counters = false) {
		$pinterest_type = isset($settings['pinterest_type']) ? $settings['pinterest_type'] : 'follow';
		$pinterest_url = isset($settings['pinterest_url']) ? $settings['pinterest_url'] : '';
		$pinterest_text = isset($settings['pinterest_display']) ? $settings['pinterest_display'] : '';
		//print_r($settings);
		$code = '';
		
		if ($pinterest_type == "follow") {
			$code = '<a data-pin-do="buttonFollow" href="'.$pinterest_url.'">'.$pinterest_text.'</a>';
		}
		else {
			$code = '<a href="//www.pinterest.com/pin/create/button/" data-pin-do="buttonBookmark" ><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" /></a>';
		}
		
		return $code;
	}
	
	public static function linkedin_button_code($settings = array(), $counters = false) {
		$linkedin_company = isset($settings['linkedin_company']) ? $settings['linkedin_company'] : '';
		
		$code = '<script src="//platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script><script type="IN/FollowCompany" data-id="'.$linkedin_company.'" data-counter="'.($counters ? "right" : "none").'"></script>';
		
		return $code;
	}
	
	public static function yourbute_button_code($settings = array(), $counters = false) {
		$youtube_channel = isset($settings['youtube_channel']) ? $settings['youtube_channel'] : '';
		
		$code = '<div class="g-ytsubscribe" data-channelid="'.$youtube_channel.'" data-layout="default" data-count="'.($counters ? "default" : "hidden").'"></div>';
		
		return $code;
	}
	
	public static function vk_button_code($settings = array(), $counters = false) {
		$salt = mt_rand();
		$code = '<div id="vk_like' . $salt . '" style="float: left; poistion: relative;"></div>';
		$code .= '<script type="text/javascript">
		jQuery(document).ready(function($){
		VK.Widgets.Like("vk_like' . $salt . '", {type: "button", height: 20});
		});
		</script>';
		
		return $code;
	}
}

?>