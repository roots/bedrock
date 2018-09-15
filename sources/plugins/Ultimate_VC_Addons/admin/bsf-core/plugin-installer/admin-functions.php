<?php
//global $bsf_product_validate_url;
//$bsf_product_validate_url = 'aHR0cHM6Ly93d3cuYnJhaW5zdG9ybWZvcmNlLmNvbS9zdXBwb3J0L3dwLWFkbWluL2FkbWluLWFqYXgucGhw';
if(!function_exists('get_bsf_product_id')) {
	function get_bsf_product_id($template) {
		$brainstrom_products = (get_option('brainstrom_products')) ? get_option('brainstrom_products') : array();
		$bsf_product_themes = (isset($brainstrom_products['themes'])) ? $brainstrom_products['themes'] : array();

		if(empty($brainstrom_products))
			return false;

		$id = '';
		foreach($bsf_product_themes as $theme) {
			if($theme['template'] === $template)
			{
				$id = $theme['id'];
				break;
			}
		}

		if($id != '')
			return $id;
		else
			return false;
	}
}
if(!function_exists('check_bsf_product_status')) {
	function check_bsf_product_status($id) {
		$brainstrom_products = (get_option('brainstrom_products')) ? get_option('brainstrom_products') : array();
		$bsf_product_themes = (isset($brainstrom_products['themes'])) ? $brainstrom_products['themes'] : array();

		if(empty($brainstrom_products))
			return false;

		$status = false;
		foreach($brainstrom_products as $products) {
			foreach ( $products as $key => $product) {
				if($product['id'] === $id) {
					$status = (isset($product['status'])) ? $product['status'] : '';
					break;
				}
			}


		}

		return $status;
	}
}

if(!function_exists('get_bundled_plugins')) {
	function get_bundled_plugins($template = '') {
		$brainstrom_products = (get_option('brainstrom_products')) ? get_option('brainstrom_products') : array();
		$bsf_product_themes = (isset($brainstrom_products['themes'])) ? $brainstrom_products['themes'] : array();

		// if(empty($bsf_product_themes)){
		// 	return false;
		// }

        $prd_ids = array();

        if ( $brainstrom_products == array() ) {
        	init_bsf_core();
        }

		foreach ( $brainstrom_products as $key => $value ) {
		   foreach ( $value as $key => $value2 ) {
		       array_push($prd_ids, $key);
		   }
		}

		// $id = get_bsf_product_id($template);

		// if( !$id )
		// 	return false;

		global $ultimate_referer;

		global $bsf_product_validate_url;
		$path = $bsf_product_validate_url.'?referer='.$ultimate_referer;

		$data = array(
				'action' => 'bsf_get_bundled_products',
				'id' => $prd_ids
			);
		$request = @wp_remote_post(
			$path, array(
				'body' => $data,
				'timeout' => '30',
				'sslverify' => false
			)
		);

		if (!is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200)
		{
			$brainstrom_bundled_products = (get_option('brainstrom_bundled_products')) ? get_option('brainstrom_bundled_products') : array();
			$result = json_decode( $request['body'] );

			if(empty($result)) {
				return false;
			}
			foreach ( $result as $key => $value ) {
				if( empty( $value ) ) {
					unset( $result->$key );
				}
			}

			// if ( array_key_exists( $result[$id]['api'], $result ) ) {
			// 	update_option('brainstrom_bundled_products_2', '$brainstrom_bundled_products' );
			// }

			// if(!empty($brainstrom_bundled_products) && !empty($result)) {
			// 	foreach($result as $bp) {
			// 		$is_found_in_local = false;
			// 		foreach($brainstrom_bundled_products as $key => $bp_local) {
			// 			if($bp->id === $bp_local->id) {
			// 				$is_found_in_local = true;
			// 			}
			// 		}
			// 		if(!$is_found_in_local) {
			// 			$brainstrom_bundled_products[] = $bp;
			// 		}
			// 	}
			// }
			// else {
			// 	$brainstrom_bundled_products = (array)$result;
			// }
			//echo 'GET BUNDLED <br/>';
			$brainstrom_bundled_products = (array)$result;
			update_option( 'brainstrom_bundled_products', $brainstrom_bundled_products );
		}
	}
}
//add_action('init', 'bsf_network_get_bundled_products');
//if(!function_exists('bsf_network_get_bundled_products')) {
//	function bsf_network_get_bundled_products() {
		if(false === get_site_transient( 'bsf_get_bundled_products' )) {
			global $bsf_theme_template;
			$proceed = true;

			if(phpversion() > 5.2) {
				$bsf_local_transient_bundled = get_option('bsf_local_transient_bundled');

				if($bsf_local_transient_bundled != false) {
					$datetime1 = new DateTime();
					$date_string = gmdate("Y-m-d\TH:i:s\Z", $bsf_local_transient_bundled);
					$datetime2 = new DateTime($date_string);

					$interval = $datetime1->diff($datetime2);
					$elapsed = $interval->format('%h');
					$elapsed = $elapsed + ($interval->days*24);
					if($elapsed <= 168 || $elapsed <= '168') {
						$proceed = false;
					}
				}
			}

			if($proceed) {
				global $ultimate_referer;
				$ultimate_referer = 'on-bundled-products-transient-delete';
				$template = (is_multisite()) ? $bsf_theme_template : get_template();
				get_bundled_plugins( $template );
				update_option('bsf_local_transient_bundled', current_time( 'timestamp' ));
				set_site_transient( 'bsf_get_bundled_products', true, 7*24*60*60 );
			}
		}
	//}
