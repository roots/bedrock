<?php
$tab = '';
if(isset($_POST['bsf-advanced-form-btn'])) {
	$bsf_settings = $_POST['bsf_settings'];
	update_option('bsf_settings', $bsf_settings);
}
?>
<?php
	$request_product_id = (isset($_GET['id'])) ? $_GET['id'] : '';

	$updgrate_action = (isset($_GET['action']) && $_GET['action']==='upgrade') ? $_GET['action'] : '';
	if($updgrate_action === 'upgrade')
	{
		$request_product_id = (isset($_GET['id'])) ? $_GET['id'] : '';
		if($request_product_id !== '')
		{
			if(isset($_GET['bundled']) && $_GET['bundled'] !== '')
				$bundled = $_GET['bundled'];
			else
				$bundled = false;
			?>
            	<div class="clear"></div>
				<div class="wrap bsf-sp-screen">
                	<h2><?php echo __('Upgrading Extension','bsf') ?></h2>
					<?php
                    $response = upgrade_bsf_product($request_product_id, $bundled);
					?>
                    <?php
						if(isset($response['status']) && $response['status']) :
							$url = ($response['type'] === 'theme') ? 'themes.php' : 'plugins.php';
							$txt = ($response['type'] === 'theme') ? 'theme' : 'plugin';
							$name = (isset($response['name'])) ? $response['name'] : '';
							if($name !== '') {
                    			$hashname = preg_replace("![^a-z0-9]+!i", "-", $name);
								$url .= '#'.$hashname;
							}
							if(is_multisite())
								$reg_url = network_admin_url('index.php?page=bsf-registration');
							else {
								if(defined('BSF_REG_MENU_TO_SETTINGS') && (BSF_REG_MENU_TO_SETTINGS == true || BSF_REG_MENU_TO_SETTINGS == 'true')) {
									$reg_url = admin_url('options-general.php?page=bsf-registration');
								}
								else {
									$reg_url = admin_url('index.php?page=bsf-registration');
								}
							}
					?>
                    	<a href="<?php echo (is_multisite()) ? network_admin_url($url) : admin_url($url) ?>"><?php echo __('Manage '.$txt.' here','bsf') ?></a> | <a href="<?php echo $reg_url ?>"><?php echo __('Back to Registration','bsf') ?></a>
                    <?php endif; ?>
            	</div>
         	<?php
			require_once(ABSPATH . 'wp-admin/admin-footer.php');
			exit;
		}
	}

	if(isset($_POST['bsf-developer-access'])) {
		//echo $_POST['bsf-developer-access-action'];
		if(isset($_POST['bsf-developer-access-action']) || $_POST['bsf-developer-access-action'] !== '')
		{
			$dev_action = $_POST['bsf-developer-access-action'];
			bsf_grant_developer_access($dev_action);
		}
	}

	if(isset($_GET['remove-bundled-products']))  {
		delete_option('brainstrom_bundled_products');
		global $ultimate_referer;
        $ultimate_referer = 'on-refresh-bundled-products';
        get_bundled_plugins();
        set_site_transient( 'bsf_get_bundled_products', true, 7*24*60*60 );
		update_option('bsf_local_transient_bundled', current_time( 'timestamp' ));
		//delete_site_transient('bsf_get_bundled_products');

		$redirect = isset( $_GET['redirect'] ) ? urldecode( $_GET['redirect'] ) : '';

		if ( $redirect == '' ) {
			if(is_multisite())
				$redirect = network_admin_url('index.php?page=bsf-registration');
			else {
				if(defined('BSF_REG_MENU_TO_SETTINGS') && (BSF_REG_MENU_TO_SETTINGS == true || BSF_REG_MENU_TO_SETTINGS == 'true')) {
					$redirect = admin_url('options-general.php?page=bsf-registration');
				}
				else {
					$redirect = admin_url('index.php?page=bsf-registration');
				}
			}
		} else {
			$redirect = add_query_arg( 'bsf-reload-page', '', $redirect );
		}

		echo '<script type="text/javascript">window.location = "'.$redirect.'";</script>';
		//wp_redirect($redirect);
	}

	if(isset($_GET['reset-bsf-users'])) {
		delete_option('brainstrom_users');
		delete_option('brainstrom_products');
		delete_option('brainstrom_bundled_products');
		delete_site_transient('bsf_get_bundled_products');
		if(is_multisite())
			$redirect = network_admin_url('index.php?page=bsf-registration');
		else
			$redirect = admin_url('index.php?page=bsf-registration');
		echo '<script type="text/javascript">window.location = "'.$redirect.'";</script>';
		//wp_redirect($redirect);
	}

	if(isset($_GET['force-check-update'])) {
		global $ultimate_referer;
		$ultimate_referer = 'on-force-check-update';
		bsf_check_product_update();
		set_transient( 'bsf_check_product_updates', true, 2*24*60*60 );
		update_option('bsf_local_transient', current_time( 'timestamp' ));
		if(is_multisite())
			$redirect = network_admin_url('update-core.php#brainstormforce-products');
		else
			$redirect = admin_url('update-core.php#brainstormforce-products');
		echo '<script type="text/javascript">window.location = "'.$redirect.'";</script>';
		//if(is_multisite())
			//$redirect = network_admin_url('update-core.php#brainstormforce-products');
		//else
			//$redirect = admin_url('update-core.php#brainstormforce-products');
		//wp_redirect($redirect);
	}

	$author = (isset($_GET['author'])) ? true : false;
	if($author)
		$tab = 'author';

	$is_product_theme = false;
