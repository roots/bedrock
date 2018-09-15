<?php
/*

# Usage -
	array(
		'type' => 'radio_image_box',
		'options' => array(
			'image-1' => plugins_url('../assets/images/patterns/01.png',__FILE__),
			'image-2' => plugins_url('../assets/images/patterns/12.png',__FILE__),
		),
		'useextension' => false, // if false it will use key as value instead file name. Eg - "image-1" instead "01.png"
		'css' => array(
			'width' => '40px',
			'height' => '35px',
			'background-repeat' => 'repeat',
			'background-size' => 'cover'
		),
	)

*/
if(!class_exists('Ultimate_Radio_Image_Param'))
{
	class Ultimate_Radio_Image_Param
	{
		function __construct()
		{
			if(defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
				if(function_exists('vc_add_shortcode_param'))
				{
					vc_add_shortcode_param('radio_image_box' , array(&$this, 'radio_image_settings_field' ) );
				}
			}
			else {
				if(function_exists('add_shortcode_param'))
				{
					add_shortcode_param('radio_image_box' , array(&$this, 'radio_image_settings_field' ) );
				}
			}
		}

		function radio_image_settings_field($settings, $value)
		{
			$default_css = array(
				'width' => '25px',
				'height' => '25px',
				'background-repeat' => 'repeat',
				'background-size' => 'cover'
			);
			$dependency = '';
			$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
			$type = isset($settings['type']) ? $settings['type'] : '';
			$options = isset($settings['options']) ? $settings['options'] : '';
			$css = isset($settings['css']) ? $settings['css'] : $default_css;
			$class = isset($settings['class']) ? $settings['class'] : '';
			$useextension = (isset($settings['useextension']) && $settings['useextension'] != '' ) ? $settings['useextension'] : 'true';
			$default = isset($settings['default']) ? $settings['default'] : 'transperant';

			$uni = uniqid();

			$output = '';
			$output = '<input id="radio_image_setting_val_'.$uni.'" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . ' '.$value.' vc_ug_gradient" name="' . $param_name . '"  style="display:none"  value="'.$value.'" '.$dependency.'/>';
			$output .= '<div class="ult-radio-image-box" data-uniqid="'.$uni.'">';
				if($value == 'transperant')
					$checked = 'checked';
				else
					$checked = '';
				$output .= '<label>
					<input type="radio" name="radio_image_'.$uni.'" '.$checked.' class="radio_pattern_image" value="'.$default.'" />
					<span class="pattern-background no-bg" style="background:transperant;"></span>
				</label>';
				foreach($options as $key => $img_url)
				{
					if($value == $key)
						$checked = 'checked';
					else
						$checked = '';
					if($useextension != 'true')
					{
						$temp = pathinfo($key);
						$temp_filename = $temp['filename'];
						$key = $temp_filename;
					}
					$output .= '<label>
						<input type="radio" name="radio_image_'.$uni.'" '.$checked.' class="radio_pattern_image" value="'.$key.'" />
						<span class="pattern-background" style="background:url('.$img_url.')"></span>
					</label>';
				}
			$output .= '</div>';
			$output .= '<style>
				.ult-radio-image-box label > input{ /* HIDE RADIO */
					display:none;
				}
				.ult-radio-image-box label > input + img{ /* IMAGE STYLES */
					cursor:pointer;
				  	border:2px solid transparent;
				}
				.ult-radio-image-box .no-bg {
					border:2px solid #ccc;
				}
				.ult-radio-image-box label > input:checked + img, .ult-radio-image-box label > input:checked + .pattern-background{ /* (CHECKED) IMAGE STYLES */
				  	border:2px solid #f00;
				}
				.pattern-background {';
					foreach($css as $attr => $inine_style)
					{
						$output .= $attr.':'.$inine_style.';';
					}
					$output .= 'display: inline-block;
					border:2px solid transparent;
				}
			</style>';
			$output .= '<script type="text/javascript">
				jQuery(".radio_pattern_image").change(function(){
					var radio_id = jQuery(this).parent().parent().data("uniqid");
					var val = jQuery(this).val();
					jQuery("#radio_image_setting_val_"+radio_id).val(val);
				});
			</script>';
			return $output;
		}

	}
}

if(class_exists('Ultimate_Radio_Image_Param'))
{
	$Ultimate_Radio_Image_Param = new Ultimate_Radio_Image_Param();
}
