<?php
// Alternative function for wp_remote_get
if(!function_exists('bsf_get_remote_version')) {
	function bsf_get_remote_version($products, $check_license){
		global $ultimate_referer;
		global $bsf_product_validate_url;

		$path = $bsf_product_validate_url.'?referer='.$ultimate_referer;

		$data = array(
				'action' => 'bsf_get_product_versions',
				'ids' => $products,
				'linceses_check' => $check_license
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

			bsf_update_license_checked($result->updated_licenses);

			if(!$result->error)
				return $result->updated_versions;
			else
				return $result->error;
		}
	}
}
if(!function_exists('bsf_update_license_checked')) {
	function bsf_update_license_checked($updated_licenses) {
		$brainstrom_products = (get_option('brainstrom_products')) ? get_option('brainstrom_products') : array();
		if(empty($brainstrom_products))
			return false;
		if(empty($updated_licenses))
			return false;

		$is_updated = false;

		foreach($updated_licenses as $license) :
			$product_id = $license->product_id;
			$type = $license->type.'s';
			$new_status = $license->status;
			$purchase_key = $license->purchase_code;
			if(isset($brainstrom_products[$type]) && !empty($brainstrom_products[$type])) {
				if(isset($brainstrom_products[$type][$product_id])) {
					$old_status = $brainstrom_products[$type][$product_id]['status'];
					if($old_status !== $new_status) {
						$brainstrom_products[$type][$product_id]['status'] = $new_status;
						$is_updated = true;
					}
				}
			}
		endforeach;

		if($is_updated)
			update_option('brainstrom_products', $brainstrom_products);
	}
}
if(!function_exists('bsf_check_product_update')) {
	function bsf_check_product_update(){
		$brainstrom_products = (get_option('brainstrom_products')) ? get_option('brainstrom_products') : array();
		$bsf_users = (get_option('brainstrom_users')) ? get_option('brainstrom_users') : array();

		$mix = $bsf_product_plugins = $bsf_product_themes = $registered = $check_license = array();

		if(!empty($bsf_users)) {
			$bsf_user_email = $bsf_users[0]['email'];
			$bsf_user_name = $bsf_users[0]['name'];
		}

		if(!empty($brainstrom_products)) :
			$bsf_product_plugins = (isset($brainstrom_products['plugins'])) ? $brainstrom_products['plugins'] : array();
			$bsf_product_themes = (isset($brainstrom_products['themes'])) ? $brainstrom_products['themes'] : array();
		endif;

		$mix = array_merge($bsf_product_plugins, $bsf_product_themes);

		$is_update = false;
		$temp = '';
		if(!empty($mix)) :
			foreach($mix as $key => $product) :
				if(!isset($product['id']))
					continue;
				$constant = strtoupper(str_replace('-', '_', $product['id']));
				$constant = 'BSF_'.$constant.'_CHECK_UPDATES';
				if(defined($constant) && (constant($constant) === 'false' || constant($constant) === false)) {
					continue;
				}
				array_push($registered, $product['id']);
				//check license array build
				$temp = array();
				$temp['site_url'] = site_url();
				if(!isset($product['purchase_key']))
					continue;
				$is_wp = (isset($product['in_house']) && $product['in_house'] === 'wp') ? true : false;
				if($is_wp)
					continue;
				$temp['purchase_code'] = $product['purchase_key'];
				$temp['user_email'] = $bsf_user_email;
				$temp['user_name'] = $bsf_user_name;
				$temp['product_id'] = $product['id'];
				$temp['type'] = $product['type'];
				array_push($check_license, $temp);

			endforeach;
		endif;
		if(!empty($registered))
		{
			$remote_versions = bsf_get_remote_version($registered, $check_license);

			$brainstrom_products = (get_option('brainstrom_products')) ? get_option('brainstrom_products') : array();
			$brainstrom_bundled_products = (get_option('brainstrom_bundled_products')) ? get_option('brainstrom_bundled_products') : array();

			if($remote_versions !== false)
			{
				if(!empty($remote_versions))
				{
					$is_bundled_update = false;
					foreach($remote_versions as $rkey => $remote_data)
					{
						$rid = (string)$remote_data->id;
						$remote_version = (isset($remote_data->remote_version)) ? $remote_data->remote_version : '';
						$in_house = (isset($remote_data->in_house)) ? $remote_data->in_house : '';
						$on_market = (isset($remote_data->on_market)) ? $remote_data->on_market : '';
						$is_product_free = (isset($remote_data->is_product_free)) ? $remote_data->is_product_free : '';
						$short_name = (isset($remote_data->short_name)) ? $remote_data->short_name : '';
						$changelog_url = (isset($remote_data->changelog_url)) ? $remote_data->changelog_url : '';
						$purchase_url = (isset($remote_data->purchase_url)) ? $remote_data->purchase_url : '';
						if(!empty($bsf_product_plugins))
						{
							foreach($bsf_product_plugins as $key => $plugin)
							{
								if(!isset($plugin['id']))
									continue;
								$pid = (string)$plugin['id'];
								if($pid === $rid)
								{
									$brainstrom_products['plugins'][$key]['remote'] = $remote_version;
									$brainstrom_products['plugins'][$key]['in_house'] = $in_house;
									$brainstrom_products['plugins'][$key]['on_market'] = $on_market;
									$brainstrom_products['plugins'][$key]['is_product_free'] = $is_product_free;
									$brainstrom_products['plugins'][$key]['short_name'] = $short_name;
									$brainstrom_products['plugins'][$key]['changelog_url'] = $changelog_url;
									$brainstrom_products['plugins'][$key]['purchase_url'] = $purchase_url;
									$is_update = true;
								}
							}
						}
						if(!empty($bsf_product_themes))
						{
							foreach($bsf_product_themes as $key => $theme)
							{
								if(!isset($theme['id']))
									continue;
								$pid = $theme['id'];
								if($pid === $rid)
								{
									$brainstrom_products['themes'][$key]['remote'] = $remote_version;
									$brainstrom_products['themes'][$key]['in_house'] = $in_house;
									$brainstrom_products['themes'][$key]['on_market'] = $on_market;
									$brainstrom_products['themes'][$key]['is_product_free'] = $is_product_free;
									$brainstrom_products['themes'][$key]['short_name'] = $short_name;
									$brainstrom_products['themes'][$key]['changelog_url'] = $changelog_url;
									$brainstrom_products['themes'][$key]['purchase_url'] = $purchase_url;
									$is_update = true;
								}
							}
						}

						if(isset($remote_data->bundled_products) && !empty($remote_data->bundled_products)) {
							if(!empty($brainstrom_bundled_products)) {
								foreach($brainstrom_bundled_products as $bkeys => $bps) {
									foreach ($bps as $bkey => $bp) {
										if(!isset($bp->id))
											continue;
										foreach($remote_data->bundled_products as $rbp) {
											if(!isset($rbp->id))
												continue;
											if( $rbp->id === $bp->id ) {
												$bprd = $brainstrom_bundled_products[$bkeys];
												$brainstrom_bundled_products[$bkeys][$bkey]->remote = $rbp->remote_version;
												$brainstrom_bundled_products[$bkeys][$bkey]->parent = $rbp->parent;
												$brainstrom_bundled_products[$bkeys][$bkey]->short_name = $rbp->short_name;
												$brainstrom_bundled_products[$bkeys][$bkey]->changelog_url = $rbp->changelog_url;
												/*$bprd[$bkey]->remote = $rbp->remote_version;
												$bprd[$bkey]->parent = $rbp->parent;
												$bprd[$bkey]->short_name = $rbp->short_name;
												$bprd[$bkey]->changelog_url = $rbp->changelog_url;*/

												//$brainstrom_bundled_products->$bkeys = $bprd;
												$is_bundled_update = true;
											}
										}
									}

								}
							}
						}
					}

					if($is_bundled_update){
						//echo 'CHECK UPDATE FUNCTION'; die();
						/*echo '<pre>';
						print_r($brainstrom_bundled_products);
						echo '</pre>'; die();*/
						update_option('brainstrom_bundled_products', $brainstrom_bundled_products);
					}
				}
			}
		}

		if($is_update)
			update_option('brainstrom_products', $brainstrom_products);

		//new Ultimate_Auto_Update(ULTIMATE_VERSION, 'http://ec2-54-183-173-184.us-west-1.compute.amazonaws.com/updates/?'.time(), 'Ultimate_VC_Addons/Ultimate_VC_Addons.php');
	}
}
if(!defined('BSF_CHECK_PRODUCT_UPDATES'))
	$BSF_CHECK_PRODUCT_UPDATES = true;
