<?php
/**
 * EasySocialShareButtons DisplayMethod: Popup
 *
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2016 AppsCreo
 * @since 3.6
 *
 */

class ESSBDisplayMethodPopup {
	
	public static function generate_popup_code($options, $share_buttons, $is_shortcode, $shortcode_options = array()) {
		// loading popup display settings
		
		$output = '';
		
		$popup_window_title = ESSBOptionValuesHelper::options_value($options, 'popup_window_title');
		$popup_user_message = ESSBOptionValuesHelper::options_value($options, 'popup_user_message');
		$popup_user_autoclose = ESSBOptionValuesHelper::options_value($options, 'popup_user_autoclose');
			
		// display settings
		$popup_user_width = ESSBOptionValuesHelper::options_value($options, 'popup_user_width');
		$popup_window_popafter = ESSBOptionValuesHelper::options_value($options, 'popup_window_popafter');
		$popup_user_percent = ESSBOptionValuesHelper::options_value($options, 'popup_user_percent');
		$popup_display_end = ESSBOptionValuesHelper::options_bool_value($options, 'popup_display_end');
		$popup_user_manual_show = ESSBOptionValuesHelper::options_bool_value($options, 'popup_user_manual_show');
		$popup_window_close_after = ESSBOptionValuesHelper::options_value($options, 'popup_window_close_after');
		$popup_user_notshow_onclose = ESSBOptionValuesHelper::options_bool_value($options, 'popup_user_notshow_onclose');
		$popup_user_notshow_onclose_all = ESSBOptionValuesHelper::options_bool_value($options, 'popup_user_notshow_onclose_all');
			
		// new @3.3
		$popup_display_exit = ESSBOptionValuesHelper::options_bool_value($options, 'popup_display_exit');
			
		if ($is_shortcode) {
			if (!empty($shortcode_popafter)) {
				$popup_window_popafter = $shortcode_popafter;
			}
		
			$shortcode_window_title = isset($shortcode_options['popup_title']) ? $shortcode_options['popup_title'] : '';
			$shortcode_window_message = isset($shortcode_options['popup_message']) ? $shortcode_options['popup_message'] : '';
			$shortcode_pop_on_percent = isset($shortcode_options['popup_percent']) ? $shortcode_options['popup_percent'] : '';
			$shortcode_pop_end = isset($shortcode_options['popup_end']) ? $shortcode_options['popup_end'] : '';
		
			if (!empty($shortcode_window_title)) {
				$popup_window_title = $shortcode_window_title;
			}
			if (!empty($shortcode_window_message)) {
				$popup_user_message = $shortcode_window_message;
			}
			if (!empty($shortcode_pop_on_percent)) {
				$popup_user_percent = $shortcode_pop_on_percent;
			}
			if (!empty($shortcode_pop_end)) {
				$popup_display_end = ESSBOptionValuesHelper::unified_true($shortcode_pop_end);
			}
		}
			
		if (!empty($popup_user_message)) {
			$popup_user_message = essb_post_details_to_content($popup_user_message);
		}
		if (!empty($popup_window_title)) {
			$popup_window_title = essb_post_details_to_content($popup_window_title);
		}
			
		$popup_trigger_oncomment = ESSBOptionValuesHelper::options_bool_value($options, 'popup_display_comment') ? " essb-popup-oncomment" : "";
			
		$output .= sprintf('<div class="essb-popup%10$s" data-width="%1$s" data-load-percent="%2$s" data-load-end="%3$s" data-load-manual="%4$s" data-load-time="%5$s" data-close-after="%6$s" data-close-hide="%7$s" data-close-hide-all="%8$s" data-postid="%9$s" data-exit-intent="%11$s">',
				$popup_user_width, $popup_user_percent, $popup_display_end, $popup_user_manual_show, $popup_window_popafter,
				$popup_window_close_after, $popup_user_notshow_onclose, $popup_user_notshow_onclose_all, get_the_ID(), $popup_trigger_oncomment, $popup_display_exit);
		$output .= '<a href="#" class="essb-popup-close" onclick="essb.popup_close(); return false;"></a>';
		$output .= '<div class="essb-popup-content">';
			
		if ($popup_window_title != '') {
			$output .= sprintf('<h3>%1$s</h3>', stripslashes($popup_window_title));
		}
		if ($popup_user_message != '') {
			$output .= sprintf('<div class="essb-popup-content-message">%1$s</div>', stripslashes($popup_user_message));
		}
			
		$output .= $share_buttons;
			
		if ($popup_window_close_after != '') {
			$output .= '<div class="essb_popup_counter_text"></div>';
		}
			
		$output .= '</div>';
		$output .= "</div>";
		$output .= '<div class="essb-popup-shadow" onclick="essb.popup_close(); return false;"></div>';
			
		if ($popup_window_popafter != '') {
			$output .= '<div style="display: none;" id="essb_settings_popafter_counter"></div>';
		}
		if ($popup_user_autoclose != '') {
			$output .= sprintf('<div id="essb_settings_popup_user_autoclose" style="display: none;">%1$s</div>', $popup_user_autoclose);
		}
		
		return $output;
	}
	
}