<?php
// BSF CORE commom functions
if(!function_exists('bsf_get_option')) {
	function bsf_get_option($request = false) {
		$bsf_options = get_option('bsf_options');
		if(!$request)
			return $bsf_options;
		else
			return (isset($bsf_options[$request])) ? $bsf_options[$request] : false;
	}
}
if(!function_exists('bsf_update_option')) {
	function bsf_update_option($request, $value) {
		$bsf_options = get_option('bsf_options');
		$bsf_options[$request] = $value;
		return update_option('bsf_options', $bsf_options);
	}
}
add_action( 'wp_ajax_bsf_dismiss_notice', 'bsf_dismiss_notice');
if(!function_exists('bsf_dismiss_notice')) {
	function bsf_dismiss_notice() {
		$notice = $_POST['notice'];
		$x = bsf_update_option($notice, true);
		echo ($x) ? true : false;
		die();
	}
}

add_action('admin_init', 'bsf_core_check',10);
if(!function_exists('bsf_core_check')) {
	function bsf_core_check() {
		if(!defined('BSF_CORE')) {
			if(!bsf_get_option('hide-bsf-core-notice'))
				add_action( 'admin_notices', 'bsf_core_admin_notice' );
		}
	}
}

if(!function_exists('bsf_core_admin_notice')) {
	function bsf_core_admin_notice() {
		?>
		<script type="text/javascript">
		(function($){
			$(document).ready(function(){
				$(document).on( "click", ".bsf-notice", function() {
					var bsf_notice_name = $(this).attr("data-bsf-notice");
				    $.ajax({
				        url: ajaxurl,
				        method: 'POST',
				        data: {
				            action: "bsf_dismiss_notice",
				            notice: bsf_notice_name
				        },
				        success: function(response) {
				        	console.log(response);
				        }
				    })
				})
			});
		})(jQuery);
		</script>
		<div class="bsf-notice update-nag notice is-dismissible" data-bsf-notice="hide-bsf-core-notice">
            <p><?php _e( 'License registration and extensions are not part of plugin/theme anymore. Kindly download and install "BSF CORE" plugin to manage your licenses and extensins.', 'bsf' ); ?></p>
        </div>
		<?php
	}
}

if(isset($_GET['hide-bsf-core-notice']) && $_GET['hide-bsf-core-notice'] === 're-enable') {
	$x = bsf_update_option('hide-bsf-core-notice', false);
}

// end of common functions

