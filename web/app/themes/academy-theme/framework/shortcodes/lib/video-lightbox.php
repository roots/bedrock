<?php

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		Video Lightbox
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

function vntd_video_lightbox($atts, $content = null) {
	extract(shortcode_atts(array(
		"link" => '',
		"label" => '6'		
	), $atts));	
	
	wp_enqueue_script('magnific-popup', '', '', '', true);
	wp_enqueue_style('magnific-popup');
	
	$output = '<div class="video-lightbox"><a href="'.$link.'" class="video-link mp-video"><i class="fa fa-play fa-2x round"></i><h3 class="font-secondary">'.$label.'</h3></a></div>';    
	
	return $output;
	
}
remove_shortcode('video_lightbox');
add_shortcode('video_lightbox', 'vntd_video_lightbox');