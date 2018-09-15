<?php

if( !defined( 'ABSPATH') ) exit();

$orders = false;
//order=asc&ot=name&type=reg
if(isset($_GET['ot']) && isset($_GET['order']) && isset($_GET['type'])){
	$order = array();
	switch($_GET['ot']){
		case 'alias':
			$order['alias'] = ($_GET['order'] == 'asc') ? 'ASC' : 'DESC';
		break;
		case 'favorite':
			$order['favorite'] = ($_GET['order'] == 'asc') ? 'ASC' : 'DESC';
		break;
		case 'name':
		default:
			$order['title'] = ($_GET['order'] == 'asc') ? 'ASC' : 'DESC';
		break;
	}
	
	$orders = $order;
}


$slider = new RevSlider();
$operations = new RevSliderOperations();
$arrSliders = $slider->getArrSliders($orders);
$glob_vals = $operations->getGeneralSettingsValues();

$addNewLink = self::getViewUrl(RevSliderAdmin::VIEW_SLIDER);


$fav = get_option('rev_fav_slider', array());
if($orders == false){ //sort the favs to top
	if(!empty($fav) && !empty($arrSliders)){
		$fav_sort = array();
		foreach($arrSliders as $skey => $sort_slider){
			if(in_array($sort_slider->getID(), $fav)){
				$fav_sort[] = $arrSliders[$skey];
				unset($arrSliders[$skey]);
			}
		}
		if(!empty($fav_sort)){
			//revert order of favs
			krsort($fav_sort);
			foreach($fav_sort as $fav_arr){
				array_unshift($arrSliders, $fav_arr);
			}
		}
	}
}

global $revSliderAsTheme;

$exampleID = '"slider1"';
if(!empty($arrSliders))
	$exampleID = '"'.$arrSliders[0]->getAlias().'"';

$latest_version = get_option('revslider-latest-version', RevSliderGlobals::SLIDER_REVISION);
$stable_version = get_option('revslider-stable-version', '4.1');

?>

