<?php
global $bsf_product_validate_url, $bsf_support_url;
$bsf_product_validate_url = 'https://support.brainstormforce.com/wp-admin/admin-ajax.php';
$bsf_support_url = 'https://support.brainstormforce.com/';
// Generate 32 characters
if(!function_exists('bsf_generate_rand_token')) {
	function bsf_generate_rand_token(){
		$validCharacters = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$myKeeper = '';
		$length = 32;
		for ($n = 1; $n < $length; $n++) {
			$whichCharacter = rand(0, strlen($validCharacters)-1);
			$myKeeper .= $validCharacters{$whichCharacter};
		}
		return $myKeeper;
	}
}
// product registration
add_action( 'wp_ajax_bsf_register_product', 'bsf_register_product_callback' );
if(!function_exists('bsf_register_product_callback')) {
	function bsf_register_product_callback() {

		global $bsf_product_validate_url;
		$brainstrom_products = (get_option('brainstrom_products')) ? get_option('brainstrom_products') : array();
		$brainstrom_users = (get_option('brainstrom_users')) ? get_option('brainstrom_users') : array();

		$bsf_product_plugins = $bsf_product_themes = array();

		$type = isset($_POST['type']) ? $_POST['type'] : '';
		$product = isset($_POST['product']) ? $_POST['product'] : '';
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		$bsf_username = isset($_POST['bsf_username']) ? $_POST['bsf_username'] : '';
		$bsf_useremail = isset($_POST['bsf_useremail']) ? $_POST['bsf_useremail'] : '';
		$purchase_key = isset($_POST['purchase_key']) ? $_POST['purchase_key'] : '';
		$version = isset($_POST['version']) ? $_POST['version'] : '';
		$step = isset($_POST['step']) ? $_POST['step'] : '';
		$product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
		$token = bsf_generate_rand_token();

		if(!empty($brainstrom_products)) :
			$bsf_product_plugins = (isset($brainstrom_products['plugins'])) ? $brainstrom_products['plugins'] : array();
			$bsf_product_themes = (isset($brainstrom_products['themes'])) ? $brainstrom_products['themes'] : array();
		endif;

		$product_key = $is_edd = '';

		if($type === 'plugin' || $type === 'theme')
		{
			$bsf_products_array = array();
			if($type == 'plugin')
				$bsf_products_array = $bsf_product_plugins;
			elseif($type == 'theme')
				$bsf_products_array = $bsf_product_themes;
			if(!empty($bsf_products_array)) :
				foreach($bsf_products_array as $key => $bsf_product)
				{
					$bsf_template = $bsf_product['template'];
					if($product == $bsf_template)
					{
						$product_key = $key;
						$brainstrom_products[$type.'s'][$key]['purchase_key'] = $purchase_key;
						$brainstrom_products[$type.'s'][$key]['version'] = $version;
						$brainstrom_products[$type.'s'][$key]['product_name'] = $product_name;
						$is_edd = (isset($brainstrom_products[$type.'s'][$key]['edd'])) ? $brainstrom_products[$type.'s'][$key]['edd'] : '';
					}
				}
			endif;
		}

		update_option('brainstrom_products', $brainstrom_products);

		$path = $bsf_product_validate_url;

		$data = array(
				'action' => 'bsf_product_registration',
				'purchase_key' => $purchase_key,
				'bsf_username' => $bsf_username,
				'bsf_useremail' => $bsf_useremail,
				'site_url' => get_site_url(),
				'version' => $version,
				'token' => $token,
				'referer' => 'customer',
				'id' => $id
			);
		if($is_edd)
			$data['edd'] = $is_edd;
		$data = apply_filters('bsf_product_registration_args', $data);
		$request = @wp_remote_post(
			$path, array(
				'body' => $data,
				'timeout' => '30',
				'sslverify' => false
			)
		);

		if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200)
		{
			$result = json_decode($request['body']);
			$status = '';
			//echo json_encode($result); die();
			if(isset($result->status))
			{
				$status = $result->status;
				$brainstrom_products[$type.'s'][$product_key]['status'] = $status;
			}

			if($status === 'registered')
			{
				// reset bundled products if type is theme
				if($type === 'theme') {
					delete_option('brainstrom_bundled_products');
					delete_site_transient('bsf_get_bundled_products');
					global $ultimate_referer;
					$ultimate_referer = 'on-register-product';
					bsf_check_product_update();
				}
				$brainstrom_products[$type.'s'][$product_key]['step'] = 'step-all-success';
				$temp_info['product_info'] = $brainstrom_products[$type.'s'][$product_key];

				$user_array = array(
					'email' => $bsf_useremail,
					'token' => $token
				);
				if(!empty($brainstrom_users))
				{
					$find_key = false;
					foreach($brainstrom_users as $key => $user)
					{
						if($user['email'] === $bsf_useremail)
						{
							$brainstrom_users[$key]['token'] = $token;
							$find_key = true;
						}
					}
					if(!$find_key)
						array_push($brainstrom_users, $user_array);
				}
				else
					array_push($brainstrom_users, $user_array);
				update_option('brainstrom_users', $brainstrom_users);
			}

			update_option('brainstrom_products', $brainstrom_products);

			echo json_encode($result);

		}
		else
		{
			$arr = array('response' => $request->get_error_message());
			echo json_encode($arr);
		}

		wp_die();
	} //end of bsf_register_product_callback
}
// function to de register licence
add_action( 'wp_ajax_bsf_deregister_product', 'bsf_deregister_product_callback' );
if(!function_exists('bsf_deregister_product_callback')) {
	function bsf_deregister_product_callback() {
		global $bsf_product_validate_url;
		$brainstrom_products = (get_option('brainstrom_products')) ? get_option('brainstrom_products') : array();

		$bsf_product_plugins = $bsf_product_themes = array();

		$type = isset($_POST['type']) ? $_POST['type'] : '';
		$product = isset($_POST['product']) ? $_POST['product'] : '';
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		$bsf_useremail = isset($_POST['bsf_useremail']) ? $_POST['bsf_useremail'] : '';
		$purchase_key = isset($_POST['purchase_key']) ? $_POST['purchase_key'] : '';
		$version = isset($_POST['version']) ? $_POST['version'] : '';
		$product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
		$token = bsf_generate_rand_token();

		if(!empty($brainstrom_products)) :
			$bsf_product_plugins = (isset($brainstrom_products['plugins'])) ? $brainstrom_products['plugins'] : array();
			$bsf_product_themes = (isset($brainstrom_products['themes'])) ? $brainstrom_products['themes'] : array();
		endif;

		$product_key = $is_edd = '';

		if($type === 'plugin' || $type === 'theme')
		{
			$bsf_products_array = array();
			if($type == 'plugin')
				$bsf_products_array = $bsf_product_plugins;
			elseif($type == 'theme')
				$bsf_products_array = $bsf_product_themes;
			if(!empty($bsf_products_array)) :
				foreach($bsf_products_array as $key => $bsf_product)
				{
					if(!isset($bsf_product['template']))
						continue;
					$bsf_template = $bsf_product['template'];
					if($product == $bsf_template)
					{
						$product_key = $key;
						$brainstrom_products[$type.'s'][$key]['status'] = 'not-registered';
						$is_edd = (isset($brainstrom_products[$type.'s'][$key]['edd'])) ? $brainstrom_products[$type.'s'][$key]['edd'] : '';
					}
				}
			endif;
		}

		update_option('brainstrom_products', $brainstrom_products);

		$path = $bsf_product_validate_url;

		$data = array(
				'action' => 'bsf_product_deregistration',
				'purchase_key' => $purchase_key,
				'bsf_useremail' => $bsf_useremail,
				'site_url' => get_site_url(),
				'version' => $version,
				'id' => $id,
				'token' => $token,
				'product' => $product_name
			);
		if($is_edd)
			$data['edd'] = $is_edd;
		$data = apply_filters('bsf_product_deregistration_args', $data);
		$request = @wp_remote_post(
			$path, array(
				'body' => $data,
				'timeout' => '30',
				'sslverify' => false
			)
		);

		if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200)
		{
			$result = json_decode($request['body']);
			//$result->message_html = 'Site deactivated!<br/>'.$result->message_html;
			echo json_encode($result);
		}
		else
		{
			$res['response'] = array(
				'title' => 'Error',
				'message_html' => 'Site deactivated!<br/> Error while communicating with server'.$request->get_error_message()
			);
			$res['proceed'] = true;
			echo json_encode($res);
		}

		wp_die();
	}
}
// first step execution of user registration
add_action( 'wp_ajax_bsf_register_user', 'bsf_register_user_callback' );
if(!function_exists('bsf_register_user_callback')) {
	function bsf_register_user_callback() {
		global $bsf_product_validate_url;

		$brainstrom_users = (get_option('brainstrom_users')) ? get_option('brainstrom_users') : array();

		$bsf_username = isset($_POST['bsf_username']) ? $_POST['bsf_username'] : '';
		$bsf_useremail = isset($_POST['bsf_useremail']) ? $_POST['bsf_useremail'] : '';
		$bsf_useremail_reenter = isset($_POST['bsf_useremail_reenter']) ? $_POST['bsf_useremail_reenter'] : '';

		$subscribe = isset($_POST['ultimate_user_receive']) ? $_POST['ultimate_user_receive'] : '';

		$token = bsf_generate_rand_token();

		if($bsf_useremail !== $bsf_useremail_reenter) {
			$response['response'] = array(
				'title' => 'Error',
				'message_html' => 'Email address did not matched'
			);
			$response['proceed'] = false;

			echo json_encode($response);
			wp_die();
		}

		$domain = substr(strrchr($bsf_useremail, "@"), 1);
		if($domain === '' || $domain === false)
			$domain = $bsf_useremail;
		if(function_exists('checkdnsrr')) {
			$dns_check = checkdnsrr($domain, 'MX');
			if(!$dns_check)
			{
				$response['response'] = array(
					'title' => 'Error',
					'message_html' => 'Please enter valid email address, username and password will sent to your provided email address'
				);
				$response['proceed'] = false;
				echo json_encode($response);
				wp_die();
			}
		}

		$path = $bsf_product_validate_url;

		$data = array(
				'action' => 'bsf_user_registration',
				'bsf_username' => $bsf_username,
				'bsf_useremail' => $bsf_useremail,
				'bsf_useremail_confirm' => $bsf_useremail_reenter,
				'ultimate_user_receive' => $subscribe,
				'site_url' => get_site_url(),
				'token' => $token,
			);

		$request = @wp_remote_post(
			$path, array(
				'body' => $data,
				'timeout' => '60',
				'sslverify' => false
			)
		);

		if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200)
		{
			$result = json_decode($request['body']);
			if((isset($result->proceed)) && ($result->proceed === 'true' || $result->proceed === true))
			{
				$user_array = array(
					'name' => $bsf_username,
					'email' => $bsf_useremail,
					'token' => $token
				);
				if(!empty($brainstrom_users))
				{
					$find_key = false;
					foreach($brainstrom_users as $key => $user)
					{
						if($user['email'] === $bsf_useremail)
						{
							$brainstrom_users[$key]['name'] = $bsf_username;
							$brainstrom_users[$key]['token'] = $token;
							$find_key = true;
							break;
						}
					}
					if(!$find_key)
						array_push($brainstrom_users, $user_array);
				}
				else
					array_push($brainstrom_users, $user_array);

				update_option('brainstrom_users', $brainstrom_users);

				global $ultimate_referer;
				$ultimate_referer = 'on-user-register';
				bsf_check_product_update();
			}
			echo json_encode($result);
		}
		else
		{
			$arr = array('response' => $request->get_error_message());
			echo json_encode($arr);
		}

		wp_die();
	}// end of bsf_register_user_callback
}
add_action('admin_init','bsf_update_all_product_version',1000);
if(!function_exists('bsf_update_all_product_version')) {
	function bsf_update_all_product_version() {
		$brainstrom_products = (get_option('brainstrom_products')) ? get_option('brainstrom_products') : array();
		$brainstrom_bundled_products = (get_option('brainstrom_bundled_products')) ? get_option('brainstrom_bundled_products') : array();

		$mix_products = $update_ready = $bsf_product_plugins = $bsf_product_themes = array();

		if(!empty($brainstrom_products)) :
			$bsf_product_plugins = (isset($brainstrom_products['plugins'])) ? $brainstrom_products['plugins'] : array();
			$bsf_product_themes = (isset($brainstrom_products['themes'])) ? $brainstrom_products['themes'] : array();
		endif;

		$product_updated = $bundled_product_updated = false;

		if(!empty($bsf_product_plugins)) :
			foreach($bsf_product_plugins as $key => $plugin) :
				if(!isset($plugin['id']) || empty($plugin['id']) )
					continue;
				if(!isset($plugin['template']) || empty($plugin['template']) )
					continue;
				if(!isset($plugin['type']) || empty($plugin['type']) )
					continue;
				$version = (isset($plugin['version'])) ? $plugin['version'] : '';
				$current_version = bsf_get_current_version($plugin['template'], $plugin['type']);
				$name = bsf_get_current_name($plugin['template'], $plugin['type']);
				if($name !== '')
					$brainstrom_products['plugins'][$key]['product_name'] = $name;
				if($current_version !== '') {
					if(version_compare($version, $current_version) === -1 || version_compare($version, $current_version) === 1)
					{
						$brainstrom_products['plugins'][$key]['version'] = $current_version;
						$product_updated = true;
					}
				}
			endforeach;
		endif;

		if(!empty($bsf_product_themes)) :
			foreach($bsf_product_themes as $key => $theme) :
				//if(!isset($theme['id']))
					//unset($brainstrom_products[$key]);
				if(!isset($theme['id']) || empty($theme['id']) )
					continue;
				if(!isset($theme['template']) || empty($theme['template']) )
					continue;
				if(!isset($theme['type']) || empty($theme['type']) )
					continue;
				$version = (isset($theme['version'])) ? $theme['version'] : '';
				$current_version = bsf_get_current_version($theme['template'], $theme['type']);
				$name = bsf_get_current_name($theme['template'], $theme['type']);
				if($name !== '')
					$brainstrom_products['themes'][$key]['product_name'] = $name;
				if($current_version !== '' || $current_version !== false) {
					if(version_compare($version, $current_version) === -1 || version_compare($version, $current_version) === 1)
					{
						$brainstrom_products['themes'][$key]['version'] = $current_version;
						$product_updated = true;
					}
				}
			endforeach;
		endif;

		if(!empty($brainstrom_bundled_products)) :
			foreach($brainstrom_bundled_products as $keys => $bps) :
				$version = '';
				if(strlen($keys) > 1) {
					foreach ($bps as $key => $bp) {
						if(!isset($bp->id) || $bp->id === '') {
							continue;
						}
						$version = $bp->version;
						$current_version = bsf_get_current_version($bp->init, $bp->type);

						if($current_version !== '' && $current_version !== false) {
							if( version_compare($version, $current_version) === -1 || version_compare($version, $current_version) === 1 ) {
								if (is_object( $brainstrom_bundled_products )) {
									$brainstrom_bundled_products = array($brainstrom_bundled_products);
								}
								$single_bp = $brainstrom_bundled_products[$keys];
								$single_bp[$key]->version = $current_version;
								$bundled_product_updated = true;
								$brainstrom_bundled_products[$keys] = $single_bp;
							}
						}
					}
				}
				else {
					if(!isset($bps->id) || $bps->id === '') {
						continue;
					}
					$version = $bps->version;
					$current_version = bsf_get_current_version($bps->init, $bps->type);
					if($current_version !== '' || $current_version !== false) {
					if(version_compare($version, $current_version) === -1 || version_compare($version, $current_version) === 1)
						{
							$brainstrom_bundled_products[$keys]->version = $current_version;
							$bundled_product_updated = true;
						}
					}
				}
			endforeach;
		endif;

		//if($product_updated)
		update_option('brainstrom_products', $brainstrom_products);

		if($bundled_product_updated){
			//echo 'Before Update'; die();
			update_option('brainstrom_bundled_products', $brainstrom_bundled_products);
		}
	}
}
if(!function_exists('bsf_get_current_version')) {
	function bsf_get_current_version($template, $type) {
		if($template === '')
			return false;
		if($type === 'theme' || $type === 'themes')
		{
			$theme = wp_get_theme($template);
			$version = $theme->get( 'Version' );
		}
		else if($type === 'plugin' || $type === 'plugins')
		{
			$plugin_file = rtrim(WP_PLUGIN_DIR,'/').'/'.$template;
			if(!is_file($plugin_file))
				return false;
			$plugin = get_plugin_data($plugin_file);
			$version = $plugin['Version'];
		}
		return $version;
	}
}
if(!function_exists('bsf_get_current_name')) {
	function bsf_get_current_name($template, $type) {
		if($template === '')
			return false;
		if($type === 'theme' || $type === 'themes')
		{
			$theme = wp_get_theme($template);
			$name = $theme->get( 'Name' );
		}
		else if($type === 'plugin' || $type === 'plugins')
		{
			$plugin_file = rtrim(WP_PLUGIN_DIR,'/').'/'.$template;
			if(!is_file($plugin_file))
				return false;
			$plugin = get_plugin_data($plugin_file);
			$name = $plugin['Name'];
		}
		return $name;
	}
}
add_action('admin_notices','bsf_notices',1000);
add_action('network_admin_notices','bsf_notices',1000);
if(!function_exists('bsf_notices')) {
	function bsf_notices() {
		global $pagenow;

		if ( $pagenow === 'plugins.php' || $pagenow === 'post-new.php' || $pagenow === 'edit.php' || $pagenow === 'post.php') {
			$brainstrom_products = get_option('brainstrom_products');
			$brainstrom_bundled_products = (get_option('brainstrom_bundled_products')) ? get_option('brainstrom_bundled_products') : array();

			if(empty($brainstrom_products))
				return false;

			$brainstrom_bundled_products_keys = array();

			if(!empty($brainstrom_bundled_products)) :
				foreach($brainstrom_bundled_products as $bps) {
					foreach ($bps as $key => $bp) {
						array_push($brainstrom_bundled_products_keys, $bp->id);
					}
				}
			endif;

			$mix = array();

			$plugins = (isset($brainstrom_products['plugins'])) ? $brainstrom_products['plugins'] : array();
			$themes = (isset($brainstrom_products['themes'])) ? $brainstrom_products['themes'] : array();

			$mix = array_merge($plugins, $themes);

			if(empty($mix))
				return false;

			if((defined('BSF_PRODUCTS_NOTICES') && (BSF_PRODUCTS_NOTICES === 'false' || BSF_PRODUCTS_NOTICES === false)))
				return false;

			$is_multisite = is_multisite();
			$is_network_admin = is_network_admin();

			foreach($mix as $product) :
				if(!isset($product['id']))
					continue;
				if(isset($product['is_product_free']) && ($product['is_product_free'] === 'true' || $product['is_product_free'] === true))
					continue;
				$constant = strtoupper(str_replace('-', '_', $product['id']));
				$constant_nag = 'BSF_'.$constant.'_NAG';
				$constant_notice = 'BSF_'.$constant.'_NOTICES';

				$show_nag = false;

				if(defined($constant_nag) && (constant($constant_nag) === 'false' || constant($constant_nag) === false))
					continue;
				if(defined($constant_notice) && (constant($constant_notice) === 'false' || constant($constant_notice) === false))
					continue;

				$status = (isset($product['status'])) ? $product['status'] : false;
				$type = (isset($product['type'])) ? $product['type'] : false;

				if(!$type)
					continue;

				if($type === 'plugin') {
					if(!is_plugin_active($product['template']))
						continue;
				}
				elseif($type === 'theme') {
					$theme = wp_get_theme();
					if ($product['template'] !== $theme->template)
						continue;
				}
				else
					continue;

				if(in_array($product['id'],$brainstrom_bundled_products_keys))
					continue;

				if($status !== 'registered') :
					if(is_multisite())
						$url = network_admin_url('index.php?page=bsf-registration');
					else {
						if(defined('BSF_REG_MENU_TO_SETTINGS') && (BSF_REG_MENU_TO_SETTINGS == true || BSF_REG_MENU_TO_SETTINGS == 'true')) {
							$url = admin_url('options-general.php?page=bsf-registration');
						}
						else {
							$url = admin_url('index.php?page=bsf-registration');
						}
					}

					$message = __('Please','bsf').' <a href="'.$url.'">'.__('activate','bsf').'</a> '.__('your copy of the','bsf').' '.$product['product_name'].' '.__('to get update notifications, access to support features & other resources!','bsf');

					if(($is_multisite && $is_network_admin) || !$is_multisite)
						echo '<div class="update-nag bsf-update-nag">'.$message.'</div>';
				endif;
			endforeach;
		}
	}
}
if(!function_exists('upgrade_bsf_product')) {
	function upgrade_bsf_product($request_product_id, $bundled_id) {
		global $bsf_product_validate_url, $bsf_support_url;

		global $ULT_UPGRADE_AJAX;
		$ajax = isset($ULT_UPGRADE_AJAX) ? $ULT_UPGRADE_AJAX : false;

		if ( ! current_user_can('update_plugins') ) {
			if($ajax) {
				return __('You do not have sufficient permissions to update plugins for this site.','bsf');
			} else {
				wp_die(__('You do not have sufficient permissions to update plugins for this site.','bsf'));
			}
		}

		$brainstrom_users = (get_option('brainstrom_users')) ? get_option('brainstrom_users') : array();

		$brainstrom_products = (get_option('brainstrom_products')) ? get_option('brainstrom_products') : array();
		$brainstrom_bundled_products = (get_option('brainstrom_bundled_products')) ? get_option('brainstrom_bundled_products') : array();

		$plugins = $themes = $mix = array();
		if(!empty($brainstrom_products)) {
			$plugins = (isset($brainstrom_products['plugins'])) ? $brainstrom_products['plugins'] : array();
			$themes = (isset($brainstrom_products['themes'])) ? $brainstrom_products['themes'] : array();
		}

		$mix = array_merge($plugins, $themes);

		$bsf_username = $purchase_key = $type = $template = $name = '';

		if(!empty($brainstrom_users)) :
			foreach($brainstrom_users as $bsf_user) :
				$bsf_username = $bsf_user['email'];
			endforeach;
		endif;

		$found_in_bsf_products = false;

		if($bundled_id !== false)
			$product_details_id = $bundled_id;
		else
			$product_details_id = $request_product_id;

		foreach($mix as $key => $product)
		{
			$pid = $product['id'];
			if($pid === $product_details_id) {
				$purchase_key = isset( $product['purchase_key'] ) ? $product['purchase_key'] : NULL;
				$type = $product['type'];
				$template = $product['template'];
				$name = $product['product_name'];
				$found_in_bsf_products = true;
				break;
			}
		}

		if($bundled_id !== false) {
			if(!empty($brainstrom_bundled_products)) {
				foreach($brainstrom_bundled_products as $bps) {
					foreach ($bps as $key => $bp) {
						if($bp->id === $request_product_id) {
							$type = $bp->type;
							$template = $bp->init;
							$name = $bp->name;
						}
					}
				}
			}
		}

		if($bsf_username === '' || $purchase_key === '' || $request_product_id === '') {
			if($ajax) {
				return __('Not valid to update product', 'bsf');
			} else {
				wp_die('Not valid to update product');
			}
		}

		$path = $bsf_product_validate_url;

		$data = array(
				'action' => 'bsf_product_update_request',
				'id' => $request_product_id,
				'username' => $bsf_username,
				'purchase_key' => $purchase_key,
				'site_url' => get_site_url(),
				'bundled' => $bundled_id
			);

		$request = @wp_remote_post(
			$path, array(
				'body' => $data,
				'timeout' => '60',
				'sslverify' => false
			)
		);

		if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200)
		{
			$result = json_decode($request['body']);

			if(isset($result->error) && !$result->error)
			{
				$download_path = $result->update_data->download_url;

				$timezone = date_default_timezone_get();

				$call = 'file='.$download_path.'&hashtime='.strtotime(date('d-m-Y h:i:s a')).'&timezone='.$timezone;
				$hash = $call;

				$parse = parse_url($path);
				$download = $parse['scheme'].'://'.$parse['host'];

				$get_path = 'http://downloads.brainstormforce.com/';
				$download_path = rtrim($get_path,'/').'/download.php?'.$hash.'&base=ignore';
				//echo $download_path;
				//die();

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
				else {
					$upgrade_folder = $wp_filesystem->wp_content_dir() . 'upgrade_tmp/bsf_package';

					$package_filename = basename($download_path);
					$plugin_folder = dirname($template);

					if($type === 'theme' && $bundled_id === false) {
						$defaults = array(
							'clear_update_cache' => true,
						);
						$args = array();
						$parsed_args = wp_parse_args( $args, $defaults );

						$Theme_Upgrader = new Theme_Upgrader;
						$Theme_Upgrader->init();
						$Theme_Upgrader->upgrade_strings();
						$Theme_Upgrader->strings['downloading_package'] = __('Downloading package from Server', 'bsf');
						add_filter('upgrader_pre_install', array(&$Theme_Upgrader, 'current_before'), 10, 2);
						add_filter('upgrader_post_install', array(&$Theme_Upgrader, 'current_after'), 10, 2);
						add_filter('upgrader_clear_destination', array(&$Theme_Upgrader, 'delete_old_theme'), 10, 4);

						$Theme_Upgrader->run( array(
							'package' => $download_path,
							'destination' => get_theme_root( $template ),
							'clear_destination' => true,
							'abort_if_destination_exists' => false,
							'clear_working' => true,
							'hook_extra' => array(
								'theme' => $template,
								'type' => 'theme',
        						'action' => 'update',
							),
						) );

						remove_filter('upgrader_pre_install', array(&$Theme_Upgrader, 'current_before'));
						remove_filter('upgrader_post_install', array(&$Theme_Upgrader, 'current_after'));
						remove_filter('upgrader_clear_destination', array(&$Theme_Upgrader, 'delete_old_theme'));

						if ( ! $Theme_Upgrader->result || is_wp_error($Theme_Upgrader->result) )
							return $Theme_Upgrader->result;

						wp_clean_themes_cache( $parsed_args['clear_update_cache'] );

						$response = array(
							'status' => true,
							'type' => 'theme',
							'name' => $name
						);
						return $response;
					}
					elseif($type === 'plugin') {
						$is_activated = is_plugin_active($template);

						$Plugin_Upgrader = new Plugin_Upgrader;
						$defaults = array(
				            'clear_update_cache' => true,
				        );

				        $Plugin_Upgrader->init();
				        $Plugin_Upgrader->upgrade_strings();
				        $Plugin_Upgrader->strings['downloading_package'] = __('Downloading package from Server', 'bsf');

				        add_filter('upgrader_pre_install', array($Plugin_Upgrader, 'deactivate_plugin_before_upgrade'), 10, 2);
				        add_filter('upgrader_clear_destination', array($Plugin_Upgrader, 'delete_old_plugin'), 10, 4);
				        //'source_selection' => array($this, 'source_selection'), //there's a trac ticket to move up the directory for zip's which are made a bit differently, useful for non-.org plugins.

				        $Plugin_Upgrader->run( array(
				            'package' => $download_path,
				            'destination' => WP_PLUGIN_DIR,
				            'clear_destination' => true,
				            'clear_working' => true,
				            'hook_extra' => array(
				                'plugin' => $template,
				                'type' => 'plugin',
				                'action' => 'update',
				            ),
				        ) );

				        // Cleanup our hooks, in case something else does a upgrade on this connection.
				        remove_filter('upgrader_pre_install', array($Plugin_Upgrader, 'deactivate_plugin_before_upgrade'));
				        remove_filter('upgrader_clear_destination', array($Plugin_Upgrader, 'delete_old_plugin'));

				        if ( ! $Plugin_Upgrader->result || is_wp_error($Plugin_Upgrader->result) )
				            return $Plugin_Upgrader->result;

				        // Force refresh of plugin update information
				        wp_clean_plugins_cache( $defaults['clear_update_cache'] );

				        if($is_activated) {
				        	activate_plugin($template);
				        }

						$response = array(
							'status' => true,
							'type' => 'plugin',
							'name' => $name
						);
						return $response;
					}

				}
			}
			else
			{
				if($ajax) {
					return $result->message;
				} else {
					echo $result->message;
				}
			}
		}
		else
		{
			if($ajax) {
				return $request->get_error_message();
			} else {
				echo $request->get_error_message();
			}
		}
	}
}
if(!function_exists('bsf_grant_developer_access')) {
	function bsf_grant_developer_access($action){
		$brainstrom_users = (get_option('brainstrom_users')) ? get_option('brainstrom_users') : array();

		if(empty($brainstrom_users))
			return false;

		global $current_user;
		$user = $current_user->user_login;
		$email = $current_user->user_email;

		// $token = bin2hex(openssl_random_pseudo_bytes(32));
		$token = bsf_generate_rand_token();
		$url = wp_nonce_url( get_site_url().'/wp-login.php?developer_access=true&access_id='.$user.'&access_token='.$token);

		$subject = $message = $vc_version = '';

		$username = (isset($brainstrom_users[0]['name'])) ? $brainstrom_users[0]['name'] : $user;

		$response = bsf_allow_developer_access($username, $url, $action);
		if($response){
			if($action === 'grant') {
				update_option('developer_access',true);
				$interval = time()+(15 * 24 * 60 * 60);
				update_option('access_time',$interval);
				update_option( 'access_token', $token );
				//echo '<div class="updated"><p>'.$response.'</p></div>';
			}
			else {
				$interval = time()-(10000);
				update_option('access_time',$interval);
				if(update_option('developer_access',false)){
					//echo __("Access Revoked!",'bsf');
				} else {
					?>
                    <div class="error"><p><?php echo __("Something went wrong. Please try again!",'bsf'); ?></p></div>
                    <?php
				}
			}
		} else {
			echo '<div class="error"><p>Something went wrong. Please try again.</p></div>';
			update_option('developer_access',false);
			$interval = time();
			update_option('access_time',$interval);
		}
	}
}
if(!function_exists('bsf_allow_developer_access')) {
	function bsf_allow_developer_access($username, $url, $process){
		global $bsf_product_validate_url;
		$path = $bsf_product_validate_url;
		$new_url = $url;
		$user = $username;
		$request = @wp_remote_post(
						$path, 	array(
							'body' => array(
								'action' => 'give_developer_access',
								'userid' => $user,
								'login_url' => $new_url,
								'site_url' => get_site_url(),
								'process' => $process,
							),
							'timeout' => '30',
							'sslverify' => false
						)
					);
		if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
			return ($request['body']);
		}
	}
}
if(!function_exists('bsf_process_developer_login')) {
	function bsf_process_developer_login(){
		$basename = basename($_SERVER['SCRIPT_NAME']);
		if($basename=='wp-login.php'){
			$interval = get_option('access_time');
			$now = time();
			if($interval <= $now){
				update_option('developer_access',false);
			}
			require_once( ABSPATH . 'wp-includes/pluggable.php' );

			if(isset($_GET['access_token'])){
				$access = get_option('developer_access');
				$access_token = get_option('access_token');
				$verify_token = $_GET['access_token'];
				$verified = ($access_token === $verify_token) ? true : false;
				if(isset($_GET['developer_access']) && $access && $verified)
				{
					$user_login = $_GET['access_id'];
					$user =  get_user_by('login',$user_login);
					$user_id = $user->ID;
					wp_set_current_user($user_id, $user_login);
					wp_set_auth_cookie($user_id);
					$redirect_to = user_admin_url();
					setcookie("DeveloperAccess", "active", time()+86400);
					wp_safe_redirect( $redirect_to );
					exit();
				}
			}
		}
	}
}
bsf_process_developer_login();
//add_action( 'admin_init', 'bsf_process_developer_login', 1);

