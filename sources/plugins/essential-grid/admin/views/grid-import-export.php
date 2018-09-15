<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

$c_grids = new Essential_Grid();
$item_skin = new Essential_Grid_Item_Skin();
$item_ele = new Essential_Grid_Item_Element();
$nav_skin = new Essential_Grid_Navigation();
$metas = new Essential_Grid_Meta();
$fonts = new ThemePunch_Fonts();

$grids = $c_grids->get_essential_grids();
$skins = $item_skin->get_essential_item_skins();
$elements = $item_ele->get_essential_item_elements();
$navigation_skins = $nav_skin->get_essential_navigation_skins();
$custom_metas = $metas->get_all_meta();
$custom_fonts = $fonts->get_all_fonts();

$token = wp_create_nonce("Essential_Grid_actions");

$import_data = false;
if (isset($_FILES['import_file'])) {
    if ($_FILES['import_file']['error'] > 0) {
        echo '<div class="error"><p>'.__('Invalid file or file size too big.', EG_TEXTDOMAIN).'</p></div>';
    }else {
        $file_name = $_FILES['import_file']['name'];
		$ext = explode(".", $file_name);
        $file_ext = strtolower(end($ext));
        $file_size = $_FILES['import_file']['size'];
        if ($file_ext == "json") {
            $encode_data = file_get_contents($_FILES['import_file']['tmp_name']);
            $import_data = json_decode($encode_data, true);
        }else {
			echo '<div class="error"><p>'.__('Invalid file or file size too big.', EG_TEXTDOMAIN).'</p></div>';
        }
    }
}
?>
	<h2 class="topheader"><?php echo esc_html(get_admin_page_title()); ?></h2>
	<div id="eg-grid-export-import-wrapper">
		<form id="eg-grid-export-form" method="POST" action="<?php echo admin_url('admin-ajax.php'); ?>?action=Essential_Grid_request_ajax">
			<input type="hidden" name="client_action" value="export_data">
			<input type="hidden" name="token" value="<?php echo $token; ?>">
			<div class="postbox eg-postbox" style="width:100%;min-width:500px">
				<h3 class="box-closed"><span style="font-weight:400"><?php _e('Export:', EG_TEXTDOMAIN); ?></span><div class="postbox-arrow"></div></h3>
				<div class="inside" style="display:none;padding:10px !important;margin:0px !important;height:100%;position:relative;">
					<ul>
						<?php
						if(!empty($grids)){
							?>
							<li><div class="eg-li-intern-wrap"><span class="eg-expand-collapse closed"><i class="eg-icon-folder-open"></i><i class="eg-icon-folder"></i></span><span class="eg-inputchecked"><i class="eg-icon-ok-squared"></i><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span><input  type="checkbox" name="export-grids" checked="checked" /><span><?php _e('Grids', EG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
								<ul class="eg-ie-sub-ul">
									<?php
									foreach($grids as $grid){
										?>
										<li><div class="eg-li-intern-wrap"><span class="eg-inputchecked"><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span><input type="checkbox" name="export-grids-id[]" value="<?php echo $grid->id; ?>" checked="checked" /><?php echo $grid->handle; ?></div></li>
										<?php
									}
									?>
								</ul>
							</li>
							<?php
						}
						
						if(!empty($skins)){
							?>
							<li><div class="eg-li-intern-wrap"><span class="eg-expand-collapse closed"><i class="eg-icon-folder-open"></i><i class="eg-icon-folder"></i></span><span class="eg-inputchecked"><i class="eg-icon-ok-squared"></i><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span><input type="checkbox" name="export-skins" checked="checked" /><span><?php _e('Skins', EG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
								<ul class="eg-ie-sub-ul">
									<?php
									foreach($skins as $skin){
										?>
										<li><div class="eg-li-intern-wrap"><span class="eg-inputchecked"><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span><input type="checkbox" name="export-skins-id[]" checked="checked" value="<?php echo $skin['id']; ?>" /><?php echo $skin['name']; ?></div></li>
										<?php
									}
									?>
								</ul>
							</li>
							<?php
						}
						
						if(!empty($elements)){
							?>
							<li><div class="eg-li-intern-wrap"><span class="eg-expand-collapse closed"><i class="eg-icon-folder-open"></i><i class="eg-icon-folder"></i></span><span class="eg-inputchecked"><i class="eg-icon-ok-squared"></i><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span><input type="checkbox" name="export-elements" checked="checked" /><span><?php _e('Elements', EG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
								<ul class="eg-ie-sub-ul">
									<?php
									foreach($elements as $element){
										?>
										<li><div class="eg-li-intern-wrap"><span class="eg-inputchecked"><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span><input type="checkbox" name="export-elements-id[]" checked="checked" value="<?php echo $element['id']; ?>" /><?php echo $element['name']; ?></div></li>
										<?php
									}
									?>
								</ul>
							</li>
							<?php
						}
						
						if(!empty($navigation_skins)){
							?>
							<li><div class="eg-li-intern-wrap"><span class="eg-expand-collapse closed"><i class="eg-icon-folder-open"></i><i class="eg-icon-folder"></i></span><span class="eg-inputchecked"><i class="eg-icon-ok-squared"></i><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span><input type="checkbox" name="export-navigation-skins" checked="checked" /><span><?php _e('Navigation Skins', EG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
								<ul class="eg-ie-sub-ul">
									<?php
									foreach($navigation_skins as $skin){
										?>
										<li><div class="eg-li-intern-wrap"><span class="eg-inputchecked"><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span><input type="checkbox" name="export-navigation-skins-id[]" checked="checked" value="<?php echo $skin['id']; ?>" /><?php echo $skin['name']; ?></div></li>
										<?php
									}
									?>
								</ul>
							</li>
							<?php
						}
						
						if(!empty($custom_metas)){
							?>
							<li><div class="eg-li-intern-wrap"><span class="eg-expand-collapse closed"><i class="eg-icon-folder-open"></i><i class="eg-icon-folder"></i></span><span class="eg-inputchecked"><i class="eg-icon-ok-squared"></i><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span><input type="checkbox" name="export-custom-meta" checked="checked" /><span><?php _e('Custom Meta', EG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
								<ul class="eg-ie-sub-ul">
									<?php
									foreach($custom_metas as $meta){
										$type = ($meta['m_type'] == 'link') ? 'egl-' : 'eg-';
										?>
										<li><div class="eg-li-intern-wrap"><span class="eg-inputchecked"><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span><input type="checkbox" name="export-custom-meta-handle[]" checked="checked" value="<?php echo $meta['handle']; ?>" /><?php echo $type; ?><?php echo $meta['handle']; ?></div></li>
										<?php
									}
									?>
								</ul>
							</li>
							<?php
						}
						
						if(!empty($custom_fonts)){
							?>
							<li><div class="eg-li-intern-wrap"><span class="eg-expand-collapse closed"><i class="eg-icon-folder-open"></i><i class="eg-icon-folder"></i></span><span class="eg-inputchecked"><i class="eg-icon-ok-squared"></i><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span><input type="checkbox" name="export-punch-fonts" checked="checked" /><span><?php _e('Punch Fonts', EG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
								<ul class="eg-ie-sub-ul">
									<?php
									foreach($custom_fonts as $font){
										?>
										<li><div class="eg-li-intern-wrap"><span class="eg-inputchecked"><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span><input type="checkbox" name="export-punch-fonts-handle[]" checked="checked" value="<?php echo $font['handle']; ?>" /><?php echo $font['handle']; ?></div></li>
										<?php
									}
									?>
								</ul>
							</li>
							<?php
						}
						?>
						<li><div class="eg-li-intern-wrap"><span style="margin-left:33px" class="eg-inputchecked"><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span><input type="checkbox" name="export-global-styles" checked="checked" style="margin-left:33px"/><span><?php _e('Global Styles', EG_TEXTDOMAIN); ?></span></div></li>
					</ul>
					
					<div>
						<input type="submit" id="eg-export-selected-settings" class="button-primary revgreen" value="<?php _e('Export Selected', EG_TEXTDOMAIN); ?>" />
					</div>
				</div>
			</div>
		</form>
		
		<?php 
		$is_open = 'closed';
		$is_vis = 'display:none;';
		if($import_data !== false && !empty($import_data)){
			$is_open = 'open';
			$is_vis = '';
			?>
			<form id="eg-grid-import-form">
				<?php
				if(isset($import_data['grids']) && is_array($import_data['grids']) && !empty($import_data['grids'])){
					foreach($import_data['grids'] as $d_grid){
						?>
						<input type="hidden" name="data-grids[]" value="<?php echo htmlentities(json_encode($d_grid, true)); ?>" />
						<?php
					}
				}
				if(isset($import_data['skins']) && is_array($import_data['skins']) && !empty($import_data['skins'])){
					foreach($import_data['skins'] as $d_skin){
						?>
						<input type="hidden" name="data-skins[]" value="<?php echo htmlentities(json_encode($d_skin, true)); ?>" />
						<?php
					}
				}
				if(isset($import_data['elements']) && is_array($import_data['elements']) && !empty($import_data['elements'])){
					foreach($import_data['elements'] as $d_elements){
						?>
						<input type="hidden" name="data-elements[]" value="<?php echo htmlentities(json_encode($d_elements, true)); ?>" />
						<?php
					}
				}
				if(isset($import_data['navigation-skins']) && is_array($import_data['navigation-skins']) && !empty($import_data['navigation-skins'])){
					foreach($import_data['navigation-skins'] as $d_navigation_skins){
						?>
						<input type="hidden" name="data-navigation-skins[]" value="<?php echo htmlentities(json_encode($d_navigation_skins, true)); ?>" />
						<?php
					}
				}
				if(isset($import_data['custom-meta']) && is_array($import_data['custom-meta']) && !empty($import_data['custom-meta'])){
					foreach($import_data['custom-meta'] as $d_custom_meta){
						?>
						<input type="hidden" name="data-custom-meta[]" value="<?php echo htmlentities(json_encode($d_custom_meta, true)); ?>" />
						<?php
					}
				}
				if(isset($import_data['punch-fonts']) && is_array($import_data['punch-fonts']) && !empty($import_data['punch-fonts'])){
					foreach($import_data['punch-fonts'] as $d_punch_fonts){
						?>
						<input type="hidden" name="data-punch-fonts[]" value="<?php echo htmlentities(json_encode($d_punch_fonts, true)); ?>" />
						<?php
					}
				}
				if(isset($import_data['global-css'])){
					?>
					<input type="hidden" name="data-global-css" value="<?php echo htmlentities(json_encode($import_data['global-css'], true)); ?>" />
					<?php
				}
				?>
			<?php
		}else{
			?>
			<form id="eg-grid-import-form" method="post" enctype="multipart/form-data">
			<?php
		}
		?>
			<div class="postbox eg-postbox" style="width:100%;min-width:500px">
				<h3 class="box-<?php echo $is_open; ?>"><span style="font-weight:400"><?php _e('Import:', EG_TEXTDOMAIN); ?></span><div class="postbox-arrow"></div></h3>
				<div class="inside" style="<?php echo $is_vis; ?>padding:10px !important;margin:0px !important;height:100%;position:relative;">
					<?php 
					if($import_data !== false && !empty($import_data)){
						?>
						<?php _e('The following could be found in the selected file:', EG_TEXTDOMAIN); ?>
						<ul>
							<?php
							if(!empty($import_data['grids'])){
								?>
								<li><div class="eg-li-intern-wrap"><span class="eg-expand-collapse closed"><i class="eg-icon-folder-open"></i><i class="eg-icon-folder"></i></span><span class="eg-inputchecked"><i class="eg-icon-ok-squared"></i><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span><input  type="checkbox" name="import-grids" checked="checked" /><span><?php _e('Grids', EG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
									<ul class="eg-ie-sub-ul">
										<?php
										foreach($import_data['grids'] as $grid_values){
											?>
											<li>
												<div class="eg-li-intern-wrap">
													<span class="eg-inputchecked"><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span>
													<input class="eg-get-val" type="checkbox" name="import-grids-id[]" value="<?php echo $grid_values['id']; ?>" checked="checked" />
													<?php echo $grid_values['name']; ?>
													<?php
													if(!empty($grids)){
														foreach($grids as $grid){
															if($grid->handle == $grid_values['handle']){ //already exists in database, ask to append or overwrite
																?>
																<span style="float: right;">
																	<input type="radio" name="grid-overwrite-<?php echo $grid_values['id']; ?>" checked="checked" value="append" /> <?php _e('Append as New', EG_TEXTDOMAIN); ?>
																	<input type="radio" name="grid-overwrite-<?php echo $grid_values['id']; ?>" value="overwrite" /> <?php _e('Overwrite Existing', EG_TEXTDOMAIN); ?>
																</span>
																<div style="clear: both;"></div>
																<?php
																break;
															}
														}
													}
													?>
												</div>
											</li>
											<?php
										}
										?>
									</ul>
								</li>
								<?php
							}
							
							if(!empty($import_data['skins'])){
								?>
								<li><div class="eg-li-intern-wrap"><span class="eg-expand-collapse closed"><i class="eg-icon-folder-open"></i><i class="eg-icon-folder"></i></span><span class="eg-inputchecked"><i class="eg-icon-ok-squared"></i><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span><input type="checkbox" name="import-skins" checked="checked" /><span><?php _e('Skins', EG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
									<ul class="eg-ie-sub-ul">
										<?php
										foreach($import_data['skins'] as $skin){
											?>
											<li>
												<div class="eg-li-intern-wrap">
													<span class="eg-inputchecked"><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span>
													<input class="eg-get-val" type="checkbox" name="import-skins-id[]" checked="checked" value="<?php echo $skin['id']; ?>" />
													<?php echo $skin['name']; ?>
													<?php
													if(!empty($skins)){
														foreach($skins as $e_skin){
															if($skin['handle'] == $e_skin['handle']){ //already exists in database, ask to append or overwrite
																?>
																<span style="float: right;">
																	<input type="radio" name="skin-overwrite-<?php echo $skin['id']; ?>" checked="checked" value="append" /> <?php _e('Append as New', EG_TEXTDOMAIN); ?>
																	<input type="radio" name="skin-overwrite-<?php echo $skin['id']; ?>" value="overwrite" /> <?php _e('Overwrite Existing', EG_TEXTDOMAIN); ?>
																</span>
																<div style="clear: both;"></div>
																<?php
																break;
															}
														}
													}
													?>
												</div>
											</li>
											<?php
										}
										?>
									</ul>
								</li>
								<?php
							}
							
							if(!empty($import_data['elements'])){
								?>
								<li><div class="eg-li-intern-wrap"><span class="eg-expand-collapse closed"><i class="eg-icon-folder-open"></i><i class="eg-icon-folder"></i></span><span class="eg-inputchecked"><i class="eg-icon-ok-squared"></i><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span><input type="checkbox" name="import-elements" checked="checked" /><span><?php _e('Elements', EG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
									<ul class="eg-ie-sub-ul">
										<?php
										foreach($import_data['elements'] as $element){
											?>
											<li>
												<div class="eg-li-intern-wrap">
													<span class="eg-inputchecked"><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span>
													<input class="eg-get-val" type="checkbox" name="import-elements-id[]" checked="checked" value="<?php echo $element['id']; ?>" />
													<?php echo $element['name']; ?>
													<?php
													if(!empty($elements)){
														foreach($elements as $e_element){
															if($element['handle'] == $e_element['handle']){ //already exists in database, ask to append or overwrite
																?>
																<span style="float: right;">
																	<input type="radio" name="element-overwrite-<?php echo $element['id']; ?>" checked="checked" value="append" /> <?php _e('Append as New', EG_TEXTDOMAIN); ?>
																	<input type="radio" name="element-overwrite-<?php echo $element['id']; ?>" value="overwrite" /> <?php _e('Overwrite Existing', EG_TEXTDOMAIN); ?>
																</span>
																<div style="clear: both;"></div>
																<?php
																break;
															}
														}
													}
													?>
												</div>
											</li>
											<?php
										}
										?>
									</ul>
								</li>
								<?php
							}
							
							if(!empty($import_data['navigation-skins'])){
								?>
								<li><div class="eg-li-intern-wrap"><span class="eg-expand-collapse closed"><i class="eg-icon-folder-open"></i><i class="eg-icon-folder"></i></span><span class="eg-inputchecked"><i class="eg-icon-ok-squared"></i><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span><input type="checkbox" name="import-navigation-skins" checked="checked" /><span><?php _e('Navigation Skins', EG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
									<ul class="eg-ie-sub-ul">
										<?php
										foreach($import_data['navigation-skins'] as $skin){
											?>
											<li>
												<div class="eg-li-intern-wrap">
													<span class="eg-inputchecked"><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span>
													<input class="eg-get-val" type="checkbox" name="import-navigation-skins-id[]" checked="checked" value="<?php echo $skin['id']; ?>" />
													<?php echo $skin['name']; ?>
													<?php
													if(!empty($navigation_skins)){
														foreach($navigation_skins as $e_nav_skins){
															if($skin['handle'] == $e_nav_skins['handle']){ //already exists in database, ask to append or overwrite
																?>
																<span style="float: right;">
																	<input type="radio" name="nav-skin-overwrite-<?php echo $skin['id']; ?>" checked="checked" value="append" /> <?php _e('Append as New', EG_TEXTDOMAIN); ?>
																	<input type="radio" name="nav-skin-overwrite-<?php echo $skin['id']; ?>" value="overwrite" /> <?php _e('Overwrite Existing', EG_TEXTDOMAIN); ?>
																</span>
																<div style="clear: both;"></div>
																<?php
																break;
															}
														}
													}
													?>
												</div>
											</li>
											<?php
										}
										?>
									</ul>
								</li>
								<?php
							}
							
							if(!empty($import_data['custom-meta'])){
								?>
								<li><div class="eg-li-intern-wrap"><span class="eg-expand-collapse closed"><i class="eg-icon-folder-open"></i><i class="eg-icon-folder"></i></span><span class="eg-inputchecked"><i class="eg-icon-ok-squared"></i><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span><input type="checkbox" name="import-custom-meta" checked="checked" /><span><?php _e('Custom Meta', EG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
									<ul class="eg-ie-sub-ul">
										<?php
										foreach($import_data['custom-meta'] as $custom_meta){
											?>
											<li>
												<div class="eg-li-intern-wrap">
													<span class="eg-inputchecked"><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span>
													<input class="eg-get-val" type="checkbox" name="import-custom-meta-handle[]" checked="checked" value="<?php echo $custom_meta['handle']; ?>" />
													<?php echo $custom_meta['handle']; ?>
													<?php
													if(!empty($custom_metas)){
														foreach($custom_metas as $e_custom_meta){
															if($custom_meta['handle'] == $e_custom_meta['handle']){ //already exists in database, ask to append or overwrite
																?>
																<span style="float: right;">
																	<input type="radio" name="custom-meta-overwrite-<?php echo $custom_meta['handle']; ?>" checked="checked" value="append" /> <?php _e('Append as New', EG_TEXTDOMAIN); ?>
																	<input type="radio" name="custom-meta-overwrite-<?php echo $custom_meta['handle']; ?>" value="overwrite" /> <?php _e('Overwrite Existing', EG_TEXTDOMAIN); ?>
																</span>
																<div style="clear: both;"></div>
																<?php
																break;
															}
														}
													}
													?>
												</div>
											</li>
											<?php
										}
										?>
									</ul>
								</li>
								<?php
							}
							
							if(!empty($import_data['punch-fonts'])){
								?>
								<li><div class="eg-li-intern-wrap"><span class="eg-expand-collapse closed"><i class="eg-icon-folder-open"></i><i class="eg-icon-folder"></i></span><span class="eg-inputchecked"><i class="eg-icon-ok-squared"></i><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span><input type="checkbox" name="import-punch-fonts" checked="checked" /><span><?php _e('Punch Fonts', EG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
									<ul class="eg-ie-sub-ul">
										<?php
										foreach($import_data['punch-fonts'] as $punch_font){
											?>
											<li>
												<div class="eg-li-intern-wrap">
													<span class="eg-inputchecked"><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span>
													<input class="eg-get-val" type="checkbox" name="import-punch-fonts-handle[]" checked="checked" value="<?php echo $punch_font['handle']; ?>" />
													<?php echo $punch_font['handle']; ?>
													<?php
													if(!empty($custom_fonts)){
														foreach($custom_fonts as $e_custom_font){
															if($punch_font['handle'] == $e_custom_font['handle']){ //already exists in database, ask to append or overwrite
																?>
																<span style="float: right;">
																	<input type="radio" name="punch-fonts-overwrite-<?php echo $punch_font['handle']; ?>" checked="checked" value="append" /> <?php _e('Append as New', EG_TEXTDOMAIN); ?>
																	<input type="radio" name="punch-fonts-overwrite-<?php echo $punch_font['handle']; ?>" value="overwrite" /> <?php _e('Overwrite Existing', EG_TEXTDOMAIN); ?>
																</span>
																<div style="clear: both;"></div>
																<?php
																break;
															}
														}
													}
													?>
												</div>
											</li>
											<?php
										}
										?>
									</ul>
								</li>
								<?php
							}
							if(!empty($import_data['global-css'])){
								?>
								<li>
									<div class="eg-li-intern-wrap">
										<span style="margin-left:33px" class="eg-inputchecked"><i class="eg-icon-ok"></i><i class="eg-icon-cancel"></i></span>
										<input class="eg-get-val" type="checkbox" name="import-global-styles" checked="checked" style="margin-left:33px"/>
										<span><?php _e('Global Styles', EG_TEXTDOMAIN); ?></span>
										<span style="float: right;">
											<input type="radio" name="global-styles-overwrite" checked="checked" value="append" /> <?php _e('Append as New', EG_TEXTDOMAIN); ?>
											<input type="radio" name="global-styles-overwrite" value="overwrite" /> <?php _e('Overwrite Existing', EG_TEXTDOMAIN); ?>
										</span>
										<div style="clear: both;"></div>
									</div>
								</li>
								<?php
							}
							?>
						</ul>
						
						<div>
							<a id="esg-import-data" href="javascript:void(0);" class="button-primary revgreen" /><?php _e('Import Selected Data', EG_TEXTDOMAIN); ?></a>
						</div>
						<?php
					}else{
						?>
						<input type="file" name="import_file" />
						<input type="submit" class="button-primary revgreen" id="esg-read-file-import" value="<?php _e('Read File', EG_TEXTDOMAIN); ?>" />
						<?php
					}
					?>
				</div>
			</div>
		</form>
		<div>
			<?php
			$add_cpt = apply_filters('essgrid_set_cpt', get_option('tp_eg_enable_custom_post_type', 'true'));
			
			if($add_cpt == 'true' || $add_cpt === true){
				?>
				<div style="display: inline-block;">
					<a href="javascript:void(0);" class="button-primary revgreen" id="esg-import-demo-posts"><?php _e('Import Full Demo Data', EG_TEXTDOMAIN); ?></a>
				</div>
				<?php
			}
			?>
			<div style="display: inline-block;">
				<a href="javascript:void(0);" class="button-primary revgreen" id="esg-import-demo-posts-210"><?php _e('Import 2.1.0 Demo Grids', EG_TEXTDOMAIN); ?></a>
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
		jQuery(function(){
			AdminEssentials.initImportExport();
		});
	</script>