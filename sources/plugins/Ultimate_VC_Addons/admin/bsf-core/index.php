<?php
/*
Plugin Name: Brainstorm Core
Plugin URI: https://brainstormforce.com
Author: Brainstorm Force
Author URI: https://brainstormforce.com
Version: 1.0
Description: Brainstorm Core
Text Domain: bsf
*/

/*
	Instrunctions - Product Registration & Updater
	# Copy "auto-upadater" folder to admin folder
	# Change "include_once" and "require_once" directory path as per your "auto-updater" path (Line no. 72, 78, 79)

*/
/* product registration */
require_once 'auto-update/admin-functions.php';
require_once 'auto-update/updater.php';

// abspath of groupi

if ( ! defined( 'BSF_UPDATER_PATH' ) ) {
	define( 'BSF_UPDATER_PATH', dirname(__FILE__) );
}

if(!function_exists('bsf_convert_core_path_to_relative')) {
	function bsf_convert_core_path_to_relative($path) {
		global $bsf_core_url;
		$plugin_dir = basename(PLUGINDIR);
		$theme_dir = basename(get_theme_root());
		if (strpos($path, $theme_dir) !== false) {
		    return rtrim(get_template_directory_uri().'/admin/bsf-core/', '/');
		}
		elseif(strpos($path, $plugin_dir) !== false) {
			return rtrim(plugin_dir_url( __FILE__ ),'/');
		}
		return false;
	}
}

add_action('admin_init', 'set_bsf_core_constant',1);
	if(!function_exists('set_bsf_core_constant')) {
	function set_bsf_core_constant() {
		if(!defined('BSF_CORE')) {
			define('BSF_CORE',true);
		}
	}
}

if ( ! function_exists( 'register_bsf_products_registration_page' ) ) {
	function register_bsf_products_registration_page() {
		if ( defined( 'BSF_UNREG_MENU' ) && ( BSF_UNREG_MENU === true || BSF_UNREG_MENU === 'true' ) ) {
			return false;
		}
		if ( empty ( $GLOBALS['admin_page_hooks']['bsf-registration'] ) ) {
			$place = bsf_get_free_menu_position( 200, 1 );
			if ( ! defined( 'BSF_MENU_POS' ) ) {
				define( 'BSF_MENU_POS', $place );
			}
			if(is_multisite()) {
				$page = add_menu_page('Brainstorm Force', 'Brainstorm', 'administrator', 'bsf-registration', 'bsf_registration','',$place);
			}
			else {
				if(defined('BSF_REG_MENU_TO_SETTINGS') && (BSF_REG_MENU_TO_SETTINGS == true || BSF_REG_MENU_TO_SETTINGS == 'true')) {
					$page = add_options_page('Brainstorm Force', 'Brainstorm', 'administrator', 'bsf-registration', 'bsf_registration' );
				}
				else {
					$page = add_dashboard_page( 'Brainstorm Force', 'Brainstorm', 'administrator', 'bsf-registration', 'bsf_registration' );
				}
			}
		}
	}
}
if ( ! function_exists( 'bsf_registration' ) ) {
	function bsf_registration() {
		include_once 'auto-update/index.php';
	}
}

if ( is_multisite() ) {
	add_action( 'network_admin_menu', 'register_bsf_products_registration_page', 98 );
} else {
	add_action( 'admin_menu', 'register_bsf_products_registration_page', 98 );
}

/*
	Instrunctions - Plugin Installer
	# Copy "plugin-installer" folder to theme's admin folder
	# Change "include_once" and "require_once" directory path as per your "plugin-installer" path (Line no. 101, 113)
*/
add_action( 'admin_init', 'init_bsf_plugin_installer' );
if ( ! function_exists( 'init_bsf_plugin_installer' ) ) {
	function init_bsf_plugin_installer() {
		require_once 'plugin-installer/admin-functions.php';

		/**
		 * Action will run after plugin installer is loaded
		 */
		do_action( 'bsf_after_plugin_installer' );
	}
}

if(!is_multisite())
	add_action('admin_menu', 'register_bsf_extension_page',999);
else
	add_action('network_admin_menu', 'register_bsf_extension_page_network',999);

