<?php
/**
 * Panel to the search options.
 * 
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 * @since: 2.0
 */

if( !defined( 'ABSPATH') ) exit();

$settings = get_option('esg-search-settings', array('settings' => array(), 'global' => array(), 'shortcode' => array()));
$settings = Essential_Grid_Base::stripslashes_deep($settings);

$base = new Essential_Grid_Base();
$grids = Essential_Grid::get_grids_short();

$my_skins = array(
	'light' => __('Light', EG_TEXTDOMAIN),
	'dark' => __('Dark', EG_TEXTDOMAIN)
);
$my_skins = apply_filters('essgrid_modify_search_skins', $my_skins);

?>
<h2 class="topheader"><?php _e('Search Settings', EG_TEXTDOMAIN); ?></h2>

<div id="eg-grid-search-wrapper">
	<ul class="es-grid-search-tabs">
		<li><a href="#eg-search-settings-wrap"><?php _e('Global Settings', EG_TEXTDOMAIN); ?></a></li>
		<li><a href="#eg-shortcode-search-wrap"><?php _e('ShortCode Search', EG_TEXTDOMAIN); ?></a></li>
	</ul>
	
	<div id="eg-search-settings-wrap">
		<p>
			<?php $search_enable = $base->getVar(@$settings['settings'], 'search-enable', 'off'); ?>
			<label for="search-enable"><?php _e('Enable Search Globally', EG_TEXTDOMAIN); ?></label>
			<input type="radio" name="search-enable" value="on" <?php checked($search_enable, 'on'); ?> /> <?php _e('On', EG_TEXTDOMAIN); ?>
			<input type="radio" name="search-enable" value="off" <?php checked($search_enable, 'off'); ?> /> <?php _e('Off', EG_TEXTDOMAIN); ?>
		</p>
		<form id="esg-search-global-settings">
			<div class="eg-search-settings-info-box" style="padding:10px 15px; margin-bottom:15px;background:#3498db; color:#fff;">
				<h3 style="color:#fff"><div style="margin-right:15px;" class="dashicons dashicons-info"></div><?php _e('What Are The Search Settings?', EG_TEXTDOMAIN); ?><div style="float:right" class="dashicons dashicons-arrow-down-alt2"></div></h3>
				<div class="eg-search-settings-toggle-visible">
					<p><?php _e('With this, you can let any element in your theme use Essential Grid as a Search Result page.', EG_TEXTDOMAIN); ?></p>
					<h3 style="color:#fff"><?php _e('Note:', EG_TEXTDOMAIN); ?></h3>
					<p style="margin-bottom:15px"><?php _e('You can add more than one Setting to have more than one resulting Grid Style depending on the element that opened the search overlay', EG_TEXTDOMAIN); ?></p>
				</div>
			</div>
			
			<div class="eg-global-search-wrap">
			</div>
			
			<a id="eg-btn-add-global-setting" href="javascript:void(0);" class="button-primary revblue"><i class="eg-icon-plus"></i><?php _e('Add Setting', EG_TEXTDOMAIN); ?></a>
			
		</form>
	</div>
	<div id="eg-shortcode-search-wrap">
		<form id="esg-search-shortcode-settings">
			<div class="eg-search-settings-info-box" style="padding:10px 15px; margin-bottom:15px;background:#3498db; color:#fff;">
				<h3 style="color:#fff"><div style="margin-right:15px;" class="dashicons dashicons-info"></div><?php _e('What Are The Search ShortCode Settings?', EG_TEXTDOMAIN); ?><div style="float:right" class="dashicons dashicons-arrow-down-alt2"></div></h3>
				<div class="eg-search-settings-toggle-visible">
					<p><?php _e('With this, you can create a ShortCode with custom HTML markup that can be used anywhere on the website to use the search functionality of Essential Grid.', EG_TEXTDOMAIN); ?></p>
					<h3 style="color:#fff"><?php _e('Note:', EG_TEXTDOMAIN); ?></h3>
					<p><?php _e('- adding HTML will add the onclick event in the first found tag', EG_TEXTDOMAIN); ?></p>
					<p style="margin-bottom:15px"><?php _e('- adding text will wrap an a tag around it that will have the onclick event', EG_TEXTDOMAIN); ?></p>
				</div>
			</div>
			
			<div class="eg-shortcode-search-wrap">
			</div>
			
			<a id="eg-btn-add-shortcode-setting" href="javascript:void(0);" class="button-primary revblue"><i class="eg-icon-plus"></i><?php _e('Add ShortCode', EG_TEXTDOMAIN); ?></a>
		</form>
	</div>
	
	<p>
		<a id="eg-btn-save-settings" href="javascript:void(0);" class="button-primary revgreen"><i class="eg-icon-cog"></i><?php _e('Save Settings', EG_TEXTDOMAIN); ?></a>
	</p>
</div>

