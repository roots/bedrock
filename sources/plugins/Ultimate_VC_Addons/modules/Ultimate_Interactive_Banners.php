<?php
/*
* Add-on Name: Interactive Banners for Visual Composer
* Add-on URI: http://dev.brainstormforce.com
*/
if(!class_exists('AIO_Interactive_Banners'))
{
	class AIO_Interactive_Banners
	{
		function __construct() {
			add_action('init',array($this,'banner_init'));
			add_shortcode('interactive_banner',array($this,'banner_shortcode'));
			add_action('wp_enqueue_scripts', array($this, 'register_ib_banner_assets'),1);
		}
		function register_ib_banner_assets() {
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
			wp_register_style('ult-interactive-banner',plugins_url($css_path.'interactive-styles'.$ext.'.css',__FILE__),array(), ULTIMATE_VERSION, false);
		}
		function banner_init()
		{
			if(function_exists('vc_map'))
			{
				vc_map(
					array(
					   "name" => __("Interactive Banner","ultimate_vc"),
					   "base" => "interactive_banner",
					   "class" => "vc_interactive_icon",
					   "icon" => "vc_icon_interactive",
					   "category" => "Ultimate VC Addons",
					   "description" => __("Displays the banner image with Information","ultimate_vc"),
					   "params" => array(
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Interactive Banner Title ","ultimate_vc"),
								"param_name" => "banner_title",
								"admin_label" => true,
								"value" => "",
								"description" => __("Give a title to this banner","ultimate_vc")
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Banner Title Location ","ultimate_vc"),
								"param_name" => "banner_title_location",
								"value" => array(
									__("Title on Center","ultimate_vc")=>'center',
									__("Title on Left","ultimate_vc")=>'left',
								),
								"description" => __("Alignment of the title.","ultimate_vc")
							),
							array(
								"type" => "textarea",
								"class" => "",
								"heading" => __("Banner Description","ultimate_vc"),
								"param_name" => "banner_desc",
								"value" => "",
								"description" => __("Text that comes on mouse hover.","ultimate_vc")
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Use Icon", "ultimate_vc"),
								"param_name" => "icon_disp",
								"value" => array(
									__("None","ultimate_vc") => "none",
									__("Icon with Heading","ultimate_vc") => "with_heading",
									__("Icon with Description","ultimate_vc") => "with_description",
									__("Both","ultimate_vc") => "both",
								),
								"description" => __("Icon can be displayed with title and description.", "ultimate_vc"),
							),
							array(
								"type" => "icon_manager",
								"class" => "",
								"heading" => __("Select Icon","ultimate_vc"),
								"param_name" => "banner_icon",
								"admin_label" => true,
								"value" => "",
								"description" => __("Click and select icon of your choice. If you can't find the one that suits for your purpose","ultimate_vc").", ".__("you can","ultimate_vc")." <a href='admin.php?page=bsf-font-icon-manager' target='_blank'>".__("add new here","ultimate_vc")."</a>.",
								"dependency" => Array("element" => "icon_disp","value" => array("with_heading","with_description","both")),
							),
							array(
								"type" => "ult_img_single",
								"class" => "",
								"heading" => __("Banner Image","ultimate_vc"),
								"param_name" => "banner_image",
								"value" => "",
								"description" => __("Upload the image for this banner","ultimate_vc")
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Banner height Type","ultimate_vc"),
								"param_name" => "banner_height",
								"value" => array(
									__("Auto Height","ultimate_vc") => '',
									__("Custom Height","ultimate_vc") => 'ult-banner-block-custom-height'
								),
								"description" => __("Selct between Auto or Custom height for Banner.","ultimate_vc")
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Banner height Value","ultimate_vc"),
								"param_name" => "banner_height_val",
								"value" => '',
								"suffix"=>'px',
								"description" => __("Give height in pixels for interactive banner.","ultimate_vc"),
								"dependency" => Array("element"=>"banner_height","value"=>array("ult-banner-block-custom-height"))
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Apply link to:", "ultimate_vc"),
								"param_name" => "link_opts",
								"value" => array(
									__("No Link","ultimate_vc") => "none",
									__("Complete Box","ultimate_vc") => "box",
									__("Display Read More","ultimate_vc") => "more",
								),
								"description" => __("Select whether to use color for icon or not.", "ultimate_vc"),
							),
							array(
								"type" => "vc_link",
								"class" => "",
								"heading" => __("Banner Link ","ultimate_vc"),
								"param_name" => "banner_link",
								"value" => "",
								"description" => __("Add link / select existing page to link to this banner","ultimate_vc"),
								"dependency" => Array("element" => "link_opts", "value" => array("box","more")),
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Link Text","ultimate_vc"),
								"param_name" => "banner_link_text",
								"value" => "",
								"description" => __("Enter text for button","ultimate_vc"),
								"dependency" => Array("element" => "link_opts","value" => array("more")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Button Background Color","ultimate_vc"),
								"param_name" => "banner_link_bg_color",
								"value" => "#242424",
								"description" => __("Select the background color for banner overlay","ultimate_vc"),
								"dependency" => Array("element" => "link_opts","value" => array("more")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Button Text Color","ultimate_vc"),
								"param_name" => "banner_link_text_color",
								"value" => "#ffffff",
								"description" => __("Select the background color for banner overlay","ultimate_vc"),
								"dependency" => Array("element" => "link_opts","value" => array("more")),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Box Hover Effects","ultimate_vc"),
								"param_name" => "banner_style",
								"value" => array(
									__("Appear From Bottom","ultimate_vc") => "style01",
									__("Appear From Top","ultimate_vc") => "style02",
									__("Appear From Left","ultimate_vc") => "style03",
									__("Appear From Right","ultimate_vc") => "style04",
									__("Zoom In","ultimate_vc") => "style11",
									__("Zoom Out","ultimate_vc") => "style12",
									__("Zoom In-Out","ultimate_vc") => "style13",
									__("Jump From Left","ultimate_vc") => "style21",
									__("Jump From Right","ultimate_vc") => "style22",
									__("Pull From Bottom","ultimate_vc") => "style31",
									__("Pull From Top","ultimate_vc") => "style32",
									__("Pull From Left","ultimate_vc") => "style33",
									__("Pull From Right","ultimate_vc") => "style34",
									),
								"description" => __("Select animation effect style for this block.","ultimate_vc")
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Heading Title Color","ultimate_vc"),
								"param_name" => "heading_title_color",
								"value" => "#ffffff",
								"description" => __("Select the  color for banner heading","ultimate_vc"),
								"group" => "Color",

							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Heading Background Color","ultimate_vc"),
								"param_name" => "banner_bg_color",
								"value" => "#242424",
								"description" => __("Select the background color for banner heading","ultimate_vc"),
								"group" => "Color",

							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Descrption  Color","ultimate_vc"),
								"param_name" => "desc_color",
								"value" => "#ffffff",
								"description" => __("Select the Description color for banner ","ultimate_vc"),
								"group" => "Color",

							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon  Color","ultimate_vc"),
								"param_name" => "icon_color",
								"value" => "#ffffff",
								"description" => __("Select the  color for icon ","ultimate_vc"),
								"group" => "Color",
								"dependency" => Array("element" => "icon_disp","value" => array("with_heading","with_description","both")),

							),
							/*array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Background Color Opacity","ultimate_vc"),
								"param_name" => "banner_opacity",
								"value" => array(
									__('Transparent Background','ultimate_vc')=>'opaque',
									__('Solid Background','ultimate_vc')=>'solid'
								),
								"description" => __("Select the background opacity for content overlay","ultimate_vc")
							),*/
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Overlay Background Color","ultimate_vc"),
								"param_name" => "banner_overlay_bg_color",
								"value" => "#242424",
								"description" => __("Select the background color for banner overlay","ultimate_vc"),
								//"group" => "Color",

							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Extra Class", "ultimate_vc"),
								"param_name" => "el_class",
								"value" => "",
								"description" => __("Add extra class name that will be applied to the icon process, and you can use this class for your customizations.", "ultimate_vc"),
							),
							array(
								"type" => "ult_param_heading",
								"text" => __("Banner Title Settings","ultimate_vc"),
								"param_name" => "banner_title_typograpy",
								//"dependency" => Array("element" => "banner_title", "not_empty" => true),
								"group" => "Typography",
								'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
							),
							array(
								"type" => "ultimate_google_fonts",
								"heading" => __("Font Family", "ultimate_vc"),
								"param_name" => "banner_title_font_family",
								"description" => __("Select the font of your choice.","ultimate_vc")." ".__("You can","ultimate_vc")." <a target='_blank' href='".admin_url('admin.php?page=bsf-google-font-manager')."'>".__("add new in the collection here","ultimate_vc")."</a>.",
								//"dependency" => Array("element" => "banner_title", "not_empty" => true),
								"group" => "Typography"
							),
							array(
								"type" => "ultimate_google_fonts_style",
								"heading" 		=>	__("Font Style", "ultimate_vc"),
								"param_name"	=>	"banner_title_style",
								//"description"	=>	__("Main heading font style", "smile"),
								//"dependency" => Array("element" => "banner_title", "not_empty" => true),
								"group" => "Typography"
							),
							// array(
							// 	"type" => "number",
							// 	"class" => "",
							// 	"heading" => __("Font Size", "ultimate_vc"),
							// 	"param_name" => "banner_title_font_size",
							// 	"min" => 12,
							// 	"suffix" => "px",
							// 	//"description" => __("Sub heading font size", "smile"),
							// 	"dependency" => Array("element" => "banner_title", "not_empty" => true),
							// 	"group" => "Typography",
							// ),
							array(
		                    "type" => "ultimate_responsive",
		                    "class" => "",
		                    "heading" => __("Font size", 'ultimate_vc'),
		                    "param_name" => "banner_title_font_size",
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
		                    "param_name" => "banner_title_line_height",
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
								"text" => __("Banner Description Settings","ultimate_vc"),
								"param_name" => "banner_desc_typograpy",
								//"dependency" => Array("element" => "banner_desc", "not_empty" => true),
								"group" => "Typography",
								'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
							),
							array(
								"type" => "ultimate_google_fonts",
								"heading" => __("Font Family", "ultimate_vc"),
								"param_name" => "banner_desc_font_family",
								"description" => __("Select the font of your choice.","ultimate_vc")." ".__("You can","ultimate_vc")." <a target='_blank' href='".admin_url('admin.php?page=bsf-google-font-manager')."'>".__("add new in the collection here","ultimate_vc")."</a>.",
								//"dependency" => Array("element" => "banner_desc", "not_empty" => true),
								"group" => "Typography"
							),
							array(
								"type" => "ultimate_google_fonts_style",
								"heading" 		=>	__("Font Style", "ultimate_vc"),
								"param_name"	=>	"banner_desc_style",
								//"description"	=>	__("Main heading font style", "smile"),
								//"dependency" => Array("element" => "banner_desc", "not_empty" => true),
								"group" => "Typography"
							),
							// array(
							// 	"type" => "number",
							// 	"class" => "",
							// 	"heading" => __("Font Size", "ultimate_vc"),
							// 	"param_name" => "banner_desc_font_size",
							// 	"min" => 12,
							// 	"suffix" => "px",
							// 	//"description" => __("Sub heading font size", "smile"),
							// 	"dependency" => Array("element" => "banner_desc", "not_empty" => true),
							// 	"group" => "Typography",
							// ),
							array(
			                    "type" => "ultimate_responsive",
			                    "class" => "",
			                    "heading" => __("Font size", 'ultimate_vc'),
			                    "param_name" => "banner_desc_font_size",
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
			                    "param_name" => "banner_desc_line_height",
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
						            "type" => "ultimate_spacing",
						            "heading" => " Margin ",
						            "param_name" => "ib_wrapper_margin",
						            "mode"  => "margin",                    //  margin/padding
						            "unit"  => "px",                        //  [required] px,em,%,all     Default all
						            "positions" => array(                   //  Also set 'defaults'
						              	"Top" => "",
						              	"Right" => "",
						              	"Bottom" => "",
						              	"Left" => "",
						            ),
									 'group' => __( 'Design ', 'ultimate_vc' ),
									 "description" => __("Add or remove margin.", "ultimate_vc"),
					        ),
						),
					)
				);
			}
		}
		// Shortcode handler function for stats banner
		function banner_shortcode($atts)
		{
			$banner_title = $banner_title_line_height = $banner_desc = $banner_desc_line_height = $banner_icon = $banner_image = $banner_link = $banner_link_text = $banner_style = $banner_bg_color = $el_class = $animation = $icon_disp = $link_opts = $banner_title_location = $banner_title_style_inline = $banner_desc_style_inline = $banner_overlay_bg_color = $banner_link_text_color = $banner_link_bg_color = $css_ibanner = '';
			extract(shortcode_atts( array(
				'banner_title' => '',
				'banner_desc' => '',
				'banner_title_location' => 'center',
				'icon_disp' => 'none',
				'banner_icon' => '',
				'banner_image' => '',
				'banner_height'=>'',
				'banner_height_val'=>'',
				'link_opts' => 'none',
				'banner_link' => '',
				'banner_link_text' => '',
				'banner_style' => 'style01',
				'banner_bg_color' => '#242424',
				'banner_overlay_bg_color' => '#242424',
				'banner_opacity' => 'opaque',
				'el_class' =>'',
				'animation' => '',
				'banner_title_font_family' => '',
				'banner_title_style' => '',
				'banner_title_font_size' => '',
				'banner_title_line_height' =>'',
				'banner_desc_font_family' => '',
				'banner_desc_style' => '',
				'banner_desc_font_size' => '',
				'banner_desc_line_height' => '',
				'banner_link_text_color' => '#ffffff',
				'banner_link_bg_color' => '#242424',
				'heading_title_color'=>'#ffffff',
				'desc_color'=>'#ffffff',
				'icon_color'=>'#ffffff',
				'ib_wrapper_margin'=> '',

			),$atts));
			$css_ibanner_styles = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css_ibanner, ' ' ), "interactive_banner", $atts );
			$css_ibanner_styles = esc_attr( $css_ibanner_styles );

			$vc_version = (defined('WPB_VC_VERSION')) ? WPB_VC_VERSION : 0;
			$is_vc_49_plus = (version_compare(4.9, $vc_version, '<=')) ? 'ult-adjust-bottom-margin' : '';
			$output = $icon = $style = $target = '';
			$headerstyle = $ib_wrapper_margin;
			if($banner_title_font_family != '')
			{
				$bfamily = get_ultimate_font_family($banner_title_font_family);
				if($bfamily !== '')
					$banner_title_style_inline = 'font-family:\''.$bfamily.'\';';
			}
			$banner_title_style_inline .= get_ultimate_font_style($banner_title_style);
			// if($banner_title_font_size != '')
			// 	$banner_title_style_inline .= 'font-size:'.$banner_title_font_size.'px;';

			//Responsive param

			if(is_numeric($banner_title_font_size)){
				$banner_title_font_size = 'desktop:'.$banner_title_font_size.'px;';
			}

			if(is_numeric($banner_title_line_height)){
				$banner_title_line_height = 'desktop:'.$banner_title_line_height.'px;';
			}

			$interactive_banner_1_id = 'interactive-banner-1-wrap-'.rand(1000, 9999);

			$interactive_banner_1_args = array(
                'target' => '#'.$interactive_banner_1_id.' .bb-top-title ', // set targeted element e.g. unique class/id etc.
                'media_sizes' => array(
                    'font-size' => $banner_title_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
                   	'line-height' => $banner_title_line_height
                ),
            );
			$interactive_banner_1_data_list = get_ultimate_vc_responsive_media_css($interactive_banner_1_args);

			if($banner_bg_color != '')
				$banner_title_style_inline .= 'background:'.$banner_bg_color.';';

			if($heading_title_color != '')
				$banner_title_style_inline .= 'color:'.$heading_title_color.';';


			if($banner_desc_font_family != '')
			{
				$bdfamily = get_ultimate_font_family($banner_desc_font_family);
				if($bdfamily !== '')
					$banner_desc_style_inline = 'font-family:\''.$bdfamily.'\';';
			}
			$banner_desc_style_inline .= get_ultimate_font_style($banner_desc_style);
			// if($banner_desc_font_size != '')
			// 	$banner_desc_style_inline .= 'font-size:'.$banner_desc_font_size.'px;';

			//Responsive param

			if(is_numeric($banner_desc_font_size)){
				$banner_desc_font_size = 'desktop:'.$banner_desc_font_size.'px;';
			}

			if(is_numeric($banner_desc_line_height)){
				$banner_desc_line_height = 'desktop:'.$banner_desc_line_height.'px;';
			}

			$interactive_banner_desc_1_args = array(
                'target' => '#'.$interactive_banner_1_id.' .bb-description', // set targeted element e.g. unique class/id etc.
                'media_sizes' => array(
                    'font-size' => $banner_desc_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
                   	'line-height' => $banner_desc_line_height
                ),
            );
			$interactive_banner_desc_1_data_list = get_ultimate_vc_responsive_media_css($interactive_banner_desc_1_args);


			if($desc_color != '')
				$banner_desc_style_inline .= 'color:'.$desc_color.';';

			$icon_style = $css_trans = '';
			if($icon_color !=='')
				$icon_style.='color:'.$icon_color.';';

			if($banner_icon !== '')
				$icon = '<i class="'.$banner_icon.'"  style= "'.$icon_style.'"></i>';
			$img = apply_filters('ult_get_img_single', $banner_image, 'url');
			$alt = apply_filters('ult_get_img_single', $banner_image, 'alt');
			$href = vc_build_link($banner_link);
			if(isset($href['target']) && $href['target'] != ''){
				$target = 'target="'.$href['target'].'"';
			}
			$banner_top_style='';
			if($banner_height!='' && $banner_height_val!=''){
				$banner_top_style = 'height:'.$banner_height_val.'px;';
			}
			$output .= "\n".'<div id="'.$interactive_banner_1_id.'" class="ult-banner-block '.$is_vc_49_plus.' ult-bb-'.$link_opts.' '.$banner_height.' banner-'.$banner_style.' '.$el_class.'"  '.$css_trans.' style="'.$banner_top_style.''.$headerstyle.'">';
			if($img !== '')
				$output .= "\n\t".'<img src="'.apply_filters('ultimate_images', $img).'" alt="'.$alt.'">';
			if($banner_title !== ''){
				$output .= "\n\t".'<h3 '.$interactive_banner_1_data_list.' class="title-'.$banner_title_location.' bb-top-title ult-responsive" style="'.$banner_title_style_inline.'">'.$banner_title;
				if($icon_disp == "with_heading" || $icon_disp == "both")
					$output .= $icon;
				$output .= '</h3>';
			}
			$banner_overlay_bg_color = 'background:'.$banner_overlay_bg_color.';';
			$output .= "\n\t".'<div class="mask '.$banner_opacity.'-background" style="'.$banner_overlay_bg_color.'">';
			if($icon_disp == "with_description" || $icon_disp == "both"){
				if($banner_icon !== ''){
					$output .= "\n\t\t".'<div class="bb-back-icon">'.$icon.'</div>';
					$output .= "\n\t\t".'<p class="" style="'.$banner_desc_style_inline.'">'.$banner_desc.'</p>';
				}
			} else {
				$output .= "\n\t\t".'<div '.$interactive_banner_desc_1_data_list.' class="bb-description ult-responsive" style="'.$banner_desc_style_inline.'">'.$banner_desc.'</div>';
			}
			if($link_opts == "more"){
				$button_style = 'background:'.$banner_link_bg_color.';';
				$button_style .= 'color:'.$banner_link_text_color.';';
				$output .= "\n\t\t".'<a class="bb-link" href="'.$href['url'].'" '.$target.' style="'.$button_style.'">'.$banner_link_text.'</a>';
			}
			$output .= "\n\t".'</div>';
			if($link_opts == "box")
				$output .= '<a class="bb-link" href="'.$href['url'].'" '.$target.'></a>';
			$output .= "\n".'</div>';
			//if($link_opts == "box"){
				//$banner_with_link = '<a class="bb-link" href="'.$href['url'].'" '.$target.'>'.$output.'</a>';
				//return $banner_with_link;
			//} else {
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
			//}
		}
	}
}
if(class_exists('AIO_Interactive_Banners'))
{
	$AIO_Interactive_Banners = new AIO_Interactive_Banners;
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_interactive_banner extends WPBakeryShortCode {
    }
}