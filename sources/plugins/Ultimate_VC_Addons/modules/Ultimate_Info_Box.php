<?php
/*
* Add-on Name: Info Box
* Add-on URI: https://www.brainstormforce.com
*/
if(!class_exists('AIO_Icons_Box'))
{
	class AIO_Icons_Box
	{
		function __construct()
		{
			// Add shortcode for icon box
			add_shortcode('bsf-info-box', array(&$this, 'icon_boxes' ) );
			// Initialize the icon box component for Visual Composer
			add_action('init', array( &$this, 'icon_box_init' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'icon_box_scripts' ), 1 );
		}
		// Add shortcode for icon-box
		function icon_boxes($atts, $content = null)
		{
			$icon_type = $icon_img = $img_width = $icon = $icon_color = $icon_color_bg = $icon_size = $icon_style = $icon_border_style = $icon_border_radius = $icon_color_border = $icon_border_size = $icon_border_spacing = $el_class = $icon_animation = $title = $link = $hover_effect = $pos = $read_more= $read_text = $box_border_style = $box_border_width =$box_border_color = $box_bg_color = $pos = $css_class = $desc_font_line_height = $title_font_line_height = '';
			$title_font = $title_font_style = $title_font_size = $title_font_color = $desc_font = $desc_font_style = $desc_font_size = $desc_font_color = $box_min_height = '';
			extract(shortcode_atts(array(
				'icon_type' => 'selector',
				'icon' => 'none',
				'icon_img' => '',
				'img_width' => '48',
				'icon_size' => '32',
				'icon_color' => '#333',
				'icon_style' => 'none',
				'icon_color_bg' => '#ffffff',
				'icon_color_border' => '#333333',
				'icon_border_style' => '',
				'icon_border_size' => '1',
				'icon_border_radius' => '500',
				'icon_border_spacing' => '50',
				'icon_animation' => '',
				'title'	  => '',
				'link'	   => '',
				'hover_effect' => 'style_1',
				'pos'	    => 'default',
				'box_min_height' => '',
				'box_border_style'=>'',
				'box_border_width'=>'',
				'box_border_color'=>'',
				'box_bg_color'=>"",
				'read_more'  => 'none',
				'read_text'  => 'Read More',
				'title_font' => '',
				'title_font_style' => '',
				'title_font_size' => '',
				'title_font_line_height'=> '',
				'title_font_color' => '',
				'desc_font' => '',
				'desc_font_style' => '',
				'desc_font_size' => '',
				'desc_font_color' => '',
				'desc_font_line_height'=> '',
				'el_class'	  => '',
				'css_info_box' => '',
				),$atts,'bsf-info-box'));
			$html = $target = $suffix = $prefix = $title_style = $desc_style = $inf_design_style = '';
			$inf_design_style = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css_info_box, ' ' ), "bsf-info-box", $atts );
 			$inf_design_style = esc_attr( $inf_design_style );
			//$font_args = array();
			//echo $pos; die();
			$box_icon = do_shortcode('[just_icon icon_type="'.$icon_type.'" icon="'.$icon.'" icon_img="'.$icon_img.'" img_width="'.$img_width.'" icon_size="'.$icon_size.'" icon_color="'.$icon_color.'" icon_style="'.$icon_style.'" icon_color_bg="'.$icon_color_bg.'" icon_color_border="'.$icon_color_border.'"  icon_border_style="'.$icon_border_style.'" icon_border_size="'.$icon_border_size.'" icon_border_radius="'.$icon_border_radius.'" icon_border_spacing="'.$icon_border_spacing.'" icon_animation="'.$icon_animation.'"]');
			$prefix .= '<div class="aio-icon-component '.$inf_design_style.' '.$css_class.' '.$el_class.' '.$hover_effect.'">';
			$suffix .= '</div> <!-- aio-icon-component -->';
			$ex_class = $ic_class = '';
			if($pos != ''){
				$ex_class .= $pos.'-icon';
				$ic_class = 'aio-icon-'.$pos;
			}

			/* title */
			if($title_font != '')
			{
				$font_family = get_ultimate_font_family($title_font);
				if($font_family != '')
					$title_style .= 'font-family:\''.$font_family.'\';';
				//array_push($font_args, $title_font);
			}
			if($title_font_style != '')
				$title_style .= get_ultimate_font_style($title_font_style);
			// if($title_font_size != '')
			// 	$title_style .= 'font-size:'.$title_font_size.'px;';
			// if($title_font_line_height != '')
			// 	$title_style .= 'line-height:'.$title_font_line_height.'px;';

			if(is_numeric($title_font_size)){
				$title_font_size = 'desktop:'.$title_font_size.'px;';
			}
			if(is_numeric($title_font_line_height)){
				$title_font_line_height = 'desktop:'.$title_font_line_height.'px;';
			}
			$info_box_id = 'Info-box-wrap-'.rand(1000, 9999);
			$info_box_args = array(
                'target' => '#'.$info_box_id.' .aio-icon-title', // set targeted element e.g. unique class/id etc.
                'media_sizes' => array(
                    'font-size' => $title_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
                   	'line-height' => $title_font_line_height
                ),
            );
            $info_box_data_list = get_ultimate_vc_responsive_media_css($info_box_args);

			if($title_font_color != '')
				$title_style .= 'color:'.$title_font_color.';';

			/* description */
			if($desc_font != '')
			{
				$font_family = get_ultimate_font_family($desc_font);
				if($font_family !== '')
					$desc_style .= 'font-family:\''.$font_family.'\';';
				//array_push($font_args, $desc_font);
			}
			if($desc_font_style != '')
				$desc_style .= get_ultimate_font_style($desc_font_style);
			// if($desc_font_size != '')
			// 	$desc_style .= 'font-size:'.$desc_font_size.'px;';
			// if($desc_font_line_height != '')
			// 	$desc_style .= 'line-height:'.$desc_font_line_height.'px;';

			if(is_numeric($desc_font_size)){
				$desc_font_size = 'desktop:'.$desc_font_size.'px;';
			}
			if(is_numeric($desc_font_line_height)){
				$desc_font_line_height = 'desktop:'.$desc_font_line_height.'px;';
			}

			$info_box_desc_args = array(
                'target' => '#'.$info_box_id.' .aio-icon-description', // set targeted element e.g. unique class/id etc.
                'media_sizes' => array(
                    'font-size' => $desc_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
                   	'line-height' => $desc_font_line_height
                ),
            );
            $info_box_desc_data_list = get_ultimate_vc_responsive_media_css($info_box_desc_args);
			if($desc_font_color != '')
				$desc_style .= 'color:'.$desc_font_color.';';
			//enquque_ultimate_google_fonts($font_args);

			$box_style = $box_style_data = '';
			if($pos=='square_box'){
				if($box_min_height!='') {
					$box_style_data .="data-min-height='".$box_min_height."px'";
				}
				if($box_border_color!=''){
					$box_style .="border-color:".$box_border_color.";";
				}
				if($box_border_style!=''){
					$box_style .="border-style:".$box_border_style.";";
				}
				if($box_border_width!=''){
					$box_style .="border-width:".$box_border_width."px;";
				}
				if($box_bg_color!=''){
					$box_style .="background-color:".$box_bg_color.";";
				}
			}
			$html .= '<div id="'.$info_box_id.'" class="aio-icon-box '.$ex_class.'" style="'.$box_style.'" '.$box_style_data.' >';

			if($pos == "heading-right" || $pos == "right"){
					if($pos == "right"){
						$html .= '<div class="aio-ibd-block" >';
					}
					if($title !== ''){
						$html .= '<div class="aio-icon-header" >';
						$link_prefix = $link_sufix = '';
						if($link !== 'none'){
							if($read_more == 'title')
							{
								$href = vc_build_link($link);
								if(isset($href['target']) && trim($href['target']) !== ''){
									$target = 'target="'.$href['target'].'"';
								}
								$link_prefix = '<a class="aio-icon-box-link" href="'.$href['url'].'" '.$target.'>';
								$link_sufix = '</a>';
							}
						}
						$html .= $link_prefix.'<h3 class="aio-icon-title ult-responsive" '.$info_box_data_list.' style="'.$title_style.'">'.$title.'</h3>'.$link_sufix;
						$html .= '</div> <!-- header -->';
					}
					if($pos !== "right"){
						if($icon !== 'none' || $icon_img !== '')
							$html .= '<div class="'.$ic_class.'" >'.$box_icon.'</div>';
					}
					if($content !== ''){
						$html .= '<div class="aio-icon-description ult-responsive" '.$info_box_desc_data_list.' style="'.$desc_style.'">';
						$html .= do_shortcode($content);
						if($link !== 'none'){
							if($read_more == 'more')
							{
								$href = vc_build_link($link);
								if(isset($href['target']) && $href['target'] != ''){
									$target = 'target="'.$href['target'].'"';
								}
								$more_link = '<a class="aio-icon-read x" href="'.$href['url'].'" '.$target.'>';
								$more_link .= $read_text;
								$more_link .= '&nbsp;&raquo;';
								$more_link .= '</a>';
								$html .= $more_link;
							}
						}
						$html .= '</div> <!-- description -->';
					}
					if($pos == "right"){
						$html .= '</div> <!-- aio-ibd-block -->';
						if($icon !== 'none' || $icon_img !== '')
							$html .= '<div class="'.$ic_class.'">'.$box_icon.'</div>';
					}

				}
				else {
					//echo $icon_img; die();
					if($icon !== 'none' || $icon_img != '')
						$html .= '<div class="'.$ic_class.'">'.$box_icon.'</div>';
					if($pos == "left")
						$html .= '<div class="aio-ibd-block">';
					if($title !== ''){
						$html .= '<div class="aio-icon-header" >';
						$link_prefix = $link_sufix = '';
						if($link !== 'none'){
							if($read_more == 'title')
							{
								$href = vc_build_link($link);
								if(isset($href['target']) && trim($href['target']) !== ''){
									$target = 'target="'.$href['target'].'"';
								}
								$link_prefix = '<a class="aio-icon-box-link" href="'.$href['url'].'" '.$target.'>';
								$link_sufix = '</a>';
							}
						}
						$html .= $link_prefix.'<h3 class="aio-icon-title ult-responsive" '.$info_box_data_list.' style="'.$title_style.'">'.$title.'</h3>'.$link_sufix;
						$html .= '</div> <!-- header -->';
					}
					if($content !== ''){
						$html .= '<div class="aio-icon-description ult-responsive" '.$info_box_desc_data_list.' style="'.$desc_style.'">';
						$html .= do_shortcode($content);
						if($link !== 'none'){
							if($read_more == 'more')
							{
								$href = vc_build_link($link);
								if(isset($href['target']) && trim($href['target']) != ''){
									$target = 'target="'.$href['target'].'"';
								}
								$more_link = '<a class="aio-icon-read xx" href="'.$href['url'].'" '.$target.'>';
								$more_link .= $read_text;
								$more_link .= '&nbsp;&raquo;';
								$more_link .= '</a>';
								$html .= $more_link;
							}
						}
						$html .= '</div> <!-- description -->';
					}
					if($pos == "left")
						$html .= '</div> <!-- aio-ibd-block -->';

				}


			$html .= '</div> <!-- aio-icon-box -->';
			if($link !== 'none'){
				if($read_more == 'box')
				{
					$href = vc_build_link($link);
					if(isset($href['target']) && trim($href['target']) !== ''){
						$target = 'target="'.$href['target'].'"';
					}
					$output = $prefix.'<a class="aio-icon-box-link" href="'.$href['url'].'" '.$target.'>'.$html.'</a>'.$suffix;
				} else {
					$output = $prefix.$html.$suffix;
				}
			} else {
				$output = $prefix.$html.$suffix;
			}
			$is_preset = false; //Display settings for Preset
			if(isset($_GET['preset'])) {
				$is_preset = true;
			}
			if($is_preset) {
				$text = 'array ( ';
				foreach ($atts as $key => $att) {
					$text .= '<br/>	\''.$key.'\' => \''.$att.'\',';
				}
				if($content != '') {
					$text .= '<br/>	\'content\' => \''.$content.'\',';
				}
				$text .= '<br/>)';
				$output .= '<pre>';
				$output .= $text;
				$output .= '</pre>';
			}
			return $output;
		}
		/* Add icon box Component*/
		function icon_box_init()
		{
			if ( function_exists('vc_map'))
			{
				vc_map(
					array(
						"name"		=> __("Info Box", "ultimate_vc"),
						"base"		=> "bsf-info-box",
						"icon"		=> "vc_info_box",
						"class"	   => "info_box",
						"category"  => "Ultimate VC Addons",
						"description" => __("Adds icon box with custom font icon","ultimate_vc"),
						"controls" => "full",
						"show_settings_on_create" => true,
						"params" => array(
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Icon to display:", "ultimate_vc"),
								"param_name" => "icon_type",
								"value" => array(
									__("Font Icon Manager","ultimate_vc") => "selector",
									__("Custom Image Icon","ultimate_vc") => "custom",
								),
								"description" => __("Use an existing font icon or upload a custom image.", "ultimate_vc")
							),
							array(
								"type" => "icon_manager",
								"class" => "",
								"heading" => __("Select Icon ","ultimate_vc"),
								"param_name" => "icon",
								"value" => "",
								"description" => __("Click and select icon of your choice. If you can't find the one that suits for your purpose","ultimate_vc").", ".__("you can","ultimate_vc")." <a href='admin.php?page=bsf-font-icon-manager' target='_blank'>".__("add new here","ultimate_vc")."</a>.",
								"dependency" => Array("element" => "icon_type","value" => array("selector")),
							),
							array(
								"type" => "ult_img_single",
								"class" => "",
								"heading" => __("Upload Image Icon:", "ultimate_vc"),
								"param_name" => "icon_img",
								"value" => "",
								"description" => __("Upload the custom image icon.", "ultimate_vc"),
								"dependency" => Array("element" => "icon_type","value" => array("custom")),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Image Width", "ultimate_vc"),
								"param_name" => "img_width",
								"value" => 48,
								"min" => 16,
								"max" => 512,
								"suffix" => "px",
								"description" => __("Provide image width", "ultimate_vc"),
								"dependency" => Array("element" => "icon_type","value" => array("custom")),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Size of Icon", "ultimate_vc"),
								"param_name" => "icon_size",
								"value" => 32,
								"min" => 12,
								"max" => 72,
								"suffix" => "px",
								"description" => __("How big would you like it?", "ultimate_vc"),
								"dependency" => Array("element" => "icon_type","value" => array("selector")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Color", "ultimate_vc"),
								"param_name" => "icon_color",
								"value" => "#333333",
								"description" => __("Give it a nice paint!", "ultimate_vc"),
								"dependency" => Array("element" => "icon_type","value" => array("selector")),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Icon Style", "ultimate_vc"),
								"param_name" => "icon_style",
								"value" => array(
									__("Simple","ultimate_vc") => "none",
									__("Circle Background","ultimate_vc") => "circle",
									__("Square Background","ultimate_vc") => "square",
									__("Design your own","ultimate_vc") => "advanced",
								),
								"description" => __("We have given three quick preset if you are in a hurry. Otherwise, create your own with various options.", "ultimate_vc"),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Background Color", "ultimate_vc"),
								"param_name" => "icon_color_bg",
								"value" => "#ffffff",
								"description" => __("Select background color for icon.", "ultimate_vc"),
								"dependency" => Array("element" => "icon_style", "value" => array("circle","square","advanced")),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Icon Border Style", "ultimate_vc"),
								"param_name" => "icon_border_style",
								"value" => array(
									__("None","ultimate_vc") => "",
									__("Solid","ultimate_vc") => "solid",
									__("Dashed","ultimate_vc") => "dashed",
									__("Dotted","ultimate_vc") => "dotted",
									__("Double","ultimate_vc") => "double",
									__("Inset","ultimate_vc") => "inset",
									__("Outset","ultimate_vc") => "outset",
								),
								"description" => __("Select the border style for icon.","ultimate_vc"),
								"dependency" => Array("element" => "icon_style", "value" => array("advanced")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Border Color", "ultimate_vc"),
								"param_name" => "icon_color_border",
								"value" => "#333333",
								"description" => __("Select border color for icon.", "ultimate_vc"),
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Border Width", "ultimate_vc"),
								"param_name" => "icon_border_size",
								"value" => 1,
								"min" => 1,
								"max" => 10,
								"suffix" => "px",
								"description" => __("Thickness of the border.", "ultimate_vc"),
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Border Radius", "ultimate_vc"),
								"param_name" => "icon_border_radius",
								"value" => 500,
								"min" => 1,
								"max" => 500,
								"suffix" => "px",
								"description" => __("0 pixel value will create a square border. As you increase the value, the shape convert in circle slowly. (e.g 500 pixels).", "ultimate_vc"),
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Background Size", "ultimate_vc"),
								"param_name" => "icon_border_spacing",
								"value" => 50,
								"min" => 30,
								"max" => 500,
								"suffix" => "px",
								"description" => __("Spacing from center of the icon till the boundary of border / background", "ultimate_vc"),
								"dependency" => Array("element" => "icon_style", "value" => array("advanced")),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Animation","ultimate_vc"),
								"param_name" => "icon_animation",
								"value" => array(
							 		__("No Animation","ultimate_vc") => "",
									__("Swing","ultimate_vc") => "swing",
									__("Pulse","ultimate_vc") => "pulse",
									__("Fade In","ultimate_vc") => "fadeIn",
									__("Fade In Up","ultimate_vc") => "fadeInUp",
									__("Fade In Down","ultimate_vc") => "fadeInDown",
									__("Fade In Left","ultimate_vc") => "fadeInLeft",
									__("Fade In Right","ultimate_vc") => "fadeInRight",
									__("Fade In Up Long","ultimate_vc") => "fadeInUpBig",
									__("Fade In Down Long","ultimate_vc") => "fadeInDownBig",
									__("Fade In Left Long","ultimate_vc") => "fadeInLeftBig",
									__("Fade In Right Long","ultimate_vc") => "fadeInRightBig",
									__("Slide In Down","ultimate_vc") => "slideInDown",
									__("Slide In Left","ultimate_vc") => "slideInLeft",
									__("Slide In Left","ultimate_vc") => "slideInLeft",
									__("Bounce In","ultimate_vc") => "bounceIn",
									__("Bounce In Up","ultimate_vc") => "bounceInUp",
									__("Bounce In Down","ultimate_vc") => "bounceInDown",
									__("Bounce In Left","ultimate_vc") => "bounceInLeft",
									__("Bounce In Right","ultimate_vc") => "bounceInRight",
									__("Rotate In","ultimate_vc") => "rotateIn",
									__("Light Speed In","ultimate_vc") => "lightSpeedIn",
									__("Roll In","ultimate_vc") => "rollIn",
									),
								"description" => __("Like CSS3 Animations? We have several options for you!","ultimate_vc")
						  	),
							// Icon Box Heading
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Title", "ultimate_vc"),
								"param_name" => "title",
								"admin_label" => true,
								"value" => "",
								"description" => __("Provide the title for this icon box.", "ultimate_vc"),
							),
							// Add some description
							array(
								"type" => "textarea_html",
								"class" => "",
								"heading" => __("Description", "ultimate_vc"),
								"param_name" => "content",
								"value" => "",
								"description" => __("Provide the description for this icon box.", "ultimate_vc"),
								"edit_field_class" => "ult_hide_editor_fullscreen vc_col-xs-12 vc_column wpb_el_type_textarea_html vc_wrapper-param-type-textarea_html vc_shortcode-param",
							),
							// Select link option - to box or with read more text
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Apply link to:", "ultimate_vc"),
								"param_name" => "read_more",
								"value" => array(
									__("No Link","ultimate_vc") => "none",
									__("Complete Box","ultimate_vc") => "box",
									__("Box Title","ultimate_vc") => "title",
									__("Display Read More","ultimate_vc") => "more",
								),
								"description" => __("Select whether to use color for icon or not.", "ultimate_vc")
							),
							// Add link to existing content or to another resource
							array(
								"type" => "vc_link",
								"class" => "",
								"heading" => __("Add Link", "ultimate_vc"),
								"param_name" => "link",
								"value" => "",
								"description" => __("Add a custom link or select existing page. You can remove existing link as well.", "ultimate_vc"),
								"dependency" => Array("element" => "read_more", "value" => array("box","title","more")),
							),
							// Link to traditional read more
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Read More Text", "ultimate_vc"),
								"param_name" => "read_text",
								"value" => "Read More",
								"description" => __("Customize the read more text.", "ultimate_vc"),
								"dependency" => Array("element" => "read_more","value" => array("more")),
							),
							// Hover Effect type
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Select Hover Effect type", "ultimate_vc"),
								"param_name" => "hover_effect",
								"value" => array(
									__("No Effect","ultimate_vc") => "style_1",
									__("Icon Zoom","ultimate_vc") => "style_2",
									__("Icon Bounce Up","ultimate_vc") => "style_3",
								),
								"description" => __("Select the type of effct you want on hover", "smile")
							),
							// Position the icon box
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Box Style", "ultimate_vc"),
								"param_name" => "pos",
								"value" => array(
									__("Icon at Left with heading","ultimate_vc") => "default",
									__("Icon at Right with heading","ultimate_vc") => "heading-right",
									__("Icon at Left","ultimate_vc") => "left",
									__("Icon at Right","ultimate_vc") => "right",
									__("Icon at Top","ultimate_vc") => "top",
									__("Boxed Style","ultimate_vc") => "square_box",
								),
								"description" => __("Select icon position. Icon box style will be changed according to the icon position.", "ultimate_vc")
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Box Min Height", "ultimate_vc"),
								"param_name" => "box_min_height",
								"value" => "",
								"suffix" =>"px",
								"dependency" => Array("element" => "pos","value" => array("square_box")),
								"description" => __("Select Min Height for Box.", "ultimate_vc")
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Box Border Style", "ultimate_vc"),
								"param_name" => "box_border_style",
								"value" => array(
									__("None","ultimate_vc") => "",
									__("Solid","ultimate_vc")=> "solid",
									__("Dashed","ultimate_vc") => "dashed",
									__("Dotted","ultimate_vc") => "dotted",
									__("Double","ultimate_vc") => "double",
									__("Inset","ultimate_vc") => "inset",
									__("Outset","ultimate_vc") => "outset",
								),
								"dependency" => Array("element" => "pos","value" => array("square_box")),
								"description" => __("Select Border Style for box border.", "ultimate_vc")
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Box Border Width", "ultimate_vc"),
								"param_name" => "box_border_width",
								"value" => "",
								"suffix" =>"",
								"dependency" => Array("element" => "pos","value" => array("square_box")),
								"description" => __("Select Width for Box Border.", "ultimate_vc")
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Box Border Color", "ultimate_vc"),
								"param_name" => "box_border_color",
								"value" => "",
								"dependency" => Array("element" => "pos","value" => array("square_box")),
								"description" => __("Select Border color for border box.", "ultimate_vc")
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Box Background Color", "ultimate_vc"),
								"param_name" => "box_bg_color",
								"value" => "",
								"dependency" => Array("element" => "pos","value" => array("square_box")),
								"description" => __("Select Box background color.", "ultimate_vc")
							),
							// Customize everything
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Extra Class", "ultimate_vc"),
								"param_name" => "el_class",
								"value" => "",
								"description" => __("Add extra class name that will be applied to the icon box, and you can use this class for your customizations.", "ultimate_vc"),
							),
							array(
								"type" => "ult_param_heading",
								"param_name" => "title_text_typography",
								"heading" => __("Title settings","ultimate_vc"),
								"value" => "",
								"group" => "Typography",
								'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
							),
							array(
								"type" => "ultimate_google_fonts",
								"heading" => __("Font Family","ultimate_vc"),
								"param_name" => "title_font",
								"value" => "",
								"group" => "Typography"
							),
							array(
								"type" => "ultimate_google_fonts_style",
								"heading" => __("Font Style","ultimate_vc"),
								"param_name" => "title_font_style",
								"value" => "",
								"group" => "Typography"
							),
							// array(
							// 	"type" => "number",
							// 	"param_name" => "title_font_size",
							// 	"heading" => __("Font size","ultimate_vc"),
							// 	"value" => "",
							// 	"suffix" => "px",
							// 	"min" => 10,
							// 	"group" => "Typography"
							// ),
							// array(
							// 	"type" => "number",
							// 	"param_name" => "title_font_line_height",
							// 	"heading" => __("Font Line Height","ultimate_vc"),
							// 	"value" => "",
							// 	"suffix" => "px",
							// 	"min" => 10,
							// 	"group" => "Typography"
							// ),
							array(
			                    "type" => "ultimate_responsive",
			                    "class" => "",
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
			                    "param_name" => "title_font_line_height",
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
								"type" => "colorpicker",
								"param_name" => "title_font_color",
								"heading" => __("Color","ultimate_vc"),
								"group" => "Typography"
							),
							/*
							array(
								"type" => "textarea_html",
								"class" => "",
								"heading" => __("Description", "smile"),
								"param_name" => "content",
								"admin_label" => true,
								"value" => "",
								"description" => __("Provide some description.", "smile"),
							),
							*/
							array(
								"type" => "ult_param_heading",
								"param_name" => "desc_text_typography",
								"heading" => __("Description settings","ultimate_vc"),
								"value" => "",
								"group" => "Typography",
								'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
							),
							array(
								"type" => "ultimate_google_fonts",
								"heading" => __("Font Family","ultimate_vc"),
								"param_name" => "desc_font",
								"value" => "",
								"group" => "Typography"
							),
							array(
								"type" => "ultimate_google_fonts_style",
								"heading" => __("Font Style","ultimate_vc"),
								"param_name" => "desc_font_style",
								"value" => "",
								"group" => "Typography"
							),
							// array(
							// 	"type" => "number",
							// 	"param_name" => "desc_font_size",
							// 	"heading" => __("Font size","ultimate_vc"),
							// 	"value" => "",
							// 	"suffix" => "px",
							// 	"min" => 10,
							// 	"group" => "Typography"
							// ),
							// array(
							// 	"type" => "number",
							// 	"param_name" => "desc_font_line_height",
							// 	"heading" => __("Font Line Height","ultimate_vc"),
							// 	"value" => "",
							// 	"suffix" => "px",
							// 	"min" => 10,
							// 	"group" => "Typography"
							// ),
							array(
                                "type" => "ultimate_responsive",
                                "class" => "",
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
                                "param_name" => "desc_font_line_height",
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
								"type" => "colorpicker",
								"param_name" => "desc_font_color",
								"heading" => __("Color","ultimate_vc"),
								"group" => "Typography"
							),
							array(
								"type" => "ult_param_heading",
								"text" => "<span style='display: block;'><a href='http://bsf.io/kqzzi' target='_blank'>".__("Watch Video Tutorial","ultimate_vc")." &nbsp; <span class='dashicons dashicons-video-alt3' style='font-size:30px;vertical-align: middle;color: #e52d27;'></span></a></span>",
								"param_name" => "notification",
								'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
							),
							array(
					            'type' => 'css_editor',
					            'heading' => __( 'Css', 'ultimate_vc' ),
					            'param_name' => 'css_info_box',
					            'group' => __( 'Design ', 'ultimate_vc' ),
					            'edit_field_class' => 'vc_col-sm-12 vc_column no-vc-background no-vc-border creative_link_css_editor',
					        ),
						) // end params array
					) // end vc_map array
				); // end vc_map
			} // end function check 'vc_map'
		}// end function icon_box_init
		function icon_box_scripts() {
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
			wp_register_script('info_box_js', plugins_url($js_path.'info-box'.$ext.'.js',__FILE__) , array('jquery'), ULTIMATE_VERSION, true);
			wp_register_style('info-box-style', plugins_url($css_path.'info-box'.$ext.'.css',__FILE__) , array(), ULTIMATE_VERSION, false);
		}
	}//Class end
}
if(class_exists('AIO_Icons_Box'))
{
	$AIO_Icons_Box = new AIO_Icons_Box;
}

/*if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_bsf-info-box extends WPBakeryShortCode {
    }
}*/