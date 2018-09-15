<?php
/*
@Module: Single Product view
@Since: 1.0
@Package: WooComposer
*/
if(!class_exists('WooComposer_ViewProduct')){
	class WooComposer_ViewProduct
	{
		function __construct(){
			add_action('admin_init',array($this,'WooComposer_Init_Product'));
			add_shortcode('woocomposer_product',array($this,'WooComposer_Product'));
		} 
		function WooComposer_Init_Product(){
			if(function_exists('vc_map')){
				$params =
					array(
						"name"		=> __("Single Product", "ultimate_vc"),
						"base"		=> "woocomposer_product",
						"icon"		=> "woo_product",
						"class"	   => "woo_product",
						"category"  => __("WooComposer [ Beta ]", "ultimate_vc"),
						"description" => __("Display single product from list","ultimate_vc"),
						"controls" => "full",
						"show_settings_on_create" => true,
						"deprecated" => "3.13.5",
						"params" => array(
							array(
								"type" => "product_search",
								"class" => "",
								"heading" => __("Select Product", "ultimate_vc"),
								"param_name" => "product_id",
								"admin_label" => true,
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Select Product Style", "ultimate_vc"),
								"param_name" => "product_style",
								"admin_label" => true,
								"value" => array(
										__("Style 01","ultimate_vc") => "style01",
										__("Style 02","ultimate_vc") => "style02",
										__("Style 03","ultimate_vc") => "style03",
									),
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "ult_switch",
								"class" => "",
								"heading" => __("Select Options to Display", "ultimate_vc"),
								"param_name" => "options",
								"admin_label" => true,
								"value" => "",
								"options" => array(
										"category" => array(
													"label" => __("Category","ultimate_vc"),
													"on" => __("Yes","ultimate_vc"),
													"off" => __("No","ultimate_vc"),
												),
										"reviews" => array(
													"label" => __("Reviews","ultimate_vc"),
													"on" => __("Yes","ultimate_vc"),
													"off" => __("No","ultimate_vc"),
												),
										"quick" => array(
													"label" => __("Quick View","ultimate_vc"),
													"on" => __("Yes","ultimate_vc"),
													"off" => __("No","ultimate_vc"),
												),
										"description" => array(
													"label" => __("Description","ultimate_vc"),
													"on" => __("Yes","ultimate_vc"),
													"off" => __("No","ultimate_vc"),
												),
									),
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Product Text Alignment", "ultimate_vc"),
								"param_name" => "text_align",
								"value" => array(
									__("Left","ultimate_vc")=> "left",
									__("Center","ultimate_vc")=> "center",
									__("Right","ultimate_vc") => "right",
								),
								//"description" => __("","smile"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Sale Notification Label", "ultimate_vc"),
								"param_name" => "label_on_sale",
								"value" => "",
								"description" => __("Enter custom text for Product On Sale label. Default is - Sale!.", "ultimate_vc"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Sale Notification Style", "ultimate_vc"),
								"param_name" => "on_sale_style",
								"admin_label" => true,
								"value" => array(
										__("Circle","ultimate_vc") => "wcmp-sale-circle",
										__("Rectangle","ultimate_vc") => "wcmp-sale-rectangle",
									),
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Sale Notification Alignment", "ultimate_vc"),
								"param_name" => "on_sale_alignment",
								"admin_label" => true,
								"value" => array(
										__("Right","ultimate_vc") => "wcmp-sale-right",
										__("Left","ultimate_vc") => "wcmp-sale-left",
									),
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Product Image Setting", "ultimate_vc"),
								"param_name" => "product_img_disp",
								"value" => array(
									__("Display product featured image","ultimate_vc") => "single",
									__("Display product gallery in carousel slider","ultimate_vc") => "carousel",
								),
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Image Hover Animation", "ultimate_vc"),
								"param_name" => "img_animate",
								"value" => array(
									__("Rotate Clock","ultimate_vc")=> "rotate-clock",
									__("Rotate Anti-clock","ultimate_vc")=> "rotate-anticlock",
									__("Zoom-In","ultimate_vc") => "zoomin",
									__("Zoom-Out","ultimate_vc") => "zoomout",
									__("Fade","ultimate_vc") => "fade",
									__("Gray Scale","ultimate_vc") => "grayscale",
									__("Shadow","ultimate_vc") => "imgshadow",
									__("Blur","ultimate_vc") => "blur",
									__("Anti Grayscale","ultimate_vc") => "antigrayscale",
								),
								//"description" => __("","smile"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Product Border Style", "ultimate_vc"),
								"param_name" => "border_style",
								"value" => array(
									__("None","ultimate_vc")=> "",
									__("Solid","ultimate_vc")=> "solid",
									__("Dashed","ultimate_vc") => "dashed",
									__("Dotted","ultimate_vc") => "dotted",
									__("Double","ultimate_vc") => "double",
									__("Inset","ultimate_vc") => "inset",
									__("Outset","ultimate_vc") => "outset",
								),
								//"description" => __("","smile"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Border Color", "ultimate_vc"),
								"param_name" => "border_color",
								"value" => "#333333",
								//"description" => __("", "woocomposer"),	
								"dependency" => Array("element" => "border_style", "not_empty" => true),
								"group" => "Initial Settings",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Border Width", "ultimate_vc"),
								"param_name" => "border_size",
								"value" => 1,
								"min" => 1,
								"max" => 10,
								"suffix" => "px",
								//"description" => __("", "woocomposer"),
								"dependency" => Array("element" => "border_style", "not_empty" => true),
								"group" => "Initial Settings",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Border Radius", "ultimate_vc"),
								"param_name" => "border_radius",
								"value" => 5,
								"min" => 1,
								"max" => 500,
								"suffix" => "px",
								//"description" => __("", "woocomposer"),
								"dependency" => Array("element" => "border_style", "not_empty" => true),
								"group" => "Initial Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Product Title Color", "ultimate_vc"),
								"param_name" => "color_heading",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Categories Color", "ultimate_vc"),
								"param_name" => "color_categories",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Price Color", "ultimate_vc"),
								"param_name" => "color_price",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Star Ratings Color", "ultimate_vc"),
								"param_name" => "color_rating",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Star Rating Background Color", "ultimate_vc"),
								"param_name" => "color_rating_bg",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Quick View Icon Color", "ultimate_vc"),
								"param_name" => "color_quick",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Quick View Background Color", "ultimate_vc"),
								"param_name" => "color_quick_bg",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Cart Icon Color", "ultimate_vc"),
								"param_name" => "color_cart",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Cart Button Background Color", "ultimate_vc"),
								"param_name" => "color_cart_bg",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Sale Notification Text Color", "ultimate_vc"),
								"param_name" => "color_on_sale",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Sale Notification Background Color", "ultimate_vc"),
								"param_name" => "color_on_sale_bg",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Product Description Text Color", "ultimate_vc"),
								"param_name" => "color_product_desc",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Product Description Background Color", "ultimate_vc"),
								"param_name" => "color_product_desc_bg",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Product Title", "ultimate_vc"),
								"param_name" => "size_title",
								"value" => "",
								"min" => 10,
								"max" => 72,
								"suffix" => "px",
								//"description" => __("", "woocomposer"),
								"group" => "Font Sizes",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Categories", "ultimate_vc"),
								"param_name" => "size_cat",
								"value" => "",
								"min" => 10,
								"max" => 72,
								"suffix" => "px",
								//"description" => __("", "woocomposer"),
								"group" => "Font Sizes",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Price", "ultimate_vc"),
								"param_name" => "size_price",
								"value" => "",
								"min" => 10,
								"max" => 72,
								"suffix" => "px",
								//"description" => __("", "woocomposer"),
								"group" => "Font Sizes",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Sale Notification", "ultimate_vc"),
								"param_name" => "sale_price",
								"value" => "",
								"min" => 10,
								"max" => 72,
								"suffix" => "px",
								//"description" => __("", "woocomposer"),
								"group" => "Font Sizes",
							),
						)
					);
				vc_map($params);
			}
		} 
		function WooComposer_Product($atts){
			$product_style = '';
			extract(shortcode_atts(array(
				"product_style" => "style01",
			),$atts));
			
			$output = '';
			
			ob_start();
			$output .= '<div class="woocommerce woo-msg">';
			if(function_exists('wc_print_notices'))
				wc_print_notices();
			$output .= ob_get_clean();
			$output .= '</div>';
			
			$template = 'design-single-'.$product_style.'.php';
			require_once($template);
			$function = 'WooComposer_Single_'.$product_style;
			$output .= $function($atts);
			
			return $output;
						
		} 
	}
	new WooComposer_ViewProduct;
}