<script type="text/javascript">
	var global_settings = <?php echo json_encode($settings); ?>;
	jQuery(function(){
		AdminEssentials.initSearchSettings();
	});
</script>

<script type="text/html" id="tmpl-esg-global-settings-wrap">
	<div class="postbox eg-postbox" style="width:100%;min-width:500px">
		<h3 class="box-closed"><span style="font-weight:400"><?php _e('Selector:', EG_TEXTDOMAIN); ?></span><span class="search-title">{{ data['search-class'] }} </span><div class="postbox-arrow"></div></h3>
		<div class="inside" style="display:none;padding:15px !important;margin:0px !important;height:100%;position:relative;background:#ebebeb">
			<p>
				<label for="search-class"><?php _e('Set by Class/ID', EG_TEXTDOMAIN); ?></label>
				<input type="text" name="search-class[]" class="eg-tooltip-wrap" title="<?php _e('Add CSS ID or Class here to trigger search as an onclick event on given elements (can be combined like \'.search, .search2, #search\')', EG_TEXTDOMAIN); ?>" value="{{ data['search-class'] }}"  />
			</p>
			<p>
				
				<label for="search-grid-id"><?php _e('Choose Grid To Use', EG_TEXTDOMAIN); ?></label>
				<select name="search-grid-id[]">
					<?php
					if(!empty($grids)){
						foreach($grids as $id => $name){
							echo '<option value="'.$id.'" <# if ( \''.$id.'\' == data[\'search-grid-id\'] ) { #>selected="selected"<# } #>>'.$name.'</option>'."\n";
						}
					}
					?>
				</select>
			</p>
			<p>
				<label for="search-style"><?php _e('Overlay Skin', EG_TEXTDOMAIN); ?></label>
				<select name="search-style[]">
					<?php
					foreach($my_skins as $handle => $name){
						echo '<option value="'.$handle.'" <# if ( \''.$handle.'\' == data[\'search-style\'] ) { #>selected="selected"<# } #>>'.$name.'</option>'."\n";
					}
					?>
				</select>
			</p>
			
			<?php add_action('essgrid_add_search_global_settings', (object)$settings); ?>
			
			<p>
				<a href="javascript:void(0);" class="button-primary revred eg-btn-remove-setting"><i class="eg-icon-trash"></i><?php _e('Remove', EG_TEXTDOMAIN); ?></a>
			</p>
		</div>
	</div>
</script>


<script type="text/html" id="tmpl-esg-shortcode-settings-wrap">
	<div class="postbox eg-postbox" style="width:100%;min-width:500px">
		<h3 class="box-closed"><span style="font-weight:400"><?php _e('ShortCode:', EG_TEXTDOMAIN); ?></span><span class="search-title">{{ data['sc-shortcode'] }} </span><div class="postbox-arrow"></div></h3>
		<div class="inside" style="display:none;padding:15px !important;margin:0px !important;height:100%;position:relative;background:#ebebeb">
			<p>
				<label for="sc-handle"><?php _e('Handle', EG_TEXTDOMAIN); ?></label>
				<input type="text" value="{{ data['sc-handle'] }}" name="sc-handle[]" />
			</p>
			<p>
				<label for="sc-grid-id"><?php _e('Choose Grid To Use', EG_TEXTDOMAIN); ?></label>
				<select name="sc-grid-id[]">
					<?php
					if(!empty($grids)){
						foreach($grids as $id => $name){
							echo '<option value="'.$id.'" <# if ( \''.$id.'\' == data[\'sc-grid-id\'] ) { #>selected="selected"<# } #>>'.$name.'</option>'."\n";
						}
					}
					?>
				</select>
			</p>
			<p>
				<label for="sc-style"><?php _e('Overlay Skin', EG_TEXTDOMAIN); ?></label>
				<select name="sc-style[]">
					<?php
					foreach($my_skins as $handle => $name){
						echo '<option value="'.$handle.'" <# if ( \''.$handle.'\' == data[\'sc-style\'] ) { #>selected="selected"<# } #>>'.$name.'</option>'."\n";
					}
					?>
				</select>
			</p>
			<p>
				<label for="sc-html"><?php _e('HTML Markup', EG_TEXTDOMAIN); ?></label>
				<textarea name="sc-html[]">{{ data['sc-html'] }}</textarea>
			</p>
			<p>
				<label for="sc-shortcode"><?php _e('Generated ShortCode', EG_TEXTDOMAIN); ?></label>
				<input type="text" value="" name="sc-shortcode[]" readonly="readonly" style="width: 400px;" />
			</p>
			
			<?php add_action('essgrid_add_search_shortcode_settings', (object)$settings); ?>
			
			<p>
				<a href="javascript:void(0);" class="button-primary revred eg-btn-remove-setting"><i class="eg-icon-trash"></i><?php _e('Remove', EG_TEXTDOMAIN); ?></a>
			</p>
		</div>
	</div>
</script>