?>
<script type="text/javascript">
(function($){
	"use strict";
	$(document).ready(function(){
		if(window.location.hash) {
			var hash = window.location.hash;
			$('.nav-tab').removeClass('nav-tab-active');
			$('.nav-tab').each(function(i,nav){
				var href = $(nav).attr('href');
				if(href === hash) {
					$(nav).addClass('nav-tab-active');
				}
			});
			$('.bsf-tab').hide();
			$(hash).show();
		}

		if($('body').find('bsf-popup').length == 0)
			$('body').append('<div class="bsf-popup"></div><div class="bsf-popup-message"><div class="bsf-popup-message-inner"></div><span class="bsf-popup-close dashicons dashicons-no-alt"></span></div>');
		$('body').on('click', '.bsf-popup, .bsf-popup-close', function(){
			$('.bsf-popup, .bsf-popup-message').fadeOut(300);
		});
		$('body').on('click', '.bsf-close-reload', function(){
			location.reload();
			$('.bsf-popup, .bsf-popup-message').fadeOut(300);
		});

		/* local storage */
		if (localStorage["bsf_username"]) {
            $('#bsf_username').val(localStorage["bsf_username"]);
        }
        if (localStorage["bsf_useremail"]) {
            $('#bsf_useremail').val(localStorage["bsf_useremail"]);
        }
        if (localStorage["bsf_useremail_reenter"]) {
            $('#bsf_useremail_reenter').val(localStorage["bsf_useremail_reenter"]);
        }
		$('.bsf-pr-input.stored').keyup(function () {
		    localStorage[$(this).attr('name')] = $(this).val();
		});
		$('.bsf-pr-input.stored').change(function () {
		    localStorage[$(this).attr('name')] = $(this).val();
		});
		/* local storage */

		$('body').on('click','.bsf-pr-form-submit', function(){
			var form_id = $(this).attr('data-form-id');
			var $form = $('#'+form_id);
			var $wrapper = $form.parent().parent();

			$wrapper.find('.bsf-spinner').toggleClass('bsf-spinner-show');

			var errors = 0;
			$form.parent().find('.bsf-pr-input').each(function(i,input){
				var type = $(input).attr('type');
				var required = $(input).attr('data-required');
				if(required === 'true' || required === true)
				{
					if(type === 'text')
					{
						$(input).removeClass('bsf-pr-input-required');
						if($(input).val() === '')
						{
							$(input).addClass('bsf-pr-input-required');
							errors++;
						}
					}
				}
			});
			if(errors > 0)
			{
				$wrapper.find('.bsf-spinner').toggleClass('bsf-spinner-show');
				return false;
			}
			var data = $form.serialize();
			$.post(ajaxurl, data, function(response) {
				//console.log($.parseJSON(response));
				//return false;
				localStorage.clear(); // clear local storage on success
				var result = $.parseJSON(response);
				console.log(result);

				if(typeof result === 'undefined' || result === null)
					return false;

				var step = $form.find('input[name="step"]').val();

				var state = '';

				//result.proceed = true;

				if(result.proceed === 'false' || result.proceed === false)
				{
					var html = '';
					if(typeof result.response.title !== 'undefined')
						html += '<h2><span class="dashicons dashicons-info" style="transform: scale(-1);-web-kit-transform: scale(-1);margin-right: 10px;color: rgb(244, 0, 0);  font-size: 25px;"></span>'+result.response.title+'</h2>';
					if(typeof result.response.message_html !== 'undefined')
						html += '<div class="bsf-popup-message-inner-html">'+result.response.message_html+'</div>';
					$('.bsf-popup-message-inner').html(html);
					$('.bsf-popup, .bsf-popup-message').fadeIn(300);
				}
				else if(result.proceed === 'true' || result.proceed === true)
				{
					if(step === 'step-product-registration')
					{
						$wrapper.slideUp(200);
						setTimeout(function(){
							$wrapper.append(result.next_action_html);
							$wrapper.find('.bsf-step-1').remove();
							$wrapper.slideDown(300);
						},300);

					}
					else
					{
						var html = '';
						if(typeof result.response.title !== 'undefined')
							html += '<h2><span class="dashicons dashicons-yes" style="margin-right: 10px;color: rgb(0, 213, 0);  font-size: 25px;"></span>'+result.response.title+'</h2>';
						if(typeof result.response.message_html !== 'undefined')
							html += '<div class="bsf-popup-message-inner-html">'+result.response.message_html+'</div>';
						$('.bsf-popup-message-inner').html(html);

						if(typeof result.state !== 'undefined')
							state = result.state;

						$('.bsf-popup-message').addClass(state);
						$('.bsf-popup, .bsf-popup-message').fadeIn(300);
						$('.bsf-popup').addClass('bsf-close-reload');
						$('.bsf-popup-close').addClass('bsf-close-reload');
						//setTimeout(function(){
							//location.reload();
						//},4000);
					}
				}
				$wrapper.find('.bsf-spinner').toggleClass('bsf-spinner-show');
			});
		});

		$('body').on('click', '.bsf-registration-form-toggle', function(){
			var toggle = $(this).attr('data-toggle');
			if(toggle === 'show-form')
			{
				//$(this).find('span').removeClass('dashicons-arrow-down-alt2').addClass('dashicons-arrow-up-alt2');
				$(this).find('span').addClass('toggle-icon');
				$(this).next('.bsf-pr-form-wrapper').slideDown(300);
				$(this).attr('data-toggle','hide-form');
			}
			else
			{
				//$(this).find('span').removeClass('dashicons-arrow-up-alt2').addClass('dashicons-arrow-down-alt2');
				$(this).find('span').removeClass('toggle-icon');
				$(this).next('.bsf-pr-form-wrapper').slideUp(300);
				$(this).attr('data-toggle','show-form');
			}
		});

		$("input[name='bsf_useremail_reenter']").bind("cut copy paste",function(e){
			e.preventDefault();
		});
	});
})(jQuery);
</script>
<div class="clear"></div>
<div class="wrap bsf-sp-screen">

