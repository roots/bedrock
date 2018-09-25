<?php

// Icon Box Shortcode

if ( !function_exists( 'vntd_icon_box' ) ) {
	function vntd_icon_box($atts, $content = null) {
		
		$defaultFont = 'fontawesome';
		$defaultIconClass = 'fa fa-info-circle';
		
		extract(shortcode_atts(array(
			"icon" => 'heart-o',
			"icon_type" => $defaultFont,
			"icon_fontawesome" => $defaultIconClass,
			"icon_typicons" => '',
			"icon_openiconic" => '',
			"icon_entypo" => '',
			"icon_linecons" => '',
			"style" => 'default',
			"title" => '',
			"text" => '',	
			"url" => '',	
			"target" => '_self',
			"text_style" => 'fullwidth',
			"link_title" => 'More Info',
			"animated" => '',
			"animation_delay" => 100			
		), $atts));
		
		$icon = str_replace('fa-','',$icon);
		
		vc_icon_element_fonts_enqueue( $icon_type );
		
		$iconClass = isset( ${"icon_" . $icon_type} ) ? ${"icon_" . $icon_type} : $defaultIconClass;
		
		$defaultIconClass = 'fa ' . $icon;
		
		$aligned_class = ' box';
		if($style == 'left' || $style == 'right') $aligned_class = ' feature-box';
		
		$animated_class = $animated_data = '';
		
		if($animated != 'no') {
			$animated_class = North::get_animated_class();
			$animated_data = ' data-animation="fadeIn" data-animation-delay="' . $animation_delay . '"';
		}
		
		$output = '<div class="vntd-icon-box icon-box-'.$style.$animated_class.$aligned_class.'"'.$animated_data.'>';
		
		if($style == 'centered') {
		
			$output .= '<a target="'.$target.'" title="'.$title.'" class="icon-box-icon about-icon">';
			$output .= '<i class="'.$iconClass.'"></i>';
			$output .= '</a>';
			if($title) $output .= '<h3 class="icon-box-title uppercase normal font-primary">'.$title.'</h3>';	
			$output .= '<p class="icon-description">'.$text.'</p>';
			if($url) $output .= '<a href="'.$url.'" target="'.$target.'" title="'.$title.'">'.$link_title.'</a>';	
		
		} elseif($style == 'default' || !$style) {	
		
			$output .= '<div class="left-icon f-left"><a href="'.$url.'" class="round"><i class="'.$iconClass.'"></i></a></div>';
			$output .= '<div class="right-desc f-left"><h3 class="box-head dark">'.$title.'</h3>';
			$output .= '<p class="box-desc dark">'.$text.'</p></div>';
		
		} else {	
		
			$output .= '<a href="'.$url.'" target="'.$target.'" title="'.$title.'" class="box-icon">';
			$output .= '<i class="'.$iconClass.'"></i></a>';
			$output .= '<div class="feature-texts"><h3 class="box-head uppercase">'.$title.'</h3>';
			$output .= '<p class="box-desc semibold">'.$text.'</p></div>';
		
		}
		
		$output .= '</div>';
		
		return $output;
		
	}
	remove_shortcode('icon_box');
	add_shortcode('icon_box', 'vntd_icon_box');
}