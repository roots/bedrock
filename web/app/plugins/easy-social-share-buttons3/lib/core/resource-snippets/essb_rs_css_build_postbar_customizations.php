<?php
if (!function_exists('essb_rs_css_build_postbar_customizations')) {
	add_filter('essb_css_buffer_head', 'essb_rs_css_build_postbar_customizations');
	function essb_rs_css_build_postbar_customizations($buffer) {
		global $essb_options;
		
		$postbar_bgcolor = ESSBOptionValuesHelper::options_value($essb_options, 'postbar_bgcolor');
		$postbar_color = ESSBOptionValuesHelper::options_value($essb_options, 'postbar_color');
		$postbar_accentcolor = ESSBOptionValuesHelper::options_value($essb_options, 'postbar_accentcolor');
		$postbar_altcolor = ESSBOptionValuesHelper::options_value($essb_options, 'postbar_altcolor');
		
		$snippet = '';
		
		if ($postbar_bgcolor != '') {
			$snippet .= ('.essb-postbar .essb-postbar-container, .essb-postbar-prev-post .essb_prev_post, .essb-postbar-next-post .essb_next_post { background-color: '.$postbar_bgcolor.'!important;}');
		}
		
		if ($postbar_color != '') {
			$snippet .= ('.essb-postbar, .essb-postbar a, .essb-postbar-prev-post .essb_prev_post { color: '.$postbar_color.'!important;}');
			$snippet .= ('.essb-postbar-next-post .essb_next_post_info span.essb_title, .essb-postbar-prev-post .essb_prev_post_info span.essb_title {color: '.$postbar_color.'!important;} ');
		}
		
		if ($postbar_accentcolor != '') {
			$snippet .= ('.essb-postbar .essb-postbar-progress-bar{ background-color: '.$postbar_accentcolor.'!important;}');
			$snippet .= ('.essb-postbar .essb-postbar-category a { background-color: '.$postbar_accentcolor.'!important;}');
			$snippet .= ('.essb-postbar-next-post .essb_next_post_info span.essb_category, .essb-postbar-prev-post .essb_prev_post_info span.essb_category {background-color: '.$postbar_accentcolor.'!important; }');
			$snippet .= ('.essb-postbar-close-postpopup  {background-color: '.$postbar_accentcolor.'!important; }');
		}
		
		if ($postbar_altcolor != '') {
			$snippet .= ('.essb-postbar .essb-postbar-category a { color: '.$postbar_altcolor.'!important;}');
			$snippet .= ('.essb-postbar-next-post .essb_next_post_info span.essb_category, .essb-postbar-prev-post .essb_prev_post_info span.essb_category {color: '.$postbar_altcolor.'!important; }');
			$snippet .= ('.essb-postbar-close-postpopup  { color: '.$postbar_altcolor.'!important; }');
		}
		
		// postbar related code to move body below it
		$snippet .= ('body.single {margin-bottom: 46px !important;}');
		
		return $buffer.$snippet;
	}
}