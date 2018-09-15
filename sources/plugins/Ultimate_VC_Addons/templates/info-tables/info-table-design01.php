<?php
/*
* Add-on Name: Info Tables for Visual Composer
* Template : Design layout 01
*/
if(!function_exists('ult_info_table_generate_design01')) {
	function ult_info_table_generate_design01($atts,$content = null){
		$icon_type = $icon_img = $img_width = $icon = $icon_color = $icon_color_bg = $icon_size = $icon_style = $icon_border_style = $icon_border_radius = $icon_color_border = $icon_border_size = $icon_border_spacing = $el_class = $package_heading = $package_sub_heading = $package_price = $package_unit = $package_btn_text = $package_link = $package_featured = $color_bg_main = $color_txt_main = $color_bg_highlight = $color_txt_highlight = $color_scheme = $use_cta_btn = '';
		extract(shortcode_atts(array(
			'color_scheme' => 'black',
			'package_heading' => '',
			'package_sub_heading' => '',
			'icon_type' => 'none',
			'icon' => '',
			'icon_img' => '',
			'img_width' => '48',
			'icon_size' => '32',
			'icon_color' => '#333333',
			'icon_style' => 'none',
			'icon_color_bg' => '#ffffff',
			'icon_color_border' => '#333333',
			'icon_border_style' => '',
			'icon_border_size' => '1',
			'icon_border_radius' => '500',
			'icon_border_spacing' => '50',
			'use_cta_btn' => '',
			'package_btn_text' => '',
			'package_link' => '',
			'package_featured' => '',
			'color_bg_main' => '',
			'color_txt_main' => '',
			'color_bg_highlight' => '',
			'color_txt_highlight' => '',
			'heading_font_family' => '',
			'heading_font_style' => '',
			'heading_font_size' => '',
			'heading_font_color' => '',
			'heading_line_height' => '',
			'subheading_font_family' => '',
			'subheading_font_style' => '',
			'subheading_font_size' => '',
			'subheading_font_color' => '',
			'subheading_line_height' => '',
			'features_font_family' => '',
			'features_font_style' => '',
			'features_font_size' => '',
			'features_font_color' => '',
			'features_line_height' => '',
			'button_font_family' => '',
			'button_font_style' => '',
			'button_font_size' => '',
			'button_font_color' => '',
			'button_line_height' => '',
			'el_class' => '',
			'features_min_ht'=>'',
			"css_info_tables" => '',
		),$atts));
		$css_info_tables = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css_info_tables, ' ' ), "ultimate_info_table", $atts );
		$css_info_tables = esc_attr( $css_info_tables );

		$output = $link = $target = $featured = $featured_style = $normal_style = $dynamic_style = $box_icon = '';
		if($icon_type !== "none"){
			$box_icon = do_shortcode('[just_icon icon_type="'.$icon_type.'" icon="'.$icon.'" icon_img="'.$icon_img.'" img_width="'.$img_width.'" icon_size="'.$icon_size.'" icon_color="'.$icon_color.'" icon_style="'.$icon_style.'" icon_color_bg="'.$icon_color_bg.'" icon_color_border="'.$icon_color_border.'"  icon_border_style="'.$icon_border_style.'" icon_border_size="'.$icon_border_size.'" icon_border_radius="'.$icon_border_radius.'" icon_border_spacing="'.$icon_border_spacing.'"]');
		}
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
			$dynamic_style = $featured_style;
		} else {
			$dynamic_style = $normal_style;
		}
		if($use_cta_btn == "box"){
			$output .= '<a href="'.$link.'" '.$target.' class="ult_price_action_button">'.$package_btn_text;
		}

		/*---min ht style---*/
		$info_tab_ht='';$info_tab_ht_style='';
		if($features_min_ht !== ""){
			    $info_tab_ht='info_min_ht';
				$info_tab_ht_style .= 'min-height:'.$features_min_ht.'px;';
			}

		/* typography */

		$heading_style_inline = $sub_heading_inline = $features_inline = $button_inline = '';

		// heading
		if($heading_font_family != '')
		{
			$hdfont_family = get_ultimate_font_family($heading_font_family);
			if($hdfont_family !== '')
				$heading_style_inline .= 'font-family:\''.$hdfont_family.'\';';
		}

		$heading_style_inline .= get_ultimate_font_style($heading_font_style);

		if($heading_font_color != '')
			$heading_style_inline .= 'color:'.$heading_font_color.';';

		// if($heading_font_size != '')
		// 	$heading_style_inline .= 'font-size:'.$heading_font_size.'px;';

		// if($heading_line_height != '')
		// 	$heading_style_inline .= 'line-height:'.$heading_line_height.'px;';

		if(is_numeric($heading_font_size)){
				$heading_font_size = 'desktop:'.$heading_font_size.'px;';
			}
			
		if(is_numeric($heading_line_height)){
				$heading_line_height = 'desktop:'.$heading_line_height.'px;';
			}

			$info_table_id = 'Info-table-wrap-'.rand(1000, 9999);
			$info_table_args = array(
                'target' => '#'.$info_table_id.' h3', // set targeted element e.g. unique class/id etc.
                'media_sizes' => array(
                    'font-size' => $heading_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
                   	'line-height' => $heading_line_height
                ),
            );
            $info_table_data_list = get_ultimate_vc_responsive_media_css($info_table_args);
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

			$info_table_sub_head_args = array(
                'target' => '#'.$info_table_id.' h5', // set targeted element e.g. unique class/id etc.
                'media_sizes' => array(
                    'font-size' => $subheading_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
                   	'line-height' => $subheading_line_height
                ),
            );
            $info_table_sub_head_data_list = get_ultimate_vc_responsive_media_css($info_table_sub_head_args);

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

		if(is_numeric($features_font_size)){
				$features_font_size = 'desktop:'.$features_font_size.'px;';
			}
			
		if(is_numeric($features_line_height)){
				$features_line_height = 'desktop:'.$features_line_height.'px;';
			}

			$info_table_features_id= 'info_table_features_wrap-'.rand(1000, 9999);

			$info_table_features_args = array(
                'target' => '#'.$info_table_features_id.'.ult_price_features', // set targeted element e.g. unique class/id etc.
                'media_sizes' => array(
                    'font-size' => $features_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
                   	'line-height' => $features_line_height
                ),
            );
            $info_table_features_data_list = get_ultimate_vc_responsive_media_css($info_table_features_args);

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

		if(is_numeric($button_font_size)){
				$button_font_size = 'desktop:'.$button_font_size.'px;';
			}
			
		if(is_numeric($button_line_height)){
				$button_line_height = 'desktop:'.$button_line_height.'px;';
			}

			$info_table_btn_id= 'info_table_btn_wrap-'.rand(1000, 9999);
			
			$info_table_btn_args = array(
                'target' => '#'.$info_table_btn_id.' .ult_price_action_button', // set targeted element e.g. unique class/id etc.
                'media_sizes' => array(
                    'font-size' => $button_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
                   	'line-height' => $button_line_height
                ),
            );
            $info_table_btn_data_list = get_ultimate_vc_responsive_media_css($info_table_btn_args);


		$output .= '<div class="ult_pricing_table_wrap ult_info_table ult_design_1 '.$featured.' ult-cs-'.$color_scheme.' '.$el_class.''.$css_info_tables.'">
					<div class="ult_pricing_table '.$info_tab_ht.'" style="'.$featured_style.' '.$info_tab_ht_style.'">';
			$output .= '<div class="ult_pricing_heading" id="'.$info_table_id.'">
							<h3 class="ult-responsive" '.$info_table_data_list.' style="'.$heading_style_inline.'">'.$package_heading.'</h3>';
						if($package_sub_heading !== ''){
							$output .= '<h5 class="ult-responsive" '.$info_table_sub_head_data_list.'style="'.$sub_heading_inline.'">'.$package_sub_heading.'</h5>';
						}
			$output .= '</div><!--ult_pricing_heading-->';
			$output .= '<div class="ult_price_body_block">
							<div class="ult_price_body">
								<div class="ult_price">
								'.$box_icon.'
								</div>
							</div>
						</div><!--ult_price_body_block-->';
			$output .= '<div id="'.$info_table_features_id.'" '.$info_table_features_data_list.' class="ult-responsive ult_price_features" style="'.$features_inline.'">
							'.wpb_js_remove_wpautop(do_shortcode($content), true).'
						</div><!--ult_price_features-->';
			if($use_cta_btn == "true"){
				$output .= '<div id="'.$info_table_btn_id.'" class="ult_price_link" style="'.$normal_style.'">
							<a href="'.$link.'" '.$target.' '.$info_table_btn_data_list.' class="ult-responsive ult_price_action_button" style="'.$featured_style.' '.$button_inline.'">'.$package_btn_text.'</a>
						</div><!--ult_price_link-->';
			}
			$output .= '<div class="ult_clr"></div>
			</div><!--pricing_table-->
		</div><!--pricing_table_wrap-->';
		if($use_cta_btn == "box"){
			$output .= '</a>';
		}
		return $output;
	}
}
