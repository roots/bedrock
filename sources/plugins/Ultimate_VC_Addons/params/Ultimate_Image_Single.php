<?php

/*-----------------------------------------------------------------------------------------
  # HOW TO USE
  -----------------------------------------------------------------------------------------
  1]  DEFINE STRUCTURE?

  - Define below structure in module which you want.

  e.g.  array(
              "type" => "ult_img_single",
              "heading" => "Upload Image",
              "param_name" => "icon_image",
              "description" => __("description for image single.", "ultimate_vc"),
        ),
  -----------------------------------------------------------------------------------------
  2]  USE FILTER?

  - Return url, array or json.

  e.g.  apply_filters('ult_get_img_single', $PARAM_NAME, 'url', 'size');    // {size} [optional] - thumbnail, full, medium etc. - default: full

        apply_filters('ult_get_img_single', $PARAM_NAME, 'array');
        apply_filters('ult_get_img_single', $PARAM_NAME, 'json');

  -----------------------------------------------------------------------------------------
  3]  OUTPUT

  - Output of two image uploader fields.

    http://i.imgur.com/csfJvKV.png
-----------------------------------------------------------------------------------------*/

if(!class_exists('Ult_Image_Single'))
{
  class Ult_Image_Single
  {
    function __construct()
    {
      add_action( 'admin_enqueue_scripts', array( $this, 'image_single_scripts' ) );
      add_filter('ult_get_img_single', array( $this, 'ult_img_single_init'),10,3);

      if(defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
        if(function_exists('vc_add_shortcode_param'))
        {
          vc_add_shortcode_param('ult_img_single', array($this, 'ult_img_single_callback'), plugins_url('../admin/vc_extend/js/ultimate-image_single.js',__FILE__));
        }
      }
      else {
        if(function_exists('add_shortcode_param'))
        {
          add_shortcode_param('ult_img_single', array($this, 'ult_img_single_callback'), plugins_url('../admin/vc_extend/js/ultimate-image_single.js',__FILE__));
        }
      }

      add_action('wp_ajax_ult_get_attachment_url', array($this, 'get_attachment_url_init') );
    }
    function get_attachment_url_init() {
      $id = $_POST['attach_id'];
      $thumb = wp_get_attachment_image_src( $id, 'thumbnail' );
      //echo json_encode( $thumb );
      echo $thumb[0];

      die();
    }

    function ult_img_single_callback($settings, $value)
    {
        $dependency = '';

        $uid = 'ult-image_single-'. rand(1000, 9999);

        $html  = '<div class="ult-image_single" id="'.$uid.'">';

        $html .= '<div class="ult_selected_image">';
        $html .= '  <ul class="ult_selected_image_list">';
        $html .= '    <li class="">';
        $html .= '      <div class="inner" style="width: 75px; height: 75px; overflow: hidden;text-align: center;">';
        $html .= '        <div class="spinner ult_img_single_spinner"></div>';
        $html .= '        <img src="">';
        $html .= '      </div>';
        $html .= '      <a title="Remove Footer Image" href="javascript:;" id="remove-thumbnail" class="icon-remove"></a>';
        $html .= '    </li>';
        $html .= '  </ul>';
        $html .= '</div>';
        $html .= '<a class="ult_add_image" href="#" title="Add image">Add image</a>';

        $html .= '  <input type="hidden" name="'.$settings['param_name'].'" class="wpb_vc_param_value ult-image_single-value '.$settings['param_name'].' '.$settings['type'].'_field" value="'.$value.'" '.$dependency.' />';
        $html .= '</div>';
      return $html;
    }

    function image_single_scripts() {
      wp_enqueue_media();
      wp_enqueue_style( 'ultimate_image_single_css', plugins_url('../admin/vc_extend/css/ultimate_image_single.css', __FILE__ ));
    }

    /**   Filter for image uploader
     *
     * @args    null|null
     *     or   null|URL
     *     or   ID|URL
     * @return  array|json
     *-------------------------------------------------*/
    function ult_img_single_init( $content = null, $data = '', $size = 'full' ){

      $final = '';

      if($content!='' && $content!='null|null') {

        //  Create an array
        $mainStr = explode('|', (string)$content);
        $string = '';
        $mainArr = array();

        $temp_id = $mainStr[0];
        $temp_url = (isset($mainStr[1])) ? $mainStr[1] : 'null';

        if( !empty($mainStr) && is_array($mainStr) ) {
          foreach ($mainStr as $key => $value) {
            if( !empty($value) ) {
            	if(stripos($value, '^') !== false) {
            		$tmvav_array = explode('^', $value);
	            	if(is_array($tmvav_array) && !empty($tmvav_array)) {
	            		if(!empty($tmvav_array)) {
		            		if(isset($tmvav_array[0])) {
		            			$mainArr[$tmvav_array[0]] = (isset($tmvav_array[1])) ? $tmvav_array[1] : '';
		            		}
		            	}
	            	}
            	}
            	else {
            		$mainArr['id'] = $temp_id;
            		$mainArr['url'] = $temp_url;
            	}
            }
          }
        }

        if($data!='') {
          switch ($data) {
            case 'url':     // First  - Priority for ID
                            if( !empty($mainArr['id']) && $mainArr['id'] != 'null' ) {

                              $Image_Url = '';
                              //  Get image URL, If input is number - e.g. 100x48 / 140x40 / 350x53
                              if( preg_match('/^\d/', $size) === 1 ) {
                                $size = explode('x', $size);

                                //  resize image using vc helper function - wpb_resize
                                $img = wpb_resize( $mainArr['id'], null, $size[0], $size[1], true );
                                if ( $img ) {
                                  $Image_Url = $img['url']; // $img['width'], $img['height'],
                                }

                              } else {

                                //  Get image URL, If input is string - [thumbnail, medium, large, full]
                                $hasImage = wp_get_attachment_image_src( $mainArr['id'], $size ); // returns an array
                                $Image_Url = $hasImage[0];
                              }

                              if( isset( $Image_Url ) && !empty( $Image_Url ) ) {
                                $final = $Image_Url;
                              } else {

                                //  Second - Priority for URL - get {image from url}
                                if(isset($mainArr['url']))
                                  $final = ult_get_url($mainArr['url']);

                              }
                            } else {
                              //  Second - Priority for URL - get {image from url}
                              if(isset($mainArr['url']))
                                $final = ult_get_url($mainArr['url']);
                            }
            break;
            case 'title':
            	$final = isset($mainArr['title']) ? $mainArr['title'] : get_post_meta($mainArr['id'], '_wp_attachment_image_title', true);
            break;
            case 'caption':
            	$final = isset($mainArr['caption']) ? $mainArr['caption'] : get_post_meta($mainArr['id'], '_wp_attachment_image_caption', true);
            break;
            case 'alt':
            	$final = isset($mainArr['alt']) ? $mainArr['alt'] : get_post_meta($mainArr['id'], '_wp_attachment_image_alt', true);
            break;
            case 'description':
            	$final = isset($mainArr['description']) ? $mainArr['description'] : get_post_meta($mainArr['id'], '_wp_attachment_image_description', true);
            break;
            case 'json':
                          $final = json_encode($mainArr);
              break;

            case 'sizes':
                          $img_size = getImageSquereSize( $img_id, $img_size );

                          $img = wpb_getImageBySize( array(
                            'attach_id' => $img_id,
                            'thumb_size' => $img_size,
                            'class' => 'vc_single_image-img'
                          ) );
                          $final = $img;
              break;

            case 'array':
            default:
                          $final = $mainArr;
              break;

          }
        }
      }

      return $final;
    }
  }

  if(!function_exists('ult_get_url')) {
    function ult_get_url($img) {
      if( isset($img) && !empty($img) ) {
        return $img;
      }
    }
  }

  //  USE THIS CODE TO SUPPORT CUSTOM SIZE OPTION
  if(!function_exists('getImageSquereSize')) {
    function getImageSquereSize( $img_id, $img_size ) {
      if ( preg_match_all( '/(\d+)x(\d+)/', $img_size, $sizes ) ) {
        $exact_size = array(
          'width' => isset( $sizes[1][0] ) ? $sizes[1][0] : '0',
          'height' => isset( $sizes[2][0] ) ? $sizes[2][0] : '0',
        );
      } else {
        $image_downsize = image_downsize( $img_id, $img_size );
        $exact_size = array(
          'width' => $image_downsize[1],
          'height' => $image_downsize[2],
        );
      }
      if ( isset( $exact_size['width'] ) && (int) $exact_size['width'] !== (int) $exact_size['height'] ) {
        $img_size = (int) $exact_size['width'] > (int) $exact_size['height']
          ? $exact_size['height'] . 'x' . $exact_size['height']
          : $exact_size['width'] . 'x' . $exact_size['width'];
      }

      return $img_size;
    }
  }
}



if(class_exists('Ult_Image_Single'))
{
  $Ult_Image_Single = new Ult_Image_Single();
}