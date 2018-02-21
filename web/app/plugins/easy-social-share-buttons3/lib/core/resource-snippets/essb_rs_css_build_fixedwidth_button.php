<?php
if (!function_exists('essb_rs_css_build_fixedwidth_button')) {
	function essb_rs_css_build_fixedwidth_button($salt, $width, $align) {
		$snippet = '';

		$main_class = sprintf('essb_fixedwidth_%1$s', $width.'_'.$align);
		
		$snippet .= sprintf('.%1$s a { width: %2$spx;}', $main_class, $width);
		if ($align == '') {
			$snippet .= sprintf('.%1$s a { text-align: center;}', $main_class);
		}
		if ($align == 'right') {
			$snippet .= sprintf('.%1$s .essb_network_name { float: right;}', $main_class);
		}		
		
		return $snippet;
	}
}