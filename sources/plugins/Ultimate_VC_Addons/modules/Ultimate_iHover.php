<?php
  if(!class_exists('ULT_iHover')) {
	class ULT_iHover {
		function __construct() {

			add_shortcode("ult_ihover",array($this,"ult_ihover_callback"));
			add_shortcode("ult_ihover_item",array($this,"ult_ihover_item_callback"));

			add_action( 'init', array( $this, 'ult_ihover_init' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'ult_ihover_scripts' ), 1 );
		}
		function ult_ihover_callback($atts, $content = null){
		  /*	global variables */
		  global $glob_gutter_width, $glob_thumb_height_width, $glob_ihover_shape;

		  $glob_gutter_width = $glob_thumb_height_width = $glob_ihover_shape = /* $glob_ihover_effect = $glob_ihover_effectdirection = $glob_ihover_effectscale */  '';
		  $thumb_height_width = $res_thumb_height_width = $thumb_shape = $el_class = $output = '';

		  extract( shortcode_atts( array(
				  'thumb_shape' 			=>	'circle',
				  'el_class' 				=>	'',
				  'thumb_height_width'		=>	'250',
				  'res_thumb_height_width' 	=>  '',
				  'responsive_size' 		=> 	'off',
				  'align'					=>	'center',
				  'gutter_width'			=> 	'30',
			  ), $atts ) );
		  	$vc_version = (defined('WPB_VC_VERSION')) ? WPB_VC_VERSION : 0;
			$is_vc_49_plus = (version_compare(4.9, $vc_version, '<=')) ? 'ult-adjust-bottom-margin' : '';
			  /* 		Shape
			   *--------------------------------------*/
			  $shape = '';
			  if($thumb_shape!='') :		$glob_ihover_shape 	= $thumb_shape;
										  $shape = ' data-shape="' .$thumb_shape. '" ';
			  endif;

			  /*		Height/Width
			   *--------------------------------------*/
			  $width = $height = '';
			  if($thumb_height_width!='') :
			  		$glob_thumb_height_width = $thumb_height_width;
					$width = ' data-width="' .$thumb_height_width. '" ';
					$height = ' data-height="' .$thumb_height_width. '" ';
			  endif;

			  /*		Responsive Height/Width
			   *--------------------------------------*/
			  $res_width = $res_height = '';
			  if($responsive_size == 'on' && $res_thumb_height_width!='') {
			  		$res_width = ' data-res_width="' .$res_thumb_height_width. '" ';
					$res_height = ' data-res_height="' .$res_thumb_height_width. '" ';
			  } /*else {
			  		// 	Set default values for responsive
					if($thumb_height_width!=''){
						$res_width = ' data-res_width="' .thumb_height_width. " ';
						$res_height = ' data-res_height="' .thumb_height_width. " ';
					}
			  }*/


			  /*		Gutter Width
			   *--------------------------------------*/
			  if($gutter_width!='') : 	$glob_gutter_width = $gutter_width;
			  endif;

			  /* 		Extra Class
			   *--------------------------------------*/
			  $exClass = '';
			  if($el_class!='') :			/*$glob_ihover_el_class 	= $el_class;*/
										  $exClass = $el_class;
			  endif;

			  $containerStyle = '';
			  if($align!='') { $containerStyle = 'text-align:' .$align. '; ';}

		  //	If effect-5
		  //$output 	.= 	'			<div class="ult-ih-spinner"></div>';

		  $output 	.= 	'<div class="ult-ih-container '.$is_vc_49_plus.' ' .$exClass. ' " >';
		  $output 	.= 	'	<ul class="ult-ih-list " ' .$shape. '' .$width. '' .$height. '' .$res_width. '' .$res_height. ' style="'.$containerStyle.'">';
		  $output 	.= 			do_shortcode($content);
		  $output 	.= 	'	</ul>';
		  $output 	.= 	'</div>';

		  return $output;
		}
		function ult_ihover_item_callback($atts, $content = null){
		  global $glob_gutter_width, $glob_thumb_height_width, $glob_ihover_shape;
		  global $glob_gutter_width;
		  global $glob_thumb_height_width;
		  global $glob_ihover_effectdirection;

		  //	Item
		  $title_margin = $divider_margin = $description_margin = $spacer_border = $spacer_border_color = $spacer_width = $spacer_border_width = $thumbnail_border_styling = $block_border_color	= $block_border_size = $block_link = $info_color_bg = $effect_direction = $title_text_typography = $title_font = $title_font_style = $title_responsive_font_size = $title_responsive_font_line_height = $title_font_color = $desc_text_typography = $desc_font = $desc_font_style = $desc_font_size = $desc_font_line_height = $desc_font_color = $itemOutput = $title = $itemOutput = '';
		  extract( shortcode_atts( array(
				  'thumb_img'					=> 	'',
				  'title'	  					=> 	'',
				  'title_text_typography'		=>	'',
				  'title_font'					=>	'',
				  'title_font_style'			=>	'',
				  'title_responsive_font_size'	=>	'desktop:22px;',
				  'title_responsive_line_height' =>	'desktop:28px;',
				  'title_font_color'			=>	'#ffffff',
				  'desc_text_typography'		=>	'',
				  'desc_font'					=>	'',
				  'desc_font_style'				=>	'',
				  'desc_responsive_font_size'	=>	'desktop:12px;',
				  'desc_responsive_line_height' =>	'desktop:18px;',
				  'desc_font_color'				=>	'#bbbbbb',
				  'info_color_bg'				=>	'rgba(0,0,0,0.75)',
				  'hover_effect'				=>	'effect1',
				  'effect_direction'			=>	'right_to_left',
				  'spacer_border' 				=> 	'solid',
				  'spacer_border_color' 		=> 	'rgba(255,255,255,0.75)',
				  'spacer_width' 				=> 	'100',
				  'spacer_border_width' 		=> 	'1',
				  'block_click'					=> 	'',
				  'block_link'					=> 	'',
				  'thumbnail_border_styling'	=>	'solid',
				  'block_border_color'			=>	'rgba(255,255,255,0.2)',
				  'block_border_size'			=>	'20',
				  'effect_scale'				=> 	'scale_up',
				  'effect_top_bottom'			=> 	'top_to_bottom',
				  'effect_left_right'			=> 	'left_to_right',
				  /*'css'						=>	'',*/
				  'title_margin'				=> 	'',
				  'divider_margin'				=> 	'',
				  'description_margin'			=> 	'',
			  ), $atts ) );

			  $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

			  $info_style 				= '';
			  $title_style 				= '';
			  $desc_style 				= '';
			  $thumbnail_border_style	= '';
			 // $font_args = array();

			  if($info_color_bg != '') :		$info_style .= 'background-color: ' .$info_color_bg. '; ';		endif;

			  if($title_font != '') {
				  $font_family = get_ultimate_font_family($title_font);
				  $title_style .= 'font-family:\''.$font_family.'\';';
				  //array_push($font_args, $title_font);
			  }
			  if($title_font_style != '') { $title_style .= get_ultimate_font_style($title_font_style); }
			  if($title_font_color != '') { $title_style .= 'color:'.$title_font_color.';'; }

			  if($desc_font != '') {
				  $font_family = get_ultimate_font_family($desc_font);
				  $desc_style .= 'font-family:\''.$font_family.'\';';
				  //array_push($font_args, $desc_font);
			  }
			  if($desc_font_style != '') { $desc_style .= get_ultimate_font_style($desc_font_style); }
			  if($desc_font_color != '') { $desc_style .= 'color:'.$desc_font_color.';'; }
			  //enquque_ultimate_google_fonts($font_args);

			  $spacer_line_style = $spacer_style = '';
			  if($spacer_border!=''){
				  $spacer_line_style .="border-style:".$spacer_border.";";
				  if($spacer_border_color != '') {
					  $spacer_line_style .="border-color:".$spacer_border_color.";";
				  }
				  if($spacer_width != '') {
					  $spacer_line_style  .="width:".$spacer_width."px;";
				  }
				  if($spacer_border_width!=''){
					  $spacer_line_style  .="border-width:".$spacer_border_width."px;";
					  /* spacer height */
					  $spacer_style .="height:".$spacer_border_width."px;";
				  }
			  }

			  $thumb_url = $thumb_alt = '';
			  if($thumb_img != '') {

				  $img 		= apply_filters('ult_get_img_single', $thumb_img, 'url');
				  $thumb_alt = apply_filters('ult_get_img_single', $thumb_img, 'alt');
				  if($thumb_alt == '')
				  	$thumb_alt = 'image';
				  $thumb_url  = $img;
			  }

			  if($thumbnail_border_styling!='' && $thumbnail_border_styling!='none') {
				  $thumbnail_border_style.= 'border-style: '. $thumbnail_border_styling.'; ';
				  if($block_border_color != '') 	: $thumbnail_border_style.= 'border-color: '. $block_border_color.'; '; endif;
				  if($block_border_size != '') 	: $thumbnail_border_style.= 'border-width: '. $block_border_size.'px;'; endif;
			  }

			  $HeightWidth = /*$elClass =*/ $imgHeight = $imgWidth = '';
			  if($glob_thumb_height_width != '') {
				  $HeightWidth .= "height: " .$glob_thumb_height_width. "px; ";
				  $HeightWidth .= "width: " .$glob_thumb_height_width. "px; ";
			  }

			  $effect = '';
			  if($hover_effect!='') :
				  $effect 			= $hover_effect;
			  endif;

			  $Scale = '';
			  switch ($effect) {
				  case 'effect6':	if($effect_scale!='') :  	$Scale = 'ult-ih-' .$effect_scale; 	endif;
								  break;
			  }

			  //	Directions: [left, right, top, bottom]
			  $Direction = '';
			  switch ($effect) {
				  case 'effect2':
				  case 'effect3':
				  case 'effect4':
				  case 'effect7':
				  case 'effect8':
				  case 'effect9':
				  case 'effect11':
				  case 'effect12':
				  case 'effect13':
				  case 'effect14':
				  case 'effect18':	if($effect_direction!='') : $Direction = 'ult-ih-' .$effect_direction;	endif;
									  break;
			  }

			  $TopBottom = '';
			  switch ($effect) {
				  case 'effect10':

				  case 'effect1':
									  if($effect_top_bottom!='') :	$TopBottom = 'ult-ih-' .$effect_top_bottom;		endif;
									  break;
			  }

			  $LeftRight = '';
			  switch ($effect) {
				  case 'effect16':
									  if($effect_left_right!='') :	$LeftRight = 'ult-ih-' .$effect_left_right;		endif;
									  break;
			  }

			  $GutterMargin = '';
			  if($glob_gutter_width != '') {
				  $GutterMargin = 'margin: '.($glob_gutter_width / 2). 'px';
			  }

			  $heading_block = $description_block = '';
			  if($title_margin!='') 		{ 	$heading_block 		.= $title_margin;	}
			  if($description_margin!='') 	{	$description_block 	.= $description_margin;	}
			  if($divider_margin!='') 		{	$spacer_style		.= $divider_margin;	}

			  $url = '#';
			  $link_title = $target = '';
			  if($block_link !=''){
				  $href 		= 	vc_build_link($block_link);
				  $url 			= 	$href['url'];
				  $link_title	=	'title="'.$href['title'].'" ';
				  $target		=	'target="'.trim($href['target']).'" ';
			  }

			$item_id = 'ult-ih-list-item-'. rand(1000,9999);

		  	//responsive font size and line height for title
		  	$args = array(
		  		'target'		=>	'#'.$item_id.' .ult-ih-heading',
		  		'media_sizes' 	=> array(
					'font-size' 	=> $title_responsive_font_size,
					'line-height' 	=> $title_responsive_line_height,
				),
		  	);
			$title_responsive = get_ultimate_vc_responsive_media_css($args);

			//resposnive font size and line height for description
			$args = array(
		  		'target'		=>	'#'.$item_id.' .ult-ih-description, #'.$item_id.' .ult-ih-description p',
		  		'media_sizes' 	=> array(
					'font-size' 	=> $desc_responsive_font_size,
					'line-height' 	=> $desc_responsive_line_height,
				),
		  	);
			$desc_responsive = get_ultimate_vc_responsive_media_css($args);

			$itemOutput			.=	'<li id="'.$item_id.'" class="ult-ih-list-item" style="' .$HeightWidth. ' ' .$GutterMargin. '">';
			if($block_click!='') {
				$itemOutput 	.= 	'<a class="ult-ih-link" href="' .$url. '" ' .$target. ' ' .$link_title. '><div style="' .$HeightWidth. '" class="ult-ih-item ult-ih-' .$effect. ' ' .$LeftRight.' ' .$Direction. ' ' .$Scale. ' ' .$TopBottom. '">';
			} else {
				$itemOutput 	.= 	'<div style="' .$HeightWidth. '" class="ult-ih-item ult-ih-' .$effect. ' ' .$LeftRight.' ' .$Direction. ' ' .$Scale. ' ' .$TopBottom. /*' ' .$elClass.*/ ' ">';
			  }

			  switch ($effect) {

				  case 'effect8':
								  $itemOutput 	.= 	'<div class="ult-ih-image-block-container">';
								  $itemOutput 	.= 	'	<div class="ult-ih-image-block" style="' .$HeightWidth. '">';
								  $itemOutput 	.= 	'		<div class="ult-ih-wrapper" style="' .$thumbnail_border_style. '"></div>';
								  $itemOutput	.=	'		<img class="ult-ih-image" src="' .apply_filters('ultimate_images', $thumb_url). '" alt="'.$thumb_alt.'">';
								  $itemOutput 	.= 	'	</div> ';
								  $itemOutput 	.= 	'</div>';

								  $itemOutput 	.= 	'<div class="info-container">';
								  $itemOutput 	.= 	'	<div class="ult-ih-info" style="' .$info_style. '">';
								  $itemOutput 	.= 	$this->commonStructure($desc_responsive, $title_responsive, $heading_block, $title_style, $title, $spacer_style, $spacer_line_style, $description_block, $desc_style, $content);
								  $itemOutput 	.= 	'	</div>';
					  			  $itemOutput 	.= 	'</div>';

					  break;

				  case 'effect1':
				  case 'effect5':
				  case 'effect18':

					  $itemOutput 	.= 	'<div class="ult-ih-image-block" style="' .$HeightWidth. '">';
					  $itemOutput 	.= 	'	<div class="ult-ih-wrapper" style="' .$thumbnail_border_style. '"></div>';
					  $itemOutput 	.= 	'	<img class="ult-ih-image" src="' .apply_filters('ultimate_images', $thumb_url). '" alt="'.$thumb_alt.'">';
					  $itemOutput 	.= 	'</div>';

					  $itemOutput 	.= 	'<div class="ult-ih-info" >';
					  $itemOutput 	.= 	'	<div class="ult-ih-info-back" style="' .$info_style. '">';

					  $itemOutput 	.= 	$this->commonStructure($desc_responsive, $title_responsive, $heading_block, $title_style, $title, $spacer_style, $spacer_line_style, $description_block, $desc_style, $content);

					  $itemOutput 	.= 	'	</div>';
					  $itemOutput 	.= 	'</div>';
					  break;

				  default:

					  $itemOutput 	.= 	'<div class="ult-ih-image-block" style="' .$HeightWidth. '">';
					  $itemOutput 	.= 	'	<div class="ult-ih-wrapper" style="' .$thumbnail_border_style. '"></div>';
					  $itemOutput 	.= 	'	<img class="ult-ih-image" src="' .apply_filters('ultimate_images', $thumb_url). '" alt="'.$thumb_alt.'">';
					  $itemOutput 	.= 	'</div>';

					  $itemOutput 	.= 	'<div class="ult-ih-info" style="' .$info_style. '">';
					  $itemOutput 	.= 	'	<div class="ult-ih-info-back">';

					  $itemOutput 	.= 	$this->commonStructure($desc_responsive, $title_responsive, $heading_block, $title_style, $title, $spacer_style, $spacer_line_style, $description_block, $desc_style, $content);
					  $itemOutput 	.= 	'	</div>';
					  $itemOutput 	.= 	'</div>';
					  break;
			  }

			  //	Check anchor
			  if($block_click!='') {
			  	$itemOutput 	.= 	'</div></a>';
			  } else {
			  	$itemOutput 	.= 	'</div>';
			  }
			  $itemOutput 	.= 	'</li>';

		   	return $itemOutput;
		}

		function commonStructure($desc_responsive, $title_responsive, $heading_block, $title_style, $title, $spacer_style, $spacer_line_style, $description_block, $desc_style, $content) {
			$itemOutput = '';

			$itemOutput .='	<div class="ult-ih-content">';

			$itemOutput .='			<div class="ult-ih-heading-block" style="' .$heading_block. '">';
			$itemOutput .='				<h3 class="ult-ih-heading ult-responsive" style="' .$title_style. '" ' .$title_responsive. '>' .$title. '</h3>';
			$itemOutput .='			</div>';

			$itemOutput .='			<div class="ult-ih-divider-block" style="' .$spacer_style. '">';
			$itemOutput .='				<span class="ult-ih-line" style="' .$spacer_line_style. '"></span>';
			$itemOutput .='			</div>';

			$itemOutput .='			<div class="ult-ih-description-block" style="' .$description_block. '">';
			$itemOutput .='				<div class="ult-ih-description ult-responsive" style="' .$desc_style. '" '.$desc_responsive.'>';
										if($content!='') {
			$itemOutput .=					$content;
										}
			$itemOutput .='				</div>';
			$itemOutput .='			</div>';
			$itemOutput .='	</div>';

			return $itemOutput; 	//ob_get_clean();
		}

		function ult_ihover_init() {
			  //Register "container" content element. It will hold all your inner (child) content elements
			  if(function_exists("vc_map")){
				  vc_map( array(
					  "name" => __("iHover", "ultimate_vc"),
					  "base" => "ult_ihover",
					  "as_parent" => array('only' => 'ult_ihover_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
					  "content_element" => true,
					  "show_settings_on_create" => true,
					  "category" => 'Ultimate VC Addons',
					  "icon" => "ult_ihover",
					  "class" => "ult_ihover",
					  "description" => __("Image hover effects with information.","ultimate_vc"),
					  //'admin_enqueue_js' => array( plugins_url('../assets/js/ihover.js',__FILE__)), // This will load js file in the VC backend editor
					  //"admin_enqueue_css" => array( plugins_url('../assets/css/ihover.css',__FILE__)), // This will load css file in the VC backend editor
					 //"is_container"    => true,
					  "params" => array(
						  array(
							  "type" => "dropdown",
							  "class" => "",
							  "heading" => __("Thumbnail Shape", "ultimate_vc"),
							  "param_name" => "thumb_shape",
							  "value" => array(
								/*"None" => "",*/
								"Circle"=> "circle",
								"Square" => "square",
							  ),
							  "admin_label" => true,
							 /* "description" => __("Select the Thumbnail Shape for iHover.","ultimate"),*/
						  ),
						  array(
							  "type" => "number",
							  "heading" => __("Thumbnail Height & Width", "ultimate_vc"),
							  "param_name" => "thumb_height_width",
							  "admin_label" => true,
							  "suffix" => "px",
							  "value" => "",
							  /*"description" => __("Select the Thumbnail Height & Width for iHover.","ultimate"),*/
						  ),
						  array(
						  	"type" => "ult_switch",
						  	"class" => "",
						  	"heading" => __("Responsive Size", "ultimate_vc"),
						  	"param_name" => "responsive_size",
						  	"default_set" => true,
						  	"value" => "",
						  	"options" => array(
						  			"on" => array(
						  					"label" => __("Add responsive size blow 768px.","ultimate_vc"),
						  					"on" => "Yes",
						  					"off" => "No",
						  				),
						  		),
						  ),
						  array(
							  "type" => "number",
							  "heading" => __("Responsive Thumbnail Height & Width", "ultimate_vc"),
							  "param_name" => "res_thumb_height_width",
							  "suffix" => "px",
							  "value" => "",
							  "dependency" => Array("element" => "responsive_size", "value" => "on"),
						  ),
						  array(
							  "type" => "number",
							  "heading" => __("Spacing Between Two Thumbnails", "ultimate_vc"),
							  "param_name" => "gutter_width",
							  "suffix" => "px",
							  "value" => "",
							 /* "description" => __("Spacing between two thumbnails.","ultimate"),*/
						  ),
						  array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("iHover Alignment", "ultimate_vc"),
							"param_name" => "align",
							/*"admin_label" => true,*/
							"value" => array(
								  __("Center","ultimate_vc") 	=> "center",
								  __("Left","ultimate_vc") 	=> "left",
								  __("Right","ultimate_vc") 	=> "right"
							),
							/*"description" => __("Select the Hover Effect for iHover.","ultimate"),*/
							/*"group" => "Effects",*/
						  ),
						  array(
							  "type" => "textfield",
							  "heading" => __("Extra class name", "ultimate_vc"),
							  "param_name" => "el_class",
							  "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "ultimate_vc")
						  )
					  ),
					  "js_view" => 'VcColumnView'
				  ) );

				  vc_map( array(
					  "name" => __("iHover Item", "ultimate_vc"),
					  "base" => "ult_ihover_item",
					  "content_element" => true,
					  "icon" => "ult_ihover",
					  "class" => "ult_ihover",
					  "as_child" => array('only' => 'ult_ihover'), // Use only|except attributes to limit parent (separate multiple values with comma)
					  "is_container"    => false,
					  "params" => array(
						  // General
						  array(
							  "type" => "textfield",
							  /*"holder" => "div",*/
							  "class" => "",
							  "heading" => __("Title", 'ultimate_vc'),
							  "param_name" => "title",
							  "admin_label" => true,
							  "value" => "",
							  /*"description" => __("Provide the title for the iHover.", 'ultimate')*/
						  ),
						  array(
							  "type" => "ult_img_single",
							  "class" => "",
							  "heading" => __("Upload Image", "ultimate_vc"),
							  "param_name" => "thumb_img",
							  "value" => "",
							  "description" => __("Upload image.", "ultimate_vc"),
						  ),
						  array(
							  "type" => "textarea_html",
							  "holder" => "",
							  "class" => "",
							  "heading" => __("Description", 'ultimate_vc'),
							  "param_name" => "content",
							  "value" => "",
							  "description" => __("Provide the description for the iHover.", 'ultimate_vc'),
							  "edit_field_class" => "ult_hide_editor_fullscreen vc_col-xs-12 vc_column wpb_el_type_textarea_html vc_wrapper-param-type-textarea_html vc_shortcode-param",
						  ),

						  //	Effects
						  array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Hover Effect", "ultimate_vc"),
							"param_name" => "hover_effect",
							"admin_label" => true,
							"value" => array(
								  __("Effect 1","ultimate_vc") => "effect1",
								  __("Effect 2","ultimate_vc") => "effect2",
								  __("Effect 3","ultimate_vc") => "effect3",
								  __("Effect 4","ultimate_vc") => "effect4",
								  __("Effect 5","ultimate_vc") => "effect5",
								  __("Effect 6","ultimate_vc") => "effect6",
								  __("Effect 7","ultimate_vc") => "effect7",
								  __("Effect 8","ultimate_vc") => "effect8",
								  __("Effect 9","ultimate_vc") => "effect9",
								  __("Effect 10","ultimate_vc") => "effect10",
								  __("Effect 11","ultimate_vc") => "effect11",
								  __("Effect 12","ultimate_vc") => "effect12",
								  __("Effect 13","ultimate_vc") => "effect13",
								  __("Effect 14","ultimate_vc") => "effect14",
								  __("Effect 15","ultimate_vc") => "effect15",
								  __("Effect 16","ultimate_vc") => "effect16",
								  __("Effect 17","ultimate_vc") => "effect17",
								  __("Effect 18","ultimate_vc") => "effect18",
								  __("Effect 19","ultimate_vc") => "effect19",
								  /*"Effect 20" => "effect20",*/
							),
							"description" => __("Select the Hover Effect for iHover.","ultimate_vc"),
							/*"group" => "Effects",*/
						  ),
						  array(
							"type" => "dropdown",
							"class" => "",
							  "heading" => __("Hover Effect Direction", "ultimate_vc"),
							  "param_name" => "effect_direction",
							  "value" => array(
								__("Towards Left","ultimate_vc") => "right_to_left",
								__("Towards Right","ultimate_vc") => "left_to_right",
								__("Towards Top","ultimate_vc") => "bottom_to_top",
								__("Towards Bottom","ultimate_vc") => "top_to_bottom",
							  ),
							  "description" => __("Select the Hover Effect Direction for iHover.","ultimate_vc"),
							  "dependency" => Array("element" => "hover_effect", "value" => array("effect2", "effect3", "effect4", "effect7", "effect8", "effect9", "effect11", "effect12", "effect13", "effect14", "effect18")),
							  /*"group" => "Effects",*/
						  ),
						  array(
							  "type" => "dropdown",
							  "class" => "",
							  "heading" => __("Hover Effect Scale", "ultimate_vc"),
							  "param_name" => "effect_scale",
							  "value" => array(
								__("Scale Up","ultimate_vc") => "scale_up",
								__("Scale Down","ultimate_vc") => "scale_down",
								__("Scale Down Up","ultimate_vc") => "scale_down_up",
							  ),
							  "description" => __("Select the Hover Effect Scale for iHover.","ultimate_vc"),
							  "dependency" => Array("element" => "hover_effect", "value" => "effect6"),
							  /*"group" => "Effects",*/
						  ),
						  array(
							  "type" => "dropdown",
							  "class" => "",
							  "heading" => __("Hover Effect Direction", "ultimate_vc"),
							  "param_name" => "effect_top_bottom",
							  "value" => array(
								__("Top to Bottom","ultimate_vc") => "top_to_bottom",
								__("Bottom to Top","ultimate_vc") => "bottom_to_top",
							  ),
							  "description" => __("Select the Hover Effect Direction for iHover.","ultimate_vc"),
							  "dependency" => Array("element" => "hover_effect", "value" => array("effect10", "effect20")),
							  /*"group" => "Effects",*/
						  ),
						  array(
							  "type" => "dropdown",
							  "class" => "",
							  "heading" => __("Hover Effect Direction", "ultimate_vc"),
							  "param_name" => "effect_left_right",
							  "value" => array(
								__("Left to Right","ultimate_vc") => "left_to_right",
								__("Right to Left","ultimate_vc") => "right_to_left",
							  ),
							  "description" => __("Select the Hover Effect Direction for iHover.","ultimate_vc"),
							  "dependency" => Array("element" => "hover_effect", "value" => "effect16"),
							  /*"group" => "Effects",*/
						  ),
						  array(
							  "type" => "dropdown",
							  "class" => "",
							  "heading" => __("On Click", "ultimate_vc"),
							  "param_name" => "block_click",
							  "value" => array(
								__("Do Nothing","ultimate_vc") 		=> "",
								__("Link","ultimate_vc") 			=> "link",
								/*"Image Lightbox" 	=> "image_lightbox",*/
							  ),
							 /* "description" => __("Add .", 'ultimate')*/
						  ),
						  array(
							  "type" => "vc_link",
							  "class" => "",
							  "heading" => __("Apply Link to:", "ultimate_vc"),
							  "param_name" => "block_link",
							  "value" => "",
							  "description" => __("Provide the link for iHover.", "ultimate_vc"),
							  "dependency" => Array("element" => "block_click", "value" => "link"),
						  ),
						  array(
							  "type" => "colorpicker",
							  "param_name" => "title_font_color",
							  "heading" => __("Title Color","ultimate_vc"),
							  "group" => "Design",
							  "value" => "#ffffff",
							),
						  array(
							  "type" => "colorpicker",
							  "param_name" => "desc_font_color",
							  "heading" => __("Description Color","ultimate_vc"),
							  "group" => "Design",
							  "value" => "",
						  ),
						  array(
							  "type" => "colorpicker",
							  "param_name" => "info_color_bg",
							  "heading" => __("iHover Background Color", "ultimate_vc"),
							  "group" => "Design",
							  "value" => "",
							  /*"description" => __("Select the Background Hover Color. Default: #E6E6E6.", "ultimate"),*/
						  ),
						  array(
							  "type" => "ult_param_heading",
							  "param_name" => "thumbnail_border_styling_text",
							  "text" => __("Thumbnail Border Styling", "ultimate_vc"),
							  "value" => "",
							  "group" => "Design",
							  'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
						  ),
						  array(
							  "type" => "dropdown",
							  "class" => "",
							  "heading" => __("Border Style", "ultimate_vc"),
							  "param_name" => "thumbnail_border_styling",
							  "value" => array(
								__("Solid","ultimate_vc")=> "solid",
								__("None","ultimate_vc") => "none",
								/*"Dashed" => "dashed",
								"Dotted" => "dotted",
								"Double" => "double",
								"Inset" => "inset",
								"Outset" => "outset",*/
							  ),
							  "description" => __("Select Thumbnail Border Style for iHover.","ultimate_vc"),
							  "group" => "Design"
						  ),
						  array(
							  "type" => "colorpicker",
							  "class" => "",
							  "heading" => __("Border Color", "ultimate_vc"),
							  "param_name" => "block_border_color",
							  "value" => "",
							  /*"description" => __("Select Thumbnail Border Color.", "ultimate"),*/
							  "dependency" => array("element" => "thumbnail_border_styling", "value" => "solid" ),
							  "group" => "Design",
						  ),
						  array(
							  "type" => "number",
							  "class" => "",
							  "heading" => __("Border Thickness", "ultimate_vc"),
							  "param_name" => "block_border_size",
							  "value" => "",
							  "suffix" => "px",
							  /*"description" => __("Thickness of the Thumbnail Border.", "ultimate"),*/
							  "dependency" => array("element" => "thumbnail_border_styling", "value" => "solid" ),
							  "group" => "Design",
						  ),

						  //	Divider
						  array(
							  "type" => "ult_param_heading",
							  "param_name" => "thumbnail_divider_styling_text",
							  "text" => __("Heading & Description Divider","ultimate_vc"),
							  "value" => "",
							  "group" => "Design",
							  'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
						  ),
						  array(
							  "type" => "dropdown",
							  "class" => "",
							  "heading" => __("Divider - Style", "ultimate_vc"),
							  "param_name" => "spacer_border",
							  "value" => array(
								__("Solid","ultimate_vc")=> "solid",
								__("Dashed","ultimate_vc") => "dashed",
								__("Dotted","ultimate_vc") => "dotted",
								__("Double","ultimate_vc") => "double",
								__("Inset","ultimate_vc") => "inset",
								__("Outset","ultimate_vc") => "outset",
								__("None","ultimate_vc") => "none",
							  ),
							  "description" => __("Select Heading & Description's Divider Border Style.", "ultimate_vc"),
							  "group" => "Design"
						  ),
 						  array(
							  "type" => "colorpicker",
							  "class" => "",
							  "heading" => __("Divider - Border Color", "ultimate_vc"),
							  "param_name" => "spacer_border_color",
							  "value" => "rgba(255,255,255,0.75)",
							  "description" => __("Select Divider Border Color.", "ultimate_vc"),
							  "dependency" => array("element" => "spacer_border", "value" => array("solid", "dashed", "dotted", "double", "inset", "outset") ),
							  "group" => "Design"
						  ),
						  array(
							  "type" => "number",
							  "class" => "",
							  "heading" => __("Divider - Line Width (optional)", "ultimate_vc"),
							  "param_name" => "spacer_width",
							  "value" => "",
							  "suffix" => "px",
							  "description" => __("Width of Divider Border. Default: 100%;", "ultimate_vc"),
							  "dependency" => array("element" => "spacer_border", "value" => array("solid", "dashed", "dotted", "double", "inset", "outset") ),
							  "group" => "Design"
						  ),
						  array(
							  "type" => "number",
							  "class" => "",
							  "heading" => __("Divider - Border Thickness", "ultimate_vc"),
							  "param_name" => "spacer_border_width",
							  "value" => "",
							  /*"min" => 1,
							  "max" => 10,*/
							  "suffix" => "px",
							  "description" => __("Height of Divider Border.", "ultimate_vc"),
							  "dependency" => array("element" => "spacer_border", "value" => array("solid", "dashed", "dotted", "double", "inset", "outset") ),
							  "group" => "Design"
						  ),

	  					  array(
							  "type" => "ult_param_heading",
							  "param_name" => "thumbnail_spacing_styling_text",
							  "text" => __("Spacing","ultimate_vc"),
							  "value" => "",
							  "description" => __("Add Space Between Title, Divider and Description. Just put only numbers in textbox. All values will consider in px.","ultimate_vc"),
							  "group" => "Design",
							  'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
						  ),
						  array(
							  "type" => "ultimate_margins",
							  "heading" => __("Title Margins","ultimate_vc"),
							  "param_name" => "title_margin",
							  "positions" => array(
								  __("Top","ultimate_vc") => "top",
								  __("Bottom","ultimate_vc") => "bottom",
								  __("Left","ultimate_vc") => "left",
								  __("Right","ultimate_vc") => "right"
							  ),
							  "group" => "Design"
						  ),
						  array(
							  "type" => "ultimate_margins",
							  "heading" => __("Divider Margins","ultimate_vc"),
							  "param_name" => "divider_margin",
							  "positions" => array(
								  __("Top","ultimate_vc") => "top",
								  __("Bottom","ultimate_vc") => "bottom",
								  __("Left","ultimate_vc") => "left",
								  __("Right","ultimate_vc") => "right"
							  ),
							  "group" => "Design"
						  ),
						  array(
							  "type" => "ultimate_margins",
							  "heading" => __("Description Margins","ultimate_vc"),
							  "param_name" => "description_margin",
							  "positions" => array(
								  __("Top","ultimate_vc") => "top",
								  __("Bottom","ultimate_vc") => "bottom",
								  __("Left","ultimate_vc") => "left",
								  __("Right","ultimate_vc") => "right"
							  ),
							  "group" => "Design"
						  ),
						  array(
							  "type" => "ult_param_heading",
							  "param_name" => "title_text_typography",
							  "text" => __("Title settings","ultimate_vc"),
							  "value" => "",
							  "group" => "Typography",
							  'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
						  ),
						  array(
							  "type" => "ultimate_google_fonts",
							  "heading" => __("Font Family","ultimate_vc"),
							  "param_name" => "title_font",
							  "value" => "",
							  "group" => "Typography"
							),
						  array(
							  "type" => "ultimate_google_fonts_style",
							  "heading" => __("Font Style","ultimate_vc"),
							  "param_name" => "title_font_style",
							  "value" => "",
							  "group" => "Typography"
							),
						  array(
                      	  	"type" => "ultimate_responsive",
                      	  	"class" => "",
                      	  	"heading" => __("Font size", 'ultimate_vc'),
                      	  	"param_name" => "title_responsive_font_size",
                      	  	"unit"  => "px",
                      	  	"media" => array(
                      	  	    /*"Large Screen"      => '',*/
                      	  	    "Desktop"           => '22',
                      	  	    "Tablet"            => '',
                      	  	    "Tablet Portrait"   => '',
                      	  	    "Mobile Landscape"  => '',
                      	  	    "Mobile"            => '',
                      	  	),
                      	  	"group" => "Typography"
                          ),
						  array(
                          	  	"type" => "ultimate_responsive",
                          	  	"class" => "",
                          	  	"heading" => __("Line Height", 'ultimate_vc'),
                          	  	"param_name" => "title_responsive_line_height",
                          	  	"unit"  => "px",
                          	  	"media" => array(
                          	  	    /*"Large Screen"      => '',*/
                          	  	    "Desktop"           => '28',
                          	  	    "Tablet"            => '',
                          	  	    "Tablet Portrait"   => '',
                          	  	    "Mobile Landscape"  => '',
                          	  	    "Mobile"            => '',
                          	  	),
                          	  	"group" => "Typography"
                          	),
						  array(
							  "type" => "ult_param_heading",
							  "param_name" => "desc_text_typography",
							  "text" => __("Description settings","ultimate_vc"),
							  "value" => "",
							  "group" => "Typography",
							  'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
							),
						  array(
							  "type" => "ultimate_google_fonts",
							  "heading" => __("Font Family","ultimate_vc"),
							  "param_name" => "desc_font",
							  "value" => "",
							  "group" => "Typography"
							),
						  array(
							  "type" => "ultimate_google_fonts_style",
							  "heading" => __("Font Style","ultimate_vc"),
							  "param_name" => "desc_font_style",
							  "value" => "",
							  "group" => "Typography"
							),
						  array(
                          	  	"type" => "ultimate_responsive",
                          	  	"class" => "",
                          	  	"heading" => __("Font size", 'ultimate_vc'),
                          	  	"param_name" => "desc_responsive_font_size",
                          	  	"unit"  => "px",
                          	  	"media" => array(
                          	  	    /*"Large Screen"      => '',*/
                          	  	    "Desktop"           => '12',
                          	  	    "Tablet"            => '',
                          	  	    "Tablet Portrait"   => '',
                          	  	    "Mobile Landscape"  => '',
                          	  	    "Mobile"            => '',
                          	  	),
                          	  	"group" => "Typography"
                          	),
						  array(
                          	  	"type" => "ultimate_responsive",
                          	  	"class" => "",
                          	  	"heading" => __("Line Height", 'ultimate_vc'),
                          	  	"param_name" => "desc_responsive_line_height",
                          	  	"unit"  => "px",
                          	  	"media" => array(
                          	  	    /*"Large Screen"      => '',*/
                          	  	    "Desktop"           => '18',
                          	  	    "Tablet"            => '',
                          	  	    "Tablet Portrait"   => '',
                          	  	    "Mobile Landscape"  => '',
                          	  	    "Mobile"            => '',
                          	  	),
                          	  	"group" => "Typography"
                          	),
					  )
				  ) );
			  }
		}
		//     Load plugin css and javascript files which you may need on front end of your site
		function ult_ihover_scripts() {
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
		  	wp_register_style( 'ult_ihover_css', plugins_url($css_path.'ihover'.$ext.'.css',__FILE__) );
		  	wp_register_script('ult_ihover_js', plugins_url($js_path.'ihover'.$ext.'.js',__FILE__) , array('jquery'), ULTIMATE_VERSION, true);
		}
	}
	// Finally initialize code
	new ULT_iHover;

	  if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
			  class WPBakeryShortCode_ult_ihover extends WPBakeryShortCodesContainer {
		  }
	  }
	  if ( class_exists( 'WPBakeryShortCode' ) ) {
			  class WPBakeryShortCode_ult_ihover_item extends WPBakeryShortCode {
		  }
	  }
  }
