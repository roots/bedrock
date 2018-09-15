<?php
/*
* Add-on Name: Creatve Link for Visual Composer
* Add-on URI: http://dev.brainstormforce.com
*/
if(!class_exists('AIO_creative_link'))
{
	class AIO_creative_link

	{
		function __construct()
		{
			add_shortcode('ult_createlink',array($this,'ult_createlink_shortcode'));
			add_action('init',array($this,'ultimate_createlink'));
			add_action( 'wp_enqueue_scripts', array( $this, 'creative_link_scripts'), 1 );
			//add_action( 'admin_enqueue_scripts', array( $this, 'link_backend_scripts') );
		}

		//enque script
		function creative_link_scripts(){
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
			wp_register_style( 'ult_cllink', plugins_url($css_path.'creative-link'.$ext.'.css', __FILE__),array(),ULTIMATE_VERSION );
			wp_register_script("jquery.ult_cllink",plugins_url($js_path."creative-link".$ext.".js",__FILE__),array('jquery'),ULTIMATE_VERSION);
		}
		/*function link_backend_scripts(){
			wp_enqueue_script("ult_jquery_creative_link",plugins_url("../admin/js/jquery_creative_link.js ",__FILE__),array('jquery'),ULTIMATE_VERSION);

		}*/

		// Shortcode handler function for stats Icon
		function ult_createlink_shortcode($atts)
		{


	extract(shortcode_atts( array(

				'btn_link'			 => '',
				'text_color'		 => '#333333',
				'text_hovercolor' 	 => '#333333',
				'background_color'   => '#ffffff',
				'bghovercolor' 		 => '',
				'font_family' 		 => '',
				'heading_style' 	 => '',
				'title_font_size'    => '',
				'title_line_ht'		 => '',
				'link_hover_style'	 =>'',
				'border_style' 		 => 'solid',
				'border_color' 		 => '#333333',
				'border_hovercolor'  => '#333333',
				'border_size' 		 => '1',
				'el_class'  		 => '',
				'dot_color' 		 =>'#333333',
				'css'		         =>'',
				'title'				 =>'',
				'text_style'		 =>'',

			),$atts));

			$vc_version = (defined('WPB_VC_VERSION')) ? WPB_VC_VERSION : 0;
			$is_vc_49_plus = (version_compare(4.9, $vc_version, '<=')) ? 'ult-adjust-bottom-margin' : '';

 		$href=$target=$text=$url= $alt_text="";
		if($btn_link !== ''){
				 $href = vc_build_link($btn_link);
				$target =(isset($href['target'])) ? "target='".trim($href['target'])."'" :'';

				$alt_text=$href['title'];
				$url=$href['url'];
				if($url==''){
					$url="javascript:void(0);";
				}
			}
			else{
				$url="javascript:void(0);";
			}

/*--- design option---*/
if($title!==''){
	$text=$title;
}
else{
	$text=$alt_text;
}

$css_class ='';$title_style='';$secondtitle_style=$span_style='';
 $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), "ult_createlink", $atts );
 $css_class = esc_attr( $css_class );

	if($link_hover_style=='Style_2'){
	 $span_style = 'background:'.$background_color.';';     //background-color
	}

/*--- hover effect for link-----*/

$data_link='';
 if($link_hover_style==''){
		$data_link .='data-textcolor="'.$text_color.'"';
		$data_link .='data-texthover="'.$text_hovercolor.'"';
	}
	else{
		$data_link .='data-textcolor="'.$text_color.'"';
		$data_link .='data-texthover="'.$text_hovercolor.'"';
	}

if($link_hover_style=='Style_2'){
	if($text_hovercolor==''){
		$text_hovercolor=$text_color;
	}
	if($bghovercolor==''){
		$bghovercolor=$background_color;
	}
	if($text_hovercolor=='' && $bghovercolor==''){

		$data_link .='data-bgcolor="'.$background_color.'"';
		$data_link .='data-bghover="'.$background_color.'"';
		//$data_link .='data-texthover="'.$text_color.'"';
	}
	else{

		$data_link .='data-bgcolor="'.$background_color.'"';
		$data_link .='data-bghover="'.$bghovercolor.'"';
	}
}
$data_link .='data-style="'.$link_hover_style.'"';

/*--- border style---*/

$data_border='';
if($border_style!=''){
 $data_border .='border-color:'.$border_color.';';
 $data_border .='border-width:'.$border_size.'px;';
 $data_border .='border-style:'.$border_style.';';
}

$main_span=$before=$borderhover=$ult_style2css=$ult_style11css='';
$after='';$style=$class=$id=$colorstyle=$borderstyle=$style11_css_class='';

/*---- text typography----*/

if($text_style!=''){
  $colorstyle.='float:'.$text_style.';';
}

if (function_exists('get_ultimate_font_family')) {
		$mhfont_family = get_ultimate_font_family($font_family);  		//for font family
		if($mhfont_family!=''){
			$colorstyle .= 'font-family:'.$mhfont_family.';';
		}
		//$secondtitle_style .='font-family:'.$mhfont_family.';';
	}
	if (function_exists('get_ultimate_font_style')) {
		         	//for font style
		$colorstyle .= get_ultimate_font_style($heading_style);
		//$secondtitle_style .=get_ultimate_font_style($heading_style);
	}
	// if($title_font_size!=''){
	// 	$colorstyle .= 'font-size:'.$title_font_size.'px;';
	// }
	// if($title_line_ht!=''){
	// 		$colorstyle .= 'line-height:'.$title_line_ht.'px;';
	// 		//$colorstyle .='color:'.$text_color.';';
	// 	}

	//Responsive param

	if(is_numeric($title_font_size)){
				$title_font_size = 'desktop:'.$title_font_size.'px;';
		}
		if(is_numeric($title_line_ht)){
			$title_line_ht = 'desktop:'.$title_line_ht.'px;';
		}
		$creative_link_id = 'creative-link-wrap-'.rand(1000, 9999);
		$creative_link_args = array(
            'target' => '#'.$creative_link_id.' .ult_colorlink', // set targeted element e.g. unique class/id etc.
            'media_sizes' => array(
                'font-size' => $title_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
               	'line-height' => $title_line_ht
            ),
        );
        $creative_link_data_list = get_ultimate_vc_responsive_media_css($creative_link_args);

	//font-size
	$title_style .= 'color:'.$text_color.';';//color

	// if($link_hover_style!='Style_2'){
	// 	if($title_line_ht!=''){
	// 		$colorstyle .= 'line-height:'.$title_line_ht.'px;';
	// 		//$colorstyle .='color:'.$text_color.';';
	// 	}
	// 		//font-line-height
 //    }
 //    else{
 //    	if($title_line_ht!=''){
	// 		$colorstyle .= 'line-height:'.$title_line_ht.'px;';
	// 	}		//font-line-height
 //    }

/*-- hover style---*/

$id='';
if($link_hover_style=='Style_1'){               //style1
$class .='ult_cl_link_1';
//$id .='ult_cl_link_1';
$colorstyle .='color:'.$text_color.';'; //text color for bracket
if($title_font_size!=''){
//$colorstyle .='font-size:'.$title_font_size.'px;';
}

}
else if($link_hover_style=='Style_2'){              //style2
$class .='ult_cl_link_2';
//$id .='ult_cl_link_2';

}
else if($link_hover_style=='Style_3'){               //style3
$class .='ult_cl_link_3';
//$id .='ult_cl_link_3';
$data_border='';
$data_border .='border-color:'.$border_color.';';
$data_border .='border-bottom-width:'.$border_size.'px;';
$data_border .='border-style:'.$border_style.';';
if($title_font_size!=''){
//$colorstyle .='font-size:'.$title_font_size.'px;';
}
$borderstyle .=$data_border; //text color for btm border
$after .='<span class="ult_link_btm3 " style="'.$borderstyle.'"></span>';

}
else if($link_hover_style=='Style_4'){               //style4
$class .='ult_cl_link_4';
//$id .='ult_cl_link_4';
$data_border='';
$data_border .='border-color:'.$border_color.';';
$data_border .='border-bottom-width:'.$border_size.'px;';
$data_border .='border-style:'.$border_style.';';
if($title_font_size!=''){
///$colorstyle .='font-size:'.$title_font_size.'px;';
}
$borderstyle .=$data_border; //text color for btm border
$after .='<span class="ult_link_btm4 " style="'.$borderstyle.'"></span>';
}
else if($link_hover_style=='Style_6'){               //style6
$class .='ult_cl_link_6';
//$id .='ult_cl_link_6';//
$colorstyle .='color:'.$text_hovercolor.';';
if($title_font_size!=''){
//$colorstyle .='font-size:'.$title_font_size.'px;';
}
$after .='<span class="ult_btn6_link_top " data-color="'.$dot_color.'">•</span>';
}
else if($link_hover_style=='Style_5'){               //style5
$class .='ult_cl_link_5';
//$id .='ult_cl_link_5';//
if($title_font_size!=''){
//$colorstyle .='font-size:'.$title_font_size.'px;';
}
$data_border='';
$data_border .='border-color:'.$border_color.';';
$data_border .='border-bottom-width:'.$border_size.'px;';
$data_border .='border-style:'.$border_style.';';
$borderstyle .=$data_border; //text color for btm border
$before='<span class="ult_link_top" style="'.$borderstyle.'"></span>';
$after .='<span class="ult_link_btm  " style="'.$borderstyle.'"></span>';
}

else if($link_hover_style=='Style_7'){               //style7
$class .='ult_cl_link_7';
//$id .='ult_cl_link_7';//
//$colorstyle .='font-size:'.$title_font_size.'px;';
$borderstyle .='background:'.$border_color.';';
$borderstyle .='height:'.$border_size.'px;';

$before='<span class="ult_link_top btn7_link_top " style="'.$borderstyle.'"></span>';
$after .='<span class="ult_link_btm  btn7_link_btm" style="'.$borderstyle.'"></span>';
}

else if($link_hover_style=='Style_8'){               //style8
$class .='ult_cl_link_8';
//$id .='ult_cl_link_8';//
if($title_font_size!=''){
//$colorstyle .='font-size:'.$title_font_size.'px;';
}
$borderstyle .='outline-color:'.$border_color.';';
$borderstyle .='outline-width:'.$border_size.'px;';
$borderstyle .='outline-style:'.$border_style.';'; //text color for btm border

$borderhover .='outline-color:'.$border_hovercolor.';';
$borderhover .='outline-width:'.$border_size.'px;';
$borderhover .='outline-style:'.$border_style.';'; //text color for btm border

$before='<span class="ult_link_top ult_btn8_link_top " style="'.$borderstyle.'"></span>';
$after .='<span class="ult_link_btm  ulmt_btn8_link_btm" style="'.$borderhover.'"></span>';
}
else if($link_hover_style=='Style_9'){               //style9
$class .='ult_cl_link_9';
//$id .='ult_cl_link_9';//
if($title_font_size!=''){
//$colorstyle .='font-size:'.$title_font_size.'px;';
}
//$borderstyle .='background:'.$border_color.';';
//$borderstyle .='height:'.$border_size.'px;';
$borderstyle .= 'border-top-width:'.$border_size.'px;';
$borderstyle .= 'border-top-style:'.$border_style.';';
$borderstyle .= 'border-top-color:'.$border_color.';';

//$borderstyle .='height:'; //text color for btm border
$before='<span class="ult_link_top ult_btn9_link_top " style="'.$borderstyle.'"></span>';
$after .='<span class="ult_link_btm  ult_btn9_link_btm" style="'.$borderstyle.'"></span>';

}
else if($link_hover_style=='Style_10'){               //style10
$class .='ult_cl_link_10';
//$id .='ult_cl_link_10';//
if($title_font_size!=''){
//$colorstyle .='font-size:'.$title_font_size.'px;';
}
$borderstyle .='background:'.$border_color.';';
$borderstyle .='height:'.$border_size.'px;';
$span_style .= 'background:'.$background_color.';';
if($border_style!=''){
 $span_style .= 'border-top:'.$border_size.'px '.$border_style.' '.$border_color.';';
}

$span_style1='';
$span_style1 .= 'background:'.$bghovercolor.';';
}
else if($link_hover_style=='Style_11'){
 //style11
$style11_css_class='';
$style11_css_class=$css_class;
$css_class='';
$class .='ult_cl_link_11';
//$id .='ult_cl_link_11';//
$span_style .='background:'.$background_color.';';
$span_style1='';
$span_style1 .= 'background:'.$bghovercolor.';';
$span_style1 .= 'color:'.$text_hovercolor.';';
//$span_style1 .= $secondtitle_style;

//padding
   $ult_style2css=$css_class;
	$css_class='';
	$domain = strstr($css, 'padding');
	$domain=(explode("}",$domain));
	$ult_style11css=$domain[0];

$before='<span class="ult_link_top ult_btn11_link_top " style="'.$span_style1.';'.$ult_style11css.'">'.$text.'</span>';

}
//echo $bghovercolor;
//$text=ucfirst($text);
$text=$text;
if($link_hover_style=='Style_2'){
	$ult_style2css=$css_class;
	$css_class='';

}
	$output='';

	if($link_hover_style!='Style_10'){

			$output .='<span id="'.$creative_link_id.'" class="ult_main_cl '.$is_vc_49_plus.' '.$el_class.' '.$style11_css_class.'" >
	 			<span class="'.$class.'  ult_crlink" >
					<a '.$creative_link_data_list.' href = "'.esc_attr($url).'" '.$target.' class="ult_colorlink ult-responsive '.$css_class .'" style="'.$colorstyle.' "  '.$data_link.' title="'.$alt_text.'">
						'.$before.'
						<span data-hover="'.$text.'" style="'.$title_style.';'.$span_style.';'.$ult_style11css.'" class="ult_btn10_span  '.$ult_style2css.' ">'.$text.'</span>
						'.$after.'
					</a>
				</span>
			</span>';

		}
	  else if($link_hover_style=='Style_10'){

			$output .='<span id="'.$creative_link_id.'" class=" ult_main_cl  '.$el_class.'" >
	 			<span  class="'.$class.'  ult_crlink" id="'.$id.'">
					<a '.$creative_link_data_list.' href = "'.esc_attr($url).'" '.$target.' class="ult_colorlink  ult-responsive "  style="'.$colorstyle.' "  '.$data_link.' title="'.$alt_text.'">
						<span   class="ult_btn10_span  '.$css_class .'" style="'.$span_style.'" data-color="'.$border_color.'"  data-bhover="'.$bghovercolor.'" data-bstyle="'.$border_style.'">
							<span class="ult_link_btm  ult_btn10_link_top" style="'.$span_style1.'">
								<span style="'.$title_style.';color:'.$text_hovercolor.'" class="style10-span">'.$text.'</span>
							</span>
							<span style="'.$title_style.';">'.$text.'</span>
						</span>

					</a>
				</span>
			</span>';
	 	 }
	 	 if($text!=''){
	 	 	$is_preset = false; // Preset setting array display
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
	 	 }
	//return $output;

		}


		function ultimate_createlink()
		{
			if(function_exists('vc_map'))
			{
				vc_map(
					array(
					   "name" => __("Creative Link"),
					   "base" => "ult_createlink",
					   "icon"=>"uvc_creative_link",
					   "category" => __("Ultimate VC Addons","ultimate_vc"),
					   "description" => __("Add a custom link.","ultimate_vc"),
					   "params" => array(
							// Play with icon selector
					   		array(
								"type" => "textfield",
								"class" => "",
								"admin_label" => true,
								"heading" => __("Title", "ultimate_vc"),
								"param_name" => "title",
								"value" => "",
								//"description" => __("Ran out of options? Need more styles? Write your own CSS and mention the class name here.", "ultimate_vc"),
							),
					   		array(
								"type" => "vc_link",
								"class" => "",
								"heading" => __("Link ","ultimate_vc"),
								"param_name" => "btn_link",
								"value" => "",
								"description" => __("Add a custom link or select existing page. You can remove existing link as well.","ultimate_vc"),
								//"group" => "Title Setting",

							),


							/*---typography-------*/

							array(
									"type" => "ult_param_heading",
									"param_name" => "bt1typo-setting",
									"text" => __("Typography", "ultimate"),
									"value" => "",
									"class" => "",
									"group" => "Typography ",
									'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',

								),

							array(
								"type" => "ultimate_google_fonts",
								"heading" => __("Title Font Family", "ultimate_vc"),
								"param_name" => "font_family",
								"description" => __("Select the font of your choice. ","ultimate_vc").", ".__("you can","ultimate_vc")." <a href='admin.php?page=bsf-google-font-manager' target='_blank'>".__("add new in the collection here","ultimate_vc")."</a>.",
								"group" => "Typography ",
								),

							array(
								"type" => "ultimate_google_fonts_style",
								"heading" 		=>	__("Font Style", "ultimate_vc"),
								"param_name"	=>	"heading_style",

								"group" => "Typography ",
							),
							// array(
							// 	"type" => "number",
							// 	"param_name" => "title_font_size",
							// 	"heading" => __("Font size","ultimate_vc"),
							// 	"value" => "",
							// 	"suffix" => "px",
							// 	"group" => "Typography ",
							// ),

							// array(
							// 	"type" => "number",
							// 	"param_name" => "title_line_ht",
							// 	"heading" => __("Line Height","ultimate_vc"),
							// 	"value" => "",
							// 	"suffix" => "px",
							// 	"group" => "Typography ",

							// ),
							array(
		                    "type" => "ultimate_responsive",
		                    "class" => "font-size",
		                    "heading" => __("Font size", 'ultimate_vc'),
		                    "param_name" => "title_font_size",
		                    "unit" => "px",
		                    "media" => array(
		                        "Desktop" => '',
		                        "Tablet" => '',
		                        "Tablet Portrait" => '',
		                        "Mobile Landscape" => '',
		                        "Mobile" => '',
		                    ),
		                    "group" => "Typography ",
		                ),
		                array(
		                    "type" => "ultimate_responsive",
		                    "class" => "",
		                    "heading" => __("Line Height", 'ultimate_vc'),
		                    "param_name" => "title_line_ht",
		                    "unit" => "px",
		                    "media" => array(
		                        "Desktop" => '',
		                        "Tablet" => '',
		                        "Tablet Portrait" => '',
		                        "Mobile Landscape" => '',
		                        "Mobile" => '',
		                    ),
		                    "group" => "Typography ",
		                ),
							/*-----------general------------*/
							array(
								"type" => "dropdown",
								"class" => "",
								"admin_label" => true,
								"heading" => __("Link Style", "ultimate_vc"),
								"param_name" => "link_hover_style",
								"value" => array(
									"None"=> "",
									"Style 1"=> "Style_1",
									"Style 2" => "Style_2",
									"Style 3" => "Style_3",
									"Style 4"=> "Style_4",
									"Style 5" => "Style_5",
									"Style 6" => "Style_6",
									/*"Style 7" => "Style_7",*/
									"Style 7" => "Style_8",
									"Style 8" => "Style_9",
									"Style 9" => "Style_10",
									"Style 10" => "Style_11",
								),
								"description" => __("Select the Hover style for Link.","ultimate_vc"),

							),
							array(
									"type" => "ult_param_heading",
									"param_name" => "button1bg_settng",
									"text" => __("Color Settings", "ultimate_vc"),
									"value" => "",
									"class" => "",
									'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
								),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Link Color", "ultimate_vc"),
								"param_name" => "text_color",
								"value" => "#333333",
								"description" => __("Select text color for Link.", "ultimate_vc"),

							),
							/*array(
								"type" => "chk-switch",
								"class" => "",
								"heading" => __("Hover Effect ", "ultimate_vc"),
								"param_name" => "enable_hover",
								"value" => "",
								"options" => array(
										"enable" => array(
											"label" => "Enable Hover effect?",
											"on" => "Yes",
											"off" => "No",
										)
									),
								/*"description" => __("Enable Hover effect on hover?", "ultimate_vc"),
							"dependency" => Array("element" => "link_hover_style","value" => array("Style_2")),
							),*/
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Link Hover Color", "ultimate_vc"),
								"param_name" => "text_hovercolor",
								"value" => "#333333",
								"description" => __("Select text hover color for Link.", "ultimate_vc"),
								//"dependency" => Array("element" => "link_hover_style","not_empty" => true),

							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Link Background Color", "ultimate_vc"),
								"param_name" => "background_color",
								"value" => "#ffffff",
								"description" => __("Select Background Color for link.", "ultimate_vc"),
								//"group" => "Title Setting",
								"dependency" => Array("element" => "link_hover_style","value" => array("Style_2","Style_10","Style_11")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Link Background Hover Color", "ultimate_vc"),
								"param_name" => "bghovercolor",
								"value" => "",
								"description" => __("Select background hover color for link.", "ultimate_vc"),
								"dependency" => Array("element" => "link_hover_style","value" => array("Style_2","Style_10","Style_11")),

							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Border Style", "ultimate_vc"),
								"param_name" => "border_style",
								"value" => array(
									/*"None"=> " ",*/
									"Solid"=> "solid",
									"Dashed" => "dashed",
									"Dotted" => "dotted",
									"Double" => "double",
									"Inset" => "inset",
									"Outset" => "outset",

								),
								"description" => __("Select the border style for link.","ultimate_vc"),
								"dependency" => Array("element" => "link_hover_style","value" => array("Style_3","Style_4","Style_5","Style_7","Style_8","Style_9","Style_10")),

							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Link Border Color", "ultimate_vc"),
								"param_name" => "border_color",
								"value" => "#333333",
								"description" => __("Select border color for link.", "ultimate_vc"),
								//"dependency" => Array("element" => "border_style", "not_empty" => true),
								"dependency" => Array("element" => "border_style", "value" => array("solid","dashed","dotted","double","inset","outset")),

							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Link Border HoverColor", "ultimate_vc"),
								"param_name" => "border_hovercolor",
								"value" => "#333333",
								"description" => __("Select border hover color for link.", "ultimate_vc"),
								"dependency" => Array(
									"element"=>"link_hover_style","value" => array("Style_8"),
									/*"element" => "border_style",  "not_empty" => true*/ ),

							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Link Border Width", "ultimate_vc"),
								"param_name" => "border_size",
								"value" => 1,
								"min" => 1,
								"max" => 10,
								"suffix" => "px",
								"description" => __("Thickness of the border.", "ultimate_vc"),
								//"dependency" => Array("element" => "border_style", "not_empty" => true),
								"dependency" => Array("element" => "border_style", "value" => array("solid","dashed","dotted","double","inset","outset")),

							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Link Dot Color", "ultimate_vc"),
								"param_name" => "dot_color",
								"value" => "#333333",
								"description" => __("Select color for dots.", "ultimate_vc"),
								"dependency" => Array("element"=>"link_hover_style","value" => array("Style_6")),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Link Alignment", "ultimate_vc"),
								"param_name" => "text_style",
								"value" => array(
									"Center"=> " ",
									"Left"=> "left",
									"Right" => "right",

								),
								"description" => __("Select the text align for link.","ultimate_vc"),
								//"group" => "Typography ",
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
					            'param_name' => 'css',
					            'group' => __( 'Design ', 'ultimate_vc' ),
					            'edit_field_class' => 'vc_col-sm-12 vc_column no-vc-background no-vc-border creative_link_css_editor',
					        ),
						),
					)
				);
			}
		}

	}
}
if(class_exists('AIO_creative_link'))
{

$AIO_creative_link = new AIO_creative_link;

}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_ult_createlink extends WPBakeryShortCode {
    }
}