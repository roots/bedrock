<?php
  if(!class_exists('Ult_Content_Box')) {
	class Ult_Content_Box {
		function __construct() {
			add_shortcode("ult_content_box",array($this,"ult_content_box_callback"));
			add_action( 'init', array( $this, 'ult_content_box_init' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'ult_content_box_scripts' ), 1 );
		}
		function ult_content_box_callback($atts, $content = null){
		  extract( shortcode_atts( array(
		  			'bg_type' => 'bg_color',
		  			'bg_image' => '',
					'bg_color' => '',
					'bg_repeat' => 'repeat',
					'bg_size' => 'cover',
					'bg_position' => 'center center',
					'border' => '',
					'box_shadow' => '',
					'box_shadow_color' => '',
					'padding' => '',
					'margin' => '',
					'link' => '',
					'hover_bg_color' => '',
					'hover_border_color' => '',
					'hover_box_shadow' => '',
					'box_hover_shadow_color' => '',
					'min_height' => '',
					'el_class' => '',
					'trans_property' => 'all',
					'trans_duration' => '700',
					'trans_function' => 'ease',
					'responsive_margin' => '',
					/*'img_overlay_hover_effect'	=> '',*/
			  ), $atts ) );

		  	/* 	init var's 	*/
		  	$style = $url = $link_title = $target = $responsive_margins = $normal_margins = $hover = $shadow = $data_attr = '';

		  	if($bg_type!='') {
		  		switch ($bg_type) {
		  			case 'bg_color':	/* 	background color 	*/
										if($bg_color!='') {
											$style .= 'background-color:'.$bg_color.';';
											$data_attr .= ' data-bg="'.$bg_color.'" ';
										}
										if($hover_bg_color!='') {
											$hover .= ' data-hover_bg_color="'.$hover_bg_color.'" ';
										}
		  				break;
		  			case 'bg_image': 	if($bg_image != '') {
											$img = wp_get_attachment_image_src( $bg_image, 'large');
										 	$style .= "background-image:url('".$img[0]."');";
											$style .= 'background-size: '.$bg_size.';';
											$style .= 'background-repeat: '.$bg_repeat.';';
											$style .= 'background-position: '.$bg_position.';';
											$style .= 'background-color: rgba(0, 0, 0, 0);';
									  	}
					break;
		  		}
		  	}


		  	/* 	box shadow 	*/
			if($box_shadow!='' ) {
				$style .= apply_filters('Ultimate_GetBoxShadow', $box_shadow, 'css');
			}

		  	/* 	box shadow - {HOVER} 	*/
			if($hover_box_shadow!='' ) {

				$data = apply_filters('Ultimate_GetBoxShadow', $hover_box_shadow, 'data');

				if ( strpos($data,'none') !== false ) {
					$data = 'none';
				}
				//	Apply default box shadow
				if ( strpos($data,'inherit') !== false ) {
				    if($box_shadow!='') {
						$data = apply_filters('Ultimate_GetBoxShadow', $box_shadow, 'data');
					}
				}

				$hover .= ' data-hover_box_shadow="'.$data.'" ';
			}


			/* 	border 	*/
			if($border!=''){
				$border_array = explode('|', $border);
				$border_color = '';
				foreach ($border_array as $border_val) {
					$border_value_array = explode(':', $border_val);
					if(isset($border_value_array[0]) && $border_value_array[0] === 'border-color') {
						$border_color = (isset($border_value_array[1])) ? rtrim($border_value_array[1], ';') : '';
					}
				}
				$temp_border = str_replace( '|', '', $border );
				$style .= $temp_border;
				$data_attr .= ' data-border_color="'.$border_color.'" ';
			}

			/* 	link 	*/
			if($link!='') {
			  $href 		= 	vc_build_link($link);
			  $url 			= 	$href['url'];
			  $link_title	=	$href['title'];
			  $target		=	trim($href['target']);
			}


		  	/* 	padding  	*/
			if($padding!=''){ 	$style .= $padding; 	}

			/* 	margin 		*/
			if($margin!=''){ 	$style .= $margin; 		}

			// HOVER
			if($hover_border_color!='') {
				$hover .= ' data-hover_border_color="'.$hover_border_color.'" ';
			}
			if($min_height!='') { $style .= 'min-height:'.$min_height.'px;'; }

			// Transition Effect
			if($trans_property!='' && $trans_duration!='' && $trans_function!='') {
				$style .= '-webkit-transition: '.$trans_property.' '.$trans_duration.'ms '.$trans_function.';';
				$style .= '-moz-transition: '.$trans_property.' '.$trans_duration.'ms '.$trans_function.';';
				$style .= '-ms-transition: '.$trans_property.' '.$trans_duration.'ms '.$trans_function.';';
				$style .= '-o-transition: '.$trans_property.' '.$trans_duration.'ms '.$trans_function.';';
				$style .= 'transition: '.$trans_property.' '.$trans_duration.'ms '.$trans_function.';';
			}

			/* 	Margins - Responsive 	*/
			if($responsive_margin!='') {
				$responsive_margins .= ' data-responsive_margins="'.$responsive_margin.'" ';
			}
			/* 	Margins - Normal  */
			if($margin!='') {
				$normal_margins .= ' data-normal_margins="'.$margin.'" ';
			}

			$output  = '<div class="ult-content-box-container '.$el_class.'" >';
			if($link!='') {
				$output .= '	<a class="ult-content-box-anchor" href="'.$url.'" title="'.$link_title.'" target="'.$target.'" >';
			}
			$output .= '		<div class="ult-content-box" style="'.$style.'" '.$hover.' '.$responsive_margins.' '.$normal_margins.' '.$data_attr.'>';
			$output .=				do_shortcode( $content );
			$output .= '		</div>';
			if($link!='') {
				$output .= '	</a>';
			}
			$output .= '</div>';

		  return $output;
		}

		function ult_content_box_init() {
			  if(function_exists("vc_map")){
				  vc_map( array(
					  "name" => __("Content Box", "ultimate_vc"),
					  "base" => "ult_content_box",
					  "icon" => "vc_icon_content_box",
					  "class" => "vc_icon_content_box",
					  "as_parent" => array('except' => 'ult_content_box'),
					  //"as_parent" => '',
					  ///"content_element" => true,
					  "controls" => "full",
					  "show_settings_on_create" => true,
					  //"is_container"    => true,
					  "category" => "Ultimate VC Addons",
					  "description" => __("Content Box.","ultimate_vc"),
					  "js_view" => 'VcColumnView',
					  "params" => array(
					  		array(
					  			"type" => "dropdown",
					  			"heading" => __("Background Type","ultimate_vc"),
					  			"param_name" => "bg_type",
					  			"value" => array(
				  					__("Background Color","ultimate_vc") => "bg_color",
				  					__("Background Image","ultimate_vc") => "bg_image",
				  				),
					  		),
							/*array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Transition Property","ultimate_vc"),
								"param_name" => "trans_property",
								"value" => array(
									__("All", "ultimate_vc") => 'all',
									__("Background", "ultimate_vc") => 'background',
									__("Color", "ultimate_vc") => 'color',
									__("Height", "ultimate_vc") => 'height',
									__("Width", "ultimate_vc") => 'width',
									__("Outline", "ultimate_vc") => 'outline',
								),
								"group"=> "Effect",
						  	),*/
							array(
								"type" => "colorpicker",
								"heading" => __("Background Color","ultimate_vc"),
								"param_name" => "bg_color",
								"dependency" => Array("element" => "bg_type", "value" => "bg_color" ),
						  	),
						  	array(
						  		"type" => "attach_image",
						  		"heading" => __("Background Image", 'ultimate_vc'),
						  		"param_name" => "bg_image",
						  		"description" => __("Set background image for content box.", 'ultimate_vc'),
						  		"dependency" => Array("element" => "bg_type", "value" => "bg_image" ),
						  	),
					  		array(
					  			"type" => "ultimate_border",
					  			"heading" => __("Border","ultimate_vc"),
					  			"param_name" => "border",
					  			"unit"     => "px",                        						//  [required] px,em,%,all     Default all
					  			"positions" => array(
					  				__("Top","ultimate_vc")     => "",
					  				__("Right","ultimate_vc")   => "",
					  				__("Bottom","ultimate_vc")  => "",
					  				__("Left","ultimate_vc")    => ""
					  			),
					  			//"enable_radius" => false,                   					//  Enable border-radius. default true
					  			"radius" => array(
					  				__("Top Left","ultimate_vc")     => "",                	// use 'Top Left'
					  			  	__("Top Right","ultimate_vc")    => "",                	// use 'Top Right'
					  			  	__("Bottom Right","ultimate_vc") => "",                	// use 'Bottom Right'
					  			 	__("Bottom Left","ultimate_vc")  => ""                 	// use 'Bottom Left'
					  			),
					  			//"label_color"   => __("Border Color","ultimate_vc"),     	//  label for 'border color'   default 'Border Color'
					  			//"label_radius"  => __("Border Radius","ultimate_vc"), 	//  label for 'radius'  default 'Border Redius'
					  			//"label_border"  => "Border Style",       						//  label for 'style'   default 'Border Style'
					  		),
							array(
								"type" => "ultimate_boxshadow",
								"heading" => __("Box Shadow", "ultimate_vc"),
								"param_name" => "box_shadow",
								"unit" => "px",                        //  [required] px,em,%,all     Default all
								"positions" => array(
									__("Horizontal","ultimate_vc")     => "",
									__("Vertical","ultimate_vc")   => "",
									__("Blur","ultimate_vc")  => "",
									__("Spread","ultimate_vc")    => ""
								),
								//"enable_color" => false,
								//"label_style"	=> __("Style","ultimate_vc"),
								//"label_color"   => __("Shadow Color","ultimate_vc"),
							),
							/*array(
								"type" => "colorpicker",
								"edit_field_class" => "vc_col-sm-12 vc_column box_shadow_ultimate_box_shadow_color", 	// color dependency
								"heading" => __("Shadow Color","ultimate_vc"),
								"param_name" => "box_shadow_color",
						  	),*/

							//	Spacing
							array(
								"type" => "ult_param_heading",
								"param_name" => "content_spacing",
								"text" => __("Spacing","ultimate_vc"),
								"value" => "",
								'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
						  	),
						  	array(
								"type" => "ultimate_spacing",
								"heading" => __("Padding", "ultimate_vc"),
								"param_name" => "padding",
								"mode"  => "padding",                   	//  margin/padding
								"unit"  => "px",                       		//  [required] px,em,%,all     Default all
								"positions" => array(                  		//  Also set 'defaults'
								  __("Top","ultimate_vc")     => "",
								  __("Right","ultimate_vc")   => "",
								  __("Bottom","ultimate_vc")  => "",
								  __("Left","ultimate_vc")    => ""
								),
							),
							array(
								"type" => "ultimate_spacing",
								"heading" => __("Margin", "ultimate_vc"),
								"param_name" => "margin",
								"mode"  => "margin",                   	//  margin/padding
								"unit"  => "px",                       		//  [required] px,em,%,all     Default all
								"positions" => array(                  		//  Also set 'defaults'
								  __("Top","ultimate_vc")     => "",
								  __("Right","ultimate_vc")   => "",
								  __("Bottom","ultimate_vc")  => "",
								  __("Left","ultimate_vc")    => ""
								),
							),
							array(
								"type" => "vc_link",
								"heading" => __("Content Box Link","ultimate_vc"),
								"param_name" => "link",
								//"description" => __("", "ultimate_vc"),
								//"dependency" => array("element" => "img_link_type", "value" => "custom"),
						  	),
						  	array(
						   		"type" => "number",
								"heading" => __("Min Height", "ultimate_vc"),
								"param_name" => "min_height",
								"suffix"=>"px",
								"min"=>"0",
							),
						  	array(
								"type" => "textfield",
								"heading" => __("Extra class name", "ultimate_vc"),
								"param_name" => "el_class",
								"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "ultimate_vc")
						  	),

						  	//	Background
						  	array(
					  			"type" => "dropdown",
					  			"heading" => __("Background Image Repeat","ultimate_vc"),
					  			"param_name" => "bg_repeat",
					  			"value" => array(
									__("Repeat", "ultimate_vc") => 'repeat',
									__("Repeat X", "ultimate_vc") => 'repeat-x',
									__("Repeat Y", "ultimate_vc") => 'repeat-y',
									__("No Repeat", "ultimate_vc") => 'no-repeat',
				  				),
								"group" => "Background",
								"dependency" => Array("element" => "bg_type", "value" => "bg_image" ),
					  		),
						  	array(
					  			"type" => "dropdown",
					  			"heading" => __("Background Image Size","ultimate_vc"),
					  			"param_name" => "bg_size",
					  			"value" => array(
									__("Cover - Image to be as large as possible", "ultimate_vc") => 'cover',
									__("Contain - Image will try to fit inside the container area", "ultimate_vc") => 'contain',
									__("Initial", "ultimate_vc") => 'initial',
				  				),
				  				"group" => "Background",
								"dependency" => Array("element" => "bg_type", "value" => "bg_image" ),
					  		),
					  		array(
								"type" => "textfield",
								"heading" => __("Background Image Posiiton", "ultimate_vc"),
								"param_name" => "bg_position",
								"description" => __("You can use any number with px, em, %, etc. Example- 100px 100px.", "ultimate_vc"),
								"group" => "Background",
								"dependency" => Array("element" => "bg_type", "value" => "bg_image" ),
						  	),

						  	//	Hover
							array(
								"type" => "colorpicker",
								//"class" => "",
								"heading" => __("Background Color","ultimate_vc"),
								"param_name" => "hover_bg_color",
								"dependency" => Array("element" => "bg_type", "value" => "bg_color" ),
								"group" => "Hover",
							),
							array(
								"type" => "colorpicker",
								"heading" => __("Border Color","ultimate_vc"),
								"param_name" => "hover_border_color",
								"edit_field_class" => "vc_col-sm-12 vc_column border_ultimate_border", 	// Custom dependency
								"group" => "Hover",
							),
							array(
								"type" => "ultimate_boxshadow",
								"heading" => __("Box Shadow", "ultimate_vc"),
								"param_name" => "hover_box_shadow",
								"unit"     => "px",                        //  [required] px,em,%,all     Default all
								"positions" => array(
									__("Horizontal","ultimate_vc")     => "",
									__("Vertical","ultimate_vc")   => "",
									__("Blur","ultimate_vc")  => "",
									__("Spread","ultimate_vc")    => ""
								),
								"label_color"   => __("Shadow Color","ultimate_vc"),
								//"enable_color" => false,
								//"label_style"	=> __("Style","ultimate_vc"),
								//"dependency" => Array("element" => "img_box_shadow_type", "value" => "on" ),
								"group" => "Hover",
							),
							/*array(
								"type" => "colorpicker",
								"edit_field_class" => "vc_col-sm-12 vc_column hover_box_shadow_ultimate_box_shadow_color", 	// color dependency
								"heading" => __("Shadow Color","ultimate_vc"),
								"param_name" => "box_hover_shadow_color",
								"group" => "Hover",
						  	),*/

							//	Effect
							array(
								"type" => "ult_param_heading",
								"param_name" => "content_transition",
								"text" => __("Transition Options","ultimate_vc"),
								'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
								"group" => "Hover",
						  	),
							array(
								"type" => "dropdown",
								//"class" => "",
								"heading" => __("Transition Property","ultimate_vc"),
								"param_name" => "trans_property",
								"value" => array(
									__("All", "ultimate_vc") => 'all',
									__("Background", "ultimate_vc") => 'background',
									__("Color", "ultimate_vc") => 'color',
									__("Height", "ultimate_vc") => 'height',
									__("Width", "ultimate_vc") => 'width',
									__("Outline", "ultimate_vc") => 'outline',
								),
								"group"=> "Hover",
						  	),
						  	array(
						   		"type" => "number",
								//"class" => "",
								"heading" => __("Duration", "ultimate_vc"),
								"param_name" => "trans_duration",
								"suffix"=>"ms",
								"min"=>"0",
								"value" => "",
								"group"=> "Hover",
							),
							array(
								"type" => "dropdown",
								//"class" => "",
								"heading" => __("Transition Effect","ultimate_vc"),
								"param_name" => "trans_function",
								"value" => array(
									__("Ease", "ultimate_vc") => 'ease',
									__("Linear", "ultimate_vc") => 'linear',
									__("Ease-In", "ultimate_vc") => 'ease-in',
									__("Ease-Out", "ultimate_vc") => 'ease-out',
									__("Ease-In-Out", "ultimate_vc") => 'ease-in-out',
								),
								"group"=> "Hover",
						  	),

						  	// Responsive
						  	array(
								"type" => "ultimate_spacing",
								"heading" => __("Margin", "ultimate_vc"),
								"param_name" => "responsive_margin",
								"mode"  => "margin",                   		//  margin/padding
								"unit"  => "px",                       		//  [required] px,em,%,all     Default all
								"positions" => array(                  		//  Also set 'defaults'
								  __("Top","ultimate_vc")     => "",
								  __("Right","ultimate_vc")   => "",
								  __("Bottom","ultimate_vc")  => "",
								  __("Left","ultimate_vc")    => ""
								),
								"group" => __( 'Responsive', 'ultimate_vc' ),
								"description" => __( 'This margin will apply below screen 768px.', 'ultimate_vc' )
							),
					  	),
				  ) );
			  }
		}
		function ult_content_box_scripts() {
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
		  	wp_register_style( 'ult_content_box_css', plugins_url($css_path.'content-box'.$ext.'.css',__FILE__) );
		  	wp_register_script('ult_content_box_js', plugins_url($js_path.'content-box'.$ext.'.js',__FILE__) , array('jquery'), ULTIMATE_VERSION, true);
		}
	}
	// Finally initialize code
	new Ult_Content_Box;
		if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
			class WPBakeryShortCode_ult_content_box extends WPBakeryShortCodesContainer {
			}
		}
  }
