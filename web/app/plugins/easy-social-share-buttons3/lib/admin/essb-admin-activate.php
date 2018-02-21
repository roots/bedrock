<?php

class ESSBAdminActivate {
	public static function is_activated() {
		return ESSBActivationManager::isActivated();
	}
	
	public static function should_display_notice() {
		$notice_dismissed = get_transient('essb3-activate-notice');
		
		if ($notice_dismissed === false) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public static function activateToUnlock($user_message = '', $custom_style = '') {
		if ($user_message == '') {
			$user_message = __('Activate plugin to unlock', 'essb');
		}

		$activate_url = admin_url('admin.php?page=essb_redirect_update&tab=update');
		
		$code = '<a href="'.$activate_url.'" style="font-weight: 600;border-radius: 4px;padding: 0px 15px;line-height: 32px;color: #fff;font-size: 13px;background-color: #e74c3c; display: inline-block;'.$custom_style.'"><i class="fa fa-ban"></i> '.$user_message.'</a>';
		
		return $code;
	}
	
	public static function dismiss_notice() {
		//update_option('essb3-activate-notice', 'true');
		set_transient('essb3-activate-notice', 'true', 336 * HOUR_IN_SECONDS);
	}
	
	public static function notice_activate() {
		
		if (ESSBActivationManager::isThemeIntegrated()) {
			return;
		}
		
		$options_slug = essb_show_welcome() ? 'essb_redirect_social' : 'essb_options';
		
		$dismiss_url = esc_url_raw(add_query_arg(array('dismissactivate' => 'true'), admin_url ("admin.php?page=".$options_slug)));
		//$update_url = esc_url_raw(admin_url ("admin.php?page=essb_redirect_update&tab=update"));
		
		$dismiss_addons_button = '<a href="'.$dismiss_url.'"  text="' . __ ( 'Close this message', 'essb' ) . '" class="status_button float_right" style="margin-right: 5px;"><i class="fa fa-close"></i>&nbsp;' . __ ( 'Close this message', 'essb' ) . '</a>';
		echo '<div class="essb-header-status">';		
		ESSBOptionsFramework::draw_hint(__('Activate Easy Social Share Buttons for WordPress', 'essb'), sprintf('Hello! Would you like to receive automatic updates, access to free extensions library, access to ready made presents and unlock premium support? Please <a href="admin.php?page=essb_redirect_update&tab=update">activate your copy</a> of Easy Social Share Buttons for WordPress %1$s', $dismiss_addons_button), 'fa fa-lock', 'status essb-status-activate');
		echo '</div>';
		
	}
	
	public static function notice_manager() {
		$dismiss_translate = isset($_REQUEST['dismiss_translate']) ? $_REQUEST['dismiss_translate'] : '';
		if ($dismiss_translate == 'true') {
			self::dismiss_notice_translate();
		}	
		
		$dismiss_subscribe = isset($_REQUEST['dismiss_subscribe']) ? $_REQUEST['dismiss_subscribe'] : '';
		if ($dismiss_subscribe == 'true') {
			//self::dismiss_notice_subscribe();
		}
		// notice display
		if (self::should_display_notice_translate()) {
			self::notice_translate();
		}
		if (self::should_display_notice_subscribe()) {
			//self::notice_subscribe();
		}
	}
	
	public static function should_display_notice_translate() {
		return false;
		
		/*$notice_dismissed = get_option('essb3-translate-notice');
		
		if ($notice_dismissed === false) {
			return true;
		}
		else {
			return false;
		}*/
	}
	
	public static function dismiss_notice_translate() {
		update_option('essb3-translate-notice', 'true');
	}
	
	public static function notice_translate() {
		$dismiss_url = esc_url_raw(add_query_arg(array('dismiss_translate' => 'true'), admin_url ("admin.php?page=essb_options")));
	
		$dismiss_addons_button = '<a href="'.$dismiss_url.'"  text="' . __ ( 'Close this message', 'essb' ) . '" class="status_button float_right" style="margin-right: 5px;"><i class="fa fa-close"></i>&nbsp;' . __ ( 'Close this message', 'essb' ) . '</a>';
		echo '<div class="essb-header-status">';		
		ESSBOptionsFramework::draw_hint(__('Help us make Easy Social Share Buttons speak in your language', 'essb'), sprintf('Version 4 of Easy Social Share Buttons for WordPress has fully translatable admin panel. Help up us and our customers by translating plugin in your language. Please <a href="admin.php?page=essb_redirect_advanced&tab=advanced&section=translate&subsection">view translate instructions and see how easy is.</a> %1$s', $dismiss_addons_button), 'fa fa-language', 'status');
		echo '</div>';
	}
	
	public static function should_display_notice_subscribe() {
		return false;
		/*$notice_dismissed = get_option('essb3-subscribe-notice');
	
		if ($notice_dismissed === false) {
			return true;
		}
		else {
			return false;
		}*/
	}
	
	public static function dismiss_notice_subscribe() {
		update_option('essb3-subscribe-notice', 'true');
	}
	
	public static function notice_subscribe() {
		$code = '<div class="essb-admin-widget">';
		$code .= '<form action="//appscreo.us13.list-manage.com/subscribe/post?u=a1d01670c240536f6a70e7778&amp;id=c896311986" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>';
		$code .= '<div class="" id="title-wrap" style="margin-top: 5px;">';
		//print '<label class="screen-reader-text prompt" for="mce-EMAIL" id="title-prompt-text">Enter your email</label>';
		$code .= '<input type="email" name="EMAIL" id="mce-EMAIL" autocomplete="off" placeholder="Enter your email" class="input-element" style="width: 250px; border-radius: 3px; font-size: 12px; padding: 3px;" />';
		$code .= '<input type="submit" name="subscribe" id="mc-embedded-subscribe" class="essb-btn" value="Subscribe" style="font-size:11px; box-shadow: none;">';
		$code .= '</div>';
		$code .= '</form>';
		$code .= '</div>';

		$dismiss_url = esc_url_raw(add_query_arg(array('dismiss_subscribe' => 'true'), admin_url ("admin.php?page=essb_options")));
		
		$dismiss_addons_button = '<a href="'.$dismiss_url.'"  text="' . __ ( 'Close this message', 'essb' ) . '" class="status_button float_right" style="margin-right: 5px; margin-top: -15px; z-index: 100;"><i class="fa fa-close"></i>&nbsp;' . __ ( 'Close this message', 'essb' ) . '</a>';
		echo '<div class="essb-header-status">';
		
		ESSBOptionsFramework::draw_hint(__('Join our list and be the first to know of what we are working on (including useful social media and WordPress tips)', 'essb'), sprintf('%2$s %1$s', $dismiss_addons_button, $code), 'fa fa-envelope-o', 'status');
		echo '</div>';
	}
	
	public static function notice_new_addons() {
		if (ESSB3_ADDONS_ACTIVE && class_exists('ESSBAddonsHelper')) {
			$addons = ESSBAddonsHelper::get_instance();
			$new_addons = $addons->get_new_addons();
			
			$new_addons_count = $addons->get_new_addons_count();

			if ($new_addons_count > 0) {
				$dismiss_keys = "";
				$new_addons_list = "";
				$cnt = 0;
				foreach ($new_addons as $key => $data) {
			
					if ($dismiss_keys != "") {
						$dismiss_keys .= ',';
					}
					$dismiss_keys .= $key;
					
					$cnt++;
			
					if ($new_addons_list != '') {
						$new_addons_list .= ', ';
					}
					$new_addons_list .= sprintf('<a href="%2$s"><b>%1$s</b></a>', $data['title'], admin_url ("admin.php?page=essb_addons"));
				}
					
				$single_text = __('New extension for Easy Social Share Buttons for WordPress is available!', 'essb');
				$plural_text = __('New extensions for Easy Social Share Buttons for WordPress are available! ', 'essb');
					
				$display_text = ($cnt > 1) ? $plural_text : $single_text;
				$display_text = $cnt. ' '.$display_text;
				
				if (essb_show_welcome()) {
					$dismiss_url = esc_url_raw(add_query_arg(array('dismiss' => 'true', 'addon' => $dismiss_keys), admin_url ("admin.php?page=essb_redirect_social&tab=social")));
				}
				else {
					$dismiss_url = esc_url_raw(add_query_arg(array('dismiss' => 'true', 'addon' => $dismiss_keys), admin_url ("admin.php?page=essb_options")));
				}
				$all_addons_button = '<a href="' . admin_url ( "admin.php?page=essb_redirect_extensions&tab=extensions" ) . '"  text="' . __ ( 'Extensions', 'essb' ) . '" class="status_button" style="margin-right: 10px;"><i class="dashicons dashicons-admin-plugins" style="margin-right: 3px;"></i>&nbsp;' . __ ( 'View list of all extensions', 'essb' ) . '</a>';
				
				$dismiss_addons_button = '<a href="'.$dismiss_url.'"  text="' . __ ( 'Hide notice', 'essb' ) . '" class="status_button"><i class="dashicons dashicons-no-alt"></i>&nbsp;'.__('Hide message', 'essb').'</a>';
				
				$buttons_container = '<div style="text-align: right; margin-top: 5px;">'.$all_addons_button.$dismiss_addons_button.'</div>';
				
				
				//printf ( '<div class="updated fade"><div><div style="padding-top: 10px; padding-bottom: 10px; display: inline-block; width:%4$s;">%1$s%2$s</div><div style="display: inline-block; width:%5$s; text-align: right; vertical-align: top; margin-top:5px;">%3$s</div></div></div>', $display_text, $new_addons_list, $dismiss_addons_button, '95%', '5%' );
				echo '<div class="essb-header-status">';
				
				ESSBOptionsFramework::draw_hint($display_text, sprintf('%1$s %2$s', $new_addons_list, $buttons_container), 'dashicons dashicons-admin-plugins', 'status essb-status-addon fade essb-status-global-addons');
				echo '</div>';
			}
		}
		
	}
}

?>