<div class='wrap'>
	<div class="clear_both"></div>
	<div class="title_line" style="margin-bottom:10px">
		<?php 
			$icon_general = '<div class="icon32" id="icon-options-general"></div>';
			echo apply_filters( 'rev_icon_general_filter', $icon_general ); 
		?>
		<a href="<?php echo RevSliderGlobals::LINK_HELP_SLIDERS; ?>" class="button-secondary float_right mtop_10 mleft_10" target="_blank"><?php _e("Help",'revslider'); ?></a>

		<a id="button_general_settings" class="button-secondary float_right mtop_10"><?php _e("Global Settings",'revslider'); ?></a>
	</div>

	<div class="clear_both"></div>

	<div class="title_line nobgnopd" style="height:auto; min-height:50px">
		<div class="view_title">
			<?php _e("Revolution Sliders", 'revslider'); ?>			
		</div>
		<div class="slider-sortandfilter">
				<span class="slider-listviews slider-lg-views" data-type="rs-listview"><i class="eg-icon-align-justify"></i></span>
				<span class="slider-gridviews slider-lg-views active" data-type="rs-gridview"><i class="eg-icon-th"></i></span>
				<span class="slider-sort-drop"><?php _e("Sort By:",'revslider'); ?></span>
				<select id="sort-sliders" name="sort-sliders" style="max-width: 105px;" class="withlabel">
					<option value="id" selected="selected"><?php _e("By ID",'revslider'); ?></option>
					<option value="name"><?php _e("By Name",'revslider'); ?></option>
					<option value="type"><?php _e("By Type",'revslider'); ?></option>
					<option value="favorit"><?php _e("By Favorit",'revslider'); ?></option>
				</select>
				
				<span class="slider-filter-drop"><?php _e("Filter By:",'revslider'); ?></span>
				
				<select id="filter-sliders" name="filter-sliders" style="max-width: 105px;" class="withlabel">
					<option value="all" selected="selected"><?php _e("All",'revslider'); ?></option>
					<option value="posts"><?php _e("Posts",'revslider'); ?></option>
					<option value="gallery"><?php _e("Gallery",'revslider'); ?></option>
					<option value="vimeo"><?php _e("Vimeo",'revslider'); ?></option>
					<option value="youtube"><?php _e("YouTube",'revslider'); ?></option>
					<option value="twitter"><?php _e("Twitter",'revslider'); ?></option>
					<option value="facebook"><?php _e("Facebook",'revslider'); ?></option>
					<option value="instagram"><?php _e("Instagram",'revslider'); ?></option>
					<option value="flickr"><?php _e("Flickr",'revslider'); ?></option>
				</select>
		</div>
		<div style="width:100%;height:1px;float:none;clear:both"></div>
	</div>

	<?php
	$no_sliders = false;
	if(empty($arrSliders)){
		?>
		<span style="display:block;margin-top:15px;margin-bottom:15px;">
		<?php  _e("No Sliders Found",'revslider'); ?>
		</span>
		<?php
		$no_sliders = true;
	}

	require self::getPathTemplate('sliders-list');

	?>
	<!--
	THE INFO ABOUT EMBEDING OF THE SLIDER
	-->
	<div class="rs-dialog-embed-slider" title="<?php _e("Embed Slider",'revslider'); ?>" style="display: none;">
		<div class="revyellow" style="background: none repeat scroll 0% 0% #F1C40F; left:0px;top:55px;position:absolute;height:205px;padding:20px 10px;"><i style="color:#fff;font-size:25px" class="revicon-arrows-ccw"></i></div>
		<div style="margin:5px 0px; padding-left: 55px;">
			<div style="font-size:14px;margin-bottom:10px;"><strong><?php _e("Standard Embeding",'revslider'); ?></strong></div>
			<?php _e("For the",'revslider'); ?> <b><?php _e("pages or posts editor",'revslider'); ?></b> <?php _e("insert the shortcode:",'revslider'); ?> <code class="rs-example-alias-1"></code>
			<div style="width:100%;height:10px"></div>
			<?php _e("From the",'revslider'); ?> <b><?php _e("widgets panel",'revslider'); ?></b> <?php _e("drag the \"Revolution Slider\" widget to the desired sidebar",'revslider'); ?>
			<div style="width:100%;height:25px"></div>
			<div id="advanced-emeding" style="font-size:14px;margin-bottom:10px;"><strong><?php _e("Advanced Embeding",'revslider'); ?></strong><i class="eg-icon-plus"></i></div>
			<div id="advanced-accord" style="display:none; line-height:25px">
				<?php _e("From the",'revslider'); ?> <b><?php _e("theme html",'revslider'); ?></b> <?php _e("use",'revslider'); ?>: <code>&lt?php putRevSlider( '<span class="rs-example-alias">alias</span>' ); ?&gt</code><br>
				<span><?php _e("To add the slider only to homepage use",'revslider'); ?>: <code>&lt?php putRevSlider('<span class="rs-example-alias"><?php echo $exampleID; ?></span>', 'homepage'); ?&gt</code></span></br>
				<span><?php _e("To add the slider on specific pages or posts use",'revslider'); ?>: <code>&lt?php putRevSlider('<span class="rs-example-alias"><?php echo $exampleID; ?></span>', '2,10'); ?&gt</code></span></br>
			</div>
			
		</div>
	</div>
	<script>
		jQuery('#advanced-emeding').click(function() {
			jQuery('#advanced-accord').toggle(200);
		});
	</script>


	<div style="width:100%;height:40px"></div>
	
	<!-- DASHBOARD -->
	<div class="rs-dashboard">
		<?php
		$validated = get_option('revslider-valid', 'false');
		$temp_active = get_option('revslider-temp-active', 'false');
		$code = get_option('revslider-code', '');
		//$email = get_option('revslider-email', '');
		$latest_version = get_option('revslider-latest-version', RevSliderGlobals::SLIDER_REVISION);

		$activewidgetclass = $validated === 'true'? "rs-status-green-wrap" : "rs-status-red-wrap";
		$activewidgetclass = $temp_active === 'true' ? "rs-status-orange-wrap" : $activewidgetclass;
		
		$dashboard_array = array();
		$dashboard_required_array = array();
		
		ob_start();
		?>
		<!-- VALIDATION WIDGET -->
		<div class="rs-dash-widget" id="activation_dw">
			<div class="rs-dash-title-wrap <?php echo $activewidgetclass; ?>">
				<div class="rs-dash-title"><?php _e("Plugin Activation",'revslider'); ?></div>
				<div class="rs-dash-title-button rs-status-red"><i class="icon-not-registered"></i><?php _e("Not Activated",'revslider'); ?></div>
				<div class="rs-dash-title-button rs-status-orange"><i class="icon-no-problem-found"></i><?php _e("Temporarily Activated",'revslider'); ?></div>
				<div class="rs-dash-title-button rs-status-green"><i class="icon-no-problem-found"></i><?php _e("Plugin Activated",'revslider'); ?></div>
			</div>
			
			<div class="rs-dash-widget-inner rs-dash-widget-deregistered" <?php echo ($validated !== 'true') ? '' : 'style="display: none;"'; ?>>
				<div class="rs-dash-icon rs-dash-refresh"></div>
				<div class="rs-dash-content-with-icon">
					<div class="rs-dash-strong-content"><?php _e("Live Updates",'revslider'); ?></div>
					<div><?php _e("Fresh versions directly to your admin",'revslider'); ?></div>
				</div>
				<div class="rs-dash-content-space"></div>				
				<div class="rs-dash-icon rs-dash-ticket"></div>
				<div class="rs-dash-content-with-icon">
					<div class="rs-dash-strong-content"><?php _e("Ticket Support",'revslider'); ?></div>
					<div><?php _e("Direct help from our qualified support team",'revslider'); ?></div>
				</div>
				<div class="rs-dash-content-space"></div>				
				<div class="rs-dash-icon rs-dash-gift"></div>
				<div class="rs-dash-content-with-icon">
					<div class="rs-dash-strong-content"><?php _e("Free Premium Sliders",'revslider'); ?></div>
					<div><?php _e("Exclusive new slider exports for our direct customers",'revslider'); ?></div>
				</div>

				<div class="rs-dash-bottom-wrapper">
					<span id="rs-validation-activate-step-a" class="rs-dash-button"><?php _e('Register Slider Revolution','revslider'); ?></span>
					<a class="rs-dash-button" href="https://themepunch.com/purchase-code-deactivation/" target="_blank"><?php _e('Deregister Domain','revslider'); ?></a>
				</div>
			</div>

			<div class="rs-dash-widget-inner rs-dash-widget-registered" <?php echo ($validated === 'true') ? '' : 'style="display: none;position:absolute;top:60px;left:0px;"'; ?>>
				
				<div class="rs-dash-icon rs-dash-credit"></div>
				<div class="rs-dash-content-with-icon">
					<div class="rs-dash-strong-content"><?php _e("Purchase Code",'revslider'); ?></div>
					<div><?php _e("You can learn how to find your purchase key <a target='_blank' href='http://www.themepunch.com/faq/where-to-find-the-purchase-code/'>here</a>",'revslider'); ?></div>
				</div>
				<div class="rs-dash-content-space"></div>
				<?php if(!RS_DEMO){ ?>
					<input type="text" name="rs-validation-token" class="rs-dashboard-input" style="width:100%" value="<?php echo $code; ?>" <?php echo ($validated === 'true') ? ' readonly="readonly"' : ''; ?> style="width: 350px;" />
					<div class="rs-dash-content-space"></div>
					<?php
					/*
					<div class="rs-dash-strong-content"><?php _e("Email Address",'revslider'); ?></div>
					<input type="text" name="rs-validation-email" class="rs-dashboard-input" style="width:100%" value="<?php echo $email; ?>" <?php echo ($validated === 'true') ? ' readonly="readonly"' : ''; ?> style="width: 350px;" />
					?>
					
					<div class="rs-dash-content-space"></div>
					*/
					?>
					<?php if ($validated == 'true') {
					?>
						<div><?php _e("In order to register your purchase code on another domain, deregister <br>it first by clicking the button below.",'revslider'); ?></div>				
					<?php 
					} else { ?>
						<div><?php _e("Reminder ! One registration per Website. If registered elsewhere please deactivate that registration first.",'revslider'); ?></div>				
					<?php 
					}
					?>
					
					<div class="rs-dash-bottom-wrapper">
						<span style="display:none" id="rs_purchase_validation" class="loader_round"><?php _e('Please Wait...', 'revslider'); ?></span>					
						<a href="javascript:void(0);" <?php echo ($validated !== 'true') ? '' : 'style="display: none;"'; ?> id="rs-validation-activate" class="rs-dash-button"><?php _e('Register the code','revslider'); ?></a>				
						<a href="javascript:void(0);" <?php echo ($validated === 'true') ? '' : 'style="display: none;"'; ?> id="rs-validation-deactivate" class="rs-dash-button"><?php _e('Deregister the code','revslider'); ?></a>
						
						<?php
						$temp_active = get_option('revslider-temp-active', 'false');
						if($temp_active == 'true'){
							?>
							<a href="?page=revslider&checktempactivate=true" id="rs-validation-full-activate" class="rs-dash-button"><?php _e('Complete Activation','revslider'); ?></a>
							<span class="rs-dash-more-info" data-takemeback="false" data-title="<?php _e('What does \'Temporary Activated\' mean?', 'revslider');?>" data-content="<?php echo __('The Envato API was unavailable at the activation process:', 'revslider').'<div class=\'rs-dash-content-space\'></div>'.__('The Slider is temporary activated until the Envato API can be reached again by the ThemePunch servers.','revslider').'<div class=\'rs-dash-content-space\'></div>'.__('The plugin will be fully activated as soon as the Envato API is available again.','revslider').''; ?>"><span class="rs-dash-invers-button-gray rs-dash-close-panel"><?php _e('Why?', 'revslider'); ?></span></span>
							<?php
						}
						?>
					</div>					
				<?php } ?>
			</div>		
			
			<script>
				jQuery(document).ready(function() {
					jQuery('#rs-validation-activate-step-a').click(function() {
						punchgs.TweenLite.to(jQuery('.rs-dash-widget-inner.rs-dash-widget-deregistered'),0.5,{autoAlpha:1,x:"-100%",ease:punchgs.Power3.easeInOut});
						punchgs.TweenLite.fromTo(jQuery('.rs-dash-widget-inner.rs-dash-widget-registered'),0.5,{display:"block",autoAlpha:0,left:400},{autoAlpha:1,left:0,ease:punchgs.Power3.easeInOut});
					})
				});
			</script>
		</div><!-- END OF VALIDATION WIDGET -->
		<?php
		$dbc = ob_get_contents();
		ob_clean();
		ob_end_clean();
		
		$dashboard_array['rs-validation'] = array('order' => 10, 'content' => $dbc);
		
		ob_start();
		?>
		<!--
		THE CURRENT AND NEXT VERSION
		-->
		<?php 
		if (version_compare(RevSliderGlobals::SLIDER_REVISION, $latest_version, '<')) { 
			$updateclass = 'rs-status-orange-wrap';
		} else {	
			$updateclass = 'rs-status-green-wrap';
		}
		if($validated !== 'true' && version_compare(RevSliderGlobals::SLIDER_REVISION, $stable_version, '<'))
			$updateclass = 'rs-status-red-wrap';
		?>
		<div class="rs-dash-widget" id="updates_dw">
			<div class="rs-dash-title-wrap <?php echo $updateclass; ?>">
				<div class="rs-dash-title"><?php _e("Plugin Updates",'revslider'); ?></div>
				<div class="rs-dash-title-button rs-status-orange"><i class="icon-update-refresh"></i><?php _e("Update Available",'revslider'); ?></div>
				<div class="rs-dash-title-button rs-status-green"><i class="icon-no-problem-found"></i><?php _e("Plugin up to date",'revslider'); ?></div>
				<div class="rs-dash-title-button rs-status-red"><i class="icon-no-problem-found"></i><?php _e("Critical Update",'revslider'); ?></div>
			</div>
			
			<div class="rs-dash-widget-inner">
				<div class="rs-dash-strong-content"><?php _e("Installed Version",'revslider'); ?></div>
				<div><?php echo RevSliderGlobals::SLIDER_REVISION; ?></div>								
				<div class="rs-dash-content-space"></div>
				<div class="rs-dash-strong-content"><?php _e("Latest Available Version",'revslider'); ?></div>
				<div><?php echo $latest_version; ?></div>
				<div class="rs-dash-content-space"></div>
				<a class='rs-dash-invers-button' href='?page=revslider&checkforupdates=true' id="rev_check_version"><?php _e("Check for Updates",'revslider'); ?> </a>			
				<?php if(!RS_DEMO){ ?>	
					<div class="rs-dash-bottom-wrapper">
					<?php if ($validated === 'true') 
						{ 					
							if (version_compare(RevSliderGlobals::SLIDER_REVISION, $latest_version, '<')) { 
							?>
								<a href="update-core.php?force-check=1&checkforupdates=true" id="rs-check-updates" class="rs-dash-button"><?php _e('Update Now', 'revslider'); ?></a>
							<?php	
							} else {
							?>	
								<span  class="rs-dash-button-gray"><?php _e('Up to date', 'revslider'); ?></span>
							<?php 					
							}					
						} else {
						?>
							<span class="rs-dash-button" id="regsiter-to-access-update-none"><?php _e('Update', 'revslider'); ?></a>
						<?php
						}	
						
						if($validated !== 'true' && version_compare(RevSliderGlobals::SLIDER_REVISION, $stable_version, '<')){
							?>
							<a href="update-core.php?force-check=1&checkforupdates=true" id="rs-check-updates" class="rs-dash-button"><?php _e('Update to Stable (Free)','revslider'); ?></a><br>
							<?php
						}
						?>	
					</div>
				<?php } ?>
			</div>
			
		</div><!-- END OF VERSION INFORMATION WIDGET -->
		<?php
		$dbc = ob_get_contents();
		ob_clean();
		ob_end_clean();
		
		$dashboard_required_array['rs-version-information'] = array('order' => 20, 'content' => $dbc);
		
		ob_start();
		?>
		<!-- Requirements & Recommendations -->
		<div class="rs-dash-widget" id="system_dw">
			<?php
			$dir = wp_upload_dir();
			$mem_limit = ini_get('memory_limit');
			$mem_limit_byte = wp_convert_hr_to_bytes($mem_limit);
			$upload_max_filesize = ini_get('upload_max_filesize');
			$upload_max_filesize_byte = wp_convert_hr_to_bytes($upload_max_filesize);
			$post_max_size = ini_get('post_max_size');
			$post_max_size_byte = wp_convert_hr_to_bytes($post_max_size);

			$writeable_boolean = wp_is_writable($dir['basedir'].'/');
			$can_connect = get_option('revslider-connection', false);
			$mem_limit_byte_boolean = $mem_limit_byte<268435456;
			$upload_max_filesize_byte_boolean = ($upload_max_filesize_byte < 33554432);
			$post_max_size_byte_boolean = ($post_max_size_byte < 33554432);
			$dash_rr_status = ($writeable_boolean==true && $can_connect==true && $mem_limit_byte_boolean==false && $upload_max_filesize_byte_boolean==false && $post_max_size_byte_boolean==false) ? "rs-status-green-wrap" : "rs-status-red-wrap";
			$img_editor_test = (wp_image_editor_supports(array('methods' => array('resize', 'save')))) ? true : false;
			
			?>
			<div class="rs-dash-title-wrap <?php echo $dash_rr_status; ?>">
				<div class="rs-dash-title"><?php _e("System Requirements",'revslider'); ?></div>
				<div class="rs-dash-title-button rs-status-red"><i class="icon-problem-found"></i><?php _e("Problem Found",'revslider'); ?></div>
				<a class="rs-status-red rs-dash-title-button requirement-link" target="_blank" href="http://www.themepunch.com/revslider-doc/requirements-and-recommendations/" ><i class="eg-icon-info"></i></a> <div class="rs-dash-title-button rs-status-green"><i class="icon-no-problem-found"></i><?php _e("No Problems",'revslider'); ?></div>
			</div>
			<div class="rs-dash-widget-inner">
				<span class="rs-dash-label"><?php _e('Uploads folder writable', 'revslider'); ?></span>
				<?php
				//check if uploads folder can be written into
				if($writeable_boolean){
					echo '<i class="revgreenicon eg-icon-ok"></i>';
				}else{
					echo '<i class="revredicon eg-icon-cancel"></i><span style="margin-left:16px" class="rs-dash-more-info" data-title="'.__('Error with File Permissions', 'revslider').'" data-content="'.__('Please set write permission (755) to your wp-content/uploads folders to make sure the Slider can save all updates and imports in the future.', 'revslider').'"><i class="eg-icon-info"></i></span>';
				}
				?>
				

				<div class="rs-dash-content-space-small"></div>
				<span class="rs-dash-label"><?php _e('Memory Limit', 'revslider'); ?></span>
				<?php
				

				if($mem_limit_byte_boolean){ 
					//not good
					echo '<i style="margin-right:20px" class="revredicon eg-icon-cancel"></i>';
					echo '<span class="rs-dash-red-content">';
				} else {
					echo '<i style="margin-right:20px" class="revgreenicon eg-icon-ok"></i>';
					echo '<span class="rs-dash-strong-content">';
				}

				echo __('Currently:', 'revslider').' '.$mem_limit;
				echo '</span>';
				if($mem_limit_byte_boolean){
					//not good
					echo '<span class="rs-dash-strong-content" style="margin-left:20px">'. __('(min:256M)', 'revslider').'</span>';
				} 
				?>
				<div class="rs-dash-content-space-small"></div>
				<span class="rs-dash-label"><?php _e('Upload Max. Filesize', 'revslider'); ?></span>
				<?php
				
				
				if($upload_max_filesize_byte_boolean){
					//not good
					echo '<i style="margin-right:20px" class="revredicon eg-icon-cancel"></i>';
					echo '<span class="rs-dash-red-content">';
				} else {
					echo '<i style="margin-right:20px"class="revgreenicon eg-icon-ok"></i>';
					echo '<span class="rs-dash-strong-content">';
				}

				echo __('Currently:', 'revslider').' '.$upload_max_filesize;
				echo '</span>';
				if($upload_max_filesize_byte_boolean){
					echo '<span class="rs-dash-strong-content" style="margin-left:20px">'. __('(min:32M)', 'revslider').'</span>';
				}
				?>
				<div class="rs-dash-content-space-small"></div>
				<span class="rs-dash-label"><?php _e('Max. Post Size', 'revslider'); ?></span>
				<?php
				
				
				
				if($post_max_size_byte_boolean){
				//not good
					echo '<i style="margin-right:20px" class="revredicon eg-icon-cancel"></i>';
					echo '<span class="rs-dash-red-content">';
				} else {
					echo '<i style="margin-right:20px"class="revgreenicon eg-icon-ok"></i>';
					echo '<span class="rs-dash-strong-content">';
				}

				echo __('Currently:', 'revslider').' '.$post_max_size;
				echo '</span>';
				if($post_max_size_byte_boolean){
					echo '<span class="rs-dash-strong-content" style="margin-left:20px">'. __('(min:32M)', 'revslider').'</span>';
				}
				?>

				<div class="rs-dash-content-space-small"></div>
				<span class="rs-dash-label"><?php _e('Contact ThemePunch Server', 'revslider'); ?></span>
				<?php
				
				if($can_connect){
					echo '<i class="revgreenicon eg-icon-ok"></i>';
				}else{
					echo '<i class="revredicon eg-icon-cancel"></i>';					
				}
				?>				
				<a class='rs-dash-invers-button' href='?page=revslider&checkforupdates=true' id="rev_check_version_1" style="margin-left:16px"><?php _e("Check Now",'revslider'); ?></a>
				<?php 
				if(!$can_connect){
					echo '<span class="rs-dash-more-info" data-title="'.__('Error with contacting the ThemePunch Server', 'revslider').'" data-content="'.__('Please make sure that your server can connect to updates.themepunch.tools and templates.themepunch.tools programmatically.', 'revslider').'"><i class="eg-icon-info"></i></span>';
				} 
				?>
				<div class="rs-dash-content-space-small"></div>
				<span class="rs-dash-label"><?php _e('Object Library', 'revslider'); ?></span>
				<?php
				if($img_editor_test){
					echo '<i class="revgreenicon eg-icon-ok"></i>';
				}else{
					echo '<i class="revredicon eg-icon-cancel"></i>';
					echo '<span style="margin-left:16px" class="rs-dash-more-info" data-title="'.__('Error using ', 'revslider').'" data-content="'.__('Please make sure that your server can use wp_get_image_editor() by enabling the GD and/or ImageMagick libraries. Without this, the Object Library will always take the original source.', 'revslider').'"><i class="eg-icon-info"></i></span>';
				} 
				?>
			</div>
		</div><!-- END OF Requirements & Recommendations -->
		<?php
		$dbc = ob_get_contents();
		ob_clean();
		ob_end_clean();
		
		$dashboard_required_array['rs-requirements'] = array('order' => 30, 'content' => $dbc);
		
		ob_start();
		?>
		<!--
		TEMPLATE WIDGET
		-->
		<div id="templates_dw" class="rs-dash-widget">
			<div class="templatestore-bg"></div>
			<div class="rs-dash-title-wrap" style="position:relative; z-index:1">
				<div class="rs-dash-title"><?php _e("Start Downloading Templates",'revslider'); ?></div>
			</div>
			
			<div class="rs-dash-widget-inner">				
				<?php if ($validated === 'true') { 
					?>
					<div class="rs-dash-icon rs-dash-download"></div>
					<div class="rs-dash-content-with-icon">
						<div class="rs-dash-strong-content"><?php _e("Online Slider Library",'revslider'); ?></div>
						<div><?php _e("Full examples for instant usage",'revslider'); ?></div>
					</div>
					<div class="rs-dash-content-space"></div>				
					<div class="rs-dash-icon rs-dash-diamond"></div>
					<div class="rs-dash-content-with-icon">
						<div class="rs-dash-strong-content"><?php _e("Get Free Premium Sliders",'revslider'); ?></div>
						<div class=""><?php _e("Activate your plugin and profit",'revslider'); ?></div>
					</div>
				<?php }else{ ?>
					<div class="rs-dash-icon rs-dash-notregistered"></div>
					<div class="rs-dash-content-with-icon" style="width:190px;margin-right:20px">
						<div class="rs-dash-strong-content rs-dash-deactivated"><?php _e("Online Slider Library",'revslider'); ?></div>
						<div class="rs-dash-deactivated"><?php _e("Full examples for instant usage",'revslider'); ?></div>						
					</div>
					<span class="rs-dash-more-info" data-takemeback="false" data-title="<?php _e('How to Unlock Premium Features?', 'revslider');?>" data-content="<?php echo __('If you have purchased Slider Revolution from ThemePunch directly you can find your activation code here:', 'revslider').'<div class=\'rs-dash-content-space\'></div><a target=\'_blank\' href=\'http://revolution.themepunch.com/direct-customer-benefits/#productactivation\' class=\'rs-dash-invers-button\'>'.__('Where is my Purchase Code?','revslider').'</a><div class=\'rs-dash-content-space\'></div>'.__('Dont have a license yet? Purchase a license on CodeCanyon','revslider').'<div class=\'rs-dash-content-space\'></div><a target=\'_blank\' href=\'http://codecanyon.net/item/slider-revolution-responsive-wordpress-plugin/2751380\' class=\'rs-dash-button-small\'>'.__('Buy Now from $19','revslider').'</a>'; ?>"><span class="rs-dash-invers-button-gray rs-dash-close-panel"><?php _e('Unlock Now', 'revslider'); ?></span></span>
					<div class="rs-dash-content-space"></div>				
					<div class="rs-dash-icon rs-dash-notregistered"></div>
					<div class="rs-dash-content-with-icon" style="width:190px;margin-right:20px">
						<div class="rs-dash-strong-content rs-dash-deactivated"><?php _e("Get Free Premium Sliders",'revslider'); ?></div>
						<div class="rs-dash-deactivated"><?php _e("Activate your plugin and profit",'revslider'); ?></div>						
					</div>
					<span class="rs-dash-more-info" data-takemeback="false" data-title="<?php _e('How to Unlock Premium Features?', 'revslider');?>" data-content="<?php echo __('If you have purchased Slider Revolution from ThemePunch directly you can find your activation code here:', 'revslider').'<div class=\'rs-dash-content-space\'></div><a target=\'_blank\' href=\'http://revolution.themepunch.com/direct-customer-benefits/#productactivation\' class=\'rs-dash-invers-button\'>'.__('Where is my Purchase Code?','revslider').'</a><div class=\'rs-dash-content-space\'></div>'.__('Dont have a license yet? Purchase a license on CodeCanyon','revslider').'<div class=\'rs-dash-content-space\'></div><a target=\'_blank\' href=\'http://codecanyon.net/item/slider-revolution-responsive-wordpress-plugin/2751380\' class=\'rs-dash-button-small\'>'.__('Buy Now from $19','revslider').'</a>'; ?>"><span class="rs-dash-invers-button-gray rs-dash-close-panel"><?php _e('Unlock Now', 'revslider'); ?></span></span>
				<?php } ?>				
				<div class="rs-dash-bottom-wrapper">
					<?php if ($validated === 'true') { ?>
						<a href="javascript:void(0)" class="rs-dash-button" id="button_import_template_slider_b"><?php _e('Open Template Store', 'revslider'); ?></a>				
					<?php }else{ ?>
				 		<span class="rs-dash-button" id="regsiter-to-access-store-none" ><?php _e('Open Template Library', 'revslider'); ?></span>				 
					<?php } ?>
				</div>
			</div>
		</div><!-- END TEMPLATE WIDGET -->
		<?php
		$dbc = ob_get_contents();
		ob_clean();
		ob_end_clean();
		
		$dashboard_required_array['rs-templates'] = array('order' => 40, 'content' => $dbc);
		
		ob_start();
		?>
		<!--
		NEWSLETTER
		-->
		<div class="rs-dash-widget" id="newsletter_dw">
			<div class="rs-dash-title-wrap">
				<div class="rs-dash-title"><?php _e("ThemePunch Newsletter",'revslider'); ?></div>				
			</div>
			<div class="newsletter-bg"></div>
			<div class="rs-dash-widget-inner">				
				<div class="rs-dash-icon rs-dash-speaker"></div>
				<div class="rs-dash-content-with-icon">
					<div class="rs-dash-strong-content"><?php _e("Stay Updated",'revslider'); ?></div>
					<div><?php _e("Receive info on the latest product updates & products",'revslider'); ?></div>
				</div>
				<div class="rs-dash-content-space"></div>				
				<div class="rs-dash-icon rs-dash-gift"></div>
				<div class="rs-dash-content-with-icon">
					<div class="rs-dash-strong-content"><?php _e("Free Goodies",'revslider'); ?></div>
					<div><?php _e("Learn about free stuff we offer on a regular basis",'revslider'); ?></div>
				</div>
				<div class="rs-dash-content-space"></div>				
				<div class="rs-dash-icon rs-dash-smile"></div>
				<div class="rs-dash-content-with-icon">
					<div class="rs-dash-strong-content"><?php _e("Provide Feedback",'revslider'); ?></div>
					<div><?php _e("Participate in survey and help us improve constantly",'revslider'); ?></div>
				</div>

				<div class="rs-dash-bottom-wrapper">
					<span class="subscribe-newsletter-wrap"><a href="javascript:void(0);" class="rs-dash-button" id="subscribe-to-newsletter"><?php _e('Subscribe', 'revslider'); ?></a></span>				
					<input class="rs-dashboard-input" style="width:220px;margin-left:10px" type="text" value="" placeholder="<?php _e('Enter your E-Mail here', 'revslider'); ?>" name="rs-email" />
				</div>
			</div>
			
		</div><!-- END OF NEWSLETTER  -->
		<?php
		$dbc = ob_get_contents();
		ob_clean();
		ob_end_clean();
		
		$dashboard_required_array['rs-newsletter'] = array('order' => 50, 'content' => $dbc);
		
		ob_start();
		?>
		<!--
		PRODUCT SUPPORT
		-->
		<div class="rs-dash-widget" id="support_dw">
			<div class="rs-dash-title-wrap">
				<div class="rs-dash-title"><?php _e("Product Support",'revslider'); ?></div>				
			</div>			
			<div class="rs-dash-widget-inner">			

				<div class="rs-dash-icon rs-dash-copy"></div>
				<div class="rs-dash-content-with-icon">
					<div class="rs-dash-strong-content"><?php _e("Online Documentation",'revslider'); ?></div>
					<div><?php _e("The best start for Slider Revolution beginners",'revslider'); ?></div>
				</div>
				<div class="rs-dash-content-space"></div>				
				<div class="rs-dash-icon rs-dash-light"></div>
				<div class="rs-dash-content-with-icon">
					<div class="rs-dash-strong-content"><?php _e("Browse FAQ's",'revslider'); ?></div>
					<div><?php _e("Instant solutions for most problems",'revslider'); ?></div>
				</div>
				<div class="rs-dash-content-space"></div>
				<?php if ($validated === 'true') { ?>
					<div class="rs-dash-icon rs-dash-ticket"></div>
					<div class="rs-dash-content-with-icon">
						<div class="rs-dash-strong-content"><?php _e("Ticket Support",'revslider'); ?></div>
						<div><?php _e("Direct help from our qualified support team",'revslider'); ?></div>
					</div>
				<?php }else{ ?>												
					<div class="rs-dash-icon rs-dash-notregistered"></div>
					<div class="rs-dash-content-with-icon" style="width:278px;margin-right:20px">
						<div class="rs-dash-strong-content"><?php _e("Ticket Support",'revslider'); ?></div>
						<div><?php _e("Direct help from our qualified support team",'revslider'); ?></div>
					</div>
					<span class="rs-dash-more-info" data-takemeback="false" data-title="<?php _e('How to Unlock Premium Features?', 'revslider');?>" data-content="<?php echo __('If you have purchased Slider Revolution from ThemePunch directly you can find your activation code here:', 'revslider').'<div class=\'rs-dash-content-space\'></div><a target=\'_blank\' href=\'http://revolution.themepunch.com/direct-customer-benefits/#productactivation\' class=\'rs-dash-invers-button\'>'.__('Where is my Purchase Code?','revslider').'</a><div class=\'rs-dash-content-space\'></div>'.__('Dont have a license yet? Purchase a license on CodeCanyon','revslider').'<div class=\'rs-dash-content-space\'></div><a target=\'_blank\' href=\'http://codecanyon.net/item/slider-revolution-responsive-wordpress-plugin/2751380\' class=\'rs-dash-button-small\'>'.__('Buy Now from $19','revslider').'</a>'; ?>"><span class="rs-dash-invers-button-gray rs-dash-close-panel"><?php _e('Unlock Now', 'revslider'); ?></span></span>
				<?php } ?>

				<div class="rs-dash-bottom-wrapper">					
					<a href="http://www.themepunch.com/support-center/?rev=rsb" target="_blank" class="rs-dash-button"><?php _e('Visit Support Center', 'revslider'); ?></a>									
				</div>
			</div>
			
		</div><!-- END OF PRODUCT SUPPORT  -->
		<?php
		$dbc = ob_get_contents();
		ob_clean();
		ob_end_clean();
		
		$dashboard_array['rs-support'] = array('order' => 60, 'content' => $dbc);
		
		$dbvariables = array(
							'validated' 		=> $validated,
							'code'				=> $code,
							'current_version'	=> RevSliderGlobals::SLIDER_REVISION
							);
							
		$dashboard_array = apply_filters('revslider_dashboard_elements', $dashboard_array, $dbvariables);
		
		$dashboard_array = array_merge($dashboard_array, $dashboard_required_array);
		
		
		$dashboard_server = (array) get_option('revslider-dashboard', array());
		
		if(!empty($dashboard_server)){
			foreach($dashboard_server as $dbk => $dbv){
				$dashboard_server[$dbk] = (array) $dbv;
				if(version_compare(RevSliderGlobals::SLIDER_REVISION, $dbv->version_from, '<') || version_compare(RevSliderGlobals::SLIDER_REVISION, $dbv->version_to, '>')){
					unset($dashboard_server[$dbk]);
				}
			}
			
			if(!empty($dashboard_server)){
				$dashboard_array = array_merge($dashboard_array, $dashboard_server);
			}
		}
		
		if(!empty($dashboard_array) && is_array($dashboard_array)){
			usort($dashboard_array, array('RevSliderFunctions', 'sortByOrder'));
			
			foreach($dashboard_array as $dbarray){
				foreach($dbvariables as $dbhandle => $dbvalue){
					$dbarray['content'] = str_replace('{{'.$dbhandle.'}}', $dbvalue, $dbarray['content']);
				}
				echo $dbarray['content'];
			}
		}
		?>
		<div class="tp-clearfix"></div>
	</div><!-- END OF RS DASHBOARD -->
	
	<!-- THE UPDATE HISTORY OF SLIDER REVOLUTION -->
	<div style="width:100%;height:40px"></div>
	<div class="rs-update-history-wrapper">
		<div class="rs-dash-title-wrap">
			<div class="rs-dash-title"><?php _e("Update History",'revslider'); ?></div>				
		</div>	
		<div class="rs-update-history"><?php echo file_get_contents(RS_PLUGIN_PATH.'release_log.html'); ?></div>
	</div>
	
