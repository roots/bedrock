<?php

// Shortcode init


function vntd_accordion_init()
{
	add_action('cs_init_bilder', 'vntd_accordion_init_info');
	//add_action('cs_init_shortcode','vntd_toggle_init_bilder');
}

add_action('wp_cs_init','vntd_accordion_init');


// Shortcode Builder


function vntd_accordion_init_info()
{
	cs_show_bilder(
		'accordion',
		'Accordion',
		'Just a accordion. What else can I say?',
		''
	);
}


// Shortcode Processing

function vntd_accordions($atts, $content = null) {	
	return '<div class="vntd-accordions">'.vntd_do_shortcode($content).'</div>';
}
remove_shortcode('accordions');
add_shortcode('accordions', 'vntd_accordions'); 


function vntd_accordion($atts, $content = null) {
	extract(shortcode_atts(array(
		"title" => ''
	), $atts));
	
	return '<div class="vntd-accordion"><h4 class="vntd-accordion-title">'.$title.'</h4><div class="vntd-accordion-content">'.vntd_do_shortcode($content).'</div></div>';
}
remove_shortcode('accordion');
add_shortcode('accordion', 'vntd_accordion'); 