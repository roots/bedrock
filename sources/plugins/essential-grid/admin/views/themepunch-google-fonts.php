<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 */
 
if( !defined( 'ABSPATH') ) exit();
 
 ?>
	<h2><?php echo esc_html(get_admin_page_title()); ?></h2>

	<div id="eg-grid-google-font-wrapper">
		<?php
		$fonts = new ThemePunch_Fonts();
		$custom_fonts = $fonts->get_all_fonts();
		
		if(!empty($custom_fonts)){
			foreach($custom_fonts as $font){
				$cur_font = $font['url'];
				$cur_font = explode('+', $cur_font);
				$cur_font = implode(' ', $cur_font);
				$cur_font = explode(':', $cur_font);
				
				$title = $cur_font['0'];
				
				?>
				<div class="postbox eg-postbox" style="width:100%;min-width:500px">
					<h3 class="box-closed"><span style="font-weight:400"><?php _e('Font Family:', EG_TEXTDOMAIN); ?></span><span style="text-transform:uppercase;"><?php echo $title; ?> </span><div class="postbox-arrow"></div></h3>
					<div class="inside" style="display:none;padding:0px !important;margin:0px !important;height:100%;position:relative;background:#ebebeb">
						<div class="tp-googlefont-row">
							<div class="eg-cus-row-l"><label><?php _e('Handle:', EG_TEXTDOMAIN); ?></label> tp-<input type="text" name="esg-font-handle[]" value="<?php echo @$font['handle']; ?>" readonly="readonly"></div>
							<div class="eg-cus-row-l"><label><?php _e('Parameter:', EG_TEXTDOMAIN); ?></label><input type="text" name="esg-font-url[]" value="<?php echo @$font['url']; ?>"></div>
						</div>
						<div class="tp-googlefont-save-wrap-settings">
							<a class="button-primary revblue eg-font-edit" href="javascript:void(0);"><?php _e('Edit', EG_TEXTDOMAIN); ?></a>
							<a class="button-primary revred eg-font-delete" href="javascript:void(0);"><?php _e('Remove', EG_TEXTDOMAIN); ?></a>
						</div>
					</div>
				</div>
				<?php
			}
		}
		?>
		<div>
			<i style="font-size:10px;color:#777"><?php _e('Copy the Google Font Family from <a href="http://www.google.com/fonts" target="_blank">http://www.google.com/fonts</a> like: <strong>Open+Sans:400,700,600</strong>', EG_TEXTDOMAIN); ?></i>
		</div>
	</div>

	<a class="button-primary revblue" id="eg-font-add" href="javascript:void(0);"><?php _e('Add New Font', EG_TEXTDOMAIN); ?></a>
	
	<?php Essential_Grid_Dialogs::fonts_dialog(); ?>
	
	<script type="text/javascript">
		jQuery(function(){
			AdminEssentials.initGoogleFonts();
		});
	</script>