<?php
$output = $el_class = $bg_image = $bg_color = $bg_overlay_class = $bg_image_repeat = $section_class = $font_color = $padding = $margin_bottom = $css = $bg_rain = $video_bg = $vimeo = $full_height = $full_width = $equal_height = $content_placement = '';
$disable_element = '';
//extract(shortcode_atts(array(
//    'el_class'        	=> '',
//    'bg_image'        	=> '',
//    'bg_color'        	=> '',
//    'bg_image_repeat' 	=> '',
//    'font_color'      	=> '',
//    'padding'         	=> '',
//    'margin_bottom'   	=> '',
//    'css' 				=> '',
//    'el_id' 			=> '',
//    'color_scheme'		=> '',
//    'customcolor_heading' 	=> '',
//    'customcolor_text' 	=> '',
//    'bg_overlay'		=> '',
//    'content_width'		=> '',
//    'parallax'			=> '',
//    'fullscreen'		=> '',
//    'video'				=> '',
//    'video_autoplay'	=> 'true',
//    'video_controls'	=> 'true',
//    'video_mute'		=> 'true',
//    'bg_rain'			=> '',
//    'bg_rain_sound'		=> '',
//    'video_bg'			=> '',
//    'vimeo'				=> '',
//    'disable_element'   => 'no',
//), $atts));

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

//wp_enqueue_style('js_composer_front');
wp_enqueue_script('wpb_composer_front_js');
//wp_enqueue_style('js_composer_custom_css');

if(!$el_id) { 
	$el_id = rand(1,9999);
} else {
	$el_id = str_replace( " ", "_", esc_attr( $el_id ) );
}

$el_class = $this->getExtraClass($el_class);

$section_class = 'vntd-section-default';

if($color_scheme == 'white') {
	$section_class = 'vntd-section-white';
}elseif($color_scheme == 'custom') {
	$section_class = 'vntd-section-customcolors';
	$output .= '<style type="text/css"> #'.$el_id.' h1,#'.$el_id.' h2,#'.$el_id.' h3,#'.$el_id.' h4,#'.$el_id.' h5,#'.$el_id.' h6 { color: '.$customcolor_heading.'!important; } #'.$el_id.',#'.$el_id.' p { color: '.$customcolor_heading.'!important; } </style>';
}

$disabled_class = '';

if ( 'yes' === $disable_element ) {
	if ( vc_is_page_editable() ) {
		$css_classes[] = 'vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md';
		$disabled_class .= ' vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md ';
	} else {
		return '';
	}
}

if($bg_overlay == 'dark') {
	$bg_overlay_class = ' soft-bg';
}elseif($bg_overlay == 'darker') {
	$bg_overlay_class = ' soft-black-bg';
}elseif($bg_overlay == 'light') {
	$bg_overlay_class = ' soft-white-bg';
}elseif($bg_overlay == 'dots_dark') {
	$bg_overlay_class = ' pattern-black soft-black-bg';
}elseif($bg_overlay == 'dots_white') {
	$bg_overlay_class = ' pattern-white';
}

// Rainy Day

if($bg_rain == 'yes') {
	wp_enqueue_script('rainyday', '', '', '', true);	
}

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_row wpb_row '. ( $this->settings('base')==='vc_row_inner' ? 'vc_inner ' : '' ) . get_row_css_class() . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

$row_after = '';

global $post;

$content_fullwidth_class = '';
$section_width_class = ' section-default-width';
$container_class = '-fluid';
if($content_width == 'fullwidth') {
	$content_fullwidth_class = ' fullwidth';
	$section_width_class = ' section-fullwidth';	
}

// Parallax
$parallax_class = '';
if($parallax == 'yes') {
	$parallax_class = ' parallax';
}

// Page Layout 


$page_layout = get_post_meta(vntd_get_id(), 'page_layout', true);
if(!$page_layout || get_post_type(vntd_get_id()) == 'portfolio') $page_layout = 'fullwidth';

$row_content_before = '<div class="inner'.$content_fullwidth_class.'">';
$row_content_after = '</div>';

