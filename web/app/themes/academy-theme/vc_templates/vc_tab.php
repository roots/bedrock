<?php
$output = $title = $style = $tab_id = '';
//extract(shortcode_atts($this->predefined_atts, $atts));

extract( shortcode_atts( array(
	'title' => '',
	'tab_id' => '',
	'style' => ''
), $atts ) );

if($style != 'stylish') {

	//$output .= 'STYLE: '.$style;
	//$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_tab ui-tabs-panel wpb_ui-tabs-hide vc_clearfix', $this->settings['base'], $atts );
	//$output .= "\n\t\t\t" . '<div id="tab-'. (empty($tab_id) ? sanitize_title( $title ) : $tab_id) .'" class="'.$css_class.'">';
	//$output .= ($content=='' || $content==' ') ? __("Empty section. Edit page to add content here.", "north") : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
	//$output .= "\n\t\t\t" . '</div> ' . $this->endBlockComment('.wpb_tab');
	
	$output .= '<div class="tab-pane fade clearfix" id="tab-'.(empty($tab_id) ? sanitize_title( $title ) : $tab_id).'">';
		
	$output .= ($content=='' || $content==' ') ? __("Empty section. Edit page to add content here.", "north") : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
	
	$output .= '</div>';
	
} else {

	$output .= "\n\t\t\t" . '<div class="w-item white tab-'. (empty($tab_id) ? sanitize_title( $title ) : $tab_id) .'">';
	$output .= ($content=='' || $content==' ') ? __("Empty section. Edit page to add content here.", "north") : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
	$output .= "\n\t\t\t" . '</div> ' . $this->endBlockComment('.wpb_tab');

}

echo $output;