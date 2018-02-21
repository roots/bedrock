<?php
if (!function_exists('essb_rs_css_build_fullwidth_buttons')) {
	function essb_rs_css_build_fullwidth_buttons($number_of_buttons, $container_width, $buttons_correction_width, $first_button = '', $second_button = '') {
		$button_width = intval($container_width) / intval($number_of_buttons);
		$button_width = floor($button_width);
				
		$main_class = 'essb_fullwidth_'.$button_width.'_'.$buttons_correction_width.'_'.$container_width;
		
		if (intval($first_button) != 0 || intval($second_button) != 0) {
			$recalc_count = intval($number_of_buttons);
			$recalc_container_width = intval($container_width);
			
			if (intval($first_button) != 0) {
				$recalc_count--;
				$recalc_container_width -= intval($first_button);
			}

			if (intval($second_button) != 0) {
				$recalc_count--;
				$recalc_container_width -= intval($second_button);
			}
			
			$button_width = intval($recalc_container_width) / intval($recalc_count);
			$button_width = floor($button_width);
		}
		
		$snippet = '';
		
		$snippet .= (sprintf('.%1$s { width: %2$s;}', $main_class, $container_width.'%'));
		$snippet .= (sprintf('.%1$s .essb_links_list { width: %2$s;}', $main_class, '100%'));
		$snippet .= (sprintf('.%1$s li { width: %2$s;}', $main_class, $button_width.'%'));
		$snippet .= (sprintf('.%1$s li.essb_totalcount_item_before { width: %2$s;}', $main_class, '100%'));
		$snippet .= (sprintf('.%1$s li a { width: %2$s;}', $main_class, $buttons_correction_width.'%'));

		if (intval($first_button) != 0) {
			$snippet .= (sprintf('.%1$s li.essb_item_fw_first { width: %2$s;}', $main_class, $first_button.'%'));
		}
		if (intval($second_button) != 0) {
			$snippet .= (sprintf('.%1$s li.essb_item_fw_second { width: %2$s;}', $main_class, $second_button.'%'));
		}
				
		return $snippet;
	}
}