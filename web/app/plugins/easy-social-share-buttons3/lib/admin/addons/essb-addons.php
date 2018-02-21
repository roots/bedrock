<?php

$current_list = array ();

if (class_exists ( 'ESSBAddonsHelper' )) {
	
	$essb_addons = ESSBAddonsHelper::get_instance ();
	
	$check = isset($_REQUEST['check']) ? $_REQUEST['check'] : '';
	if ($check == 'true') {
		$essb_addons->call_remove_addon_list_update ();
	}
	
	$current_list = $essb_addons->get_addons ();
}


if (! isset ( $current_list )) {
	$current_list = array ();
}

?>

<style type="text/css">
.essb-column-compatibility { width: 100% !important; float: none !important; text-align: left !important; font-size: 12px; margin-bottom: 5px;  }
.essb-column-downloaded { width: 100% !important; max-width: 100% !important; text-align: right; }
.essb-addon-price { font-size: 15px; margin-bottom: 5px; }
.essb-addon-price b { font-weight: 800; }
.plugin-card-top { padding: 10px 20px 10px; height: 320px; }
.plugin-card-top h4 { font-size: 16px; font-weight: 700; margin-top: 5px; margin-bottom: 10px;}
.plugin-card { width: 400px; }
.essb-column-compatibility { width: 100%; }
.essb-column-compatibility .button { margin-right: 5px; }
.essb-column-compatibility .button-no-margin { margin-right: 0px !important; }
.plugin-card-top h4 { height: 35px; }
.plugin-card-top p.essb-description { min-height: 80px; }
.plugin-card:nth-child(3n+1) { clear: none !important; margin-left: 8px; }
.plugin-card:nth-child(4n+1) { clear: none !important; margin-right: 8px; }
.plugin-card:nth-child(even) { clear: none !important; }
.plugin-card:nth-child(odd) { clear: none !important; }
.plugin-card:nth-child(3n) { margin-right: 8px; }
.essb-free { background-color: #27AE60; color: #fff; margin-left: 5px; border-radius: 4px; padding: 2px 6px; font-size: 14px; font-weight: bold; }
.essb-paid { background-color: #D33257; color: #fff; margin-left: 5px; border-radius: 4px; padding: 2px 6px; font-size: 14px; font-weight: bold; }
.essb-free, .essb-paid {
	padding: 5px 8px;
	float: right;
}

.essb-addon-category {
	color: #fff;
	margin-right: 5px; padding: 5px 8px; font-size: 12px;
	text-transform: uppercase; 
	font-weight: bold;
	background-color: #2c8ac8;
	position: absolute;
	top: 0px;
	left: 0px;
	border-top-right-radius: 4px;
	border-bottom-right-radius:4px;
}

.essb-addon-tag {
	color: #fff;
	margin-right: 5px; border-radius: 4px; padding: 2px 6px; font-size: 11px;
	text-transform: uppercase; 
	font-weight: bold;
}

.essb-addon-unique {
	background-color:#D8335B;
}

.essb-addon-new {
	background-color: #2C82C9;
}

.essb-addon-popular {
	background-color: #00B5B5;
}
.essb-addon-updated {
	background-color: #FD5B03;
}
.essb-options-hint-addonhint {
	background-color: #fff !important;
}

.essb-options-hint-addonhint i {
	font-size: 28px !important;
	margin-right: 10px;
}

.essb-options-hint-addonhint a { font-weight: bold; }
.essb-btn-installed, .essb-btn-installed:hover { background-color: #D4D4D4; color: #666 !important;}
.essb-filter-links, .essb-filter-links li {
	display: inline-block;
	margin: 0;
}
.essb-filter-links li { margin-right: 5px;}
.essb-filter-links { padding: 15px 10px; }
.essb-filter-links a {
	font-size: 12px;
	border: 1px solid #ddd;
	color: #444;
	padding: 3px 6px;
	border-radius: 4px;
}

.essb-filter-links a.current, .essb-filter-links a:hover, .essb-filter-links a:focus {
	color: #009cdd;
	border-color: #009cdd;
	box-shadow: none;
}

.essb-addon-count {
	float: right;
	margin-top: 15px;
	font-size: 12px;
}

.essb-wp-filters { margin-top: 0px; }

</style>

<div class="wrap">

	<div class="essb-tabs">
		<div class="essb-tabs-title" style="padding-top: 15px; padding-bottom: 20px;">
			<div class="essb-tabs-version">
				<div class="essb-logo essb-logo32"></div>
				<div class="essb-text-afterlogo">
					<h3>Extensions for Easy Social Share Buttons for WordPress</h3>
					<p>
						Version <strong><?php echo ESSB3_VERSION;?></strong>. 
					</p>
					
				</div>
			</div>
			<div class="essb-title-panel-buttons">
				<?php echo '<a href="'.admin_url ("admin.php?page=essb_addons&check=true").'"  text="' . __ ( 'Check for new addons', 'essb' ) . '" class="essb-btn essb-btn-green" style="margin-right: 5px;"><i class="fa fa-refresh"></i>&nbsp;' . __ ( 'Check for new extensions', 'essb' ) . '</a>'; ?>			
			</div>
		</div>
		

	</div>

	<?php 
	
	global $essb_options;
	$exist_user_purchase_code = isset($essb_options['purchase_code']) ? $essb_options['purchase_code'] : '';
	
	if (!ESSBActivationManager::isActivated()) {
		if (!ESSBActivationManager::isThemeIntegrated()) {
			ESSBOptionsFramework::draw_hint(__('Activate plugin to download extensions', 'essb'), __('Thank you for choosing Easy Social Share Buttons for WordPress. To download our free extensions please activate plugin by filling your purchase code in Activation Page. <a href="admin.php?page=essb_redirect_update">Click here to visit Activation Page</a>', 'essb'), 'fa fa-lock', 'addonhint');
		}
		else {
			ESSBOptionsFramework::draw_hint(__('Direct Customer Benefit ', 'essb'), sprintf(__('Access to download and install extensions is benefit for direct plugin customers. <a href="%s" target="_blank">See all direct customer benefits</a>', 'essb'), ESSBActivationManager::getBenefitURL()), 'fa fa-lock', 'addonhint');
		}
	}
	
	?>
	
	<?php 
	
	$exist_filters = isset($current_list['filters']) ? $current_list['filters'] : array();
	
	$count = 0;
	foreach ( $current_list as $addon_key => $addon_data ) {
			
		if ($addon_key == "filters") continue;
		$count++;
	}
	
	if (count($exist_filters) > 0) {
		echo '<div class="wp-filter essb-wp-filters">';
		echo '<ul class="essb-filter-links">';
		
		foreach ($exist_filters as $key => $text) {
			echo '<li><a href="#" class="essb-filter-addon'.($key == 'all' ? ' current' : '').'" data-filter="'.$key.'">'.$text.'</a>';
		}
		
		echo '</ul>';
		echo '<div class="essb-addon-count">Showing <b><span class="essb-active-count">'.$count.'</span></b> of <b>'.$count.'</b> extensions</div>';
		echo '</div>';
	}
	
	?>

	<div class="wp-list-table widefat plugin-install">
		<div id="the-list">
		<?php
		
		
		
		$site_url = get_bloginfo('url');
		
		
		foreach ( $current_list as $addon_key => $addon_data ) {
			
			if ($addon_key == "filters") continue;
			
			$filters = isset($addon_data['filters']) ? $addon_data['filters'] : '';
			$filters_lists = explode(',', $filters);
			
			$filters_class = " essb-addon-filter-all";
			foreach ($filters_lists as $filter) {
				$filters_class .= ' essb-addon-filter-'.$filter;
			}
			
			$demo_url = isset ( $addon_data ['demo_url'] ) ? $addon_data ['demo_url'] : '';
			print '<div class="plugin-card'.$filters_class.'">';
			print '<div class="plugin-card-top">';
			//print '<h4><a href="' . $addon_data ['page'] . '" target="_blank">' . (($addon_data ['price'] == 'FREE') ? '<span class="essb-free">FREE</span>' : '' ) . $addon_data ["name"] . '</a></h4>';
			print '<h4>';
			print (($addon_data ['price'] == 'FREE') ? '<span class="essb-free">FREE</span>' : '<span class="essb-paid">'.$addon_data ['price'].'</span>' );
			print '<a href="' . $addon_data ['page'] . '" target="_blank">' . $addon_data ["name"] . '</a>';
			print '</h4>';
			print '<a href="' . $addon_data ['page'] . '" target="_blank">';
			print '<div style="position:relative">';
			print '<img src="' . $addon_data ["image"] . '" style="max-width: 100%;"/>';
			
			if (isset($addon_data['category'])) {
				if ($addon_data['category'] != '') {
				$tags = explode(',', $addon_data['category']);
				foreach ($tags as $tag) {
					print '<span class="essb-addon-category">'.$tag.'</span>';
				}
				}
			}
			
			print '</div>';
			print '</a>';
			print '<p class="essb-description">';
			if (isset($addon_data['tags'])) {
			
				$tags = explode(',', $addon_data['tags']);
				foreach ($tags as $tag) {
					print '<span class="essb-addon-tag essb-addon-'.$tag.'">'.$tag.'</span>';
				}
			
			}
			print  $addon_data ['description'];
			
			
			
			print '</p>';
				
			//print '<div class="plugin-action-buttons"></div>';
			if ($addon_data ['price'] != 'FREE') {
				print '<div class="essb-column-compatibility column-compatibility" style="float: right !important; margin-top:-20px !important; text-align: right;">';
				print '<a class="essb-btn essb-btn-red" target="_blank"  href="' . $addon_data ['page'] . '" style="margin-left: 5px;">Learn more</a>';
				print '</div>';
			}
			
			
			print '</div>';
			
			print '<div class="plugin-card-bottom">';
			print '<div class="column-downloaded essb-column-downloaded">';
			
			print '<div class="essb-column-compatibility column-compatibility">';
			$addon_requires = $addon_data ['requires'];
			if (version_compare ( ESSB3_VERSION, $addon_requires, '<' )) {
				print '<span class="compatibility-untested">Requires plugin version <b>' . $addon_requires . '</b> or newer</span>';
			} else {
				print '<span class="compatibility-compatible"><b>Compatible</b> with your version of plugin</span>';
					
			}
			print '</div>';
			//print '<div class="essb-addon-price">';
			
			//print 'Price: <b>' . $addon_data ['price'] . '</b>';
			//print '</div>';
			
			print '</div>';
			
			print '<div class="column-compatibility essb-column-compatibility">';
			
			
			$check_exist = $addon_data ['check'];
			$is_installed = false;
			
			if (! empty ( $check_exist )) {
				if (defined ( $check_exist )) {
					$is_installed = true;
				}
			}
			
			if (! $is_installed) {
				if ($addon_data ['price'] != 'FREE') {
					print '<a class="essb-btn" target="_blank"  href="' . $addon_data ['page'] . '">Get it now ' . $addon_data ['price'] . '</a>';
				}
				else {
					if (ESSBActivationManager::isActivated()) {
						print '<a class="essb-btn" target="_blank"  href="' . $addon_data ['page'] .'&url='.$site_url .'&code='.ESSBActivationManager::getActivationCode() . '" onclick="essbShowFreeAddonInstallation();">Download Free</a>';
					}
					else {
						//print '<span class="button button-primary button-disabled">Download Free</span>';
						echo ESSBAdminActivate::activateToUnlock('Activate plugin to download');
						
					}
				}
			} else {
				print '<span class="essb-btn essb-btn-installed" disabled="disabled">Installed</span>';
			}
			
			if (! empty ( $demo_url )) {
				print '<a class="essb-btn essb-btn-orange button-no-margin" target="_blank" style="float: right;" href="' . $demo_url . '">Try live demo</a>';
			}
						
			
			print '</div>';
			
			print '</div>';
			print '</div>';
		}
		
		?>
		</div>
	</div>
</div>

<script type="text/javascript">

jQuery(document).ready(function($){

	var essbShowFreeAddonInstallation() {
		console.log('message');

			swal('Thank you for downloading a free extension!', 'Once the download is complete install the file like all other plugins you have. All extension options you can find integrated inside plugin or as a separate menu under Easy Social Share Buttons.', 'success');
	}

	var essbRemoveFilterActiveState = function() {
		$('.essb-wp-filters').find('.essb-filter-addon').each(function() {
			if ($(this).hasClass('current')) 
				$(this).removeClass('current');
		});
	}
	
	if ($('.essb-wp-filters').length) {
		$('.essb-wp-filters').find('.essb-filter-addon').each(function() {
			$(this).click(function(e) {
				e.preventDefault();

				if ($(this).hasClass('current')) return;

				essbRemoveFilterActiveState();
				$(this).addClass('current');

				var filterFor = $(this).attr("data-filter") || "";
				var filterClass = 'essb-addon-filter-'+filterFor;

				$('.wp-list-table').hide();

				var count = 0;
				$('.wp-list-table').find('.plugin-card').each(function() {
					if ($(this).hasClass(filterClass)) { 
						$(this).show();
						count++;
					}
					else
						$(this).hide();
				});
				$('.essb-active-count').text(count);
				$('.wp-list-table').show();
			});
		});
	}
});
</script>
