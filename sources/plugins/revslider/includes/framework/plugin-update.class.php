<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2015 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

class RevSliderPluginUpdate {

	/**
	 * @since 5.0
	 */
	public function __construct(){		
	}
	
	
	/**
	 * return version of installation
	 * @since 5.0
	 */
	public static function get_version(){
		$real_version = get_option('revslider_update_version', 1.0);
		
		return $real_version;
	}
	
	
	/**
	 * set version of installation
	 * @since 5.0
	 */
	public static function set_version($set_to){
	
		update_option('revslider_update_version', $set_to);
		
	}
	
	
	/**
	 * check for updates and proceed if needed
	 * @since 5.0
	 */
	public static function do_update_checks(){
		$version = self::get_version();
		
		if(version_compare($version, 5.0, '<')){
			self::update_css_styles(); //update styles to the new 5.0 way
			self::add_v5_styles(); //add the version 5 styles that are new!
			self::check_settings_table(); //remove the usage of the settings table
			self::move_template_slider(); //move template sliders slides to the post based sliders and delete them/move them if not used
			self::add_animation_settings_to_layer(); //set missing animation fields to the slides layers
			self::add_style_settings_to_layer(); //set missing styling fields to the slides layers
			self::change_settings_on_layers(); //change settings on layers, for example, add the new structure of actions
			self::add_general_settings(); //set general settings
			
			self::remove_static_slides(); //remove static slides if the slider was v4 and had static slides which were not enabled
			
			$version = 5.0;
			self::set_version($version);
		}
		
		
		if(version_compare($version, '5.0.7', '<')){
			$version = '5.0.7';
			
			self::change_general_settings_5_0_7();
			self::set_version($version);
		}
		
		
		if(version_compare($version, '5.1.1', '<')){
			$version = '5.1.1';
			
			self::change_slide_settings_5_1_1();
			self::set_version($version);
		}
		
		
		if(version_compare($version, '5.2.5.5', '<')){
			$version = '5.2.5.5';
			
			self::change_layers_svg_5_2_5_5();
			self::set_version($version);
		}
		
	}
	
	
	/**
	 * add new styles for version 5.0
	 * @since 5.0
	 */
	public static function add_v5_styles(){
		
		$v5 = array(
			array('handle' => '.tp-caption.MarkerDisplay','settings' => '{"translated":5,"type":"text","version":"5.0"}','hover' => '{"color":"#ff0000","text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0px","0px","0px","0px"],"skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0"}','params' => '{"font-style":"normal","font-family":"Permanent Marker","padding":"0px 0px 0px 0px","text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"#000000","border-style":"none","border-width":"0px","border-radius":"0px 0px 0px 0px","z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":{"text-shadow":"none"},"hover":""}'),
			array('handle' => '.tp-caption.Restaurant-Display','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0"}','params' => '{"color":"#ffffff","font-size":"120px","line-height":"120px","font-weight":"700","font-style":"normal","font-family":"Roboto","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.Restaurant-Cursive','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0"}','params' => '{"color":"#ffffff","font-size":"30px","line-height":"30px","font-weight":"400","font-style":"normal","font-family":"Nothing you could do","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Restaurant-ScrollDownText','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0"}','params' => '{"color":"#ffffff","font-size":"17px","line-height":"17px","font-weight":"400","font-style":"normal","font-family":"Roboto","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Restaurant-Description','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0"}','params' => '{"color":"#ffffff","font-size":"20px","line-height":"30px","font-weight":"300","font-style":"normal","font-family":"Roboto","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":{"letter-spacing":"3px"},"hover":""}'),
			array('handle' => '.tp-caption.Restaurant-Price','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0"}','params' => '{"color":"#ffffff","font-size":"30px","line-height":"30px","font-weight":"300","font-style":"normal","font-family":"Roboto","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":{"letter-spacing":"3px"},"hover":""}'),
			array('handle' => '.tp-caption.Restaurant-Menuitem','settings' => '{"hover":"false","type":"text","version":"5.0","translated":"5"}','hover' => '{"color":"#000000","color-transparency":"1","text-decoration":"none","background-color":"#ffffff","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"pointer","speed":"500","easing":"Power2.easeInOut"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"17px","line-height":"17px","font-weight":"400","font-style":"normal","font-family":"Roboto","padding":["10px","30px","10px","30px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Furniture-LogoText','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#e6cfa3","color-transparency":"1","font-size":"160px","line-height":"150px","font-weight":"300","font-style":"normal","font-family":"\\"Raleway\\"","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":{"text-shadow":"none"},"hover":""}'),
			array('handle' => '.tp-caption.Furniture-Plus','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#000000","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["30px","30px","30px","30px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0.5","easing":"Linear.easeNone"}','params' => '{"color":"#e6cfa3","color-transparency":"1","font-size":"20","line-height":"20px","font-weight":"400","font-style":"normal","font-family":"\\"Raleway\\"","padding":["6px","7px","4px","7px"],"text-decoration":"none","background-color":"#ffffff","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["30px","30px","30px","30px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":{"text-shadow":"none","box-shadow":"rgba(0,0,0,0.1) 0 1px 3px"},"hover":""}'),
			array('handle' => '.tp-caption.Furniture-Title','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#000000","color-transparency":"1","font-size":"20px","line-height":"20px","font-weight":"700","font-style":"normal","font-family":"\\"Raleway\\"","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":{"text-shadow":"none","letter-spacing":"3px"},"hover":""}'),
			array('handle' => '.tp-caption.Furniture-Subtitle','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#000000","color-transparency":"1","font-size":"17px","line-height":"20px","font-weight":"300","font-style":"normal","font-family":"\\"Raleway\\"","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":{"text-shadow":"none"},"hover":""}'),
			array('handle' => '.tp-caption.Gym-Display','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"80px","line-height":"70px","font-weight":"900","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.Gym-Subline','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"30px","line-height":"30px","font-weight":"100","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":{"letter-spacing":"5px"},"hover":""}'),
			array('handle' => '.tp-caption.Gym-SmallText','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"17px","line-height":"22","font-weight":"300","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":{"text-shadow":"none"},"hover":""}'),
			array('handle' => '.tp-caption.Fashion-SmallText','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"12px","line-height":"20px","font-weight":"600","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Fashion-BigDisplay','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#000000","color-transparency":"1","font-size":"60px","line-height":"60px","font-weight":"900","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Fashion-TextBlock','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#000000","color-transparency":"1","font-size":"20px","line-height":"40px","font-weight":"400","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Sports-Display','settings' => '{"translated":5,"type":"text","version":"5.0"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"130px","line-height":"130px","font-weight":"100","font-style":"normal","font-family":"\\"Raleway\\"","padding":"0 0 0 0","text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":"0 0 0 0","z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":{"letter-spacing":"13px"},"hover":""}'),
			array('handle' => '.tp-caption.Sports-DisplayFat','settings' => '{"translated":5,"type":"text","version":"5.0"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"130px","line-height":"130px","font-weight":"900","font-style":"normal","font-family":"\\"Raleway\\"","padding":"0 0 0 0","text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":"0 0 0 0","z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":[""],"hover":""}'),
			array('handle' => '.tp-caption.Sports-Subline','settings' => '{"translated":5,"type":"text","version":"5.0"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#000000","color-transparency":"1","font-size":"32px","line-height":"32px","font-weight":"400","font-style":"normal","font-family":"\\"Raleway\\"","padding":"0 0 0 0","text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":"0 0 0 0","z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":{"letter-spacing":"4px"},"hover":""}'),
			array('handle' => '.tp-caption.Instagram-Caption','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"20px","line-height":"20px","font-weight":"900","font-style":"normal","font-family":"Roboto","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.News-Title','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"70px","line-height":"60px","font-weight":"400","font-style":"normal","font-family":"Roboto Slab","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.News-Subtitle','settings' => '{"hover":"true","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"0.65","text-decoration":"none","background-color":"#ffffff","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"solid","border-width":"0px","border-radius":["0","0","0px","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"300","easing":"Power3.easeInOut"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"15px","line-height":"24px","font-weight":"300","font-style":"normal","font-family":"Roboto Slab","padding":["0","0","0","0"],"text-decoration":"none","background-color":"#ffffff","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.Photography-Display','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"80px","line-height":"70px","font-weight":"100","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":{"letter-spacing":"5px"},"hover":""}'),
			array('handle' => '.tp-caption.Photography-Subline','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#777777","color-transparency":"1","font-size":"20px","line-height":"30px","font-weight":"300","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":{"letter-spacing":"3px"},"hover":""}'),
			array('handle' => '.tp-caption.Photography-ImageHover','settings' => '{"hover":"true","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"0.5","scalex":"0.8","scaley":"0.8","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"1000","easing":"Power3.easeInOut"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"20","line-height":"22","font-weight":"400","font-style":"normal","font-family":"","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"#ffffff","border-transparency":"0","border-style":"none","border-width":"0px","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.Photography-Menuitem','settings' => '{"hover":"true","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#00ffde","background-transparency":"0.65","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"pointer","speed":"200","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"20px","line-height":"20px","font-weight":"300","font-style":"normal","font-family":"Raleway","padding":["3px","5px","3px","8px"],"text-decoration":"none","background-color":"#000000","background-transparency":"0.65","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Photography-Textblock','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#fff","color-transparency":"1","font-size":"17px","line-height":"30px","font-weight":"300","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Photography-Subline-2','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"auto","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"0.35","font-size":"20px","line-height":"30px","font-weight":"300","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":{"letter-spacing":"3px"},"hover":""}'),
			array('handle' => '.tp-caption.Photography-ImageHover2','settings' => '{"hover":"true","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"0.5","scalex":"0.8","scaley":"0.8","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"pointer","speed":"500","easing":"Back.easeOut"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"20","line-height":"22","font-weight":"400","font-style":"normal","font-family":"Arial","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"#ffffff","border-transparency":"0","border-style":"none","border-width":"0px","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.WebProduct-Title','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"auto","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#333333","color-transparency":"1","font-size":"90px","line-height":"90px","font-weight":"100","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.WebProduct-SubTitle','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"auto","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#999999","color-transparency":"1","font-size":"15px","line-height":"20px","font-weight":"400","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.WebProduct-Content','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"auto","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#999999","color-transparency":"1","font-size":"16px","line-height":"24px","font-weight":"600","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600"}','advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.WebProduct-Menuitem','settings' => '{"hover":"true","version":"5.0","translated":"5"}','hover' => '{"color":"#999999","color-transparency":"1","text-decoration":"none","background-color":"#ffffff","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"pointer","speed":"200","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"15px","line-height":"20px","font-weight":"500","font-style":"normal","font-family":"Raleway","padding":["3px","5px","3px","8px"],"text-decoration":"none","text-align":"left","background-color":"#333333","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.WebProduct-Title-Light','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"auto","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#fff","color-transparency":"1","font-size":"90px","line-height":"90px","font-weight":"100","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","text-align":"left","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.WebProduct-SubTitle-Light','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"auto","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"0.35","font-size":"15px","line-height":"20px","font-weight":"400","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","text-align":"left","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","parallax":"-"}','advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.WebProduct-Content-Light','settings' => '{"hover":"false","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"auto","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"0.65","font-size":"16px","line-height":"24px","font-weight":"600","font-style":"normal","font-family":"Raleway","padding":["0","0","0","0"],"text-decoration":"none","text-align":"left","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","parallax":"-"}','advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.FatRounded','settings' => '{"hover":"true","type":"text","version":"5.0","translated":"5"}','hover' => '{"color":"#fff","color-transparency":"1","text-decoration":"none","background-color":"#000000","background-transparency":"1","border-color":"#d3d3d3","border-transparency":"1","border-style":"none","border-width":"0px","border-radius":["50px","50px","50px","50px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"pointer","speed":"300","easing":"Linear.easeNone"}','params' => '{"color":"#fff","color-transparency":"1","font-size":"30px","line-height":"30px","font-weight":"900","font-style":"normal","font-family":"Raleway","padding":["20px","22px","20px","25px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"0.5","border-color":"#d3d3d3","border-transparency":"1","border-style":"none","border-width":"0px","border-radius":["50px","50px","50px","50px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":{"text-shadow":"none"},"hover":""}'),
			array('handle' => '.tp-caption.NotGeneric-Title','settings' => '{"translated":5,"type":"text","version":"5.0"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"auto","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"70px","line-height":"70px","font-weight":"800","font-style":"normal","font-family":"Raleway","padding":"10px 0px 10px 0","text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":"0 0 0 0","z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":"[object Object]","hover":""}'),
			array('handle' => '.tp-caption.NotGeneric-SubTitle','settings' => '{"translated":5,"type":"text","version":"5.0"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"auto","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"13px","line-height":"20px","font-weight":"500","font-style":"normal","font-family":"Raleway","padding":"0 0 0 0","text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":"0 0 0 0","z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":{"letter-spacing":"4px","text-align":"left"},"hover":""}'),
			array('handle' => '.tp-caption.NotGeneric-CallToAction','settings' => '{"hover":"true","translated":5,"type":"text","version":"5.0"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"#ffffff","border-transparency":"1","border-style":"solid","border-width":"1","border-radius":"0px 0px 0px 0px","opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"pointer","speed":"300","easing":"Power3.easeOut"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"14px","line-height":"14px","font-weight":"500","font-style":"normal","font-family":"Raleway","padding":"10px 30px 10px 30px","text-decoration":"none","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.5","border-style":"solid","border-width":"1","border-radius":"0px 0px 0px 0px","z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":{"letter-spacing":"3px","text-align":"left"},"hover":""}'),
			array('handle' => '.tp-caption.NotGeneric-Icon','settings' => '{"translated":5,"type":"text","version":"5.0"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"#ffffff","border-transparency":"1","border-style":"solid","border-width":"1","border-radius":["0px","0px","0px","0px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"default","speed":"300","easing":"Power3.easeOut"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"30px","line-height":"30px","font-weight":"400","font-style":"normal","font-family":"Raleway","padding":"0px 0px 0px 0px","text-decoration":"none","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"0","border-style":"solid","border-width":"0px","border-radius":"0px 0px 0px 0px","z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":{"letter-spacing":"3px","text-align":"left"},"hover":""}'),
			array('handle' => '.tp-caption.NotGeneric-Menuitem','settings' => '{"hover":"true","translated":5,"type":"text","version":"5.0"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"1","border-style":"solid","border-width":"1px","border-radius":"0px 0px 0px 0px","opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"pointer","speed":"300","easing":"Power1.easeInOut"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"14px","line-height":"14px","font-weight":"500","font-style":"normal","font-family":"Raleway","padding":"27px 30px 27px 30px","text-decoration":"none","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.15","border-style":"solid","border-width":"1px","border-radius":"0px 0px 0px 0px","z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":{"letter-spacing":"3px","text-align":"left"},"hover":""}'),
			array('handle' => '.tp-caption.MarkerStyle','settings' => '{"translated":5,"type":"text","version":"5.0"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"auto","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"17px","line-height":"30px","font-weight":"100","font-style":"normal","font-family":"\\"Permanent Marker\\"","padding":"0 0 0 0","text-decoration":"none","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":"0 0 0 0","z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":{"text-align":"left","0":""},"hover":""}'),
			array('handle' => '.tp-caption.Gym-Menuitem','settings' => '{"hover":"true","type":"text","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#000000","background-transparency":"1","border-color":"#ffffff","border-transparency":"0.25","border-style":"solid","border-width":"2px","border-radius":["3px","3px","3px","3px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"pointer","speed":"200","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"20px","line-height":"20px","font-weight":"300","font-style":"normal","font-family":"Raleway","padding":["3px","5px","3px","8px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"1","border-color":"#ffffff","border-transparency":"0","border-style":"solid","border-width":"2px","border-radius":["3px","3px","3px","3px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Newspaper-Button','settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}','hover' => '{"color":"#000000","color-transparency":"1","text-decoration":"none","background-color":"#FFFFFF","background-transparency":"1","border-color":"#ffffff","border-transparency":"1","border-style":"solid","border-width":"1px","border-radius":["0px","0px","0px","0px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"pointer","speed":"300","easing":"Power1.easeInOut"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"13px","line-height":"17px","font-weight":"700","font-style":"normal","font-family":"Roboto","padding":["12px","35px","12px","35px"],"text-decoration":"none","text-align":"left","background-color":"#ffffff","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.25","border-style":"solid","border-width":"1px","border-radius":["0px","0px","0px","0px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Newspaper-Subtitle','settings' => '{"hover":"false","type":"text","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"auto","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#a8d8ee","color-transparency":"1","font-size":"15px","line-height":"20px","font-weight":"900","font-style":"normal","font-family":"Roboto","padding":["0","0","0","0"],"text-decoration":"none","text-align":"left","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.Newspaper-Title','settings' => '{"hover":"false","type":"text","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"auto","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#fff","color-transparency":"1","font-size":"50px","line-height":"55px","font-weight":"400","font-style":"normal","font-family":"\\"Roboto Slab\\"","padding":["0","0","10px","0"],"text-decoration":"none","text-align":"left","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.Newspaper-Title-Centered','settings' => '{"hover":"false","type":"text","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"auto","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#fff","color-transparency":"1","font-size":"50px","line-height":"55px","font-weight":"400","font-style":"normal","font-family":"\\"Roboto Slab\\"","padding":["0","0","10px","0"],"text-decoration":"none","text-align":"center","background-color":"transparent","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.Hero-Button','settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}','hover' => '{"color":"#000000","color-transparency":"1","text-decoration":"none","background-color":"#ffffff","background-transparency":"1","border-color":"#ffffff","border-transparency":"1","border-style":"solid","border-width":"1","border-radius":["0px","0px","0px","0px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"pointer","speed":"300","easing":"Power1.easeInOut"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"14px","line-height":"14px","font-weight":"500","font-style":"normal","font-family":"Raleway","padding":["10px","30px","10px","30px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.5","border-style":"solid","border-width":"1","border-radius":["0px","0px","0px","0px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":{"letter-spacing":"3px"},"hover":""}'),
			array('handle' => '.tp-caption.Video-Title','settings' => '{"hover":"false","type":"text","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"auto","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#fff","color-transparency":"1","font-size":"30px","line-height":"30px","font-weight":"900","font-style":"normal","font-family":"Raleway","padding":["5px","5px","5px","5px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"1","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"-20%","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.Video-SubTitle','settings' => '{"hover":"false","type":"text","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"auto","speed":"0","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"12px","line-height":"12px","font-weight":"600","font-style":"normal","font-family":"Raleway","padding":["5px","5px","5px","5px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"0.35","border-color":"transparent","border-transparency":"1","border-style":"none","border-width":"0","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"-20%","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.NotGeneric-Button','settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"transparent","background-transparency":"0","border-color":"#ffffff","border-transparency":"1","border-style":"solid","border-width":"1","border-radius":["0px","0px","0px","0px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"pointer","speed":"300","easing":"Power1.easeInOut"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"14px","line-height":"14px","font-weight":"500","font-style":"normal","font-family":"Raleway","padding":["10px","30px","10px","30px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.5","border-style":"solid","border-width":"1","border-radius":["0px","0px","0px","0px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":{"letter-spacing":"3px","text-align":"left"},"hover":""}'),
			array('handle' => '.tp-caption.NotGeneric-BigButton','settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"1","border-style":"solid","border-width":"1px","border-radius":["0px","0px","0px","0px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"pointer","speed":"300","easing":"Power1.easeInOut"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"14px","line-height":"14px","font-weight":"500","font-style":"normal","font-family":"Raleway","padding":["27px","30px","27px","30px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.15","border-style":"solid","border-width":"1px","border-radius":["0px","0px","0px","0px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":{"letter-spacing":"3px"},"hover":""}'),
			array('handle' => '.tp-caption.WebProduct-Button','settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}','hover' => '{"color":"#333333","color-transparency":"1","text-decoration":"none","background-color":"#ffffff","background-transparency":"1","border-color":"#000000","border-transparency":"1","border-style":"none","border-width":"2","border-radius":["0","0","0","0"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"auto","speed":"300","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"16px","line-height":"48px","font-weight":"600","font-style":"normal","font-family":"Raleway","padding":["0px","40px","0px","40px"],"text-decoration":"none","text-align":"left","background-color":"#333333","background-transparency":"1","border-color":"#000000","border-transparency":"1","border-style":"none","border-width":"2","border-radius":["0","0","0","0"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":{"letter-spacing":"1px"},"hover":""}'),
			array('handle' => '.tp-caption.Restaurant-Button','settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#000000","background-transparency":"0","border-color":"#ffe081","border-transparency":"1","border-style":"solid","border-width":"2","border-radius":["0px","0px","0px","0px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"auto","speed":"300","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"17px","line-height":"17px","font-weight":"500","font-style":"normal","font-family":"Roboto","padding":["12px","35px","12px","35px"],"text-decoration":"none","text-align":"left","background-color":"#0a0a0a","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.5","border-style":"solid","border-width":"2","border-radius":["0px","0px","0px","0px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":{"letter-spacing":"3px"},"hover":""}'),
			array('handle' => '.tp-caption.Gym-Button','settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#72a800","background-transparency":"1","border-color":"#000000","border-transparency":"0","border-style":"solid","border-width":"0","border-radius":["30px","30px","30px","30px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"pointer","speed":"300","easing":"Power1.easeInOut"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"15px","line-height":"15px","font-weight":"600","font-style":"normal","font-family":"Raleway","padding":["13px","35px","13px","35px"],"text-decoration":"none","text-align":"left","background-color":"#8bc027","background-transparency":"1","border-color":"#000000","border-transparency":"0","border-style":"solid","border-width":"0","border-radius":["30px","30px","30px","30px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":{"letter-spacing":"1px"},"hover":""}'),
			array('handle' => '.tp-caption.Gym-Button-Light','settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#72a800","background-transparency":"0","border-color":"#8bc027","border-transparency":"1","border-style":"solid","border-width":"2px","border-radius":["30px","30px","30px","30px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"pointer","speed":"300","easing":"Power2.easeInOut"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"15px","line-height":"15px","font-weight":"600","font-style":"normal","font-family":"Raleway","padding":["12px","35px","12px","35px"],"text-decoration":"none","text-align":"left","background-color":"transparent","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.25","border-style":"solid","border-width":"2px","border-radius":["30px","30px","30px","30px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":"","hover":""}'),
			array('handle' => '.tp-caption.Sports-Button-Light','settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"1","border-style":"solid","border-width":"2","border-radius":["0px","0px","0px","0px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"auto","speed":"500","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"17px","line-height":"17px","font-weight":"600","font-style":"normal","font-family":"Raleway","padding":["12px","35px","12px","35px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.5","border-style":"solid","border-width":"2","border-radius":["0px","0px","0px","0px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Sports-Button-Red','settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#000000","background-transparency":"1","border-color":"#000000","border-transparency":"1","border-style":"solid","border-width":"2","border-radius":["0px","0px","0px","0px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"auto","speed":"500","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"17px","line-height":"17px","font-weight":"600","font-style":"normal","font-family":"Raleway","padding":["12px","35px","12px","35px"],"text-decoration":"none","text-align":"left","background-color":"#db1c22","background-transparency":"1","border-color":"#db1c22","border-transparency":"0","border-style":"solid","border-width":"2px","border-radius":["0px","0px","0px","0px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":{"letter-spacing":"2px"},"hover":""}'),
			array('handle' => '.tp-caption.Photography-Button','settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"1","border-style":"solid","border-width":"1px","border-radius":["30px","30px","30px","30px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"auto","speed":"300","easing":"Power3.easeOut"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"15px","line-height":"15px","font-weight":"600","font-style":"normal","font-family":"Raleway","padding":["13px","35px","13px","35px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.25","border-style":"solid","border-width":"1px","border-radius":["30px","30px","30px","30px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":{"letter-spacing":"1px"},"hover":""}'),
			array('handle' => '.tp-caption.Newspaper-Button-2','settings' => '{"hover":"true","type":"button","version":"5.0","translated":"5"}','hover' => '{"color":"#ffffff","color-transparency":"1","text-decoration":"none","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"1","border-style":"solid","border-width":"2","border-radius":["3px","3px","3px","3px"],"opacity":"1","scalex":"1","scaley":"1","skewx":"0","skewy":"0","xrotate":"0","yrotate":"0","2d_rotation":"0","css_cursor":"pointer","speed":"300","easing":"Linear.easeNone"}','params' => '{"color":"#ffffff","color-transparency":"1","font-size":"15px","line-height":"15px","font-weight":"900","font-style":"normal","font-family":"Roboto","padding":["10px","30px","10px","30px"],"text-decoration":"none","text-align":"left","background-color":"#000000","background-transparency":"0","border-color":"#ffffff","border-transparency":"0.5","border-style":"solid","border-width":"2","border-radius":["3px","3px","3px","3px"],"z":"0","skewx":"0","skewy":"0","scalex":"1","scaley":"1","opacity":"1","xrotate":"0","yrotate":"0","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","pers":"600","corner_left":"nothing","corner_right":"nothing","parallax":"-"}','advanced' => '{"idle":"","hover":""}')
		);
		
		$db = new RevSliderDB();
		
		foreach($v5 as $v5class){
			$result = $db->fetch(RevSliderGlobals::$table_css, $db->prepare("handle = %s", array($v5class['handle'])));
			if(empty($result)){
				//add v5 style
				$db->insert(RevSliderGlobals::$table_css, $v5class);
			}
		}
		
	}
	

