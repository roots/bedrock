<?php

// Shortcode Processing

function vntd_portfolio_details($atts, $content) {
	extract(shortcode_atts(array(
		"title" => 'Project Details',
		"title2" => 'Project Description',
		"skills" => 'Design,Photography,HTML,jQuery',
		"client_website" => '',
		"client" => 'Gold Eye Themes',
		"button1_label" => 'Live Preview',
		"button1_url" => '',
		"button2_label" => '',
		"button2_url" => '',
		"style" => 'style2'
	), $atts));
	
	$output = '<div class="vntd-portfolio-details">';
	
	if($style == 'style2') {
		$output .= '<div class="col-xs-8 p-column"><h3 class="p-head font-secondary">'.$title2.'</h3>'.$content.'</div>';
		$output .= '<div class="col-xs-4 p-column"><h3 class="p-head font-secondary">'.$title.'</h3>';
	} else {	
		$output .= '<h1 class="project-head dark bold font-secondary">'.$title.'</h1>';
		$output .= '<p class="project-desc dark">'.$content.'</p>';
	}	

	$output .= '<ul class="project_features">';
	
	if($client) {
		$output .= '<li class="p-feature"><h4 class="bold font-secondary">'.__('Client','north').'</h4><p class="normal">'.$client.'</p></li>';
	}
	
	if($client) {
		$output .= '<li class="p-feature"><h4 class="bold font-secondary">'.__('Skills','north').'</h4><ul class="list list-horizontal no-padding no-margin">';
		
		$skills = explode(',',$skills);
		
		foreach($skills as $skill) {
			$output .= '<li class="project-skill"><i class="fa fa-check-circle colored"></i> '.$skill.'</li>';
		}
		
		$output .= '</ul></li>';
	}
	
	$output .= '</ul>';
	
	if($button1_label) {
		$output .= '<a href="'.$button1_url.'" target="_blank" class="button active-colored white semibold">'.$button1_label.'</a>';
	}
	
	if($button2_label) {
		$output .= '<a href="'.$button2_url.'" class="button active-dark white semibold ex-link">'.$button2_label.'</a>';
	}

	$output .= '</div>';
	
	if($style == 'style2') {
		$output .= '</div>';
	}
	
	return $output;
	
}
remove_shortcode('portfolio_details');
add_shortcode('portfolio_details', 'vntd_portfolio_details');  