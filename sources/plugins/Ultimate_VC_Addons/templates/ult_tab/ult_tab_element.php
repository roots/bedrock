<?php
/* main shortcode for Tab Element*/

$output = $title = $interval = $el_class = $shadow_color=$shadow_width='';
extract( shortcode_atts( array(
	//'maintitle' => '',
	'title_color'			 	=>'',
	'auto_rotate'			 	=>'',
	'interval' 				 	=> 0,
	'tab_style'					=>'',
	'tab_bottom_border' 		=> '',
	'border_color' 				=> '',
	'border_thickness' 			=> '',
	'tab_title_color' 			=> '',
	'tab_hover_title_color' 	=> '',
	'tab_background_color' 		=> '',
	'tab_hover_background_color'=>'',
	'container_width' 			=> '',
	'el_class' 					=> '',
	'container_width'			=>'',
	'main_heading_font_family'	=>'',
    'title_font_size'			=>'',
    'title_font_wt'				=>'',
    'title_line_ht'    			=>'',
    'desc_font_family'			=>'',
    'desc_font_size'			=>'',
    'desc_font_style'			=>'',
    'desc_line_ht'    			=>'',
    'shadow_color' 				=>'',
    'shadow_width' 				=>'',
    'enable_bg_color'			=>'',
    'resp_style'				=>'',
    'container_border_style'	=>'',
	'container_color_border'	=>'',
	'cont_border_size'			=>'',
	'tabs_border_radius'		=>'',
	'tab_animation'				=>'',
	'tab_describe_color'		=>'',
	'title_font_style'			=>'',
	'css'						=>'',
	'act_icon_color'			=>'',
	'acttab_background'			=>'',
	'acttab_title'				=>'',
	'resp_type'					=>'',
	'resp_width'				=>'',
	'resp_style'				=>'',
	'ac_tabs'					=>'',
), $atts ) );
global $tabarr;
	$tabarr = array();
    do_shortcode($content);

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

$container_style=$ult_style=$tab_style_no='';
if($tab_bottom_border=='Disable'){
$border_thickness="0";
$border_color="transparent";
} 
if($container_width!=''){
	$container_style='width:'.$container_width.'px;';
}
$border_Style=$mhfont_family=$border_style ='';

$tabs_nav_style='';

if($title_font_size!='')
$tabs_nav_style .= 'font-size:'.$title_font_size.'px;';
if($title_line_ht!='')
$tabs_nav_style .='line-height:'.$title_line_ht.'px;';

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
if ( 'vc_tour' == $this->shortcode ) $element = 'wpb_tour';
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
 if($tab_style=='Style_1'){
 	$tab_border .='background-color:'.$tab_background_color.';';
 	$tab_border .='border-top-left-radius:'.$tabs_border_radius.'px;';
 	$tab_border .='border-top-right-radius:'.$tabs_border_radius.'px;';
 }
 if($tab_style=='Style_2'){
$tab_border .='border-bottom-width:0px;';
 }
  if($tab_style=='Style_4'||$tab_style=='Style_5'){
 	$tab_border .='border-bottom-width:0px;';

 }

/*-----------------content baground-------------------*/

$contain_bg='';

/*---------------- description font family-----------*/
if($desc_font_size!='')
$contain_bg .= 'font-size:'.$desc_font_size.'px;';
if($title_line_ht!='')
$contain_bg .='line-height:'.$desc_line_ht.'px;';

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

}if($tab_style=='Style_3'){
		$ult_top='ult_top';
		$icon_top_link='icon_top_link';
}

if($enable_bg_color!='')
 {
 	$contain_bg .='background-color:'.$enable_bg_color.';';
 }
if($container_border_style!=''){
	$contain_bg .='border-style:'.$container_border_style.';';
	$contain_bg .='border-color:'.$container_color_border.';';
	$contain_bg .='border-width:'.$cont_border_size.'px;';
	$contain_bg .='border-top:none;';
}
if($tab_describe_color!=''){
	$contain_bg .='color:'.$tab_describe_color.';';
}
$acord ='';
//echo $resp_style;
$array_count='';
$array_count=sizeof($tabarr);
$newtab='';
$newtab .='<ul class="ult_tabmenu '.$style.' '.$tab_style_no.'" style="'.$tab_border.'">';
$cnt=0;
//print_r($tabarr );