if ( ! function_exists( 'register_bsf_extension_page' ) ) {

	function register_bsf_extension_page() {

		add_submenu_page(
			'imedica_options',
			__( 'Extensions', 'bsf' ),
			__( 'Extensions', 'bsf' ),
			'manage_options',
			'bsf-extensions-10395942',
			'bsf_extensions_callback'
		);

		$installer_menu = '';
		$reg_menu       = array();
		$reg_menu       = apply_filters( 'bsf_installer_menu', $reg_menu, $installer_menu );

		if ( is_array( $reg_menu ) ) {

			foreach ( $reg_menu as $installer => $attr ) {

				if ( empty ( $GLOBALS['admin_page_hooks'][ $attr['parent_slug'] ] ) &&
				     _bsf_maybe_add_dashboard_menu( $attr['product_id'] ) == true
				) {

					add_dashboard_page(
						$installer . ' ' . $attr['page_title'],
						$installer . ' ' . $attr['menu_title'],
						'manage_options',
						'bsf-extensions-' . $attr['product_id'],
						'bsf_extensions_callback'
					);

				} else {

					add_submenu_page(
						$attr['parent_slug'],
						$attr['page_title'],
						$attr['menu_title'],
						'manage_options',
						'bsf-extensions-' . $attr['product_id'],
						'bsf_extensions_callback'
					);

				}
			}

		}
		
	}

}

/**
 * Check if the dashboard menu for installer should be added.
 * Checks if theme or plugin is active, if it is not active, the menu for installer should not be registered.
 *
 * @param $product_id Product if of brainstorm product.
 *
 * @return boolean true - If menu is to be shown | false - if menu is not to be displayed.
 */
if ( ! function_exists( '_bsf_maybe_add_dashboard_menu' ) ) {

	function _bsf_maybe_add_dashboard_menu( $product_id ) {
		$brainstrom_products = ( get_option( 'brainstrom_products' ) ) ? get_option( 'brainstrom_products' ) : array();
		$template_plugin     = '';
		$template_theme      = '';
		$is_theme            = false;

		if ( is_multisite() ) {
			// Do not register menu if we are on multisite, multisite menu will be registered below the brainstorm menu.
			return false;
		}

		if ( $brainstrom_products !== array() ) {

			if ( isset( $brainstrom_products['plugins'] ) && isset( $brainstrom_products['plugins'][ $product_id ] ) ) {
				$template_plugin = $brainstrom_products['plugins'][ $product_id ]['template'];
			}

			if ( isset( $brainstrom_products['themes'] ) && isset( $brainstrom_products['themes'][ $product_id ] ) ) {
				$template_theme = $brainstrom_products['themes'][ $product_id ]['product_name'];
				$is_theme       = true;
			}

			if ( $is_theme == true && $template_theme !== '' ) {

				$themes = wp_get_theme();
				if ( $themes->get( 'Name' ) == $template_theme || $themes->parent()->get( 'Name' ) == $template_theme ) {
					// Theme / Parent theme is active, hence display menu
					return true;
				}

				// don't display menu if theme/parent theme does not need extension installer
				return false;

			} elseif ( $is_theme == false && $template_plugin !== '' ) {

				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

				if ( is_plugin_active( $template_plugin ) || is_plugin_active_for_network( $template_plugin ) ) {
					// Plugin is active, hence display menu
					return true;
				}

				// don't display menu if plugin does not need extension installer
				return false;

			}

		}

		// do not register menu if all conditions fail
		return false;

	}

}


if(!function_exists('register_bsf_extension_page_network')) {
	function register_bsf_extension_page_network() {

		$themes = wp_get_themes(array('allowed' => 'network'));

		foreach( $themes as $theme ) {
			if ( $theme->Name == 'iMedica' ) {
				add_submenu_page( 'bsf-registration', __('iMedica Extensions','bsf'), __('iMedica Extensions','bsf'), 'manage_options', 'bsf-extensions-10395942', 'bsf_extensions_callback' );
				break;
			}
		}

		$installer_menu = 	'';
		$reg_menu 		= 	array();
		$reg_menu 		=	get_site_option( 'bsf_installer_menu', array() );

		if( is_array( $reg_menu ) ) {

			foreach ( $reg_menu as $installer => $attr ) {
				add_submenu_page(
					'bsf-registration',
					$installer .' ' . $attr['page_title'],
					$installer .' ' . $attr['menu_title'],
					'manage_options',
					'bsf-extensions-' . $attr['product_id'],
					'bsf_extensions_callback'
				);
			}

		}

	}
}
if ( ! function_exists( 'bsf_extensions_callback' ) ) {
	function bsf_extensions_callback() {
		include_once 'plugin-installer/index.php';
	}
}

