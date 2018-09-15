<?php
/*
* Add-on Name: Icons Block for Visual Composer
*/
if(!class_exists('Ultimate_List_Icon'))
{
	class Ultimate_List_Icon
	{
		function __construct()
		{
			add_action('init',array($this,'list_icon_init'));
			add_shortcode('ultimate_icon_list',array($this,'ultimate_icon_list_shortcode'));
			add_shortcode('ultimate_icon_list_item',array($this,'icon_list_item_shortcode'));
		}
		function list_icon_init()
		{
			if(function_exists('vc_map'))
			{
				vc_map(
					array(
						"name" => __("List Icon","ultimate_vc"),
						"base" => "ultimate_icon_list",
						"class" => "ultimate_icon_list",
						"icon" => "ultimate_icon_list",
						"category" => "Ultimate VC Addons",
						"description" => __("Add a set of multiple icons and give some custom style.","ultimate_vc"),
						"as_parent" => array('only' => 'ultimate_icon_list_item'),
						"content_element" => true,
						"show_settings_on_create" => true,
						"js_view" => 'VcColumnView',
						//"is_container"    => true,
						"params" => array(
							// Play with icon selector
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Size of Icon", "ultimate_vc"),
								"param_name" => "icon_size",
								"value" => '',
								"min" => 0,
								"max" => 200,
								"suffix" => "px",
								"description" => __("How big would you like it?", "ultimate_vc"),
								//"dependency" => Array("element" => "icon_type","value" => array("selector")),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Space after Icon", "ultimate_vc"),
								"param_name" => "icon_margin",
								"value" => '',
								"min" => 0,
								"max" => 100,
								"suffix" => "px",
								"description" => __("How much distance would you like in two icons?", "ultimate_vc"),

							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Extra Class","ultimate_vc"),
								"param_name" => "el_class",
								"value" => "",
								"description" => __("Write your own CSS and mention the class name here.", "ultimate_vc"),
							),
							array(
								'type' => 'css_editor',
					            'heading' => __( 'Css', 'ultimate_vc' ),
					            'param_name' => 'css_icon_list',
					            'group' => __( 'Design ', 'ultimate_vc' ),
					            'edit_field_class' => 'vc_col-sm-12 vc_column no-vc-background no-vc-border creative_link_css_editor',
					        ),
						)
					)
				);
				vc_map(
					array(
					   "name" => __("List Icon Item","ultimate_vc"),
					   "base" => "ultimate_icon_list_item",
					   "class" => "icon_list_item",
					   "icon" => "icon_list_item",
					   "category" => "Ultimate VC Addons",
					   "description" => __("Add a list of icons with some content and give some custom style.","ultimate_vc"),
					   "as_child" => array('only' => 'ultimate_icon_list'),
					   "show_settings_on_create" => true,
					   "is_container"    => false,
					   "params" => array(
							// Play with icon selector
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
								"dependency" => Array("element" => "icon_type","value" => array("selector")),
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
								"type" => "textarea_html",
								"class" => "",
								"heading" => __("List content", "ultimate_vc"),
								"param_name" => "content",
								"value" => "",
								"description" => __("Enter the list content here.", "ultimate_vc"),
								"edit_field_class" => "ult_hide_editor_fullscreen vc_col-xs-12 vc_column wpb_el_type_textarea_html vc_wrapper-param-type-textarea_html vc_shortcode-param",
								"group"=> "List Content",
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Custom CSS Class", "smile"),
								"param_name" => "el_class",
								"value" => "",
								"description" => __("Ran out of options? Need more styles? Write your own CSS and mention the class name here.", "ultimate_vc"),

							),
							array(
								"type" => "ult_param_heading",
								"param_name" => "title_text_typography",
								"heading" => __("List content settings","ultimate_vc"),
								"value" => "",
								"group" => "Typography",
								"class" => "ult-param-heading",
								'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
							),
							array(
								"type" => "ultimate_google_fonts",
								"heading" => __("Font Family","ultimate_vc"),
								"param_name" => "content_font_family",
								"value" => "",
								"group" => "Typography"
							),
							array(
								"type" => "ultimate_google_fonts_style",
								"heading" => __("Font Style","ultimate_vc"),
								"param_name" => "content_font_style",
								"value" => "",
								"group" => "Typography"
							),
							// array(
							// 	"type" => "number",
							// 	"param_name" => "content_font_size",
							// 	"heading" => __("Font size","ultimate_vc"),
							// 	"value" => "",
							// 	"suffix" => "px",
							// 	"group" => "Typography"
							// ),

							// array(
							// 	"type" => "number",
							// 	"param_name" => "content_line_ht",
							// 	"heading" => __("Line Height","ultimate_vc"),
							// 	"value" => "",
							// 	"suffix" => "px",
							// 	"group" => "Typography",
							// ),
							array(
		                    "type" => "ultimate_responsive",
		                    "class" => "",
		                    "heading" => __("Font size", 'ultimate_vc'),
		                    "param_name" => "content_font_size",
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
		                    "param_name" => "content_line_ht",
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
								"param_name" => "content_font_color",
								"heading" => __("Color","ultimate_vc"),
								"group" => "Typography"
							),
						),
					)
				);
			}
		}
		// Shortcode handler function for list Icon
		function ultimate_icon_list_shortcode($atts,$content = null)
		{
			global $vc_list_icon_size, $vc_list_icon_margin;
			$el_class = '';
			extract(shortcode_atts(array(
				"icon_size" => "32",
				"icon_margin" => "5",
				"el_class" => "",
				"css_icon_list" => "",
			),$atts));
			$css_icon_list = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css_icon_list, ' ' ), "ultimate_icon_list", $atts );
			$css_icon_list = esc_attr( $css_icon_list );
			$vc_version = (defined('WPB_VC_VERSION')) ? WPB_VC_VERSION : 0;
			$is_vc_49_plus = (version_compare(4.9, $vc_version, '<=')) ? 'ult-adjust-bottom-margin' : '';

			$vc_list_icon_size = $icon_size;
			$vc_list_icon_margin = $icon_margin;
			// enqueue js
			//wp_enqueue_script('aio-tooltip',plugins_url('../assets/min-js/',__FILE__).'tooltip.min.js',array('jquery'));

			$output = '<div class="uavc-list-icon uavc-list-icon-wrapper '.$is_vc_49_plus.' '.$el_class.' '.$css_icon_list.' '.$css_icon_list.'">';
			$output .= '<ul class="uavc-list">';
			$output .= do_shortcode($content);
			$output .= '</ul>';
			$output .= '</div>';

			return $output;
		}

		function icon_list_item_shortcode($atts, $content = null){

			$icon_type = $icon_img = $img_width = $icon = $icon_color = $icon_color_bg = $icon_size = $icon_style = $icon_border_style = $icon_border_radius = $icon_color_border = $icon_border_size = $icon_border_spacing = $icon_link = $el_class = $icon_animation =  $tooltip_disp = $tooltip_text = $icon_margin = '';
			$content_font_family = $content_font_style = $content_font_size = $content_line_ht = $content_font_color = $css_icon_list = '';
			extract(shortcode_atts( array(
				'icon_type' => 'selector',
				'icon'=> '',
				'icon_img' => '',
				'icon_color' => '#333333',
				'icon_style' => 'none',
				'icon_color_bg' => '#ffffff',
				'icon_color_border' => '#333333',
				'icon_border_style' => '',
				'icon_border_size' => '1',
				'icon_border_radius' => '500',
				'icon_border_spacing' => '50',
				"icon_size" => "",
				"icon_margin" => "",
				'el_class'=>'',
				'content_font_family' => '',
				'content_font_style' => '',
				'content_font_size' => '',
				'content_font_color' => '',
				'content_line_ht' => '',
				'content_font_size' => '',
			),$atts));
			global $vc_list_icon_size, $vc_list_icon_margin;
			if(empty($icon_size))
				$icon_size = $vc_list_icon_size;

			if(empty($icon_margin))
				$icon_margin = $vc_list_icon_margin;

			if($icon_animation !== 'none')
			{
				$css_trans = 'data-animation="'.$icon_animation.'" data-animation-delay="03"';
			}
			$output = $style = $link_sufix = $link_prefix = $target = $content_style = $href = $icon_align_style = '';

			if($icon_margin !== '')
				$style .= 'margin-right:'.$icon_margin.'px;';
			if($content_font_family != ''){
				$apply_font_family = get_ultimate_font_family($content_font_family);
				if($apply_font_family)
					$content_style .= 'font-family:\''.$apply_font_family.'\';';
			}
			if($content_font_style != ''){
					$content_style .= get_ultimate_font_style($content_font_style);
				}
			if($content_font_color !='')
				$content_style .= 'color:'.$content_font_color.';';
			// if($content_font_size != '')
			// 	$content_style .= 'font-size:'.$content_font_size.'px;';
			// if($content_line_ht)
			// 	$content_style .='line-height:'.$content_line_ht.'px;';
			if(is_numeric($content_font_size)){
				$content_font_size = 'desktop:'.$content_font_size.'px;';
			}

			if(is_numeric($content_line_ht)){
				$content_line_ht = 'desktop:'.$content_line_ht.'px;';
			}

			$list_icon_id = 'list-icon-wrap-'.rand(1000, 9999);

			$list_icon_args = array(
                'target' => '#'.$list_icon_id.' .uavc-list-desc', // set targeted element e.g. unique class/id etc.
                'media_sizes' => array(
                    'font-size' => $content_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
                   	'line-height' => $content_line_ht
                ),
            );

            $list_icon_data_list = get_ultimate_vc_responsive_media_css($list_icon_args);
			$icon_animation = $icon_link = '';

			$output .= '<div class="uavc-list-content" id="'.$list_icon_id.'">';

			if($icon !== "" || $icon_img !== ''){
				if($icon_type == 'custom'){
					$icon_style = 'none';
				}
				$main_icon = do_shortcode('[just_icon icon_type="'.$icon_type.'" icon="'.$icon.'" icon_img="'.$icon_img.'" img_width="'.$icon_size.'" icon_size="'.$icon_size.'" icon_color="'.$icon_color.'" icon_style="'.$icon_style.'" icon_color_bg="'.$icon_color_bg.'" icon_color_border="'.$icon_color_border.'"  icon_border_style="'.$icon_border_style.'" icon_border_size="'.$icon_border_size.'" icon_border_radius="'.$icon_border_radius.'" icon_border_spacing="'.$icon_border_spacing.'" icon_link="'.$icon_link.'" icon_animation="'.$icon_animation.'"]');
				$output .= "\n".'<div class="uavc-list-icon '.$el_class.' '.$css_icon_list.'" '.$css_trans.' style="'.$style.'">';
				$output .= $main_icon;
				$output .= "\n".'</div>';
			}
			$output .= '<span '.$list_icon_data_list.' class="uavc-list-desc ult-responsive" style="'.$content_style.'">'.do_shortcode($content).'</span>';
			$output .= '</div>';

			$output = '<li>'.$output.'</li>';
			return $output;
		}
	}
}
if(class_exists('Ultimate_List_Icon'))
{
	$Ultimate_List_Icon = new Ultimate_List_Icon;
}
//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_ultimate_icon_list extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_ultimate_icon_list_item extends WPBakeryShortCode {
    }
}