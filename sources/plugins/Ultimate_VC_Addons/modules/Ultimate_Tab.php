<?php
/*
Add-on Name: Advanced Tab
* Add-on URI: http://dev.brainstormforce.com
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
if(!class_exists('ULT_TAB_ELEMENT'))
{
	class ULT_TAB_ELEMENT

	{
		function __construct()
		{
			add_action( 'wp_enqueue_scripts', 'ultimate_tabs',1 );
			add_action('init',array($this,'ult_tab_init'));
			//add_action('admin_init', 'ult_tab_init');
			add_action( 'admin_print_scripts', 'ultimate_tabs_admin',999 );
			add_shortcode('ult_tab_element',array($this,'ultimate_main_tab'));
			add_shortcode('single_tab',array($this,'ultimate_single_tab'));
		}

function ultimate_single_tab($atts ,$content = null)
		{
			$output = $title = $tab_id = $font_icons_position= $icon_type= $icon= $icon_color= $icon_hover_color=
			$icon_size= $icon_background_color=$icon_margin_bottom=$icon_margin_left=$icon_margin =$ul_sub_class='';

			//extract(shortcode_atts($this->predefined_atts, $atts));
			extract( shortcode_atts( array(
				'title'=>' ',
			   	'tab_id'=>' ',
			   	'font_icons_position'=>' ',
			   	'icon_type'=>' ',
			   	'icon'=>' ',
			   	'icon_color'=>' ',
			   	'icon_hover_color'=>' ',
			   	'icon_size'=>' ',
			    'icon_margin'=>' ',
			    'ul_sub_class'=>'',
			    ), $atts ) );
			//wp_enqueue_script('jquery_ui_tabs_rotate');
			//wp_enqueue_script('imd_ui_tabs_rotate');
 //echo $content = wpb_js_remove_wpautop($content, true);
			global $tabarr;

			   $tabarr[]=array(
			   	'title'=>$title,
			   	'tab_id'=>$tab_id,
			   	'font_icons_position'=>$font_icons_position,
			   	'icon_type'=>$icon_type,
			   	'icon'=>$icon,
			   	'icon_color'=>$icon_color,
			   	'icon_hover_color'=>$icon_hover_color,
			   	'icon_size'=>$icon_size,
			    'content'=>$content,
			    'icon_margin'=>$icon_margin,
			    'ul_sub_class'=>$ul_sub_class,
			   	);


			if( current_user_can('editor') || current_user_can('administrator') ) {

			$admn="Empty tab. Edit page to add content here.";
			}
			else{
			   $admn="";
			}
			  $tabcont=wpb_js_remove_wpautop($content);


			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_tab ui-tabs-panel wpb_ui-tabs-hide vc_clearfix ult_back','single_tab', $atts );
			$output .= "\n\t\t\t" . '<div  class="ult_tabitemname"  >';
			$output .= ($content=='' || $content==' ') ? __($admn, "js_composer") : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
			$output .= "\n\t\t\t" . '</div>' ;
			 //do_shortcode($content);
			return $output;

		}
function ultimate_main_tab($atts ,$content)
		{

$output = $title = $interval = $el_class = $shadow_color=$shadow_width='';
extract( shortcode_atts( array(
	//'maintitle' => '',
	'title_color'			 	=>'',
	'auto_rotate'			 	=>'',
	'interval' 				 	=> 0,
	'tab_style'					=>'Style_1',
	'tab_bottom_border' 		=> 'Disable',
	'border_color' 				=> '#1e73be',
	'border_thickness' 			=> '2',
	'tab_title_color' 			=> '#74777b',
	'tab_hover_title_color' 	=> '#ffffff',
	'tab_background_color' 		=> '#e7ecea',
	'tab_hover_background_color'=>'#4f90d1',
	'container_width' 			=> '',
	'el_class' 					=> '',
	'container_width'			=>'',
	'main_heading_font_family'	=>'',
    'title_font_size'			=>'15',
    'title_font_wt'				=>'',
    'title_line_ht'    			=>'',
    'desc_font_family'			=>'',
    'desc_font_size'			=>'',
    'desc_font_style'			=>'',
    'desc_line_ht'    			=>'',
    'shadow_color' 				=>'#333333',
    'shadow_width' 				=>'',
    'enable_bg_color'			=>'',
    'container_border_style1'	=>'',
	'container_color_border'	=>'',
	'cont_border_size'			=>'',
	'tabs_border_radius'		=>'8',
	'tab_animation'				=>'Slide',
	'tab_describe_color'		=>'#74777b',
	'title_font_style'			=>'',
	'css'						=>'',
	'act_icon_color'			=>'',
	'acttab_background'			=>'',
	'acttab_title'				=>'',
	'resp_type'					=>'Tabs',
	'resp_width'				=>'400',
	'resp_style'				=>'Both',
	'ac_tabs'					=>'',
	'icon_color'				=>'#74777b',
	'icon_hover_color'			=>'#ffffff',
	'icon_size'					=>'15',
	'icon_margin'				=>'',
	'disp_icon'					=>'Enable',
	'tab_css' 				    =>' ',
	'font_icons_position'		=>'Right',
	'main_title_typograpy'		=>'',
	'tab_max' 			  		=>'off',
	'wrapper_margin'			=>'',
	'smooth_scroll' 			=>'on',
), $atts ) );
global $tabarr;
	$tabarr = array();
    do_shortcode($content);

/*-----------default settings------------*/

if($acttab_background==''){
	$acttab_background=$tab_hover_background_color;
}
if($acttab_title==''){
	$acttab_title=$tab_hover_title_color;
}

/*---------------padding---------------------*/
 $css_class='';
 $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), "ult_tab_element", $atts );
 $css_class = esc_attr( $css_class );


if($tabs_border_radius!=''){
	//echo $tabs_border_radius;
}
/*-------------------font style------------------*/
if($tab_style=='Style_5'){
	//$tab_bottom_border=='Enable';
}

$container_style=$ult_style=$tab_style_no='';
if($tab_bottom_border=='Disable'){
$border_thickness="0";
$border_color="transparent";
}
if($container_width!=''){
	$container_style='max-width:'.$container_width.'px;';
}
$border_Style=$mhfont_family=$border_style ='';

$tabs_nav_style='';

// if($title_font_size!='')
// $tabs_nav_style .= 'font-size:'.$title_font_size.'px;';
// if($title_line_ht!='')
// $tabs_nav_style .='line-height:'.$title_line_ht.'px;';

if(is_numeric($title_font_size)){
			$title_font_size = 'desktop:'.$title_font_size.'px;';
		}

		if(is_numeric($title_line_ht)){
			$title_line_ht = 'desktop:'.$title_line_ht.'px;';
		}

		$advanced_tabs_id = 'advanced-tabs-wrap-'.rand(1000, 9999);

		$advanced_tabs_args = array(
            'target' => '#'.$advanced_tabs_id.' .ult-span-text', // set targeted element e.g. unique class/id etc.
            'media_sizes' => array(
                'font-size' => $title_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
               	'line-height' => $title_line_ht
            ),
        );

        $advanced_tabs_data_list = get_ultimate_vc_responsive_media_css($advanced_tabs_args);