	/**
	 * update the styles to meet requirements for version 5.0
	 * @since 5.0
	 */
	public static function update_css_styles(){
	
		$css = new RevSliderCssParser();
		$db = new RevSliderDB();
		
		$styles = $db->fetch(RevSliderGlobals::$table_css);
		$default_classes = RevSliderCssParser::default_css_classes();
		
		$cs = array(
			'background-color' => 'backgroundColor', //rgb rgba and opacity
			'border-color' => 'borderColor',
			'border-radius' => 'borderRadius',
			'border-style' => 'borderStyle',
			'border-width' => 'borderWidth',
			'color' => 'color',
			'font-family' => 'fontFamily',
			'font-size' => 'fontSize',
			'font-style' => 'fontStyle',
			'font-weight' => 'fontWeight',
			'line-height' => 'lineHeight',
			'opacity' => 'opacity',
			'padding' => 'padding',
			'text-decoration' => 'textDecoration',
			'text-align' => 'textAlign'
		);
		
		$cs = array_merge($cs, RevSliderCssParser::get_deformation_css_tags());
		
		
		
		foreach($styles as $key => $attr){
			
			if(isset($attr['advanced'])){
				$adv = json_decode($attr['advanced'], true); // = array('idle' => array(), 'hover' => '');
			}else{
				$adv = array('idle' => array(), 'hover' => '');
			}
			
			if(!isset($adv['idle'])) $adv['idle'] = array();
			if(!isset($adv['hover'])) $adv['hover'] = array();
			
			//only do this to styles prior 5.0
			$settings = json_decode($attr['settings'], true);
			if(!empty($settings) && isset($settings['translated'])){
				if(version_compare($settings['translated'], 5.0, '>=')) continue;
			}
			
			$idle = json_decode($attr['params'], true);
			$hover = json_decode($attr['hover'], true);
			
			//check if in styles, there is type, then change the type text to something else
			$the_type = 'text';
			
			if(!empty($idle)){
				foreach($idle as $style => $value){
					if($style == 'type') $the_type = $value;
					if(!isset($cs[$style])){
						$adv['idle'][$style] = $value;
						unset($idle[$style]);
					}
				}
			}
			
			if(!empty($hover)){
				foreach($hover as $style => $value){
					if(!isset($cs[$style])){
						$adv['hover'][$style] = $value;
						unset($hover[$style]);
					}
				}
			}
			
			$settings['translated'] = 5.0; //set the style version to 5.0
			$settings['type'] = $the_type; //set the type version to text, since 5.0 we also have buttons and shapes, so we need to differentiate from now on
			
			
			
			if(!isset($settings['version'])){
				if(isset($default_classes[$styles[$key]['handle']])){
					$settings['version'] = $default_classes[$styles[$key]['handle']];
				}else{
					$settings['version'] = 'custom'; //set the version to custom as its not in the defaults
				}
			}
			
			$styles[$key]['params'] = json_encode($idle);
			$styles[$key]['hover'] = json_encode($hover);
			$styles[$key]['advanced'] = json_encode($adv);
			$styles[$key]['settings'] = json_encode($settings);			
		}
		
		//save now all styles back to database
		foreach($styles as $key => $attr){
			$ret = $db->update(RevSliderGlobals::$table_css, array('settings' => $styles[$key]['settings'], 'params' => $styles[$key]['params'], 'hover' => $styles[$key]['hover'], 'advanced' => $styles[$key]['advanced']), array('id' => $attr['id']));
		}
		
	}
	
	
	/**
	 * remove the settings from the table and use them from now on with get_option / update_option
	 * @since 5.0
	 */
	public static function check_settings_table(){
		global $wpdb;
		
		if($wpdb->get_var("SHOW TABLES LIKE '".RevSliderGlobals::$table_settings."'") == RevSliderGlobals::$table_settings) {
			$result = $wpdb->get_row("SELECT `general` FROM ".RevSliderGlobals::$table_settings, ARRAY_A);
			if(isset($result['general'])){
				update_option('revslider-global-settings', $result['general']);
			}
		}
		
	}
	
	
	/**
	 * move the template sliders and add the slides to corresponding post based slider or simply move them and change them to post based slider if no slider is using them
	 * @since 5.0
	 */
	public static function move_template_slider(){
		$db = new RevSliderDB();
		
		$used_templates = array(); //will store all template IDs that are used by post based Sliders, these can be deleted after the progress.
		
		$sr = new RevSlider();
		$sl = new RevSliderSlide();
		$arrSliders = $sr->getArrSliders(false, false);
		$tempSliders = $sr->getArrSliders(false, true);
		
		if(empty($tempSliders) || !is_array($tempSliders)) return true; //as we do not have any template sliders, we do not need to run further here
		
		if(!empty($arrSliders) && is_array($arrSliders)){
			foreach($arrSliders as $slider){
				if($slider->getParam('source_type', 'gallery') !== 'posts')  continue; //only check Slider with type of posts
				
				$slider_id = $slider->getID();
				
				$template_id = $slider->getParam('slider_template_id',0);
				
				if($template_id > 0){ //initialize slider to see if it exists. Then copy over the Template Sliders Slides to the Post Based Slider
					foreach($tempSliders as $t_slider){
						if($t_slider->getID() === $template_id){ //copy over the slides
							//get all slides from template, then copy to Slider
							
							$slides = $t_slider->getSlides();
							
							if(!empty($slides) && is_array($slides)){
								foreach($slides as $slide){
									$slide_id = $slide->getID();
									$slider->copySlideToSlider(array('slider_id' => $slider_id, 'slide_id' => $slide_id));
								}
							}
							
							$static_id = $sl->getStaticSlideID($template_id);
							if($static_id !== false){
								$record = $db->fetchSingle(RevSliderGlobals::$table_static_slides, $db->prepare("id = %s", array($static_id)));
								unset($record['id']);
								$record['slider_id'] = $slider_id;
								
								$db->insert(RevSliderGlobals::$table_static_slides, $record);
							}
							
							$used_templates[$template_id] = $t_slider;
							break;
						}
					}
				}
				
			}
		}
		
		if(!empty($used_templates)){
			foreach($used_templates as $tid => $t_slider){
				$t_slider->deleteSlider();
			}
		}
		
		//translate all other template Sliders to normal sliders and set them to post based
		$temp_sliders = $sr->getArrSliders(false, true); 
		
		if(!empty($temp_sliders) && is_array($temp_sliders)){
			foreach($temp_sliders as $slider){
				$slider->updateParam(array('template' => 'false'));
				$slider->updateParam(array('source_type' => 'posts'));
			}
		}
		
	}
	
	
	/**
	 * add missing new animation fields to the layers as all animations would be broken without this
	 * @since 5.0
	 */
	public static function add_animation_settings_to_layer($sliders = false){
		$sr = new RevSlider();
		$sl = new RevSliderSlide();
		
		if($sliders === false){ //do it on all Sliders
			$sliders = $sr->getArrSliders(false);
		}else{
			$sliders = array($sliders);
		}
		
		
		$inAnimations = RevSliderOperations::getArrAnimations(true);
		$outAnimations = RevSliderOperations::getArrEndAnimations(true);
		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				$slides = $slider->getSlides();
				$staticID = $sl->getStaticSlideID($slider->getID());
				if($staticID !== false){
					$msl = new RevSliderSlide();
					if(strpos($staticID, 'static_') === false){
						$staticID = 'static_'.$slider->getID();
					}
					$msl->initByID($staticID);
					if($msl->getID() !== ''){
						$slides = array_merge($slides, array($msl));
					}
				}
				
				if(!empty($slides) && is_array($slides)){
					foreach($slides as $slide){
						$layers = $slide->getLayers();
						if(!empty($layers) && is_array($layers)){
							foreach($layers as $lk => $layer){
								if(RevSliderFunctions::getVal($layer, 'x_start', false) === false){ //values are not set, set them now through
									$animation = RevSliderFunctions::getVal($layer, 'animation', 'tp-fade');
									$endanimation = RevSliderFunctions::getVal($layer, 'endanimation', 'tp-fade');
									if($animation == 'fade') $animation = 'tp-fade';
									if($endanimation == 'fade') $endanimation = 'tp-fade';
									
									$anim_values = array();
									foreach($inAnimations as $handle => $anim){
										if($handle == $animation){
											$anim_values = (isset($anim['params'])) ? $anim['params'] : '';
											if(!is_array($anim_values)) $anim_values = json_encode($anim_values);
											break;
										}
									}
									
									$anim_endvalues = array();
									foreach($outAnimations as $handle => $anim){
										if($handle == $endanimation){
											$anim_endvalues = (isset($anim['params'])) ? $anim['params'] : '';
											if(!is_array($anim_endvalues)) $anim_endvalues = json_encode($anim_endvalues);
											break;
										}
									}
									
									$layers[$lk]['x_start'] = RevSliderFunctions::getVal($anim_values, 'movex', 'inherit');
									$layers[$lk]['x_end'] = RevSliderFunctions::getVal($anim_endvalues, 'movex', 'inherit');
									$layers[$lk]['y_start'] = RevSliderFunctions::getVal($anim_values, 'movey', 'inherit');
									$layers[$lk]['y_end'] = RevSliderFunctions::getVal($anim_endvalues, 'movey', 'inherit');
									$layers[$lk]['z_start'] = RevSliderFunctions::getVal($anim_values, 'movez', 'inherit');
									$layers[$lk]['z_end'] = RevSliderFunctions::getVal($anim_endvalues, 'movez', 'inherit');
									
									$layers[$lk]['x_rotate_start'] = RevSliderFunctions::getVal($anim_values, 'rotationx', 'inherit');
									$layers[$lk]['x_rotate_end'] = RevSliderFunctions::getVal($anim_endvalues, 'rotationx', 'inherit');
									$layers[$lk]['y_rotate_start'] = RevSliderFunctions::getVal($anim_values, 'rotationy', 'inherit');
									$layers[$lk]['y_rotate_end'] = RevSliderFunctions::getVal($anim_endvalues, 'rotationy', 'inherit');
									$layers[$lk]['z_rotate_start'] = RevSliderFunctions::getVal($anim_values, 'rotationz', 'inherit');
									$layers[$lk]['z_rotate_end'] = RevSliderFunctions::getVal($anim_endvalues, 'rotationz', 'inherit');
									
									$layers[$lk]['scale_x_start'] = RevSliderFunctions::getVal($anim_values, 'scalex', 'inherit');
									if(intval($layers[$lk]['scale_x_start']) > 10) $layers[$lk]['scale_x_start'] /= 100;
									$layers[$lk]['scale_x_end'] = RevSliderFunctions::getVal($anim_endvalues, 'scalex', 'inherit');
									if(intval($layers[$lk]['scale_x_end']) > 10) $layers[$lk]['scale_x_end'] /= 100;
									$layers[$lk]['scale_y_start'] = RevSliderFunctions::getVal($anim_values, 'scaley', 'inherit');
									if(intval($layers[$lk]['scale_y_start']) > 10) $layers[$lk]['scale_y_start'] /= 100;
									$layers[$lk]['scale_y_end'] = RevSliderFunctions::getVal($anim_endvalues, 'scaley', 'inherit');
									if(intval($layers[$lk]['scale_y_end']) > 10) $layers[$lk]['scale_y_end'] /= 100;
									
									$layers[$lk]['skew_x_start'] = RevSliderFunctions::getVal($anim_values, 'skewx', 'inherit');
									$layers[$lk]['skew_x_end'] = RevSliderFunctions::getVal($anim_endvalues, 'skewx', 'inherit');
									$layers[$lk]['skew_y_start'] = RevSliderFunctions::getVal($anim_values, 'skewy', 'inherit');
									$layers[$lk]['skew_y_end'] = RevSliderFunctions::getVal($anim_endvalues, 'skewy', 'inherit');
									
									$layers[$lk]['opacity_start'] = RevSliderFunctions::getVal($anim_values, 'captionopacity', 'inherit');
									$layers[$lk]['opacity_end'] = RevSliderFunctions::getVal($anim_endvalues, 'captionopacity', 'inherit');
									
								}
							}
							$slide->setLayersRaw($layers);
							$slide->saveLayers();
						}
					}
				}
			}
		}
	}
	
	
	/**
	 * add/change layers options
	 * @since 5.0
	 */
	public static function change_settings_on_layers($sliders = false){
		$sr = new RevSlider();
		$sl = new RevSliderSlide();
		if($sliders === false){ //do it on all Sliders
			$sliders = $sr->getArrSliders(false);
		}else{
			$sliders = array($sliders);
		}
		
		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				$slides = $slider->getSlides();
				$staticID = $sl->getStaticSlideID($slider->getID());
				if($staticID !== false){
					$msl = new RevSliderSlide();
					if(strpos($staticID, 'static_') === false){
						$staticID = 'static_'.$slider->getID();
					}
					$msl->initByID($staticID);
					if($msl->getID() !== ''){
						$slides = array_merge($slides, array($msl));
					}
				}
				if(!empty($slides) && is_array($slides)){
					foreach($slides as $slide){
						$layers = $slide->getLayers();
						if(!empty($layers) && is_array($layers)){
							$do_save = false;
							foreach($layers as $lk => $layer){
								$link_slide = RevSliderFunctions::getVal($layer, 'link_slide', false);
								if($link_slide != false && $link_slide !== 'nothing'){ //link to slide/scrollunder is set, move it to actions
									$layers[$lk]['layer_action'] = new stdClass();
									switch($link_slide){
										case 'link':
											$link = RevSliderFunctions::getVal($layer, 'link');
											$link_open_in = RevSliderFunctions::getVal($layer, 'link_open_in');
											$layers[$lk]['layer_action']->action = array('a' => 'link');
											$layers[$lk]['layer_action']->link_type = array('a' => 'a');
											$layers[$lk]['layer_action']->image_link = array('a' => $link);
											$layers[$lk]['layer_action']->link_open_in = array('a' => $link_open_in);
											
											unset($layers[$lk]['link']);
											unset($layers[$lk]['link_open_in']);
										case 'next':
											$layers[$lk]['layer_action']->action = array('a' => 'next');
										break;
										case 'prev':
											$layers[$lk]['layer_action']->action = array('a' => 'prev');
										break;
										case 'scroll_under':
											$scrollunder_offset = RevSliderFunctions::getVal($layer, 'scrollunder_offset');
											$layers[$lk]['layer_action']->action = array('a' => 'scroll_under');
											$layers[$lk]['layer_action']->scrollunder_offset = array('a' => $scrollunder_offset);
											
											unset($layers[$lk]['scrollunder_offset']);
										break;
										default: //its an ID, so its a slide ID
											$layers[$lk]['layer_action']->action = array('a' => 'jumpto');
											$layers[$lk]['layer_action']->jump_to_slide = array('a' => $link_slide);
										break;
										
									}
									$layers[$lk]['layer_action']->tooltip_event = array('a' => 'click');
									
									unset($layers[$lk]['link_slide']);
									
									$do_save = true;
								}
							}
							
							if($do_save){
								$slide->setLayersRaw($layers);
								$slide->saveLayers();
							}
						}
					}
				}
			}
		}
	}
	
	
	/**
	 * add missing new style fields to the layers as all layers would be broken without this
	 * @since 5.0
	 */
	public static function add_style_settings_to_layer($sliders = false){
		
		$sr = new RevSlider();
		$sl = new RevSliderSlide();
		$operations = new RevSliderOperations();
		if($sliders === false){ //do it on all Sliders
			$sliders = $sr->getArrSliders(false);
		}else{
			$sliders = array($sliders);
		}
		
		$styles = $operations->getCaptionsContentArray();
		
		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				$slides = $slider->getSlides();
				$staticID = $sl->getStaticSlideID($slider->getID());
				if($staticID !== false){
					$msl = new RevSliderSlide();
					if(strpos($staticID, 'static_') === false){
						$staticID = 'static_'.$slider->getID();
					}
					$msl->initByID($staticID);
					if($msl->getID() !== ''){
						$slides = array_merge($slides, array($msl));
					}
				}
				if(!empty($slides) && is_array($slides)){
					foreach($slides as $slide){
						$layers = $slide->getLayers();
						if(!empty($layers) && is_array($layers)){
							foreach($layers as $lk => $layer){
								$static_styles = (array) RevSliderFunctions::getVal($layer, 'static_styles', array());
								$def_val = (array) RevSliderFunctions::getVal($layer, 'deformation', array());
								$defh_val = (array) RevSliderFunctions::getVal($layer, 'deformation-hover', array());
								
								if(empty($def_val)){
									
									//add parallax always!
									$def_val['parallax'] = RevSliderFunctions::getVal($layer, 'parallax_level', '-');
									$layers[$lk]['deformation'] = $def_val;
									
									//check for selected style in styles, then add all deformations to the layer
									$cur_style = RevSliderFunctions::getVal($layer, 'style', '');
									
									if(trim($cur_style) == '') continue;
									$wws = false;
									
									foreach($styles as $style){
										if($style['handle'] == '.tp-caption.'.$cur_style){
											$wws = $style;
											break;
										}
									}
									
									if($wws == false) continue;
									
									$css_idle = '';
									$css_hover = '';
									
									$wws['params'] = (array)$wws['params'];
									$wws['hover'] = (array)$wws['hover'];
									$wws['advanced'] = (array)$wws['advanced'];
									
									if(isset($wws['params']['font-family'])) $def_val['font-family'] = $wws['params']['font-family'];
									if(isset($wws['params']['padding'])){
										$raw_pad = $wws['params']['padding'];
										if(!is_array($raw_pad)) $raw_pad = explode(' ', $raw_pad);
										
										switch(count($raw_pad)){
											case 1:
												$raw_pad = array($raw_pad[0], $raw_pad[0], $raw_pad[0], $raw_pad[0]);
											break;
											case 2:
												$raw_pad = array($raw_pad[0], $raw_pad[1], $raw_pad[0], $raw_pad[1]);
											break;
											case 3:
												$raw_pad = array($raw_pad[0], $raw_pad[1], $raw_pad[2], $raw_pad[1]);
											break;
										}
										
										$def_val['padding'] = $raw_pad;
									}
									if(isset($wws['params']['font-style'])) $def_val['font-style'] = $wws['params']['font-style'];
									if(isset($wws['params']['text-decoration'])) $def_val['text-decoration'] = $wws['params']['text-decoration'];
									if(isset($wws['params']['background-color'])){
										if(RevSliderFunctions::isrgb($wws['params']['background-color'])){
											$def_val['background-color'] = RevSliderFunctions::rgba2hex($wws['params']['background-color']);
										}else{
											$def_val['background-color'] = $wws['params']['background-color'];
										}
									}
									if(isset($wws['params']['background-transparency'])){
										$def_val['background-transparency'] = $wws['params']['background-transparency'];
										if($def_val['background-transparency'] > 1) $def_val['background-transparency'] /= 100;
									}else{
										if(isset($wws['params']['background-color'])) $def_val['background-transparency'] = RevSliderFunctions::get_trans_from_rgba($wws['params']['background-color'], true);
									}
									
									if(isset($wws['params']['border-color'])){
										if(RevSliderFunctions::isrgb($wws['params']['border-color'])){
											$def_val['border-color'] = RevSliderFunctions::rgba2hex($wws['params']['border-color']);
										}else{
											$def_val['border-color'] = $wws['params']['border-color'];
										}
									}
									
									if(isset($wws['params']['border-style'])) $def_val['border-style'] = $wws['params']['border-style'];
									if(isset($wws['params']['border-width'])) $def_val['border-width'] = $wws['params']['border-width'];
									if(isset($wws['params']['border-radius'])){
										$raw_bor = $wws['params']['border-radius'];
										if(!is_array($raw_bor)) $raw_bor = explode(' ', $raw_bor);
										
										switch(count($raw_bor)){
											case 1:
												$raw_bor = array($raw_bor[0], $raw_bor[0], $raw_bor[0], $raw_bor[0]);
											break;
											case 2:
												$raw_bor = array($raw_bor[0], $raw_bor[1], $raw_bor[0], $raw_bor[1]);
											break;
											case 3:
												$raw_bor = array($raw_bor[0], $raw_bor[1], $raw_bor[2], $raw_bor[1]);
											break;
										}
										
										$def_val['border-radius'] = $raw_bor;
									}
									if(isset($wws['params']['x'])) $def_val['x'] = $wws['params']['x'];
									if(isset($wws['params']['y'])) $def_val['y'] = $wws['params']['y'];
									if(isset($wws['params']['z'])) $def_val['z'] = $wws['params']['z'];
									if(isset($wws['params']['skewx'])) $def_val['skewx'] = $wws['params']['skewx'];
									if(isset($wws['params']['skewy'])) $def_val['skewy'] = $wws['params']['skewy'];
									if(isset($wws['params']['scalex'])) $def_val['scalex'] = $wws['params']['scalex'];
									if(isset($wws['params']['scaley'])) $def_val['scaley'] = $wws['params']['scaley'];
									if(isset($wws['params']['opacity'])) $def_val['opacity'] = $wws['params']['opacity'];
									if(isset($wws['params']['xrotate'])) $def_val['xrotate'] = $wws['params']['xrotate'];
									if(isset($wws['params']['yrotate'])) $def_val['yrotate'] = $wws['params']['yrotate'];
									if(isset($wws['params']['2d_rotation'])) $def_val['2d_rotation'] = $wws['params']['2d_rotation'];
									if(isset($wws['params']['2d_origin_x'])) $def_val['2d_origin_x'] = $wws['params']['2d_origin_x'];
									if(isset($wws['params']['2d_origin_y'])) $def_val['2d_origin_y'] = $wws['params']['2d_origin_y'];
									if(isset($wws['params']['pers'])) $def_val['pers'] = $wws['params']['pers'];
									
									if(isset($wws['params']['color'])){
										if(RevSliderFunctions::isrgb($wws['params']['color'])){
											$static_styles['color'] = RevSliderFunctions::rgba2hex($wws['params']['color']);
										}else{
											$static_styles['color'] = $wws['params']['color'];
										}
									}
									
									if(isset($wws['params']['font-weight'])) $static_styles['font-weight'] = $wws['params']['font-weight'];
									if(isset($wws['params']['font-size'])) $static_styles['font-size'] = $wws['params']['font-size'];
									if(isset($wws['params']['line-height'])) $static_styles['line-height'] = $wws['params']['line-height'];
									if(isset($wws['params']['font-family'])) $static_styles['font-family'] = $wws['params']['font-family'];
									
									if(isset($wws['advanced']) && isset($wws['advanced']['idle']) && is_array($wws['advanced']['idle']) && !empty($wws['advanced']['idle'])){
										$css_idle = '{'."\n";
										foreach($wws['advanced']['idle'] as $handle => $value){
											$value = implode(' ', $value);
											if($value !== '')
												$css_idle .= '	'.$key.': '.$value.';'."\n";
											
										}
										$css_idle .= '}'."\n";
									}
									
									if(isset($wws['hover']['color'])){
										if(RevSliderFunctions::isrgb($wws['hover']['color'])){
											$defh_val['color'] = RevSliderFunctions::rgba2hex($wws['hover']['color']);
										}else{
											$defh_val['color'] = $wws['hover']['color'];
										}
									}
									if(isset($wws['hover']['text-decoration'])) $defh_val['text-decoration'] = $wws['hover']['text-decoration'];
									if(isset($wws['hover']['background-color'])){
										if(RevSliderFunctions::isrgb($wws['hover']['background-color'])){
											$defh_val['background-color'] = RevSliderFunctions::rgba2hex($wws['hover']['background-color']);
										}else{
											$defh_val['background-color'] = $wws['hover']['background-color'];
										}
									}
									if(isset($wws['hover']['background-transparency'])){
										$defh_val['background-transparency'] = $wws['hover']['background-transparency'];
										if($defh_val['background-transparency'] > 1) $defh_val['background-transparency'] /= 100;
									}else{
										if(isset($wws['hover']['background-color'])) $defh_val['background-transparency'] = RevSliderFunctions::get_trans_from_rgba($wws['hover']['background-color'], true);
									}
									if(isset($wws['hover']['border-color'])){
										if(RevSliderFunctions::isrgb($wws['hover']['border-color'])){
											$defh_val['border-color'] = RevSliderFunctions::rgba2hex($wws['hover']['border-color']);
										}else{
											$defh_val['border-color'] = $wws['hover']['border-color'];
										}
									}
									if(isset($wws['hover']['border-style'])) $defh_val['border-style'] = $wws['hover']['border-style'];
									if(isset($wws['hover']['border-width'])) $defh_val['border-width'] = $wws['hover']['border-width'];
									if(isset($wws['hover']['border-radius'])){
										$raw_bor = $wws['hover']['border-radius'];
										if(!is_array($raw_bor)) $raw_bor = explode(' ', $raw_bor);
										
										switch(count($raw_bor)){
											case 1:
												$raw_bor = array($raw_bor[0], $raw_bor[0], $raw_bor[0], $raw_bor[0]);
											break;
											case 2:
												$raw_bor = array($raw_bor[0], $raw_bor[1], $raw_bor[0], $raw_bor[1]);
											break;
											case 3:
												$raw_bor = array($raw_bor[0], $raw_bor[1], $raw_bor[2], $raw_bor[1]);
											break;
										}
										
										$defh_val['border-radius'] = $raw_bor;
									}
									if(isset($wws['hover']['x'])) $defh_val['x'] = $wws['hover']['x'];
									if(isset($wws['hover']['y'])) $defh_val['y'] = $wws['hover']['y'];
									if(isset($wws['hover']['z'])) $defh_val['z'] = $wws['hover']['z'];
									if(isset($wws['hover']['skewx'])) $defh_val['skewx'] = $wws['hover']['skewx'];
									if(isset($wws['hover']['skewy'])) $defh_val['skewy'] = $wws['hover']['skewy'];
									if(isset($wws['hover']['scalex'])) $defh_val['scalex'] = $wws['hover']['scalex'];
									if(isset($wws['hover']['scaley'])) $defh_val['scaley'] = $wws['hover']['scaley'];
									if(isset($wws['hover']['opacity'])) $defh_val['opacity'] = $wws['hover']['opacity'];
									if(isset($wws['hover']['xrotate'])) $defh_val['xrotate'] = $wws['hover']['xrotate'];
									if(isset($wws['hover']['yrotate'])) $defh_val['yrotate'] = $wws['hover']['yrotate'];
									if(isset($wws['hover']['2d_rotation'])) $defh_val['2d_rotation'] = $wws['hover']['2d_rotation'];
									if(isset($wws['hover']['2d_origin_x'])) $defh_val['2d_origin_x'] = $wws['hover']['2d_origin_x'];
									if(isset($wws['hover']['2d_origin_y'])) $defh_val['2d_origin_y'] = $wws['hover']['2d_origin_y'];
									if(isset($wws['hover']['speed'])) $defh_val['speed'] = $wws['hover']['speed'];
									if(isset($wws['hover']['easing'])) $defh_val['easing'] = $wws['hover']['easing'];
									
									if(isset($wws['advanced']) && isset($wws['advanced']['hover']) && is_array($wws['advanced']['hover']) && !empty($wws['advanced']['hover'])){
										$css_hover = '{'."\n";
										foreach($wws['advanced']['hover'] as $handle => $value){
											$value = implode(' ', $value);
											if($value !== '')
												$css_hover .= '	'.$key.': '.$value.';'."\n";
											
										}
										$css_hover .= '}'."\n";
										
									}
									
									if(!isset($layers[$lk]['inline'])) $layers[$lk]['inline'] = array();
									if($css_idle !== ''){
										$layers[$lk]['inline']['idle'] = $css_idle;
									}
									if($css_hover !== ''){
										$layers[$lk]['inline']['idle'] = $css_hover;
									}
									
									$layers[$lk]['deformation'] = $def_val;
									$layers[$lk]['deformation-hover'] = $defh_val;
									$layers[$lk]['static_styles'] = $static_styles;
								}
							}
							
							$slide->setLayersRaw($layers);
							$slide->saveLayers();
						}
					}
				}
			}
		}
	}
	
	
	/**
	 * add settings to layer depending on how 
	 * @since 5.0
	 */
	public static function add_general_settings($sliders = false){
		
		$sr = new RevSlider();
		$sl = new RevSliderSlide();
		//$operations = new RevSliderOperations();
		if($sliders === false){ //do it on all Sliders
			$sliders = $sr->getArrSliders(false);
		}else{
			$sliders = array($sliders);
		}
		
		//$styles = $operations->getCaptionsContentArray();
		
		if(!empty($sliders) && is_array($sliders)){
			$fonts = get_option('tp-google-fonts', array());
			
			foreach($sliders as $slider){
				$settings = $slider->getSettings();
				$bg_freeze = $slider->getParam('parallax_bg_freeze', 'off');
				$google_fonts = $slider->getParam('google_font', array());
				
				if(!isset($settings['version']) || version_compare($settings['version'], 5.0, '<')){
					if(empty($google_fonts) && !empty($fonts)){ //add all punchfonts to the Slider
						foreach($fonts as $font){
							$google_fonts[] = $font['url'];
						}
						$slider->updateParam(array('google_font' => $google_fonts));
					}
					$settings['version'] = 5.0;
					$slider->updateSetting(array('version' => 5.0));
				}
				
				if($bg_freeze == 'on'){ //deprecated here, moved to slides so remove check here and add on to slides
					$slider->updateParam(array('parallax_bg_freeze' => 'off'));
				}
				
				$slides = $slider->getSlides();
				$staticID = $sl->getStaticSlideID($slider->getID());
				if($staticID !== false){
					$msl = new RevSliderSlide();
					if(strpos($staticID, 'static_') === false){
						$staticID = 'static_'.$slider->getID();
					}
					$msl->initByID($staticID);
					if($msl->getID() !== ''){
						$slides = array_merge($slides, array($msl));
					}
				}
				if(!empty($slides) && is_array($slides)){
					foreach($slides as $slide){
						
						if($bg_freeze == 'on'){ //set bg_freeze to on for slide settings
							$slide->setParam('slide_parallax_level', '1');
						}

						$slide->saveParams();
					}
				}
				
			}
		}
	}
	
	
	/**
	 * remove static slide from Sliders if the setting was set to off
	 * @since 5.0
	 */
	public static function remove_static_slides($sliders = false){
		
		$sr = new RevSlider();
		$sl = new RevSliderSlide();
		//$operations = new RevSliderOperations();
		if($sliders === false){ //do it on all Sliders
			$sliders = $sr->getArrSliders(false);
		}else{
			$sliders = array($sliders);
		}
		
		//$styles = $operations->getCaptionsContentArray();
		
		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				$settings = $slider->getSettings();
				$enable_static_layers = $slider->getParam('enable_static_layers', 'off');
				
				if($enable_static_layers == 'off'){
					$staticID = $sl->getStaticSlideID($slider->getID());
					if($staticID !== false){
						$slider->deleteStaticSlide();
					}
				}
				
			}
		}
	}
	
	
	/**
	 * change general settings of all sliders to 5.0.7
	 * @since 5.0.7
	 */
	public static function change_general_settings_5_0_7($sliders = false){
		//handle the new option for shuffle in combination with first alternative slide
		$sr = new RevSlider();
		$sl = new RevSliderSlide();
		//$operations = new RevSliderOperations();
		if($sliders === false){ //do it on all Sliders
			$sliders = $sr->getArrSliders(false);
		}else{
			$sliders = array($sliders);
		}
		
		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				$settings = $slider->getSettings();
				
				if(!isset($settings['version']) || version_compare($settings['version'], '5.0.7', '<')){
					$start_with_slide = $slider->getParam('start_with_slide', '1');
					
					if($start_with_slide !== '1'){
						$slider->updateParam(array('start_with_slide_enable' => 'on'));
					}
					
					$settings['version'] = '5.0.7';
					$slider->updateSetting(array('version' => '5.0.7'));
				}

			}
		}
	}
	
	
	/**
	 * change image id of all slides to 5.1.1
	 * @since 5.1.1
	 */
	public static function change_slide_settings_5_1_1($sliders = false){
		$sr = new RevSlider();
		$sl = new RevSliderSlide();
		//$operations = new RevSliderOperations();
		if($sliders === false){ //do it on all Sliders
			$sliders = $sr->getArrSliders(false);
		}else{
			$sliders = array($sliders);
		}
		
		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				$slides = $slider->getSlides();
				$staticID = $sl->getStaticSlideID($slider->getID());
				if($staticID !== false){
					$msl = new RevSliderSlide();
					if(strpos($staticID, 'static_') === false){
						$staticID = 'static_'.$slider->getID();
					}
					$msl->initByID($staticID);
					if($msl->getID() !== ''){
						$slides = array_merge($slides, array($msl));
					}
				}
				
				if(!empty($slides) && is_array($slides)){
					foreach($slides as $slide){
						//get image url, then get the image id and save it in image_id
						
						$image_id = $slide->getParam('image_id', '');
						$image = $slide->getParam('image', '');
						
						$ml_id = '';
						if($image !== ''){
							$ml_id = RevSliderFunctionsWP::get_image_id_by_url($image);
						}
						if($image == '' && $image_id == '') continue; //if we are a video and have no cover image, do nothing
						
						if($ml_id !== false && $ml_id !== $image_id){
							$urlImage = wp_get_attachment_image_src($ml_id, 'full');

							$slide->setParam('image_id', $ml_id);
							$slide->saveParams();
						}
						
					}
				}

			}
		}
	}
	
	
	/**
	 * change svg path of all layers from the upload folder if 5.2.5.3+ was installed
	 * @since 5.2.5.5
	 */
	public static function change_layers_svg_5_2_5_5($sliders = false){
		$sr = new RevSlider();
		$sl = new RevSliderSlide();
		$upload_dir = wp_upload_dir();
		$path = $upload_dir['baseurl'].'/revslider/assets/svg/';
		
		//$operations = new RevSliderOperations();
		if($sliders === false){ //do it on all Sliders
			$sliders = $sr->getArrSliders(false);
		}else{
			$sliders = array($sliders);
		}
		
		if(!empty($sliders) && is_array($sliders)){
			foreach($sliders as $slider){
				$slides = $slider->getSlides();
				$staticID = $sl->getStaticSlideID($slider->getID());
				if($staticID !== false){
					$msl = new RevSliderSlide();
					if(strpos($staticID, 'static_') === false){
						$staticID = 'static_'.$slider->getID();
					}
					$msl->initByID($staticID);
					if($msl->getID() !== ''){
						$slides = array_merge($slides, array($msl));
					}
				}
				
				if(!empty($slides) && is_array($slides)){
					foreach($slides as $slide){
						$layers = $slide->getLayers();
						if(!empty($layers) && is_array($layers)){
							foreach($layers as $lk => $layer){
								if(isset($layer['type']) && $layer['type'] == 'svg'){
									if(isset($layer['svg']) && isset($layer['svg']->src)){
										//change newer path to older path
										if(strpos($layers[$lk]['svg']->src, $path) !== false){
											
											$layers[$lk]['svg']->src = str_replace($path, RS_PLUGIN_URL . 'public/assets/assets/svg/', $layers[$lk]['svg']->src);
										}
									}
								}
							}
							
							$slide->setLayersRaw($layers);
							$slide->saveLayers();
						}
					}
				}
			}
		}
	}
	
}

/**
 * old classname extends new one (old classnames will be obsolete soon)
 * @since: 5.0
 **/
class UnitePluginUpdateRev extends RevSliderPluginUpdate {}
?>