<?php
	global $bsf_support_url;
	$brainstrom_users = (get_option('brainstrom_users')) ? get_option('brainstrom_users') : array();
	$bsf_user_name = $bsf_user_email = $bsf_token = '';
	$only_author = false;
	if(empty($brainstrom_users) && (!$author)) :
		?>
			<div class="bsf-pr-header">
				<h2><?php echo __("Let's Get Started!",'imedica') ?></h2>
		    	<div class="bsf-pr-decription"><?php echo __('Please register using the form below and get instant access to our support portal, updates, extensions and more!','bsf'); ?></div>
		    </div>
        	<div class="bsf-user-registration-form-wrapper">
            	<div class="bsf-user-registration-inner-wrapper">
                	<div class="bsf-ur-wrap">
                        <form action="" method="post" id="bsf-user-form" class="bsf-pr-form">
                            <input type="hidden" name="action" value="bsf_register_user"/>
                            <div class="bsf-pr-form-row">
                                <input type="text" id="bsf_username" name="bsf_username" value="" spellcheck="false" placeholder="<?php echo __('Your Name','bsf'); ?>" class="bsf-pr-input stored" data-required="true"/>
                            </div>
                            <div class="bsf-pr-form-row">
                                <input type="text" id="bsf_useremail" name="bsf_useremail" value="" spellcheck="false" placeholder="<?php echo __('Your Email Address','bsf'); ?>" class="bsf-pr-input stored" data-required="true"/>
                            </div>
                            <div class="bsf-pr-form-row">
                                <input type="text" id="bsf_useremail_reenter" name="bsf_useremail_reenter" value="" spellcheck="false" placeholder="<?php echo __('Verify Email Address','bsf'); ?>" class="bsf-pr-input stored" data-required="true"/>
                            </div>
                            <div class="bsf-pr-form-row">
                                <input type="checkbox" name="ultimate_user_receive" id="checkbox-subscribe" value="true" checked="checked" data-required="false" />
                                <label class="checkbox-subscribe" for="checkbox-subscribe"><?php echo __('Receive important news, updates & freebies on email.', 'bsf'); ?></label>
                            </div>
                        </form>
                        <div class="bsf-pr-submit-row">
                            <input type="button" class="bsf-pr-form-submit button-primary bsf-button-primary" data-form-id="bsf-user-form" value="<?php echo __('Register and Proceed','bsf'); ?>"/>
                            <span class="spinner bsf-spinner"></span>
                        </div>
                        <div class="bsf-pr-form-row bsf-privacy-stat"><?php echo __('We respect your privacy & of course you can unsubscribe at any time.', 'bsf'); ?></div>
                    </div>
                </div>
            </div>
        <?php
		return false;
	else :
		$bsf_user_email = (isset($brainstrom_users[0]['email'])) ? $brainstrom_users[0]['email'] : '';
		$bsf_user_name = (isset($brainstrom_users[0]['name'])) ? $brainstrom_users[0]['name'] : '';
		if(empty($brainstrom_users))
			$only_author = true;
	endif;
?>
<?php
	$brainstrom_bundled_products = (get_option('brainstrom_bundled_products')) ? get_option('brainstrom_bundled_products') : array();
	$brainstrom_bundled_products_keys = array();
	if(!empty($brainstrom_bundled_products)) :
		foreach($brainstrom_bundled_products as $bkeys => $bps){
			if(strlen($bkeys) > 1) {
				foreach ($bps as $key => $bp) {
					if(!isset($bp->id) || $bp->id == '')
						continue;
					array_push($brainstrom_bundled_products_keys, $bp->id);
				}
			}
			else {
				if(!isset($bps->id) || $bps->id == '')
					continue;
				array_push($brainstrom_bundled_products_keys, $bps->id);
			}
		}
	endif;

	$brainstrom_products = (get_option('brainstrom_products')) ? get_option('brainstrom_products') : array();

	/*echo '<pre>';
	print_r($brainstrom_products);
	echo '</pre>';*/

	$bsf_product_plugins = $bsf_product_themes = array();

	if(!empty($brainstrom_products)) :
		$bsf_product_plugins = (isset($brainstrom_products['plugins'])) ? $brainstrom_products['plugins'] : array();
		$bsf_product_themes = (isset($brainstrom_products['themes'])) ? $brainstrom_products['themes'] : array();
	endif;

	$plugins = get_plugins();
	$themes = wp_get_themes();