if(!function_exists('bsf_extract_product_id')) {
	function bsf_extract_product_id($path) {
		$id = false;
		$file = rtrim($path,'/').'/admin/bsf.yml';
		$file_fallback = rtrim($path,'/').'/bsf.yml';
		if(is_file($file))
			$file = $file;
		else if(is_file($file_fallback))
			$file = $file_fallback;
		else
			return false;
		$filelines = file_get_contents($file);
		if(stripos($filelines,'ID:[') !== false) {
			preg_match_all("/ID:\[(.*?)\]/", $filelines, $matches);
			if(isset($matches[1])) {
				$id = (isset($matches[1][0])) ? $matches[1][0] : '';
			}
		}
		return $id;
	}
}

add_action( 'admin_init', 'init_bsf_core' );
if(!function_exists('init_bsf_core')) {
	function init_bsf_core() {
		$plugins = get_plugins();
		$themes = wp_get_themes();

		$bsf_products = array();
		foreach($plugins as $plugin => $plugin_data)
		{
			if(trim($plugin_data['Author']) === 'Brainstorm Force')
			{
				$plugin_data['type'] = 'plugin';
				$plugin_data['template'] = $plugin;
				$plugin_data['path'] = dirname(realpath(WP_PLUGIN_DIR.'/'.$plugin));
				$id = bsf_extract_product_id($plugin_data['path']);
				if($id !== false)
					$plugin_data['id'] = $id; // without readme.txt filename
				array_push($bsf_products, $plugin_data);
			}
		}

		foreach($themes as $theme => $theme_data)
		{
			$temp = array();
			$theme_author = trim($theme_data->display('Author', FALSE));
			if($theme_author === 'Brainstorm Force')
			{
				$temp['Name'] = $theme_data->get('Name');
				$temp['ThemeURI'] = $theme_data->get('ThemeURI');
				$temp['Description'] = $theme_data->get('Description');
				$temp['Author'] = $theme_data->get('Author');
				$temp['AuthorURI'] = $theme_data->get('AuthorURI');
				$temp['Version'] = $theme_data->get('Version');
				$temp['type'] = 'theme';
				$temp['template'] = $theme;
				$temp['path'] = realpath(get_theme_root().'/'.$theme);
				$id = bsf_extract_product_id($temp['path']);
				if($id !== false)
					$temp['id'] = $id; // without readme.txt filename
				array_push($bsf_products, $temp);
			}
		}

		$brainstrom_products = ( get_option( 'brainstrom_products' ) ) ? get_option( 'brainstrom_products' ) : array();

		if(!empty($bsf_products)) {
			foreach ($bsf_products as $key => $product) {
				if(!(isset($product['id'])) || $product['id'] === '')
					continue;
				if(isset($brainstrom_products[$product['type'].'s'][$product['id']]))
					$bsf_product_info = $brainstrom_products[$product['type'].'s'][$product['id']];
				else
					$bsf_product_info = array();
				$bsf_product_info['template'] = $product['template'];
				$bsf_product_info['type'] = $product['type'];
				$bsf_product_info['id'] = $product['id'];
				$brainstrom_products[$product['type'].'s'][$product['id']] = $bsf_product_info;
			}
		}

		update_option('brainstrom_products', $brainstrom_products);
	}
}
if(is_multisite()) {
	$brainstrom_products = (get_option('brainstrom_products')) ? get_option('brainstrom_products') : array();
	if(!empty($brainstrom_products)) {
		$bsf_product_themes = (isset($brainstrom_products['themes'])) ? $brainstrom_products['themes'] : array();
		if(!empty($bsf_product_themes)) {
			foreach ($bsf_product_themes as $id => $theme) {
				global $bsf_theme_template;
				$template = $theme['template'];
				$bsf_theme_template = $template;
			}
		}
	}
}
// assets
add_action( 'admin_enqueue_scripts', 'register_bsf_core_admin_styles', 1 );
if(!function_exists('register_bsf_core_admin_styles')) {
	function register_bsf_core_admin_styles($hook) {
		//echo '--------------------------------------........'.$hook;die();

		// bsf core style
		$hook_array = array(
			'toplevel_page_bsf-registration',
			'update-core.php',
			'dashboard_page_bsf-registration',
			'index_page_bsf-registration',
			'admin_page_bsf-extensions',
			'settings_page_bsf-registration'
		);
		$hook_array = apply_filters('bsf_core_style_screens',$hook_array);

		if( in_array($hook, $hook_array) || strpos( $hook, 'bsf-extensions' ) !== false ){
			// add function here
			global $bsf_core_path;
			$bsf_core_url = bsf_convert_core_path_to_relative($bsf_core_path);
			$path = $bsf_core_url.'/assets/css/style.css';
			wp_register_style( 'bsf-core-admin', $path );
			wp_enqueue_style( 'bsf-core-admin' );
		}

		// frosty script
		$hook_frosty_array = array();
		$hook_frosty_array = apply_filters('bsf_core_frosty_screens',$hook_frosty_array);
		if(in_array($hook, $hook_frosty_array)){
			global $bsf_core_path;
			$bsf_core_url = bsf_convert_core_path_to_relative($bsf_core_path);

			$path = $bsf_core_url.'/assets/js/frosty.js';
			$css_path = $bsf_core_url.'/assets/css/frosty.css';

			wp_register_script( 'bsf-core-frosty', $path );
			wp_enqueue_script( 'bsf-core-frosty' );

			wp_register_style( 'bsf-core-frosty-style', $css_path );
			wp_enqueue_style( 'bsf-core-frosty-style' );
		}
	}
}
if(is_multisite()) {
	add_action('admin_print_scripts', 'print_bsf_styles');
	if(!function_exists('print_bsf_styles')) {
		function print_bsf_styles() {
			global $bsf_core_path;
			$bsf_core_url = bsf_convert_core_path_to_relative($bsf_core_path);

			$path = $bsf_core_url.'/assets/fonts';

			echo "<style>
				@font-face {
					font-family: 'brainstorm';
					src:url('".$path."/brainstorm.eot');
					src:url('".$path."/brainstorm.eot') format('embedded-opentype'),
						url('".$path."/brainstorm.woff') format('woff'),
						url('".$path."/brainstorm.ttf') format('truetype'),
						url('".$path."/brainstorm.svg') format('svg');
					font-weight: normal;
					font-style: normal;
				}
				.toplevel_page_bsf-registration > div.wp-menu-image:before {
					content: \"\\e603\" !important;
					font-family: 'brainstorm' !important;
					speak: none;
					font-style: normal;
					font-weight: normal;
					font-variant: normal;
					text-transform: none;
					line-height: 1;
					-webkit-font-smoothing: antialiased;
					-moz-osx-font-smoothing: grayscale;
				}
			</style>";
		}
	}
}

