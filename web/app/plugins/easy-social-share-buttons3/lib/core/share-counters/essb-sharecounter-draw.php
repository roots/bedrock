<?php
/**
 * Share counter drawing functions
 *
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2017 AppsCreo
 * @since 4.2
 *
 */

function essb_draw_share_counter_code($position, $counter, $counter_hidden) {

	$css_hidden_negative = "";

	if ($counter_hidden != '') {
		if (intval($counter_hidden) > intval($counter)) {
			$css_hidden_negative = ' style="display: none;"';
		}
	}

	$counter_short = "";
	$original_counter_short = "";
	
	if ($position != "hidden" && $position != "_hidden") {
		$counter_short = essb_kilomega_format($counter, 'button');
		$original_counter_short = $counter_short;
	}
	
	$animante_counter = essb_option_bool_value('animate_single_counter');
	if (essb_is_mobile()) {
		$animante_counter = false;
	}
	if ($animante_counter && intval($counter) > 0 && $position != "hidden" && $position != "_hidden") {
		$counter_short = '&nbsp;';
		
		$position .= ' essb_animated';
	}

	return '<span class="essb_counter'.$position.'" data-cnt="' .$counter. '"'.$css_hidden_negative.' data-cnt-short="'.$original_counter_short.'">' .$counter_short. '</span>';
}