?>
	<div class="bsf-pr-header bsf-left-header">
		<h2><?php echo __("Welcome to Brainstorm Force",'bsf') ?></h2>
    	<div class="bsf-pr-decription"><?php echo __('Validate your purchase keys and get eligible for receiving one click updates, extensions and freebies.','bsf'); ?></div>
    </div>

    <div class="inside">
    	<div class="bsf-logged-user-email"><?php echo $bsf_user_email ?></div>
    	<?php
			foreach($plugins as $plugin => $plugin_data)
			{
				if(trim($plugin_data['Author']) === 'Brainstorm Force')
				{
					if(!empty($bsf_product_plugins)) :
						foreach($bsf_product_plugins as $key => $bsf_product_plugin)
						{
							$temp = array();
							if(!isset($bsf_product_plugin['template']))
								continue;
							if(isset($bsf_product_plugin['is_product_free']) && $bsf_product_plugin['is_product_free'] === 'true')
								continue;
							$bsf_template = $bsf_product_plugin['template'];
							if($plugin == $bsf_template)
							{
								$temp['product_info'] = $bsf_product_plugin;
								$plugin_data = array_merge($plugin_data, $temp);
							}
						}
					endif;
					$bsf_plugins[$plugin] = $plugin_data;
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
							$temp = array();
							if(!isset($bsf_product_theme['template']))
								continue;
							if(isset($bsf_product_theme['is_product_free']) && $bsf_product_theme['is_product_free'] === 'true')
								continue;
							$bsf_template = $bsf_product_theme['template'];
							if($theme == $bsf_template)
							{
								$temp['product_info'] = $bsf_product_theme;
								$theme_data = array_merge((array)$theme_data, $temp);
							}
						}
					endif;
					$bsf_themes[$theme] = $theme_data;
				}
			}

			//echo '<pre>';
			//print_r($bsf_themes);
			//echo '</pre>';

			//echo '<pre>';
			//print_r($bsf_plugins);
			//echo '</pre>';
		?>
        <h2 class="nav-tab-wrapper">
        	<?php if(!$only_author) : ?>
        		<a href="#bsf-licenses" class="nav-tab <?php echo ($tab !== 'author') ? 'nav-tab-active' : ''  ?>"><?php echo __('Licenses','bsf') ?></a>
        	<?php endif; ?>
            <a href="#bsf-help" class="nav-tab"><?php echo __('Help','bsf'); ?></a>
            <!--<a href="#bsf-advanced-tab" class="nav-tab"><?php //echo __('Custom Scripts','bsf'); ?></a>-->
            <?php if($author) : ?>
            	<a href="#bsf-author" class="nav-tab <?php echo ($tab === 'author') ? 'nav-tab-active' : '' ?>"><?php echo __('Debug','bsf') ?></a>
            <?php endif; ?>
            <a href="#bsf-system" class="nav-tab"><?php echo __('System Info','bsf'); ?></a>
        </h2>
        	<div id="bsf-licenses" class="bsf-tab <?php echo ($tab !== 'author') ? 'bsf-tab-active' : ''  ?>">
            	<div class="inner">
            	<table class="wp-list-table widefat fixed licenses">
                	<thead>
                    	<tr>
                        	<th scope="col" class="manage-column column-product_name">Product</th>
                            <th scope="col" class="manage-column column-product_version">Version</th>
                            <th scope="col" class="manage-column column-product_status">Purchase code</th>
                            <th scope="col" class="manage-column column-product_action">Action</th>
                     	</tr>
                    </thead>
                    <tbody>
                    	<?php
							$count = $registered_licence = 0;
							if(!empty($bsf_plugins)) :
								foreach($bsf_plugins as $plugin => $plugin_data) :

									$readonly = '';

									if(!isset($plugin_data['product_info']))
										continue;

									$info = $plugin_data['product_info'];

									$status = (isset($info['status'])) ? $info['status'] : '';

									$purchase_key = (isset($info['purchase_key'])) ? $info['purchase_key'] : '';
									$type = (isset($info['type'])) ? $info['type'] : 'plugin';
									$template = (isset($info['template'])) ? $info['template'] : $plugin;
									$id = (isset($info['id'])) ? $info['id'] : '';
									$version = (isset($plugin_data['Version'])) ? $plugin_data['Version'] : '';
									$name = $plugin_data['Name'];
									$purchase_url = (isset($info['purchase_url'])) ? $info['purchase_url'] : 'javascript:void(0)';

									$bsf_username = (isset($info['bsf_username'])) ? $info['bsf_username'] : $bsf_user_name;
									$bsf_useremail = (isset($info['bsf_useremail'])) ? $info['bsf_useremail'] : $bsf_user_email;

									if($request_product_id!='')
										$init_single_product_show = true;
									else
										$init_single_product_show = false;

									if($id === '')
										continue;

									if(in_array($id,$brainstrom_bundled_products_keys))
										continue;

									if($init_single_product_show && $request_product_id !== $id)
										continue;

									$constant = 'BSF_REMOVE_'.$id.'_FROM_REGISTRATION_LISTING';
									if(defined($constant) && ($constant == 'true' || $constant == true))
										continue;

									$step = (isset($plugin_data['step']) && $plugin_data['step'] != '') ? $plugin_data['step'] : 'step-product-registration';

									$common_data = ' data-product-id="'.$id.'" ';
									$common_data .= ' data-bsf_username="'.$bsf_username.'" ';
									$common_data .= ' data-bsf_useremail="'.$bsf_useremail.'" ';
									$common_data .= ' data-product-type="'.$type.'" ';
									$common_data .= ' data-template="'.$template.'" ';
									$common_data .= ' data-version="'.$version.'" ';
									$common_data .= ' data-step="'.$step.'" ';
									$common_data .= ' data-product-name="'.$name.'" ';

									$mod = ($count%2);
									$alternate = ($mod) ? 'alternate' : '';
									$row_id = 'bsf-row-'.$count;

									if($status === 'registered')
									{
										$readonly = ' readonly="readonly" ';
										$common_data .= ' data-action="bsf_deregister_product" ';
										$registered_licence++;
									}
									else
									{
										$common_data .= ' data-action="bsf_register_product" ';
									}

									?>
										<tr id="<?php echo $row_id ?>" class="<?php echo $alternate.' '.$status ?>">
											<td><?php echo $name ?></td>
											<td><?php echo $plugin_data['Version'] ?></td>
                                            <td><input type="text" class="bsf-form-input" name="purchase_key" spellcheck="false" data-required="true" value="<?php echo $purchase_key ?>" <?php echo $readonly ?>/></td>
                                            <td>
                                            	<?php if($status !== 'registered') : ?>
                                            		<input type="button" class="button button-primary bsf-submit-button" value="Register" data-row-id="<?php echo $row_id ?>" <?php echo $common_data; ?>/>
                                            		<a href="<?php echo $purchase_url; ?>" target="_blank" class="bsf-purchase-link" data-row-id="<?php echo $row_id ?>" />Buy License</a> <span class="spinner bsf-spinner"></span>
                                               	<?php else : ?>
                                                	<input type="button" class="button bsf-submit-button-deregister" value="De-register" data-row-id="<?php echo $row_id ?>" <?php echo $common_data; ?>/> <span class="spinner bsf-spinner"></span>
                                                <?php endif; ?>
                                         	</td>
										</tr>
									<?php
									$count++;
								endforeach;
							endif;

							if(!empty($bsf_themes)) :

								foreach($bsf_themes as $theme => $theme_data) :

									//echo '<pre>';
									//print_r($theme_data);
									//echo '</pre>';
									$readonly = '';

									if(isset($theme_data['product_info']))
										$info = $theme_data['product_info'];
									else
										continue;
									$status = (isset($info['status'])) ? $info['status'] : '';

									$bsf_username = (isset($info['bsf_username'])) ? $info['bsf_username'] : $bsf_user_name;
									$bsf_useremail = (isset($info['bsf_useremail'])) ? $info['bsf_useremail'] : $bsf_user_email;
									$purchase_key = (isset($info['purchase_key'])) ? $info['purchase_key'] : '';
									$type = (isset($info['type'])) ? $info['type'] : 'theme';
									$template = (isset($info['template'])) ? $info['template'] : $plugin;
									$id = (isset($info['id'])) ? $info['id'] : '';
									$purchase_url = (isset($info['purchase_url'])) ? $info['purchase_url'] : 'javascript:void(0)';

									if($request_product_id!='')
										$init_single_product_show = true;
									else
										$init_single_product_show = false;

									if($init_single_product_show && $request_product_id !== $id)
										continue;

									$constant = 'BSF_REMOVE_'.$id.'_FROM_REGISTRATION';
									if(defined($constant) && ($constant == 'true' || $constant == true))
										continue;

									$version = bsf_get_current_version($template, $type);
									$name = bsf_get_current_name($template, $type);

									$step = (isset($theme_data['step']) && $theme_data['step'] != '') ? $theme_data['step'] : 'step-product-registration';

									$common_data = ' data-product-id="'.$id.'" ';
									$common_data .= ' data-bsf_username="'.$bsf_username.'" ';
									$common_data .= ' data-bsf_useremail="'.$bsf_useremail.'" ';
									$common_data .= ' data-product-type="'.$type.'" ';
									$common_data .= ' data-template="'.$template.'" ';
									$common_data .= ' data-version="'.$version.'" ';
									$common_data .= ' data-step="'.$step.'" ';
									$common_data .= ' data-product-name="'.$name.'" ';

									$mod = ($count%2);
									$alternate = ($mod) ? 'alternate' : '';
									$row_id = 'bsf-row-'.$count;

									if($status === 'registered')
									{
										$readonly = ' readonly="readonly" ';
										$common_data .= ' data-action="bsf_deregister_product" ';
										$registered_licence++;
									}
									else
									{
										$common_data .= ' data-action="bsf_register_product" ';
									}

									if($type === 'theme')
										$is_product_theme = true;
									?>
										<tr id="<?php echo $row_id ?>" class="<?php echo $alternate.' '.$status ?>">
											<td><?php echo $name ?></td>
											<td><?php echo $version ?></td>
                                            <td><input type="text" class="bsf-form-input" name="purchase_key" data-required="true" value="<?php echo $purchase_key ?>" <?php echo $readonly ?>/></td>
                                            <td>
                                            	<?php if($status !== 'registered') : ?>
                                            		<input type="button" class="button button-primary bsf-submit-button" value="Register" data-row-id="<?php echo $row_id ?>" <?php echo $common_data; ?>/>
                                            		<a href="<?php echo $purchase_url; ?>" target="_blank" class="bsf-purchase-link" data-row-id="<?php echo $row_id ?>" />Buy License</a> <span class="spinner bsf-spinner"></span>
                                               	<?php else : ?>
                                                	<input type="button" class="button bsf-submit-button-deregister" value="De-register" data-row-id="<?php echo $row_id ?>" <?php echo $common_data; ?>/> <span class="spinner bsf-spinner"></span>
                                                <?php endif; ?>
                                         	</td>
										</tr>
									<?php
									$count++;
								endforeach;
							endif;
						?>
                    </tbody>
                </table>
	                <div class="bsf-listing-cta">
	                	<a href="https://support.brainstormforce.com/license-registration-faqs/" target="_blank">Questions? Having Issues?</a>
	                </div>
                </div>

            </div><!-- bsf-licence-tab -->
            <div id="bsf-help" class="bsf-tab">
            	<div class="inner">
                	<div class="bsf-row">
                    	<div class="bsf-column">
                        	<div class="bsf-column-inner">
                                <h2>Developer Access</h2>
                                <span class="bsf-span"><?php echo __('Enable Developer access','bsf') ?>,<br/><?php echo __('Read more about developer access ','bsf'); ?><a href="<?php echo $bsf_support_url.'license-registration-faqs/#developer-access' ?>" target="_blank"><?php echo __('here','bsf') ?></a></span>
                                <form action="" class="bsf-cp-dev-access" method="post">
                                    <?php
                                        $title = '';
                                        if($registered_licence > 0)
                                            $disabled = '';
                                        else {
                                            $disabled = 'disabled="disabled"';
                                            $title = __('Activate your license to enable!','bsf');
											update_option('developer_access', false);
                                        }

                                        $developer_access = get_option('developer_access');

                                        if($developer_access)
                                        {
                                            $button_text = 'Revoke developer access';
                                            $action = 'revoke';
                                        }
                                        else
                                        {
                                            $button_text = 'Allow developer access';
                                            $action = 'grant';
                                        }
                                    ?>
                                    <input type="hidden" name="bsf-developer-access-action" value="<?php echo $action ?>"/>
                                    <input type="submit" class="button-primary bsf-access-<?php echo $action ?>-button" name="bsf-developer-access" value="<?php echo $button_text ?>" title="<?php echo $title ?>" <?php echo $disabled ?>/>
                                </form>
                            </div>
                        </div>
                        <div class="bsf-column">
                        	<div class="bsf-column-inner">
                                <h2>Force Check Updates</h2>
                                <span class="bsf-span"><?php echo __('Check if there are updates available of plugins by Brainstorm Force.','bsf'); ?></span>
                                <?php
                                	if(is_multisite())
										$reset_url = network_admin_url('index.php?page=bsf-registration&force-check-update');
									else {
										if(defined('BSF_REG_MENU_TO_SETTINGS') && (BSF_REG_MENU_TO_SETTINGS == true || BSF_REG_MENU_TO_SETTINGS == 'true')) {
											$reset_url = admin_url('options-general.php?page=bsf-registration&force-check-update');
										}
										else {
											$reset_url = admin_url('index.php?page=bsf-registration&force-check-update');
										}
									}
                                ?>
                                <a class="button-primary bsf-cp-update-btn" href="<?php echo $reset_url ?>"><?php echo __('Check Updates Now','bsf') ?></a>
                            </div>
                        </div>
                        <div class="bsf-column">
                        	<div class="bsf-column-inner">
                                <h2>Request Support</h2>
                                <?php global $bsf_support_url; ?>
                                <span class="bsf-span"><?php echo __('Having any trouble using our products? Head to our support center to get your issues resolved.','bsf'); ?></span>
                                <a class="button-primary bsf-cp-support-btn" href="<?php echo $bsf_support_url.'request-support/' ?>" target="_blank"><?php echo __('Request Support','bsf') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- bsf-help-tab -->
            <!--<div id="bsf-advanced" class="bsf-tab">
            	<div class="inner">
                	<?php //$bsf_settings = get_option('bsf_settings'); ?>
                	<form action="" method="post" class="bsf-settings-form">
                    	<div class="bsf-pr-form-row bsf-rem-top-margin">
                        	<label>Custom CSS</label>
                            <textarea name="bsf_settings[custom_css]" rows="8" placeholder="html { margin:0 }"><?php //echo (isset($bsf_settings['custom_css'])) ? stripslashes($bsf_settings['custom_css']) : '' ?></textarea>
                        </div>
                        <div class="bsf-pr-form-row">
                        	<label>Custom JS</label>
                            <textarea name="bsf_settings[custom_js]" rows="8" placeholder="alert('Howdy!');"><?php //echo (isset($bsf_settings['custom_js'])) ? stripslashes($bsf_settings['custom_js']) : '' ?></textarea>
                        </div>
                        <div class="bsf-pr-form-row">
                        	<input type="submit" class="button-primary" name="bsf-advanced-form-btn" value="<?php //echo __('Save Changes','bsf'); ?>"/>
                        </div>
                    </form>
                </div>
         	</div><!-- bsf-advanced-tab -->
            <?php if($author) : ?>
			<div id="bsf-author" class="bsf-tab <?php echo ($tab == 'author') ? 'bsf-tab-active' : '' ?>">
            	<div class="inner">
                	<div class="bsf-cp-res-user">
                    	<?php
                    		if(is_multisite())
								$reset_url = network_admin_url('index.php?page=bsf-registration&reset-bsf-users');
							else {
								if(defined('BSF_REG_MENU_TO_SETTINGS') && (BSF_REG_MENU_TO_SETTINGS == true || BSF_REG_MENU_TO_SETTINGS == 'true')) {
									$reset_url = admin_url('options-general.php?page=bsf-registration&reset-bsf-users');
								}
								else {
									$reset_url = admin_url('index.php?page=bsf-registration&reset-bsf-users');
								}
							}
						?>
						<a class="button-primary" href="<?php echo $reset_url ?>"><?php echo __('Reset Site','bsf') ?></a>
                    </div>
                	<div class="bsf-cp-rem-bundle">
	                	<?php
	                		if(is_multisite())
								$url = network_admin_url('index.php?page=bsf-registration&remove-bundled-products');
							else {
								if(defined('BSF_REG_MENU_TO_SETTINGS') && (BSF_REG_MENU_TO_SETTINGS == true || BSF_REG_MENU_TO_SETTINGS == 'true')) {
									$url = admin_url('options-general.php?page=bsf-registration&remove-bundled-products');
								}
								else {
									$url = admin_url('index.php?page=bsf-registration&remove-bundled-products');
								}
							}
						?>
						<a class="button-primary" href="<?php echo $url ?>"><?php echo __('Check Bundled Products','bsf') ?></a>
                    </div>
                </div>
            </div><!-- bsf-author-tab -->
            <?php endif; ?>
            <div id="bsf-system" class="bsf-tab">
            	<div class="inner">
                	<table class="wp-list-table widefat fixed bsf-sys-info">
                    	<tbody>
                        	<tr class="alternate">
                            	<th colspan="2"><?php echo __('WordPress Environment','bsf'); ?></th>
                            </tr>
                            <tr>
                            	<td>Home URL</td><td><?php echo site_url(); ?></td>
                            </tr>
                            <tr>
                            	<td>Site URL</td><td><?php echo site_url(); ?></td>
                            </tr>
                            <tr>
                            	<?php global $wp_version ?>
                            	<td>WP Version</td><td><?php echo $wp_version; ?></td>
                            </tr>
                            <tr>
                            	<td>Multisite</td><td><?php echo (is_multisite()) ? 'Yes' : 'No'; ?></td>
                            </tr>
                            <?php
								$limit = (int) ini_get('memory_limit');
								$usage = function_exists('memory_get_usage') ? round(memory_get_usage() / 1024 / 1024, 2) : 0;
							?>
                            <tr >
                            	<td>Memory Usage</td>
                                <td>
									<?php echo $usage ?>
                                   	MB of
                                    <?php echo $limit ?>
                                   	MB
                                </td>
                            </tr>
                            <tr>
                            	<td>WP Memory Limit</td>
                                <td>
									<?php echo WP_MEMORY_LIMIT ?>
                                </td>
                            </tr>
                            <tr>
                            	<td>WP Debug</td><td><?php echo (WP_DEBUG) ? 'Enabled' : 'Disabled'; ?></td>
                            </tr>
                            <tr>
                            	<td>WP Lang</td><td><?php echo $currentlang = get_bloginfo('language'); ?></td>
                            </tr>
                            <tr>
                            	<td>WP Uploads Directory</td>
                                <td>
									<?php
										$wp_up = wp_upload_dir();
										echo (is_writable($wp_up['basedir'])) ? 'Writable' : 'Readable';
									?>
                                </td>
                            </tr>
                            <tr>
                            	<td>BSF Updater Path</td>
                            	<td>
                            		<?php global $bsf_core_version; ?>
                            		<?php echo '(v'.$bsf_core_version.') '.BSF_UPDATER_PATH; ?>
                            	</td>
                            </tr>
                            <?php if(defined('WPB_VC_VERSION')) : ?>
                            <tr>
                            	<td>vc_shortcode_output Filter</td>
								<td>
                                	<?php echo (has_filter('vc_shortcode_output')) ? 'Available' : 'Not Available'; ?>
                                </td>
                            </tr>
							<?php endif; ?>
							<?php
								$mix = array_merge($bsf_product_plugins, $bsf_product_themes);
								$temp_constant = '';
								if(!empty($mix)) :
									foreach($mix as $key => $product) :
										$constant = strtoupper(str_replace('-', '_', $product['id']));
										$constant = 'BSF_'.$constant.'_CHECK_UPDATES';
										if(defined($constant) && (constant($constant) === 'false' || constant($constant) === false)) {
											$temp_constant .= $constant.'<br/>';
											continue;
										}
									endforeach;
								endif;
								if(defined('BSF_CHECK_PRODUCT_UPDATES') && BSF_CHECK_PRODUCT_UPDATES == false) {
									$temp_constant .= 'BSF_CHECK_PRODUCT_UPDATES';
								}
								if($temp_constant != '') {
									if(!defined('BSF_RESTRICTED_UPDATES')) {
										define('BSF_RESTRICTED_UPDATES', $temp_constant);
									}
								}
							?>
							<?php if(defined('BSF_RESTRICTED_UPDATES')) : ?>
                            <tr>
                            	<td>Restrited Updates Filter</td>
								<td>
                                	<?php echo BSF_RESTRICTED_UPDATES; ?>
                                </td>
                            </tr>
							<?php endif; ?>
						</tbody>
					</table>
					<table class="wp-list-table widefat fixed bsf-sys-info">
                    	<tbody>
                            <tr class="alternate">
                            	<th colspan="2"><?php echo __('Server Environment','bsf'); ?></th>
                            </tr>
                            <tr>
                            	<td>Server Info</td><td><?php echo $_SERVER['SERVER_SOFTWARE'] ?></td>
                            </tr>
                            <tr>
                            	<td>PHP Version</td><td><?php echo (function_exists('phpversion')) ? phpversion() : 'Not sure'; ?></td>
                            </tr>
                            <tr>
                            	<td>MYSQL Version</td><td><?php echo (function_exists('mysql_get_server_info')) ? @mysql_get_server_info() : 'Not sure'; ?></td>
                            </tr>
                            <tr>
                            	<td>PHP Post Max Size</td><td><?php echo ini_get('post_max_size'); ?></td>
                            </tr>
                            <tr>
                            	<td>PHP Max Execution Time</td><td><?php echo ini_get('max_execution_time'); ?> Seconds</td>
                            </tr>
                            <tr>
                            	<td>PHP Max Input Vars</td><td><?php echo ini_get('max_input_vars'); ?></td>
                            </tr>
                       		<tr>
                            	<td>Max Upload Size</td><td><?php echo ini_get("upload_max_filesize"); ?></td>
                            </tr>
                            <tr>
                            	<td>Default Time Zone</td>
                                <td>
									<?php
										if (date_default_timezone_get()) {
											echo date_default_timezone_get();
										}
										if(ini_get('date.timezone')) {
											echo ' '.ini_get('date.timezone');
										}
									?>
                             	</td>
                            </tr>
                            <tr class="<?php echo (!function_exists('curl_version')) ? 'bsf-alert' : ''; ?>">
                            	<td>cURL</td>
                                <td>
									<?php
										if(function_exists('curl_version')) {
											$curl_info = curl_version();
											echo $curl_info['version'];
										}
										else {
											echo 'Not Enabled';
										}
									?>
                              	</td>
                            </tr>
                            <tr class="<?php echo (!function_exists('curl_version')) ? 'bsf-alert' : ''; ?>">
                            	<td>SimpleXML</td>
                                <td>
									<?php
										if (extension_loaded('simplexml')) {
										    echo "All good, extension is installed";
										} else {
											echo "Oops! extension not installed, Icon Manager will not work";
										}
									?>
                              	</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="wp-list-table widefat fixed bsf-sys-info">
                    	<tbody>
                            <tr class="alternate">
                            	<th colspan="2"><?php echo __('Theme Information','bsf'); ?></th>
                            </tr>
                            <?php $theme_data = wp_get_theme(); ?>
                            <tr>
								<td>Name</td>
								<td><?php echo $theme_data->Name ?></td>
							</tr>
							<tr>
								<td>Version</td>
								<td><?php echo $theme_data->Version ?></td>
							</tr>
							<tr>
								<td>Author</td>
								<td><a href="<?php echo $theme_data->ThemeURI ?>"><?php echo $theme_data->Author ?></a></td>
							</tr>
						</tbody>
					</table>
					<table class="wp-list-table widefat fixed bsf-sys-info bsf-table-active-plugin">
                    	<tbody>
                            <tr class="alternate">
                            	<th colspan="4"><?php echo __('Installed Plugins','bsf'); ?></th>
                            </tr>
                        	<?php
								$plugins = get_plugins();
								asort($plugins);
								foreach($plugins as $plugin_file => $plugin_data) {
									?>
                                    <tr>
                                    	<td><?php echo str_pad($plugin_data['Title'], 30); ?></td>
                                        <td>
                                        	<?php
												if(is_plugin_active($plugin_file)) {
													echo str_pad('Active', 10);
												} else {
													echo str_pad('Inactive', 10);
												}
											?>
                                        </td>
                                        <td><?php echo str_pad($plugin_data['Version'], 10) ?></td>
                                        <td><?php echo $plugin_data['Author'] ?></td>
                                    </tr>
                                    <?php
								}
                       		?>
                        </tbody>
                    </table>
                </div>
         	</div><!-- bsf-system-tab -->
    </div>
