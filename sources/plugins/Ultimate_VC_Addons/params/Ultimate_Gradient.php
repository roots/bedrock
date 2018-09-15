<?php
if(!class_exists('Ultimate_Gradient_Param'))
{
	class Ultimate_Gradient_Param
	{
		function __construct()
		{
			if(defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
				if(function_exists('vc_add_shortcode_param'))
				{
					vc_add_shortcode_param('gradient' , array(&$this, 'gradient_picker' ) );
				}
			}
			else {
				if(function_exists('add_shortcode_param'))
				{
					add_shortcode_param('gradient' , array(&$this, 'gradient_picker' ) );
				}
			}
		}

		function gradient_picker($settings, $value)
		{
			$dependency = '';
			$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
			$type = isset($settings['type']) ? $settings['type'] : '';
			$color1 = isset($settings['color1']) ? $settings['color1'] : ' ';
			$color2 = isset($settings['color2']) ? $settings['color2'] : ' ';
			$class = isset($settings['class']) ? $settings['class'] : '';

			$dependency_element = $settings['dependency']['element'];
			$dependency_value = $settings['dependency']['value'];
			$dependency_value_json =  json_encode($dependency_value);

			$uni = uniqid();
			$output = '<div class="vc_ug_control" data-uniqid="'.$uni.'" data-color1="'.$color1.'" data-color2="'.$color2.'">';
			//$output .= '<div class="wpb_element_label" style="margin-top: 10px;">'.__('Gradient Type','upb_parallax').'</div>
			$output .= '<select id="grad_type'.$uni.'" class="grad_type" data-uniqid="'.$uni.'">
				<option value="vertical">'.__('Vertical','ultimate_vc').'</option>
				<option value="horizontal">'.__('Horizontal','ultimate_vc').'</option>
				<option value="custom">'.__('Custom','ultimate_vc').'</option>
			</select>
			<div id="grad_type_custom_wrapper'.$uni.'" class="grad_type_custom_wrapper" style="display:none;"><input type="number" id="grad_type_custom'.$uni.'" placeholder="45" data-uniqid="'.$uni.'" class="grad_custom" style="width: 200px; margin-bottom: 10px;"/> deg</div>';
			$output .= '<div class="wpb_element_label" style="margin-top: 10px;">'.__('Choose Colors','ultimate_vc').'</div>';
			$output .= '<div class="grad_hold" id="grad_hold'.$uni.'"></div>';
			$output .= '<div class="grad_trgt" id="grad_target'.$uni.'"></div>';

			$output .= '<input id="grad_val'.$uni.'" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . ' vc_ug_gradient" name="' . $param_name . '"  style="display:none"  value="'.$value.'" '.$dependency.'/></div>';

			?>
				<script type="text/javascript">
				jQuery(document).ready(function(){
						var dependency_element = '<?php echo $dependency_element ?>';
						var dependency_values = jQuery.parseJSON('<?php echo $dependency_value_json ?>');
						var dependency_values_array = jQuery.map(dependency_values, function(el) { return el; });

						var get_depend_value = jQuery('.'+dependency_element).val();

						jQuery('.grad_type').change(function(){
							var uni = jQuery(this).data('uniqid');
							var hid = "#grad_hold"+uni;
							var did = "#grad_target"+uni;
							var cid = "#grad_type_custom"+uni;
							var tid = "#grad_val"+uni;
							var cid_wrapper = "#grad_type_custom_wrapper"+uni;
							var orientation = jQuery(this).children('option:selected').val();

							if(orientation == 'custom')
							{
								jQuery(cid_wrapper).show();
							}
							else
							{
								jQuery(cid_wrapper).hide();
								if(orientation == 'vertical')
									var ori = 'top';
								else
									var ori = 'left';

								jQuery(hid).data('ClassyGradient').setOrientation(ori);
								var newCSS = jQuery(hid).data('ClassyGradient').getCSS();

								jQuery(tid).val(newCSS);
							}

						});

						jQuery('.grad_custom').on('keyup',function() {
							var uni = jQuery(this).data('uniqid');
							var hid = "#grad_hold"+uni;
							var gid = "#grad_type"+uni;
							var tid = "#grad_val"+uni;
							var orientation = jQuery(this).val()+'deg';
							jQuery(hid).data('ClassyGradient').setOrientation(orientation);
							var newCSS = jQuery(hid).data('ClassyGradient').getCSS();
							jQuery(tid).val(newCSS);
						});

						function gradient_pre_defined(dependency_element, dependency_values_array){
							jQuery('.vc_ug_control').each(function(){
								var uni = jQuery(this).data('uniqid');
								var hid = "#grad_hold"+uni;
								var did = "#grad_target"+uni;
								var tid = "#grad_val"+uni;
								var oid = "#grad_type"+uni;
								var cid = "#grad_type_custom"+uni;
								var cid_wrapper = "#grad_type_custom_wrapper"+uni;
								var orientation = jQuery(oid).children('option:selected').val();
								var prev_col = jQuery(tid).val();

								var is_custom = 'false';

								if(prev_col!='')
								{
									if(prev_col.indexOf('-webkit-linear-gradient(top,') != -1)
									{
										var p_l = prev_col.indexOf('-webkit-linear-gradient(top,');
										prev_col = prev_col.substring(p_l+28);
										p_l = prev_col.indexOf(');');
										prev_col = prev_col.substring(0,p_l);
										orientation = 'vertical';
									}
									else if(prev_col.indexOf('-webkit-linear-gradient(left,') != -1)
									{
										var p_l = prev_col.indexOf('-webkit-linear-gradient(left,');
										prev_col = prev_col.substring(p_l+29);
										p_l = prev_col.indexOf(');');
										prev_col = prev_col.substring(0,p_l);
										orientation = 'horizontal';
									}
									else
									{
										var p_l = prev_col.indexOf('-webkit-linear-gradient(');

										var subStr = prev_col.match("-webkit-linear-gradient((.*));background: -o");

										var prev_col = subStr[1].replace(/\(|\)/g, '');

										var temp_col = prev_col;

										var t_l = temp_col.indexOf('deg');
										var deg = temp_col.substring(0,t_l);

										prev_col = prev_col.substring(t_l+4, prev_col.length);

										jQuery(cid).val(deg);
										jQuery(cid_wrapper).show();
										orientation = 'custom';
										is_custom = 'true';
									}
								}
								else
								{
									prev_col ="#e3e3e3 0%";
								}

								jQuery(oid).children('option').each(function(i,opt){
									if(opt.value == orientation)
										jQuery(this).attr('selected',true);

								});

								if(is_custom == 'true')
									orientation = deg+'deg';
								else
								{
									if(orientation == 'vertical')
										orientation = 'top';
									else
										orientation = 'left';
								}

								jQuery(hid).ClassyGradient({
									width:350,
									height:25,
									orientation : orientation,
							        target:did,
							        gradient: prev_col,
							        onChange: function(stringGradient,cssGradient) {

										var depend = uvc_gradient_verfiy_depedant(dependency_element, dependency_values_array);

							        	cssGradient = cssGradient.replace('url(data:image/svg+xml;base64,','');
							        	var e_pos = cssGradient.indexOf(';');
							        	cssGradient = cssGradient.substring(e_pos+1);
							        	if(jQuery(tid).parents('.wpb_el_type_gradient').css('display')=='none'){
											//jQuery(tid).val('');
											cssGradient='';
										}
										if(depend)
											jQuery(tid).val(cssGradient);
										else
											jQuery(tid).val('');
							        },
							        onInit: function(cssGradient){
							        	//console.log(jQuery(tid).val())
										//check_for_orientation();

							        }
								});
								jQuery('.colorpicker').css('z-index','999999');
							})
						}
						if(jQuery.inArray( get_depend_value, dependency_values_array ) !== -1)
							var depend = true;
						else
							var depend = false;
						gradient_pre_defined(dependency_element, dependency_values_array);

						jQuery('.'+dependency_element).on('change',function(){
							var depend = uvc_gradient_verfiy_depedant(dependency_element, dependency_values_array);
							jQuery('.vc_ug_control').each(function(){
								var uni = jQuery(this).data('uniqid');
								var tid = "#grad_val"+uni;
								if(depend === false)
									jQuery(tid).val('');
								else
									gradient_pre_defined(dependency_element, dependency_values_array);
							});

						});

						function uvc_gradient_verfiy_depedant(dependency_element, dependency_values_array) {
							var get_depend_value = jQuery('.'+dependency_element).val();
							if(jQuery.inArray( get_depend_value, dependency_values_array ) !== -1)
								return true;
							else
								return false;
						}

				})
				</script>
			<?php
			return $output;
		}

	}
}

if(class_exists('Ultimate_Gradient_Param'))
{
	$Ultimate_Gradient_Param = new Ultimate_Gradient_Param();
}
