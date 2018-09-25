<?php

// Counter Shortcode Processing

function vntd_counter($atts, $content=null){
	extract(shortcode_atts(array(
		"title" => 'Days',
		"number" => '100'
	), $atts));
	
	$return = '<div class="fact colored" data-perc="'.$number.'"><h1 class="factor"></h1><h3>'.$title.'</h3></div>';
	
	return $return;
}
remove_shortcode('counter');
add_shortcode('counter', 'vntd_counter');