</div>
<script type="text/javascript">
(function($){
	"use strict";
	$(document).ready(function(){
		$('body').on('click','.bsf-submit-button', function(){
			var row_id = $(this).attr('data-row-id');
			var $row = $('#'+row_id);

			var errors = 0;

			$row.find('.bsf-spinner').toggleClass('bsf-spinner-show');

			var purchase_key = $row.find('input[name="purchase_key"]').val();

			var product_id = $(this).attr('data-product-id');
			var username = $(this).attr('data-bsf_username');
			var useremail = $(this).attr('data-bsf_useremail');
			var product_type = $(this).attr('data-product-type');
			var template = $(this).attr('data-template');
			var version = $(this).attr('data-version');
			var step = $(this).attr('data-step');
			var product_name = $(this).attr('data-product-name');

			var action = $(this).attr('data-action');

			var admin_url = '<?php echo (is_multisite()) ? rtrim(network_admin_url(),'/') : rtrim(admin_url(),'/'); ?>';

			$row.find('.bsf-form-input').each(function(i,input){
				var type = $(input).attr('type');
				var required = $(input).attr('data-required');
				if(required === 'true' || required === true)
				{
					if(type === 'text')
					{
						$(input).removeClass('bsf-pr-input-required');
						if($(input).val() === '')
						{
							$(input).addClass('bsf-pr-input-required');
							errors++;
						}
					}
				}
			});
			if(errors > 0)
			{
				$row.find('.bsf-spinner').toggleClass('bsf-spinner-show');
				return false;
			}

			var data = {
				action: action,
				bsf_username: username,
				bsf_useremail: useremail,
				purchase_key: purchase_key,
				type: product_type,
				id: product_id,
				product: template,
				version: version,
				step: step,
				product_name: product_name
			};

			$.post(ajaxurl, data, function(response) {
				console.log(response);
				//return false;
				var result = $.parseJSON(response);
				console.log(result);

				if(typeof result === 'undefined' || result === null)
					return false;

				//result.proceed = true;

				if(result.proceed === 'false' || result.proceed === false)
				{
					var html = '';
					if(typeof result.response.title !== 'undefined')
						html += '<h2><span class="dashicons dashicons-info" style="transform: scale(-1);-web-kit-transform: scale(-1);margin-right: 10px;color: rgb(244, 0, 0);  font-size: 25px;"></span>'+result.response.title+'</h2>';
					if(typeof result.response.message_html !== 'undefined')
						html += '<div class="bsf-popup-message-inner-html">'+result.response.message_html+'</div>';
					$('.bsf-popup-message-inner').html(html);
					$('.bsf-popup, .bsf-popup-message').fadeIn(300);
				}
				else if(result.proceed === 'true' || result.proceed === true)
				{
					var html = '';
					if(typeof result.response.title !== 'undefined')
						html += '<h2><span class="dashicons dashicons-yes" style="margin-right: 10px;color: rgb(0, 213, 0);  font-size: 25px;"></span>'+result.response.title+'</h2>';
					if(typeof result.response.message_html !== 'undefined')
						html += '<div class="bsf-popup-message-inner-html">'+result.response.message_html+'</div>';
					$('.bsf-popup-message-inner').html(html);
					$('.bsf-popup, .bsf-popup-message').fadeIn(300);
					if(typeof result.after_registration_action !== 'undefined' && result.after_registration_action !== '')
						if ( result.after_registration_action == 'admin.php?page=bsf-extensions' ) {
							window.location.href = admin_url+'/'+result.after_registration_action+'?product_id=10395942';
						} else {
							window.location.href = admin_url+'/'+result.after_registration_action;
						}
					else
						location.reload();
				}
				$row.find('.bsf-spinner').toggleClass('bsf-spinner-show');
			});
		}); //end of submit button

		$('body').on('click','.bsf-submit-button-deregister',function(){
			var row_id = $(this).attr('data-row-id');
			var $row = $('#'+row_id);

			var errors = 0;

			$row.find('.bsf-spinner').toggleClass('bsf-spinner-show');

			var purchase_key = $row.find('input[name="purchase_key"]').val();
			var bsf_username = $(this).attr('data-bsf_username');
			var bsf_useremail = $(this).attr('data-bsf_useremail');
			var product_id = $(this).attr('data-product-id');
			var product_type = $(this).attr('data-product-type');
			var template = $(this).attr('data-template');
			var version = $(this).attr('data-version');
			var name = $(this).attr('data-product-name');

			var action = $(this).attr('data-action');

			var data = {
				action: action,
				purchase_key: purchase_key,
				bsf_username: bsf_username,
				bsf_useremail: bsf_useremail,
				type: product_type,
				id: product_id,
				product: template,
				version: version,
				product_name: name
			};

			console.log(data);

			$.post(ajaxurl, data, function(response) {
				//console.log($.parseJSON(response));
				//return false;
				console.log(response);
				//return false;
				var result = $.parseJSON(response);
				var html = '';
				if(typeof result.response.title !== 'undefined')
					html += '<h2><span class="dashicons dashicons-yes" style="margin-right: 10px;color: rgb(0, 213, 0);  font-size: 25px;"></span>'+result.response.title+'</h2>';
				if(typeof result.response.message_html !== 'undefined')
					html += '<div class="bsf-popup-message-inner-html">'+result.response.message_html+'</div>';
				$('.bsf-popup-message-inner').html(html);
				$('.bsf-popup, .bsf-popup-message').fadeIn(300);
				if(result.proceed === 'true' || result.proceed === true)
				{
					//setTimeout(function(){
						location.reload();
					//},2000);
				}
			});

		}); // end of de-registering licence

		$('body').on('click','.nav-tab',function(event){
			//event.preventDefault();
			$('.nav-tab').removeClass('nav-tab-active');
			$(this).addClass('nav-tab-active');
			var tab = $(this).attr('href');
			$('.bsf-tab').fadeOut(200);
			setTimeout(function(){
				$(tab).fadeIn(200);
			},200);
		}); // end of tabs functionality
	});
})(jQuery);
</script>