</div>

<!-- Import slider dialog -->
<div id="dialog_import_slider" title="<?php _e("Import Slider",'revslider'); ?>" class="dialog_import_slider" style="display:none">
	<form action="<?php echo RevSliderBase::$url_ajax; ?>" enctype="multipart/form-data" method="post">
		<br>
		<input type="hidden" name="action" value="revslider_ajax_action">
		<input type="hidden" name="client_action" value="import_slider_slidersview">
		<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("revslider_actions"); ?>">
		<?php _e("Choose the import file",'revslider'); ?>:
		<br>
		<input type="file" size="60" name="import_file" class="input_import_slider">
		<br><br>
		<span style="font-weight: 700;"><?php _e("Note: styles templates will be updated if they exist!",'revslider'); ?></span><br><br>
		<table>
			<tr>
				<td><?php _e("Custom Animations:",'revslider'); ?></td>
				<td><input type="radio" name="update_animations" value="true" checked="checked"> <?php _e("Overwrite",'revslider'); ?></td>
				<td><input type="radio" name="update_animations" value="false"> <?php _e("Append",'revslider'); ?></td>
			</tr>
			<tr>
				<td><?php _e("Custom Navigations:",'revslider'); ?></td>
				<td><input type="radio" name="update_navigations" value="true" checked="checked"> <?php _e("Overwrite",'revslider'); ?></td>
				<td><input type="radio" name="update_navigations" value="false"> <?php _e("Append",'revslider'); ?></td>
			</tr>
			<tr>
				<td><?php _e("Static Styles:",'revslider'); ?></td>
				<td><input type="radio" name="update_static_captions" value="true"> <?php _e("Overwrite",'revslider'); ?></td>
				<td><input type="radio" name="update_static_captions" value="false"> <?php _e("Append",'revslider'); ?></td>
				<td><input type="radio" name="update_static_captions" value="none" checked="checked"> <?php _e("Ignore",'revslider'); ?></td>
			</tr>
			<?php
			$single_page_creation = RevSliderFunctions::getVal($glob_vals, "single_page_creation", "off");
			?>
			<tr style="<?php echo ($single_page_creation == 'on') ? '' : 'display: none;'; ?>">
				<td><?php _e('Create Blank Page:','revslider'); ?></td>
				<td><input type="radio" name="page-creation" value="true"> <?php _e('Yes', 'revslider'); ?></td>
				<td><input type="radio" name="page-creation" value="false" checked="checked"> <?php _e('No', 'revslider'); ?></td>
			</tr>
		</table>
		<br>
		<input type="submit" class="button-primary revblue tp-be-button rev-import-slider-button" style="display: none;" value="<?php _e("Import Slider",'revslider'); ?>">
	</form>