if (function_exists('get_ultimate_font_family')) {

		$mhfont_family = get_ultimate_font_family($main_heading_font_family);
		if($mhfont_family!='')
		$tabs_nav_style .= 'font-family:'.$mhfont_family.';';

	}
	if (function_exists('get_ultimate_font_style')) {
		if($title_font_style!='')
		$tabs_nav_style .= get_ultimate_font_style($title_font_style);
	}

/*-------------------auto rotate------------------*/

if($auto_rotate=='Disables'){
	$interval=0;
	$autorotate='no';
}
else{
	$autorotate='yes';
}

if($tab_background_color=='')
{
	$tab_background_color="transparent";
}

$element = 'wpb_tabs';
//if ( 'vc_tour' == $this->shortcode ) $element = 'wpb_tour';
$ul_style=$tabs_nav = $style='';

/*------------------- style------------------*/

if($tab_style=='Style_1'){

	$style='style1';
	}
else if($tab_style=='Style_2'){

	$style='style2';

}
else if($tab_style=='Style_3'){

	$style='style3';

}
else if($tab_style=='Style_4'){
	$ult_style='ult_tab_style_4';
	$style='style1';
	}
else if($tab_style=='Style_5'){
	$ult_style='ult_tab_style_5';
	$style='style1';
	}
else if($tab_style=='Style_6'){
	$ult_style='ult_tab_style_6';
	$style='style1';
	}
foreach ($tabarr as $key => $value) {
	 $icon_value=$value["icon_size"];
	if (is_numeric($icon_value)) {
	 $icon_value1[]=$value["icon_size"];
	}
}


/*-------------- border style-----------*/
$tab_border='';
$tab_border .='color:'.$border_color.';';
	$tab_border .='border-bottom-color:'.$border_color.';';
	$tab_border .='border-bottom-width:'.$border_thickness.'px;';
	$tab_border .='border-bottom-style:solid;';
 if($tab_style=='Style_1'||$tab_style=='Style_3'){
 	$tab_border .='background-color:'.$tab_background_color.';';
 	$tab_border .='border-top-left-radius:'.$tabs_border_radius.'px;';
 	$tab_border .='border-top-right-radius:'.$tabs_border_radius.'px;';
 	$tab_border='';
 }
 if($tab_style=='Style_2'){
$tab_border .='border-bottom-width:0px;';
 }
  if($tab_style=='Style_4'||$tab_style=='Style_5'||$tab_style=='Style_6'){
 	$tab_border .='border-bottom-width:0px;';

 }

/*-----------------content baground-------------------*/

$contain_bg='';

/*---------------- description font family-----------*/
// if($desc_font_size!='')
// $contain_bg .= 'font-size:'.$desc_font_size.'px;';
// if($title_line_ht!='')
// $contain_bg .='line-height:'.$desc_line_ht.'px;';

//responsive param

if(is_numeric($desc_font_size)){
			$desc_font_size = 'desktop:'.$desc_font_size.'px;';
		}

		if(is_numeric($desc_line_ht)){
			$desc_line_ht = 'desktop:'.$desc_line_ht.'px;';
		}

		$advanced_tabs_desc_id = 'advanced-tabs-desc-wrap-'.rand(1000, 9999);

		$advanced_tabs_desc_args = array(
            'target' => '#'.$advanced_tabs_desc_id.' .ult_tabcontent .ult_tab_min_contain  p', // set targeted element e.g. unique class/id etc.
            'media_sizes' => array(
                'font-size' => $desc_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
               	'line-height' => $desc_line_ht
            ),
        );

        $advanced_tabs_desc_data_list = get_ultimate_vc_responsive_media_css($advanced_tabs_desc_args);


if (function_exists('get_ultimate_font_family')) {

		$dhfont_family = get_ultimate_font_family($desc_font_family);
		if($dhfont_family!='')
		$contain_bg .= 'font-family:'.$dhfont_family.';';

	}
	if (function_exists('get_ultimate_font_style')) {
		if($desc_font_style!='')
		$contain_bg .= get_ultimate_font_style($desc_font_style);
	}




$ult_top=$icon_top_link='';
if($tab_style=='Style_1'){
	$ult_top='ult_top';
	$icon_top_link='icon_top_link';
}
else if($tab_style=='Style_2'){

	$ult_top='ult_top';
	$icon_top_link='';
}
if($tab_style=='Style_4'){
	$tab_style_no.='Style_4';
	$ult_top='ult_top';
	$icon_top_link='style_4_top';
}
if($tab_style=='Style_5'){
	$tab_style_no.='Style_5';
	$icon_top_link='';

}
if($tab_style=='Style_6'){
	$tab_style_no.='Style_6';
	$icon_top_link='';

}
if($tab_style=='Style_3'){
		$ult_top='ult_top';
		$icon_top_link='icon_top_link';
}

if($enable_bg_color!='')
 {
 	$contain_bg .='background-color:'.$enable_bg_color.';';
 }
if($container_border_style1!=''){
	$container_border_style1=str_replace("|"," ",$container_border_style1);
	//$contain_bg .='border-style:'.$container_border_style.';';
	//$contain_bg .='border-color:'.$container_color_border.';';
	//$contain_bg .='border-width:'.$cont_border_size.'px;';
	//$contain_bg .='border-top:none;';
	$contain_bg .=$container_border_style1;
}
if($tab_describe_color!=''){
	$contain_bg .='color:'.$tab_describe_color.';';
}
$acord ='';
//echo $resp_style;
$array_count='';
$array_count=sizeof($tabarr);
$newtab='';
$newtab .='<ul id='.$advanced_tabs_id.' class="ult_tabmenu '.$style.' '.$tab_style_no.'" style="'.$tab_border.'">';
$cnt=0;
//print_r($tabarr );

