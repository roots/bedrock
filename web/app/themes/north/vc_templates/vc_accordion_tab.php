<?php
$output = $title = '';

extract(shortcode_atts(array(
	'title' => __("Section", "north")
), $atts));

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_accordion_section group', $this->settings['base'], $atts );
//$output .= "\n\t\t\t" . '<div class="'.$css_class.'">';
//    $output .= "\n\t\t\t\t" . '<h3 class="wpb_accordion_header ui-accordion-header"><a href="#'.sanitize_title($title).'">'.$title.'</a></h3>';
//    $output .= "\n\t\t\t\t" . '<div class="wpb_accordion_content ui-accordion-content vc_clearfix">';
//        $output .= ($content=='' || $content==' ') ? __("Empty section. Edit page to add content here.", "north") : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
//        $output .= "\n\t\t\t\t" . '</div>';
//    $output .= "\n\t\t\t" . '</div> ' . $this->endBlockComment('.wpb_accordion_section') . "\n";
   
$rand_id = rand(1,99999); 

$output .= '<div class="panel panel-default"><a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$rand_id.'" class="panel-button font-primary uppercase">'.$title.'</a><div id="collapse'.$rand_id.'" class="panel-collapse collapse"><div class="panel-body">'.wpb_js_remove_wpautop($content).'</div></div></div>';

echo $output;