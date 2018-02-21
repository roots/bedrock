<?php
/**
 * EasySocialShareButtons CoreExtender: Shortcode TotalShares
 *
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2016 AppsCreo
 * @since 3.6
 *
 */

class ESSBCoreExtenderShortcodeTotalShares {

	public static function parse_shortcode($atts, $options, $network_list = array()) {
		global $post;
		
		$atts = shortcode_atts(array(
				'message' => '',
				'align' => '',
				'url' => '',
				'share_text' => '',
				'fullnumber' => 'no',
				'networks' => '',
				'inline' => 'no',
				'postid' => ''
		), $atts);
		
		$align = isset($atts['align']) ? $atts['align'] : '';
		$message = isset($atts['message']) ? $atts['message'] : '';
		$url = isset($atts['url']) ? $atts['url'] : '';
		$share_text = isset($atts['share_text']) ? $atts['share_text'] : '';
		$fullnumber = isset($atts['fullnumber']) ? $atts['fullnumber'] : 'no';
		$networks = isset($atts['networks']) ? $atts['networks'] : 'no';
		$inline = isset($atts['inline']) ? $atts['inline'] : 'no';
		$postid = isset($atts['postid']) ? $atts['postid'] : '';
		
		$data_full_number = "false";
		if ($fullnumber == 'yes') {
			$data_full_number = "true";
		}
		
		
		if ($networks != '') {
			$buttons = $networks;
		}
		else {
			$buttons = implode(',', $network_list);
		}
		
		
		$css_class_align = "";
		
		$data_url = $post ? get_permalink() : essb_get_current_url( 'raw' );
		
		if (ESSBOptionValuesHelper::options_bool_value($options, 'avoid_nextpage')) {
			$data_url = $post ? get_permalink(get_the_ID()) : essb_get_current_url( 'raw' );
		}
		
		if (ESSBOptionValuesHelper::options_bool_value($options, 'force_wp_fullurl')) {
			$data_url = essb_get_current_page_url();
		}
		
		if (ESSBOptionValuesHelper::options_bool_value($options, 'always_use_http')) {
			$data_url = str_replace("https://", "http://", $data_url);
		}
		
		if ($url != '' ) {
			$data_url = $url;
		}
		
		$data_post_id = "";
		if (isset($post)) {
			$data_post_id = $post->ID;
		}
		
		if ($postid != '') {
			$data_post_id = $postid;
		}
		
		if ($align == "right" || $align == "center") {
			$css_class_align = $align;
		}
		
		$total_counter_hidden = ESSBOptionValuesHelper::options_value($options, 'total_counter_hidden_till');
		
		// @since 3.3 support for cached counters
		$cached_counters = array();
		$cached_counters_active = false;
		$cached_total_counter = '';
		if (defined('ESSB3_CACHED_COUNTERS')) {
			$share_options = array('url' => $data_url, 'full_url' => $data_url);
			$cached_counter_networks = ESSBCachedCounters::prepare_list_of_networks_with_counter(explode(',', $buttons), explode(',', $buttons));
			$cached_counters = ESSBCachedCounters::get_counters($data_post_id, $share_options, $cached_counter_networks);
			$cached_counters_active = true;
		}
		else {
			$use_minifed_js = (ESSBGlobalSettings::$use_minified_js) ? ".min" : "";
			$script_url = ESSB3_PLUGIN_URL .'/assets/js/easy-social-share-buttons-total'.$use_minifed_js.'.js';
			essb_resource_builder()->add_static_resource_footer($script_url, 'easy-social-share-buttons-total', 'js');
		}
		$css_hide_total_counter = "";
		if ($total_counter_hidden != '') {
			$css_hide_total_counter = ' style="display: none !important;" data-essb-hide-till="' . $total_counter_hidden . '"';
		}
		
		if ($cached_counters_active) {
			$cached_total_counter = isset($cached_counters['total']) ? $cached_counters['total'] : '0';
		
			if ($total_counter_hidden != '') {
				if (intval($cached_total_counter) > intval($total_counter_hidden)) {
					$css_hide_total_counter = "";
				}
			}
			$cached_total_counter = essb_kilomega($cached_total_counter);
		}
		
		$output = "";
		
		$tag = ($inline == 'yes') ? 'span' : 'div';
		
		$output .= '<'.$tag.' class="essb-total '.$css_class_align.'" data-network-list="'.$buttons.'" data-url="'.$data_url.'" data-full-number="'.$data_full_number.'" data-post="'.$data_post_id.'" '.$css_hide_total_counter.'>';
		
		if ($message != '') {
			$output .= '<'.$tag.' class="essb-message essb-block">'.$message.'</'.$tag.'>';
		}
		
		$output .= '<'.$tag.' class="essb-total-value essb-block">'.$cached_total_counter.'</'.$tag.'>';
		if ($share_text != '') {
			$output .= '<'.$tag.' class="essb-total-text essb-block">'.$share_text.'</'.$tag.'>';
		}
		
		$output .= '</'.$tag.'>';
		
		
		return $output;
		
	}
}