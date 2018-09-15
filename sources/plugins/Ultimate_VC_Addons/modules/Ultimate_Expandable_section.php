<?php
/*
* Add-on Name: Expandable Section for Visual Composer
* Add-on URI: http://dev.brainstormforce.com
*/
if(!class_exists('AIO_ultimate_exp_section'))
{
	class AIO_ultimate_exp_section

	{
		function __construct()
		{
			add_shortcode('ultimate_exp_section',array($this,'ultimate_exp_section_shortcode'));
			add_action('init',array($this,'ultimate_ultimate_exp_section'));
			add_action( 'wp_enqueue_scripts', array( $this, 'ultimate_exp_scripts') , 1);

		}

		function ultimate_exp_scripts(){
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
			wp_register_style( 'style_ultimate_expsection', plugins_url($css_path.'expandable-section'.$ext.'.css', __FILE__),array(),ULTIMATE_VERSION,FALSE);
			wp_register_script("jquery_ultimate_expsection",plugins_url($js_path."expandable-section".$ext.".js",__FILE__),array('jquery','jquery_ui'),ULTIMATE_VERSION);
			wp_register_script("jquery_ui",plugins_url($js_path."jquery-ui".$ext.".js",__FILE__),array('jquery'),ULTIMATE_VERSION);

		}

		// Shortcode handler function for stats Icon
		function ultimate_exp_section_shortcode($atts ,$content)
		{
			$title=$heading_style=$font_family=$title_font_size=$title_line_ht=$text_color=$text_hovercolor=
			$icon_type=
			$icon=$icon_img=$img_width=$icon_size=$icon_size=$icon_color=
			$icon_hover_color=$icon_style=$icon_color_bg=$icon_color_hoverbg=
			$icon_border_style=$icon_color_border=$icon_color_hoverborder=
			$icon_border_size=$icon_border_radius=$icon_border_spacing=$map_override=
			$icon_align=$el_class=$css_editor='';

			extract(shortcode_atts( array(

				'title'					=>' ',
				'heading_style'			=>' ',
				'font_family'			=>' ',
				'title_font_size'		=>'20',
				'title_line_ht'			=>'20',
				'text_color'			=>'#333333',
				'text_hovercolor'		=>'#333333',
				'icon_type'				=>'selector',
				'icon'					=>'',
				'icon_img'				=>'',
				'img_width'				=>'48',
				'icon_size'				=>'32',
				'icon_color'			=>'#333333',
				'icon_hover_color'		=>'#333333',
				'icon_style'			=>'none',
				'icon_color_bg'			=>'#ffffff',
				'icon_color_hoverbg'	=>'#ecf0f1',
				'icon_border_style' 	=>'solid',
				'icon_color_border' 	=>'#333333',
				'icon_color_hoverborder'=>'#333333',
				'icon_border_size'		=>'1',
				'icon_border_radius'    =>'0',
				'icon_border_spacing'	=>'30',
				'icon_align'			=>'center',
				'extra_class'			=>' ',
				'css'  					=>' ',
				'background_color'      =>'#dbdbdb',
                'bghovercolor'			=>'#e5e5e5',
                'cnt_bg_color'			=>'#dbdbdb',
				'cnt_hover_bg_color'	=>' ',
				'exp_icon'				=>' ',
				'exp_effect'			=>'slideToggle',
				'cont_css'				=>' ',
				'section_width'			=>' ',
				'map_override'			=>'0',
				'new_title'				=>' ',
				'new_icon'				=>' ',
				'new_icon_img'			=>' ',
				'title_active' 			=>'#333333',
				'title_active_bg' 		=>'#dbdbdb',
				'icon_active_color'		=>'#333333',
				'icon_active_color_bg'  =>'#ffffff',
				'title_margin'			=>' ',
				'iconmargin_css'		=>' ',
				'icon_color_activeborder'=>'#333333',
				'title_margin' 			=>' ',
				'title_padding'			=>' ',
				'desc_padding'			=>' ',
				'desc_margin'			=>' ',
				'icon_margin'			=>' ',
				'section_height'   		=>'0',

				),$atts));

				$vc_version = (defined('WPB_VC_VERSION')) ? WPB_VC_VERSION : 0;
				$is_vc_49_plus = (version_compare(4.9, $vc_version, '<=')) ? 'ult-adjust-bottom-margin' : '';

				/*---------- data attribute-----------------------------*/
				//echo $title_margin.$title_padding;
				$data='';
				$data.='data-textcolor="'.$text_color.'"';
				if($text_hovercolor==' '){
					$text_hovercolor=$text_color;
				}

				$data.='data-texthover="'.$text_hovercolor.'"';
				$data.='data-icncolor="'.$icon_color.'"';
				$data.='data-ihover="'.$icon_hover_color.'"';
				$data.='data-height="'.$section_height.'"';

				$data.='data-cntbg="'.$background_color.'"';
				$data.='data-cnthvrbg="'.$bghovercolor.'"';
				$data.='data-headerbg="'.$background_color.'"';
				if($bghovercolor==' '){
					$bghovercolor=$background_color;
				}
				$data.='data-headerhover="'.$bghovercolor.'"';
				$data.='data-title="'.$title.'"';
				if($new_title==' '){
					$new_title=$title;
				}

				$data.='data-newtitle="'.$new_title.'"';
				//echo $new_icon;
				$data.='data-icon="'.$icon.'"';
				//echo $new_icon;
				if($new_icon==' '){
					$new_icon=$icon;
				}
				if($new_icon =='none'){
				 $new_icon=$icon;
				}
				$data.='data-newicon="'.$new_icon.'"';
				/*----active icon --------*/

				if($icon_active_color==''){
					$icon_active_color=$icon_hover_color;
				}
				$data.='data-activeicon="'.$icon_active_color.'"';


				if($icon_style!= 'none'){
					$data.='data-icnbg="'.$icon_color_bg.'"';
					$data.='data-icnhvrbg="'.$icon_color_hoverbg.'"';
					if($icon_active_color_bg==' '){
					$icon_active_color_bg=$icon_color_hoverbg;
					}
					$data.='data-activeiconbg="'.$icon_active_color_bg.'"';

				}
				if($icon_style== 'advanced'){
					$data.='data-icnbg="'.$icon_color_bg.'"';
					$data.='data-icnhvrbg="'.$icon_color_hoverbg.'"';
					$data.='data-icnborder="'.$icon_color_border.'"';
					if($icon_color_hoverborder==' '){
					$icon_color_hoverborder=$icon_color_border;
					}
					$data.='data-icnhvrborder="'.$icon_color_hoverborder.'"';
					if($icon_active_color_bg==' '){
					$icon_active_color_bg=$bghovercolor;
					}
					$data.='data-activeiconbg="'.$icon_active_color_bg.'"';

					if($icon_color_activeborder==' '){
					$icon_color_activeborder=$icnhvrborder;
					}
					$data.='data-activeborder="'.$icon_color_activeborder.'"';

				}
				$data.='data-effect="'.$exp_effect.'"';
				$data.='data-override="'.$map_override.'"';

				/*---active color ----------*/
				if($title_active==''){
					$title_active=$text_hovercolor;
				}
				$data.='data-activetitle="'.$title_active.'"';

				if($title_active_bg==' '){
					$title_active_bg=$bghovercolor;
				}
				$data.='data-activebg="'.$title_active_bg.'"';

				/*----active icon --------*/

				/*if($icon_active_color==''){
					$icon_active_color=$bghovercolor;
				}
				$data.='data-activeicon="'.$icon_active_color.'"';

				if($icon_active_color_bg==''){
					$icon_active_color_bg=$bghovercolor;
				}
				$data.='data-activeicon="'.$icon_active_color_bg.'"';*/


/*------------icon style---------*/
$iconoutput =$newsrc=$src1=$img_ext='';
$style =$css_trans=$iconbgstyle='';
if($icon_type == 'custom'){

				if($icon_img!==''){

				$img = apply_filters('ult_get_img_single', $icon_img, 'url', 'large');

				$newimg=apply_filters('ult_get_img_single', $new_icon_img, 'url', 'large');

				$newsrc=$newimg;
				$src1=$img;
				$alt = apply_filters('ult_get_img_single', $icon_img, 'alt');

				if($icon_style !== 'none'){
					if($icon_color_bg !== '')
						$style .= 'background:'.$icon_color_bg.';';
					//$style .= 'background:transperent;';
				}
				if($icon_style == 'circle'){
					$el_class.= ' uavc-circle ';
					$img_ext.= 'ult_circle ';
				}
				if($icon_style == 'square'){
					$el_class.= ' uavc-square ';
					$img_ext.= 'ult_square ';
				}
				if($icon_style == 'advanced' && $icon_border_style !== '' ){
					$style .= 'border-style:'.$icon_border_style.';';
					$style .= 'border-color:'.$icon_color_border.';';
					$style .= 'border-width:'.$icon_border_size.'px;';
					$style .= 'padding:'.$icon_border_spacing.'px;';
					$style .= 'border-radius:'.$icon_border_radius.'px;';
				}
				if(!empty($img)){

					if($icon_align == 'center') {
						$style .= 'display:inline-block;';
					}
					$iconoutput .= "\n".'<span class="aio-icon-img '.$el_class.' '.'ult_expsection_icon " style="font-size:'.$img_width.'px;'.$style.'" '.$css_trans.'>';
					$iconoutput .= "\n\t".'<img class="img-icon ult_exp_img '.$img_ext.'" alt="'.$alt.'" src="'.apply_filters('ultimate_images', $img).'" />';
					$iconoutput .= "\n".'</span>';
				}
				if(!empty($img)){

				$iconoutput = $iconoutput;
			    }
			    else{
			    	$iconoutput = '';
			    }

			}
		}else {
			if($icon!=='')
			{
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
					$iconoutput .= "\n".'<span class="aio-icon  '.$icon_style.' '.$el_class.' ult_expsection_icon " '.$css_trans.' style="'.$style.'">';
					$iconoutput .= "\n\t".'<i class="'.$icon.' ult_ex_icon"  ></i>';
					$iconoutput .= "\n".'</span>';
				}
				if($icon !== "" && $icon!=="none"){
				$iconoutput = $iconoutput;
			    }
			    else{
			    	$iconoutput = '';
			    }

			}
		}
			if($iconoutput !== ''){
				 //$iconoutput = '<div class="align-icon" style="'.$icon_align_style.'">'.$iconoutput.'</div>';
			}

/*----------- image replace ----------------*/

$data.='data-img="'.$src1.'"';
if($newsrc==''){
	$newsrc=$src1;
}
$data.='data-newimg="'.$newsrc.'"';

/*------------header bg style---------*/

$headerstyle ='';
if($text_color!='')
$headerstyle.='color:'.$text_color.';';
if($background_color!='')
$headerstyle.='background-color:'.$background_color.';';

if (function_exists('get_ultimate_font_family')) {
		$mhfont_family = get_ultimate_font_family($font_family);
		if($mhfont_family!='')
		$headerstyle .= 'font-family:'.$mhfont_family.';';
	}
	if (function_exists('get_ultimate_font_style')) {
		$headerstyle .= get_ultimate_font_style($heading_style);
	}
	// if($title_font_size!=''){
	// 	$headerstyle.='font-size:'.$title_font_size.'px;';
	// }
	// if($title_line_ht!=''){
	// 	$headerstyle.='line-height:'.$title_line_ht.'px;';
	// }
	if (is_numeric($title_font_size)) {
        $title_font_size = 'desktop:'.$title_font_size.'px;';
    }
    if (is_numeric($title_line_ht)) {
        $title_line_ht = 'desktop:'.$title_line_ht.'px;';
    }
    $ult_expandable_id = 'uvc-exp-wrap-'.rand(1000, 9999);
    $ult_expandable_args = array(
                'target' => '#'.$ult_expandable_id. '', // set targeted element e.g. unique class/id etc.
                'media_sizes' => array(
                    'font-size' => $title_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
                   	'line-height' => $title_line_ht
                ),
            );
	$data_list = get_ultimate_vc_responsive_media_css($ult_expandable_args);
$headerstyle.=$title_margin;
$headerstyle.=$title_padding;

/*---------------title padding---------------------*/
 $css_class='';
 $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), "ultimate_exp_section", $atts );
 $css_class = esc_attr( $css_class );

 /*---------------desc padding---------------------*/
 $desc_css_class='';
 $desc_css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $cont_css, ' ' ), "ultimate_exp_section", $atts );
 $desc_css_class = esc_attr( $desc_css_class );


