<?php
if (!function_exists('essb_shortcode_share_popup_prepare')) {
	function essb_shortcode_share_popup_prepare($atts) {
		$shortcode_options = array();
		
		if (is_array($atts)) {
			$flyin_title = essb_object_value($atts, 'popup_title');
			$flyin_message = essb_object_value($atts, 'popup_message');
			$flyin_percent = essb_object_value($atts, 'popup_percent');
			$flyin_end = essb_object_value($atts, 'popup_end');
		
			foreach ($atts as $key => $value) {
				if ($key != 'popup_title' && $key != 'popup_message' && $key != 'popup_percent' && $key != 'popup_end') {
					$shortcode_options[$key] = $value;
				}
			}
		
			$shortcode_options['extended_popup_title'] = $flyin_title;
			$shortcode_options['extended_popup_message'] = $flyin_message;
			$shortcode_options['extended_popup_percent'] = $flyin_percent;
			$shortcode_options['extended_popup_end'] = $flyin_end;
		}
		
		$shortcode_options['popup'] = "yes";
		
		return $shortcode_options;
	}
}