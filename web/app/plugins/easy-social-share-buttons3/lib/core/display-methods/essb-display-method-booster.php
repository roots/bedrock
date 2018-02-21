<?php
/**
 * EasySocialShareButtons Display Method: Corner Bar
 *
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2017 AppsCreo
 * @since 5.1
 *
 */

if (!function_exists('essb5_generate_booster')) {
	function essb5_generate_booster($share_buttons = '') {
		$output = '';
		
		$booster_trigger = essb_option_value('booster_trigger');
		$booster_time = essb_option_value('booster_time');
		$booster_scroll = essb_option_value('booster_scroll');
		$booster_bg = essb_option_value('booster_bg');
		
		$booster_donotshow = essb_option_value('booster_donotshow');
		$booster_donotshow_on = essb_option_value('booster_donotshow_on');
		$booster_autoclose = essb_option_value('booster_autoclose');
		$booster_manualclose = essb_option_bool_value('booster_manualclose');
		$booster_manualclose_text = essb_option_value('booster_manualclose_text');
		
		$booster_window_bg = essb_option_value('booster_window_bg');
		$booster_window_color = essb_option_value('booster_window_color');
		$booster_title = essb_option_value('booster_title');
		$booster_message = essb_option_value('booster_message');
		$booster_bg_image = essb_option_value('booster_bg_image');
		
		if ($booster_message != '') {
			$booster_message = stripslashes($booster_message);
			$booster_message = do_shortcode($booster_message);
		}
		
		if ($booster_manualclose_text == '') {
			$booster_manualclose_text = __('I am not interested. Take me back to content', 'essb');
		}
		
		$custom_styles = "";
		
		if ($booster_window_bg != '') {
			$custom_styles .= 'background-color:'.$booster_window_bg.';';
		}
		
		if ($booster_window_color != '') {
			$custom_styles .= 'color:'.$booster_window_color.';';
		}
		if ($booster_bg_image != '') {
			$custom_styles .= 'background-image: url('.esc_url($booster_bg_image).');background-size: cover; background-position: center;';
		}
		
		if ($custom_styles != '') {
			$custom_styles = ' style="'.$custom_styles.'"';
		}
		
		$output .= '<div class="essb-sharebooster" data-trigger="'.$booster_trigger.'" data-trigger-time="'.$booster_time.
			'" data-trigger-scroll="'.$booster_scroll.'" data-donotshow="'.$booster_donotshow.'" data-donotshowon="'.$booster_donotshow_on.
			'" data-autoclose="'.$booster_autoclose.'"'.$custom_styles.'>';
		
		if ($booster_title != '') {
			$output .= '<h3 class="essb-sharebooster-title">'.$booster_title.'</h3>';
		}
		
		if ($booster_message != '') {
			$output .= '<div class="essb-sharebooster-message">'.$booster_message.'</div>';
		}
		
		$output .= '<div class="essb-sharebooster-buttons">'.$share_buttons.'</div>';
		
		if ($booster_manualclose) {
			$output .= '<div class="essb-sharebooster-close">'.$booster_manualclose_text.'</div>';
		}
		
		if ($booster_autoclose != '') {
			$output .= '<div class="essb-sharebooster-autoclose">'.__('This window will automatically close in ', 'essb').$booster_autoclose.__(' seconds', 'essb').'</div>';
		}
		
		$output .= '</div>';
		
		$output .= '<div class="essb-sharebooster-overlay" '.($booster_bg != '' ? 'style="background-color: '.$booster_bg.';"' : '').'></div>';
		
		return $output;
	}
	
	
}
