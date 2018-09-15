<?php
/*
* Add-on Name: Ultimate Headings
* Add-on URI: http://dev.brainstormforce.com
*/
if(!class_exists("Ultimate_Headings")){
	class Ultimate_Headings{
		static $add_plugin_script;
		function __construct(){
			add_action("init",array($this,"ultimate_headings_init"));
			add_shortcode("ultimate_heading",array($this,"ultimate_headings_shortcode"));
			add_action("wp_enqueue_scripts", array($this, "register_headings_assets"),1);
		}
		function register_headings_assets()
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
			wp_register_style("ultimate-headings-style",plugins_url($css_path."headings".$ext.".css",__FILE__),array(),ULTIMATE_VERSION);
			wp_register_script("ultimate-headings-script",plugins_url($js_path."headings".$ext.".js",__FILE__),array('jquery'),ULTIMATE_VERSION);
		}
		function ultimate_headings_init(){
			if(function_exists("vc_map")){
				vc_map(
					array(
					   "name" => __("Headings","ultimate_vc"),
					   "base" => "ultimate_heading",
					   "class" => "vc_ultimate_heading",
					   "icon" => "vc_ultimate_heading",
					   "category" => "Ultimate VC Addons",
					   "description" => __("Awesome heading styles.","ultimate_vc"),
					   "params" => array(
							array(
								'type' => 'textfield',
								'heading' => __( 'Title', 'ultimate_vc' ),
								'param_name' => 'main_heading',
								'holder' => 'div',
								'value' => ''
							),
							array(
								"type" => "ult_param_heading",
								"text" => __("Heading Settings","ultimate_vc"),
								"param_name" => "main_heading_typograpy",
								//"dependency" => Array("element" => "main_heading", "not_empty" => true),
								"group" => "Typography",
								"class" => "ult-param-heading",
								'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
							),
							array(
								"type" => "ultimate_google_fonts",
								"heading" => __("Font Family", "ultimate_vc"),
								"param_name" => "main_heading_font_family",
								"description" => __("Select the font of your choice.","ultimate_vc")." ".__("You can","ultimate_vc")." <a target='_blank' href='".admin_url('admin.php?page=bsf-google-font-manager')."'>".__("add new in the collection here","ultimate_vc")."</a>.",
								//"dependency" => Array("element" => "main_heading", "not_empty" => true),
								"group" => "Typography"
							),
							array(
								"type" => "ultimate_google_fonts_style",
								"heading" 		=>	__("Font Style", "ultimate_vc"),
								"param_name"	=>	"main_heading_style",
								//"description"	=>	__("Main heading font style", "smile"),
								//"dependency" => Array("element" => "main_heading", "not_empty" => true),
								"group" => "Typography"
							),

							// Responsive Param
							array(
                          	  	"type" => "ultimate_responsive",
                          	  	"class" => "font-size",
                          	  	"heading" => __("Font size", 'ultimate_vc'),
                          	  	"param_name" => "main_heading_font_size",
                          	  	"unit"  => "px",
                          	  	"media" => array(
                          	  	    "Desktop"           => '',
                          	  	    "Tablet"            => '',
                          	  	    "Tablet Portrait"   => '',
                          	  	    "Mobile Landscape"  => '',
                          	  	    "Mobile"            => '',
                          	  	),
                          	  	"group" => "Typography"
                          	),

							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Font Color", "ultimate_vc"),
								"param_name" => "main_heading_color",
								"value" => "",
								//"description" => __("Main heading color", "smile"),
								//"dependency" => Array("element" => "main_heading", "not_empty" => true),
								"group" => "Typography"
							),

							// responsive
							array(
                          	  	"type" => "ultimate_responsive",
                          	  	"class" => "font-size",
                          	  	"heading" => __("Line Height", 'ultimate_vc'),
                          	  	"param_name" => "main_heading_line_height",
                          	  	"unit"  => "px",
                          	  	"media" => array(
                          	  	    "Desktop"           => '',
                          	  	    "Tablet"            => '',
                          	  	    "Tablet Portrait"   => '',
                          	  	    "Mobile Landscape"  => '',
                          	  	    "Mobile"            => '',
                          	  	),
                          	  	"group" => "Typography"
                          	),

							array(
								"type" => "text",
								"heading" => "<h4>".__("Enter values with respective unites. Example - 10px, 10em, 10%, etc.","ultimate_vc")."</h4>",
								"param_name" => "margin_design_tab_text",
								"group" => "Design",
							),
							array(
								"type" => "ultimate_margins",
								"heading" => __("Heading Margins","ultimate_vc"),
								"param_name" => "main_heading_margin",
								"positions" => array(
									"Top" => "top",
									"Bottom" => "bottom"
								),
								//"dependency" => Array("element" => "main_heading", "not_empty" => true),
								"group" => "Design"
							),
							array(
								"type" => "textarea_html",
								"edit_field_class" => "ult_hide_editor_fullscreen vc_col-xs-12 vc_column wpb_el_type_textarea_html vc_wrapper-param-type-textarea_html vc_shortcode-param",
								"heading" => __("Sub Heading (Optional)", "ultimate_vc"),
								"param_name" => "content",
								"value" => "",
								//"description" => __("Sub heading text", "smile"),
							),
							array(
								"type" => "dropdown",
								"heading" => __("Tag","ultimate_vc"),
								"param_name" => "heading_tag",
								"value" => array(
									__("Default","ultimate_vc") => "h2",
									__("H1","ultimate_vc") => "h1",
									__("H3","ultimate_vc") => "h3",
									__("H4","ultimate_vc") => "h4",
									__("H5","ultimate_vc") => "h5",
									__("H6","ultimate_vc") => "h6",
								),
								"description" => __("Default is H2", "ultimate_vc"),
							),
							array(
								"type" => "ult_param_heading",
								"text" => __("Sub Heading Settings","ultimate_vc"),
								"param_name" => "sub_heading_typograpy",
								//"dependency" => Array("element" => "content", "not_empty" => true),
								"group" => "Typography",
								"class" => "ult-param-heading",
								'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
							),
							array(
								"type" => "ultimate_google_fonts",
								"heading" => __("Font Family", "ultimate_vc"),
								"param_name" => "sub_heading_font_family",
								"description" => __("Select the font of your choice.","ultimate_vc")." ".__("You can","ultimate_vc")." <a target='_blank' href='".admin_url('admin.php?page=bsf-google-font-manager')."'>".__("add new in the collection here","ultimate_vc")."</a>.",
								//"dependency" => Array("element" => "content", "not_empty" => true),
								"group" => "Typography",
							),
							array(
								"type" => "ultimate_google_fonts_style",
								"heading" 		=>	__("Font Style", "ultimate_vc"),
								"param_name"	=>	"sub_heading_style",
								//"description"	=>	__("Sub heading font style", "smile"),
								//"dependency" => Array("element" => "content", "not_empty" => true),
								"group" => "Typography",
							),

							// responsive font size
							array(
                          	  	"type" => "ultimate_responsive",
                          	  	"class" => "",
                          	  	"heading" => __("Font Size", 'ultimate_vc'),
                          	  	"param_name" => "sub_heading_font_size",
                          	  	"unit"  => "px",
                          	  	"media" => array(
                          	  	    "Desktop"           => '',
                          	  	    "Tablet"            => '',
                          	  	    "Tablet Portrait"   => '',
                          	  	    "Mobile Landscape"  => '',
                          	  	    "Mobile"            => '',
                          	  	),
                          	  	"group" => "Typography"
                          	),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Font Color", "ultimate_vc"),
								"param_name" => "sub_heading_color",
								"value" => "",
								//"description" => __("Sub heading color", "smile"),
								//"dependency" => Array("element" => "content", "not_empty" => true),
								"group" => "Typography",
							),

							// responsive
							array(
                          	  	"type" => "ultimate_responsive",
                          	  	"class" => "",
                          	  	"heading" => __("Line Height", 'ultimate_vc'),
                          	  	"param_name" => "sub_heading_line_height",
                          	  	"unit"  => "px",
                          	  	"media" => array(
                          	  	    "Desktop"           => '',
                          	  	    "Tablet"            => '',
                          	  	    "Tablet Portrait"   => '',
                          	  	    "Mobile Landscape"  => '',
                          	  	    "Mobile"            => '',
                          	  	),
                          	  	"group" => "Typography"
                          	),
							array(
								"type" => "ultimate_margins",
								"heading" => "Sub Heading Margins",
								"param_name" => "sub_heading_margin",
								"positions" => array(
									__("Top","ultimate_vc") => "top",
									__("Bottom","ultimate_vc") => "bottom"
								),
								//"dependency" => Array("element" => "sub_heading", "not_empty" => true),
								"group" => "Design"
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Alignment", "ultimate_vc"),
								"param_name" => "alignment",
								"value" => array(
									__("Center","ultimate_vc")	=>	"center",
									__("Left","ultimate_vc")	=>	"left",
									__("Right","ultimate_vc")	=>	"right"
								),
								//"description" => __("Text alignment", "smile"),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Seperator", "ultimate_vc"),
								"param_name" => "spacer",
								"value" => array(
									__("No Seperator","ultimate_vc")	=>	"no_spacer",
									__("Line","ultimate_vc")			=>	"line_only",
									__("Icon","ultimate_vc")			=>	"icon_only",
									__("Image","ultimate_vc") 			=> "image_only",
									__("Line with icon/image","ultimate_vc")	=>	"line_with_icon",
								),
								"description" => __("Horizontal line, icon or image to divide sections", "ultimate_vc"),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Seperator Position", "ultimate_vc"),
								"param_name" => "spacer_position",
								"value" => array(
									__("Top","ultimate_vc")		=>	"top",
									__("Between Heading & Sub-Heading","ultimate_vc")	=>	"middle",
									__("Bottom","ultimate_vc")	=>	"bottom"
								),
								//"description" => __("Alignment of seperator", "smile"),
								"dependency" => Array("element" => "spacer", "value" => array("line_with_icon","line_only","icon_only","image_only")),
							),
							array(
								"type" => "ult_img_single",
								"heading" => __("Select Image", "ultimate_vc"),
								"param_name" => "spacer_img",
								//"description" => __("Alignment of spacer", "smile"),
								"dependency" => Array("element" => "spacer", "value" => array("image_only")),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Image Width", "ultimate_vc"),
								"param_name" => "spacer_img_width",
								"value" => 48,
								"suffix" => "px",
								"description" => __("Provide image width (optional)", "ultimate_vc"),
								"dependency" => Array("element" => "spacer", "value" => array("image_only")),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Line Style", "ultimate_vc"),
								"param_name" => "line_style",
								"value" => array(
									__("Solid","ultimate_vc") => "solid",
									__("Dashed","ultimate_vc") => "dashed",
									__("Dotted","ultimate_vc") => "dotted",
									__("Double","ultimate_vc") => "double",
									__("Inset","ultimate_vc") => "inset",
									__("Outset","ultimate_vc") => "outset",
								),
								//"description" => __("Select the line style.","smile"),
								"dependency" => Array("element" => "spacer", "value" => array("line_with_icon","line_only")),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Line Width (optional)", "ultimate_vc"),
								"param_name" => "line_width",
								//"value" => 250,
								//"min" => 150,
								//"max" => 500,
								"suffix" => "px",
								//"description" => __("Set line width", "smile"),
								"dependency" => Array("element" => "spacer", "value" => array("line_with_icon","line_only")),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Line Height", "ultimate_vc"),
								"param_name" => "line_height",
								"value" => 1,
								"min" => 1,
								"max" => 500,
								"suffix" => "px",
								//"description" => __("Set line height", "smile"),
								"dependency" => Array("element" => "spacer", "value" => array("line_with_icon","line_only")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Line Color", "ultimate_vc"),
								"param_name" => "line_color",
								"value" => "#333333",
								//"description" => __("Select color for line.", "smile"),
								"dependency" => Array("element" => "spacer", "value" => array("line_with_icon","line_only")),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Icon to display:", "ultimate_vc"),
								"param_name" => "icon_type",
								"value" => array(
									__("Font Icon Manager","ultimate_vc") => "selector",
									__("Custom Image Icon","ultimate_vc") => "custom",
								),
								"description" => __("Use an existing font icon or upload a custom image.", "ultimate_vc"),
								"dependency" => Array("element" => "spacer", "value" => array("line_with_icon","icon_only")),
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
								"value" => "",
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
								"dependency" => Array("element" => "icon_type","value" => array("selector")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Background Color", "ultimate_vc"),
								"param_name" => "icon_color_bg",
								"value" => "",
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
								"type" => "ultimate_margins",
								"heading" => "Seperator Margins",
								"param_name" => "spacer_margin",
								"positions" => array(
									__("Top","ultimate_vc") => "top",
									__("Bottom","ultimate_vc") => "bottom"
								),
								"dependency" => Array("element" => "spacer", "value" => array("line_with_icon","line_only","icon_only","image_only")),
								"group" => "Design"
							),
							array(
								"type" => "number",
								"heading" => __("Space between Line & Icon/Image","ultimate_vc"),
								"param_name" => "line_icon_fixer",
								"value" => "10",
								"suffix" => "px",
								"dependency" => Array("element" => "spacer", "value" => array("line_with_icon")),
							),
							array(
								"type" => "textfield",
								"heading" => __("Extra class name", "ultimate_vc"),
								"param_name" => "el_class",
								"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "ultimate_vc")
							),
							array(
								"type" => "ult_param_heading",
								"text" => "<span style='display: block;'><a href='http://bsf.io/8v9sy' target='_blank'>".__("Watch Video Tutorial","ultimate_vc")." &nbsp; <span class='dashicons dashicons-video-alt3' style='font-size:30px;vertical-align: middle;color: #e52d27;'></span></a></span>",
								"param_name" => "notification",
								'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
							),
						)
					)
				);
			}
		}
		function ultimate_headings_shortcode($atts, $content = null){
			$wrapper_style = $main_heading_style_inline = $sub_heading_style_inline = $line_style_inline = $icon_inline = $output = $el_class = '';
			extract(shortcode_atts(array(
				'main_heading' => '',
				"main_heading_font_size"	=> "",
				"main_heading_line_height" 	=> "",
				"main_heading_font_family" 	=> "",
				"main_heading_style"		=> "",
				"main_heading_color"		=> "",
				"main_heading_margin" 		=> "",
				"sub_heading"				=> "",
				"sub_heading_font_size"		=> "",
				"sub_heading_line_height" 	=> "",
				"sub_heading_font_family" 	=> "",
				"sub_heading_style"			=> "",
				"sub_heading_color"			=> "",
				"sub_heading_margin" 		=> "",
				"spacer"					=> "no_spacer",
				"spacer_position"			=> "top",
				"spacer_img"				=> "",
				"spacer_img_width"			=> "",
				"line_style"				=> "solid",
				"line_width"				=> "auto",
				"line_height"				=> "1",
				"line_color"				=> "#ccc",
				"icon_type"					=> "selector",
				"icon"						=> "",
				"icon_color"				=> "",
				"icon_style"				=> "none",
				"icon_color_bg"				=> "",
				"icon_border_style"			=> "",
				"icon_color_border"			=> "#333333",
				"icon_border_size"			=> "1",
				"icon_border_radius"		=> "",
				"icon_border_spacing"		=> "",
				"icon_img"					=> "",
				"img_width"					=> "48",
				"icon_size"					=> "32",
				"alignment"					=> "center",
				"spacer_margin" 			=> "top",
				"line_icon_fixer" 			=> "10",
				"heading_tag" 				=> "",
				"el_class" => "",
			),$atts));
			$vc_version = (defined('WPB_VC_VERSION')) ? WPB_VC_VERSION : 0;
			$is_vc_49_plus = (version_compare(4.9, $vc_version, '<=')) ? 'ult-adjust-bottom-margin' : '';
			$wrapper_class = $spacer;

			if($heading_tag == '')
				$heading_tag = 'h2';

			/* ---- main heading styles ---- */
			if($main_heading_font_family != '')
			{
				$mhfont_family = get_ultimate_font_family($main_heading_font_family);
				if($mhfont_family)
					$main_heading_style_inline .= 'font-family:\''.$mhfont_family.'\';';
			}
			// main heading font style
			$main_heading_style_inline .= get_ultimate_font_style($main_heading_style);
			//attach font size if set

			//attach font color if set
			if($main_heading_color != '')
				$main_heading_style_inline .= 'color:'.$main_heading_color.';';
			//attach margins for main heading
			if($main_heading_margin != '')
				$main_heading_style_inline .= $main_heading_margin;

			/* ----- sub heading styles ----- */
			if($sub_heading_font_family != '')
			{
				$shfont_family = get_ultimate_font_family($sub_heading_font_family);
				if($shfont_family != '')
					$sub_heading_style_inline .= 'font-family:\''.$shfont_family.'\';';
			}
			//sub heaing font style
			$sub_heading_style_inline .= get_ultimate_font_style($sub_heading_style);

			//attach font color if set
			if($sub_heading_color != '')
				$sub_heading_style_inline .= 'color:'.$sub_heading_color.';';
			//attach margins for sub heading
			if($sub_heading_margin != '')
				$sub_heading_style_inline .= $sub_heading_margin;

			if($spacer != '')
				$wrapper_style .= $spacer_margin;
			if($spacer == 'line_with_icon')
			{
				if($line_width < $icon_size)
					$wrap_width = $icon_size;
				else
					$wrap_width = $line_width;
				if($icon_type == 'selector')
				{
					if($icon_style == 'advanced')
					{
						//if($icon_border_spacing != '')
							//$wrapper_style .= 'padding:'.$icon_border_spacing.'px 0;';
					}
					else
					{
						$wrapper_style .= 'height:'.$icon_size.'px;';
					}
				}
				$icon_style_inline = 'font-size:'.$icon_size.'px;';
			}
			else if($spacer == 'line_only')
			{
				$wrap_width = $line_width;
				$line_style_inline = 'border-style:'.$line_style.';';
				$line_style_inline .= 'border-bottom-width:'.$line_height.'px;';
				$line_style_inline .= 'border-color:'.$line_color.';';
				$line_style_inline .= 'width:'.$wrap_width.'px;';
				$wrapper_style .= 'height:'.$line_height.'px;';
				$line = '<span class="uvc-headings-line" style="'.$line_style_inline.'"></span>';
				$icon_inline = $line;
			}
			else if($spacer == 'icon_only')
			{
				$icon_style_inline = 'font-size:'.$icon_size.'px;';
			}
			else if($spacer == 'image_only')
			{
				if(!empty($spacer_img_width))
					$siwidth = array($spacer_img_width, $spacer_img_width);
				else
					$siwidth = 'full';

				$spacer_inline = '';
				//$icon_inline = wp_get_attachment_image( $spacer_img, $siwidth, false, array("class"=>"ultimate-headings-icon-image") );
				$icon_inline = apply_filters('ult_get_img_single', $spacer_img, 'url');
				$alt = apply_filters('ult_get_img_single', $spacer_img, 'alt');
				if($spacer_img_width !== '')
					$spacer_inline = 'width:'.$spacer_img_width.'px';
				$icon_inline = '<img src="'.apply_filters('ultimate_images', $icon_inline).'" class="ultimate-headings-icon-image" alt="'.$alt.'" style="'.$spacer_inline.'"/>';
			}
			//if spacer type is line with icon or only icon show icon or image respectively
			if($spacer == 'line_with_icon' || $spacer == 'icon_only')
			{
				$icon_animation = '';
				$icon_inline = do_shortcode('[just_icon icon_align="'.$alignment.'" icon_type="'.$icon_type.'" icon="'.$icon.'" icon_img="'.$icon_img.'" img_width="'.$img_width.'" icon_size="'.$icon_size.'" icon_color="'.$icon_color.'" icon_style="'.$icon_style.'" icon_color_bg="'.$icon_color_bg.'" icon_color_border="'.$icon_color_border.'"  icon_border_style="'.$icon_border_style.'" icon_border_size="'.$icon_border_size.'" icon_border_radius="'.$icon_border_radius.'" icon_border_spacing="'.$icon_border_spacing.'" icon_animation="'.$icon_animation.'"]');
			}
			if($spacer == 'line_with_icon')
			{
				$data = 'data-hline_width="'.$wrap_width.'" data-hicon_type="'.$icon_type.'" data-hborder_style="'.$line_style.'" data-hborder_height="'.$line_height.'" data-hborder_color="'.$line_color.'"';
				if($icon_type == 'selector')
					$data .= ' data-icon_width="'.$icon_size.'"';
				else
					$data .= ' data-icon_width="'.$img_width.'"';
				if($line_icon_fixer != '')
					$data .= ' data-hfixer="'.$line_icon_fixer.'" ';
			}
			else
				$data = '';
			$micro = rand(0000,9999);
			$id = uniqid('ultimate-heading-'.$micro);
			$uid = 'uvc-'.rand(0000,9999);

			// FIX: set old font size before implementing responsive param
			if(is_numeric($main_heading_font_size)) 	{ 	$main_heading_font_size = 'desktop:'.$main_heading_font_size.'px;';		}
			if(is_numeric($main_heading_line_height)) 	{ 	$main_heading_line_height = 'desktop:'.$main_heading_line_height.'px;';		}
			// responsive {main} heading styles
		  	$args = array(
		  		'target'		=>	'.uvc-heading.'.$id.' '.$heading_tag,
		  		'media_sizes' 	=> array(
					'font-size' 	=> $main_heading_font_size,
					'line-height' 	=> $main_heading_line_height,
				),
		  	);
			$main_heading_responsive = get_ultimate_vc_responsive_media_css($args);

			// FIX: set old font size before implementing responsive param
			if(is_numeric($sub_heading_font_size)) 		{ 	$sub_heading_font_size = 'desktop:'.$sub_heading_font_size.'px;';		}
			if(is_numeric($sub_heading_line_height)) 	{ 	$sub_heading_line_height = 'desktop:'.$sub_heading_line_height.'px;';		}
			// responsive {sub} heading styles
		  	$args = array(
		  		'target'		=>	'.uvc-heading.'.$id.' .uvc-sub-heading ',
		  		'media_sizes' 	=> array(
					'font-size' 	=> $sub_heading_font_size,
					'line-height' 	=> $sub_heading_line_height,
				),
		  	);
			$sub_heading_responsive = get_ultimate_vc_responsive_media_css($args);

			$output = '<div id="'.$id.'" class="uvc-heading '.$is_vc_49_plus.' '.$id.' '.$uid.' '.$el_class.'" data-hspacer="'.$spacer.'" '.$data.' data-halign="'.$alignment.'" style="text-align:'.$alignment.'">';
				if($spacer_position == 'top')
					$output .= $this->ultimate_heading_spacer($wrapper_class, $wrapper_style, $icon_inline);
				if($main_heading != '')
					$output .= '<div class="uvc-main-heading ult-responsive" '.$main_heading_responsive.'><'.$heading_tag.' style="'.$main_heading_style_inline.'">'.$main_heading.'</'.$heading_tag.'></div>';
				if($spacer_position == 'middle')
					$output .= $this->ultimate_heading_spacer($wrapper_class, $wrapper_style, $icon_inline);
				if($content != '')
					$output .= '<div class="uvc-sub-heading ult-responsive" '.$sub_heading_responsive.' style="'.$sub_heading_style_inline.'">'.do_shortcode($content).'</div>';
				if($spacer_position == 'bottom')
					$output .= $this->ultimate_heading_spacer($wrapper_class, $wrapper_style, $icon_inline);
			$output .= '</div>';

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
		function ultimate_heading_spacer($wrapper_class, $wrapper_style, $icon_inline)
		{
			$spacer = '<div class="uvc-heading-spacer '.$wrapper_class.'" style="'.$wrapper_style.'">'.$icon_inline.'</div>';
			return $spacer;
		}
	} // end class
	new Ultimate_Headings;
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_ultimate_heading extends WPBakeryShortCode {
		}
	}
}