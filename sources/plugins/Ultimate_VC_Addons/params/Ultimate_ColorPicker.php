<?php
if(!class_exists('Ultimate_ColorPicker_Param'))
{
	class Ultimate_ColorPicker_Param
	{
		function __construct()
		{
			if(defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
				if(function_exists('vc_add_shortcode_param'))
				{
					vc_add_shortcode_param('colorpicker_alpha' , array($this, 'colorpicker_alpha_gen'));
				}
			}
			else {
				if(function_exists('add_shortcode_param'))
				{
					add_shortcode_param('colorpicker_alpha' , array($this, 'colorpicker_alpha_gen'));
				}
			}
		}

		function colorpicker_alpha_gen($settings, $value)
		{
			$base = $opacity = $output = '';
			$dependency = '';
			$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
			$type = isset($settings['type']) ? $settings['type'] : '';
			$class = isset($settings['class']) ? $settings['class'] : '';
			$uni = uniqid('colorpicker-'.rand());
			if($value != ''){
				$arr_v = explode(',', $value);
				if(is_array($arr_v)){
					if(isset($arr_v[1])){
						$opacity = $arr_v[1];
					}
					if(isset($arr_v[0])){
						$base = $arr_v[0];
					}
				}
			}
			else{
				//$opacity=1;
				//$base='#fff';
			}
			$output = '
                <input id="alpha_val'.$uni.'" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . ' vc_column_alpha" value="'.$value.'" '.$dependency.' data-uniqid="'.$uni.'" data-opacity="'.$opacity.'" data-hex-code="'.$base.'"/>
';
			$output .= '
<input class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" '.$dependency.' name="'.$param_name.'" value="'.$value.'" style="display:none"/>
<button class="alpha_clear" type="button">'.__('Clear','ultimate_vc').'</button>
';
			?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					function colorpicker_alpha(selector,id_prefix){
						jQuery(selector).each(function(){
							var aid = jQuery(this).data('uniqid');
							jQuery(id_prefix+aid).minicolors({
								change: function(hex, opacity) {
									console.log(hex+','+opacity);
									jQuery(this).parent().next().val(hex+','+opacity);
									console.log(jQuery(this).parent().next().attr('class'))
								},
								opacity: true,
								defaultValue: jQuery(this).data('hex-code'),
								position: 'default',
							});
							jQuery('.alpha_clear').click(function(){
								jQuery(this).parent().find('input').val('');
								jQuery(this).parent().find('.minicolors-swatch-color').css('background-color','');
								//$select.val('');
								//jQuery(id_prefix+aid).val('');
								//jQuery(id_prefix+aid).next().find('.minicolors-swatch-color').css('background-color','');
							})
						});
					}
					colorpicker_alpha('.vc_column_alpha','#alpha_val');
				})
				</script>
            <?php
			return $output;
		}

	}
}

if(class_exists('Ultimate_ColorPicker_Param'))
{
	$Ultimate_ColorPicker_Param = new Ultimate_ColorPicker_Param();
}