$acord .='';
$accontaint='';
$ult_ac_border='';
foreach ($tabarr as $key => $value) {
		$cnt++;


	 $icon_position=$font_icons_position;
	 //echo $disp_icon;
	if($disp_icon=='Disables'){
	$icon_position='none';
	}
	 $tabicon=$value["icon"];
	 $icon_color=$icon_color;
	 $icon_size=$icon_size;
	 $icon_hover_color=$icon_hover_color;
	 $margin=$icon_margin;
  	 $tab_id=$value["tab_id"];
	$accontaint=$value['content'];
	$accontaint=wpb_js_remove_wpautop( $accontaint );
	 $ul_sub_class = $value['ul_sub_class'];
	/*---icon style---*/
	 $icon_size;
if($icon_size ==''){
	$icon_size ="15";
}
$tab_icon_style='';
$tab_icon_style .='color:'.$icon_color.';';
$tab_icon_style .='font-size:'.$icon_size.'px;';
$tab_icon_style .= $margin;
$link_li_style='';
$bgcolor='';
if($tab_style!='Style_2'){
$link_li_style.='background-color:'.$tab_background_color.';';
}
else{
	$bgcolor .='background-color:'.$tab_background_color.';';

}
$style5bgcolor='';
if($tab_style=='Style_5'||$tab_style=='Style_6'){
		$style5bgcolor='border-color:'.$shadow_color.';';
		$ult_top='ult_top';
	}

if($tab_style=='Style_4'){
	$ult_top='ult_top';
	$link_li_style.='';
	$link_li_style .='border-color:'.$border_color.';';
	$link_li_style .='border-width:'.$border_thickness.'px;';
	$link_li_style .='border-style:solid;';

}
if($tab_style=='Style_1'||$tab_style=='Style_3'){

	$link_li_style.='';
	$link_li_style .='border-color:'.$border_color.';';
	$link_li_style .='border-width:'.$border_thickness.'px;';
	$link_li_style .='border-style:solid;';

}

/*---------------- for tabs border -----------------*/

if($tab_style!='Style_2'){
	if($cnt==$array_count){
		$link_li_style.='border-top-right-radius:'.$tabs_border_radius.'px;';
	}
	else if($cnt==1){
		$link_li_style.='border-top-left-radius:'.$tabs_border_radius.'px;';
	}

}
else{

	if($cnt==$array_count){
		$bgcolor .='border-top-right-radius:'.$tabs_border_radius.'px;';
	}
	else if($cnt==1){
		$bgcolor.='border-top-left-radius:'.$tabs_border_radius.'px;';
	}

}

/*------------ accordian border style --------------*/

	$ult_ac_border .='border-bottom-color:'.$border_color.';';
	$ult_ac_border .='border-bottom-width:'.$border_thickness.'px;';
	$ult_ac_border .='border-bottom-style:solid;';

	if(isset($value['title'])) {
		//echo $icon_position;
			if($icon_position=='Right')
				{
				$icon_position='right';
				$newtab .='<li class="ult_tab_li '.$ult_style.' '.$ul_sub_class.' " data-iconcolor="'.$icon_color.'" data-iconhover="'.$icon_hover_color.'" style="'.$link_li_style.'">
					<a href="#'.$tab_id.'" id="'.$tab_id.'" style="color:'.$tab_title_color.';'.$bgcolor.';'.$style5bgcolor.' '.$tab_css.'" class="ult_a '.$css_class .'">
					   <span class="ult_tab_main  '.$resp_style.' ">
					    <span class="ult_tab_section">
					  		<span '.$advanced_tabs_data_list.' class="ult-span-text ult-responsive" style="'.$tabs_nav_style.'">'.$value['title'].'</span>
						   	<span class="aio-icon none ult_tab_icon'.$icon_position.'" style="'.$tab_icon_style.'">
						   	<i class=" '.$tabicon.' ult_tab_icon"  ></i>
						   </span>
						</span>
					   </span>

					</a>
					</li>';

	/*-------------------accordion right icon------------------*/

				$acord.='<dt class="'.$ul_sub_class.'">
        	<a class="ult-tabto-actitle withBorder ult_a" id="'.$tab_id.'" style="color:'.$tab_title_color.';'.$style5bgcolor.';background-color:'.$tab_background_color.';'.$ult_ac_border.'" href="#'.$tab_id.'">
        		<i class="accordion-icon">+</i>
        			<span class="ult_tab_main ult_ac_main'.$resp_style.'">
					   <span '.$advanced_tabs_data_list.' class="ult-span-text ult_acordian-text ult-responsive" style="'.$tabs_nav_style.';color:inherit " >'.$value['title'].'</span>
					</span>
					   <div class="aio-icon none " style="'.$tab_icon_style.'" data-iconcolor="'.$icon_color.'" data-iconhover="'.$icon_hover_color.'">
					   <i class="  '.$tabicon.' ult_tab_icon"  ></i>
					   </div>
					</a></dt>
            		<dd class="ult-tabto-accordionItem ult-tabto-accolapsed">
			            <div class="ult-tabto-acontent" style="'.$contain_bg.'">
			               '.$accontaint .'
			            </div>
        	</dd>';

				}
				else if($icon_position=='Left'){
				$icon_position='left';
					$newtab .='<li class="ult_tab_li '.$ult_style.' '.$ul_sub_class.'" data-iconcolor="'.$icon_color.'" data-iconhover="'.$icon_hover_color.'" style="'.$link_li_style.'">
					<a href="#'.$tab_id.'" id="'.$tab_id.'" style="color:'.$tab_title_color.';'.$bgcolor.';'.$style5bgcolor.' '.$tab_css.'" class="ult_a  '.$css_class .'">
					     <span class="ult_tab_main '.$resp_style.'">
					      <span class="ult_tab_section">
						   <span class="aio-icon none ult_tab_icon'.$icon_position.'" style="'.$tab_icon_style.'">
						   <i class="  '.$tabicon.' ult_tab_icon"  ></i>
						   </span>
						   <span '.$advanced_tabs_data_list.' class="ult-span-text ult-responsive" style="'.$tabs_nav_style.'">'.$value['title'].'</span>
						    </span >
						</span>
					</a>
					</li>';

/*-------------------accordion left icon------------------*/

				$acord.='<dt class="'.$ul_sub_class.'">
        	<a class="ult-tabto-actitle withBorder ult_a"  id="'.$tab_id.'" style="color:'.$tab_title_color.';'.$style5bgcolor.';background-color:'.$tab_background_color.';'.$ult_ac_border.'" href="#'.$tab_id.'">
        		<i class="accordion-icon">+</i>
        			<span class="ult_tab_main ult_ac_main'.$resp_style.'">
					   <div class="aio-icon none " style="'.$tab_icon_style.'" data-iconcolor="'.$icon_color.'" data-iconhover="'.$icon_hover_color.'">
					   <i class="  '.$tabicon.' ult_tab_icon"  ></i>
					   </div>
					<span '.$advanced_tabs_data_list.' class="ult-span-text ult_acordian-text ult-responsive" style="'.$tabs_nav_style.';color:inherit " >'.$value['title'].'</span>
					</span></a></dt>
            		<dd class="ult-tabto-accordionItem ult-tabto-accolapsed">
			            <div class="ult-tabto-acontent" style="'.$contain_bg.'">
			               '.$accontaint .'
			            </div>
        	</dd>';
				}
		     	else if($icon_position=='Top')
				{
					$newtab .='<li class="ult_tab_li '.$ult_style.' '.$ul_sub_class.'" data-iconcolor="'.$icon_color.'" data-iconhover="'.$icon_hover_color.'" style="'.$link_li_style.'">
					<a href="#'.$tab_id.'" id="'.$tab_id.'"  style="color:'.$tab_title_color.';'.$bgcolor.';'.$style5bgcolor.' '.$tab_css.'" class="ult_a '.$icon_top_link.' '.$css_class .'">
					    <span class="ult_tab_main '.$ult_top.' '.$resp_style.' ">
					    <span class="ult_tab_section">
					   <span class="aio-icon none icon-top ult_tab_icon'.$icon_position.'"  style="'.$tab_icon_style.'">
					   <i class="  '.$tabicon.' ult_tab_icon" ></i>
					   </span>
					   <span '.$advanced_tabs_data_list.' class="ult-span-text ult-responsive" style="'.$tabs_nav_style.'">'.$value['title'].'</span>
					   </span>
						</span>
					</a>
					</li>';

/*-------------------accordion top icon------------------*/

				$acord.='<dt class="'.$ul_sub_class.'">
	        	<a class="ult-tabto-actitle withBorder ult_a" id="'.$tab_id.'"  style="color:'.$tab_title_color.';'.$style5bgcolor.';background-color:'.$tab_background_color.';'.$ult_ac_border.'" href="#'.$tab_id.'">
	        		<i class="accordion-icon">+</i>
	        			<span class="ult_tab_main ult_ac_main ult_top ' .$resp_style.'">
						   <span class="aio-icon none icon-top" style="'.$tab_icon_style.'" data-iconcolor="'.$icon_color.'" data-iconhover="'.$icon_hover_color.'">
						   <i class="  '.$tabicon.' ult_tab_icon"  ></i>
						   </span>
						<span '.$advanced_tabs_data_list.' class="ult-span-text ult_acordian-text ult-responsive" style="'.$tabs_nav_style.';color:inherit " >'.$value['title'].'</span>
						</span></a></dt>
	            		<dd class="ult-tabto-accordionItem ult-tabto-accolapsed">
				            <div class="ult-tabto-acontent" style="'.$contain_bg.'">
				               '.$accontaint .'
				            </div>
	        	</dd>';

				}
			  	 else {
					$icon_position='none';
					$newtab .='<li class="ult_tab_li '.$ult_style.' '.$ul_sub_class.'" data-iconcolor="'.$icon_color.'" data-iconhover="'.$icon_hover_color.'" style="'.$link_li_style.'">
					<a href="#'.$tab_id.'"  id="'.$tab_id.'"  style="color:'.$tab_title_color.';'.$bgcolor.';'.$style5bgcolor.' '.$tab_css.' " class="ult_a '.$ult_style.' '.$css_class .'">
					     <span class="ult_tab_main '.$resp_style.' ">
					 		 <span class="ult_tab_section">
					   			<span '.$advanced_tabs_data_list.' class="ult-span-text no_icon ult_tab_display_text ult-responsive" style="'.$tabs_nav_style.';">'.$value['title'].'</span>
					   		</span>
						</span>
					</a>
					</li>';

/*-------------------accordion without icon------------------*/

				$acord.='<dt class="'.$ul_sub_class.'">
	        	<a class="ult-tabto-actitle withBorder ult_a " id="'.$tab_id.'" style="color:'.$tab_title_color.';'.$style5bgcolor.';background-color:'.$tab_background_color.';'.$ult_ac_border.'" href="#'.$tab_id.'">
	        		<i class="accordion-icon">+</i>
	        			<span class="ult_tab_main ult_ac_main ult_noacordicn' .$resp_style.'">

						<span '.$advanced_tabs_data_list.' class="ult-span-text no_icon ult_acordian-text ult-responsive" style="'.$tabs_nav_style.';color:inherit " >'.$value['title'].'</span>
						</span></a></dt>
	            		<dd class="ult-tabto-accordionItem ult-tabto-accolapsed">
				            <div class="ult-tabto-acontent" style="'.$contain_bg.'">
				               '.$accontaint .'
				            </div>
	        			</dd>';

		     	 }

   	    }
 }
 $newtab .='</ul>';

