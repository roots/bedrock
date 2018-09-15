<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 * @since 1.0.6
 */
 
if( !defined( 'ABSPATH') ) exit();

?>
	<h2 class="topheader"><?php _e('Custom Widgets', EG_TEXTDOMAIN); ?></h2>
	
	<div id="eg-grid-widget-areas-wrapper">
		<?php
		$wa = new Essential_Grid_Widget_Areas();
		$sidebars = $wa->get_all_sidebars();
		
		if(is_array($sidebars) && !empty($sidebars)){
			foreach($sidebars as $handle => $name){
				?>
				<div class="postbox eg-postbox" style="width:100%;min-width:500px">
					<h3 class="box-closed"><span style="font-weight:400"><?php _e('Handle:', EG_TEXTDOMAIN); ?></span><span>eg-<?php echo $handle; ?> </span><div class="postbox-arrow"></div></h3>
					<div class="inside" style="display:none;padding:0px !important;margin:0px !important;height:100%;position:relative;background:#ebebeb">
						<input type="hidden" name="esg-widget-area-handle[]" value="<?php echo $handle; ?>" />
						<div class="eg-custommeta-row">
							<div class="eg-cus-row-l"><label><?php _e('Name:', EG_TEXTDOMAIN); ?></label><input type="text" name="esg-widget-area-name[]" value="<?php echo @$name; ?>"></div>
						</div>
						
						<div class="eg-widget-area-save-wrap-settings">
							<a class="button-primary revblue eg-widget-area-edit" href="javascript:void(0);"><?php _e('Edit', EG_TEXTDOMAIN); ?></a>
							<a class="button-primary revred eg-widget-area-delete" href="javascript:void(0);"><?php _e('Remove', EG_TEXTDOMAIN); ?></a>
						</div>
					</div>
				</div>
				<?php
			}
		}
		?>
	</div>
	
	<a class="button-primary revblue" id="eg-widget-area-add" href="javascript:void(0);"><?php _e('Add New Widget Area', EG_TEXTDOMAIN); ?></a>
	
	
	<?php Essential_Grid_Dialogs::widget_areas_dialog(); ?>
	
	<script type="text/javascript">
		jQuery(function(){
			AdminEssentials.initWidgetAreas();
		});
	</script>