<?php
/*
* Add-on Name: Info List for Visual Composer
* Add-on URI: http://dev.brainstormforce.com
*/
if(!class_exists('AIO_Info_list'))
{
	class AIO_Info_list
	{
		var $connector_animate;
		var $connect_color;
		var $icon_font;
		var $border_col;
		var $icon_style;

		// Icon size that will be also added for icon description for equal height.
		var $icon_size;

		function __construct()
		{
			$this->connector_animate = '';
			$this->connect_color = '';
			$this->icon_style = '';
			$this->icon_style = '';
			add_action('init', array($this, 'add_info_list'));
			if(function_exists('vc_is_inline')){
				if(!vc_is_inline()){
					add_shortcode( 'info_list', array($this, 'info_list' ) );
					add_shortcode( 'info_list_item', array($this, 'info_list_item' ) );
				}
			} else {
				add_shortcode( 'info_list', array($this, 'info_list' ) );
				add_shortcode( 'info_list_item', array($this, 'info_list_item' ) );
			}
		}
		function info_list($atts, $content = null)
		{
			$this->icon_style = $this->connector_animate = $this->icon_font = $this->border_col = '';
			$position = $style = $icon_color = $icon_bg_color = $connector_animation = $font_size_icon = $icon_border_style = $icon_border_size = $connector_color = $border_color = $el_class = $info_list_link_html = '';
			extract(shortcode_atts(array(
				'position' => 'left',
				'style' => 'square with_bg',
				'connector_animation' => '',
				'icon_color' =>'#333333',
				'icon_bg_color' =>'#ffffff',
				'connector_color' => '#333333',
				'border_color' => '#333333',
				'font_size_icon' => '24',
				'icon_border_style' => 'none',
				'icon_border_size' => '1',
				'el_class' => '',
				'css_info_list' =>'',
			), $atts));

			$css_info_list = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css_info_list, ' ' ), "info_list", $atts );
			$css_info_list = esc_attr( $css_info_list );

			$vc_version = (defined('WPB_VC_VERSION')) ? WPB_VC_VERSION : 0;
			$is_vc_49_plus = (version_compare(4.9, $vc_version, '<=')) ? 'ult-adjust-bottom-margin' : '';

			$this->connect_color = $connector_color;
			$this->border_col = $border_color;
			if($style == 'square with_bg' || $style == 'circle with_bg' || $style == 'hexagon'){
				$this->icon_font = 'font-size:'.($font_size_icon*3).'px;';
				if($icon_border_size !== ''){
					$this->icon_style .= 'font-size:'.$font_size_icon.'px;';
					if($style !== 'hexagon') {
						$this->icon_style .= 'border-width:'.$icon_border_size.'px;';
						$this->icon_style .= 'border-style:'.$icon_border_style.';';
					}
					$this->icon_style .= 'background:'.$icon_bg_color.';';
					$this->icon_style .= 'color:'.$icon_color.';';
					if($style =="hexagon")
						$this->icon_style .= 'border-color:'.$icon_bg_color.';';
					else
						$this->icon_style .= 'border-color:'.$border_color.';';
				}
			} else {
				$big_size = ($font_size_icon*3)+($icon_border_size*2);
				if($icon_border_size !== ''){
					$this->icon_font = 'font-size:'.$big_size.'px;';
					$this->icon_style .= 'font-size:'.$font_size_icon.'px;';
					$this->icon_style .= 'border-width:'.$icon_border_size.'px;';
					$this->icon_style .= 'border-style:'.$icon_border_style.';';
					$this->icon_style .= 'color:'.$icon_color.';';
					$this->icon_style .= 'border-color:'.$border_color.';';
				}
			}

			$this->icon_size = $font_size_icon;

			if($position == "top")
				$this->connector_animate = "fadeInLeft";
			else
				$this->connector_animate = $connector_animation;
			$output = '<div class="smile_icon_list_wrap '.$is_vc_49_plus.' '.$el_class.' '.$css_info_list.'">';
			$output .= '<ul class="smile_icon_list '.$position.' '.$style.'">';
			$output .= do_shortcode($content);
			$output .= '</ul>';
			$output .= '</div>';
			return $output;
		}
		function info_list_item($atts,$content = null)
		{
			// Do nothing
			$list_title = $list_icon = $animation = $icon_color = $icon_bg_color = $icon_img = $icon_type = $desc_font_line_height = $title_font_line_height = '';
			$title_font = $title_font_style = $title_font_size = $title_font_color = $desc_font = $desc_font_style = $desc_font_size = $desc_font_color = '';
			extract(shortcode_atts(array(
				'list_title' => '',
				'animation' => '',
				'list_icon' => '',
				'icon_img' => '',
				'icon_type' => '',
				'title_font' => '',
				'title_font_style' => '',
				'title_font_size' => '16',
				'title_font_line_height'=> '24',
				'title_font_color' => '',
				'desc_font' => '',
				'desc_font_style' => '',
				'desc_font_size' => '13',
				'desc_font_color' => '',
				'desc_font_line_height'=> '18',
				'info_list_link' => '',
				'info_list_link_apply' => '',
			), $atts));
			//$content =  wpb_js_remove_wpautop($content);
			$css_trans = $style = $ico_col = $connector_trans = $icon_html = $title_style = $desc_style = $info_list_link_html = '';
			//$font_args = array();

			$is_link = false;

			if($info_list_link != '')
			{
				$info_list_link_temp = vc_build_link($info_list_link);
				$url = $info_list_link_temp['url'];
				$title = $info_list_link_temp['title'];
				$target = $info_list_link_temp['target'];
				if($url != '')
				{
					if($target != '')
						$target = 'target="'.$target.'"';
					$info_list_link_html = '<a href="'.$url.'" class="ulimate-info-list-link" '.$target.'></a>';
				}
				$is_link = true;
			}

						/* title */
			if($title_font != '')
			{
				$font_family = get_ultimate_font_family($title_font);
				$title_style .= 'font-family:\''.$font_family.'\';';
				//array_push($font_args, $title_font);
			}
			if($title_font_style != '')
				$title_style .= get_ultimate_font_style($title_font_style);
			// if($title_font_size != '')
			// 	$title_style .= 'font-size:'.$title_font_size.'px;';
			// if($title_font_line_height != '')
			// 	$title_style .= 'line-height:'.$title_font_line_height.'px;';

			if(is_numeric($title_font_size)){
				$title_font_size = 'desktop:'.$title_font_size.'px;';
			}
			if(is_numeric($title_font_line_height)){
				$title_font_line_height = 'desktop:'.$title_font_line_height.'px;';
			}
			$info_list_id = 'Info-list-wrap-'.rand(1000, 9999);
			$info_list_args = array(
                'target' => '#'.$info_list_id.' h3', // set targeted element e.g. unique class/id etc.
                'media_sizes' => array(
                    'font-size' => $title_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
                   	'line-height' => $title_font_line_height
                ),
            );
            $info_list_data_list = get_ultimate_vc_responsive_media_css($info_list_args);

			if($title_font_color != '')
				$title_style .= 'color:'.$title_font_color.';';

			/* description */
			if($desc_font != '')
			{
				$font_family = get_ultimate_font_family($desc_font);
				$desc_style .= 'font-family:\''.$font_family.'\';';
				//array_push($font_args, $desc_font);
			}
			if($desc_font_style != '')
				$desc_style .= get_ultimate_font_style($desc_font_style);
			// if($desc_font_size != '')
			// 	$desc_style .= 'font-size:'.$desc_font_size.'px;';
			// if($desc_font_line_height != '')
			// 	$desc_style .= 'line-height:'.$desc_font_line_height.'px;';

			if(is_numeric($desc_font_size)){
				$desc_font_size = 'desktop:'.$desc_font_size.'px;';
			}
			if(is_numeric($desc_font_line_height)){
				$desc_font_line_height = 'desktop:'.$desc_font_line_height.'px;';
			}
			$info_list_desc_args = array(
                'target' => '#'.$info_list_id.' .icon_description_text', // set targeted element e.g. unique class/id etc.
                'media_sizes' => array(
                    'font-size' => $desc_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
                   	'line-height' => $desc_font_line_height
                ),
            );
            $info_list_desc_data_list = get_ultimate_vc_responsive_media_css($info_list_desc_args);


			if($desc_font_color != '')
				$desc_style .= 'color:'.$desc_font_color.';';
			//enquque_ultimate_google_fonts($font_args);

			if($animation !== 'none')
			{
				$css_trans = 'data-animation="'.$animation.'" data-animation-delay="03"';
			}
			if($this->connector_animate)
			{
				$connector_trans = 'data-animation="'.$this->connector_animate.'" data-animation-delay="03"';
			}
			if($icon_color !=''){
				$ico_col = 'style="color:'.$icon_color.'";';
			}
			if($icon_bg_color != ''){
				$style .= 'background:'.$icon_bg_color.';  color:'.$icon_bg_color.';';
			}
			if($icon_bg_color != ''){
				$style .= 'border-color:'.$this->border_col.';';
			}

			if($icon_type == "custom"){
				$img = apply_filters('ult_get_img_single', $icon_img, 'url', 'large');
				$alt = apply_filters('ult_get_img_single', $icon_img, 'alt');
				if($alt == '')
					$alt = 'icon';
				//if(!empty($img)){

				$icon_html .= '<div class="icon_list_icon" '.$css_trans.' style="'.$this->icon_style.'">';
				$icon_html .= '<img class="list-img-icon" alt="'.$alt.'" src="'.apply_filters('ultimate_images', $img).'"/>';
				if($is_link && $info_list_link_apply == 'icon')
					$icon_html .= $info_list_link_html;
				$icon_html .= '</div>';
			 // }
			}
			else {
				$icon_html .= '<div class="icon_list_icon" '.$css_trans.' style="'.$this->icon_style.'">';
				$icon_html .= '<i class="'.$list_icon.'" '.$ico_col.'></i>';
				if($is_link && $info_list_link_apply == 'icon')
					$icon_html .= $info_list_link_html;
				$icon_html .= '</div>';
			}
			$output = '<li class="icon_list_item" style=" '.$this->icon_font.'">';
			$output .= $icon_html;
			$output .= '<div class="icon_description" id="'.$info_list_id.'" style="font-size:'.$this->icon_size.'px;">';
			if($list_title != '')
			{
				$output .= '<h3 class="ult-responsive" '.$info_list_data_list.' style="'.$title_style.'">';
				if($is_link && $info_list_link_apply == 'title')
					$output .= '<a href="'.$url.'" target="'.$target.'">'.$list_title.'</a>';
				else
					$output .= $list_title;
				$output .= '</h3>';
			}
			$output .= '<div class="icon_description_text ult-responsive" '.$info_list_desc_data_list.' style="'.$desc_style.'">'.wpb_js_remove_wpautop($content, true).'</div>';
			$output .= '</div>';
			$output .= '<div class="icon_list_connector" '.$connector_trans.' style="border-color:'.$this->connect_color.';"></div>';
			if($is_link && $info_list_link_apply == 'container')
				$output .= $info_list_link_html;
			$output .= '</li>';
			return $output;
		}
	// Shortcode Functions for frontend editor
		function front_info_list($atts, $content = null)
		{
			// Do nothing
			$position = $style = $icon_color = $icon_bg_color = $connector_animation = $font_size_icon = $icon_border_style = $icon_border_size = $connector_color = $border_color = $el_class = '';
			extract(shortcode_atts(array(
				'position' => 'left',
				'style' => 'square with_bg',
				'connector_animation' => '',
				'icon_color' =>'#333333',
				'icon_bg_color' =>'#ffffff',
				'connector_color' => '#333333',
				'border_color' => '#333333',
				'font_size_icon' => '24',
				'icon_border_style' => 'none',
				'icon_border_size' => '1',
				'el_class' => '',
			), $atts));
			$this->connect_color = $connector_color;
			$this->border_col = $border_color;
			if($style == 'square with_bg' || $style == 'circle with_bg' || $style == 'hexagon'){
				$this->icon_font = 'font-size:'.($font_size_icon*3).'px;';
				if($icon_border_size !== ''){
					$this->icon_style = 'font-size:'.$font_size_icon.'px;';
					$this->icon_style .= 'border-width:0px;';
					$this->icon_style .= 'border-style:none;';
					$this->icon_style .= 'background:'.$icon_bg_color.';';
					$this->icon_style .= 'color:'.$icon_color.';';
					if($style =="hexagon")
						$this->icon_style .= 'border-color:'.$icon_bg_color.';';
					else
						$this->icon_style .= 'border-color:'.$border_color.';';
				}
			} else {
				$big_size = ($font_size_icon*3)+($icon_border_size*2);
				if($icon_border_size !== ''){
					$this->icon_font = 'font-size:'.$big_size.'px;';
					$this->icon_style = 'font-size:'.$font_size_icon.'px;';
					$this->icon_style .= 'border-width:'.$icon_border_size.'px;';
					$this->icon_style .= 'border-style:'.$icon_border_style.';';
					$this->icon_style .= 'color:'.$icon_color.';';
					$this->icon_style .= 'border-color:'.$border_color.';';
				}
			}
			if($position == "top")
				$this->connector_animate = "fadeInLeft";
			else
				$this->connector_animate = $connector_animation;
			$output = '<div class="smile_icon_list_wrap '.$el_class.''.$css_info_list.'">';
			$output .= '<ul class="smile_icon_list '.$position.' '.$style.'" data-style="'.$this->icon_style.'" data-fonts="'.$this->icon_font.'" data-connector="'.$connector_color.'">';
			$output .= do_shortcode($content);
			$output .= '</ul>';
			$output .= '</div>';
			return $output;
		}
		function front_info_list_item($atts,$content = null)
		{
			// Do nothing
			$list_title = $list_icon = $animation = $icon_color = $icon_bg_color = $icon_img = $icon_type = '';
			extract(shortcode_atts(array(
				'list_title' => '',
				'animation' => '',
				'list_icon' => '',
				'icon_img' => '',
				'icon_type' => '',
			), $atts));
			//$content =  wpb_js_remove_wpautop($content);
			$css_trans = $style = $ico_col = $connector_trans = $icon_html = '';
			if($animation !== 'none')
			{
				$css_trans = 'data-animation="'.$animation.'" data-animation-delay="03"';
			}
			if($this->connector_animate)
			{
				$connector_trans = 'data-animation="'.$this->connector_animate.'" data-animation-delay="02"';
			}
			if($icon_color !=''){
				$ico_col = 'style="color:'.$icon_color.'";';
			}
			if($icon_bg_color != ''){
				$style .= 'background:'.$icon_bg_color.';  color:'.$icon_bg_color.';';
			}
			if($icon_bg_color != ''){
				$style .= 'border-color:'.$this->border_col.';';
			}
			if($icon_type == "selector"){
				$icon_html .= '<div class="icon_list_icon" '.$css_trans.'>';
				$icon_html .= '<i class="'.$list_icon.'" '.$ico_col.'></i>';
				$icon_html .= '</div>';
			} else {

				$img = apply_filters('ult_get_img_single', $icon_img, 'url', 'large');
				//if(!empty($img)){
				$icon_html .= '<div class="icon_list_icon" '.$css_trans.'>';
				$icon_html .= '<img class="list-img-icon " alt="icon" src="'.apply_filters('ultimate_images', $img).'"/>';
				$img = apply_filters('ult_get_img_single', $icon_img, 'url');
				$icon_html .= '<div class="icon_list_icon" '.$css_trans.'>';
				$icon_html .= '<img class="list-img-icon" alt="icon" src="'.apply_filters('ultimate_images', $img).'"/>';
				$icon_html .= '</div>';
			   //}
			}

			$output = '<li class="icon_list_item">';
			$output .= $icon_html;
			$output .= '<div class="icon_description">';
			$output .= '<h3>'.$list_title.'</h3>';
			$output .= wpb_js_remove_wpautop($content, true);
			$output .= '</div>';
			$output .= '<div class="icon_list_connector" '.$connector_trans.' style="border-color:'.$this->connect_color.';"></div>';
			$output .= '</li>';
			return $output;
		}
		function add_info_list()
		{
			if(function_exists('vc_map'))
			{
				vc_map(
				array(
				   "name" => __("Info List","ultimate_vc"),
				   "base" => "info_list",
				   "class" => "vc_info_list",
				   "icon" => "vc_icon_list",
				   "category" => "Ultimate VC Addons",
				   "as_parent" => array('only' => 'info_list_item'),
				   "description" => __("Text blocks connected together in one list.","ultimate_vc"),
				   "content_element" => true,
				   "show_settings_on_create" => true,
				   //"is_container"    => true,
				   "params" => array(
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Icon or Image Position","ultimate_vc"),
							"param_name" => "position",
							"value" => array(
								__('Icon to the Left','ultimate_vc') => 'left',
								__('Icon to the Right','ultimate_vc') => 'right',
								__('Icon at Top','ultimate_vc') => 'top',
								),
							"description" => __("Select the icon position for icon list.","ultimate_vc")
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Style of Image or Icon + Color","ultimate_vc"),
							"param_name" => "style",
							"value" => array(
								__('Square With Background','ultimate_vc') => 'square with_bg',
								__('Circle With Background','ultimate_vc') => 'circle with_bg',
								__('Hexagon With Background','ultimate_vc') => 'hexagon',
								),
							"description" => __("Select the icon style for icon list.","ultimate_vc")
						),
						array(
							"type" => "colorpicker",
							"class" => "",
							"heading" => __("Icon Background Color:", "ultimate_vc"),
							"param_name" => "icon_bg_color",
							"value" => "#ffffff",
							"description" => __("Select the color for icon background.", "ultimate_vc"),
							"dependency" => Array("element" => "style", "value" => array("square with_bg","circle with_bg","hexagon")),
						),
						array(
							"type" => "colorpicker",
							"class" => "",
							"heading" => __("Icon Color:", "ultimate_vc"),
							"param_name" => "icon_color",
							"value" => "#333333",
							"description" => __("Select the color for icon.", "ultimate_vc"),
						),
						array(
							"type" => "number",
							"class" => "",
							"heading" => __("Icon Font Size", "ultimate_vc"),
							"param_name" => "font_size_icon",
							"value" => 24,
							"min" => 12,
							"max" => 72,
							"suffix" => "px",
							"description" => __("Enter value in pixels.", "ultimate_vc")
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Border Style", "ultimate_vc"),
							"param_name" => "icon_border_style",
							"value" => array(
								__("None","ultimate_vc") => "none",
								__("Solid","ultimate_vc")	=> "solid",
								__("Dashed","ultimate_vc") => "dashed",
								__("Dotted","ultimate_vc") => "dotted",
								__("Double","ultimate_vc") => "double",
								__("Inset","ultimate_vc") => "inset",
								__("Outset","ultimate_vc") => "outset",
							),
							"description" => __("Select the border style for icon.","ultimate_vc"),
							"dependency" => Array("element" => "style", "value" => array("square with_bg","circle with_bg")),
						),
						array(
							"type" => "number",
							"class" => "",
							"heading" => __("Border Width", "ultimate_vc"),
							"param_name" => "icon_border_size",
							"value" => 1,
							"min" => 0,
							"max" => 10,
							"suffix" => "px",
							"description" => __("Thickness of the border.", "ultimate_vc"),
							"dependency" => Array("element" => "icon_border_style", "value" => array("solid","dashed","dotted","double","inset","outset")),
						),
						array(
							"type" => "colorpicker",
							"class" => "",
							"heading" => __("Border Color:", "ultimate_vc"),
							"param_name" => "border_color",
							"value" => "#333333",
							"description" => __("Select the color border.", "ultimate_vc"),
							"dependency" => Array("element" => "icon_border_style", "value" => array("solid","dashed","dotted","double","inset","outset")),
						),
						array(
							"type" => "colorpicker",
							"class" => "",
							"heading" => __("Connector Line Color:", "ultimate_vc"),
							"param_name" => "connector_color",
							"value" => "#333333",
							"description" => __("Select the color for connector line.", "ultimate_vc"),
							"group" => "Connector"
						),
						array(
							"type" => "checkbox",
							"class" => "",
							"heading" => __("Connector Line Animation: ","ultimate_vc"),
							"param_name" => "connector_animation",
							"value" => array (
								__('Enabled','ultimate_vc') => 'fadeInUp',
							),
							"description" => __("Select wheather to animate connector or not","ultimate_vc"),
							"group" => "Connector"
						),

						// Customize everything
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Extra Class", "ultimate_vc"),
							"param_name" => "el_class",
							"value" => "",
							"description" => __("Add extra class name that will be applied to the info list, and you can use this class for your customizations.", "ultimate_vc"),
						),
						array(
							"type" => "ult_param_heading",
							"text" => "<span style='display: block;'><a href='http://bsf.io/v9k0x' target='_blank'>".__("Watch Video Tutorial","ultimate_vc")." &nbsp; <span class='dashicons dashicons-video-alt3' style='font-size:30px;vertical-align: middle;color: #e52d27;'></span></a></span>",
							"param_name" => "notification",
							'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
						),
						array(
								'type' => 'css_editor',
					            'heading' => __( 'Css', 'ultimate_vc' ),
					            'param_name' => 'css_info_list',
					            'group' => __( 'Design ', 'ultimate_vc' ),
					            'edit_field_class' => 'vc_col-sm-12 vc_column no-vc-background no-vc-border creative_link_css_editor',
					    ),
					),
					"js_view" => 'VcColumnView'
				));
				// Add list item
				vc_map(
					array(
					   "name" => __("Info List Item","ultimate_vc"),
					   "base" => "info_list_item",
					   "class" => "vc_info_list",
					   "icon" => "vc_icon_list",
					   "category" => "Ultimate VC Addons",
					   "content_element" => true,
					   "as_child" => array('only' => 'info_list'),
					   "is_container"    => false,
					   "params" => array(
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Title","ultimate_vc"),
							"admin_label" => true,
							"param_name" => "list_title",
							"value" => "",
							"description" => __("Provide a title for this icon list item.","ultimate_vc")
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Icon to display:", "ultimate_vc"),
							"param_name" => "icon_type",
							"value" => array(
								__("Font Icon Manager","ultimate_vc") => "selector",
								__("Custom Image Icon","ultimate_vc") => "custom",
							),
							"description" => __("Use existing font icon or upload a custom image.", "ultimate_vc")
						),
						array(
							"type" => "icon_manager",
							"class" => "",
							"heading" => __("Select List Icon ","ultimate_vc"),
							"param_name" => "list_icon",
							"value" => "",
							"description" => __("Click and select icon of your choice. If you can't find the one that suits for your purpose","ultimate_vc").", ".__("you can","ultimate_vc")." <a href='admin.php?page=bsf-font-icon-manager' target='_blank'>".__("add new here","ultimate_vc")."</a>.",
							"dependency" => Array("element" => "icon_type","value" => array("selector")),
						),
						array(
							"type" => "ult_img_single",
							"class" => "",
							"heading" => __("Upload Image Icon:", "ultimate_vc"),
							"param_name" => "icon_img",
							"value" => "",
							"description" => __("Upload the custom image icon.", "ultimate_vc"),
							"dependency" => Array("element" => "icon_type","value" => array("custom")),
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Icon Animation","ultimate_vc"),
							"param_name" => "animation",
							"value" => array(
								__("No Animation","ultimate_vc") => "",
								__("Swing","ultimate_vc") => "swing",
								__("Pulse","ultimate_vc") => "pulse",
								__("Fade In","ultimate_vc") => "fadeIn",
								__("Fade In Up","ultimate_vc") => "fadeInUp",
								__("Fade In Down","ultimate_vc") => "fadeInDown",
								__("Fade In Left","ultimate_vc") => "fadeInLeft",
								__("Fade In Right","ultimate_vc") => "fadeInRight",
								__("Fade In Up Long","ultimate_vc") => "fadeInUpBig",
								__("Fade In Down Long","ultimate_vc") => "fadeInDownBig",
								__("Fade In Left Long","ultimate_vc") => "fadeInLeftBig",
								__("Fade In Right Long","ultimate_vc") => "fadeInRightBig",
								__("Slide In Down","ultimate_vc") => "slideInDown",
								__("Slide In Left","ultimate_vc") => "slideInLeft",
								__("Slide In Left","ultimate_vc") => "slideInLeft",
								__("Bounce In","ultimate_vc") => "bounceIn",
								__("Bounce In Up","ultimate_vc") => "bounceInUp",
								__("Bounce In Down","ultimate_vc") => "bounceInDown",
								__("Bounce In Left","ultimate_vc") => "bounceInLeft",
								__("Bounce In Right","ultimate_vc") => "bounceInRight",
								__("Rotate In","ultimate_vc") => "rotateIn",
								__("Light Speed In","ultimate_vc") => "lightSpeedIn",
								__("Roll In","ultimate_vc") => "rollIn",
							),
							"description" => __("Select the animation style for icon.","ultimate_vc")
						),
						array(
							"type" => "textarea_html",
							"class" => "",
							"heading" => __("Description","ultimate_vc"),
							"param_name" => "content",
							"value" => "",
							"description" => __("Description about this list item","ultimate_vc")
						),
						array(
							"type" => "dropdown",
							"heading" => __("Apply link To","ultimate_vc"),
							"param_name" => "info_list_link_apply",
							"value" => array(
								__("No Link","ultimate_vc") => "no-link",
								__("Complete Container","ultimate_vc") => "container",
								__("List Title","ultimate_vc") => "title",
								__("Icon","ultimate_vc") => "icon"
							)
						),
						array(
							"type" => "vc_link",
							"heading" => __("Link","ultimate_vc"),
							"param_name" => "info_list_link",
							"dependency" => array("element" => "info_list_link_apply", "value" => array("container","title","icon"))
						),
						array(
								"type" => "ult_param_heading",
								"param_name" => "title_text_typography",
								"text" => __("Title Settings","ultimate_vc"),
								"value" => "",
								"group" => "Typography",
								"class" => "ult-param-heading",
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
							// array(
							// 	"type" => "number",
							// 	"param_name" => "title_font_size",
							// 	"heading" => __("Font size","ultimate_vc"),
							// 	"value" => "16",
							// 	"suffix" => "px",
							// 	"min" => 10,
							// 	"group" => "Typography"
							// ),
							// array(
							// 	"type" => "number",
							// 	"param_name" => "title_font_line_height",
							// 	"heading" => __("Font Line Height","ultimate_vc"),
							// 	"value" => "24",
							// 	"suffix" => "px",
							// 	"min" => 10,
							// 	"group" => "Typography"
							// ),
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
			                    "heading" => __("Font Line Height", 'ultimate_vc'),
			                    "param_name" => "title_font_line_height",
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
								"type" => "colorpicker",
								"param_name" => "title_font_color",
								"heading" => __("Color","ultimate_vc"),
								"group" => "Typography"
							),
							array(
								"type" => "ult_param_heading",
								"param_name" => "desc_text_typography",
								"text" => __("Description Settings","ultimate_vc"),
								"value" => "",
								"group" => "Typography",
								"class" => "ult-param-heading",
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
							// array(
							// 	"type" => "number",
							// 	"param_name" => "desc_font_size",
							// 	"heading" => __("Font size","ultimate_vc"),
							// 	"value" => "13",
							// 	"suffix" => "px",
							// 	"min" => 10,
							// 	"group" => "Typography"
							// ),
							// array(
							// 	"type" => "number",
							// 	"param_name" => "desc_font_line_height",
							// 	"heading" => __("Font Line Height","ultimate_vc"),
							// 	"value" => "18",
							// 	"suffix" => "px",
							// 	"min" => 10,
							// 	"group" => "Typography"
							// ),
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
			                    "heading" => __("Font Line Height", 'ultimate_vc'),
			                    "param_name" => "desc_font_line_height",
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
								"type" => "colorpicker",
								"param_name" => "desc_font_color",
								"heading" => __("Color","ultimate_vc"),
								"group" => "Typography"
							),
					   )
					)
				);
			}//endif
		}
	}
}
global $AIO_Info_list; // WPB: Beter to create singleton in AIO_Info_list I think, but it also work
if(class_exists('WPBakeryShortCodesContainer'))
{
	class WPBakeryShortCode_info_list extends WPBakeryShortCodesContainer {
        function content( $atts, $content = null ) {
            global $AIO_Info_list;
            return $AIO_Info_list->front_info_list($atts, $content);
        }
	}
	class WPBakeryShortCode_info_list_item extends WPBakeryShortCode {
        function content($atts, $content = null ) {
            global $AIO_Info_list;
            return $AIO_Info_list->front_info_list_item($atts, $content);
        }
	}
}
if(class_exists('AIO_Info_list'))
{
	$AIO_Info_list = new AIO_Info_list;
}