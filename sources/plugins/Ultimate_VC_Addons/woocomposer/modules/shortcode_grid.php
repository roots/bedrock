<?php
/*
@Module: Grid Layout view
@Since: 1.0
@Package: WooComposer
*/
if(!class_exists('WooComposer_GridView')){
	class WooComposer_GridView
	{
		function __construct(){
			add_action('admin_init',array($this,'woocomposer_init_grid'));
			add_shortcode('woocomposer_grid',array($this,'woocomposer_grid_shortcode'));
		} /* end constructor */
		function woocomposer_init_grid(){
			if(function_exists('vc_map')){
				vc_map(
					array(
						"name"		=> __("Products Grid", "woocomposer"),
						"base"		=> "woocomposer_grid",
						"icon"		=> "woo_grid",
						"class"	   => "woo_grid",
						"category"  => __("WooComposer [ Beta ]", "woocomposer"),
						"description" => "Display products in grid view",
						"controls" => "full",
						"wrapper_class" => "clearfix",
						"show_settings_on_create" => true,
						"deprecated" => "3.13.5",
						"params" => array(
							array(
								"type" => "woocomposer",
								"class" => "",
								"heading" => __("Query Builder", "woocomposer"),
								"param_name" => "shortcode",
								"value" => "",
								"module" => "grid",
								"labels" => array(
										"products_from"   => __("Display:","woocomposer"),
										"per_page"		=> __("How Many:","woocomposer"),
										"columns"		 => __("Columns:","woocomposer"),
										"order_by"		=> __("Order By:","woocomposer"),
										"order"		   => __("Display Order:","woocomposer"),
										"category" 		=> __("Category:","woocomposer"),
								),
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Product Style", "woocomposer"),
								"param_name" => "product_style",
								"admin_label" => true,
								"value" => array(
										"Style 1" => "style01",
										"Style 2" => "style02",
										"Style 3" => "style03",
										/* "Style 4" => "style04", */
									),
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "ult_switch",
								"class" => "",
								"heading" => "",
								"param_name" => "pagination",
								"value" => "",
								"options" => array(
									"enable" => array(
											"label" => "Enable Pagination",
											"on" => "Yes",
											"off" => "No",
										),
									),
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "ult_switch",
								"class" => "",
								"heading" => "",
								"param_name" => "lazy_images",
								"admin_label" => true,
								"value" => "",
								"options" => array(
									"enable" => array(
											"label" => "Enable Lazy Load",
											"on" => "Yes",
											"off" => "No",
										),
									),
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "ult_switch",
								"class" => "",
								"heading" => __("Select Product Elements to display", "woocomposer"),
								"param_name" => "display_elements",
								"value" => "",
								"options" => array(
										"category" => array(
													"label" => "Category",
													"on" => "Yes",
													"off" => "No",
												),
										"reviews" => array(
													"label" => "Reviews",
													"on" => "Yes",
													"off" => "No",
												),
										"quick" => array(
													"label" => "Quick View",
													"on" => "Yes",
													"off" => "No",
												),
										"description" => array(
													"label" => "Description",
													"on" => "Yes",
													"off" => "No",
												),
									),
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Select quick view type", "woocomposer"),
								"param_name" => "quick_view_style",
								"admin_label" => true,
								"value" => array(
										"Expanding Preview " => "expandable",
										"Display in Lightbox" => "popup",
									),
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Product Text Alignment", "woocomposer"),
								"param_name" => "text_align",
								"value" => array(
									"Left"=> "left",
									"Center"=> "center",
									"Right" => "right",
								),
								//"description" => __("","smile"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Sale Notification Label", "woocomposer"),
								"param_name" => "label_on_sale",
								"value" => "",
								"description" => __("Enter custom text for Product On Sale label. Default is - Sale!.", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Sale Notification Style", "woocomposer"),
								"param_name" => "on_sale_style",
								"admin_label" => true,
								"value" => array(
										"Circle" => "wcmp-sale-circle",
										"Square" => "wcmp-sale-rectangle",
									),
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Sale Notification Alignment", "woocomposer"),
								"param_name" => "on_sale_alignment",
								"admin_label" => true,
								"value" => array(
										"Right" => "wcmp-sale-right",
										"Left" => "wcmp-sale-left",
									),
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Product Image Setting", "woocomposer"),
								"param_name" => "product_img_disp",
								"value" => array(
									"Display product featured image" => "single",
									"Display product gallery in carousel slider" => "carousel",
								),
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Image Hover Style", "woocomposer"),
								"param_name" => "img_animate",
								"value" => array(
									"Rotate Clock"=> "rotate-clock",
									"Rotate Anti-clock"=> "rotate-anticlock",
									"Zoom-In" => "zoomin",
									"Zoom-Out" => "zoomout",
									"Fade" => "fade",
									"Gray Scale" => "grayscale",
									"Shadow" => "imgshadow",
									"Blur" => "blur",
									"Anti Grayscale" => "antigrayscale",
								),
								//"description" => __("","smile"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Product Border Style", "woocomposer"),
								"param_name" => "border_style",
								"value" => array(
									"None"=> "",
									"Solid"=> "solid",
									"Dashed" => "dashed",
									"Dotted" => "dotted",
									"Double" => "double",
									"Inset" => "inset",
									"Outset" => "outset",
								),
								//"description" => __("","smile"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Border Color", "woocomposer"),
								"param_name" => "border_color",
								"value" => "#333333",
								//"description" => __("", "woocomposer"),	
								"dependency" => Array("element" => "border_style", "not_empty" => true),
								"group" => "Initial Settings",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Border Size", "woocomposer"),
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
								"heading" => __("Border Radius", "woocomposer"),
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
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Product Animation","smile"),
								"param_name" => "product_animation",
								"value" => array(
							 		__("No Animation","smile") => "",
									__("Swing","smile") => "swing",
									__("Pulse","smile") => "pulse",
									__("Fade In","smile") => "fadeIn",
									__("Fade In Up","smile") => "fadeInUp",
									__("Fade In Down","smile") => "fadeInDown",
									__("Fade In Left","smile") => "fadeInLeft",
									__("Fade In Right","smile") => "fadeInRight",
									__("Fade In Up Long","smile") => "fadeInUpBig",
									__("Fade In Down Long","smile") => "fadeInDownBig",
									__("Fade In Left Long","smile") => "fadeInLeftBig",
									__("Fade In Right Long","smile") => "fadeInRightBig",
									__("Slide In Down","smile") => "slideInDown",
									__("Slide In Left","smile") => "slideInLeft",
									__("Slide In Left","smile") => "slideInLeft",
									__("Bounce In","smile") => "bounceIn",
									__("Bounce In Up","smile") => "bounceInUp",
									__("Bounce In Down","smile") => "bounceInDown",
									__("Bounce In Left","smile") => "bounceInLeft",
									__("Bounce In Right","smile") => "bounceInRight",
									__("Rotate In","smile") => "rotateIn",
									__("Light Speed In","smile") => "lightSpeedIn",
									__("Roll In","smile") => "rollIn",
									),
								//"description" => __("","smile"),
								"group" => "Initial Settings",
						  	),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Product Title Color", "woocomposer"),
								"param_name" => "color_heading",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Categories Color", "woocomposer"),
								"param_name" => "color_categories",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Price Color", "woocomposer"),
								"param_name" => "color_price",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Star Ratings Color", "woocomposer"),
								"param_name" => "color_rating",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Star Ratings Background Color", "woocomposer"),
								"param_name" => "color_rating_bg",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Quick View Icon Color", "woocomposer"),
								"param_name" => "color_quick",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Quick View Icon Background Color", "woocomposer"),
								"param_name" => "color_quick_bg",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Cart Icon Color", "woocomposer"),
								"param_name" => "color_cart",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Cart Icon Background Color", "woocomposer"),
								"param_name" => "color_cart_bg",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Sale Notification Label Color", "woocomposer"),
								"param_name" => "color_on_sale",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Sale Notification Background Color", "woocomposer"),
								"param_name" => "color_on_sale_bg",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Product Description Text Color", "woocomposer"),
								"param_name" => "color_product_desc",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Product Description Background Color", "woocomposer"),
								"param_name" => "color_product_desc_bg",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Product Title", "woocomposer"),
								"param_name" => "size_title",
								"value" => "",
								"min" => 10,
								"max" => 72,
								"suffix" => "px",
								//"description" => __("", "woocomposer"),
								"group" => "Size Settings",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Categories", "woocomposer"),
								"param_name" => "size_cat",
								"value" => "",
								"min" => 10,
								"max" => 72,
								"suffix" => "px",
								//"description" => __("", "woocomposer"),
								"group" => "Size Settings",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Price", "woocomposer"),
								"param_name" => "size_price",
								"value" => "",
								"min" => 10,
								"max" => 72,
								"suffix" => "px",
								//"description" => __("", "woocomposer"),
								"group" => "Size Settings",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Sale Notification", "woocomposer"),
								"param_name" => "sale_price",
								"value" => "",
								"min" => 10,
								"max" => 72,
								"suffix" => "px",
								//"description" => __("", "woocomposer"),
								"group" => "Size Settings",
							),
						)/* vc_map params array */
					)/* vc_map parent array */ 
				); /* vc_map call */ 
			} /* vc_map function check */
		} /* end woocomposer_init_grid */
		function woocomposer_grid_shortcode($atts){
			$product_style = '';
			extract(shortcode_atts(array(
				"product_style" => "style01",
			),$atts));
			$output = '';
			ob_start();
			$output .= '<div class="woocommerce">';
			if(function_exists('wc_print_notices'))
				wc_print_notices();
			$output .= ob_get_clean();
			$output .= '</div>';
			$uid = uniqid();
			$output = '<div id="woo-grid-'.$uid.'" class="woocomposer_grid">';
			
			$template = 'design-loop-'.$product_style.'.php';
			require_once($template);
			$function = 'WooComposer_Loop_'.$product_style;
			$output .= $function($atts,'grid');
			$output .= "\n".'</div>';
			return $output;
		}/* end woocomposer_grid_shortcode */
	} /* end class GridView */
	new WooComposer_GridView;
}