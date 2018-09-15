<?php

 /**  # W3Schools
  *               - box-shadow: none|h-shadow v-shadow blur spread color |inset|initial|inherit;
  *
  *   How To?
  *
  *     array(
  *           "type" => "ultimate_boxshadow",
  *           "heading" => __("Box Shadow", "ultimate_vc"),
  *           "param_name" => "img_box_shadow",
  *           "unit"     => "px",                        //  [required] px,em,%,all     Default all
  *           "positions" => array(
  *             __("Horizontal","ultimate_vc")     => "",
  *             __("Vertical","ultimate_vc")   => "",
  *             __("Blur","ultimate_vc")  => "",
  *             __("Spread","ultimate_vc")    => ""
  *           ),
  *           "label_color"   => __("Shadow Color","ultimate_vc"),
  *           //"label_style" => __("Style","ultimate_vc"),
  *           "dependency" => Array("element" => "img_box_shadow_type", "value" => "on" ),
  *     ),
  *
  */

if(!class_exists('Ultimate_BoxShadow'))
{
  class Ultimate_BoxShadow
  {
    function __construct()
    {
      if(defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
        if(function_exists('vc_add_shortcode_param'))
        {
          vc_add_shortcode_param('ultimate_boxshadow', array($this, 'ultimate_boxshadow_callback'), plugins_url('../admin/vc_extend/js/vc-box-shadow-param.js',__FILE__));
        }
      }
      else {
        if(function_exists('add_shortcode_param')) {
          add_shortcode_param('ultimate_boxshadow', array($this, 'ultimate_boxshadow_callback'), plugins_url('../admin/vc_extend/js/vc-box-shadow-param.js',__FILE__));
        }
      }

      add_action( 'admin_enqueue_scripts', array( $this, 'ultimate_boxshadow_param_scripts' ) );
      add_filter('Ultimate_GetBoxShadow', array( $this, 'ultimate_get_box_shadow'),10,3);
    }

    function ultimate_boxshadow_callback($settings, $value) {

        $dependency = '';
        $positions = $settings['positions'];
        $enable_color = isset($settings['enable_color']) ? $settings['enable_color'] : true;
        //$enable_radius = isset($settings['enable_radius']) ? $settings['enable_radius'] : true ;
        $unit = isset($settings['unit']) ? $settings['unit'] : 'px';

        $uid = 'ultimate-boxshadow-'. rand(1000, 9999); //$settings['param_name'];
        //$uid = uniqid('ultimate-boxshadow-'. $settings['param_name'] .'-'. rand());
          $html  = '<div class="ultimate-boxshadow" id="'.$uid.'" data-unit="'.$unit.'" >';

        //  Box Shadow - Style
        $label = "Shadow Style";
        if(isset($settings['label_style']) && $settings['label_style']!='' ) { $label = $settings['label_style']; }
        $html .= '<div class="ultbs-select-block">';
        $html .= '    <div class="ultbs-select-wrap">';
        //$html .= '    <div class="label wpb_element_label">';
        //$html .=        $label;
        //$html .= '    </div>';
        $html .= '        <select class="ultbs-select" >';
        $html .= '            <option value="none">'.__('None','ultimate_vc').'</option>';
        $html .= '            <option value="inherit">'.__('Inherit','ultimate_vc').'</option>';
        $html .= '            <option value="inset">'.__('Inset','ultimate_vc').'</option>';
        $html .= '            <option value="outset">'.__('Outset','ultimate_vc').'</option>';
        /*$html .= '            <option value="initial">'.__('Initial','ultimate_vc').'</option>';*/
        $html .= '        </select>';
        $html .= '    </div>';
        $html .= '</div>';

        //  BORDER - WIDTH
        $html .= '<div class="ultbs-input-block" >';
        foreach($positions as $key => $default_value) {
          switch ($key) {
            case 'Horizontal':
                        $dashicon = 'dashicons dashicons-leftright';
                        $html .= $this->ultimate_boxshadow_param_item($dashicon, $unit, $default_value, $key);
              break;
            case 'Vertical':
                        $dashicon = 'dashicons dashicons-sort';
                        $html .= $this->ultimate_boxshadow_param_item($dashicon, $unit, $default_value, $key);
              break;
            case 'Blur':
                        $dashicon = 'dashicons dashicons-visibility';
                        $html .= $this->ultimate_boxshadow_param_item($dashicon, $unit, $default_value, $key);
              break;
            case 'Spread':
                        $dashicon = 'dashicons dashicons-location';
                        $html .= $this->ultimate_boxshadow_param_item($dashicon, $unit, $default_value, $key);
              break;
          }
        }
        $html .= $this->get_units($unit);
        $html .= '</div>';


        //  Box Shadow - Color
        if($enable_color) {
          $label = "Box Shadow Color";
          if(isset($settings['label_color']) && $settings['label_color']!='' ) { $label = $settings['label_color']; }
          $html .= '  <div class="ultbs-colorpicker-block">';
          $html .= '    <div class="label wpb_element_label">';
          $html .=        $label;
          $html .= '    </div>';
          $html .= '    <div class="ultbs-colorpicker-wrap">';
          $html .= '      <input name="" class="ultbs-colorpicker cs-wp-color-picker" type="text" value="" />';
          $html .= '    </div>';
          $html .= '  </div>';
        }

        $html .= '  <input type="hidden" data-unit="'.$unit.'" name="'.$settings['param_name'].'" class="wpb_vc_param_value ultbs-result-value '.$settings['param_name'].' '.$settings['type'].'_field" value="'.$value.'" '.$dependency.' />';
        $html .= '</div>';
      return $html;
    }
    function ultimate_boxshadow_param_item($dashicon, /*$mode,*/ $unit,/* $default_value,*/$default_value, $key) {
        $html  = '  <div class="ultbs-input-wrap">';
        $html .= '    <span class="ultbs-icon">';
        $html .= '      <span class="ultbs-tooltip">'.esc_html( $key ).'</span>';
        $html .= '      <i class="'.$dashicon.'"></i>';
        $html .= '    </span>';
        $html .= '    <input type="number" class="ultbs-input" data-unit="'.$unit.'" data-id="'.strtolower($key).'" data-default="'.$default_value.'" placeholder="'.$key.'" />';
        $html .= '  </div>';
        return $html;
    }
    function get_units($unit) {
      //  set units - px, em, %
      $html  = '<div class="ultbs-unit">';
      $html .= '  <label>'.$unit.'</label>';
      $html .= '</div>';
      return $html;
    }
    function ultimate_get_box_shadow( $content = null, $data = '' ){
        //    e.g.    horizontal:14px|vertical:20px|blur:30px|spread:40px|color:#81d742|style:inset|
      $final = '';

      if($content!='') {

        //  Create an array
        $mainStr = explode('|', $content);
        $string = '';
        $mainArr = array();
        if( !empty($mainStr) && is_array($mainStr) ) {
          foreach ($mainStr as $key => $value) {
            if(!empty($value)) {
              $string=explode(":",$value);
              if(is_array($string)) {
                if( !empty($string[1]) && $string[1] != 'outset' ) {
                  $mainArr[$string[0]]=$string[1];
                }
              }
            }
          }
        }

        $rm_bar = str_replace("|","",$content);
        $rm_colon = str_replace(":"," ",$rm_bar);
        $rmkeys = str_replace("horizontal","",$rm_colon);
        $rmkeys = str_replace("vertical","",$rmkeys);
        $rmkeys = str_replace("blur","",$rmkeys);
        $rmkeys = str_replace("spread","",$rmkeys);
        $rmkeys = str_replace("color","",$rmkeys);
        $rmkeys = str_replace("style","",$rmkeys);
        $rmkeys = str_replace("outset","",$rmkeys);     // Remove outset from style - To apply {outset} box shadow

        if($data!='') {
          switch ($data) {
            case 'data':
                          $final  = $rmkeys;
              break;
            case 'array':
                          $final = $mainArr;
              break;
            case 'css':
            default:
                      $final  = 'box-shadow:'.$rmkeys.';';
              break;
          }
        } else {
          $final  = 'box-shadow:'.$rmkeys.';';
        }
      }

      return $final;
    }
    function ultimate_boxshadow_param_scripts($hook) {
      if($hook == "post.php" || $hook == "post-new.php"){
        $bsf_dev_mode = bsf_get_option('dev_mode');
        if($bsf_dev_mode === 'enable') {
          wp_enqueue_style( 'wp-color-picker' );

          wp_register_style( 'ultimate_boxshadow_param_css', plugins_url('../admin/vc_extend/css/vc_param_boxshadow.css', __FILE__ ));
          wp_enqueue_style( 'ultimate_boxshadow_param_css');
          //wp_register_script('ultimate_boxshadow_param_js',plugins_url( '../admin/vc_extend/js/vc-box-shadow-param.js', __FILE__ ));
          //wp_enqueue_style( 'ultimate_boxshadow_param_choosen_css', plugins_url('../admin/vc_extend/css/chosen.css', __FILE__ ));
          //wp_enqueue_script('ultimate_boxshadow_param_choosen_js',plugins_url( '../admin/vc_extend/js/chosen.js', __FILE__ ));
        }
      }
    }
  }
}
if(class_exists('Ultimate_BoxShadow'))
{
  $Ultimate_BoxShadow = new Ultimate_BoxShadow();
}