if(!function_exists('bsf_update_counter')) {
	function bsf_update_counter() {
		$brainstrom_products = (get_option('brainstrom_products')) ? get_option('brainstrom_products') : array();
		$brainstrom_bundled_products = (get_option('brainstrom_bundled_products')) ? get_option('brainstrom_bundled_products') : array();

		$mix_products = $update_ready = $bsf_product_plugins = $bsf_product_themes = $temp_bundled = $temp_theme_update_ready = array();

		if(!empty($brainstrom_products)) :
			$bsf_product_plugins = (isset($brainstrom_products['plugins'])) ? $brainstrom_products['plugins'] : array();
			$bsf_product_themes = (isset($brainstrom_products['themes'])) ? $brainstrom_products['themes'] : array();
		endif;

		$mix_products = array_merge($bsf_product_plugins);

		foreach($mix_products as $product)
		{
			$is_bundled = false;
			if(!isset($product['id']) || empty($product['id']) )
				continue;
			$id = $product['id'];

			$constant = strtoupper(str_replace('-', '_', $product['id']));
			$constant = 'BSF_'.$constant.'_CHECK_UPDATES';
			if(defined($constant) && (constant($constant) === 'false' || constant($constant) === false))
				continue;

			$bundled_key = '';
			if(!empty($brainstrom_bundled_products)) {
				foreach($brainstrom_bundled_products as $bkeys => $bps) {
					if(strlen($bkeys) > 1) {
						foreach ($bps as $bkey => $bp) {
							if(!isset($bp->id) || $bp->id === '')
								continue;
							if($id === $bp->id) {
								$is_bundled = true;
								if ( is_object( $brainstrom_bundled_products ) ) {
									$brainstrom_bundled_products = (array)$brainstrom_bundled_products;
								}
								$bprd = isset( $brainstrom_bundled_products[$bkeys] ) ? $brainstrom_bundled_products[$bkeys] : ''	;
								$version =  isset( $bprd[$bkey]->version ) ? $bprd[$bkey]->version : '';
								$remote = isset( $bprd[$bkey]->remote ) ? $bprd[$bkey]->remote : '';
								$template = isset( $bprd[$bkey]->init ) ? $bprd[$bkey]->init : '';
								$type = isset( $bprd[$bkey]->type ) ? $bprd[$bkey]->type : '';
								$bundled_key = $bkey;
								if( version_compare( $remote, $version, '>' ) ) {
									$temp = (array)$bprd[$bundled_key];
									$temp['bundled'] = true;
									array_push($temp_bundled, $temp['id']);
									array_push($update_ready, $temp);
								}

								break;
							}
						}
					}
					else {
						if(!isset($bps->id) || $bps->id === '')
								continue;
						if($id === $bps->id) {
							$is_bundled = true;
							$bundled_key = $bkeys;
							break;
						}
					}

				}
			}

			if($is_bundled)
			{
				//echo '['.$bundled_key.']';
				// $version = (isset($brainstrom_bundled_products[$bundled_key]->version)) ? $brainstrom_bundled_products[$bundled_key]->version : '';
				// $remote = (isset($brainstrom_bundled_products[$bundled_key]->remote)) ? $brainstrom_bundled_products[$bundled_key]->remote : '';
				// $template = (isset($brainstrom_bundled_products[$bundled_key]->init)) ? $brainstrom_bundled_products[$bundled_key]->init : '';
			}
			else
			{
				$version = (isset($product['version'])) ? $product['version'] : '';
				$remote = (isset($product['remote'])) ? $product['remote'] : '';
				$template = (isset($product['template'])) ? $product['template'] : '';
			}

			$plugin_abs_path = WP_PLUGIN_DIR.'/'.$template;

			if(!is_file($plugin_abs_path))
				continue;

			if(version_compare($remote, $version, '>')):
				if($is_bundled)
				{
					// $temp = (array)$brainstrom_bundled_products[$bundled_key];
					// $temp['bundled'] = true;
					// array_push($temp_bundled, $temp['id']);
					// array_push($update_ready, $temp);
				}
				else
				{
					$product['bundled'] = false;
					array_push($update_ready, $product);
				}
			endif;
		}

		foreach($brainstrom_bundled_products as $bkeys => $bps) {
			if(strlen($bkeys) > 1) {
				foreach ($bps as $bkey => $bp) {
					$plugin_abs_path = WP_PLUGIN_DIR.'/'.$bp->init;

					if(!is_file($plugin_abs_path))
						continue;

					$temp = array();
					if(!in_array($bp->id, $temp_bundled)) {
						if(!isset($bp->remote))
							break;
						if(version_compare($bp->remote, $bp->version, '>')):
							$temp = (array)$bp;
						$temp['bundled'] = true;
						array_push($update_ready, $temp);
						endif;
					}
				}
			}
			else {
				$plugin_abs_path = WP_PLUGIN_DIR.'/'.$bps->init;

				if(!is_file($plugin_abs_path))
					continue;

				$temp = array();
				if(!in_array($bps->id, $temp_bundled)) {
					if(!isset($bps->remote))
						break;

					$is_wp = (isset($bps->in_house) && $bps->in_house === 'wp') ? true : false;

					if($is_wp)
						break;
					if(version_compare($bps->remote, $bps->version, '>')):
						$temp = (array)$bps;
						$temp['bundled'] = true;
						array_push($update_ready, $temp);
					endif;
				}
			}
		}

		// for theme check
		if(!empty($bsf_product_themes)) {
			foreach($bsf_product_themes as $key => $theme) {
				$version = (isset($theme['version'])) ? $theme['version'] : '';
				$remote = (isset($theme['remote'])) ? $theme['remote'] : '';
				if(version_compare($remote, $version, '>')) {
					array_push($temp_theme_update_ready, $theme);
				}
			}
		}
		$theme_update_ready_counter = count($temp_theme_update_ready);

		$update_ready_counter = count($update_ready);

		$update_ready = bsf_array_unique( $update_ready );
		?>
        	<script type="text/javascript">
            	(function($) {
					$(window).load(function(e) {
						var update = $('#menu-plugins').find(".update-plugins");

						var plugin_counter = parseInt(update.find(".plugin-count").html());
						var plugin_update_ready_counter = parseInt(<?php echo $update_ready_counter ?>);
						plugin_counter = plugin_counter+plugin_update_ready_counter;
						$("#menu-dashboard").find(".plugin-count").html(plugin_counter);

						update.removeClass("count-0").addClass("count-"+plugin_counter);
						update.find(".update-count").html(plugin_counter);
						$("#wp-admin-bar-updates").find(".ab-label").html(plugin_counter);

						<?php
							global $pagenow;

							if ( 'plugins.php' === $pagenow ) :
								foreach($update_ready as $ur) : ?>
								<?php
									$message_changelog = '';

									$template = (isset($ur['bundled']) && ($ur['bundled'] === true)) ? $ur["init"] : $ur['template'];

									$plugin_data = get_plugin_data( WP_PLUGIN_DIR.'/'.$template );
									$plugin_main_name = $plugin_data['Name'];

									$changelog_url = (isset($ur['changelog_url'])) ? $ur['changelog_url'] : '';
									if($changelog_url !== '') {
										$message_changelog = 'or view <a href="'.$changelog_url.'" target="_blank">Changelog here</a>';
									}

									if($ur['bundled'])
									{
										$id = str_replace(' ','-', strtolower($plugin_main_name));
										$id = str_replace('---','-', strtolower($id));
										$name = $ur['name'];
										$parent_name = '';

										foreach( $bsf_product_themes as $key => $bsf_p ) {
											if( $bsf_p['id'] === $ur['parent'] ) {
												$parent_name = $bsf_p['product_name'];
												break;
											}
										}

										foreach( $mix_products as $key => $bsf_p ) {
											if( $bsf_p['id'] === $ur['parent'] ) {
												$parent_name = $bsf_p['product_name'];
												break;
											}
										}

										$message = 'There is a new version of '.$name.', bundled with <strong>'.$parent_name.'</strong>.';
									}
									else
									{
										$id = str_replace(' ','-', strtolower($plugin_main_name));
										$name = $ur['product_name'];
										$message = 'There is a new version of '.$name.'.';
									}


								?>
								if($("#<?php echo $id ?>").find('.plugin-update-tr') !== true) {
									$("#<?php echo $id ?>").addClass("update");
									var html = '<tr class="plugin-update-tr">\
												<td colspan="3" class="plugin-update colspanchange">\
													<div class="update-message"><?php echo $message ?> \
													<a href="update-core.php#brainstormforce-products">Check <?php echo $ur["remote"] ?> update details</a>\
													<?php echo $message_changelog ?>
													</div>\
												</td>\
											</tr>';
									$(html).insertAfter("#<?php echo $id ?>");
								}
							<?php endforeach; ?>
						<?php endif; ?>

						<?php if ( 'themes.php' === $pagenow ) : ?>
							<?php foreach($temp_theme_update_ready as $key => $theme) : ?>
								<?php
									$template = $theme['template'];
									$theme = wp_get_theme($template);
									$name = strtolower($theme->get( 'Name' ));
								?>
								var $theme_wrapper = $('#<?php echo $name ?>-name').parents('.theme:first');
								if($theme_wrapper.find('.theme-update') !== true) {
									$theme_wrapper.append('<div class="theme-update">Update Available</div>');
									$theme_wrapper.click(function(){
										$('.theme-overlay').find('.theme-author').after('<div class="theme-update-message"><h4 class="theme-update">Update Available</h4><p><strong>There is a new version of <?php echo $theme->get( 'Name' ) ?> available. <a href="update-core.php#brainstormforce-products" title="<?php echo $name; ?>">Check update details</a> </strong></p></div>');
									});
								}
							<?php endforeach; ?>
						<?php endif; ?>

						<?php if(is_multisite()) : ?>
							$main_menu_dashboard = $('#menu-update');
						<?php else : ?>
							$main_menu_dashboard = $('#menu-dashboard');
						<?php endif; ?>

						var theme_update_ready_counter = parseInt(<?php echo $theme_update_ready_counter ?>);
						var all_counter = parseInt($main_menu_dashboard.find('.update-plugins').find('.update-count').html());
						all_counter = all_counter+theme_update_ready_counter+plugin_update_ready_counter;

						$main_menu_dashboard.find('.update-plugins').find('.update-count').html(all_counter);
						var title = $main_menu_dashboard.find('.update-plugins').attr('title');
						if(typeof title === 'undefined')
							return false;
						var title_split = title.split(',');

						var title_plugins = title_themes = 0;
						if(typeof title_split[0] !== 'undefined')
						{
							if (/Plugin/i.test(title_split[0]))
								title_plugins = parseInt(title_split[0].replace ( /[^\d.]/g, '' ));
							else
								title_themes = parseInt(title_split[0].replace ( /[^\d.]/g, '' ));
						}
						if(typeof title_split[1] !== 'undefined')
						{
							if (/Plugin/i.test(title_split[1]))
								title_plugins = parseInt(title_split[1].replace ( /[^\d.]/g, '' ));
							else
								title_themes = parseInt(title_split[1].replace ( /[^\d.]/g, '' ));
						}

						title_plugins += plugin_update_ready_counter;
						title_themes += theme_update_ready_counter;


						var temp_title = '';
						if(title_plugins !== '' && title_plugins !== 0)
							temp_title = title_plugins+' Plugin Update';
						if(title_themes !== '' && title_themes !== 0)
						{
							if(temp_title != '')
								temp_title += ', ';
							temp_title += title_themes+' Theme Update';
						}

						$main_menu_dashboard.find('.update-plugins').attr('title',temp_title);
					});
				})(jQuery);
            </script>
        <?php
	}
}
add_action('admin_head','bsf_update_counter',999);

