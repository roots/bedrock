<?php
ESSBOptionsStructureHelper::field_func('update', 'automatic', 'essb4_text_automatic_updates', '', '');

function essb4_text_automatic_updates() {
	

	
	?>
	
	<style type="text/css">
	.essb-options-header { padding-top: 20px; }
	.essb-options-title { text-align: center; }
	.essb-activation-wrap {
		max-width: 900px;
		width: 100%;	
		margin: 0 auto;		
	}
	
	.essb-activate-welcome {
		padding: 15px;
		background-color: #f5f6f7;
		font-size: 13px;
		line-height: 20px;	
		border-radius: 4px;
		margin-top: 30px;
	}
	
	.essb-button-backtotop { 
		display: none !important;	
	}
	
	.essb-activate-localhost {
		margin-top: 10px;
		font-weight: bold;
	}
	
	.color-notactivated {
		color: #e74c3c;
	}
	
	.background-notactivated {
		background-color: #e74c3c;	
	}
	
	.color-activated {
		color: #27ae60;	
	}
	
	.essb-options-hint-addonhint i {
		color: #27ae60;	
	}
	
	.background-activated {
		background-color: #27ae60;
	}
	
	.essb-activation-form {
		margin-top: 15px;	

	}
	
	.essb-activation-form-title {
		position: relative;
}
	
	.essb-activation-title {
		font-size: 19px;
		font-weight: 600;
		line-height: 32px;
	}
	
	.essb-activation-state {
		font-weight: 600;
		border-radius: 4px;
		padding: 0px 15px;
		line-height: 32px;
		color: #fff;
		font-size: 13px;
		position: absolute;
		right: 0px;
	}
	
	.essb-activation-title, .essb-activation-state {
		display: inline-block;
	}
		
	.essb-activation-form-code {
		clear: both;
		margin-top: 15px;
	}
	
	.essb-activation-buttons {
		clear: both;
		position: relative;
		margin-top: 15px;
}
	
	.essb-purchase-code {
		box-shadow: none !important;
		background-color: #eaeaea !important;
		border-radius: 4px !important;
		padding: 15px;
		font-size: 15px;
		font-weight: 600;
		color: #303133 !important;
		border: 0px !important;	
		width: 100%;
	}
	
	.essb-activation-button {
		font-weight: 600;
		border-radius: 4px;
		padding: 0px 25px;
		line-height: 40px;
		color: #fff;
		font-size: 14px;
		display: inline-block;
		text-decoration: none;
		cursor: pointer;
	}
	
	.essb-activation-button-default {
		background-color: #3498db;
	}
	.essb-activation-button-default:hover, .essb-activation-button-default:active, .essb-activation-button-default:focus {
		background-color: #2c8ac8;
		color: #fff;
		text-decoration: none !important;
	}

		.essb-activation-button-color1 {
		background-color: #BB3658;
	}
	
	.essb-activation-button-color2 {
		background-color: #FD5B03;
}
	
	.essb-activation-button-color1:hover, .essb-activation-button-color1:active, .essb-activation-button-color1:focus {
		background-color: #7E3661;
		color: #fff;
		text-decoration: none !important;
	}

		.essb-activation-button-color2:hover, .essb-activation-button-color2:active, .essb-activation-button-color2:focus {
		background-color: #F04903;
		color: #fff;
		text-decoration: none !important;
	}
	
	
	.essb-button-right {
		float: right;
}
	
.essb-purchase-code::-webkit-input-placeholder {
   color: #aaa;
}

.essb-purchase-code:-moz-placeholder { /* Firefox 18- */
   color: #aaa;  
}

.essb-purchase-code::-moz-placeholder {  /* Firefox 19+ */
   color: #aaa;  
}

.essb-purchase-code:-ms-input-placeholder {  
   color: #aaa;  
}
.essb-activation-form-header strong {
	font-size: 15px;
}
.essb-activation-form-header { margin-bottom: 5px; }
#essb-manual-registration { display: none; }
	</style>
<!--  sweet alerts -->
<script src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/jquery.toast.js"></script> 
<link rel="stylesheet" type="text/css" href="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/jquery.toast.css">
<!--  code mirror include -->
	
	<div class="essb-activation-wrap">

		<?php 
		
		if (!ESSBActivationManager::isActivated() && ESSBActivationManager::isThemeIntegrated()) {
			ESSBOptionsFramework::draw_hint(__('You are using theme integrated version of plugin with the theme you purchase', 'essb'), sprintf(__('<br/>The version of plugin you are using is bundled with theme. Bundled inside theme versions does not have access to direct customer benefits including automatic plugin updates, free extensions, one click ready made styles and etc. <a href="%s" target="_blank"><b>See all direct customer benefits</b></a>', 'essb'), ESSBActivationManager::getBenefitURL()), 'fa32 fa fa-check-circle-o', 'addonhint');
				
		}
		
		?>
	
		
		<div class="essb-activation-form">
			<div class="essb-activation-form-title">
			<div class="essb-activation-title<?php if (ESSBActivationManager::isActivated()) { echo " color-activated"; } else { echo " color-notactivated"; } ?>"><?php echo __('Plugin Activation', 'essb');?></div>
			<div class="essb-activation-state<?php if (ESSBActivationManager::isActivated()) { echo " background-activated"; } else { echo " background-notactivated"; } ?>">
				<i class="fa fa-<?php if (ESSBActivationManager::isActivated() || ESSBActivationManager::isThemeIntegrated()) { echo "check"; } else { echo "ban"; } ?>"></i> <?php if (ESSBActivationManager::isActivated()) { echo __('Activated', 'essb'); } else { 
					if (ESSBActivationManager::isThemeIntegrated()) {
						echo __('Theme Integrated', 'essb');
					}
					else {
						echo __('Not activated', 'essb'); 
					}
				} ?>			
			</div>
			</div>
			
			<div class="essb-activation-form-code">
				<div class="essb-activation-form-header">
					<strong><?php echo __('Purchase code', 'essb');?></strong>
					<br/>You can learn how to find your purchase code <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">here</a>
					
				</div>
				<input type="text" class="essb-purchase-code" id="essb-automatic-purchase-code" value="<?php echo ESSBActivationManager::getPurchaseCode(); ?>" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"/>			
			</div>
			
			
			<div class="essb-activation-buttons">
				<?php if (!ESSBActivationManager::isActivated()) { ?>
				<a href="#" id="essb-activate" class="essb-activation-button essb-activation-button-default essb-activate-plugin"><?php echo __('Register the code', 'essb'); ?></a>
				<?php } ?>
				<?php if (ESSBActivationManager::isActivated()) { ?>
				<a href="#" id="essb-deactivate" class="essb-activation-button essb-activation-button-default essb-deactivate-plugin"><?php echo __('Deregister the code', 'essb'); ?></a>
				<?php } ?>
				<a href="<?php echo ESSBActivationManager::getApiUrl('manager').'?purchase_code='.ESSBActivationManager::getPurchaseCode();?>" target="_blank" id="essb-manager" class="essb-activation-button essb-activation-button-color1 essb-manage-activation-plugin essb-button-right"><?php echo __('Manage my activations', 'essb'); ?></a>
				<a href="http://go.appscreo.com/activate-essb" target="_blank" id="essb-manager1" class="essb-activation-button essb-activation-button-color2 essb-manage-activation-plugin essb-button-right" style="margin-right: 5px;"><?php echo __('Need help with activation?', 'essb'); ?></a>
				</div>
			
			
		</div>
		
		<?php 		
		if (ESSBActivationManager::isActivated()) {
		?>
		<div class="essb-activate-welcome">
		<p style="text-align: center; font-weight: bold;">In order to register your purchase code on another domain, deregister it first by clicking the button above or get another purchase code. You can also check and manage your activations via Manage my activations button</p>
	<p style="text-align:center;"><a href="http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476?ref=appscreo&license=regular&open_purchase_for_item_id=6394476&purchasable=source" target="blank" class="essb-activation-button essb-activation-button-color2">Purchase new copy of Easy Social Share Buttons for just $19</a></p>
		</div>
		<?php 
		}
		?>
		
		<?php if (!ESSBActivationManager::isActivated()) { ?>
		
			<?php if (!ESSBActivationManager::isThemeIntegrated()) { ?>
				<div class="essb-activate-welcome">
			Thank you for choosing Easy Social Share Buttons for WordPress! Your product must be registered to unlock automatic updates, ready made design library and our free add-ons library. 
			
			<p>To activate plugin you need to fill in valid purchase code for Easy Social Share Buttons for WordPress. <b>If you have plugin bundled into theme that you bought to activate automatic updates, access to our add-ons library, full access to ready made presents library and our premium support you need to buy separate license for Easy Social Share Buttons for WordPress.</b>.</p>
			<p>One purchase code can be used on one domain. If registered elsewhere please deactivate that registration first. Usage of one purchase code on multiple sites at same time will block automatic updates for all of them and you will not be able to access restricted by activation functions of plugin.</p>
	<p style="text-align:center;"><a href="http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476?ref=appscreo&license=regular&open_purchase_for_item_id=6394476&purchasable=source" target="blank" class="essb-activation-button essb-activation-button-color2">Purchase new copy of Easy Social Share Buttons for just $19</a></p>
			
		<?php 
		
		if (ESSBActivationManager::isDevelopment()) {
			print '<div class="essb-activate-localhost">';
			print __('You are running plugin on development environment. Activation in this case is optional and it will allow you to use locked plugin features without reflecting activation on your real site.', 'essb');
			print '</div>';
		}
		
		?>
			
		</div>
		<?php } else { ?>
		<div class="essb-activate-welcome">
			You are using plugin bundled inside theme. What are the benefits of direct license for Easy Social Share Buttons for WordPress?
If you purchase direct license for Easy Social Share Buttons for WordPress there are following benefits you receive:
<ul>
<li>Access official customer support (opening support tickets are available only for direct license owners);</li>
<li>Automatic plugin updates directly inside your WordPress dashboard (no need to wait - get instant updates);</li>
<li>Access to Extensions Library: Download and install professional extensions to expand functionality of your social sharing plugin (updated regularly).</li>
<li>Access to Ready Made Styles Library - install professional designed layouts with one click</li>
<li>Use Easy Social Share Buttons for WordPress with any theme (not just the one that got Easy Social Share Buttons for WordPress bundled);</li>
<li>Advanced and detailed multilangual configurations - personalize plugin functions by different languages when you use WPML or Polylang</li>
<li>Manage your licenses at Activation Manager;</li>
<li>Support your beloved page builder plugin for rapid development.</li>
</ul>
	<p style="text-align:center;"><a href="http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476?ref=appscreo&license=regular&open_purchase_for_item_id=6394476&purchasable=source" target="blank" class="essb-btn essb-btn-red" style="padding: 15px;">Purchase copy of Easy Social Share Buttons for just $19</a></p>

		</div>
		<?php } ?>
		
		<div class="essb-activation-form" style="margin-top:30px;">
			<div class="essb-activation-form-title">
				<div class="essb-activation-title<?php if (ESSBActivationManager::isActivated()) { echo " color-activated"; } else { echo " color-notactivated"; } ?>"><?php echo __('Manual Plugin Activation', 'essb');?></div>			
			</div>
			<div class="essb-activation-form-code">
				If you have problem with automatic plugin registration please <a href="#" id="essb-activate-manual-registration">click here to activate it manually</a>.
			</div>
			
			<div id="essb-manual-registration">
			<div class="essb-activation-form-code">
				<div class="essb-activation-form-header">
					<strong><?php echo __('Purchase code', 'essb');?></strong>
					<br/>You can learn how to find your purchase code <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">here</a>
					
				</div>
				<input type="text" id="essb-manual-purchase-code" class="essb-purchase-code" value="<?php echo ESSBActivationManager::getPurchaseCode(); ?>" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"/>			
			</div>
			<div class="essb-activation-form-code">
				<div class="essb-activation-form-header">
					<strong><?php echo __('Activation code', 'essb');?></strong>
					<br/><a href="<?php echo ESSBActivationManager::getApiUrl('activate'); ?>" target="_blank">Go to our manual activation page and fill in all required details to receive your activation code</a>. In the domain field enter <b><?php echo ESSBActivationManager::domain();?></b>
					
				</div>
				<input type="text" id="essb-manual-activation-code" class="essb-purchase-code" value="" placeholder="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"/>			
			</div>
			
			<div class="essb-activation-buttons">
				<?php if (!ESSBActivationManager::isActivated()) { ?>
				<a href="#" id="essb-manual-activate" class="essb-activation-button essb-activation-button-default essb-manual-activate-plugin"><?php echo __('Manual registration of code', 'essb'); ?></a>
				<?php } ?>
				
				
			</div>
			</div>
		</div>
		
		<?php } ?>
			
		
		
		
	</div>
	
	<script type="text/javascript">

	var essb_api_activate_domain = "<?php echo ESSBActivationManager::domain(); ?>";
	var essb_api_activate_url = "<?php echo ESSBActivationManager::getSiteURL(); ?>";
	var essb_api_url = "<?php echo ESSBActivationManager::getApiUrl('api'); ?>";
	var essb_ajax_url = "<?php echo admin_url ('admin-ajax.php'); ?>";

	var essb_used_purchasecode = "<?php echo ESSBActivationManager::getPurchaseCode(); ?>";
	var essb_used_activationcode = "<?php echo ESSBActivationManager::getActivationCode(); ?>";
	
	jQuery(document).ready(function($){

		if ($('#essb-activate-manual-registration').length) {
			$('#essb-activate-manual-registration').click(function(e) {
				e.preventDefault();

				if (!$('#essb-activate-manual-registration').hasClass('opened')) {
					$('#essb-manual-registration').fadeIn('200');
					$('#essb-activate-manual-registration').addClass('opened');
				}
				else {
					$('#essb-manual-registration').fadeOut('200');
					$('#essb-activate-manual-registration').removeClass('opened');
				}
			});
		}

		if ($('#essb-manual-activate').length) {
			$('#essb-manual-activate').click(function(e) {
				e.preventDefault();

				var purchase_code = $('#essb-manual-purchase-code').val();
				var activation_code = $('#essb-manual-activation-code').val();

				if (purchase_code == '' || activation_code == '') {
					$.toast({
					    heading: 'Missing Activation Data',
					    text: 'Please fill purchase code and activation code before processing with activation',
					    showHideTransition: 'fade',
					    icon: 'error',
					    position: 'bottom-right',
					    hideAfter: 5000
					});

					return;
				}

				$('.preloader-holder').fadeIn(100);

				$.ajax({
		            type: "POST",
		            url: essb_ajax_url,
		            data: { 'action': 'essb_process_activation', 'purchase_code': purchase_code, 'activation_code': activation_code, 'activation_state': 'manual', 'domain': essb_api_activate_domain},
		            success: function (data) {
		            	$('.preloader-holder').fadeOut(400);
    		            console.log(data);
    		            if (typeof(data) == "string")
		                	data = JSON.parse(data);

						var code = data['code'] || '';

	                	if (code != '100') {
	                		sweetAlert({
			            	    title: "Activation Error",
			            	    text: "Purchase code and activation code did not match. Please check them again and if problem exists contact us.",
			            	    type: "error"
			            	});
	                	}
	                	else {
			            	sweetAlert({
			            	    title: "Activation Successful",
			            	    text: "Thank you for activating Easy Social Share Buttons for WordPress.",
			            	    type: "success"
			            	},
	
			            	function () {
			            	    window.location.reload();
			            	});
	                	}
		            }
            	});
			});
		}
		
		if ($('#essb-activate').length) {
			$('#essb-activate').click(function(e) {
				e.preventDefault();

				var purchase_code = $('#essb-automatic-purchase-code').val();

				if (purchase_code == '') {
					$.toast({
					    heading: 'Missing Purchase Code',
					    text: 'Please fill purchase code before processing with activation',
					    showHideTransition: 'fade',
					    icon: 'error',
					    position: 'bottom-right',
					    hideAfter: 5000
					});

					return;
				}

				$('.preloader-holder').fadeIn(100);
				console.log(purchase_code + '-'+essb_api_activate_domain);
				console.log({ 'code': purchase_code, 'domain': essb_api_activate_domain, 'url': essb_api_activate_url});
				console.log(essb_api_url);
				$.ajax({
		            type: "POST",
		            url: essb_api_url,
		            data: { 'code': purchase_code, 'domain': essb_api_activate_domain, 'url': essb_api_activate_url},
		            success: function (data) {
		                $('.preloader-holder').fadeOut(400);
		                console.log(data);
		                if (typeof(data) == "string")
		                	data = JSON.parse(data);
		                
		                var code = data['code'] || '';
		                var activation_message = data['message'] || '';
		                var activation_code = data['hash'] || '';
		                
		                console.log('code = '+ code);
		                console.log('activation_message = '+ activation_message);
		                console.log('activation_code = ' + activation_code);
		                
		                if (parseInt(code) > 0 && parseInt(code) < 10) {
		                	$.ajax({
		    		            type: "POST",
		    		            url: essb_ajax_url,
		    		            data: { 'action': 'essb_process_activation', 'purchase_code': purchase_code, 'activation_code': activation_code, 'activation_state': 'activate'},
		    		            success: function (data) {
			    		            console.log(data);
		    		            	sweetAlert({
		    		            	    title: "Activation Successful",
		    		            	    text: "Thank you for activating Easy Social Share Buttons for WordPress.",
		    		            	    type: "success"
		    		            	},

		    		            	function () {
		    		            	    window.location.reload();
		    		            	});
		    		            }
		                	});

		                }
		                else {
		                	swal("Activation Error", ''+activation_message+'', "error");
		                }

		                
		            },
		            error: function(data) {
		            	 $('.preloader-holder').fadeOut(400);
		            	 $.toast({
							    heading: 'Connection Error',
							    text: 'Cannot connection to registration server. Please try again and if problem still exist proceed with manual activation.',
							    showHideTransition: 'fade',
							    icon: 'error',
							    position: 'bottom-right',
							    hideAfter: 5000
							});
		            }
		        });
			});
		}
		
		if ($('#essb-deactivate').length) {
			$('#essb-deactivate').click(function(e) {
				e.preventDefault();

				var purchase_code = essb_used_purchasecode;

				if (purchase_code == '') {
					$.toast({
					    heading: 'Missing Purchase Code',
					    text: 'Please fill purchase code before processing with activation',
					    showHideTransition: 'fade',
					    icon: 'error',
					    position: 'bottom-right',
					    hideAfter: 5000
					});

					return;
				}

				$('.preloader-holder').fadeIn(100);
				console.log(purchase_code + '-'+essb_api_activate_domain);
				$.ajax({
		            type: "POST",
		            url: essb_api_url + 'deactivate.php',
		            data: { 'hash': essb_used_activationcode, 'code': essb_used_purchasecode },
		            success: function (data) {
		                $('.preloader-holder').fadeOut(400);
		                console.log(data);
		                if (typeof(data) == "string")
		                	data = JSON.parse(data);
		                
		                var code = data['code'] || '';
		                var activation_message = data['message'] || '';
		                var activation_code = data['hash'] || '';
		                
		                console.log('code = '+ code);
		                console.log('activation_message = '+ activation_message);
		                console.log('activation_code = ' + activation_code);
		                
		                if (parseInt(code) > 0 && parseInt(code) < 10) {
		                	$.ajax({
		    		            type: "POST",
		    		            url: essb_ajax_url,
		    		            data: { 'action': 'essb_process_activation', 'activation_state': 'deactivate'},
		    		            success: function (data) {
		    		            	window.location.reload();
		    		            }
		                	});

		                }
		                else {
		                	swal("Deactivation Error", '<b>'+activation_message+'</b>', "error");
		                }

		                
		            },
		            error: function(data) {
		            	 $('.preloader-holder').fadeOut(400);
		            	 $.toast({
							    heading: 'Connection Error',
							    text: 'Cannot connection to registration server. Please try again and if problem still exist proceed with manual activation.',
							    showHideTransition: 'fade',
							    icon: 'error',
							    position: 'bottom-right',
							    hideAfter: 5000
							});
		            }
		        });
			});
		}
		

	});

	</script>
	
	<?php 
}