/*---------------desc padding---------------------*/
 $icon_css_class='';
 $icon_css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $iconmargin_css, ' ' ), "ultimate_exp_section", $atts );
 $icon_css_class = esc_attr( $icon_css_class);

 /*--------------------- full width row settings---------------------*/
 //echo $map_override;

/*------------content style--------------------------*/
$cnt_style ='';

if($cnt_bg_color!='')
$cnt_style .= 'background-color:'.$cnt_bg_color.';';
	//$cnt_style .= 'background-color:'.$bghovercolor.';';
$cnt_style .= $desc_padding;
$cnt_style .= $desc_margin;

$position='';
if($icon_align=='left'){
	$position='ult_expleft_icon';
}
if($icon_align=='right'){
	$position='ult_expright_icon';
}
$top='';
$output='';
$icon_output='';
$text_align='';
if($icon_align=='top'){
	if($icon_type == 'custom'){
	$text_align .='text-align:center;';
	}
	else{
	$text_align .='text-align:center;';
	}
//text_align .='text-align:center';

}
$text_align.=$icon_margin;

if($iconoutput!=''){
	$icon_output='	<div class="ult-just-icon-wrapper ult_exp_icon">
					<div class="align-icon '.$icon_css_class.'" style="text-align:'.$icon_align.';'.$text_align.'">
						'.$iconoutput.'
					</div>
				</div>';
}
//echo $icon;
if(empty($iconoutput) || $iconoutput==' '){
	//echo"dhgfhj";
 		$icon_output='';
 	}
 	$section_style=' ';
