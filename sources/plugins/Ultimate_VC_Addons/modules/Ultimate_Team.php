<?php
/*
* Module - Team Module
*/
if(!class_exists("Ultimate_Team")){
	class Ultimate_Team{
		function __construct(){
			add_action( 'init', array($this, 'init_team') );
			add_shortcode( 'ult_team',array($this,'ult_team_shortcode'));
			//add_action('admin_enqueue_scripts',array($this,'admin_scripts'));
			add_action("wp_enqueue_scripts", array($this, "register_team_assets"),1);
		}

		function register_team_assets()
		{
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
			wp_register_script("ultimate-team",plugins_url($js_path."teams".$ext.".js",__FILE__),array('jquery'),ULTIMATE_VERSION);
			//wp_register_script("ultimate-modal-all-switched",plugins_url("../assets/min-js/modal-all.min-switched.js",__FILE__),array('jquery'),ULTIMATE_VERSION);
			wp_register_style("ultimate-team",plugins_url($css_path."teams".$ext.".css",__FILE__),array(),ULTIMATE_VERSION);
		}

		function admin_scripts($hook) {

		  	if($hook == "post.php" || $hook == "post-new.php" || $hook == 'visual-composer_page_vc-roles'){
		   		$bsf_dev_mode = bsf_get_option('dev_mode');
				if($bsf_dev_mode === 'enable') {
					wp_enqueue_script('ult-team-admin',plugins_url('../admin/js/team-admin.js',__FILE__),array('jquery'),ULTIMATE_VERSION,true);
				}
			}
		}

		function ult_team_shortcode($atts, $content){

			$image                  = $name = $pos_in_org  = $text_align = '';
			$team_member_name_font  = $team_member_name_font_style = $team_member_name_font_size = $team_member_name_line_height = $team_member_position_font = $team_member_position_font_style = $team_member_position_font_size = $team_member_position_line_height = $team_member_description_font = $team_member_description_font_style = $team_member_description_font_size = $team_member_description_line_height = $team_member_name_tag = '';
			$team_member_name_color = '';
			$team_member_org_color  = '';
			$team_member_desc_color = $team_img_bg_color = $team_img_opacity = $team_img_grayscale = $team_img_hover_opacity = $team_img_hover_opacity_style3 = $img_hover_eft = $img_hover_color = $img_border_style = $img_border_width = $img_border_color = $img_border_radius = $staff_link = $link_switch = '';

			/* Declaration for style-1 for team */
			$team_member_style = $divider_effect = $team_member_divider_color = $team_member_divider_width = $team_member_divider_height = $social_links = $selected_team_icon = $social_icon_url = $social_link_title = $social_icon_color = $social_icon_hover_color = $team_member_bg_color = $team_member_align_style = $social_icon_size = $social_icon_space = $social_icon_effect = $custom_team_class = '';

			$title_box_padding = $title_box_margin = $team_css = $team_member_responsive_enable = $team_responsive_width = '';

			/* Declaration closed for style-1 for team */
			extract(shortcode_atts(array(
				"image"                              	=> "",
			    "name"                               	=> "",
			    "pos_in_org"                         	=> "",
			    "text_align"                         	=> "",
			    "team_member_name_tag"					=> "",
			    "team_member_name_font"              	=> "",
			    "team_member_name_font_style"        	=> "",
			    "team_member_name_font_size"         	=> "",
			    "team_member_name_line_height"		 	=> "",
			    "team_member_position_font"          	=> "",
			    "team_member_position_font_style"    	=> "",
			    "team_member_position_font_size"     	=> "",
			    "team_member_position_line_height"	 	=> "",
			    "team_member_description_font"       	=> "",
			    "team_member_description_font_style" 	=> "",
			    "team_member_description_font_size"  	=> "",
			    "team_member_description_line_height" 	=> "",
			    "team_member_name_color"             	=> "",
			    "team_member_org_color"              	=> "",
			    "team_member_desc_color"             	=> "",
			    "img_hover_eft"                      	=> "",
			    "img_hover_color"						=> "",
			    "img_border_style"                   	=> "",
			    "img_border_width"                   	=> "",
			    "img_border_radius"                  	=> "",
			    "img_border_color"                   	=> "",
			    "staff_link"                         	=> "",
			    "link_switch"                        	=> "",

			    //New attributes for style 2
			    "team_member_style"                   	=> "",
			    "divider_effect"                      	=> "",
			 // "team_member_bg_color"                	=> "",
			    "team_member_align_style"             	=> "",
			    "team_member_divider_color"           	=> "",
			    "team_member_divider_width"           	=> "",
			    "team_member_divider_height"			=> "",
			    "social_icon_effect"				  	=> "",
			    "social_links"                        	=> "",
			    "social_icon_size" 					  	=> "",
			    "social_icon_space" 				  	=> "",

			    //"title_box_margin"					  => "",
			    "title_box_padding"					  	=> "",
			    "custom_team_class" 				  	=> "",

			    "team_css"							  	=> "",
			    "team_member_responsive_enable"			=> "",
			    "team_responsive_width"					=> "",

			    "team_img_opacity"						=> "",
			    "team_img_hover_opacity"				=> "",
			    "team_img_hover_opacity_style3"			=> "",
			    "team_img_bg_color"						=> "",

			    "team_img_grayscale"					=> "on",

			),$atts));

			// Grayscale Image
			$team_img_grayscale_cls = ( $team_img_grayscale != 'off' ) ? 'ult-team-grayscale' : '';


			// Style-2 Image Opacity
			$team_img_opacity = ( isset( $team_img_opacity ) && trim( $team_img_opacity ) !== '' ) ? $team_img_opacity : '1';
			$team_img_hover_opacity = ( isset( $team_img_hover_opacity ) && trim( $team_img_hover_opacity ) !== '' ) ? $team_img_hover_opacity : '0.65';
			$team_img_hover_opacity_style3 = ( isset( $team_img_hover_opacity_style3 ) && trim( $team_img_hover_opacity_style3 ) !== '' ) ? $team_img_hover_opacity_style3 : '0.1';

			$team_img_bg_color = ( isset( $team_img_bg_color ) && trim( $team_img_bg_color ) !== '' ) ? $team_img_bg_color : 'inherit';

			$team_member_style = ( isset( $team_member_style ) && trim( $team_member_style ) !== '' ) ? $team_member_style : 'style-1';
			$custom_team_class = ( isset( $custom_team_class ) && trim( $custom_team_class ) !== '' ) ? $custom_team_class : '';

			// Set responsive width
			$team_responsive_width = ( isset( $team_responsive_width ) && trim( $team_responsive_width ) !== '' ) ? $team_responsive_width : '';
			$team_responsive_width = ( isset( $team_member_responsive_enable ) && trim( $team_member_responsive_enable ) == 'on' ) ? $team_responsive_width : '';

			// Set typography colors
			$team_member_name_color = ( isset( $team_member_name_color ) && trim( $team_member_name_color ) !== '' ) ? $team_member_name_color : 'inherit';
			$team_member_org_color = ( isset( $team_member_org_color ) && trim( $team_member_org_color ) !== '' ) ? $team_member_org_color : 'inherit';
			$team_member_desc_color = ( isset( $team_member_desc_color ) && trim( $team_member_desc_color ) !== '' ) ? $team_member_desc_color : 'inherit';

			// Set team Member name's tag element
			$team_member_name_tag = ( isset( $team_member_name_tag ) && trim( $team_member_name_tag ) !== '' ) ? $team_member_name_tag : 'h2';

			$team_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $team_css, ' ' ), "ult_team", $atts );

			//title box style
			$title_box_style = "";
			//$title_box_style .= trim( $title_box_margin ) != '' ? $title_box_margin." " : '' ;
			$title_box_style .= trim( $title_box_padding ) != '' ? $title_box_padding : '' ;

			$href                      = vc_build_link( $staff_link );
			$url                       = $href['url'];
			$target                    = trim( $href['target'] , ' ');
			$font_args                     = array();
			$team_member_name_font_styling = '';
			if ( ! $team_member_name_font == '' ) {
			    $team_member_font_family = function_exists( "get_ultimate_font_family" ) ? get_ultimate_font_family( $team_member_name_font ) : '';
			    $team_member_font_family = ( $team_member_font_family != '') ? $team_member_font_family : 'inherit';
			    $team_member_name_font_styling .= 'font-family:' . $team_member_font_family . ';';
			    array_push( $font_args, $team_member_name_font );
			}

			if ( function_exists( 'get_ultimate_font_style' ) ) {
				if( isset($team_member_name_font_style) && trim($team_member_name_font_style) != '') {
					$team_member_name_font_styling .= get_ultimate_font_style($team_member_name_font_style);
				}
			}

			if ( ! ($team_member_name_color == '') && ! ($team_member_name_color == 'inherit') ) {

			    $team_member_name_font_styling .= 'color:' . $team_member_name_color . ';';
			}
			$team_member_position_font_styling = '';
			if ( ! $team_member_position_font == '' ) {
			    $team_member_font_family = function_exists( "get_ultimate_font_family" ) ? get_ultimate_font_family( $team_member_position_font ) : '';
			    $team_member_font_family = ( $team_member_font_family != '') ? $team_member_font_family : 'inherit';
			    $team_member_position_font_styling .= 'font-family:' . $team_member_font_family . ';';
			    array_push( $font_args, $team_member_position_font );
			}
			if ( ! $team_member_position_font_style == '' ) {
			    $team_member_position_font_styling .= $team_member_position_font_style . ';';
			}


			if ( ! ($team_member_org_color == '') && ! ($team_member_org_color == 'inherit') ) {
			    $team_member_position_font_styling .= 'color:' . $team_member_org_color . ';';
			}
			$team_member_description_font_styling = '';
			if ( ! $team_member_description_font == '' ) {
			    $team_member_font_family = function_exists( "get_ultimate_font_family" ) ? get_ultimate_font_family( $team_member_description_font ) : '';
			    $team_member_font_family = ( $team_member_font_family != '') ? $team_member_font_family : 'inherit';
			    $team_member_description_font_styling .= 'font-family:' . $team_member_font_family . ';';
			    array_push( $font_args, $team_member_description_font );
			}
			if ( ! $team_member_description_font_style == '' ) {
			    $team_member_description_font_styling .= $team_member_description_font_style . ';';
			}

			if ( ! ($team_member_desc_color == '') &&  ! ($team_member_desc_color == 'inherit') ) {

			    $team_member_description_font_styling .= 'color:' . $team_member_desc_color . ';';
			}
			$img_hver_class = '';
			$img_hver_data = '';
			if ( $img_hover_eft == 'on' ) {
			    $img_hver_class = 'ult-team_img_hover';
			    $img_hover_color = ( isset( $img_hover_color ) && trim( $img_hover_color ) != "" ) ? $img_hover_color : 'rgba(100,100,100,0.6)';
			    $img_hver_data = 'data-background_clr = "' . $img_hover_color . '"';
			} elseif ( $img_hover_eft == 'off' ) {
			    $img_hver_class = '';
			    $img_hver_data = '';
			}
			$team_image_style = '';
			if ( !$img_border_style == '' ) {
			    $team_image_style .= 'border-style:'.$img_border_style.';';
			}
			if ( !$img_border_width == '' ) {
			    $team_image_style .= 'border-width:'.$img_border_width.'px;';
			}
			if ( !$img_border_radius == '' ) {
			    $team_image_style .= 'border-radius:'.$img_border_radius.'px;';
			}
			if ( !$img_border_color == '' ) {
			    $team_image_style .= 'border-color:'.$img_border_color.';';
			}

			$img = apply_filters('ult_get_img_single', $image, 'url');
			$alt = apply_filters('ult_get_img_single', $image, 'alt');

			// Code for Responsive font-size [Open]
			$id = uniqid('ultimate-heading');
			// FIX: set old font size before implementing responsive param
			if(is_numeric($team_member_name_font_size))     {   $team_member_name_font_size = 'desktop:'.$team_member_name_font_size.'px;';     }
			if(is_numeric($team_member_name_line_height))     {   $team_member_name_line_height = 'desktop:'.$team_member_name_line_height.'px;';     }
			$team_name_args = array(
			                'target'        =>  '.ult-team-member-bio-wrap.'. $id .' .ult-team-member-name',
			                'media_sizes'   => array(
			                    'font-size'     => $team_member_name_font_size,
			                    'line-height'	=> $team_member_name_line_height,
			                ),
			            );
			$team_member_name_responsive = get_ultimate_vc_responsive_media_css($team_name_args);


			if(is_numeric($team_member_position_font_size))     {   $team_member_position_font_size = 'desktop:'.$team_member_position_font_size.'px;';     }
			if(is_numeric($team_member_position_line_height))     {   $team_member_position_line_height = 'desktop:'.$team_member_position_line_height.'px;';     }
			$team_position_args = array(
			                'target'        =>  '.ult-team-member-bio-wrap.'. $id .' .ult-team-member-position',
			                'media_sizes'   => array(
			                    'font-size'     => $team_member_position_font_size,
			                    'line-height'	=> $team_member_position_line_height,
			                ),
			            );
			$team_member_position_responsive = get_ultimate_vc_responsive_media_css($team_position_args);

			if(is_numeric($team_member_description_font_size))     {   $team_member_description_font_size = 'desktop:'.$team_member_description_font_size.'px;';     }
			if(is_numeric($team_member_description_line_height))     {   $team_member_description_line_height = 'desktop:'.$team_member_description_line_height.'px;';     }
			$team_desc_args = array(
			                'target'        =>  '.ult-team-member-bio-wrap.'. $id .' .ult-team-member-description',
			                'media_sizes'   => array(
			                    'font-size'     => $team_member_description_font_size,
			                    'line-height'	=> $team_member_description_line_height,
			                ),
			            );
			$team_member_desc_responsive = get_ultimate_vc_responsive_media_css($team_desc_args);


			$team_member_divider_color = ( isset( $team_member_divider_color ) && trim( $team_member_divider_color ) !== '' ) ? $team_member_divider_color : '';

			//$team_member_bg_color = ( isset( $team_member_bg_color ) && trim( $team_member_bg_color ) !== '' ) ? $team_member_bg_color : '#ffffff';
			$team_member_align_style = ( isset( $team_member_align_style ) && trim( $team_member_align_style ) !== '' ) ? $team_member_align_style : 'center';

			$social_icon_size = ( isset( $social_icon_size ) && trim( $social_icon_size ) !== '' ) ? $social_icon_size."px"  : '16px';
	        $social_icon_space = ( isset( $social_icon_space ) && trim( $social_icon_space ) !== '' ) ? ( $social_icon_space / 2)."px" : '5px';

	        $team_member_divider_width = ( isset( $team_member_divider_width ) && trim($team_member_divider_width) !== '' ) ? $team_member_divider_width : '80';
			$team_member_divider_width = ( $team_member_divider_width <= 100 ) ? $team_member_divider_width : '100';
			$team_member_divider_height = ( isset( $team_member_divider_height ) && trim($team_member_divider_height) !== '' ) ? $team_member_divider_height : '1';
			// Code for Responsive font-size [Closed]

			ob_start();
			//echo do_shortcode( $content );
			if ( $team_member_style == 'style-3' ) {

				$team_desc_args = array(
				                'target'        =>  '.ult-team-member-image.'. $id .' .ult-team-member-description',
				                'media_sizes'   => array(
				                    'font-size'     => $team_member_description_font_size,
				                    'line-height'	=> $team_member_description_line_height,
				                ),
				            );
				$team_member_desc_responsive = get_ultimate_vc_responsive_media_css($team_desc_args);

				echo '<div class="ult-team-member-wrap ult-style-3 '. $custom_team_class .' '. $team_css .'">';
				if ( $link_switch == 'on' ) {
			        echo '<a href="'. $url .'" target="'. $target  .'">';
			    }
				echo '<div class="ult-team-member-image ' . $id . '" style="'. esc_attr( $team_image_style ).'; background-color:' . $team_img_bg_color. '" data-hover_opacity="' . $team_img_hover_opacity_style3 . '" > <img class="'. $team_img_grayscale_cls. '" src="' .apply_filters('ultimate_images', esc_url( $img ))  . '" alt="'.$alt.'" >';
				echo '<span class="ult-team-member-image-overlay ' . esc_attr( $img_hver_class ) . '" ' . $img_hver_data . ' ></span>';
				if ( $content ) {
			        echo '<div class="ult-team-member-description ult-responsive" ' . $team_member_desc_responsive . ' style="' . $team_member_description_font_styling . '; text-align:' . $team_member_align_style . ';' . $title_box_style . '; "><p>' . do_shortcode( $content ) . '</p></div>';
			    }
				if ( $link_switch == 'on' ) {
			        echo '</a>';
			    }
				echo '</div>';//ult-team-member-image

			    echo '<div class="ult-team-member-bio-wrap ' . $team_member_style . ' ' . $id . '" style="text-align:' . $team_member_align_style . ';' . $title_box_style . '; ">';

			    echo '<div class="ult-team-member-name-wrap">';
			    if ( $link_switch == 'on' ) {
			        echo '<a href="'. $url .'" target="'. $target  .'" style="text-decoration: none;">';
			    }
			    echo '<'. $team_member_name_tag .' class="ult-team-member-name ult-responsive" ' . $team_member_name_responsive .' style="' . $team_member_name_font_styling . '">' . $name . '</'. $team_member_name_tag .'>';
			    if ( $link_switch == 'on' ) {
			        echo '</a>';
			    }
			    if ( $pos_in_org ) {
			        echo '<div class="ult-team-member-position ult-responsive" ' . $team_member_position_responsive . ' style="' . $team_member_position_font_styling . '">' . $pos_in_org . '</div>';
			    }

			    echo '<div style="margin-bottom:15px">';

			    if ( $divider_effect == 'on') {

			        $divider_margin = '';
			        if( $team_member_align_style != 'center' ) {
			        	$divider_margin = "margin-" . $team_member_align_style . ":0px";
			        }

			        echo '<hr align="'. $team_member_align_style .'" class="ult-team-divider" style="padding-top: ' . $team_member_divider_height . 'px; width: ' . $team_member_divider_width . '%; background-color: ' . $team_member_divider_color . '; ' . $divider_margin . '" />';
			    }
			    echo '</div>';

			    $social_icons = json_decode (urldecode( $social_links ) );

			    if ( count( $social_icons ) > 0 && $social_icon_effect == 'on' ) {

			        $icon_styling = 'font-size:' . $social_icon_size .' ; margin-left:' . $social_icon_space .';margin-right:' . $social_icon_space .';';
			        echo "<div class='ult-social-buttons'>";

			            foreach ($social_icons as $social_link) {

			                if ( isset( $social_link->selected_team_icon ) && $social_link->selected_team_icon !== '' ) {

			                    $social_icon_url = ( isset( $social_link->social_icon_url ) && $social_link->social_icon_url !== '' ) ? $social_link->social_icon_url : '#';
			                    $social_link_title = ( isset( $social_link->social_link_title ) && $social_link->social_link_title !== '' ) ? $social_link->social_link_title : '';
			                    $social_icon_color = ( isset( $social_link->social_icon_color ) && $social_link->social_icon_color !== '' ) ? $social_link->social_icon_color : 'inherit';
			                    $default_icon_color = ( $social_icon_color != 'inherit' ) ? 'color:'.$social_icon_color.';' : '';
			                    $social_icon_hover_color = ( isset( $social_link->social_icon_hover_color ) && $social_link->social_icon_hover_color !== '' ) ? $social_link->social_icon_hover_color : 'inherit';
			                    echo "<a href='" . $social_icon_url . "' target='_blank' title='" . $social_link_title . "' class='ult-team ult-social-icon' style='" . $icon_styling . ";". $default_icon_color ."'  data-iconcolor='" . $social_icon_color . "' data-iconhover='" . $social_icon_hover_color . "' ><i class='". $social_link->selected_team_icon  ."'></i></a>";
			                }
			            }

			        echo "</div>";
			    }
			    echo '</div>'; //ult-team-member-name-wrap

				echo '</div>'; //ult-team-member-bio-wrap
				echo '</div>'; //ult-team-member-wrap
			}
			elseif ( $team_member_style == 'style-2' ) {
				echo '<div class="ult-team-member-wrap ult-style-2 '. $custom_team_class .' '. $team_css .'" data-responsive_width="'. $team_responsive_width .'" style="background-color:' . $team_img_bg_color. '">';
				if ( $link_switch == 'on' ) {
			        echo '<a href="'. $url .'" target="'. $target  .'" style="text-decoration: none;">';
			    }
				echo '<div class="ult-team-member-image" style="'. esc_attr( $team_image_style ).'" data-opacity="' . $team_img_opacity . '" data-hover_opacity="' . $team_img_hover_opacity . '" > <img src="' . apply_filters('ultimate_images', esc_url( $img )) . '" alt="'.$alt.'"  style="opacity:'. $team_img_opacity .'">';
				echo '</div>';//ult-team-member-image

			    echo '<div class="ult-team-member-bio-wrap ' . $id . '">';
			    echo '<div class="ult-team-member-name-wrap"  style="text-align:' . $team_member_align_style . ';' . $title_box_style . ' ">';

			    echo '<'. $team_member_name_tag .' class="ult-team-member-name ult-responsive" ' . $team_member_name_responsive .' style="' . $team_member_name_font_styling . '">' . $name . '</'. $team_member_name_tag .'>';

			    if ( $pos_in_org ) {
			        echo '<div class="ult-team-member-position ult-responsive" ' . $team_member_position_responsive . ' style="' . $team_member_position_font_styling . '">' . $pos_in_org . '</div>';
			    }

			    echo '</div>'; //ult-team-member-name-wrap

			    echo '<div class="ult-team_description_slide"  style="text-align:' . $team_member_align_style . ';' . $title_box_style . ' ">';
			    if ( $content ) {
			        echo '<div class="ult-team-member-description ult-responsive" ' . $team_member_desc_responsive . ' style="' . $team_member_description_font_styling . '"><p>' . do_shortcode( $content ) . '</p></div>';
			    }

			    echo '<div style="margin-bottom:15px">';
			    if ( $divider_effect == 'on') {

			        $divider_margin = '';
			        if( $team_member_align_style != 'center' ) {
			        	$divider_margin = "margin-" . $team_member_align_style . ":0px";
			        }
			        echo '<hr align="'. $team_member_align_style .'" class="ult-team-divider" style="padding-top: ' . $team_member_divider_height . 'px; width: ' . $team_member_divider_width . '%; background-color: ' . $team_member_divider_color . '; ' . $divider_margin . '" />';
			    }
			    echo '</div>';

			    $social_icons = json_decode (urldecode( $social_links ) );

			    if ( count( $social_icons ) > 0 && $social_icon_effect == 'on' ) {

			        $icon_styling = ' font-size:' . $social_icon_size .' ; margin-left:' . $social_icon_space .';margin-right:' . $social_icon_space .';';
			        echo "<div class='ult-social-buttons'>";

			            foreach ($social_icons as $social_link) {

			                if ( isset( $social_link->selected_team_icon ) && $social_link->selected_team_icon !== '' ) {

			                    $social_icon_url = ( isset( $social_link->social_icon_url ) && $social_link->social_icon_url !== '' ) ? $social_link->social_icon_url : '#';
			                    $social_link_title = ( isset( $social_link->social_link_title ) && $social_link->social_link_title !== '' ) ? $social_link->social_link_title : '';
			                    $social_icon_color = ( isset( $social_link->social_icon_color ) && $social_link->social_icon_color !== '' ) ? $social_link->social_icon_color : 'inherit';
			                    $default_icon_color = ( $social_icon_color != 'inherit' ) ? 'color:'.$social_icon_color.';' : '';
			                    $social_icon_hover_color = ( isset( $social_link->social_icon_hover_color ) && $social_link->social_icon_hover_color !== '' ) ? $social_link->social_icon_hover_color : 'inherit';
			                    echo "<a href='" . $social_icon_url . "' target='_blank' title='" . $social_link_title . "' class='ult-team ult-social-icon' style='" . $icon_styling . "; ". $default_icon_color ."'  data-iconcolor='" . $social_icon_color . "' data-iconhover='" . $social_icon_hover_color . "' ><i class='". $social_link->selected_team_icon ."'></i></a>";
			                }
			            }

			        echo "</div>";
			    }

			    echo '</div>'; //Description Slide

				echo '</div>'; //ult-team-member-bio-wrap
				if ( $link_switch == 'on' ) {
			        echo '</a>';
			    }
				echo '</div>'; //ult-team-member-wrap
			}
			elseif ( $team_member_style == 'style-1' ) {


				echo '<div class="ult-team-member-wrap ult-style-1 '. $custom_team_class .' '. $team_css .'">';
				if ( $link_switch == 'on' ) {
			        echo '<a href="'. $url .'" target="'. $target  .'">';
			    }
				echo '<div class="ult-team-member-image" style="'. esc_attr( $team_image_style ).'"> <img class="'. $team_img_grayscale_cls. '" src="' . apply_filters('ultimate_images', esc_url( $img )) . '" alt="'.$alt.'"  style="">';
				echo '<span class="ult-team-member-image-overlay ' . esc_attr( $img_hver_class ) . '" ' . $img_hver_data . ' ></span>';
				if ( $link_switch == 'on' ) {
			        echo '</a>';
			    }
				echo '</div>';//ult-team-member-image

			    echo '<div class="ult-team-member-bio-wrap ' . $team_member_style . ' ' . $id . '" style="text-align:' . $team_member_align_style . ';' . $title_box_style . '; ">';

			    echo '<div class="ult-team-member-name-wrap">';
			    if ( $link_switch == 'on' ) {
			        echo '<a href="'. $url .'" target="'. $target  .'" style="text-decoration: none;">';
			    }
			    echo '<'. $team_member_name_tag .' class="ult-team-member-name ult-responsive" ' . $team_member_name_responsive .' style="' . $team_member_name_font_styling . '">' . $name . '</'. $team_member_name_tag .'>';
			    if ( $link_switch == 'on' ) {
			        echo '</a>';
			    }
			    if ( $pos_in_org ) {
			        echo '<div class="ult-team-member-position ult-responsive" ' . $team_member_position_responsive . ' style="' . $team_member_position_font_styling . '">' . $pos_in_org . '</div>';
			    }

			    if ( $content ) {
			        echo '<div class="ult-team-member-description ult-responsive" ' . $team_member_desc_responsive . ' style="' . $team_member_description_font_styling . '"><p>' . do_shortcode( $content ) . '</p></div>';
			    }

			    echo '<div style="margin-bottom:15px">';

			    if ( $divider_effect == 'on') {

			        $divider_margin = '';
			        if( $team_member_align_style != 'center' ) {
			        	$divider_margin = "margin-" . $team_member_align_style . ":0px";
			        }

			        echo '<hr align="'. $team_member_align_style .'" class="ult-team-divider" style="padding-top: ' . $team_member_divider_height . 'px; width: ' . $team_member_divider_width . '%; background-color: ' . $team_member_divider_color . '; ' . $divider_margin . '" />';
			    }
			    echo '</div>';

			    $social_icons = json_decode (urldecode( $social_links ) );

			    if ( count( $social_icons ) > 0 && $social_icon_effect == 'on' ) {

			        $icon_styling = 'font-size:' . $social_icon_size .' ; margin-left:' . $social_icon_space .';margin-right:' . $social_icon_space .';';
			        echo "<div class='ult-social-buttons'>";

			            foreach ($social_icons as $social_link) {

			                if ( isset( $social_link->selected_team_icon ) && $social_link->selected_team_icon !== '' ) {

			                    $social_icon_url = ( isset( $social_link->social_icon_url ) && $social_link->social_icon_url !== '' ) ? $social_link->social_icon_url : '#';
			                    $social_link_title = ( isset( $social_link->social_link_title ) && $social_link->social_link_title !== '' ) ? $social_link->social_link_title : '';
			                    $social_icon_color = ( isset( $social_link->social_icon_color ) && $social_link->social_icon_color !== '' ) ? $social_link->social_icon_color : 'inherit';
			                    $default_icon_color = ( $social_icon_color != 'inherit' ) ? 'color:'.$social_icon_color.';' : '';
			                    $social_icon_hover_color = ( isset( $social_link->social_icon_hover_color ) && $social_link->social_icon_hover_color !== '' ) ? $social_link->social_icon_hover_color : 'inherit';
			                    echo "<a href='" . $social_icon_url . "' target='_blank' title='" . $social_link_title . "' class='ult-team ult-social-icon' style='" . $icon_styling . ";". $default_icon_color ."'  data-iconcolor='" . $social_icon_color . "' data-iconhover='" . $social_icon_hover_color . "' ><i class='". $social_link->selected_team_icon  ."'></i></a>";
			                }
			            }

			        echo "</div>";
			    }
			    echo '</div>'; //ult-team-member-name-wrap

				echo '</div>'; //ult-team-member-bio-wrap
				echo '</div>'; //ult-team-member-wrap
			}
			$is_preset = false; //Display settings for Preset
			$output = '';
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
				$output = '<pre>';
				$output .= $text;
				$output .= '</pre>';
			}
			echo $output;
			return ob_get_clean();
		}
		function init_team(){
			if(function_exists("vc_map"))
			{
				vc_map(
					array(
						"name" => __("Team", "ultimate_vc"),
						"base" => "ult_team",
						"icon" => "vc_icon_team",
						"class" => "",
						"content_element" => true,
						"controls" => "full",
						"category" => "Ultimate VC Addons",
						"description" => __("Show your awesome team.","ultimate_vc"),
						"admin_enqueue_js"  => preg_replace( '/\s/', '%20', plugins_url('../admin/js/team-admin.js',__FILE__) ),
						"params" => array(
							// Custom Coding for new team styles
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Team Style", "ultimate_vc" ),
								"param_name"  => "team_member_style",
								"value"       => array(
									__( "Style 1", "ultimate_vc" )  => "style-1",
									__( "Style 2", "ultimate_vc" )  => "style-2",
									__( "Style 3", "ultimate_vc" )  => "style-3",
								),
								"description" => __( "", "ultimate_vc" ),
								"group"       => "Image",
							),
							array(
								"type"        => "ult_img_single",
								"heading"     => __( "Select Image", "ultimate_vc" ),
								"param_name"  => "image",
								"description" => "",
								"group"       => "Image"
							),
							array(
								"type"        => "ult_switch",
								"class"       => "",
								"heading"     => __( "Grayscale Image", "ultimate_vc" ),
								"param_name"  => "team_img_grayscale",
								"value"       => "on",
								"options"     => array(
									"on" => array(
										"label" => __( "", "ultimate_vc" ),
										"on"    => "Yes",
										"off"   => "No",
									),
								),
								"default_set" => true,
								"description" => "",
								"dependency"  => Array( "element" => "team_member_style", "value" => Array('style-1' , 'style-3') ),
								"group"       => "Image",
							),
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Image Border Style", "ultimate_vc" ),
								"param_name"  => "img_border_style",
								"value"       => array(
									__( "None", "ultimate_vc" )   => "",
									__( "Solid", "ultimate_vc" )  => "solid",
									__( "Dashed", "ultimate_vc" ) => "dashed",
									__( "Dotted", "ultimate_vc" ) => "dotted",
									__( "Double", "ultimate_vc" ) => "double",
									__( "Inset", "ultimate_vc" )  => "inset",
									__( "Outset", "ultimate_vc" ) => "outset",
								),
								"description" => __( "", "ultimate_vc" ),
								"group"       => "Image",
							),
							array(
								"type"        => "number",
								"class"       => "",
								"heading"     => __( "Image Border Width", "ultimate_vc" ),
								"param_name"  => "img_border_width",
								"value"       => "",
								"suffix"      => "",
								"dependency"  => Array( "element" => "img_border_style", "not_empty" => true ),
								"description" => __( "", "ultimate_vc" ),
								"group"       => "Image",
							),
							array(
								"type"        => "colorpicker",
								"class"       => "",
								"heading"     => __( "Image Border Color", "ultimate_vc" ),
								"param_name"  => "img_border_color",
								"value"       => "",
								"dependency"  => Array( "element" => "img_border_style", "not_empty" => true ),
								"description" => __( "", "ultimate_vc" ),
								"group"       => "Image",
							),
							array(
								"type"        => "number",
								"class"       => "",
								"heading"     => __( "Image border radius", "ultimate_vc" ),
								"param_name"  => "img_border_radius",
								"value"       => "0",
								"min"         => "0",
								"max"         => "500",
								"step"        => "1",
								"suffix"      => "px",
								"description" => "",
								"dependency"  => Array( "element" => "img_border_style", "not_empty" => true ),
								"group"       => "Image",
							),
							array(
								"type"        => "ult_switch",
								"class"       => "",
								"heading"     => __( "Image Hover Effect", "ultimate_vc" ),
								"param_name"  => "img_hover_eft",
								"value"       => "off",
								"options"     => array(
									"on" => array(
										"label" => __( "Hover effect for the team member image", "ultimate_vc" ),
										"on"    => "Yes",
										"off"   => "No",
									),
								),
								"description" => "",
								"dependency"  => Array( "element" => "team_member_style", "value" => 'style-1' ),
								"group"       => "Image",
							),
							array(
								"type"        => "colorpicker",
								"class"       => "",
								"heading"     => __( "Image Hover Color", "ultimate_vc" ),
								"param_name"  => "img_hover_color",
								"value"       => "",
								"description" => "",
								"group"       => "Image",
								"dependency"  => Array( "element" => "img_hover_eft", "value" => 'on' ),
							),
							array(
								"type"        => "colorpicker",
								"class"       => "",
								"heading"     => __( "Background Color", "ultimate_vc" ),
								"param_name"  => "team_img_bg_color",
								"value"       => "",
								"description" => "",
								"group"       => "Image",
								"dependency"  => Array( "element" => "team_member_style", "value" => Array( 'style-2' , 'style-3') ),
							),
							array(
								"type" 		 => "number",
								"class" 	 => "",
								"heading" 	 => __("Image Opacity", "ultimate_vc"),
								"param_name" => "team_img_opacity",
								"value" 	 => 1,
								"min" 		 => 0,
								"max" 		 => 1,
								"description"=> __( "Enter value between 0.0 to 1 (0 is maximum transparency, while 1 is lowest)", "ultimate_vc" ),
								"group"      => "Image",
								"dependency"  => Array( "element" => "team_member_style", "value" =>  Array( 'style-2' ) ),
							),
							array(
								"type" 		 => "number",
								"class" 	 => "",
								"heading" 	 => __("Image Opacity on Hover", "ultimate_vc"),
								"param_name" => "team_img_hover_opacity",
								"value" 	 => '0.65',
								"min" 		 => 0,
								"max" 		 => 1,
								"description"=> __( "Enter value between 0.0 to 1 (0 is maximum transparency, while 1 is lowest)", "ultimate_vc" ),
								"group"      => "Image",
								"dependency"  => Array( "element" => "team_member_style", "value" =>  Array( 'style-2' ) ),
							),
							array(
								"type" 		 => "number",
								"class" 	 => "",
								"heading" 	 => __("Image Opacity on Hover", "ultimate_vc"),
								"param_name" => "team_img_hover_opacity_style3",
								"value" 	 => 0.1,
								"min" 		 => 0,
								"max" 		 => 1,
								"description"=> __( "Enter value between 0.0 to 1 (0 is maximum transparency, while 1 is lowest)", "ultimate_vc" ),
								"group"      => "Image",
								"dependency"  => Array( "element" => "team_member_style", "value" =>  Array( 'style-3') ),
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Custom Class", "ultimate_vc" ),
								"param_name"  => "custom_team_class",
								"description" => "",
								"group"       => "Image"
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Name", "ultimate_vc" ),
								"param_name"  => "name",
								"admin_label" => true,
								"description" => "",
								"group"       => "Text"
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Designation", "ultimate_vc" ),
								"param_name"  => "pos_in_org",
								"description" => "",
								"group"       => "Text"
							),
							array(
								"type"        => "textarea_html",
								"heading"     => __( "Description", "ultimate_vc" ),
								"param_name"  => "content",
								"description" => "",
								"group"       => "Text"
							),
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Text Alignment", "ultimate_vc" ),
								"param_name"  => "team_member_align_style",
								"value"       => array(
									__( "Center", "ultimate_vc" )   => "center",
									__( "Left", "ultimate_vc" )  => "left",
									__( "Right", "ultimate_vc" )  => "right",
								),
								"description" => __( "", "ultimate_vc" ),
								"group"       => "Text",
							),
							array(
								"type" => "ultimate_spacing",
								"heading" => __("Space around text","ultimate_vc"),
								"param_name" => "title_box_padding",
								"mode"  => "padding",                   		//  margin/padding
								"unit"  => "px",                       		//  [required] px,em,%,all     Default all
								"positions" => array(                  		//  Also set 'defaults'
								  __("Top","ultimate_vc")     => "",
								  __("Right","ultimate_vc")   => "",
								  __("Bottom","ultimate_vc")  => "",
								  __("Left","ultimate_vc")    => ""
								),
								"group"      => __( "Text", "ultimate_vc" )
							),
							/*array(
								"type"       => "text",
								"param_name" => "social_link_setting",
								"heading"    => __( "<h4>Social Links Setting</h4>", "ultimate_vc" ),
								"value"      => "",
								"group"      => "Image",
								"edit_field_class" => "ult-param-heading-wrapper vc_column vc_col-sm-12",
							),*/
							array(
								"type"        => "ult_switch",
								"class"       => "",
								"heading"     => __( "Enable Social Icons", "ultimate_vc" ),
								"param_name"  => "social_icon_effect",
								"value"       => "off",
								"options"     => array(
									"on" => array(
										"label" => __( "Add Social Icon links to connect on social network", "ultimate_vc" ),
										"on"    => "Yes",
										"off"   => "No",
									),
								),
								"description" => "",
								"group"       => "Social Links",
							),
							array(
								'type' => 'param_group',
								'heading' => __( 'Add Social Links', 'ultimate_vc' ),
								'param_name' => 'social_links',
								'group'  => __( 'Social Links', 'ultimate_vc' ),
								'value' => urlencode( json_encode ( array(
																		array(
																			"selected_team_icon" => "",
																			"social_title" => "",
																			"social_icon_url" => "",
																			"social_icon_color" => "",
																			"social_icon_hover_color" => ""
																		)
								) ) ),
								'params' => array(
									array(
										"type" => "textfield",
										"heading" => __( "Title", "my-text-domain" ),
										"param_name" => "social_link_title",
										"value" => "",
										"description" => "",
										"admin_label" => true,
									),
									array(
										'type' => 'textfield',
										'heading' => __( 'Link', 'ultimate_vc' ),
										'param_name' => 'social_icon_url',
										'description' => "",
										'value' => '#',
									),
									array(
										'type' => 'icon_manager',
										'heading' => __( 'Select Icon', 'js_composer' ),
										'param_name' => 'selected_team_icon',
										'value' => '',
										'description' => __( 'Select icon from library.', 'ultimate_vc' ),
									),
									array(
										"type"        => "colorpicker",
										"class"       => "",
										"heading"     => __( "Icon Color", "ultimate_vc" ),
										"param_name"  => "social_icon_color",
										"value"       => "",
									),
									array(
										"type"        => "colorpicker",
										"class"       => "",
										"heading"     => __( "Icon hover Color", "ultimate_vc" ),
										"param_name"  => "social_icon_hover_color",
										"value"       => "",
									),
								),
								"dependency"  => Array( "element" => "social_icon_effect", "value" => 'on' ),
								'callbacks' => array(
									'after_add' => 'vcChartParamAfterAddCallback'
								)
							),
							array(
								"type"        => "number",
								"heading"     => __( "Social Icon Size", "ultimate_vc" ),
								"param_name"  => "social_icon_size",
								"value"       => "16",
								"suffix"      => "px",
								"dependency"  => Array( "element" => "img_border_style", "not_empty" => true ),
								"description" => "",
								"dependency"  => Array( "element" => "social_icon_effect", "value" => 'on' ),
								"group"       => __( 'Social Links', 'ultimate_vc' ),
							),
							array(
								"type"        => "number",
								"heading"     => __( "Spacing Between Social Icons", "ultimate_vc" ),
								"param_name"  => "social_icon_space",
								"value"       => "10",
								"suffix"      => "px",
								"dependency"  => Array( "element" => "img_border_style", "not_empty" => true ),
								"description" => "",
								"dependency"  => Array( "element" => "social_icon_effect", "value" => 'on' ),
								"group"       => __( 'Social Links', 'ultimate_vc' ),
							),
							array(
								"type"        => "ult_switch",
								"class"       => "",
								"heading"     => __( "Separator", "ultimate_vc" ),
								"param_name"  => "divider_effect",
								"value"       => "off",
								"options"     => array(
									"on" => array(
										"label" => __( "Separator between description & social icons", "ultimate_vc" ),
										"on"    => "Yes",
										"off"   => "No",
									),
								),
								"description" => "",
								"group"       => "Social Links",
								"dependency"  => Array( "element" => "social_icon_effect", "value" => 'on' ),
							),
							array(
								"type"        => "colorpicker",
								"class"       => "",
								"heading"     => __( "Separator Color", "ultimate_vc" ),
								"param_name"  => "team_member_divider_color",
								"value"       => "",
								"description" => "",
								"group"       => "Social Links",
								"dependency"  => Array( "element" => "divider_effect", "value" => 'on' ),
							),
							array(
								"type" 		 => "number",
								"class" 	 => "",
								"heading" 	 => __("Separator Height", "ultimate_vc"),
								"param_name" => "team_member_divider_height",
								"value" 	 => 1,
								"min" 		 => 1,
								"max" 		 => 500,
								"suffix" 	 => "px",
								"group"      => "Social Links",
								"dependency" => Array("element" => "divider_effect", "value" => 'on' ),
							),
							array(
								"type"        => "number",
								"class"       => "",
								"heading"     => __( "Separator Width", "ultimate_vc" ),
								"param_name"  => "team_member_divider_width",
								"value"       => "80",
								"suffix"      => "%",
								"description" => "",
								"group"       => "Social Links",
								"dependency"  => Array( "element" => "divider_effect", "value" => 'on' ),
							),
							array(
								"type"       => "text",
								"param_name" => "title_text_typography",
								"heading"    => __( "<h4>Name Typography</h4>", "ultimate_vc" ),
								"value"      => "",
								"group"      => "Typography",
								"edit_field_class" => "ult-param-heading-wrapper vc_column vc_col-sm-12",
							),
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Tag", "ultimate_vc" ),
								"param_name"  => "team_member_name_tag",
								"value"       => array(
									__( "Default", "ultimate_vc" )  => "h2",
									__( "H1", "ultimate_vc" )  => "h1",
									__( "H2", "ultimate_vc" )  => "h2",
									__( "H3", "ultimate_vc" )  => "h3",
									__( "H4", "ultimate_vc" )  => "h4",
									__( "H5", "ultimate_vc" )  => "h5",
									__( "H6", "ultimate_vc" )  => "h6",
									__( "P", "ultimate_vc" )  => "p",
									__( "Div", "ultimate_vc" )  => "div",
								),
								"description" => __( "Default is H2", "ultimate_vc" ),
								"group"       => "Typography",
							),
							array(
								"type"       => "ultimate_google_fonts",
								"heading"    => __( "Font Family", "ultimate_vc" ),
								"param_name" => "team_member_name_font",
								"value"      => "",
								"group"      => "Typography"
							),
							array(
								"type"       => "ultimate_google_fonts_style",
								"heading"    => __( "Font Style", "ultimate_vc" ),
								"param_name" => "team_member_name_font_style",
								"value"      => "",
								"group"      => "Typography"
							),
							// Responsive Param
							array(
		                  	  	"type" => "ultimate_responsive",
		                  	  	"class" => "font-size",
		                  	  	"heading" => __("Font size", 'ultimate_vc'),
		                  	  	"param_name" => "team_member_name_font_size",
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
		                  	array(
		                  	  	"type" => "ultimate_responsive",
		                  	  	"class" => "font-size",
		                  	  	"heading" => __("Line Height", 'ultimate_vc'),
		                  	  	"param_name" => "team_member_name_line_height",
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
							array(
								"type"        => "colorpicker",
								"class"       => "",
								"heading"     => __( "Text Color", "ultimate_vc" ),
								"param_name"  => "team_member_name_color",
								"value"       => "",
								"description" => "",
								"group"       => "Typography",
							),
							array(
								"type"       => "text",
								"param_name" => "title_text_typography",
								"heading"    => __( "<h4>Designation Typography</h4>", "ultimate_vc" ),
								"value"      => "",
								"group"      => "Typography",
								"edit_field_class" => "ult-param-heading-wrapper vc_column vc_col-sm-12",
							),
							array(
								"type"       => "ultimate_google_fonts",
								"heading"    => __( "Font Family", "ultimate_vc" ),
								"param_name" => "team_member_position_font",
								"value"      => "",
								"group"      => "Typography"
							),
							array(
								"type"       => "ultimate_google_fonts_style",
								"heading"    => __( "Font Style", "ultimate_vc" ),
								"param_name" => "team_member_position_font_style",
								"value"      => "",
								"group"      => "Typography"
							),
							// Responsive Param
							array(
		                  	  	"type" => "ultimate_responsive",
		                  	  	"class" => "font-size",
		                  	  	"heading" => __("Font size", 'ultimate_vc'),
		                  	  	"param_name" => "team_member_position_font_size",
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
		                  	array(
		                  	  	"type" => "ultimate_responsive",
		                  	  	"class" => "font-size",
		                  	  	"heading" => __("Line Height", 'ultimate_vc'),
		                  	  	"param_name" => "team_member_position_line_height",
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
							array(
								"type"        => "colorpicker",
								"class"       => "",
								"heading"     => __( "Text Color", "ultimate_vc" ),
								"param_name"  => "team_member_org_color",
								"value"       => "",
								"description" => "",
								"group"       => "Typography",
							),
							array(
								"type"       => "text",
								"param_name" => "title_text_typography",
								"heading"    => __( "<h4>Description Typography</h4>", "ultimate_vc" ),
								"value"      => "",
								"group"      => "Typography",
								"edit_field_class" => "ult-param-heading-wrapper vc_column vc_col-sm-12",
							),
							array(
								"type"       => "ultimate_google_fonts",
								"heading"    => __( "Font Family", "ultimate_vc" ),
								"param_name" => "team_member_description_font",
								"value"      => "",
								"group"      => "Typography"
							),
							array(
								"type"       => "ultimate_google_fonts_style",
								"heading"    => __( "Font Style", "ultimate_vc" ),
								"param_name" => "team_member_description_font_style",
								"value"      => "",
								"group"      => "Typography"
							),
							array(
		                  	  	"type" => "ultimate_responsive",
		                  	  	"class" => "font-size",
		                  	  	"heading" => __("Font size", 'ultimate_vc'),
		                  	  	"param_name" => "team_member_description_font_size",
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
		                  	array(
		                  	  	"type" => "ultimate_responsive",
		                  	  	"class" => "font-size",
		                  	  	"heading" => __("Line Height", 'ultimate_vc'),
		                  	  	"param_name" => "team_member_description_line_height",
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
							array(
								"type"        => "colorpicker",
								"class"       => "",
								"heading"     => __( "Text Color", "ultimate_vc" ),
								"param_name"  => "team_member_desc_color",
								"value"       => "",
								"description" => "",
								"group"       => "Typography",
							),
							/*array(
								"type" => "ultimate_spacing",
								"heading" => __("Title Box Margin","ultimate_vc"),
								"param_name" => "title_box_margin",
								"mode"  => "margin",                   	//  margin/padding
								"unit"  => "px",                       		//  [required] px,em,%,all     Default all
								"positions" => array(                  		//  Also set 'defaults'
								  __("Top","ultimate_vc")     => "",
								  __("Right","ultimate_vc")   => "",
								  __("Bottom","ultimate_vc")  => "",
								  __("Left","ultimate_vc")    => ""
								),
								"group"      => __( "Advanced", "ultimate_vc" )
							),*/
							array(
								"type"        => "ult_switch",
								"class"       => "",
								"heading"     => __( "Responsive", "ultimate_vc" ),
								"param_name"  => "team_member_responsive_enable",
								"value"       => "off",
								"options"     => array(
									"on" => array(
										"label" => __( "Apply Breakpoint to container?", "ultimate_vc" ),
										"on"    => "Yes",
										"off"   => "No",
									),
								),
								"description" => "",
								"dependency"  => Array( "element" => "team_member_style", "value" => 'style-2' ),
								"group"       => "Advanced",
							),
							array(
								"type"        => "number",
								"heading"     => __( "Breakpoint", "ultimate_vc" ),
								"param_name"  => "team_responsive_width",
								"suffix"	  => "px",
								"description" => "Breakpoint is the point of screen resolution from where you can set your Style-2 into Style-1 to the minimum screen resolution.",
								"dependency"  => Array( "element" => "team_member_responsive_enable", "value" => 'on' ),
								"group"       => "Advanced"
							),
							array(
								"type"        => "ult_switch",
								"class"       => "",
								"heading"     => __( "Custom link to staff page", "ultimate_vc" ),
								"param_name"  => "link_switch",
								"value"       => "",
								// "default_set" => 'true',
								"options"     => array(
									"on" => array(
										"label" => __( "Add custom link to employee page", "ultimate_vc" ),
										"on"    => "Yes",
										"off"   => "No",
									),
								),
								"description" => "",
								"dependency"  => "",
								"group"       => "Advanced",
							),
							array(
								"type"        => "vc_link",
								"class"       => "",
								"heading"     => __( "Custom Link", "ultimate_vc" ),
								"param_name"  => "staff_link",
								"value"       => "",
								// "description" => __( "Add link to team member's name ", "ultimate_vc" ),
								"group"       => __( "Advanced", "ultimate_vc" ),
								"dependency"  => Array( "element" => "link_switch", "value" => 'on' ),
							),
							/*array(
								"type"        => "colorpicker",
								"class"       => "",
								"heading"     => __( "Title Background Color", "ultimate_vc" ),
								"param_name"  => "team_member_bg_color",
								"value"       => "#ffffff",
								"description" => "",
								"group"       => "Advanced",
							),*/
							array(
            					"type" => "css_editor",
            					"heading" => __( "CSS box", "my-text-domain" ),
            					"param_name" => "team_css",
            					"group" => __( "Design Options", "my-text-domain" ),
        					),
						) // params array
					)
				);
			}
		}
	}
	new Ultimate_Team;

	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_ult_team extends WPBakeryShortCode {
		}
	}

}