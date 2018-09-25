<?php

// Shortcode Processing


function vntd_button($atts, $content = null) {
	extract(shortcode_atts(array(
		"label" => 'Text on the button',
		"url" => '',
		"target" => '_self',
		"color" => 'accent',
		"custom_color" => '',
		"size" => 'regular',
		"scroll" => '',
		"align" => ''
	), $atts));		
	
	$custom_style = $scroll_class = $align_class = '';
	
	if($color == "custom") {
		$custom_style .= 'background-color:'.$customcolor.';border-color:'.$customcolor.';';
	} elseif(strpos($color,'#') !== false) {
		$custom_style .= 'background-color:'.$color.';border-color:'.$color.';';
	}
	
	if($align == 'center') {
		$align_class = ' btn-center';
	}
	
	if($scroll == 'yes') $scroll_class = ' scroll';
	
	// Button Size
	$size_class = '';
	if($size == 'large') {
		$size_class = ' btn-lg';
	} elseif($size == 'small') {
		$size_class = ' btn-sm';
	} elseif($size == 'tiny' || $size == 'extra-small' || $size == 'extrasmall') {
		$size_class = ' btn-xs';
	}
	
	return '<a href="'.$url.'" class="btn btn-'.$color.$size_class.$scroll_class.$align_class.'" target="'.$target.'"'.$custom_style.'>'.$label.'</a>';

}
remove_shortcode('button');
add_shortcode('button', 'vntd_button');