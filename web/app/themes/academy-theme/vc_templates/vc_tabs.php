<?php
$output = $title = $interval = $el_class = '';
extract( shortcode_atts( array(
	'title' => '',
	'interval' => 0,
	'style' => '',
	'el_class' => ''
), $atts ) );

$el_class = $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );

$element = 'wpb_tabs';
if ( 'vc_tour' == $this->shortcode ) $element = 'wpb_tour';



// Extract tab titles
preg_match_all( '/vc_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
$tab_titles = array();
/**
 * vc_tabs
 *
 */
 
$tabs_nav = '';

$tabs_style = 'default';
if($style == 'stylish') $tabs_style = 'stylish t-center';

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, trim( $element . ' wpb_content_element ' . $el_class ), $this->settings['base'], $atts );


if($style != 'stylish') {

//	$output .= "\n\t" . '<div class="vntd-tabs-' .$tabs_style . ' ' . $css_class . '" data-interval="' . $interval . '">';
//	$output .= "\n\t\t" . '<div class="wpb_wrapper wpb_tour_tabs_wrapper ui-tabs vc_clearfix">';
// 
//	if ( isset( $matches[1] ) ) {
//		$tab_titles = $matches[1];
//	}	
//	$tabs_nav .= '<ul class="wpb_tabs_nav ui-tabs-nav vc_clearfix">';
//	foreach ( $tab_titles as $tab ) {
//		$tab_atts = shortcode_parse_atts($tab[0]);
//		if(isset($tab_atts['title'])) {
//			$tabs_nav .= '<li><a href="#tab-' . ( isset( $tab_atts['tab_id'] ) ? $tab_atts['tab_id'] : sanitize_title( $tab_atts['title'] ) ) . '">' . $tab_atts['title'] . '</a></li>';
//		}
//	}
//	$tabs_nav .= '</ul>' . "\n";	
//	
//	$output .= wpb_widget_title( array( 'title' => $title, 'extraclass' => $element . '_heading' ) );
//	$output .= "\n\t\t\t" . $tabs_nav;
//	$output .= "\n\t\t\t" . wpb_js_remove_wpautop( $content );
//	if ( 'vc_tour' == $this->shortcode ) {
//		$output .= "\n\t\t\t" . '<div class="wpb_tour_next_prev_nav vc_clearfix"> <span class="wpb_prev_slide"><a href="#prev" title="' . __( 'Previous slide', 'north' ) . '">' . __( 'Previous slide', 'north' ) . '</a></span> <span class="wpb_next_slide"><a href="#next" title="' . __( 'Next slide', 'north' ) . '">' . __( 'Next slide', 'north' ) . '</a></span></div>';
//	}

	$tour_class = '';
	//echo "TEST";
	if ( 'wpb_tour' == $element ) {
		$tour_class = " vntd-tour";
	}

	$output .= '<div class="tabs vntd-tabs-'.$tabs_style.$tour_class.'">';
	
	$tabs_nav .= '<ul class="nav nav-tabs">';
	
	if ( isset( $matches[1] ) ) {
		$tab_titles = $matches[1];
	}

	$i = 0;
	foreach ( $tab_titles as $tab ) {
		$active_class = '';
		if($i == 0) $active_class = ' class="active"';
		$tab_atts = shortcode_parse_atts($tab[0]);
		if(isset($tab_atts['title'])) {
			$tabs_nav .= '<li'.$active_class.'><a href="#tab-'.$tab_atts['tab_id'].'" data-toggle="tab" class="uppercase font-primary">'.$tab_atts['title'].'</a></li>';
				//$tabs_nav .= '<li><a href="#tab-' . ( isset( $tab_atts['tab_id'] ) ? $tab_atts['tab_id'] : sanitize_title( $tab_atts['title'] ) ) . '">' . $tab_atts['title'] . '</a></li>';
		}
		$i++;
	}
	
	$tabs_nav .= '</ul>';
	
	$output .= $tabs_nav;
	
	$output .= '<div class="tab-content">';
	
	$output .= wpb_js_remove_wpautop( $content );		

} else {

	

	$output .= "\n\t" . '<div class="vntd-tabs-' .$tabs_style . ' ">';
	$output .= "\n\t\t" . '<div class="wpb_wrapper">';

	if ( isset( $matches[1] ) ) {
		$tab_titles = $matches[1];
	}	
	$tabs_nav .= '<div id="w-options" class="filter-menu fullwidth">';
	$tabs_nav .= '<ul id="w-filters" class="w-option-set relative normal font-primary uppercase" data-option-key="filter">';
	$i=0;
	$delay=100;
	foreach ( $tab_titles as $tab ) {
		$tab_atts = shortcode_parse_atts($tab[0]);
		if(isset($tab_atts['title'])) {
			$selected = '';
			if($i == 0) $selected = ' selected';
			$tabs_nav .= '<li class="animated" data-animation="flipInY" data-animation-delay="'.$delay.'"><a class="soft-bg-icons'.$selected.'" href="#filter" data-option-value=".tab-'.$tab_atts['tab_id'].'"><span>' . $tab_atts['title'] . '</span></a></li>';
		}
		$delay = $delay+100;
		$i++;
	}
	$tabs_nav .= '</ul></div>' . "\n";
	
	
	$content = str_replace("tab_id",'style="stylish" tab_id',$content);

	$output .= "\n\t\t\t" . $tabs_nav;
	$output .= '<div class="w-items t-left isotope">';
	$output .= "\n\t\t\t" . wpb_js_remove_wpautop( $content );
	$output .= '</div>';

}

$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
$output .= "\n\t" . '</div> ' . $this->endBlockComment( $element );

echo $output;