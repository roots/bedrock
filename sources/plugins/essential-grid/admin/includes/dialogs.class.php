<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 */
 
if( !defined( 'ABSPATH') ) exit();

class Essential_Grid_Dialogs {
	
	
	/**
	 * Insert Pages Dialog
	 * @since    1.0.0
	 */
	public static function pages_select_dialog(){
		$pages = apply_filters('essgrid_pages_select_dialog', get_pages(array('sort_column' => 'post_name')));
		?>
		<div id="pages-select-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Choose Pages', EG_TEXTDOMAIN); ?>"  style="display: none;">
			<?php echo _e('Choose Pages', EG_TEXTDOMAIN); ?>:
			<table>
				<tr>
					<td colspan="2"><input type="checkbox" id="check-uncheck-pages"><?php echo _e('Select All', EG_TEXTDOMAIN); ?></td>
				</tr>
				<?php
				foreach($pages as $page){
					?>
					<tr><td><input type="checkbox" value="<?php echo str_replace('"', '', $page->post_title).' (ID: '.$page->ID.')'; ?>" name="selected-pages"></td><td><?php echo str_replace('"', '', $page->post_title).' (ID: '.$page->ID.')'; ?></td></tr>
					<?php
				}
				?>
			</table>
			<?php
			do_action('essgrid_pages_select_dialog_post', $pages);
			?>
		</div>
		<?php
	}
	
	
	/**
	 * Insert global CSS Dialog
	 * @since    1.0.0
	 */
	public static function global_css_edit_dialog(){
		$global_css = apply_filters('essgrid_global_css_edit_dialog', Essential_Grid_Global_Css::get_global_css_styles());
		?>
		<div id="global-css-edit-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Global Custom CSS', EG_TEXTDOMAIN); ?>"  style="display: none;">
			<textarea id="eg-global-css-editor"><?php echo $global_css; ?></textarea>
			<?php
			do_action('essgrid_global_css_edit_dialog_post', $global_css);
			?>
		</div>
		<?php
	}
	
	
	/**
	 * Insert navigation skin CSS Dialog
	 * @since    1.0.0
	 */
	public static function navigation_skin_css_edit_dialog(){
		?>
		<div id="navigation-skin-css-edit-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Navigation Skin CSS', EG_TEXTDOMAIN); ?>"  style="display: none;">
			<textarea id="eg-navigation-skin-css-editor"></textarea>
			<?php
			do_action('essgrid_navigation_skin_css_edit_dialog_post');
			?>
		</div>
		<?php
	}
    
	
	/**
	 * Fontello Icons
	 * @since    1.0.0
	 */
	public static function fontello_icons_dialog(){
		?>
		<div id="eg-fontello-icons-dialog-wrap" style="width:602px; height:405px; margin-left:15px;margin-top:15px;overflow:visible;display:none">
			<div id="dialog-eg-fakeicon-in"></div>
			<div id="dialog-eg-fakeicon-out"></div>				
			<div class="eg-icon-chooser eg-icon-soundcloud"></div>
			<div class="eg-icon-chooser eg-icon-music"></div>
			<div class="eg-icon-chooser eg-icon-color-adjust"></div>
			<div class="eg-icon-chooser eg-icon-mail"></div>
			<div class="eg-icon-chooser eg-icon-mail-alt"></div>
			<div class="eg-icon-chooser eg-icon-heart"></div>
			<div class="eg-icon-chooser eg-icon-heart-empty"></div>
			<div class="eg-icon-chooser eg-icon-star"></div>
			<div class="eg-icon-chooser eg-icon-star-empty"></div>
			<div class="eg-icon-chooser eg-icon-user"></div>
			<div class="eg-icon-chooser eg-icon-male"></div>
			<div class="eg-icon-chooser eg-icon-female"></div>
			<div class="eg-icon-chooser eg-icon-video"></div>
			<div class="eg-icon-chooser eg-icon-videocam"></div>
			<div class="eg-icon-chooser eg-icon-picture-1"></div>
			<div class="eg-icon-chooser eg-icon-camera"></div>
			<div class="eg-icon-chooser eg-icon-camera-alt"></div>
			<div class="eg-icon-chooser eg-icon-th-large"></div>
			<div class="eg-icon-chooser eg-icon-th"></div>
			<div class="eg-icon-chooser eg-icon-ok"></div>
			<div class="eg-icon-chooser eg-icon-ok-circled2"></div>
			<div class="eg-icon-chooser eg-icon-ok-squared"></div>
			<div class="eg-icon-chooser eg-icon-cancel"></div>
			<div class="eg-icon-chooser eg-icon-plus"></div>
			<div class="eg-icon-chooser eg-icon-plus-circled"></div>
			<div class="eg-icon-chooser eg-icon-plus-squared"></div>
			<div class="eg-icon-chooser eg-icon-minus"></div>
			<div class="eg-icon-chooser eg-icon-minus-circled"></div>
			<div class="eg-icon-chooser eg-icon-minus-squared"></div>
			<div class="eg-icon-chooser eg-icon-minus-squared-alt"></div>
			<div class="eg-icon-chooser eg-icon-info-circled"></div>
			<div class="eg-icon-chooser eg-icon-info"></div>
			<div class="eg-icon-chooser eg-icon-home"></div>
			<div class="eg-icon-chooser eg-icon-link"></div>
			<div class="eg-icon-chooser eg-icon-unlink"></div>
			<div class="eg-icon-chooser eg-icon-link-ext"></div>
			<div class="eg-icon-chooser eg-icon-lock"></div>
			<div class="eg-icon-chooser eg-icon-lock-open"></div>
			<div class="eg-icon-chooser eg-icon-eye"></div>
			<div class="eg-icon-chooser eg-icon-eye-off"></div>
			<div class="eg-icon-chooser eg-icon-tag"></div>
			<div class="eg-icon-chooser eg-icon-thumbs-up"></div>
			<div class="eg-icon-chooser eg-icon-thumbs-up-alt"></div>
			<div class="eg-icon-chooser eg-icon-download"></div>
			<div class="eg-icon-chooser eg-icon-upload"></div>
			<div class="eg-icon-chooser eg-icon-reply"></div>
			<div class="eg-icon-chooser eg-icon-forward"></div>
			<div class="eg-icon-chooser eg-icon-export-1"></div>
			<div class="eg-icon-chooser eg-icon-print"></div>
			<div class="eg-icon-chooser eg-icon-gamepad"></div>
			<div class="eg-icon-chooser eg-icon-trash"></div>
			<div class="eg-icon-chooser eg-icon-doc-text"></div>
			<div class="eg-icon-chooser eg-icon-doc-inv"></div>
			<div class="eg-icon-chooser eg-icon-folder-1"></div>
			<div class="eg-icon-chooser eg-icon-folder-open"></div>
			<div class="eg-icon-chooser eg-icon-folder-open-empty"></div>
			<div class="eg-icon-chooser eg-icon-rss"></div>
			<div class="eg-icon-chooser eg-icon-rss-squared"></div>
			<div class="eg-icon-chooser eg-icon-phone"></div>
			<div class="eg-icon-chooser eg-icon-menu"></div>
			<div class="eg-icon-chooser eg-icon-cog-alt"></div>
			<div class="eg-icon-chooser eg-icon-wrench"></div>
			<div class="eg-icon-chooser eg-icon-basket-1"></div>
			<div class="eg-icon-chooser eg-icon-calendar"></div>
			<div class="eg-icon-chooser eg-icon-calendar-empty"></div>
			<div class="eg-icon-chooser eg-icon-lightbulb"></div>
			<div class="eg-icon-chooser eg-icon-resize-full-alt"></div>
			<div class="eg-icon-chooser eg-icon-move"></div>
			<div class="eg-icon-chooser eg-icon-down-dir"></div>
			<div class="eg-icon-chooser eg-icon-up-dir"></div>
			<div class="eg-icon-chooser eg-icon-left-dir"></div>
			<div class="eg-icon-chooser eg-icon-right-dir"></div>
			<div class="eg-icon-chooser eg-icon-down-open"></div>
			<div class="eg-icon-chooser eg-icon-left-open"></div>
			<div class="eg-icon-chooser eg-icon-right-open"></div>
			<div class="eg-icon-chooser eg-icon-angle-left"></div>
			<div class="eg-icon-chooser eg-icon-angle-right"></div>
			<div class="eg-icon-chooser eg-icon-angle-double-left"></div>
			<div class="eg-icon-chooser eg-icon-angle-double-right"></div>
			<div class="eg-icon-chooser eg-icon-left-big"></div>
			<div class="eg-icon-chooser eg-icon-right-big"></div>
			<div class="eg-icon-chooser eg-icon-up-hand"></div>
			<div class="eg-icon-chooser eg-icon-ccw-1"></div>
			<div class="eg-icon-chooser eg-icon-shuffle-1"></div>
			<div class="eg-icon-chooser eg-icon-play"></div>
			<div class="eg-icon-chooser eg-icon-play-circled"></div>
			<div class="eg-icon-chooser eg-icon-stop"></div>
			<div class="eg-icon-chooser eg-icon-pause"></div>
			<div class="eg-icon-chooser eg-icon-fast-fw"></div>
			<div class="eg-icon-chooser eg-icon-desktop"></div>
			<div class="eg-icon-chooser eg-icon-laptop"></div>
			<div class="eg-icon-chooser eg-icon-tablet"></div>
			<div class="eg-icon-chooser eg-icon-mobile"></div>
			<div class="eg-icon-chooser eg-icon-flight"></div>
			<div class="eg-icon-chooser eg-icon-font"></div>
			<div class="eg-icon-chooser eg-icon-bold"></div>
			<div class="eg-icon-chooser eg-icon-italic"></div>
			<div class="eg-icon-chooser eg-icon-text-height"></div>
			<div class="eg-icon-chooser eg-icon-text-width"></div>
			<div class="eg-icon-chooser eg-icon-align-left"></div>
			<div class="eg-icon-chooser eg-icon-align-center"></div>
			<div class="eg-icon-chooser eg-icon-align-right"></div>
			<div class="eg-icon-chooser eg-icon-search"></div>
			<div class="eg-icon-chooser eg-icon-indent-left"></div>
			<div class="eg-icon-chooser eg-icon-indent-right"></div>
			<div class="eg-icon-chooser eg-icon-ajust"></div>
			<div class="eg-icon-chooser eg-icon-tint"></div>
			<div class="eg-icon-chooser eg-icon-chart-bar"></div>
			<div class="eg-icon-chooser eg-icon-magic"></div>
			<div class="eg-icon-chooser eg-icon-sort"></div>
			<div class="eg-icon-chooser eg-icon-sort-alt-up"></div>
			<div class="eg-icon-chooser eg-icon-sort-alt-down"></div>
			<div class="eg-icon-chooser eg-icon-sort-name-up"></div>
			<div class="eg-icon-chooser eg-icon-sort-name-down"></div>
			<div class="eg-icon-chooser eg-icon-coffee"></div>
			<div class="eg-icon-chooser eg-icon-food"></div>
			<div class="eg-icon-chooser eg-icon-medkit"></div>
			<div class="eg-icon-chooser eg-icon-puzzle"></div>
			<div class="eg-icon-chooser eg-icon-apple"></div>
			<div class="eg-icon-chooser eg-icon-facebook"></div>
			<div class="eg-icon-chooser eg-icon-gplus"></div>
			<div class="eg-icon-chooser eg-icon-tumblr"></div>
			<div class="eg-icon-chooser eg-icon-twitter-squared"></div>
			<div class="eg-icon-chooser eg-icon-twitter"></div>
			<div class="eg-icon-chooser eg-icon-vimeo-squared"></div>
			<div class="eg-icon-chooser eg-icon-youtube"></div>
			<div class="eg-icon-chooser eg-icon-youtube-squared"></div>
			<div class="eg-icon-chooser eg-icon-picture"></div>
			<div class="eg-icon-chooser eg-icon-check"></div>
			<div class="eg-icon-chooser eg-icon-back"></div>
			<div class="eg-icon-chooser eg-icon-thumbs-up-1"></div>
			<div class="eg-icon-chooser eg-icon-thumbs-down"></div>
			<div class="eg-icon-chooser eg-icon-download-1"></div>
			<div class="eg-icon-chooser eg-icon-upload-1"></div>
			<div class="eg-icon-chooser eg-icon-reply-1"></div>
			<div class="eg-icon-chooser eg-icon-forward-1"></div>
			<div class="eg-icon-chooser eg-icon-export"></div>
			<div class="eg-icon-chooser eg-icon-folder"></div>
			<div class="eg-icon-chooser eg-icon-rss-1"></div>
			<div class="eg-icon-chooser eg-icon-cog"></div>
			<div class="eg-icon-chooser eg-icon-tools"></div>
			<div class="eg-icon-chooser eg-icon-basket"></div>
			<div class="eg-icon-chooser eg-icon-login"></div>
			<div class="eg-icon-chooser eg-icon-logout"></div>
			<div class="eg-icon-chooser eg-icon-resize-full"></div>
			<div class="eg-icon-chooser eg-icon-popup"></div>
			<div class="eg-icon-chooser eg-icon-arrow-combo"></div>
			<div class="eg-icon-chooser eg-icon-left-open-1"></div>
			<div class="eg-icon-chooser eg-icon-right-open-1"></div>
			<div class="eg-icon-chooser eg-icon-left-open-mini"></div>
			<div class="eg-icon-chooser eg-icon-right-open-mini"></div>
			<div class="eg-icon-chooser eg-icon-left-open-big"></div>
			<div class="eg-icon-chooser eg-icon-right-open-big"></div>
			<div class="eg-icon-chooser eg-icon-left"></div>
			<div class="eg-icon-chooser eg-icon-right"></div>
			<div class="eg-icon-chooser eg-icon-ccw"></div>
			<div class="eg-icon-chooser eg-icon-cw"></div>
			<div class="eg-icon-chooser eg-icon-arrows-ccw"></div>
			<div class="eg-icon-chooser eg-icon-level-down"></div>
			<div class="eg-icon-chooser eg-icon-level-up"></div>
			<div class="eg-icon-chooser eg-icon-shuffle"></div>
			<div class="eg-icon-chooser eg-icon-palette"></div>
			<div class="eg-icon-chooser eg-icon-list-add"></div>
			<div class="eg-icon-chooser eg-icon-back-in-time"></div>
			<div class="eg-icon-chooser eg-icon-monitor"></div>
			<div class="eg-icon-chooser eg-icon-paper-plane"></div>
			<div class="eg-icon-chooser eg-icon-brush"></div>
			<div class="eg-icon-chooser eg-icon-droplet"></div>
			<div class="eg-icon-chooser eg-icon-clipboard"></div>
			<div class="eg-icon-chooser eg-icon-megaphone"></div>
			<div class="eg-icon-chooser eg-icon-key"></div>
			<div class="eg-icon-chooser eg-icon-github"></div>
			<div class="eg-icon-chooser eg-icon-github-circled"></div>
			<div class="eg-icon-chooser eg-icon-flickr"></div>
			<div class="eg-icon-chooser eg-icon-flickr-circled"></div>
			<div class="eg-icon-chooser eg-icon-vimeo"></div>
			<div class="eg-icon-chooser eg-icon-vimeo-circled"></div>
			<div class="eg-icon-chooser eg-icon-twitter-1"></div>
			<div class="eg-icon-chooser eg-icon-twitter-circled"></div>
			<div class="eg-icon-chooser eg-icon-facebook-1"></div>
			<div class="eg-icon-chooser eg-icon-facebook-circled"></div>
			<div class="eg-icon-chooser eg-icon-facebook-squared"></div>
			<div class="eg-icon-chooser eg-icon-gplus-1"></div>
			<div class="eg-icon-chooser eg-icon-gplus-circled"></div>
			<div class="eg-icon-chooser eg-icon-pinterest"></div>
			<div class="eg-icon-chooser eg-icon-pinterest-circled"></div>
			<div class="eg-icon-chooser eg-icon-tumblr-1"></div>
			<div class="eg-icon-chooser eg-icon-tumblr-circled"></div>
			<div class="eg-icon-chooser eg-icon-linkedin"></div>
			<div class="eg-icon-chooser eg-icon-linkedin-circled"></div>
			<div class="eg-icon-chooser eg-icon-dribbble"></div>
			<div class="eg-icon-chooser eg-icon-dribbble-circled"></div>
			<div class="eg-icon-chooser eg-icon-picasa"></div>
			<div class="eg-icon-chooser eg-icon-ok-1"></div>
			<div class="eg-icon-chooser eg-icon-doc"></div>
			<div class="eg-icon-chooser eg-icon-left-open-outline"></div>
			<div class="eg-icon-chooser eg-icon-left-open-2"></div>
			<div class="eg-icon-chooser eg-icon-right-open-outline"></div>
			<div class="eg-icon-chooser eg-icon-right-open-2"></div>
			<div class="eg-icon-chooser eg-icon-equalizer"></div>
			<div class="eg-icon-chooser eg-icon-layers-alt"></div>
			<div class="eg-icon-chooser eg-icon-pencil-1"></div>
			<div class="eg-icon-chooser eg-icon-align-justify"></div>
			<?php
			do_action('essgrid_fontello_icons_dialog_post');
			?>
		</div>
        <?php
	}
	
	
	/**
	 * Insert custom meta Dialog
	 * @since    1.0.0
	 */
	public static function custom_meta_dialog(){
		?>
		<div id="custom-meta-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Custom Meta', EG_TEXTDOMAIN); ?>"  style="display: none; padding:20px !important;">
			<div class="eg-cus-row-l"><label><?php _e('Name:', EG_TEXTDOMAIN); ?></label><input type="text" name="eg-custom-meta-name" value="" /></div>

			<p style="font-weight:600;color:#ddd; margin-top:20px;padding-bottom:5px; border-bottom:1px solid #ddd"><?php _e('HANDLES', EG_TEXTDOMAIN); ?></p>
			<div class="eg-cus-row-l"><label><?php _e('Handle:', EG_TEXTDOMAIN); ?></label><span style="margin-left:-20px;margin-right:2px;"><strong>eg-</strong></span><input type="text" name="eg-custom-meta-handle" value="" /></div>
			<p style="font-weight:600;color:#ddd; margin-top:20px;padding-bottom:5px; border-bottom:1px solid #ddd"><?php _e('SETTINGS', EG_TEXTDOMAIN); ?></p>
			<div class="eg-cus-row-l"><label><?php _e('Default:', EG_TEXTDOMAIN); ?></label><input type="text" name="eg-custom-meta-default" value="" /></div>
			<div class="eg-cus-row-l"><label><?php _e('Type:', EG_TEXTDOMAIN); ?></label><select name="eg-custom-meta-type"><option value="text"><?php _e('Text', EG_TEXTDOMAIN); ?></option><option value="multi-select"><?php _e('Multi Select', EG_TEXTDOMAIN); ?></option><option value="select"><?php _e('Select', EG_TEXTDOMAIN); ?></option><option value="image"><?php _e('Image', EG_TEXTDOMAIN); ?></option></select></div>
			<div id="eg-custom-meta-select-wrap" style="display: none;">
				<?php _e('Comma Seperated List of Elements:', EG_TEXTDOMAIN); ?>
				<textarea name="eg-custom-meta-select" style="width: 100%;height: 70px;"></textarea>
			</div>
			
			<p style="font-weight:600;color:#ddd; margin-top:20px;padding-bottom:5px; border-bottom:1px solid #ddd"><?php _e('SORTING', EG_TEXTDOMAIN); ?></p>			
			<div class="eg-cus-row-l"><label><?php _e('Sort Type:', EG_TEXTDOMAIN); ?></label><select name="eg-custom-meta-sort-type"><option value="alphabetic"><?php _e('Alphabetic', EG_TEXTDOMAIN); ?></option><option value="numeric"><?php _e('Numeric', EG_TEXTDOMAIN); ?></option></select></div>
			<?php
			do_action('essgrid_custom_meta_dialog_post');
			?>
		</div>
		<?php
	}
	
	
	/**
	 * Insert link meta Dialog
	 * @since    1.5.0
	 */
	public static function custom_meta_linking_dialog(){
		?>
		<div id="link-meta-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Meta References', EG_TEXTDOMAIN); ?>"  style="display: none; padding:15px !important;">
			
			<div class="eg-cus-row-l"><label><?php _e('Name:', EG_TEXTDOMAIN); ?></label><input type="text" name="eg-link-meta-name" value="" /></div>
			<p style="font-weight:600;color:#ddd; margin-top:20px;padding-bottom:5px; border-bottom:1px solid #ddd"><?php _e('HANDLES', EG_TEXTDOMAIN); ?></p>
			<div class="eg-cus-row-l"><label><?php _e('Internal:', EG_TEXTDOMAIN); ?></label><span style="margin-left:-25px;margin-right:2px;"><strong>egl-</strong></span><input type="text" name="eg-link-meta-handle" value="" /></div>
			<div class="eg-cus-row-l"><label><?php _e('Original:', EG_TEXTDOMAIN); ?></label><input type="text" name="eg-link-meta-original" value="" /></div>
			<p style="font-weight:600;color:#ddd; margin-top:20px;padding-bottom:5px; border-bottom:1px solid #ddd"><?php _e('SORTING', EG_TEXTDOMAIN); ?></p>			
			<div class="eg-cus-row-l"><label><?php _e('Sort Type:', EG_TEXTDOMAIN); ?></label><select name="eg-link-meta-sort-type"><option value="alphabetic"><?php _e('Alphabetic', EG_TEXTDOMAIN); ?></option><option value="numeric"><?php _e('Numeric', EG_TEXTDOMAIN); ?></option></select></div>
			
			<?php
			do_action('essgrid_custom_meta_linking_dialog_post');
			?>
		</div>
		<?php
	}
	
	
	/**
	 * Insert Widget Areas Dialog
	 * @since    1.0.0
	 */
	public static function widget_areas_dialog(){
		?>
		<div id="widget-areas-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('New Widget Area', EG_TEXTDOMAIN); ?>"  style="display: none; padding:20px !important;">
			
			<div class="eg-cus-row-l"><label><?php _e('Handle:', EG_TEXTDOMAIN); ?></label><span style="margin-right:2px;"><strong>eg-</strong></span><input type="text" name="eg-widget-area-handle" value="" /></div>
			<div class="eg-cus-row-l"><label><?php _e('Name:', EG_TEXTDOMAIN); ?></label><input type="text" name="eg-widget-area-name" style="margin-left:29px;" value="" /></div>
			<?php
			do_action('essgrid_widget_areas_dialog_post');
			?>
		</div>
		<?php
	}
	
	
	/**
	 * Insert font Dialog
	 * @since    1.0.0
	 */
	public static function fonts_dialog(){
		?>
		<div id="font-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Add Font', EG_TEXTDOMAIN); ?>"  style="display: none; padding:20px !important;">
			
			<div class="tp-googlefont-cus-row-l"><label><?php _e('Handle:', EG_TEXTDOMAIN); ?></label><span style="margin-left:-20px;margin-right:2px;"><strong>tp-</strong></span><input type="text" name="eg-font-handle" value="" /></div>
			<div style="margin-top:0px; padding-left:100px; margin-bottom:20px;">
				<i style="font-size:12px;color:#777; line-height:20px;"><?php _e('Unique WordPress handle (Internal use only)', EG_TEXTDOMAIN); ?></i>
			</div>
			<div class="tp-googlefont-cus-row-l"><label><?php _e('Parameter:', EG_TEXTDOMAIN); ?></label><input type="text" name="eg-font-url" value="" /></div>
			<div style="padding-left:100px;">
				<i style="font-size:12px;color:#777; line-height:20px;"><?php _e('Copy the Google Font Family from <a href="http://www.google.com/fonts" target="_blank">http://www.google.com/fonts</a><br/>i.e.:<strong>Open+Sans:400,600,700</strong>', EG_TEXTDOMAIN); ?></i>
			</div>
			<?php
			do_action('essgrid_fonts_dialog_post');
			?>
		</div>
		
		
		<?php
	}
	
	
	/**
	 * Meta Dialog
	 * @since    1.0.0
	 */
	public static function meta_dialog(){
		$m = new Essential_Grid_Meta();
		$item_ele = new Essential_Grid_Item_Element();
		
		$post_items = $item_ele->getPostElementsArray();
		$metas = $m->get_all_meta();
		?>
		<div id="meta-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Meta', EG_TEXTDOMAIN); ?>"  style="display: none; padding:20px !important;">
			<table>
				<tr class="eg-table-title"><td><?php _e('Meta Handle', EG_TEXTDOMAIN); ?></td><td><?php _e('Description', EG_TEXTDOMAIN); ?>
			<?php
			if(!empty($post_items)){
				foreach($post_items as $phandle => $pitem){
					echo '<tr class="eg-add-meta-to-textarea"><td>%'.$phandle.'%</td><td>'.$pitem['name'].'</td></tr>';
				}
			}
			
			if(!empty($metas)){
				foreach($metas as $meta){
					if($meta['m_type'] == 'link'){
						echo '<tr class="eg-add-meta-to-textarea"><td>%egl-'.$meta['handle'].'%</td><td>'.$meta['name'].'</td></tr>';
					}else{
						echo '<tr class="eg-add-meta-to-textarea"><td>%eg-'.$meta['handle'].'%</td><td>'.$meta['name'].'</td></tr>';
					}
				}
			}
			
			if(Essential_Grid_Woocommerce::is_woo_exists()){
				$metas = Essential_Grid_Woocommerce::get_meta_array();
				
				foreach($metas as $meta => $name){
					echo '<tr><td>%'.$meta.'%</td><td>'.$name.'</td></tr>';
				}
				
			}
			
			do_action('essgrid_meta_dialog_post');
			?>
			</table>
		</div>
		<?php
	}
	
	
	/**
	 * Post Meta Dialog
	 * @since    1.0.0
	 */
	public static function post_meta_dialog(){
		?>
		<div id="post-meta-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Post Meta Editor', EG_TEXTDOMAIN); ?>"  style="display: none; padding:20px !important;">
			<div id="eg-meta-box">
			
			</div>
			<?php
			do_action('essgrid_post_meta_dialog_post');
			?>
		</div>
		<?php
	}
	
	
	/**
	 * Custom Element Image Dialog
	 * @since    1.0.1
	 */
	public static function custom_element_image_dialog(){
		?>
		<div id="custom-element-image-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Please Choose', EG_TEXTDOMAIN); ?>"  style="display: none; padding:20px !important;">
			<?php
			_e('Please choose the art you wish to add the Image(s): Single Image or Bulk Images ?', EG_TEXTDOMAIN);
			
			do_action('essgrid_custom_element_image_dialog_post');
			?>
		</div>
		<?php
	}
	
	
	/**
	 * Advanced Rules Dialog for Item Skin Editor
	 * @since    1.5.0
	 */
	public static function edit_advanced_rules_dialog(){
		$base = new Essential_Grid_Base();
		$types = $base->get_media_source_order();
		?>
		<div id="advanced-rules-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Advanced Rules', EG_TEXTDOMAIN); ?>"  style="display: none; padding:20px !important;">
			<form id="ar-form-wrap">
				<div class="ad-rules-main"><?php _e('Show/Hide if rules are true:', EG_TEXTDOMAIN); ?>
					<input class="ar-show-field" type="radio" value="show" name="ar-show" checked="checked" /> <?php _e('Show', EG_TEXTDOMAIN); ?>
					<input class="ar-show-field" type="radio" value="hide" name="ar-show" /> <?php _e('Hide', EG_TEXTDOMAIN); ?>
				</div>
				<?php
				$num = 0;
				for($i=0;$i<=2;$i++){
					?>
					<div class="ar-form-table-wrapper">
						<table>
							<tr style="text-align:center">
								<td style="width:150px;"><?php _e('Type', EG_TEXTDOMAIN); ?></td>
								<td style="width:250px;"><?php _e('Meta', EG_TEXTDOMAIN); ?></td>
								<td style="width:85px;"><?php _e('Operator', EG_TEXTDOMAIN); ?></td>
								<td style="width:105px;"><?php _e('Value', EG_TEXTDOMAIN); ?></td>
								<td style="width:105px;"><?php _e('Value', EG_TEXTDOMAIN); ?></td>								
							</tr>
							<?php 
							for($g=0;$g<=2;$g++){
								?>
								<tr>
									<td style="text-align:center">
										<select class="ar-type-field" id="ar-field-<?php echo $num - 1; ?>" name="ar-type[]" style="width: 150px;">
											<option value="off"><?php _e('--- Choose ---', EG_TEXTDOMAIN); ?></option>
											<?php
											if(!empty($types)){
												foreach($types as $handle => $val){
													?>
													<option value="<?php echo $handle; ?>"><?php echo $val['name']; ?></option>
													<?php
												}
											}
											?>
											<option value="meta"><?php _e('Meta', EG_TEXTDOMAIN); ?></option>
										</select>
									</td>
									<td>
										<input class="ar-meta-field" style="width: 150px;" name="ar-meta[]" value="" disabled="disabled" /> <a class="button-secondary ar-open-meta" href="javascript:void(0);"><i class="eg-icon-down-open"></i></a>
									</td>
									<td style="text-align:center">
										<select class="ar-operator-field" name="ar-operator[]" style="width: 45px;">
											<option value="isset"><?php _e('isset', EG_TEXTDOMAIN); ?></option>
											<option value="empty"><?php _e('empty', EG_TEXTDOMAIN); ?></option>
											<option class="ar-opt-meta" value="lt"><</option>
											<option class="ar-opt-meta" value="gt">></option>
											<option class="ar-opt-meta" value="equal">==</option>
											<option class="ar-opt-meta" value="notequal">!=</option>
											<option class="ar-opt-meta" value="lte"><=</option>
											<option class="ar-opt-meta" value="gte">>=</option>
											<option class="ar-opt-meta" value="between"><?php _e('between', EG_TEXTDOMAIN); ?></option>
										</select>
									</td>
									<td>
										<input class="ar-value-field" style="width: 100px;" name="ar-value[]" value="" />
									</td>
									<td>
										<input style="width: 100px;" name="ar-value-2[]" value="" disabled="disabled" />
									</td>
									
								</tr>
								<?php
								if($g !== 2){
									?>
									<tr>
										<td colspan="5" style="text-align:center;">
											<select class="ar-logic-field" id="ar-field-<?php echo $num; ?>-logic" name="ar-logic[]">
												<option value="and"><?php _e('and', EG_TEXTDOMAIN); ?></option>
												<option value="or"><?php _e('or', EG_TEXTDOMAIN); ?></option>
											</select>
										</td>
									</tr>
									<?php
								}
								$num++;
							}
							?>
						</table>
					</div>
					<?php
					if($i !== 2){
						?>
						<div style="text-align:center;">
							<select  class="ar-logic-glob-field" name="ar-logic-glob[]">
								<option value="and"><?php _e('and', EG_TEXTDOMAIN); ?></option>
								<option value="or"><?php _e('or', EG_TEXTDOMAIN); ?></option>
							</select>
						</div>
						<?php
					}
				}
				
				do_action('essgrid_edit_advanced_rules_dialog_post');
				?>
			</form>
		</div>
		<?php
	}
	
	
	/**
	 * Edit Custom Element Dialog
	 * @since    1.0.0
	 */
	public static function edit_custom_element_dialog(){
		$meta = new Essential_Grid_Meta();
		$item_elements = new Essential_Grid_Item_Element();
		
		?>
		<div id="edit-custom-element-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Element Settings', EG_TEXTDOMAIN); ?>"  style="display: none; padding:15px 0px;">
			<form id="edit-custom-element-form">
				<input type="hidden" name="custom-type" value="" />
				<div class="eg-elset-title esg-item-skin-media-title">
					<?php _e('Media:', EG_TEXTDOMAIN); ?>
				</div>
				<div id="esg-item-skin-elements-media">
					<div class="eg-elset-row esg-item-skin-elements" id="esg-item-skin-elements-media-sound">
						<div class="eg-elset-label"  for="custom-soundcloud"><?php _e('SoundCloud Track ID', EG_TEXTDOMAIN); ?></div><input name="custom-soundcloud" type="input" value="" />
					</div>
					<div class="eg-elset-row esg-item-skin-elements" id="esg-item-skin-elements-media-youtube">
						<div class="eg-elset-label"  for="custom-soundcloud"><?php _e('YouTube ID', EG_TEXTDOMAIN); ?></div><input name="custom-youtube" type="input" value="" />
					</div>
					<div class="eg-elset-row esg-item-skin-elements" id="esg-item-skin-elements-media-vimeo">
						<div class="eg-elset-label"  for="custom-soundcloud"><?php _e('Vimeo ID', EG_TEXTDOMAIN); ?></div><input name="custom-vimeo" type="input" value="" />
					</div>
					<div class="esg-item-skin-elements" id="esg-item-skin-elements-media-html5">
						<div class="eg-elset-row"><div class="eg-elset-label"  for="custom-html5-mp4"><?php _e('MP4', EG_TEXTDOMAIN); ?></div><input name="custom-html5-mp4" type="input" value="" /></div>
						<div class="eg-elset-row"><div class="eg-elset-label"  for="custom-html5-ogv"><?php _e('OGV', EG_TEXTDOMAIN); ?></div><input name="custom-html5-ogv" type="input" value="" /></div>
						<div class="eg-elset-row"><div class="eg-elset-label"  for="custom-html5-webm"><?php _e('WEBM', EG_TEXTDOMAIN); ?></div><input name="custom-html5-webm" type="input" value="" /></div>
					</div>
					<div class="eg-elset-row esg-item-skin-elements" id="esg-item-skin-elements-media-image">
						<div class="eg-elset-label" for="custom-image"><?php _e('Image', EG_TEXTDOMAIN); ?></div>
						<input type="hidden" value="" id="esg-custom-image" name="custom-image">
						<a id="eg-custom-choose-from-image-library" class="button-primary revblue" href="javascript:void(0);" data-setto="esg-custom-image"><?php _e('Choose Image', EG_TEXTDOMAIN); ?></a>
						<a id="eg-custom-clear-from-image-library" class="button-primary revred eg-custom-remove-custom-meta-field" href="javascript:void(0);"><?php _e('Remove Image', EG_TEXTDOMAIN); ?></a>
						
						<div id="custom-image-wrapper" style="width:100%;">
							<img id="esg-custom-image-img" src="" style="max-width:200px; display: none;margin:20px 0px 0px 250px;">
						</div>
					</div>
					<div class="eg-elset-row esg-item-skin-elements" id="esg-item-skin-elements-media-ratio">
						<div class="eg-elset-label"  for="custom-ratio"><?php _e('Video Ratio', EG_TEXTDOMAIN); ?></div>
						<select name="custom-ratio">
							<option value="0"><?php _e('4:3', EG_TEXTDOMAIN); ?></option>
							<option value="1"><?php _e('16:9', EG_TEXTDOMAIN); ?></option>
						</select>
					</div>
				</div>
				<div id="">
					
					<?php
					$custom_meta = $meta->get_all_meta(false);
					if(!empty($custom_meta)){
						echo '<div class="eg-elset-title">';				
						_e('Custom Meta:', EG_TEXTDOMAIN);
						echo '</div>';
					
						foreach($custom_meta as $cmeta){
							?>
							<div class="eg-elset-row"><div class="eg-elset-label"  class="eg-mb-label"><?php echo $cmeta['name']; ?>:</div>
								<?php
								switch($cmeta['type']){
									case 'text':
										echo '<input type="text" name="eg-'.$cmeta['handle'].'" value="" />';
									break;
									case 'select':
									case 'multi-select':
										$do_array = ($cmeta['type'] == 'multi-select') ? '[]' : '';
										$el = $meta->prepare_select_by_string($cmeta['select']);
										echo '<select name="eg-'.$cmeta['handle'].$do_array.'"';
										if($cmeta['type'] == 'multi-select') echo ' multiple="multiple" size="5"';
										echo '>';
										if(!empty($el) && is_array($el)){
											if($cmeta['type'] == 'multi-select'){
												echo '<option value="">'.__('---', EG_TEXTDOMAIN).'</option>';
											}
											foreach($el as $ele){
												echo '<option value="'.$ele.'">'.$ele.'</option>';
											}
										}
										echo '</select>';
									break;
									case 'image':
										$var_src = '';
										?>
										<input type="hidden" value="" name="eg-<?php echo $cmeta['handle']; ?>" id="eg-<?php echo $cmeta['handle'].'-cm'; ?>" />
										<a class="button-primary revblue eg-image-add" href="javascript:void(0);" data-setto="eg-<?php echo $cmeta['handle'].'-cm'; ?>"><?php _e('Choose Image', EG_TEXTDOMAIN); ?></a>
										<a class="button-primary revred eg-image-clear" href="javascript:void(0);" data-setto="eg-<?php echo $cmeta['handle'].'-cm'; ?>"><?php _e('Remove Image', EG_TEXTDOMAIN); ?></a>
										<div>
											<img id="eg-<?php echo $cmeta['handle'].'-cm'; ?>-img" src="<?php echo $var_src; ?>" <?php echo ($var_src == '') ? 'style="max-width:200px; display: none;margin:20px 0px 0px 250px;"' : ''; ?>>
										</div>
										<?php
									break;
								}
								?>
							</div>
							<?php
						}
					}else{
						_e('No metas available yet. Add some through the Custom Meta menu of Essential Grid.', EG_TEXTDOMAIN);
						?><div style="clear:both; height:20px"></div><?php 			
					}
					
					$elements = $item_elements->getElementsForDropdown();
					$p_lang = array('post' => __('Post', EG_TEXTDOMAIN), 'woocommerce' => __('WooCommerce', EG_TEXTDOMAIN));
					
					foreach($elements as $type => $element){
						?>
						<div class="eg-elset-title">
							<?php echo $p_lang[$type]; ?>
						</div>
						<?php
						foreach($element as $handle => $name){
							echo '<div class="eg-elset-row"><div class="eg-elset-label"  for="'.$handle.'">'.$name['name'].':</div><input name="'.$handle.'" value="" /></div>';
						}
					}
					echo '<div class="eg-elset-title">';	
					_e('Link To:', EG_TEXTDOMAIN);
					echo '</div>';
					
					echo '<div class="eg-elset-row"><div class="eg-elset-label"  for="post-link">'.__('Post Link', EG_TEXTDOMAIN).':</div><input name="post-link" value="" /></div>';
					
					echo '<div class="eg-elset-title">';	
					_e('Other:', EG_TEXTDOMAIN);
					echo '</div>';
					
					echo '<div class="eg-elset-row"><div class="eg-elset-label"  for="custom-filter">'.__('Filter (comma seperated)', EG_TEXTDOMAIN).':</div><input name="custom-filter" value="" /></div>';
					?>
					<div class="eg-elset-row">
						<div class="eg-elset-label" for="cobbles">
							<?php _e('Cobbles Element Size:', EG_TEXTDOMAIN); ?>
						</div>
						<select name="cobbles-size">
							<option value="1:1"><?php _e('width 1, height 1', EG_TEXTDOMAIN); ?></option>
							<option value="1:2"><?php _e('width 1, height 2', EG_TEXTDOMAIN); ?></option>
							<option value="1:3"><?php _e('width 1, height 3', EG_TEXTDOMAIN); ?></option>
							<option value="2:1"><?php _e('width 2, height 1', EG_TEXTDOMAIN); ?></option>
							<option value="2:2"><?php _e('width 2, height 2', EG_TEXTDOMAIN); ?></option>
							<option value="2:3"><?php _e('width 2, height 3', EG_TEXTDOMAIN); ?></option>
							<option value="3:1"><?php _e('width 3, height 1', EG_TEXTDOMAIN); ?></option>
							<option value="3:2"><?php _e('width 3, height 2', EG_TEXTDOMAIN); ?></option>
							<option value="3:3"><?php _e('width 3, height 3', EG_TEXTDOMAIN); ?></option>
						</select>
					</div>
					<div class="eg-elset-row">
						<?php
						$skins = Essential_Grid_Item_Skin::get_essential_item_skins('all', false);
						?>
						<div class="eg-elset-label" for="use-skin">
							<?php _e('Choose Specific Skin:', EG_TEXTDOMAIN); ?>
						</div>
						<select name="use-skin">
							<option value="-1"><?php _e('-- Default Skin --', EG_TEXTDOMAIN); ?></option>
							<?php
							if(!empty($skins)){
								foreach($skins as $skin){
									echo '<option value="'.$skin['id'].'">'.$skin['name'].'</option>'."\n";
								}
							}
							?>
						</select>
					</div>
					<div class="eg-elset-row">
						<div class="eg-elset-label" for="image-fit">
							<?php _e('Image Fit:', EG_TEXTDOMAIN); ?>
						</div>
						<select name="image-fit">
							<option value="-1"><?php _e('-- Default Fit --', EG_TEXTDOMAIN); ?></option>
							<option value="contain"><?php _e('Contain', EG_TEXTDOMAIN); ?></option>
							<option value="cover"><?php _e('Cover', EG_TEXTDOMAIN); ?></option>
						</select>
					</div>
					<div class="eg-elset-row">
						<div class="eg-elset-label" for="image-repeat">
							<?php _e('Image Repeat:', EG_TEXTDOMAIN); ?>
						</div>
						<select name="image-repeat">
							<option value="-1"><?php _e('-- Default Repeat --', EG_TEXTDOMAIN); ?></option>
							<option value="no-repeat"><?php _e('no-repeat', EG_TEXTDOMAIN); ?></option>
							<option value="repeat"><?php _e('repeat', EG_TEXTDOMAIN); ?></option>
							<option value="repeat-x"><?php _e('repeat-x', EG_TEXTDOMAIN); ?></option>
							<option value="repeat-y"><?php _e('repeat-y', EG_TEXTDOMAIN); ?></option>
						</select>
					</div>
					<div class="eg-elset-row">
						<div class="eg-elset-label" for="image-align-horizontal">
							<?php _e('Horizontal Align:', EG_TEXTDOMAIN); ?>
						</div>
						<select name="image-align-horizontal">
							<option value="-1"><?php _e('-- Horizontal Align --', EG_TEXTDOMAIN); ?></option>
							<option value="left"><?php _e('Left', EG_TEXTDOMAIN); ?></option>
							<option value="center"><?php _e('Center', EG_TEXTDOMAIN); ?></option>
							<option value="right"><?php _e('Right', EG_TEXTDOMAIN); ?></option>
						</select>
					</div>
					<div class="eg-elset-row">
						<div class="eg-elset-label" for="image-align-vertical">
							<?php _e('Vertical Align:', EG_TEXTDOMAIN); ?>
						</div>
						<select name="image-align-vertical">
							<option value="-1"><?php _e('-- Vertical Align --', EG_TEXTDOMAIN); ?></option>
							<option value="top"><?php _e('Top', EG_TEXTDOMAIN); ?></option>
							<option value="center"><?php _e('Center', EG_TEXTDOMAIN); ?></option>
							<option value="bottom"><?php _e('Bottom', EG_TEXTDOMAIN); ?></option>
						</select>
					</div>
				</div>
				<?php
				do_action('essgrid_edit_custom_element_dialog_post');
				?>
			</form>
			<script type="text/javascript">
				jQuery('.eg-image-add').click(function(e) {
					e.preventDefault();
					AdminEssentials.upload_image_img(jQuery(this).data('setto'));
					
					return false; 
				});
				
				jQuery('.eg-image-clear').click(function(e) {
					e.preventDefault();
					var setto = jQuery(this).data('setto');
					jQuery('#'+setto).val('');
					jQuery('#'+setto+'-img').attr("src","");
					jQuery('#'+setto+'-img').hide();
					return false; 
				});
				
				jQuery('#eg-custom-choose-from-image-library').click(function(e) {
					e.preventDefault();
					AdminEssentials.upload_image_img(jQuery(this).data('setto'));
					
					return false; 
				});
				
				jQuery('#eg-custom-clear-from-image-library').click(function(e) {
					e.preventDefault();
					
					jQuery('#esg-custom-image-src').val('');
					jQuery('#esg-custom-image').val('');
					jQuery('#esg-custom-image-img').attr("src","");
					jQuery('#esg-custom-image-img').hide();
					return false; 
				});
				<?php
				do_action('essgrid_edit_custom_element_dialog_script');
				?>
			</script>
		</div>
		<?php
	}
	
	
	/**
	 * Add tinymce shortcode dialog
	 * @since    1.2.0
	 */
	public static function add_tiny_mce_shortcode_dialog(){
		$base = new Essential_Grid_Base();
		$grid_c = new Essential_Grid();
		$skins_c = new Essential_Grid_Item_Skin();
		
		$grids = Essential_Grid::get_grids_short_vc();
		?>
		<div id="ess-grid-tiny-mce-dialog" tabindex="-1" action="" class="essential-dialog-wrap" title="<?php _e('Shortcode Generator', EG_TEXTDOMAIN); ?>" style="display: none; ">
			<script type="text/javascript">
				var token = '<?php echo wp_create_nonce("Essential_Grid_actions"); ?>';
			</script>
			<form id="ess-grid-tiny-mce-settings-form" action="">
			
				<!-- STEP 1 -->
				<div id="ess-grid-tiny-dialog-step-1">
					<div class="ess-top_half">
						<p class="ess-quicktitle"><?php _e('Choose Predefined Grid:', EG_TEXTDOMAIN); ?></p>
						<select name="ess-grid-existing-grid">
							<option value="-1"><?php _e('--- Choose Grid ---', EG_TEXTDOMAIN); ?></option>
							<?php
							if(!empty($grids)){
								foreach($grids as $title => $alias){
									echo '<option value="'.$alias.'">'.$title.'</option>'."\n";
								}
							}
							?>
						</select>
						<div style="margin-top:20px">
							<a href="javascript:void(0);" class="button-primary ess-revgreen" id="eg-add-predefined-grid"><?php _e('Add Selected Grid', EG_TEXTDOMAIN); ?></a>
							<a href="<?php echo Essential_Grid_Base::getViewUrl(Essential_Grid_Admin::VIEW_GRID_CREATE, 'create=true'); ?>" target="_blank" class="button-primary ess-revgreen" id="eg-create-predefined-grid"><?php _e('Create Full Grid', EG_TEXTDOMAIN); ?></a>
						</div>
					</div>
					<div class="ess-bottom_half">
						<p class="ess-quicktitle"><?php _e('Create a Quick Grid:', EG_TEXTDOMAIN); ?></p>
						<a href="javascript:void(0);" class="" id="eg-create-custom-grid">
							<div class="ess-customgridwrap">
								<div class="dashicons dashicons-format-gallery ess-customgridicon"></div>
								<div class="ess-customonbutton"><?php _e('Add Custom', EG_TEXTDOMAIN); ?></div>
							</div>
						</a>
						
						<a href="javascript:void(0);" class="" id="eg-edit-custom-grid">
							<div class="ess-customgridwrap">
								<div class="dashicons dashicons-format-gallery ess-customgridicon"></div>
								<div class="ess-customonbutton"><?php _e('Edit Custom', EG_TEXTDOMAIN); ?></div>
							</div>
						</a>
						
						
						<a href="javascript:void(0);" class="" id="eg-create-popularpost-grid">
							<div class="ess-customgridwrap">
								<div class="dashicons dashicons-groups ess-customgridicon"></div>
								<div class="ess-customonbutton"><?php _e('Popular Post', EG_TEXTDOMAIN); ?></div>
							</div>
						</a>


						<a href="javascript:void(0);" class="" id="eg-create-recentpost-grid">
							<div class="ess-customgridwrap">
								<div class="dashicons dashicons-calendar ess-customgridicon"></div>
								<div class="ess-customonbutton"><?php _e('Recent Post', EG_TEXTDOMAIN); ?></div>
							</div>
						</a>
						
						<a href="javascript:void(0);" class="" id="eg-create-relatedpost-grid">
							<div class="ess-customgridwrap">
								<div class="dashicons dashicons-tickets ess-customgridicon"></div>
								<div class="ess-customonbutton"><?php _e('Related Post', EG_TEXTDOMAIN); ?></div>
							</div>
						</a>
						
					</div>
					
					<div class="ess-stepnavigator">
						<span class="ess-currentstep"><?php _e('STEP 1 - Choose Grid', EG_TEXTDOMAIN); ?></span>
					</div>
				</div>
				
				<!-- STEP 2.5 -->
				<div id="ess-grid-tiny-dialog-step-2-5" style="display: none;">
					<div id="esg-tiny-shortcode-analyze-wrap" class="ess-top_half" style="padding-top:0px;margin-top:0px;padding-bottom:30px;">
						<div class="ess-quicktitle" style="margin-left:25px;"><?php _e('Edit Existing QuickGrid ShortCode', EG_TEXTDOMAIN); ?></div>
						<p>
							<label><?php _e('Input Quickgrid Code', EG_TEXTDOMAIN); ?></label>
							<input type="text" name="eg-shortcode-analyzer" value="" /> <a class="button-primary revblue" href="javascript:void(0);" id="eg-shortcode-do-analyze"><?php _e('Analyze Shortcode', EG_TEXTDOMAIN); ?></a>
						</p>
						<p style="line-height:20px;font-size:11px;font-style:italic;color:#999;"><?php _e('You can paste your Existing Quick Grid Shortcode here for further editing. Simple copy the full Shortcode of Essential grid i.e. [ess_grid settings=....][/ess_grid] and paste it here.', EG_TEXTDOMAIN); ?>
					</div>
					<div style="width:100%;height:30px"></div>
					<div class="ess-stepnavigator">
						<a href="javascript:void(0);" class=""  id="eg-goto-step-1-5">
							<div class="ess-stepbutton-left">
								<div class="dashicons dashicons-arrow-left-alt2"></div>	
								<span class="ess-currentstep"><?php _e('STEP 1 - Select Grid', EG_TEXTDOMAIN); ?></span>										
							</div>
						</a>
					</div>
				</div>
				
				<!-- STEP 2 -->
				<div id="ess-grid-tiny-dialog-step-2" style="display: none;">
					<div id="esg-tiny-settings-wrap">
						<div class="ess-top_half" style="padding:0px 0px 30px;">
							<div class="ess-quicktitle" style="margin-left:25px;"><?php _e('Predefined Grid Settings', EG_TEXTDOMAIN); ?></div>
							
							<p style="">
								<label><?php _e('Choose Grid', EG_TEXTDOMAIN); ?></label>
								<select name="ess-grid-tiny-existing-settings">
									<option value="-1"><?php _e('--- Choose Grid to use Settings from Grid ---', EG_TEXTDOMAIN); ?></option>
									<?php
									if(!empty($grids)){
										foreach($grids as $title => $alias){
											echo '<option value="'.$alias.'">'.$title.'</option>'."\n";
										}
									}
									?>
								</select>
								<p style="line-height:20px;font-size:11px;font-style:italic;color:#999;"><?php _e('Use the Grid Settings from one of the Existing Essential Grid. This helps to use all Complex settings of a Grid, not just the quick settings listed below.', EG_TEXTDOMAIN); ?>
							</p>
						</div>
						<div class="ess-bottom_half" style="padding:30px 0px 0px;">
							<div class="ess-quicktitle" style="margin-left:25px;"><?php _e('Quick Grid Settings', EG_TEXTDOMAIN); ?></div>
							
							<p class="esg-max-entries" style="display: none; background:#FFF;">
								<label><?php _e('Maximum Entries', EG_TEXTDOMAIN); ?></label>
								<input type="text" name="ess-grid-tiny-max-entries" value="20" />
							</p>
							<div id="ess-grid-tiny-grid-settings-wrap">
		
								<p>
									<label><?php _e('Grid Skin', EG_TEXTDOMAIN); ?></label>
									<select name="ess-grid-tiny-entry-skin">
										<?php
										$skins = Essential_Grid_Item_Skin::get_essential_item_skins('all', false);
										
										if(!empty($skins)){
											foreach($skins as $skin){
												echo '<option value="'.$skin['id'].'">'.$skin['name'].'</option>'."\n";
											}
										}
										?>
									</select>
								</p>
								<p>
									<label><?php _e('Layout', EG_TEXTDOMAIN); ?></label>
									<select name="ess-grid-tiny-layout-sizing">
										<option value="boxed"><?php _e('Boxed', EG_TEXTDOMAIN); ?></option>
										<option value="fullwidth"><?php _e('Fullwidth', EG_TEXTDOMAIN); ?></option>
									</select>
								</p>
								<p>
									<label><?php _e('Grid Layout', EG_TEXTDOMAIN); ?></label>
									<select name="ess-grid-tiny-grid-layout">
										<option value="even"><?php _e('Even', EG_TEXTDOMAIN); ?></option>
										<option value="masonry"><?php _e('Masonry', EG_TEXTDOMAIN); ?></option>
										<option value="cobbles"><?php _e('Cobbles', EG_TEXTDOMAIN); ?></option>
									</select>
								</p>
								<p>
									<label><?php _e('Item Spacing', EG_TEXTDOMAIN); ?></label>
									<input type="text" name="ess-grid-tiny-spacings" value="0" />
								</p>
								<p>
									<label><?php _e('Pagination', EG_TEXTDOMAIN); ?></label>
									<input type="radio" style="margin-left:0px !important;" name="ess-grid-tiny-rows-unlimited" value="on" /> <?php _e('Disable', EG_TEXTDOMAIN); ?> 
									<input type="radio" name="ess-grid-tiny-rows-unlimited" checked="checked" value="off" /> <?php _e('Enable', EG_TEXTDOMAIN); ?> 
								</p>
								<p>
									<label><?php _e('Columns', EG_TEXTDOMAIN); ?></label>
									<input type="text" name="ess-grid-tiny-columns" value="5" />
								</p>
								<p>
									<label><?php _e('Max. Visible Rows', EG_TEXTDOMAIN); ?></label>
									<input type="text" name="ess-grid-tiny-rows" value="3" />
								</p>
								<p>
									<label><?php _e('Start and Filter Animations', EG_TEXTDOMAIN); ?></label>
									<?php
									$anims = Essential_Grid_Base::get_grid_animations();
									?>
									<select class="eg-tooltip-wrap tooltipstered" name="ess-grid-tiny-grid-animation" id="grid-animation-select">
										<?php
										foreach($anims as $value => $name){
											echo '<option value="'.$value.'">'.$name.'</option>'."\n";
										}
										?>
									</select>
								</p>
								<p>
									<label><?php _e('Choose Spinner', EG_TEXTDOMAIN); ?></label>
									<select class="eg-tooltip-wrap tooltipstered" name="ess-grid-tiny-use-spinner" id="use_spinner">
										<option value="-1"><?php _e('off', EG_TEXTDOMAIN); ?></option>
										<option value="0" selected="selected">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>
								</p>
							</div>
						</div>
					</div>
					<!--<a href="javascript:void(0);" class="button-primary ess-revgreen"  id="eg-goto-step-3"><?php _e('Add Entries', EG_TEXTDOMAIN); ?></a>-->
					<div style="width:100%;height:30px"></div>
					<div class="ess-stepnavigator">
						<a href="javascript:void(0);" class=""  id="eg-goto-step-1">
							<div class="ess-stepbutton-left">
								<div class="dashicons dashicons-arrow-left-alt2"></div>	
								<span class="ess-currentstep"><?php _e('STEP 1 - Select Grid', EG_TEXTDOMAIN); ?></span>										
							</div>
						</a>

						<a href="javascript:void(0);" class=""  id="eg-goto-step-3">
							<div class="ess-stepbutton-right">
								<span class="ess-currentstep"><?php _e('STEP 3 - Add Items', EG_TEXTDOMAIN); ?></span>										
								<div class="dashicons dashicons-arrow-right-alt2"></div>									
							</div>
						</a>

						<a href="javascript:void(0);" class=""  id="ess-grid-add-custom-shortcode-special" style="display: none;">
							<div class="ess-stepbutton-right">
								<span class="ess-currentstep"><?php _e('FINNISH - Generate Shortcode', EG_TEXTDOMAIN); ?></span>										
								<div class="dashicons dashicons-arrow-right-alt2"></div>									
							</div>
						</a>
					</div>
				</div>
				<?php
				do_action('essgrid_edit_custom_element_dialog_form');
				?>
			</form>
			<form id="ess-grid-tiny-mce-layers-form" action="">
			
				<!-- STEP 3 -->
				<div id="ess-grid-tiny-dialog-step-3" style="display: none;">
					<div style="padding:30px">
						<div class="ess-mediaselector"><a href="javascript:void(0);" class="eg-add-custom-element" data-type="image"><div class="dashicons dashicons-format-image"></div><?php _e('Image', EG_TEXTDOMAIN); ?></a></div>
						<div class="ess-mediaselector"><a href="javascript:void(0);" class="eg-add-custom-element" data-type="html5"><div class="dashicons dashicons-editor-video"></div><?php _e('HTML5 Video', EG_TEXTDOMAIN); ?></a></div>
						<div class="ess-mediaselector"><a href="javascript:void(0);" class="eg-add-custom-element" data-type="vimeo"><div class="dashicons dashicons-format-video"></div><?php _e('Vimeo', EG_TEXTDOMAIN); ?></a></div>
						<div class="ess-mediaselector"><a href="javascript:void(0);" class="eg-add-custom-element" data-type="youtube"><div class="dashicons dashicons-format-video"></div><?php _e('YouTube', EG_TEXTDOMAIN); ?></a></div>
						<div class="ess-mediaselector"><a href="javascript:void(0);" class="eg-add-custom-element" data-type="soundcloud"><div class="dashicons dashicons-format-audio"></div><?php _e('SoundCloud', EG_TEXTDOMAIN); ?></a></div>
						<div class="ess-mediaselector collapseall"><a href="javascript:void(0);"><div class="dashicons dashicons-sort"></div><?php _e('Collapse', EG_TEXTDOMAIN); ?></a></div>						
						<div id="eg-custom-elements-wrap">
							
						</div>
					</div>
					
					<div style="width:100%;height:30px"></div>
					<div class="ess-stepnavigator">
						<a href="javascript:void(0);" class=""  id="eg-goto-step-2">
							<div class="ess-stepbutton-left">
								<div class="dashicons dashicons-arrow-left-alt2"></div>	
								<span class="ess-currentstep"><?php _e('STEP 2 - Grid Settings', EG_TEXTDOMAIN); ?></span>										
							</div>
						</a>
						<a href="javascript:void(0);" class="" id="ess-grid-add-custom-shortcode">
							<div class="ess-stepbutton-right">
								<span class="ess-currentstep"><?php _e('FINNISH - Generate Shortcode', EG_TEXTDOMAIN); ?></span>										
								<div class="dashicons dashicons-arrow-right-alt2"></div>									
							</div>
						</a>
					</div>

				</div>
				<?php
				do_action('essgrid_edit_custom_element_dialog_form_layer');
				?>
			</form>
			<div class="esg-tiny-template-wrap esg-tiny-element" style="display: none;">
				<div class="ess-grid-tiny-collapse-wrapper">
						<div style="width:100%;height:10px;"></div>
						<div class="ess-grid-tiny-custom-wrapper" >
							<!-- POSTER  IMAGE -->
							<div id="ess-grid-tiny-custom-poster-wrap" class="ess-grid-tiny-option-wrap" style="display: none;">
								<div class="ess-quicktitle"><?php _e('Choose Poster Image', EG_TEXTDOMAIN); ?></div>
								<div class="esg-tiny-img-placeholder"><img src="" class="esg-tiny-preshow-img" style="display: none;" /></div>
								<a href="javascript:void(0);" class="esg-toolbutton ess-grid-select-image" data-setto="ess-grid-tiny-custom-poster[]"><div class="dashicons dashicons-plus"></div></a>
								<input type="hidden" name="ess-grid-tiny-custom-poster[]" data-type="image" value="" />
							</div>
							<!-- SIMPLE IMAGE -->
							<div id="ess-grid-tiny-custom-image-wrap" class="ess-grid-tiny-option-wrap" style="display: none;">
								<div class="ess-quicktitle"><?php _e('Choose Image', EG_TEXTDOMAIN); ?></div>
								<div class="esg-tiny-img-placeholder"><img src="" class="esg-tiny-preshow-img" style="display: none;" /></div>
								<a href="javascript:void(0);" class="esg-toolbutton ess-grid-select-image" data-setto="ess-grid-tiny-custom-image[]"><div class="dashicons dashicons-plus"></div></a>
								<input type="hidden" name="ess-grid-tiny-custom-image[]" data-type="image" value="" />
							</div>
							<!-- VIMEO ID SELECTOR -->
							<div id="ess-grid-tiny-custom-vimeo-wrap" class="ess-grid-tiny-option-wrap" style="display: none;">
								<div class="ess-grid-tiny-elset-label"><?php _e('Vimeo ID', EG_TEXTDOMAIN); ?> </div><input type="text" name="ess-grid-tiny-custom-vimeo[]" value="" />
							</div>
							<!-- YOUTUBE ID SELECTOR -->
							<div id="ess-grid-tiny-custom-youtube-wrap" class="ess-grid-tiny-option-wrap" style="display: none;">
								<div class="ess-grid-tiny-elset-label"><?php _e('YouTube ID', EG_TEXTDOMAIN); ?> </div><input type="text" name="ess-grid-tiny-custom-youtube[]" value="" />
							</div>
							<!-- SOUND CLOUD SELECTOR -->
							<div id="ess-grid-tiny-custom-soundcloud-wrap" class="ess-grid-tiny-option-wrap" style="display: none;">
								<div class="ess-quicktitle"><?php _e('SoundCloud', EG_TEXTDOMAIN); ?></div>
								<div class="ess-grid-tiny-elset-label"><?php _e('SoundCloud ID', EG_TEXTDOMAIN); ?></div> <input type="text" name="ess-grid-tiny-custom-soundcloud[]" value="" />
							</div>
							<!-- HTML5 SELECTORS -->
							<div id="ess-grid-tiny-custom-html5-wrap" class="ess-grid-tiny-option-wrap" style="display: none;">
								<div class="ess-grid-tiny-elset-label"><?php _e('WEBM URL', EG_TEXTDOMAIN); ?></div> <input type="text" name="ess-grid-tiny-custom-html5-webm[]" value="" />
								<div class="ess-grid-tiny-elset-label"><?php _e('OGV URL', EG_TEXTDOMAIN); ?></div> <input type="text" name="ess-grid-tiny-custom-html5-ogv[]" value="" />
								<div class="ess-grid-tiny-elset-label"><?php _e('MP4 URL', EG_TEXTDOMAIN); ?></div> <input type="text" name="ess-grid-tiny-custom-html5-mp4[]" value="" />
							</div>
							<!-- VIDEO RATIO -->
							<div id="ess-grid-tiny-custom-ratio-wrap" class="ess-grid-tiny-option-wrap" style="display: none;">
								<div class="ess-grid-tiny-elset-label"><?php _e('Video Ratio', EG_TEXTDOMAIN); ?> </div>
								<select name="ess-grid-tiny-custom-ratio[]">
									<option value="0" selected="selected">4:3</option>
									<option value="1">16:9</option>
								</select>
							</div>
							<!-- COBBLES SETTINGS -->
							<div class="ess-grid-tiny-cobbles-size-wrap ess-grid-tiny-option-wrap" style="display: none;">
								<div class="ess-grid-tiny-elset-label"><?php _e('Cobbles Size', EG_TEXTDOMAIN); ?> </div>
								<select name="ess-grid-tiny-cobbles-size[]">
									<option value="1:1"><?php _e('width 1, height 1', EG_TEXTDOMAIN); ?></option>
									<option value="1:2"><?php _e('width 1, height 2', EG_TEXTDOMAIN); ?></option>
									<option value="1:3"><?php _e('width 1, height 3', EG_TEXTDOMAIN); ?></option>
									<option value="2:1"><?php _e('width 2, height 1', EG_TEXTDOMAIN); ?></option>
									<option value="2:2"><?php _e('width 2, height 2', EG_TEXTDOMAIN); ?></option>
									<option value="2:3"><?php _e('width 2, height 3', EG_TEXTDOMAIN); ?></option>
									<option value="3:1"><?php _e('width 3, height 1', EG_TEXTDOMAIN); ?></option>
									<option value="3:2"><?php _e('width 3, height 2', EG_TEXTDOMAIN); ?></option>
									<option value="3:3"><?php _e('width 3, height 3', EG_TEXTDOMAIN); ?></option>
								</select>
							</div>
							<!-- CUSTOM SKIN SETTINGS -->
							<div class="ess-grid-tiny-use-skin-wrap ess-grid-tiny-option-wrap">
								<div class="ess-grid-tiny-elset-label"><?php _e('Specific Skin', EG_TEXTDOMAIN); ?> </div>
								<?php
								$skins = Essential_Grid_Item_Skin::get_essential_item_skins('all', false);
								?>
								<select name="ess-grid-tiny-use-skin[]">
									<option value="-1"><?php _e('-- Default Skin --', EG_TEXTDOMAIN); ?></option>
									<?php
									if(!empty($skins)){
										foreach($skins as $skin){
											echo '<option value="'.$skin['id'].'">'.$skin['name'].'</option>'."\n";
										}
									}
									?>
								</select>
							</div>
							<?php
							do_action('essgrid_edit_custom_element_dialog_template');
							?>
						</div>
						
						<div class="ess-grid-tiny-custom-wrapper" >
							<?php
							/*$meta = new Essential_Grid_Meta();
							$custom_meta = $meta->get_all_meta(false);
							if(!empty($custom_meta)){
								echo '<div class="ess-grid-tiny-elset-title">';				
								_e('Layers Content', EG_TEXTDOMAIN);
								echo '</div>';
							
								foreach($custom_meta as $cmeta){
									?>
									<div class="ess-grid-tiny-<?php echo $cmeta['handle']; ?>-wrap ess-grid-tiny-elset-row" style="display: none;"><div class="eg-elset-label" class="eg-mb-label"><?php echo $cmeta['name']; ?>:</div>
										<?php
										switch($cmeta['type']){
											case 'text':
												echo '<input type="text" name="ess-grid-tiny-'.$cmeta['handle'].'[]" value="" />';
												break;
											case 'select':
												$el = $meta->prepare_select_by_string($cmeta['select']);
												echo '<select name="ess-grid-tiny-'.$cmeta['handle'].'[]">';
												if(!empty($el) && is_array($el)){
													echo '<option value="">'.__('---', EG_TEXTDOMAIN).'</option>';
													foreach($el as $ele){
														
														echo '<option value="'.$ele.'">'.$ele.'</option>';
													}
												}
												echo '</select>';
												break;
											case 'image':
												$var_src = '';
												?>
												<input type="hidden" value="" name="ess-grid-tiny-<?php echo $cmeta['handle']; ?>[]" id="ess-grid-tiny-<?php echo $cmeta['handle']; ?>" />
												<a class="button-primary revblue eg-image-add" href="javascript:void(0);" data-setto="eg-<?php echo $cmeta['handle']; ?>"><?php _e('Choose Image', EG_TEXTDOMAIN); ?></a>
												<a class="button-primary revred eg-image-clear" href="javascript:void(0);" data-setto="eg-<?php echo $cmeta['handle']; ?>"><?php _e('Remove Image', EG_TEXTDOMAIN); ?></a>
												<div>
													<img id="ess-grid-tiny-<?php echo $cmeta['handle']; ?>-img" src="<?php echo $var_src; ?>" <?php echo ($var_src == '') ? 'style="max-width:200px; display: none;margin:20px 0px 0px 250px;"' : ''; ?>>
												</div>
												<?php
												break;
										}
										?>
									</div>
									<?php
								}
							}else{
								_e('No metas available yet. Add some through the Custom Meta menu of Essential Grid.', EG_TEXTDOMAIN);
								?><div style="clear:both; height:20px"></div><?php 			
							}*/
							
							$elements = Essential_Grid_Item_Element::getElementsForDropdown();
							$p_lang = array('post' => __('Post', EG_TEXTDOMAIN), 'woocommerce' => __('WooCommerce', EG_TEXTDOMAIN));
							
							foreach($elements as $type => $element){
								?>
								<!--<div class="ess-grid-tiny-elset-title">
									<?php echo $p_lang[$type]; ?>
								</div>-->
								<?php
								foreach($element as $handle => $name){
									echo '<div class="ess-grid-tiny-'.$handle.'-wrap ess-grid-tiny-elset-row" style="display: none;"><div class="ess-grid-tiny-elset-label"  for="'.$handle.'">'.$name['name'].':</div><input name="ess-grid-tiny-'.$handle.'[]" value="" /></div>';
								}
							}
							?>
						</div>
						<div style="clear:both"></div>
						<div style="width:100%;height:30px;"></div>						
				</div>
				
				<div class="ess-grid-tiny-custom-pictogram"><div class="dashicons dashicons-format-image"></div></div>
				<div class="esg-toolbutton esg-delete-item">
					<a href="javascript:void(0);" class="esg-tiny-delete-entry"><div class="dashicons dashicons-trash"></div></a>
				</div>
				<div class="esg-toolbutton esg-collapsme-item">
					<a href="javascript:void(0);" class="esg-tiny-collapsme-entry"><div class="dashicons dashicons-sort"></div></a>
				</div>
				<img class="esg-toolbarimg" src="">

			</div>
			<script type="text/javascript">
				<?php
				$skin_layers = array();
				
				$all_skins = $skins_c->get_essential_item_skins();
				
				if(!empty($all_skins)){
					foreach($all_skins as $cskin){
						$custom_layer_elements = array();
						if(isset($cskin['layers'])){
							foreach($cskin['layers'] as $layer){
								if(@isset($layer['settings']['source'])){
							
									switch($layer['settings']['source']){
										case 'post':
											$custom_layer_elements[@$layer['settings']['source-post']] = '';
											break;
										case 'woocommerce':
											$custom_layer_elements[@$layer['settings']['source-woocommerce']] = '';
											break;
									}
									
								}
							}
						}
						$skin_layers[$cskin['id']] = $custom_layer_elements;
					}
				}
				
				?>
				
				var esg_tiny_skin_layers = jQuery.parseJSON(<?php echo $base->jsonEncodeForClientSide($skin_layers); ?>);
				
				
				// KRIKI SCRIPT 
				var esgCustomCollapser = function(bt,direction) {
					var	cp =  bt.closest('.esg-tiny-element'),
						cpitem = cp.find('.ess-grid-tiny-collapse-wrapper'),
						timg = cp.find('.esg-toolbarimg'),
						pimg = cp.find('.esg-tiny-preshow-img');
						
					if ((direction=="auto" && cpitem.hasClass("collapsed")) || direction=="open") {
					   cpitem.slideDown(200);
					   cpitem.removeClass("collapsed");
					   bt.removeClass("collapsed");
					   timg.removeClass("collapsed");
				   } else {
					   cpitem.slideUp(200);					   
					   cpitem.addClass("collapsed");
					   bt.addClass("collapsed");	
					   timg.addClass("collapsed");
					   jQuery.each(pimg,function(index,pimge) {
							if (jQuery(pimge).attr('src') !=undefined && jQuery(pimge).attr('src').length>0)
									timg.attr('src',jQuery(pimge).attr('src'));						   
					   })
					}
				}
				
				jQuery('body').on('click','.esg-toolbutton.esg-collapsme-item',function() {
					esgCustomCollapser(jQuery(this),"auto");
				});
				
					
				jQuery('.ess-mediaselector.collapseall').click(function() {
					var ca = jQuery(this);
					if (ca.hasClass("collapsed")) {
						jQuery('.esg-toolbutton.esg-collapsme-item').each(function() {
							esgCustomCollapser(jQuery(this),"open");
						})
						ca.removeClass("collapsed");
					} else {
						jQuery('.esg-toolbutton.esg-collapsme-item').each(function() {
							esgCustomCollapser(jQuery(this),"close");
						})
					
						ca.addClass("collapsed");						
					}				
				});
				<?php
				do_action('essgrid_edit_custom_element_dialog_script');
				?>
			</script>
		</div>
		<?php
	}
	
	
	/**
	 * Filter Dialog Box
	 * @since    2.1.0
	 */
	public static function filter_select_dialog(){
		?>
		<div id="filter-select-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Select Filter', EG_TEXTDOMAIN); ?>"  style="display: none; padding:20px !important;">
			<select id="eg-filter-select-box" name="custom-filter-select" multiple="true" size="10" style="width: 560px">
				
			</select>
			<?php
			do_action('essgrid_filter_select_dialog');
			?>
		</div>
		<?php
	}
}
?>