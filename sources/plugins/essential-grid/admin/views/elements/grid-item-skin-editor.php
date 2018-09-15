<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 */
 
if( !defined( 'ABSPATH') ) exit();

//force the js file to be included
wp_enqueue_script('essential-grid-item-editor-script', plugins_url('../../assets/js/grid-editor.js', __FILE__ ), array('jquery'), Essential_Grid::VERSION );

$base = new Essential_Grid_Base();
$item_elements = new Essential_Grid_Item_Element();
$meta = new Essential_Grid_Meta();
$meta_link = new Essential_Grid_Meta_Linking();
$fonts = new ThemePunch_Fonts();

//check if id exists and get data from database if so.
$skin = false;
$skin_id = false;

$isCreate = $base->getGetVar('create', 'true');

$title = __('Create New Item Skin', EG_TEXTDOMAIN);
$save = __('Save Item Skin', EG_TEXTDOMAIN);

if(intval($isCreate) > 0){ //currently editing
	$skin = Essential_Grid_Item_Skin::get_essential_item_skin_by_id(intval($isCreate));
	if(!empty($skin)){
		$title = __('Change Item Skin', EG_TEXTDOMAIN);
		$save = __('Change Item Skin', EG_TEXTDOMAIN);
		$skin_id = intval($isCreate);
	}
}

$elements = $item_elements->getElementsForJavascript();
$style_attributes = $item_elements->get_existing_elements(true);
$all_attributes = $item_elements->get_existing_elements();
$element_type = $item_elements->getElementsForDropdown();

$fonts_full = $fonts->get_all_fonts();

$meta_keys = $meta->get_all_meta_handle();

$meta_link_keys = $meta_link->get_all_link_meta_handle();
$meta_keys = array_merge($meta_keys, $meta_link_keys);

$transitions_cover = $base->get_hover_animations();
$transitions_media = $base->get_media_animations();

if(!isset($skin['params'])) $skin['params'] = array(); //fallback if skin does not exist
if(!isset($skin['layers'])) $skin['layers'] = array(); //fallback if skin does not exist

?>

<div id="eg-tool-panel">
	<div id="eg-global-css-dialog" class="revpurple eg-side-buttons">
		<i>&lt;/&gt;</i><?php _e('CSS Editor', EG_TEXTDOMAIN); ?>
	</div>
	<div id="eg-global-change" class="revgreen eg-side-buttons">
		<i class="rs-icon-save-light" style="display: inline-block;vertical-align: middle;width: 18px;height: 20px;background-repeat: no-repeat;margin-right:10px !important;margin-left:2px !important;"></i><?php _e('Save Skin', EG_TEXTDOMAIN); ?>
	</div>
	<a href="<?php echo $base->getViewUrl("","",'essential-'.Essential_Grid_Admin::VIEW_SUB_ITEM_SKIN_OVERVIEW); ?>" id="eg-global-back-to-overview" class="revblue eg-side-buttons">
		<i class="eg-icon-th"></i><?php _e('Skin Overview', EG_TEXTDOMAIN); ?>
	</a>
</div>