$newtabcontain='';
$newtabcontain.='<div class="ult_tab_min_contain">';
$newtabcontain .='<div class="ult_tabitemname" style="color:inherit">';
$newtabcontain .=wpb_js_remove_wpautop( $content );
$newtabcontain .='</div>';
$newtabcontain .='</div>';
$op='';
$op .='<div id="'.$advanced_tabs_desc_id.'" class="ult_tabs '.$el_class.'" style="'.$container_style.' '.$wrapper_margin.'" data-tabsstyle="'.$style.'"
 data-titlebg="'.$tab_background_color.'" data-titlecolor="'.$tab_title_color.'" data-fullheight="'.$tab_max.'"
 data-titlehoverbg="'.$tab_hover_background_color.'" data-titlehovercolor="'.$tab_hover_title_color.'"
 data-rotatetabs="'.$interval.'" data-responsivemode="'.$resp_style.'" data-animation="'.$tab_animation.'"
data-activetitle="'.$acttab_title.'" data-activeicon="'.$act_icon_color.'" data-activebg="'.$acttab_background.'"  data-respmode="'.$resp_type.'" data-respwidth="'.$resp_width.'" data-scroll = "'.$smooth_scroll.'">';
$op .=$newtab;
$op .='<div '.$advanced_tabs_desc_data_list.'class="ult_tabcontent ult-responsive '.$style.'" style="'.$contain_bg.'">';
$tabanimatclass="";
if($tab_animation=='Slide-Zoom'){

	$tabanimatclass="tabanimate";
}
$op .='<div class="ult_tab_min_contain '.$tabanimatclass.'" >';
$op .=wpb_js_remove_wpautop( $content );
$op .='</div>';
$op .='</div>';
$op .='</div>';
ob_start();
//return $op;
echo $op;

/*---------------- for acordian -----------------*/
$actab='';
$actab .='<div class="ult_acord">
   <div class="ult-tabto-accordion " style="width:;"
    data-titlecolor="'.$tab_title_color.'"  data-titlebg="'.$tab_background_color.'"
     data-titlehoverbg="'.$tab_hover_background_color.'" data-titlehovercolor="'.$tab_hover_title_color.'" data-animation="'.$tab_animation.'"
     data-activetitle="'.$acttab_title.'" data-activeicon="'.$act_icon_color.'" data-activebg="'.$acttab_background.'" data-scroll = "'.$smooth_scroll.'" >
     <dl>';

$actab .=$acord;
$actab .='
    	</dl>
    <!--<div class="extraborder" style="background-color:'.$tab_hover_background_color.'"></div>-->
</div>

</div>';

//return $actab;
echo $actab;
return ob_get_clean();

		}



