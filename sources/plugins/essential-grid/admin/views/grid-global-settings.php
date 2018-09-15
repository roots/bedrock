<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

?>
<h2 class="topheader"><?php echo esc_html(get_admin_page_title()); ?></h2>
<div id="global-settings-dialog-wrap">
	<?php
	$curPermission = Essential_Grid_Admin::getPluginPermissionValue();
	$output_protection = get_option('tp_eg_output_protection', 'none');
	$tooltips = get_option('tp_eg_tooltips', 'true');
	$wait_for_fonts = get_option('tp_eg_wait_for_fonts', 'true');
	$js_to_footer = get_option('tp_eg_js_to_footer', 'false');
	$use_cache = get_option('tp_eg_use_cache', 'false');
	$overwrite_gallery = get_option('tp_eg_overwrite_gallery', 'off');
	$query_type = get_option('tp_eg_query_type', 'wp_query');
	$enable_log = get_option('tp_eg_enable_log', 'false');
	$use_lightbox = get_option('tp_eg_use_lightbox', 'false');
	$enable_custom_post_type = get_option('tp_eg_enable_custom_post_type', 'true');
	$enable_post_meta = get_option('tp_eg_enable_post_meta', 'true');

	$data = apply_filters('essgrid_globalSettingsDialog_data', array());
	
	if(Essential_Grid_Jackbox::jb_exists()) {
		$jb_active = true;
	}else{ //disable jackbox and reset to default if it was set until now
		if($use_lightbox == 'jackbox'){
			update_option('tp_eg_use_lightbox', 'false');
		}
		$jb_active = false;
	}
	
	if(Essential_Grid_Social_Gallery::sg_exists()) {
		$sg_active = true;
	}else{ //disable jackbox and reset to default if it was set until now
		if($use_lightbox == 'sg'){
			update_option('tp_eg_use_lightbox', 'false');
		}
		$sg_active = false;
	}
	?>
	<div class="esg-global-setting">
		<div class="esg-gs-tc">
			<label><?php echo _e('View Plugin Permissions', EG_TEXTDOMAIN); ?>:</label>
		</div>
		<div class="esg-gs-tc">
			<select name="plugin_permissions">
				<option <?php echo ($curPermission == Essential_Grid_Admin::ROLE_ADMIN) ?  'selected="selected" ' : '';?>value="admin"><?php _e('Admin', EG_TEXTDOMAIN); ?></option>
				<option <?php echo ($curPermission == Essential_Grid_Admin::ROLE_EDITOR) ? 'selected="selected" ' : '';?>value="editor"><?php _e('Editor, Admin', EG_TEXTDOMAIN); ?></option>
				<option <?php echo ($curPermission == Essential_Grid_Admin::ROLE_AUTHOR) ? 'selected="selected" ' : '';?>value="author"><?php _e('Author, Editor, Admin', EG_TEXTDOMAIN); ?></option>
			</select>
		</div>
		<div class="esg-gs-tc">
		</div>
	</div>
	<div class="esg-global-setting">
		<div class="esg-gs-tc">
			<label><?php echo _e('Advanced Tooltips', EG_TEXTDOMAIN); ?>:</label>
		</div>
		<div class="esg-gs-tc">
			<select name="plugin_tooltips">
				<option <?php echo ($tooltips == 'true') ?  'selected="selected" ' : '';?>value="true"><?php _e('On', EG_TEXTDOMAIN); ?></option>
				<option <?php echo ($tooltips == 'false') ? 'selected="selected" ' : '';?>value="false"><?php _e('Off', EG_TEXTDOMAIN); ?></option>
			</select>
		</div>
		<div class="esg-gs-tc">		
			<i style=""><?php echo _e('Show or Hide the Tooltips on Hover over the Settings in Essential Grid Backend. ', EG_TEXTDOMAIN); ?></i>
		</div>
	</div>
	<div class="esg-global-setting">
		<div class="esg-gs-tc">
			<label><?php echo _e('Wait for Fonts', EG_TEXTDOMAIN); ?>:</label>
		</div>
		<div class="esg-gs-tc">
			<select name="wait_for_fonts">
				<option <?php echo ($wait_for_fonts == 'true') ?  'selected="selected" ' : '';?>value="true"><?php _e('On', EG_TEXTDOMAIN); ?></option>
				<option <?php echo ($wait_for_fonts == 'false') ? 'selected="selected" ' : '';?>value="false"><?php _e('Off', EG_TEXTDOMAIN); ?></option>
			</select>
		</div>
		<div class="esg-gs-tc">		
			<i style=""><?php echo _e('In case Options is enabled, the Grid will always wait till the Google Fonts has been loaded, before the grid starts.', EG_TEXTDOMAIN); ?></i>
		</div>
	</div>
	<div class="esg-global-setting">
		<div class="esg-gs-tc">
			<label><?php echo _e('Output Filter Protection', EG_TEXTDOMAIN); ?>:</label>
		</div>
		<div class="esg-gs-tc">
			<select name="output_protection">
				<option <?php echo ($output_protection == 'none') ?  'selected="selected" ' : '';?>value="none"><?php _e('None', EG_TEXTDOMAIN); ?></option>
				<option <?php echo ($output_protection == 'compress') ? 'selected="selected" ' : '';?>value="compress"><?php _e('By Compressing Output', EG_TEXTDOMAIN); ?></option>
				<option <?php echo ($output_protection == 'echo') ? 'selected="selected" ' : '';?>value="echo"><?php _e('By Echo Output', EG_TEXTDOMAIN); ?></option>
			</select>
		</div>
		<div class="esg-gs-tc">		
			<i style=""><?php echo _e('The HTML Markup is printed in compressed form, or it is written due Echo instead of Reutrn. In some case Echo will move the full Grid to the top/bottom of the page ! ', EG_TEXTDOMAIN); ?></i>				
		</div>
	</div>
	<div class="esg-global-setting">
		<div class="esg-gs-tc">
			<label><?php echo _e('JS To Footer', EG_TEXTDOMAIN); ?>:</label>
		</div>
		<div class="esg-gs-tc">
			<select name="js_to_footer">
				<option <?php echo ($js_to_footer == 'true') ?  'selected="selected" ' : '';?>value="true"><?php _e('On', EG_TEXTDOMAIN); ?></option>
				<option <?php echo ($js_to_footer == 'false') ? 'selected="selected" ' : '';?>value="false"><?php _e('Off', EG_TEXTDOMAIN); ?></option>
			</select>
		</div>
		<div class="esg-gs-tc">		
			<i style=""><?php echo _e('Defines where the jQuery files should be loaded in the DOM.', EG_TEXTDOMAIN); ?></i>				
		</div>
	</div>
	<div class="esg-global-setting">
		<div class="esg-gs-tc">
			<label><?php echo _e('Select LightBox Type', EG_TEXTDOMAIN); ?>:</label>
		</div>
		<div class="esg-gs-tc">
			<select name="use_lightbox">
				<option <?php echo ($use_lightbox == 'false') ? 'selected="selected" ' : '';?>value="false"><?php _e('Default LightBox', EG_TEXTDOMAIN); ?></option>
				<option <?php echo ($use_lightbox == 'jackbox') ?  'selected="selected" ' : '';?>value="jackbox" <?php echo ($jb_active === true) ? '' : ' disabled="disabled"'; ?>><?php _e('JackBox', EG_TEXTDOMAIN); ?></option>
				<option <?php echo ($use_lightbox == 'sg') ?  'selected="selected" ' : '';?>value="sg" <?php echo ($sg_active === true) ? '' : ' disabled="disabled"'; ?>><?php _e('Social Gallery', EG_TEXTDOMAIN); ?></option>
				<option <?php echo ($use_lightbox == 'disabled') ?  'selected="selected" ' : '';?>value="disabled"><?php _e('Disable LightBox', EG_TEXTDOMAIN); ?></option>
			</select>
		</div>
		<div class="esg-gs-tc">		
			<i style=""><?php echo _e('Select the default LightBox to be used.<br>- The JackBox WordPress plugin is available <a href="http://codecanyon.net/item/jackbox-responsive-lightbox-wordpress-plugin/3357551" target="_blank">here</a>,<br>- The Social Gallery plugin can be found <a href="http://codecanyon.net/item/social-gallery-wordpress-photo-viewer-plugin/2665332" target="_blank">here</a>', EG_TEXTDOMAIN); ?></i>				
		</div>
	</div>
	<div class="esg-global-setting">
		<div class="esg-gs-tc">
			<label><?php echo _e('WP Gallery Default Grid', EG_TEXTDOMAIN); ?>:</label>
		</div>
		<div class="esg-gs-tc">
			<select name="overwrite_gallery">
				<option <?php selected( $overwrite_gallery, 'off' , true ); ?> value="off"><?php _e('Off', EG_TEXTDOMAIN); ?></option>
				<?php 
					$grids = new Essential_Grid(); 
					$arrGrids = $grids->get_essential_grids(); 
					foreach($arrGrids as $grid){
						echo '<option value="'.$grid->handle.'" '. selected( $overwrite_gallery, $grid->handle, false ) .'>'. $grid->name . '</option>';
					}
				?>
			</select>
		</div>
		<div class="esg-gs-tc">		
			<i style=""><?php echo _e('If selected <strong>all</strong> WordPress Galleries will be displayed with Essential Grid. Select a grid in each gallery setting individually. Galleries with no grid setting will use this default grid.', EG_TEXTDOMAIN); ?></i>								 
		</div>
	</div>
	<div class="esg-global-setting">
		<div class="esg-gs-tc">
			<label><?php echo _e('Use Own Caching System', EG_TEXTDOMAIN); ?>:</label>
		</div>
		<div class="esg-gs-tc">
			<select name="use_cache">
				<option <?php echo ($use_cache == 'true') ?  'selected="selected" ' : '';?>value="true"><?php _e('On', EG_TEXTDOMAIN); ?></option>
				<option <?php echo ($use_cache == 'false') ? 'selected="selected" ' : '';?>value="false"><?php _e('Off', EG_TEXTDOMAIN); ?></option>
			</select>
			<span id="ess-grid-delete-cache" class="button-primary revblue"><?php echo _e('delete cache', EG_TEXTDOMAIN); ?></span>
		</div>
		<div class="esg-gs-tc">	
			<i style=""><?php echo _e('Essential Grid has two Caching Engines !  The Primary cache will precache Post Queries to provide a quicker result of queries.  The "Own" Caching system will additional allow to cache the Grid HTML Markup also, to provide an extreme quick Result of output. This cache should be deleted after any changes ! Only for advanced users.', EG_TEXTDOMAIN); ?></i>								 
		</div>
	</div>
	<div class="esg-global-setting">
		<div class="esg-gs-tc">
			<label><?php echo _e('Set Query Type Used', EG_TEXTDOMAIN); ?>:</label>
		</div>
		<div class="esg-gs-tc">
			<select name="query_type">
				<option <?php echo ($query_type == 'wp_query') ?  'selected="selected" ' : '';?>value="wp_query"><?php _e('WP_Query()', EG_TEXTDOMAIN); ?></option>
				<option <?php echo ($query_type == 'get_posts') ? 'selected="selected" ' : '';?>value="get_posts"><?php _e('get_posts()', EG_TEXTDOMAIN); ?></option>
			</select>
		</div>
		<div class="esg-gs-tc">	
			<i style=""><?php echo _e('If this is changed, caching of Essential Grid may be required to be deleted!', EG_TEXTDOMAIN); ?></i>
		</div>
	</div>
	<div class="esg-global-setting">
		<div class="esg-gs-tc">
			<label><?php echo _e('Enable Debug Log', EG_TEXTDOMAIN); ?>:</label>
		</div>
		<div class="esg-gs-tc">
			<select name="enable_log">
				<option <?php echo ($enable_log == 'true') ?  'selected="selected" ' : '';?>value="true"><?php _e('On', EG_TEXTDOMAIN); ?></option>
				<option <?php echo ($enable_log == 'false') ? 'selected="selected" ' : '';?>value="false"><?php _e('Off', EG_TEXTDOMAIN); ?></option>
			</select>
		</div>
		<div class="esg-gs-tc">	
			<i style=""><?php echo _e('This enables console logs for debugging purposes.', EG_TEXTDOMAIN); ?></i>								 
		</div>
	</div>
	<div class="esg-global-setting">
		<div class="esg-gs-tc">
			<label><?php echo _e('Enable Custom Post Type', EG_TEXTDOMAIN); ?>:</label>
		</div>
		<div class="esg-gs-tc">
			<select name="enable_custom_post_type">
				<option <?php echo ($enable_custom_post_type == 'true') ?  'selected="selected" ' : '';?>value="true"><?php _e('On', EG_TEXTDOMAIN); ?></option>
				<option <?php echo ($enable_custom_post_type == 'false') ? 'selected="selected" ' : '';?>value="false"><?php _e('Off', EG_TEXTDOMAIN); ?></option>
			</select>
		</div>
		<div class="esg-gs-tc">	
			<i style=""><?php echo _e('This enables the Custom Post Type.', EG_TEXTDOMAIN); ?></i>
		</div>
	</div>
	<div class="esg-global-setting last-egs">
		<div class="esg-gs-tc">
			<label><?php echo _e('Enable Page/Post Options', EG_TEXTDOMAIN); ?>:</label>
		</div>
		<div class="esg-gs-tc">
			<select name="enable_post_meta">
				<option <?php echo ($enable_post_meta == 'true') ?  'selected="selected" ' : '';?>value="true"><?php _e('On', EG_TEXTDOMAIN); ?></option>
				<option <?php echo ($enable_post_meta == 'false') ? 'selected="selected" ' : '';?>value="false"><?php _e('Off', EG_TEXTDOMAIN); ?></option>
			</select>
		</div>
		<div class="esg-gs-tc">	
			<i style=""><?php echo _e('This enables the post and page meta box options beneath the WordPress content editor pages.', EG_TEXTDOMAIN); ?></i>								 
		</div>
	</div>
	<?php
	do_action('essgrid_globalSettingsDialog', $data);
	?>
</div>
<p>
	<a id="eg-btn-save-global-settings" href="javascript:void(0);" class="button-primary revgreen"><i class="eg-icon-cog"></i><?php _e('Save Settings', EG_TEXTDOMAIN); ?></a>
</p>

<script type="text/javascript">
	AdminEssentials.initGlobalSettings();
</script>