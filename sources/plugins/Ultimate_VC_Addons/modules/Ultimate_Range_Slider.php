<?php
/*
* Module - Range Slider
*/
if( !class_exists( "Ultimate_Range_Slider" ) ){
	/**
	* Ultimate_Range_Slider Class
	*/
	class Ultimate_Range_Slider
	{
		
		function __construct()
		{
			add_action( 'init', array($this, 'init_range_slider') );
			add_shortcode( 'ult_range_slider',array( $this,'ult_range_slider_shortcode' ) );
			add_action( "wp_enqueue_scripts", array( $this, "range_slider_scripts" ), 1 );
		}
		function ult_range_slider_shortcode( $atts, $content=null )
		{
		 	$slider_color = "";//$slider_active_color = $dragger_color = "";
		 	$title_box_color = $title_border = $title_box = $title_box_width = $title_box_height = $title_padding = "";
		 	$el_class = "";
		 	//$slider_steps = 
		 	$slider_bar_size = "";//$dragger_size = "";
		 	$slider_data = "";
		 	$title_font = $title_font_size = $title_line_height = $title_color = $title_font_style = '';
			$desc_font = $desc_font_size = $desc_line_height = $desc_color = $desc_font_style = '';

		 	$desc_width = $desc_padding = $desc_margin = $adaptive_height = '';//$desc_min_height = '';

			extract( shortcode_atts( array(
				'slider_color' => '',
				//'slider_active_color' => '',
				//'dragger_color' => '',

				'title_box_color' => '',
				'title_border' => 'border-style:solid;|border-width:2px;border-radius:0px;|border-color:#30eae9;',
				'title_box' => '',
				'title_box_width' => '',
				'title_box_height' => '',
				'title_padding' => '',
				'el_class' => '',

				//'slider_steps' => '',
				'slider_data' => '',
				'slider_bar_size' => '',
				//'dragger_size' => '',

				'title_font' => '',
				'title_font_size' => '',
				'title_line_height' => '',
				'title_color' => '',
				'title_font_style'=> '',
				
				'desc_font'=> '',
				'desc_font_size'=> '',
				'desc_line_height' => '',
				'desc_color' => '',
				'desc_font_style'=> '',

				'desc_width' => '',
				'adaptive_height' => '',
	//				'desc_min_height' => '',
				'desc_padding' => '',
				'desc_margin' => '',
		  	), $atts ) );

			$steps_count = 0;
			$title_count = 1;
			$desc_count = 1;
			$output = '';

			//slider color setting setting 
			$slider_color_data = '';
			$slider_color_data .= $slider_color != ''? " data-slider_color = '".$slider_color."'" : '';
			//$slider_color_data .= $slider_active_color != ''? " data-slider_active_color = '".$slider_active_color."'" : '' ;
			//$slider_color_data .= $dragger_color != '' ? " data-dragger_color = '".$dragger_color."'" : '';
		  	
			// Title box style 
			$title_box_data = $title_box_color != '' ? "data-title-background = ".$title_box_color." " : '';
			$title_box_data .= $title_box != '' ? " data-title-box = ".$title_box." " : " data-title-box = auto ";
			$title_style = " style = '"; //title box style var
			$arrow_style = "";
			
			$none_style = "ult-tooltip-border ult-arrow";

			//echo $title_border;
			if (strpos($title_border,'none') !== false) {
				$none_style = "";
			}
			else{
				$arrow_style = " data-arrow = '";

				if (strpos($title_border,'border-width:0px') !== false) {
					$none_style = "";
				}

				$temp_array = array();
				$temp_border = str_replace( '|', '', $title_border );
				$title_style .= $temp_border;
				$title_style .= $title_box_color == '' ? '' : "background:".$title_box_color."; ";
				$temp_array = explode(";", $temp_border);

				if( is_array( $temp_array ) ){
					foreach ($temp_array as $key => $value) {
						if ( strpos($value,'border-width:') !== false ) {
							$value = str_replace( 'border-width:', '', $value );
							$value = str_replace( 'px', '', $value );
							$value = $value + 7;
							$arrow_style .= " border-width:".$value."px; ";
			    			$arrow_style .= "margin-left:-".$value."px; ";
						}elseif( strpos($value,'border-color:') !== false ) {
							$value = str_replace( 'border-color', 'border-top-color', $value );
							$value = $value."; ";
							$arrow_style .= $value;
						}
					}
				}
				$arrow_style .= "'";
			}

			$title_style .= $title_padding !== '' ? ' '.$title_padding.';' : '';
			//title box custom width
			$center_class = '';
			$title_box_width_t = $title_box_height_t = $slider_padding = '';
			if( $title_box == 'custom' ){
				$center_class = ' ult-tooltip-center';
				
				$title_box_width_t = $title_box_width !== '' ? $title_box_width : '115';
				$title_box_height_t = $title_box_height !== '' ? $title_box_height : '115';

				$title_style .= ' width:'.$title_box_width_t.'px;';
				$title_style .= ' height:'.$title_box_height_t.'px;';

				//apply this time padding to slider for tooltip adjustment
				$slider_padding = ' style = "padding:'.$title_box_height_t.'px '.(($title_box_width_t/2)+10).'px 35px;"';

				
				
			}
			
			//slider size data
			$slider_bar_size = $slider_bar_size != '' ? ' '.$slider_bar_size.'px;' : ''; 
			$slider_size_data = $slider_bar_size != '' ? ' data-slider_size = "'.$slider_bar_size.'px"' : ''; 
			//$slider_size_data = $dragger_size != '' ? ' data-dragger_size = "'.$dragger_size.'px"' : ''; 
			//title data
		  	$slider_data = json_decode( urldecode( $slider_data ), true );

		  	//min max value data
		  	if( isset( $slider_data ) ) {
				foreach ( $slider_data as $slider_datas ){
					$steps_count = $steps_count + 1;
				}
			}

		  	$steps_data = ' data-slider_steps = "'.$steps_count.'"';

		  	

//////////////////////////typography data
		  	
		  	//title 
			//$title_style = " style = '";

			if ( $title_font !== '' ) {
				$title_font_family = function_exists( "get_ultimate_font_family" ) ? get_ultimate_font_family( $title_font ) : '' ;
				$title_style .= 'font-family:'. $title_font_family . ';';
			}
			if ( $title_font_style !== '') {
				$title_style .= $title_font_style;
			}

			$micro = rand(0000,9999);
			$id = uniqid('ultimate-range-slider'.$micro);
			$uid = 'urs-'.rand(0000,9999);

			// FIX: set old font size before implementing responsive param
			if(is_numeric($title_font_size)) 	{ 	$title_font_size = 'desktop:'.$title_font_size.'px;';		}
			if(is_numeric($title_line_height)) 	{ 	$title_line_height = 'desktop:'.$title_line_height.'px;';		}
			// responsive {main} heading styles
		  	$args = array(
		  		'target'		=>	'#'.$id.' .ult-content',
		  		'media_sizes' 	=> array(
					'font-size' 	=> $title_font_size,
					'line-height' 	=> $title_line_height,
				),
		  	);
			$title_responsive = get_ultimate_vc_responsive_media_css($args);

			//$title_style .= $title_font_size !== '' ? 'font-size:'.$title_font_size.'px;' : '';
			//$title_style .= $title_line_height !== '' ? 'line-height:'.$title_line_height.'px;' : '';
			$title_style .= $title_color !== '' ? 'color:'.$title_color.';' : '';
			$title_style .= "'";



			$desc_style = " style = '";

			if ( $desc_font !== '' ) {
				$desc_font_family = function_exists( "get_ultimate_font_family" ) ? get_ultimate_font_family( $desc_font ) : '' ;
				$desc_style .= 'font-family:'. $desc_font_family . ';';
			}
			if ( $desc_font_style !== '') {
				$desc_style .= $desc_font_style;
			}

			if(is_numeric($desc_font_size)) 	{ 	$desc_font_size = 'desktop:'.$desc_font_size.'px;';		}
			if(is_numeric($desc_line_height)) 	{ 	$desc_line_height = 'desktop:'.$desc_line_height.'px;';		}
			// responsive {main} heading styles
		  	$args = array(
		  		'target'		=>	'#'.$id.' .ult-description',
		  		'media_sizes' 	=> array(
					'font-size' 	=> $desc_font_size,
					'line-height' 	=> $desc_line_height,
				),
		  	);

			$desc_responsive = get_ultimate_vc_responsive_media_css($args);
			//$desc_style .= $desc_font_size !== '' ? 'font-size:'.$desc_font_size.'px;' : '';
			//$desc_style .= $desc_line_height !== '' ? 'line-height:'.$desc_line_height.'px;' : '';
			$desc_style .= $desc_color !== '' ? 'color:'.$desc_color.';' : '';
			//$desc_style .= "'";

//////////design data
			//$desc_style = 'style = "';
			$desc_style .= $desc_padding !== '' ? ' '.$desc_padding.';' : '';
			$desc_style .= $desc_margin !== '' ? ' '.$desc_margin.';' : '';
			$desc_style .= $desc_width !== '' ? ' width:'.$desc_width.'px;' : '';
			//$desc_style .= $desc_min_height !== '' ? ' min-height:'.$desc_min_height.'px;' : '';
			$desc_style .= "'";
			
			$desc_data = $adaptive_height !== '' ? ' data-adaptive_height = '.$adaptive_height.' ' : '';

		  	/////////////////////////////////////////////////////////////////////////typogrphy data end/////////
		  	$output .= '<div id="'.$id.'" class="ult-rs-wrapper"><div id="ult-range-slider " '.$slider_padding.' class="ult-rslider-container ult-responsive '.$el_class.'" '.$steps_data.$slider_color_data.$slider_size_data.$arrow_style.$title_box_data.$desc_data.' '.$title_responsive.'>';
		  	if( isset( $slider_data ) ) {
				foreach ( $slider_data as $slider_datas ){

						
					if ( isset( $slider_datas["slider_title"] ) ){
							
						//$output .= '<div class = "ult-tooltip ult-title'.$title_count.'" ><div class = "ult-tooltip-inner"'.$title_style.'>'.$slider_datas["slider_title"]; " '.$main_heading_responsive
						//$output .= '</div></div>';

						$output .= '<div class = "ult-tooltip '.$none_style.' ult-title'.$title_count.'" '.$title_style.'><span class="ult-content '.$center_class.'">'.$slider_datas["slider_title"];
						$output .= '</span></div>';
						//$output .= '</span><span class="ult-arrow" ></span></div>';
					}
					$title_count = $title_count + 1;
				}
			}

		  	$output .= '<div class = "ult-rslider" style = "width:'.$slider_bar_size.'" ></div>';
			//echo $title_border;
			$output .= '</div>';
			  	//description data

		  	if( isset( $slider_data ) ) {
		  		$output .=  '<div class="ult-desc-wrap ult-responsive "'.$desc_responsive.'>';
				foreach ( $slider_data as $slider_datas ){
						
					if ( isset( $slider_datas["slider_desc"] ) ){
							
						$output .= '<div class = "ult-description ult-desc'.$desc_count.'"'.$desc_style.' >'.$slider_datas["slider_desc"].'</div>';
					}
					$desc_count = $desc_count + 1;
				}
				$output .=  '</div>';
			}

			$output .= '</div>'; //wrapper div close
		  	return $output;
		}

		function init_range_slider()
		{
			if ( function_exists( "vc_map" ) ) {
				vc_map(
					array(
						"name" => __("Range Slider", "ultimate_vc"),
						"base" => "ult_range_slider",
						"icon" => "vc_icon_range_slider",
						"class" => "",
						"content_element" => true,
						"controls" => "full",
						"category" => "Ultimate VC Addons",
						"description" => __("Create creative range sliders.","ultimate_vc"),
						"params" => array(
							array(
									"type"       => "text",
									"param_name" => "title_typography",
									"heading"    => __( "<h4>Slider Content</h4>", "ultimate_vc" ),
									"value"      => "",
									//"group" => "Slider Setting",
									"edit_field_class" => "ult-param-heading-wrapper vc_column vc_col-sm-12",
							),
							//title and description for slider step
							array(
								"type" => "param_group",
								"heading" => __( "Slider Text Setting", "ultimate_vc" ),
								"param_name" => "slider_data",
								"description" => __("Add content here steps will generate based on content", "ultimate_vc"),
								"value" => urlencode( json_encode ( array(
																		array(
																			"slider_title" => "",
																			"slider_desc" => "",
																			
																		)
								)	)	),

								"params" => array(
												
												array(
													"type" => "textfield",
													"heading" => __("Slider Title","ultimate_vc"),
													"param_name" => "slider_title",
													"description" =>"",
													"admin_label" => true
												),
												array(
													"type" => "textarea",
													"heading" => __("Slider Description","ultimate_vc"),
													"param_name" => "slider_desc",
													"value" => "",
													"description" => "",
													
													
												),
								),
								//"group" => "Slider Setting",
							),

							//slider setting
							array(
									"type"       => "text",
									"param_name" => "title_typography",
									"heading"    => __( "<h4>Slider Bar Color</h4>", "ultimate_vc" ),
									"value"      => "",
									"edit_field_class" => "ult-param-heading-wrapper vc_column vc_col-sm-12",
							),
							// SLider BAr Setting
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Slider Bar Color","ultimate_vc"),
								"param_name" => "slider_color",
								"value" => "#3BF7D1",
								"description" => "",
								//"group" => "General",
							),
							/*array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Slider Bar Active Color","ultimate_vc"),
								"param_name" => "slider_active_color",
								"value" => "",
								"description" => "",
								//"group" => "General",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Slider Dragger Color","ultimate_vc"),
								"param_name" => "dragger_color",
								"value" => "",
								"description" => "",
								//"group" => "General",
							),*/
							
							
							array(
									"type"       => "text",
									"param_name" => "title_typography",
									"heading"    => __( "<h4>Slider Bar Width</h4>", "ultimate_vc" ),
									"value"      => "",
									//"group" => "Slider Setting",
									"edit_field_class" => "ult-param-heading-wrapper vc_column vc_col-sm-12",
							),


							array(
								"type" => "number",
								"class" => "",
								"heading" => __( "Slider Width", "ultimate_vc" ),
								"param_name" => "slider_bar_size",
								"value" => "",
								"suffix"      => "px",
								"description" => __( "If title box text or width is too long then slider width will reduce according to title box width", "ultimate_vc" ),
								//"group" => "Slider Setting",
							),

							array(
									"type"       => "text",
									"param_name" => "title_typography",
									"heading"    => __( "<h4>Extra Class</h4>", "ultimate_vc" ),
									"value"      => "",
									"edit_field_class" => "ult-param-heading-wrapper vc_column vc_col-sm-12",
							),
							array(
								"type" => "textfield",
								"heading" => __("Extra class name", "ultimate_vc"),
								"param_name" => "el_class",
								"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "ultimate_vc")
						  	),
						
							/* slider bar*/

							

							/*array(
								"type" => "number",
								"class" => "",
								"heading" => __( "Dragger Size", "ultimate_vc" ),
								"param_name" => "dragger_size",
								"value" => "",
								"suffix"      => "px",
								"description" => __( "", "ultimate_vc" ),
								"group" => "Slider Setting",
							),*/

							//Title Box
							//Title Setting
							array(
									"type"       => "text",
									"param_name" => "title_typography",
									"heading"    => __( "<h4>Title Box</h4>", "ultimate_vc" ),
									"value"      => "",
									"edit_field_class" => "ult-param-heading-wrapper vc_column vc_col-sm-12",
									"group" => "Title Box",
							),

							//Title Color
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __( "Title Color", "ultimate_vc" ),
								"param_name" => "title_color",
								"value" => "#444444",
								"description" => "",
								"group"      => "Title Box"
							),

							// Title Box Color
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Background Color","ultimate_vc"),
								"param_name" => "title_box_color",
								"value" => "#fff",
								"description" => "",
								"group" => "Title Box",
							),
							array(
					  			"type" => "ultimate_border",
					  			"heading" => __("Title Box Border","ultimate_vc"),
					  			"param_name" => "title_border",
					  			"unit"     => "px",  
					  			"value" => "border-style:solid;|border-width:2px;border-radius:0px;|border-color:#30eae9;",                      			//  [required] px,em,%,all     Default all
								"group" => "Title Box",
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
							
								//spacing
							array(
								"type" => "ultimate_spacing",
								"heading" => __("Title Box Padding", "ultimate_vc"),
								"param_name" => "title_padding",
								"mode"  => "padding",                   	//  margin/padding
								"unit"  => "px",                      		//  [required] px,em,%,all     Default all
								"positions" => array(                  		//  Also set 'defaults'
								  __("Top","ultimate_vc")     => "15",
								  __("Right","ultimate_vc")   => "15",
								  __("Bottom","ultimate_vc")  => "15",
								  __("Left","ultimate_vc")    => "15"
								),
								"group" => "Title Box",
							),


							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __( "Title Box Size", "ultimate_vc" ),
								"param_name" => "title_box",
								"value" => array(
									'Auto'   => 'auto',
        							'Custom'   => 'custom'
        							),
								"description" => __( "Set Title Box Size", "ultimate_vc" ),
								"group" => "Title Box",
							),

							//width
							array(
								"type" => "number",
								"class" => "",
								"heading" => __( "Width", "ultimate_vc" ),
								"param_name" => "title_box_width",
								"value" => "115",
								"suffix"      => "px",
								"description" => __( "Ex: 20px", "ultimate_vc" ),
								"dependency" => array(
									"element" => "title_box",
									"value" => "custom"
									),
								"group" => "Title Box",
							),

							//height
							array(
								"type" => "number",
								"class" => "",
								"heading" => __( "Height", "ultimate_vc" ),
								"param_name" => "title_box_height",
								"value" => "115",
								"suffix"      => "px",
								"description" => __( "Ex: 20px ", "ultimate_vc" ),
								"dependency" => array(
									"element" => "title_box",
									"value" => "custom"
									),
								"group" => "Title Box",
							),

							//Description
							array(
									"type"       => "text",
									"param_name" => "title_typography",
									"heading"    => __( "<h4>Description Design Setting</h4>", "ultimate_vc" ),
									"value"      => "",
									"group"      => "Description",
									"edit_field_class" => "ult-param-heading-wrapper vc_column vc_col-sm-12",
							),

							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __( "Description Color", "ultimate_vc" ),
								"param_name" => "desc_color",
								"value" => "#444",
								"description" => "",
								"group"      => "Description"
							),

							array(
								"type"       => "number",
								"param_name" => "desc_width",
								"heading"    => __( "Width", "ultimate_vc" ),
								"value"      => "",
								"suffix"     => "px",
								"group"      => "Description",
							),

							/*array(
								"type"       => "number",
								"param_name" => "desc_min_height",
								"heading"    => __( "Minimum Heigth", "ultimate_vc" ),
								"value"      => "",
								"suffix"     => "px",
								"group"      => "Description",
							),*/

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
								"description" => __("If you have different height of descriptions. It will automatically adapt the maximum height.  ", "smile"),
								"dependency"  => "",
								"group"      => "Description",
							),

							//spacing
							array(
								"type" => "ultimate_spacing",
								"heading" => __("Padding", "ultimate_vc"),
								"param_name" => "desc_padding",
								"mode"  => "padding",                   	//  margin/padding
								"unit"  => "px",                       		//  [required] px,em,%,all     Default all
								"positions" => array(                  		//  Also set 'defaults'
								  __("Top","ultimate_vc")     => "35",
								  __("Right","ultimate_vc")   => "35",
								  __("Bottom","ultimate_vc")  => "35",
								  __("Left","ultimate_vc")    => "35"
								),
								"group"      => "Description",
							),

							//spacing
							array(
								"type" => "ultimate_spacing",
								"heading" => __("Margin", "ultimate_vc"),
								"param_name" => "desc_margin",
								"mode"  => "margin",                   	//  margin/padding
								"unit"  => "px",                       		//  [required] px,em,%,all     Default all
								"positions" => array(                  		//  Also set 'defaults'
								  __("Top","ultimate_vc")     => "",
								  //__("Right","ultimate_vc")   => "",
								  __("Bottom","ultimate_vc")  => "",
								  //__("Left","ultimate_vc")    => ""
								),
								"group"      => "Description",
							),


							//TYpography
							//Title Typography
							array(
									"type"       => "text",
									"param_name" => "title_typography",
									"heading"    => __( "<h4>For Title</h4>", "ultimate_vc" ),
									"value"      => "",
									"group"      => "Typography",
									"edit_field_class" => "ult-param-heading-wrapper vc_column vc_col-sm-12",
							),

							
							array(
								"type"       => "ultimate_google_fonts",
								"heading"    => __( "Font Family", "ultimate_vc" ),
								"param_name" => "title_font",
								"value"      => "",
								"description" => __("Click and select font of your choice. If you can't find the one that suits for your purpose","ultimate_vc").", ".__("you can","ultimate_vc")." <a href='admin.php?page=bsf-google-font-manager' target='_blank'>".__("add new here","ultimate_vc")."</a>.",
								"group"      => "Typography"
							),

							array(
								"type"       => "ultimate_google_fonts_style",
								"heading"    => __( "Font Style", "ultimate_vc" ),
								"param_name" => "title_font_style",
								"value"      => "",
								"group"      => "Typography"
							),
							

							array(
                          	  	"type" => "ultimate_responsive",
                          	  	"class" => "font-size",
                          	  	"heading" => __("Font size", 'ultimate_vc'),
                          	  	"param_name" => "title_font_size",
                          	  	"unit"  => "px",
                          	  	"media" => array(
                          	  	    "Desktop"           => '16',
                          	  	    "Tablet"            => '',
                          	  	    "Tablet Portrait"   => '',
                          	  	    "Mobile Landscape"  => '',
                          	  	    "Mobile"            => '',
                          	  	),
                          	  	"group" => "Typography"
                          	),

							/*array(
								"type"       => "number",
								"param_name" => "title_font_size",
								"heading"    => __( "Font size", "ultimate_vc" ),
								"value"      => "16",
								"suffix"     => "px",
								"group"      => "Typography"
							),*/

							array(
                          	  	"type" => "ultimate_responsive",
                          	  	"class" => "font-size",
                          	  	"heading" => __("Line Height", 'ultimate_vc'),
                          	  	"param_name" => "title_line_height",
                          	  	"unit"  => "px",
                          	  	"media" => array(
                          	  	    "Desktop"           => '',
                          	  	    "Tablet"            => '',
                          	  	    "Tablet Portrait"   => '',
                          	  	    "Mobile Landscape"  => '',
                          	  	    "Mobile"            => '',
                          	  	),
                          	  	"group" => "Typography"
                          	),

							/*array(
								"type"       => "number",
								"param_name" => "title_line_height",
								"heading"    => __( "Line Height", "ultimate_vc" ),
								"value"      => "22",
								"suffix"     => "px",
								"group"      => "Typography"
							),*/

							//Description Typography

							array(
									"type"       => "text",
									"param_name" => "title_typography",
									"heading"    => __( "<h4>For Description</h4>", "ultimate_vc" ),
									"value"      => "",
									"group"      => "Typography",
									"edit_field_class" => "ult-param-heading-wrapper vc_column vc_col-sm-12",
							),

							
							array(
								"type"       => "ultimate_google_fonts",
								"heading"    => __( "Font Family", "ultimate_vc" ),
								"param_name" => "desc_font",
								"value"      => "",
								"description" => __("Click and select font of your choice. If you can't find the one that suits for your purpose","ultimate_vc").", ".__("you can","ultimate_vc")." <a href='admin.php?page=bsf-google-font-manager' target='_blank'>".__("add new here","ultimate_vc")."</a>.",
								"group"      => "Typography"
							),

							array(
								"type"       => "ultimate_google_fonts_style",
								"heading"    => __( "Font Style", "ultimate_vc" ),
								"param_name" => "desc_font_style",
								"value"      => "",
								"group"      => "Typography"
							),
							
							array(
                          	  	"type" => "ultimate_responsive",
                          	  	"class" => "font-size",
                          	  	"heading" => __("Font size", 'ultimate_vc'),
                          	  	"param_name" => "desc_font_size",
                          	  	"unit"  => "px",
                          	  	"media" => array(
                          	  	    "Desktop"           => '16',
                          	  	    "Tablet"            => '',
                          	  	    "Tablet Portrait"   => '',
                          	  	    "Mobile Landscape"  => '',
                          	  	    "Mobile"            => '',
                          	  	),
                          	  	"group" => "Typography"
                          	),

                          	array(
                          	  	"type" => "ultimate_responsive",
                          	  	"class" => "font-size",
                          	  	"heading" => __("Line Height", 'ultimate_vc'),
                          	  	"param_name" => "desc_line_height",
                          	  	"unit"  => "px",
                          	  	"media" => array(
                          	  	    "Desktop"           => '',
                          	  	    "Tablet"            => '',
                          	  	    "Tablet Portrait"   => '',
                          	  	    "Mobile Landscape"  => '',
                          	  	    "Mobile"            => '',
                          	  	),
                          	  	"group" => "Typography"
                          	),

							/*array(
								"type"       => "number",
								"param_name" => "desc_font_size",
								"heading"    => __( "Font Size", "ultimate_vc" ),
								"value"      => "22",
								"suffix"     => "px",
								"group"      => "Typography"
							),*/

							/*array(
								"type"       => "number",
								"param_name" => "desc_line_height",
								"heading"    => __( "Line Height", "ultimate_vc" ),
								"value"      => "33",
								"suffix"     => "px",
								"group"      => "Typography"
							),*/
						),
					)
				); //vc_map() end
			} //vc_map function check
		} // init_range_slider() end

		function range_slider_scripts() {
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
			wp_register_style('ult_range_slider_css',plugins_url($css_path.'range-slider'.$ext.'.css',__FILE__), array(), ULTIMATE_VERSION, false);
			
			wp_register_script('ult_range_slider_js', plugins_url($js_path.'range-slider'.$ext.'.js',__FILE__) , array('jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-mouse', 'jquery-ui-slider'), ULTIMATE_VERSION, true);
			
			wp_register_script('ult_ui_touch_punch', plugins_url($js_path.'range-slider-touch-punch'.$ext.'.js',__FILE__) , array('jquery, jquery-ui-widget, jquery-ui-mouse'), ULTIMATE_VERSION, true);

			//jquery.ui.labeledslider
			wp_register_script( 'ult_range_tick', plugins_url($js_path.'jquery-ui-labeledslider'.$ext.'.js',__FILE__) , array('jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-slider' ), ULTIMATE_VERSION, false);
			

			
		}
	}
	new Ultimate_Range_Slider;

	if ( class_exists( "WPBakeryShortCode" ) ) {
		class WPBakeryShortCode_ult_range_slider extends WPBakeryShortCode {
		}
	}
}