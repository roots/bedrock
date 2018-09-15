<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 */
 
if( !defined( 'ABSPATH') ) exit();

//force the js file to be included
//wp_enqueue_script('essential-grid-item-editor-script', EG_PLUGIN_URL.'admin/assets/js/grid-editor.js', array('jquery'), Essential_Grid::VERSION );

$metas = new Essential_Grid_Meta();
$meta_links = new Essential_Grid_Meta_Linking();
	
?>
<h2 class="topheader"><?php echo esc_html(get_admin_page_title()); ?></h2>

<div id="eg-grid-custom-meta-wrapper">
	<ul class="es-grid-meta-tabs">
		<li><a href="#eg-custom-meta-wrap"><?php _e('Custom Meta', EG_TEXTDOMAIN); ?></a></li>
		<li><a href="#eg-meta-links-wrap"><?php _e('Meta References / Aliases', EG_TEXTDOMAIN); ?></a></li>
	</ul>
	<div id="eg-custom-meta-wrap">
		<div class="eg-custom-meta-info-box" style="padding:10px 15px; margin-bottom:15px;background:#3498db; color:#fff;">
			<h3 style="color:#fff"><div style="margin-right:15px;" class="dashicons dashicons-info"></div><?php _e('What Are Custom Meta Boxes?', EG_TEXTDOMAIN); ?><div style="float:right" class="dashicons dashicons-arrow-down-alt2"></div></h3>
			<div class="eg-custom-meta-toggle-visible">
				<p><?php _e('A custom meta (or write) box is incredibly simple in theory. It allows you to add a custom piece of data to a post or page in WordPress.<br>These meta boxes are available in any Posts, Custom Posts, Pages and Custom Items in Grid Editor in the Essential Grid.', EG_TEXTDOMAIN); ?></p>
				<p><?php _e('Imagine you wish to have a Custom Link to your posts. You can create 1 Meta Box named <i>Custom Link</i>. Now this Meta Box is available in all your posts where you can add your individual value for it.  In the Skin Editor you can refer to this Meta Data to show the individual content of your posts.', EG_TEXTDOMAIN); ?></p>
				<h3 style="color:#fff"><?php _e('Where can I find the Custom Meta Fields?', EG_TEXTDOMAIN); ?></h3>					
				<p><?php _e('You can edit the Custom Meta Values in your posts, custom post and  pages within the Essential Grid section, and also in the Essential Grid Editor by clicking on the <strong>Cog Wheel Icon</strong> <span class="dashicons dashicons-admin-generic"></span> of the Item.', EG_TEXTDOMAIN); ?></p>					
				<h3 style="color:#fff"><?php _e('How to add Custom Meta Fields to my Skin?', EG_TEXTDOMAIN); ?></h3>					
				<p style="margin-bottom:15px"><?php _e('<strong>Edit the Skin</strong> you selected for the Grid(s) and <strong>add or edit</strong> an existing <strong>Layer</strong>. Here you can select under the source tab the <strong>Source Type</strong> to <strong>"POST"</strong> and <strong>Element</strong> to <strong>"META"</strong>. Pick the Custom Meta Key of your choice from the Drop Down list. ', EG_TEXTDOMAIN); ?></p>					
				
			</div>

		</div>
		<?php
		$custom_metas = $metas->get_all_meta(false);
		
		if(!empty($custom_metas)){
			foreach($custom_metas as $meta){
				if(!isset($meta['sort-type'])) $meta['sort-type'] = 'alphabetic';
				?>
				<div class="postbox eg-postbox" style="width:100%;min-width:500px">
					<h3 class="box-closed"><span style="font-weight:400"><?php _e('Handle:', EG_TEXTDOMAIN); ?></span><span>eg-<?php echo $meta['handle']; ?> </span><div class="postbox-arrow"></div></h3>
					<div class="inside" style="display:none;padding:0px !important;margin:0px !important;height:100%;position:relative;background:#ebebeb">
						<input type="hidden" name="esg-meta-handle[]" value="<?php echo $meta['handle']; ?>" />
						<div class="eg-custommeta-row">
							<div class="eg-cus-row-l"><label><?php _e('Name:', EG_TEXTDOMAIN); ?></label><input type="text" name="esg-meta-name[]" value="<?php echo @$meta['name']; ?>"></div>
							<div class="eg-cus-row-l">
								<label><?php _e('Type:', EG_TEXTDOMAIN); ?></label><select name="esg-meta-type[]" disabled="disabled">
									<option value="<?php echo $meta['type']; ?>"><?php echo ucwords(str_replace('-', ' ', $meta['type'])); ?></option>
								</select>
							</div>
							<div class="eg-cus-row-l">
								<label><?php _e('Sort Type:', EG_TEXTDOMAIN); ?></label><select name="esg-meta-sort-type[]" disabled="disabled">
									<option value="<?php echo $meta['sort-type']; ?>"><?php echo ucwords(str_replace('-', ' ', $meta['sort-type'])); ?></option>
								</select>
							</div>
							<div class="eg-cus-row-l"><label><?php _e('Default:', EG_TEXTDOMAIN); ?></label><input type="text" name="esg-meta-default[]" value="<?php echo @$meta['default']; ?>"></div>
							<div class="eg-cus-row-l">
								<?php if($meta['type'] == 'select' || $meta['type'] == 'multi-select') { ?>
								<label><?php _e('List:', EG_TEXTDOMAIN); ?></label><textarea class="eg-custommeta-textarea" name="esg-meta-select[]"><?php echo @$meta['select']; ?></textarea>
								<?php } ?>
							</div>									
						</div>
						<div class="eg-custommeta-save-wrap-settings">
							<a class="button-primary revblue eg-meta-edit" href="javascript:void(0);"><?php _e('Edit', EG_TEXTDOMAIN); ?></a>
							<a class="button-primary revred eg-meta-delete" href="javascript:void(0);"><?php _e('Remove', EG_TEXTDOMAIN); ?></a>
						</div>
					</div>
				</div>
				<?php
			}
		}
		?>
		
		<a class="button-primary revblue" id="eg-meta-add" href="javascript:void(0);"><?php _e('Add New Meta', EG_TEXTDOMAIN); ?></a>
	</div>
	
	<div id="eg-meta-links-wrap">
		<div class="eg-custom-meta-info-box" style="padding:10px 15px; margin-bottom:15px;background:#3498db; color:#fff;">
			<h3 style="color:#fff"><div style="margin-right:15px;" class="dashicons dashicons-info"></div><?php _e('What Are Meta References / Aliases ?', EG_TEXTDOMAIN); ?><div style="float:right" class="dashicons dashicons-arrow-down-alt2"></div></h3>
			<div class="eg-custom-meta-toggle-visible">
				<p><?php _e('To make the selection of different <strong>existing Meta Datas of other plugins and themes</strong> easier within the Essential Grid, we created this Reference Table. <br>Define the Internal name (within Essential Grid) and the original Handle Name of the Meta Key, and all these Meta Keys are available anywhere in Essential Grid from now on.', EG_TEXTDOMAIN); ?></p>
				<h3 style="color:#fff"><?php _e('Where can I edit the Meta Key References ?', EG_TEXTDOMAIN); ?></h3>					
				<p><?php _e('You will still need to edit the Value of these Meta Keys in the old place where you edited them before. (Also applies to  WooCommerce, Event Plugins or other third party plugins)    We only reference on these values to deliver the value to the Grid.', EG_TEXTDOMAIN); ?></p>					
				<h3 style="color:#fff"><?php _e('How to add Meta Field References to my Skin?', EG_TEXTDOMAIN); ?></h3>					
				<p style="margin-bottom:15px"><?php _e('<strong>Edit the Skin</strong> you selected for the Grid(s) and <strong>add or edit</strong> an existing <strong>Layer</strong>. Here you can select under the source tab the <strong>Source Type</strong> to <strong>"POST"</strong> and <strong>Element</strong> to <strong>"META"</strong>. Pick the Custom Meta Key of your choice from the Drop Down list. ', EG_TEXTDOMAIN); ?></p>					
				
			</div>

		</div>
		<?php
		$link_metas = $meta_links->get_all_link_meta();
		
		if(!empty($link_metas)){
			foreach($link_metas as $meta){
				if(!isset($meta['sort-type'])) $meta['sort-type'] = 'alphabetic';
				?>
				<div class="postbox eg-postbox" style="width:100%;min-width:500px">
					<h3 class="box-closed"><span style="font-weight:400"><?php _e('Handle:', EG_TEXTDOMAIN); ?></span><span>egl-<?php echo $meta['handle']; ?> </span><div class="postbox-arrow"></div></h3>
					<div class="inside" style="display:none;padding:0px !important;margin:0px !important;height:100%;position:relative;background:#ebebeb">
						<input type="hidden" name="esg-link-meta-handle[]" value="<?php echo $meta['handle']; ?>" />
						<div class="eg-custommeta-row">
							<div class="eg-cus-row-l"><label><?php _e('Name:', EG_TEXTDOMAIN); ?></label><input type="text" name="esg-link-meta-name[]" value="<?php echo @$meta['name']; ?>"></div>
							<div class="eg-cus-row-l"><label><?php _e('Original Handle:', EG_TEXTDOMAIN); ?></label><input type="text" name="esg-link-meta-original[]" value="<?php echo @$meta['original']; ?>"></div>
							<div class="eg-cus-row-l">
								<label><?php _e('Sort Type:', EG_TEXTDOMAIN); ?></label><select name="esg-link-meta-sort-type[]" disabled="disabled">
									<option value="<?php echo $meta['sort-type']; ?>"><?php echo ucfirst($meta['sort-type']); ?></option>
								</select>
							</div>
						</div>
						<div class="eg-custommeta-save-wrap-settings">
							<a class="button-primary revblue eg-link-meta-edit" href="javascript:void(0);"><?php _e('Edit', EG_TEXTDOMAIN); ?></a>
							<a class="button-primary revred eg-link-meta-delete" href="javascript:void(0);"><?php _e('Remove', EG_TEXTDOMAIN); ?></a>
						</div>
					</div>
				</div>
				<?php
			}
		}
		?>
		<a class="button-primary revblue" id="eg-link-meta-add" href="javascript:void(0);"><?php _e('Add New Meta Reference', EG_TEXTDOMAIN); ?></a>
	</div>
</div>

<?php Essential_Grid_Dialogs::custom_meta_dialog(); ?>
<?php Essential_Grid_Dialogs::custom_meta_linking_dialog(); ?>

<script type="text/javascript">
	jQuery(function(){
		AdminEssentials.initCustomMeta();
	});
</script>