<?php
/**
 * EasySocialShareButtons CoreExtender: Shortcode Profiles
 *
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2016 AppsCreo
 * @since 3.6
 *
 */

class ESSBCoreExtenderShortcodeProfiles {
	
	public static function parse_shortcode($atts, $options) {
		
		$sc_networks = isset($atts['networks']) ? $atts['networks'] : '';
		$sc_template = isset($atts['template']) ? $atts['template'] : 'flat';
		$sc_animation = isset($atts['animation']) ? $atts['animation'] : '';
		$sc_nospace = isset($atts['nospace']) ? $atts['nospace'] : 'false';
				
		$sc_nospace = ESSBOptionValuesHelper::unified_true($sc_nospace);		
		
		$profile_networks = array();
		if ($sc_networks != '') {
			$profile_networks = explode(',', $sc_networks);
		}
		else {
			$profile_networks = ESSBOptionValuesHelper::advanced_array_to_simple_array(essb_available_social_profiles());
		}
		
		
		// prepare network values
		$sc_network_address = array();
		foreach ($profile_networks as $network) {
			$value = isset($atts[$network]) ? $atts[$network] : '';
				
			if (empty($value)) {
				$value = isset($atts['profile_'.$network]) ? $atts['profile_'.$network] : '';
			}
				
			if (empty($value)) {
				$value = ESSBOptionValuesHelper::options_value($options, 'profile_'.$network);
			}
				
			if (!empty($value)) {
				$sc_network_address[$network] = $value;
			}
		}
		
		
		if (!defined('ESSB3_SOCIALPROFILES_ACTIVE')) {
			include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-profiles/essb-social-profiles.php');
			include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-profiles/essb-social-profiles-helper.php');
			define('ESSB3_SOCIALPROFILES_ACTIVE', 'true');
			$template_url = ESSB3_PLUGIN_URL . '/lib/modules/social-followers-counter/assets/css/essb-followers-counter.min.css';
			essb_resource_builder()->add_static_footer_css($template_url, 'essb-social-followers-counter');
		}
		else {
			if (!essb_resource_builder()->is_activated('profiles_css')) {
				$template_url = ESSB3_PLUGIN_URL . '/lib/modules/social-followers-counter/assets/css/essb-followers-counter.min.css';
				essb_resource_builder()->add_static_footer_css($template_url, 'essb-social-followers-counter');				
			}
		}
		
		$options = array(
				'position' => '',
				'template' => $sc_template,
				'animation' => $sc_animation,
				'nospace' => $sc_nospace,
				'networks' => $sc_network_address
		);
		
		return ESSBSocialProfiles::draw_social_profiles($options);
		
		//return ESSBSocialProfiles::generate_social_profile_icons($sc_network_address, $sc_button_type, $sc_button_size, $sc_button_fill,
		//		$sc_nospace, '', $sc_usetexts, $sc_network_texts, $sc_width);
	}
	
}