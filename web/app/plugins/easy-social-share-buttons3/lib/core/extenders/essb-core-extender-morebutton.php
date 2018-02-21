<?php
if (!function_exists('essb_generate_morebutton_code')) {
	function essb_generate_morebutton_code($button_style, $social_networks, $social_networks_order, $salt, $position,
			$post_share_details, $social_networks_names, $share_button_exist = false) {
		
		$code = "";
		
		$share_bottom_networks = $social_networks;
		
		//print "position = ".$position. ", more button = ".$intance_morebutton_func;
		$user_set_morebutton_func = $button_style['more_button_func'];
		
		$user_set_style_ofpop = essb_option_value('more_button_popstyle');
		$user_set_template_ofpop = essb_option_value('more_button_poptemplate');
					
		// @since 3.3 - option to change more button style on each display position
		if (isset($button_style['location_more_button_func'])) {
			if (!empty($button_style['location_more_button_func'])) {
				$user_set_morebutton_func = $button_style['location_more_button_func'];
			}
		}
		
		if ($share_button_exist) {
			$user_set_morebutton_func = $button_style['share_button_func'];
			$user_set_style_ofpop = essb_option_value('share_button_popstyle');
			$user_set_template_ofpop = essb_option_value('share_button_poptemplate');
		}
		
		// correcting mobile popup style of mobile share buttons - it should be default classic style
		if ($position == 'sharebottom' || $position == 'sharebar' || $position == 'sharepoint') {
			$user_set_style_ofpop = '';
		}
		
		if ($user_set_morebutton_func == '1') {
			//essb_resource_builder()->add_js(ESSBResourceBuilderSnippets::js_build_generate_more_button_inline(), true, 'essb-inlinemore-code');
			//essb_depend_load_function('essb_rs_js_build_generate_more_button_inline', 'lib/core/resource-snippets/essb_rs_js_build_generate_more_button_inline.php');
				
		}
		if (($user_set_morebutton_func == '2' || $user_set_morebutton_func == '3' || $user_set_morebutton_func == '4' || $user_set_morebutton_func == '5')) {
			//essb_resource_builder()->add_js(ESSBResourceBuilderSnippets::js_build_generate_more_button_popup(), true, 'essb-popupmore-code');
			//essb_depend_load_function('essb_rs_js_build_generate_more_button_popup', 'lib/core/resource-snippets/essb_rs_js_build_generate_more_button_popup.php');
				
		
			$listAllNetworks = ($user_set_morebutton_func == '2') ? true: false;
			$more_social_networks = essb_core_helper_generate_list_networks($listAllNetworks);
			$more_social_networks_order = essb_core_helper_generate_network_list();	

			if (defined('ESSB_MORE_FORCE_ORDER')) {
				$more_social_networks = $social_networks;
				$more_social_networks_order = $social_networks_order;
			}
			
			// fix for shortcode used networks with more button
			if (is_array($social_networks) && $user_set_morebutton_func != '2' && $position == 'shortcode') {
				$more_social_networks = $social_networks;
				$more_social_networks_order = $social_networks_order;
			}				
			
			if ($user_set_morebutton_func == '4' || $user_set_morebutton_func == '5') {
				$more_social_networks = essb_core_helper_generate_list_networks_with_more(false);
				//$more_social_networks = essb_core_helper_networks_after_more($more_social_networks);
			}
			
			if ($user_set_morebutton_func != '2') {
				$personalized_networks = essb_get_active_social_networks_by_position($position);
				$personalized_network_order = essb_get_order_of_social_networks_by_position($position);
				
				if (is_array($personalized_networks) && count($personalized_networks) > 0) {
					$more_social_networks = $personalized_networks;
				}
					
				if (is_array($personalized_network_order) && count($personalized_network_order) > 0) {
					$more_social_networks_order = $personalized_network_order;
				}
			}
			
			if ($user_set_morebutton_func == '2') {
				$more_social_networks = essb_core_helper_networks_without_more($more_social_networks);
				
			}
			if ($user_set_morebutton_func == '3') {
				if (in_array('more', $more_social_networks) || in_array('share', $more_social_networks)) {
					$more_social_networks = essb_core_helper_networks_after_more($more_social_networks);
				}
			}
				
			if ($user_set_morebutton_func == '4' || $user_set_morebutton_func == '5') {
				//$more_social_networks = essb_core_helper_generate_list_networks_with_more(false);
				$more_social_networks = essb_core_helper_networks_after_more($more_social_networks);
			}
			
		
			
			//print_r($more_social_networks_order);
			//print_r($share_bottom_networks);
		
			
			// fix for missing print code
			/*if (in_array('print', $more_social_networks) && !essb_resource_builder()->is_activated('print')) {
				//essb_resource_builder()->add_js(ESSBResourceBuilderSnippets::js_build_window_print_code(), true, 'essb-printing-code');
				essb_depend_load_function('essb_rs_js_build_window_print_code', 'lib/core/resource-snippets/essb_rs_js_build_window_print_code.php');				
				essb_resource_builder()->activate_resource('print');
			}*/
			
			if (in_array('mail', $more_social_networks)) {
				essb_resource_builder()->activate_resource('mail');
			}
			
			if (in_array("love", $more_social_networks)) {
				essb_depend_load_function('essb_love_generate_js_code', 'lib/networks/essb-loveyou.php');
			}
				
		
			if ($position == "sharebottom") {
				$more_social_networks = $share_bottom_networks;
				$more_social_networks_order = $social_networks_order;
				//$button_style['more_button_icon'] = "dots";
			}
		
			$button_style['button_style'] = "button";
			$button_style['show_counter'] = false;
			$button_style['button_width'] = "column";
			$button_style['button_width_columns'] = (essb_is_mobile() ? "1" : "3");
			$button_style['counter_pos'] = "left";
			
			if ($user_set_template_ofpop != '') {
				$button_style['template'] = $user_set_template_ofpop;
			}
		
			if ($position == "sharebottom") {
				$button_style['button_width_columns'] = "1";
			}
		
			$more_salt = mt_rand();
			
			$additional_popup = '';
			$additional_popup_shadow = '';
			if ($user_set_morebutton_func == '4') {
				$additional_popup = ' essb_morepopup_inline';
				$button_style['button_style'] = "icon";
				$button_style['button_width'] = 'auto';
			}
			if ($user_set_morebutton_func == '5') {
				$additional_popup = ' essb_morepopup_inline essb_morepopup_inline_names';
				$button_style['button_style'] = "button";
				$button_style['button_width'] = "column";
				$button_style['button_width_columns'] = (essb_is_mobile() ? "1" : "2");
			}
			
			if ($user_set_style_ofpop != '') {
				$additional_popup .= ' essb_morepopup_'.$user_set_style_ofpop;
				$button_style['button_style'] = "vertical";	
				$button_style['button_width_columns'] = (essb_is_mobile() ? "2" : "4");
				$additional_popup_shadow .= ' essb_morepopup_shadow_'.$user_set_style_ofpop;
			}
			
			$user_message_inpop = "";
			if ($user_set_style_ofpop == 'modern') {
				$sharing_title = isset($post_share_details['title_plain']) ? $post_share_details['title_plain'] : '';
				$sharing_url = isset($post_share_details['full_url']) ? $post_share_details['full_url'] : '';

				$user_message_inpop .= '<div class="essb-morepopup-modern-message">';
				$user_message_inpop .= '<div class="essb-morepopup-modern-title">'.$sharing_title.'</div>';
				$user_message_inpop .= '<div class="essb-morepopup-modern-link"><a href="'.$sharing_url.'" target="_blank">'.$sharing_url.'</a></div>';
				$user_message_inpop .= '</div>';
			}
			
			$add_pointer = '';
			if ($user_set_morebutton_func == '4' || $user_set_morebutton_func == '5') {
				$add_pointer = '<div class="modal-pointer modal-pointer-up-left"><div class="modal-pointer-conceal"></div></div>';
			}				
			
			$code .= sprintf('<div class="essb_morepopup essb_morepopup_%1$s essb_morepopup_%3$s%4$s" style="display:none;">
					<a href="#" class="essb_morepopup_close" onclick="essb.toggle_less_popup(\'%1$s\'); return false;"><i class="essb_icon_close"></i></a>
					<div class="essb_morepopup_content essb_morepopup_content_%1$s">%2$s</div>%5$s</div>
					<div class="essb_morepopup_shadow essb_morepopup_shadow_%1$s%6$s" onclick="essb.toggle_less_popup(\'%1$s\'); return false;"></div>',
					$salt,
					$user_message_inpop.ESSBButtonHelper::draw_share_buttons($post_share_details, $button_style,
							$more_social_networks, $more_social_networks_order, $social_networks_names, "more_popup", $more_salt, 'share'),
					$position, $additional_popup, $add_pointer, $additional_popup_shadow);
		
			//print $more_salt."|";
		
			// fix for not workin mail in more button
			if (!isset($post_share_details['mail_subject'])) {
				if (!function_exists('essb_sharing_prepare_mail')) {
					include_once (ESSB3_PLUGIN_ROOT . 'lib/core/extenders/essb-core-extender-sharing.php');
				}
					
				$post_share_details = essb_sharing_prepare_mail($post_share_details);
					
			}
			
			// fix for the subcribe button
			// @since 3.6 Invoke code for subscribe button if network is active in list
			if (in_array("subscribe", $more_social_networks) && ESSBGlobalSettings::$subscribe_function != "link") {
				if (!class_exists('ESSBNetworks_Subscribe')) {
					include_once (ESSB3_PLUGIN_ROOT . 'lib/networks/essb-subscribe.php');
				}
					
				$code .= ESSBNetworks_Subscribe::draw_subscribe_form('sidebar', $more_salt, 'sharebuttons-more');
			}
		
			///essb_resource_builder()->add_js(essb_print_mailer_code($post_share_details['mail_subject'], $post_share_details['mail_body'],
			//		$more_salt, $post_share_details["post_id"], $position), true, 'essb-mailform-'.$more_salt);
		
		}
		
		return $code;
	}
}