function ult_tab_init() {

	$tab_id_1 = time() . '-1-' . rand( 0, 100 );
	$tab_id_2 = time() . '-2-' . rand( 0, 100 );

	$settings = array(
		'name'    => __('Advanced Tabs') ,
		'base'    => 'ult_tab_element',
		"category" => __("Ultimate VC Addons","ultimate_vc"),
		"description" => __("Create nice looking tabs.","ultimate_vc"),
		 "class" => "ult_tab_eleicon",
		//'show_settings_on_create' => false,
		'is_container' => true,
		'weight'                  => - 5,
		'html_template'           => dirname( __FILE__ ) . '../vc_templates/ult_tab_element.php',
		'admin_enqueue_css'       => preg_replace( '/\s/', '%20', plugins_url( '../admin/vc_extend/css/sub-tab.css', __FILE__ ) ),
		'js_view'                 => 'UltimateTabView',
		// JS View name for backend. Can be used to override or add some logic for shortcodes in backend (cloning/rendering/deleting/editing).
		'icon' => 'icon-wpb-ui-tab-content ult_tab_eleicon',
		'params'                  => array(

		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Style"),
			"param_name" => "tab_style",
			"value" => array('Style 1'=>'Style_1','Style 2'=>'Style_2','Style 3'=>'Style_3','Style 4'=>'Style_4','Style 5'=>'Style_5','Style 6'=>'Style_6'),
			"group" => "General ",
		),

		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Animation"),
			"param_name" => "tab_animation",
			"value" => array(
				'Vertical Slide '=>'',
				'Horizontal Slide'=>'Slide-Horizontal',
				'Slide-Zoom'=>'Slide-Zoom',
				'Fade'=>'Fade',
				'Scale'=>'Scale',
				'None'=>'None' ),

			"group" => "General ",

		),

		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __(" Auto Rotate Tabs"),
			"param_name" => "auto_rotate",
			"value" => array("Disable" =>"Disables","Enable" =>"Enable"),
			"group" => "General ",
			),

		array(
			'type' => 'number',
			'heading' => __( 'Auto Rotate Interval', 'ultimate_vc' ),
			'param_name' => 'interval',
			//'std' => 2,
			'value'=>'',
			"suffix" => "seconds",
			"dependency" => Array("element" => "auto_rotate","value" => array("Enable")),
			"group" => "General ",

		),
		array(
			'type' => 'number',
			'heading' => __( 'Tab Element Width' ),
			'value'=>'',
			"min" => 300,
			"suffix" => "px",
			'param_name' => 'container_width',
			'description' => __( 'Adjust width of your tab section. Keep empty for full width.' ),
			"group" => "General ",
			),
		array(
			"type" => "ult_switch",
			"class" => "",
			//"heading" => __("Want To show button in responsive mode", "ultimate_vc"),
			"param_name" => "tab_max",
			// "admin_label" => true,
			"value" => "off",
			"default_set" => true,
			"options" => array(
				"on" => array(
					"label" => __("Apply Max height to container?","ultimate_vc"),
					"off" => __("No","ultimate_vc"),
					"on" => __("Yes","ultimate_vc"),
				  ),
			  ),
			"description" => __("Apply Max height to container?", 'ultimate_vc'),
			"group" => "General ",
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra Class Name', 'ultimate_vc' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'ultimate_vc' ),
			"group" => "General ",
		),


		/*---------tab----------------*/

		array(
			"type" => "colorpicker",
			"heading" => __("Tab Title Color"),
			"param_name" => "tab_title_color",
			"value" => "",
			"group" => "Tab",

		),

		array(
			"type" => "colorpicker",
			"heading" => __(" Tab Background Color"),
			"param_name" => "tab_background_color",
			"value" => "",
			"group" => "Tab",
			"edit_field_class" => "vc_col-sm-12 vc_column ult_space_border",
		),


		array(
			"type" => "colorpicker",
			"heading" => __(" Tab Hover Title Color"),
			"param_name" => "tab_hover_title_color",
			"value" => "",
			"group" => "Tab",

		),
		array(
			"type" => "colorpicker",
			"heading" => __(" Tab Hover Background Color"),
			"param_name" => "tab_hover_background_color",
			"value" => "",
			"group" => "Tab",
			"edit_field_class" => "vc_col-sm-12 vc_column ult_space_border",
		),

		array(
			"type" => "colorpicker",
			"heading" => __("Tab Active Title Color"),
			"param_name" => "acttab_title",
			"value" => "",
			"group" => "Tab",
			),

		array(
			"type" => "colorpicker",
			"heading" => __("Tab Active Background Color"),
			"param_name" => "acttab_background",
			"value" => "",
			"group" => "Tab",
			"edit_field_class" => "vc_col-sm-12 vc_column ult_space_border",
		),
		array(
            "type" => "ultimate_spacing",
            "heading" => "Tab Padding",
            "param_name" => "tab_css",
            "mode"  => "padding",                    //  margin/padding
            "unit"  => "px",                        //  [required] px,em,%,all     Default all
            "positions" => array(                   //  Also set 'defaults'
              	"Top" => "",
              	"Right" => "",
              	"Bottom" => "",
              	"Left" => "",
            ),
			"group" => "Tab",
			"description" => __("Adjust inside spacing of tabs.", "ultimate_vc"),
			"dependency" => Array("element" => "tab_style","value" => array("Style_4","Style_1","Style_3","Style_5","Style_6")),
			"edit_field_class" => "vc_col-sm-12 vc_column ult_space_border",
		 ),


			array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Tab Border"),
			"param_name" => "tab_bottom_border",
			"value" => array('Disable'=>'Disable','Enable'=>'Enable'),
			"dependency" => Array("element" => "tab_style","value" => array("Style_1","Style_3","Style_4")),
			"group" => "Tab",
		),

		array(
			"type" => "colorpicker",
			"heading" => __("Tab Border Color"),
			"param_name" => "border_color",
			"value" => "",
			"dependency" => Array("element" => "tab_bottom_border","value" => array("Enable")),
			"group" => "Tab",
			),

		array(
			'type' => 'number',
			"class" => "",
			'heading' => __( 'Tab Border Thickness' ),
			'param_name' => 'border_thickness',
			"dependency" => Array("element" => "tab_bottom_border","value" => array("Enable")),
			'min'=>'1',
			'value' => '',
			'suffix'=>'px',
			"group" => "Tab",
			),
		array(
			"type" => "number",
			"class" => "",
			"heading" => __("Tab Border Radius", "ultimate_vc"),
			"param_name" => "tabs_border_radius",
			"value" => "",
			"min" => 1,
			"max" => 100,
			"suffix" => "px",
			"description" => __("This border will assign to border-top-left and border-top-right for first and last tab element . As you increase the value, the shape convert in circle slowly. (e.g 100 pixels).", "ultimate_vc"),
			"group" => "Tab",
			"edit_field_class" => "vc_col-sm-12 vc_column ult_space_border",
		),
		array(
			"type" => "colorpicker",
			"heading" => __("Tab Shaddow Color"),
			"param_name" => "shadow_color",
			"value" => "",
			"dependency" => Array("element" => "tab_style","value" => array("Style_5","Style_6")),
			"group" => "Tab",

		),
		/*---------icon----------------*/
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Display Icon"),
			"param_name" => "disp_icon",
			"value" => array("Enable" =>"Enable","Disable" =>"Disables"),
			"group" => "Icon ",
			"description" => __("Display icon with tab title.", "ultimate_vc"),
			),

		array(
				"type" => "ult_param_heading",
				"param_name" => "icon_text_setting",
				"text" => __("Please choose icon from Subtab settings ", "ultimate_vc"),
				"value" => "",
				"class" => "",
				"group" => "Icon ",
				'edit_field_class' => 'ult-param-heading-wrapper  vc_column vc_col-sm-12 ult_tabicon_notice',
			),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Icon Position"),
			"param_name" => "font_icons_position",
			"value" => array(//'None'=>'None',
							'Right'=>'Right',
							'Left'=>'Left',
							'Top'=>'Top',
							),
			"group" => "Icon ",
			"dependency" => Array("element" => "disp_icon","value" => array("Enable")),
		),
		array(
			"type" => "number",
			'heading' => __( 'Icon Size', 'smile' ),
			'param_name' => 'icon_size',
			"value" => "",
			"min" => 15,
			"max" => 72,
			"suffix" => "px",
			"group" => "Icon ",
			"dependency" => Array("element" => "disp_icon","value" => array("Enable")),
			"edit_field_class" => "vc_col-sm-12 vc_column ult_space_border",
		),
		array(
			"type" => "colorpicker",
			"heading" => __("Icon Color", "smile"),
			"param_name" => "icon_color",
			"value" => "",
			"group" => "Icon ",
			"dependency" => Array("element" => "disp_icon","value" => array("Enable")),
		),
		array(
			"type" => "colorpicker",
			"heading" => __("Icon Hover Color", "smile"),
			"param_name" => "icon_hover_color",
			"value" => "",
			"group" => "Icon ",
			"dependency" => Array("element" => "disp_icon","value" => array("Enable")),
		),
		array(
			"type" => "colorpicker",
			"heading" => __("Icon Active Color"),
			"param_name" => "act_icon_color",
			"value" => "",
			"group" => "Icon ",
			"dependency" => Array("element" => "disp_icon","value" => array("Enable")),
			"edit_field_class" => "vc_col-sm-12 vc_column ult_space_border",
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
            "group" => "Icon ",
			"dependency" => Array("element" => "disp_icon","value" => array("Enable")),
			"description" => __("Adjust spacing of icon.", "ultimate_vc"),
        ),


		/*--------------container-----------*/

		array(
			"type" => "colorpicker",
			"heading" => __("Container Text Color"),
			"param_name" => "tab_describe_color",
			"value" => "",
			"group" => "Container ",
		),
		array(
			"type" => "colorpicker",
			"heading" => __("Container Background Color"),
			"param_name" => "enable_bg_color",
			"value" => "",
			"group" => "Container ",

		),
		array(
			"type" => "ultimate_border",
			"heading" => __("Container Border","ultimate_vc"),
			"param_name" => "container_border_style1",
			"unit"     => "px",                        //  [required] px,em,%,all     Default all
			"positions" => array(
				__("Top","ultimate_vc")     => "",
				__("Right","ultimate_vc")   => "",
				__("Bottom","ultimate_vc")  => "",
				__("Left","ultimate_vc")    => ""
			),
			//"enable_radius" => false,                   //  Enable border-radius. default true
			"radius" => array(
				__("Top Left","ultimate_vc")        => "",                // use 'Top Left'
			  	__("Top Right","ultimate_vc")       => "",                  // use 'Top Right'
			  	__("Bottom Right","ultimate_vc")    => "3",                // use 'Bottom Right'
			 	__("Bottom Left","ultimate_vc")     => "3"                   // use 'Bottom Left'
			),
			"label_color"   => __("Container Border Color","ultimate_vc"),       //  label for 'border color'   default 'Border Color'
			"label_radius"  => __("Container Border Radius","ultimate_vc"),        //  label for 'radius'  default 'Border Redius'
			//"label_border"  => "Border Style",       //  label for 'style'   default 'Border Style'
			"group" => "Container ",
		),

		/*-------------design-------------*/
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Responsive Mode for Tabs "),
			"param_name" => "resp_type",
			"value" => array('Tabs'=>'Tabs',
							 'Accordion'=>'Accordion',
							 ),

			"group" => "Responsive",
			"description" => __("Display normal tab or convert them into accordion on responsive devices.", "ultimate_vc"),
		),

		array(
			"type" => "number",
			"class" => "",
			"heading" => __("Responsive Width", "ultimate_vc"),
			"param_name" => "resp_width",
			"value" => "",
			"min" => 300,
			"max" => 1200,
			"suffix" => "px",
			"description" => __("Enable accordion below this width.", "ultimate_vc"),
			"dependency" => Array("element" => "resp_type","value" => array("Accordion")),
			"group" => "Responsive",

		),
		array(
			"type" => "ult_switch",
			"class" => "",
			//"heading" => __("Want To show button in responsive mode", "ultimate_vc"),
			"param_name" => "smooth_scroll",
			// "admin_label" => true,
			"value" => "on",
			"default_set" => true,
			"options" => array(
				"on" => array(
					"label" => __("Scroll to Top of Container","ultimate_vc"),
					"off" => __("No","ultimate_vc"),
					"on" => __("Yes","ultimate_vc"),
				  ),
			  ),
			"description" => __("If enable, tab will adjust on viewport on click.", "ultimate_vc"),
			"dependency" => Array("element" => "resp_type","value" => array("Accordion")),
			"group" => "Responsive",
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Responsive Mode Visibility "),
			"param_name" => "resp_style",
			"value" => array(
								'Both'=>'Both',
								'Icon'=>'Icon',
							 	'Title'=>'Title',
							),

			"group" => "Responsive",
			"dependency" => Array("element" => "resp_type","value" => array("Tabs")),
			"description" => __("Choose what you want to display on responsive devices.", "ultimate_vc"),
		),