if ( ! function_exists( 'bsf_flush_bundled_products' ) ) {

	function bsf_flush_bundled_products() {
		$bsf_force_check_extensions = get_site_option( 'bsf_force_check_extensions', false );

		if ( $bsf_force_check_extensions == true ) {
			delete_site_option( 'brainstrom_bundled_products' );
			delete_site_transient( 'bsf_get_bundled_products' );
			global $ultimate_referer;
			$ultimate_referer = 'on-flush-bundled-products';
			get_bundled_plugins();

			update_site_option( 'bsf_force_check_extensions', false );
		}
	}
}

add_action( 'bsf_after_plugin_installer', 'bsf_flush_bundled_products' );

/**
 * Return extension installer page URL
 */
if ( ! function_exists( 'bsf_exension_installer_url' ) ) {

	function bsf_exension_installer_url( $priduct_id ) {
		if ( is_multisite() ) {
			return network_admin_url( 'admin.php?page=bsf-extensions-' . $priduct_id );
		} else {
			return admin_url( 'admin.php?page=bsf-extensions-' . $priduct_id );
		}
	}
}

/**
 * Return array of bundled plugins for a specific
 *
 * @since Graupi 1.9
 */
if ( ! function_exists( 'bsf_bundled_plugins' ) ) {

	function bsf_bundled_plugins( $product_id = '' ) {
		$products = array();

		$brainstrom_bundled_products = get_option( 'brainstrom_bundled_products', '' );

		if ( $brainstrom_bundled_products !== '' ) {
			if ( array_key_exists( $product_id, $brainstrom_bundled_products ) ) {
				$products = $brainstrom_bundled_products[ $product_id ];
			}
		}

		return $products;
	}
}