<div id="skin-editor-wrapper">

	<?php
	if($skin_id !== false){
		?><input type="hidden" value="<?php echo $skin_id; ?>" name="eg-item-skin-id" /><?php
	}
	?>

	<h2 class="topheader"><?php _e('Item Skin Name:', EG_TEXTDOMAIN); ?> <input type="text" name="item-skin-name" value="<?php echo esc_attr(@$skin['name']); ?>" style="margin-right: 15px;" /> <span style="font-size:12px;font-weight:600;"><?php _e('Class Prefix = ', EG_TEXTDOMAIN); ?> .eg-<span class="eg-tooltip-wrap" title="<?php _e('Each element in the Skin becomes this CSS Prefix', EG_TEXTDOMAIN); ?>" id="eg-item-skin-slug"></span>-</span></h2>

	<div style="width:100%;height:15px"></div>
	<div style="width:1085px">

		<div style="float:left; width:600px;margin-right:15px;">
			<!-- START OF SETTINGS ON THE LEFT SIDE  border: 2px solid #27AE60; -->
			<form id="eg-form-item-skin-layout-settings">
				<input type="hidden" value="<?php echo $base->getVar($skin['params'], 'eg-item-skin-element-last-id', 0, 'i'); ?>" name="eg-item-skin-element-last-id" />
				<div class="postbox eg-postbox" style=""><h3 style="padding:10px"><span><i style="background-color:#27AE60; padding:3px; margin-right:10px;border-radius:50%;-moz-border-radius:50%;-webkit-border-radius:50%;color:#fff;" class="eg-icon-menu"></i><?php _e('Layout Composition', EG_TEXTDOMAIN); ?></span><div class="postbox-arrow"></div></h3>
					<div class="inside" style="padding:0px;margin:0px;height:415px">

						<div class="eg-lc-menu-wrapper" style="height:100%;">
							<div class="eg-lc-vertical-menu" style="height:100%;">
								<ul>
									<li class="selected-lc-setting" data-toshow="eg-lc-layout"><i class="eg-icon-th-large"></i><p><?php _e('Layout', EG_TEXTDOMAIN); ?></p></li>
									<li data-toshow="eg-lc-cover"><i class="eg-icon-stop"></i><p><?php _e('Cover', EG_TEXTDOMAIN); ?></p></li>
									<li data-toshow="eg-lc-spaces"><i class="eg-icon-indent-right"></i><p><?php _e('Spaces', EG_TEXTDOMAIN); ?></p></li>
									<li data-toshow="eg-lc-content-shadow"><i class="eg-icon-picture"></i><p><?php _e('Shadow', EG_TEXTDOMAIN); ?></p></li>
									<li data-toshow="eg-lc-content-animation"><i class="eg-icon-star"></i><p><?php _e('Animation', EG_TEXTDOMAIN); ?></p></li>
									<li data-toshow="eg-lc-content-link-seo"><i class="eg-icon-link"></i><p><?php _e('Link/SEO', EG_TEXTDOMAIN); ?></p></li>
								</ul>
							</div>

							<!-- THE LAYOUT SETTINGS -->
							<div id="eg-lc-layout" class="esg-lc-settings-container active-esc">
								<div style="margin-top:15px">
									<label for="choose-preset" class="eg-group-setter"><?php _e('Grid Layout', EG_TEXTDOMAIN); ?></label>
									<input type="radio" name="choose-layout" value="even" class="firstinput" <?php checked($base->getVar($skin['params'], 'choose-layout', 'even'), 'even'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('Each item gets Same Height. Width and Height are Item Ratio dependent.', EG_TEXTDOMAIN); ?>"><?php _e('Even', EG_TEXTDOMAIN); ?></span>
									<input type="radio" name="choose-layout" value="masonry" <?php checked($base->getVar($skin['params'], 'choose-layout', 'even'), 'masonry'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('Items height are depending on Media height and Content height.', EG_TEXTDOMAIN); ?>"><?php _e('Masonry', EG_TEXTDOMAIN); ?></span>
								</div>
								<!-- MASONRY SETTINGS-->
								<div id="eg-show-content">
									<div style="margin-top:15px">
										<label style="float:left" class="eg-group-setter eg-tooltip-wrap" title="<?php _e('Position of Fixed Content', EG_TEXTDOMAIN); ?>"><?php _e('Content', EG_TEXTDOMAIN); ?></label>
										<div class="select_wrapper" style="float:left;">
											<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
											<select name="show-content">
												<option value="bottom" <?php selected($base->getVar($skin['params'], 'show-content', 'none'), 'bottom'); ?>><?php _e('Bottom', EG_TEXTDOMAIN); ?></option>
												<option value="top" <?php selected($base->getVar($skin['params'], 'show-content', 'none'), 'top'); ?>><?php _e('Top', EG_TEXTDOMAIN); ?></option>
												<option value="none" <?php selected($base->getVar($skin['params'], 'show-content', 'none'), 'none'); ?>><?php _e('Hide', EG_TEXTDOMAIN); ?></option>
											</select>
										</div>
										<div class="select_wrapper" style="float:left;">
											<div class="select_fake eg-tooltip-wrap" title="<?php _e('Content Text Align Globaly', EG_TEXTDOMAIN); ?>"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
											<select name="content-align">
												<option value="left" <?php selected($base->getVar($skin['params'], 'content-align', 'left'), 'left'); ?>><?php _e('Left', EG_TEXTDOMAIN); ?></option>
												<option value="center" <?php selected($base->getVar($skin['params'], 'content-align', 'left'), 'center'); ?>><?php _e('Center', EG_TEXTDOMAIN); ?></option>
												<option value="right" <?php selected($base->getVar($skin['params'], 'content-align', 'left'), 'right'); ?>><?php _e('Right', EG_TEXTDOMAIN); ?></option>
											</select>
										</div>
									</div>
								</div>
								<div class="clear"></div>
								<div style="margin-top:15px">
									<label style="float: left;" class="eg-group-setter eg-tooltip-wrap" title="<?php _e('Media Repeat', EG_TEXTDOMAIN); ?>"><?php _e('Media Repeat', EG_TEXTDOMAIN); ?></label>
									<div class="select_wrapper" style="float: left;">
										<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
										<select name="image-repeat">
											<option value="no-repeat" <?php selected($base->getVar($skin['params'], 'image-repeat', 'no-repeat'), 'no-repeat'); ?>><?php _e('no-repeat', EG_TEXTDOMAIN); ?></option>
											<option value="repeat" <?php selected($base->getVar($skin['params'], 'image-repeat', 'no-repeat'), 'repeat'); ?>><?php _e('repeat', EG_TEXTDOMAIN); ?></option>
											<option value="repeat-x" <?php selected($base->getVar($skin['params'], 'image-repeat', 'no-repeat'), 'repeat-x'); ?>><?php _e('repeat-x', EG_TEXTDOMAIN); ?></option>
											<option value="repeat-y" <?php selected($base->getVar($skin['params'], 'image-repeat', 'no-repeat'), 'repeat-y'); ?>><?php _e('repeat-y', EG_TEXTDOMAIN); ?></option>
										</select>
									</div>
								</div>
								<div class="clear"></div>
								<div style="margin-top:15px">
									<label style="float: left;" class="eg-group-setter eg-tooltip-wrap" title="<?php _e('Media Fit', EG_TEXTDOMAIN); ?>"><?php _e('Media Fit', EG_TEXTDOMAIN); ?></label>
									<div class="select_wrapper" style="float: left;">
										<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
										<select name="image-fit">
											<option value="contain" <?php selected($base->getVar($skin['params'], 'image-fit', 'cover'), 'contain'); ?>><?php _e('Contain', EG_TEXTDOMAIN); ?></option>
											<option value="cover" <?php selected($base->getVar($skin['params'], 'image-fit', 'cover'), 'cover'); ?>><?php _e('Cover', EG_TEXTDOMAIN); ?></option>
										</select>
									</div>
								</div>
								<div class="clear"></div>
								<div style="margin-top:15px">
									<label style="float: left;" class="eg-group-setter eg-tooltip-wrap" title="<?php _e('Media Align horizontal and vertical', EG_TEXTDOMAIN); ?>"><?php _e('Media Align', EG_TEXTDOMAIN); ?></label>
									<div class="select_wrapper" style="float: left;">
										<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
										<select name="image-align-horizontal">
											<option value="left" <?php selected($base->getVar($skin['params'], 'image-align-horizontal', 'center'), 'left'); ?>><?php _e('Hor. Left', EG_TEXTDOMAIN); ?></option>
											<option value="center" <?php selected($base->getVar($skin['params'], 'image-align-horizontal', 'center'), 'center'); ?>><?php _e('Hor. Center', EG_TEXTDOMAIN); ?></option>
											<option value="right" <?php selected($base->getVar($skin['params'], 'image-align-horizontal', 'center'), 'right'); ?>><?php _e('Hor. Right', EG_TEXTDOMAIN); ?></option>
										</select>
									</div>
									<div class="select_wrapper" style="float: left;">
										<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
										<select name="image-align-vertical">
											<option value="top" <?php selected($base->getVar($skin['params'], 'image-align-vertical', 'center'), 'top'); ?>><?php _e('Ver. Top', EG_TEXTDOMAIN); ?></option>
											<option value="center" <?php selected($base->getVar($skin['params'], 'image-align-vertical', 'center'), 'center'); ?>><?php _e('Ver. Center', EG_TEXTDOMAIN); ?></option>
											<option value="bottom" <?php selected($base->getVar($skin['params'], 'image-align-vertical', 'center'), 'bottom'); ?>><?php _e('Ver. Bottom', EG_TEXTDOMAIN); ?></option>
										</select>
									</div>
								</div>
								<div class="clear"></div>
								<!-- EVEN SETTINGS -->
								<div id="eg-show-ratio" >
									<p>
										<label class="eg-group-setter"><?php _e('Ratio X', EG_TEXTDOMAIN); ?></label>
										<span id="element-x-ratio" class="slider-settings eg-tooltip-wrap" title="<?php _e('Width Ratio of Item.', EG_TEXTDOMAIN); ?>"></span> <input class="input-settings-small element-setting" type="text" name="element-x-ratio" value="<?php echo $base->getVar($skin['params'], 'element-x-ratio', 4, 'i'); ?>" />
									</p>
									<p>
										<label style="float:left" class="eg-group-setter"><?php _e('Ratio Y', EG_TEXTDOMAIN); ?></label>
										<span id="element-y-ratio" class="slider-settings eg-tooltip-wrap" title="<?php _e('Height Ratio of Item.', EG_TEXTDOMAIN); ?>"></span> <input class="input-settings-small element-setting" type="text" name="element-y-ratio" value="<?php echo $base->getVar($skin['params'], 'element-y-ratio', 3, 'i'); ?>" />
									</p>
								</div>

								<div class="clear"></div>

							</div>
							<!-- THE COVER SETTINGS -->
							<div id="eg-lc-cover" class="esg-lc-settings-container">
								<!-- COVER LAYOUT -->
								<div style="margin-top:15px">
									<label style="float:left" class="eg-group-setter eg-tooltip-wrap" title="<?php _e('Dynamic Covering Content Type. Show Cover Background on full Media, or only under Cover Contents ?', EG_TEXTDOMAIN); ?>"><?php _e('Cover Type', EG_TEXTDOMAIN); ?></label>
									<div class="select_wrapper" style="float:left;">
										<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
										<select name="cover-type">
											<option value="full" <?php selected($base->getVar($skin['params'], 'cover-type', 'full'), 'full'); ?>><?php _e('Full', EG_TEXTDOMAIN); ?></option>
											<option value="content" <?php selected($base->getVar($skin['params'], 'cover-type', 'full'), 'content'); ?>><?php _e('Content Based', EG_TEXTDOMAIN); ?></option>
										</select>
									</div>
								</div>
								<div class="clear"></div>

								<p>
									<label style="float:left; width:150px" class="eg-cover-setter eg-tooltip-wrap" title="<?php _e('Background Color of Covers', EG_TEXTDOMAIN); ?>"><?php _e('Background Color', EG_TEXTDOMAIN); ?></label>
									<input class="element-setting" type="text" name="container-background-color" id="container-background-color" data-default-color="#363839" value="<?php echo $base->getVar($skin['params'], 'container-background-color', '#363839', 's'); ?>" />
								</p>
								<p>
									<label style="float:left; width:150px" class="eg-cover-setter"><?php _e('Opacity', EG_TEXTDOMAIN); ?></label>
									<span id="element-container-background-color-opacity" class="slider-settings eg-tooltip-wrap" title="<?php _e('Cover Background Color opacity', EG_TEXTDOMAIN); ?>"></span>
									<input class="input-settings-small element-setting" type="text" name="element-container-background-color-opacity" value="<?php echo $base->getVar($skin['params'], 'element-container-background-color-opacity', '85', 'i'); ?>" />
								</p>

								<div style="display:none">
									<label style="float:left; width:150px" class="eg-group-setter"><?php _e('Background Fit', EG_TEXTDOMAIN); ?></label>
									<div class="select_wrapper" style="float:left;">
										<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
										<select name="cover-background-size">
											<option value="cover" <?php selected($base->getVar($skin['params'], 'cover-background-size', 'cover'), 'cover'); ?>><?php _e('Cover', EG_TEXTDOMAIN); ?></option>
											<option value="contain" <?php selected($base->getVar($skin['params'], 'cover-background-size', 'cover'), 'contain'); ?>><?php _e('Contain', EG_TEXTDOMAIN); ?></option>
											<!--option value="%" <?php selected($base->getVar($skin['params'], 'cover-background-size', 'cover'), '%'); ?>><?php _e('%', EG_TEXTDOMAIN); ?></option-->
											<option value="auto" <?php selected($base->getVar($skin['params'], 'cover-background-size', 'cover'), 'auto'); ?>><?php _e('Normal', EG_TEXTDOMAIN); ?></option>
										</select>
									</div><div class="clear"></div>
								</div>
								<div style="display:none">
									<label style="float:left; width:150px" class="eg-group-setter"><?php _e('Background Repeat', EG_TEXTDOMAIN); ?></label>
									<div class="select_wrapper" style="float:left;">
										<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
										<select name="cover-background-repeat">
											<option value="no-repeat" <?php selected($base->getVar($skin['params'], 'cover-background-repeat', 'no-repeat'), 'auto'); ?>><?php _e('no-repeat', EG_TEXTDOMAIN); ?></option>
											<option value="repeat" <?php selected($base->getVar($skin['params'], 'cover-background-repeat', 'no-repeat'), 'repeat'); ?>><?php _e('repeat', EG_TEXTDOMAIN); ?></option>
											<option value="repeat-x" <?php selected($base->getVar($skin['params'], 'cover-background-repeat', 'no-repeat'), 'repeat-x'); ?>><?php _e('repeat-x', EG_TEXTDOMAIN); ?></option>
											<option value="repeat-y" <?php selected($base->getVar($skin['params'], 'cover-background-repeat', 'no-repeat'), 'repeat-y'); ?>><?php _e('repeat-y', EG_TEXTDOMAIN); ?></option>
										</select>
									</div><div class="clear"></div>
								</div>
								<div style="display:none">
									<?php
									$cover_image_url = false;
									$cover_image_id = $base->getVar($skin['params'], 'cover-background-image', '0', 'i');
									if($cover_image_id > 0){
										$cover_image_url = wp_get_attachment_image_src($cover_image_id, 'full');
									}
									?>
									<input type="hidden" value="<?php echo $base->getVar($skin['params'], 'cover-background-image', '0', 'i'); ?>" name="cover-background-image">
									<input type="hidden" value="<?php echo ($cover_image_url !== false) ? $cover_image_url[0] : ''; ?>" name="cover-background-image-url">
									<div id="cover-background-image-wrap"<?php echo ($cover_image_url !== false) ? ' style="background-image: url('.$cover_image_url[0].'); background-size: 100% 100%;"' : ''; ?>><?php _e("Click to<br>Select<br>Image", EG_TEXTDOMAIN); ?></div>
									<i class="eg-icon-trash" id="remove-cover-background-image-wrap"><?php _e('Remove', EG_TEXTDOMAIN); ?></i>
								</div>

							</div>

							<!-- SPACES -->
							<div id="eg-lc-spaces" class="esg-lc-settings-container">
								<ul class="eg-submenu" style="width:100%;margin:-18px 0px 0px -20px;padding:0px;height:50px;vertical-align:bottom">
									<li data-toshow="eg-style-full" class="selected-submenu-setting eg-tooltip-wrap" title="<?php _e('Padding and border of the full item', EG_TEXTDOMAIN); ?>" style="float:left; margin-top:10px; padding:7px 10px;"><i class="eg-icon-stop"></i><?php _e('Full Item', EG_TEXTDOMAIN); ?></li>
									<li data-toshow="eg-style-content" class="eg-tooltip-wrap" title="<?php _e('Padding and border of the Fixed Content', EG_TEXTDOMAIN); ?>" style="float:left; margin-top:10px; padding:7px 10px;"><i class="eg-icon-doc-text"></i><?php _e('Content', EG_TEXTDOMAIN); ?></li>
									<div class="clear"></div>
								</ul>
								<div class="clear"></div>
								<!-- FULL STYLING -->
								<div id="eg-style-full">
									<!-- THE PADDING, BORDER AND BG COLOR -->
									<div style="margin-top:15px">
										<label class="eg-tooltip-wrap" title="<?php _e('Background Color of Full Item', EG_TEXTDOMAIN); ?>"><?php _e('Item BG Color', EG_TEXTDOMAIN); ?></label>
										<input class="element-setting" name="full-bg-color" type="text" id="full-bg-color" value="<?php echo $base->getVar($skin['params'], 'full-bg-color', '#ffffff'); ?>" data-default-color="#ffffff">
									</div>
									<p>
										<?php
										$padding = $base->getVar($skin['params'], 'full-padding');
										?>
										<label class="eg-tooltip-wrap" title="<?php _e('Top,Right,Bottom,Left Padding of Item', EG_TEXTDOMAIN); ?>"><?php _e('Item Paddings', EG_TEXTDOMAIN); ?></label>
										<input class="input-settings-small element-setting firstinput" type="text" name="full-padding[]" value="<?php echo (isset($padding[0])) ? $padding[0] : 0; ?>" />
										<input class="input-settings-small element-setting" type="text" name="full-padding[]" value="<?php echo (isset($padding[1])) ? $padding[1] : 0; ?>" />
										<input class="input-settings-small element-setting" type="text" name="full-padding[]" value="<?php echo (isset($padding[2])) ? $padding[2] : 0; ?>" />
										<input class="input-settings-small element-setting" type="text" name="full-padding[]" value="<?php echo (isset($padding[3])) ? $padding[3] : 0; ?>" /> px
									</p>
									<p>
										<?php
										$border = $base->getVar($skin['params'], 'full-border');
										?>
										<label class="eg-tooltip-wrap" title="<?php _e('Top,Right,Bottom,Left Border of Item', EG_TEXTDOMAIN); ?>"><?php _e('Item Border', EG_TEXTDOMAIN); ?></label>
										<input class="input-settings-small element-setting firstinput" type="text" name="full-border[]" value="<?php echo (isset($border[0])) ? $border[0] : 0; ?>" />
										<input class="input-settings-small element-setting" type="text" name="full-border[]" value="<?php echo (isset($border[1])) ? $border[1] : 0; ?>" />
										<input class="input-settings-small element-setting" type="text" name="full-border[]" value="<?php echo (isset($border[2])) ? $border[2] : 0; ?>" />
										<input class="input-settings-small element-setting" type="text" name="full-border[]" value="<?php echo (isset($border[3])) ? $border[3] : 0; ?>" /> px
									</p>
									<p>
										<?php
										$radius = $base->getVar($skin['params'], 'full-border-radius');
										?>
										<label class="eg-tooltip-wrap" title="<?php _e('Top Left,Top Right,Bottom Right, Bottom Left Border Radius of Item', EG_TEXTDOMAIN); ?>"><?php _e('Border Radius', EG_TEXTDOMAIN); ?></label>
										<input class="input-settings-small element-setting firstinput" type="text" name="full-border-radius[]" value="<?php echo (isset($radius[0])) ? $radius[0] : 0; ?>" />
										<input class="input-settings-small element-setting" type="text" name="full-border-radius[]" value="<?php echo (isset($radius[1])) ? $radius[1] : 0; ?>" />
										<input class="input-settings-small element-setting" type="text" name="full-border-radius[]" value="<?php echo (isset($radius[2])) ? $radius[2] : 0; ?>" />
										<input class="input-settings-small element-setting" type="text" name="full-border-radius[]" value="<?php echo (isset($radius[3])) ? $radius[3] : 0; ?>" /> px
									</p>
									<p>
										<label><?php _e('Border Color', EG_TEXTDOMAIN); ?></label>
										<input class="element-setting"  name="full-border-color" type="text" id="full-border-color" value="<?php echo $base->getVar($skin['params'], 'full-border-color', 'transparent'); ?>" data-default-color="transparent">
									</p>
									<div style="margin-top:10px">
										<label style="float:left" class="eg-tooltip-wrap" title="<?php _e('Border Line Style', EG_TEXTDOMAIN); ?>"><?php _e('Border Style', EG_TEXTDOMAIN); ?></label>
										<div class="select_wrapper" style="float:left;">
											<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
											<select name="full-border-style">
												<option value="none" <?php selected($base->getVar($skin['params'], 'full-border-style', 'none'), 'none'); ?>><?php _e('none', EG_TEXTDOMAIN); ?></option>
												<option value="solid" <?php selected($base->getVar($skin['params'], 'full-border-style', 'none'), 'solid'); ?>><?php _e('solid', EG_TEXTDOMAIN); ?></option>
												<option value="dotted" <?php selected($base->getVar($skin['params'], 'full-border-style', 'none'), 'dotted'); ?>><?php _e('dotted', EG_TEXTDOMAIN); ?></option>
												<option value="dashed" <?php selected($base->getVar($skin['params'], 'full-border-style', 'none'), 'dashed'); ?>><?php _e('dashed', EG_TEXTDOMAIN); ?></option>
												<option value="double" <?php selected($base->getVar($skin['params'], 'full-border-style', 'none'), 'double'); ?>><?php _e('double', EG_TEXTDOMAIN); ?></option>
											</select>
										</div>
										<div class="clear"></div>
									</div>
									<p>
										<label><?php _e('Overflow Hidden', EG_TEXTDOMAIN); ?></label>
										<input type="radio" name="full-overflow-hidden" value="true" class="firstinput" <?php checked($base->getVar($skin['params'], 'full-overflow-hidden', 'false'), 'true'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('Hide Overflow (fix border radius issues)', EG_TEXTDOMAIN); ?>"><?php _e('On', EG_TEXTDOMAIN); ?></span>
										<input type="radio" name="full-overflow-hidden" value="false" <?php checked($base->getVar($skin['params'], 'full-overflow-hidden', 'false'), 'false'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('Show Overflowed content', EG_TEXTDOMAIN); ?>"><?php _e('Off', EG_TEXTDOMAIN); ?></span>
									</p>
								</div>
								<div id="eg-style-content" style="display:none">
									<!-- THE PADDING, BORDER AND BG COLOR -->
									<div style="margin-top:15px">
										<label><?php _e('Content BG Color', EG_TEXTDOMAIN); ?></label>
										<input class="element-setting" name="content-bg-color" type="text" id="content-bg-color" value="<?php echo $base->getVar($skin['params'], 'content-bg-color', '#ffffff'); ?>" data-default-color="#ffffff">
									</div>
									<p>
										<?php
										$padding = $base->getVar($skin['params'], 'content-padding');
										?>
										<label class="eg-tooltip-wrap" title="<?php _e('Top, Right, Bottom, Left Padding of Fix Content', EG_TEXTDOMAIN); ?>"><?php _e('Content Paddings', EG_TEXTDOMAIN); ?></label>
										<input class="input-settings-small element-setting firstinput" type="number" name="content-padding[]" value="<?php echo (isset($padding[0])) ? $padding[0] : 0; ?>" />
										<input class="input-settings-small element-setting" type="number" name="content-padding[]" value="<?php echo (isset($padding[1])) ? $padding[1] : 0; ?>" />
										<input class="input-settings-small element-setting" type="number" name="content-padding[]" value="<?php echo (isset($padding[2])) ? $padding[2] : 0; ?>" />
										<input class="input-settings-small element-setting" type="number" name="content-padding[]" value="<?php echo (isset($padding[3])) ? $padding[3] : 0; ?>" /> px
									</p>
									<p>
										<?php
										$border = $base->getVar($skin['params'], 'content-border');
										?>
										<label class="eg-tooltip-wrap" title="<?php _e('Top, Right, Bottom, Left Padding of Fix Content', EG_TEXTDOMAIN); ?>"><?php _e('Content Border', EG_TEXTDOMAIN); ?></label>
										<input class="input-settings-small element-setting firstinput" type="number" name="content-border[]" value="<?php echo (isset($border[0])) ? $border[0] : 0; ?>" />
										<input class="input-settings-small element-setting" type="number" name="content-border[]" value="<?php echo (isset($border[1])) ? $border[1] : 0; ?>" />
										<input class="input-settings-small element-setting" type="number" name="content-border[]" value="<?php echo (isset($border[2])) ? $border[2] : 0; ?>" />
										<input class="input-settings-small element-setting" type="number" name="content-border[]" value="<?php echo (isset($border[3])) ? $border[3] : 0; ?>" /> px
									</p>
									<p>
										<?php
										$radius = $base->getVar($skin['params'], 'content-border-radius');
										?>
										<label class="eg-tooltip-wrap" title="<?php _e('Top Left, Top Right, Bottom Right, Bottom Left Border Radius of Fix Content', EG_TEXTDOMAIN); ?>"><?php _e('Border Radius', EG_TEXTDOMAIN); ?></label>
										<input class="input-settings-small element-setting firstinput" type="text" name="content-border-radius[]" value="<?php echo (isset($radius[0])) ? $radius[0] : 0; ?>" />
										<input class="input-settings-small element-setting" type="text" name="content-border-radius[]" value="<?php echo (isset($radius[1])) ? $radius[1] : 0; ?>" />
										<input class="input-settings-small element-setting" type="text" name="content-border-radius[]" value="<?php echo (isset($radius[2])) ? $radius[2] : 0; ?>" />
										<input class="input-settings-small element-setting" type="text" name="content-border-radius[]" value="<?php echo (isset($radius[3])) ? $radius[3] : 0; ?>" /> px
									</p>
									<p>
										<label><?php _e('Border Color', EG_TEXTDOMAIN); ?></label>
										<input class="element-setting" name="content-border-color" type="text" id="content-border-color" value="<?php echo $base->getVar($skin['params'], 'content-border-color', 'transparent'); ?>" data-default-color="transparent">
									</p>
									<div style="margin-top:10px">
										<label class="eg-tooltip-wrap" title="<?php _e('Border Line Style', EG_TEXTDOMAIN); ?>" style="float:left"><?php _e('Border Style', EG_TEXTDOMAIN); ?></label>
										<div class="select_wrapper" style="float:left;">
											<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
											<select name="content-border-style">
												<option value="none" <?php selected($base->getVar($skin['params'], 'content-border-style', 'none'), 'none'); ?>><?php _e('none', EG_TEXTDOMAIN); ?></option>
												<option value="solid" <?php selected($base->getVar($skin['params'], 'content-border-style', 'none'), 'solid'); ?>><?php _e('solid', EG_TEXTDOMAIN); ?></option>
												<option value="dotted" <?php selected($base->getVar($skin['params'], 'content-border-style', 'none'), 'dotted'); ?>><?php _e('dotted', EG_TEXTDOMAIN); ?></option>
												<option value="dashed" <?php selected($base->getVar($skin['params'], 'content-border-style', 'none'), 'dashed'); ?>><?php _e('dashed', EG_TEXTDOMAIN); ?></option>
												<option value="double" <?php selected($base->getVar($skin['params'], 'content-border-style', 'none'), 'double'); ?>><?php _e('double', EG_TEXTDOMAIN); ?></option>
											</select>
										</div>
										<div class="clear"></div>
									</div>
								</div>
							</div>

							<!-- THE CONTENT SHADOW SETTINGS -->
							<div id="eg-lc-content-shadow" class="esg-lc-settings-container ">
								<div style="margin-top:15px">
									<label class="eg-tooltip-wrap" title="<?php _e('Drop Shadow of Element(s)', EG_TEXTDOMAIN); ?>" style="float:left"><?php _e('Use Shadow', EG_TEXTDOMAIN); ?></label>
									<div class="select_wrapper" style="float:left;">
										<?php
										$shadow_type = $base->getVar($skin['params'], 'all-shadow-used', 'none');
										?>
										<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
										<select name="all-shadow-used">
											<option<?php selected($shadow_type, 'none'); ?> value="none"><?php _e('none', EG_TEXTDOMAIN); ?></option>
											<option<?php selected($shadow_type, 'media'); ?> value="media"><?php _e('media', EG_TEXTDOMAIN); ?></option>
											<option<?php selected($shadow_type, 'content'); ?> value="content"><?php _e('content', EG_TEXTDOMAIN); ?></option>
											<option<?php selected($shadow_type, 'both'); ?> value="both"><?php _e('both', EG_TEXTDOMAIN); ?></option>
										</select>
									</div>
									<div class="clear"></div>
								</div>
								<p>
									<label><?php _e('Shadow Color', EG_TEXTDOMAIN); ?></label>
									<input class="element-setting" name="content-shadow-color" type="text" id="content-shadow-color" value="<?php echo $base->getVar($skin['params'], 'content-shadow-color', '#000000'); ?>" data-default-color="#000000">
								</p>
								<p>
									<label class="eg-tooltip-wrap" title="<?php _e('Shadow Opacity', EG_TEXTDOMAIN); ?>"><?php _e('Shadow Alpha', EG_TEXTDOMAIN); ?></label>
									<span id="content-shadow-alpha" class="slider-settings eg-tooltip-wrap" title="<?php _e('Shadow Opacity', EG_TEXTDOMAIN); ?>"></span>
									<input class="input-settings-small element-setting" type="text" name="content-shadow-alpha" value="<?php echo $base->getVar($skin['params'], 'content-shadow-alpha', '100', 'i'); ?>" />
								</p>
								<p>
									<?php
									$shadow = $base->getVar($skin['params'], 'content-box-shadow');
									?>
									<label class="eg-tooltip-wrap" title="<?php _e('Position of horizontal shadow(Negative values possible)', EG_TEXTDOMAIN); ?>, <?php _e('blur distance', EG_TEXTDOMAIN); ?>, <?php _e('size of shadow', EG_TEXTDOMAIN); ?>"><?php _e('Shadow', EG_TEXTDOMAIN); ?></label>
									<input class="input-settings-small element-setting firstinput" type="text" name="content-box-shadow[]" value="<?php echo (isset($shadow[0])) ? $shadow[0] : 0; ?>" />
									<input class="input-settings-small element-setting" type="text" name="content-box-shadow[]" value="<?php echo (isset($shadow[1])) ? $shadow[1] : 0; ?>" />
									<input class="input-settings-small element-setting" type="text" name="content-box-shadow[]" value="<?php echo (isset($shadow[2])) ? $shadow[2] : 0; ?>" />
									<input class="input-settings-small element-setting" type="text" name="content-box-shadow[]" value="<?php echo (isset($shadow[3])) ? $shadow[3] : 0; ?>" /> px
								</p>

								<p><div style="position:absolute;bottom:10px;text-align:center"><i style="font-size:10px;color:#777"><?php _e('The Container under or over the Media Container.', EG_TEXTDOMAIN); ?></i></div></p>
							</div>

							<!-- THE CONTENT ANIMATION SETTINGS -->
							<div id="eg-lc-content-animation" class="esg-lc-settings-container ">
								<!-- COVER ANIMATION -->
								<div  style="margin-top:15px">
									<label style="float:left; width:150px" class="eg-cover-setter"><?php _e('Cover Animation', EG_TEXTDOMAIN); ?></label>
									<div style="float:left">

										<div id="eg-cover-animation-top">
											<span style="padding-right:23px; margin-right:10px;float:left;" class="eg-tooltip-wrap" title="<?php _e('Show or Hide on hover. In = Show on Hover, Out = Hide on hover', EG_TEXTDOMAIN); ?>"><?php _e('Top', EG_TEXTDOMAIN); ?></span>
											<div class="select_wrapper" style="float:right;">
												<div class="select_fake" style="width: 40px;overflow: hidden;white-space: nowrap;"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
												<select name="cover-animation-top-type" style="width: 70px;">
													<option value="" <?php selected($base->getVar($skin['params'], 'cover-animation-top-type', ''), ''); ?>><?php echo _e('in', EG_TEXTDOMAIN); ?></option>
													<option value="out" <?php selected($base->getVar($skin['params'], 'cover-animation-top-type', ''), 'out'); ?>><?php echo _e('out', EG_TEXTDOMAIN); ?></option>
												</select>
												<span id="cover-animation-delay-top" class="slider-settings eg-slider-small eg-tooltip-wrap" title="<?php _e('Delay before the Animation starts', EG_TEXTDOMAIN); ?>"></span>
												<input class="input-settings-small element-setting" type="text" name="cover-animation-delay-top" value="<?php echo $base->getVar($skin['params'], 'cover-animation-delay-top', '0', 'i'); ?>" />
											</div>
											<div class="select_wrapper" style="float:right;" class="eg-tooltip-wrap" title="<?php _e('Animation Effect on Cover', EG_TEXTDOMAIN); ?>">
												<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
												<select name="cover-animation-top">
													<?php
													foreach($transitions_cover as $handle => $name){
														?>
														<option value="<?php echo $handle; ?>" <?php selected($base->getVar($skin['params'], 'cover-animation-top', 'fade'), $handle); ?>><?php echo $name; ?></option>
														<?php
													}
													?>
												</select>
											</div>
										</div>
										<div style="clear:both"></div>
										<div id="eg-cover-animation-center">
											<span id="eg-cover-animation-center-hide" style="float:left;" class="eg-tooltip-wrap" title="<?php _e('Show or Hide on hover. In = Show on Hover, Out = Hide on hover', EG_TEXTDOMAIN); ?>"><?php _e('Center', EG_TEXTDOMAIN); ?></span>
											<div class="select_wrapper" style="float:right;">
												<div class="select_fake" style="width: 40px;overflow: hidden;white-space: nowrap;"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
												<select name="cover-animation-center-type" style="width: 70px;">
													<option value="" <?php selected($base->getVar($skin['params'], 'cover-animation-center-type', ''), ''); ?>><?php echo _e('in', EG_TEXTDOMAIN); ?></option>
													<option value="out" <?php selected($base->getVar($skin['params'], 'cover-animation-center-type', ''), 'out'); ?>><?php echo _e('out', EG_TEXTDOMAIN); ?></option>
												</select>
												<span id="cover-animation-delay-center" class="slider-settings eg-slider-small eg-tooltip-wrap" title="<?php _e('Delay before the Animation starts', EG_TEXTDOMAIN); ?>"></span>
												<input class="input-settings-small element-setting" type="text" name="cover-animation-delay-center" value="<?php echo $base->getVar($skin['params'], 'cover-animation-delay-center', '0', 'i'); ?>" />
											</div>
											<div class="select_wrapper" style="float:right;" class="eg-tooltip-wrap" title="<?php _e('Animation Effect on Cover', EG_TEXTDOMAIN); ?>">
												<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
												<select name="cover-animation-center">
													<?php
													foreach($transitions_cover as $handle => $name){
													?>
													<option value="<?php echo $handle; ?>" <?php selected($base->getVar($skin['params'], 'cover-animation-center', 'fade'), $handle); ?>><?php echo $name; ?></option>
													<?php
													}
													?>
												</select>
											</div>
										</div>
										<div style="clear:both"></div>
										<div id="eg-cover-animation-bottom">
											<span style="margin-right:10px;float:left" class="eg-tooltip-wrap" title="<?php _e('Show or Hide on hover. In = Show on Hover, Out = Hide on hover', EG_TEXTDOMAIN); ?>"><?php _e('Bottom', EG_TEXTDOMAIN); ?></span>
											<div class="select_wrapper" style="float:right;">
												<div class="select_fake" style="width: 40px;overflow: hidden;white-space: nowrap;"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
												<select name="cover-animation-bottom-type" style="width: 70px;">
													<option value="" <?php selected($base->getVar($skin['params'], 'cover-animation-bottom-type', ''), ''); ?>><?php echo _e('in', EG_TEXTDOMAIN); ?></option>
													<option value="out" <?php selected($base->getVar($skin['params'], 'cover-animation-bottom-type', ''), 'out'); ?>><?php echo _e('out', EG_TEXTDOMAIN); ?></option>
												</select>
												<span id="cover-animation-delay-bottom" class="slider-settings eg-slider-small eg-tooltip-wrap" title="<?php _e('Delay before the Animation starts', EG_TEXTDOMAIN); ?>"></span>
												<input class="input-settings-small element-setting" type="text" name="cover-animation-delay-bottom" value="<?php echo $base->getVar($skin['params'], 'cover-animation-delay-bottom', '0', 'i'); ?>" />
											</div>
											<div class="select_wrapper" style="float:right;" class="eg-tooltip-wrap" title="<?php _e('Animation Effect on Cover', EG_TEXTDOMAIN); ?>">
												<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
												<select name="cover-animation-bottom">
													<?php
													foreach($transitions_cover as $handle => $name){
													?>
													<option value="<?php echo $handle; ?>" <?php selected($base->getVar($skin['params'], 'cover-animation-bottom', 'fade'), $handle); ?>><?php echo $name; ?></option>
													<?php
													}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="clear"></div>
								</div>
								<!-- GROUP ANIMATION -->
								<div style="margin-top:15px">
									<label style="float:left; width:150px" class="eg-group-setter eg-tooltip-wrap" title="<?php _e('Animation Effect on Cover and on All Cover elements Grouped. This will not replace the Animation but add a global animation extra.', EG_TEXTDOMAIN); ?>"><?php _e('Group Animation', EG_TEXTDOMAIN); ?></label>
									<div class="select_wrapper" style="float:left;">
										<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
										<select name="cover-group-animation">
											<?php
											foreach($transitions_cover as $handle => $name){
											?>
											<option value="<?php echo $handle; ?>" <?php selected($base->getVar($skin['params'], 'cover-group-animation', 'none'), $handle); ?>><?php echo $name; ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<div class="clear"></div>
								<!-- MEDIA ANIMATION -->
								<div style="margin-top:15px">
									<label style="float:left; width:150px;" class="eg-tooltip-wrap" title="<?php _e('Animation of Media on Hover. All Media animation hide, or partly hide the Media on hover.', EG_TEXTDOMAIN); ?>"><?php _e('Media Animation', EG_TEXTDOMAIN); ?></label>
									<div class="select_wrapper" style="float:left;">
										<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
										<select name="media-animation">
											<?php
											foreach($transitions_media as $handle => $name){
												?>
												<option value="<?php echo $handle; ?>" <?php selected($base->getVar($skin['params'], 'media-animation', 'fade'), $handle); ?>><?php echo $name; ?></option>
												<?php
											}
											?>
										</select>
										<span id="media-animation-delay" class="slider-settings eg-slider-small eg-tooltip-wrap" title="<?php _e('Delay before the Animation starts', EG_TEXTDOMAIN); ?>"></span>
										<input class="input-settings-small element-setting" type="text" name="media-animation-delay" value="<?php echo $base->getVar($skin['params'], 'media-animation-delay', '0', 'i'); ?>" />
									</div>
									<div class="clear"></div>
								</div>
							</div>

							<!-- GENERAL LINK/SEO SETTINGS -->
							<div id="eg-lc-content-link-seo" class="esg-lc-settings-container">
								<div style="margin-top:15px">
									<label style="float:left; width:150px;" class="eg-tooltip-wrap" title="<?php _e('Choose where the following link should be appended to.', EG_TEXTDOMAIN); ?>"><?php _e('Add Link To', EG_TEXTDOMAIN); ?></label>
									<div class="select_wrapper" style="float:left;">
										<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
										<?php $link_set_to = $base->getVar($skin['params'], 'link-set-to', 'none'); ?>
										<select name="link-set-to">
											<option value="none" <?php selected($link_set_to, 'none'); ?>><?php _e('None', EG_TEXTDOMAIN); ?></option>
											<option value="media" <?php selected($link_set_to, 'media'); ?>><?php _e('Media', EG_TEXTDOMAIN); ?></option>
											<option value="cover" <?php selected($link_set_to, 'cover'); ?>><?php _e('Cover', EG_TEXTDOMAIN); ?></option>
										</select>
									</div>
									<div class="clear"></div>
									<div class="add-link-to-wrapper" style="display: none;">
										<div style="margin-top:15px">
											<label style="float:left"><?php _e('Link To', EG_TEXTDOMAIN); ?></label>
											<div class="select_wrapper" style="float:left;">
												<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
												<?php $link_link_type = $base->getVar($skin['params'], 'link-link-type', 'none'); ?>
												<select name="link-link-type">
													<option <?php selected($link_link_type, 'none'); ?> value="none"><?php _e('None', EG_TEXTDOMAIN); ?></option>
													<option <?php selected($link_link_type, 'post'); ?> value="post"><?php _e('Post', EG_TEXTDOMAIN); ?></option>
													<option <?php selected($link_link_type, 'url'); ?> value="url"><?php _e('URL', EG_TEXTDOMAIN); ?></option>
													<option <?php selected($link_link_type, 'meta'); ?> value="meta"><?php _e('Meta', EG_TEXTDOMAIN); ?></option>
													<option <?php selected($link_link_type, 'javascript'); ?> value="javascript"><?php _e('JavaScript', EG_TEXTDOMAIN); ?></option>
													<option <?php selected($link_link_type, 'lightbox'); ?> value="lightbox"><?php _e('Lightbox', EG_TEXTDOMAIN); ?></option>
													<option <?php selected($link_link_type, 'ajax'); ?> value="ajax"><?php _e('Ajax', EG_TEXTDOMAIN); ?></option>
												</select>
											</div><div class="clear"></div>
										</div>
										<p id="eg-link-post-url-wrap" style="display: none;">
											<label><?php _e('Link To URL', EG_TEXTDOMAIN); ?></label>
											<input class="element-setting" type="text" name="link-url-link" value="<?php echo $base->getVar($skin['params'], 'link-url-link', ''); ?>" />
										</p>
										<p id="eg-link-post-meta-wrap" style="display: none;">
											<label><?php _e('Meta Key', EG_TEXTDOMAIN); ?></label>
											<input class="element-setting" type="text" name="link-meta-link" value="<?php echo $base->getVar($skin['params'], 'link-meta-link', ''); ?>" />
											<a class="button-secondary" id="button-open-link-link-meta-key" href="javascript:void(0);"><i class="eg-icon-down-open"></i></a>
										</p>
										<p id="eg-link-post-javascript-wrap" style="display: none;">
											<label><?php _e('Link JavaScript', EG_TEXTDOMAIN); ?></label>
											<input class="element-setting" type="text" name="link-javascript-link" value="<?php echo $base->getVar($skin['params'], 'link-javascript-link', ''); ?>" />
										</p>
										<div style="margin-top:10px">
											<label style="float:left"><?php _e('Link Target', EG_TEXTDOMAIN); ?></label>
											<div class="select_wrapper" style="float:left;">
												<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
												<?php $link_target = $base->getVar($skin['params'], 'link-target', '_self'); ?>
												<select name="link-target">
													<option <?php selected($link_target, 'disabled'); ?> value="disabled"><?php _e('disabled', EG_TEXTDOMAIN); ?></option>
													<option <?php selected($link_target, '_self'); ?> value="_self"><?php _e('_self', EG_TEXTDOMAIN); ?></option>
													<option <?php selected($link_target, '_blank'); ?> value="_blank"><?php _e('_blank', EG_TEXTDOMAIN); ?></option>
													<option <?php selected($link_target, '_parent'); ?> value="_parent"><?php _e('_parent', EG_TEXTDOMAIN); ?></option>
													<option <?php selected($link_target, '_top'); ?> value="_top"><?php _e('_top', EG_TEXTDOMAIN); ?></option>
												</select>
											</div><div class="clear"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>

			<!--
			ELEMENT EDITOR
			-->
			<div class="postbox eg-postbox " style="" id="eg-layersettings-box-wrapper">
				<h3 style="padding:12px;" id="layer-settings-header" class="box-closed">
					<span class="eg-element-setter eg-tor-250"><span id="eg-ls-smalllsicon" style="padding:0px"><i style="background-color:#8e44ad; padding:3px; margin-right:10px;border-radius:50%;-moz-border-radius:50%;-webkit-border-radius:50%;color:#fff;"  class="eg-icon-star"></i></span>
					<?php _e('Layer Settings - ', EG_TEXTDOMAIN); ?></span>
					<div class="postbox-arrow"></div>
					<div class="clear"></div>
				</h3>
				<h3 style="background:none; cursor:default !important; position:absolute;height:23px;width:100%; max-width:370px;left:165px;top:5px;border:none !important; overflow:hidden;" >

					<div class="select_wrapper" style="float:left;margin-left:5px;">
						<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
						<select id="element-settings-current-name"></select>
					</div>
					<span style="font-size:10px;font-weight:600;cursor:text;-webkit-touch-callout: all;-webkit-user-select: all;-khtml-user-select: all;-moz-user-select: all;-ms-user-select: all;user-select: all;" class="eg-element-class-setter"></span>
				</h3>
				<div class="inside" style="padding:0px;margin:0px;height:100%;display:none">
					<div id="element-setting-wrap-top" style="display:none">
						<form id="eg-item-element-settings-wrap">
							<div id="settings-dz-elements-wrapper" class="eg-ul-tabs">
								<ul>
									<li class="selected-el-setting eg-source-li"><a href="#eg-element-source"><i class="eg-icon-folder-open-empty" style="margin-right:5px;"></i><?php _e('Source', EG_TEXTDOMAIN); ?></a></li>
									<li class="eg-hide-on-special eg-hide-on-blank-element"><a href="#eg-element-style"><i class="eg-icon-droplet" style="margin-right:5px;"></i><?php _e('Style', EG_TEXTDOMAIN); ?></a></li>
									<li><a href="#eg-element-hide"><i class="eg-icon-tablet" style="margin-right:5px;"></i><?php _e('Show/Hide', EG_TEXTDOMAIN); ?></a></li>
									<li><a href="#eg-element-animation"><i class="eg-icon-gamepad" style="margin-right:5px;"></i><?php _e('Animation', EG_TEXTDOMAIN); ?></a></li>
									<li class="eg-hide-on-special eg-hide-on-blank-element"><a href="#eg-element-link"><i class="eg-icon-link" style="margin-right:5px;"></i><?php _e('Link/SEO', EG_TEXTDOMAIN); ?></a></li>
								</ul>
								<!--
								SOURCE
								-->
								<div id="eg-element-source">
									<div id="dz-source">
										<div style="margin-top:10px" class="eg-hide-on-special eg-hide-on-blank-element">
											<label style="float:left" class="eg-tooltip-wrap" title="<?php _e('Select The Source of this Element', EG_TEXTDOMAIN); ?>"><?php _e('Source', EG_TEXTDOMAIN); ?></label>
											<div class="select_wrapper" style="float:left;">
												<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
												<select name="element-source" style="width:180px">
													<?php
													foreach($element_type as $el_cat => $el_type){
													?>
													<option value="<?php echo $el_cat; ?>"><?php echo ucwords($el_cat); ?></option>
													<?php
													}
													?>
													<option value="icon"><?php _e('Icon', EG_TEXTDOMAIN); ?></option>
													<option value="text"><?php _e('Text/HTML', EG_TEXTDOMAIN); ?></option>
												</select>
											</div>
											<div class="clear"></div>
										</div>

										<div style="margin-top:10px">
											<div id="eg-source-element-drops" class="eg-hide-on-special eg-hide-on-blank-element">
												<!-- DROP DOWNS FOR ELEMENTS -->
												<label style="float:left"><?php _e('Element', EG_TEXTDOMAIN); ?></label>
													<?php
													foreach($element_type as $el_cat => $el_type){
														?>
														<div class="select_wrapper eg-tooltip-wrap" title="<?php _e('Narrow down your selection', EG_TEXTDOMAIN); ?>" style="float:left;">
															<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
															<select name="element-source-<?php echo $el_cat; ?>" style="width:180px" class="elements-select-wrap">
																<?php
																foreach($el_type as $ty_name => $ty_values){
																	?><option value="<?php echo $ty_name; ?>"><?php echo $ty_values['name']; ?></option><?php
																}
																?>
															</select>
														</div>
														<?php
													}
													?>
												<div class="clear"></div>

												<!-- CAT & TAG SEPERATOR -->
												<div id="eg-source-seperate-wrap" style="margin-top:10px;line-height:25px">
													<label style="float: left" class="eg-tooltip-wrap" title="<?php _e('Separator Char in the Listed element', EG_TEXTDOMAIN); ?>"><?php _e('Separate By', EG_TEXTDOMAIN); ?></label>
													<input type="text" value="" name="element-source-separate" class="input-settings-small element-setting firstinput">
													<div class="clear"></div>
												</div>

												<!-- CAT & TAG CHOOSE TYPE -->
												<div id="eg-source-functonality-wrap" style="margin-top:10px;line-height:25px">
													<label style="float: left" class="eg-tooltip-wrap" title="<?php _e('Narrow down your selection', EG_TEXTDOMAIN); ?>"><?php _e('On Click', EG_TEXTDOMAIN); ?></label>
													<div class="select_wrapper" style="float:left;">
														<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
														<select name="element-source-function" style="width:180px" class="elements-select-wrap">
															<option value="none"><?php _e('None', EG_TEXTDOMAIN); ?></option>
															<option value="link"><?php _e('Link To Post', EG_TEXTDOMAIN); ?></option>
															<option value="filter"><?php _e('Trigger Filter', EG_TEXTDOMAIN); ?></option>
														</select>
													</div>
													<div class="clear"></div>
												</div>

												<!-- META TAG -->
												<div id="eg-source-meta-wrap" style="margin-top:10px;line-height:25px">
													<label class="eg-tooltip-wrap" title="<?php _e('The Handle or ID of Meta Key', EG_TEXTDOMAIN); ?>" style="float: left"><?php _e('Meta Key', EG_TEXTDOMAIN); ?></label>
													<input type="text" value="" name="element-source-meta" class="input-settings element-setting firstinput">
													<a href="javascript:void(0);" id="button-open-meta-key" class="button-secondary"><i class="eg-icon-down-open"></i></a>
													<div class="clear"></div>
												</div>

												<!-- WORD LIMITATION -->
												<div id="eg-source-limit-wrap" style="margin-top:10px;line-height:25px">
													<label style="float: left"><?php _e('Limit By', EG_TEXTDOMAIN); ?></label>

													<div class="select_wrapper" style="float:left;">
														<div class="select_fake"><span class="eg-tooltip-wrap" title="<?php _e('Text Length Limitation calculated based on...', EG_TEXTDOMAIN); ?>"><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>

														<select name="element-limit-type">
															<option value="none"><?php _e('None', EG_TEXTDOMAIN); ?></option>
															<option value="words"><?php _e('Words', EG_TEXTDOMAIN); ?></option>
															<option value="chars"><?php _e('Characters', EG_TEXTDOMAIN); ?></option>
														</select>
													</div>

													<input style="float:left; margin-left:10px;" type="text" value="" name="element-limit-num" class="input-settings-small element-setting firstinput">

													<div class="clear"></div>
												</div>
											</div>

											<!-- ICON SELECTOR -->
											<div id="eg-source-icon-wrap" class="elements-select-wrap" style="margin-left:150px; width:100%;">
												<div id="show-fontello-dialog">
													<div id="eg-preview-icon"></div>
												</div>
												<div style="float:left; margin-left:10px; margin-top:15px;font-size:11px;font-style:italic;color:#777;"><?php _e('Click on the Field to change the Icon', EG_TEXTDOMAIN); ?></div>

												<input type="hidden" value="" name="element-source-icon" />
											</div>

											<!-- HTML TEXT SOURCE -->
											<div id="eg-source-text-style-disable-wrap" class="elements-select-wrap eg-hide-on-special eg-hide-on-blank-element">
												<label class="eg-tooltip-wrap" title="<?php _e('Stylings will not be written', EG_TEXTDOMAIN); ?>" style="float: left"><?php _e('Disable Styling', EG_TEXTDOMAIN); ?></label>
												<div style="float: left; margin-top: 5px;"><input type="checkbox"  name="element-source-text-style-disable" value="on" class="input-settings element-setting firstinput"></div>
											</div>

											<div style="clear: both;"></div>

											<div id="eg-source-text-wrap" class="elements-select-wrap" style="margin-left:150px;">
												<textarea name="element-source-text" style="width:350px;height:150px"></textarea>
												<div style="font-size:10px;color:#777"><?php _e('Use %meta-key-handle% to insert meta data. Most can be found ', EG_TEXTDOMAIN); ?><a href="javascript:void(0);" id="eg-show-meta-keys-dialog"><?php _e('here', EG_TEXTDOMAIN); ?> </a></div>
											</div>

										</div>
									</div>
								</div>

								<!--
								STYLING
								-->
								<div id="eg-element-style" style="position:relative">
									<div id="eg-styling-idle-hover-tab" class="eg-ul-tabs">
										<ul class="eg-submenu">
											<li class="selected-submenu-setting eg-tooltip-wrap" title="<?php _e('Style of Element in Idle State', EG_TEXTDOMAIN); ?>" data-toshow="eg-style-idle"><i class="eg-icon-star-empty"></i><?php _e('Idle', EG_TEXTDOMAIN); ?></li>
											<li class="eg-tooltip-wrap" title="<?php _e('Style of Element in Hover state (only if Hover Box Checked)', EG_TEXTDOMAIN); ?>" data-toshow="eg-style-hover"><i class="eg-icon-star"></i><?php _e('Hover', EG_TEXTDOMAIN); ?> <input style="margin-left:5px" type="checkbox" name="element-enable-hover" /></li>
											<div class="clear"></div>
										</ul>
										<div class="clear"></div>
										<!-- IDLE STYLING -->
										<div id="eg-style-idle">
											<div class="eg-small-vertical-menu">
												<ul>
													<li class="selected-el-setting" data-toshow="eg-el-font"><i class="eg-icon-font" ></i><p><?php _e('Style', EG_TEXTDOMAIN); ?></p></li>
													<li class="" data-toshow="eg-el-pos"><i class="eg-icon-align-left"></i><p><?php _e('Spacing', EG_TEXTDOMAIN); ?></p></li>
													<li class="" data-toshow="eg-el-border"><i class="eg-icon-minus-squared-alt"></i><p><?php _e('Border', EG_TEXTDOMAIN); ?></p></li>
													<li class="" data-toshow="eg-el-bg"><i class="eg-icon-picture-1"></i><p><?php _e('BG', EG_TEXTDOMAIN); ?></p></li>
													<li class="" data-toshow="eg-el-shadow"><i class="eg-icon-picture"></i><p><?php _e('Shadow', EG_TEXTDOMAIN); ?></p></li>
												</ul>
											</div>
											<!--
											FONT
											-->
											<div id="eg-el-font" class="esg-el-settings-container active-esc">
												<p>
													<label><?php _e('Font Size', EG_TEXTDOMAIN); ?></label>
													<span id="element-font-size" class="slider-settings"></span>
													<input class="input-settings-small element-setting" type="text" name="element-font-size" value="6" /> px
												</p>
												<p>
													<label><?php _e('Line Height', EG_TEXTDOMAIN); ?></label>
													<span id="element-line-height" class="slider-settings"></span>
													<input class="input-settings-small element-setting" type="text" name="element-line-height" value="8" /> px
												</p>
												<p>
													<label><?php _e('Font Color', EG_TEXTDOMAIN); ?></label>
													<input class="element-setting" name="element-color" type="text" id="element-color" value="" data-default-color="#000">
												</p>
												<p>
													<label><?php _e('Font Family', EG_TEXTDOMAIN); ?></label>
													<input class="element-setting" name="element-font-family" type="text" value=""> <a class="button-secondary" id="button-open-font-family" href="javascript:void(0);"><i class="eg-icon-down-open"></i></a>
												</p>
												<div style="margin-top:10px">
													<label style="float:left"><?php _e('Font Weight', EG_TEXTDOMAIN); ?></label>
													<div class="select_wrapper" style="float:left;">

														<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
														<select name="element-font-weight">
															<option value="400"><?php _e('400', EG_TEXTDOMAIN); ?></option>
															<option value="100"><?php _e('100', EG_TEXTDOMAIN); ?></option>
															<option value="200"><?php _e('200', EG_TEXTDOMAIN); ?></option>
															<option value="300"><?php _e('300', EG_TEXTDOMAIN); ?></option>
															<option value="500"><?php _e('500', EG_TEXTDOMAIN); ?></option>
															<option value="600"><?php _e('600', EG_TEXTDOMAIN); ?></option>
															<option value="700"><?php _e('700', EG_TEXTDOMAIN); ?></option>
															<option value="800"><?php _e('800', EG_TEXTDOMAIN); ?></option>
															<option value="900"><?php _e('900', EG_TEXTDOMAIN); ?></option>
														</select>
													</div><div class="clear"></div>
												</div>
												<div style="margin-top:10px">
													<label style="float:left"><?php _e('Text Decoration', EG_TEXTDOMAIN); ?></label>
													<div class="select_wrapper" style="float:left;">
														<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
														<select name="element-text-decoration">
															<option value="none"><?php _e('None', EG_TEXTDOMAIN); ?></option>
															<option value="underline"><?php _e('Underline', EG_TEXTDOMAIN); ?></option>
															<option value="overline"><?php _e('Overline', EG_TEXTDOMAIN); ?></option>
															<option value="line-through"><?php _e('Line Through', EG_TEXTDOMAIN); ?></option>
														</select>
													</div><div class="clear"></div>
												</div>
												<p>
													<label><?php _e('Font Style', EG_TEXTDOMAIN); ?></label>
													<input type="checkbox" name="element-font-style" value="italic" /> <?php _e('Italic', EG_TEXTDOMAIN); ?>
												</p>
												<div style="margin-top:10px">
													<label style="float:left"><?php _e('Text Transform', EG_TEXTDOMAIN); ?></label>
													<div class="select_wrapper" style="float:left;">
														<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
														<select name="element-text-transform">
															<option value="none"><?php _e('None', EG_TEXTDOMAIN); ?></option>
															<option value="capitalize"><?php _e('Capitalize', EG_TEXTDOMAIN); ?></option>
															<option value="uppercase"><?php _e('Uppercase', EG_TEXTDOMAIN); ?></option>
															<option value="lowercase"><?php _e('Lowercase', EG_TEXTDOMAIN); ?></option>
														</select>
													</div><div class="clear"></div>
												</div>
												<div class="drop-to-stylechange eg-tooltip-wrap" title="<?php _e('Drop Element from Available Layers here to overwrite Styling of Current Element', EG_TEXTDOMAIN); ?>"><?php _e("Drop for<br>Style<br>Change", EG_TEXTDOMAIN); ?></div>
											</div>

											<!--
											POSITION
											-->
											<div id="eg-el-pos" class="esg-el-settings-container">
												<div style="margin-top:10px">
													<label style="float:left"><?php _e('Position', EG_TEXTDOMAIN); ?></label>
													<div class="select_wrapper" style="float:left;">
														<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
														<select name="element-position">
															<option value="relative"><?php _e('Relative', EG_TEXTDOMAIN); ?></option>
															<option value="absolute"><?php _e('Absolute', EG_TEXTDOMAIN); ?></option>
														</select>
													</div><div class="clear"></div>
												</div>
												<div id="eg-show-on-absolute">
													<div style="margin-top:10px">
														<label style="float:left"><?php _e('Align', EG_TEXTDOMAIN); ?></label>
														<div class="select_wrapper" style="float:left;">
															<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
															<select name="element-align">
																<option value="t_l"><?php _e('Top/Left', EG_TEXTDOMAIN); ?></option>
																<option value="t_r"><?php _e('Top/Right', EG_TEXTDOMAIN); ?></option>
																<option value="b_l"><?php _e('Bottom/Left', EG_TEXTDOMAIN); ?></option>
																<option value="b_r"><?php _e('Bottom/Right', EG_TEXTDOMAIN); ?></option>
															</select>
														</div>
														<div class="select_wrapper" style="float:left; width:40px;margin-left:15px;">
															<div class="select_fake" style="width: 40px;overflow: hidden;white-space: nowrap;"><span>px</span><i class="eg-icon-sort"></i></div>
															<select name="element-absolute-unit">
																<option value="px">px</option>
																<option value="%">%</option>
															</select>
														</div><div class="clear"></div>
													</div>
													<div style="margin-top:10px">
														<label style="float:left">&nbsp;</label>
														<span id="eg-t_b_align"><?php _e('Top', EG_TEXTDOMAIN); ?></span> <input class="input-settings-small element-setting" type="text" name="element-top-bottom" value="0" />
														<span id="eg-l_r_align"><?php _e('Left', EG_TEXTDOMAIN); ?></span> <input class="input-settings-small element-setting" type="text" name="element-left-right" value="0" />
														<div class="clear"></div>
													</div>
													<!--div style="margin-top:10px">
														<label style="float:left"><?php _e('Bottom', EG_TEXTDOMAIN); ?></label>
														<input style="float:left" class="input-settings-small element-setting firstinput" type="text" name="element-bottom" value="0" />
														<div class="select_wrapper" style="float:left; width:40px;margin-left:15px;">
															<div class="select_fake" style="width: 40px;overflow: hidden;white-space: nowrap;"><span>px</span><i class="eg-icon-sort"></i></div>
															<select name="element-bottom-unit">
																<option value="px">px</option>
																<option value="%">%</option>
															</select>
														</div><div class="clear"></div>
													</div>
													<div style="margin-top:10px">
														<label style="float:left"><?php _e('Left', EG_TEXTDOMAIN); ?></label>
														<input style="float:left" class="input-settings-small element-setting firstinput" type="text" name="element-left" value="0" />
														<div class="select_wrapper" style="float:left; width:40px;margin-left:15px;">
															<div class="select_fake" style="width: 40px;overflow: hidden;white-space: nowrap;"><span>px</span><i class="eg-icon-sort"></i></div>
															<select name="element-left-unit">
																<option value="px">px</option>
																<option value="%">%</option>
															</select>
														</div><div class="clear"></div>
													</div-->
												</div>
												<div id="eg-show-on-relative">

													<div style="margin-top:10px">
														<label style="float:left"><?php _e('Display', EG_TEXTDOMAIN); ?></label>
														<div class="select_wrapper" style="float:left;">
															<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
															<select name="element-display">
																<option value="block"><?php _e('block', EG_TEXTDOMAIN); ?></option>
																<option value="inline-block"><?php _e('inline-block', EG_TEXTDOMAIN); ?></option>
															</select>
														</div><div class="clear"></div>
													</div>

													<div style="margin-top:10px" id="element-text-align-wrap">
														<label style="float:left"><?php _e('Text Align', EG_TEXTDOMAIN); ?></label>
														<div class="select_wrapper" style="float:left;">
															<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
															<select name="element-text-align">
																<option value="center"><?php _e('center', EG_TEXTDOMAIN); ?></option>
																<option value="left"><?php _e('left', EG_TEXTDOMAIN); ?></option>
																<option value="right"><?php _e('right', EG_TEXTDOMAIN); ?></option>
															</select>
														</div><div class="clear"></div>
													</div>

													<div style="margin-top:10px" id="element-float-wrap">
														<label style="float:left"><?php _e('Float Element', EG_TEXTDOMAIN); ?></label>
														<div class="select_wrapper" style="float:left;">
															<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
															<select name="element-float">
																<option value="none"><?php _e('none', EG_TEXTDOMAIN); ?></option>
																<option value="left"><?php _e('left', EG_TEXTDOMAIN); ?></option>
																<option value="right"><?php _e('right', EG_TEXTDOMAIN); ?></option>
															</select>
														</div><div class="clear"></div>
													</div>

													<div style="margin-top:10px">
														<label style="float:left"><?php _e('Clear', EG_TEXTDOMAIN); ?></label>
														<div class="select_wrapper" style="float:left;">
															<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
															<select name="element-clear">
																<option value="none"><?php _e('none', EG_TEXTDOMAIN); ?></option>
																<option value="left"><?php _e('left', EG_TEXTDOMAIN); ?></option>
																<option value="right"><?php _e('right', EG_TEXTDOMAIN); ?></option>
																<option value="both"><?php _e('both', EG_TEXTDOMAIN); ?></option>
															</select>
														</div><div class="clear"></div>
													</div>
												</div>
												<p>
													<label class="eg-tooltip-wrap" title="<?php _e('Top', EG_TEXTDOMAIN); ?>, <?php _e('Right', EG_TEXTDOMAIN); ?>, <?php _e('Bottom', EG_TEXTDOMAIN); ?>, <?php _e('Left', EG_TEXTDOMAIN); ?>"><?php _e('Margin', EG_TEXTDOMAIN); ?></label>
													<input class="input-settings-small element-setting firstinput" type="text" name="element-margin[]" value="0" />
													<input class="input-settings-small element-setting" type="text" name="element-margin[]" value="0" />
													<input class="input-settings-small element-setting" type="text" name="element-margin[]" value="0" />
													<input class="input-settings-small element-setting" type="text" name="element-margin[]" value="0" /> px
												</p>
												<p>
													<label class="eg-tooltip-wrap" title="<?php _e('Top', EG_TEXTDOMAIN); ?>, <?php _e('Right', EG_TEXTDOMAIN); ?>, <?php _e('Bottom', EG_TEXTDOMAIN); ?>, <?php _e('Left', EG_TEXTDOMAIN); ?>"><?php _e('Paddings', EG_TEXTDOMAIN); ?></label>
													<input class="input-settings-small element-setting firstinput" type="text" name="element-padding[]" value="0" />
													<input class="input-settings-small element-setting" type="text" name="element-padding[]" value="0" />
													<input class="input-settings-small element-setting" type="text" name="element-padding[]" value="0" />
													<input class="input-settings-small element-setting" type="text" name="element-padding[]" value="0" /> px
												</p>
												<!-- <p>
													<label><?php _e('Height', EG_TEXTDOMAIN); ?></label>
													<span id="element-height" class="slider-settings"></span>
													<input class="input-settings-small element-setting" type="text" name="element-height" value="0" /> px
												</p>-->
												<div class="drop-to-stylechange eg-tooltip-wrap" title="<?php _e('Drop Element from Available Layers here to overwrite Styling of Current Element', EG_TEXTDOMAIN); ?>"><?php _e("Drop for<br>Style<br>Change", EG_TEXTDOMAIN); ?></div>
											</div>
											<!--
											BG
											-->
											<div id="eg-el-bg" class="esg-el-settings-container">
												<p>
													<label><?php _e('Background Color', EG_TEXTDOMAIN); ?></label>
													<input class="element-setting" name="element-background-color" type="text" id="element-background-color" value="" data-default-color="transparent">
												</p>
												<p>
													<label><?php _e('Background Alpha', EG_TEXTDOMAIN); ?></label>
													<span id="element-bg-alpha" class="slider-settings"></span>
													<input class="input-settings-small element-setting" type="text" name="element-bg-alpha" value="100" />
												</p>
												<?php /*
												<div>
													<label style="float:left"><?php _e('Background Fit', EG_TEXTDOMAIN); ?></label>
													<div class="select_wrapper" style="float:left;">
														<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
														<select name="element-background-size">
															<option value="cover"><?php _e('Cover', EG_TEXTDOMAIN); ?></option>
															<option value="contain"><?php _e('Contain', EG_TEXTDOMAIN); ?></option>
															<!--option value="%"><?php _e('%', EG_TEXTDOMAIN); ?></option-->
															<option value="normal"><?php _e('Normal', EG_TEXTDOMAIN); ?></option>
														</select>
													</div><div class="clear"></div>
													<!--div id="background-size-percent-wrap">
														<input class="input-settings-small element-setting" type="text" name="element-background-size-x" value="100" />
														<input class="input-settings-small element-setting" type="text" name="element-background-size-y" value="100" />
													</div-->
												</div>
												<div>
													<label style="float:left"><?php _e('Background Repeat', EG_TEXTDOMAIN); ?></label>
													<div class="select_wrapper" style="float:left;">
														<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
														<select name="element-background-repeat">
															<option value="no-repeat"><?php _e('no-repeat', EG_TEXTDOMAIN); ?></option>
															<option value="repeat"><?php _e('repeat', EG_TEXTDOMAIN); ?></option>
															<option value="repeat-x"><?php _e('repeat-x', EG_TEXTDOMAIN); ?></option>
															<option value="repeat-y"><?php _e('repeat-y', EG_TEXTDOMAIN); ?></option>
														</select>
													</div><div class="clear"></div>
												</div> */ ?>
												<div class="drop-to-stylechange eg-tooltip-wrap" title="<?php _e('Drop Element from Available Layers here to overwrite Styling of Current Element', EG_TEXTDOMAIN); ?>"><?php _e("Drop for<br>Style<br>Change", EG_TEXTDOMAIN); ?></div>
											</div>

											<!--
											SHADOW
											-->
											<div id="eg-el-shadow" class="esg-el-settings-container">
												<p>
													<label><?php _e('Shadow Color', EG_TEXTDOMAIN); ?></label>
													<input class="element-setting" name="element-shadow-color" type="text" id="element-shadow-color" value="" data-default-color="#000000">
												</p>
												<p>
													<label><?php _e('Shadow Alpha', EG_TEXTDOMAIN); ?></label>
													<span id="element-shadow-alpha" class="slider-settings"></span>
													<input class="input-settings-small element-setting" type="text" name="element-shadow-alpha" value="100" />
												</p>
												<p>
													<label class="eg-tooltip-wrap" title="<?php _e('Position of horizontal shadow(Negative values possible)', EG_TEXTDOMAIN) ?>, <?php _e('blur distance', EG_TEXTDOMAIN) ?>, <?php _e('size of shadow', EG_TEXTDOMAIN) ?>"><?php _e('Shadow', EG_TEXTDOMAIN); ?></label>
													<input class="input-settings-small element-setting firstinput" type="text" name="element-box-shadow[]" value="0" />
													<input class="input-settings-small element-setting" type="text" name="element-box-shadow[]" value="0" />
													<input class="input-settings-small element-setting" type="text" name="element-box-shadow[]" value="0" />
													<input class="input-settings-small element-setting" type="text" name="element-box-shadow[]" value="0" /> px
												</p>
												<div class="drop-to-stylechange eg-tooltip-wrap" title="<?php _e('Drop Element from Available Layers here to overwrite Styling of Current Element', EG_TEXTDOMAIN); ?>"><?php _e("Drop for<br>Style<br>Change", EG_TEXTDOMAIN); ?></div>
											</div>

											<!--
											BORDER
											-->
											<div id="eg-el-border" class="esg-el-settings-container">
												<p>
													<label class="eg-tooltip-wrap" title="<?php _e('Top Border Width', EG_TEXTDOMAIN) ?>, <?php _e('Right Border Width', EG_TEXTDOMAIN) ?>, <?php _e('Bottom Border Width', EG_TEXTDOMAIN) ?>, <?php _e('Left Border Width', EG_TEXTDOMAIN) ?>"><?php _e('Border', EG_TEXTDOMAIN); ?></label>
													<input class="input-settings-small element-setting firstinput" type="text" name="element-border[]" value="0" />
													<input class="input-settings-small element-setting" type="text" name="element-border[]" value="0" />
													<input class="input-settings-small element-setting" type="text" name="element-border[]" value="0" />
													<input class="input-settings-small element-setting" type="text" name="element-border[]" value="0" /> px
												</p>
												<div style="margin-top:10px">
													<label style="float:left" class="eg-tooltip-wrap" title="<?php _e('Top Left Radius', EG_TEXTDOMAIN) ?>, <?php _e('Top Right Radius', EG_TEXTDOMAIN) ?>, <?php _e('Bottom Right Radius', EG_TEXTDOMAIN) ?>, <?php _e('Bottom Left Radius', EG_TEXTDOMAIN) ?>"><?php _e('Border Radius', EG_TEXTDOMAIN); ?></label>
													<input style="float:left" class="input-settings-small element-setting firstinput" type="text" name="element-border-radius[]" value="0" />
													<input style="float:left" class="input-settings-small element-setting" type="text" name="element-border-radius[]" value="0" />
													<input style="float:left" class="input-settings-small element-setting" type="text" name="element-border-radius[]" value="0" />
													<input style="float:left" class="input-settings-small element-setting" type="text" name="element-border-radius[]" value="0" />
													<div class="select_wrapper" style="float:left; width:40px;margin-left:15px;">
														<div class="select_fake" style="width: 40px;overflow: hidden;white-space: nowrap;"><span>px</span><i class="eg-icon-sort"></i></div>
														<select name="element-border-radius-unit">
															<option value="px">px</option>
															<option value="%">%</option>
														</select>
													</div><div class="clear"></div>
												</div>
												<p>
													<label><?php _e('Border Color', EG_TEXTDOMAIN); ?></label>
													<input class="element-setting" name="element-border-color" type="text" id="element-border-color" value="" data-default-color="transparent">
												</p>
												<div style="margin-top:10px">
													<label style="float:left"><?php _e('Border Style', EG_TEXTDOMAIN); ?></label>
													<div class="select_wrapper" style="float:left;">
														<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
														<select name="element-border-style">
															<option value="none"><?php _e('none', EG_TEXTDOMAIN); ?></option>
															<option value="solid"><?php _e('solid', EG_TEXTDOMAIN); ?></option>
															<option value="dotted"><?php _e('dotted', EG_TEXTDOMAIN); ?></option>
															<option value="dashed"><?php _e('dashed', EG_TEXTDOMAIN); ?></option>
															<option value="double"><?php _e('double', EG_TEXTDOMAIN); ?></option>
														</select>
													</div><div class="clear"></div>
												</div>
												<div class="drop-to-stylechange eg-tooltip-wrap" title="<?php _e('Drop Element from Available Layers here to overwrite Styling of Current Element', EG_TEXTDOMAIN); ?>"><?php _e("Drop for<br>Style<br>Change", EG_TEXTDOMAIN); ?></div>
											</div>
										</div>

										<!-- HOVER STYLING -->
										<div id="eg-style-hover">
											<div class="eg-small-vertical-menu">
												<ul>
													<li class="selected-el-setting" data-toshow="eg-el-font-hover"><i class="eg-icon-font" ></i><p><?php _e('Style', EG_TEXTDOMAIN); ?></p></li>
													<li class="" data-toshow="eg-el-border-hover"><i class="eg-icon-minus-squared-alt"></i><p><?php _e('Border', EG_TEXTDOMAIN); ?></p></li>
													<li class="" data-toshow="eg-el-bg-hover"><i class="eg-icon-picture-1"></i><p><?php _e('BG', EG_TEXTDOMAIN); ?></p></li>
													<li class="" data-toshow="eg-el-shadow-hover"><i class="eg-icon-picture"></i><p><?php _e('Shadow', EG_TEXTDOMAIN); ?></p></li>
												</ul>
											</div>
											<!--
											FONT ON HONVER
											-->
											<div id="eg-el-font-hover" class="esg-el-settings-container active-esc">
												<p>
													<label><?php _e('Font Size', EG_TEXTDOMAIN); ?></label>
													<span id="element-font-size-hover" class="slider-settings"></span>
													<input class="input-settings-small element-setting" type="text" name="element-font-size-hover" value="6" /> px
												</p>
												<p>
													<label><?php _e('Line Height', EG_TEXTDOMAIN); ?></label>
													<span id="element-line-height-hover" class="slider-settings"></span>
													<input class="input-settings-small element-setting" type="text" name="element-line-height-hover" value="8" /> px
												</p>
												<p>
													<label><?php _e('Font Color', EG_TEXTDOMAIN); ?></label>
													<input class="element-setting" name="element-color-hover" type="text" id="element-color-hover" value="" data-default-color="#000">
												</p>
												<p>
													<label><?php _e('Font Family', EG_TEXTDOMAIN); ?></label>
													<input class="element-setting" name="element-font-family-hover" type="text" value=""> <a class="button-secondary" id="button-open-font-family-hover" href="javascript:void(0);"><i class="eg-icon-down-open"></i></a>
												</p>
												<div style="margin-top:10px">
													<label style="float:left"><?php _e('Font Weight', EG_TEXTDOMAIN); ?></label>
													<div class="select_wrapper" style="float:left;">

														<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
														<select name="element-font-weight-hover">
															<option value="400"><?php _e('400', EG_TEXTDOMAIN); ?></option>
															<option value="100"><?php _e('100', EG_TEXTDOMAIN); ?></option>
															<option value="200"><?php _e('200', EG_TEXTDOMAIN); ?></option>
															<option value="300"><?php _e('300', EG_TEXTDOMAIN); ?></option>
															<option value="500"><?php _e('500', EG_TEXTDOMAIN); ?></option>
															<option value="600"><?php _e('600', EG_TEXTDOMAIN); ?></option>
															<option value="700"><?php _e('700', EG_TEXTDOMAIN); ?></option>
															<option value="800"><?php _e('800', EG_TEXTDOMAIN); ?></option>
															<option value="900"><?php _e('900', EG_TEXTDOMAIN); ?></option>
														</select>
													</div><div class="clear"></div>
												</div>
												<div style="margin-top:10px">
													<label style="float:left"><?php _e('Text Decoration', EG_TEXTDOMAIN); ?></label>
													<div class="select_wrapper" style="float:left;">
														<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
														<select name="element-text-decoration-hover">
															<option value="none"><?php _e('None', EG_TEXTDOMAIN); ?></option>
															<option value="underline"><?php _e('Underline', EG_TEXTDOMAIN); ?></option>
															<option value="overline"><?php _e('Overline', EG_TEXTDOMAIN); ?></option>
															<option value="line-through"><?php _e('Line Through', EG_TEXTDOMAIN); ?></option>
														</select>
													</div><div class="clear"></div>
												</div>
												<p>
													<label><?php _e('Font Style', EG_TEXTDOMAIN); ?></label>
													<input type="checkbox" name="element-font-style-hover" value="italic" /> <?php _e('Italic', EG_TEXTDOMAIN); ?>
												</p>
												<div style="margin-top:10px">
													<label style="float:left"><?php _e('Text Transform', EG_TEXTDOMAIN); ?></label>
													<div class="select_wrapper" style="float:left;">
														<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
														<select name="element-text-transform-hover">
															<option value="none"><?php _e('None', EG_TEXTDOMAIN); ?></option>
															<option value="capitalize"><?php _e('Capitalize', EG_TEXTDOMAIN); ?></option>
															<option value="uppercase"><?php _e('Uppercase', EG_TEXTDOMAIN); ?></option>
															<option value="lowercase"><?php _e('Lowercase', EG_TEXTDOMAIN); ?></option>
														</select>
													</div><div class="clear"></div>
												</div>
												<div class="revyellow drop-to-stylereset button-primary"><i class="eg-icon-ccw-1"></i><?php _e("Reset from Idle", EG_TEXTDOMAIN); ?></div>
											</div>

											<!--
											BG ON HOVER
											-->
											<div id="eg-el-bg-hover" class="esg-el-settings-container">
												<p>
													<label><?php _e('Background Color', EG_TEXTDOMAIN); ?></label>
													<input class="element-setting" name="element-background-color-hover" type="text" id="element-background-color-hover" value="" data-default-color="transparent">
												</p>
												<p>
													<label><?php _e('Background Alpha', EG_TEXTDOMAIN); ?></label>
													<span id="element-bg-alpha-hover" class="slider-settings"></span>
													<input class="input-settings-small element-setting" type="text" name="element-bg-alpha-hover" value="100" />
												</p>
												<?php /*
												<div>
													<label style="float:left"><?php _e('Background Fit', EG_TEXTDOMAIN); ?></label>
													<div class="select_wrapper" style="float:left;">
														<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
														<select name="element-background-size-hover">
															<option value="cover"><?php _e('Cover', EG_TEXTDOMAIN); ?></option>
															<option value="contain"><?php _e('Contain', EG_TEXTDOMAIN); ?></option>
															<!--option value="%"><?php _e('%', EG_TEXTDOMAIN); ?></option-->
															<option value="normal"><?php _e('Normal', EG_TEXTDOMAIN); ?></option>
														</select>
													</div><div class="clear"></div>
													<div id="background-size-percent-wrap-hover">
														<input class="input-settings-small element-setting" type="text" name="element-background-size-x-hover" value="100" />
														<input class="input-settings-small element-setting" type="text" name="element-background-size-y-hover" value="100" />
													</div>
												</div>
												<div>
													<label style="float:left"><?php _e('Background Repeat', EG_TEXTDOMAIN); ?></label>
													<div class="select_wrapper" style="float:left;">
														<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
														<select name="element-background-repeat-hover">
															<option value="no-repeat"><?php _e('no-repeat', EG_TEXTDOMAIN); ?></option>
															<option value="repeat"><?php _e('repeat', EG_TEXTDOMAIN); ?></option>
															<option value="repeat-x"><?php _e('repeat-x', EG_TEXTDOMAIN); ?></option>
															<option value="repeat-y"><?php _e('repeat-y', EG_TEXTDOMAIN); ?></option>
														</select>
													</div><div class="clear"></div>
												</div>     */ ?>
												<div class="revyellow drop-to-stylereset button-primary"><i class="eg-icon-ccw-1"></i><?php _e("Reset from Idle", EG_TEXTDOMAIN); ?></div>
											</div>

											<!--
											SHADOW ON HOVER
											-->
											<div id="eg-el-shadow-hover" class="esg-el-settings-container">
												<p>
													<label><?php _e('Shadow Color', EG_TEXTDOMAIN); ?></label>
													<input class="element-setting" name="element-shadow-color-hover" type="text" id="element-shadow-color-hover" value="" data-default-color="#000000">
												</p>
												<p>
													<label><?php _e('Shadow Alpha', EG_TEXTDOMAIN); ?></label>
													<span id="element-shadow-alpha-hover" class="slider-settings"></span>
													<input class="input-settings-small element-setting" type="text" name="element-shadow-alpha-hover" value="100" />
												</p>
												<p>
													<label class=" eg-tooltip-wrap" title="<?php _e('Position horizontal shadow(Negative values possible)', EG_TEXTDOMAIN) ?>, <?php _e('blur distance', EG_TEXTDOMAIN) ?>, <?php _e('Shadow size', EG_TEXTDOMAIN) ?>"><?php _e('Shadow', EG_TEXTDOMAIN); ?></label>
													<input class="input-settings-small element-setting firstinput" type="text" name="element-box-shadow-hover[]" value="0" />
													<input class="input-settings-small element-setting" type="text" name="element-box-shadow-hover[]" value="0" />
													<input class="input-settings-small element-setting" type="text" name="element-box-shadow-hover[]" value="0" />
													<input class="input-settings-small element-setting" type="text" name="element-box-shadow-hover[]" value="0" /> px
												</p>
												<div class="revyellow drop-to-stylereset button-primary"><i class="eg-icon-ccw-1"></i><?php _e("Reset from Idle", EG_TEXTDOMAIN); ?></div>
											</div>

											<!--
											BORDER ON HOVER
											-->
											<div id="eg-el-border-hover" class="esg-el-settings-container">

												<p>
													<label class="eg-tooltip-wrap" title="<?php _e('Top', EG_TEXTDOMAIN) ?>, <?php _e('Right', EG_TEXTDOMAIN) ?>, <?php _e('Bottom', EG_TEXTDOMAIN) ?>, <?php _e('Left Border Width', EG_TEXTDOMAIN) ?>"><?php _e('Border', EG_TEXTDOMAIN); ?></label>
													<input class="input-settings-small element-setting firstinput" type="text" name="element-border-hover[]" value="0" />
													<input class="input-settings-small element-setting" type="text" name="element-border-hover[]" value="0" />
													<input class="input-settings-small element-setting" type="text" name="element-border-hover[]" value="0" />
													<input class="input-settings-small element-setting" type="text" name="element-border-hover[]" value="0" /> px
												</p>
												<div style="margin-top:10px">
													<label style="float:left" class="eg-tooltip-wrap" title="<?php _e('Top Left Radius', EG_TEXTDOMAIN) ?>, <?php _e('Top Right Radius', EG_TEXTDOMAIN) ?>, <?php _e('Bottom Right Radius', EG_TEXTDOMAIN) ?>, <?php _e('Bottom Left Radius', EG_TEXTDOMAIN) ?>"><?php _e('Border Radius', EG_TEXTDOMAIN); ?></label>
													<input style="float:left" class="input-settings-small element-setting firstinput" type="text" name="element-border-radius-hover[]" value="0" />
													<input style="float:left" class="input-settings-small element-setting" type="text" name="element-border-radius-hover[]" value="0" />
													<input style="float:left" class="input-settings-small element-setting" type="text" name="element-border-radius-hover[]" value="0" />
													<input style="float:left" class="input-settings-small element-setting" type="text" name="element-border-radius-hover[]" value="0" />
													<div class="select_wrapper" style="float:left; width:40px;margin-left:15px;">
														<div class="select_fake" style="width: 40px;overflow: hidden;white-space: nowrap;"><span>px</span><i class="eg-icon-sort"></i></div>
														<select name="element-border-radius-unit-hover">
															<option value="px">px</option>
															<option value="%">%</option>
														</select>
													</div><div class="clear"></div>
												</div>
												<p>
													<label><?php _e('Border Color', EG_TEXTDOMAIN); ?></label>
													<input class="element-setting" name="element-border-color-hover" type="text" id="element-border-color-hover" value="" data-default-color="transparent">
												</p>
												<div style="margin-top:10px">
													<label style="float:left"><?php _e('Border Style', EG_TEXTDOMAIN); ?></label>
													<div class="select_wrapper" style="float:left;">
														<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
														<select name="element-border-style-hover">
															<option value="none"><?php _e('none', EG_TEXTDOMAIN); ?></option>
															<option value="solid"><?php _e('solid', EG_TEXTDOMAIN); ?></option>
															<option value="dotted"><?php _e('dotted', EG_TEXTDOMAIN); ?></option>
															<option value="dashed"><?php _e('dashed', EG_TEXTDOMAIN); ?></option>
															<option value="double"><?php _e('double', EG_TEXTDOMAIN); ?></option>
														</select>
													</div><div class="clear"></div>
												</div>
												<div class="revyellow drop-to-stylereset button-primary"><i class="eg-icon-ccw-1"></i><?php _e("Reset from Idle", EG_TEXTDOMAIN); ?></div>
											</div>

										</div>

									</div>
								</div>

								<!--
								HIDE UNDER
								-->
								<div id="eg-element-hide">
									<p>
										<label style="width:250px" class="eg-tooltip-wrap" title="<?php _e('Dont Show Element if Item Width is smaller than:', EG_TEXTDOMAIN); ?>"><?php _e('Hide Under Width', EG_TEXTDOMAIN); ?></label>
										<input class="input-settings-small element-setting firstinput" type="text" name="element-hideunder" value="0" /> px
									</p>
									<p>
										<label style="width:250px" class="eg-tooltip-wrap" title="<?php _e('Dont Show Element on mobile if Item height is smaller than:', EG_TEXTDOMAIN); ?>"><?php _e('Hide Under Height', EG_TEXTDOMAIN); ?></label>
										<input class="input-settings-small element-setting firstinput" type="text" name="element-hideunderheight" value="0" /> px
									</p>
									<div style="margin-top:10px">
										<label style="width:250px; float:left"><?php _e('Hide Under Type', EG_TEXTDOMAIN); ?></label>
										<div class="select_wrapper" style="float:left;">
											<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
											<select name="element-hidetype">
												<option value="visibility"><?php _e('visibility', EG_TEXTDOMAIN); ?></option>
												<option value="display"><?php _e('display', EG_TEXTDOMAIN); ?></option>
											</select>
										</div><div class="clear"></div>
									</div>
									<div style="margin-top:10px">
										<label style="width:250px; float:left" title="<?php _e('Show/Hide Element if the Media this Entry gains is a Video', EG_TEXTDOMAIN); ?>"><?php _e('If Media is Video', EG_TEXTDOMAIN); ?></label>
										<div class="select_wrapper" style="float:left;">
											<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
											<select name="element-hide-on-video">
												<option value="false"><?php _e('-- Do Nothing --', EG_TEXTDOMAIN); ?></option>
												<option value="true"><?php _e('Hide', EG_TEXTDOMAIN); ?></option>
												<option value="show"><?php _e('Show', EG_TEXTDOMAIN); ?></option>
											</select>
										</div><div class="clear"></div>
									</div>
									<p>
										<label style="width:250px; float:left" class="eg-tooltip-wrap" title="<?php _e('Show/Hide Element only if the LightBox is a Video', EG_TEXTDOMAIN); ?>"><?php _e('If LightBox is Video', EG_TEXTDOMAIN); ?></label>
										<!--input type="checkbox" name="element-show-on-lightbox-video" value="true" /-->
										<div class="select_wrapper" style="float:left;">
											<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
											<select name="element-show-on-lightbox-video">
												<option value="false"><?php _e('-- Do Nothing --', EG_TEXTDOMAIN); ?></option>
												<option value="true"><?php _e('Show', EG_TEXTDOMAIN); ?></option>
												<option value="hide"><?php _e('Hide', EG_TEXTDOMAIN); ?></option>
											</select>
										</div><div class="clear"></div>
									</p>
									<?php
									if(!Essential_Grid_Woocommerce::is_woo_exists()){
										echo '<div style="display: none;">';
									}
									?>
									<p>
										<label style="width:250px" class="eg-tooltip-wrap" title="<?php _e('Show the Element only if it is on Sale. This is a WooCommerce setting', EG_TEXTDOMAIN); ?>"><?php _e('Show if Product is on Sale', EG_TEXTDOMAIN); ?></label>
										<input type="checkbox" name="element-show-on-sale"  value="true" />
									</p>
									<p>
										<label style="width:250px" class="eg-tooltip-wrap" title="<?php _e('Show the Element only if it is featured. This is a WooCommerce setting', EG_TEXTDOMAIN); ?>"><?php _e('Show if Product is featured', EG_TEXTDOMAIN); ?></label>
										<input type="checkbox" name="element-show-if-featured" value="true" />
									</p>
									<?php
									if(!Essential_Grid_Woocommerce::is_woo_exists()){
										echo '</div>';
									}
									?>
									<p>
										<a href="javascript:void(0);" id="esg-advanced-rules-edit" class="button-primary revyellow"><?php _e('Advanced Rules', EG_TEXTDOMAIN); ?></a>
									</p>

								</div>

								<!--
								ANIMATION
								-->
								<div id="eg-element-animation">
									<div style="margin-top:10px">
										<label style="float:left"><?php _e('Transition', EG_TEXTDOMAIN); ?></label>
										<div id="eg-element-transition-drop" class="select_wrapper" style="float:left;">
											<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
											<select name="element-transition" class="eg-tooltip-wrap" title="<?php _e('Select Animation of Element on Hover', EG_TEXTDOMAIN); ?>" >
												<?php
												foreach($transitions_cover as $handle => $name){
												?>
												<option value="<?php echo $handle; ?>"><?php echo $name; ?></option>
												<?php
												}
												?>
											</select>
										</div>
										<div class="select_wrapper" style="float:left;width:120px;">
											<div class="select_fake" style="width: 95px;overflow: hidden;white-space: nowrap;"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
											<select name="element-transition-type" class="eg-tooltip-wrap" title="<?php _e('Hide or Show element on hover. In = Show, Out = Hide', EG_TEXTDOMAIN); ?>" >
												<option value=""><?php _e('in', EG_TEXTDOMAIN); ?></option>
												<option value="out"><?php _e('out', EG_TEXTDOMAIN); ?></option>
												<option value="always"><?php _e('always visible', EG_TEXTDOMAIN); ?></option>
											</select>
										</div>
										<div id="groupanimwarning"><?php _e('Dont forget to set the <strong>Group Animation</strong> to "none" !', EG_TEXTDOMAIN); ?></div>
										<div class="clear"></div>
									</div>
									<!--div style="margin-top:10px">
										<label style="float:left"><?php _e('Transition Split', EG_TEXTDOMAIN); ?></label>
										<div class="select_wrapper" style="float:left;">
											<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
											<select name="element-split">
												<option value="full"><?php _e('Full', EG_TEXTDOMAIN); ?></option>
												<option value="line"><?php _e('Line', EG_TEXTDOMAIN); ?></option>
												<option value="word"><?php _e('Word', EG_TEXTDOMAIN); ?></option>
												<option value="character"><?php _e('Character', EG_TEXTDOMAIN); ?></option>
											</select>
										</div>
										<div class="clear"></div>
									</div-->
									<p>
										<label><?php _e('Delay', EG_TEXTDOMAIN); ?></label>
										<span id="element-delay" class="slider-settings eg-tooltip-wrap" title="<?php _e('Delay before Element Animation starts', EG_TEXTDOMAIN) ?>" ></span>
										<input class="input-settings-small element-setting" type="text" name="element-delay" value="0" />
									</p>
								</div>
								<!--
								LINK TO
								-->
								<div id="eg-element-link">
									<div style="margin-top:10px">
										<label style="float:left"><?php _e('Link To', EG_TEXTDOMAIN); ?></label>
										<div class="select_wrapper" style="float:left;">
											<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
											<select name="element-link-type">
												<option value="none"><?php _e('None', EG_TEXTDOMAIN); ?></option>
												<option value="post"><?php _e('Post', EG_TEXTDOMAIN); ?></option>
												<option value="url"><?php _e('URL', EG_TEXTDOMAIN); ?></option>
												<option value="meta"><?php _e('Meta', EG_TEXTDOMAIN); ?></option>
												<option value="ajax"><?php _e('Ajax', EG_TEXTDOMAIN); ?></option>
												<option value="javascript"><?php _e('JavaScript', EG_TEXTDOMAIN); ?></option>
												<option value="lightbox"><?php _e('Lightbox', EG_TEXTDOMAIN); ?></option>
												<option value="embedded_video"><?php _e('Play Embedded Video', EG_TEXTDOMAIN); ?></option>
												<option value="sharefacebook"><?php _e('Share on Facebook', EG_TEXTDOMAIN); ?></option>
												<option value="sharetwitter"><?php _e('Share on Twitter', EG_TEXTDOMAIN); ?></option>
											</select>
										</div><div class="clear"></div>
									</div>
									<p id="eg-element-post-url-wrap" style="display: none;">
										<label><?php _e('Link To URL', EG_TEXTDOMAIN); ?></label>
										<input class="element-setting" type="text" name="element-url-link" value="" />
									</p>
									<p id="eg-element-post-meta-wrap" style="display: none;">
										<label><?php _e('Meta Key', EG_TEXTDOMAIN); ?></label>
										<input class="element-setting" type="text" name="element-meta-link" value="" />
										<a class="button-secondary" id="button-open-link-meta-key" href="javascript:void(0);"><i class="eg-icon-down-open"></i></a>
									</p>
									<p id="eg-element-post-javascript-wrap" style="display: none;">
										<label><?php _e('Link JavaScript', EG_TEXTDOMAIN); ?></label>
										<input class="element-setting" type="text" name="element-javascript-link" value="" />
									</p>
									<div id="eg-element-link-details-wrap">
										<div style="margin-top:10px">
											<label style="float:left"><?php _e('Link Target', EG_TEXTDOMAIN); ?></label>
											<div class="select_wrapper" style="float:left;">
												<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
												<select name="element-link-target">
													<option value="disabled"><?php _e('disabled', EG_TEXTDOMAIN); ?></option>
													<option value="_self"><?php _e('_self', EG_TEXTDOMAIN); ?></option>
													<option value="_blank"><?php _e('_blank', EG_TEXTDOMAIN); ?></option>
													<option value="_parent"><?php _e('_parent', EG_TEXTDOMAIN); ?></option>
													<option value="_top"><?php _e('_top', EG_TEXTDOMAIN); ?></option>
												</select>
											</div><div class="clear"></div>
										</div>
										<div style="margin-top:10px">
											<label style="float:left"><?php _e('Use Tag', EG_TEXTDOMAIN); ?></label>
											<div class="select_wrapper" style="float:left;">
												<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
												<select name="element-tag-type">
													<option value="div"><?php _e('DIV', EG_TEXTDOMAIN); ?></option>
													<option value="p"><?php _e('P', EG_TEXTDOMAIN); ?></option>
													<option value="h2"><?php _e('H2', EG_TEXTDOMAIN); ?></option>
													<option value="h3"><?php _e('H3', EG_TEXTDOMAIN); ?></option>
													<option value="h4"><?php _e('H4', EG_TEXTDOMAIN); ?></option>
													<option value="h5"><?php _e('H5', EG_TEXTDOMAIN); ?></option>
													<option value="h6"><?php _e('H6', EG_TEXTDOMAIN); ?></option>
												</select>
											</div><div class="clear"></div>
										</div>
									</div>
									<div style="margin-top:10px">
										<label style="float:left"><?php _e('Fix: !important', EG_TEXTDOMAIN); ?></label>
										<input type="checkbox" name="element-force-important" value="true" /> <?php _e('Force !important in styles', EG_TEXTDOMAIN); ?>
									</div>
									
									<!-- Facebook Fields -->
									<div class="eg-element-facebook-wrap">
										<div style="margin-top:10px">
											<label style="float:left"><?php _e('Link Target', EG_TEXTDOMAIN); ?></label>
											<div class="select_wrapper" style="float:left;">
												<div class="select_fake"><span><?php _e('Not uppercased', EG_TEXTDOMAIN); ?></span><i class="eg-icon-sort"></i></div>
												<select name="element-facebook-sharing-link">
													<option value="site"><?php _e("Parent Site URL",EG_TEXTDOMAIN); ?></option>
													<option value="post"><?php _e("Post URL",EG_TEXTDOMAIN); ?></option>
													<option value="custom"><?php _e("Custom URL",EG_TEXTDOMAIN); ?></option>
												</select>
											</div><div class="clear"></div>
										</div>
										<div style="margin-top:10px">
											<div class="eg-element-facebook_link_custom">
												<label style="float:left"><?php _e("URL",EG_TEXTDOMAIN); ?></label>
												<input type="text" style="width:250px;" name="element-facebook-link-url" value="">
											</div><div class="clear"></div>
										</div>
									</div>
									<?php
									/*
									<p>
										<label><?php _e('Attribute', EG_TEXTDOMAIN); ?></label>
										<input class="element-setting" name="element-attribute" type="text" value="">
									</p>
									<p>
										<label><?php _e('Class', EG_TEXTDOMAIN); ?></label>
										<input class="element-setting" name="element-class" type="text" value="">
									</p>
									<p>
										<label><?php _e('Rel', EG_TEXTDOMAIN); ?></label>
										<input class="element-setting" name="element-rel" type="text" value="">
									</p>
									*/
									?>
								</div>
							</div>
							<p id="dz-delete" class="eg-delete-wrapper">
								<a id="element-save-as-button" class="button-primary revblue" href="javascript:void(0);"><i class="eg-icon-login"></i> <?php _e('Save as Template', EG_TEXTDOMAIN); ?></a>
								<a id="element-delete-button" class="button-primary revred" href="javascript:void(0);"><i class="eg-icon-trash"></i> <?php _e('Remove', EG_TEXTDOMAIN); ?></a>
							</p>
						</form>
					</div>

					<div id="element-setting-wrap-alternative" style="padding: 10px;">
						<?php _e("Please Drop some Element from the AVAILABLE LAYERS into the ITEM LAYOUT drop zone to be able to edit any Elements here", EG_TEXTDOMAIN); ?>
					</div>
				</div>
			</div>
		</div>

		<!--
		THE ITEM LAYOUT
		-->
		<div class="postbox eg-postbox" id="eg-it-layout-wrap" style="display:inline-block;"><h3><span class="eg-element-setter"><i style="background-color:#27AE60; padding:3px; margin-right:10px;border-radius:50%;-moz-border-radius:50%;-webkit-border-radius:50%;color:#fff;" class="eg-icon-menu"></i><?php _e('Item Layout', EG_TEXTDOMAIN); ?></span></h3>
			<div class="inside padding-10">

				<div style="display:none">
					<?php _e('Show at Width:', EG_TEXTDOMAIN); ?> <span id="element-item-skin-width-check" class="slider-settings"></span>
					<span id="currently-at-pixel">400px</span>
				</div>

				<div style="width:100%;height:15px"></div>

				<div style="float:left">
					<a href="javascript:void(0);" class="button-primary revblue" id="eg-preview-item-skin"><i class="eg-icon-play"></i></a>
					<a href="javascript:void(0);" class="button-primary revred" id="eg-preview-stop-item-skin"><i class="eg-icon-stop"></i></a>
				</div>

				<div style="float:left">
					<a href="javascript:void(0);" class="button-primary revblue" id="make-3d-map"><?php _e('Schematic', EG_TEXTDOMAIN); ?></a>
				</div>

				<div style="margin-left:50px;float:left">
					<a href="javascript:void(0);" class="button-primary revpurple" id="layertotop"><i class="eg-icon-up-dir"></i></a>
				</div>

				<div style="float:left">
					<a href="javascript:void(0);" class="button-primary revpurple" id="layertobottom"><i class="eg-icon-down-dir"></i></a>
				</div>


				<div style="float:right">
					<a href="javascript:void(0);" class="button-primary revgreen" style="margin-right:0px !important" id="drop-1"><?php _e('Hide DropZones', EG_TEXTDOMAIN); ?></a>
				</div>

				<div class="clear"></div>

				<div style="width:100%;height:15px"></div>

				<div style="position:relative">
					<div class="eg-editor-inside-wrapper">
						<div id="eg-dz-padding-wrapper" class="esg-media-cover-wrapper">
							<div id="eg-dz-hover-wrap">
								<!-- MEDIA -->
								<div id="skin-dz-media-bg-wrapper" class="esg-entry-media-wrapper" style="width:100%;height:100%;position:absolute;overflow:hidden">
									<div id="skin-dz-media-bg"></div>
								</div>

								<!-- OVERLAYS -->
								<div id="skin-dz-wrapper">
									<div class="esg-cc eec" id="skin-dz-c-wrap">
										<div class="eg-element-cover"></div>
										<div id="eg-element-centerme-c">
											<div class="dropzonetext eg-drop-2">
												<div class="dropzoneinner"><?php _e('DROP ZONE', EG_TEXTDOMAIN); ?></div>
											</div>
											<div id="skin-dz-c"></div>
										</div>
									</div>
									<div class="esg-tc eec" id="skin-dz-tl-wrap">
										<div class="dropzonetext eg-drop-1">
											<div class="dropzoneinner"><?php _e('DROP ZONE', EG_TEXTDOMAIN); ?></div>
										</div>
										<div id="skin-dz-tl"><div class="eg-element-cover"></div></div>
									</div>
									<div class="esg-bc eec" id="skin-dz-br-wrap">
										<div class="dropzonetext eg-drop-3">
											<div class="dropzoneinner"><?php _e('DROP ZONE', EG_TEXTDOMAIN); ?></div>
										</div>
										<div id="skin-dz-br"><div class="eg-element-cover"></div></div>
									</div>
								</div>

								<!-- CONTENT -->
								<div id="skin-dz-m-wrap" class="esg-entry-content">
									<div class="dropzonetext eg-drop-4">
										<div class="dropzoneinner"><?php _e('DROP ZONE', EG_TEXTDOMAIN); ?></div>
									</div>

									<div id="skin-dz-m"></div>
								</div>

								<div class="clear"></div>
							</div>
						</div>
					</div>

					<!-- 3D MAP -->
					<div id="eg-3dpp" class="eg-3dpp" style="visibility:hidden">
						<div id="eg-3dpp-inner" style="position:relative">
							<div class="eg-3dmc">
								<div class="eg-3d-bg"></div>
								<div class="eg-3d-cover"></div>
								<div class="eg-3d-elements">
									<div class="eg-3d-element"><i style="margin-right:10px; " class="eg-icon-link"></i><i class="eg-icon-search"></i></div>
									<div class="eg-3d-element" style="margin-top:30px; color:#34495e; background:#fff; padding:5px 10px; font-size:12px; display:inline-block">LOREM IPSUM DOLOR</div>
									<div style="width:100%;height:5px"></div>
									<div class="eg-3d-element" style="color:#000; background:#fff; padding:3px 7px; font-size:12px; display:inline-block">sed do ediusmod 09.06.2021</div>
								</div>
							</div>

							<div class="eg-3dcc">
								<div class="eg-3d-ccbg"></div>
								<div class="eg-3d-element 3d-cont" style="font-size:14px; font-weight:600;color:#34495e; background:#fff; padding:3px 7px;">Lorem Ipsum Dolor</div>
								<div class="eg-3d-element 3d-cont" style="font-size:12px; line-height:14px;color:#34495e; background:#fff; padding:3px 7px; font-weight:400;margin-top:5px;">Sit amet, consectetur adipisicing elit, sed ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exerci.</div>
								<div class="eg-3d-element 3d-cont" style="margin-top:10px;font-size:11px; color:#333; font-weight:600;background:#34495e; padding:3px;5px; float:right; color:#fff;font-wieght:600;">LOREM</div>
								<div class="clear"></div>
							</div>
						</div>
					</div>
					<div id="eg-3d-description" style="visibility:hidden">
						<span id="eg-3d-cstep1"><?php _e("Layers", EG_TEXTDOMAIN); ?></span>
						<span id="eg-3d-cstep2"><?php _e("Covers", EG_TEXTDOMAIN); ?></span>
						<span id="eg-3d-cstep3"><?php _e("Media", EG_TEXTDOMAIN); ?></span>
						<span id="eg-3d-cstep4"><?php _e("Content & Layers", EG_TEXTDOMAIN); ?></span>
					</div>
				</div>

				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>


	<!--******************************
	-	THE ELEMENTS GRID	-
	******************************** -->
	<div style="width:100%;height:40px"></div>
	<div class="postbox eg-postbox fullwidthpostbox2 eg-transbg" ><h3><span class="eg-element-setter"><?php _e('Available Layers', EG_TEXTDOMAIN); ?></span></h3>
		<div class="inside" style="margin:0; padding:0;">

			<!-- GRID WRAPPER FOR CONTAINER SIZING   HERE YOU CAN SET THE CONTAINER SIZE AND CONTAINER SKIN-->
			<article class="backend-flat">

				<!-- THE GRID ITSELF WITH FILTERS, PAGINATION,  SORTING ETC... -->
				<div id="eg-elements-container-grid" class="esg-grid" style="text-align:center;">

					<!-- THE FILTERING,  SORTING AND WOOCOMMERCE BUTTONS -->
					<article class="esg-filters esg-singlefilters "> <!-- Use esg-multiplefilters for Mixed Filtering, and esg-singlefilters for Single Filtering -->
						<!-- THE FILTER BUTTONS -->
						<div class="esg-filter-wrapper">
							<div class="esg-filterbutton selected esg-allfilter" data-filter="filterall"><span><?php _e('Filter - All', EG_TEXTDOMAIN); ?></span></div>
							<div class="esg-filterbutton" data-filter="filter-icon"><span><?php _e('Icons', EG_TEXTDOMAIN); ?></span><span class="esg-filter-checked"><i class="eg-icon-ok-1"></i></span></div>
							<div class="esg-filterbutton" data-filter="filter-text"><span><?php _e('Texts', EG_TEXTDOMAIN); ?></span><span class="esg-filter-checked"><i class="eg-icon-ok-1"></i></span></div>
							<div class="esg-filterbutton" data-filter="filter-default"><span><?php _e('Default', EG_TEXTDOMAIN); ?></span><span class="esg-filter-checked"><i class="eg-icon-ok-1"></i></span></div>
						</div>

						<div class="clear"></div>

					</article><!-- END OF FILTERING, SORTING AND  CART BUTTONS -->

					<div class="clear"></div>

					<!-- ############################ -->
					<!-- THE GRID ITSELF WITH ENTRIES -->
					<!-- ############################ -->
					<ul id="" data-kriki="">
						<?php echo $item_elements->prepareDefaultElementsForEditor(); ?>
						<?php echo $item_elements->prepareTextElementsForEditor(); ?>
					</ul>

					<!-- The Pagination Container. Page Buttons will be added on demand Automatically !! -->
					<article style="background: #FFF;z-index: 100;-webkit-backface-visibility: hidden;" class="esg-pagination"></article>
				</div>

			</article>

			<div class="clear"></div>
			<div class="eg-special">
				<?php echo $item_elements->prepareSpecialElementsForEditor(); ?>

				<?php echo $item_elements->prepareAdditionalElementsForEditor(); ?>

			</div>
			<div style="text-align:center;position: absolute;width: 100%;background:#fff;"><i style="font-size:10px;color:#777"><?php _e('Drag and Drop Elements into the Item Layout - Note You only see here the elements which fits well in your Cover Colors !', EG_TEXTDOMAIN); ?></i></div>
			<div class="eg-trashdropzone eg-tooltip-wrap" title="<?php _e('Move ELement Template over to Remove from Available Layers', EG_TEXTDOMAIN); ?>"><i style="float:left" class="eg-icon-trash"></i><div style="float:left; line-height:11px;"><span style="font-size:10px;"><?php _e('DROP<br>HERE', EG_TEXTDOMAIN); ?></span></div></div>
		</div>
	</div>

	<div id="eg-inline-style-wrapper"></div>

	<div style="margin-top:20px;" class="save-wrap-settings-skin"><a class="button-primary revgreen" href="javascript:void(0);" id="eg-btn-save-grid-editor"><i class="rs-icon-save-light" style="display: inline-block;vertical-align: middle;width: 18px;height: 20px;background-repeat: no-repeat;margin-right:10px !important;margin-left:2px !important;"></i><?php echo $save; ?></a></div>

	<?php
	Essential_Grid_Dialogs::fontello_icons_dialog();
	Essential_Grid_Dialogs::global_css_edit_dialog();
	Essential_Grid_Dialogs::meta_dialog();
	Essential_Grid_Dialogs::edit_advanced_rules_dialog();
	?>
</div>

<script type="text/javascript">
	jQuery(function(){
		GridEditorEssentials.setInitElementsJson(<?php echo $base->jsonEncodeForClientSide($elements); ?>);

		GridEditorEssentials.setInitFontsJson(<?php echo $base->jsonEncodeForClientSide($fonts_full); ?>);

		GridEditorEssentials.setInitAllAttributesJson(<?php echo $base->jsonEncodeForClientSide($all_attributes); ?>);

		GridEditorEssentials.setInitMetaKeysJson(<?php echo $base->jsonEncodeForClientSide($meta_keys); ?>);

		GridEditorEssentials.initGridEditor(<?php echo ($skin_id !== false) ? '"update_item_skin"' : ''; ?>);

        <?php if(!empty($skin['layers'])){ ?>
            GridEditorEssentials.setInitLayersJson(<?php echo $base->jsonEncodeForClientSide($skin['layers']); ?>);
            GridEditorEssentials.create_elements_by_data();
        <?php } ?>

        GridEditorEssentials.initDraggable();
        AdminEssentials.initSmallMenu();
        AdminEssentials.atDropStop();
        AdminEssentials.eg3dtakeCare();
        AdminEssentials.initSideButtons();

        jQuery('body').on("click",".skin-dz-elements",function() {
        	var ic = jQuery('#eg-ls-smalllsicon');
        	var bw = jQuery('#eg-layersettings-box-wrapper');

//		   punchgs.TweenLite.to(ic,0.5,{scale:1.3,ease:punchgs.Power3.easeOut,delay:1});
//		   punchgs.TweenLite.to(ic,0.5,{scale:1,delay:1.6,ease:punchgs.Power3.easeOut});
		   punchgs.TweenLite.to(bw,0.3,{borderColor:"#8E44A9"});
		   punchgs.TweenLite.to(bw,0.3,{borderColor:"#ccc",delay:0.5});
	       if (jQuery('#layer-settings-header').hasClass("box-closed")) jQuery('#layer-settings-header').click();
        });
	});

</script>