else
	$BSF_CHECK_PRODUCT_UPDATES = BSF_CHECK_PRODUCT_UPDATES;

if((false === get_transient( 'bsf_check_product_updates') && ($BSF_CHECK_PRODUCT_UPDATES === true || $BSF_CHECK_PRODUCT_UPDATES === 'true') )) {
	$proceed = true;

	if(phpversion() > 5.2) {
		$bsf_local_transient = get_option('bsf_local_transient');
		if($bsf_local_transient != false) {
			$datetime1 = new DateTime();
			$date_string = gmdate("Y-m-d\TH:i:s\Z", $bsf_local_transient);
			$datetime2 = new DateTime($date_string);

			$interval = $datetime1->diff($datetime2);
			$elapsed = $interval->format('%h');
			$elapsed = $elapsed + ($interval->days*24);
			if($elapsed <= 48 || $elapsed <= '48') {
				$proceed = false;
			}
		}
	}

	if($proceed) {
		global $ultimate_referer;
		$ultimate_referer = 'on-transient-delete';
		bsf_check_product_update();
		update_option('bsf_local_transient', current_time( 'timestamp' ));
		set_transient( 'bsf_check_product_updates', true, 2*24*60*60 );
	}
}

if(!function_exists('get_bsf_product_upgrade_link')) {
	function get_bsf_product_upgrade_link($product) {
		$brainstrom_products = (get_option('brainstrom_products')) ? get_option('brainstrom_products') : array();

		$mix = $bsf_product_plugins = $bsf_product_themes = $registered = array();
		$licence_require_update = '';

		if(!empty($brainstrom_products)) :
			$bsf_product_plugins = (isset($brainstrom_products['plugins'])) ? $brainstrom_products['plugins'] : array();
			$bsf_product_themes = (isset($brainstrom_products['themes'])) ? $brainstrom_products['themes'] : array();
		endif;

		$mix = array_merge($bsf_product_plugins, $bsf_product_themes);
		$status = (isset($product['status'])) ? $product['status'] : '';
		$name = (isset($product['bundled']) && ($product['bundled'])) ? $product['name'] : $product['product_name'];
		$free = (isset($product['is_product_free']) && ($product['is_product_free'] == true || $product['is_product_free'] == 'true')) ? $product['is_product_free'] : 'false';

		$id = $product['id'];

		$original_id = $id;

		$not_registered_msg = 'Activate your licence for one click update.';
		if($product['bundled'])
		{
			$product_name = '';
			$parent = $product['parent'];
			foreach($mix as $key => $bsf_p) {
				if($bsf_p['id'] == $parent) {
					$status = (isset($bsf_p['status'])) ? $bsf_p['status'] : '';
					$product_name = (isset($bsf_p['product_name'])) ? $bsf_p['product_name'] : '';
					$id = $parent;
					break;
				}
			}
			$not_registered_msg = 'This is bundled with '.$product_name.', Activate '.$product_name.'\'s licence for one click update.';
		}

		if ( array_key_exists( 'licence_require_update', $product ) ) {
			$licence_require_update = $product['licence_require_update'];
		}
		//echo '[[['.$licence_require_update.']]]';

		if($status === 'registered' || ($free === true || $free === 'true') || $licence_require_update == 'false' )
		{
			if(defined('BSF_REG_MENU_TO_SETTINGS') && (BSF_REG_MENU_TO_SETTINGS == true || BSF_REG_MENU_TO_SETTINGS == 'true')) {
				$request = 'options-general.php?page=bsf-registration&action=upgrade&id='.$original_id;
			}
			else {
				$request = 'index.php?page=bsf-registration&action=upgrade&id='.$original_id;
			}
			if($product['bundled'])
				$request .= '&bundled='.$id;
			if(is_multisite()) {
				$link = '<a href="'.network_admin_url($request).'" data-pid="'.$original_id.'" data-bundled="'.$product['bundled'].'" data-bid="'.$id.'" class="bsf-update-product-button">'.__('Update '.$name.'.', 'bsf').'</a><span class="spinner bsf-update-spinner"></span>';
			}
			else {
				$link = '<a href="'.admin_url($request).'" data-pid="'.$original_id.'" data-bundled="'.$product['bundled'].'" data-bid="'.$id.'" class="bsf-update-product-button">'.__('Update '.$name.'.', 'bsf').'</a><span class="spinner bsf-update-spinner"></span>';
			}
		}
		else
		{
			if(is_multisite())
				$link = '<a href="'.network_admin_url('index.php?page=bsf-registration&id='.$id).'">'.__($not_registered_msg, 'bsf').'</a>';
			else {
				if(defined('BSF_REG_MENU_TO_SETTINGS') && (BSF_REG_MENU_TO_SETTINGS == true || BSF_REG_MENU_TO_SETTINGS == 'true')) {
					$link = '<a href="'.admin_url('options-general.php?page=bsf-registration&id='.$id).'">'.__($not_registered_msg, 'bsf').'</a>';
				}
				else {
					$link = '<a href="'.admin_url('index.php?page=bsf-registration&id='.$id).'">'.__($not_registered_msg, 'bsf').'</a>';
				}
			}
		}

		return $link;
	}
}
add_action( 'core_upgrade_preamble', 'list_bsf_products_updates', 999 );
if(!function_exists('list_bsf_products_updates')) {
	function list_bsf_products_updates() {
		$brainstrom_products = (get_option('brainstrom_products')) ? get_option('brainstrom_products') : array();
		$brainstrom_bundled_products = (get_option('brainstrom_bundled_products')) ? get_option('brainstrom_bundled_products') : array();

		$mix_products = $update_ready = $bsf_product_plugins = $bsf_product_themes = $temp_bundled = array();

		if(!empty($brainstrom_products)) :
			$bsf_product_plugins = (isset($brainstrom_products['plugins'])) ? $brainstrom_products['plugins'] : array();
			$bsf_product_themes = (isset($brainstrom_products['themes'])) ? $brainstrom_products['themes'] : array();
		endif;

		$mix_products = array_merge($bsf_product_plugins, $bsf_product_themes);

		foreach($mix_products as $product) {
			$is_bundled = false;
			if(!isset($product['id']))
				continue;
			$id = $product['id'];
			$bundled_key = array();
			$bundled_wrapper = array();
			if(!empty($brainstrom_bundled_products)) {
				foreach($brainstrom_bundled_products as $bkeys => $bps) {
					if(strlen($bkeys) > 1) {
						foreach ($bps as $bkey => $bp) {
							/*echo '<pre>';
							print_r($bp);
							echo '</pre>['.$bp->id.' '.$id.']';*/
							if(!isset($bp->id) || $bp->id == '')
								continue;
							if($id === $bp->id) {
								$is_bundled = true;
								$bprd = $brainstrom_bundled_products[$bkeys];
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
						if(!isset($bps->id) || $bps->id == '')
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
				// $type = (isset($brainstrom_bundled_products[$bundled_key]->type)) ? $brainstrom_bundled_products[$bundled_key]->type : 'plugin';
			}
			else
			{
				$version = (isset($product['version'])) ? $product['version'] : '';
				$remote = (isset($product['remote'])) ? $product['remote'] : '';
				$template = (isset($product['template'])) ? $product['template'] : '';
				$type = (isset($product['type'])) ? $product['type'] : '';
			}

			if($type === 'theme')
			{
				$product_abs_path = WP_CONTENT_DIR.'/themes/'.$template;
				if(!is_dir($product_abs_path))
					continue;
			}
			else
			{
				$product_abs_path = WP_PLUGIN_DIR.'/'.$template;
				if(!is_file($product_abs_path))
					continue;
			}

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
		/*echo '<pre>';
		print_r($brainstrom_bundled_products);
		echo '</pre>';*/
		foreach($brainstrom_bundled_products as $bkeys => $bps) {
			if(strlen($bkeys) > 1) {
				foreach ($bps as $bkey => $bp) {
					if(!isset($bp->id) || $bp->id == '')
						continue;
					$plugin_abs_path = WP_PLUGIN_DIR.'/'.$bp->init;

					if(!is_file($plugin_abs_path))
						continue;
					if(!isset($bp->remote))
						continue;

					$temp = array();
					if(!in_array($bp->id, $temp_bundled)) {
						if(version_compare($bp->remote, $bp->version, '>')):
							$is_wp = (isset($bp->in_house) && $bp->in_house === 'wp') ? true : false;
						if($is_wp)
							break;
						$temp = (array)$bp;
						$temp['bundled'] = true;
						array_push($update_ready, $temp);
						endif;
					}
				}
			}
			else {
				if(!isset($bps->id) || $bps->id == '')
					continue;
				$plugin_abs_path = WP_PLUGIN_DIR.'/'.$bps->init;

				if(!is_file($plugin_abs_path))
					continue;
				if(!isset($bps->remote))
					continue;

				$temp = array();
				if(!in_array($bps->id, $temp_bundled)) {
					if(version_compare($bps->remote, $bps->version, '>')):
						$is_wp = (isset($bps->in_house) && $bps->in_house === 'wp') ? true : false;
						if($is_wp)
							break;
						$temp = (array)$bps;
						$temp['bundled'] = true;
						array_push($update_ready, $temp);
					endif;
				}
			}
		}

		$update_ready = bsf_array_unique( $update_ready );

		echo '<h3 id="brainstormforce-products">Brainstorm Force - ' . __( 'Products', 'bsf' ) . '</h3>';

		if(!empty($update_ready)) :
			echo '<p>'. __( 'The following plugins from Brainstorm Force have new versions available.', 'bsf' ).'</p>';
			?>
            <table class="widefat" cellspacing="0" id="update-plugins-table">
                <thead>
                <tr>
                    <th scope="col" class="manage-column"><label><?php _e( 'Name', 'bsf' ); ?></label></th>
                    <th scope="col" class="manage-column"><label><?php _e( 'Installed Version', 'bsf' ); ?></label></th>
                    <th scope="col" class="manage-column"><label><?php _e( 'Latest Version', 'bsf' ); ?></label></th>
                    <th scope="col" class="manage-column"><label><?php _e( 'Actions', 'bsf' ); ?></label></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th scope="col" class="manage-column"><label><?php _e( 'Name', 'bsf' ); ?></label></th>
                    <th scope="col" class="manage-column"><label><?php _e( 'Installed Version', 'bsf' ); ?></label></th>
                    <th scope="col" class="manage-column"><label><?php _e( 'Latest Version', 'bsf' ); ?></label></th>
                    <th scope="col" class="manage-column"><label><?php _e( 'Actions', 'bsf' ); ?></label></th>
                </tr>
                </tfoot>
                <tbody class="plugins">
					<?php
                    foreach($update_ready as $key => $product) :
						$is_bundled = $product['bundled'];

						if($is_bundled)
						{
							if(!isset($product['init']))
								continue;
							if(trim($product['init']) === '' || $product['init'] === false)
								continue;
						}
						else
						{
							if(!isset($product['template']))
								continue;
							if(trim($product['template']) === '' || $product['template'] === false)
								continue;
						}
                    $upgradeLink = get_bsf_product_upgrade_link($product);
                    ?>

                        <tr class='active' id="bsf-row-<?php echo $key ?>">
                            <td class='plugin-title'><strong><?php echo ($product['bundled']) ? $product['name'] : $product['product_name'] ?></strong>
                            	<span><?php _e( 'You have version '.$product['version'].' installed. Update to '.$product['remote'], 'bsf' );?></span></td>
                            <td style='vertical-align:middle'><strong><?php echo __($product['version'], 'bsf'); ?></strong></td>
                            <td style='vertical-align:middle'><strong><?php echo __($product['remote'], 'bsf'); ?></strong></td>
                            <td style='vertical-align:middle'><?php echo $upgradeLink; ?></td>
                      	</tr>

                    <?php
                    endforeach;
					?>
                </tbody>
            </table>
            <?php if(!isset($_GET['noajax'])) : ?>
            <script type="text/javascript">
            (function($){
            	$(document).ready(function(){
            		$('tbody.plugins').on('click', '.bsf-update-product-button', function(e) {
            			e.preventDefault();
            			var $tr = $(this).parents('tr:first');
            			var product_id = $(this).attr('data-pid');
            			var bundled_id = $(this).attr('data-bid');
			            var action = 'bsf_upgrade';
			            var bundled = $(this).attr('data-bundled');

			            var is_product_upgraded = false;

			            var $link = $(this).attr('href');

			            $tr.addClass('bsf-product-updating');

			            $tr.find('.bsf-update-spinner').addClass('show');

			            var data = {
			                'action': action,
			                'product_id': product_id,
			                'bundled' : bundled,
			                'bundled_id' : bundled_id
			            };
			            // We can also pass the url value separately from ajaxurl for front end AJAX implementations
			            jQuery.post(ajaxurl, data, function(response) {
			            	// log response for debugging in client sites.
			            	console.log( response );

			            	var is_ftp = false;

			            	$tr.find('td:nth-child(4)').find('.error_message').remove();
			            	$tr.find('td:nth-child(4)').find('br').remove();
			            	var productName = $tr.find('td:nth-child(4)').text();
			            	productName = productName.replace('Update ', '');
			            	productName = productName.replace('.', '');
			            	var html = $tr.find('td:nth-child(4)').html();
			            	html = html + '<br><span class="error_message">There was some problem updating <strong>'+ productName +'</strong>, Please try again.</span>';

			                var plugin_status = response.split('|');

			                if(/Connection Type/i.test(response)) {
	                            is_ftp = true;
	                            response = 'FTP protected, redirecting to traditional installer.';
	                        }

			                $.each(plugin_status, function(i,res){
			                    if(res === 'bsf-product-upgraded') {
			                        is_product_upgraded = true;
			                    }
			                });
			                if(is_product_upgraded) {
			                    $tr.addClass('bsf-product-upgraded').removeClass('active');
			                    var remote_version = $tr.find('td:nth-child(3)').html();
			                    $tr.find('td:nth-child(4)').html('Updated successfully! <i class="dashicons dashicons-yes"></i>');
			                    $tr.find('td:nth-child(2)').html(remote_version);
			                    $tr.find('td:nth-child(1)').find('span').remove();
			                }
			                else {
			                	$tr.find('td:nth-child(4)').html(response);
			                	setTimeout(function(){
	                                window.location.assign($link);
	                            },2000);
			                }

			                if ( response == '' ) {
			                	$tr.find('td:nth-child(4)').html(html);
			                	$tr.find('td:nth-child(4)').find('span').removeClass('show');
			                	//$tr.find('td:nth-child(4)').append('</br><span>There was some problem updating <strong>'+ val +'</strong>, Please try again.</span>');
			                }
			            });
            		});
            	});
            })(jQuery);
            </script>
        	<?php endif; ?>
           	<?php
		else :
			echo '<p>' . __( 'Your plugins from Brainstorm Force are all up to date.', 'bsf' ) . '</p>';
		endif;
	}
}


/**
 * Unique sort final update ready array
 *
 * @param array
 *
 * @return array with unique plugins
 */
if ( ! function_exists( 'bsf_array_unique' ) ) {
	function bsf_array_unique( $arrs ) {

		$available_inits = array();

		foreach ( $arrs as $key => $arr ) {
			if( array_key_exists( 'init', $arr ) ) {
				if ( in_array( $arr['init'], $available_inits ) ) {
					unset( $arrs[$key] );
				} else {
					array_push( $available_inits , $arr['init']);
				}
			}
		}

		return $arrs;
	}
}