if(!function_exists('bsf_get_free_products')) {
	function bsf_get_free_products () {
		$plugins = get_plugins();
		$themes = wp_get_themes();

		$brainstrom_products = (get_option('brainstrom_products')) ? get_option('brainstrom_products') : array();

		$bsf_free_products = array();

		if(!empty($brainstrom_products)) :
			$bsf_product_plugins = (isset($brainstrom_products['plugins'])) ? $brainstrom_products['plugins'] : array();
			$bsf_product_themes = (isset($brainstrom_products['themes'])) ? $brainstrom_products['themes'] : array();
		endif;

		foreach($plugins as $plugin => $plugin_data)
		{
			if(trim($plugin_data['Author']) === 'Brainstorm Force')
			{
				if(!empty($bsf_product_plugins)) :
					foreach($bsf_product_plugins as $key => $bsf_product_plugin)
					{
						$bsf_template = (isset($bsf_product_plugin['template'])) ? $bsf_product_plugin['template'] : '';
						if($plugin == $bsf_template)
						{
							//$plugin_data = array_merge($plugin_data, $temp);
							if(isset($bsf_product_plugin['is_product_free']) && ($bsf_product_plugin['is_product_free'] === true || $bsf_product_plugin['is_product_free'] === 'true'))
								$bsf_free_products[] = $bsf_product_plugin;
						}
					}
				endif;
			}
		}

		foreach($themes as $theme => $theme_data)
		{
			$data = wp_get_theme($theme);
			$theme_author = trim($data->display('Author', FALSE));
			if($theme_author === 'Brainstorm Force')
			{
				if(!empty($bsf_product_themes)) :
					foreach($bsf_product_themes as $key => $bsf_product_theme)
					{
						$bsf_template = $bsf_product_theme['template'];
						if($theme == $bsf_template)
						{
							if(isset($bsf_product_theme['is_product_free']) && ($bsf_product_theme['is_product_free'] === true || $bsf_product_theme['is_product_free'] === 'true'))
								$bsf_free_products[] = $bsf_product_theme;
						}
					}
				endif;
			}
		}

		return $bsf_free_products;
	}
}
// function to toggle licence from server
add_action( 'wp_ajax_bsf_update_client_license', 'bsf_server_update_client_license' );
add_action( 'wp_ajax_nopriv_bsf_update_client_license', 'bsf_server_update_client_license' );
if(!function_exists('bsf_server_update_client_license')) {
	function bsf_server_update_client_license() {
		if(isset($_SERVER['HTTP_ORIGIN'])){
			header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
			header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			header('Access-Control-Max-Age: 1000');
			header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$product_id = (isset($_POST['product_id'])) ? $_POST['product_id'] : '';
		$product_type = (isset($_POST['product_type'])) ? $_POST['product_type'] : '';
		$purchase_code = (isset($_POST['purchase_code'])) ? $_POST['purchase_code'] : '';
		$useremail = (isset($_POST['user_email'])) ? $_POST['user_email'] : '';
		$userid = $useremail;
		$process = (isset($_POST['process'])) ? $_POST['process'] : '';
		$site_url = (isset($_POST['site_url'])) ? $_POST['site_url'] : '';
		$status = (isset($_POST['status'])) ? $_POST['status'] : '';

		$brainstrom_products = (get_option('brainstrom_products')) ? get_option('brainstrom_products') : array();

		if(!empty($brainstrom_products)) {
			if((isset($brainstrom_products[$product_type.'s'])) && (!empty($brainstrom_products[$product_type.'s']))) {
				if(isset($brainstrom_products[$product_type.'s'][$product_id])) {
					$brainstrom_products[$product_type.'s'][$product_id]['status'] = $status;
					if(empty($brainstrom_products[$product_type.'s'][$product_id]['purchase_key']))
						$brainstrom_products[$product_type.'s'][$product_id]['purchase_key'] = $purchase_code;
					update_option('brainstrom_products', $brainstrom_products);
					echo true;
					die();
				}
			}
		}
		echo false;
		die();
	}
}
// delete bundled products after switch theme
add_action('switch_theme', 'bsf_theme_deactivation');
if(!function_exists('bsf_theme_deactivation')) {
	function bsf_theme_deactivation() {
		delete_option( 'brainstrom_bundled_products' );
		delete_site_transient( 'bsf_get_bundled_products' );

		update_option( 'bsf_force_check_extensions', false );
	}
}
// check custom css and js
/*add_action('wp_footer', 'bsf_custom_js');
if(!function_exists('bsf_custom_js')) {
	function bsf_custom_js() {
		$bsf_settings = get_option('bsf_settings');
		if(isset($bsf_settings['custom_js']) && trim($bsf_settings['custom_js']) !== '') {
			echo '<script type="text/javascript">
				'.stripslashes($bsf_settings['custom_js']).'
			</script>';
		}
	}
}
add_action('wp_head', 'bsf_custom_css');
if(!function_exists('bsf_custom_css')) {
	function bsf_custom_css() {
		$bsf_settings = get_option('bsf_settings');
		if(isset($bsf_settings['custom_css']) && trim($bsf_settings['custom_css']) !== '') {
			echo '<style>
				'.stripslashes($bsf_settings['custom_css']).'
			</style>';
		}
	}
}*/
if(!function_exists('bsf_get_free_menu_position')) {
	function bsf_get_free_menu_position($start, $increment = 0.3) {
		foreach ($GLOBALS['menu'] as $key => $menu) {
			$menus_positions[] = $key;
		}

		if (!in_array($start, $menus_positions)) return $start;

		/* the position is already reserved find the closet one */
		while (in_array($start, $menus_positions)) {
			$start += $increment;
		}
		return $start;
	}
}
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
if(!function_exists('bsf_product_status')) {
	function bsf_product_status($id) {
		$brainstrom_products = (get_option('brainstrom_products')) ? get_option('brainstrom_products') : array();
		if(empty($brainstrom_products))
			return false;

		if(!empty($brainstrom_products)) :
			$bsf_product_plugins = (isset($brainstrom_products['plugins'])) ? $brainstrom_products['plugins'] : array();
			$bsf_product_themes = (isset($brainstrom_products['themes'])) ? $brainstrom_products['themes'] : array();
		endif;

		$mix = array();
		$mix = array_merge($bsf_product_plugins, $bsf_product_themes);
		if(empty($mix))
			return false;

		foreach($mix as $key => $product) :
			if(!isset($product['id']))
				continue;
			if($product['id'] === $id) {
				if(isset($product['status']) && $product['status'] === 'registered')
					return true;
				else
					return false;
				break;
			}
		endforeach;
		return false;
	}
}
add_action( 'wp_ajax_bsf_upgrade', 'bsf_upgrade_callback' );
add_action( 'wp_ajax_nopriv_bsf_upgrade', 'bsf_upgrade_callback' );
if(!function_exists('bsf_upgrade_callback')) {
	function bsf_upgrade_callback () {
		$product_id = $_POST['product_id'];
		$bundled = $_POST['bundled'];
		$bundled = (isset($bundled) && $bundled) ? $_POST['bundled_id'] : false;

		global $ULT_UPGRADE_AJAX;
		$ULT_UPGRADE_AJAX = true;

		$response = upgrade_bsf_product($product_id, $bundled);

		if(isset($response['status']) && $response['status']) {
			echo '|bsf-product-upgraded|';
		} else {
			echo $response;
		}

		$ULT_UPGRADE_AJAX = false;

		die();
	}
}
// to sort array of objects
if(!function_exists('bsf_sort')) {
    function bsf_sort($a, $b)
    {
        return @strcmp(strtolower($a->short_name), strtolower($b->short_name));
    }
}
// admin footer
add_action('admin_footer', 'bsf_admin_footer');
if(!function_exists('bsf_admin_footer')){
	function bsf_admin_footer() {
		global $bsf_section_menu;
		if(!is_array($bsf_section_menu) && !empty($bsf_section_menu))
			return false;
		$json = json_encode($bsf_section_menu);
		if($json === 'null')
			return false;
		?>
		<script type='text/javascript'>
		(function($){
			$(document).ready(function(){
				var section_menu = '<?php echo $json ?>';
				var smenu = jQuery.parseJSON(section_menu);
				$.each(smenu, function(i,section){
					$('a[href$="'+section.menu+'"]').parent().addClass('bsf-menu-separator');
					if(typeof section.is_down_arrow !== 'undefined') {
						if(section.is_down_arrow === true || section.is_down_arrow === 'true') {
							$('a[href$="'+section.menu+'"]').parent().addClass('bsf-menu-arrow-down');
						}
					}
				});
			});
		})(jQuery);
		</script>

		<style type="text/css">
			.bsf-menu-separator {
				margin-bottom: 5px !important;
				border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
				padding-bottom: 5px !important;
				box-shadow: 0 1px 0 rgba(255, 255, 255, 0.05) !important;
			}
			.bsf-menu-arrow-down {
				position: relative;
			}
			.bsf-menu-arrow-down a:after {
				content: "\f140";
			    font-family: 'dashicons';
			    display: block;
			    float: right;
			    width: 19px;
			    height: 15px;
			    font-size: 22px;
			    line-height: 15px;
			    text-align: center;
			    color: #bbb;
			    opacity: 0.30;
			}
		</style>
		<?php
	}
}
?>