/**
 * Get product name from product ID
 *
 * @since Graupi 1.9
 */
if ( ! function_exists( 'brainstrom_product_name' ) ) {

	function brainstrom_product_name( $product_id = '' ) {
		$product_name = '';
		$brainstrom_products =  get_option( 'brainstrom_products', '' );

		foreach ( $brainstrom_products as $key => $value ) {
			foreach ( $value as $key => $product ) {
				if ( $product_id == $key ) {
					$product_name = $product['product_name'];
				}
			}
		}

		return $product_name;
	}
}


/**
 * Dismiss Extension installer nag
 *
 * @since Graupi 1.9
 */
if ( ! function_exists( 'bsf_dismiss_extension_nag' ) ) {

	function bsf_dismiss_extension_nag() {
		if ( isset( $_GET['bsf-dismiss-notice'] ) ) {
			$product_id =  $_GET['bsf-dismiss-notice'];
			update_user_meta( get_current_user_id(), $product_id . '-bsf_nag_dismiss', true );
		}
	}

}

add_action( 'admin_head', 'bsf_dismiss_extension_nag' );

// For debugging uncomment line below and remove query var &bsf-dismiss-notice from url and nag will be restored.
// delete_user_meta( get_current_user_id(), 'bsf-next-bsf_nag_dismiss');

/**
 * Generate's markup to generate notice to ask users to install required extensions.
 *
 * @since Graupi 1.9
 *
 * $product_id (string) Product ID of the brainstorm product
 * $mu_updater (bool) If True - give nag to separately install brainstorm updater multisite plugin
 */
if ( ! function_exists( 'bsf_extension_nag' ) ) {

	function bsf_extension_nag( $product_id = '', $mu_updater = false ) {

		$display_nag = get_user_meta( get_current_user_id(), $product_id . '-bsf_nag_dismiss', true );

		if ( $mu_updater == true ) {
			bsf_nag_brainstorm_updater_multisite();
		}

		if ( $display_nag === '1' || 
			! user_can( get_current_user_id(), 'activate_plugins' ) || 
			! user_can( get_current_user_id(), 'install_plugins' ) ) {
			return;
		}

		$bsf_installed_plugins     = '';
		$bsf_not_installed_plugins = '';
		$bsf_not_activated_plugins = '';
		$installer                 = '';
		$bsf_install               = false;
		$bsf_activate              = false;
		$bsf_bundled_products      = bsf_bundled_plugins( $product_id );
		$bsf_product_name          = brainstrom_product_name( $product_id );

		foreach ( $bsf_bundled_products as $key => $plugin ) {

			if ( ! isset( $plugin->id ) || $plugin->id == '' || ! isset( $plugin->must_have_extension ) || $plugin->must_have_extension == 'false' ) {
				continue;
			}

			$plugin_abs_path = WP_PLUGIN_DIR . '/' . $plugin->init;
			if ( is_file( $plugin_abs_path ) ) {

				if ( ! is_plugin_active( $plugin->init ) ) {
					$bsf_not_activated_plugins .= $bsf_bundled_products[ $key ]->name . ', ';
				}
			} else {
				$bsf_not_installed_plugins .= $bsf_bundled_products[ $key ]->name . ', ';
			}

		}

		$bsf_not_activated_plugins = rtrim( $bsf_not_activated_plugins, ", " );
		$bsf_not_installed_plugins = rtrim( $bsf_not_installed_plugins, ", " );

		if ( $bsf_not_activated_plugins !== '' || $bsf_not_installed_plugins !== '' ) {
			echo '<div class="updated notice is-dismissible"><p></p>';
			if ( $bsf_not_activated_plugins !== '' ) {
				echo '<p>';
				echo $bsf_product_name . __( ' requires following plugins to be active : ', 'bsf' );
				echo "<strong><em>";
				echo $bsf_not_activated_plugins;
				echo "</strong></em>";
				echo '</p>';
				$bsf_activate = true;
			}

			if ( $bsf_not_installed_plugins !== '' ) {
				echo '<p>';
				echo $bsf_product_name . __( ' requires following plugins to be installed and activated : ', 'bsf' );
				echo "<strong><em>";
				echo $bsf_not_installed_plugins;
				echo "</strong></em>";
				echo '</p>';
				$bsf_install = true;
			}

			if ( $bsf_activate == true ) {
				$installer .= '<a href="' . get_admin_url() . 'plugins.php?plugin_status=inactive">' . __( 'Begin activating plugins', 'bsf' ) . '</a> | ';
			}

			if ( $bsf_install == true ) {
				$installer .= '<a href="' . bsf_exension_installer_url( $product_id ) . '">' . __( 'Begin installing plugins', 'bsf' ) . '</a> | ';
			}

			$installer .= '<a href="' . esc_url( add_query_arg( 'bsf-dismiss-notice', $product_id ) ) . '">' . __( 'Dismiss This Notice', 'bsf' ) . '</a>';

			$installer = ltrim( $installer, '| ' );
			echo '<p><strong>';
			echo rtrim( $installer, ' |' );
			echo '</p></strong>';

			echo '<p></p></div>';
		}
	}

}

