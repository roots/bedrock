<?php

/**
 * JackBox WordPress Plugin Extension
 * @url: http://codecanyon.net/item/jackbox-responsive-lightbox-wordpress-plugin/3357551
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 * @since: 2.0
 **/

if( !defined( 'ABSPATH') ) exit();

class Essential_Grid_Jackbox {
	
	/**
	 * Check if JackBox is activated and at least version 2.2 is installed
	 **/
	public static function jb_exists(){
		$exists = false;
		
		//if(is_plugin_active("wp-jackbox/wp-jackbox.php")){
		if(function_exists('jackbox_admin_link')){
			if(is_admin()){
				$data = get_plugin_data(WP_PLUGIN_DIR."/wp-jackbox/wp-jackbox.php", false);
				update_option('tp_eg_jackbox_version', $data['Version']);
				$version =  $data['Version'];
			}else{
				$version =  get_option('tp_eg_jackbox_version', '0');
			}
			
			$exists = true;
		}
		
		return apply_filters('essgrid_jb_exists', $exists);
	}
	
	
	/**
	 * Enable JackBox by adding Essential Grid to the Options of JackBox. JB will handle the rest
	 **/
	public static function enable_jackbox(){
		if(!self::jb_exists()) return false;
		
		$jackbox_options = get_option('jackbox_settings');
		
		if($jackbox_options){
			$jackbox_options['essential'] = 'yes';
		}
		
		update_option("jackbox_settings", apply_filters('essgrid_enable_jackbox', $jackbox_options));
	}
	
	
	/**
	 * Disable JackBox by removing Essential Grid from the Options of JackBox. JB will handle the rest
	 **/
	public static function disable_jackbox(){
		if(!self::jb_exists()) return false;
		
		$jackbox_options = get_option('jackbox_settings');
		
		if($jackbox_options){
			$jackbox_options['essential'] = 'no';
		}
		
		update_option("jackbox_settings", apply_filters('essgrid_disable_jackbox', $jackbox_options));
	}
	
	
	/**
	 * Check if JackBox is active in the Essential Grid Global options
	 **/
	public static function is_active(){
		$active = false;
		if(self::jb_exists()){
			$opt = get_option('tp_eg_use_lightbox', 'false');
			if($opt === 'jackbox') $active = true;
		}
		
		return apply_filters('essgrid_is_active', $active);
	}
	
}
	
?>