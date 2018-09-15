<?php
if(!class_exists('Ultimate_DateTime_Picker_Param'))
{
	class Ultimate_DateTime_Picker_Param
	{
		function __construct()
		{
			if(defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
				if(function_exists('vc_add_shortcode_param'))
				{
					vc_add_shortcode_param('datetimepicker' , array($this, 'datetimepicker'), plugins_url('../admin/js/bootstrap-datetimepicker.min.js',__FILE__));
				}
			}
			else {
				if(function_exists('add_shortcode_param'))
				{
					add_shortcode_param('datetimepicker' , array($this, 'datetimepicker'), plugins_url('../admin/js/bootstrap-datetimepicker.min.js',__FILE__));
				}
			}
		}

		function datetimepicker($settings, $value)
		{
			$dependency = '';
			$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
			$type = isset($settings['type']) ? $settings['type'] : '';
			$class = isset($settings['class']) ? $settings['class'] : '';
			$uni = uniqid('datetimepicker-'.rand());
			$output = '<div id="ult-date-time'.$uni.'" class="ult-datetime"><input data-format="yyyy/MM/dd hh:mm:ss" readonly class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" style="width:258px;" value="'.$value.'" '.$dependency.'/><div class="add-on" >  <i data-time-icon="Defaults-calendar-o" data-date-icon="Defaults-calendar-o"></i></div></div>';
			$output .= '<script type="text/javascript">

				</script>';
			return $output;
		}

	}
}

if(class_exists('Ultimate_DateTime_Picker_Param'))
{
	$Ultimate_DateTime_Picker_Param = new Ultimate_DateTime_Picker_Param();
}
