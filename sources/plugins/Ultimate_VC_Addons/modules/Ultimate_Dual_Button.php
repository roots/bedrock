<?php
/*
* Add-on Name: Just Dual Button for Visual Composer
* Add-on URI: http://dev.brainstormforce.com
*/
//error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
if(!class_exists('AIO_Dual_Button'))
{
	class AIO_Dual_Button
	{
		function __construct()
		{
			add_shortcode('ult_dualbutton',array($this,'ultimate_dualbtn_shortcode'));
			add_action('init',array($this,'ultimate_dual_button'));
			add_action( 'wp_enqueue_scripts', array( $this, 'dualbutton_scripts') );
			add_action( 'admin_enqueue_scripts', array( $this, 'dualbutton_backend_scripts') );
		}
		function dualbutton_backend_scripts($hook){
			if($hook == "post.php" || $hook == "post-new.php"){
				$bsf_dev_mode = bsf_get_option('dev_mode');
				if($bsf_dev_mode === 'enable') {
					wp_register_script("jquery_dualbtn_new",plugins_url("../admin/js/dualbtnbackend.js ",__FILE__),array('jquery'),ULTIMATE_VERSION);
					wp_enqueue_script('jquery_dualbtn_new');
				}
			}
		}

		//enque script
		function dualbutton_scripts(){
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
			wp_register_style( 'ult-dualbutton', plugins_url($css_path.'dual-button'.$ext.'.css', __FILE__) );
			wp_register_script("jquery.dualbtn",plugins_url($js_path."dual-button".$ext.".js",__FILE__),array('jquery'),ULTIMATE_VERSION);

			if(isset($_SERVER['HTTP_REFERER'])){
				$params = parse_url($_SERVER['HTTP_REFERER']);
			$vc_is_inline = false;
			if(isset($params['query'])){
				parse_str($params['query'],$params);
				$vc_is_inline = isset($params['vc_action']) ? true : false;
			}

			if($vc_is_inline){
				//echo $vc_is_inline;
					wp_enqueue_style( 'ult-dualbutton', plugins_url($css_path.'dual-button'.$ext.'.css', __FILE__) );
					wp_enqueue_script("jquery.dualbtn",plugins_url($js_path."dual-button".$ext.".js",__FILE__),array('jquery'),ULTIMATE_VERSION);
				}
			}



			}



		// Shortcode handler function for stats Icon
		function ultimate_dualbtn_shortcode($atts)
		{

$button1_text= $icon_type = $icon = $icon_img = $img_width = $icon_size = $icon_color = $icon_hover_color = $icon_style = $icon_color_bg ='';
$icon_border_style= $icon_color_border = $icon_border_size = $icon_border_radius = $icon_border_spacing = $icon_link = $icon_align = $btn1_background_color = $btn1_bghovercolor = $btn2_font_family = $btn2_heading_style = $btn1_text_color = $btn1_text_hovercolor = '';
$button2_text = $btn_icon_type = $btn_icon = $btn_icon_img = $btn_img_width = $btn_icon_size =
$btn_icon_color = $btn_icon_style = $btn_icon_color_bg = $btn_icon_border_style = $btn_icon_color_border =
$btn_icon_border_size = $btn_icon_border_radius = $btn_icon_border_spacing =  $btn_icon_link = $btn2_icon_align =
$btn2_background_color = $btn2_bghovercolor = $btn2_font_family = $btn2_heading_style = $btn2_text_color =
$btn2_text_hovercolor = '';
$divider_style = $divider_text = $divider_text_color = $divider_bg_color = $divider_icon = $divider_icon_img = $btn_border_style = $btn_color_border = $btn_border_size = $btn_border_radius = $btn_hover_style = $title_font_size = $title_line_ht = $el_class = '';

	extract(shortcode_atts( array(

			/*--------btn1-----------*/
				'button1_text' => '',
				'icon_type' => 'selector',
				'icon' => '',
				'icon_img' => '',
				'img_width' => '',
				'icon_size' => '32',
				'icon_color' => '#333333',
				'icon_hover_color' =>'#333333',
				'icon_style' => 'none',
				'icon_color_bg' => '#ffffff',
				'icon_border_style' => '',
				'icon_color_border' => '#333333',
				'icon_border_size' => '1',
				'icon_border_radius' => '0',
				'icon_border_spacing' => '30',
				'icon_link' => '',
				'icon_align' => 'left',
				'btn1_background_color'=>'#ffffff',
				'btn1_bghovercolor' => '#bcbcbc',
				'btn1_font_family' => '',
				'btn1_heading_style' => '',
				'btn1_text_color' => '#333333',
				'btn1_text_hovercolor'=>'#333333',
				'icon_color_hoverbg'=>'#ecf0f1',
				'icon_color_hoverborder'=>'#333333',
				'btn1_padding'=>'',

				/*--------btn2-----------*/
				'button2_text' => '',
				'btn_icon_type' => 'selector',
				'btn_icon' => '',
				'btn_icon_img' => '',
				'btn_img_width' => '48',
				'btn_icon_size' => '32',
				'btn_icon_color' => '#333333',
				'btn_iconhover_color'=>'#333333',
				'btn_icon_style' => 'none',
				'btn_icon_color_bg' => '#ffffff',
				'icon_color_bg' => '#ffffff',
				'btn_icon_border_style' => '',
				'btn_icon_color_border' => '#333333',
				'btn_icon_border_size' => '1',
				'btn_icon_border_radius' => '1',
				'btn_icon_border_spacing' => '30',
				'btn_icon_link' => '',
				'btn2_icon_align' => 'right',
				'btn2_background_color'=>'#ffffff',
				'btn2_bghovercolor' => '#bcbcbc',
				'btn2_font_family' => '',
				'btn2_heading_style' => '',
				'btn2_text_color' => '#333333',
				'btn2_text_hovercolor'=>'#333333',
				'btn_icon_color_hoverbg'=>'#ffffff',
				'btn_icon_color_hoverborder'=>'#333333',
				'btn2_padding'=>'',

				/*--------divider-----------*/

				'divider_style' => 'text',
				'divider_text' => 'or',
				'divider_text_color' => '#ffffff',
				'divider_bg_color' => '#333333',
				'divider_icon' => '',
				'divider_icon_img' => '',
				'divider_border_radius'=>'',
				'divider_border_size'=>'1',
				'divider_color_border'=>'#e7e7e7',
				'divider_border_style'=>'',

				/*--------general-----------*/

				'btn_border_style' => '',
				'btn_color_border'=>'#333333',
				'btn_border_size' => '1',
				'btn_border_radius' => '',
				'btn_hover_style' => 'Style 1',
				'title_font_size' => '15',
				'title_line_ht' => '15',
				'el_class' => '',
				'btn_alignment'=>'center',
				'btn_width'=>'',
				'dual_resp' =>'on',
				'css_dualbtn_design' => '',
				//'btn_resp_width'=>'',
				//'btn_color_hoverborder'=>' ',

			),$atts));

			$vc_version = (defined('WPB_VC_VERSION')) ? WPB_VC_VERSION : 0;
			$is_vc_49_plus = (version_compare(4.9, $vc_version, '<=')) ? 'ult-adjust-bottom-margin' : '';

			$extraclass=$el_class;
			$el_class1=$css_trans=$button2_bstyle=$button1_bstyle=$target1=$url1=$btn_color_hoverborder='';
			$iconoutput= $style = $link_sufix = $link_prefix = $target = $href = $icon_align_style = '';
			$secicon=$style1= $dual_design_style_css ='';
			 $dual_design_style_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css_dualbtn_design, ' ' ), "ult_dualbutton", $atts );
			 $dual_design_style_css = esc_attr( $dual_design_style_css );

			if($icon_link !== ''){
				 $href = vc_build_link($icon_link);
				$target =(isset($href['target'])) ? "target='".$href['target']."'" :'';
				$target = str_replace(' ', '', $target);
				 $url1=$href['url'];
				if($url1==''){
					$url1="javascript:void(0);";
				}
				//echo $url1;
			}
			else{
				$url1="javascript:void(0);";
			}

			if($icon_type == 'custom'){
				if($icon_img!==''){
				$img = apply_filters('ult_get_img_single', $icon_img, 'url');
				$alt = apply_filters('ult_get_img_single', $icon_img, 'alt');
				if($icon_style !== 'none'){
					if($icon_color_bg !== '')
						$style .= 'background:'.$icon_color_bg.';';
					//$style .= 'background:transperent;';
				}
				if($icon_style == 'circle'){
					$el_class.= ' uavc-circle ';
				}
				if($icon_style == 'square'){
					$el_class.= ' uavc-square ';
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
						//$style .= 'display:inline-block;';
					}
					$iconoutput .= "\n".'<span class="aio-icon-img '.$el_class.' '.'btn1icon " style="font-size:'.$img_width.'px;'.$style.'" '.$css_trans.'>';
					$iconoutput .= "\n\t".'<img class="img-icon dual_img" alt="'.$alt.'" src="'.apply_filters('ultimate_images', $img).'" />';
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
					$iconoutput .= "\n".'<span class="aio-icon btn1icon '.$icon_style.' '.$el_class.'" '.$css_trans.' style="'.$style.'">';
					$iconoutput .= "\n\t".'<i class="'.$icon.'" ></i>';
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



$style2=$href1 =$target2=$img2=$alt1 =$iconoutput2=$url2='';
/*---- for icon 2--------------*/
		if($btn_icon_link !== ''){
						 $href1 = vc_build_link($btn_icon_link);
						$target1 =(isset($href1['target'])) ? "target='".$href1['target']."'" :'';
						// $link_prefix .= '<a class="aio-tooltip " href = "'.$href1['url'].'" '.$target1.' data-toggle="tooltip" data-placement="'.$tooltip_disp.'" title="'.$tooltip_text.'">';
						// $link_sufix .= '</a>';
						$target1 = str_replace(' ', '', $target1);
						$url2=$href1['url'];
						if($url2==''){
							$url2="javascript:void(0);";
						}
					}
					else{
				$url2="javascript:void(0);";
			}

if($btn_icon_type == 'custom'){
				$img2 = apply_filters('ult_get_img_single', $btn_icon_img, 'url');
				$alt2 = apply_filters('ult_get_img_single', $btn_icon_img, 'alt');
				if($btn_icon_style !== 'none'){
					if($btn_icon_color_bg !== '')
						$style2 .= 'background:'.$btn_icon_color_bg.';';
					//$style2 .= 'background:transperent;';
				}

				if($btn_icon_style == 'square'){
					$el_class1.= ' uavc-square ';
				}
				if($btn_icon_style == 'circle'){
					$el_class1.= ' uavc-circle ';
				}
				if($btn_icon_style == 'advanced' && $btn_icon_border_style !== '' ){
					$style2 .= 'border-style:'.$btn_icon_border_style.';';
					$style2 .= 'border-color:'.$btn_icon_color_border.';';
					$style2 .= 'border-width:'.$btn_icon_border_size.'px;';
					$style2 .= 'padding:'.$btn_icon_border_spacing.'px;';
					$style2 .= 'border-radius:'.$btn_icon_border_radius.'px;';
				}
				if(!empty($img2)){
					if($btn_icon_link == '' || $btn2_icon_align == 'center') {
						//$style .= 'display:inline-block;';
					}
					$iconoutput2 .= "\n".'<span class="aio-icon-img '.$el_class1.' btn1icon" style="font-size:'.$btn_img_width.'px;'.$style2.'" '.$css_trans.'>';
					$iconoutput2 .= "\n\t".'<img class="img-icon dual_img" alt="'.$alt2.'" src="'.apply_filters('ultimate_images', $img2).'" />';
					$iconoutput2 .= "\n".'</span>';
				}
				if(!empty($img2)){
					$iconoutput2 = $iconoutput2;
				}
				else{
					$iconoutput2 = '';
				}
			} else {
				if($btn_icon_color !== '')
					$style2 .= 'color:'.$btn_icon_color.';';
				if($btn_icon_style !== 'none'){
					if($btn_icon_color_bg !== '')
						$style2 .= 'background:'.$btn_icon_color_bg.';';
				}
				if($btn_icon_style == 'advanced'){
					$style2 .= 'border-style:'.$btn_icon_border_style.';';
					$style2 .= 'border-color:'.$btn_icon_color_border.';';
					$style2 .= 'border-width:'.$btn_icon_border_size.'px;';
					$style2 .= 'width:'.$btn_icon_border_spacing.'px;';
					$style2 .= 'height:'.$btn_icon_border_spacing.'px;';
					$style2 .= 'line-height:'.$btn_icon_border_spacing.'px;';
					$style2 .= 'border-radius:'.$btn_icon_border_radius.'px;';
				}
				//echo $btn_icon_size;
				if($btn_icon_size !== ''){
					$style2 .='font-size:'.$btn_icon_size.'px;';
				}

				if($btn2_icon_align !== 'left'){
					$style2 .= 'display:inline-block;';
				}
				if($btn_icon !== ""){
					$iconoutput2 .= "\n".'<span class="aio-icon btn1icon '.$btn_icon_style.' '.$el_class1.'" '.$css_trans.' style="'.$style2.'">';
					$iconoutput2 .= "\n\t".'<i class="'.$btn_icon.'" ></i>';
					$iconoutput2 .= "\n".'</span>';
				}
				if($btn_icon !== "" && $btn_icon!=="none"){
					$iconoutput2 = $iconoutput2;
				}
				else{

					$iconoutput2 = '';
				}
			}
			if($icon_align_style !== ''){
				 //$iconoutput = '<div class="align-icon" style="'.$icon_align_style.'">'.$iconoutput.'</div>';
			}


$hstyle=$hoverstyle='';
 $btn_hover_style;
if($btn_hover_style=='Style 1'){
	$hoverstyle='ult-dual-btn';
}
if($btn_hover_style==''){
	$hoverstyle='ult-dual-btn';

}
if($btn_hover_style=='Style 2'){
	$hoverstyle='ult-dual-btn3';

}
if($btn_hover_style=='Style 3'){
	$hoverstyle='ult-dual-btn4';

}

/*--------css for title1------------*/
 $btn1_padding;
 $dual_btn_id = 'dualbtn-'.rand(1000, 9999);
$title1_style='';
if (function_exists('get_ultimate_font_family')) {
		$mhfont_family = get_ultimate_font_family($btn1_font_family);
		if($mhfont_family !== '')
			$title1_style .= 'font-family:'.$mhfont_family.';';
	}
	if (function_exists('get_ultimate_font_style')) {
		$title1_style .= get_ultimate_font_style($btn1_heading_style);
	}
	if (is_numeric($title_font_size)) {
        $title_font_size = 'desktop:'.$title_font_size.'px;';
    }
    if (is_numeric($title_line_ht)) {
        $title_line_ht = 'desktop:'.$title_line_ht.'px;';
    }
	// $title1_style .= 'font-size:'.$title_font_size.'px;';//style
	$title1_style .= 'color:'.$btn1_text_color.';';//color
	// if($title_line_ht!=''){
	// $title1_style .= 'line-height:'.$title_line_ht.'px;';//line-height
	// }
	$dualbtn_args = array(
                'target' => '#'.$dual_btn_id . ' .ult-dual-button-title', // set targeted element e.g. unique class/id etc.
                'media_sizes' => array(
                    'font-size' => $title_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
                   	'line-height' => $title_line_ht
                ),
            );
	$data_list1 = get_ultimate_vc_responsive_media_css($dualbtn_args);
/*--------css for title2------------*/

$title2_style='';
if (function_exists('get_ultimate_font_family')) {
		$mhfont_family1 = get_ultimate_font_family($btn2_font_family);
		if($mhfont_family1 !== '')
			$title2_style .= 'font-family:'.$mhfont_family1.';';
	}
	if (function_exists('get_ultimate_font_style')) {
		$title2_style .= get_ultimate_font_style($btn2_heading_style);
	}
	// $title2_style .= 'font-size:'.$title_font_size.'px;';//style
	$title2_style .= 'color:'.$btn2_text_color.';';//color
	// if($title_line_ht!=''){
	// $title2_style .= 'line-height:'.$title_line_ht.'px;';//line-height
 //    }
/*--------css for button1------------*/

$btncolor_style='';
$btncolor_style .= 'background-color:'.$btn1_background_color.' !important;';

/*--------css for button2------------*/

$btncolor1_style='';
$btncolor1_style .= 'background-color:'.$btn2_background_color.' !important;';

/*--------css for button------------*/

$btnmain_style='';
$btnmain_style .= 'border-color:'.$btn_color_border.';';

$btnmain_style .= 'border-style:'.$btn_border_style.';';
if($btn_border_style!=''){
$btnmain_style .= 'border-width:'.$btn_border_size.'px;';
}
else{
	$btnmain_style .= 'border-width:0px;';
}
$btnmain_style .= 'border-radius:'.$btn_border_radius.'px;';
if($btn_width!='')
$btnmain_style .= 'width:'.$btn_width.'px;';


/*--------for divider------------*/
$text_style='';
$text_style .='line-height: 1.8em;';
$text_style .='color:'.$divider_text_color.';';
$text_style .='background-color:'.$divider_bg_color.';';

if($divider_border_style==''){
	$text_style .='border-width:0px;';
}
else{
	$text_style .='border-color:'.$divider_color_border.';';
	$text_style .='border-width:'.$divider_border_size.'px;';
	$text_style .='border-style:'.$divider_border_style.';';
	$text_style .='border-radius:'.$divider_border_radius.'px;';
}



if($divider_style=='text')
{
$text=$divider_text;
}
else if($divider_style=='icon')
{
$text='<i class="'.$divider_icon.'"></i>';

}
else if($divider_style=='image')
{
$text_style='';
$text_style.='width: 25px;
height: 25px;
border-radius: 50%;
background-color:'.$divider_bg_color.';';

$img3 = apply_filters('ult_get_img_single', $divider_icon_img, 'url');
$alt3 = apply_filters('ult_get_img_single', $divider_icon_img, 'alt');
$text='<img class="img-icon" alt="'.$alt3.'" src="'.apply_filters('ultimate_images', $img3).'" style="'.$text_style.'" />';

}

/*-----------responsive mode --------*/

//echo $btn_resp_width;
/*$mainarr='';
$resp_data='';
if($btn_resp_width!='')
$mainarr=explode(";",$btn_resp_width);
$subarr=array();$sub='';
//print_r($mainarr);
if(!empty($mainarr)){


foreach ($mainarr as $key => $value) {
	if($value!='')
	$sub=explode(":",$value);
	$sub[1]=str_replace("px","",$sub[1]);
	$subarr[$sub[0]]=$sub[1];

	}

foreach ($subarr as $key => $value) {
			$resp_data.='data-'.$key.'="'.$value.'"';
	}
}*/
/*--- generate random no------------*/
$dual_resp;
$resp_data='data-response="'.$dual_resp.'"';
$id='';
$id="ult_btn_".mt_rand();


/*----------for btn1 hover------------*/
$btn_hover='';
$btn_hover .='data-bgcolor="'.$btn1_background_color.'" ';
$btn_hover .='data-bghovercolor="'.$btn1_bghovercolor.'" ';
$btn_hover .='data-icon_color="'.$icon_color.'" ';
$btn_hover .='data-icon_hover_color="'.$icon_hover_color.'" ';
$btn_hover .='data-textcolor="'.$btn1_text_color.'" ';
$btn_hover .='data-texthovercolor="'.$btn1_text_hovercolor.'" ';
if($icon_style == 'none'){
$btn_hover .='data-iconbgcolor="transperent" ';
$btn_hover .='data-iconbghovercolor="transperent" ';
$btn_hover .='data-iconborder="transperent" ';
$btn_hover .='data-iconhoverborder="transperent" ';
}
else{

$btn_hover .='data-iconbgcolor="'.$icon_color_bg.'" ';
$btn_hover .='data-iconbghovercolor="'.$icon_color_hoverbg.'" ';
$btn_hover .='data-iconborder="'.$icon_color_border.'" ';
$btn_hover .='data-iconhoverborder="'.$icon_color_hoverborder.'" ';
}


/*----------for btn2 hover------------*/
$btn2_hover='';
$btn2_hover .='data-bgcolor="'.$btn2_background_color.'" ';
$btn2_hover .='data-bghovercolor="'.$btn2_bghovercolor.'" ';
$btn2_hover .='data-icon_color="'.$btn_icon_color.'" ';
$btn2_hover .='data-icon_hover_color="'.$btn_iconhover_color.'" ';
$btn2_hover .='data-textcolor="'.$btn2_text_color.'" ';
$btn2_hover .='data-texthovercolor="'.$btn2_text_hovercolor.'" ';
if($btn_icon_style == 'none'){
$btn2_hover .='data-iconbgcolor="transperent" ';
$btn2_hover .='data-iconbghovercolor="transperent" ';
$btn2_hover .='data-iconborder="transperent" ';
$btn2_hover .='data-iconhoverborder="transperent" ';
}
else{
$btn2_hover .='data-iconbgcolor="'.$btn_icon_color_bg.'" ';
$btn2_hover .='data-iconbghovercolor="'.$btn_icon_color_hoverbg.'" ';
$btn2_hover .='data-iconborder="'.$btn_icon_color_border.'" ';
$btn2_hover .='data-iconhoverborder="'.$btn_icon_color_hoverborder.'" ';
}

//echo $btn_hover_style;

/*--- main button border-----*/
$mainbtn='';
if($btn_hover_style == ''){
$mainbtn .= 'data-bcolor="'.$btn_color_border.'"';
$mainbtn .= 'data-bhcolor="'.$btn_color_border.'"';
}
else{
$mainbtn .= 'data-bcolor="'.$btn_color_border.'"';
$mainbtn .= 'data-bhcolor="'.$btn_color_hoverborder.'"';
}

 $icon_align;

/*---- for icon line-height----*/
$size=$icon1_lineht=$icon2_lineht=$iconht1='';
$iconht=$icon2_lineht2=$iconht2=$icon1_lineht2='';$icnsize='';$icnsize1='';$icnsize2='';

//echo $iconoutput;
//echo $iconoutput2;
$emptyicon='';$emptyicon1='';
if( $iconoutput==''){
	$emptyicon='padding-left:0px;';
	$icon_align='left';
}
if($iconoutput2==''){
	$emptyicon1='padding-left:0px;';
	$btn2_icon_align='right';
}
/* change class name */
			//return $mainoutput;

//echo $btn_width;
		$subop='';
		$subop .='
			<div class="ult_dual_button '.$dual_design_style_css.' '.$is_vc_49_plus.' to-'.$btn_alignment.'  '.$extraclass.'"  '.$resp_data.' id="'.$id.'">

			<div id="'.$dual_btn_id.'" class="ulitmate_dual_buttons '.$hoverstyle.' ult_main_dualbtn " '.$mainbtn.'>

			<div class="ult_dualbutton-wrapper btn-inline place-template bt1 ">';
			$is_no_icon_first = (trim($iconoutput) === '') ? 'ult-dual-btn-no-icon' : '';
			if($icon_align=='right')
			{
			$subop .='<a href = "'.$url1.'" '.$target.' class="ult_ivan_button   round-square  with-icon icon-after with-text place-template ult_dual1" style=" '.$icon1_lineht2.';margin-right:px;'.$size.';'.$btncolor_style.$button1_bstyle.'; '.$btnmain_style.';">
			<span class="ult-dual-btn-1 ' .$btn_hover_style. '" style=""  '.$btn_hover.'>

			<span class="text-btn ult-dual-button-title title_left "  style="'.$title1_style.'">'.$button1_text.'</span>
			<span class="icon-simple icon-right1 ult_btn1span '.$is_no_icon_first.'"  style="'.$icnsize1.';'.$emptyicon.' ">'.$iconoutput.'</span
			</span>
			</a>';
			}
			else{

			$subop .='<a href = "'.$url1.'" '.$target.'class="ult_ivan_button   round-square  with-icon icon-before with-text place-template ult_dual1" style="'.$icon1_lineht2.';margin-right:px;'.$size.';'.$btncolor_style.$button1_bstyle.'; '.$btnmain_style.';">
			<span class="ult-dual-btn-1 ' .$btn_hover_style. '" style=""  '.$btn_hover.'>
			<span class="icon-simple icon-left1 ult_btn1span '.$is_no_icon_first.'"  style="'.$icnsize1.';'.$emptyicon.' ">'.$iconoutput.'</span>
			<span class="text-btn ult-dual-button-title ult-responsive" '.$data_list1.' style="'.$title1_style.'">'.$button1_text.'</span>

			</span>
			</a>';
			}


		$subop .='<span class="middle-text" style="'.$text_style.'">
			<span class="middle-inner"  >'.$text.'</span>
			</span>

			</div>

			<div class="ult_dualbutton-wrapper btn-inline place-template btn2 ">';
			$is_no_icon = (trim($iconoutput2) === '') ? 'ult-dual-btn-no-icon' : '';
			if($btn2_icon_align=='right')
			{
			$subop .='<a href = "'.$url2.'" '.$target1.' class="ult_ivan_button   round-square  with-icon icon-after with-text place-template ult_dual2"  style="'.$icon2_lineht2.';'.$btncolor1_style.$button2_bstyle.';margin-left:px;'.$size.';'.$btnmain_style.'">
			<span class="ult-dual-btn-2 ' .$btn_hover_style. '"  '.$btn2_hover.'>
			<span class="text-btn ult-dual-button-title" style="'.$title2_style.'">'.$button2_text.'</span>

			<span class="icon-simple icon-right2 ult_btn1span '.$is_no_icon.'"  style="'.$icnsize2.';'.$emptyicon1.' ">'.$iconoutput2.'</span>
			</span>
			</a>';
		  }
		  else{

		  	$subop .='<a href = "'.$url2.'" '.$target1.' class="ult_ivan_button   round-square  with-icon icon-before with-text place-template ult_dual2"  style="'.$icon2_lineht2.';'.$btncolor1_style.$button2_bstyle.';margin-left:-0px;'.$size.'; '.$btnmain_style.'">
			<span class="ult-dual-btn-2 ' .$btn_hover_style. '"  '.$btn2_hover.'>

			<span class="icon-simple icon-left2 ult_btn1span '.$is_no_icon.'"  style="'.$icnsize2.';'.$emptyicon1.' ">'.$iconoutput2.'</span>
			<span class="text-btn ult-dual-button-title title_right" style="'.$title2_style.'">'.$button2_text.'</span>


			</span>
			</a>';

		  }
			$subop .='</div>
			</div>
			</div>';

			$is_preset = false; //Retrieve preset Code
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
				$subop .= '<pre>';
				$subop .= $text;
				$subop .= '</pre>'; // remove backslash once copied
			}

		return 	$subop ;



		}

		function ultimate_dual_button()
		{
			if(function_exists('vc_map'))
			{
				vc_map(
					array(
					   "name" => __("Dual Button"),
					   "base" => "ult_dualbutton",
					   "icon"=> "uvc_dual_button",
					   "class" => "uvc_dual_button",
					   "category" => __("Ultimate VC Addons","ultimate_vc"),
					  // "front_enqueue_js" => array(plugins_url("../assets/min-js/dual_button.min.js",__FILE__),array('jquery'),ULTIMATE_VERSION),
					  // "front_enqueue_js" =>  preg_replace( '/\s/', '%20', plugins_url( '../admin/js/dualbtnfront.js', __FILE__ ) ),
					   "description" => __("Add a dual button and give some custom style.","ultimate_vc"),
					   "params" => array(
							// Play with icon selector
					   	/*-----------general------------*/
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Button Style", "ultimate_vc"),
								"param_name" => "btn_hover_style",
								"value" => array(
									"Style 1"=> "Style 1",
									"Style 2" => "Style 2",
									/*"Style 3" => "Style 3",*/
									"None"=> " ",

								),
								"description" => __("Select the Hover style for Button.","ultimate_vc"),

							),
							// array(
							// 	"type" => "number",
							// 	"param_name" => "title_font_size",
							// 	"heading" => __("Text Font size","ultimate_vc"),
							// 	"value" => "",
							// 	"suffix" => "px",
							// 	'edit_field_class' => 'vc_column vc_col-sm-4',
							// ),
							array(
                                "type" => "ultimate_responsive",
                                "class" => "",
                                "heading" => __("Text Font size", 'ultimate_vc'),
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
                            ),

							// array(
							// 	"type" => "number",
							// 	"param_name" => "title_line_ht",
							// 	"heading" => __("Text Line Height","ultimate_vc"),
							// 	"value" => "",
							// 	"suffix" => "px",
							// 	'edit_field_class' => 'vc_column vc_col-sm-4',

							// ),
							array(
                                "type" => "ultimate_responsive",
                                "class" => "",
                                "heading" => __("Text Line Height", 'ultimate_vc'),
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
                            ),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Border Radius", "ultimate_vc"),
								"param_name" => "btn_border_radius",

								"min" => 1,
								"max" => 50,
								"suffix" => "px",
								 //"dependency" => Array("element" => "btn_border_style", "not_empty" => true),
								 'edit_field_class' => 'vc_column vc_col-sm-4',

							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Border Style", "ultimate_vc"),
								"param_name" => "btn_border_style",
								"value" => array(
									"None"=> "",
									"Solid"=> "solid",
									"Dashed" => "dashed",
									"Dotted" => "dotted",
									"Double" => "double",
									"Inset" => "inset",
									"Outset" => "outset",
								),
								"description" => __("Select the border style for Button.","ultimate_vc"),
								//"dependency" => Array("element" => "btn_hover_style", "not_empty" => true),


							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Border Color", "ultimate_vc"),
								"param_name" => "btn_color_border",
								"value" => "",
								"description" => __("Select border color for button.", "ultimate_vc"),
								"dependency" => Array("element" => "btn_border_style", "not_empty" => true),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Border Width", "ultimate_vc"),
								"param_name" => "btn_border_size",
								"value" => "",
								"min" => 1,
								"max" => 10,
								"suffix" => "px",
								"description" => __("Thickness of the border.", "ultimate_vc"),
								"dependency" => Array("element" => "btn_border_style", "not_empty" => true),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Button Width", "ultimate_vc"),
								"param_name" => "btn_width",
								"min" => 1,
								"max" => 50,
								"suffix" => "px",
								 //"dependency" => Array("element" => "btn_border_style", "not_empty" => true),
								 'edit_field_class' => 'vc_column vc_col-sm-6',

							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Button Alignment", "ultimate_vc"),
								"param_name" => "btn_alignment",
								"value" => array(
									"center"=> "",
									"left"=> "left",
									"right" => "right",

								),
								'edit_field_class' => 'vc_column vc_col-sm-6',

							),
							array(
									"type" => "ult_switch",
									"class" => "",
									//"heading" => __("Want To show button in responsive mode", "ultimate_vc"),
									"param_name" => "dual_resp",
									// "admin_label" => true,
									"value" => "on",
									"default_set" => true,
									"options" => array(
										"on" => array(
											"label" => __("Enable Responsive Mode?","ultimate_vc"),
											"on" => __("Yes","ultimate_vc"),
											"off" => __("No","ultimate_vc"),
										  ),
									  ),
									/*"description" => __("", "smile"),*/
									"description" => __("Enable Responsive Mod or not", 'ultimate_vc'),
								),

							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Custom CSS Class", "ultimate_vc"),
								"param_name" => "el_class",
								"value" => "",
								"description" => __("Ran out of options? Need more styles? Write your own CSS and mention the class name here.", "ultimate_vc"),
							),

					   	/*---bt1----*/
					   		/*array(
									"type" => "ult_param_heading",
									"param_name" => "btn1_text_setting",
									"text" => __("Button Text", "ultimate_vc"),
									"value" => "",
									"class" => "",
									"group" => __("Button1","ultimate_vc"),
									'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
								),*/

					   		array(
								"type" => "textfield",
								"class" => "",
								"heading" => __(" Button Text", "ultimate_vc"),
								"param_name" => "button1_text",
								"value" => "",
								"admin_label" => true,
								"description" => __("Enter your text here.", "ultimate_vc"),
								"group" => "Button1",
							),
							array(
								"type" => "vc_link",
								"class" => "",
								"heading" => __("Link ","ultimate_vc"),
								"param_name" => "icon_link",
								"value" => "",
								"description" => __("Add a custom link or select existing page. You can remove existing link as well.","ultimate_vc"),
								"group" => "Button1",

							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Background Color", "ultimate_vc"),
								"param_name" => "btn1_background_color",
								"value" => "",
								"description" => __("Select Background Color for Button.", "ultimate_vc"),
								"group" => "Button1",

							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Background Hover Color", "ultimate_vc"),
								"param_name" => "btn1_bghovercolor",
								"value" => "",
								"description" => __("Select background hover color for Button.", "ultimate_vc"),
								/*"dependency" => Array("element" => "btn_hover_style", "not_empty" => true),*/
								"dependency" => Array("element" => "btn_hover_style", "value" => array("Style 1","Style 2","Style 3")),
								"group" => "Button1",

							),

					   		array(
									"type" => "ult_param_heading",
									"param_name" => "btn1_icon_setting",
									"text" => __("Icon/Image ", "ultimate_vc"),
									"value" => "",
									"class" => "",
									"group" => __("Button1","ultimate_vc"),
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
								"group" => "Button1",
							),
							array(
								"type" => "icon_manager",
								"class" => "",
								"heading" => __("Select Icon ","ultimate_vc"),
								"param_name" => "icon",
								"value" => "",
								"description" => __("Click and select icon of your choice. If you can't find the one that suits for your purpose","ultimate_vc").", ".__("you can","ultimate_vc")." <a href='admin.php?page=bsf-font-icon-manager' target='_blank'>".__("add new here","ultimate_vc")."</a>.",
								"dependency" => Array("element" => "icon_type","value" => array("selector")),
								"group" => "Button1",
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
								"group" => "Button1",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Image Width", "ultimate_vc"),
								"param_name" => "img_width",
								"value" => "",
								"min" => 16,
								"max" => 512,
								"suffix" => "px",
								"description" => __("Provide image width", "ultimate_vc"),
								"dependency" => Array("element" => "icon_type","value" => array("custom")),
								"group" => "Button1",
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
								"group" => "Button1",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon Color", "ultimate_vc"),
								"param_name" => "icon_color",
								"value" => "",
								"description" => __("Icon Color!", "ultimate_vc"),
								"dependency" => Array("element" => "icon_type","value" => array("selector")),
								"group" => "Button1",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon Hover Color", "ultimate_vc"),
								"param_name" => "icon_hover_color",
								"value" => "",
								"description" => __("Icon hover color !", "ultimate_vc"),
								"dependency" => Array("element" => "icon_type","value" => array("selector"),
													/*"element" => "btn_hover_style", "not_empty" => true*/),
								"group" => "Button1",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Icon or Image Style", "ultimate_vc"),
								"param_name" => "icon_style",
								"value" => array(
									"Simple" => "none",
									"Circle Background" => "circle",
									"Square Background" => "square",
									"Design your own" => "advanced",
								),
								"description" => __("We have given three quick preset if you are in a hurry. Otherwise, create your own with various options.", "ultimate_vc"),
								"group" => "Button1",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon or Image Background Color ", "ultimate_vc"),
								"param_name" => "icon_color_bg",
								"value" => "",
								"description" => __("Select background color for icon.", "ultimate_vc"),
								"dependency" => Array("element" => "icon_style", "value" => array("circle","square","advanced")),
								"group" => "Button1",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon or Image Background Hover Color ", "ultimate_vc"),
								"param_name" => "icon_color_hoverbg",
								"value" => "",
								"description" => __("Select background hover color for icon.", "ultimate_vc"),
								"dependency" => Array("element" => "icon_style", "value" => array("circle","square","advanced")
									),
								"group" => "Button1",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Icon or Image Border Style", "ultimate_vc"),
								"param_name" => "icon_border_style",
								"value" => array(
									"Solid"=> "solid",
									/*"None"=> "",*/
									"Dashed" => "dashed",
									"Dotted" => "dotted",
									"Double" => "double",
									"Inset" => "inset",
									"Outset" => "outset",
								),
								"description" => __("Select the border style for icon.","ultimate_vc"),
								"dependency" => Array("element" => "icon_style", "value" => array("advanced")),
								"group" => "Button1",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon or Image Border Color", "ultimate_vc"),
								"param_name" => "icon_color_border",
								"value" => "",
								"description" => __("Select border color for icon.", "ultimate_vc"),
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
								"group" => "Button1",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon or Image Border Hover Color", "ultimate_vc"),
								"param_name" => "icon_color_hoverborder",
								"value" => "",
								"description" => __("Select border hover color for icon.", "ultimate_vc"),
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
								"group" => "Button1",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Icon or Image Border Width", "ultimate_vc"),
								"param_name" => "icon_border_size",
								"value" => "",
								"min" => 1,
								"max" => 10,
								"suffix" => "px",
								"description" => __("Thickness of the border.", "ultimate_vc"),
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
								"group" => "Button1",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Icon or Image Border Radius", "ultimate_vc"),
								"param_name" => "icon_border_radius",
								"value" => "",
								"min" => 1,
								"max" => 100,
								"suffix" => "px",
								"description" => __("0 pixel value will create a square border. As you increase the value, the shape convert in circle slowly. (e.g 500 pixels).", "ultimate_vc"),
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
								"group" => "Button1",
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
								"group" => "Button1",

							),

							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Alignment", "ultimate_vc"),
								"param_name" => "icon_align",
								"value" => array(
									//"Center"	=>	"center",
									"Left"		=>	"",
									"Right"		=>	"right"
								),
								"group" => "Button1",
							),
							/*array(
									"type" => "ult_param_heading",
									"param_name" => "button1bg_settng",
									"text" => __("Button Background Settings", "ultimate_vc"),
									"value" => "",
									"class" => "",
									"group" => __("Button1","ultimate_vc"),
									'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
								),
*/










							/*---for btn2----*/
							/*array(
									"type" => "ult_param_heading",
									"param_name" => "btn2_text_setting",
									"text" => __("Button Text ", "ultimate"),
									"value" => "",
									"class" => "",
									"group" => __("Button2","ultimate_vc"),
									'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
								),*/

							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __(" Button Text", "ultimate_vc"),
								"param_name" => "button2_text",
								"value" => "",
								"admin_label" => true,
								"description" => __("Enter your Button2 text here.", "ultimate_vc"),
								"group" => "Button2",
							),
							array(
								"type" => "vc_link",
								"class" => "",
								"heading" => __("Link ","ultimate_vc"),
								"param_name" => "btn_icon_link",
								"value" => "",
								"description" => __("Add a custom link or select existing page. You can remove existing link as well.","ultimate_vc"),
								"group" => "Button2",

							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Background Color", "ultimate_vc"),
								"param_name" => "btn2_background_color",
								"value" => "",
								"description" => __("Select Background Color for Button.", "ultimate_vc"),
								"group" => "Button2",

							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Background Hover Color", "ultimate_vc"),
								"param_name" => "btn2_bghovercolor",
								"value" => "",
								"description" => __("Select background hover color for Button.", "ultimate_vc"),
								//"dependency" => Array("element" => "btn_hover_style", "not_empty" => true),
								"dependency" => Array("element" => "btn_hover_style", "value" => array("Style 1","Style 2","Style 3")),
								"group" => "Button2",

							),

							array(
									"type" => "ult_param_heading",
									"param_name" => "btn1_icon_setting",
									"text" => __("Icon/Image ", "ultimate"),
									"value" => "",
									"class" => "",
									"group" => __("Button2","ultimate_vc"),
									'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
								),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Icon to display:", "ultimate_vc"),
								"param_name" => "btn_icon_type",
								"value" => array(
									"Font Icon Manager" => "selector",
									"Custom Image Icon" => "custom",
								),
								"description" => __("Use existing font icon or upload a custom image.", "ultimate_vc"),
								"group" => "Button2",
							),
							array(
								"type" => "icon_manager",
								"class" => "",
								"heading" => __("Select Icon ","ultimate_vc"),
								"param_name" => "btn_icon",
								"value" => "",
								"description" => __("Click and select icon of your choice. If you can't find the one that suits for your purpose","ultimate_vc").", ".__("you can","ultimate_vc")." <a href='admin.php?page=bsf-font-icon-manager' target='_blank'>".__("add new here","ultimate_vc")."</a>.",
								"dependency" => Array("element" => "btn_icon_type","value" => array("selector")),
								"group" => "Button2",
							),
							array(
								"type" => "ult_img_single",
								"class" => "",
								"heading" => __("Upload Image Icon:", "ultimate_vc"),
								"param_name" => "btn_icon_img",
								//"admin_label" => true,
								"value" => "",
								"description" => __("Upload the custom image icon.", "ultimate_vc"),
								"dependency" => Array("element" => "btn_icon_type","value" => array("custom")),
								"group" => "Button2",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Image Width", "ultimate_vc"),
								"param_name" => "btn_img_width",
								"value" => "",
								"min" => 16,
								"max" => 512,
								"suffix" => "px",
								"description" => __("Provide image width", "ultimate_vc"),
								"dependency" => Array("element" => "btn_icon_type","value" => array("custom")),
								"group" => "Button2",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Size of Icon", "ultimate_vc"),
								"param_name" => "btn_icon_size",
								"value" => "",
								"min" => 12,
								"max" => 72,
								"suffix" => "px",
								"description" => __("How big would you like it?", "ultimate_vc"),
								"dependency" => Array("element" => "btn_icon_type","value" => array("selector")),
								"group" => "Button2",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon Color", "ultimate_vc"),
								"param_name" => "btn_icon_color",
								"value" => "",
								"description" => __("Icon Color!", "ultimate_vc"),
								"dependency" => Array("element" => "btn_icon_type","value" => array("selector")),
								"group" => "Button2",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon Hover Color", "ultimate_vc"),
								"param_name" => "btn_iconhover_color",
								"value" => "",
								"description" => __("Icon hover color!", "ultimate_vc"),
								"dependency" => Array("element" => "btn_icon_type","value" => array("selector")),
								"group" => "Button2",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Icon or Image Style", "ultimate_vc"),
								"param_name" => "btn_icon_style",
								"value" => array(
									"Simple" => "none",
									"Circle Background" => "circle",
									"Square Background" => "square",
									"Design your own" => "advanced",
								),
								"description" => __("We have given three quick preset if you are in a hurry. Otherwise, create your own with various options.", "ultimate_vc"),
								"group" => "Button2",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon or Image Background Color", "ultimate_vc"),
								"param_name" => "btn_icon_color_bg",
								"value" => "",
								"description" => __("Select background color for icon.", "ultimate_vc"),
								"dependency" => Array("element" => "btn_icon_style", "value" => array("circle","square","advanced")),
								"group" => "Button2",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon or Image Background hover Color", "ultimate_vc"),
								"param_name" => "btn_icon_color_hoverbg",
								"value" => "",
								"description" => __("Select background hover color for icon.", "ultimate_vc"),
								"dependency" => Array("element" => "btn_icon_style", "value" => array("circle","square","advanced")
									  				  ),
								"group" => "Button2",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Icon or Image Border Style", "ultimate_vc"),
								"param_name" => "btn_icon_border_style",
								"value" => array(
									"None"=> "",
									"Solid"=> "solid",
									"Dashed" => "dashed",
									"Dotted" => "dotted",
									"Double" => "double",
									"Inset" => "inset",
									"Outset" => "outset",
								),
								"description" => __("Select the border style for Button.","ultimate_vc"),
								"dependency" => Array("element" => "btn_icon_style", "value" => array("advanced")),
								"group" => "Button2",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon or Image Border Color", "ultimate_vc"),
								"param_name" => "btn_icon_color_border",
								"value" => "",
								"description" => __("Select border color for icon.", "ultimate_vc"),
								"dependency" => Array("element" => "btn_icon_border_style", "not_empty" => true),
								"group" => "Button2",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon or Image Border Hover Color", "ultimate_vc"),
								"param_name" => "btn_icon_color_hoverborder",
								"value" => "",
								"description" => __("Select border color for icon.", "ultimate_vc"),
								"dependency" => Array("element" => "btn_icon_border_style", "not_empty" => true
														),
								"group" => "Button2",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Icon or Image Border Width", "ultimate_vc"),
								"param_name" => "btn_icon_border_size",
								"value" => "",
								"min" => 1,
								"max" => 10,
								"suffix" => "px",
								"description" => __("Thickness of the border.", "ultimate_vc"),
								"dependency" => Array("element" => "btn_icon_border_style", "not_empty" => true),
								"group" => "Button2",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Icon or Image Border Radius", "ultimate_vc"),
								"param_name" => "btn_icon_border_radius",
								"value" => "",
								"min" => 1,
								"max" => 100,
								"suffix" => "px",
								"description" => __("0 pixel value will create a square border. As you increase the value, the shape convert in circle slowly. (e.g 500 pixels).", "ultimate_vc"),
								"dependency" => Array("element" => "btn_icon_border_style", "not_empty" => true),
								"group" => "Button2",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Icon or Image Background Size", "ultimate_vc"),
								"param_name" => "btn_icon_border_spacing",
								"value" => "",
								"min" => 30,
								"max" => 500,
								"suffix" => "px",
								"description" => __("Spacing from center of the icon till the boundary of border / background", "ultimate_vc"),
								"dependency" => Array("element" => "btn_icon_border_style", "not_empty" => true),
								"group" => "Button2",

							),

							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Alignment", "ultimate_vc"),
								"param_name" => "btn2_icon_align",
								"value" => array(
									//"Center"	=>	"center",
									"Right"		=>	"",
									"Left"		=>	"left",

								),
								"group" => "Button2",
							),

							/*---typography----------*/

							/*array(
									"type" => "ult_param_heading",
									"param_name" => "btn2_bg_setting",
									"text" => __("Button Background Settings", "ultimate"),
									"value" => "",
									"class" => "",
									"group" => __("Button2","ultimate_vc"),
									'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
								),*/
