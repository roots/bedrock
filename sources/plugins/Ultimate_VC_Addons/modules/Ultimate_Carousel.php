<?php
/*
Module Name: Ultimate Carousel for Visual Composer
Module URI: https://www.brainstormforce.com/demos/ultimate-carousel
*/
if(!class_exists("Ultimate_Carousel")){
	class Ultimate_Carousel{

		function __construct(){
			add_action("init", array($this, "init_carousel_addon"));
			add_shortcode("ultimate_carousel", array($this, "ultimate_carousel_shortcode"));
			add_action( "wp_enqueue_scripts", array( $this, "ultimate_front_scripts"),1 );
			add_action( "admin_enqueue_scripts", array( $this, "custom_param_styles") );
			add_action( "admin_enqueue_scripts", array( $this, "ultimate_admin_scripts"),100 );
		}
		function custom_param_styles(){
			echo '<style type="text/css">
					.items_to_show.vc_shortcode-param {
						background: #E6E6E6;
						padding-bottom: 10px;
					}
					.items_to_show.ult_margin_bottom{
						margin-bottom: 15px;
					}
					.items_to_show.ult_margin_top{
						margin-top: 15px;
					}
				</style>';
		}

		function ultimate_front_scripts(){
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
			wp_register_script("ult-slick",plugins_url($js_path."slick".$ext.".js",__FILE__),array('jquery'),ULTIMATE_VERSION,false);
			wp_register_script("ult-slick-custom",plugins_url($js_path."slick-custom".$ext.".js",__FILE__),array('jquery','ult-slick'),ULTIMATE_VERSION,false);

			wp_register_style("ult-slick",plugins_url($css_path."slick".$ext.".css",__FILE__),array(),ULTIMATE_VERSION);
			wp_register_style("ult-icons",plugins_url("../assets/css/icons.css",__FILE__),array(),ULTIMATE_VERSION);
		}

		function ultimate_admin_scripts($hook){
			if($hook == "post.php" || $hook == "post-new.php"){
				wp_enqueue_style("ult-icons", plugins_url("../assets/css/icons.css",__FILE__));
			}
		}

		function init_carousel_addon(){
			if(function_exists("vc_map")){
				vc_map(
					array(
						"name" => __("Advanced Carousel", "ultimate_vc"),
						"base" => "ultimate_carousel",
						"icon" => "ultimate_carousel",
						"class" => "ultimate_carousel",
						"as_parent" => array('except' => 'ultimate_carousel'),
						"content_element" => true,
						"controls" => "full",
						"show_settings_on_create" => true,
						//"is_container"    => true,
						"category" => "Ultimate VC Addons",
						//"front_enqueue_css" =>  preg_replace( '/\s/', '%20', plugins_url( '../assets/css/advacne_carosal_front.css', __FILE__ ) ),
						"description" => __("Carousel anything.","ultimate_vc"),
						"params" => array(
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Slider Type","ultimate_vc"),
								"param_name" => "slider_type",
								"value" => array(
										"Horizontal" => "horizontal",
										"Vertical" => "vertical",
										"Horizontal Full Width" => "full_width"
									),
								//"description" => __("","smile"),
								"group"=> "General",
						  	),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Slides to Scroll","ultimate_vc"),
								"param_name" => "slide_to_scroll",
								"value" => array("All visible" => "all", "One at a Time" => "single"),
								//"description" => __("","smile"),
								"group"=> "General",
						  	),
							array(
								"type" => "text",
								"param_name" => "title_text_typography",
								"heading" => "<p>".__("Items to Show‏ -","ultimate_vc")."</p>",
								"value" => "",
								"edit_field_class" => "vc_col-sm-12 items_to_show ult_margin_top",
								"group" => "General"
							),
							array(
								"type" => "number",
								"class" => "",
								"edit_field_class" => "vc_col-sm-4 items_to_show ult_margin_bottom",
								"heading" => __("On Desktop","ultimate_vc"),
								"param_name" => "slides_on_desk",
								"value" => "5",
								"min" => "1",
								"max" => "25",
								"step" => "1",
								//"description" => __("","smile"),
								"group"=> "General",
						  	),
							array(
								"type" => "number",
								"class" => "",
								"edit_field_class" => "vc_col-sm-4 items_to_show ult_margin_bottom",
								"heading" => __("On Tabs","ultimate_vc"),
								"param_name" => "slides_on_tabs",
								"value" => "3",
								"min" => "1",
								"max" => "25",
								"step" => "1",
								//"description" => __("","smile"),
								"group"=> "General",
						  	),
							array(
								"type" => "number",
								"class" => "",
								"edit_field_class" => "vc_col-sm-4 items_to_show ult_margin_bottom",
								"heading" => __("On Mobile","ultimate_vc"),
								"param_name" => "slides_on_mob",
								"value" => "2",
								"min" => "1",
								"max" => "25",
								"step" => "1",
								//"description" => __("","smile"),
								"group"=> "General",
						  	),
							/*
							array(
								"type" => "checkbox",
								"class" => "",
								"heading" => __("Infinite loop","smile"),
								"param_name" => "infinite_loop",
								"value" => array("Enable infinite loop" => "true"),
								"description" => __("","smile"),
								"group"=> "General",
						  	),
							*/
							array(
								"type" => "ult_switch",
								"class" => "",
								"heading" => __("Infinite loop", "ultimate_vc"),
								"param_name" => "infinite_loop",
								// "admin_label" => true,
								"value" => "on",
								"options" => array(
										"on" => array(
												"label" => __("Restart the slider automatically as it passes the last slide.","ultimate_vc"),
												"on" => "Yes",
												"off" => "No",
											),
									),
								//"description" => __("", "smile"),
								"dependency"  => "",
								"default_set" => true,
								"group"=> "General",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Transition speed","ultimate_vc"),
								"param_name" => "speed",
								"value" => "300",
								"min" => "100",
								"max" => "10000",
								"step" => "100",
								"suffix" => "ms",
								"description" => __("Speed at which next slide comes.","ultimate_vc"),
								"group"=> "General",
						  	),
							/*
							array(
								"type" => "checkbox",
								"class" => "",
								"heading" => __("Autoplay","smile"),
								"param_name" => "autoplay",
								"value" => array("Enable Autoplay" => "true"),
								"description" => __("","smile"),
								"group"=> "General",
						  	),
							*/
							array(
								"type" => "ult_switch",
								"class" => "",
								"heading" => __("Autoplay Slides‏", "ultimate_vc"),
								"param_name" => "autoplay",
								// "admin_label" => true,
								"value" => "on",
								"options" => array(
										"on" => array(
												"label" => __("Enable Autoplay","ultimate_vc"),
												"on" => "Yes",
												"off" => "No",
											),
									),
								//"description" => __("", "smile"),
								"dependency"  => "",
								"default_set" => true,
								"group"=> "General",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Autoplay Speed","ultimate_vc"),
								"param_name" => "autoplay_speed",
								"value" => "5000",
								"min" => "100",
								"max" => "10000",
								"step" => "10",
								"suffix" => "ms",
								//"description" => __("","smile"),
								"dependency" => Array("element" => "autoplay", "value" => array("on")),
								"group"=> "General",
						  	),
							/*
							array(
								"type" => "checkbox",
								"class" => "",
								"heading" => __("Lazyload","smile"),
								"param_name" => "lazyload",
								"value" => array("Enable Lazyload" => "true"),
								"description" => __("","smile"),
								"group"=> "General",
						  	),
							*/
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Extra Class","ultimate_vc"),
								"param_name" => "el_class",
								"value" => "",
								//"description" => __("","smile"),
								"group"=> "General",
						  	),
							/*
							array(
								"type" => "checkbox",
								"class" => "",
								"heading" => __("Arrows","smile"),
								"param_name" => "arrows",
								"value" => array("Disable / Hide Next/Prev arrows" => "hide"),
								"description" => __("","smile"),
								"group"=> "Navigation",
						  	),
							*/
							array(
								"type" => "ult_switch",
								"class" => "",
								"heading" => __("Navigation Arrows", "ultimate_vc"),
								"param_name" => "arrows",
								// "admin_label" => true,
								"value" => "show",
								"options" => array(
										"show" => array(
												"label" => __("Display next / previous navigation arrows","ultimate_vc"),
												"on" => "Yes",
												"off" => "No",
											),
									),
								//"description" => __("", "smile"),
								"dependency"  => "",
								"default_set" => true,
								"group"=> "Navigation",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Arrow Style","ultimate_vc"),
								"param_name" => "arrow_style",
								"value" => array(
									"Default" => "default",
									"Circle Background" => "circle-bg",
									"Square Background" => "square-bg",
									"Circle Border" => "circle-border",
									"Square Border" => "square-border",
								),
								//"description" => __("","smile"),
								"dependency" => Array("element" => "arrows", "value" => array("show")),
								"group"=> "Navigation",
						  	),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Background Color","ultimate_vc"),
								"param_name" => "arrow_bg_color",
								"value" => "",
								//"description" => __("","smile"),
								"dependency" => Array("element" => "arrow_style", "value" => array("circle-bg","square-bg")),
								"group"=> "Navigation",
						  	),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Border Color","ultimate_vc"),
								"param_name" => "arrow_border_color",
								"value" => "",
								//"description" => __("","smile"),
								"dependency" => Array("element" => "arrow_style", "value" => array("circle-border","square-border")),
								"group"=> "Navigation",
						  	),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Border Size","ultimate_vc"),
								"param_name" => "border_size",
								"value" => "2",
								"min" => "1",
								"max" => "100",
								"step" => "1",
								"suffix" => "px",
								//"description" => __("","smile"),
								"dependency" => Array("element" => "arrow_style", "value" => array("circle-border","square-border")),
								"group"=> "Navigation",
						  	),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Arrow Color","ultimate_vc"),
								"param_name" => "arrow_color",
								"value" => "#333333",
								//"description" => __("","smile"),
								"dependency" => Array("element" => "arrows", "value" => array("show")),
								"group"=> "Navigation",
						  	),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Arrow Size","ultimate_vc"),
								"param_name" => "arrow_size",
								"value" => "24",
								"min" => "10",
								"max" => "75",
								"step" => "1",
								"suffix" => "px",
								//"description" => __("","smile"),
								"dependency" => Array("element" => "arrows", "value" => array("show")),
								"group"=> "Navigation",
						  	),
							array(
								"type" => "ultimate_navigation",
								"class" => "",
								"heading" => __("Select icon for 'Next Arrow'", "ultimate_vc"),
								"param_name" => "next_icon",
								"value" => "ultsl-arrow-right4",
								//"description" => __("","smile"),
								"dependency" => Array("element" => "arrows", "value" => array("show")),
								"group"=> "Navigation",
							),
							array(
								"type" => "ultimate_navigation",
								"class" => "",
								"heading" => __("Select icon for 'Previous Arrow'", "ultimate_vc"),
								"param_name" => "prev_icon",
								"value" => "ultsl-arrow-left4",
								//"description" => __("","smile"),
								"dependency" => Array("element" => "arrows", "value" => array("show")),
								"group"=> "Navigation",
							),

							/*
							array(
								"type" => "checkbox",
								"class" => "",
								"heading" => __("Dots Navigation","smile"),
								"param_name" => "dots",
								"value" => array("Disable / Hide dot navigation" => "hide"),
								"description" => __("","smile"),
								"group"=> "Navigation",
						  	),
							*/
							array(
								"type" => "ult_switch",
								"class" => "",
								"heading" => __("Dots Navigation", "ultimate_vc"),
								"param_name" => "dots",
								// "admin_label" => true,
								"value" => "show",
								"options" => array(
										"show" => array(
												"label" => __("Display dot navigation","ultimate_vc"),
												"on" => "Yes",
												"off" => "No",
											),
									),
								//"description" => __("", "smile"),
								"dependency"  => "",
								"default_set" => true,
								"group"=> "Navigation",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Color of dots","ultimate_vc"),
								"param_name" => "dots_color",
								"value" => "#333333",
								//"description" => __("","smile"),
								"dependency" => Array("element" => "dots", "value" => array("show")),
								"group"=> "Navigation",
						  	),
							array(
								"type" => "ultimate_navigation",
								"class" => "",
								"heading" => __("Select icon for 'Navigation Dots'", "ultimate_vc"),
								"param_name" => "dots_icon",
								"value" => "ultsl-record",
								//"description" => __("","smile"),
								"dependency" => Array("element" => "dots", "value" => array("show")),
								"group"=> "Navigation",
							),
							/*
							array(
								"type" => "checkbox",
								"class" => "",
								"heading" => __("Fade Effect","smile"),
								"param_name" => "fade",
								"value" => array("Enable Fade Effect" => "true"),
								"description" => __("This will display only 1 slide at a time.","smile"),
								"dependency" => Array("element" => "slide_to_scroll", "value" => array("single")),
								"group"=> "Animation",
						  	),
							*/
							/*
							array(
								"type" => "ult_switch",
								"class" => "",
								"heading" => __("Fade Effect", "smile"),
								"param_name" => "fade",
								// "admin_label" => true,
								"value" => "",
								"options" => array(
										"on" => array(
												"label" => "Enable Fade Effect",
												"on" => "Yes",
												"off" => "No",
											),
									),
								"description" => __("", "smile"),
								"dependency" => Array("element" => "slide_to_scroll", "value" => array("single")),
								"group"=> "Animation",
							),
							*/
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Item Animation","ultimate_vc"),
								"param_name" => "item_animation",
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
								//"description" => __("", "smile"),
								"group"=> "Animation",
						  	),
							/*
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("CSS3 Ease Animation","smile"),
								"param_name" => "cssease",
								"value" => array(
											"No Easing" => "none",
											"Ease" => "ease",
											"Ease In" => "ease-in",
											"Ease Out" => "ease-out",
											"Ease In Out" => "ease-in-out",
											"Linear" => "linear",
										),
								"description" => __("","smile"),
								"group"=> "Animation",
						  	),
							*/
							/*
							array(
								"type" => "checkbox",
								"class" => "",
								"heading" => __("Draggable Effect","smile"),
								"param_name" => "draggable",
								"value" => array("Allow slides to be draggable" => "true"),
								"description" => __("","smile"),
								"group"=> "Advanced",
						  	),
							*/
							array(
								"type" => "ult_switch",
								"class" => "",
								"heading" => __("Draggable Effect", "ultimate_vc"),
								"param_name" => "draggable",
								// "admin_label" => true,
								"value" => "on",
								"options" => array(
										"on" => array(
												"label" => __("Allow slides to be draggable","ultimate_vc"),
												"on" => "Yes",
												"off" => "No",
											),
									),
								//"description" => __("", "smile"),
								"dependency"  => "",
								"default_set" => true,
								"group"=> "Advanced",
							),
							/*
							array(
								"type" => "checkbox",
								"class" => "",
								"heading" => __("Swipe Mode","smile"),
								"param_name" => "swipe",
								"value" => array("Enable touch swipe" => "true"),
								"description" => __("","smile"),
								"group"=> "Advanced",
						  	),
							*/
							/*
							array(
								"type" => "checkbox",
								"class" => "",
								"heading" => __("Touch Move","smile"),
								"param_name" => "touch_move",
								"value" => array("Enable slide moving with touch" => "true"),
								"description" => __("","smile"),
								"dependency" => Array("element" => "draggable", "value" => array("true")),
								"group"=> "Advanced",
						  	),
							*/
							array(
								"type" => "ult_switch",
								"class" => "",
								"heading" => __("Touch Move", "ultimate_vc"),
								"param_name" => "touch_move",
								// "admin_label" => true,
								"value" => "on",
								"options" => array(
										"on" => array(
												"label" => __("Enable slide moving with touch","ultimate_vc"),
												"on" => "Yes",
												"off" => "No",
											),
									),
								//"description" => __("", "smile"),
								"dependency" => Array("element" => "draggable", "value" => array("on")),
								"default_set" => true,
								"group"=> "Advanced",
							),
							array(
								"type" => "ult_switch",
								"class" => "",
								"heading" => __("RTL Mode", "ultimate_vc"),
								"param_name" => "rtl",
								// "admin_label" => true,
								"value" => "",
								"options" => array(
										"on" => array(
												"label" => __("Turn on RTL mode","ultimate_vc"),
												"on" => "Yes",
												"off" => "No",
											),
									),
								//"description" => __("", "smile"),
								"dependency"  => "",
								"group"=> "Advanced",
							),
							array(
								"type" => "ult_switch",
								"class" => "",
								"heading" => __("Adaptive Height", "ultimate_vc"),
								"param_name" => "adaptive_height",
								// "admin_label" => true,
								"value" => "",
								"options" => array(
										"on" => array(
												"label" => __("Turn on Adaptive Height","ultimate_vc"),
												"on" => "Yes",
												"off" => "No",
											),
									),
								//"description" => __("", "smile"),
								"dependency"  => "",
								"group"=> "Advanced",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Space between two items","ultimate_vc"),
								"param_name" => "item_space",
								"value" => "15",
								"min" => "0",
								"max" => "1000",
								"step" => "1",
								"suffix" => "px",
								//"description" => __("","smile"),
								"group"=> "Advanced",
						  	),
							array(
								"type" => "ult_param_heading",
								"text" => "<span style='display: block;'><a href='http://bsf.io/bzyci' target='_blank'>".__("Watch Video Tutorial","ultimate_vc")." &nbsp; <span class='dashicons dashicons-video-alt3' style='font-size:30px;vertical-align: middle;color: #e52d27;'></span></a></span>",
								"param_name" => "notification",
								'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
								"group" => "General"
							),
							array(
					            'type' => 'css_editor',
					            'heading' => __( 'Css', 'ultimate_vc' ),
					            'param_name' => 'css_ad_caraousel',
					            'group' => __( 'Design ', 'ultimate_vc' ),
					            'edit_field_class' => 'vc_col-sm-12 vc_column no-vc-background no-vc-border creative_link_css_editor',
					        ),
						),
						"js_view" => 'VcColumnView'
					)
				); // vc_map
			}
		}

		function ultimate_carousel_shortcode($atts, $content){

			$slider_type = $slides_on_desk = $slides_on_tabs = $slides_on_mob = $slide_to_scroll = $speed = $infinite_loop = $autoplay = $autoplay_speed = '';
			$lazyload = $arrows = $dots = $dots_icon = $next_icon = $prev_icon = $dots_color = $draggable = $swipe = $touch_move = '';
			$rtl = $arrow_color = $arrow_size = $arrow_style = $arrow_bg_color = $arrow_border_color = $border_size = $item_space = $el_class = '';
			$item_animation =  '';
			extract(shortcode_atts(array(
				"slider_type" => "horizontal",
				"slides_on_desk" => "5",
				"slides_on_tabs" => "3",
				"slides_on_mob" => "2",
				"slide_to_scroll" => "all",
				"speed" => "300",
				"infinite_loop" => "on",
				"autoplay" => "on",
				"autoplay_speed" => "5000",
				"lazyload" => "",
				"arrows" => "show",
				"dots" => "show",
				"dots_icon" => "ultsl-record",
				"next_icon" => "ultsl-arrow-right4",
				"prev_icon"=> "ultsl-arrow-left4",
				"dots_color" => "#333333",
				"arrow_color" => "#333333",
				"arrow_size" => "20",
				"arrow_style" => "default",
				"arrow_bg_color" => "",
				"arrow_border_color" => "",
				"border_size" => "1.5",
				"draggable" => "on",
				"swipe" => "true",
				"touch_move" => "on",
				"rtl" => "",
				"item_space" => "15",
				"el_class" => "",
				"item_animation" => "",
				"adaptive_height" => "",
				"css_ad_caraousel" => "",
			),$atts));


			$uid = uniqid(rand());

			$settings = $responsive = $infinite = $dot_display = $custom_dots = $arr_style = $wrap_data = $design_style = '';

			$desing_style = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css_ad_caraousel, ' ' ), "ultimate_carousel", $atts );
			$desing_style = esc_attr( $desing_style);
			if($slide_to_scroll == "all")
				$slide_to_scroll = $slides_on_desk;
			else
				$slide_to_scroll = 1;

			$arr_style .= 'color:'.$arrow_color.'; font-size:'.$arrow_size.'px;';
			if($arrow_style == "circle-bg" || $arrow_style == "square-bg"){
				$arr_style .= "background:".$arrow_bg_color.";";
			} elseif($arrow_style == "circle-border" || $arrow_style == "square-border"){
				$arr_style .= "border:".$border_size."px solid ".$arrow_border_color.";";
			}

			if($dots !== "off" && $dots !== "")
				$settings .= 'dots: true,';
			else
				$settings .= 'dots: false,';
			if($autoplay !== 'off' && $autoplay !== '')
				$settings .= 'autoplay: true,';
			if($autoplay_speed !== '')
				$settings .= 'autoplaySpeed: '.$autoplay_speed.',';
			if($speed !== '')
				$settings .= 'speed: '.$speed.',';
			if($infinite_loop !== 'off' && $infinite_loop !== '')
				$settings .= 'infinite: true,';
			else
				$settings .= 'infinite: false,';
			if($lazyload !== 'off' && $lazyload !== '')
				$settings .= 'lazyLoad: true,';
			if($arrows !== 'off' && $arrows !== ''){
				$settings .= 'arrows: true,';
				$settings .= 'nextArrow: \'<button type="button" style="'.$arr_style.'" class="slick-next '.$arrow_style.'"><i class="'.$next_icon.'"></i></button>\',';
				$settings .= 'prevArrow: \'<button type="button" style="'.$arr_style.'" class="slick-prev '.$arrow_style.'"><i class="'.$prev_icon.'"></i></button>\',';
			} else {
				$settings .= 'arrows: false,';
			}

			if($slide_to_scroll !== '')
				$settings .= 'slidesToScroll:'.$slide_to_scroll.',';
			if($slides_on_desk !== '')
				$settings .= 'slidesToShow:'.$slides_on_desk.',';
			if($slides_on_mob == '')
				$slides_on_mob = $slides_on_desk;
			if($slides_on_tabs == '')
				$slides_on_tabs = $slides_on_desk;
			if($draggable !== 'off' && $draggable !== ''){
				$settings .= 'swipe: true,';
				$settings .= 'draggable: true,';
			} else {
				$settings .= 'swipe: false,';
				$settings .= 'draggable: false,';
			}

			if($touch_move == "on")
				$settings .= 'touchMove: true,';
			else
				$settings .= 'touchMove: false,';

			if($rtl !== "off" && $rtl !== "") {
				$settings .= 'rtl: true,';
				$wrap_data = 'dir="rtl"';
			}

			if($slider_type == "vertical"){
				$settings .= 'vertical: true,';
			}

			$site_rtl = 'false';
			if(is_rtl())
				$site_rtl = 'true';
			if($site_rtl === 'false' || $site_rtl === false) {
				$ultimate_rtl_support = get_option('ultimate_rtl_support');
				if($ultimate_rtl_support == 'enable')
					$site_rtl = 'true';
			}

			if($adaptive_height === 'on')
				$settings .= 'adaptiveHeight: true,';

			$settings .= 'responsive: [
							{
							  breakpoint: 1025,
							  settings: {
								slidesToShow: '.$slides_on_desk.',
								slidesToScroll: '.$slide_to_scroll.', '.$infinite.' '.$dot_display.'
							  }
							},
							{
							  breakpoint: 769,
							  settings: {
								slidesToShow: '.$slides_on_tabs.',
								slidesToScroll: '.$slides_on_tabs.'
							  }
							},
							{
							  breakpoint: 481,
							  settings: {
								slidesToShow: '.$slides_on_mob.',
								slidesToScroll: '.$slides_on_mob.'
							  }
							}
						],';
			$settings .= 'pauseOnHover: true,
						pauseOnDotsHover: true,';
			if($dots_icon !== 'off' && $dots_icon !== ''){
				if($dots_color !== 'off' && $dots_color !== '')
					$custom_dots = 'style="color:'.$dots_color.';"';
				$settings .= 'customPaging: function(slider, i) {
                   return \'<i type="button" '.$custom_dots.' class="'.$dots_icon.'" data-role="none"></i>\';
                },';
			}

			if($item_animation == ''){
				$item_animation = 'no-animation';
			}
			ob_start();
			$uniqid = uniqid(rand());

			echo '<div id="ult-carousel-'.$uniqid.'" class="ult-carousel-wrapper '.$desing_style.' '.$el_class.' ult_'.$slider_type.'" data-gutter="'.$item_space.'" data-rtl="'.$site_rtl.'" >';
				echo '<div class="ult-carousel-'.$uid.' " '.$wrap_data.'>';
					ultimate_override_shortcodes($item_space, $item_animation);
					echo do_shortcode($content);
					ultimate_restore_shortcodes();
				echo '</div>';
			echo '</div>';
			?>
            <script type="text/javascript">
				jQuery(document).ready(function($){
               		$('.ult-carousel-<?php echo $uid; ?>').slick({<?php echo $settings; ?>});
				});
			</script>
            <?php
			return ob_get_clean();
		}
	}
	new Ultimate_Carousel;
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_ultimate_carousel extends WPBakeryShortCodesContainer {
		}
	}
}
if(!function_exists('ultimate_override_shortcodes')){
	function ultimate_override_shortcodes($item_space, $item_animation) {
	    global $shortcode_tags, $_shortcode_tags;
	    // Let's make a back-up of the shortcodes
	    $_shortcode_tags = $shortcode_tags;
	    // Add any shortcode tags that we shouldn't touch here
	    $disabled_tags = array( '' );
	    foreach ( $shortcode_tags as $tag => $cb ) {
	        if ( in_array( $tag, $disabled_tags ) ) {
	            continue;
	        }
	        // Overwrite the callback function
	        $shortcode_tags[ $tag ] = 'ultimate_wrap_shortcode_in_div';
			$_shortcode_tags["ult_item_space"] = $item_space;
			$_shortcode_tags["item_animation"] = $item_animation;
	    }
	}
}
// Wrap the output of a shortcode in a div with class "ult-item-wrap"
// The original callback is called from the $_shortcode_tags array
if(!function_exists('ultimate_wrap_shortcode_in_div')){
	function ultimate_wrap_shortcode_in_div( $attr, $content = null, $tag ) {
	    global $_shortcode_tags;
	    return '<div class="ult-item-wrap" data-animation="animated '.$_shortcode_tags["item_animation"].'">' . call_user_func( $_shortcode_tags[ $tag ], $attr, $content, $tag ) . '</div>';
	}
}
if(!function_exists('ultimate_restore_shortcodes')){
	function ultimate_restore_shortcodes() {
	    global $shortcode_tags, $_shortcode_tags;
	    // Restore the original callbacks
	    if ( isset( $_shortcode_tags ) ) {
	        $shortcode_tags = $_shortcode_tags;
	    }
	}
}