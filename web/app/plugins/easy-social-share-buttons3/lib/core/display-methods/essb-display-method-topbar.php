<?php
/**
 * EasySocialShareButtons DisplayMethod: TopBar
 *
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2016 AppsCreo
 * @since 3.6
 *
 */

class ESSBDisplayMethodTopBar {
	public static function generate_topbar_code($options, $share_buttons, $is_shortcode, $shortcode_options = array()) {
		$output = '';
		
		$topbar_content_area = ESSBOptionValuesHelper::options_bool_value($options, 'topbar_contentarea');
		$topbar_content_area_pos = ESSBOptionValuesHelper::options_value($options, 'topbar_contentarea_pos');
		$topbar_buttons_align = ESSBOptionValuesHelper::options_value($options, 'topbar_buttons_align', 'left');
		$topbar_usercontent = ESSBOptionValuesHelper::options_value($options, 'topbar_usercontent');
		
		if ($is_shortcode) {
			if (!empty($shortcode_options['topbar_contentarea'])){
				$topbar_content_area = ESSBOptionValuesHelper::unified_true($shortcode_options['topbar_contentarea']);
			}
			if (!empty($shortcode_options['topbar_contentarea_pos'])) {
				$topbar_contentarea_pos = $shortcode_options['topbar_contentarea_pos'];
			}
			if (!empty($shortcode_options['topbar_buttons_align'])) {
				$topbar_buttons_align = $shortcode_options['topbar_buttons_align'];
			}
			if (!empty($shortcode_options['topbar_usercontent'])) {
				$topbar_usercontent = $shortcode_options['topbar_usercontent'];
			}
		}
			
		$topbar_usercontent = stripslashes($topbar_usercontent);
		$topbar_usercontent = do_shortcode($topbar_usercontent);
		
		if ($topbar_usercontent != '') {
			$topbar_usercontent = preg_replace(array('#%%title%%#', '#%%siteurl%%#', '#%%permalink%%#'), array(get_the_title(), get_site_url(), get_permalink()), $topbar_usercontent);
		
			$topbar_usercontent = essb_post_details_to_content($topbar_usercontent);
		}
			
		
		$ssbuttons = $share_buttons;
			
		$output = '';
			
		$output .= '<div class="essb_topbar">';
		$output .= '<div class="essb_topbar_inner">';
			
		if (!$topbar_content_area) {
			$output .= sprintf('<div class="essb_topbar_inner_buttons essb_bar_withoutcontent essb_topbar_align_%1$s">', $topbar_buttons_align);
			$output .= $ssbuttons;
			$output .= '</div>';
		}
		else {
			if ($topbar_content_area_pos == "left") {
				$output .= '<div class="essb_topbar_inner_content">';
				$output .= stripslashes($topbar_usercontent);
				$output .= '</div>';
				$output .= sprintf('<div class="essb_topbar_inner_buttons essb_topbar_align_%1$s">', $topbar_buttons_align);
				$output .= $ssbuttons;
				$output .= '</div>';
			}
			else {
				$output .= sprintf('<div class="essb_topbar_inner_buttons essb_topbar_align_%1$s">', $topbar_buttons_align);
				$output .= $ssbuttons;
				$output .= '</div>';
				$output .= '<div class="essb_topbar_inner_content">';
				$output .= stripslashes($topbar_usercontent);
				$output .= '</div>';
			}
		}
		$output .= '</div>';
		$output .= '</div>';
			
		return $output;
	}
}