if(!class_exists('Ultimate_Admin_Area')){
	class Ultimate_Admin_Area{
		function __construct(){
			if($_SERVER['HTTP_HOST'] !== 'localhost' && $_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1'){
				//add_action( 'admin_notices', array( $this, 'display_notice' ) );
				//add_action( 'plugins_loaded', array($this, 'check_for_update') );
				//add_action( 'in_plugin_update_message-Ultimate_VC_Addons/Ultimate_VC_Addons.php', array($this,'addUltimateUpgradeLink'));
			}
			/* add admin menu */
			add_action( 'admin_menu', array($this,'register_brainstorm_menu'),99);
			//add_action( 'network_admin_menu', array( $this, 'register_brainstorm_network_menu' ) );

			add_action('admin_enqueue_scripts', array($this, 'bsf_admin_scripts_updater'), 1);
			add_action( 'wp_ajax_update_ultimate_options', array($this,'update_settings'));
			add_action( 'wp_ajax_update_ultimate_debug_options', array($this,'update_debug_settings'));
			add_action( 'wp_ajax_update_ultimate_modules', array($this,'update_modules'));
			add_action( 'wp_ajax_update_css_options', array($this,'update_css_options'));
			add_action( 'wp_ajax_update_dev_notes', array($this,'update_dev_notes'));
			add_filter('update_footer', array($this, 'debug_link'),999);
		}

		function debug_link($text) {
			$screen = get_current_screen();
			$array = array(
				'ultimate_page_ultimate-scripts-and-styles',
				'ultimate_page_ultimate-smoothscroll',
				'ultimate_page_ultimate-dashboard',
				'toplevel_page_about-ultimate'
			);
			if(!in_array($screen->id, $array))
				return $text;
			$url = admin_url('admin.php?page=ultimate-debug-settings');
			$link = '<a href="'.$url.'">Ultimate Addons Debug Settings</a>';
			$text = $link.' | '.$text;
			return $text;
		}

		function bsf_admin_scripts_updater($hook){
			if(defined('OPN_VERSION')) {
				echo "<style>
					@font-face {
						font-family: 'opn';
						src:url('".plugins_url( 'fonts/opn.eot', __FILE__ )."');
						src:url('".plugins_url( 'fonts/opn.eot', __FILE__ )."') format('embedded-opentype'),
							url('".plugins_url( 'fonts/opn.woff', __FILE__ )."') format('woff'),
							url('".plugins_url( 'fonts/opn.ttf', __FILE__ )."') format('truetype'),
							url('".plugins_url( 'fonts/opn.svg', __FILE__ )."') format('svg');
						font-weight: normal;
						font-style: normal;
					}
					.toplevel_page_opn-settings > div.wp-menu-image:before {
						content: \"\\e600\" !important;
						font-family: 'opn' !important;
					}
				</style>";
			}
			echo "
				<style>
					@font-face {
						font-family: 'ultimate';
						src:url('".plugins_url( 'fonts/ultimate.eot', __FILE__ )."');
						src:url('".plugins_url( 'fonts/ultimate.eot', __FILE__ )."') format('embedded-opentype'),
							url('".plugins_url( 'fonts/ultimate.woff', __FILE__ )."') format('woff'),
							url('".plugins_url( 'fonts/ultimate.ttf', __FILE__ )."') format('truetype'),
							url('".plugins_url( 'fonts/ultimate.svg', __FILE__ )."') format('svg');
						font-weight: normal;
						font-style: normal;
					}
					.toplevel_page_about-ultimate > div.wp-menu-image:before {
						content: \"\\e600\" !important;
						font-family: 'ultimate' !important;
						speak: none;
						font-style: normal;
						font-weight: normal;
						font-variant: normal;
						text-transform: none;
						line-height: 1;
						-webkit-font-smoothing: antialiased;
						-moz-osx-font-smoothing: grayscale;
						font-size:24px;
					}
					.toplevel_page_about-ultimate a[href=\"admin.php?page=font-icon-Manager\"] {
					    display: none !important;
					}
					.toplevel_page_about-ultimate a[href=\"admin.php?page=ultimate-font-manager\"] {
					    display: none !important;
					}
				</style>
			";
			if($hook == "post.php" ||
				$hook == "post-new.php" ||
				$hook == 'ultimate_page_about-ultimate' ||
				$hook == 'visual-composer_page_vc-roles' ||
				$hook == 'toplevel_page_about-ultimate' ||
				$hook == 'ultimate_page_ultimate-dashboard' ||
				$hook == 'ultimate_page_ultimate-smoothscroll' ||
				$hook == 'ultimate_page_ultimate-scripts-and-styles' ||
				$hook == 'admin_page_ultimate-debug-settings' ||
				$hook == 'ultimate_page_bsf-google-maps' ){

				$bsf_dev_mode = bsf_get_option('dev_mode');

				wp_register_style("ultimate-admin-style",plugins_url("../admin/css/style.css",__FILE__));

				wp_register_style("ultimate-chosen-style",plugins_url('../admin/vc_extend/css/chosen.css', __FILE__ ));
				wp_register_script("ultimate-chosen-script",plugins_url("../admin/vc_extend/js/chosen.js",__FILE__));

				wp_register_script("ultimate-vc-backend-script",plugins_url("../admin/js/ultimate-vc-backend.min.js",__FILE__),array('jquery'),ULTIMATE_VERSION,true);
				wp_register_style("ultimate-vc-backend-style",plugins_url('../admin/css/ultimate-vc-backend.min.css', __FILE__ ));

				if($bsf_dev_mode === 'enable') {
					wp_enqueue_style('ultimate-admin-style');
				}
				else {
					wp_enqueue_style( 'wp-color-picker' );
					wp_enqueue_script('ultimate-vc-backend-script');
					wp_enqueue_style('ultimate-vc-backend-style');
				}
			}
		}/* end admin_scripts */

		function register_brainstorm_menu(){
			$role = $this->can_access_admin();
			if($role == false)
				return;

			global $submenu;
			if(defined('BSF_MENU_POS'))
				$required_place = BSF_MENU_POS;
			else
				$required_place = 200;

			if(function_exists('bsf_get_free_menu_position'))
				$place = bsf_get_free_menu_position($required_place,1);
			else
				$place = null;

			$page = add_menu_page(
				'Ultimate',
				'Ultimate',
				$role,
				'about-ultimate',
				array($this,'load_about'),
				'', $place );

			add_submenu_page(
				"about-ultimate",
				__("Modules","ultimate_vc"),
				__("Modules","ultimate_vc"),
				$role,
				"ultimate-dashboard",
				array($this,'load_modules')
			);

			add_submenu_page(
				"about-ultimate",
				__("Smooth Scroll","ultimate_vc"),
				__("Smooth Scroll","ultimate_vc"),
				$role,
				"ultimate-smoothscroll",
				array($this,'load_smoothscroll')
			);

			add_submenu_page(
				"about-ultimate",
				__("Scripts & Styles","ultimate_vc"),
				__("Scripts & Styles","ultimate_vc"),
				$role,
				"ultimate-scripts-and-styles",
				array($this,'load_scripts_styles')
			);

			add_submenu_page(
				"NOATTACH",
				__("Debug","ultimate_vc"),
				__("Debug","ultimate_vc"),
				$role,
				"ultimate-debug-settings",
				array($this,'load_debug_settings')
			);

			//	Add sub-menu for OPN if OPN in installed - {One Page Navigator}.
			if( defined('OPN_VERSION') ){
				if(defined('BSF_MENU_POS'))
					$required_place = BSF_MENU_POS;
				else
					$required_place = 200;

				if(function_exists('bsf_get_free_menu_position'))
					$place = bsf_get_free_menu_position($required_place,1);
				else
					$place = null;

				$page = add_menu_page(
					'OPN',
					'OPN',
					'administrator',
					'opn-settings',
					array($this,'load_opn'),
					'dashicons-admin-generic',
					$place );
			}

			$resources_page = add_submenu_page(
				"about-ultimate",
				__("Resources","ultimate_vc"),
				__("Resources","ultimate_vc"),
				$role,
				"ultimate-resources",
				array($this, 'ultimate_resources')
			);

			// section wise menu
			global $bsf_section_menu;
			$section_menu = array(
				'menu' => 'ultimate-resources',
				'is_down_arrow' => true
			);
			$bsf_section_menu[] = $section_menu;

			$icon_manager_page = add_submenu_page(
				"about-ultimate",
				__("Icon Manager","ultimate_vc"),
				__("Icon Manager","ultimate_vc"),
				$role,
				"bsf-font-icon-manager",
				array($this, 'ultimate_icon_manager_menu')
			);

			$AIO_Icon_Manager = new AIO_Icon_Manager;
			add_action( 'admin_print_scripts-' . $icon_manager_page, array($AIO_Icon_Manager,'admin_scripts'));

			$Ultimate_Google_Font_Manager = new Ultimate_Google_Font_Manager;
			$google_font_manager_page = add_submenu_page(
				"about-ultimate",
				__("Google Font Manager","ultimate_vc"),
				__("Google Fonts","ultimate_vc"),
				$role,
				"bsf-google-font-manager",
				array($Ultimate_Google_Font_Manager,'ultimate_font_manager_dashboard')
			);
			add_action( 'admin_print_scripts-' . $google_font_manager_page, array($Ultimate_Google_Font_Manager,'admin_google_font_scripts'));

			$google_font_manager_page = add_submenu_page(
				"about-ultimate",
				__("Google Maps","ultimate_vc"),
				__("Google Maps","ultimate_vc"),
				$role,
				"bsf-google-maps",
				array($this,'ultimate_google_maps_dashboard')
			);

			// must be at end of all sub menu


			$submenu['about-ultimate'][0][0] = __("About","ultimate_vc");
		}
		function load_opn(){
			if(class_exists('OPN_Navigator')) {
				$OPN_Navigator = new OPN_Navigator;
				$OPN_Navigator->opn_settings();
			}
		}
		function ultimate_icon_manager_menu(){
			$AIO_Icon_Manager = new AIO_Icon_Manager;
			$AIO_Icon_Manager->icon_manager_dashboard();
		}
		function load_modules(){
			require_once(plugin_dir_path(__FILE__).'/modules.php');
		}

		function load_dashboard(){
			require_once(plugin_dir_path(__FILE__).'/dashboard.php');
		}

		function load_about() {
			require_once(plugin_dir_path(__FILE__).'/about.php');
		}

		function load_smoothscroll() {
			require_once(plugin_dir_path(__FILE__).'/smooth-scroll-setting.php');
		}

		function load_scripts_styles() {
			require_once(plugin_dir_path(__FILE__).'/script-styles.php');
		}

		function load_debug_settings() {
			require_once(plugin_dir_path(__FILE__).'/debug.php');
		}

		function ultimate_resources() {
			$connects = false;
			require_once(plugin_dir_path(__FILE__).'/resources.php');
		}

		function ultimate_google_maps_dashboard() {
			require_once(plugin_dir_path(__FILE__).'/map-settings.php');
		}

		function update_modules(){
			if(isset($_POST['ultimate_row'])){
				$ultimate_row = $_POST['ultimate_row'];
			} else {
				$ultimate_row = 'disable';
			}
			$result1 = update_option('ultimate_row',$ultimate_row);

			$ultimate_modules = array();
			if(isset($_POST['ultimate_modules'])){
				$ultimate_modules = $_POST['ultimate_modules'];
			}
			$result2 = update_option('ultimate_modules',$ultimate_modules);

			if($result1 || $result2 ){
				echo 'success';
			} else {
				echo 'failed';
			}
			die();
		}

		function can_access_admin() {
			$bsf_ultimate_roles = bsf_get_option('ultimate_roles');
			if($bsf_ultimate_roles == false || empty($bsf_ultimate_roles)) {
				$bsf_ultimate_roles = array( 'administrator' );
			}

			if(!in_array('administrator', $bsf_ultimate_roles))
				array_push($bsf_ultimate_roles, 'administrator');

			$user = wp_get_current_user();
			$user_role = $user->roles[0];

			if(in_array($user_role, $bsf_ultimate_roles)) {
				return $user_role;
			}
			return false;
		}

		function update_debug_settings(){
			if(isset($_POST['ultimate_video_fixer'])){
				$ultimate_video_fixer = $_POST['ultimate_video_fixer'];
			} else {
				$ultimate_video_fixer = 'disable';
			}
			$result1 = update_option('ultimate_video_fixer',$ultimate_video_fixer);

			if(isset($_POST['ultimate_ajax_theme'])){
				$ultimate_ajax_theme = $_POST['ultimate_ajax_theme'];
			} else {
				$ultimate_ajax_theme = 'disable';
			}
			$result2 = update_option('ultimate_ajax_theme',$ultimate_ajax_theme);

			if(isset($_POST['ultimate_custom_vc_row'])){
				$ultimate_custom_vc_row = $_POST['ultimate_custom_vc_row'];
			} else {
				$ultimate_custom_vc_row = 'disable';
			}
			$result3 = update_option('ultimate_custom_vc_row',$ultimate_custom_vc_row);

			if(isset($_POST['ultimate_theme_support'])){
				$ultimate_theme_support = $_POST['ultimate_theme_support'];
			} else {
				$ultimate_theme_support = 'disable';
			}
			$result4 = update_option('ultimate_theme_support',$ultimate_theme_support);

			if(isset($_POST['ultimate_rtl_support'])){
				$ultimate_rtl_support = $_POST['ultimate_rtl_support'];
			} else {
				$ultimate_rtl_support = 'disable';
			}
			$result5 = update_option('ultimate_rtl_support',$ultimate_rtl_support);

			if(isset($_POST['ultimate_modal_fixer'])){
				$ultimate_modal_fixer = $_POST['ultimate_modal_fixer'];
			} else {
				$ultimate_modal_fixer = 'disable';
			}
			$result6 = update_option('ultimate_modal_fixer',$ultimate_modal_fixer);

			$result7 = $result8 = false;

			$bsf_options_array = array('dev_mode', 'ultimate_global_scripts', 'ultimate_roles');
			$check_update_option_7 = $check_update_option_8 = false;

			if(isset($_POST['bsf_options'])){
				$bsf_options_keys = array_keys($_POST['bsf_options']);

				$bsf_options_array = array_diff($bsf_options_array, $bsf_options_keys);

				foreach ($_POST['bsf_options'] as $key => $value) {
					$result7 = bsf_update_option($key, $value);
					if($result7)
						$check_update_option_7 = true;
				}
			}

			foreach ($bsf_options_array as $key => $key_value) {
				$result8 = bsf_update_option($key_value, '');
				if($result8)
					$check_update_option_8 = true;
				$result8 = true;
			}

			if(isset($_POST['ultimate_smooth_scroll_compatible'])){
				$ultimate_smooth_scroll_compatible = $_POST['ultimate_smooth_scroll_compatible'];
			} else {
				$ultimate_smooth_scroll_compatible = 'disable';
			}
			$result9 = update_option('ultimate_smooth_scroll_compatible',$ultimate_smooth_scroll_compatible);

			if(isset($_POST['ultimate_animation'])){
				$ultimate_animation = $_POST['ultimate_animation'];
			} else {
				$ultimate_animation = 'disable';
			}
			$result10 = update_option('ultimate_animation',$ultimate_animation);



			if($result1 || $result2 || $result3 || $result4 || $result5 || $result6 || $result7 || $result8 || $result9 || $result10){
				echo 'success';
			} else {
				echo 'failed';
			}

			die();
		}

		function update_settings(){

			if(isset($_POST['ultimate_smooth_scroll'])){
				$ultimate_smooth_scroll = $_POST['ultimate_smooth_scroll'];
			} else {
				$ultimate_smooth_scroll = 'disable';
			}
			$result1 = update_option('ultimate_smooth_scroll',$ultimate_smooth_scroll);

			if(isset($_POST['ultimate_smooth_scroll_options'])){
				$ultimate_smooth_scroll_options = $_POST['ultimate_smooth_scroll_options'];
			} else {
				$ultimate_smooth_scroll_options = '';
			}
			$result2 = update_option('ultimate_smooth_scroll_options',$ultimate_smooth_scroll_options);

			if($result1 || $result2){
				echo 'success';
			} else {
				echo 'failed';
			}
			die();
		}

		function update_css_options(){
			if(isset($_POST['ultimate_css'])){
				$ultimate_css = $_POST['ultimate_css'];
			} else {
				$ultimate_css = 'disable';
			}
			$result1 = update_option('ultimate_css',$ultimate_css);
			if(isset($_POST['ultimate_js'])){
				$ultimate_js = $_POST['ultimate_js'];
			} else {
				$ultimate_js = 'disable';
			}
			$result2 = update_option('ultimate_js',$ultimate_js);
			if($result1 || $result2){
				echo 'success';
			} else {
				echo 'failed';
			}
			die();
		}

		/*
		* Display admin notices for plugin activation
		*/
		function display_notice(){
			global $hook_suffix;
			$status = "not-activated";
			$ultimate_keys = get_option('ultimate_keys');
			$username = $ultimate_keys['envato_username'];
			$api_key =  $ultimate_keys['envato_api_key'];
			$purchase_code =  $ultimate_keys['ultimate_purchase_code'];
			$user_email = (isset($ultimate_keys['ultimate_user_email'])) ? $ultimate_keys['ultimate_user_email'] : '';

			$activation_check = get_option('ultimate_license_activation');

			if(false === ( get_transient( 'ultimate_license_activation' ) )){
				if(!empty($activation_check)){
					$get_activation_data = check_license_activation($purchase_code, $username, $user_email);
					$activation_check_temp = json_decode($get_activation_data);
					$val = array(
						'response' => $activation_check_temp->response,
						'status' => $activation_check_temp->status,
						'code' => $activation_check_temp->code
					);
					update_option('ultimate_license_activation', $val);
					delete_transient( 'ultimate_license_activation' );
					set_transient( "ultimate_license_activation", true, 60*60*12);
				}
			}

			$activation_check = get_option('ultimate_license_activation');
			$ultimate_constants = get_option('ultimate_constants');
			$builtin = get_option('ultimate_updater');

			if($activation_check !== ''){
				$status = isset($activation_check['status']) ? $activation_check['status'] : "not-activated";
				$code = $activation_check['code'];
			}

			if($status == "Deactivated" || $status == "not-activated" || $status == "not-verified"){
				if ( $hook_suffix == 'plugins.php' ){
					if( $builtin === 'disabled' || $ultimate_constants['ULTIMATE_NO_PLUGIN_PAGE_NOTICE'] === true || (is_multisite() == true && is_main_site() == false))
						$hide_notice = true;
					else
						$hide_notice = false;
					$reg_link = (is_multisite()) ? network_admin_url('index.php?page=bsf-dashboard') : admin_url('index.php?page=bsf-dashboard');

					if(!$hide_notice) :
					?>
                        <div class="updated" style="padding: 0; margin: 0; border: none; background: none;">
                            <style type="text/css">
                        .ult_activate{min-width:825px;background: #FFF;border:1px solid #0096A3;padding:5px;margin:15px 0;border-radius:3px;-webkit-border-radius:3px;position:relative;overflow:hidden}
                        .ult_activate .ult_a{position:absolute;top:5px;right:10px;font-size:48px;}
                        .ult_activate .ult_button{font-weight:bold;border:1px solid #029DD6;border-top:1px solid #06B9FD;font-size:15px;text-align:center;padding:9px 0 8px 0;color:#FFF;background:#029DD6;-moz-border-radius:2px;border-radius:2px;-webkit-border-radius:2px}
                        .ult_activate .ult_button:hover{text-decoration:none !important;border:1px solid #029DD6;border-bottom:1px solid #00A8EF;font-size:15px;text-align:center;padding:9px 0 8px 0;color:#F0F8FB;background:#0079B1;-moz-border-radius:2px;border-radius:2px;-webkit-border-radius:2px}
                        .ult_activate .ult_button_border{border:1px solid #0096A3;-moz-border-radius:2px;border-radius:2px;-webkit-border-radius:2px;background:#029DD6;}
                        .ult_activate .ult_button_container{cursor:pointer;display:inline-block; padding:5px;-moz-border-radius:2px;border-radius:2px;-webkit-border-radius:2px;width:215px}
                        .ult_activate .ult_description{position:absolute;top:8px;left:230px;margin-left:25px;color:#0096A3;font-size:15px;z-index:1000}
                        .ult_activate .ult_description strong{color:#0096A3;font-weight:normal}
                            </style>
                                <div class="ult_activate">
                                    <div class="ult_a"><img style="width:1em;" src="<?php echo plugins_url("img/logo-icon.png",__FILE__); ?>" alt=""></div>
                                    <?php

                                    ?>
                                    <div class="ult_button_container" onclick="document.location='<?php echo $reg_link; ?>'">
                                        <div class="ult_button_border">
                                            <div class="ult_button"><span class="dashicons-before dashicons-admin-network" style="padding-right: 6px;"></span><?php __('Activate your license', 'ultimate_vc');?></div>
                                        </div>
                                    </div>
                                    <div class="ult_description"><h3 style="margin:0;padding: 2px 0px;"><strong><?php _e('Almost done!','ultimate_vc'); ?></strong></h3><p style="margin: 0;"><?php _e('Please activate your copy of the Ultimate Addons for Visual Composer to receive automatic updates & get premium support','ultimate_vc'); ?></p></div>
                                </div>
                        </div>
					<?php
					endif;
				} else if($hook_suffix == 'post-new.php' || $hook_suffix == 'edit.php' || $hook_suffix == 'post.php'){
					if( $builtin === 'disabled' || $ultimate_constants['ULTIMATE_NO_EDIT_PAGE_NOTICE'] === true || (is_multisite() == true && is_main_site() == false))
						$hide_notice = true;
					else
						$hide_notice = false;
					if(!$hide_notice) :
					?>

                        <div class="updated fade">

                            <p><?php echo _e('Howdy! Please','ultimate_vc').' <a href="'.$reg_link.'">'.__('activate your copy','ultimate_vc').' </a> '.__('of the Ultimate Addons for Visual Composer to receive automatic updates & get premium support.','ultimate_vc');?>
                            <span style="float: right; padding: 0px 4px; cursor: pointer;" class="uavc-activation-notice">X</span>
                            </p>
                        </div>
                        <script type="text/javascript">
                        jQuery(".uavc-activation-notice").click(function(){
                            jQuery(this).parents(".updated").fadeOut(800);
                        });
                        </script>

					<?php
					endif;
				}
			}
		}

	}
	new Ultimate_Admin_Area;
}

// Generate 32 characters
function ult_generate_rand_id(){
	$validCharacters = 'abcdefghijklmnopqrstuvwxyz0123456789';
	$myKeeper = '';
	$length = 32;
	for ($n = 1; $n < $length; $n++) {
	    $whichCharacter = rand(0, strlen($validCharacters)-1);
	    $myKeeper .= $validCharacters{$whichCharacter};
	}
	return $myKeeper;
}
// Alternative function for wp_remote_get
function ultimate_remote_get($path){

	if(function_exists('curl_init')){
		// create curl resource
		$ch = curl_init();

		// set url
		curl_setopt($ch, CURLOPT_URL, $path);

		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// $output contains the output string
		$output = curl_exec($ch);

		// close curl resource to free up system resources
		curl_close($ch);

		if($output !== "")
			return $output;
		else
			return false;
	} else {
		return false;
	}
}

// hooks to add bsf-core stylesheet
add_filter('bsf_core_style_screens', 'ultimate_bsf_core_style_hooks');
function ultimate_bsf_core_style_hooks($hooks) {
	$array = array(
		'ultimate_page_ultimate-resources',
		'ultimate_page_about-ultimate',
		'toplevel_page_about-ultimate',
		'ultimate_page_ultimate-dashboard',
		'ultimate_page_ultimate-smoothscroll',
		'ultimate_page_ultimate-scripts-and-styles',
		'admin_page_ultimate-debug-settings',
		'ultimate_page_bsf-google-maps'
	);
	foreach ($array as $hook) {
		array_push($hooks, $hook);
	}
	return $hooks;
}
// hooks to add frosty script
add_filter('bsf_core_frosty_screens', 'ultimate_bsf_core_frosty_hooks');
function ultimate_bsf_core_frosty_hooks($hooks) {
	$array = array(
		'ultimate_page_ultimate-smoothscroll'
	);
	foreach ($array as $hook) {
		array_push($hooks, $hook);
	}
	return $hooks;
}
