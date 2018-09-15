<?php
/*
* Add-on Name: Ultimate Video Banner
* Add-on URI: http://dev.brainstormforce.com
*/
if(!class_exists('Ultimate_Video_Banner')) {
	class Ultimate_Video_Banner {
		function __construct() {
			add_action('init',array($this,'ultimate_video_banner_init'));
			add_shortcode('ultimate_video_banner',array($this,'ultimate_video_banner_shortcode'));
			add_action("wp_enqueue_scripts", array($this, "register_video_banner_assets"),1);
		}

		function register_video_banner_assets() {
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
			wp_register_style('ultimate-video-banner-style',plugins_url($css_path.'video-banner'.$ext.'.css',__FILE__),array(),ULTIMATE_VERSION);
			wp_register_script('ultimate-video-banner-script',plugins_url($js_path.'video-banner'.$ext.'.js',__FILE__),array('jquery'),ULTIMATE_VERSION);
		}

		function ultimate_video_banner_init() {
			if(function_exists('vc_map')) {
				vc_map(
					array(
						'name' => __('Video Banner','ultimate_vc'),
						'base' => 'ultimate_video_banner',
						'icon' => 'vc_ultimate_video_banner',
						'category' => 'Ultimate VC Addons',
						'description' => __('Show your video in ease.','ultimate_vc'),
						'deprecated' => '3.13.5',
						'params' => array(
							array(
								'type' => 'textfield',
								'heading' => __('Link to the video in MP4 Format','ultimate_vc'),
								'param_name' => 'video_banner_mp4_link',
							),
							array(
								'type' => 'textfield',
								'heading' => __('Link to the video in WebM / Ogg Format','ultimate_vc'),
								'param_name' => 'video_banner_webm_ogg_link',
								'description' => __('IE, Chrome & Safari','ultimate_vc').' <a href="http://www.w3schools.com/html/html5_video.asp" target="_blank">'.__('support','ultimate_vc').'</a> '.__('MP4 format, while Firefox & Opera prefer WebM / Ogg formats.','ultimate_vc').' '.__('You can upload the video through','ultimate_vc').' <a href="'.home_url().'/wp-admin/media-new.php" target="_blank">'.__('WordPress Media Library','ultimate_vc').'</a>.',
							),
							array(
								'type' => 'ult_img_single',
								'heading' => __('Placeholder','ultimate_vc'),
								'param_name' => 'video_banner_placeholder',
 							),
							array(
								'type' => 'dropdown',
								'heading' => __('Effect','ultimate_vc'),
								'param_name' => 'video_banner_effect',
								'value' => array(
									__('Style 1','ultimate_vc') => 'ult-vdo-effect-style1',
									__('Style 2','ultimate_vc') => 'ult-vdo-effect-style2',
									__('Style 3','ultimate_vc') => 'ult-vdo-effect-style3',
									__('Style 4','ultimate_vc') => 'ult-vdo-effect-style4',
									__('Style 5','ultimate_vc') => 'ult-vdo-effect-style5',
									__('Style 6','ultimate_vc') => 'ult-vdo-effect-style6',
									__('Style 7','ultimate_vc') => 'ult-vdo-effect-style7',
									//__('Style 8','ultimate_vc') => 'ult-vdo-effect-style10',
									//__('Style 9','ultimate_vc') => 'ult-vdo-effect-style10',
									//__('Style 10','ultimate_vc') => 'ult-vdo-effect-style10'
								)
							),
							array(
								'type' => 'textfield',
								'heading' => __('Title','ultimate_vc'),
								'param_name' => 'video_banner_title',
								'group' => 'Content'
							),
							array(
								'type' => 'textarea',
								'heading' => __('Content','ultimate_vc'),
								'param_name' => 'video_banner_content',
								'group' => 'Content'
							),
							array(
								"type" => "ult_param_heading",
								"text" => __("Title Settings","ultimate_vc"),
								"param_name" => "title_typograpy",
								"group" => "Typography",
								"class" => "ult-param-heading",
								'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
							),
							array(
								"type" => "ultimate_google_fonts",
								"heading" => __("Font Family", "ultimate_vc"),
								"param_name" => "title_font_family",
								"description" => __("Select the font of your choice.","ultimate_vc")." ".__("You can","ultimate_vc")." <a target='_blank' href='".admin_url('admin.php?page=bsf-google-font-manager')."'>".__("add new in the collection here","ultimate_vc")."</a>.",
								"group" => "Typography"
							),
							array(
								"type" => "ultimate_google_fonts_style",
								"heading" 		=>	__("Font Style", "ultimate_vc"),
								"param_name"	=>	"title_font_style",
								"group" => "Typography"
							),
							array(
								"type" => "number",
								"class" => "font-size",
								"heading" => __("Font Size", "ultimate_vc"),
								"param_name" => "title_font_size",
								"min" => 10,
								"suffix" => "px",
								"group" => "Typography"
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Font Color", "ultimate_vc"),
								"param_name" => "title_color",
								"value" => "",
								"group" => "Typography"
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Line Height", "ultimate_vc"),
								"param_name" => "title_line_height",
								"value" => "",
								"suffix" => "px",
								"group" => "Typography"
							),
							array(
								"type" => "ult_param_heading",
								"text" => __("Desciption Settings","ultimate_vc"),
								"param_name" => "desc_typograpy",
								"group" => "Typography",
								"class" => "ult-param-heading",
								'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
							),
							array(
								"type" => "ultimate_google_fonts",
								"heading" => __("Font Family", "ultimate_vc"),
								"param_name" => "desc_font_family",
								"description" => __("Select the font of your choice.","ultimate_vc")." ".__("You can","ultimate_vc")." <a target='_blank' href='".admin_url('admin.php?page=bsf-google-font-manager')."'>".__("add new in the collection here","ultimate_vc")."</a>.",
								"group" => "Typography"
							),
							array(
								"type" => "ultimate_google_fonts_style",
								"heading" 		=>	__("Font Style", "ultimate_vc"),
								"param_name"	=>	"desc_font_style",
								"group" => "Typography"
							),
							array(
								"type" => "number",
								"class" => "font-size",
								"heading" => __("Font Size", "ultimate_vc"),
								"param_name" => "desc_font_size",
								"min" => 10,
								"suffix" => "px",
								"group" => "Typography"
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Font Color", "ultimate_vc"),
								"param_name" => "desc_color",
								"value" => "",
								"group" => "Typography"
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Line Height", "ultimate_vc"),
								"param_name" => "desc_line_height",
								"value" => "",
								"suffix" => "px",
								"group" => "Typography"
							),
							array(
								'type' => 'ultimate_responsive',
								'heading' => __('Banner Size','ultimate_vc'),
								'param_name' => 'video_banner_size',
								'unit' => 'px',
								'media' => array(
									'Desktop'           => '',
                          	  	    'Tablet'            => '',
                          	  	    'Tablet Portrait'   => '',
                          	  	    'Mobile Landscape'  => '',
                          	  	    'Mobile'            => '',
								),
								'group' => 'Design'
							),
							array(
								'type' => 'colorpicker',
								'heading' => __('Overlay Color','ultimate_vc'),
								'param_name' => 'video_banner_overlay_color',
								'group' => 'Design'
							),
							array(
								'type' => 'colorpicker',
								'heading' => __('Overlay Hover Color','ultimate_vc'),
								'param_name' => 'video_banner_overlay_hover_color',
								'group' => 'Design'
							),
							array(
								'type' => 'css_editor',
								'heading' => __('CSS','ultimate_vc'),
								'param_name' => 'video_banner_vc_css',
								'edit_field_class' => 'vc_col-sm-12 vc_column no-vc-background no-vc-border video_banner_css_editor',
								'group' => 'Design'
							),
							array(
								'type' => 'number',
								'heading' => __('Start Time','ultimate_vc'),
								'param_name' => 'video_banner_start_time',
								'suffix' => 'in seconds',
								'group' => 'Advanced Settings'
							),
							array(
								'type' => 'checkbox',
								'heading' => __('Mute','ultimate_vc'),
								'param_name' => 'video_banner_mute',
								'value' => array(
									__('Enable','ultimate_vc') => 'muted'
								),
								'group' => 'Advanced Settings'
							)
						)
					)
				);
			}
		}

		function ultimate_video_banner_shortcode($atts, $content = null) {
			extract(
				shortcode_atts(
					array(
						'video_banner_mp4_link' => '',
						'video_banner_webm_ogg_link' => '',
						'video_banner_effect' => 'ult-vdo-effect-style1',
						'video_banner_placeholder' => '',
						'video_banner_title' => '',
						'video_banner_content' => '',
						'title_font_family' => '',
						'title_font_style' => '',
						'title_font_size' => '',
						'title_color' => '',
						'title_line_height' => '',
						'desc_font_family' => '',
						'desc_font_style' => '',
						'desc_font_size' => '',
						'desc_color' => '',
						'desc_line_height' => '',
						'video_banner_size' => '',
						'video_banner_overlay_color' => '',
						'video_banner_overlay_hover_color' => '',
						'video_banner_vc_css' => '',
						'video_banner_start_time' => '0',
						'video_banner_mute' => '',
					),$atts
				)
			);
			$output = $placeholder = $placeholder_css = $vc_css_class = '';

			$vc_css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $video_banner_vc_css, ' ' ), 'ultimate_video_banner', $atts );

			$video_id = 'ult-video-banner-'.uniqid(rand());

			$args = array(
		  		'target'		=>	'#'.$video_id,
		  		'media_sizes' 	=> array(
					'width' 	=> $video_banner_size,
				),
		  	);
			$banner_height_responsive_data = get_ultimate_vc_responsive_media_css($args);

			if(preg_match('/^#[a-f0-9]{6}$/i', $video_banner_overlay_color)) //hex color is valid
			{
				$video_banner_overlay_color = hex2rgbUltParallax($video_banner_overlay_color, $opacity = 0.8);
			}
			if(preg_match('/^#[a-f0-9]{6}$/i', $video_banner_overlay_hover_color)) //hex color is valid
			{
				$video_banner_overlay_hover_color = hex2rgbUltParallax($video_banner_overlay_hover_color, $opacity = 0.4);
			}

			/* ---- main heading styles ---- */
			$title_style_inline = '';
			if($title_font_family != '')
			{
				$title_font_family = get_ultimate_font_family($title_font_family);
				if($title_font_family)
					$title_style_inline .= 'font-family:\''.$title_font_family.'\';';
			}
			// main heading font style
			$title_style_inline .= get_ultimate_font_style($title_font_style);
			//attach font size if set
			if($title_font_size != '')
				$title_style_inline .= 'font-size:'.$title_font_size.'px;';
			//attach font color if set
			if($title_color != '')
				$title_style_inline .= 'color:'.$title_color.';';
			//line height
			if($title_line_height != '')
				$title_style_inline .= 'line-height:'.$title_line_height.'px;';

			/* ---- description styles ---- */
			$desc_style_inline = '';
			if($desc_font_family != '')
			{
				$desc_font_family = get_ultimate_font_family($desc_font_family);
				if($desc_font_family)
					$desc_style_inline .= 'font-family:\''.$desc_font_family.'\';';
			}
			// desc font style
			$desc_style_inline .= get_ultimate_font_style($desc_font_style);
			//attach font size if set
			if($desc_font_size != '')
				$desc_style_inline .= 'font-size:'.$desc_font_size.'px;';
			//attach font color if set
			if($desc_color != '')
				$desc_style_inline .= 'color:'.$desc_color.';';
			//line height
			if($desc_line_height != '')
				$desc_style_inline .= 'line-height:'.$desc_line_height.'px;';

			if($video_banner_placeholder != '')

			{
				$img_info = apply_filters('ult_get_img_single', $video_banner_placeholder, 'url', 'full');

				$placeholder = $img_info;
				$placeholder_css = 'background-image:url('.$placeholder.');';
			}

			$output = '<div id="'.$video_id.'" class="'.$vc_css_class.' ult-video-banner ult-vdo-effect '.$video_banner_effect.' utl-video-banner-item ult-responsive" '.$banner_height_responsive_data.' data-current-time="'.$video_banner_start_time.'" data-placeholder="'.$placeholder.'" style="'.$placeholder_css.'">';
				if($video_banner_mp4_link != '' || $video_banner_webm_ogg_link != '') :
					$output .= '<video autoplay loop '.$video_banner_mute.' poster="'.$placeholder.'">';
						if($video_banner_mp4_link != '')
							$output .= '<source src="'.$video_banner_mp4_link.'" type="video/mp4">';
						if($video_banner_webm_ogg_link != '') :
							$ext = pathinfo($video_banner_webm_ogg_link);
							if($ext['extension'] == 'webm')
								$type = 'webm';
							else
								$type = 'ogg';
							$output .= '<source src="'.$video_banner_webm_ogg_link.'" type="video/'.$type.'">';
						endif;
						$output.= __('Your browser does not support the video tag.','ultimate_vc');
					$output .= '</video>';
				endif;
				if($video_banner_title != '' || $content != '') :
					$output .= '<div class="ult-video-banner-desc">';
						if($video_banner_title != '') :
							$output .= '<h2 class="ult-video-banner-title" style="'.$title_style_inline.'">'.__($video_banner_title, 'ultimate_vc').'</h2>';
						endif;
						if($video_banner_content != '') :
							$output .= '<div class="ult-video-banner-content" style="'.$desc_style_inline.'">'.__($video_banner_content, 'ultimate_vc').'</div>';
						endif;
					$output .= '</div>';
				endif;
				$output .= '<div class="ult-video-banner-overlay" data-overlay="'.$video_banner_overlay_color.'" data-overlay-hover="'.$video_banner_overlay_hover_color.'"></div>';
			$output .= '</div>';
			return $output;
		}
	}
}
$Ultimate_Video_Banner = new Ultimate_Video_Banner;
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_ultimate_video_banner extends WPBakeryShortCode {
    }
}
?>