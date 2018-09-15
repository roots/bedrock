<?php
/*
* Add-on Name: Info Circle for Visual Composer
* Add-on URI: http://dev.brainstormforce.com
*/
if(!class_exists('Ultimate_Info_Circle'))
{
	class Ultimate_Info_Circle
	{
		function __construct()
		{
			add_action('init', array($this, 'add_info_circle'));
			add_action("wp_enqueue_scripts", array($this, "register_info_circle_assets"),1);
			add_shortcode( 'info_circle', array($this, 'info_circle' ) );
			add_shortcode( 'info_circle_item', array($this, 'info_circle_item' ) );
		}
		function register_info_circle_assets()
		{
			$bsf_dev_mode = bsf_get_option('dev_mode');
			if($bsf_dev_mode === 'enable') {
				$js_path = '../assets/js/';
				$css_path = '../assets/css/';
				$ext = '';
			}
			else {
				$js_path = '../assets/min-js/';
				$css_path = '../assets/min-css/';
				$ext = '.min';
			}
			wp_register_script("info-circle",plugins_url($js_path."info-circle".$ext.".js",__FILE__),array('jquery'),ULTIMATE_VERSION);
			wp_register_script("info-circle-ui-effect",plugins_url($js_path."jquery-ui-effect".$ext.".js",__FILE__),array('jquery'),ULTIMATE_VERSION);
			wp_register_style("info-circle",plugins_url($css_path."info-circle".$ext.".css",__FILE__),array(),ULTIMATE_VERSION,false);
		}
		function info_circle($atts, $content = null)
		{
			//$ultimate_js = get_option('ultimate_js');
			//if($ultimate_js != 'enable')
			//	wp_enqueue_script('ultimate-appear');
			//wp_enqueue_script('info-circle');
			//wp_enqueue_script('info-circle-ui-effect');
			$edge_radius = $visible_circle = $start_degree = $eg_padding = $circle_type = $icon_position = $eg_br_width = $eg_br_style = $eg_border_color = $cn_br_style = $highlight_style = $responsive_breakpoint = '';
			$icon_size = $cn_br_width =$cn_border_color = $icon_diversion = $icon_show = $content_bg = $content_color = $el_class = $img_icon_size = '';
			$icon_launch = $icon_launch_duration = $icon_launch_delay = $clipped_circle = '';
			$title_font = $title_font_style = $title_font_size = $title_line_height = $desc_font = $desc_font_style = $desc_font_size = $desc_line_height = '';
			extract(shortcode_atts(array(
				'edge_radius' =>'80',
				'visible_circle' => '70',
				'start_degree' => '90',
				'circle_type' => '',
				'icon_position' => 'full',
				'focus_on'=>'hover',
				'eg_br_width' => '1',
				'eg_br_style' =>'none',
				'eg_border_color' =>'',
				'cn_br_style' => 'none',
				'cn_br_width' => '1',
				'cn_border_color' => '',
				'highlight_style'=>'info-circle-highlight-style',
				'icon_size' =>'32',
				'img_icon_size' => '32',
				'eg_padding'=>'50',
				'icon_diversion'=>'',
				'icon_show' =>'show',
				'content_icon_size'=>'32',
				'content_color'=>'',
				'content_bg'=>'',
				'responsive'=>'on',
				'responsive_breakpoint' => '800',
				'auto_slide'=>'off',
				'auto_slide_duration'=>'3',
				'icon_launch'=>'',
				'icon_launch_duration'=>'1',
				'icon_launch_delay' =>'0.2',
				'el_class' =>'',
				'title_font' => '',
				'title_font_style' => '',
				'title_font_size' => '',
				'title_line_height' => '',
				'desc_font' => '',
				'desc_font_style' => '',
				'desc_font_size' => '',
				'desc_line_height' => '',
			), $atts));

			$vc_version = (defined('WPB_VC_VERSION')) ? WPB_VC_VERSION : 0;
			$is_vc_49_plus = (version_compare(4.9, $vc_version, '<=')) ? 'ult-adjust-bottom-margin' : '';

			$uniq = uniqid();

			global $title_style_inline, $desc_style_inline, $info_circle_id, $info_circle_data_list;

			/* ---- main title styles ---- */
			if($title_font != '')
			{
				$title_font_family = get_ultimate_font_family($title_font);
				if($title_font_family != '')
					$title_style_inline = 'font-family:\''.$title_font_family.'\';';
			}
			// main heading font style
			$title_style_inline .= get_ultimate_font_style($title_font_style);
			//attach font size if set

			// if($title_font_size != '')
			// 	$title_style_inline .= 'font-size:'.$title_font_size.'px;';
			// //line height
			// if($title_line_height != '')
			// 	$title_style_inline .= 'line-height:'.$title_line_height.'px;';

			//responsive param for title

			if(is_numeric($title_font_size)){
				$title_font_size = 'desktop:'.$title_font_size.'px;';
			}

			if(is_numeric($title_line_height)){
				$title_line_height = 'desktop:'.$title_line_height.'px;';
			}

			$info_circle_id = 'info-cirlce-wrap-'.rand(1000, 9999);
			$info_circle_args = array(
                'target' => '#'.$info_circle_id.' .responsive-font-class h3.new-cust-responsive-class', // set targeted element e.g. unique class/id etc.
                'media_sizes' => array(
                    'font-size' => $title_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
                   	'line-height' => $title_line_height
                ),
            );

            $info_circle_data_list = get_ultimate_vc_responsive_media_css($info_circle_args);

			/* ---- description styles ---- */
			if($desc_font != '')
			{
				$desc_font_family = get_ultimate_font_family($desc_font);
				if($desc_font_family != '')
					$desc_style_inline = 'font-family:\''.$desc_font_family.'\';';
			}
			// main heading font style
			$desc_style_inline .= get_ultimate_font_style($desc_font_style);
			//attach font size if set

			// if($desc_font_size != '')
			// 	$desc_style_inline .= 'font-size:'.$desc_font_size.'px;';
			// //line height
			// if($desc_line_height != '')
			// 	$desc_style_inline .= 'line-height:'.$desc_line_height.'px;';


			//Responsive param for Description

			if(is_numeric($desc_font_size)){
				$desc_font_size = 'desktop:'.$desc_font_size.'px;';
			}

			if(is_numeric($desc_line_height)){
				$desc_line_height = 'desktop:'.$desc_line_height.'px;';
			}

			$info_circle_desc_args = array(
                'target' => '#'.$info_circle_id.' .responsive-font-class *', // set targeted element e.g. unique class/id etc.
                'media_sizes' => array(
                    'font-size' => $desc_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
                   	'line-height' => $desc_line_height
                ),
            );

            $info_circle_desc_data_list = get_ultimate_vc_responsive_media_css($info_circle_desc_args);

			$style = $style1 = $style3 = $ex_class ='';

			if($eg_br_style!='none' && $eg_br_width!='' && $eg_border_color!=''){
				$style.='border:'.$eg_br_width.'px '.$eg_br_style.' '.$eg_border_color.';';
			}
			if($cn_br_style!='none' && $cn_br_width!='' && $cn_border_color!=''){
				$style1.='border:'.$cn_br_width.'px '.$cn_br_style.' '.$cn_border_color.';';
			}
			//$style .='border-style:'.$eg_br_style.';';
			$style1 .='background-color:'.$content_bg.';color:'.$content_color.';';
			$style1 .='width:'.$eg_padding.'%;height:'.$eg_padding.'%;margin:'.((100-$eg_padding)/2).'%;';
			if($el_class!='')
				$ex_class = $el_class;
			if($responsive=='on')
				$ex_class .= ' info-circle-responsive';
			if($icon_show=='show'){
				$content_icon_size = $content_icon_size;
			}
			else{
				$content_icon_size='';
			}
			if($edge_radius!=''){
				$style .= 'width:'.$edge_radius.'%;';
			}
			$style .='opacity:0;';
			if($circle_type=='') $circle_type= 'info-c-full-br';

			if($icon_position == 'full')
				$circle_type_extended = 'full-circle';
			else
			{
				if($icon_position == 90)
					$circle_type_extended = 'left-circle';
				elseif($icon_position == 270)
					$circle_type_extended = 'right-circle';
				elseif($icon_position == 180)
					$circle_type_extended = 'top-circle';
				elseif($icon_position == 0)
					$circle_type_extended = 'bottom-circle';
				else
					$circle_type_extended = 'full-circle';
			}

			if($visible_circle != '' && $visible_circle != 100 && $circle_type_extended != 'full-circle')
				$clipped_circle = 'clipped-info-circle';

			$output ='<div class="info-wrapper '.$is_vc_49_plus.'"><div id="info-circle-wrapper-'.$uniq.'" data-uniqid="'.$uniq.'" class="info-circle-wrapper '.$ex_class.' '.$clipped_circle.'" data-half-percentage="'.$visible_circle.'" data-circle-type="'.$circle_type_extended.'">';
			$output .= '<div class="'.$circle_type.'" style=\''.$style.'\' data-start-degree="'.$start_degree.'" data-divert="'.$icon_diversion.'" data-info-circle-angle="'.$icon_position.'" data-responsive-circle="'.$responsive.'" data-responsive-breakpoint="'.$responsive_breakpoint.'" data-launch="'.$icon_launch.'" data-launch-duration="'.$icon_launch_duration.'" data-launch-delay="'.$icon_launch_delay.'" data-slide-true="'.$auto_slide.'" data-slide-duration="'.$auto_slide_duration.'" data-icon-size="'.$icon_size.'" data-icon-show="'.$icon_show.'" data-icon-show-size="'.$content_icon_size.'" data-highlight-style="'.$highlight_style.'" data-focus-on="'.$focus_on.'">';

			$output .= '<div  class="icon-circle-list">';

			//$content = str_replace('[info_circle_item', '[info_circle_item  icon_size="'.$icon_size.'"', $content);
			$output .= do_shortcode($content);
			if($icon_position!='full'){
				$output .='<div class="info-circle-icons suffix-remove"></div>';
			}
			$output .= '</div>';
			$output .='<div id="'.$info_circle_id.'" class="info-c-full" style="'.$style1.'"><div class="info-c-full-wrap"></div>';
			$output .='</div>';
			$output .= '</div>';
			if($responsive=='on'){
				$output .='<div class="smile_icon_list_wrap " data-content_bg="'.$content_bg.'" data-content_color="'.$content_color.'">
							<ul id="'.$info_circle_id.'" class="smile_icon_list left circle with_bg">
								<li class="icon_list_item" style="font-size:'.( $img_icon_size*3).'px;">
									<div class="icon_list_icon" style="font-size:'. $img_icon_size.'px;">
										<i class="smt-pencil"></i>
									</div>
									<div  class="icon_description" >
										<div class="responsive-font-class ult-responsive" '.$info_circle_desc_data_list.' style="'.$desc_style_inline.'">
											<h3 '.$info_circle_data_list.' class="ult-responsive new-cust-responsive-class" style="'.$title_style_inline.'"></h3>
											<p></p>
										</div>
									</div>
									<div class="icon_list_connector" style="border-style:'.$eg_br_style.';border-color:'.$eg_border_color.'">
									</div>
								</li>
							</ul>
						</div>';
			}
			$output .='</div></div>';
			return $output;
		}
		function info_circle_item($atts,$content = null)
		{
			global $title_style_inline, $desc_style_inline, $info_circle_id, $info_circle_data_list, $info_circle_desc_data_list;
			// Do nothing
			$info_title = $info_icon = $icon_color = $icon_bg_color = $info_img = $icon_type  = $contents = $radius = $icon_size = $icon_html = $style = $output = $style = $ilink = '';
			extract(shortcode_atts(array(
				'info_title' => '',
				'info_icon' => '',
				'icon_color' => '',
				'icon_bg_color' => '',
				'info_img' => '',
				'icon_type' => 'selector',
				'icon_br_style'=>'none',
				'icon_br_width'=>'1',
				'icon_border_color'=>'',
				'contents' => '',
				'el_class' =>'',
				'ilink' => ''
			), $atts));
			$icon_html = $output = $icon_type_class = '';
			if($icon_type == "selector"){
				$icon_html .= '<i class="'.$info_icon.'" ></i>';
				$icon_type_class = 'ult-info-circle-icon';
			} else {
				$img = apply_filters('ult_get_img_single', $info_img, 'url');
				$alt = apply_filters('ult_get_img_single', $info_img, 'alt');
				if($alt == '')
					$alt = 'icon';
				$icon_html .= '<img class="info-circle-img-icon" alt="'.$alt.'" src="'.apply_filters('ultimate_images', $img).'"/>';
				$icon_type_class = 'ult-info-circle-img';
			}
			if($icon_bg_color!=''){
				$style .='background:'.$icon_bg_color.';';
			}
			else {
				$el_class .= ' info-circle-icon-without-background ';
			}
			if($icon_color!=''){
				$style .='color:'.$icon_color.';';
			}
			if($icon_br_style!='none' && $icon_br_width!='' && $icon_border_color!=''){
				$style.='border-style:'.$icon_br_style.';';
				$style.='border-width:'.$icon_br_width.'px;';
				$style.='border-color:'.$icon_border_color.';';
			}
			$href = vc_build_link($ilink);
			if( !empty($href['url']) ){
				// $href = vc_build_link($ilink);
				if(isset($href['target'])){
									$target = 'target="'.$href['target'].'"';
								}
				$output .= '<div class="info-circle-icons '.$el_class.'" style="'.$style.'"><div class="info-circle-link"><a class="info-circle-href" href="'.$href['url'].'" '.$target.'></a>';
				$output .= $icon_html;
				$output .="</div></div>";
			}
			else{
				$output .= '<div class="info-circle-icons '.$el_class.'" style="'.$style.'">';
				$output .= $icon_html;
				$output .="</div>";
			}
			$output .='<div class="info-details" data-icon-class="'.$icon_type_class.'">';
			//$output .=$icon_html;
			if( !empty($href['url']) ){
				// $href = vc_build_link($ilink);
				if(isset($href['target'])){
									$target = 'target="'.$href['target'].'"';
								}
			$output .='<div class="info-circle-def"><div  class="info-circle-sub-def"><a class="info-circle-href" href="'.$href['url'].'" style="color:inherit;" '.$target.'>'.$icon_html.'</a><div class="responsive-font-class ult-responsive" '.$info_circle_desc_data_list.'><h3 '.$info_circle_data_list.' class="info-circle-heading ult-responsive new-cust-responsive-class" style="'.$title_style_inline.'">'.$info_title.'</h3><div '.$info_circle_desc_data_list.' class="info-circle-text " style="'.$desc_style_inline.'">'.do_shortcode($content).'</div></div></div></div></div>';
						//$output .= wpb_js_remove_wpautop($content, true);
			}else{
				$output .='<div class="info-circle-def"><div  class="info-circle-sub-def">'.$icon_html.'<div class="responsive-font-class ult-responsive" '.$info_circle_desc_data_list.'><h3 '.$info_circle_data_list.' class="info-circle-heading ult-responsive new-cust-responsive-class" style="'.$title_style_inline.'">'.$info_title.'</h3><div '.$info_circle_desc_data_list.' class="info-circle-text " style="'.$desc_style_inline.'">'.do_shortcode($content).'</div></div></div></div></div>';
			}
			return $output;
		}
		function add_info_circle()
		{
			if(function_exists('vc_map'))
			{
				$thumbnail_tab = 'Thumbnail';
				$information_tab = 'Information Area';
				$connector_tab = 'Connector';
				$reponsive_tab = 'Responsive';

				vc_map(
				array(
				   "name" => __("Info Circle","ultimate_vc"),
				   "base" => "info_circle",
				   "class" => "vc_info_circle",
				   "icon" => "vc_info_circle",
				   "category" => "Ultimate VC Addons",
				   "as_parent" => array('only' => 'info_circle_item'),
				   "description" => __("Information Circle","ultimate_vc"),
				   "content_element" => true,
				   "show_settings_on_create" => true,
				   //"is_container"    => true,
				   "params" => array(
						/*array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Circle Type","smile"),
							"param_name" => "circle_type",
							"admin_label" => true,
							"value" => array(
								'Circle' => 'info-c-full-br',
								'Semi Circle' => 'info-c-semi-br',
								),
							"description" => __("Select the Circle Style.","smile")
						),
						*/
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Select area to display thumbnail icons","ultimate_vc"),
							"param_name" => "icon_position",
							"value" => array(
								__('Complete','ultimate_vc') => 'full',
								__('Top','ultimate_vc') => '180',
								__('Bottom','ultimate_vc') => '0',
								__('Left','ultimate_vc') => '90',
								__('Right','ultimate_vc') => '270'
							),
							//"description" => __("Select area to display thumbnail icon .","smile")
						),
						array(
							"type" => "number",
							"class" => "",
							"heading" => __("Clipped Circle","ultimate_vc"),
							"param_name" => "visible_circle",
							"value" => "70",
							"suffix" => "%",
							"dependency" => Array("element" => "icon_position", "value" => array("180","270","90","0") )
							//"description" => __("Select area to display thumbnail icon .","smile")
						),
						/*array(
							"type" => "number",
							"class" => "",
							"heading" => __("Deviation", "smile"),
							"param_name" => "icon_diversion",
							"value" => 0,
							"suffix" => "px",
							"description" => __("Deviation from initial point.", "smile"),
						),*/
						array(
							"type" => "number",
							"class" => "",
							"heading" => __("Size of Information Circle", "ultimate_vc"),
							"param_name" => "edge_radius",
							"value" => 80,
							"suffix" => "%",
							"description" => __("Size of circle relative to container width.", "ultimate_vc"),
						),
						array(
							"type" => "number",
							"class" => "",
							"heading" => __("Position of First Thumbnail", "ultimate_vc"),
							"param_name" => "start_degree",
							"value" => 90,
							"max" => 360,
							"suffix" => "&deg; degree",
							"description" => __("The degree from where Info Circle will be displayed.", "ultimate_vc"),
							"dependency" => Array("element" => "icon_position", "value" => array("full")),
							"group" => $thumbnail_tab
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Distance Between Thumbnails & Information Circle", "ultimate_vc"),
							"param_name" => "eg_padding",
							"value" => array(
								__("Extra large","ultimate_vc")=>"50",
								__("Large","ultimate_vc")=>"60",
								__("Medium","ultimate_vc")=>"70",
								__("Small","ultimate_vc")=>"80",
							),
							//"description" => __("Distance between Information Cirlce and Thumbnails.", "smile"),
						),
						array(
							"type" => "number",
							"class" => "",
							"heading" => __("Thumbnail Icon Size", "ultimate_vc"),
							"param_name" => "icon_size",
							"value" => 32,
							"suffix" => "px",
							"group" => $thumbnail_tab
							//"description" => __("Size of the thumbnails.", "smile"),
						),
						array(
							"type" => "number",
							"class" => "",
							"heading" => __("Responseve Icon/image Size", "ultimate_vc"),
							"param_name" => "img_icon_size",
							"value" => 32,
							"suffix" => "px",
							"dependency" => Array("element" => "responsive", "value" => array("on")),
							"group" => $thumbnail_tab,
							"description" => __("This size of the thumbnails on breakpoint.", "smile"),
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Display Icon","ultimate_vc"),
							"param_name" => "icon_show",
							"value" => array(
								__('Yes','ultimate_vc') => 'show',
								__('No','ultimate_vc') => 'not-show',
								),
							"description" => __("Select whether you want to show icon in information circle.","ultimate_vc"),
							"group" => $information_tab
						),
						array(
							"type" => "number",
							"class" => "",
							"heading" => __("Icon Size", "ultimate_vc"),
							"param_name" => "content_icon_size",
							"value" => 32,
							"suffix"=>"px",
							"dependency" => Array("element" => "icon_show","value" => array("show")),
							"group" => $information_tab
							//"description" => __("Select the icon size inside information circle.", "smile"),
						),
						array(
							"type" => "colorpicker",
							"class" => "",
							"heading" => __("Background Color", "ultimate_vc"),
							"param_name" => "content_bg",
							"value" => "",
							"group" => $information_tab
							//"description" => __("Select the background color for information circle.", "smile"),
						),
						array(
							"type" => "colorpicker",
							"class" => "",
							"heading" => __("Text Color", "ultimate_vc"),
							"param_name" => "content_color",
							"value" => "",
							"group" => $information_tab
							//"description" => __("Select the text color for information circle.", "smile"),
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Line Style", "ultimate_vc"),
							"param_name" => "eg_br_style",
							"value" => array(
								__("None","ultimate_vc") => "none",
								__("Solid","ultimate_vc")	=> "solid",
								__("Dashed","ultimate_vc") => "dashed",
								__("Dotted","ultimate_vc") => "dotted",
							),
							"group" => $connector_tab
							//"description" => __("Select the style for Thumbnail Connector.","smile"),
						),
						array(
							"type" => "number",
							"class" => "",
							"heading" => __("Line Width", "ultimate_vc"),
							"param_name" => "eg_br_width",
							"value" => 1,
							"min" => 0,
							"max" => 10,
							"suffix" => "px",
							//"description" => __("Thickness of the Thumbnail Connector line.", "smile"),
							"dependency" => Array("element" => "eg_br_style","value" => array("solid","dashed","dotted")),
							"group" => $connector_tab
						),
						array(
							"type" => "colorpicker",
							"class" => "",
							"heading" => __("Line Color", "ultimate_vc"),
							"param_name" => "eg_border_color",
							"value" => "",
							//"description" => __("Select the color for thumbnail connector.", "smile"),
							"dependency" => Array("element" => "eg_br_style","value" => array("solid","dashed","dotted")),
							"group" => $connector_tab
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Border Style", "ultimate_vc"),
							"param_name" => "cn_br_style",
							"value" => array(
								__("None","ultimate_vc") => "none",
								__("Solid","ultimate_vc")	=> "solid",
								__("Dashed","ultimate_vc") => "dashed",
								__("Dotted","ultimate_vc") => "dotted",
								__("Double","ultimate_vc") => "double",
								__("Inset","ultimate_vc") => "inset",
								__("Outset","ultimate_vc") => "outset",
							),
							"group" => $information_tab
							//"description" => __("Select the border style for information circle.","smile"),
						),
						array(
							"type" => "number",
							"class" => "",
							"heading" => __("Border Width", "ultimate_vc"),
							"param_name" => "cn_br_width",
							"value" => 1,
							"min" => 0,
							"max" => 10,
							"suffix" => "px",
							//"description" => __("Thickness of information Cirlce border.", "smile"),
							"dependency" => Array("element" => "cn_br_style","value" => array("solid","dashed","dotted","double","inset","outset")),
							"group" => $information_tab
						),
						array(
							"type" => "colorpicker",
							"class" => "",
							"heading" => __("Border color", "ultimate_vc"),
							"param_name" => "cn_border_color",
							"value" => "",
							//"description" => __("Border color of information circle.", "smile"),
							"dependency" => Array("element" => "cn_br_style","value" => array("solid","dashed","dotted","double","inset","outset")),
							"group" => $information_tab
						),


						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Appear Information Circle on","ultimate_vc"),
							"param_name" => "focus_on",
							"value" => array(
								__('Hover','ultimate_vc') => 'hover',
								__('Click','ultimate_vc') => 'click',
								//	'None' => '',
								),
							"description" => __("Select on which event information should appear in information circle.","ultimate_vc")
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Autoplay", "ultimate_vc"),
							"param_name" => "auto_slide",
							"value" => array(
								__("No","ultimate_vc")	=> "off",
								__("Yes","ultimate_vc") => "on",
							),
							//"description" => __("Select whether information will be shown into circle.","smile"),
						),
						array(
							"type" => "number",
							"class" => "",
							"heading" => __("Autoplay Time", "ultimate_vc"),
							"param_name" => "auto_slide_duration",
							"value" => 3,
							"suffix" => "seconds",
							"description" => __("Duration before info circle should display next information on thumbnails.", "ultimate_vc"),
							"dependency" => Array("element" => "auto_slide","value" => array("on")),
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Animation of Active Thumbnail", "ultimate_vc"),
							"param_name" => "highlight_style",
							"value" => array(
								__("None","ultimate_vc") =>'info-circle-highlight-style',
								//"Buzz Out"=>"info-circle-buzz-out",
								__("Zoom InOut","ultimate_vc")=>"info-circle-pulse",
								__("Zoom Out","ultimate_vc")=>"info-circle-push",
								__("Zoom In","ultimate_vc")=>"info-circle-pop",
								//"Rotate"=>"info-circle-rotate",
								),
							"description" => __("Select animation style for active thumbnails.", "ultimate_vc"),
							"group" => $thumbnail_tab
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Animation of Thumbnails when Page Loads", "ultimate_vc"),
							"param_name" => "icon_launch",
							"value" => array(
								__("None","ultimate_vc") =>'',
								__("Linear","ultimate_vc")=>"linear",
								__("Elastic","ultimate_vc")=>"easeOutElastic",
								__("Bounce","ultimate_vc")=>"easeOutBounce",
								),
							"description" => __("Select Animation Style.", "ultimate_vc"),
							"group" => $thumbnail_tab
						),
						array(
							"type" => "number",
							"class" => "",
							"heading" => __("Animation Duration", "ultimate_vc"),
							"param_name" => "icon_launch_duration",
							"value" => 1,
							"suffix" => "seconds",
							"description" => __("Specify animation duration.", "ultimate_vc"),
							"dependency" => Array("element" => "icon_launch","not_empty"=>true),
							"group" => $thumbnail_tab
						),
						array(
							"type" => "number",
							"class" => "",
							"heading" => __("Animation Delay", "ultimate_vc"),
							"param_name" => "icon_launch_delay",
							"value" => 0.2,
							"suffix" => "seconds",
							"description" => __("Delay of animatin start in-between thumbnails.", "ultimate_vc"),
							"dependency" => Array("element" => "icon_launch","not_empty"=>true),
							"group" => $thumbnail_tab
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Responsive Nature", "ultimate_vc"),
							"param_name" => "responsive",
							"value" => array(
								__('True','ultimate_vc') => 'on',
								__('False','ultimate_vc') => 'off',
								),
							"description" => __("Select true to change its display style on low resolution.", "ultimate_vc"),
							//"group" => $reponsive_tab
						),
						array(
							"type" => "number",
							"class" => "",
							"heading" => __("Breakpoint", "ultimate_vc"),
							"param_name" => "responsive_breakpoint",
							"value" => 800,
							"suffix" => "px",
							"description" => __("Break point is the point of screen resolution from where you can set your info-circle style into list style to the minimum screen resolution.", "smile"),
							"dependency" => Array("element" => "responsive", "value" => array("on")),
							//"group" => $reponsive_tab
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Extra Class", "ultimate_vc"),
							"param_name" => "el_class",
							"value" => "",
							"description" => __("Custom class.", "ultimate_vc"),
						),
						array(
							"type" => "ult_param_heading",
							"text" => __("Title Settings","ultimate_vc"),
							"param_name" => "title_typography",
							//"dependency" => Array("element" => "main_heading", "not_empty" => true),
							"group" => "Typography",
							"class" => "ult-param-heading",
							'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
						),
						array(
							"type" => "ultimate_google_fonts",
							"heading" => __("Font Family", "ultimate_vc"),
							"param_name" => "title_font",
							"group" => "Typography",
						),
						array(
							"type" => "ultimate_google_fonts_style",
							"heading" 		=>	__("Font Style", "ultimate_vc"),
							"param_name"	=>	"title_font_style",
							"group" => "Typography",
						),
						// array(
						// 	"type" => "number",
						// 	"class" => "font-size",
						// 	"heading" => __("Font Size", "ultimate_vc"),
						// 	"param_name" => "title_font_size",
						// 	"value" => "",
						// 	"suffix" => "px",
						// 	"group" => "Typography"
						// ),
						// array(
						// 	"type" => "number",
						// 	"class" => "",
						// 	"heading" => __("Line Height", "ultimate_vc"),
						// 	"param_name" => "title_line_height",
						// 	"value" => "",
						// 	"suffix" => "px",
						// 	"group" => "Typography"
						// ),
						array(
		                    "type" => "ultimate_responsive",
		                    "class" => "font-size",
		                    "heading" => __("Font size", 'ultimate_vc'),
		                    "param_name" => "title_font_size",
		                    "unit" => "px",
		                    "media" => array(
		                        "Desktop" => '',
		                        "Tablet" => '',
		                        "Tablet Portrait" => '',
		                        "Mobile Landscape" => '',
		                        "Mobile" => '',
			                    ),
			                    "group" => "Typography",
			                ),
			                array(
		                    "type" => "ultimate_responsive",
		                    "class" => "",
		                    "heading" => __("Line Height", 'ultimate_vc'),
		                    "param_name" => "title_line_height",
		                    "unit" => "px",
		                    "media" => array(
		                        "Desktop" => '',
		                        "Tablet" => '',
		                        "Tablet Portrait" => '',
		                        "Mobile Landscape" => '',
		                        "Mobile" => '',
			                    ),
			                    "group" => "Typography",
			                ),
						array(
							"type" => "ult_param_heading",
							"text" => __("Description Settings","ultimate_vc"),
							"param_name" => "desc_typography",
							//"dependency" => Array("element" => "main_heading", "not_empty" => true),
							"group" => "Typography",
							"class" => "ult-param-heading",
							'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
						),
						array(
							"type" => "ultimate_google_fonts",
							"heading" => __("Font Family", "ultimate_vc"),
							"param_name" => "desc_font",
							"group" => "Typography",
						),
						array(
							"type" => "ultimate_google_fonts_style",
							"heading" 		=>	__("Font Style", "ultimate_vc"),
							"param_name"	=>	"desc_font_style",
							"group" => "Typography",
						),
						// array(
						// 	"type" => "number",
						// 	"class" => "font-size",
						// 	"heading" => __("Font Size", "ultimate_vc"),
						// 	"param_name" => "desc_font_size",
						// 	"suffix" => "px",
						// 	"value" => "",
						// 	"group" => "Typography"
						// ),
						// array(
						// 	"type" => "number",
						// 	"class" => "",
						// 	"heading" => __("Line Height", "ultimate_vc"),
						// 	"param_name" => "desc_line_height",
						// 	"value" => "",
						// 	"suffix" => "px",
						// 	"group" => "Typography"
						// ),
						array(
		                    "type" => "ultimate_responsive",
		                    "class" => "font-size",
		                    "heading" => __("Font size", 'ultimate_vc'),
		                    "param_name" => "desc_font_size",
		                    "unit" => "px",
		                    "media" => array(
		                        "Desktop" => '',
		                        "Tablet" => '',
		                        "Tablet Portrait" => '',
		                        "Mobile Landscape" => '',
		                        "Mobile" => '',
			                    ),
			                    "group" => "Typography",
			                ),
			                array(
		                    "type" => "ultimate_responsive",
		                    "class" => "",
		                    "heading" => __("Line Height", 'ultimate_vc'),
		                    "param_name" => "desc_line_height",
		                    "unit" => "px",
		                    "media" => array(
		                        "Desktop" => '',
		                        "Tablet" => '',
		                        "Tablet Portrait" => '',
		                        "Mobile Landscape" => '',
		                        "Mobile" => '',
			                    ),
			                    "group" => "Typography",
			                ),
						array(
							"type" => "ult_param_heading",
							"text" => "<span style='display: block;'><a href='http://bsf.io/z-dpz' target='_blank'>".__("Watch Video Tutorial","ultimate_vc")." &nbsp; <span class='dashicons dashicons-video-alt3' style='font-size:30px;vertical-align: middle;color: #e52d27;'></span></a></span>",
							"param_name" => "notification",
							'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
						),
					),
					"js_view" => 'VcColumnView',
				));
				// Add list item
				vc_map(
					array(
					   "name" => __("Info Circle Item","ultimate_vc"),
					   "base" => "info_circle_item",
					   "class" => "vc_info_circle_item",
					   "icon" => "vc_info_circle_item",
					   "category" => "Ultimate VC Addons",
					   "content_element" => true,
					   "as_child" => array('only' => 'info_circle'),
					   "is_container"    => false,
					   "params" => array(
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Title","ultimate_vc"),
							"param_name" => "info_title",
							"value" => "",
							"admin_label" => true,
							//"description" => __("Provide a title for this info circle item.","smile")
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Icon to display", "ultimate_vc"),
							"param_name" => "icon_type",
							"value" => array(
								__("Font Icon Manager","ultimate_vc") => "selector",
								__("Custom Image Icon","ultimate_vc") => "custom",
							),
							"description" => __("Use existing font icon or upload a custom image.", "ultimate_vc"),
							"group" => __("Design")
						),
						array(
							"type" => "icon_manager",
							"class" => "",
							"heading" => __("Select Icon For Information Circle & Thumbnail ","ultimate_vc"),
							"param_name" => "info_icon",
							"value" => "",
							"description" => __("Click and select icon of your choice. If you can't find the one that suits for your purpose","ultimate_vc").", ".__("you can","ultimate_vc")." <a href='admin.php?page=bsf-font-icon-manager' target='_blank'>".__("add new here","ultimate_vc")."</a>.",
							"dependency" => Array("element" => "icon_type","value" => array("selector")),
							"group" => __("Design")
						),
						array(
							"type" => "ult_img_single",
							"class" => "",
							"heading" => __("Upload Image Icon", "ultimate_vc"),
							"param_name" => "info_img",
							"admin_label" => true,
							"value" => "",
							"description" => __("Upload the custom image icon.", "ultimate_vc"),
							"dependency" => Array("element" => "icon_type","value" => array("custom")),
							"group" => __("Design")
						),
						array(
							"type" => "colorpicker",
							"class" => "",
							"heading" => __("Icon Background Color", "ultimate_vc"),
							"param_name" => "icon_bg_color",
							"value" => "",
							"description" => __("Select the color for icon background.", "ultimate_vc"),
							"group" => __("Design")
						),
						array(
							"type" => "colorpicker",
							"class" => "",
							"heading" => __("Icon Color", "ultimate_vc"),
							"param_name" => "icon_color",
							"value" => "",
							"description" => __("Select the color for icon.", "ultimate_vc"),
							"group" => __("Design")
						),
						array(
							"type" => "textarea_html",
							"class" => "",
							"heading" => __("Description","ultimate_vc"),
							"param_name" => "content",
							"value" => "",
							//"description" => __("Description about this  item","smile")
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Border Style", "ultimate_vc"),
							"param_name" => "icon_br_style",
							"value" => array(
								__("None","ultimate_vc") => "none",
								__("Solid","ultimate_vc")	=> "solid",
								__("Dashed","ultimate_vc") => "dashed",
								__("Dotted","ultimate_vc") => "dotted",
								__("Double","ultimate_vc") => "double",
								__("Inset","ultimate_vc") => "inset",
								__("Outset","ultimate_vc") => "outset",
							),
							"group" => __("Design")
							//"description" => __("Select the border style for icon.","smile"),
						),
						array(
							"type" => "number",
							"class" => "",
							"heading" => __("Border Thickness", "ultimate_vc"),
							"param_name" => "icon_br_width",
							"value" => 1,
							"min" => 0,
							"max" => 10,
							"suffix" => "px",
							//"description" => __("Thickness of the border.", "smile"),
							"dependency" => Array("element" => "icon_br_style","value" => array("solid","dashed","dotted","double","inset","outset")),
							"group" => __("Design")
						),
						array(
							"type" => "colorpicker",
							"class" => "",
							"heading" => __("Border Color", "ultimate_vc"),
							"param_name" => "icon_border_color",
							"value" => "",
							//"description" => __("Select the color border.", "smile"),
							"dependency" => Array("element" => "icon_br_style","value" => array("solid","dashed","dotted","double","inset","outset")),
							"group" => __("Design")
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Extra Class", "ultimate_vc"),
							"param_name" => "el_class",
							"value" => "",
							"description" => __("Custom class.", "ultimate_vc"),
						),
						array(
							"type" => "vc_link",
							"class" => "",
							"heading" => __("Link", "ultimate_vc"),
							"param_name" => "ilink",
							"value" => "",
							"description" => __("Add link to Icon/image on Info Circle", "ultimate_vc")
						),
					   )
					)
				);
			}//endif
		}
	}
}
if(class_exists('WPBakeryShortCodesContainer'))
{
	class WPBakeryShortCode_info_circle extends WPBakeryShortCodesContainer {
	}
	class WPBakeryShortCode_info_circle_item extends WPBakeryShortCode {
	}
}
if(class_exists('Ultimate_Info_Circle'))
{
	$Ultimate_Info_Circle = new Ultimate_Info_Circle;
}