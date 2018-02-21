<?php
if (!function_exists('essb_shortcode_share_flyin_prepare')) {
	function essb_shortcode_share_flyin_prepare($atts) {
		$shortcode_options = array();
		
		if (is_array($atts)) {
			$flyin_title = essb_object_value($atts, 'flyin_title');
			$flyin_message = essb_object_value($atts, 'flyin_message');
			$flyin_percent = essb_object_value($atts, 'flyin_percent');
			$flyin_end = essb_object_value($atts, 'flyin_end');
				
			foreach ($atts as $key => $value) {
				if ($key != 'flyin_title' && $key != 'flyin_message' && $key != 'flyin_percent' && $key != 'flyin_end') {
					$shortcode_options[$key] = $value;
				}
			}
				
			$shortcode_options['extended_flyin_title'] = $flyin_title;
			$shortcode_options['extended_flyin_message'] = $flyin_message;
			$shortcode_options['extended_flyin_percent'] = $flyin_percent;
			$shortcode_options['extended_flyin_end'] = $flyin_end;
		}
		
		$shortcode_options['flyin'] = "yes";
		
		return $shortcode_options;
	}
}