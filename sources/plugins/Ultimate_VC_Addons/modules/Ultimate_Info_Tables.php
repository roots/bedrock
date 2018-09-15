<?php
/*
* Add-on Name: Info Tables for Visual Composer
* Add-on URI: http://dev.brainstormforce.com
*/
if(!class_exists("Ultimate_Info_Table")){
	class Ultimate_Info_Table{
		function __construct(){
			add_action("init",array($this,"ultimate_it_init"));
			add_shortcode("ultimate_info_table",array($this,"ultimate_it_shortcode"));
			add_action( 'wp_enqueue_scripts', array( $this, 'info_table_assets' ), 1 );
		}
		function info_table_assets() {
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
			wp_register_style('ultimate-pricing', plugins_url($css_path.'pricing'.$ext.'.css',__FILE__) , array(), ULTIMATE_VERSION, false);
		}
		function ultimate_it_init(){
			if(function_exists("vc_map")){
				vc_map(
				array(
				   "name" => __("Info Tables","ultimate_vc"),
				   "base" => "ultimate_info_table",
				   "class" => "vc_ultimate_info_table",
				   "icon" => "vc_ultimate_info_table",
				   "category" => "Ultimate VC Addons",
				   "description" => __("Create nice looking info tables.","ultimate_vc"),
				   "params" => array(
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Select Design Style", "ultimate_vc"),
							"param_name" => "design_style",
							"value" => array(
								__("Design 01","ultimate_vc") => "design01",
								__("Design 02","ultimate_vc") => "design02",
								__("Design 03","ultimate_vc") => "design03",
								__("Design 04","ultimate_vc") => "design04",
								__("Design 05","ultimate_vc") => "design05",
								__("Design 06","ultimate_vc") => "design06",
							),
							"description" => __("Select Info table design you would like to use", "ultimate_vc")
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Select Color Scheme", "ultimate_vc"),
							"param_name" => "color_scheme",
							"value" => array(
								__("Black","ultimate_vc") => "black",
								__("Red","ultimate_vc") => "red",
								__("Blue","ultimate_vc") => "blue",
								__("Yellow","ultimate_vc") => "yellow",
								__("Green","ultimate_vc") => "green",
								__("Gray","ultimate_vc") => "gray",
								__("Design Your Own","ultimate_vc") => "custom",
							),
							"description" => __("Which color scheme would like to use?", "ultimate_vc")
						),
						array(
							"type" => "colorpicker",
							"class" => "",
							"heading" => __("Main background Color", "ultimate_vc"),
							"param_name" => "color_bg_main",
							"value" => "",
							"description" => __("Select normal background color.", "ultimate_vc"),
							"dependency" => Array("element" => "color_scheme","value" => array("custom")),
						),
						array(
							"type" => "colorpicker",
							"class" => "",
							"heading" => __("Main text Color", "ultimate_vc"),
							"param_name" => "color_txt_main",
							"value" => "",
							"description" => __("Select normal background color.", "ultimate_vc"),
							"dependency" => Array("element" => "color_scheme","value" => array("custom")),
						),
						array(
							"type" => "colorpicker",
							"class" => "",
							"heading" => __("Highlight background Color", "ultimate_vc"),
							"param_name" => "color_bg_highlight",
							"value" => "",
							"description" => __("Select highlight background color.", "ultimate_vc"),
							"dependency" => Array("element" => "color_scheme","value" => array("custom")),
						),
						array(
							"type" => "colorpicker",
							"class" => "",
							"heading" => __("Highlight text Color", "ultimate_vc"),
							"param_name" => "color_txt_highlight",
							"value" => "",
							"description" => __("Select highlight background color.", "ultimate_vc"),
							"dependency" => Array("element" => "color_scheme","value" => array("custom")),
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Heading", "ultimate_vc"),
							"param_name" => "package_heading",
							"admin_label" => true,
							"value" => "",
							"description" => __("The title of Info Table", "ultimate_vc"),
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Sub Heading", "ultimate_vc"),
							"param_name" => "package_sub_heading",
							"value" => "",
							"description" => __(" Describe the info table in one line", "ultimate_vc"),
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Icon to display:", "ultimate_vc"),
							"param_name" => "icon_type",
							"value" => array(
								__("No Icon","ultimate_vc") => "none",
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
							"type" => "attach_image",
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
							"value" => "",
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
							"value" => "",
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
							"dependency" => Array("element" => "icon_type","value" => array("selector")),
							"description" => __("We have given three quick preset if you are in a hurry. Otherwise, create your own with various options.", "ultimate_vc"),
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
								__("Solid","ultimate_vc")=> "solid",
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
							"value" => "",
							"description" => __("Select border color for icon.", "ultimate_vc"),
							"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
						),
						array(
							"type" => "number",
							"class" => "",
							"heading" => __("Border Width", "ultimate_vc"),
							"param_name" => "icon_border_size",
							"value" => "",
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
							"value" => "",
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
							"value" => "",
							"min" => 30,
							"max" => 500,
							"suffix" => "px",
							"description" => __("Spacing from center of the icon till the boundary of border / background", "ultimate_vc"),
							"dependency" => Array("element" => "icon_style", "value" => array("advanced")),
						),
						array(
							"type" => "textarea_html",
							"class" => "",
							"heading" => __("Features", "ultimate_vc"),
							"param_name" => "content",
							"value" => "",
							"description" => __("Describe the Info Table in brief.", "ultimate_vc"),
							"edit_field_class" => "ult_hide_editor_fullscreen vc_col-xs-12 vc_column wpb_el_type_textarea_html vc_wrapper-param-type-textarea_html vc_shortcode-param",
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Add link", "ultimate_vc"),
							"param_name" => "use_cta_btn",
							"value" => array(
								__("No Link","ultimate_vc") => "",
								__("Call to Action Button","ultimate_vc") => "true",
								__("Link to Complete Box","ultimate_vc") => "box",
							),
							"description" => __("Do you want to display call to action button?","ultimate_vc"),
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Call to action button text", "ultimate_vc"),
							"param_name" => "package_btn_text",
							"value" => "",
							"description" => __("Enter call to action button text", "ultimate_vc"),
							"dependency" => Array("element" => "use_cta_btn", "value" => array("true")),
						),
						array(
							"type" => "vc_link",
							"class" => "",
							"heading" => __("Call to action link", "ultimate_vc"),
							"param_name" => "package_link",
							"value" => "",
							"description" => __("Select / enter the link for call to action button", "ultimate_vc"),
							"dependency" => Array("element" => "use_cta_btn", "value" => array("true","box")),
						),
						/* typoraphy - heading */
						array(
							"type" => "ult_param_heading",
							"text" => __("Heading Settings","ultimate_vc"),
							"param_name" => "heading_typograpy",
							"group" => "Typography",
							"class" => "ult-param-heading",
							'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
						),
						array(
							"type" => "ultimate_google_fonts",
							"heading" => __("Font Family", "ultimate_vc"),
							"param_name" => "heading_font_family",
							"description" => __("Select the font of your choice.","ultimate_vc")." ".__("You can","ultimate_vc")." <a target='_blank' href='".admin_url('admin.php?page=bsf-google-font-manager')."'>".__("add new in the collection here","ultimate_vc")."</a>.",
							"group" => "Typography"
						),
						array(
							"type" => "ultimate_google_fonts_style",
							"heading" 		=>	__("Font Style", "ultimate_vc"),
							"param_name"	=>	"heading_font_style",
							"group" => "Typography"
						),
						// array(
						// 	"type" => "number",
						// 	"class" => "font-size",
						// 	"heading" => __("Font Size", "ultimate_vc"),
						// 	"param_name" => "heading_font_size",
						// 	"min" => 10,
						// 	"suffix" => "px",
						// 	"group" => "Typography"
						// ),
						// array(
						// 	"type" => "number",
						// 	"class" => "",
						// 	"heading" => __("Line Height", "ultimate_vc"),
						// 	"param_name" => "heading_line_height",
						// 	"value" => "",
						// 	"suffix" => "px",
						// 	"group" => "Typography"
						// ),
						array(
		                    "type" => "ultimate_responsive",
		                    "class" => "font-size",
		                    "heading" => __("Font size", 'ultimate_vc'),
		                    "param_name" => "heading_font_size",
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
		                    "param_name" => "heading_line_height",
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
							"class" => "",
							"heading" => __("Font Color", "ultimate_vc"),
							"param_name" => "heading_font_color",
							"value" => "",
							"group" => "Typography"
						),

						/* typoraphy - sub heading */
						array(
							"type" => "ult_param_heading",
							"text" => __("Sub-Heading Settings","ultimate_vc"),
							"param_name" => "subheading_typograpy",
							"group" => "Typography",
							"class" => "ult-param-heading",
							'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
						),
						array(
							"type" => "ultimate_google_fonts",
							"heading" => __("Font Family", "ultimate_vc"),
							"param_name" => "subheading_font_family",
							"description" => __("Select the font of your choice.","ultimate_vc")." ".__("You can","ultimate_vc")." <a target='_blank' href='".admin_url('admin.php?page=bsf-google-font-manager')."'>".__("add new in the collection here","ultimate_vc")."</a>.",
							"group" => "Typography"
						),
						array(
							"type" => "ultimate_google_fonts_style",
							"heading" 		=>	__("Font Style", "ultimate_vc"),
							"param_name"	=>	"subheading_font_style",
							"group" => "Typography"
						),
						// array(
						// 	"type" => "number",
						// 	"class" => "font-size",
						// 	"heading" => __("Font Size", "ultimate_vc"),
						// 	"param_name" => "subheading_font_size",
						// 	"min" => 10,
						// 	"suffix" => "px",
						// 	"group" => "Typography"
						// ),
						// array(
						// 	"type" => "number",
						// 	"class" => "",
						// 	"heading" => __("Line Height", "ultimate_vc"),
						// 	"param_name" => "subheading_line_height",
						// 	"value" => "",
						// 	"suffix" => "px",
						// 	"group" => "Typography"
						// ),
						array(
		                    "type" => "ultimate_responsive",
		                    "class" => "font-size",
		                    "heading" => __("Font size", 'ultimate_vc'),
		                    "param_name" => "subheading_font_size",
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
		                    "param_name" => "subheading_line_height",
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
							"class" => "",
							"heading" => __("Font Color", "ultimate_vc"),
							"param_name" => "subheading_font_color",
							"value" => "",
							"group" => "Typography"
						),

						/* typoraphy - feature*/
						array(
							"type" => "ult_param_heading",
							"text" => __("Features Settings","ultimate_vc"),
							"param_name" => "features_typograpy",
							"group" => "Typography",
							"class" => "ult-param-heading",
							'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
						),
						array(
							"type" => "ultimate_google_fonts",
							"heading" => __("Font Family", "ultimate_vc"),
							"param_name" => "features_font_family",
							"description" => __("Select the font of your choice.","ultimate_vc")." ".__("You can","ultimate_vc")." <a target='_blank' href='".admin_url('admin.php?page=bsf-google-font-manager')."'>".__("add new in the collection here","ultimate_vc")."</a>.",
							"group" => "Typography"
						),
						array(
							"type" => "ultimate_google_fonts_style",
							"heading" 		=>	__("Font Style", "ultimate_vc"),
							"param_name"	=>	"features_font_style",
							"group" => "Typography"
						),
						// array(
						// 	"type" => "number",
						// 	"class" => "font-size",
						// 	"heading" => __("Font Size", "ultimate_vc"),
						// 	"param_name" => "features_font_size",
						// 	"min" => 10,
						// 	"suffix" => "px",
						// 	"group" => "Typography"
						// ),
						// array(
						// 	"type" => "number",
						// 	"class" => "",
						// 	"heading" => __("Line Height", "ultimate_vc"),
						// 	"param_name" => "features_line_height",
						// 	"value" => "",
						// 	"suffix" => "px",
						// 	"group" => "Typography"
						// ),
						array(
		                    "type" => "ultimate_responsive",
		                    "class" => "font-size",
		                    "heading" => __("Font size", 'ultimate_vc'),
		                    "param_name" => "features_font_size",
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
		                    "param_name" => "features_line_height",
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
							"class" => "",
							"heading" => __("Font Color", "ultimate_vc"),
							"param_name" => "features_font_color",
							"value" => "",
							"group" => "Typography"
						),

						/* typoraphy - button */
						array(
							"type" => "ult_param_heading",
							"text" => __("Button Settings","ultimate_vc"),
							"param_name" => "button_typograpy",
							"group" => "Typography",
							"class" => "ult-param-heading",
							'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
						),
						array(
							"type" => "ultimate_google_fonts",
							"heading" => __("Font Family", "ultimate_vc"),
							"param_name" => "button_font_family",
							"description" => __("Select the font of your choice.","ultimate_vc")." ".__("You can","ultimate_vc")." <a target='_blank' href='".admin_url('admin.php?page=bsf-google-font-manager')."'>".__("add new in the collection here","ultimate_vc")."</a>.",
							"group" => "Typography"
						),
						array(
							"type" => "ultimate_google_fonts_style",
							"heading" 		=>	__("Font Style", "ultimate_vc"),
							"param_name"	=>	"button_font_style",
							"group" => "Typography"
						),
						// array(
						// 	"type" => "number",
						// 	"class" => "font-size",
						// 	"heading" => __("Font Size", "ultimate_vc"),
						// 	"param_name" => "button_font_size",
						// 	"min" => 10,
						// 	"suffix" => "px",
						// 	"group" => "Typography"
						// ),

						// array(
						// 	"type" => "number",
						// 	"class" => "",
						// 	"heading" => __("Line Height", "ultimate_vc"),
						// 	"param_name" => "button_line_height",
						// 	"value" => "",
						// 	"suffix" => "px",
						// 	"group" => "Typography"
						// ),
						array(
		                    "type" => "ultimate_responsive",
		                    "class" => "font-size",
		                    "heading" => __("Font size", 'ultimate_vc'),
		                    "param_name" => "button_font_size",
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
		                    "param_name" => "button_line_height",
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
							"class" => "",
							"heading" => __("Font Color", "ultimate_vc"),
							"param_name" => "button_font_color",
							"value" => "",
							"group" => "Typography"
						),
						array(
							"type" => "number",
							"class" => "font-size",
							"heading" => __("Minimum Height For Info Table", "ultimate_vc"),
							"param_name" => "features_min_ht",
							"min" => 10,
							"suffix" => "px",
							"description" => __("Adjust height of your price Info Table.", "ultimate_vc"),

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
							"text" => "<span style='display: block;'><a href='http://bsf.io/t9vlh' target='_blank'>".__("Watch Video Tutorial","ultimate_vc")." &nbsp; <span class='dashicons dashicons-video-alt3' style='font-size:30px;vertical-align: middle;color: #e52d27;'></span></a></span>",
							"param_name" => "notification",
							'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
						),
						array(
							'type' => 'css_editor',
				            'heading' => __( 'Css', 'ultimate_vc' ),
				            'param_name' => 'css_info_tables',
				            'group' => __( 'Design ', 'ultimate_vc' ),
				            'edit_field_class' => 'vc_col-sm-12 vc_column no-vc-background no-vc-border creative_link_css_editor',
					    ),
					)// params
				));// vc_map
			}
		}
		function ultimate_it_shortcode($atts,$content = null){
			$design_style = '';
			extract(shortcode_atts(array(
				"design_style" => "design01",
			),$atts));
			$output = '';
			require_once(__ULTIMATE_ROOT__.'/templates/info-tables/info-table-'.$design_style.'.php');
			$design_func = 'ult_info_table_generate_'.$design_style;
			//$design_cls = 'Info_'.ucfirst($design_style);
			//$class = new $design_cls;
			$output .= $design_func($atts,$content);
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
	} // class Ultimate_Info_Table
	new Ultimate_Info_Table;
	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_ultimate_info_table extends WPBakeryShortCode {
	    }
	}
}