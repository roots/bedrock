<?php
/**
 * EasySocialShareButtons DisplayMethod: BottomBar
 *
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2016 AppsCreo
 * @since 3.6
 *
 */

class ESSBDisplayMethodBottomBar {
	public static function generate_bottombar_code($options, $share_buttons, $is_shortcode, $shortcode_options = array()) {
		$output = '';
		
		$bottombar_content_area = ESSBOptionValuesHelper::options_bool_value($options, 'bottombar_contentarea');
		$bottombar_content_area_pos = ESSBOptionValuesHelper::options_value($options, 'bottombar_contentarea_pos');
		$bottombar_usercontent = ESSBOptionValuesHelper::options_value($options, 'bottombar_usercontent');
		$bottombar_buttons_align = ESSBOptionValuesHelper::options_value($options, 'bottombar_buttons_align', 'left');
			
		if ($is_shortcode) {
			if (!empty($shortcode_options['bottombar_contentarea'])){
				$bottombar_contentarea = ESSBOptionValuesHelper::unified_true($shortcode_options['bottombar_contentarea']);
			}
			if (!empty($shortcode_options['bottombar_contentarea_pos'])) {
				$bottombar_contentarea_pos = $shortcode_options['bottombar_contentarea_pos'];
			}
			if (!empty($shortcode_options['bottombar_buttons_align'])) {
				$bottombar_buttons_align = $shortcode_options['bottombar_buttons_align'];
			}
			if (!empty($shortcode_options['bottombar_usercontent'])) {
				$bottombar_usercontent = $shortcode_options['bottombar_usercontent'];
			}
		}
			
		$bottombar_usercontent = stripslashes($bottombar_usercontent);
		$bottombar_usercontent = do_shortcode($bottombar_usercontent);
		
		if ($bottombar_usercontent != '') {
			$bottombar_usercontent = preg_replace(array('#%%title%%#', '#%%siteurl%%#', '#%%permalink%%#'), array(get_the_title(), get_site_url(), get_permalink()), $bottombar_usercontent);
		
			$bottombar_usercontent = essb_post_details_to_content($bottombar_usercontent);
		}
				
		$ssbuttons = $share_buttons;		
		
		$output .= '<div class="essb_bottombar">';
		$output .= '<div class="essb_bottombar_inner">';
		
		if (!$bottombar_content_area) {
			$output .= sprintf('<div class="essb_bottombar_inner_buttons essb_bar_withoutcontent essb_bottombar_align_%1$s">', $bottombar_buttons_align);
			$output .= $ssbuttons;
			$output .= '</div>';
		}
		else {
			if ($bottombar_content_area_pos == "left") {
				$output .= '<div class="essb_bottombar_inner_content">';
				$output .= stripslashes($bottombar_usercontent);
				$output .= '</div>';
				$output .= sprintf('<div class="essb_bottombar_inner_buttons essb_bottombar_align_%1$s">', $bottombar_buttons_align);
				$output .= $ssbuttons;
				$output .= '</div>';
			}
			else {
				$output .= sprintf('<div class="essb_bottombar_inner_buttons essb_bottombar_align_%1$s">', $bottombar_buttons_align);
				$output .= $ssbuttons;
				$output .= '</div>';
				$output .= '<div class="essb_bottombar_inner_content">';
				$output .= stripslashes($bottombar_usercontent);
				$output .= '</div>';
			}
		}
		$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
}