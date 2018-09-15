<?php
/*
Plugin Name: Slider Revolution
Plugin URI: http://revolution.themepunch.com/
Description: Slider Revolution - Premium responsive slider
Author: ThemePunch
Version: 5.3.0.2
Author URI: http://themepunch.com
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if(class_exists('RevSliderFront')) {
	die('ERROR: It looks like you have more than one instance of Slider Revolution installed. Please remove additional instances for this plugin to work again.');
}

$revSliderVersion = "5.3.0.2";
$revSliderAsTheme = false;
$revslider_screens = array();
$revslider_fonts = array();

$rs_plugin_url = str_replace('index.php','',plugins_url( 'index.php', __FILE__ ));
if(strpos($rs_plugin_url, 'http') === false) {
	$site_url = get_site_url();
	$rs_plugin_url = (substr($site_url, -1) === '/') ? substr($site_url, 0, -1). $rs_plugin_url : $site_url. $rs_plugin_url;
}

define( 'RS_PLUGIN_PATH', plugin_dir_path(__FILE__) );
define( 'RS_PLUGIN_FILE_PATH', __FILE__ );
define( 'RS_PLUGIN_URL', $rs_plugin_url);

define( 'RS_DEMO', false );

if(isset($_GET['revSliderAsTheme'])){
	if($_GET['revSliderAsTheme'] == 'true'){
		update_option('revSliderAsTheme', 'true');
	}else{
		update_option('revSliderAsTheme', 'false');
	}
}

//set the RevSlider Plugin as a Theme. This hides the activation notice and the activation area in the Slider Overview
function set_revslider_as_theme(){
	global $revSliderAsTheme;
	
	if(defined('REV_SLIDER_AS_THEME')){
		if(REV_SLIDER_AS_THEME == true)
			$revSliderAsTheme = true;
	}else{
		if(get_option('revSliderAsTheme', 'true') == 'true')
			$revSliderAsTheme = true;
	}
}

//include frameword files
require_once(RS_PLUGIN_PATH . 'includes/framework/include-framework.php');

//include bases
require_once($folderIncludes . 'base.class.php');
require_once($folderIncludes . 'elements-base.class.php');
require_once($folderIncludes . 'base-admin.class.php');
require_once($folderIncludes . 'base-front.class.php');

//include product files
require_once(RS_PLUGIN_PATH . 'includes/globals.class.php');
require_once(RS_PLUGIN_PATH . 'includes/operations.class.php');
require_once(RS_PLUGIN_PATH . 'includes/slider.class.php');
require_once(RS_PLUGIN_PATH . 'includes/output.class.php');
require_once(RS_PLUGIN_PATH . 'includes/slide.class.php');
require_once(RS_PLUGIN_PATH . 'includes/widget.class.php');
require_once(RS_PLUGIN_PATH . 'includes/navigation.class.php');
require_once(RS_PLUGIN_PATH . 'includes/object-library.class.php');
require_once(RS_PLUGIN_PATH . 'includes/template.class.php');
require_once(RS_PLUGIN_PATH . 'includes/external-sources.class.php');
require_once(RS_PLUGIN_PATH . 'includes/page-template.class.php');

require_once(RS_PLUGIN_PATH . 'includes/tinybox.class.php');
require_once(RS_PLUGIN_PATH . 'includes/extension.class.php');
require_once(RS_PLUGIN_PATH . 'public/revslider-front.class.php');

try{
	//register the revolution slider widget
	RevSliderFunctionsWP::registerWidget("RevSliderWidget");

	//add shortcode
	function rev_slider_shortcode($args, $mid_content = null){
		
        extract(shortcode_atts(array('alias' => ''), $args, 'rev_slider'));
		extract(shortcode_atts(array('settings' => ''), $args, 'rev_slider'));
		extract(shortcode_atts(array('order' => ''), $args, 'rev_slider'));
		
		if($settings !== '') $settings = json_decode(str_replace(array('({', '})', "'"), array('[', ']', '"'), $settings) ,true);
		if($order !== '') $order = explode(',', $order);
		
        $sliderAlias = ($alias != '') ? $alias : RevSliderFunctions::getVal($args,0);
		
		$gal_ids = RevSliderFunctionsWP::check_for_shortcodes($mid_content); //check for example on gallery shortcode and do stuff
		
		ob_start();
		if(!empty($gal_ids)){ //add a gallery based slider
			$slider = RevSliderOutput::putSlider($sliderAlias, '', $gal_ids);
		}else{
			$slider = RevSliderOutput::putSlider($sliderAlias, '', array(), $settings, $order);
		}
		$content = ob_get_contents();
		ob_clean();
		ob_end_clean();
		
		if(!empty($slider)){
			// Do not output Slider if we are on mobile
			$disable_on_mobile = $slider->getParam("disable_on_mobile","off");
			if($disable_on_mobile == 'on'){
				$mobile = (strstr($_SERVER['HTTP_USER_AGENT'],'Android') || strstr($_SERVER['HTTP_USER_AGENT'],'webOS') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') ||strstr($_SERVER['HTTP_USER_AGENT'],'iPod') || strstr($_SERVER['HTTP_USER_AGENT'],'iPad') || strstr($_SERVER['HTTP_USER_AGENT'],'Windows Phone') || wp_is_mobile()) ? true : false;
				if($mobile) return false;
			}
			
			$show_alternate = $slider->getParam("show_alternative_type","off");
			
			if($show_alternate == 'mobile' || $show_alternate == 'mobile-ie8'){
				if(strstr($_SERVER['HTTP_USER_AGENT'],'Android') || strstr($_SERVER['HTTP_USER_AGENT'],'webOS') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') ||strstr($_SERVER['HTTP_USER_AGENT'],'iPod') || strstr($_SERVER['HTTP_USER_AGENT'],'iPad') || strstr($_SERVER['HTTP_USER_AGENT'],'Windows Phone') || wp_is_mobile()){
					$show_alternate_image = $slider->getParam("show_alternate_image","");
					return '<img class="tp-slider-alternative-image" src="'.$show_alternate_image.'" data-no-retina>';
				}
			}
		
			//handle slider output types
			$outputType = $slider->getParam("output_type","");
			switch($outputType){
				case "compress":
					$content = str_replace("\n", "", $content);
					$content = str_replace("\r", "", $content);
					return($content);
				break;
				case "echo":
					echo $content; //bypass the filters
				break;
				default:
					return($content);
				break;
			}
		}else
			return($content); //normal output

	}

	add_shortcode( 'rev_slider', 'rev_slider_shortcode' );
	
	/**
	 * Call Extensions
	 */
	$revext = new RevSliderExtension();
	
	add_action('plugins_loaded', array( 'RevSliderTinyBox', 'visual_composer_include' )); //VC functionality
	add_action('plugins_loaded', array( 'RevSliderPageTemplate', 'get_instance' ));
	
	if(is_admin()){ //load admin part
	
		require_once(RS_PLUGIN_PATH . 'includes/framework/update.class.php');
		require_once(RS_PLUGIN_PATH . 'includes/framework/newsletter.class.php');
		require_once(RS_PLUGIN_PATH . 'admin/revslider-admin.class.php');

		$productAdmin = new RevSliderAdmin(RS_PLUGIN_FILE_PATH);
		
		//add tiny box dropdown menu
		add_action('admin_head', array('RevSliderTinyBox', 'add_tinymce_editor'));
		
		
	}else{ //load front part

		/**
		 *
		 * put rev slider on the page.
		 * the data can be slider ID or slider alias.
		 */
		function putRevSlider($data,$putIn = ""){
			$operations = new RevSliderOperations();
			$arrValues = $operations->getGeneralSettingsValues();
			$includesGlobally = RevSliderFunctions::getVal($arrValues, "includes_globally","on");
			$strPutIn = RevSliderFunctions::getVal($arrValues, "pages_for_includes");
			$isPutIn = RevSliderOutput::isPutIn($strPutIn,true);
			if($isPutIn == false && $includesGlobally == "off"){
				$output = new RevSliderOutput();
				$option1Name = __("Include RevSlider libraries globally (all pages/posts)", 'revslider');
				$option2Name = __("Pages to include RevSlider libraries", 'revslider');
				$output->putErrorMessage(__("If you want to use the PHP function \"putRevSlider\" in your code please make sure to check \" ",'revslider').$option1Name.__(" \" in the backend's \"General Settings\" (top right panel). <br> <br> Or add the current page to the \"",'revslider').$option2Name.__("\" option box.", 'revslider'));
				return(false);
			}
			
			
			ob_start();
			$slider = RevSliderOutput::putSlider($data,$putIn);
			$content = ob_get_contents();
			ob_clean();
			ob_end_clean();
			
			if(is_object($slider)){
				$disable_on_mobile = @$slider->getParam("disable_on_mobile","off"); // Do not output Slider if we are on mobile
				if($disable_on_mobile == 'on'){
					$mobile = (strstr($_SERVER['HTTP_USER_AGENT'],'Android') || strstr($_SERVER['HTTP_USER_AGENT'],'webOS') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') ||strstr($_SERVER['HTTP_USER_AGENT'],'iPod') || strstr($_SERVER['HTTP_USER_AGENT'],'Windows Phone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPad') || wp_is_mobile()) ? true : false;
					if($mobile) return false;
				}
			}
			
			echo $content;
		}


		/**
		 *
		 * put rev slider on the page.
		 * the data can be slider ID or slider alias.
		 */
		function checkRevSliderExists($alias){
            $rev = new RevSlider();
            return $rev->isAliasExists($alias);
		}

		$productFront = new RevSliderFront(RS_PLUGIN_FILE_PATH);
	}
	
	add_action('plugins_loaded', array( 'RevSliderFront', 'createDBTables' )); //add update checks
	add_action('plugins_loaded', array( 'RevSliderPluginUpdate', 'do_update_checks' )); //add update checks
	
}catch(Exception $e){
	$message = $e->getMessage();
	$trace = $e->getTraceAsString();
	echo _e("Revolution Slider Error:",'revslider')." <b>".$message."</b>";
}

?>