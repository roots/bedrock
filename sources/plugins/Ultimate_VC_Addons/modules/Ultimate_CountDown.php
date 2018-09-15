<?php
/*
* Add-on Name: CountDown for Visual Composer
* Add-on URI: http://dev.brainstormforce.com
*/
if(!class_exists('Ultimate_CountDown'))
{
	class Ultimate_CountDown
	{
		function __construct()
		{
			add_action('init',array($this,'countdown_init'));
			add_shortcode('ult_countdown',array($this,'countdown_shortcode'));
			add_action('admin_enqueue_scripts',array($this,'admin_scripts'));
			add_action('wp_enqueue_scripts',array($this,'count_down_scripts'),1);
		}
		function count_down_scripts() {
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
			wp_register_script("jquery.timecircle",plugins_url($js_path."countdown".$ext.".js",__FILE__),array('jquery'),ULTIMATE_VERSION);
			wp_register_script("jquery.countdown",plugins_url($js_path."count-timer".$ext.".js",__FILE__),array('jquery'),ULTIMATE_VERSION);
			wp_register_style("ult-countdown",plugins_url($css_path."countdown".$ext.".css",__FILE__),array(),ULTIMATE_VERSION);
		}
		function admin_scripts($hook) {
		   if($hook == "post.php" || $hook == "post-new.php"){
		   		$bsf_dev_mode = bsf_get_option('dev_mode');
				if($bsf_dev_mode === 'enable') {
					//wp_enqueue_script('jquery.datetimep',plugins_url('../admin/js/bootstrap-datetimepicker.min.js',__FILE__),'1.0','jQuery',true);
		   			wp_register_style("ult-colorpicker-style",plugins_url('../admin/css/bootstrap-datetimepicker-admin.css',__FILE__));
					wp_enqueue_style('ult-colorpicker-style');
				}
		   }
	   	}
		function countdown_init()
		{
			if(function_exists('vc_map'))
			{
				vc_map(
					array(
					   "name" => __("Countdown","ultimate_vc"),
					   "base" => "ult_countdown",
					   "class" => "vc_countdown",
					   "icon" => "vc_countdown",
					   "category" => "Ultimate VC Addons",
					   "description" => __("Countdown Timer.","ultimate_vc"),
					   "params" => array(
					   		array(
						   		"type" => "dropdown",
								"class" => "",
								"heading" => __("Countdown Timer Style", "ultimate_vc"),
								"param_name" => "count_style",
								"value" => array(
										__("Digit and Unit Side by Side","smile") => "ult-cd-s1",
										__("Digit and Unit Up and Down","smile") => "ult-cd-s2",
									),
								"group" => "General Settings",
								//"description" => __("Select style for countdown timer.", "smile"),
							),
							array(
						   		"type" => "datetimepicker",
								"class" => "",
								"heading" => __("Target Time For Countdown", "ultimate_vc"),
								"param_name" => "datetime",
								"value" => "",
								"description" => __("Date and time format (yyyy/mm/dd hh:mm:ss).", "ultimate_vc"),
								"group" => "General Settings",
							),
							array(
						   		"type" => "dropdown",
								"class" => "",
								"heading" => __("Countdown Timer Depends on", "ultimate_vc"),
								"param_name" => "ult_tz",
								"value" => array(
										__("WordPress Defined Timezone","ultimate_vc") => "ult-wptz",
										__("User's System Timezone","ultimate_vc") => "ult-usrtz",
									),
								//"description" => __("Select style for countdown timer.", "smile"),
								"group" => "General Settings",
							),
							array(
						   		"type" => "checkbox",
								"class" => "",
								"heading" => __("Select Time Units To Display In Countdown Timer", "ultimate_vc"),
								"param_name" => "countdown_opts",
								"value" => array(
										__("Years","ultimate_vc") => "syear",
										__("Months","ultimate_vc") => "smonth",
										__("Weeks","ultimate_vc") => "sweek",
										__("Days","ultimate_vc") => "sday",
										__("Hours","ultimate_vc") => "shr",
										__("Minutes","ultimate_vc") => "smin",
										__("Seconds","ultimate_vc") => "ssec",
									),
								//"description" => __("Select options for the video.", "smile"),
								"group" => "General Settings",
							),
							array(
						   		"type" => "colorpicker",
								"class" => "",
								"heading" => __("Timer Digit Text Color", "ultimate_vc"),
								"param_name" => "tick_col",
								"value" => "",
								//"description" => __("Text color for time ticks.", "smile"),
								"group" => "General Settings",
							),
							array(
                          	  	"type" => "ultimate_responsive",
                          	  	"class" => "",
                          	  	"heading" => __("Timer Digit Text Size", 'ultimate_vc'),
                          	  	"param_name" => "tick_size",
                          	  	"unit"  => "px",
                          	  	"media" => array(
                          	  	    "Desktop"           => '',
                          	  	    "Tablet"            => '',
                          	  	    "Tablet Portrait"   => '',
                          	  	    "Mobile Landscape"  => '',
                          	  	    "Mobile"            => '',
                          	  	),
                          	  	"group" => "General Settings"
                          	),
                          	array(
                          	  	"type" => "ultimate_responsive",
                          	  	"class" => "",
                          	  	"heading" => __("Timer Digit Text Line height", 'ultimate_vc'),
                          	  	"param_name" => "tick_line_height",
                          	  	"unit"  => "px",
                          	  	"media" => array(
                          	  	    "Desktop"           => '',
                          	  	    "Tablet"            => '',
                          	  	    "Tablet Portrait"   => '',
                          	  	    "Mobile Landscape"  => '',
                          	  	    "Mobile"            => '',
                          	  	),
                          	  	"group" => "General Settings"
                          	),
							array(
						   		"type" => "dropdown",
								"class" => "",
								"heading" => __("Timer Digit Text Style", "ultimate_vc"),
								"param_name" => "tick_style",
								"value" => array(
												__("Normal","ultimate_vc")=>"",
												__("Bold","ultimate_vc") =>"bold",
												__("Italic","ultimate_vc")=>"italic",
												__("Bold & Italic","ultimate_vc")=>"boldnitalic",
											),
								//"description" => __("Font size of tick text.", "smile"),
								"group" => "General Settings",
							),
							array(
						   		"type" => "colorpicker",
								"class" => "",
								"heading" => __("Timer Unit Text Color", "ultimate_vc"),
								"param_name" => "tick_sep_col",
								"value" => "",
								//"description" => __("Text color for time ticks Period.", "smile"),
								"group" => "General Settings",
							),
							array(
                          	  	"type" => "ultimate_responsive",
                          	  	"class" => "",
                          	  	"heading" => __("Timer Unit Text Size", 'ultimate_vc'),
                          	  	"param_name" => "tick_sep_size",
                          	  	"unit"  => "px",
                          	  	"media" => array(
                          	  	    "Desktop"           => '',
                          	  	    "Tablet"            => '',
                          	  	    "Tablet Portrait"   => '',
                          	  	    "Mobile Landscape"  => '',
                          	  	    "Mobile"            => '',
                          	  	),
                          	  	"group" => "General Settings"
                          	),
                          	array(
                          	  	"type" => "ultimate_responsive",
                          	  	"class" => "",
                          	  	"heading" => __("Timer Unit Line Height", 'ultimate_vc'),
                          	  	"param_name" => "tick_sep_line_height",
                          	  	"unit"  => "px",
                          	  	"media" => array(
                          	  	    "Desktop"           => '',
                          	  	    "Tablet"            => '',
                          	  	    "Tablet Portrait"   => '',
                          	  	    "Mobile Landscape"  => '',
                          	  	    "Mobile"            => '',
                          	  	),
                          	  	"group" => "General Settings"
                          	),
							array(
						   		"type" => "dropdown",
								"class" => "",
								"heading" => __("Timer Unit Text Style", "ultimate_vc"),
								"param_name" => "tick_sep_style",
								"value" => array(
												__("Normal","ultimate_vc")=>"",
												__("Bold","ultimate_vc") =>"bold",
												__("Italic","ultimate_vc")=>"italic",
												__("Bold & Italic","ultimate_vc")=>"boldnitalic",
											),
								//"description" => __("Font size of tick text.", "smile"),
								"group" => "General Settings",
							),
							array(
						   		"type" => "dropdown",
								"class" => "",
								"heading" => __("Timer Digit Border Style", "ultimate_vc"),
								"param_name" => "br_style",
								"value" => array(
											"None"=>'',
											"Solid"=>"solid",
											"Dashed"=>"dashed",
											"Dotted"=>"dotted",
											"Double"=>"double",
											"Inset"=>"inset",
											"Outset"=>"outset",
											),
								//"description" => __("Border-style.", "smile"),
								"group" => "General Settings",
							),
							array(
						   		"type" => "number",
								"class" => "",
								"heading" => __("Timer Digit Border Size", "ultimate_vc"),
								"param_name" => "br_size",
								"value" => "",
								"min"=>"0",
								"suffix"=>"px",
								//"description" => __("Border-size.", "smile"),
								"dependency" => Array("element"=>"br_style","value"=>array("solid","dotted","dashed","double","inset","outset",)),
								"group" => "General Settings",
							),
							array(
						   		"type" => "colorpicker",
								"class" => "",
								"heading" => __("Timer Digit Border Color", "ultimate_vc"),
								"param_name" => "br_color",
								"value" => "",
								//"description" => __("Text color for time ticks Period.", "smile"),
								"dependency" => Array("element"=>"br_style","value"=>array("solid","dotted","dashed","double","inset","outset",)),
								"group" => "General Settings",
							),
							array(
						   		"type" => "number",
								"class" => "",
								"heading" => __("Timer Digit Border Radius", "ultimate_vc"),
								"param_name" => "br_radius",
								"value" => "",
								"min"=>"0",
								"suffix"=>"px",
								//"description" => __("Border-Time Radius.", "smile"),
								"dependency" => Array("element"=>"br_style","value"=>array("solid","dotted","dashed","double","inset","outset",)),
								"group" => "General Settings",
							),
							array(
						   		"type" => "colorpicker",
								"class" => "",
								"heading" => __("Timer Digit Background Color", "ultimate_vc"),
								"param_name" => "timer_bg_color",
								"value" => "",
								//"description" => __("Background-Color.", "smile"),
								"group" => "General Settings",
							),
							array(
						   		"type" => "number",
								"class" => "",
								"heading" => __("Timer Digit Background Size", "ultimate_vc"),
								"param_name" => "br_time_space",
								"min"=>"0",
								"value" => "0",
								"suffix"=>"px",
								//"description" => __("Border-Timer Space.", "smile"),
								"group" => "General Settings",
							),
							array(
						   		"type" => "textfield",
								"class" => "",
								"heading" => __("Extra Class", "ultimate_vc"),
								"param_name" => "el_class",
								"value" => "",
								"description" => __("Extra Class for the Wrapper.", "ultimate_vc"),
								"group" => "General Settings",
							),
							array(
						   		"type" => "textfield",
								"class" => "",
								"heading" => __("Day (Singular)", "ultimate_vc"),
								"param_name" => "string_days",
								"value" => "Day",
								//"description" => __("Enter your string for day.", "smile"),
								"group" => "Strings Translation",
							),
							array(
						   		"type" => "textfield",
								"class" => "",
								"heading" => __("Days (Plural)", "ultimate_vc"),
								"param_name" => "string_days2",
								"value" => "Days",
								//"description" => __("Enter your string for days.", "smile"),
								"group" => "Strings Translation",
							),
							array(
						   		"type" => "textfield",
								"class" => "",
								"heading" => __("Week (Singular)", "ultimate_vc"),
								"param_name" => "string_weeks",
								"value" => "Week",
								//"description" => __("Enter your string for Week.", "smile"),
								"group" => "Strings Translation",
							),
							array(
						   		"type" => "textfield",
								"class" => "",
								"heading" => __("Weeks (Plural)", "ultimate_vc"),
								"param_name" => "string_weeks2",
								"value" => "Weeks",
								//"description" => __("Enter your string for Weeks.", "smile"),
								"group" => "Strings Translation",
							),
							array(
						   		"type" => "textfield",
								"class" => "",
								"heading" => __("Month (Singular)", "ultimate_vc"),
								"param_name" => "string_months",
								"value" => "Month",
								//"description" => __("Enter your string for Month.", "smile"),
								"group" => "Strings Translation",
							),
							array(
						   		"type" => "textfield",
								"class" => "",
								"heading" => __("Months (Plural)", "ultimate_vc"),
								"param_name" => "string_months2",
								"value" => "Months",
								//"description" => __("Enter your string for Months.", "smile"),
								"group" => "Strings Translation",
							),
							array(
						   		"type" => "textfield",
								"class" => "",
								"heading" => __("Year (Singular)", "ultimate_vc"),
								"param_name" => "string_years",
								"value" => "Year",
								//"description" => __("Enter your string for Year.", "smile"),
								"group" => "Strings Translation",
							),
							array(
						   		"type" => "textfield",
								"class" => "",
								"heading" => __("Years (Plural)", "ultimate_vc"),
								"param_name" => "string_years2",
								"value" => "Years",
								//"description" => __("Enter your string for Years.", "smile"),
								"group" => "Strings Translation",
							),
							array(
						   		"type" => "textfield",
								"class" => "",
								"heading" => __("Hour (Singular)", "ultimate_vc"),
								"param_name" => "string_hours",
								"value" => "Hour",
								//"description" => __("Enter your string for Hour.", "smile"),
								"group" => "Strings Translation",
							),
							array(
						   		"type" => "textfield",
								"class" => "",
								"heading" => __("Hours (Plural)", "ultimate_vc"),
								"param_name" => "string_hours2",
								"value" => "Hours",
								//"description" => __("Enter your string for Hours.", "smile"),
								"group" => "Strings Translation",
							),
							array(
						   		"type" => "textfield",
								"class" => "",
								"heading" => __("Minute (Singular)", "ultimate_vc"),
								"param_name" => "string_minutes",
								"value" => "Minute",
								//"description" => __("Enter your string for Minute.", "smile"),
								"group" => "Strings Translation",
							),
							array(
						   		"type" => "textfield",
								"class" => "",
								"heading" => __("Minutes (Plural)", "ultimate_vc"),
								"param_name" => "string_minutes2",
								"value" => "Minutes",
								//"description" => __("Enter your string for Minutes.", "smile"),
								"group" => "Strings Translation",
							),
							array(
						   		"type" => "textfield",
								"class" => "",
								"heading" => __("Second (Singular)", "ultimate_vc"),
								"param_name" => "string_seconds",
								"value" => "Second",
								//"description" => __("Enter your string for Second.", "smile"),
								"group" => "Strings Translation",
							),
							array(
						   		"type" => "textfield",
								"class" => "",
								"heading" => __("Seconds (Plural)", "ultimate_vc"),
								"param_name" => "string_seconds2",
								"value" => "Seconds",
								//"description" => __("Enter your string for Seconds.", "smile"),
								"group" => "Strings Translation",
							),
							array(
								"type" => "ult_param_heading",
								"text" => "<span style='display: block;'><a href='http://bsf.io/szdd2' target='_blank'>".__("Watch Video Tutorial","ultimate_vc")." &nbsp; <span class='dashicons dashicons-video-alt3' style='font-size:30px;vertical-align: middle;color: #e52d27;'></span></a></span>",
								"param_name" => "notification",
								'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
								"group" => "General Settings",
							),
							array(
					            'type' => 'css_editor',
					            'heading' => __( 'Css', 'ultimate_vc' ),
					            'param_name' => 'css_countdown',
					            'group' => __( 'Design ', 'ultimate_vc' ),
					            'edit_field_class' => 'vc_col-sm-12 vc_column no-vc-background no-vc-border creative_link_css_editor',
					        ),
						)
					)
				);
			}
		}
		// Shortcode handler function for  icon block
		function countdown_shortcode($atts)
		{
			$count_style = $datetime = $ult_tz = $countdown_opts = $tick_col = $tick_size = $tick_line_height = $tick_style = $tick_sep_col = $tick_sep_size = $tick_sep_line_height = '';
			$tick_sep_style = $br_color = $br_style = $br_size = $timer_bg_color = $br_radius = $br_time_space = $el_class = '';
			$string_days = $string_weeks = $string_months = $string_years = $string_hours = $string_minutes = $string_seconds = '';
			$string_days2 = $string_weeks2 = $string_months2 = $string_years2 = $string_hours2 = $string_minutes2 = $string_seconds2 = '';
			extract(shortcode_atts( array(
				'count_style'=>'ult-cd-s1',
				'datetime'=>'',
				'ult_tz'=>'ult-wptz',
				'countdown_opts'=>'',
				'tick_col'=>'',
				'tick_size'=>'36',
				'tick_line_height'=>'',
				'tick_style'=>'',
				'tick_sep_col'=>'',
				'tick_sep_size'=>'13',
				'tick_sep_line_height'=> '',
				'tick_sep_style'=>'',
				'br_color'=>'',
				'br_style'=>'',
				'br_size'=>'',
				'timer_bg_color'=>'',
				'br_radius'=>'',
				'br_time_space'=>'0',
				'el_class'=>'',
				'string_days' => 'Day',
				'string_days2' => 'Days',
				'string_weeks' => 'Week',
				'string_weeks2' => 'Weeks',
				'string_months' => 'Month',
				'string_months2' => 'Months',
				'string_years' => 'Year',
				'string_years2' => 'Years',
				'string_hours' => 'Hour',
				'string_hours2' => 'Hours',
				'string_minutes' => 'Minute',
				'string_minutes2' => 'Minutes',
				'string_seconds' => 'Second',
				'string_seconds2' => 'Seconds',
				'css_countdown' => '',
			),$atts));
			$count_frmt = $labels = $countdown_design_style = '';
			$labels = $string_years2 .','.$string_months2.','.$string_weeks2.','.$string_days2.','.$string_hours2.','.$string_minutes2.','.$string_seconds2;
			$labels2 = $string_years .','.$string_months.','.$string_weeks.','.$string_days.','.$string_hours.','.$string_minutes.','.$string_seconds;
			$countdown_opt = explode(",",$countdown_opts);
				if(is_array($countdown_opt)){
					foreach($countdown_opt as $opt){
						if($opt == "syear") $count_frmt .= 'Y';
						if($opt == "smonth") $count_frmt .= 'O';
						if($opt == "sweek") $count_frmt .= 'W';
						if($opt == "sday") $count_frmt .= 'D';
						if($opt == "shr") $count_frmt .= 'H';
						if($opt == "smin") $count_frmt .= 'M';
						if($opt == "ssec") $count_frmt .= 'S';
					}
				}
			if (is_numeric($tick_size)) {
                $tick_size = 'desktop:'.$tick_size.'px;';
            }
            $countdown_design_style = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css_countdown, ' ' ), "ult_countdown", $atts );
            $countdown_design_style = esc_attr( $countdown_design_style );
            $countdown_id = 'countdown-wrap-'.rand(1000, 9999);
   //          $ult_countdown_args = array(
   //              'target' => '#'.$countdown_id.' .ult_countdown-amount', // set targeted element e.g. unique class/id etc.
   //              'media_sizes' => array(
   //                  'font-size' => $tick_size, // set 'css property' & 'ultimate_responsive' sizes. Here $title_responsive_font_size holds responsive font sizes from user input.
   //                 	//'line-height' => $title_font_line_height
   //              ),
   //          );
			// $data_list = get_ultimate_vc_responsive_media_css($ult_countdown_args);

			$data_attr = '';
			if($count_frmt=='') $count_frmt = 'DHMS';
			if($br_size =='' || $br_color == '' || $br_style ==''){
				if($timer_bg_color==''){
					$el_class.=' ult-cd-no-border';
				}
			}
			else{
				$data_attr .=  'data-br-color="'.$br_color.'" data-br-style="'.$br_style.'" data-br-size="'.$br_size.'" ';
			}
			// Responsive param

			if(is_numeric($tick_sep_size)) 	{ 	$tick_sep_size = 'desktop:'.$tick_sep_size.'px;';		}
			if(is_numeric($tick_sep_line_height)) 	{ 	$tick_sep_line_height = 'desktop:'.$tick_sep_line_height.'px;';		}

			$count_down_id = "count-down-wrap-".rand(1000,9999);
		  	$count_down_sep_args = array(
		  		'target'		=>	'#'.$count_down_id.' .ult_countdown-period',
		  		'media_sizes' 	=> array(
					'font-size' 	=> $tick_sep_size,
					'line-height' 	=> $tick_sep_line_height,
				),
		  	);
			$count_down_sep_data_list = get_ultimate_vc_responsive_media_css($count_down_sep_args);

			$data_attr .= ' data-tick-style="'.$tick_style.'" ';
			$data_attr .= ' data-tick-p-style="'.$tick_sep_style.'" ';
			$data_attr .= ' data-bg-color="'.$timer_bg_color.'" data-br-radius="'.$br_radius.'" data-padd="'.$br_time_space.'" ';
			$output = '<div "'.$count_down_sep_data_list.'" class="ult-responsive ult_countdown '.$countdown_design_style.' '.$el_class.' '.$count_style.'">';

			//Responsive param

			if(is_numeric($tick_size)) 	{ 	$tick_size = 'desktop:'.$tick_size.'px;';		}
			if(is_numeric($tick_line_height)) 	{ 	$tick_line_height = 'desktop:'.$tick_line_height.'px;';		}

		  	$count_down_args = array(
		  		'target'		=>	'#'.$count_down_id.' .ult_countdown-amount',
		  		'media_sizes' 	=> array(
					'font-size' 	=> $tick_size,
					'line-height' 	=> $tick_line_height,
				),
		  	);
			$count_down_data_list = get_ultimate_vc_responsive_media_css($count_down_args);

			if($datetime!=''){
				$output .='<div id="'.$count_down_id.'"  class="ult-responsive ult_countdown-div ult_countdown-dateAndTime '.$ult_tz.'" data-labels="'.$labels.'" data-labels2="'.$labels2.'"  data-terminal-date="'.$datetime.'" data-countformat="'.$count_frmt.'" data-time-zone="'.get_option('gmt_offset').'" data-time-now="'.str_replace('-', '/', current_time('mysql')).'"  data-tick-col="'.$tick_col.'"  '.$count_down_data_list.' data-tick-p-col="'.$tick_sep_col.'" '.$data_attr.'>'.$datetime.'</div>';
			}
			$output .='</div>';
			$is_preset = false;
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
				$output .= '</pre>'; // remove backslash once copied
			}
			return $output;
		}
	}
	//instantiate the class
	$ult_countdown = new Ultimate_CountDown;
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_ult_countdown extends WPBakeryShortCode {
		}
	}
}