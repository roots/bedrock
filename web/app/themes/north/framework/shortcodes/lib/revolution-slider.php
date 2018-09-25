<?php

// Shortcode Processing


function vntd_revslider($atts, $content=null){
	extract(shortcode_atts(array(
		"alias" => ''
	), $atts));

	return do_shortcode('[rev_slider '.$alias.']');
}
add_shortcode('revslider', 'vntd_revslider');


function vntd_composer_revslider($atts, $content=null){
	extract(shortcode_atts(array(
		"alias" => ''
	), $atts));

	global $post;
	$layout = get_post_meta($post->ID, 'page_layout', true);
	$content_class = "span9";
	if($layout == "fullwidth") $content_class = "span12";
	if($layout != "fullwidth") $sidebar_class = "page-sidebar";
	
	$return .= '</div></div></div></div>';
	$return .= do_shortcode('[rev_slider '.$alias.']');
	
	$return .= '<div class="vntd-container after-rev"><div class="page-content row '.$layout.' '.$sidebar_class.'"><div class="content-wrap '.$content_class.'">';
	
	return $return;
}
add_shortcode('composer_revslider', 'vntd_composer_revslider');