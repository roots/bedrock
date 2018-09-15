<?php
/*
* Module - Sticky Section
*/

if( !class_exists( 'Ultimate_Sticky_Section' ) ) {
	/**
	*
	*/
	class Ultimate_Sticky_Section
	{

		function __construct()
		{
			add_shortcode( 'ult_sticky_section', array( $this, 'sticky_shortcode') );
			add_action( 'init', array( $this, 'sticky_shortcode_mapper') );
			add_action( 'wp_enqueue_scripts', array( $this, 'ult_sticky_section_scripts' ), 1 );
			//add_action( 'wp_enqueue_scripts', array( $this , 'enqueue_style' ) );

		} /* Contructor End*/

		function sticky_shortcode( $atts, $content = null )
		{
			$el_class = '';
			$sticky_gutter = $sticky_offset_class = '';

			$sticky_width = $sticky_custom_width = '';

			$stick_behaviour = '';
			$sticky_position = $sticky_position_lr = $permanent_lr = '';
			$btn_mobile = '';

			extract( shortcode_atts( array(
				"el_class" => "",
				"sticky_gutter" => "",
				"sticky_offset_class" => "",

				"sticky_width" => "",
				"sticky_custom_width" => "",

				"stick_behaviour" => "",
				"sticky_position" => "",
				"sticky_position_lr" => "left",
				"permanent_lr" => "",
				"btn_mobile" => "",
				"btn_support" => "",

			), $atts ) );

			$sticky_classes_data = array();
			$sticky_gutter_class = " data-sticky_gutter_class= '";
			$sticky_gutter_id = " data-sticky_gutter_id= '";
			$class_flag = $id_flag = -1;
			$stick_behaviour_data = "";
			$left_right_postion = "";
			$data_mobile = "";
			$data_support = "";
			if($btn_mobile == "enable"){
				$data_mobile = " data-mobile='yes'";
			}else{
				$data_mobile = " data-mobile='no'";
			}

			if($btn_support == "enable"){
				$data_support = " data-support='yes'";
			}else{
				$data_support = " data-support='no'";
			}


			//gutter classes explode
			if( $sticky_offset_class != '' ){
				//$sticky_class = " data-sticky_gutter_class= '";
				if ( strpos( $sticky_offset_class, ',' ) !== false )
				{
					$sticky_classes_data = explode( ',', $sticky_offset_class ); //str_replace( ',', '', trim( $sticky_offset_class ) );
					foreach($sticky_classes_data as $data) {
					    if ( strpos( $data, '.' ) !== false ) {
					    	$class_flag = 0;

					    	$sticky_gutter_class .= trim( $data );
					    	$sticky_gutter_class .= " ";
					    }
					    elseif (strpos( $data, '#' ) !== false ) {
					    	$id_flag = 0;

					    	$sticky_gutter_id .= trim( $data );
					    	$sticky_gutter_id .= " ";
					    }
					}

					// $sticky_gutter_class .= " '";
					// $sticky_gutter_id .= " '";
					//echo ( $sticky_classes[0] );
				} //check ',' in string end if
				else {
					 if ( strpos( $sticky_offset_class, '.' ) !== false ) {
					 		$class_flag = 0;

					    	$sticky_gutter_class .= trim( $sticky_offset_class );

					    }
					    elseif ( strpos( $sticky_offset_class, '#' ) !== false ) {
					    	$id_flag = 0;
					    	$sticky_gutter_id .= trim( $sticky_offset_class );

					    }
				}//checked ',' in string end else

				if ( $class_flag != 0 ) {
					$sticky_gutter_class = "";
				} else {
					$sticky_gutter_class = rtrim( $sticky_gutter_class)."'";
				}

				if ( $id_flag != 0 ) {
					$sticky_gutter_id = "";
				} else {
					$sticky_gutter_id = rtrim( $sticky_gutter_id )."'";
				}
			}//check sticky_offset_class end if
			else{
				$sticky_gutter_class = "";
				$sticky_gutter_id = "";
			} //check sticky_offset_class end else

			//width data
			if ( $sticky_width == 'customwidth' ) {
				//$sticky_custom_width = " data-sticky_customwidth= '";

				if ( $sticky_custom_width != '' ) {
					if ( strpos( $sticky_custom_width, 'px' ) !== false  || strpos( $sticky_custom_width, 'em' ) !== false  || strpos( $sticky_custom_width, '%' ) !== false ) {
						$sticky_custom_width .= " data-sticky_customwidth= '".$sticky_custom_width;
					} else {
						$sticky_custom_width .= " data-sticky_customwidth= '".$sticky_custom_width."px";
					}
				} else {
					$sticky_custom_width .= " data-sticky_customwidth= '60%";

				}
				$sticky_custom_width .= "'";
				//$sticky_custom_width != '' ? " data-sticky_customwidth= '".$sticky_custom_width."px'" : " data-sticky_customwidth= '50px'" ;
			}

			//sticky bahviour
			$stick_behaviour_data = $stick_behaviour != '' ? " data-stick_behaviour= '".$stick_behaviour."'" : " data-stick_behaviour= 'stick_with_scroll_row'" ;

			//permanent data
			if ( $stick_behaviour == 'stick_permanent') {
				$left_right_postion = " data-lr_position= '".$sticky_position_lr."' ";
				//$left_right_postion .=
				if ( $permanent_lr != "" ) {
					if ( strpos( $permanent_lr, 'px' ) !== false  || strpos( $permanent_lr, 'em' ) !== false  || strpos( $permanent_lr, '%' ) !== false ) {
						$left_right_postion .= " data-lr_value= '".$permanent_lr;
					} else {
						$left_right_postion .= " data-lr_value= '".$permanent_lr."px";
					}
				} else {
					$left_right_postion .= "data-lr_value= '0";

				}
				//$permanent_lr != "" ? " data-lr_value= '".$permanent_lr."px" :"data-lr_value= '0";
				$left_right_postion .= "'";
			}


			$custom_data = $sticky_gutter != '' ? " data-gutter= '".$sticky_gutter."'": '' ;
			$custom_data .= $stick_behaviour_data ;
			$custom_data .= $left_right_postion ;
			$custom_data .= $sticky_gutter_class." ".$sticky_gutter_id;
			$custom_data .= $sticky_width != '' ? " data-sticky_width= '".$sticky_width."'": '' ;
			$custom_data .= $sticky_custom_width ;
			$custom_data .= $sticky_position != '' ? " data-sticky_position= '".$sticky_position."'": " data-sticky_position= 'top'" ;
			$custom_data .= $data_mobile;
			$custom_data .= $data_support;


			$output = '<div class="ult_row_spacer">';
			$output .= '<div class="ult-sticky-anchor">';
			$output .= '<div class="ult-sticky-section ult-sticky '.$el_class.'" '.$custom_data.'>';
			$output .= do_shortcode( $content );
			$output .= '</div>';
			$output .= '<div class="ult-space"></div>';
			$output .= '</div></div>';
			return $output;

		}// end function sticky_shortcode

		function sticky_shortcode_mapper()
		{
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name" => __("Sticky Section", "ultimate_vc"),
						"base" => "ult_sticky_section",
						"icon" => "vc_icon_sticky_section",
						"class" => "",
						"as_parent" => array('except' => 'ult_sticky_section'),
						"content_element" => true,
						"controls" => "full",
						"show_settings_on_create" => true,
						"category" => "Ultimate VC Addons",
						"description" => __("Make any elements sticky anywhere.",'ultimate_vc'),
						"params" => array(

							//gutter option
							/*array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __( "Gutter Space", "ultimate_vc" ),
								"param_name" => "gutter",
								"value" => array(
									'Numerical Value'   => 'num_value',
        							'Offset Container'   => 'offset_container'
        							),
								"description" => __( "Set top/bottom position of sticky section", "ultimate_vc" )
							),*/

							//// sticky behaviour
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __( "Stick Behaviour", "ultimate_vc" ),
								"param_name" => "stick_behaviour",
								"value" => array(
									'Stick with Row'   => 'stick_with_scroll_row',
									'Stick with Window'   => 'stick_with_scroll',
        							'Stick Permanent'   => 'stick_permanent'
        							),
								"description" => __( "Set behaviour of sticky section", "ultimate_vc" )
							),

							//sticky offset class
							/*array(
								"type" => "textfield",
								"class" => "",
								"heading" => __( "Offset Container", "ultimate_vc" ),
								"param_name" => "sticky_offset_class",
								"value" => "",
								"description" => __( "Do you already have a fixed horizontal header on the page? Add Class name or Id.<br>Ex: .class1, .class2, #ID1 ", "ultimate_vc" ),
							),*/

							//sticky section width
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __( "Sticky Section Width", "ultimate_vc" ),
								"param_name" => "sticky_width",
								"value" => array(
									'Default'   => '',
        							'Full Width'   => 'fullwidth',
        							'Custom Width' => 'customwidth'
        							),
								"description" => __( "Set the width of container", "ultimate_vc" ),
								"dependency" => array(
									"element" => "stick_behaviour",
									"value" => array( 'stick_with_scroll', 'stick_permanent' )
									)
							),

							//sticy section custom width
							array(
								"type" => "textfield",
								"heading" => __("Custom Width", "ultimate_vc"),
								"param_name" => "sticky_custom_width",
								"description" => __("Ex : 20px, 20%, 20em", "ultimate_vc"),
								"dependency" => array(
									"element" => "sticky_width",
									"value" => "customwidth"
									)
							),

							//sticky section position
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __( "Sticky Section Postion Top / Bottom", "ultimate_vc" ),
								"param_name" => "sticky_position",
								"value" => array(
									'Top'   => '',
        							'Bottom'   => 'bottom'
        							),
								"description" => __( "Set the postion of container", "ultimate_vc" ),
								"dependency" => array(
									"element" => "stick_behaviour",
									"value" => array( 'stick_permanent' )
									)
							),

							//permanent position
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __( "Sticky Section Postion Left / Right", "ultimate_vc" ),
								"param_name" => "sticky_position_lr",
								"value" => array(
									'Left'   => 'left',
        							'Right'   => 'right'
        							),
								"description" => __( "Default is Left : 0px ", "ultimate_vc" ),
								"dependency" => array(
									"element" => "stick_behaviour",
									"value" => "stick_permanent"
									)
							),

							array(
								"type" => "textfield",
								"heading" => __( "Value", "ultimate_vc" ),
								"param_name" => "permanent_lr",
								"description" => __("Ex : 20px, 20%, 20em", "ultimate_vc"),
								"dependency" => array(
									"element" => "sticky_position_lr",
									"value" => array( "left", "right")
									)
							),

							//num value
							array(
								"type" => "number",
								"heading" => __("Gutter Space", "ultimate_vc"),
								"param_name" => "sticky_gutter",
								"suffix" => "px",
								"description" => __("Ex : 20", "ultimate_vc"),

							),

							/*array(
								"type" => "number",
								"heading" => __("Postion From Right", "ultimate_vc"),
								"param_name" => "permanent_right",
								"description" => __("Ex : 20px, 20%, 20em", "ultimate_vc"),
								"dependency" => array(
									"element" => "stick_behaviour",
									"value" => "stick_permanent"
									)
							),*/
							/*array(
								"type" => "ultimate_spacing",
								"heading" => __("Postion", "ultimate_vc"),
								"param_name" => "position",
								"mode"  => "padding",                   	//  margin/padding
								"unit"  => "px",                       		//  [required] px,em,%,all     Default all
								"positions" => array(                  		//  Also set 'defaults'
								  __("Top","ultimate_vc")     => "",
								  __("Right","ultimate_vc")   => "",
								  __("Bottom","ultimate_vc")  => "",
								  __("Left","ultimate_vc")    => ""
								),
								"dependency" => array(
									"element" => "stick_behaviour",
									"value" => "stick_permanent"
									)
							),*/

							array(
								"type" => "ult_switch",
								"class" => "",
								"heading" => __("Enable on Mobile", "ultimate_vc"),
								"param_name" => "btn_mobile",
								"value" => "",
								"options" => array(
										"enable" => array(
											"label" => "",
											"on" => "Yes",
											"off" => "No",
										)
									),
								"description" => __("Enable Sticky Element on Smartphone.", "ultimate_vc"),
								"dependency" => Array("element" => "stick_behaviour", "value" => array( 'stick_with_scroll_row', 'stick_with_scroll','stick_permanent' )),
							),

							array(
								"type" => "ult_switch",
								"class" => "",
								"heading" => __("Enable support", "ultimate_vc"),
								"param_name" => "btn_support",
								"value" => "",
								"options" => array(
										"enable" => array(
											"label" => "",
											"on" => "Yes",
											"off" => "No",
										)
									),
								"description" => __("Enable this incase Sticky Element not working.", "ultimate_vc"),
								"dependency" => Array("element" => "stick_behaviour", "value" => array( 'stick_with_scroll' )),
							),

							array(
								"type" => "textfield",
								"heading" => __("Extra class name", "ultimate_vc"),
								"param_name" => "el_class",
								"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "ultimate_vc")
							),
						),
						"js_view" => 'VcColumnView'
					)
				);//end vc_map
			}//end vc_map checker
		}//end function sticky_shotcode_mapper

		//Add Script
		function ult_sticky_section_scripts() {
			$script_path = '../assets/js/';
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

		  	wp_register_script( 'ult_sticky_js', plugins_url( $script_path.'fixto.js',__FILE__ ) , array('jquery'), ULTIMATE_VERSION, true);
		  	wp_register_script( 'ult_sticky_section_js', plugins_url( $js_path.'sticky-section'.$ext.'.js',__FILE__ ) , array('ult_sticky_js'), ULTIMATE_VERSION, true);
		  	wp_register_style( 'ult_sticky_section_css', plugins_url( $css_path.'sticky-section'.$ext.'.css',__FILE__ ), array(), ULTIMATE_VERSION);

		}//ult_sticky_section_class


	}//end class Ultimate_Sticky_Section


	// Instantiate the class
	new Ultimate_Sticky_Section;

	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_ult_sticky_section extends WPBakeryShortCodesContainer {
		}
	}
}