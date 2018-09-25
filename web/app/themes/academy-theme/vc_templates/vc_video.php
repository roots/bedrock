<?php
$output = $title = $link = $size = $el_class = '';
//extract( shortcode_atts( array(
//	'title' => '',
//	'link' => 'http://vimeo.com/92033601',
//	'size' => ( isset( $content_width ) ) ? $content_width : 500,
//	'el_class' => '',
//	'css' => '',
//	'frame' => ''
//), $atts ) );

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if ( $link == '' ) {
	return null;
}
$el_class = $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );

$video_w = ( isset( $content_width ) ) ? $content_width : 500;
$video_h = $video_w / 1.61; //1.61 golden ratio
global $wp_embed;
$embed = $wp_embed->run_shortcode( '[embed width="' . $video_w . '"' . $video_h . ']' . $link . '[/embed]' );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_video_widget wpb_content_element' . $el_class . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

$frame_class = $frame_before = $frame_after = '';
if($frame == 'ipad') {
	$frame_class = ' fitvid';
	$frame_before = '<div class="frame-video">';
	$frame_after = '</div>';
} 

$output .= 'Video ID: ' . $link;

$output .= "\n\t" . '<div class="' . $css_class . '">';
$output .= "\n\t\t" . '<div class="wpb_wrapper">';
$output .= wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_video_heading' ) );
$output .= $frame_before;
$output .= '<div class="wpb_video_wrapper'.$frame_class.'">' . $embed . '</div>';
$output .= $frame_after;
$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
$output .= "\n\t" . '</div> ' . $this->endBlockComment( '.wpb_video_widget' );

echo $output;