if ( ! function_exists( 'bsf_nag_brainstorm_updater_multisite' ) ) {

	function bsf_nag_brainstorm_updater_multisite() {

		if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
			require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
		}

		if ( ! is_multisite() || is_plugin_active_for_network( 'brainstorm-updater/index.php' ) ) {
			return;
		}

		echo '<div class="notice notice-error uct-notice is-dismissible"><p>';
		printf(
			__('Looks like you are on a WordPress Multisite, you will need to install and network activate %1$s Brainstorm Updater for Multisite %2$s plugin. Download it from %3$s here %4$s', 'bsf' ) ,
				'<strong><em>',
				'</strong></em>',
				'<a href="http://bsf.io/bsf-updater-mu" target="_blank">',
				'</a>'
			 );

		echo "</p>";
		echo "</div>";
	}

}

/**
 * Check if bundled products data on site is from old version of graupi and force refresh the data if required.
 */
function bsf_check_correct_updater_data() {
	$brainstrom_bundled_products = get_option( 'brainstrom_bundled_products', array() );
	$url = '';

	foreach ( $brainstrom_bundled_products  as $key => $value) {
		if ( is_object( $value ) || is_object( $brainstrom_bundled_products ) ) {
			if ( ! is_multisite() && is_admin() ) {
				$url = admin_url( 'index.php?page=bsf-registration&remove-bundled-products' );

				continue;
			}
		}
	}

	// if page is reloaded once dont check agan, this may result in redirect loop if brainstorm products are not being updated.
	if ( $url !== '' && ! isset( $_GET['bsf-reload-page'] ) ) {
		echo '<script type="text/javascript">
				var redirect = window.location.href;
				window.location = "'.$url.'&redirect=" + redirect + "&bsf-reload-page";
			  </script>';
	}

}

add_action( 'admin_init', 'bsf_check_correct_updater_data', 2 );

/*
 * Load BSF core frosty scripts on front end
*/
add_action( 'wp_enqueue_scripts', 'register_bsf_core_styles', 1 );
function register_bsf_core_styles( $hook ) {

	global $bsf_core_path;
	$bsf_core_url = bsf_convert_core_path_to_relative($bsf_core_path);
	$frosty_script_path = $bsf_core_url.'/assets/js/frosty.js';
	$frosty_style_path = $bsf_core_url.'/assets/css/frosty.css';

	// Register Frosty script and style
	wp_register_script( 'bsf-core-frosty', $frosty_script_path );
	wp_register_style( 'bsf-core-frosty-style', $frosty_style_path );

}

/**
 * Add link to debug settings for braisntorm updater on license registration page
 */
function bsf_core_debug_link( $text ) {
	$screen = get_current_screen();

	$screens = array(
		'dashboard_page_bsf-registration',
		'toplevel_page_bsf-registration-network'
		);

	if( ! in_array( $screen->id, $screens ) ) {
		return $text;
	}

	$url = bsf_registration_page_url( '&author' );
	$link = '<a href="'.$url.'">Brainstorm Updater debug settings</a>';
	$text = $link .' | '. $text;
	return $text;
}

add_filter( 'update_footer', 'bsf_core_debug_link', 999 );

/**
 * Return brainstorm registration page URL
 *
 * @param $append (string) - Append at string at the end of the url
 */
if ( ! function_exists( 'bsf_registration_page_url' ) ) {

	function bsf_registration_page_url( $append = '' ) {
		if ( is_multisite() ) {
			return network_admin_url( 'admin.php?page=bsf-registration' . $append );
		} else {
			return admin_url( 'index.php?page=bsf-registration' . $append );
		}
	}
}