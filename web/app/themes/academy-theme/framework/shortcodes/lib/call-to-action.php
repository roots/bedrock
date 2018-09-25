<?php

function vntd_cta($atts, $content=null) {
	extract(shortcode_atts(array(
		"button1_title" => 'Click me!',
		"button1_subtitle" => '',
		"button1_url" => 'http://',
		"button2_title" => '',
		"button2_subtitle" => '',
		"button2_url" => '',	
		"heading_color" => '',	
		"text_color" => '',
		"button_color" => 'dark',
		"style" => 'default',
		"subtitle" => 'Feel free to change the subtitle!',
		"heading" => 'Example Heading',
		"margin_bottom" => '0',
		"extra_class" => '',
		"buttons_target" => '_self'
	), $atts));
	
		
	$bg_color = $custom_button_color = $return = $fullwidth_class = '';
	$extra_class = ' style="';
	$extra_color_class = '';

	if($bg_color) { $extra_class .= 'background-color:'.$bg_color.';'; }
	
	if($margin_bottom != 30) { $extra_class .= 'margin-bottom:'.$margin_bottom.'px;'; }
	
	$extra_class = '"';
	
	if($text_color) { $extra_color_class = ' style="color:'.$text_color.' !important;"'; }
	if($heading_color) { $extra_heading_color_class = ' style="color:'.$heading_color.' !important;"'; }
	
	$subtitle_extra_class = ' cta-no-subtitle';	
	$button2 = '';
	
	if( $subtitle ) {
		$subtitle = '<p class="subtitle-text"' . $extra_color_class . '>' . $subtitle . '</p>';
		$subtitle_extra_class = '';
	}
	
	if($button2_title) {
		$button2 = '<a href="'.$button2_url.'" target="' . esc_attr( $buttons_target ) . '" class="page-content-button scroll font-primary uppercase white">'.$button2_title.'</a>';
	}
	
	$button_color_class = 'vntd-button-dark';
	if($button_color == 'white') $button_color_class = 'vntd-button-white';
	
	$return .= '<div class="vntd-cta vntd-cta-style-'.$style.'">';
	
	if($style != 'centered') {
	
		$return .= '<div class="content-left white'.$subtitle_extra_class.'"><h1 class="content-head"' . $extra_heading_color_class . '>'.$heading.'</h1>'.$subtitle.'</div>';
		
		// CTA Buttons
		
		if( $button1_title || $button2_title ) {
		
			$return .= '<div class="content-right white">';
			
			if( $button1_title ) {
				$return .= '<a href="'.$button1_url.'" target="' . esc_attr( $buttons_target ) . '" class="page-content-button scroll font-primary uppercase white">'.$button1_title.'</a>';
			}
			
			if( $button2_title ) $return .= $button2;
			
			$return .= '</div>';
			
		}
	
	} else {
	
		$return .= '<h1 class="f-head mini-header"' . $extra_heading_color_class . '>'.$heading.'</h1>';
		$return .= '<p class="f-text">'.$subtitle.'</p>';
		
		// Button 1
		
		if( $button1_title ) {
			$return .= '<a href="'.$button1_url.'" target="' . esc_attr( $buttons_target ) . '" class="vntd-cta-button scroll '.$button_color_class.'"><h3>'.$button1_title.'</h3>';
			if($button1_subtitle) $return .= '<p class="semibold">'.$button1_subtitle.'</p>';
			$return .= '</a>';
		}
		
		
		// Button 2
		
		if($button2_title) {
			$return .= '<a href="'.$button2_url.'" target="' . esc_attr( $buttons_target ) . '" class="vntd-cta-button scroll '.$button_color_class.'"><h3>'.$button2_title.'</h3>';
			if($button2_subtitle) $return .= '<p class="semibold">'.$button2_subtitle.'</p>';
			$return .= '</a>';
		}
		
	}
	
	$return .= '</div>';
	
	return $return;
}
remove_shortcode('cta');
add_shortcode('cta', 'vntd_cta');  