//}
if(!function_exists('install_bsf_product')) {
	function install_bsf_product($install_id) {
		global $bsf_product_validate_url, $bsf_support_url;
		if ( ! current_user_can('install_plugins') )
			wp_die(__('You do not have sufficient permissions to install plugins for this site.','bsf'));
		$brainstrom_bundled_products = (get_option('brainstrom_bundled_products')) ? get_option('brainstrom_bundled_products') : array();
		$install_product_data = array();

		if(!empty($brainstrom_bundled_products)) :
			foreach($brainstrom_bundled_products as $keys => $products) :
				if(strlen($keys) > 1) {
					foreach ($products as $key => $product) {
						if($product->id === $install_id) {
							$install_product_data = $product;
							break;
						}
					}
				}
				else {
					if($products->id === $install_id)
					{
						$install_product_data = $products;
						break;
					}
				}
			endforeach;
		endif;

		if(empty($install_product_data))
			return false;
		if($install_product_data->type !== 'plugin')
			return false;

		/* temp */
		/*$install_product_data->in_house = 'wp';
		$install_product_data->download_url = 'https://downloads.wordpress.org/plugin/redux-framework.3.5.9.zip';*/

		$is_wp = (isset($install_product_data->in_house) && $install_product_data->in_house === 'wp') ? true : false;

		if($is_wp) {
			$download_path = $install_product_data->download_url;
		}
		else {
			$path = $bsf_product_validate_url;
			$timezone = date_default_timezone_get();
			$call = 'file='.$install_product_data->download_url.'&hashtime='.strtotime(date('d-m-Y h:i:s a')).'&timezone='.$timezone;
			$hash = $call;
			//$parse = parse_url($path);
			//$download = $parse['scheme'].'://'.$parse['host'];
			$get_path = 'http://downloads.brainstormforce.com/';
			$download_path = rtrim($get_path,'/').'/download.php?'.$hash.'&base=ignore';
		}

		require_once (ABSPATH . '/wp-admin/includes/file.php');
		WP_Filesystem();
		global $wp_filesystem;
		require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		$WP_Upgrader = new WP_Upgrader;
		$res = $WP_Upgrader->fs_connect(array(
			WP_CONTENT_DIR
		));
		if (!$res) {
			wp_die(new WP_Error('Server error', __("Error! Can't connect to filesystem", 'bsf')));
		}
		$Plugin_Upgrader = new Plugin_Upgrader;
		$defaults = array(
			'clear_update_cache' => true,
		);
		$args = array();
		$parsed_args = wp_parse_args( $args, $defaults );

		$Plugin_Upgrader->init();
		$Plugin_Upgrader->install_strings();
		$Plugin_Upgrader->strings['downloading_package'] = __('Downloading package from Server', 'bsf');
		$Plugin_Upgrader->strings['remove_old'] = __('Removing old plugin, if exists', 'bsf');

		add_filter('upgrader_source_selection', array($Plugin_Upgrader, 'check_package') );
		$Plugin_Upgrader->run( array(
			'package' => $download_path,
			'destination' => WP_PLUGIN_DIR,
			'clear_destination' => true, // Do not overwrite files.
			'clear_working' => true,
			'hook_extra' => array(
				'type' => 'plugin',
				'action' => 'install',
			)
		) );
		remove_filter('upgrader_source_selection', array($Plugin_Upgrader, 'check_package') );
		if ( ! $Plugin_Upgrader->result || is_wp_error($Plugin_Upgrader->result) )
			return $Plugin_Upgrader->result;
		// Force refresh of plugin update information
		wp_clean_plugins_cache( $parsed_args['clear_update_cache'] );
		//return true;
		$response = array(
			'status' => true,
			'type' => 'plugin',
			'name' => $install_product_data->name,
			'init' => $install_product_data->init,
		);
		$plugin_abs_path = WP_PLUGIN_DIR.'/'.$install_product_data->init;
        if(is_file($plugin_abs_path))
        {
        	if(!isset($_GET['action']) && !isset($_GET['id'])) {
        		echo '|bsf-plugin-installed|';
        	}
            $is_plugin_installed = true;
            if(!is_plugin_active($install_product_data->init)) {
            	activate_plugin($install_product_data->init);
            	if(is_plugin_active($install_product_data->init)) {
            		if(!isset($_GET['action']) && !isset($_GET['id'])) {
            			echo '|bsf-plugin-activated|';
            		}
            	}
            }
            else {
            	if(!isset($_GET['action']) && !isset($_GET['id'])) {
            		echo '|bsf-plugin-activated|';
            	}
            }
        }
		return $response;
	}
}
add_action( 'wp_ajax_bsf_install', 'bsf_install_callback' );
add_action( 'wp_ajax_nopriv_bsf_install', 'bsf_install_callback' );
if(!function_exists('bsf_install_callback')) {
	function bsf_install_callback () {
		$product_id = $_POST['product_id'];
		$bundled = $_POST['bundled'];

		$response = install_bsf_product($product_id);

		echo json_encode($response);

		die();
	}
}
?>