</div>

<div id="dialog_duplicate_slider" class="dialog_duplicate_layer" title="<?php _e('Duplicate', 'revslider'); ?>" style="display:none;">
	<div style="margin-top:14px">
		<span style="margin-right:15px"><?php _e('Title:', 'revslider'); ?></span><input id="rs-duplicate-animation" type="text" name="rs-duplicate-animation" value="" />
	</div>
</div>

<div id="dialog_duplicate_slider_package" class="dialog_duplicate_layer" title="<?php _e('Duplicate', 'revslider'); ?>" style="display:none;">
	<div style="margin-top:14px">
		<span style="margin-right:15px"><?php _e('Prefix:', 'revslider'); ?></span><input id="rs-duplicate-prefix" type="text" name="rs-duplicate-prefix" value="" />
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function(){
		RevSliderAdmin.initSlidersListView();
		RevSliderAdmin.initNewsletterRoutine();
		
		jQuery('#benefitsbutton').hover(function() {
			jQuery('#benefitscontent').slideDown(200);
		}, function() {
			jQuery('#benefitscontent').slideUp(200);
		});
		
		jQuery('#why-subscribe').hover(function() {
			jQuery('#why-subscribe-wrapper').slideDown(200);
		}, function() {
			jQuery('#why-subscribe-wrapper').slideUp(200);				
		});
		
		jQuery('#tp-validation-box').click(function() {
			jQuery(this).css({cursor:"default"});
			if (jQuery('#rs-validation-wrapper').css('display')=="none") {
				jQuery('#tp-before-validation').hide();
				jQuery('#rs-validation-wrapper').slideDown(200);
			}
		});

		jQuery('body').on('click','.rs-dash-more-info',function() {
			var btn = jQuery(this),
				p = btn.closest('.rs-dash-widget-inner'),
				tmb = btn.data('takemeback'),
				btxt = '';

			btxt = btxt + '<div class="rs-dash-widget-warning-panel">';
			btxt = btxt + '	<i class="eg-icon-cancel rs-dash-widget-wp-cancel"></i>';
			btxt = btxt + '	<div class="rs-dash-strong-content">'+ btn.data("title")+'</div>';				
			btxt = btxt + '	<div class="rs-dash-content-space"></div>';
			btxt = btxt + '	<div>'+btn.data("content")+'</div>';
		
			if (tmb!=="false" && tmb!==false) {
				btxt = btxt + '	<div class="rs-dash-content-space"></div>';
				btxt = btxt + '	<span class="rs-dash-invers-button-gray rs-dash-close-panel">Thanks! Take me back</span>';
			}
			btxt = btxt + '</div>';

			p.append(btxt);
			var panel = p.find('.rs-dash-widget-warning-panel');

			punchgs.TweenLite.fromTo(panel,0.3,{y:-10,autoAlpha:0},{autoAlpha:1,y:0,ease:punchgs.Power3.easeInOut});
			panel.find('.rs-dash-widget-wp-cancel, .rs-dash-close-panel').click(function() {
				punchgs.TweenLite.to(panel,0.3,{y:-10,autoAlpha:0,ease:punchgs.Power3.easeInOut});
				setTimeout(function() {
					panel.remove();
				},300)
			})
		});
	});
</script>
<?php
require self::getPathTemplate('template-slider-selector');
?>

<div style="visibility: none;" id="register-wrong-purchase-code"></div>