/**/


									/*--------divider---------------*/
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Select Deivider options", "ultimate_vc"),
								"param_name" => "divider_style",
								"value" => array(
									"Text"	=>	"text",
									"Icon"		=>	"icon",
									"Image"		=>	"image"
								),
								"group" => "Divider",
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __(" Text", "ultimate_vc"),
								"param_name" => "divider_text",
								"value" => "",
								"description" => __("Enter your Divider text here.", "ultimate_vc"),
								"dependency" => Array("element" => "divider_style", "value" => array("text")),
								"group" => "Divider",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Text/Icon Color", "ultimate_vc"),
								"param_name" => "divider_text_color",
								"value" => "",
								"description" => __("Select  color for divider text/icon.", "ultimate_vc"),
								"dependency" => Array("element" => "divider_style", "value" => array("text","icon")),
								"group" => "Divider",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Background Color", "ultimate_vc"),
								"param_name" => "divider_bg_color",
								"value" => "",
								"description" => __("Select border color for Icon/Text/Image.", "ultimate_vc"),
								"dependency" => Array("element" => "divider_style", "not_empty" => true),
								"group" => "Divider",
							),

							array(
								"type" => "icon_manager",
								"class" => "",
								"heading" => __("Select Icon ","ultimate_vc"),
								"param_name" => "divider_icon",
								"value" => "",
								"description" => __("Click and select icon of your choice. If you can't find the one that suits for your purpose","ultimate_vc").", ".__("you can","ultimate_vc")." <a href='admin.php?page=bsf-font-icon-manager' target='_blank'>".__("add new here","ultimate_vc")."</a>.",
								"dependency" => Array("element" => "divider_style","value" => array("icon")),
								"group" => "Divider",
							),
							array(
								"type" => "ult_img_single",
								"class" => "",
								"heading" => __("Upload Image Icon:", "ultimate_vc"),
								"param_name" => "divider_icon_img",
								//"admin_label" => true,
								"value" => "",
								"description" => __("Upload the custom image icon.", "ultimate_vc"),
								"dependency" => Array("element" => "divider_style","value" => array("image")),
								"group" => "Divider",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Border Style", "ultimate_vc"),
								"param_name" => "divider_border_style",
								"value" => array(
									"None"=> "",
									"Solid"=> "solid",
									"Dashed" => "dashed",
									"Dotted" => "dotted",
									"Double" => "double",
									"Inset" => "inset",
									"Outset" => "outset",
								),
								"description" => __("Select the border style for Button.","ultimate_vc"),
								//"dependency" => Array("element" => "btn_hover_style", "not_empty" => true),
								"group" => "Divider",

							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Border Color", "ultimate_vc"),
								"param_name" => "divider_color_border",
								"value" => "",
								"description" => __("Select border color for divider.", "ultimate_vc"),
								"dependency" => Array("element" => "divider_border_style", "not_empty" => true),
								//'edit_field_class' => 'vc_column vc_col-sm-4',
								"group" => "Divider",
							),

							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Border Width", "ultimate_vc"),
								"param_name" => "divider_border_size",
								"value" => "",
								"min" => 1,
								"max" => 10,
								"suffix" => "px",
								"description" => __("Thickness of the border.", "ultimate_vc"),
								"dependency" => Array("element" => "divider_border_style", "not_empty" => true),
								//'edit_field_class' => 'vc_column vc_col-sm-4',
								"group" => "Divider",
							),

								array(
								"type" => "number",
								"class" => "",
								"heading" => __("Border Radius", "ultimate_vc"),
								"param_name" => "divider_border_radius",

								"min" => 1,
								"max" => 50,
								"suffix" => "px",
								 "dependency" => Array("element" => "divider_border_style", "not_empty" => true),
								// 'edit_field_class' => 'vc_column vc_col-sm-4',
								 "group" => "Divider",

							),
							/*--- typgraphy--*/



									array(
									"type" => "ult_param_heading",
									"param_name" => "bt1typo-setting",
									"text" => __("Button 1 ", "ultimate"),
									"value" => "",
									"class" => "",
									"group" => __("Typography","ultimate_vc"),
									'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
								),

							array(
								"type" => "ultimate_google_fonts",
								"heading" => __("Title Font Family", "ultimate_vc"),
								"param_name" => "btn1_font_family",
								"description" => __("Select the font of your choice. ","ultimate_vc").", ".__("you can","ultimate_vc")." <a href='admin.php?page=bsf-google-font-manager' target='_blank'>".__("add new in the collection here","ultimate_vc")."</a>.",
								"group" => "Typography",
								),

							array(
								"type" => "ultimate_google_fonts_style",
								"heading" 		=>	__("Font Style", "ultimate_vc"),
								"param_name"	=>	"btn1_heading_style",

								"group" => "Typography",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Text Color", "ultimate_vc"),
								"param_name" => "btn1_text_color",
								"value" => "",
								"description" => __("Select text color for icon.", "ultimate_vc"),
								"group" => "Typography",

							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Text Hover Color", "ultimate_vc"),
								"param_name" => "btn1_text_hovercolor",
								"value" => "",
								"description" => __("Select text hover color for icon.", "ultimate_vc"),
								//"dependency" => Array("element" => "btn_hover_style", "not_empty" => true),
								"dependency" => Array("element" => "btn_hover_style", "value" => array("Style 1","Style 2","Style 3")),
								"group" => "Typography",

							),

							array(
									"type" => "ult_param_heading",
									"param_name" => "btn2_bg_setting",
									"text" => __("Button 2 ", "ultimate"),
									"value" => "",
									"class" => "",
									"group" => __("Typography","ultimate_vc"),
									'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
								),

							array(
								"type" => "ultimate_google_fonts",
								"heading" => __("Title Font Family", "ultimate_vc"),
								"param_name" => "btn2_font_family",
								"description" => __("Select the font of your choice. ","ultimate_vc").", ".__("you can","ultimate_vc")." <a href='admin.php?page=bsf-google-font-manager' target='_blank'>".__("add new in the collection here","ultimate_vc")."</a>.",
								"group" => "Typography",
								),

							array(
								"type" => "ultimate_google_fonts_style",
								"heading" 		=>	__("Font Style", "ultimate_vc"),
								"param_name"	=>	"btn2_heading_style",

								"group" => "Typography",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Text Color", "ultimate_vc"),
								"param_name" => "btn2_text_color",
								"value" => "",
								"description" => __("Select text color for icon.", "ultimate_vc"),
								"group" => "Typography",

							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Text Hover Color", "ultimate_vc"),
								"param_name" => "btn2_text_hovercolor",
								"value" => "",
								"description" => __("Select text hover color for icon.", "ultimate_vc"),
								//"dependency" => Array("element" => "btn_hover_style", "not_empty" => true),
								"dependency" => Array("element" => "btn_hover_style", "value" => array("Style 1","Style 2","Style 3")),
								"group" => "Typography",

							),
							array(
					            'type' => 'css_editor',
					            'heading' => __( 'Css', 'ultimate_vc' ),
					            'param_name' => 'css_dualbtn_design',
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
if(class_exists('AIO_Dual_Button'))
{
	$AIO_Dual_Button = new AIO_Dual_Button;


}
if(class_exists('WPBakeryShortCode'))
{
	class WPBakeryShortCode_ult_dualbutton extends WPBakeryShortCode {
	}
}
