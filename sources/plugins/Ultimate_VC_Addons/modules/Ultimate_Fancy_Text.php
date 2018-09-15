<?php
/*
* Add-on Name: Ultimate Fancy Text
* Add-on URI: http://dev.brainstormforce.com
*/
if(!class_exists('Ultimate_FancyText')){
	class Ultimate_FancyText{

		function __construct(){
			add_action('init',array($this,'ultimate_fancytext_init'));
			add_shortcode('ultimate_fancytext',array($this,'ultimate_fancytext_shortcode'));
			add_action('wp_enqueue_scripts', array($this, 'register_fancytext_assets'),1);
		}
		function register_fancytext_assets()
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
			wp_register_style('ultimate-fancytext-style',plugins_url($css_path.'fancytext'.$ext.'.css',__FILE__),array(),ULTIMATE_VERSION);
			wp_register_script('ultimate-typed-js',plugins_url($js_path.'typed'.$ext.'.js',__FILE__),array('jquery'),ULTIMATE_VERSION);
			wp_register_script('ultimate-vticker-js',plugins_url($js_path.'vticker'.$ext.'.js',__FILE__),array('jquery'),ULTIMATE_VERSION);
		}

		function ultimate_fancytext_init(){
			if(function_exists("vc_map")){
				vc_map(
					array(
					   "name" => __("Fancy Text","ultimate_vc"),
					   "base" => "ultimate_fancytext",
					   "class" => "vc_ultimate_fancytext",
					   "icon" => "vc_ultimate_fancytext",
					   "category" => "Ultimate VC Addons",
					   "description" => __("Fancy lines with animation effects.","ultimate_vc"),
					   "params" => array(
					   		array(
								"type" => "textfield",
								"param_name" => "fancytext_prefix",
								"heading" => __("Prefix","ultimate_vc"),
								"value" => "",
							),
							array(
								'type' => 'textarea',
								'heading' => __( 'Fancy Text', 'ultimate_vc' ),
								'param_name' => 'fancytext_strings',
								'description' => __('Enter each string on a new line','ultimate_vc'),
								'admin_label' => true
							),
							array(
								"type" => "textfield",
								"param_name" => "fancytext_suffix",
								"heading" => __("Suffix","ultimate_vc"),
								"value" => "",
							),
							array(
								"type" => "dropdown",
								"heading" => __("Effect", "ultimate_vc"),
								"param_name" => 'fancytext_effect',
								"value" => array(
									__("Type", "ultimate_vc") => "typewriter",
									__("Slide Up", "ultimate_vc") => "ticker",
									//__("Slide Down", "ultimate_vc") => "ticker-down"
								),
							),
							array(
								"type" => "dropdown",
								"heading" => __("Alignment", "ultimate_vc"),
								"param_name" => "fancytext_align",
								"value" => array(
									__("Center","ultimate_vc") => "center",
									__("Left","ultimate_vc") => "left",
									__("Right","ultimate_vc") => "right"
								)
							),
							array(
								"type" => "number",
								"heading" => __("Type Speed", "ultimate_vc"),
								"param_name" => "strings_textspeed",
								"min" => 0,
								"value" => 35,
								"suffix" => __("In Miliseconds","ultimate_vc"),
								"group" => "Advanced Settings",
								"dependency" => array("element" => "fancytext_effect", "value" => array("typewriter")),
								"description" => __("Speed at which line progresses / Speed of typing effect.", "ultimate_vc")
							),
							array(
								"type" => "number",
								"heading" => __("Backspeed", "ultimate_vc"),
								"param_name" => "strings_backspeed",
								"min" => 0,
								"value" => 0,
								"suffix" => __("In Miliseconds","ultimate_vc"),
								"group" => "Advanced Settings",
								"dependency" => array("element" => "fancytext_effect", "value" => array("typewriter")),
								"description" => __("Speed of delete / backspace effect.", "ultimate_vc")
							),

							array(
								"type" => "number",
								"heading" => __("Start Delay", "ultimate_vc"),
								"param_name" => "strings_startdelay",
								"min" => 0,
								"value" => '200',
								"suffix" => __("In Miliseconds","ultimate_vc"),
								"group" => "Advanced Settings",
								"dependency" => array("element" => "fancytext_effect", "value" => array("typewriter")),
								"description" => __("Example - If set to 5000, the first string will appear after 5 seconds.", "ultimate_vc")
							),

							array(
								"type" => "number",
								"heading" => __("Back Delay", "ultimate_vc"),
								"param_name" => "strings_backdelay",
								"min" => 0,
								"value" => '1500',
								"suffix" => __("In Miliseconds","ultimate_vc"),
								"group" => "Advanced Settings",
								"dependency" => array("element" => "fancytext_effect", "value" => array("typewriter")),
								"description" => __("Example - If set to 5000, the string will remain visible for 5 seconds before backspace effect.","ultimate_vc")
							),
							array(
								"type" => "ult_switch",
								"heading" => __("Enable Loop","ultimate_vc"),
								"param_name" => "typewriter_loop",
								"value" => "true",
								"default_set" => true,
								"options" => array(
									"true" => array(
										"label" => "",
										"on" => "Yes",
										"off" => "No"
									)
								),
								"group" => "Advanced Settings",
								"dependency" => array("element" => "fancytext_effect", "value" => array("typewriter"))
							),
							array(
								"type" => "ult_switch",
								"heading" => __("Show Cursor","ultimate_vc"),
								"param_name" => "typewriter_cursor",
								"value" => "true",
								"default_set" => true,
								"options" => array(
									"true" => array(
										"label" => "",
										"on" => "Yes",
										"off" => "No",
									)
								),
								"group" => "Advanced Settings",
								"dependency" => array("element" => "fancytext_effect", "value" => array("typewriter"))
							),
							array(
								"type" => "textfield",
								"heading" => __("Cursor Text","ultimate_vc"),
								"param_name" => "typewriter_cursor_text",
								"value" => "|",
								"group" => "Advanced Settings",
								"dependency" => array("element" => "typewriter_cursor", "value" => array("true"))
							),
							array(
								"type" => "number",
								"heading" => __("Animation Speed", "ultimate_vc"),
								"param_name" => "strings_tickerspeed",
								"min" => 0,
								"value" => 200,
								"suffix" => __("In Miliseconds","ultimate_vc"),
								"group" => "Advanced Settings",
								"dependency" => array("element" => "fancytext_effect", "value" => array("ticker","ticker-down")),
								"description" => __("Duration of 'Slide Up' animation", "ultimate_vc")
							),
							array(
								"type" => "number",
								"heading" => __("Pause Time", "ultimate_vc"),
								"param_name" => "ticker_wait_time",
								"min" => 0,
								"value" => "3000",
								"suffix" => __("In Miliseconds","ultimate_vc"),
								"group" => "Advanced Settings",
								"dependency" => array("element" => "fancytext_effect", "value" => array("ticker","ticker-down")),
								"description" => __("How long the string should stay visible?","ultimate_vc")
							),
							array(
								"type" => "number",
								"heading" => __("Show Items", "ultimate_vc"),
								"param_name" => "ticker_show_items",
								"min" => 1,
								"value" => 1,
								"group" => "Advanced Settings",
								"dependency" => array("element" => "fancytext_effect", "value" => array("ticker","ticker-down")),
								"description" => __("How many items should be visible at a time?", "ultimate_vc")
							),
							array(
								"type" => "ult_switch",
								"heading" => __("Pause on Hover","ultimate_vc"),
								"param_name" => "ticker_hover_pause",
								"value" => "",
								"options" => array(
									"true" => array(
										"label" => "",
										"on" => "Yes",
										"off" => "No",
									)
								),
								"group" => "Advanced Settings",
								"dependency" => array("element" => "fancytext_effect", "value" => array("ticker","ticker-down"))
							),
							array(
								"type" => "textfield",
								"heading" => __("Extra Class","ultimate_vc"),
								"param_name" => "ex_class"
							),
							array(
								"type" => "ult_param_heading",
								"param_name" => "fancy_text_typography",
								"text" => __("Fancy Text Settings","ultimate_vc"),
								"value" => "",
								"group" => "Typography",
								"class" => "ult-param-heading",
								'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
							),
							array(
								"type" => "ultimate_google_fonts",
								"heading" => __("Font Family", "ultimate_vc"),
								"param_name" => "strings_font_family",
								"description" => __("Select the font of your choice.","ultimate_vc")." ".__("You can","ultimate_vc")." <a target='_blank' href='".admin_url('admin.php?page=bsf-google-font-manager')."'>".__("add new in the collection here","ultimate_vc")."</a>.",
								"group" => "Typography"
							),
							array(
								"type" => "ultimate_google_fonts_style",
								"heading" 		=>	__("Font Style", "ultimate_vc"),
								"param_name"	=>	"strings_font_style",
								"group" => "Typography"
							),
							// array(
							// 	"type" => "number",
							// 	"class" => "font-size",
							// 	"heading" => __("Font Size", "ultimate_vc"),
							// 	"param_name" => "strings_font_size",
							// 	"min" => 10,
							// 	"suffix" => "px",
							// 	"group" => "Typography"
							// ),
							array(
                                "type" => "ultimate_responsive",
                                "class" => "",
                                "heading" => __("Font Size", 'ultimate_vc'),
                                "param_name" => "strings_font_size",
                                "unit" => "px",
                                "media" => array(
                                    /*"Large Screen"      => '',*/
                                    "Desktop" => '',
                                    "Tablet" => '',
                                    "Tablet Portrait" => '',
                                    "Mobile Landscape" => '',
                                    "Mobile" => '',
                                ),
                                "group" => "Typography"
                            ),
							// array(
							// 	"type" => "number",
							// 	"class" => "",
							// 	"heading" => __("Line Height", "ultimate_vc"),
							// 	"param_name" => "strings_line_height",
							// 	"value" => "",
							// 	"suffix" => "px",
							// 	"group" => "Typography"
							// ),
							array(
                                "type" => "ultimate_responsive",
                                "class" => "",
                                "heading" => __("Line Height", 'ultimate_vc'),
                                "param_name" => "strings_line_height",
                                "unit" => "px",
                                "media" => array(
                                    /*"Large Screen"      => '',*/
                                    "Desktop" => '',
                                    "Tablet" => '',
                                    "Tablet Portrait" => '',
                                    "Mobile Landscape" => '',
                                    "Mobile" => '',
                                ),
                                "group" => "Typography"
                            ),
							array(
								"type" => "colorpicker",
								"heading" => __("Fancy Text Color","ultimate_vc"),
								"param_name" => "fancytext_color",
								"group" => "Advanced Settings",
								"group" => "Typography",
								"dependency" => array("element" => "fancytext_effect", "value" => array("typewriter","ticker","ticker-down"))
							),
							array(
								"type" => "colorpicker",
								"heading" => __("Fancy Text Background","ultimate_vc"),
								"param_name" => "ticker_background",
								"group" => "Advanced Settings",
								"group" => "Typography",
								"dependency" => array("element" => "fancytext_effect", "value" => array("typewriter","ticker","ticker-down"))
							),
							array(
								"type" => "ult_param_heading",
								"param_name" => "fancy_prefsuf_text_typography",
								"text" => __("Prefix Suffix Text Settings","ultimate_vc"),
								"value" => "",
								"group" => "Typography",
								"class" => "ult-param-heading",
								'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
							),
							array(
								"type" => "ultimate_google_fonts",
								"heading" => __("Font Family", "ultimate_vc"),
								"param_name" => "prefsuf_font_family",
								"description" => __("Select the font of your choice.","ultimate_vc")." ".__("You can","ultimate_vc")." <a target='_blank' href='".admin_url('admin.php?page=bsf-google-font-manager')."'>".__("add new in the collection here","ultimate_vc")."</a>.",
								"group" => "Typography"
							),
							array(
								"type" => "ultimate_google_fonts_style",
								"heading" 		=>	__("Font Style", "ultimate_vc"),
								"param_name"	=>	"prefsuf_font_style",
								"group" => "Typography"
							),
							array(
                                "type" => "ultimate_responsive",
                                "class" => "",
                                "heading" => __("Font Size", 'ultimate_vc'),
                                "param_name" => "prefix_suffix_font_size",
                                "unit" => "px",
                                "media" => array(
                                    /*"Large Screen"      => '',*/
                                    "Desktop" => '',
                                    "Tablet" => '',
                                    "Tablet Portrait" => '',
                                    "Mobile Landscape" => '',
                                    "Mobile" => '',
                                ),
                                "group" => "Typography"
                            ),
							array(
                                "type" => "ultimate_responsive",
                                "class" => "",
                                "heading" => __("Line Height", 'ultimate_vc'),
                                "param_name" => "prefix_suffix_line_height",
                                "unit" => "px",
                                "media" => array(
                                    /*"Large Screen"      => '',*/
                                    "Desktop" => '',
                                    "Tablet" => '',
                                    "Tablet Portrait" => '',
                                    "Mobile Landscape" => '',
                                    "Mobile" => '',
                                ),
                                "group" => "Typography"
                            ),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Prefix & Suffix Text Color", "ultimate_vc"),
								"param_name" => "sufpref_color",
								"value" => "",
								"group" => "Typography"
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Prefix & Suffix Background Color", "ultimate_vc"),
								"param_name" => "sufpref_bg_color",
								"value" => "",
								"group" => "Typography"
							),
							array(
								"type" => "colorpicker",
								"heading" => __("Cursor Color","ultimate_vc"),
								"param_name" => "typewriter_cursor_color",
								"group" => "Advanced Settings",
								"group" => "Typography",
								"dependency" => array("element" => "fancytext_effect", "value" => array("typewriter"))
							),
							array(
								"type" => "dropdown",
								"heading" => __("Markup","ultimate_vc"),
								"param_name" => "fancytext_tag",
								"value" => array(
									__("div","ultimate_vc") => "div",
									__("H1","ultimate_vc") => "h1",
									__("H2","ultimate_vc") => "h2",
									__("H3","ultimate_vc") => "h3",
									__("H4","ultimate_vc") => "h4",
									__("H5","ultimate_vc") => "h5",
									__("H6","ultimate_vc") => "h6",
								),
								"group" => "Typography",
							),
							array(
								"type" => "ult_param_heading",
								"text" => "<span style='display: block;'><a href='http://bsf.io/t5ir4' target='_blank'>".__("Watch Video Tutorial","ultimate_vc")." &nbsp; <span class='dashicons dashicons-video-alt3' style='font-size:30px;vertical-align: middle;color: #e52d27;'></span></a></span>",
								"param_name" => "notification",
								'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
							),
							array(
					            'type' => 'css_editor',
					            'heading' => __( 'Css', 'ultimate_vc' ),
					            'param_name' => 'css_fancy_design',
					            'group' => __( 'Design ', 'ultimate_vc' ),
					            'edit_field_class' => 'vc_col-sm-12 vc_column no-vc-background no-vc-border creative_link_css_editor',
					        ),
						)
					)
				);
			}
		}
		function ultimate_fancytext_shortcode($atts, $content = null){
			$output = $fancytext_strings = $fancytext_prefix = $fancytext_suffix = $fancytext_effect = $strings_textspeed = $strings_tickerspeed = $typewriter_cursor = $typewriter_cursor_text = $typewriter_loop = $fancytext_align = $strings_font_family = $strings_font_style = $strings_font_size = $sufpref_color = $strings_line_height = $strings_startdelay = $strings_backspeed = $strings_backdelay = $ticker_wait_time = $ticker_show_items = $ticker_hover_pause = $ex_class = '';
			$prefsuf_font_family = $prefsuf_font_style = $prefix_suffix_font_size = $prefix_suffix_line_height = $sufpref_bg_color ='';
			$id = uniqid(rand());

			extract(shortcode_atts(array(
				'fancytext_strings' => '',
				'fancytext_prefix' => '',
				'fancytext_suffix' => '',
				'fancytext_effect' => 'typewriter',
				'strings_textspeed' => '35',
				'strings_tickerspeed' => '200',
				'typewriter_loop' => 'true',
				'typewriter_cursor_color' => '',
				'fancytext_tag' => 'div',
				'fancytext_align' => 'center',
				'strings_font_family' => '',
				'strings_font_style' => '',
				'strings_font_size' => '',
				'sufpref_color' => '',
				'strings_line_height' => '',
				'strings_startdelay' => '200',
				'strings_backspeed' => '0',
				'strings_backdelay' => '1500',
				'typewriter_cursor' => 'true',
				'typewriter_cursor_text' => '|',
				'ticker_wait_time' => '3000',
				'ticker_show_items' => '1',
				'ticker_hover_pause' => '',
				'ticker_background' => '',
				'fancytext_color' => '',
				'prefsuf_font_family' => '',
				'prefsuf_font_style' => '',
				'prefix_suffix_font_size' =>'',
				'prefix_suffix_line_height' =>'',
				'sufpref_bg_color' => '',
				'ex_class' => '',
				'css_fancy_design' =>'',
			),$atts));

			$vc_version = (defined('WPB_VC_VERSION')) ? WPB_VC_VERSION : 0;
			$is_vc_49_plus = (version_compare(4.9, $vc_version, '<=')) ? 'ult-adjust-bottom-margin' : '';

			$string_inline_style = $vticker_inline = $valign = $prefsuf_style = $css_design_style = '';

			$css_design_style = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css_fancy_design, ' ' ), "ultimate_fancytext", $atts );

			$css_design_style = esc_attr( $css_design_style );

			if($strings_font_family != '')
			{
				$font_family = get_ultimate_font_family($strings_font_family);
				if($font_family !== '')
					$string_inline_style .= 'font-family:\''.$font_family.'\';';
			}

			$string_inline_style .= get_ultimate_font_style($strings_font_style);

			if($prefsuf_font_family != ''){
				$font_family = get_ultimate_font_family($prefsuf_font_family);
				if($font_family !== '')
					$prefsuf_style .= 'font-family:\''.$font_family.'\';';
			}
			$prefsuf_style .= get_ultimate_font_style($prefsuf_font_style);
			// if($strings_font_size != '')
			// 	$string_inline_style .= 'font-size:'.$strings_font_size.'px;';
			// if($strings_line_height != '')
			// 	$string_inline_style .= 'line-height:'.$strings_line_height.'px;';

			$fancy_text_id = 'uvc-type-wrap-'.rand(1000, 9999);

			if (is_numeric($strings_font_size)) {
                $strings_font_size = 'desktop:'.$strings_font_size.'px;';
            }
			if (is_numeric($strings_line_height)) {
                $strings_line_height = 'desktop:'.$strings_line_height.'px;';
            }

            $fancy_args = array(
                'target' => '#'.$fancy_text_id.
                '', // set targeted element e.g. unique class/id etc.
                'media_sizes' => array(
                    'font-size' => $strings_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
                   	'line-height' => $strings_line_height
                ),
            );
            $data_list = get_ultimate_vc_responsive_media_css($fancy_args);

            if (is_numeric($prefix_suffix_font_size)) {
                $prefix_suffix_font_size = 'desktop:'.$prefix_suffix_font_size.'px !important;';
            }
			if (is_numeric($prefix_suffix_line_height)) {
                $prefix_suffix_line_height = 'desktop:'.$prefix_suffix_line_height.'px !important;';
            }

            $fancy_prefsuf_args = array(
                'target' => '#'.$fancy_text_id.
                ' .mycustfancy', // set targeted element e.g. unique class/id etc.
                'media_sizes' => array(
                    'font-size' => $prefix_suffix_font_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
                   	'line-height' => $prefix_suffix_line_height
                ),
            );
            $prefsuf_data_list = get_ultimate_vc_responsive_media_css($fancy_prefsuf_args);

			if($sufpref_color != '')
				$prefsuf_style .= 'color:'.$sufpref_color.';';
			if($sufpref_bg_color != '')
				$prefsuf_style .= 'background :'.$sufpref_bg_color.';';

			if($fancytext_align != '')
				$string_inline_style .= 'text-align:'.$fancytext_align.';';

			// Order of replacement
			$order   = array("\r\n", "\n", "\r", "<br/>", "<br>");
			$replace = '|';

			// Processes \r\n's first so they aren't converted twice.
			$str = str_replace($order, $replace, $fancytext_strings);

			$lines = explode("|", $str);

			$count_lines = count($lines);

			$ex_class .= ' uvc-type-align-'.$fancytext_align.' ';
			if($fancytext_prefix == '')
				$ex_class .= 'uvc-type-no-prefix';

			if($fancytext_color != '')
				$vticker_inline .= 'color:'.$fancytext_color.';';
			if($ticker_background != '')
			{
				$vticker_inline .= 'background:'.$ticker_background.';';
				if($fancytext_effect == 'typewriter')
					$valign = 'fancytext-typewriter-background-enabled';
				else
					$valign = 'fancytext-background-enabled';
			}

			$ultimate_js = get_option('ultimate_js');

			$output = '<'.$fancytext_tag.' id="'.$fancy_text_id.'" '.$data_list.' class="uvc-type-wrap '.$css_design_style.' '.$is_vc_49_plus.' ult-responsive '.$ex_class.' uvc-wrap-'.$id.'" style="'.$string_inline_style.'">';

				if(trim($fancytext_prefix) != '')
				{
					$output .= '<span '.$prefsuf_data_list.' class="ultimate-'.$fancytext_effect.'-prefix mycustfancy ult-responsive" style="'.$prefsuf_style.'">'.ltrim($fancytext_prefix).'</span>';
				}
				if($fancytext_effect == 'ticker' || $fancytext_effect == 'ticker-down')
				{
					if($ultimate_js != 'enable')
						wp_enqueue_script('ultimate-vticker-js');
					if($strings_font_size != '')
						$inherit_font_size = 'ultimate-fancy-text-inherit';
					else
						$inherit_font_size = '';
					if($ticker_hover_pause != 'true')
						$ticker_hover_pause = 'false';
					if($fancytext_effect == 'ticker-down')
						$direction = "down";
					else
						$direction = "up";
					$output .= '<div id="vticker-'.$id.'" '.$data_list.' class="ultimate-vticker '.$fancytext_effect.' '.$valign.' '.$inherit_font_size.'" style="'.$vticker_inline.'"><ul>';
						foreach($lines as $key => $line)
						{
							if($key == 0) {
								$style = 'style="opacity:1"';
							}
							else {
								$style = 'style="opacity:0"';
							}
							$output .= '<li '.$style.'>'.strip_tags($line).'</li>';
						}
					$output .= '</ul></div>';
				}
				else
				{
					if($ultimate_js != 'enable')
						wp_enqueue_script('ultimate-typed-js');
					if($typewriter_loop != 'true')
						$typewriter_loop = 'false';
					if($typewriter_cursor != 'true')
						$typewriter_cursor = 'false';
					$strings = '[';
						foreach($lines as $key => $line)
						{
							$strings .= '"'.__(trim(htmlspecialchars_decode(strip_tags($line))),'js_composer').'"';
							if($key != ($count_lines-1))
								$strings .= ',';
						}
					$strings .= ']';
					$output .= '<span id="typed-'.$id.'" class="ultimate-typed-main '.$valign.'" style="'.$vticker_inline.'"></span>';
				}
				if(trim($fancytext_suffix) != '')
				{
					$output .= '<span '.$prefsuf_data_list.' class="ultimate-'.$fancytext_effect.'-suffix mycustfancy ult-responsive" style="'.$prefsuf_style.'">'.rtrim($fancytext_suffix).'</span>';
				}
				if($fancytext_effect == 'ticker' || $fancytext_effect == 'ticker-down')
				{
					$output .= '<script type="text/javascript">
						jQuery(function($){
							$(document).ready(function(){
								$("#vticker-'.$id.'").find("li").css("opacity","1");
								$("#vticker-'.$id.'")
									.vTicker(
									{
										speed: '.$strings_tickerspeed.',
										showItems: '.$ticker_show_items.',
										pause: '.$ticker_wait_time.',
										mousePause : '.$ticker_hover_pause.',
										direction: "'.$direction.'",
									}
								);
							});
						});
					</script>';
				}
				else
				{
					$output .= '<script type="text/javascript"> jQuery(function($){ $("#typed-'.$id.'").typed({
								strings: '.$strings.',
								typeSpeed: '.$strings_textspeed.',
								backSpeed: '.$strings_backspeed.',
								startDelay: '.$strings_startdelay.',
								backDelay: '.$strings_backdelay.',
								loop: '.$typewriter_loop.',
								loopCount: false,
								showCursor: '.$typewriter_cursor.',
								cursorChar: "'.$typewriter_cursor_text.'",
								attr: null
							});
						});
					</script>';
					if($typewriter_cursor_color != '')
					{
						$output .= '<style>
							.uvc-wrap-'.$id.' .typed-cursor {
								color:'.$typewriter_cursor_color.';
							}
						</style>';
					}
				}
			$output .= '</'.$fancytext_tag.'>';

			/*$args = array(
				$strings_font_family
			);
			enquque_ultimate_google_fonts($args);*/

			return $output;
		}
	} // end class
	new Ultimate_FancyText;
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_ultimate_fancytext extends WPBakeryShortCode {
		}
	}

}