/*-----------typography------------*/

		array(
			"type" => "text",
			"heading" => __("<h2>Title Settings</h2>"),
			"param_name" => "main_title_typograpy",
			"group" => "Typography",
			),

		array(
			"type" => "ultimate_google_fonts",
			"heading" => __("Title Font Family", "imedica"),
			"param_name" => "main_heading_font_family",
			"description" => __("Select the font of your choice. You can <a target='_blank' href='".admin_url('admin.php?page=bsf-google-font-manager')."'>add new in the collection here</a>.", "imedica"),
			"group" => "Typography",
			),

		array(
			"type" => "ultimate_google_fonts_style",
			"heading" 		=>	__("Font Style", "imedica"),
			"param_name"	=>	"title_font_style",
			"group" => "Typography",
			),


		// array(
		// 	"type" => "number",
		// 	"param_name" => "title_font_size",
		// 	"heading" => " Font size",
		// 	"value" => "",
		// 	"suffix" => "px",
		// 	"group" => "Typography"
		// 	),
		// array(
		// 	"type" => "number",
		// 	"param_name" => "title_line_ht",
		// 	"heading" => " Line Height",
		// 	"value" => "",
		// 	"suffix" => "px",
		// 	"group" => "Typography",
		// 	"edit_field_class" => "vc_col-sm-12 vc_column ult_space_border",
		// 	),

		array(
            "type" => "ultimate_responsive",
            "class" => "",
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
                "group" => "Typography",
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
                "group" => "Typography",
            ),

		array(
			"type" => "text",
			"heading" => __("<h2>Container Description </h2>"),
			"param_name" => "main_desc_typograpy",
			"group" => "Typography",
			),

		array(
			"type" => "ultimate_google_fonts",
			"heading" => __(" Font Family", "smile"),
			"param_name" => "desc_font_family",
			"description" => __("Select the font of your choice. You can <a target='_blank' href='".admin_url('admin.php?page=bsf-google-font-manager')."'>add new in the collection here</a>.", "smile"),
			"group" => "Typography",
			),

		array(
			"type" => "ultimate_google_fonts_style",
			"heading" 		=>	__("Font Style", "imedica"),
			"param_name"	=>	"desc_font_style",
			"group" => "Typography",
			),
		// array(
		// 	"type" => "number",
		// 	"param_name" => "desc_font_size",
		// 	"heading" => " Font size",
		// 	"value" => "",
		// 	"suffix" => "px",
		// 	"group" => "Typography"
		// 	),

		// array(
		// 	"type" => "number",
		// 	"param_name" => "desc_line_ht",
		// 	"heading" => " Line Height",
		// 	"value" => "",
		// 	"suffix" => "px",
		// 	"group" => "Typography",
		// 	),
		array(
            "type" => "ultimate_responsive",
            "class" => "",
            "heading" => __("Font size", 'ultimate_vc'),
            "param_name" => "desc_font_size",
            "unit" => "px",
            "media" => array(
                "Desktop" => '',
                "Tablet" => '',
                "Tablet Portrait" => '',
                "Mobile Landscape" => '',
                "Mobile" => '',
                ),
                "group" => "Typography",
            ),
            array(
            "type" => "ultimate_responsive",
            "class" => "",
            "heading" => __("Line Height", 'ultimate_vc'),
            "param_name" => "desc_line_ht",
            "unit" => "px",
            "media" => array(
                "Desktop" => '',
                "Tablet" => '',
                "Tablet Portrait" => '',
                "Mobile Landscape" => '',
                "Mobile" => '',
                ),
                "group" => "Typography",
            ),
            array(
                "type" => "ultimate_spacing",
                "heading" => " Wrapper Margin ",
                "param_name" => "wrapper_margin",
                "mode"  => "margin",                    //  margin/padding
                "unit"  => "px",                        //  [required] px,em,%,all     Default all
                "positions" => array(                   //  Also set 'defaults'
                      "Top" => "",
                      "Right" => "",
                      "Bottom" => "",
                      "Left" => "",
                ),
                 'group' => __( 'Design ', 'ultimate_vc' ),
                 "description" => __("Add or remove margin for wrapper.", "ultimate_vc"),
            ),

		/*----------end----------*/
		),
