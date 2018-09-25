<?php

// List Shortcode Processing

function vntd_list($atts, $content=null) {
	extract(shortcode_atts(
		array(
		"icon" => 'check',
		"color" => 'accent',
		"background" => ''
		), $atts)
	);
	
	$background_class = '';
	
	if($background == 'yes') {
		$background_class = 'vntd-list-bg';
	}
	
	return '<ul class="vntd-list vntd-list-'.$color.' '.$background_class.'">'.vntd_do_shortcode($content).'</ul>';
}

function vntd_li($atts, $content=null) {	
	return '<li><i class="fa fa-angle-right"></i> '.$content.'</li>';
}

remove_shortcode('list');
remove_shortcode('li');
add_shortcode('list', 'vntd_list');
add_shortcode('li', 'vntd_li');