$page_width = get_post_meta(vntd_get_id(), 'page_width', true);
if(!$page_width) $page_width = 'content';

if(!is_page_template('template-onepager.php')) {
	if($page_width == 'content' || $page_layout != 'fullwidth') {
	
		// Default page.php 
		
		$row_content_before = '';
		$row_content_after = '';
		$container_class = '';
	
	}
}

if($fullscreen == 'yes') {
	$row_content_before = '';
	$row_content_after = '';
	$parallax_class .= ' p-section';
	$container_class = '';
}

//Background Video
$row_video_before = '';
if($video != '' && $video_bg == '' || $video_bg == 'youtube' && $video != '') { // 'video' stands for YouTube, backward naming convention compatibility
	wp_enqueue_script('YTPlayer');
	wp_enqueue_style('YTPlayer');
	
	$random_id = 'fullscreen-'.rand(1,9999);
	
	$video_id = $video;
	$row_video_before = '<div id="P2-'.$random_id.'" class="player video-container" data-property="{videoURL:\''.$video_id.'\',containment:\'#'.$el_id.' > div\',autoPlay:'.$video_autoplay.', showControls:'.$video_controls.', mute:'.$video_mute.', startAt:0,opacity:1}"></div>';
	
} elseif($video_bg == 'vimeo' && $vimeo != '') {

	wp_enqueue_script('vimeoBg');
	wp_enqueue_style('vimeoBg');
	wp_enqueue_script('jQueryUI');
	$autoplay = '1';
	
	if($video_autoplay == 'false') {
		$autoplay = '0';
	}
	$row_video_before = '<div class="vimeo-bg-player"><div class="myloader"></div><ul class="fullscreen_background_list">
			<li><img src="'.get_template_directory_uri().'/img/empty.png" width="1" height="1" /><iframe src="http://player.vimeo.com/video/'.$vimeo.'?title=0&amp;byline=0&amp;portrait=0&amp;autoplay='.$autoplay.'&amp;loop=1" width="100%" height="100%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></li></ul></div>';
			
}

$css_classes = array();

if ( ! empty( $full_height ) ) {
	$css_classes[] = 'vc_row-o-full-height';
	if ( ! empty( $columns_placement ) ) {
		$flex_row = true;
		$css_classes[] = 'vc_row-o-columns-' . $columns_placement;
		if ( 'stretch' === $columns_placement ) {
			$css_classes[] = 'vc_row-o-equal-height';
		}
	}
}

if ( ! empty( $equal_height ) ) {
	$flex_row = true;
	$css_classes[] = 'vc_row-o-equal-height';
}

if ( ! empty( $content_placement ) ) {
	$flex_row = true;
	$css_classes[] = 'vc_row-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
	$css_classes[] = 'vc_row-flex';
}

$style = $this->buildStyle($bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom);
$output .= '<section id="'.$el_id.'" class="container'.$container_class . ' ' . $disabled_class . $section_class.$section_width_class. '">';
if($bg_rain) {
	//put .= '<img class="rainy-background"  alt="background" src="" />';
	
	$output .= '<img id="background" class="rainy-background" alt="background" src="" />';
	
	if($bg_rain_sound == 'yes') {
		wp_enqueue_style('YTPlayer');
		$output .= '<audio class="audio-rain" loop="true"><source src="'.get_template_directory_uri() . '/includes/rain-sound.mp3"></audio>';
		$output .= '<span class="mb_YTVPBar bg-sound-controls"><div class="buttonBar"><span class="ytpicon bg-sound-volume">A</span></div></span>';
	}
}
$output .= '<div class="'.$css_class.$bg_overlay_class.$parallax_class.' ' . implode( ' ', $css_classes ) . '"'.$style.'>';
$output .= $row_video_before;
$output .= $row_content_before;
$output .= wpb_js_remove_wpautop($content);
$output .= $row_content_after;
$output .= '</div>'.$this->endBlockComment('row');
$output .= '</section>';

echo $output;