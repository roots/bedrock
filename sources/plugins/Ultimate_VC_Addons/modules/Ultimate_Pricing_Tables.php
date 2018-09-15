<?php
/*
* Add-on Name: Pricing Tables for Visual Composer
* Add-on URI: http://dev.brainstormforce.com
*/
if(!class_exists("Ultimate_Pricing_Table")){
	class Ultimate_Pricing_Table{
		function __construct(){
			add_action("init",array($this,"ultimate_pricing_init"));
			add_shortcode("ultimate_pricing",array($this,"ultimate_pricing_shortcode"));
			add_action( 'wp_enqueue_scripts', array( $this, 'price_table_assets' ), 1 );
		}
		function price_table_assets() {
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
		function ultimate_pricing_init(){
			if(function_exists("vc_map")){
				vc_map(
				array(
				   "name" => __("Price Box","ultimate_vc"),
				   "base" => "ultimate_pricing",
				   "class" => "vc_ultimate_pricing",
				   "icon" => "vc_ultimate_pricing",
				   "category" => "Ultimate VC Addons",
				   "description" => __("Create nice looking pricing tables.","ultimate_vc"),
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
							"description" => __("Select Pricing table design you would like to use", "ultimate_vc")
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
							"heading" => __("Package Name / Title", "ultimate_vc"),
							"param_name" => "package_heading",
							"admin_label" => true,
							"value" => "",
							"description" => __("Enter the package name or table heading", "ultimate_vc"),
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Sub Heading", "ultimate_vc"),
							"param_name" => "package_sub_heading",
							"value" => "",
							"description" => __("Enter short description for this package", "ultimate_vc"),
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Package Price", "ultimate_vc"),
							"param_name" => "package_price",
							"value" => "",
							"description" => __("Enter the price for this package. e.g. $157", "ultimate_vc"),
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Price Unit", "ultimate_vc"),
							"param_name" => "package_unit",
							"value" => "",
							"description" => __("Enter the price unit for this package. e.g. per month", "ultimate_vc"),
						),
						array(
							"type" => "textarea_html",
							"class" => "",
							"heading" => __("Features", "ultimate_vc"),
							"param_name" => "content",
							"value" => "",
							"description" => __("Create the features list using un-ordered list elements.", "ultimate_vc"),
							"edit_field_class" => "ult_hide_editor_fullscreen vc_col-xs-12 vc_column wpb_el_type_textarea_html vc_wrapper-param-type-textarea_html vc_shortcode-param",
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Button Text", "ultimate_vc"),
							"param_name" => "package_btn_text",
							"value" => "",
							"description" => __("Enter call to action button text", "ultimate_vc"),
						),
						array(
							"type" => "vc_link",
							"class" => "",
							"heading" => __("Button Link", "smile"),
							"param_name" => "package_link",
							"value" => "",
							"description" => __("Select / enter the link for call to action button", "ultimate_vc"),
						),
						array(
							"type" => "checkbox",
							"class" => "",
							"heading" => "",
							"param_name" => "package_featured",
							"value" => array("Make this pricing box as featured" => "enable"),
						),
						array(
							"type" => "number",
							"class" => "",
							"heading" => __("Minimum Height For Price Box", "ultimate_vc"),
							"param_name" => "min_ht",
							"min" => "",
							"suffix" => "px",
							"description" => __("Adjust height of your price box.", "ultimate_vc")

							),
						array(
								"type" => "textfield",
								"heading" => __("Extra class name", "js_composer"),
								"param_name" => "el_class",
								"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "ultimate_vc")
						),
						/* typoraphy - package */
						array(
							"type" => "ult_param_heading",
							"text" => __("Package Name/Title Settings","ultimate_vc"),
							"param_name" => "package_typograpy",
							"group" => "Typography",
							"class" => "ult-param-heading",
							'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
						),
						array(
							"type" => "ultimate_google_fonts",
							"heading" => __("Font Family", "ultimate_vc"),
							"param_name" => "package_name_font_family",
							"description" => __("Select the font of your choice.","ultimate_vc")." ".__("You can","ultimate_vc")." <a target='_blank' href='".admin_url('admin.php?page=bsf-google-font-manager')."'>".__("add new in the collection here","ultimate_vc")."</a>.",
							"group" => "Typography"
						),
						array(
							"type" => "ultimate_google_fonts_style",
							"heading" 		=>	__("Font Style", "ultimate_vc"),
							"param_name"	=>	"package_name_font_style",
							"group" => "Typography"
						),
						// array(
						// 	"type" => "number",
						// 	"class" => "font-size",
						// 	"heading" => __("Font Size", "ultimate_vc"),
						// 	"param_name" => "package_name_font_size",
						// 	"min" => 10,
						// 	"suffix" => "px",
						// 	"group" => "Typography"
						// ),
						// array(
						// 	"type" => "number",
						// 	"class" => "",
						// 	"heading" => __("Line Height", "ultimate_vc"),
						// 	"param_name" => "package_name_line_height",
						// 	"value" => "",
						// 	"suffix" => "px",
						// 	"group" => "Typography"
						// ),
						array(
		                    "type" => "ultimate_responsive",
		                    "class" => "font-size",
		                    "heading" => __("Font size", 'ultimate_vc'),
		                    "param_name" => "package_name_font_size",
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
		                    "param_name" => "package_name_line_height",
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
							"param_name" => "package_name_font_color",
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
						/* typoraphy - price */
						array(
							"type" => "ult_param_heading",
							"text" => __("Price Settings","ultimate_vc"),
							"param_name" => "price_typograpy",
							"group" => "Typography",
							"class" => "ult-param-heading",
							'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
						),
						array(
							"type" => "ultimate_google_fonts",
							"heading" => __("Font Family", "ultimate_vc"),
							"param_name" => "price_font_family",
							"description" => __("Select the font of your choice.","ultimate_vc")." ".__("You can","ultimate_vc")." <a target='_blank' href='".admin_url('admin.php?page=bsf-google-font-manager')."'>".__("add new in the collection here","ultimate_vc")."</a>.",
							"group" => "Typography"
						),
						array(
							"type" => "ultimate_google_fonts_style",
							"heading" 		=>	__("Font Style", "ultimate_vc"),
							"param_name"	=>	"price_font_style",
							"group" => "Typography"
						),
						// array(
						// 	"type" => "number",
						// 	"class" => "font-size",
						// 	"heading" => __("Font Size", "ultimate_vc"),
						// 	"param_name" => "price_font_size",
						// 	"min" => 10,
						// 	"suffix" => "px",
						// 	"group" => "Typography"
						// ),
						// array(
						// 	"type" => "number",
						// 	"class" => "",
						// 	"heading" => __("Line Height", "ultimate_vc"),
						// 	"param_name" => "price_line_height",
						// 	"value" => "",
						// 	"suffix" => "px",
						// 	"group" => "Typography"
						// ),
						array(
		                    "type" => "ultimate_responsive",
		                    "class" => "font-size",
		                    "heading" => __("Font size", 'ultimate_vc'),
		                    "param_name" => "price_font_size",
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
		                    "param_name" => "price_line_height",
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
							"param_name" => "price_font_color",
							"value" => "",
							"group" => "Typography"
						),
						/* typoraphy - price unit*/
						array(
							"type" => "ult_param_heading",
							"text" => __("Price Unit Settings","ultimate_vc"),
							"param_name" => "price_unit_typograpy",
							"group" => "Typography",
							"class" => "ult-param-heading",
							'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
						),
						array(
							"type" => "ultimate_google_fonts",
							"heading" => __("Font Family", "smile"),
							"param_name" => "price_unit_font_family",
							"description" => __("Select the font of your choice.","ultimate_vc")." ".__("You can","ultimate_vc")." <a target='_blank' href='".admin_url('admin.php?page=bsf-google-font-manager')."'>".__("add new in the collection here","ultimate_vc")."</a>.",
							"group" => "Typography"
						),
						array(
							"type" => "ultimate_google_fonts_style",
							"heading" 		=>	__("Font Style", "ultimate_vc"),
							"param_name"	=>	"price_unit_font_style",
							"group" => "Typography"
						),
						// array(
						// 	"type" => "number",
						// 	"class" => "font-size",
						// 	"heading" => __("Font Size", "ultimate_vc"),
						// 	"param_name" => "price_unit_font_size",
						// 	"min" => 10,
						// 	"suffix" => "px",
						// 	"group" => "Typography"
						// ),
						// array(
						// 	"type" => "number",
						// 	"class" => "",
						// 	"heading" => __("Line Height", "ultimate_vc"),
						// 	"param_name" => "price_unit_line_height",
						// 	"value" => "",
						// 	"suffix" => "px",
						// 	"group" => "Typography"
						// ),
						array(
		                    "type" => "ultimate_responsive",
		                    "class" => "font-size",
		                    "heading" => __("Font size", 'ultimate_vc'),
		                    "param_name" => "price_unit_font_size",
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
		                    "param_name" => "price_unit_line_height",
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
							"param_name" => "price_unit_font_color",
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
							'type' => 'css_editor',
				            'heading' => __( 'Css', 'ultimate_vc' ),
				            'param_name' => 'css_price_box',
				            'group' => __( 'Design ', 'ultimate_vc' ),
				            'edit_field_class' => 'vc_col-sm-12 vc_column no-vc-background no-vc-border creative_link_css_editor',
			        	),
					)// params
				));// vc_map
			}
		}
		function ultimate_pricing_shortcode($atts,$content = null){
			$design_style = '';
			extract(shortcode_atts(array(
				"design_style" => "design01",
			),$atts));
			$output = '';
			require_once(__ULTIMATE_ROOT__.'/templates/pricing/pricing-'.$design_style.'.php');
			$design_func = 'ult_price_generate_'.$design_style;
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
	} // class Ultimate_Pricing_Table
	new Ultimate_Pricing_Table;
	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_ultimate_pricing extends WPBakeryShortCode {
	    }
	}
}