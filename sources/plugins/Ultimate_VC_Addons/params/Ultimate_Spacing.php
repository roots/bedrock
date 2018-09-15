<?php

if(!class_exists('Ult_Spacing'))
{
  class Ult_Spacing
  {
    function __construct()
    {
      add_action( 'admin_enqueue_scripts', array( $this, 'ultimate_spacing_param_scripts' ) );

      if(defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
        if(function_exists('vc_add_shortcode_param'))
        {
          vc_add_shortcode_param('ultimate_spacing', array($this, 'ultimate_spacing_callback'), plugins_url('../admin/vc_extend/js/ultimate-spacing.js',__FILE__));
        }
      }
      else {
        if(function_exists('add_shortcode_param'))
        {
          add_shortcode_param('ultimate_spacing', array($this, 'ultimate_spacing_callback'), plugins_url('../admin/vc_extend/js/ultimate-spacing.js',__FILE__));
        }
      }
    }

    function ultimate_spacing_callback($settings, $value)
    {
        $dependency = '';
        $positions = $settings['positions'];
        $mode = $settings['mode'];

        $uid = 'ultimate-spacing-'. rand(1000, 9999);
        if(isset($settings['unit'])) { $unit = $settings['unit']; } else { $unit = ''; }

          $html  = '<div class="ultimate-spacing" id="'.$uid.'" data-unit="'.$unit.'" >';

          //  Expand / Collapse
          $html .= '<div class="ult-spacing-expand">';
          $html .= '  <span class="ult-tooltip">Expand / Collapse</span>';
          $html .= '  <i class="dashicons dashicons-minus"></i>';
          $html .= '</div>';

          $html .= '<div class="ultimate-four-input-section" >';
            foreach($positions as $key => $default_value) {
              switch ($key) {
                case 'Top':
                            //  add '-width' if mode equals 'spacing'
                            $dashicon = 'dashicons dashicons-arrow-up-alt';
                            $html .= $this->ultimate_spacing_param_item($dashicon, $mode, $unit, /*$default_value,*/$default_value, $key);
                  break;
                case 'Right':
                            $dashicon = 'dashicons dashicons-arrow-right-alt';
                            $html .= $this->ultimate_spacing_param_item($dashicon, $mode, $unit, /*$default_value,*/$default_value, $key);
                  break;
                case 'Bottom':
                            $dashicon = 'dashicons dashicons-arrow-down-alt';
                            $html .= $this->ultimate_spacing_param_item($dashicon, $mode, $unit, /*$default_value,*/$default_value, $key);
                  break;
                case 'Left':
                            $dashicon = 'dashicons dashicons-arrow-left-alt';
                            $html .= $this->ultimate_spacing_param_item($dashicon, $mode, $unit, /*$default_value,*/$default_value, $key);
                  break;
              }
          }

          $html .= '<div class="ultimate-spacing-input-block ult-spacing-all " data-status="hide-all">
                      <span class="ultimate-spacing-icon"><i class="dashicons dashicons-editor-expand"></i></span>
                      <input type="text" class="ultimate-spacing-inputs ultimate-spacing-input" data-unit="'.$unit.'" data-default="" data-id="'.$mode.'" placeholder="All">
                    </div>';

          $html .= $this->get_units($unit);
          $html .= '</div><!-- .ultimate-four-input-section -->';

        $html .= '  <input type="hidden" data-unit="'.$unit.'" name="'.$settings['param_name'].'" class="wpb_vc_param_value ultimate-spacing-value '.$settings['param_name'].' '.$settings['type'].'_field" value="'.$value.'" '.$dependency.' />';
        $html .= '</div>';
      return $html;
    }
    function ultimate_spacing_param_item($dashicon, $mode, $unit,/* $default_value,*/$default_value, $key) {
        $html  = '  <div class="ultimate-spacing-input-block ult-spacing-single">';
        $html .= '    <span class="ultimate-spacing-icon">';
        $html .= '      <i class="'.$dashicon.'"></i>';
        $html .= '    </span>';
        $html .= '    <input type="text" class="ultimate-spacing-inputs ultimate-spacing-input" data-unit="'.$unit.'" data-default="'.$default_value.'" data-id="'.$mode.'-'.strtolower($key).'" placeholder="'.$key.'" />';
        $html .= '  </div>';
        return $html;
    }
    function get_units($unit) {
      //  set units - px, em, %
      $html  = '<div class="ultimate-unit-section">';
      //$html .= '  <label>'.$unit.'</label>';
      $html .= '  <select data-placeholder="Select Unit" class="ult-unit-spacing" >';
      switch($unit) {
        case "px":  $html .= '  <option value="px" selected>px</option>';
                    $html .= '  <option value="em">em</option>';
                    $html .= '  <option value="%">%</option>';
            break;
        case "em":  $html .= '  <option value="em" selected>em</option>';
                    $html .= '  <option value="px">px</option>';
                    $html .= '  <option value="%">%</option>';
            break;
        case "%":   $html .= '  <option value="%" selected>%</option>';
                    $html .= '  <option value="px">px</option>';
                    $html .= '  <option value="em">em</option>';
            break;
      }
      $html .= '  </select>';
      $html .= '</div>';

      return $html;
    }
    function ultimate_spacing_param_scripts($hook) {
        if($hook == "post.php" || $hook == "post-new.php"){
          $bsf_dev_mode = bsf_get_option('dev_mode');
          if($bsf_dev_mode === 'enable') {
            wp_register_style( 'ultimate_spacing_css', plugins_url('../admin/vc_extend/css/ultimate_spacing.css', __FILE__ ));
            wp_enqueue_style( 'ultimate_spacing_css');
          }
        }
    }
  }
}
if(class_exists('Ult_Spacing'))
{
  $Ult_Spacing = new Ult_Spacing();
}