'custom_markup' => '<div class="wpb_tabs_holder wpb_holder vc_container_for_children">
									<ul class="tabs_controls">
									</ul>
									%content%
									</div>'	,

'default_content' => '[single_tab title="' . __( 'Tab 1', 'ultimate_vc' ) . '" tab_id="' . $tab_id_1 . ' ][/single_tab]
					  [single_tab title="' . __( 'Tab 2', 'ultimate_vc' ) . '" tab_id="' . $tab_id_2 . ' ][/single_tab]
									',
	);
if(function_exists('vc_map')){
	vc_map( $settings );
}


/* ---for single tabs element-------------*/
if(function_exists('vc_map')){
vc_map( array(
	'name' => __( 'SubTab', 'ultimate_vc' ),
	'base' => 'single_tab',
	"icon" => "ult_tab_eleicon",
	"class" => "ult_tab_eleicon",
	'allowed_container_element' => 'vc_row',
	'is_container' => true,
	'content_element' => true,
	"as_child" => array('only' => 'ult_tab_element'),
	'html_template'  => dirname( __FILE__ ) . '/vc_templates/single_tab.php',
	//'admin_enqueue_js'  => preg_replace( '/\s/', '%20', plugins_url( 'vc_extend/js/single_element_js.js', __FILE__ ) ),
	'js_view'     => 'UltimateSubTabView',
	'params' => array(

		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'ultimate_vc' ),
			'param_name' => 'title',

		),

		array(
			'type' => 'tab_id',
			"edit_field_class" => " vc_col-sm-12 vc_column wpb_el_type_textfield vc_shortcode-param",
			'heading' => __( 'Tab ID', 'ultimate_vc' ),
			'param_name' => "tab_id"
		),




		array(
			"type" => "icon_manager",
			"class" => "",
			"heading" => __("Select Icon ","smile"),
			"param_name" => "icon",
			"value" => "",
			"group" =>"Icon",
			"description" => __("Click and select icon of your choice. If you can't find the one that suits for your purpose, you can <a href='admin.php?page=bsf-font-icon-manager' target='_blank'>add new here</a>.", "smile"),
			//"dependency" => Array("element" => "font_icons_position","value" => array("Right","Left","Top","Bottom")),
		),



		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'ultimate_vc' ),
			'param_name' => 'ul_sub_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'ultimate_vc' ),
			//"group" => "General ",
		),

	),

) );

}


function ultimate_tabs() {
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
	wp_register_script('ult_tabs_rotate',plugins_url( $js_path.'tabs'.$ext.'.js', __FILE__ ),array( 'jquery'),ULTIMATE_VERSION,true);
	wp_register_style('ult_tabs',plugins_url( $css_path.'tabs'.$ext.'.css', __FILE__ ));
	wp_register_script('ult_tabs_acordian_js',plugins_url( $js_path.'tabs-accordion'.$ext.'.js', __FILE__ ),array( 'jquery'),ULTIMATE_VERSION,true);
	wp_register_style('ult_tabs_acordian',plugins_url( $css_path.'tabs-accordion'.$ext.'.css', __FILE__ ));
}

function ultimate_tabs_admin() {
	$screen = get_current_screen();
	$screen_id = $screen->base;
	if($screen_id !== 'post')
		return false;
	wp_register_script('tab-js-1', plugins_url( '../admin/vc_extend/js/ult_tab_admin_enqueue_js.js', __FILE__ ),array( 'jquery'),ULTIMATE_VERSION,true);
	wp_register_script('tab-js-2', plugins_url( '../admin/vc_extend/js/single_element_js.js', __FILE__ ),array( 'jquery'),ULTIMATE_VERSION,true);

	wp_enqueue_script('tab-js-1');
	wp_enqueue_script('tab-js-2');
	//wp_enqueue_style('css-1',plugins_url( '../admin/vc_extend/css/sub-tab.css', __FILE__ ));
}



}//end of vcmap function


	}
}

