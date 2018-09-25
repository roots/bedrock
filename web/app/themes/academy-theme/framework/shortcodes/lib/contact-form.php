<?php

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		Contact Block
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

function vntd_contact_form($atts, $content = null) {
	extract(shortcode_atts(array(
		"id" => '',
		"animated" => 'no'
	), $atts));
	
	$social_icons = array('facebook','twitter','linkedin','instagram','youtube','pinterest','googleplus','tumblr','dribbble');
	
	//If the form is submitted	
	
	$output = '<div class="contact font-primary">';
	$output .= do_shortcode('[contact-form-7 id="'.$id.'"]');
	$output .= '</div>';
	
	return $output;
	
}
remove_shortcode('vntd_contact_form');
add_shortcode('vntd_contact_form', 'vntd_contact_form');