$acord .='';
$accontaint='';
$ult_ac_border='';
foreach ($tabarr as $key => $value) {
		$cnt++;
	

	$icon_position=$value['font_icons_position'];
	$tabicon=$value["icon"]; 
	$icon_color=$value["icon_color"]; 
	$icon_size=$value["icon_size"]; 
	$icon_hover_color=$value["icon_hover_color"]; 
     $margin=$value["icon_margin"];
	$accontaint=$value['content'];
	$accontaint=wpb_js_remove_wpautop( $accontaint );	
	/*---icon style---*/
if($icon_size==''){
	  	$icon_size="15";
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
if($tab_style=='Style_5'){
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
		
			if($icon_position=='Right')
				{
				$icon_position='right';
				$newtab .='<li class="ult_tab_li '.$ult_style.'" data-iconcolor="'.$icon_color.'" data-iconhover="'.$icon_hover_color.'" style="'.$link_li_style.'">
					<a href="#" style="color:'.$tab_title_color.';'.$bgcolor.';'.$style5bgcolor.'" class="ult_a '.$css_class .'">
					   <span class="ult_tab_main  '.$resp_style.' ">
					   <span class="ult-span-text" style="'.$tabs_nav_style.'">'.$value['title'].'</span>
					   <div class="aio-icon none " style="'.$tab_icon_style.'">
					   <i class=" '.$tabicon.' ult_tab_icon"  ></i>
					   </div>
					   </span>

					</a>
					</li>';

	/*-------------------accordion right icon------------------*/

				$acord.='<dt>
        	<a class="ult-tabto-actitle withBorder ult_a" style="color:'.$tab_title_color.';'.$style5bgcolor.';background-color:'.$tab_background_color.';'.$ult_ac_border.'" href="#">
        		<i class="accordion-icon">+</i>
        			<span class="ult_tab_main ult_ac_main'.$resp_style.'">
					   <span class="ult-span-text ult_acordian-text" style="'.$tabs_nav_style.';color:inherit " >'.$value['title'].'</span>
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
					$newtab .='<li class="ult_tab_li '.$ult_style.'" data-iconcolor="'.$icon_color.'" data-iconhover="'.$icon_hover_color.'" style="'.$link_li_style.'">
					<a href="#" style="color:'.$tab_title_color.';'.$bgcolor.';'.$style5bgcolor.'" class="ult_a  '.$css_class .'">
					     <span class="ult_tab_main '.$resp_style.'">
					   <div class="aio-icon none " style="'.$tab_icon_style.'">
					   <i class="  '.$tabicon.' ult_tab_icon"  ></i>
					   </div>
					   <span class="ult-span-text " style="'.$tabs_nav_style.'">'.$value['title'].'</span>
						</span>
					</a>
					</li>';

/*-------------------accordion left icon------------------*/

				$acord.='<dt>
        	<a class="ult-tabto-actitle withBorder ult_a" style="color:'.$tab_title_color.';'.$style5bgcolor.';background-color:'.$tab_background_color.';'.$ult_ac_border.'" href="#">
        		<i class="accordion-icon">+</i>
        			<span class="ult_tab_main ult_ac_main'.$resp_style.'">
					   <div class="aio-icon none " style="'.$tab_icon_style.'" data-iconcolor="'.$icon_color.'" data-iconhover="'.$icon_hover_color.'">
					   <i class="  '.$tabicon.' ult_tab_icon"  ></i>
					   </div>
					<span class="ult-span-text ult_acordian-text" style="'.$tabs_nav_style.';color:inherit " >'.$value['title'].'</span>
					</span></a></dt>
            		<dd class="ult-tabto-accordionItem ult-tabto-accolapsed">
			            <div class="ult-tabto-acontent" style="'.$contain_bg.'">
			               '.$accontaint .'
			            </div>
        	</dd>';	
				}
		     	else if($icon_position=='Top')
				{
					$newtab .='<li class="ult_tab_li '.$ult_style.'" data-iconcolor="'.$icon_color.'" data-iconhover="'.$icon_hover_color.'" style="'.$link_li_style.'">
					<a href="#" style="color:'.$tab_title_color.';'.$bgcolor.';'.$style5bgcolor.'" class="ult_a '.$icon_top_link.' '.$css_class .'">
					    <span class="ult_tab_main '.$ult_top.' '.$resp_style.' ">
					   <div class="aio-icon none icon-top "  style="'.$tab_icon_style.'">
					   <i class="  '.$tabicon.' ult_tab_icon" ></i>
					   </div>
					   <span class="ult-span-text" style="'.$tabs_nav_style.'">'.$value['title'].'</span>
						</span>
					</a>
					</li>';

/*-------------------accordion top icon------------------*/

				$acord.='<dt>
	        	<a class="ult-tabto-actitle withBorder ult_a" style="color:'.$tab_title_color.';'.$style5bgcolor.';background-color:'.$tab_background_color.';'.$ult_ac_border.'" href="#">
	        		<i class="accordion-icon">+</i>
	        			<span class="ult_tab_main ult_ac_main ult_top ' .$resp_style.'">
						   <div class="aio-icon none icon-top" style="'.$tab_icon_style.'" data-iconcolor="'.$icon_color.'" data-iconhover="'.$icon_hover_color.'">
						   <i class="  '.$tabicon.' ult_tab_icon"  ></i>
						   </div>
						<span class="ult-span-text ult_acordian-text" style="'.$tabs_nav_style.';color:inherit " >'.$value['title'].'</span>
						</span></a></dt>
	            		<dd class="ult-tabto-accordionItem ult-tabto-accolapsed">
				            <div class="ult-tabto-acontent" style="'.$contain_bg.'">
				               '.$accontaint .'
				            </div>
	        	</dd>';	

				}
			  	 else {
					$icon_position='none';
					$newtab .='<li class="ult_tab_li '.$ult_style.'" data-iconcolor="'.$icon_color.'" data-iconhover="'.$icon_hover_color.'" style="'.$link_li_style.'">
					<a href="#" style="color:'.$tab_title_color.';'.$bgcolor.';'.$style5bgcolor.'" class="ult_a '.$ult_style.' '.$css_class .'">
					     <span class="ult_tab_main '.$resp_style.' ">
					   <div class="aio-icon none " style="width:0px;padding-left:0px;">
					   
					   </div>
					   <span class="ult-span-text no_icon ult_tab_display_text" style="'.$tabs_nav_style.';padding-right:10px;">'.$value['title'].'</span>
					</span>
					</a>
					</li>';

/*-------------------accordion without icon------------------*/

				$acord.='<dt>
	        	<a class="ult-tabto-actitle withBorder ult_a" style="color:'.$tab_title_color.';'.$style5bgcolor.';background-color:'.$tab_background_color.';'.$ult_ac_border.'" href="#">
	        		<i class="accordion-icon">+</i>
	        			<span class="ult_tab_main ult_ac_main ult_noacordicn' .$resp_style.'">
						
						<span class="ult-span-text no_icon ult_acordian-text" style="'.$tabs_nav_style.';color:inherit " >'.$value['title'].'</span>
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
$newtabcontain .='<div class="ult_tabitemname" style="color:inherit">';
$newtabcontain .=wpb_js_remove_wpautop( $content );
$newtabcontain .='</div>';

$op='';
$op .='<div class="ult_tabs '.$el_class.' " style="'.$container_style.'" data-tabsstyle="'.$style.'"
 data-titlebg="'.$tab_background_color.'" data-titlecolor="'.$tab_title_color.'" 
 data-titlehoverbg="'.$tab_hover_background_color.'" data-titlehovercolor="'.$tab_hover_title_color.'"
 data-rotatetabs="'.$interval.'" data-responsivemode="'.$resp_style.'" data-animation="'.$tab_animation.'"
data-activetitle="'.$acttab_title.'" data-activeicon="'.$act_icon_color.'" data-activebg="'.$acttab_background.'"  data-respmode="'.$resp_type.'" data-respwidth="'.$resp_width.'">';
$op .=$newtab;
$op .='<div class="ult_tabcontent '.$style.'" style="'.$contain_bg.'">';
$op .=wpb_js_remove_wpautop( $content );
$op .='</div>';
$op .='</div>';
echo $op;


/*---------------- for acordian -----------------*/
$actab='';
$actab .='<div class="ult_acord">
   <div class="ult-tabto-accordion " style="width:;"
    data-titlecolor="'.$tab_title_color.'"  data-titlebg="'.$tab_background_color.'"
     data-titlehoverbg="'.$tab_hover_background_color.'" data-titlehovercolor="'.$tab_hover_title_color.'" data-animation="'.$tab_animation.'" 
     data-activetitle="'.$acttab_title.'" data-activeicon="'.$act_icon_color.'" data-activebg="'.$acttab_background.'">
     <dl>';

$actab .=$acord;
$actab .='      
    	</dl>
    <!--<div class="extraborder" style="background-color:'.$tab_hover_background_color.'"></div>-->
</div>

</div>';
echo $actab;