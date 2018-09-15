<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2014 ThemePunch
 */
 
if( !defined( 'ABSPATH') ) exit();

$grid = false;

$base = new Essential_Grid_Base();
$nav_skin = new Essential_Grid_Navigation();
$wa = new Essential_Grid_Widget_Areas();
$meta = new Essential_Grid_Meta();

$isCreate = $base->getGetVar('create', 'true');

$title = __('Create New Ess. Grid', EG_TEXTDOMAIN);
$save = __('Save Grid', EG_TEXTDOMAIN);

$layers = false;

if(intval($isCreate) > 0){ //currently editing
	$grid = Essential_Grid::get_essential_grid_by_id(intval($isCreate));
	if(!empty($grid)){
		$title = __('Settings', EG_TEXTDOMAIN);

		$layers = $grid['layers'];
	}
}

$postTypesWithCats = $base->getPostTypesWithCatsForClient();
$jsonTaxWithCats = $base->jsonEncodeForClientSide($postTypesWithCats);

$base = new Essential_Grid_Base();

$pages = get_pages(array('sort_column' => 'post_name'));

$post_elements = $base->getPostTypesAssoc();

$postTypes = $base->getVar($grid['postparams'], 'post_category', 'post');
$categories = $base->setCategoryByPostTypes($postTypes, $postTypesWithCats);

$selected_pages = explode(',', $base->getVar($grid['postparams'], 'selected_pages', '-1', 's'));

$columns = $base->getVar($grid['params'], 'columns', '');
$columns = $base->set_basic_colums($columns);

$mascontent_height = $base->getVar($grid['params'], 'mascontent-height', '');
$mascontent_height = $base->set_basic_mascontent_height($mascontent_height);


$columns_width = $base->getVar($grid['params'], 'columns-width', '');
$columns_width = $base->set_basic_colums_width($columns_width);

$columns_height = $base->getVar($grid['params'], 'columns-height', '');
$columns_height = $base->set_basic_colums_height($columns_height);

$columns_advanced[] = $base->getVar($grid['params'], 'columns-advanced-rows-0', '');
$columns_advanced[] = $base->getVar($grid['params'], 'columns-advanced-rows-1', '');
$columns_advanced[] = $base->getVar($grid['params'], 'columns-advanced-rows-2', '');
$columns_advanced[] = $base->getVar($grid['params'], 'columns-advanced-rows-3', '');
$columns_advanced[] = $base->getVar($grid['params'], 'columns-advanced-rows-4', '');
$columns_advanced[] = $base->getVar($grid['params'], 'columns-advanced-rows-5', '');
$columns_advanced[] = $base->getVar($grid['params'], 'columns-advanced-rows-6', '');
$columns_advanced[] = $base->getVar($grid['params'], 'columns-advanced-rows-7', '');
$columns_advanced[] = $base->getVar($grid['params'], 'columns-advanced-rows-8', '');
$columns_advanced[] = $base->getVar($grid['params'], 'columns-advanced-rows-9', '');

$nav_skin_choosen = $base->getVar($grid['params'], 'navigation-skin', 'minimal-light');
$navigation_skins = $nav_skin->get_essential_navigation_skins();
$navigation_skin_css = $base->jsonEncodeForClientSide($navigation_skins);

$entry_skins = Essential_Grid_Item_Skin::get_essential_item_skins();
$entry_skin_choosen = $base->getVar($grid['params'], 'entry-skin', '0');

$grid_animations = $base->get_grid_animations();
$hover_animations = $base->get_hover_animations();
$grid_animation_choosen = $base->getVar($grid['params'], 'grid-animation', 'fade');
$hover_animation_choosen = $base->getVar($grid['params'], 'hover-animation', 'fade');

if(intval($isCreate) > 0) //currently editing, so default can be empty
	$media_source_order = $base->getVar($grid['postparams'], 'media-source-order', '');
else
	$media_source_order = $base->getVar($grid['postparams'], 'media-source-order', array('featured-image'));

$media_source_list = $base->get_media_source_order();

$custom_elements = $base->get_custom_elements_for_javascript();

$all_image_sizes = $base->get_all_image_sizes(); 
$all_media_filters = $base->get_all_media_filters(); 

$meta_keys = $meta->get_all_meta_handle();

// INIT POSTER IMAGE SOURCE ORDERS
if(intval($isCreate) > 0){ //currently editing, so default can be empty
	$poster_source_order = $base->getVar($grid['params'], 'poster-source-order', '');
	if($poster_source_order == ''){ //since 2.1.0
		$poster_source_order = $base->getVar($grid['postparams'], 'poster-source-order', '');
	}
}else{
	$poster_source_order = $base->getVar($grid['postparams'], 'poster-source-order', array('featured-image'));
}

$poster_source_list = $base->get_poster_source_order();


?>

