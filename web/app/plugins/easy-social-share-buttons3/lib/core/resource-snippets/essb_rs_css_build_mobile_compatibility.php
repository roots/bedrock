<?php
if (!function_exists('essb_rs_css_build_mobile_compatibility')) {
	add_filter('essb_css_buffer_head', 'essb_rs_css_build_mobile_compatibility');
	
	function essb_rs_css_build_mobile_compatibility($buffer) {
		global $essb_options;
		
		$mobile_css_screensize = ESSBOptionValuesHelper::options_value($essb_options, 'mobile_css_screensize');
		if (empty($mobile_css_screensize)) {
			$mobile_css_screensize = "750";
		}
		$mobile_css_readblock = ESSBOptionValuesHelper::options_bool_value($essb_options, 'mobile_css_readblock');
		$mobile_css_all = ESSBOptionValuesHelper::options_value($essb_options, 'mobile_css_all');
		$mobile_css_optimized = ESSBOptionValuesHelper::options_bool_value($essb_options, 'mobile_css_optimized');
		
		$snippet = '';
		
		if ($mobile_css_readblock) {
			$snippet .= ('@media screen and (max-width: '.$mobile_css_screensize.'px) { .essb_links.essb_displayed_sidebar, .essb_links.essb_displayed_sidebar_right, .essb_links.essb_displayed_postfloat { display: none; } }');
		}
		if ($mobile_css_all) {
			$snippet .= ('@media screen and (max-width: '.$mobile_css_screensize.'px) { .essb_links { display: none; } }');
		}
		
		if ($mobile_css_optimized) {
			$snippet .= ('@media screen and (max-width: '.$mobile_css_screensize.'px) { .essb-mobile-sharebar, .essb-mobile-sharepoint, .essb-mobile-sharebottom, .essb-mobile-sharebottom .essb_links, .essb-mobile-sharebar-window .essb_links, .essb-mobile-sharepoint .essb_links { display: block; } }');
			$snippet .= ('@media screen and (max-width: '.$mobile_css_screensize.'px) { .essb-mobile-sharebar .essb_native_buttons, .essb-mobile-sharepoint .essb_native_buttons, .essb-mobile-sharebottom .essb_native_buttons, .essb-mobile-sharebottom .essb_native_item, .essb-mobile-sharebar-window .essb_native_item, .essb-mobile-sharepoint .essb_native_item { display: none; } }');
			$snippet .= ('@media screen and (min-width: '.$mobile_css_screensize.'px) { .essb-mobile-sharebar, .essb-mobile-sharepoint, .essb-mobile-sharebottom { display: none; } }');
		}
		else {
			$snippet .= (' .essb-mobile-sharebar, .essb-mobile-sharepoint, .essb-mobile-sharebottom { display: none; } ');
		
		}
		
		return $buffer.$snippet;
	}
}