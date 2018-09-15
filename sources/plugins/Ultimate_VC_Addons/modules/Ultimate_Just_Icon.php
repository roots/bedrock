<?php
/*
* Add-on Name: Just Icon for Visual Composer
* Add-on URI: http://dev.brainstormforce.com
*/
if(!class_exists('AIO_Just_Icon'))
{
	class AIO_Just_Icon
	{
		function __construct()
		{
			add_action('init',array($this,'just_icon_init'));
			add_shortcode('just_icon',array($this,'just_icon_shortcode'));
		}
		function just_icon_init()
		{
			if(function_exists('vc_map'))
			{
				vc_map(
					array(
					   "name" => __("Just Icon","ultimate_vc"),
					   "base" => "just_icon",
					   "class" => "vc_simple_icon",
					   "icon" => "vc_just_icon",
					   "category" => "Ultimate VC Addons",
					   "description" => __("Add a simple icon and give some custom style.","ultimate_vc"),
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
								"description" => __("Use existing font icon or upload a custom image.", "ultimate_vc")
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
								"admin_label" => true,
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
								"heading" => __("Icon or Image Style", "ultimate_vc"),
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
									__("None","ultimate_vc")=> "",
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
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
							),
							array(
								"type" => "vc_link",
								"class" => "",
								"heading" => __("Link ","smile"),
								"param_name" => "icon_link",
								"value" => "",
								"description" => __("Add a custom link or select existing page. You can remove existing link as well.","ultimate_vc")
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
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Tooltip", "ultimate_vc"),
								"param_name" => "tooltip_disp",
								"value" => array(
									__("None","ultimate_vc")=> "",
									__("Tooltip from Left","ultimate_vc") => "left",
									__("Tooltip from Right","ultimate_vc") => "right",
									__("Tooltip from Top","ultimate_vc") => "top",
									__("Tooltip from Bottom","ultimate_vc") => "bottom",
								),
								"description" => __("Select the tooltip position","ultimate_vc"),
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Tooltip Text", "ultimate_vc"),
								"param_name" => "tooltip_text",
								"value" => "",
								"description" => __("Enter your tooltip text here.", "ultimate_vc"),
								"dependency" => Array("element" => "tooltip_disp", "not_empty" => true),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Alignment", "ultimate_vc"),
								"param_name" => "icon_align",
								"value" => array(
									__("Center","ultimate_vc")	=>	"center",
									__("Left","ultimate_vc")		=>	"left",
									__("Right","ultimate_vc")		=>	"right"
								)
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Custom CSS Class", "ultimate_vc"),
								"param_name" => "el_class",
								"value" => "",
								"description" => __("Ran out of options? Need more styles? Write your own CSS and mention the class name here.", "ultimate_vc"),
							),
							array(
								'type' => 'css_editor',
					            'heading' => __( 'Css', 'ultimate_vc' ),
					            'param_name' => 'css_just_icon',
					            'group' => __( 'Design ', 'ultimate_vc' ),
					            'edit_field_class' => 'vc_col-sm-12 vc_column no-vc-background no-vc-border creative_link_css_editor',
					        ),
						),
					)
				);
			}
		}
		// Shortcode handler function for stats Icon
		function just_icon_shortcode($atts)
		{
			$icon_type = $icon_img = $img_width = $icon = $icon_color = $icon_color_bg = $icon_size = $icon_style = $icon_border_style = $icon_border_radius = $icon_color_border = $icon_border_size = $icon_border_spacing = $icon_link = $el_class = $icon_animation =  $tooltip_disp = $tooltip_text = $icon_align = '';
			extract(shortcode_atts( array(
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
				'icon_link' => '',
				'icon_animation' => 'none',
				'tooltip_disp' => '',
				'tooltip_text' => '',
				'el_class'=>'',
				'icon_align' => 'center',
				'css_just_icon' => '',
			),$atts));
			$is_preset = false;
			if(isset($_GET['preset'])) {
				$is_preset = true;
			}
			$css_just_icon = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css_just_icon, ' ' ), "just_icon", $atts );
			$css_just_icon = esc_attr( $css_just_icon );
			$ultimate_js = get_option('ultimate_js');
			if($tooltip_text != '' && $ultimate_js == 'disable')
				wp_enqueue_script('ultimate-tooltip');

			$output = $style = $link_sufix = $link_prefix = $target = $href = $icon_align_style = $css_trans = '';

			if(trim($icon_animation) === '')
				$icon_animation = 'none';

			if($icon_animation !== 'none')
			{
				$css_trans = 'data-animation="'.$icon_animation.'" data-animation-delay="03"';
			}

			$uniqid = uniqid();
			if($icon_link !== ''){
				$href = vc_build_link($icon_link);
				$target = (isset($href['target'])) ? "target='".$href['target']."'" : '';
				$link_prefix .= '<a class="aio-tooltip '.$uniqid.'" href = "'.$href['url'].'" '.$target.' data-toggle="tooltip" data-placement="'.$tooltip_disp.'" title="'.$tooltip_text.'">';
				$link_sufix .= '</a>';
			} else {
				if($tooltip_disp !== ""){
					$link_prefix .= '<div class="aio-tooltip '.$uniqid.'" href = "'.$href.'" '.$target.' data-toggle="tooltip" data-placement="'.$tooltip_disp.'" title="'.$tooltip_text.'">';
					$link_sufix .= '</div>';
				}
			}

			$elx_class = '';

			/* position fix */
			if($icon_align == 'right')
				$icon_align_style .= 'text-align:right;';
			elseif($icon_align == 'center')
				$icon_align_style .= 'text-align:center;';
			elseif($icon_align == 'left')
				$icon_align_style .= 'text-align:left;';

			if($icon_type == 'custom'){

				$img = apply_filters('ult_get_img_single', $icon_img, 'url');
				$alt = apply_filters('ult_get_img_single', $icon_img, 'alt');
				//$title = apply_filters('ult_get_img_single', $icon_img, 'title');
				//$description = apply_filters('ult_get_img_single', $icon_img, 'description');
				//$caption = apply_filters('ult_get_img_single', $icon_img, 'caption');

				if($icon_style !== 'none'){
					if($icon_color_bg !== '')
						$style .= 'background:'.$icon_color_bg.';';
				}
				if($icon_style == 'circle'){
					$elx_class.= ' uavc-circle ';
				}
				if($icon_style == 'square'){
					$elx_class.= ' uavc-square ';
				}
				if($icon_style == 'advanced' && $icon_border_style !== '' ){
					$style .= 'border-style:'.$icon_border_style.';';
					$style .= 'border-color:'.$icon_color_border.';';
					$style .= 'border-width:'.$icon_border_size.'px;';
					$style .= 'padding:'.$icon_border_spacing.'px;';
					$style .= 'border-radius:'.$icon_border_radius.'px;';
				}

				if(!empty($img)){
					if($icon_link == '' || $icon_align == 'center') {
						$style .= 'display:inline-block;';
					}
					$output .= "\n".$link_prefix.'<div class="aio-icon-img '.$elx_class.'" style="font-size:'.$img_width.'px;'.$style.'" '.$css_trans.'>';
					$output .= "\n\t".'<img class="img-icon" alt="'.$alt.'" src="'.apply_filters('ultimate_images', $img).'"/>';
					$output .= "\n".'</div>'.$link_sufix;
				}
				$output = $output;
			} else {
				if($icon_color !== '')
					$style .= 'color:'.$icon_color.';';
				if($icon_style !== 'none'){
					if($icon_color_bg !== '')
						$style .= 'background:'.$icon_color_bg.';';
				}
				if($icon_style == 'advanced'){
					$style .= 'border-style:'.$icon_border_style.';';
					$style .= 'border-color:'.$icon_color_border.';';
					$style .= 'border-width:'.$icon_border_size.'px;';
					$style .= 'width:'.$icon_border_spacing.'px;';
					$style .= 'height:'.$icon_border_spacing.'px;';
					$style .= 'line-height:'.$icon_border_spacing.'px;';
					$style .= 'border-radius:'.$icon_border_radius.'px;';
				}
				if($icon_size !== '')
					$style .='font-size:'.$icon_size.'px;';
				if($icon_align !== 'left'){
					$style .= 'display:inline-block;';
				}
				if($icon !== ""){
					$output .= "\n".$link_prefix.'<div class="aio-icon '.$icon_style.' '.$elx_class.'" '.$css_trans.' style="'.$style.'">';
					$output .= "\n\t".'<i class="'.$icon.'"></i>';
					$output .= "\n".'</div>'.$link_sufix;
				}
				$output = $output;
			}
			if($tooltip_disp !== ""){
				$output .= '<script>
					jQuery(function () {
						jQuery(".'.$uniqid.'").bsf_tooltip("hide");
					})
				</script>';
			}
			/* alignment fix */
			if($icon_align_style !== ''){
				$output = '<div class="align-icon" style="'.$icon_align_style.'">'.$output.'</div>';
			}

			$output = '<div class="ult-just-icon-wrapper '.$el_class.' '.$css_just_icon.'">'.$output.'</div>';

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
	}
}
if(class_exists('AIO_Just_Icon'))
{
	$AIO_Just_Icon = new AIO_Just_Icon;
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_just_icon extends WPBakeryShortCode {
    }
}