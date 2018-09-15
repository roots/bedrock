<?php
/*
@Module: List view
@Since: 1.0
@Package: WooComposer
*/
if(!class_exists('WooComposer_ViewCarousel')){
	class WooComposer_ViewCarousel
	{
		function __construct(){
			add_action('admin_init',array($this,'WooComposer_Init_Carousel'));
			add_shortcode('woocomposer_carousel',array($this,'WooComposer_Carousel'));
		} // end constructor
		function WooComposer_Init_Carousel(){
			if(function_exists('vc_map')){
				$categories = get_terms( 'product_cat', array(
					'orderby'    => 'count',
					'hide_empty' => 0,
				 ) );
				$cat_arr = array();
				if(is_array($categories)){
					foreach($categories as $cats){
						$cat_arr[$cats->name] = $cats->slug;
					}
				}
				vc_map(
					array(
						"name"		=> __("Products Carousel", "ultimate_vc"),
						"base"		=> "woocomposer_carousel",
						"icon"		=> "woo_carousel",
						"class"	   => "woo_carousel",
						"category"  => __("WooComposer [ Beta ]", "ultimate_vc"),
						"description" => __("Display products in carousel slider","ultimate_vc"),
						"controls" => "full",
						"show_settings_on_create" => true,
						"deprecated" => "3.13.5",
						"params" => array(
							array(
								"type" => "woocomposer",
								"class" => "",
								"heading" => __("Query Builder", "ultimate_vc"),
								"param_name" => "shortcode",
								"value" => "",
								"module" => "grid",
								"labels" => array(
										"products_from"   => __("Display:","ultimate_vc"),
										"per_page"		=> __("How Many:","ultimate_vc"),
										"columns"		 => __("Columns:","ultimate_vc"),
										"order_by"		=> __("Order By:","ultimate_vc"),
										"order"		   => __("Display Order:","ultimate_vc"),
										"category" 		=> __("Category:","ultimate_vc"),
								),
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Display Style", "ultimate_vc"),
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
								"heading" => __("Select options to display", "ultimate_vc"),
								"param_name" => "display_elements",
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
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Sale Notification Label", "ultimate_vc"),
								"param_name" => "label_on_sale",
								"value" => "",
								//"description" => __("", "woocomposer"),
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
										__("Square","ultimate_vc") => "wcmp-sale-rectangle",
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
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Animation","ultimate_vc"),
								"param_name" => "product_animation",
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
								//"description" => __("", "woocomposer"),
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
								"heading" => __("Quick View Icon Background Color", "ultimate_vc"),
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
								"heading" => __("Cart Icon Background Color", "ultimate_vc"),
								"param_name" => "color_cart_bg",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Sale Notification Label Color", "ultimate_vc"),
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
								"group" => "Size Settings",
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
								"group" => "Size Settings",
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
								"group" => "Size Settings",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Sale Notifications", "ultimate_vc"),
								"param_name" => "sale_price",
								"value" => "",
								"min" => 10,
								"max" => 72,
								"suffix" => "px",
								//"description" => __("", "woocomposer"),
								"group" => "Size Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Slide to Scroll Setting ", "ultimate_vc"),
								"param_name" => "scroll_opts",
								"value" => array(
										__("Auto","ultimate_vc") => "auto",
										__("Custom","ultimate_vc") => "custom",
									),
								//"description" => __("", "woocomposer"),
								"group" => "Carousel Settings",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Number of Slides to Scroll", "ultimate_vc"),
								"param_name" => "slides_to_scroll",
								"value" => "1",
								"min" => 1,
								"max" => 10,
								"suffix" => "",
								"description" => __("The number of slides to move on transition", "ultimate_vc"),
								"dependency" => Array("element" => "scroll_opts", "value" => array("custom")),
								"group" => "Carousel Settings",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Slide Scrolling Speed", "ultimate_vc"),
								"param_name" => "scroll_speed",
								"value" => "1000",
								"min" => 100,
								"max" => 10000,
								"suffix" => "ms",
								"description" => __("Slide transition duration (in ms)", "ultimate_vc"),
								"group" => "Carousel Settings",
							),
							array(
								"type" => "checkbox",
								"class" => "",
								"heading" => __("Advanced settings -", "ultimate_vc"),
								"param_name" => "advanced_opts",
								"value" => array(
										__("Enable infinite scroll","ultimate_vc")."<br>" => "infinite",
										__("Enable navigation dots","ultimate_vc")."<br>" => "dots",
										__("Enable auto play","ultimate_vc") => "autoplay",
									),
								//"description" => __("", "woocomposer"),
								"group" => "Carousel Settings",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Autoplay Speed", "ultimate_vc"),
								"param_name" => "autoplay_speed",
								"value" => "500",
								"min" => 100,
								"max" => 10000,
								"suffix" => "ms",
								"description" => __("The amount of time (in ms) between each auto transition", "ultimate_vc"),
								"group" => "Carousel Settings",
								"dependency" => Array("element" => "advanced_opts", "value" => array("autoplay")),
							),
						)
					)
				);
			}
		} // end WooComposer_Init_Carousel
		function WooComposer_Carousel($atts){
			$product_style = $slides_to_scroll = $scroll_speed = $advanced_opts = $output = $autoplay_speed = $scroll_opts = '';
			extract(shortcode_atts(array(
				"product_style" => "style01",
				"slides_to_scroll" => "1",
				"scroll_speed" => "1000",
				"advanced_opts" => "infinite",
				"autoplay_speed" => "500",
				"scroll_opts" => "auto",
			),$atts));
			
			$infinite = $autoplay = $dots = 'false';
			$advanced_opts = explode(",", $advanced_opts);
			if(in_array("infinite",$advanced_opts)){
				$infinite = 'true';
			}
			if(in_array("autoplay",$advanced_opts)){
				$autoplay = 'true';
			}
			if(in_array("dots",$advanced_opts)){
				$dots = 'true';
			}
			ob_start();
			$output .= '<div class="woocommerce">';
			if(function_exists('wc_print_notices'))
				wc_print_notices();
			$output .= ob_get_clean();
			$output .= '</div>';
			$uid = uniqid();
			
			$output .= '<div id="woo-carousel-'.$uid.'" class="woocomposer_carousel">';
			$template = 'design-loop-'.$product_style.'.php';
			require_once($template);
			$function = 'WooComposer_Loop_'.$product_style;
			$output .= $function($atts,'carousel');
			$output .= '</div>';
			$output .= '<script>
						jQuery(document).ready(function(){
							var columns = jQuery("#woo-carousel-'.$uid.' > .woocomposer").data("columns");
							var slides_scroll_opt = "'.$scroll_opts.'";
							var slides_to_scroll;
							if(slides_scroll_opt == "custom"){
								slides_to_scroll = '.$slides_to_scroll.';
							} else {
								slides_to_scroll = columns;
							}
							var inline_vc = jQuery(".woocomposer_carousel").find(".wcmp_vc_inline").length;
							
							if(inline_vc == 0){
								jQuery("#woo-carousel-'.$uid.' > .woocomposer").slick({
											infinite: '.$infinite.',
											slidesToShow: columns,
											slidesToScroll: slides_to_scroll,
											speed: '.$scroll_speed.',
											dots: '.$dots.',
											autoplay: '.$autoplay.',
											autoplaySpeed: '.$autoplay_speed.',
											responsive: [{
												breakpoint: 1024,
												settings: {
													slidesToShow: 3,
													slidesToScroll: 3,
													infinite: true,
													dots: true
												}
											}, {
												breakpoint: 600,
												settings: {
													slidesToShow: 2,
													slidesToScroll: 2
												}
											}, {
												breakpoint: 480,
												settings: {
													slidesToShow: 1,
													slidesToScroll: 1
												}
											}]
									});
							}
							
							var carousel_set = "{infinite: '.$infinite.',\
								slidesToShow: columns,\
								slidesToScroll: slides_to_scroll,\
								speed: '.$scroll_speed.',\
								dots: '.$dots.',\
								autoplay: '.$autoplay.',\
								autoplaySpeed: '.$autoplay_speed.',\
								responsive: [{\
									breakpoint: 1024,\
									settings: {\
										slidesToShow: 3,\
										slidesToScroll: 3,\
										infinite: true,\
										dots: true\
									}\
								}, {\
									breakpoint: 600,\
									settings: {\
										slidesToShow: 2,\
										slidesToScroll: 2\
									}\
								}, {\
									breakpoint: 480,\
									settings: {\
										slidesToShow: 1,\
										slidesToScroll: 1\
									}\
								}]\
							});}";
							jQuery("#woo-carousel-'.$uid.'").attr("data-slick", carousel_set);
						});
						jQuery(window).load(function(){
							//jQuery("[data-save=true]").trigger("click");
						});
				</script>';
			return $output;
						
		} // end WooComposer_Carousel
	}
	new WooComposer_ViewCarousel;
}