if(class_exists('ULT_TAB_ELEMENT'))
{

$ULT_TAB_ELEMENT = new ULT_TAB_ELEMENT;

}

if ( class_exists( "WPBakeryShortCode" ) ) {
		// Class Name should be WPBakeryShortCode_Your_Short_Code
		// See more in vc_composer/includes/classes/shortcodes/shortcodes.php
		class WPBakeryShortCode_ULT_TAB_ELEMENT extends WPBakeryShortCode {
					static $filter_added = false;
					protected $controls_css_settings = 'out-tc vc_controls-content-widget';
					protected $controls_list = array('edit', 'clone', 'delete');
					public function __construct( $settings ) {
								parent::__construct( $settings ); // !Important to call parent constructor to active all logic for shortcode.
								if ( ! self::$filter_added ) {
									$this->addFilter( 'vc_inline_template_content', 'setCustomTabId' );
									self::$filter_added = true;
								}
					}

		public function contentAdmin( $atts, $content = null ) {
					$width = $custom_markup = '';
					$shortcode_attributes = array( 'width' => '1/1' );
						foreach ( $this->settings['params'] as $param ) {
								if ( $param['param_name'] != 'content' ) {
									//$shortcode_attributes[$param['param_name']] = $param['value'];
									if ( isset( $param['value'] ) && is_string( $param['value'] ) ) {
										$shortcode_attributes[$param['param_name']] = __( $param['value'], "ultimate_vc" );
									} elseif ( isset( $param['value'] ) ) {
										$shortcode_attributes[$param['param_name']] = $param['value'];
									}
								} else if ( $param['param_name'] == 'content' && $content == NULL ) {
									//$content = $param['value'];
									$content = __( $param['value'], "ultimate_vc" );
								}
							}
					extract( shortcode_atts(
						$shortcode_attributes
						, $atts ) );

					// Extract tab titles

					preg_match_all( '/vc_tab title="([^\"]+)"(\stab_id\=\"([^\"]+)\"){0,1}/i', $content, $matches, PREG_OFFSET_CAPTURE );

					$output = '';
					$tab_titles = array();

					if ( isset( $matches[0] ) ) {
						$tab_titles = $matches[0];
					}
					$tmp = '';
					if ( count( $tab_titles ) ) {
						$tmp .= '<ul class="clearfix tabs_controls">';
						foreach ( $tab_titles as $tab ) {
							preg_match( '/title="([^\"]+)"(\stab_id\=\"([^\"]+)\"){0,1}/i', $tab[0], $tab_matches, PREG_OFFSET_CAPTURE );
							if ( isset( $tab_matches[1][0] ) ) {
								$tmp .= '<li><a href="#tab-' . ( isset( $tab_matches[3][0] ) ? $tab_matches[3][0] : sanitize_title( $tab_matches[1][0] ) ) . '">' . $tab_matches[1][0]. '</a></li>';

							}
						}
						$tmp .= '</ul>' . "\n";
					} else {
						$output .= do_shortcode( $content );
					}



					$elem = $this->getElementHolder( $width );

					$iner = '';
					foreach ( $this->settings['params'] as $param ) {
						$custom_markup = '';
						$param_value = isset( $param['param_name'] ) ? $param['param_name'] : '';
						if ( is_array( $param_value ) ) {
							// Get first element from the array
							reset( $param_value );
							$first_key = key( $param_value );
							$param_value = $param_value[$first_key];
						}
						$iner .= $this->singleParamHtmlHolder( $param, $param_value );
					}
					//$elem = str_ireplace('%wpb_element_content%', $iner, $elem);

					if ( isset( $this->settings["custom_markup"] ) && $this->settings["custom_markup"] != '' ) {
						if ( $content != '' ) {
							$custom_markup = str_ireplace( "%content%", $tmp . $content, $this->settings["custom_markup"] );
						} else if ( $content == '' && isset( $this->settings["default_content_in_template"] ) && $this->settings["default_content_in_template"] != '' ) {
							$custom_markup = str_ireplace( "%content%", $this->settings["default_content_in_template"], $this->settings["custom_markup"] );
						} else {
							$custom_markup = str_ireplace( "%content%", '', $this->settings["custom_markup"] );
						}
						//$output .= do_shortcode($this->settings["custom_markup"]);
						$iner .= do_shortcode( $custom_markup );
					}
					$elem = str_ireplace( '%wpb_element_content%', $iner, $elem );
					$output = $elem;

					return $output;
			}

			public function getTabTemplate() {
					return '<div class="wpb_template">' . do_shortcode( '[single_tab title="Tab" tab_id=""   icon_type="" icon="" icon_color="" icon_hover_color="" icon_size="15px" icon_background_color=""][/single_tab]' ) . '</div>';
				}

		    public function setCustomTabId( $content ) {
				return preg_replace( '/tab\_id\=\"([^\"]+)\"/', 'tab_id="$1-' . time() . '"', $content );

			}


	  }//end of tabclass



//	} // End Class

define( 'ULT_TAB_TITLE', __( "Tab", "ultimate_vc" ) );
	if(function_exists('vc_path_dir')){
	require_once vc_path_dir('SHORTCODES_DIR', 'vc-column.php');
	}

if(class_exists('WPBakeryShortCode_VC_Column')){
class WPBakeryShortCode_SINGLE_TAB extends WPBakeryShortCode_VC_Column {

						protected $controls_css_settings = 'tc vc_control-container';
						protected $controls_list = array('add', 'edit', 'clone', 'delete');
						//protected $controls_template_file = 'editors/partials/backend_controls_tab.tpl.php';

						//protected $controls_template_file = 'ultimate_vc/include/templates/editors/partials/backend_controls_tab.tpl.php';

						protected $predefined_atts = array(
								'tab_id' => ULT_TAB_TITLE,
								'title' => '',
								//'font_icons_position'=>'',
								'icon_type'=>'',
								'icon'=> '',
								'ul_sub_class'=>'',
							);



					public function __construct( $settings ) {
						parent::__construct( $settings );

					}
					public function customAdminBlockParams() {
						return ' id="tab-' . $this->atts['tab_id'] . '"';
					}

					public function mainHtmlBlockParams( $width, $i ) {
						return 'data-element_type="' . $this->settings["base"] . '" class="wpb_' . $this->settings['base'] . ' wpb_sortable wpb_content_holder"' . $this->customAdminBlockParams();
					}

					public function containerHtmlBlockParams( $width, $i ) {
						return 'class="wpb_column_container vc_container_for_children"';
					}
					public function getColumnControls( $controls, $extended_css = '' ) {

					    return $this->getColumnControlsModular($extended_css);
					}

				}
			}
}






//add_shortcode('ult_tab_element',array($this,'ultimate_tab_shortcode'));
