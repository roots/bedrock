<?php
/*
* Add-on Name: Info Banner
*/
if(!class_exists('Ultimate_Info_Banner'))
{
	class Ultimate_Info_Banner{
		function __construct(){
			add_action('init',array($this,'banner_init'));
			add_shortcode('ultimate_info_banner',array($this,'banner_shortcode'));
			add_action('wp_enqueue_scripts', array($this, 'register_info_banner_assets'),1);
		}
		function register_info_banner_assets()
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
			wp_register_script('utl-info-banner-script',plugins_url($js_path.'info-banner'.$ext.'.js',__FILE__),array('jquery','ultimate-appear'), ULTIMATE_VERSION);
			wp_register_style('utl-info-banner-style',plugins_url($css_path.'info-banner'.$ext.'.css',__FILE__),array(), ULTIMATE_VERSION);
		}
		function banner_init(){
			if(function_exists('vc_map'))
			{
				vc_map(
					array(
					   "name" => __("Info Banner","ultimate_vc"),
					   "base" => "ultimate_info_banner",
					   "class" => "vc_info_banner_icon",
					   "icon" => "vc_icon_info_banner",
					   "category" => "Ultimate VC Addons",
					   "description" => __("Displays the banner information","ultimate_vc"),
					   "params" => array(
					   		array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Title ","ultimate_vc"),
								"param_name" => "banner_title",
								"admin_label" => true,
								"value" => "",
								"description" => __("Give a title to this banner","ultimate_vc")
							),
							array(
								"type" => "textarea",
								"class" => "",
								"heading" => __("Description","ultimate_vc"),
								"param_name" => "banner_desc",
								"value" => "",
								"description" => __("Text that comes on mouse hover.","ultimate_vc")
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Button Text","ultimate_vc"),
								"param_name" => "button_text",
								"admin_label" => true,
								"value" => "",
								//"description" => __("Give a title to this banner","smile")
							),
							array(
								"type" => "vc_link",
								"class" => "",
								"heading" => __("Link ","ultimate_vc"),
								"param_name" => "button_link",
								"value" => "",
								"description" => __("Add link / select existing page to link to this banner","ultimate_vc"),
							),
							array(
								"type" => "dropdown",
								"heading" => __("Information Alignment","ultimate_vc"),
								"param_name" => "info_alignment",
								"value" => array(
									__("Center","ultimate_vc") => "ib3-info-center",
									__("Left","ultimate_vc") => "ib3-info-left",
									__("Right","ultimate_vc") => "ib3-info-right"
								)
							),
							array(
								"type" => "dropdown",
								"heading" => __("Animation Effect","ultimate_vc"),
								"param_name" => "info_effect",
								"value" => array(
									__("No Effect","ultimate_vc") => "",
									__("Fade-In","ultimate_vc") => "fadeIn",
									__("Fade-In Left","ultimate_vc") => "fadeInLeft",
									__("Fade-In Right","ultimate_vc") => "fadeInRight",
									__("Fade-In Up","ultimate_vc") => "fadeInUp",
									__("Fade-In Down","ultimate_vc") => "fadeInDown",
									__("Flip","ultimate_vc") => "flipInX",
									__("Zoom","ultimate_vc") => "zoomIn"
								)
							),
							array(
								"type" => "ult_img_single",
								"class" => "",
								"heading" => __("Banner Image","ultimate_vc"),
								"param_name" => "banner_image",
								"value" => "",
								"description" => __("Upload the image for this banner","ultimate_vc"),
								"group" => "Image",
							),
							array(
								"type" => "number",
								"param_name" => "banner_size",
								"heading" => __("Banner Min Height","ultimate_vc"),
								"value" => "50",
								"min" => "50",
								"suffix" => "px",
								"group" => "Design"
							),

							array(
								"type" => "dropdown",
								"heading" => __("Image Alignment","ultimate_vc"),
								"param_name" => "ib3_alignment",
								"value" => array(
									__("Top Left","ultimate_vc") => "ultb3-img-top-left",
									__("Top Center","ultimate_vc") => "ultb3-img-top-center",
									__("Top Right","ultimate_vc") => "ultb3-img-top-right",
									__("Center Left","ultimate_vc") => "ultb3-img-center-left",
									__("Center","ultimate_vc") => "ultb3-img-center",
									__("Center Right","ultimate_vc") => "ultb3-img-center-right",
									__("Bottom Left","ultimate_vc") => "ultb3-img-bottom-left",
									__("Bottom Center","ultimate_vc") => "ultb3-img-bottom-center",
									__("Bottom Right","ultimate_vc") => "ultb3-img-bottom-right",
								),
								"group" => "Image",
							),
							array(
								"type" => "dropdown",
								"heading" => __("Effect","ultimate_vc"),
								"param_name" => "ib3_effect",
								"value" => array(
									__("No Effect","ultimate_vc") => "",
									__("Slide Down","ultimate_vc") => "ultb3-hover-1",
									__("Slide Up","ultimate_vc") => "ultb3-hover-2",
									__("Slide Left","ultimate_vc") => "ultb3-hover-3",
									__("Slide Right","ultimate_vc") => "ultb3-hover-4",
									__("Pan","ultimate_vc") => "ultb3-hover-5",
									__("Zoom Out","ultimate_vc") => "ultb3-hover-6"
								),
								"group" => "Image",
							),
							array(
								"type" => "colorpicker",
								"heading" => __("Overlay Color on Image","ultimate_vc"),
								"param_name" => "overlay_color",
								"value" => "",
								"group" => "Image",
								// "dependency" => array("element" => "enable_overlay", "value" => array("enable_overlay_value"))
							),
							array(
								"type" => "ult_param_heading",
								"text" => __("Image Height","ultimate_vc"),
								"param_name" => "image_height_typography",
								"class" => "ult-param-heading",
								"group" => "Image",
								'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
							),
							array(
								"type" => "number",
								"param_name" => "banner_img_height_large_screen",
								"heading" => "<i class='dashicons dashicons-welcome-view-site'></i> ".__("Large Screen","ultimate_vc"),
								"min" => "50",
								"value" => "",
								"suffix" => "px",
								"group" => "Image",
								'edit_field_class' => 'vc_column vc_col-sm-4',
							),
							array(
								"type" => "number",
								"param_name" => "banner_img_height",
								"heading" => "<i class='dashicons dashicons-desktop'></i> ".__("Desktop","ultimate_vc"),
								"min" => "50",
								"value" => "",
								"suffix" => "px",
								"group" => "Image",
								'edit_field_class' => 'vc_column vc_col-sm-4',
							),
							array(
								"type" => "number",
								"heading" => "<i class='dashicons dashicons-tablet' style='transform: rotate(90deg);'></i> ".__("Tablet", "ultimate_vc"),
								"param_name" => "banner_img_height_tablet",
								"value" => "",
								"suffix" => "px",
								"group" => "Image",
								'edit_field_class' => 'vc_column vc_col-sm-4',
							),
							array(
								"type" => "number",
								"heading" => "<i class='dashicons dashicons-tablet'></i> ".__("Tablet Portrait", "ultimate_vc"),
								"param_name" => "banner_img_height_tablet_portrait",
								"value" => "",
								"suffix" => "px",
								"group" => "Image",
								'edit_field_class' => 'vc_column vc_col-sm-4',
							),
							array(
								"type" => "number",
								"heading" => "<i class='dashicons dashicons-smartphone' style='transform: rotate(90deg);'></i> ".__("Mobile Landscape", "ultimate_vc"),
								"param_name" => "banner_img_height_mobile_landscape",
								"value" => "",
								"suffix" => "px",
								"group" => "Image",
								'edit_field_class' => 'vc_column vc_col-sm-4',
							),
							array(
								"type" => "number",
								"heading" => "<i class='dashicons dashicons-smartphone'></i> ".__("Mobile", "ultimate_vc"),
								"param_name" => "banner_img_height_mobile",
								"value" => "",
								"suffix" => "px",
								"group" => "Image",
								'edit_field_class' => 'vc_column vc_col-sm-4',
							),
							array(
								"type" => "colorpicker",
								"heading" => __("Background Color","ultimate_vc"),
								"param_name" => "ib3_background",
								"group" => "Design"
							),
							array(
								"type" => "dropdown",
								"heading" => __("Border","ultimate_vc"),
								"param_name" => "ib3_border",
								"value" => array(
									__("No Border","ultimate_vc") => "no-border",
									__("Solid","ultimate_vc") => "solid",
									__("Dashed","ultimate_vc") => "dashed",
									__("Dotted","ultimate_vc") => "dotted",
									__("Double","ultimate_vc") => "double"
								),
								"group" => "Design"
							),
							array(
								"type" => "number",
								"heading" => __("Border Width","ultimate_vc"),
								"param_name" => "ib3_border_width",
								"suffix" => "px",
								"value" => "1",
								"group" => "Design",
								"dependency" => array("element" => "ib3_border", "value" => array("solid","dashed","dotted","double"))
							),
							array(
								"type" => "colorpicker",
								"heading" => __("Border Color","ultimate_vc"),
								"param_name" => "ib3_border_color",
								"group" => "Design",
								"dependency" => array("element" => "ib3_border", "value" => array("solid","dashed","dotted","double"))
							),
							array(
								"type" => "colorpicker",
								"heading" => __("Button Color","ultimate_vc"),
								"param_name" => "button_color",
								"value" => "#1e73be",
								"group" => "Button"
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Text Color", "ultimate_vc"),
								"param_name" => "button_text_color",
								"value" => "#898989",
								"group" => "Button"
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Text Hover Color", "ultimate_vc"),
								"param_name" => "button_text_hover_color",
								"value" => "#ffffff",
								"group" => "Button"
							),
							array(
								"type" => "number",
								"heading" => __("Border Width","ultimate_vc"),
								"param_name" => "button_border_width",
								"value" => "2",
								"suffix" => "px",
								"group" => "Button"
							),
							array(
								"type" => "number",
								"heading" => __("Border Radius","ultimate_vc"),
								"param_name" => "button_border_radius",
								"value" => "50",
								"suffix" => "px",
								"group" => "Button"
							),
							array(
								"type" => "ult_param_heading",
								"text" => __("Title Settings","ultimate_vc"),
								"param_name" => "title_typograpy",
								"group" => "Typography",
								"class" => "ult-param-heading",
								'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
							),
							array(
								"type" => "ultimate_google_fonts",
								"heading" => __("Font Family", "ultimate_vc"),
								"param_name" => "title_font_family",
								"description" => __("Click and select icon of your choice. If you can't find the one that suits for your purpose","ultimate_vc").", ".__("you can","ultimate_vc")." <a href='admin.php?page=bsf-google-font-manager' target='_blank'>".__("add new here","ultimate_vc")."</a>.",
								"group" => "Typography"
							),
							array(
								"type" => "ultimate_google_fonts_style",
								"heading" 		=>	__("Font Style", "ultimate_vc"),
								"param_name"	=>	"title_font_style",
								"group" => "Typography"
							),
							// array(
							// 	"type" => "number",
							// 	"class" => "font-size",
							// 	"heading" => __("Font Size", "ultimate_vc"),
							// 	"param_name" => "title_font_size",
							// 	"min" => 10,
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
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Font Color", "ultimate_vc"),
								"param_name" => "title_color",
								"value" => "",
								"group" => "Typography"
							),
							array(
								"type" => "ult_param_heading",
								"text" => __("Description Settings","ultimate_vc"),
								"param_name" => "desc_typograpy",
								"group" => "Typography",
								"class" => "ult-param-heading",
								'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
							),
							array(
								"type" => "ultimate_google_fonts",
								"heading" => __("Font Family", "ultimate_vc"),
								"param_name" => "desc_font_family",
								"description" => __("Click and select icon of your choice. If you can't find the one that suits for your purpose","ultimate_vc").", ".__("you can","ultimate_vc")." <a href='admin.php?page=bsf-font-icon-manager' target='_blank'>".__("add new here","ultimate_vc")."</a>.",
								"group" => "Typography"
							),
							array(
								"type" => "ultimate_google_fonts_style",
								"heading" 		=>	__("Font Style", "ultimate_vc"),
								"param_name"	=>	"desc_font_style",
								"group" => "Typography"
							),
							// array(
							// 	"type" => "number",
							// 	"class" => "font-size",
							// 	"heading" => __("Font Size", "ultimate_vc"),
							// 	"param_name" => "desc_font_size",
							// 	"min" => 10,
							// 	"suffix" => "px",
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
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Font Color", "ultimate_vc"),
								"param_name" => "desc_color",
								"value" => "",
								"group" => "Typography"
							),
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
								"description" => __("Click and select icon of your choice. If you can't find the one that suits for your purpose","ultimate_vc").", ".__("you can","ultimate_vc")." <a href='admin.php?page=bsf-font-icon-manager' target='_blank'>".__("add new here","ultimate_vc")."</a>.",
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
                                "class" => "",
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
								"type" => "textfield",
								"heading" => __("Extra class name", "ultimate_vc"),
								"param_name" => "el_class",
								"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "ultimate_vc")
							),
							array(
					            'type' => 'css_editor',
					            'heading' => __( 'Css', 'ultimate_vc' ),
					            'param_name' => 'css_infobanner',
					            'group' => __( 'Design', 'ultimate_vc' ),
					            'edit_field_class' => 'vc_col-sm-12 vc_column no-vc-background no-vc-border creative_link_css_editor',
					        ),
						),
					)
				);
			}
		}
		// Shortcode handler function for stats banner
		function banner_shortcode($atts)
		{
			$output = $el_class = $style = $img_style = $infobnr_design = '';

			extract(shortcode_atts( array(
				'banner_title' => '',
				'banner_desc' => '',
				'info_alignment' => 'ib3-info-center',
				'banner_image' => '',
				'banner_size' => '50',
				'ib3_alignment' => 'ultb3-img-left',
				'button_text' => '',
				'button_link' => '',
				'info_effect' => '',
				'ib3_effect' => '',
				'ib3_background' => '',
				'ib3_border' => 'no-border',
				'ib3_border_width' => '1',
				'ib3_border_color' => '',
				'title_font_family' => '',
				'title_font_style' => '',
				'title_font_size' => '',
				'title_color' => '',
				'title_line_height' => '',
				'desc_font_family' => '',
				'desc_font_style' => '',
				'desc_font_size' => '',
				'desc_color' => '',
				'desc_line_height' => '',
				'button_font_family' => '',
				'button_font_style' => '',
				'button_font_size' => '',
				'button_color' => '#1e73be',
				'button_line_height' => '',
				'button_border_radius' => '50',
				'button_border_width' => '2',
				'button_text_color' => '#898989',
				'button_text_hover_color' => '#ffffff',
				'banner_img_height_large_screen' => '',
				'banner_img_height' => '',
				'banner_img_height_tablet' => '',
				'banner_img_height_tablet_portrait' => '',
				'banner_img_height_mobile' => '',
				'banner_img_height_mobile_landscape' => '',
				'overlay_color' => '',
				'el_class' => '',
				'css_infobanner' => '',
			),$atts));

			$vc_version = (defined('WPB_VC_VERSION')) ? WPB_VC_VERSION : 0;
			$is_vc_49_plus = (version_compare(4.9, $vc_version, '<=')) ? 'ult-adjust-bottom-margin' : '';

			$infobnr_design = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css_infobanner, ' ' ), "ultimate_info_banner", $atts );
			$infobnr_design = esc_attr( $infobnr_design );
			/* typography */
			$title_style_inline = $desc_style_inline = $button_style_inline = '';
			if($title_font_family != '')
			{
				$temp = get_ultimate_font_family($title_font_family);
				if($temp != '')
					$title_style_inline .= 'font-family:'.$temp.';';
			}

			$title_style_inline .= get_ultimate_font_style($title_font_style);

			// if($title_font_size != '')
			// 	$title_style_inline .= 'font-size:'.$title_font_size.'px;';
			// if($title_line_height != '')
			// 	$title_style_inline .= 'line-height:'.$title_line_height.'px;';

			if(is_numeric($title_font_size)){
				$title_font_size = 'desktop:'.$title_font_size.'px;';
			}
			if(is_numeric($title_line_height)){
				$title_line_height = 'desktop:'.$title_line_height.'px;';
			}
			$info_banner_id = 'Info-banner-wrap'.rand(1000, 9999);
			$info_banner_args = array(
                'target' => '#'.$info_banner_id.' .ultb3-title', // set targeted element e.g. unique class/id etc.
                'media_sizes' => array(
                    'font-size' => $title_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
                   	'line-height' => $title_line_height
                ),
            );
            $info_banner_data_list = get_ultimate_vc_responsive_media_css($info_banner_args);
			if($title_color != '')
				$title_style_inline .= 'color:'.$title_color.';';

			if($desc_font_family != '')
			{
				$temp = get_ultimate_font_family($desc_font_family);
				if($temp != '')
					$desc_style_inline .= 'font-family:'.$temp.';';
			}

			$desc_style_inline .= get_ultimate_font_style($desc_font_style);

			// if($desc_font_size != '')
			// 	$desc_style_inline .= 'font-size:'.$desc_font_size.'px;';
			// if($desc_line_height != '')
			// 	$desc_style_inline .= 'line-height:'.$desc_line_height.'px;';

			if(is_numeric($desc_font_size)){
				$desc_font_size = 'desktop:'.$desc_font_size.'px;';
			}

			if(is_numeric($desc_line_height)){
				$desc_line_height = 'desktop:'.$desc_line_height.'px;';
			}

			$info_banner_desc_args = array(
                'target' => '#'.$info_banner_id.' .ultb3-desc', // set targeted element e.g. unique class/id etc.
                'media_sizes' => array(
                    'font-size' => $desc_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
                   	'line-height' => $desc_line_height
                ),
            );
            $info_banner_desc_data_list = get_ultimate_vc_responsive_media_css($info_banner_desc_args);

            if($desc_color != '')
				$desc_style_inline .= 'color:'.$desc_color.';';

			if($button_font_family != '')
			{
				$temp = get_ultimate_font_family($button_font_family);
				if($temp != '')
					$button_style_inline .= 'font-family:'.$temp.';';
			}

			$button_style_inline .= get_ultimate_font_style($button_font_style);

			// if($button_font_size != '')
			// 	$button_style_inline .= 'font-size:'.$button_font_size.'px;';

			// if($button_line_height != '')
			// 	$button_style_inline .= 'line-height:'.$button_line_height.'px;';

			if(is_numeric($button_font_size)){
				$button_font_size = 'desktop:'.$button_font_size.'px;';
			}

			if(is_numeric($button_line_height)){
				$button_line_height = 'desktop:'.$button_line_height.'px;';
			}

			$info_banner_btn_args = array(
                'target' => '#'.$info_banner_id.' .ultb3-btn', // set targeted element e.g. unique class/id etc.
                'media_sizes' => array(
                    'font-size' => $button_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
                   	'line-height' => $button_line_height
                ),
            );
            $info_banner_btn_data_list = get_ultimate_vc_responsive_media_css($info_banner_btn_args);

			$banner_src = apply_filters('ult_get_img_single', $banner_image, 'url', 'full');

			$alt = apply_filters('ult_get_img_single', $banner_image, 'alt');

			if($ib3_background != '')
				$style .= 'background-color: '.$ib3_background.';';

			if($ib3_border != 'no-border')
				$style .= 'border:'.$ib3_border_width.'px '.$ib3_border.' '.$ib3_border_color.';';

			$id = uniqid(rand());

			$button_link_main = $title = $target = '';

			if($button_link != '')
			{
				$button_link_temp = vc_build_link($button_link);
				$button_link_main = $button_link_temp['url'];
				$title = $button_link_temp['title'];
				$target = $button_link_temp['target'];
			}
			if($button_link_main == '')
				$button_link_main = 'javascript:void(0);';

			$output .= '<div id="ultib3-'.$id.'" class="'.$infobnr_design.' ultb3-box '.$is_vc_49_plus.' '.$el_class.' '.$ib3_effect.'" style="'.$style.'">';
				if($overlay_color != '')
					$output .= '<div class="ultb3-box-overlay" style="background:'.$overlay_color.';"></div>';

				if(isset($banner_src) && $banner_src != '')
					$output .= '<img src="'.apply_filters('ultimate_images', $banner_src).'" style="'.$img_style.'" class="ultb3-img '.$ib3_alignment.'" alt="'.$alt.'"/>';

				$output .= '<div id="'.$info_banner_id.'" class="ultb3-info '.$info_alignment.'" data-animation="'.$info_effect.'" data-animation-delay="03">';

				if($banner_title != '')
					$output .= '<div class="ultb3-title ult-responsive" '.$info_banner_data_list.' style="'.$title_style_inline.'">'.$banner_title.'</div>';
				if($banner_desc != '')
					$output .= '<div class="ultb3-desc ult-responsive" '.$info_banner_desc_data_list.' style="'.$desc_style_inline.'">'.$banner_desc.'</div>';
				if($button_text != '')
				{
					if($target != '')
						$target = 'target="'.$target.'"';
					$output .= '<a href="'.$button_link_main.'" '.$target.'  class="ultb3-btn ult-responsive" '.$info_banner_btn_data_list.' style="'.$button_style_inline.'">'.$button_text.'<i class="Defaults-angle-right"></i></a>';
				}
				$output .= '</div>';
			$output .= '</div>';

			$global_button_style = $global_button_hover_style = '';
			$is_css = false;

			if($button_color != '')
			{
				$global_button_style .= 'border:'.$button_border_width.'px solid '.$button_color.';';
				$global_button_hover_style .= 'background:'.$button_color.';';
				$is_css = true;
			}

			if($button_border_radius != '')
			{
				$global_button_style .= 'border-radius:'.$button_border_radius.'px;';
				$is_css = true;
			}

			if($button_text_color != '')
			{
				$global_button_style .= 'color:'.$button_text_color.';';
				$is_css = true;
			}

			if($button_text_hover_color != '')
			{
				$global_button_hover_style .= 'color:'.$button_text_hover_color.';';
				$is_css = true;
			}

			if($is_css)
			{
				$output .= '<style>
					#ultib3-'.$id.' {
						min-height:'.$banner_size.'px;
					}
					#ultib3-'.$id.' img.ultb3-img {
						height: '.$banner_img_height.'px;
					}
					#ultib3-'.$id.' .ultb3-btn {
						'.$global_button_style.'
					}
					#ultib3-'.$id.' .ultb3-btn:hover {
						'.$global_button_hover_style.'
					}
				</style>';
				if($banner_img_height_large_screen != '')
				{
					$output .= '<style>
						@media (min-width: 1824px) {
							 #ultib3-'.$id.' img.ultb3-img {
								height:'.$banner_img_height_large_screen.'px;
							}
						}
					</style>';
				}
				if($banner_img_height_tablet != '')
				{
					$output .= '<style>
						@media (max-width: 1199px) {
							 #ultib3-'.$id.' img.ultb3-img {
								height:'.$banner_img_height_tablet.'px;
							}
						}
					</style>';
				}
				if($banner_img_height_tablet_portrait != '')
				{
					$output .= '<style>
						@media (max-width: 991px) {
							 #ultib3-'.$id.' img.ultb3-img {
								height:'.$banner_img_height_tablet_portrait.'px;
							}
						}
					</style>';
				}
				if($banner_img_height_mobile_landscape != '')
				{
					$output .= '<style>
						@media (max-width: 767px) {
							 #ultib3-'.$id.' img.ultb3-img {
								height:'.$banner_img_height_mobile_landscape.'px;
							}
						}
					</style>';
				}
				if($banner_img_height_mobile != '')
				{
					$output .= '<style>
						@media (max-width: 479px) {
							 #ultib3-'.$id.' img.ultb3-img {
								height:'.$banner_img_height_mobile.'px;
							}
						}
					</style>';
				}
			}

			return $output;
		}
	}
}
if(class_exists('Ultimate_Info_Banner'))
{
	$Ultimate_Info_Banner = new Ultimate_Info_Banner;
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_ultimate_info_banner extends WPBakeryShortCode {
    }
}
