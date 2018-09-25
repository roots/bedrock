<?php

// Shortcode Processing

function vntd_pricing_box($atts, $content) {
	extract(shortcode_atts(array(
		"featured" => '',
		"title" => '',
		"features" => 'no',
		"button_label" => 'Buy Now',
		"period" => 'per year',
		"price" => '$99',
		"button_url" => '',
		"animated" => 'yes',
		"animation_delay" => '100'
	), $atts));
	
	$animated_class = $animation_data = $featured_class = '';
	
	if($animated != 'no') {
		$animated_class = North::get_animated_class();
		$animated_data = ' data-animation="fadeIn" data-animation-delay="'.$animation_delay.'"';
	}
	
	if($featured == 'yes') { $featured_class = " active"; }
	
	$features_arr = explode(',',$features);	
	
	$output = '<div class="vntd-pricing-box p-table'.$featured_class.$animated_class.'"'.$animated_data.'>';	
	$output .= '<h1>'.$price.'<span>'.$period.'</span></h1><h3>'.$title.'</h3>';
	$output .= '<ul class="properties">';
	
	foreach($features_arr as $single_feature) {
		$output .= '<li>'.$single_feature.'</li>';
	}
	
	if(!$button_url) $button_url = '#';
	
	$output .= '<a href="'.$button_url.'" target="_blank" class="p-button">'.$button_label.'</a>';

	$output .= '</div>';
	
	return $output;
	
}
remove_shortcode('pricing_box');
add_shortcode('pricing_box', 'vntd_pricing_box');  