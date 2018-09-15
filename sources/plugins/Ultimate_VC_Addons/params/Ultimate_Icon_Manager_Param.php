<?php
if(!class_exists('Ultimate_Icon_Manager_Param'))
{
	class Ultimate_Icon_Manager_Param
	{
		function __construct()
		{

			$GLOBALS['pid']=0;
				$id=null;
				$pcnt=null;
			if(defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
				if(function_exists('vc_add_shortcode_param'))
				{
					vc_add_shortcode_param('icon_manager', array($this,'icon_manager'));
				}
			}
			else {
				if(function_exists('add_shortcode_param'))
				{
					add_shortcode_param('icon_manager', array($this,'icon_manager'));
				}
			}
		}

		function icon_manager($settings, $value)
		{
			$GLOBALS['pid'] = $GLOBALS['pid'] + 1;
			$pcnt=$GLOBALS['pid'];

			$AIO_Icon_Manager = new AIO_Icon_Manager;
			$font_manager = $AIO_Icon_Manager->get_font_manager($pcnt);
			$dependency = '';

			$params = parse_url($_SERVER['HTTP_REFERER']);
			$vc_is_inline = false;
			if(isset($params['query'])){
				parse_str($params['query'],$params);
				$vc_is_inline = isset($params['vc_action']) ? true : false;
			}

			$output = '<div class="my_param_block">'
					 .'<input name="'.$settings['param_name'].'"
					  class="wpb_txt_icon_value wpb_vc_param_value wpb-textinput '.$settings['param_name'].' 
					  '.$settings['type'].'_field" type="hidden" 

					  value="'.$value.'" ' . $dependency . ' id="'.$pcnt.'"/>'
					 .'</div>';
			if($vc_is_inline){
				$output .= '<script type="text/javascript">
					var val=jQuery("#'.$pcnt.'").val();
					//alert("yes");
					var val=jQuery("#'.$pcnt.'").val();
					var pmid="'.$pcnt.'";
					var pmid="'.$pcnt.'";
					var val=jQuery("#'.$pcnt.'").val();
					if(val==""){
							val="none";
						}
						if(val=="icon_color="){
							val="none";
						}

						jQuery(".preview-icon-'.$pcnt.'").html("<i class="+val+"></i>");

						jQuery(".icon-list-'.$pcnt.' li[data-icons=\'"+ val+"\']").addClass("selected");

						jQuery(".icons-list li").click(function() {

					var id=jQuery(this).attr("id");
					//alert(id);
                    jQuery(this).attr("class","selected").siblings().removeAttr("class");
                    var icon = jQuery(this).attr("data-icons");

                    jQuery("#"+id).val(icon);
                    jQuery(".preview-icon-"+id).html("<i class=\'"+icon+"\'></i>");
                });

					</script>';
			} else {


			$output .= '<script type="text/javascript">


				jQuery(document).ready(function(){
					var pmid="'.$pcnt.'";
					var val=jQuery("#'.$pcnt.'").val();
					if(val==""){
						val="none";
					}
					if(val=="icon_color="){
						val="none";
					}

					jQuery(".preview-icon-'.$pcnt.'").html("<i class="+val+"></i>");

					jQuery(".icon-list-'.$pcnt.' li[data-icons=\'"+ val+"\']").addClass("selected");
				});
				jQuery(".icons-list li").click(function() {
					var id=jQuery(this).attr("id");
					//alert(id);
                    jQuery(this).attr("class","selected").siblings().removeAttr("class");
                    var icon = jQuery(this).attr("data-icons");

                    jQuery("#"+id).val(icon);
                    jQuery(".preview-icon-"+id).html("<i class=\'"+icon+"\'></i>");
                });
				</script>';
					}
			$output .= '<div class="wpb_txt_icons_block" data-old-icon-value="'.$pcnt.'">'.$font_manager.'</div>';
			return $output;
		}

	}
}

if(class_exists('Ultimate_Icon_Manager_Param'))
{
	$Ultimate_Icon_Manager_Param = new Ultimate_Icon_Manager_Param();
}