<!--
LEFT SETTINGS
-->
<h2 class="topheader"><?php echo $title; ?></h2>
<div class="postbox eg-postbox" style="width:100%;min-width:500px"><h3><span><?php _e('Layout Composition', EG_TEXTDOMAIN); ?></span><div class="postbox-arrow"></div></h3>
	<div class="inside" style="padding:0px !important;margin:0px !important;height:100%;position:relative;background:#e1e1e1">

		<!--
		MENU
		-->
		<div id="eg-create-settings-menu">
			<ul>
				<li style="width:150px; background:#E1e1e1;position:absolute;height:100%;top:0px;left:0px;box-sizing:border-box;
				-moz-box-sizing:border-box;
				-webkit-box-sizing:border-box;
				"></li>
				<li class="selected-esg-setting" data-toshow="eg-create-settings"><i class="eg-icon-cog"></i><p><?php _e('Naming', EG_TEXTDOMAIN); ?></p></li>
				<li class="selected-source-setting" data-toshow="esg-settings-posts-settings"><i class="eg-icon-folder"></i><p><?php _e('Source', EG_TEXTDOMAIN); ?></p></li>
				<li class="" data-toshow="esg-settings-grid-settings"><i class="eg-icon-menu"></i><p><?php _e('Grid Settings', EG_TEXTDOMAIN); ?></p></li>
				<li class="" data-toshow="esg-settings-filterandco-settings"><i class="eg-icon-shuffle"></i><p><?php _e('Nav-Filter-Sort', EG_TEXTDOMAIN); ?></p></li>
				<li class="" data-toshow="esg-settings-skins-settings"><i class="eg-icon-droplet"></i><p><?php _e('Skins', EG_TEXTDOMAIN); ?></p></li>
				<li class="" data-toshow="esg-settings-animations-settings"><i class="eg-icon-tools"></i><p><?php _e('Animations', EG_TEXTDOMAIN); ?></p></li>				
				<li class="" data-toshow="esg-settings-lightbox-settings"><i class="eg-icon-search"></i><p><?php _e('Lightbox', EG_TEXTDOMAIN); ?></p></li>
				<li class="" data-toshow="esg-settings-ajax-settings"><i class="eg-icon-ccw-1"></i><p><?php _e('Ajax', EG_TEXTDOMAIN); ?></p></li>
				<li class="" data-toshow="esg-settings-spinner-settings"><i class="eg-icon-back-in-time"></i><p><?php _e('Spinner', EG_TEXTDOMAIN); ?></p></li>
				<li class="" data-toshow="esg-settings-api-settings"><i class="eg-icon-magic"></i><p><?php _e('API/JavaScript', EG_TEXTDOMAIN); ?></p></li>
				<li class="" data-toshow="esg-settings-cookie-settings"><i class="eg-icon-eye"></i><p><?php _e('Cookies', EG_TEXTDOMAIN); ?></p></li>
				<div class="clear"></div>
			</ul>
		 </div>

		<!--
		NAMING
		-->
		<div id="eg-create-settings" class="esg-settings-container active-esc">
			<div class="eg-creative-settings">
				<div class="eg-cs-tbc-left">
					<h3><span><?php _e('Naming', EG_TEXTDOMAIN); ?></span></h3>
				</div>
				<div class="eg-cs-tbc">
					<?php if($grid !== false){ ?>
					<input type="hidden" name="eg-id" value="<?php echo $grid['id']; ?>" />
					<?php } ?>

					<p><label for="name" class="eg-tooltip-wrap" title="<?php _e('Name of the grid', EG_TEXTDOMAIN); ?>"><?php _e('Title', EG_TEXTDOMAIN); ?></label> <input type="text" name="name"  value="<?php echo $base->getVar($grid, 'name', '', 's'); ?>" /> *</p>
					<p><label for="handle" class="eg-tooltip-wrap" title="<?php _e('Technical alias without special chars and white spaces', EG_TEXTDOMAIN); ?>"><?php _e('Alias', EG_TEXTDOMAIN); ?></label> <input type="text" name="handle"  value="<?php echo $base->getVar($grid, 'handle', '', 's'); ?>" /> *</p>
					<p><label for="shortcode" class="eg-tooltip-wrap" title="<?php _e('Copy this shortcode to paste it to your pages or posts content', EG_TEXTDOMAIN); ?>" ><?php _e('Shortcode', EG_TEXTDOMAIN); ?></label> <input type="text" name="shortcode" value="" readonly="readonly" /></p>
					<p><label for="id" class="eg-tooltip-wrap" title="<?php _e('Add a unique ID to be able to add CSS to certain Grids', EG_TEXTDOMAIN); ?>"><?php _e('CSS ID', EG_TEXTDOMAIN); ?></label> <input type="text" name="css-id" id="esg-id-value" value="<?php echo $base->getVar($grid['params'], 'css-id', '', 's'); ?>" /></p>
				</div>
			</div>
		</div>

		<!--
		SOURCE
		-->
		<div id="esg-settings-posts-settings" class="esg-settings-container">
			<div class="">
				<form id="eg-form-create-posts">
					<div class="eg-creative-settings">
						<div class="eg-cs-tbc-left">
							<h3><span><?php _e('Source', EG_TEXTDOMAIN); ?></span></h3>
						</div>
						<div class="eg-cs-tbc">
							<p>
								<label for="shortcode" class="eg-tooltip-wrap" title="<?php _e('Choose source of grid items', EG_TEXTDOMAIN); ?>"><?php _e('Based on', EG_TEXTDOMAIN); ?></label>
							</p>
							<p id="esg-source-choose-wrapper">
								<input type="radio" name="source-type" value="post" class="firstinput" <?php checked($base->getVar($grid['postparams'], 'source-type', 'post'), 'post'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('Items from Posts, Custom Posts', EG_TEXTDOMAIN); ?>"><?php _e('Post, Pages, Custom Posts', EG_TEXTDOMAIN); ?></span>
								<input type="radio" name="source-type" value="custom" <?php echo checked($base->getVar($grid['postparams'], 'source-type', 'post'), 'custom'); ?> > <span class="eg-tooltip-wrap" title="<?php _e('Items from the Media Gallery (Bulk Selection, Upload Possible)', EG_TEXTDOMAIN); ?>"><?php _e('Custom Grid (Editor Below)', EG_TEXTDOMAIN); ?></span>
								<input type="radio" name="source-type" value="stream" <?php echo checked($base->getVar($grid['postparams'], 'source-type', 'post'), 'stream'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('Fetches dynamic streams from several sources ', EG_TEXTDOMAIN); ?>"><?php _e('Stream', EG_TEXTDOMAIN); ?></span>
							</p>
						</div>

					</div>
					
					
					<div id="custom-sorting-wrap" style="display: none;">
						<ul id="esg-custom-li-sorter" style="margin:0px">							
						</ul>
					</div>
					<div id="post-pages-wrap">
					<div class="divider1"></div>
						<div class="eg-creative-settings">
							<div class="eg-cs-tbc-left">
								<h3><span><?php _e('Type and Category', EG_TEXTDOMAIN); ?></span></h3>
							</div>
							<div class="eg-cs-tbc">
								<p>
									<label for="post_types" class="eg-tooltip-wrap" title="<?php _e('Select Post Types (multiple selection possible)', EG_TEXTDOMAIN); ?>"><?php _e('Post Types', EG_TEXTDOMAIN); ?></label>
									<select name="post_types" size="5" multiple="multiple" >
										<?php
										$selectedPostTypes = array();
										$post_types = $base->getVar($grid['postparams'], 'post_types', 'post');
										if(!empty($post_types))
											$selectedPostTypes = explode(',',$post_types);
										else
											$selectedPostTypes = array('post');

										if(!empty($post_elements)){
											foreach($post_elements as $handle => $name){
												?>
												<option value="<?php echo $handle; ?>"<?php selected(in_array($handle, $selectedPostTypes), true); ?>><?php echo $name; ?></option>
												<?php
											}
										}
										?>
									</select>
								</p>

								<p id="eg-post-cat-wrap">
									<label for="source-code" class="eg-tooltip-wrap" title="<?php _e('Select Categories and Tags (multiple selection possible)', EG_TEXTDOMAIN); ?>"><?php _e('Post Categories', EG_TEXTDOMAIN); ?></label>
									<?php
									$postTypes = (strpos($postTypes, ",") !== false) ? explode(",",$postTypes) : $postTypes = array($postTypes);
									if(empty($postTypes)) $postTypes = array($postTypes);
									//change $postTypes to corresponding IDs depending on language
									//$postTypes = $base->translate_base_categories_to_cur_lang($postTypes);
									?>
									<select name="post_category" size="7" multiple="multiple" >
										<?php
										if($grid !== false){ //set the values
											if(!empty($categories)){
												
												foreach($categories as $handle => $cat){
													?>
													<option value="<?php echo $handle; ?>"<?php selected(in_array($handle, $postTypes), true); ?><?php echo (strpos($handle, 'option_disabled_') !== false) ? ' disabled="disabled"' : ''; ?>><?php echo $cat; ?></option>
													<?php
												}
											}
										}else{
											if(!empty($postTypesWithCats['post'])){
												
												foreach($postTypesWithCats['post'] as $handle => $cat){
													?>
													<option value="<?php echo $handle; ?>"<?php selected(in_array($handle, $postTypes), true); ?><?php echo (strpos($handle, 'option_disabled_') !== false) ? ' disabled="disabled"' : ''; ?>><?php echo $cat; ?></option>
													<?php
												}
											}
										}
										?>
									</select>
								</p>
								<p>
									<div style="float: left"><label>&nbsp;</label></div><a class="button-primary revblue eg-clear-taxonomies" href="javascript:void(0);"><?php _e('Clear Categories', EG_TEXTDOMAIN); ?></a>
								</p>
								<p>
									<div style="float: left"><label for="category-relation"><?php _e('Category Relation', EG_TEXTDOMAIN); ?></label></div>
									<div style="float: left">
										<input type="radio" value="OR" name="category-relation" <?php checked($base->getVar($grid['postparams'], 'category-relation', 'OR'), 'OR'); ?> class="firstinput"> <span class="eg-tooltip-wrap" title="<?php _e('Post need to be in one of the selected categories/tags', EG_TEXTDOMAIN); ?>"><?php _e('OR', EG_TEXTDOMAIN); ?></span>
										<input type="radio" value="AND" name="category-relation" <?php checked($base->getVar($grid['postparams'], 'category-relation', 'OR'), 'AND'); ?> > <span class="eg-tooltip-wrap" title="<?php _e('Post need to be in all categories/tags selected', EG_TEXTDOMAIN); ?>"><?php _e('AND', EG_TEXTDOMAIN); ?></span>
									</div>
									<div style="clear: both;"></div>
								</p>
								<div id="eg-additional-post">
									<div style="float: left"><label for="additional-query" class="eg-tooltip-wrap" title="<?php _e('Please use it like \'year=2012&monthnum=12\'', EG_TEXTDOMAIN); ?>"><?php _e('Additional Parameters', EG_TEXTDOMAIN); ?></label></div>
									<div style="float: left">
										<input type="text" name="additional-query" class="eg-additional-parameters" value="<?php echo $base->getVar($grid['postparams'], 'additional-query', ''); ?>" />
										<p><?php _e('Please use it like \'year=2012&monthnum=12\' or \'post__in=array(1,2,5)&post__not_in=array(25,10)\'', EG_TEXTDOMAIN); ?>&nbsp;-&nbsp;
										<?php _e('For a full list of parameters, please visit <a href="https://codex.wordpress.org/Class_Reference/WP_Query" target="_blank">this</a> link', EG_TEXTDOMAIN); ?></p>
									</div>
									<div style="clear: both"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="divider1"></div>
					<div id="set-pages-wrap">
						<div class="eg-creative-settings">
							<div class="eg-cs-tbc-left">
								<h3><span><?php _e('Pages', EG_TEXTDOMAIN); ?></span></h3>
							</div>
							<div class="eg-cs-tbc">
								<p>
								<label for="pages" class="eg-tooltip-wrap" title="<?php _e('Additional filtering on pages,Start to type a page title for pre selection', EG_TEXTDOMAIN); ?>"><?php _e('Select Pages', EG_TEXTDOMAIN); ?></label>
								<input type="text" id="pages" value="" name="search_pages"> <a class="button-secondary" id="button-add-pages" href="javascript:void(0);">+</a>
								</p>
								<div id="pages-wrap">
									<?php
									if(!empty($pages)){
										foreach($pages as $page){
											if(in_array($page->ID, $selected_pages)){
												?>
												<div data-id="<?php echo $page->ID; ?>"><?php echo str_replace('"', '', $page->post_title).' (ID: '.$page->ID.')'; ?> <i class="eg-icon-trash del-page-entry"></i></div>
												<?php
											}
										}
									}
									?>
								</div>
								<select name="selected_pages" multiple="true" style="display: none;">
									<?php
									if(!empty($pages)){
										foreach($pages as $page){
											?>
											<option value="<?php echo $page->ID; ?>"<?php selected(in_array($page->ID, $selected_pages), true); ?>><?php echo str_replace('"', '', $page->post_title).' (ID: '.$page->ID.')'; ?></option>
											<?php
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="divider1"></div>
					</div>
					
					<div id="aditional-pages-wrap">
						<div class="eg-creative-settings">
							<div class="eg-cs-tbc-left">
								<h3><span><?php _e('Options', EG_TEXTDOMAIN); ?></span></h3>
							</div>
							<div class="eg-cs-tbc">
								<?php
								$max_entries = intval($base->getVar($grid['postparams'], 'max_entries', '-1'));
								?>
								<p>
									<label for="pages" class="eg-tooltip-wrap" title="<?php _e('Defines a entry limit, use only numbers, -1 will disable this option, use only numbers', EG_TEXTDOMAIN); ?>"><?php _e('Maximum Entries', EG_TEXTDOMAIN); ?></label>
									<input type="text" value="<?php echo $max_entries; ?>" name="max_entries">
								</p>
							</div>
						</div>
						<div class="divider1"></div>
					</div>
					
					<div id="all-stream-wrap">
						<div id="external-stream-wrap">
							<div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">
									<h3><span><?php _e('Service', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
									<label for="shortcode" class="eg-tooltip-wrap" title="<?php _e('Choose source of grid items', EG_TEXTDOMAIN); ?>"><?php _e('Provider', EG_TEXTDOMAIN); ?></label>
									</p>
									<p id="esg-source-choose-wrapper">
										<input type="radio" name="stream-source-type" value="youtube" class="firstinput" <?php checked($base->getVar($grid['postparams'], 'stream-source-type', 'instagram'), 'youtube'); ?>><span class="inplabel"><?php _e('YouTube', EG_TEXTDOMAIN); ?></span>
										<input type="radio" name="stream-source-type" value="vimeo" <?php checked($base->getVar($grid['postparams'], 'stream-source-type', 'instagram'), 'vimeo'); ?>><span class="inplabel"><?php _e('Vimeo', EG_TEXTDOMAIN); ?></span>
										<input type="radio" name="stream-source-type" value="instagram" <?php checked($base->getVar($grid['postparams'], 'stream-source-type', 'instagram'), 'instagram'); ?>><span class="inplabel"><?php _e('Instagram', EG_TEXTDOMAIN); ?></span>
										<input type="radio" name="stream-source-type" value="flickr" <?php checked($base->getVar($grid['postparams'], 'stream-source-type', 'instagram'), 'flickr'); ?>><span class="inplabel"><?php _e('Flickr', EG_TEXTDOMAIN); ?></span>
										<input type="radio" name="stream-source-type" value="facebook" <?php checked($base->getVar($grid['postparams'], 'stream-source-type', 'instagram'), 'facebook'); ?>><span class="inplabel"><?php _e('Facebook', EG_TEXTDOMAIN); ?></span>
										<input type="radio" name="stream-source-type" value="twitter" <?php checked($base->getVar($grid['postparams'], 'stream-source-type', 'instagram'), 'twitter'); ?>><span class="inplabel"><?php _e('Twitter', EG_TEXTDOMAIN); ?></span>
										
									</p>
									<p id="eg-source-youtube-message">
										<span class="description"><?php _e('The "YouTube Stream" content source is used to display a full stream of videos from a channel/playlist.', EG_TEXTDOMAIN); ?></span>
									</p>
									<p id="eg-source-vimeo-message">
										<span class="description"><?php _e('The "Vimeo Stream" content source is used to display a full stream of videos from a user/album/group/channel.', EG_TEXTDOMAIN); ?></span>
									</p>
								</div>
							</div>
							<div class="divider1"></div>
						</div>

						<div id="youtube-external-stream-wrap">
							<div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">	
									<h3><span><?php _e('API', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Put in the YouTube API key', EG_TEXTDOMAIN); ?>"><?php _e('API Key', EG_TEXTDOMAIN); ?></label>
										<input type="text" value="<?php echo $base->getVar($grid['postparams'], 'youtube-api', ''); ?>" name="youtube-api" id="youtube-api">						
										<div class="tp-clearfix"></div>
										<span class="description"><?php _e('Find information about the YouTube API key <a target="_blank" href="https://developers.google.com/youtube/v3/getting-started#before-you-start">here</a>', EG_TEXTDOMAIN); ?></span>
									</p>
								</div>		
							</div>
							<div class="divider1"></div>
							<div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">	
									<h3><span><?php _e('Stream', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
										<label  class="eg-new-label eg-tooltip-wrap" title="<?php _e('Put in the ID of the YouTube channel', EG_TEXTDOMAIN); ?>"><?php _e('Channel ID', EG_TEXTDOMAIN); ?></label>
										<input type="text" style="margin-right:10px" value="<?php echo $base->getVar($grid['postparams'], 'youtube-channel-id', ''); ?>" name="youtube-channel-id" id="youtube-channel-id">
										<span class="description"><?php _e('See how to find the Youtube channel ID <a target="_blank" href="https://support.google.com/youtube/answer/3250431?hl=en">here</a>', EG_TEXTDOMAIN); ?></span>
									</p>
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Display the channel videos or playlist', EG_TEXTDOMAIN); ?>"><?php _e('Source', EG_TEXTDOMAIN); ?></label>
										<input type="radio" name="youtube-type-source" value="channel" class="firstinput" <?php checked($base->getVar($grid['postparams'], 'youtube-type-source', 'channel'), 'channel'); ?>><span class="inplabel"><?php _e('Channel', EG_TEXTDOMAIN); ?></span>
										<input type="radio" name="youtube-type-source" value="playlist_overview" <?php checked($base->getVar($grid['postparams'], 'youtube-type-source', 'channel'), 'playlist_overview'); ?> > <span class="inplabel"><?php _e('Overview Playlists', EG_TEXTDOMAIN); ?></span>
										<input type="radio" name="youtube-type-source" value="playlist" <?php checked($base->getVar($grid['postparams'], 'youtube-type-source', 'channel'), 'playlist'); ?> > <span class="inplabel"><?php _e('Single Playlist', EG_TEXTDOMAIN); ?></span>
									</p>
									<div id="eg-external-source-youtube-playlist-wrap">
										<p>
											<?php $youtube_playlist = $base->getVar($grid['postparams'], 'youtube-playlist', '');?>
											<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Select the playlist you want to pull the data from', EG_TEXTDOMAIN); ?>"><?php _e('Select Playlist', EG_TEXTDOMAIN); ?></label>
											<input type="hidden" name="youtube-playlist" value="<?php echo $youtube_playlist; ?>">
											<select name="youtube-playlist-select" id="youtube-playlist-select">
											</select>	
										</p>
									</div>	
								</div>
							</div>
							<div class="divider1"></div>
							<div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">
									<h3><span><?php _e('Image Sizes', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('For images that appear inside the Grid Items', EG_TEXTDOMAIN); ?>"><?php _e('Grid Image Size', EG_TEXTDOMAIN); ?></label>
									</p>
									<p>
										<select name="youtube-thumb-size">
											<option value='default' <?php selected( $base->getVar($grid['postparams'], 'youtube-thumb-size', 'default'), 'default');?>><?php _e('Default (120px)', EG_TEXTDOMAIN);?></option>
											<option value='medium' <?php selected( $base->getVar($grid['postparams'], 'youtube-thumb-size', 'default'), 'medium');?>><?php _e('Medium (320px)', EG_TEXTDOMAIN);?></option>
											<option value='high' <?php selected( $base->getVar($grid['postparams'], 'youtube-thumb-size', 'default'), 'high');?>><?php _e('High (480px)', EG_TEXTDOMAIN);?></option>
											<option value='standard' <?php selected( $base->getVar($grid['postparams'], 'youtube-thumb-size', 'default'), 'standard');?>><?php _e('Standard (640px)', EG_TEXTDOMAIN);?></option>
											<option value='maxres' <?php selected( $base->getVar($grid['postparams'], 'youtube-thumb-size', 'default'), 'maxres');?>><?php _e('Max. Res. (1280px)', EG_TEXTDOMAIN);?></option>
										</select>
									</p>
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('For images that appear inside the lightbox, links, etc.', EG_TEXTDOMAIN); ?>"><?php _e('Full Image Size', EG_TEXTDOMAIN); ?></label>
									</p>
									<p>
										<select name="youtube-full-size">
											<option value='default' <?php selected( $base->getVar($grid['postparams'], 'youtube-full-size', 'default'), 'default');?>><?php _e('Default (120px)', EG_TEXTDOMAIN);?></option>
											<option value='medium' <?php selected( $base->getVar($grid['postparams'], 'youtube-full-size', 'default'), 'medium');?>><?php _e('Medium (320px)', EG_TEXTDOMAIN);?></option>
											<option value='high' <?php selected( $base->getVar($grid['postparams'], 'youtube-full-size', 'default'), 'high');?>><?php _e('High (480px)', EG_TEXTDOMAIN);?></option>
											<option value='standard' <?php selected( $base->getVar($grid['postparams'], 'youtube-full-size', 'default'), 'standard');?>><?php _e('Standard (640px)', EG_TEXTDOMAIN);?></option>
											<option value='maxres' <?php selected( $base->getVar($grid['postparams'], 'youtube-full-size', 'default'), 'maxres');?>><?php _e('Max. Res. (1280px)', EG_TEXTDOMAIN);?></option>
										</select>
									</p>
								</div>
							</div>
							<div class="divider1"></div>
							<div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">
									<h3><span><?php _e('Details', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Stream this number of videos', EG_TEXTDOMAIN); ?>"><?php _e('Count', EG_TEXTDOMAIN); ?></label>
									</p>
									<p>
										<input type="number" value="<?php echo $base->getVar($grid['postparams'], 'youtube-count', '12'); ?>" name="youtube-count">
									</p>
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Keep stream result cached (recommended)', EG_TEXTDOMAIN); ?>"><?php _e('Stream Cache (sec)', EG_TEXTDOMAIN); ?></label>
									</p>
									<p class="cachenumbercheck">
										<input id="youtube-transient-sec" type="number" value="<?php echo $base->getVar($grid['postparams'], 'youtube-transient-sec', '86400'); ?>" name="youtube-transient-sec">&nbsp;<a style="margin-right:10px" id="clear_cache_youtube"  class="button-primary revblue eg-clear-cache" href="javascript:void(0);" data-clear="youtube-transient-sec">Clear Cache</a>
										<span style="margin-left:10px" class="importantlabel showonsmallcache description"><?php _e('Small cache intervals may influnce the loading times negatively.', EG_TEXTDOMAIN); ?></span>										
									</p>
								</div>
							</div>
							<div class="divider1"></div>
						</div> <!-- End YouTube Stream -->

						<div id="vimeo-external-stream-wrap">
							<div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">
									<h3><span><?php _e('Stream', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Source of Vimeo videos', EG_TEXTDOMAIN); ?>"><?php _e('Videos of', EG_TEXTDOMAIN); ?></label>
										<input type="radio" name="vimeo-type-source" value="user" class="firstinput" <?php checked($base->getVar($grid['postparams'], 'vimeo-type-source', 'user'), 'user'); ?>><span class="inplabel"><?php _e('User', EG_TEXTDOMAIN); ?></span>
										<input type="radio" name="vimeo-type-source" value="album" <?php checked($base->getVar($grid['postparams'], 'vimeo-type-source', 'user'), 'album'); ?>><span class="inplabel"><?php _e('Album', EG_TEXTDOMAIN); ?></span>							
										<input type="radio" name="vimeo-type-source" value="group" <?php checked($base->getVar($grid['postparams'], 'vimeo-type-source', 'user'), 'group'); ?>><span class="inplabel"><?php _e('Group', EG_TEXTDOMAIN); ?>	</span>
										<input type="radio" name="vimeo-type-source" value="channel" <?php checked($base->getVar($grid['postparams'], 'vimeo-type-source', 'user'), 'channel'); ?>><span class="inplabel"><?php _e('Channel', EG_TEXTDOMAIN); ?></span>
									</p>
									
									<p>
										<div id="eg-external-source-vimeo-user-wrap" class="eg-external-source-vimeo">						
											<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('ID of the user', EG_TEXTDOMAIN); ?>"><?php _e('User', EG_TEXTDOMAIN); ?></label>
											<input type="text" value="<?php echo $base->getVar($grid['postparams'], 'vimeo-username', ''); ?>" name="vimeo-username">						
										</div>
										<div id="eg-external-source-vimeo-group-wrap" class="eg-external-source-vimeo">					
											<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('ID of the group', EG_TEXTDOMAIN); ?>"><?php _e('Group', EG_TEXTDOMAIN); ?></label>
											<input type="text" value="<?php echo $base->getVar($grid['postparams'], 'vimeo-groupname', ''); ?>" name="vimeo-groupname">						
										</div>
										<div id="eg-external-source-vimeo-album-wrap" class="eg-external-source-vimeo">						
											<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('The ID of the album', EG_TEXTDOMAIN); ?>"><?php _e('Album ID', EG_TEXTDOMAIN); ?></label>
											<input type="text" value="<?php echo $base->getVar($grid['postparams'], 'vimeo-albumid', ''); ?>" name="vimeo-albumid">					
										</div>
										<div id="eg-external-source-vimeo-channel-wrap" class="eg-external-source-vimeo">						
											<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('ID of the channel', EG_TEXTDOMAIN); ?>"><?php _e('Channel', EG_TEXTDOMAIN); ?></label>
											<input type="text" value="<?php echo $base->getVar($grid['postparams'], 'vimeo-channelname', ''); ?>" name="vimeo-channelname">						
										</div>
									</p>
								</div>
							</div>
							<div class="divider1"></div>
							<div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">
									<h3><span><?php _e('Image Sizes', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('For images that appear inside the Grid Items', EG_TEXTDOMAIN); ?>"><?php _e('Grid Image Size', EG_TEXTDOMAIN); ?></label>
									</p>
									<p>
										<select name="vimeo-thumb-size">
											<option value='thumbnail_small' <?php selected( $base->getVar($grid['postparams'], 'vimeo-thumb-size', 'thumbnail_small'), 'thumbnail_small');?>><?php _e('Small (100px)', EG_TEXTDOMAIN);?></option>
											<option value='thumbnail_medium' <?php selected( $base->getVar($grid['postparams'], 'vimeo-thumb-size', 'thumbnail_small'), 'thumbnail_medium');?>><?php _e('Medium (200px)', EG_TEXTDOMAIN);?></option>
											<option value='thumbnail_large' <?php selected( $base->getVar($grid['postparams'], 'vimeo-thumb-size', 'thumbnail_small'), 'thumbnail_large');?>><?php _e('Large (640px)', EG_TEXTDOMAIN);?></option>
										</select>
									</p>
								</div>
							</div>
							<div class="divider1"></div>
							<div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">
									<h3><span><?php _e('Details', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Display this number of videos', EG_TEXTDOMAIN); ?>"><?php _e('Count', EG_TEXTDOMAIN); ?></label>
									</p>
									<p>
										<input type="number" value="<?php echo $base->getVar($grid['postparams'], 'vimeo-count', '12'); ?>" name="vimeo-count">
									</p>
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Keep stream result cached (recommended)', EG_TEXTDOMAIN); ?>"><?php _e('Stream Cache (sec)', EG_TEXTDOMAIN); ?></label>
									</p>
									<p class="cachenumbercheck">
										<input type="number" value="<?php echo $base->getVar($grid['postparams'], 'vimeo-transient-sec', '86400'); ?>" name="vimeo-transient-sec">&nbsp;<a style="margin-right:10px" id="clear_cache_vimeo"  class="button-primary revblue eg-clear-cache" href="javascript:void(0);" data-clear="vimeo-transient-sec">Clear Cache</a>
										<span style="margin-left:10px" class="importantlabel showonsmallcache description"><?php _e('Small cache intervals may influnce the loading times negatively.', EG_TEXTDOMAIN); ?></span>	
									</p>
								</div>
							</div>
							<div class="divider1"></div>
						</div><!-- End Vimeo Stream -->

						<div id="instagram-external-stream-wrap">
							<div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">
									<h3><span><?php _e('Stream', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Put in the Instagram User', EG_TEXTDOMAIN); ?>"><?php _e('Instagram User', EG_TEXTDOMAIN); ?></label>
										<input type="text" value="<?php echo $base->getVar($grid['postparams'], 'instagram-user-id', ''); ?>" name="instagram-user-id">
									</p>
								</div>
							</div>
							<div class="divider1"></div>
							<div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">
									<h3><span><?php _e('Image Sizes', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('For images that appear inside the Grid Items', EG_TEXTDOMAIN); ?>"><?php _e('Grid Image Size', EG_TEXTDOMAIN); ?></label>
									</p>
									<p>
										<select name="instagram-thumb-size">
											<option value='Thumbnail' <?php selected( $base->getVar($grid['postparams'], 'instagram-thumb-size', 'Low Resolution'), 'Thumbnail');?>><?php _e('Thumbnail (150px)', EG_TEXTDOMAIN);?></option>
											<option value='Low Resolution' <?php selected( $base->getVar($grid['postparams'], 'instagram-thumb-size', 'Low Resolution'), 'Low Resolution');?>><?php _e('Low Resolution (320px)', EG_TEXTDOMAIN);?></option>
											<option value='Standard Resolution' <?php selected( $base->getVar($grid['postparams'], 'instagram-thumb-size', 'Low Resolution'), 'Standard Resolution');?>><?php _e('Standard Resolution (640px)', EG_TEXTDOMAIN);?></option>
										</select>
									</p>
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('For images that appear inside the lightbox, links, etc.', EG_TEXTDOMAIN); ?>"><?php _e('Full Image Size', EG_TEXTDOMAIN); ?></label>
									</p>
									<p>
										<select name="instagram-full-size">
											<option value='Thumbnail' <?php selected( $base->getVar($grid['postparams'], 'instagram-full-size', 'Standard Resolution'), 'Thumbnail');?>><?php _e('Thumbnail (150px)', EG_TEXTDOMAIN);?></option>
											<option value='Low Resolution' <?php selected( $base->getVar($grid['postparams'], 'instagram-full-size', 'Standard Resolution'), 'Low Resolution');?>><?php _e('Low Resolution (320px)', EG_TEXTDOMAIN);?></option>
											<option value='Standard Resolution' <?php selected( $base->getVar($grid['postparams'], 'instagram-full-size', 'Standard Resolution'), 'Standard Resolution');?>><?php _e('Standard Resolution (640px)', EG_TEXTDOMAIN);?></option>
										</select>
									</p>
								</div>
							</div>
							<div class="divider1"></div>
							<div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">
									<h3><span><?php _e('Details', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Display this number of photos', EG_TEXTDOMAIN); ?>"><?php _e('Count', EG_TEXTDOMAIN); ?></label>
									</p>
									<p>
										<input type="number" value="<?php echo $base->getVar($grid['postparams'], 'instagram-count', '12'); ?>" name="instagram-count">
									</p>
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Keep stream result cached (recommended)', EG_TEXTDOMAIN); ?>"><?php _e('Stream Cache (sec)', EG_TEXTDOMAIN); ?></label>
									</p>
									<p class="cachenumbercheck">
										<input type="number" value="<?php echo $base->getVar($grid['postparams'], 'instagram-transient-sec', '86400'); ?>" name="instagram-transient-sec">&nbsp;<a style="margin-right:10px" id="clear_cache_instagram"  class="button-primary revblue eg-clear-cache" href="javascript:void(0);" data-clear="instagram-transient-sec">Clear Cache</a>
										<span style="margin-left:10px" class="importantlabel showonsmallcache description"><?php _e('Small cache intervals may influnce the loading times negatively.', EG_TEXTDOMAIN); ?></span>	
									</p>
								</div>
							</div>
							<div class="divider1"></div>
						</div><!-- End Instagram Stream -->

						<div id="flickr-external-stream-wrap">
							<div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">
									<h3><span><?php _e('API', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Put in your Flickr API Key', EG_TEXTDOMAIN); ?>"><?php _e('Flickr API Key', EG_TEXTDOMAIN); ?></label>
									</p>
									<p>
										<input style="margin-right:10px" type="text" value="<?php echo $base->getVar($grid['postparams'], 'flickr-api-key', ''); ?>" name="flickr-api-key">	
										<span class="description"><?php _e('Read <a target="_blank" href="http://weblizar.com/get-flickr-api-key/">here</a> how to get your Flickr API key', EG_TEXTDOMAIN); ?></span>
									</p>
								</div>
							</div>
							<div class="divider1"></div>
							<div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">
									<h3><span><?php _e('Stream', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Select the flickr streaming source?', EG_TEXTDOMAIN); ?>"><?php _e('Source', EG_TEXTDOMAIN); ?></label>
									</p>
									<p>
										<span class="inplabel"><input type="radio" name="flickr-type" value="publicphotos" class="firstinput" <?php checked($base->getVar($grid['postparams'], 'flickr-type', 'publicphotos'), 'publicphotos'); ?>> <?php _e('User Public Photos', EG_TEXTDOMAIN); ?></span>
										<span class="inplabel"><input type="radio" name="flickr-type" value="photosets" <?php checked($base->getVar($grid['postparams'], 'flickr-type', 'publicphotos'), 'photosets'); ?>> <?php _e('User Photoset', EG_TEXTDOMAIN); ?></span>										
										<span class="inplabel"><input type="radio" name="flickr-type" value="gallery" <?php checked($base->getVar($grid['postparams'], 'flickr-type', 'publicphotos'), 'gallery'); ?>> <?php _e('Gallery', EG_TEXTDOMAIN); ?></span>
										<span class="inplabel"><input type="radio" name="flickr-type" value="group" <?php checked($base->getVar($grid['postparams'], 'flickr-type', 'publicphotos'), 'group'); ?>> <?php _e('Groups\' Photos', EG_TEXTDOMAIN); ?></span>
									</p>
									<div id="eg-external-source-flickr-sources">
										<div id="eg-external-source-flickr-publicphotos-url-wrap">
											<p>
												<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Put the URL of the flickr User', EG_TEXTDOMAIN); ?>"><?php _e('Flickr User Url', EG_TEXTDOMAIN); ?></label>
												<input type="text" value="<?php echo $base->getVar($grid['postparams'], 'flickr-user-url'); ?>" name="flickr-user-url">
											</p>
										</div>
										<div id="eg-external-source-flickr-photosets-wrap">
											<p>
													<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Select the photoset you want to pull the data from', EG_TEXTDOMAIN); ?>"><?php _e('Select Photoset', EG_TEXTDOMAIN); ?></label>
													<input type="hidden" name="flickr-photoset" value="<?php echo $base->getVar($grid['postparams'], 'flickr-photoset', ''); ?>">
													<select name="flickr-photoset-select">
													</select>
											</p>
										</div>
										<div id="eg-external-source-flickr-gallery-url-wrap">
											<p>
												<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Put the URL of the flickr Gallery', EG_TEXTDOMAIN); ?>"><?php _e('Flickr Gallery Url', EG_TEXTDOMAIN); ?></label>
												<input type="text" value="<?php echo $base->getVar($grid['postparams'], 'flickr-gallery-url'); ?>" name="flickr-gallery-url">
											</p>
										</div>
										<div id="eg-external-source-flickr-group-url-wrap">
											<p>
												<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Put the URL of the flickr Group', EG_TEXTDOMAIN); ?>"><?php _e('Flickr Group Url', EG_TEXTDOMAIN); ?></label>
												<input type="text" value="<?php echo $base->getVar($grid['postparams'], 'flickr-group-url'); ?>" name="flickr-group-url">
											</p>
										</div>
									</div>
								</div>
							</div>
							<div class="divider1"></div>
							<div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">
									<h3><span><?php _e('Image Sizes', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('For images that appear inside the Grid Items', EG_TEXTDOMAIN); ?>"><?php _e('Grid Image Size', EG_TEXTDOMAIN); ?></label>
									</p>
									<p>
										<select name="flickr-thumb-size">
											<option value='Square' <?php selected( $base->getVar($grid['postparams'], 'flickr-thumb-size', 'Small 320'), 'Square');?>><?php _e('Square (75px)', EG_TEXTDOMAIN);?></option>
											<option value='Large Square' <?php selected( $base->getVar($grid['postparams'], 'flickr-thumb-size', 'Small 320'), 'Large Square');?>><?php _e('Large Square (150px)', EG_TEXTDOMAIN);?></option>
											<option value='Thumbnail' <?php selected( $base->getVar($grid['postparams'], 'flickr-thumb-size', 'Small 320'), 'Thumbnail');?>><?php _e('Thumbnail (100px)', EG_TEXTDOMAIN);?></option>
											<option value='Small' <?php selected( $base->getVar($grid['postparams'], 'flickr-thumb-size', 'Small 320'), 'Small');?>><?php _e('Small (240px)', EG_TEXTDOMAIN);?></option>
											<option value='Small 320' <?php selected( $base->getVar($grid['postparams'], 'flickr-thumb-size', 'Small 320'), 'Small 320');?>><?php _e('Small (320px)', EG_TEXTDOMAIN);?></option>
											<option value='Medium' <?php selected( $base->getVar($grid['postparams'], 'flickr-thumb-size', 'Small 320'), 'Medium');?>><?php _e('Medium (500px)', EG_TEXTDOMAIN);?></option>
											<option value='Medium 640' <?php selected( $base->getVar($grid['postparams'], 'flickr-thumb-size', 'Small 320'), 'Medium 640');?>><?php _e('Medium (640px)', EG_TEXTDOMAIN);?></option>
											<option value='Medium 800' <?php selected( $base->getVar($grid['postparams'], 'flickr-thumb-size', 'Small 320'), 'Medium 800');?>><?php _e('Medium (800px)', EG_TEXTDOMAIN);?></option>
											<option value='Large' <?php selected( $base->getVar($grid['postparams'], 'flickr-thumb-size', 'Small 320'), 'Large');?>><?php _e('Large (1024px)', EG_TEXTDOMAIN);?></option>
											<option value='Original' <?php selected( $base->getVar($grid['postparams'], 'flickr-thumb-size', 'Small 320'), 'Original');?>><?php _e('Original', EG_TEXTDOMAIN);?></option>
										</select>
									</p>
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('For images that appear inside the lightbox, links, etc.', EG_TEXTDOMAIN); ?>"><?php _e('Full Image Size', EG_TEXTDOMAIN); ?></label>
									</p>
									<p>
										<select name="flickr-full-size">
											<option value='Square' <?php selected( $base->getVar($grid['postparams'], 'flickr-full-size', 'Medium 800'), 'Square');?>><?php _e('Square (75px)', EG_TEXTDOMAIN);?></option>
											<option value='Large Square' <?php selected( $base->getVar($grid['postparams'], 'flickr-full-size', 'Medium 800'), 'Large Square');?>><?php _e('Large Square (150px)', EG_TEXTDOMAIN);?></option>
											<option value='Thumbnail' <?php selected( $base->getVar($grid['postparams'], 'flickr-full-size', 'Medium 800'), 'Thumbnail');?>><?php _e('Thumbnail (100px)', EG_TEXTDOMAIN);?></option>
											<option value='Small' <?php selected( $base->getVar($grid['postparams'], 'flickr-full-size', 'Medium 800'), 'Small');?>><?php _e('Small (240px)', EG_TEXTDOMAIN);?></option>
											<option value='Small 320' <?php selected( $base->getVar($grid['postparams'], 'flickr-full-size', 'Medium 800'), 'Small 320');?>><?php _e('Small (320px)', EG_TEXTDOMAIN);?></option>
											<option value='Medium' <?php selected( $base->getVar($grid['postparams'], 'flickr-full-size', 'Medium 800'), 'Medium');?>><?php _e('Medium (500px)', EG_TEXTDOMAIN);?></option>
											<option value='Medium 640' <?php selected( $base->getVar($grid['postparams'], 'flickr-full-size', 'Medium 800'), 'Medium 640');?>><?php _e('Medium (640px)', EG_TEXTDOMAIN);?></option>
											<option value='Medium 800' <?php selected( $base->getVar($grid['postparams'], 'flickr-full-size', 'Medium 800'), 'Medium 800');?>><?php _e('Medium (800px)', EG_TEXTDOMAIN);?></option>
											<option value='Large' <?php selected( $base->getVar($grid['postparams'], 'flickr-full-size', 'Medium 800'), 'Large');?>><?php _e('Large (1024px)', EG_TEXTDOMAIN);?></option>
											<option value='Original' <?php selected( $base->getVar($grid['postparams'], 'flickr-full-size', 'Medium 800'), 'Original');?>><?php _e('Original', EG_TEXTDOMAIN);?></option>
										</select>
									</p>
								</div>
							</div>
							<div class="divider1"></div>
							<div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">
									<h3><span><?php _e('Details', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Stream this number of photos', EG_TEXTDOMAIN); ?>"><?php _e('Count', EG_TEXTDOMAIN); ?></label>
									</p>
									<p>
										<input type="number" value="<?php echo $base->getVar($grid['postparams'], 'flickr-count', '12'); ?>" name="flickr-count">
									</p>
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Keep stream result cached (recommended)', EG_TEXTDOMAIN); ?>"><?php _e('Stream Cache (sec)', EG_TEXTDOMAIN); ?></label>
									</p>
									<p class="cachenumbercheck">
										<input type="number" value="<?php echo $base->getVar($grid['postparams'], 'flickr-transient-sec', '86400'); ?>" name="flickr-transient-sec">&nbsp;<a style="margin-right:10px" id="clear_cache_flickr"  class="button-primary revblue eg-clear-cache" href="javascript:void(0);" data-clear="flickr-transient-sec">Clear Cache</a>
										<span style="margin-left:10px" class="importantlabel showonsmallcache description"><?php _e('Small cache intervals may influnce the loading times negatively.', EG_TEXTDOMAIN); ?></span>	
									</p>
								</div>
							</div>
							<div class="divider1"></div>
						</div><!-- End Flickr Stream -->

						<div id="facebook-external-stream-wrap">
							<div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">	
									<h3><span><?php _e('API', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Put in the Facebook app id', EG_TEXTDOMAIN); ?>"><?php _e('App ID', EG_TEXTDOMAIN); ?></label>
										<input type="text" value="<?php echo $base->getVar($grid['postparams'], 'facebook-app-id', '') ?>" name="facebook-app-id">
									</p>
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Put in the Facebook app secret', EG_TEXTDOMAIN); ?>"><?php _e('App Secret', EG_TEXTDOMAIN); ?></label>
										<input type="text" style="margin-right:10px" value="<?php echo $base->getVar($grid['postparams'], 'facebook-app-secret', '') ?>" name="facebook-app-secret">						
										<span class="description"><?php _e('Please <a target="_blank" href="https://developers.facebook.com/docs/apps/register">register</a> your Website app with Facebook to get these values.', EG_TEXTDOMAIN); ?></span>
									</p>
								</div>
							</div>
							<div class="divider1"></div>
							<div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">
									<h3><span><?php _e('Stream', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
										<?php $facebook_page_url = $base->getVar($grid['postparams'], 'facebook-page-url', ''); ?>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Put in the URL/ID of the Facebook page', EG_TEXTDOMAIN); ?>"><?php _e('Facebook Page', EG_TEXTDOMAIN); ?></label>
										<input style="margin-right:10px"  type="text" value="<?php echo $facebook_page_url; ?>" name="facebook-page-url" id="eg-facebook-page-url">
										<span class="description"><?php _e('Please enter the Page Name of a public Facebook Page (no personal profile).', EG_TEXTDOMAIN); ?></span>
									</p>
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Display a pages photo album or timeline', EG_TEXTDOMAIN); ?>"><?php _e('Source', EG_TEXTDOMAIN); ?></label>
										<input type="radio" name="facebook-type-source" value="album" class="firstinput" <?php checked($base->getVar($grid['postparams'], 'facebook-type-source', 'timeline'), 'album'); ?> > <span class="inplabel"><?php _e('Album', EG_TEXTDOMAIN); ?></span>
										<input type="radio" name="facebook-type-source" value="timeline" <?php checked($base->getVar($grid['postparams'], 'facebook-type-source', 'timeline'), 'timeline'); ?> > <span class="inplabel"><?php _e('Timeline', EG_TEXTDOMAIN); ?>	</span>
									</p>
									<div id="eg-external-source-facebook-album-wrap">
										<p>
											<?php $facebook_album = $base->getVar($grid['postparams'], 'facebook-album', '');?>
											<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Select the album you want to pull the data from', EG_TEXTDOMAIN); ?>"><?php _e('Select Album', EG_TEXTDOMAIN); ?></label>
											<input type="hidden" name="facebook-album" value="<?php echo $facebook_album; ?>">
											<select name="facebook-album-select">
											</select>									
										</p>
									</div>
								</div>
							</div>
							<div class="divider1"></div>
							<!--div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">
									<h3><span><?php _e('Image Sizes', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('For images that appear inside the Grid Items', EG_TEXTDOMAIN); ?>"><?php _e('Grid Image Size', EG_TEXTDOMAIN); ?></label>
									</p>
									<p>
										<select name="facebook-thumb-size">
											<option value='0' <?php selected( $base->getVar($grid['postparams'], 'facebook-thumb-size', '0'), 'Preview');?>><?php _e('130x130px', EG_TEXTDOMAIN);?></option>
											<option value='1' <?php selected( $base->getVar($grid['postparams'], 'facebook-thumb-size', '1'), 'Preview');?>><?php _e('480x480px', EG_TEXTDOMAIN);?></option>
											<option value='2' <?php selected( $base->getVar($grid['postparams'], 'facebook-thumb-size', '2'), 'Preview');?>><?php _e('720x720px', EG_TEXTDOMAIN);?></option>
											<option value='Preview' <?php selected( $base->getVar($grid['postparams'], 'facebook-thumb-size', 'Preview'), 'Preview');?>><?php _e('Preview', EG_TEXTDOMAIN);?></option>
											<option value='3' <?php selected( $base->getVar($grid['postparams'], 'facebook-thumb-size', '3'), 'Preview');?>><?php _e('Full', EG_TEXTDOMAIN);?></option>
										</select>
									</p>
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('For images that appear inside the lightbox, links, etc.', EG_TEXTDOMAIN); ?>"><?php _e('Full Image Size', EG_TEXTDOMAIN); ?></label>
									</p>
									<p>
										<select name="facebook-full-size">
											<option value='0' <?php selected( $base->getVar($grid['postparams'], 'facebook-full-size', '0'), '3');?>><?php _e('130x130px', EG_TEXTDOMAIN);?></option>
											<option value='1' <?php selected( $base->getVar($grid['postparams'], 'facebook-full-size', '1'), '3');?>><?php _e('480x480px', EG_TEXTDOMAIN);?></option>
											<option value='2' <?php selected( $base->getVar($grid['postparams'], 'facebook-full-size', '2'), '3');?>><?php _e('720x720px', EG_TEXTDOMAIN);?></option>
											<option value='Preview' <?php selected( $base->getVar($grid['postparams'], 'facebook-full-size', 'Preview'), '3');?>><?php _e('Preview', EG_TEXTDOMAIN);?></option>
											<option value='3' <?php selected( $base->getVar($grid['postparams'], 'facebook-full-size', '3'), '3');?>><?php _e('Full', EG_TEXTDOMAIN);?></option>
										</select>
									</p>
								</div>
							</div>
							<div class="divider1"></div-->
							<div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">
									<h3><span><?php _e('Details', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Stream this number of posts', EG_TEXTDOMAIN); ?>"><?php _e('Count', EG_TEXTDOMAIN); ?></label>
									</p>
									<p>
										<input type="number" value="<?php echo $base->getVar($grid['postparams'], 'facebook-count', '12'); ?>" name="facebook-count">
									</p>
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Keep stream result cached (recommended)', EG_TEXTDOMAIN); ?>"><?php _e('Stream Cache (sec)', EG_TEXTDOMAIN); ?></label>
									</p>
									<p class="cachenumbercheck">
										<input type="number" style="margin-right:10px" value="<?php echo $base->getVar($grid['postparams'], 'facebook-transient-sec', '86400'); ?>" name="facebook-transient-sec"><a style="margin-right:10px" id="clear_cache_facebook"  class="button-primary revblue eg-clear-cache" href="javascript:void(0);" data-clear="facebook-transient-sec">Clear Cache</a>
										<span style="margin-left:10px" class="importantlabel showonsmallcache description"><?php _e('Small cache intervals may influnce the loading times negatively.', EG_TEXTDOMAIN); ?></span>	
									</p>
								</div>
							</div>
							<div class="divider1"></div>
						</div><!-- End Facebook Stream -->

						<div id="twitter-external-stream-wrap">
							<div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">
									<h3><span><?php _e('API', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Put in your Twitter Consumer Key', EG_TEXTDOMAIN); ?>"><?php _e('Twitter Consumer Key', EG_TEXTDOMAIN); ?></label>
										<input type="text" value="<?php echo $base->getVar($grid['postparams'], 'twitter-consumer-key', ''); ?>" name="twitter-consumer-key">
									</p>
									<p>
										<label  class="eg-new-label eg-tooltip-wrap" title="<?php _e('Put in your Twitter Consumer Secret', EG_TEXTDOMAIN); ?>"><?php _e('Twitter Consumer Secret', EG_TEXTDOMAIN); ?></label>
										<input type="text" value="<?php echo $base->getVar($grid['postparams'], 'twitter-consumer-secret', ''); ?>" name="twitter-consumer-secret">
									</p>
									<p>
										<label  class="eg-new-label eg-tooltip-wrap" title="<?php _e('Put in your Twitter Access Token', EG_TEXTDOMAIN); ?>"><?php _e('Twitter Access Token', EG_TEXTDOMAIN); ?></label>
										<input type="text" value="<?php echo $base->getVar($grid['postparams'], 'twitter-access-token', ''); ?>" name="twitter-access-token" >
									</p>
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Put in your Twitter Access Secret', EG_TEXTDOMAIN); ?>"><?php _e('Twitter Access Secret', EG_TEXTDOMAIN); ?></label>
										<input type="text" style="margin-right:10px" value="<?php echo $base->getVar($grid['postparams'], 'twitter-access-secret', ''); ?>" name="twitter-access-secret">
										<span class="description"><?php _e('Please <a target="_blank" href="https://dev.twitter.com/apps">register</a> your application with Twitter to fill the API fields.', EG_TEXTDOMAIN); ?></span>
									</p>
								</div>
							</div>
						<div class="divider1"></div>
							<div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">
									<h3><span><?php _e('Stream', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Put in the Twitter Account to stream from', EG_TEXTDOMAIN); ?>"><?php _e('Twitter Account Name @', EG_TEXTDOMAIN); ?></label>
										<input type="text" value="<?php echo $base->getVar($grid['postparams'], 'twitter-user-id', ''); ?>" name="twitter-user-id">
									</p>
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Include or Exclude tweets with no tweetpic inside', EG_TEXTDOMAIN); ?>"><?php _e('Text Tweets', EG_TEXTDOMAIN); ?></label>
										<input type="radio" class="firstinput" name="twitter-image-only" value="false" <?php checked($base->getVar($grid['postparams'], 'twitter-image-only', 'true'), 'false'); ?>> <span class="inplabel eg-tooltip-wrap" title="<?php _e('Include text only tweets in stream', EG_TEXTDOMAIN); ?>"><?php _e('Include', EG_TEXTDOMAIN); ?>	</span>
										<input type="radio" name="twitter-image-only" value="true" <?php checked($base->getVar($grid['postparams'], 'twitter-image-only', 'true'), 'true'); ?>> <span class='inplabel eg-tooltip-wrap' title="<?php _e('Exclude text only tweets from stream', EG_TEXTDOMAIN); ?>"><?php _e('Exclude', EG_TEXTDOMAIN); ?></span>
									</p>
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Exclude or Include retweets in stream?', EG_TEXTDOMAIN); ?>"><?php _e('Retweets', EG_TEXTDOMAIN); ?></label>
										<input type="radio" name="twitter-include-retweets" value="on" class="firstinput" <?php checked($base->getVar($grid['postparams'], 'twitter-include-retweets', 'on'), 'on'); ?>> <span class="inplabel eg-tooltip-wrap" title="<?php _e('Include retweets in stream', EG_TEXTDOMAIN); ?>"><?php _e('Include', EG_TEXTDOMAIN); ?></span>
										<input type="radio" name="twitter-include-retweets" value="off" <?php checked($base->getVar($grid['postparams'], 'twitter-include-retweets', 'on'), 'off'); ?>> <span class="inplabel eg-tooltip-wrap" title="<?php _e('Exclude retweets from stream', EG_TEXTDOMAIN); ?>"><?php _e('Exclude', EG_TEXTDOMAIN); ?>	</span>
									</p>
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Exclude or Include replies in stream?', EG_TEXTDOMAIN); ?>"><?php _e('Replies', EG_TEXTDOMAIN); ?></label>
										<input type="radio" name="twitter-exclude-replies" value="off" class="firstinput" <?php checked($base->getVar($grid['postparams'], 'twitter-exclude-replies', 'on'), 'off'); ?>> <span class="inplabel eg-tooltip-wrap" title="<?php _e('Include replies in stream', EG_TEXTDOMAIN); ?>"><?php _e('Include', EG_TEXTDOMAIN); ?></span>
										<input type="radio" name="twitter-exclude-replies" value="on" <?php checked($base->getVar($grid['postparams'], 'twitter-exclude-replies', 'on'), 'on'); ?>> <span class="inplabel eg-tooltip-wrap" title="<?php _e('Exclude replies from stream', EG_TEXTDOMAIN); ?>"><?php _e('Exclude', EG_TEXTDOMAIN); ?></span>	
									</p>
								</div>
							</div>
							<div class="divider1"></div>
							<div class="eg-creative-settings">
								<div class="eg-cs-tbc-left">
									<h3><span><?php _e('Details', EG_TEXTDOMAIN); ?></span></h3>
								</div>
								<div class="eg-cs-tbc">
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Stream this number of posts', EG_TEXTDOMAIN); ?>"><?php _e('Count', EG_TEXTDOMAIN); ?></label>
									</p>
									<p>
										<input type="number" value="<?php echo $base->getVar($grid['postparams'], 'twitter-count', '12'); ?>" name="twitter-count">
									</p>
									<p>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php _e('Keep stream result cached (recommended)', EG_TEXTDOMAIN); ?>"><?php _e('Stream Cache (sec)', EG_TEXTDOMAIN); ?></label>
									</p>
									<p class="cachenumbercheck">
										<input type="number" value="<?php echo $base->getVar($grid['postparams'], 'twitter-transient-sec', '86400'); ?>" name="twitter-transient-sec">&nbsp;<a style="margin-right:10px" id="clear_cache_twitter"  class="button-primary revblue eg-clear-cache" href="javascript:void(0);" data-clear="twitter-transient-sec">Clear Cache</a>
										<span style="margin-left:10px" class="importantlabel showonsmallcache description"><?php _e('Small cache intervals may influnce the loading times negatively.', EG_TEXTDOMAIN); ?></span>	
									</p>
								</div>
							</div>
							<div class="divider1"></div>
						</div><!-- End Twitter Stream -->
					</div>

					<div id="media-source-order-wrap">
						<div class="eg-creative-settings">
							<div class="eg-cs-tbc-left">
								<h3><span><?php _e('Media Source', EG_TEXTDOMAIN); ?></span></h3>
							</div>
							<div class="eg-cs-tbc" style="padding:15px; min-width:310px; width:310px">								
								<div class="eg-tooltip-wrap" title="<?php _e('Set default order of used media', EG_TEXTDOMAIN); ?>"><?php _e('Item Media Source Order', EG_TEXTDOMAIN); ?></div>
								
								<div id="imso-list" class="eg-media-source-order-wrap" style="height:440px;margin-top:10px;">
									<?php
									if(!empty($media_source_order)){
										foreach($media_source_order as $media_handle){
											if(!isset($media_source_list[$media_handle])) continue;
											?>
											<div id="imso-<?php echo $media_handle; ?>" class="eg-media-source-order revblue button-primary">
												<i style="float:left; margin-right:10px;" class="eg-icon-<?php echo $media_source_list[$media_handle]['type']; ?>"></i>
												<span style="float:left"><?php echo $media_source_list[$media_handle]['name']; ?></span>														
												<input style="float:right;margin: 5px 4px 0 0;" class="eg-get-val" type="checkbox" name="media-source-order[]" checked="checked" value="<?php echo $media_handle; ?>" />
												<div style="clear:both"></div>
											</div>
											<?php
											unset($media_source_list[$media_handle]);
										}
									}
									
									if(!empty($media_source_list)){
										foreach($media_source_list as $media_handle => $media_set){
											?>
											<div id="imso-<?php echo $media_handle; ?>" class="eg-media-source-order revblue button-primary">
												<i style="float:left; margin-right:10px;" class="eg-icon-<?php echo $media_set['type']; ?>"></i>
												<span style="float:left"><?php echo $media_set['name']; ?></span>
												<input style="float:right;margin: 5px 4px 0 0;" class="eg-get-val" type="checkbox" name="media-source-order[]" value="<?php echo $media_handle; ?>" />
												<div style="clear:both"></div>
											</div>
											<?php
										}
									}
									?>
								</div>
								
							</div>

							<div id="poster-media-source-container" class="eg-cs-tbc" style="padding:15px;min-width:310px; width:100%">								
								<div class="eg-tooltip-wrap" title="<?php _e('Set the default order of Poster Image Source', EG_TEXTDOMAIN); ?>"><?php _e('Optional Audio/Video Image Order', EG_TEXTDOMAIN); ?></div>						
								<div id="pso-list" class="eg-media-source-order-wrap" style="height:440px;margin-top:10px;">
									<?php
									if(!empty($poster_source_order)){
										foreach($poster_source_order as $poster_handle){
											if(!isset($poster_source_list[$poster_handle])) continue;
											?>
											<div id="pso-<?php echo $poster_handle; ?>" class="eg-media-source-order revblue button-primary">
												<i style="float:left; margin-right:10px;" class="eg-icon-<?php echo $poster_source_list[$poster_handle]['type']; ?>"></i>
												<span style="float:left"><?php echo $poster_source_list[$poster_handle]['name']; ?></span>
												<input style="float:right;margin: 5px 4px 0 0;" class="eg-get-val" type="checkbox" name="poster-source-order[]" checked="checked" value="<?php echo $poster_handle; ?>" />
												<div style="clear:both"></div>
											</div>
											<?php
											unset($poster_source_list[$poster_handle]);
										}
									}
									
									if(!empty($poster_source_list)){
										foreach($poster_source_list as $poster_handle => $poster_set){
											?>
											<div id="pso-<?php echo $poster_handle; ?>" class="eg-media-source-order revblue button-primary">
												<i style="float:left; margin-right:10px;" class="eg-icon-<?php echo $poster_set['type']; ?>"></i>
												<span style="float:left"><?php echo $poster_set['name']; ?></span>
												<input style="float:right;margin: 5px 4px 0 0;" class="eg-get-val" type="checkbox" name="poster-source-order[]" value="<?php echo $poster_handle; ?>" />
												<div style="clear:both"></div>
											</div>
											<?php
										}
									}
									?>
								</div>								
							</div>							
						</div>
						<div style="margin-left:150px; padding-left:15px; padding-bottom:15px;margin-top:0px;background:#fff">
							<?php _e('First Media Source will be loaded as default. In case one source does not exist, next available media source in this order will be used', EG_TEXTDOMAIN); ?>
						</div>

						<div class="divider1"></div>
					</div>



					<div id="media-source-sizes">
						<div class="eg-creative-settings">
							<div class="eg-cs-tbc-left">
								<h3><span><?php _e('Source Size', EG_TEXTDOMAIN); ?></span></h3>
							</div>
							<div class="eg-cs-tbc" style="padding-top:15px">
								<!-- DEFAULT IMAGE SOURCE -->
								<label class="eg-tooltip-wrap" title="<?php _e('Grid Image Source Size', EG_TEXTDOMAIN); ?>"><?php _e('Set Image Source Type', EG_TEXTDOMAIN); ?></label>
									
								<div style="margin-bottom: 10px;">
									<?php
									$image_source_type = $base->getVar($grid['postparams'], 'image-source-type', 'full');
									?>
									<select name="image-source-type">
										<?php
										foreach($all_image_sizes as $handle => $name){
											?>
											<option <?php selected($image_source_type, $handle); ?> value="<?php echo $handle; ?>"><?php echo $name; ?></option>
											<?php
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="divider1"></div>
					</div>
					<div id="media-source-sizes">
						<div class="eg-creative-settings">
							<div class="eg-cs-tbc-left">
								<h3><span><?php _e('Media Filter', EG_TEXTDOMAIN); ?></span></h3>
							</div>
							<div class="eg-cs-tbc" style="padding-top:15px">
								
									
								<div style="display:none; margin-bottom: 10px;">
									<?php
									$media_filter_type = $base->getVar($grid['postparams'], 'media-filter-type', 'none');									
									?>									
									<select id="media-filter-type" name="media-filter-type">
										<?php
										foreach($all_media_filters as $handle => $name){
											?>
											<option <?php selected($media_filter_type, $handle); ?> value="<?php echo $handle; ?>"><?php echo $name; ?></option>
											<?php
										}
										?>
									</select>
								</div>
								<div id="inst-filter-grid">									
									<?php
										foreach($all_media_filters as $handle => $name){
											$selected = $media_filter_type === $handle ? "selected" : "";
											?>
											<div data-type="<?php echo $handle; ?>" class="inst-filter-griditem <?php echo $selected; ?>"><div class="ifgname"><?php echo $name; ?></div><div class="inst-filter-griditem-img <?php echo $handle; ?>"></div><div class="inst-filter-griditem-img-noeff"></div></div>
											<?php
										}
										?>
								</div>
							</div>
						</div>
						<div class="divider1"></div>
					</div>
					<div id="media-source-default-templates">
						<div class="eg-creative-settings">
							<div class="eg-cs-tbc-left">
								<h3><span><?php _e('Default Source', EG_TEXTDOMAIN); ?></span></h3>
							</div>
							<div class="eg-cs-tbc" style="padding-top:15px">								
								<div  style="float:left">
									<label class="eg-tooltip-wrap" title="<?php _e('Image will be used if no criteria are matching so a default image will be shown', EG_TEXTDOMAIN); ?>"><?php _e('Default Image', EG_TEXTDOMAIN); ?></label>
								</div>
								<div style="float:left; margin-bottom: 10px;">
									<div>
										<?php
										$default_img = $base->getVar($grid['postparams'], 'default-image', 0, 'i');
										$var_src = '';
										if($default_img > 0){
											$img = wp_get_attachment_image_src($default_img, 'full');
											if($img !== false){
												$var_src = $img[0];
											}
										}
										?>
										<img id="eg-default-image-img" class="image-holder-wrap-div" src="<?php echo $var_src; ?>" <?php echo ($var_src == '') ? 'style="display: none;"' : ''; ?> />
									</div>
									<a class="button-primary revblue eg-default-image-add" href="javascript:void(0);" data-setto="eg-default-image"><?php _e('Choose Image', EG_TEXTDOMAIN); ?></a>
									<a class="button-primary revred eg-default-image-clear" href="javascript:void(0);" data-setto="eg-default-image"><?php _e('Remove Image', EG_TEXTDOMAIN); ?></a>
									<input type="hidden" name="default-image" value="<?php echo $default_img; ?>" id="eg-default-image" />
								</div>
								<div style="clear:both"></div>
							</div>
						</div>
						<div class="divider1"></div>
					</div>

					<div class="eg-creative-settings" id="eg-youtube-default-poster">
						
						<div class="eg-cs-tbc-left">
							<h3 class="box-closed"><span><?php _e('YouTube Poster', EG_TEXTDOMAIN); ?></span></h3>
						</div>
						<div class="eg-cs-tbc" style="padding-top:15px">
							<div  style="float:left">
								<label class="eg-tooltip-wrap" title="<?php _e('Set the default posters for the different video sources', EG_TEXTDOMAIN); ?>"><?php _e('Default Poster', EG_TEXTDOMAIN); ?></label>
							</div>
							<div style="float:left; margin-bottom: 10px;">
								<div>
									<?php
									$youtube_default_img = $base->getVar($grid['params'], 'youtube-default-image', 0, 'i');
									$var_src = '';
									if($youtube_default_img > 0){
										$youtube_img = wp_get_attachment_image_src($youtube_default_img, 'full');
										if($youtube_img !== false){
											$var_src = $youtube_img[0];
										}
									}
									?>
									<img id="eg-youtube-default-image-img" class="image-holder-wrap-div" src="<?php echo $var_src; ?>" <?php echo ($var_src == '') ? 'style="display: none;"' : ''; ?> />
								</div>
								<a class="button-primary revblue eg-youtube-default-image-add" href="javascript:void(0);" data-setto="eg-youtube-default-image"><?php _e('Choose Image', EG_TEXTDOMAIN); ?></a>
								<a class="button-primary revred eg-youtube-default-image-clear" href="javascript:void(0);" data-setto="eg-youtube-default-image"><?php _e('Remove Image', EG_TEXTDOMAIN); ?></a>
								<input type="hidden" name="youtube-default-image" value="<?php echo $youtube_default_img; ?>" id="eg-youtube-default-image" />
							</div>
						</div>						
					</div>
					
					<div class="eg-creative-settings" id="eg-vimeo-default-poster">
						<div class="divider1"></div>
						<div class="eg-cs-tbc-left">
							<h3 class="box-closed"><span><?php _e('Vimeo Poster', EG_TEXTDOMAIN); ?></span></h3>
						</div>
						<div class="eg-cs-tbc" style="padding-top:15px">
							<div  style="float:left">
								<label class="eg-tooltip-wrap" title="<?php _e('Set the default posters for the different video sources', EG_TEXTDOMAIN); ?>"><?php _e('Default Poster', EG_TEXTDOMAIN); ?></label>
							</div>
							<div style="float:left; margin-bottom: 10px;">
								<div>
									<?php
									$vimeo_default_img = $base->getVar($grid['params'], 'vimeo-default-image', 0, 'i');
									$var_src = '';
									if($vimeo_default_img > 0){
										$vimeo_img = wp_get_attachment_image_src($vimeo_default_img, 'full');
										if($vimeo_img !== false){
											$var_src = $vimeo_img[0];
										}
									}
									?>
									<img id="eg-vimeo-default-image-img" class="image-holder-wrap-div" src="<?php echo $var_src; ?>" <?php echo ($var_src == '') ? 'style="display: none;"' : ''; ?> />
								</div>
								<a class="button-primary revblue eg-vimeo-default-image-add" href="javascript:void(0);" data-setto="eg-vimeo-default-image"><?php _e('Choose Image', EG_TEXTDOMAIN); ?></a>
								<a class="button-primary revred eg-vimeo-default-image-clear" href="javascript:void(0);" data-setto="eg-vimeo-default-image"><?php _e('Remove Image', EG_TEXTDOMAIN); ?></a>
								<input type="hidden" name="vimeo-default-image" value="<?php echo $vimeo_default_img; ?>" id="eg-vimeo-default-image" />
							</div>
							<div style="clear:both"></div>
						</div>
						
					</div>
					
					<div class="eg-creative-settings" id="eg-html5-default-poster">
						
						<div class="eg-cs-tbc-left">
							<h3 class="box-closed"><span><?php _e('HTML5 Poster', EG_TEXTDOMAIN); ?></span></h3>
						</div>
						<div class="eg-cs-tbc" style="padding-top:15px">
							<div  style="float:left">
								<label class="eg-tooltip-wrap" title="<?php _e('Set the default posters for the different video sources', EG_TEXTDOMAIN); ?>"><?php _e('Default Poster', EG_TEXTDOMAIN); ?></label>
							</div>
							<div style="float:left; margin-bottom: 10px;">
								<div>
									<?php
									$html_default_img = $base->getVar($grid['params'], 'html-default-image', 0, 'i');
									$var_src = '';
									if($html_default_img > 0){
										$html_img = wp_get_attachment_image_src($html_default_img, 'full');
										if($html_img !== false){
											$var_src = $html_img[0];
										}
									}
									?>
									<img id="eg-html-default-image-img" class="image-holder-wrap-div" src="<?php echo $var_src; ?>" <?php echo ($var_src == '') ? 'style="display: none;"' : ''; ?> />
								</div>
								<a class="button-primary revblue eg-html-default-image-add" href="javascript:void(0);" data-setto="eg-html-default-image"><?php _e('Choose Image', EG_TEXTDOMAIN); ?></a>
								<a class="button-primary revred eg-html-default-image-clear" href="javascript:void(0);" data-setto="eg-html-default-image"><?php _e('Remove Image', EG_TEXTDOMAIN); ?></a>
								<input type="hidden" name="html-default-image" value="<?php echo $html_default_img; ?>" id="eg-html-default-image" />
							</div>
							<div style="clear:both"></div>
							
						</div>
					</div>
					<div id="gallery-wrap"></div>
				</form>
			</div>
		</div>
		<?php
			require_once('elements/grid-settings.php');
		?>
		
		
		<div id="custom-element-add-elements-wrapper">
			<div class="eg-creative-settings">
				<div class="eg-cs-tbc-left">
					<h3><span><?php _e('Add Items', EG_TEXTDOMAIN); ?></span></h3>
				</div>
				<div class="eg-cs-tbc" style="vertical-align:middle;">	
					<p style="display:table-cell;vertical-align:middle;min-width:170px">								
						<label class="eg-tooltip-wrap" title="<?php _e('Add element to Custom Grid', EG_TEXTDOMAIN); ?>"><?php _e('Add', EG_TEXTDOMAIN); ?></label>																
					</p>
					<ul style="display:table-cell;vertical-align:middle;" class="esg-custom-add-item">
						<li><div class="esg-open-edit-dialog" id="esg-add-new-custom-youtube-top"><i class="eg-icon-youtube-squared"></i><?php _e('You Tube', EG_TEXTDOMAIN); ?></div></li>
						<li><div class="esg-open-edit-dialog" id="esg-add-new-custom-vimeo-top"><i class="eg-icon-vimeo-squared"></i><?php _e('Vimeo', EG_TEXTDOMAIN); ?></div></li>
						<li><div class="esg-open-edit-dialog" id="esg-add-new-custom-html5-top"><i class="eg-icon-video"></i><?php _e('Self Hosted Media', EG_TEXTDOMAIN); ?></div></li>
						<li><div class="esg-open-edit-dialog" id="esg-add-new-custom-image-top"><i class="eg-icon-picture-1"></i><?php _e('Image(s)', EG_TEXTDOMAIN); ?></div></li>
						<li><div class="esg-open-edit-dialog" id="esg-add-new-custom-soundcloud-top"><i class="eg-icon-soundcloud"></i><?php _e('Sound Cloud', EG_TEXTDOMAIN); ?></div></li>
						<li><div class="esg-open-edit-dialog" id="esg-add-new-custom-text-top"><i class="eg-icon-font"></i><?php _e('Simple Content', EG_TEXTDOMAIN); ?></div></li>										
					</ul>
					<div style="clear:both"></div>
				</div>
			</div>
			<div class="divider1"></div>
		</div>
		
		<div class="save-wrap-settings" style="">
		<!--	<div style="width:150px; background:#E1e1e1;position:absolute;height:100%;top:0px;left:0px;"></div>-->
			<div class="sws-toolbar-button"><a class="button-primary revgreen" href="javascript:void(0);" id="eg-btn-save-grid"><i class="rs-icon-save-light" style="display: inline-block;vertical-align: middle;width: 18px;height: 20px;background-repeat: no-repeat;margin-right:10px !important;margin-left:2px !important;"></i><?php echo $save; ?></a></div>
			<div class="sws-toolbar-button"><a class="button-primary revblue esg-refresh-preview-button"><i class="eg-icon-arrows-ccw"></i><?php _e('Refresh Preview', EG_TEXTDOMAIN); ?></a></div>
			<div class="sws-toolbar-button"><a class="button-primary revyellow" href="<?php echo self::getViewUrl(Essential_Grid_Admin::VIEW_OVERVIEW); ?>"><i class="eg-icon-cancel"></i><?php _e('Close', EG_TEXTDOMAIN); ?></a></div>
			<div class="sws-toolbar-button"><?php if($grid !== false){ ?>
				<a class="button-primary revred" href="javascript:void(0);" id="eg-btn-delete-grid"><i class="eg-icon-trash"></i><?php _e('Delete Grid', EG_TEXTDOMAIN); ?></a>
			<?php } ?></div>				
		</div>
		<script>
			jQuery('document').ready(function() {
				punchgs.TweenLite.fromTo(jQuery('.save-wrap-settings'),0.5,{autoAlpha:0,x:40},{autoAlpha:1,x:0,ease:punchgs.Power3.easeInOut,delay:3});
				jQuery.each(jQuery('.sws-toolbar-button'),function(ind,elem) {
					punchgs.TweenLite.fromTo(elem,0.5,{x:40},{x:0,ease:punchgs.Power3.easeInOut,delay:4+(ind*0.3)});			
				})

				jQuery('.sws-toolbar-button').hover(function() {
					punchgs.TweenLite.to(jQuery(this),0.3,{x:-110,ease:punchgs.Power3.easeInOut});
				},
				function() {
					punchgs.TweenLite.to(jQuery(this),0.3,{x:0,ease:punchgs.Power3.easeInOut});					
				})
			});
		</script>
	</div>
</div>

<div class="clear"></div>

<?php
if(intval($isCreate) == 0){ //currently editing
	echo '<div id="eg-create-step-3">';
}
?>

<div style="width:100%;height:20px"></div>
<h2><?php _e('Editor / Preview', EG_TEXTDOMAIN); ?></h2>
<form id="eg-custom-elements-form-wrap">
	<div id="eg-live-preview-wrap">
		<?php
		wp_enqueue_script($this->plugin_slug . '-essential-grid-script', EG_PLUGIN_URL.'public/assets/js/jquery.themepunch.essential.min.js', array('jquery'), Essential_Grid::VERSION );
		
		Essential_Grid_Global_Css::output_global_css_styles_wrapped();
		?>
		<div id="esg-preview-wrapping-wrapper">
			<?php
			if($base->getVar($grid['postparams'], 'source-type', 'post') == 'custom'){
				$layers = @$grid['layers']; //no stripslashes used here
				
				if(!empty($layers)){
					foreach($layers as $layer){
						?>
						<input class="eg-remove-on-reload" type="hidden" name="layers[]" value="<?php echo htmlentities($layer); ?>" />
						<?php
					}
				}
			}
			?>
		</div>
	</div>
</form>
<?php
if(intval($isCreate) == 0){ //currently editing
	echo '</div>';
}

Essential_Grid_Dialogs::post_meta_dialog(); //to change post meta informations
Essential_Grid_Dialogs::edit_custom_element_dialog(); //to change post meta informations
Essential_Grid_Dialogs::custom_element_image_dialog(); //to change post meta informations

?>
<script type="text/javascript">
	var eg_jsonTaxWithCats = <?php echo $jsonTaxWithCats; ?>;
	var pages = [
		<?php
		if(!empty($pages)){
			$first = true;
			foreach($pages as $page){
				echo (!$first) ? ",\n" : "\n";
				echo '{ value: '.$page->ID.', label: "'.str_replace('"', '', $page->post_title).' (ID: '.$page->ID.')" }';
				$first = false;
			}
		}
		?>
	];


	jQuery(document).ready(function(){
		
		AdminEssentials.setInitMetaKeysJson(<?php echo $base->jsonEncodeForClientSide($meta_keys); ?>);
		
		AdminEssentials.initCreateGrid(<?php echo ($grid !== false) ? '"update_grid"' : ''; ?>);

		AdminEssentials.set_default_nav_skin(<?php echo $navigation_skin_css; ?>);

		AdminEssentials.initAccordion('eg-create-settings-general-tab');

		AdminEssentials.initSlider();

		AdminEssentials.initAutocomplete();

		AdminEssentials.initTabSizes();

		AdminEssentials.set_navigation_layout();
		
		setTimeout(function() {
			AdminEssentials.createPreviewGrid();
		},500);


		AdminEssentials.initSpinnerAdmin();
		
		AdminEssentials.setInitCustomJson(<?php echo $base->jsonEncodeForClientSide($custom_elements); ?>);
		
	});
</script>

<?php

echo '<div id="navigation-styling-css-wrapper">'."\n";
$skins = Essential_Grid_Navigation::output_navigation_skins();
echo $skins;
echo '</div>';

?>

<div id="esg-template-wrapper" style="display: none;">

</div>