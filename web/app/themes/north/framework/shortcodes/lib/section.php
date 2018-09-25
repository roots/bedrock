<?php

// Shortcode Processing

function vntd_fullscreen($atts, $content=null) {
	extract(shortcode_atts(array(
		"bg_color" => '',
		"border" => '',
		"border_color" => '',
		"bg_image" => '',
		"bg_size" => '',
		"text_color" => '',
		"parallax" => ''
	), $atts));
	
	$return .= '<div class="sc-fullscreen';
	if($parallax == "yes") $return .= ' sc-parallax';
	if($text_color) $text_color_class = 'color:'.$text_color.' !important;';
	
	$return .= '" style="background-color:'.$bg_color.';'.$text_color_class;
	
	if($border == "no")	$return .= 'border:none;';	
	if($border_color) $return .= 'border-color:'.$border_color.';';	
	
	if($bg_image) {
		if (strpos($bg_image,'http') == false) {
		    $bg_image = wp_get_attachment_image_src($bg_image, "fullsize");
		    $bg_image = $bg_image[0];
		}
	}
	
	if($bg_image) $return .= 'background-image:url('.$bg_image.');';	
	if($bg_size == '100%') $return .= 'background-size:100%;';
	
	$return .= '"><div class="fullscreen-content">';
	$return .= do_shortcode($content).'</div></div>';
	
	return $return;
}
add_shortcode('vc_color', 'vntd_fullscreen');  