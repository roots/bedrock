<?php
/*
* Add-on Name: Stats Counter for Visual Composer
* Template : Design layout 06
*/
if(!function_exists('ult_price_generate_design06')) {
	function ult_price_generate_design06($atts,$content = null){
		$package_heading = $package_sub_heading = $package_price = $package_unit = $package_btn_text = $package_link = $package_featured = $color_bg_main = $color_txt_main = $color_bg_highlight = $color_txt_highlight = $color_scheme = $el_class = '';
		extract(shortcode_atts(array(
			"color_scheme" => "black",
			"package_heading" => "",
			"package_sub_heading" => "",
			"package_price" => "",
			"package_unit" => "",
			"package_btn_text" => "",
			"package_link" => "",
			"package_featured" => "",
			"color_bg_main" => "",
			"color_txt_main" => "",
			"color_bg_highlight" => "",
			"color_txt_highlight" => "",
			"package_name_font_family" => "",
			"package_name_font_style" => "",
			"package_name_font_size" => "",
			"package_name_font_color" => "",
			"package_name_line_height" => "",
			"subheading_font_family" => "",
			"subheading_font_style" => "",
			"subheading_font_size" => "",
			"subheading_font_color" => "",
			"subheading_line_height" => "",
			"price_font_family" => "",
			"price_font_style" => "",
			"price_font_size" => "",
			"price_font_color" => "",
			"price_line_height" => "",
			"price_unit_font_family" => "",
			"price_unit_font_style" => "",
			"price_unit_font_size" => "",
			"price_unit_font_color" => "",
			"price_unit_line_height" => "",
			"features_font_family" => "",
			"features_font_style" => "",
			"features_font_size" => "",
			"features_font_color" => "",
			"features_line_height" => "",
			"button_font_family" => "",
			"button_font_style" => "",
			"button_font_size" => "",
			"button_font_color" => "",
			"button_line_height" => "",
			"el_class" => "",
			"min_ht" => "",
			"css_price_box" => "",

		),$atts));
		$css_price_box = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css_price_box, ' ' ), "ultimate_pricing", $atts );
		$css_price_box = esc_attr( $css_price_box );
		$output = $link = $target = $featured = $featured_style = $normal_style = $dynamic_style = '';
		if($color_scheme == "custom"){
			if($color_bg_main !== ""){
				$normal_style .= 'background:'.$color_bg_main.';';
			}
			if($color_txt_main !== ""){
				$normal_style .= 'color:'.$color_txt_main.';';
			}
			if($color_bg_highlight!== ""){
				$featured_style .= 'background:'.$color_bg_highlight.';';
			}
			if($color_txt_highlight !== ""){
				$featured_style .= 'color:'.$color_txt_highlight.';';
			}
		}
		if($package_link !== ""){
			$link = vc_build_link($package_link);
			if(isset($link['target'])){
				$target = 'target="'.$link['target'].'"';
			} else {
				$target = '';
			}
			$link = $link['url'];
		} else {
			$link = "#";
		}
		if($package_featured !== ""){
			$featured = "ult_featured";
		}

		/* Typography */

		$package_name_inline = $sub_heading_inline = $price_inline = $price_unit_inline = $features_inline = $button_inline = '';

		// package name/title
		if($package_name_font_family != '')
		{
			$pkgfont_family = get_ultimate_font_family($package_name_font_family);
			if($pkgfont_family !== '')
				$package_name_inline .= 'font-family:\''.$pkgfont_family.'\';';
		}

		$package_name_inline .= get_ultimate_font_style($package_name_font_style);

		// if($package_name_font_size != '')
		// 	$package_name_inline .= 'font-size:'.$package_name_font_size.'px;';

		// if($package_name_line_height != '')
		// 	$package_name_inline .= 'line-height:'.$package_name_line_height.'px;';

		if($package_name_font_color != '')
			$package_name_inline .= 'color:'.$package_name_font_color.';';

		if(is_numeric($package_name_font_size)){
			$package_name_font_size = 'desktop:'.$package_name_font_size.'px;';
		}

		if(is_numeric($package_name_line_height)){
			$package_name_line_height = 'desktop:'.$package_name_line_height.'px;';
		}

		$price_table_id = 'price-table-wrap-'.rand(1000, 9999);
		
		$price_table_args = array(
            'target' => '#'.$price_table_id.' .cust-headformat', // set targeted element e.g. unique class/id etc.
            'media_sizes' => array(
                'font-size' => $package_name_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
               	'line-height' => $package_name_line_height
            ),
        );
        
        $price_table_data_list = get_ultimate_vc_responsive_media_css($price_table_args);

		// sub heading
		if($subheading_font_family != '')
		{
			$shfont_family = get_ultimate_font_family($subheading_font_family);
			if($shfont_family !== '')
				$sub_heading_inline .= 'font-family:\''.$shfont_family.'\';';
		}

		$sub_heading_inline .= get_ultimate_font_style($subheading_font_style);

		// if($subheading_font_size != '')
		// 	$sub_heading_inline .= 'font-size:'.$subheading_font_size.'px;';

		// if($subheading_line_height != '')
		// 	$sub_heading_inline .= 'line-height:'.$subheading_line_height.'px;';

		if($subheading_font_color != '')
			$sub_heading_inline .= 'color:'.$subheading_font_color.';';

		if(is_numeric($subheading_font_size)){
			$subheading_font_size = 'desktop:'.$subheading_font_size.'px;';
		}

		if(is_numeric($subheading_line_height)){
			$subheading_line_height = 'desktop:'.$subheading_line_height.'px;';
		}
		
		$price_table_subhead_args = array(
            'target' => '#'.$price_table_id.' .cust-subhead', // set targeted element e.g. unique class/id etc.
            'media_sizes' => array(
                'font-size' => $subheading_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
               	'line-height' => $subheading_line_height
            ),
        );
        
        $price_table_subhead_data_list = get_ultimate_vc_responsive_media_css($price_table_subhead_args);

		// price
		if($price_font_family != '')
		{
			$pricefont_family = get_ultimate_font_family($price_font_family);
			if($pricefont_family !== '')
				$price_inline .= 'font-family:\''.$pricefont_family.'\';';
		}

		$price_inline .= get_ultimate_font_style($price_font_style);

		// if($price_font_size != '')
		// 	$price_inline .= 'font-size:'.$price_font_size.'px;';

		// if($price_line_height != '')
		// 	$price_inline .= 'line-height:'.$price_line_height.'px;';

		if($price_font_color != '')
			$price_inline .= 'color:'.$price_font_color.';';

		//responsive param

		if(is_numeric($price_font_size)){
			$price_font_size = 'desktop:'.$price_font_size.'px;';
		}

		if(is_numeric($price_line_height)){
			$price_line_height = 'desktop:'.$price_line_height.'px;';
		}

		$price_table_price_id = 'price-table-wrap-'.rand(1000, 9999);
		
		$price_table_price_args = array(
            'target' => '#'.$price_table_price_id.' .ult_price_figure', // set targeted element e.g. unique class/id etc.
            'media_sizes' => array(
                'font-size' => $price_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
               	'line-height' => $price_line_height
            ),
        );
        
        $price_table_price_data_list = get_ultimate_vc_responsive_media_css($price_table_price_args);

		// price unit
		if($price_unit_font_family != '')
		{
			$price_unitfont_family = get_ultimate_font_family($price_unit_font_family);
			if($price_unitfont_family !== '')
				$price_unit_inline .= 'font-family:\''.$price_unitfont_family.'\';';
		}

		$price_unit_inline .= get_ultimate_font_style($price_unit_font_style);

		// if($price_unit_font_size != '')
		// 	$price_unit_inline .= 'font-size:'.$price_unit_font_size.'px;';

		// if($price_unit_line_height != '')
		// 	$price_unit_inline .= 'line-height:'.$price_unit_line_height.'px;';

		if($price_unit_font_color != '')
			$price_unit_inline .= 'color:'.$price_unit_font_color.';';

		//responsive param

		if(is_numeric($price_unit_font_size)){
			$price_unit_font_size = 'desktop:'.$price_unit_font_size.'px;';
		}

		if(is_numeric($price_unit_line_height)){
			$price_unit_line_height = 'desktop:'.$price_unit_line_height.'px;';
		}

		$price_table_price_unit_args = array(
            'target' => '#'.$price_table_price_id.' .ult_price_term', // set targeted element e.g. unique class/id etc.
            'media_sizes' => array(
                'font-size' => $price_unit_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
               	'line-height' => $price_unit_line_height
            ),
        );
        
        $price_table_price_unit_data_list = get_ultimate_vc_responsive_media_css($price_table_price_unit_args);

		// features
		if($features_font_family != '')
		{
			$featuresfont_family = get_ultimate_font_family($features_font_family);
			if($featuresfont_family !== '')
				$features_inline .= 'font-family:\''.$featuresfont_family.'\';';
		}

		$features_inline .= get_ultimate_font_style($features_font_style);

		// if($features_font_size != '')
		// 	$features_inline .= 'font-size:'.$features_font_size.'px;';

		// if($features_line_height != '')
		// 	$features_inline .= 'line-height:'.$features_line_height.'px;';

		if($features_font_color != '')
			$features_inline .= 'color:'.$features_font_color.';';

		//responsive param

		if(is_numeric($features_font_size)){
			$features_font_size = 'desktop:'.$features_font_size.'px;';
		}

		if(is_numeric($features_line_height)){
			$features_line_height = 'desktop:'.$features_line_height.'px;';
		}
		$price_table_features_id = 'price-table-features-wrap-'.rand(1000, 9999);
		$price_table_features_args = array(
	        'target' => '#'.$price_table_features_id.'', // set targeted element e.g. unique class/id etc.
	        'media_sizes' => array(
	            'font-size' => $features_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
	           	'line-height' => $features_line_height
	        ),
	    );
	    
	    $price_table_features_data_list = get_ultimate_vc_responsive_media_css($price_table_features_args);

		/*-- min height-------*/
		$price_normal_style='';
		$ult_price_table_ht='';
		   if($min_ht != ''){
				$ult_price_table_ht.='ult_price_table_ht';
				$price_normal_style .= 'min-height:'.$min_ht.'px;';
			}



		// button
		if($button_font_family != '')
		{
			$buttonfont_family = get_ultimate_font_family($button_font_family);
			if($buttonfont_family !== '')
				$button_inline .= 'font-family:\''.$buttonfont_family.'\';';
		}

		$button_inline .= get_ultimate_font_style($button_font_style);

		// if($button_font_size != '')
		// 	$button_inline .= 'font-size:'.$button_font_size.'px;';

		// if($button_line_height != '')
		// 	$button_inline .= 'line-height:'.$button_line_height.'px;';

		if($button_font_color != '')
			$button_inline .= 'color:'.$button_font_color.';';

		if($features_font_color != '')
			$features_inline .= 'color:'.$features_font_color.';';

		//responsive param

		if(is_numeric($button_font_size)){
			$button_font_size = 'desktop:'.$button_font_size.'px;';
		}

		if(is_numeric($button_line_height)){
			$button_line_height = 'desktop:'.$button_line_height.'px;';
		}
		$price_table_button_id = 'price-table-button-wrap-'.rand(1000, 9999);
		$price_table_button_args = array(
	        'target' => '#'.$price_table_button_id.' .ult_price_action_button', // set targeted element e.g. unique class/id etc.
	        'media_sizes' => array(
	            'font-size' => $button_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
	           	'line-height' => $button_line_height
	        ),
	    );
	    
	    $price_table_button_data_list = get_ultimate_vc_responsive_media_css($price_table_button_args);

		/*$args = array(
			$package_name_font_family, $subheading_font_family, $price_font_family, $features_font_family, $button_font_family
		);
		enquque_ultimate_google_fonts($args);*/

		/* End Typography */

		$output .= '<div class="ult_pricing_table_wrap ult_design_6 '.$featured.' ult-cs-'.$color_scheme.' '.$el_class.' '.$css_price_box.'">
					<div class="ult_pricing_table '.$ult_price_table_ht.'" style="'.$normal_style.' '.$price_normal_style.'">';
			$output .= '<div id="'.$price_table_id.'" class="ult_pricing_heading" style="'.$featured_style.'">
							<h3 class="ult-responsive cust-headformat" '.$price_table_data_list.' style="'.$package_name_inline.'">'.$package_heading.'</h3>';
						if($package_sub_heading !== ''){
							$output .= '<h5 '.$price_table_subhead_data_list.' class="ult-responsive cust-subhead" style="'.$sub_heading_inline.'">'.$package_sub_heading.'</h5>';
						}
			$output .= '</div><!--ult_pricing_heading-->';
			$output .= '<div class="ult_price_body_block" style="'.$featured_style.'">
							<div class="ult_price_body">
								<div id="'.$price_table_price_id.'"  class="ult_price">
									<span '.$price_table_price_data_list.' class="ult_price_figure ult-responsive" style="'.$price_inline.'">'.$package_price.'</span>
									<span '.$price_table_price_unit_data_list.' class="ult_price_term ult-responsive" style="'.$price_unit_inline.'">'.$package_unit.'</span>
								</div>
							</div>
						</div><!--ult_price_body_block-->';
			$output .= '<div id="'.$price_table_features_id.'" class="ult_price_features ult-responsive" '.$price_table_features_data_list.' style="'.$features_inline.'">
							'.wpb_js_remove_wpautop(do_shortcode($content), true).'
						</div><!--ult_price_features-->';
			if($package_btn_text !== ""){
				$output .= '<div id="'.$price_table_button_id.'" class="ult_price_link" style="'.$normal_style.'">
							<a '.$price_table_button_data_list.' href="'.$link.'" '.$target.' class="ult_price_action_button ult-responsive" style="'.$featured_style.' '.$button_inline.'">'.$package_btn_text.'</a>
						</div><!--ult_price_link-->';
			}
			$output .= '<div class="ult_clr"></div>
			</div><!--pricing_table-->
		</div><!--pricing_table_wrap-->';
		return $output;
	}
}