if($section_width !==' '){
	$section_style='max-width:'.$section_width.'px;';
}

$output.='<div class="ult_exp_section_layer '.$is_vc_49_plus.' '.$extra_class.'" >
	<div id="'.$ult_expandable_id.'"  '.$data_list.' class="ult_exp_section  ult-responsive '.$css_class .'" style="'.$headerstyle.'" '.$data.'>';

		if($icon_align=='left'){
			$output.='<div class="ult_exp_section-main '.$position.'">'.$icon_output.'
				<div class="ult_expheader" align="'.$icon_align.'" >'.$title.'
				</div>
			</div>
		</div>';
		}
		else if($icon_align=='top'){
		$output.='<div class="ult_exp_section-main '.$position.'">
						'.$icon_output.'
						<div class="ult_expheader" align="center" >'.$title.'
						 </div></div>
				</div>';

		}else{

		$output.='<div  class="ult_exp_section-main '.$position.'">
					<div class="ult_expheader" align="'.$icon_align.'" >'.$title.'
					 </div>'.$icon_output.'</div>
				</div>';
		}
		if($content!=''){
		$output.='<div class="ult_exp_content '.$desc_css_class.'" style="'.$cnt_style.'">';

		$output.='<div class="ult_ecpsub_cont" style="'.$section_style.'" >';
		$output.=	do_shortcode($content);
		$output.='</div>';
		}
		//<!--end of ult_ecpsub_cont-->
		$output.='</div>

			</div>';
	//<!--end of exp_content-->

	 if($title!=' '|| $new_title!=' '){
	  	return $output;
	  }



		}


		function ultimate_ultimate_exp_section()
		{
			if(function_exists('vc_map'))
			{
				vc_map(
					array(
					    "name" => __("Expandable Section"),
					    "base" => "ultimate_exp_section",
					    "icon"=> "uvc_expandable",
					    "class" => "uvc_expandable",
					    "as_parent" => array('except' => 'ultimate_exp_section'),
					    "category" => __("Ultimate VC Addons","ultimate_vc"),
					    "description" => __("Add a Expandable Section.","ultimate_vc"),
					    "content_element" => true,
					    'front_enqueue_css' => plugins_url('../assets/css/expandable-section.css', __FILE__),
					    "front_enqueue_js"=>plugins_url("../assets/js/expandable-section.js",__FILE__),
						"controls" => "full",
						"show_settings_on_create" => true,
						//"is_container"    => true,
					    "params" => array(
							// Play with icon selector
					   		array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Title ","ultimate_vc"),
								"param_name" => "title",
								"value" => "",
								//"description" => __("Add a custom link or select existing page. You can remove existing link as well.","ultimate_vc"),
								//"group" => "Title Setting",

							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Title After Click ","ultimate_vc"),
								"param_name" => "new_title",
								"value" => "",
								"description" => __("Keep empty if you want to dispaly same title as previous.","ultimate_vc"),
								//"group" => "Title Setting",

							),


							/*-----------general------------*/

							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Title Color", "ultimate_vc"),
								"param_name" => "text_color",
								"value" => "",
								//"description" => __("Select text color for Link.", "ultimate_vc"),
								"group" => "Color",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Title Background Color", "ultimate_vc"),
								"param_name" => "background_color",
								"value" => "",
								"group" => "Color",
								"edit_field_class" => "vc_col-sm-12 vc_column ult_space_border",

							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Title Hover Color", "ultimate_vc"),
								"param_name" => "text_hovercolor",
								"value" => "",
								"group" => "Color",
							),

							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Title Hover Background Color", "ultimate_vc"),
								"param_name" => "bghovercolor",
								"value" => "",
								"group" => "Color",
								"edit_field_class" => "vc_col-sm-12 vc_column ult_space_border",

							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Title Active Color", "ultimate_vc"),
								"param_name" => "title_active",
								"value" => "",
								"group" => "Color",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Title Active Background Color", "ultimate_vc"),
								"param_name" => "title_active_bg",
								"value" => "",
								"group" => "Color",
								"edit_field_class" => "vc_col-sm-12 vc_column ult_space_border",

							),
							/*--container bg color---*/
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Content Background Color", "ultimate_vc"),
								"param_name" => "cnt_bg_color",
								"value" => "",
								"group" => "Color",

							),

							/*---icon---*/
							array(
									"type" => "ult_param_heading",
									"param_name" => "btn1_icon_setting",
									"text" => __("Icon / Image ", "ultimate_vc"),
									"value" => "",
									"class" => "",
									"group" => __("Icon","ultimate_vc"),
									'edit_field_class' => 'ult-param-heading-wrapper  vc_column vc_col-sm-12',
								),

							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Icon to display", "ultimate_vc"),
								"param_name" => "icon_type",
								"value" => array(
									"Font Icon Manager" => "selector",
									"Custom Image Icon" => "custom",
								),
								"description" => __("Use existing font icon or upload a custom image.", "ultimate_vc"),
								"group" => __("Icon","ultimate_vc"),
							),

							array(
								"type" => "icon_manager",
								"class" => "",
								"heading" => __("Select Icon ","ultimate_vc"),
								"param_name" => "icon",
								"value" => "",
								"description" => __("Click and select icon of your choice. If you can't find the one that suits for your purpose","ultimate_vc").", ".__("you can","ultimate_vc")." <a href='admin.php?page=bsf-font-icon-manager' target='_blank'>".__("add new here","ultimate_vc")."</a>.",
								"dependency" => Array("element" => "icon_type","value" => array("selector")),
								"group" => __("Icon","ultimate_vc"),
							),
							array(
								"type" => "ult_img_single",
								"class" => "",
								"heading" => __("Upload Image Icon:", "ultimate_vc"),
								"param_name" => "icon_img",
								//"admin_label" => true,
								"value" => "",
								"description" => __("Upload the custom image icon.", "ultimate_vc"),
								"dependency" => Array("element" => "icon_type","value" => array("custom")),
								"group" => __("Icon","ultimate_vc"),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Image Width", "ultimate_vc"),
								"param_name" => "img_width",
								"value" =>"",
								"min" => 16,
								"max" => 512,
								"suffix" => "px",
								"description" => __("Provide image width", "ultimate_vc"),
								"dependency" => Array("element" => "icon_type","value" => array("custom")),
								"group" => __("Icon","ultimate_vc"),
							),
							array(
									"type" => "ult_param_heading",
									"param_name" => "btn1_icon_setting",
									"text" => __(" ", "ultimate_vc"),
									"value" => "",
									"class" => "",
									"group" => __("Icon","ultimate_vc"),
									'edit_field_class' => 'ult-param-heading-wrapper  vc_column vc_col-sm-12',
								),
							array(
								"type" => "icon_manager",
								"class" => "",
								"heading" => __("Select Icon For On Click ","ultimate_vc"),
								"param_name" => "new_icon",
								"value" => "",
								"description" => __("Click and select icon of your choice. If you can't find the one that suits for your purpose","ultimate_vc").", ".__("you can","ultimate_vc")." <a href='admin.php?page=bsf-font-icon-manager' target='_blank'>".__("add new here","ultimate_vc")."</a>.",
								"dependency" => Array("element" => "icon_type","value" => array("selector")),
								"group" => __("Icon","ultimate_vc"),
							),
							array(
								"type" => "ult_img_single",
								"class" => "",
								"heading" => __("Upload Image On Click:", "ultimate_vc"),
								"param_name" => "new_icon_img",
								//"admin_label" => true,
								"value" => "",
								"description" => __("Upload the custom image icon.", "ultimate_vc"),
								"dependency" => Array("element" => "icon_type","value" => array("custom")),
								"group" => __("Icon","ultimate_vc"),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Icon / Image Position", "ultimate_vc"),
								"param_name" => "icon_align",
								"value" => array(
									"Bottom"	=>	"",
									"Top"		=>	"top",
									"Left"		=>	"left",
									"Right"		=>	"right"
								),
								"group" => __("Icon","ultimate_vc"),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Size of Icon", "ultimate_vc"),
								"param_name" => "icon_size",
								"value" => "",
								"min" => 12,
								"max" => 72,
								"suffix" => "px",
								"description" => __("How big would you like it?", "ultimate_vc"),
								"dependency" => Array("element" => "icon_type","value" => array("selector")),
								"group" => __("Icon","ultimate_vc"),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon Color", "ultimate_vc"),
								"param_name" => "icon_color",
								"value" => "",
								"dependency" => Array("element" => "icon_type","value" => array("selector")),
								"group" => __("Icon","ultimate_vc"),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon Hover Color", "ultimate_vc"),
								"param_name" => "icon_hover_color",
								"value" => "",
								"dependency" => Array("element" => "icon_type","value" => array("selector")
													),
								"group" => __("Icon","ultimate_vc"),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon Active Color", "ultimate_vc"),
								"param_name" => "icon_active_color",
								"value" => "",
								"dependency" => Array("element" => "icon_type","value" => array("selector")	),
								"group" => __("Icon","ultimate_vc"),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Icon / Image Style", "ultimate_vc"),
								"param_name" => "icon_style",
								"value" => array(
									"Simple" => "none",
									"Circle Background" => "circle",
									"Square Background" => "square",
									"Design your own" => "advanced",
								),
								"description" => __("We have given three quick preset if you are in a hurry. Otherwise, create your own with various options.", "ultimate_vc"),
								"group" => __("Icon","ultimate_vc"),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon / Image Background Color ", "ultimate_vc"),
								"param_name" => "icon_color_bg",
								"value" => "",
								"dependency" => Array("element" => "icon_style", "value" => array("circle","square","advanced")),
								"group" => __("Icon","ultimate_vc"),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon / Image Hover Background Color ", "ultimate_vc"),
								"param_name" => "icon_color_hoverbg",
								"value" => "",
								"dependency" => Array("element" => "icon_style", "value" => array("circle","square","advanced")
									),
								"group" => __("Icon","ultimate_vc"),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon / Image Active Background Color ", "ultimate_vc"),
								"param_name" => "icon_active_color_bg",
								"value" => "",
								"dependency" => Array("element" => "icon_style", "value" => array("circle","square","advanced")),
								"group" => __("Icon","ultimate_vc"),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Icon / Image Border Style", "ultimate_vc"),
								"param_name" => "icon_border_style",
								"value" => array(
									"Solid"=> "",
									/*"None"=> "",*/
									"Dashed" => "dashed",
									"Dotted" => "dotted",
									"Double" => "double",
									"Inset" => "inset",
									"Outset" => "outset",
								),
								"description" => __("Select the border style for icon.","ultimate_vc"),
								"dependency" => Array("element" => "icon_style", "value" => array("advanced")),
								"group" => __("Icon","ultimate_vc"),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon / Image Border Color", "ultimate_vc"),
								"param_name" => "icon_color_border",
								"value" => "",
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
								"group" => __("Icon","ultimate_vc"),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon / Image Hover Border Color", "ultimate_vc"),
								"param_name" => "icon_color_hoverborder",
								"value" => "",
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
								"group" => __("Icon","ultimate_vc"),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon / Image Active Border Color", "ultimate_vc"),
								"param_name" => "icon_color_activeborder",
								"value" => "",
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
								"group" => __("Icon","ultimate_vc"),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Icon / Image Border Width", "ultimate_vc"),
								"param_name" => "icon_border_size",
								"value" => "",
								"min" => 1,
								"max" => 10,
								"suffix" => "px",
								"description" => __("Thickness of the border.", "ultimate_vc"),
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
								"group" => __("Icon","ultimate_vc"),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Icon / Image Border Radius", "ultimate_vc"),
								"param_name" => "icon_border_radius",
								"value" =>"",
								"min" => 1,
								"max" => 100,
								"suffix" => "px",
								"description" => __("0 pixel value will create a square border. As you increase the value, the shape convert in circle slowly. (e.g 500 pixels).", "ultimate_vc"),
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
								"group" => __("Icon","ultimate_vc"),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Background Size", "ultimate_vc"),
								"param_name" => "icon_border_spacing",
								"value" => "",
								"min" => 2,
								"max" => 100,
								"suffix" => "px",
								"description" => __("Spacing from center of the icon till the boundary of border / background", "ultimate_vc"),
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
								"group" => __("Icon","ultimate_vc"),

							),


							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Effect ", "ultimate_vc"),
								"param_name" => "exp_effect",
								"value" => array(
									"Slide" => "",
									"Fade" => "fadeToggle",

								),

							),

							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Custom CSS Class", "ultimate_vc"),
								"param_name" => "extra_class",
								"value" => "",
								"description" => __("Ran out of options? Need more styles? Write your own CSS and mention the class name here.", "ultimate_vc"),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Expandable Section Width Override", "ultimate_vc"),
								"param_name" => "map_override",
								"value" =>array(
									"Default Width"=>"0",
									"Apply 1st parent element's width"=>"1",
									"Apply 2nd parent element's width"=>"2",
									"Apply 3rd parent element's width"=>"3",
									"Apply 4th parent element's width"=>"4",
									"Apply 5th parent element's width"=>"5",
									"Apply 6th parent element's width"=>"6",
									"Apply 7th parent element's width"=>"7",
									"Apply 8th parent element's width"=>"8",
									"Apply 9th parent element's width"=>"9",
									"Full Width "=>"full",
									"Maximum Full Width"=>"ex-full",
								),
								"description" => __("By default, the section will be given to the Visual Composer row. However, in some cases depending on your theme's CSS - it may not fit well to the container you are wishing it would. In that case you will have to select the appropriate value here that gets you desired output..", "ultimate_vc"),
								'group' => __( 'Design ', 'ultimate_vc' ),
								),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Content Width", "ultimate_vc"),
								"param_name" => "section_width",
								"value" => '',
								"min" => 200,
								"max" => 1200,
								"suffix" => "px",
								"description" => __("Adjust width of your content. Keep empty for full width.", "ultimate_vc"),
								'group' => __( 'Design ', 'ultimate_vc' ),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Top Gutter Position", "ultimate_vc"),
								"param_name" => "section_height",
								"value" => '',
								"min" => 0,
								"max" => 1200,
								"suffix" => "px",
								"description" => __("After click distance between viewport top & expandable section.", "ultimate_vc"),
								'group' => __( 'Design ', 'ultimate_vc' ),
							),
							array(
									"type" => "ult_param_heading",
									"param_name" => "title-setting",
									"text" => __("Title ", "ultimate"),
									"value" => "",
									"class" => "",
									 'group' => __( 'Design ', 'ultimate_vc' ),
									'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',

								),
						/*	array(
					            'type' => 'css_editor',
					            'heading' => __( ' ', 'ultimate_vc' ),
					            'param_name' => 'css',
					            'group' => __( 'Design ', 'ultimate_vc' ),
					           // 'edit_field_class' => 'vc_col-sm-12 vc_column no-vc-background no-vc-lineborder',
					            'edit_field_class' => 'vc_col-sm-12 vc_column no-vc-background no-vc-border',
					        ),*/
							array(
						            "type" => "ultimate_spacing",
						            "heading" => " Title Margin ",
						            "param_name" => "title_margin",
						            "mode"  => "margin",                    //  margin/padding
						            "unit"  => "px",                        //  [required] px,em,%,all     Default all
						            "positions" => array(                   //  Also set 'defaults'
						              	"Top" => "",
						              	"Right" => "",
						              	"Bottom" => "",
						              	"Left" => "",
						            ),
									 'group' => __( 'Design ', 'ultimate_vc' ),
									 "description" => __("Add spacing from outside to titlebar.", "ultimate_vc"),
						        ),
							array(
						            "type" => "ultimate_spacing",
						            "heading" => " Title Padding ",
						            "param_name" => "title_padding",
						            "mode"  => "padding",                    //  margin/padding
						            "unit"  => "px",                        //  [required] px,em,%,all     Default all
						            "positions" => array(                   //  Also set 'defaults'
						              	"Top" => "",
						              	"Right" => "",
						              	"Bottom" => "",
						              	"Left" => "",
						            ),
									 'group' => __( 'Design ', 'ultimate_vc' ),
									 "description" => __("Add spacing from inside to titlebar.", "ultimate_vc"),
							      ),
					        array(
									"type" => "ult_param_heading",
									"param_name" => "title-setting",
									"text" => __("Content ", "ultimate"),
									"value" => "",
									"class" => "",
									 'group' => __( 'Design ', 'ultimate_vc' ),
									'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',


								),

							array(
						            "type" => "ultimate_spacing",
						            "heading" => " Content Margin ",
						            "param_name" => "desc_margin",
						            "mode"  => "margin",                    //  margin/padding
						            "unit"  => "px",                        //  [required] px,em,%,all     Default all
						            "positions" => array(                   //  Also set 'defaults'
						              	"Top" => "",
						              	"Right" => "",
						              	"Bottom" => "",
						              	"Left" => "",
						            ),
									 'group' => __( 'Design ', 'ultimate_vc' ),
									 "description" => __("Add spacing from outside to content.", "ultimate_vc"),
						        ),
							array(
						            "type" => "ultimate_spacing",
						            "heading" => " Content Padding ",
						            "param_name" => "desc_padding",
						            "mode"  => "padding",                    //  margin/padding
						            "unit"  => "px",                        //  [required] px,em,%,all     Default all
						            "positions" => array(                   //  Also set 'defaults'
						              	"Top" => "",
						              	"Right" => "",
						              	"Bottom" => "",
						              	"Left" => "",
						            ),
									 'group' => __( 'Design ', 'ultimate_vc' ),
									 "description" => __("Add spacing from inside to content.", "ultimate_vc"),
							      ),
					        array(
									"type" => "ult_param_heading",
									"param_name" => "icn-setting",
									"text" => __("Icon ", "ultimate"),
									"value" => "",
									"class" => "",
									 'group' => __( 'Design ', 'ultimate_vc' ),
									'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',


								),

							array(
						            "type" => "ultimate_spacing",
						            "heading" => " Icon Margin ",
						            "param_name" => "icon_margin",
						            "mode"  => "margin",                    //  margin/padding
						            "unit"  => "px",                        //  [required] px,em,%,all     Default all
						            "positions" => array(                   //  Also set 'defaults'
						              	"Top" => "",
						              	"Right" => "",
						              	"Bottom" => "",
						              	"Left" => "",
						            ),
									 'group' => __( 'Design ', 'ultimate_vc' ),
									 "description" => __("Add spacing to icon.", "ultimate_vc"),
						        ),


					        /*---typography-------*/

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
							array(
                                "type" => "ultimate_responsive",
                                "class" => "",
                                "heading" => __("Font size", 'ultimate_vc'),
                                "param_name" => "title_font_size",
                                "unit" => "px",
                                "media" => array(
                                    /*"Large Screen"      => '',*/
                                    "Desktop" => '',
                                    "Tablet" => '',
                                    "Tablet Portrait" => '',
                                    "Mobile Landscape" => '',
                                    "Mobile" => '',
                                ),
                                "group" => "Typography ",
                            ),

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
                                "class" => "",
                                "heading" => __("Line Height", 'ultimate_vc'),
                                "param_name" => "title_line_ht",
                                "unit" => "px",
                                "media" => array(
                                    /*"Large Screen"      => '',*/
                                    "Desktop" => '',
                                    "Tablet" => '',
                                    "Tablet Portrait" => '',
                                    "Mobile Landscape" => '',
                                    "Mobile" => '',
                                ),
                                "group" => "Typography ",
                            ),
						),
					"js_view" => 'VcColumnView'
					)

				);
			}
		}

	}
}
if(class_exists('AIO_ultimate_exp_section'))
{

$AIO_ultimate_exp_section = new AIO_ultimate_exp_section;

}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_ultimate_exp_section extends WPBakeryShortCodesContainer {
		}
	}
