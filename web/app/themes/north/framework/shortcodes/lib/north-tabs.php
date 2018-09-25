<?php

// Blog Posts Carousel

function vntd_north_tabs($atts, $content = null) {
	extract(shortcode_atts(array(
		"tabs" 		=> '',
	), $atts));
	
	$extra_class = '';
	
	$values = (array) vc_param_group_parse_atts( $tabs );
	
	$tabs = array();
	
	$tabs_content = array();
	
	ob_start();	
	
	//if( sizeof( $values ) == 1 ) $extra_class = ' button-no-slider';
   
	echo '<div class="vntd-tabs-stylish t-center ">';
	
	
	
	$i = 0;
	$delay = 100;
	$selected = '';
	
	foreach ( $values as $data ) {
		$new_line = $data;
		
		$new_line['title'] = isset( $data['title'] ) ? $data['title'] : '';
		$new_line['heading'] = isset( $data['heading'] ) ? $data['heading'] : '';
		$new_line['text'] = isset( $data['text'] ) ? $data['text'] : '';
		
		$rand_id = rand(1,99999);
		
		if( $i == 0 ) {
			$selected = ' selected';
		} else {
			$selected = '';
		}
		
		$tabs[$i] = '<li class="animated flipInY visible" data-animation="flipInY" data-animation-delay="' . $delay . '"><a class="soft-bg-icons' . $selected . '" href="#filter" data-option-value=".tab-' . $rand_id .'"><span>' . esc_html( $new_line['title'] ) . '</span></a></li>';
		
		$tabs_content[$i] = '<div class="w-item white tab-' . $rand_id .'"><div class="wpb_text_column wpb_content_element "><div class="wpb_wrapper"><h1>' . esc_html( $new_line['heading'] ) . '</h1><p>' . esc_html( $new_line['text'] ) . '</p></div></div></div>';
		
		$i++;
		$delay = $delay+100;
	}
	
	echo '<div id="w-options" class="filter-menu fullwidth"><ul id="w-filters" class="w-option-set relative normal font-primary uppercase" data-option-key="filter">';
	
	foreach($tabs as $tab) {
		echo $tab;
	}
	
	echo '</div>';
	
	echo '<div class="w-items t-left isotope">';
	
	foreach($tabs_content as $tab_content) {
		echo $tab_content;
	}
	
	echo '</div>';
	
	
	echo '</div>';

	
	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;
	
}
remove_shortcode('north_tabs');
add_shortcode('north_tabs', 'vntd_north_tabs');